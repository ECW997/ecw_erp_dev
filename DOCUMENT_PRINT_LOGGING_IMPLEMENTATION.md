# Document Print Logging Implementation

## Overview
This implementation adds comprehensive logging for document print operations (job cards, invoices, receipts, and gate passes) in the ECW ERP system.

## Database Structure

### 1. `doc_access_type` Table
Stores document access types for type handling.

**Columns:**
- `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
- `doc_access_type` (ENUM: 'jobcard', 'invoice', 'payment', 'gatepass', UNIQUE)
- `description` (VARCHAR(255), nullable)
- `is_active` (TINYINT(1), default: 1)
- `created_at` (DATETIME)
- `created_by` (INT, nullable)
- `updated_at` (DATETIME, nullable)
- `updated_by` (INT, nullable)

**Default Records:**
- jobcard - Job Card Document
- invoice - Invoice Document
- payment - Payment Receipt Document
- gatepass - Gate Pass Document

### 2. `doc_access` Table
Stores document access/print logs.

**Columns:**
- `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
- `doc_type_id` (INT, FOREIGN KEY to doc_access_type.id)
- `reference_id` (INT) - ID of the document (jobcard_id, invoice_id, payment_id, gatepass_id)
- `status` (ENUM: 'active', 'ignore', 'delete', default: 'active')
- `printed_at` (DATETIME, default: CURRENT_TIMESTAMP)
- `printed_by` (INT, nullable) - User ID who printed
- `branch_id` (INT, nullable)
- `company_id` (INT, nullable)
- `remarks` (TEXT, nullable)
- `created_at` (DATETIME)
- `created_by` (INT, nullable)
- `updated_at` (DATETIME, nullable)
- `updated_by` (INT, nullable)

## Files Created

### Database Migrations
1. `c:\xampp8.1\htdocs\api.ecw.lk\database\migrations\create_doc_access_type_table.sql`
2. `c:\xampp8.1\htdocs\api.ecw.lk\database\migrations\create_doc_access_table.sql`

### Models (CodeIgniter)
1. `C:\xampp\htdocs\ecw_erp_dev\application\models\DocAccessTypeinfo.php`
2. `C:\xampp\htdocs\ecw_erp_dev\application\models\DocAccessinfo.php`

### Helper Functions
1. `C:\xampp\htdocs\ecw_erp_dev\application\helpers\doc_access_helper.php`
   - `log_document_print()` - Log document print operation
   - `get_document_access_logs()` - Retrieve document access logs

### API Controllers (Laravel)
1. `c:\xampp8.1\htdocs\api.ecw.lk\app\Http\Controllers\v1\DocAccessTypeController.php`
2. `c:\xampp8.1\htdocs\api.ecw.lk\app\Http\Controllers\v1\DocAccessController.php`

### Routes
- Added routes in `c:\xampp8.1\htdocs\api.ecw.lk\routes\api.php`:
  - `Route::apiResource('doc_access_type', DocAccessTypeController::class);`
  - `Route::apiResource('doc_access', DocAccessController::class);`

### Configuration
- Updated `C:\xampp\htdocs\ecw_erp_dev\application\config\api_config.php` with new endpoints:
  - `doc_access_type_v1` => '/v1/doc_access_type'
  - `doc_access_v1` => '/v1/doc_access'

## Implementation Details

### Controllers Updated

#### 1. Payment Controller (`Payment.php`)
- **Method:** `paymentReceiptPDF()`
  - Logs receipt print after PDF generation
  - Logs invoice print if invoice is included with receipt
  - Includes branch_id, company_id, and remarks

- **Method:** `paymentReceiptV2PDF()`
  - Logs receipt V2 print after PDF generation
  - Includes branch_id, company_id, and remarks

#### 2. JobCard Controller (`JobCard.php`)
- **Method:** `jobCardPDF()`
  - Logs job card print after PDF generation
  - Includes branch_id, company_id, and remarks

#### 3. Invoice Controller (`Invoice.php`)
- **Method:** `invoicePDF()`
  - Logs invoice print after PDF generation
  - Includes branch_id, company_id, series type, and remarks

## Usage

### Logging a Print Operation

In any controller, after generating/streaming a PDF:

```php
$this->load->helper('doc_access_helper');

// Log the print
log_document_print('payment', $receipt_id, [
    'branch_id' => $this->session->userdata('branch_id'),
    'company_id' => $this->session->userdata('company_id'),
    'remarks' => 'Receipt printed (Series: ' . $series_type . ')'
]);
```

### Retrieving Print Logs

```php
$this->load->helper('doc_access_helper');

// Get logs for a specific document
$logs = get_document_access_logs('payment', $receipt_id);

// Get all logs with filters
$logs = get_document_access_logs(null, null, [
    'status' => 'active',
    'date_from' => '2025-01-01',
    'date_to' => '2025-01-31'
]);
```

## API Endpoints

### Document Access Type
- `GET /api/v1/doc_access_type` - List all document access types
- `GET /api/v1/doc_access_type/{id}` - Get specific document access type
- `POST /api/v1/doc_access_type` - Create new document access type
- `PUT /api/v1/doc_access_type/{id}` - Update document access type
- `DELETE /api/v1/doc_access_type/{id}` - Deactivate document access type

### Document Access
- `GET /api/v1/doc_access` - List document access logs (with filters)
- `GET /api/v1/doc_access/{id}` - Get specific document access log
- `POST /api/v1/doc_access` - Log new document print
- `PUT /api/v1/doc_access/{id}` - Update document access log status
- `DELETE /api/v1/doc_access/{id}` - Soft delete document access log

## Status Values

- **active** - Document was printed and log is active
- **ignore** - Log entry should be ignored (e.g., test prints)
- **delete** - Log entry is soft deleted

## Next Steps

1. **Run Database Migrations:**
   ```sql
   -- Execute the SQL files in order:
   -- 1. create_doc_access_type_table.sql
   -- 2. create_doc_access_table.sql
   ```

2. **Gate Pass Implementation:**
   - When gate pass printing is implemented, add logging similar to other documents:
   ```php
   log_document_print('gatepass', $gatepass_id, [
       'branch_id' => $branch_id,
       'company_id' => $company_id,
       'remarks' => 'Gate pass printed'
   ]);
   ```

3. **Testing:**
   - Test print operations for job cards, invoices, and receipts
   - Verify logs are created in the database
   - Test API endpoints for retrieving logs

## Notes

- All print operations are logged automatically after PDF generation
- Logs include user information, branch, company, and timestamp
- Status can be updated to 'ignore' or 'delete' for audit purposes
- The system supports filtering logs by document type, reference ID, status, date range, branch, and company

