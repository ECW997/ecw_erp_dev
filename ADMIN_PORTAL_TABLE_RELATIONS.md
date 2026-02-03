# Admin Portal - Table Relationships & Join Patterns Reference

## Overview
This document provides a comprehensive reference for table relationships and join patterns used in the Admin Portal cancellation logic. Use this as a guide when implementing queries.

## Core Table Structure

### Main Entity
```
sales_order_relation
├── id (PK)
├── jobcard_id → tbl_jobcard.idtbl_jobcard
├── sales_orders_header_id → sales_orders_header.id
├── exclude_sales_orders_header_id → exclude_sales_orders_header.id
└── status
```

## Table Relationships & Join Patterns

### 1. Sales Order Relation → Sales Orders Header

**Relationship**: One-to-One
```php
// Using Eloquent Relationship
$relation->salesOrderHeader; // SalesOrderHeader model

// Using Join
DB::table('sales_order_relation')
    ->join('sales_orders_header', 'sales_orders_header.id', '=', 'sales_order_relation.sales_orders_header_id')
    ->select('sales_order_relation.*', 'sales_orders_header.*')
    ->get();

// Using Query Builder with Alias
DB::table('sales_order_relation')
    ->join('sales_orders_header as soh', 'soh.id', '=', 'sales_order_relation.sales_orders_header_id')
    ->get();
```

**Example from InvoiceController.php (Line 212)**:
```php
->join('sales_orders_header as soh', 'soh.id', '=', 'sales_order_relation.sales_orders_header_id')
```

### 2. Sales Order Relation → Exclude Sales Orders Header

**Relationship**: One-to-One (Optional)
```php
// Using Eloquent Relationship
$relation->excludeSalesOrderHeader; // ExcludeSalesOrderHeader model

// Using Left Join (because it's optional)
DB::table('sales_order_relation')
    ->leftJoin('exclude_sales_orders_header', 'exclude_sales_orders_header.id', '=', 'sales_order_relation.exclude_sales_orders_header_id')
    ->get();

// Using Query Builder with Alias
DB::table('sales_order_relation')
    ->leftJoin('exclude_sales_orders_header as esoh', 'esoh.id', '=', 'sales_order_relation.exclude_sales_orders_header_id')
    ->get();
```

**Example from InvoiceController.php (Line 213)**:
```php
->leftJoin('exclude_sales_orders_header as esoh', 'esoh.id', '=', 'sales_order_relation.exclude_sales_orders_header_id')
```

### 3. Sales Orders Header → Sales Orders Details

**Relationship**: One-to-Many
```php
// Using Eloquent Relationship
$salesOrderHeader->details; // Collection of SalesOrderDetail

// Using Query Builder
DB::table('sales_orders_details')
    ->where('sales_orders_header_id', $headerId)
    ->get();

// Using Model
SalesOrderDetail::where('sales_orders_header_id', $headerId)->get();
```

**Example from AdminPortalController.php (Line 265)**:
```php
SalesOrderDetail::where('sales_orders_header_id', $salesOrderHeader->id)
    ->update(['status' => 'CANCELLED']);
```

### 4. Exclude Sales Orders Header → Exclude Sales Orders Details

**Relationship**: One-to-Many
```php
// Using Query Builder
DB::table('exclude_sales_orders_details')
    ->where('exclude_sales_orders_header_id', $headerId)
    ->get();

// Using Model
ExcludeSalesOrderDetail::where('exclude_sales_orders_header_id', $headerId)->get();
```

**Example from AdminPortalController.php (Line 288)**:
```php
ExcludeSalesOrderDetail::where('exclude_sales_orders_header_id', $excludeSalesOrderHeader->id)
    ->update(['status' => 'CANCELLED']);
```

### 5. Sales Orders Header → Invoices

**Relationship**: One-to-Many (via job_card_id field, but stores sales_orders_header.id)

**Validation Required Before Linking**:
- Sales Order Header: `salesorder_no` is NOT NULL
- Sales Order Header: `net_total > 0`
- Sales Order Header: `status` IN ['Approved', 'Re-Approved']
- Invoice: `inv_status` IN ['1', '2']

```php
// Validate sales order header first
$salesOrderHeader = SalesOrderHeader::find($salesOrderHeaderId);
if ($salesOrderHeader && 
    !is_null($salesOrderHeader->salesorder_no) && 
    $salesOrderHeader->net_total > 0 && 
    in_array($salesOrderHeader->status, ['Approved', 'Re-Approved'])) {
    
    // Get invoices with invoice_status in ['1','2']
    $invoices = Invoice::where('job_card_id', $salesOrderHeaderId)
        ->whereIn('inv_status', ['1', '2'])
        ->get();
}
```

**Example from AdminPortalController.php (Line 66-75)**:
```php
// Validate sales order header before linking invoices
$salesOrderHeader = SalesOrderHeader::find($relation->sales_orders_header_id);
if ($salesOrderHeader && 
    !is_null($salesOrderHeader->salesorder_no) && 
    $salesOrderHeader->net_total > 0 && 
    in_array($salesOrderHeader->status, ['Approved', 'Re-Approved'])) {
    
    // Get invoices with invoice_status in ['1','2']
    $invoices = Invoice::where('job_card_id', $relation->sales_orders_header_id)
        ->whereIn('inv_status', ['1', '2'])
        ->get();
}
```

**Example from SalesOrderController.php (Line 746)**:
```php
->leftJoin('inv_header', 'inv_header.job_card_id', '=', 'sales_orders_header.id')
```

**Example from GatePassController.php (Line 172)**:
```php
$invoice = Invoice::where('job_card_id', $salesOrderRelation->sales_orders_header_id)
```

**Important Note**: Despite the field name `job_card_id`, it actually stores `sales_orders_header.id`, not the jobcard_id!

### 6. Exclude Sales Orders Header → Exclude Invoices

**Relationship**: One-to-Many (via job_card_id field, but stores exclude_sales_orders_header.id)

**Validation Required Before Linking**:
- Exclude Sales Order Header: `salesorder_no` is NOT NULL
- Exclude Sales Order Header: `net_total > 0`
- Exclude Sales Order Header: `status` IN ['Approved', 'Re-Approved']
- Exclude Invoice: `inv_status` IN ['1', '2']

```php
// Validate exclude sales order header first
$excludeSalesOrderHeader = ExcludeSalesOrderHeader::find($excludeSalesOrderHeaderId);
if ($excludeSalesOrderHeader && 
    !is_null($excludeSalesOrderHeader->salesorder_no) && 
    $excludeSalesOrderHeader->net_total > 0 && 
    in_array($excludeSalesOrderHeader->status, ['Approved', 'Re-Approved'])) {
    
    // Get exclude invoices with invoice_status in ['1','2']
    $excludeInvoices = ExcludeInvoice::where('job_card_id', $excludeSalesOrderHeaderId)
        ->whereIn('inv_status', ['1', '2'])
        ->get();
}
```

**Example from AdminPortalController.php (Line 72-82)**:
```php
// Validate exclude sales order header before linking invoices
$excludeSalesOrderHeader = ExcludeSalesOrderHeader::find($relation->exclude_sales_orders_header_id);
if ($excludeSalesOrderHeader && 
    !is_null($excludeSalesOrderHeader->salesorder_no) && 
    $excludeSalesOrderHeader->net_total > 0 && 
    in_array($excludeSalesOrderHeader->status, ['Approved', 'Re-Approved'])) {
    
    // Get exclude invoices with invoice_status in ['1','2']
    $excludeInvoices = ExcludeInvoice::where('job_card_id', $relation->exclude_sales_orders_header_id)
        ->whereIn('inv_status', ['1', '2'])
        ->get();
}
```

**Example from SalesOrderController.php (Line 1077)**:
```php
->leftJoin('exclude_inv_header', 'exclude_inv_header.job_card_id', '=', 'exclude_sales_orders_header.id')
```

**Example from GatePassController.php (Line 181)**:
```php
$excludeInvoice = ExcludeInvoice::where('job_card_id', $salesOrderRelation->exclude_sales_orders_header_id)
```

**Important Note**: Despite the field name `job_card_id`, it actually stores `exclude_sales_orders_header.id`, not the jobcard_id!

### 7. Invoice → Invoice Details

**Relationship**: One-to-Many
```php
// Using Eloquent Relationship
$invoice->details; // Collection of InvoiceDetail

// Using Query Builder
DB::table('inv_details')
    ->where('invoice_id', $invoiceId)
    ->get();

// Using Model
InvoiceDetail::where('invoice_id', $invoiceId)->get();
```

**Example from AdminPortalController.php (Line 312)**:
```php
InvoiceDetail::where('invoice_id', $invoice->id)
    ->update(['status' => 'CANCELLED']);
```

### 8. Exclude Invoice → Exclude Invoice Details

**Relationship**: One-to-Many
```php
// Using Query Builder
DB::table('exclude_inv_details')
    ->where('invoice_id', $invoiceId)
    ->get();

// Using Model
ExcludeInvoiceDetail::where('invoice_id', $invoiceId)->get();
```

**Example from AdminPortalController.php (Line 339)**:
```php
ExcludeInvoiceDetail::where('invoice_id', $invoice->id)
    ->update(['status' => 'CANCELLED']);
```

### 9. Invoice → Payments (via pay_allocation)

**Relationship**: Many-to-Many (via pay_allocation table with pay_type='Invoice')
```php
// Get payment IDs from invoice IDs
// Note: pay_allocation uses pay_ref_id (not invoice_id) and pay_type='Invoice'
$invoiceIds = [1, 2, 3];
$paymentIds = [];
if (!empty($invoiceIds)) {
    $paymentIds = DB::table('pay_allocation')
        ->where('pay_type', 'Invoice')
        ->whereIn('pay_ref_id', $invoiceIds)
        ->pluck('pay_header_id')
        ->unique()
        ->toArray();
}

// Get payments
$payments = !empty($paymentIds) ? PayHeader::whereIn('id', $paymentIds)->get() : collect([]);
```

**Example from AdminPortalController.php (Line 100-112, 492-504)**:
```php
// Regular payments only link to regular invoices (inv_header), NOT exclude invoices
// Exclude invoices link to temp payments separately (see section 12)
$invoiceIds = $invoices->pluck('id');

// Get payment IDs via pay_allocation
// Note: pay_allocation.pay_ref_id stores invoice id when pay_type='Invoice'
$paymentIds = [];
if (!empty($invoiceIds)) {
    $paymentIds = DB::table('pay_allocation')
        ->where('pay_type', 'Invoice')
        ->whereIn('pay_ref_id', $invoiceIds)
        ->pluck('pay_header_id')
        ->unique()
        ->toArray();
}

// Get payments
$payments = !empty($paymentIds) ? PayHeader::whereIn('id', $paymentIds)->get() : collect([]);
```

**Important Notes**:
- `pay_allocation.pay_type` must be `'Invoice'` (not 'JobCard')
- `pay_allocation.pay_ref_id` stores the invoice ID (not invoice_id field)
- **Regular payments (`pay_allocation`) only link to regular invoices (`inv_header`), NOT exclude invoices**
- **Exclude invoices link to temp payments via `temp_pay_allocation` (see section 12)**
- Always check if invoiceIds is not empty before querying

### 10. Payment → Payment Details

**Relationship**: One-to-Many
```php
// Using Eloquent Relationship
$payment->details; // Collection of PayDetails

// Using Query Builder
DB::table('pay_details')
    ->where('pay_header_id', $paymentId)
    ->get();

// Using Model
PayDetails::where('pay_header_id', $paymentId)->get();
```

**Example from AdminPortalController.php (Line 441)**:
```php
PayDetails::where('pay_header_id', $payment->id)
    ->update(['status' => 'CANCELLED']);
```

### 11. Payment → Payment Allocations

**Relationship**: One-to-Many
```php
// Using Eloquent Relationship
$payment->allocations; // Collection of PayAllocation

// Using Query Builder
DB::table('pay_allocation')
    ->where('pay_header_id', $paymentId)
    ->get();

// Using Model
PayAllocation::where('pay_header_id', $paymentId)->get();
```

**Example from AdminPortalController.php (Line 448)**:
```php
PayAllocation::where('pay_header_id', $payment->id)
    ->update(['status' => 'CANCELLED']);
```

### 12. Exclude Invoice → Temp Payments (via temp_pay_allocation)

**Relationship**: Many-to-Many (via temp_pay_allocation table with pay_type='Invoice')

**Important**: `temp_pay_allocation` uses `pay_type='Invoice'` for invoice-linked temp payments.

```php
// Get temp payment IDs from exclude invoice ID
// Note: One exclude sales order links to one exclude invoice only
$excludeInvoiceId = 123;
$tempPaymentIds = DB::table('temp_pay_allocation')
    ->where('invoice_id', $excludeInvoiceId)
    ->where('pay_type', 'Invoice')
    ->pluck('pay_header_id')
    ->unique()
    ->toArray();
```

**Example from AdminPortalController.php (Line 117-124)**:
```php
if ($excludeInvoice && $excludeInvoice->id) {
    $tempPaymentIdsFromInvoices = DB::table('temp_pay_allocation')
        ->where('invoice_id', $excludeInvoice->id)
        ->where('pay_type', 'Invoice')
        ->pluck('pay_header_id')
        ->unique()
        ->toArray();
    $tempPaymentIds = array_merge($tempPaymentIds, $tempPaymentIdsFromInvoices);
}
```

**Important Notes**:
- `temp_pay_allocation.pay_type` must be `'Invoice'` for invoice-linked temp payments
- `temp_pay_allocation.invoice_id` stores the exclude invoice ID

### 13. Temp Payment → Temp Payment Details

**Relationship**: One-to-Many
```php
// Using Query Builder
DB::table('temp_pay_details')
    ->where('pay_header_id', $tempPayHeaderId)
    ->get();
```

**Example from AdminPortalController.php (Line 394-400)**:
```php
DB::table('temp_pay_details')
    ->where('pay_header_id', $tempPayHeaderId)
    ->update(['status' => 'CANCELLED']);
```

### 15. Temp Payment → Temp Payment Allocations

**Relationship**: One-to-Many
```php
// Using Query Builder
DB::table('temp_pay_allocation')
    ->where('pay_header_id', $tempPayHeaderId)
    ->get();
```

**Example from AdminPortalController.php (Line 403-409)**:
```php
DB::table('temp_pay_allocation')
    ->where('pay_header_id', $tempPayHeaderId)
    ->update(['status' => 'CANCELLED']);
```

## Complete Join Pattern Examples

### Example 1: Get Sales Order Relation with All Linked Data

```php
$relation = SalesOrderRelation::with([
    'salesOrderHeader',
    'excludeSalesOrderHeader',
    'jobCard'
])->find($id);

            // Get linked invoices
// Note: inv_header.job_card_id stores sales_orders_header.id
$invoices = Invoice::where('job_card_id', $relation->sales_orders_header_id)->get();
// Note: exclude_inv_header.job_card_id stores exclude_sales_orders_header.id
$excludeInvoices = ExcludeInvoice::where('job_card_id', $relation->exclude_sales_orders_header_id)->get();

// Get linked payments
// Note: Regular payments only link to regular invoices, NOT exclude invoices
$invoiceIds = $invoices->pluck('id');
$paymentIds = [];
if (!empty($invoiceIds)) {
    $paymentIds = DB::table('pay_allocation')
        ->where('pay_type', 'Invoice')
        ->whereIn('pay_ref_id', $invoiceIds)
        ->pluck('pay_header_id')
        ->unique()
        ->toArray();
}
$payments = !empty($paymentIds) ? PayHeader::whereIn('id', $paymentIds)->get() : collect([]);

// Get linked temp payments
$excludeInvoiceIds = $excludeInvoices->pluck('id');
$tempPaymentIds = [];

// From exclude invoices
if (!empty($excludeInvoiceIds)) {
    $tempPaymentIds = array_merge($tempPaymentIds, 
        DB::table('temp_pay_allocation')
            ->whereIn('invoice_id', $excludeInvoiceIds)
            ->pluck('pay_header_id')
            ->unique()
            ->toArray()
    );
}

// Note: Only temp payments linked to exclude invoices are included
$tempPayments = DB::table('temp_pay_header')
    ->whereIn('id', $tempPaymentIds)
    ->get();
```

### Example 2: Complex Join Query (from InvoiceController.php)

```php
$jobcards = SalesOrderRelation::query()
    ->join('sales_orders_header as soh', 'soh.id', '=', 'sales_order_relation.sales_orders_header_id')
    ->leftJoin('exclude_sales_orders_header as esoh', 'esoh.id', '=', 'sales_order_relation.exclude_sales_orders_header_id')
    ->where(function ($query) use ($term) {
        $query->where('sales_order_relation.jobcard_no', 'LIKE', "%{$term}%")
            ->orWhere('soh.salesorder_no', 'LIKE', "%{$term}%")
            ->orWhere('esoh.salesorder_no', 'LIKE', "%{$term}%");
    })
    ->get();
```

### Example 3: Join with Exclude Invoice (from PaymentController.php)

```php
$invoice = ExcludeInvoice::query()
    ->leftJoin('tbl_customer', 'tbl_customer.idtbl_customer', '=', 'exclude_inv_header.customer_id')
    ->leftJoin('sales_order_relation', 'sales_order_relation.exclude_sales_orders_header_id', '=', 'exclude_inv_header.job_card_id')
    ->leftJoin('exclude_sales_orders_header', 'exclude_sales_orders_header.id', '=', 'sales_order_relation.exclude_sales_orders_header_id')
    ->where('exclude_inv_header.id', $pay_header_id)
    ->first();
```

## Key Join Patterns Summary

| From Table | To Table | Join Type | Join Condition |
|------------|----------|-----------|----------------|
| `sales_order_relation` | `sales_orders_header` | INNER JOIN | `sales_orders_header.id = sales_order_relation.sales_orders_header_id` |
| `sales_order_relation` | `exclude_sales_orders_header` | LEFT JOIN | `exclude_sales_orders_header.id = sales_order_relation.exclude_sales_orders_header_id` |
| `sales_orders_header` | `sales_orders_details` | WHERE | `sales_orders_details.sales_orders_header_id = sales_orders_header.id` |
| `exclude_sales_orders_header` | `exclude_sales_orders_details` | WHERE | `exclude_sales_orders_details.exclude_sales_orders_header_id = exclude_sales_orders_header.id` |
| `sales_orders_header` | `inv_header` | WHERE | `inv_header.job_card_id = sales_orders_header.id` |
| `exclude_sales_orders_header` | `exclude_inv_header` | WHERE | `exclude_inv_header.job_card_id = exclude_sales_orders_header.id` |
| `inv_header` | `inv_details` | WHERE | `inv_details.invoice_id = inv_header.id` |
| `exclude_inv_header` | `exclude_inv_details` | WHERE | `exclude_inv_details.invoice_id = exclude_inv_header.id` |
| `inv_header` | `pay_header` | Via `pay_allocation` | `pay_allocation.pay_type = 'Invoice'` AND `pay_allocation.pay_ref_id = inv_header.id` AND `pay_allocation.pay_header_id = pay_header.id` |
| `exclude_inv_header` | `temp_pay_header` | Via `temp_pay_allocation` | `temp_pay_allocation.invoice_id = exclude_inv_header.id` AND `temp_pay_allocation.pay_type = 'Invoice'` AND `temp_pay_allocation.pay_header_id = temp_pay_header.id` |

## Important Notes

1. **Use LEFT JOIN** for optional relationships (like `exclude_sales_orders_header`)
2. **Use WHERE clauses** for one-to-many relationships (details tables)
3. **Use intermediate tables** (`pay_allocation`, `temp_pay_allocation`) for many-to-many relationships
4. **Always use `pluck()->unique()`** when getting IDs from allocation tables to avoid duplicates
5. **Check for empty arrays** before using `whereIn()` to avoid SQL errors
6. **Use Eloquent relationships** when possible for cleaner code
7. **Use Query Builder** for complex joins or when Eloquent relationships are not defined

## Status Update Pattern

When cancelling records, update status fields consistently:

```php
// For header tables
$record->status = 'CANCELLED';
$record->status_upd = 'CANCELLED';
$record->status_upd_at = Carbon::now();
$record->save();

// For detail tables (using update)
Model::where('parent_id', $parentId)
    ->update([
        'status' => 'CANCELLED',
        'status_upd' => 'CANCELLED',
        'status_upd_at' => Carbon::now()
    ]);
```

## References

- `AdminPortalController.php` - Main implementation
- `InvoiceController.php` - Join examples
- `PaymentController.php` - Join examples
- `SalesOrderController.php` - Join examples
