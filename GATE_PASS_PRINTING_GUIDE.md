# Gate Pass Printing Implementation Guide

## Current Printing Implementation

### 1. **From Job Card (Gate Pass IN)**
**Location:** `application/controllers/JobCard.php` (around line 280-292)

**How it works:**
- Loads job card data
- Prepares `$pdf_data` array with `main_data` containing job card information
- Uses PDF library with custom paper size (80mm width receipt printer)
- Loads view: `components/pdf/gate_pass_in_pdf.php`
- Streams PDF to browser

**Data Structure:**
```php
$pdf_data = [
    'main_data' => [
        'vehicle_number' => ...,
        'job_card_number2' => ...,
        'sales_person_name' => ...,
        'job_start_datetime' => ...,
    ],
    'is_duplicate' => false/true
];
```

### 2. **From Invoice (Gate Pass OUT)**
**Location:** `application/controllers/Invoice.php` (around line 425-439)

**How it works:**
- Loads invoice data
- Checks payment type (credit vs non-credit)
- Uses different PDF templates:
  - **Credit:** `gate_pass_out_credit_pdf.php`
  - **Non-Credit:** `gate_pass_out_noncredit_pdf.php`
- Streams PDF to browser

**Data Structure:**
```php
$pdf_data = [
    'main_data' => [
        'vehicle_number' => ...,
        'real_jobcard_no' => ...,
        'sales_person_name' => ...,
        'job_start_datetime' => ...,
        'handover_date' => ...,
        'payment_type' => 1 (non-credit) or 2 (credit),
    ],
    'is_duplicate' => false/true
];
```

### 3. **From Payment (Gate Pass OUT)**
**Location:** `application/controllers/Payment.php` (around line 387-402)

**How it works:**
- Similar to invoice printing
- Saves PDF to temporary file for email attachment
- Uses same PDF templates based on payment type

---

## New Gate Pass Module Printing Implementation

### Current Status
**Location:** `application/controllers/GatePass.php` (line 331-334)

Currently, the `printGatePass()` method only calls the API to increment print count. It does NOT generate the PDF.

### Required Implementation

#### 1. **Update `printGatePass()` Method in GatePass Controller**

```php
public function printGatePass($id) {
    // Get gate pass data from API
    $response = $this->GatePassinfo->getGatePassById($this->api_token, $id);
    
    if (!$response || !$response['status'] || !isset($response['data'])) {
        show_error('Gate pass not found', 404);
        return;
    }
    
    $gatePass = $response['data'];
    
    // Get job card details
    $jobCardResponse = $this->GatePassinfo->getJobCardDetails($this->api_token, $gatePass['job_card_id']);
    if (!$jobCardResponse || !$jobCardResponse['status']) {
        show_error('Job card not found', 404);
        return;
    }
    
    $jobCard = $jobCardResponse['data']['main_data'][0] ?? null;
    if (!$jobCard) {
        show_error('Job card data not found', 404);
        return;
    }
    
    // Prepare PDF data based on gate pass type
    $pdf_data = $this->prepareGatePassPdfData($gatePass, $jobCard);
    
    // Load PDF library
    $this->load->library('Pdf');
    $customPaper = array(0, 0, 382.84, 380.84); // 80mm width receipt printer
    $this->pdf->setPaper($customPaper);
    $this->pdf->set_option('defaultFont', 'Helvetica');
    $this->pdf->set_option('isRemoteEnabled', true);
    
    // Determine which PDF template to use
    $template = $this->getGatePassTemplate($gatePass);
    $html = $this->load->view('components/pdf/' . $template, $pdf_data, TRUE);
    
    $this->pdf->loadHtml($html);
    $this->pdf->render();
    
    // Increment print count via API
    $this->GatePassinfo->printGatePass($this->api_token, $id);
    
    // Stream PDF
    $filename = 'gate_pass_' . strtolower($gatePass['gate_pass_type']) . '_' . $gatePass['gate_pass_number'] . '.pdf';
    $this->pdf->stream($filename, ['Attachment' => 0]);
}
```

#### 2. **Create Helper Method: `prepareGatePassPdfData()`**

```php
private function prepareGatePassPdfData($gatePass, $jobCard) {
    $pdf_data = [
        'main_data' => [
            'vehicle_number' => $jobCard['vehicle_number'] ?? 'N/A',
            'job_card_number2' => $jobCard['job_card_number2'] ?? $jobCard['job_card_number'] ?? 'N/A',
            'real_jobcard_no' => $jobCard['job_card_number2'] ?? $jobCard['job_card_number'] ?? 'N/A',
            'sales_person_name' => $jobCard['sales_person_name'] ?? 'N/A',
            'job_start_datetime' => $jobCard['job_start_datetime'] ?? null,
            'handover_date' => $jobCard['handover_date'] ?? null,
            'payment_type' => $jobCard['payment_type'] ?? 1, // 1 = non-credit, 2 = credit
            'status' => $jobCard['status'] ?? 'Pending',
            'payment_status' => $this->getPaymentStatus($jobCard),
        ],
        'gate_pass' => $gatePass,
        'is_duplicate' => ($gatePass['print_count'] > 0),
        'print_count' => $gatePass['print_count'] ?? 0,
    ];
    
    // Add location information for INTERNAL/EXTERNAL gate passes
    if ($gatePass['pass_category'] === 'INTERNAL' || $gatePass['pass_category'] === 'EXTERNAL') {
        $pdf_data['main_data']['from_location'] = $gatePass['from_location']['location_name'] ?? 'N/A';
        $pdf_data['main_data']['to_location'] = $gatePass['to_location']['location_name'] ?? 'N/A';
        $pdf_data['main_data']['gate_location'] = $gatePass['location']['location_name'] ?? 'N/A';
    }
    
    // Add external party information for EXTERNAL gate passes
    if ($gatePass['pass_category'] === 'EXTERNAL') {
        $pdf_data['main_data']['external_party_name'] = $gatePass['external_party_name'] ?? 'N/A';
        $pdf_data['main_data']['external_party_type'] = $gatePass['external_party_type'] ?? 'N/A';
        $pdf_data['main_data']['external_transfer_purpose'] = $gatePass['external_transfer_purpose'] ?? 'N/A';
    }
    
    return $pdf_data;
}
```

#### 3. **Create Helper Method: `getGatePassTemplate()`**

```php
private function getGatePassTemplate($gatePass) {
    $category = $gatePass['pass_category'];
    $type = $gatePass['gate_pass_type'];
    
    // MAIN category
    if ($category === 'MAIN') {
        if ($type === 'IN') {
            return 'gate_pass_in_pdf'; // Already exists
        } elseif ($type === 'OUT') {
            // Use existing OUT templates based on payment status
            $jobCard = $this->getJobCardForGatePass($gatePass['job_card_id']);
            $paymentType = $jobCard['payment_type'] ?? 1;
            return ($paymentType == 2) ? 'gate_pass_out_credit_pdf' : 'gate_pass_out_noncredit_pdf';
        }
    }
    
    // INTERNAL category
    if ($category === 'INTERNAL') {
        if ($type === 'TEMP_IN') {
            return 'gate_pass_internal_in_pdf'; // Need to create
        } elseif ($type === 'TEMP_OUT') {
            return 'gate_pass_internal_out_pdf'; // Need to create
        }
    }
    
    // EXTERNAL category
    if ($category === 'EXTERNAL') {
        if ($type === 'TEMP_IN') {
            return 'gate_pass_external_in_pdf'; // Need to create
        } elseif ($type === 'TEMP_OUT') {
            return 'gate_pass_external_out_pdf'; // Need to create
        }
    }
    
    // Default fallback
    return 'gate_pass_in_pdf';
}
```

---

## PDF Templates Required

### Existing Templates (Can be reused):
1. ✅ `gate_pass_in_pdf.php` - For MAIN IN
2. ✅ `gate_pass_out_credit_pdf.php` - For MAIN OUT (Credit)
3. ✅ `gate_pass_out_noncredit_pdf.php` - For MAIN OUT (Non-Credit)

### New Templates Needed:

#### 1. **`gate_pass_internal_in_pdf.php`**
- For INTERNAL TEMP_IN gate passes
- Show: From Location, To Location, Gate Location
- Similar layout to MAIN IN but with location transfer details

#### 2. **`gate_pass_internal_out_pdf.php`**
- For INTERNAL TEMP_OUT gate passes
- Show: From Location, To Location, Gate Location
- Similar layout to MAIN OUT but with location transfer details

#### 3. **`gate_pass_external_in_pdf.php`**
- For EXTERNAL TEMP_IN gate passes
- Show: External Party Name, Type, Purpose, Return Date
- Company Driver/Worker information

#### 4. **`gate_pass_external_out_pdf.php`**
- For EXTERNAL TEMP_OUT gate passes
- Show: External Party Name, Type, Purpose, Expected Return Date
- Company Driver/Worker information

---

## Areas to Manage

### 1. **Print Count Tracking**
- ✅ Already implemented in backend API (`print()` method)
- Increments `print_count` field
- Tracks `printed_by` and `printed_at`

### 2. **Print Logging to doc_access Table**
- ✅ Implemented in backend API (`logPrintToDocAccess()` method)
- Logs every print operation to `doc_access` table
- **Reference ID Logic:**
  - `reference_id` = `job_card_id` (for all gate passes)
  - `reference2_id` = `gate_pass_id` (for temporary gate passes only, NULL for MAIN)
- **Duplicate Prevention:**
  - **MAIN gate passes**: One active log per `job_card_id + doc_type_id` (reference2_id is NULL)
  - **Temporary gate passes**: One active log per `job_card_id + doc_type_id + gate_pass_id` (reference2_id = gate_pass_id)
- Tracks: document type, reference_id (job card ID), reference2_id (gate pass ID for temporary), printed_by, printed_at, branch_id, company_id
- Uses doc_access_type: `gatepass_in` or `gatepass_out` based on gate pass type
- Falls back to `gatepass` if specific type doesn't exist
- Includes remarks with gate pass details (number, type, category, print count, gate pass ID)

### 2. **Print Restrictions**
Based on gate pass type:
- **MAIN IN (1)**: One-time print only (if previously not printed)
- **MAIN IN (2)**: Can print if IN=Yes AND OUT=Yes
- **MAIN OUT (1)**: One-time print only (if previously not printed)
- **MAIN OUT (2)**: Multi-print allowed if Vehicle is IN
- **MAIN OUT (3)**: Multi-print allowed if Vehicle is IN
- **INTERNAL/EXTERNAL**: Multi-print allowed

### 3. **Key Release Section**
- **MAIN OUT (1)**: Include Key Release section
- **MAIN OUT (2)**: DO NOT PRINT Key Release
- **MAIN OUT (3)**: DO NOT PRINT Key Release
- **INTERNAL/EXTERNAL**: No Key Release

### 4. **Signatures Required**

**MAIN IN:**
- Sales Person
- Sales Manager

**MAIN OUT:**
- Sales Person
- Cashier
- Driver
- Security Officer
- (Key Release): Sales Person, Cashier, Driver, Customer Accepted

**INTERNAL:**
- Sales Person
- Location Manager (From/To)

**EXTERNAL:**
- Sales Person
- Company Driver/Worker
- External Party Representative

### 5. **Data Fields to Display**

**Common Fields:**
- Gate Pass Number
- Vehicle Number
- Job Card Number
- Sales Person
- Job Start Date
- Print Count (if duplicate)
- Printed By, Date, Time

**MAIN Gate Passes:**
- Job End Date (for OUT)
- Job Status
- Payment Status

**INTERNAL Gate Passes:**
- From Location
- To Location
- Gate Location
- Transfer Purpose (if applicable)

**EXTERNAL Gate Passes:**
- External Party Name
- External Party Type
- External Party Contact
- Transfer Purpose
- Expected Return Date
- Actual Return Date (for IN)
- Company Driver Name/Contact
- Company Worker Name/Contact

---

## Implementation Steps

1. ✅ **Backend API** - Print endpoint already exists
2. ⏳ **Frontend Controller** - Update `printGatePass()` method
3. ⏳ **PDF Templates** - Create new templates for INTERNAL/EXTERNAL
4. ⏳ **Data Preparation** - Create helper methods to format data
5. ⏳ **Print Restrictions** - Implement validation in frontend
6. ⏳ **Key Release Logic** - Add conditional Key Release section
7. ⏳ **Testing** - Test all gate pass types

---

## Example: Updated printGatePass() Method

```php
public function printGatePass($id) {
    // Get gate pass data
    $gatePassResponse = $this->GatePassinfo->getGatePassById($this->api_token, $id);
    if (!$gatePassResponse || !$gatePassResponse['status']) {
        show_error('Gate pass not found', 404);
        return;
    }
    
    $gatePass = $gatePassResponse['data'];
    
    // Get job card details
    $jobCardResponse = $this->GatePassinfo->getJobCardDetails($this->api_token, $gatePass['job_card_id']);
    if (!$jobCardResponse || !$jobCardResponse['status']) {
        show_error('Job card not found', 404);
        return;
    }
    
    $jobCard = $jobCardResponse['data']['main_data'][0] ?? null;
    if (!$jobCard) {
        show_error('Job card data not found', 404);
        return;
    }
    
    // Prepare PDF data
    $pdf_data = $this->prepareGatePassPdfData($gatePass, $jobCard);
    
    // Load PDF library
    $this->load->library('Pdf');
    $customPaper = array(0, 0, 382.84, 380.84);
    $this->pdf->setPaper($customPaper);
    $this->pdf->set_option('defaultFont', 'Helvetica');
    $this->pdf->set_option('isRemoteEnabled', true);
    
    // Get template name
    $template = $this->getGatePassTemplate($gatePass);
    
    // Check if template exists
    $templatePath = APPPATH . 'views/components/pdf/' . $template . '.php';
    if (!file_exists($templatePath)) {
        // Fallback to default
        $template = ($gatePass['gate_pass_type'] === 'IN') ? 'gate_pass_in_pdf' : 'gate_pass_out_noncredit_pdf';
    }
    
    // Load view
    $html = $this->load->view('components/pdf/' . $template, $pdf_data, TRUE);
    
    $this->pdf->loadHtml($html);
    $this->pdf->render();
    
    // Increment print count via API (after successful render)
    $printResponse = $this->GatePassinfo->printGatePass($this->api_token, $id);
    
    // Stream PDF
    $filename = 'gate_pass_' . strtolower($gatePass['gate_pass_type']) . '_' . $gatePass['gate_pass_number'] . '.pdf';
    $this->pdf->stream($filename, ['Attachment' => 0]);
}
```

---

## Notes

- All PDF templates use the same paper size: `array(0, 0, 382.84, 380.84)` (80mm width)
- Templates should handle duplicate printing (show "DUPLICATE" label)
- Print count is tracked in the database
- Key Release section should only appear for MAIN OUT (1) when payment is completed
- Location names should be displayed for INTERNAL/EXTERNAL gate passes
- External party details should be displayed for EXTERNAL gate passes

