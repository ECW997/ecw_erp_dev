# Admin Portal - Invoice Relationship Correction

## Important Correction

The invoice relationships have been corrected based on actual database structure.

## Correct Relationships

### Regular Invoices
- **Field**: `inv_header.job_card_id`
- **Actually Stores**: `sales_orders_header.id` (NOT jobcard_id!)
- **Query**:
  ```php
  Invoice::where('job_card_id', $relation->sales_orders_header_id)->get();
  ```

### Exclude Invoices
- **Field**: `exclude_inv_header.job_card_id`
- **Actually Stores**: `exclude_sales_orders_header.id` (NOT jobcard_id!)
- **Query**:
  ```php
  ExcludeInvoice::where('job_card_id', $relation->exclude_sales_orders_header_id)->get();
  ```

## Evidence from Codebase

### SalesOrderController.php (Line 746)
```php
->leftJoin('inv_header', 'inv_header.job_card_id', '=', 'sales_orders_header.id')
```

### SalesOrderController.php (Line 1077)
```php
->leftJoin('exclude_inv_header', 'exclude_inv_header.job_card_id', '=', 'exclude_sales_orders_header.id')
```

### GatePassController.php (Line 172)
```php
$invoice = Invoice::where('job_card_id', $salesOrderRelation->sales_orders_header_id)
```

### GatePassController.php (Line 181)
```php
$excludeInvoice = ExcludeInvoice::where('job_card_id', $salesOrderRelation->exclude_sales_orders_header_id)
```

## Updated Code Pattern

### Before (Incorrect)
```php
// WRONG - was using jobcard_id
$invoices = Invoice::where('job_card_id', $relation->jobcard_id)->get();
$excludeInvoices = ExcludeInvoice::where('job_card_id', $relation->jobcard_id)->get();
```

### After (Correct)
```php
// CORRECT - uses sales_orders_header_id
$invoices = collect([]);
if ($relation->sales_orders_header_id) {
    $invoices = Invoice::where('job_card_id', $relation->sales_orders_header_id)->get();
}

$excludeInvoices = collect([]);
if ($relation->exclude_sales_orders_header_id) {
    $excludeInvoices = ExcludeInvoice::where('job_card_id', $relation->exclude_sales_orders_header_id)->get();
}
```

## Why Null Checks Are Needed

- `sales_orders_header_id` can be NULL (optional relationship)
- `exclude_sales_orders_header_id` can be NULL (optional relationship)
- Always check if these IDs exist before querying invoices

## Files Updated

1. ✅ `AdminPortalController.php` - Fixed invoice queries
2. ✅ `ADMIN_PORTAL_TABLE_RELATIONS.md` - Updated relationship documentation
3. ✅ `ADMIN_PORTAL_QUICK_REFERENCE.md` - Updated code snippets

## Impact

This correction ensures:
- Invoices are correctly linked to their sales orders
- Exclude invoices are correctly linked to their exclude sales orders
- No null reference errors when sales_order_header_id or exclude_sales_orders_header_id is null
- Proper cancellation of all linked invoices
