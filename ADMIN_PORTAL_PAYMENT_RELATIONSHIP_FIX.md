# Admin Portal - Payment Relationship Correction

## Important Correction

The payment relationships have been corrected based on actual database structure.

## Correct Relationships

### Regular Payments → Invoices
- **Table**: `pay_allocation`
- **Field**: `pay_ref_id` (NOT `invoice_id`!)
- **Filter**: `pay_type = 'Invoice'`
- **Query**:
  ```php
  $paymentIds = DB::table('pay_allocation')
      ->where('pay_type', 'Invoice')
      ->whereIn('pay_ref_id', $invoiceIds)
      ->pluck('pay_header_id')
      ->unique()
      ->toArray();
  ```

## Key Points

1. **pay_allocation Structure**:
   - `pay_type` - Can be 'Invoice' or 'JobCard'
   - `pay_ref_id` - Stores the reference ID:
     - When `pay_type = 'Invoice'`: stores invoice ID
     - When `pay_type = 'JobCard'`: stores jobcard ID
   - `pay_header_id` - Links to pay_header table

2. **For Invoice Payments**:
   - Must filter by `pay_type = 'Invoice'`
   - Use `pay_ref_id` (not `invoice_id` field)
   - `pay_ref_id` contains the invoice ID

3. **For JobCard Advance Payments**:
   - Filter by `pay_type = 'JobCard'`
   - Use `pay_ref_id` which contains jobcard ID
   - This is handled separately in temp payments section

## Evidence from Codebase

### PaymentController.php (Line 1710)
```php
$groupedByInvoice = $pay_allocations->where('pay_type', 'Invoice')->groupBy('pay_ref_id');
```

### PaymentController.php (Line 65)
```php
->leftJoin($invoice_table, "$invoice_table.id", '=', "$pay_allocation_table.pay_ref_id")
```

## Updated Code Pattern

### Before (Incorrect)
```php
// WRONG - was using invoice_id field
$paymentIds = DB::table('pay_allocation')
    ->whereIn('invoice_id', $invoiceIds)
    ->pluck('pay_header_id')
    ->unique();
```

### After (Correct)
```php
// CORRECT - uses pay_ref_id with pay_type='Invoice'
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
```

## pay_allocation Table Structure

| Field | Description | Values |
|-------|-------------|--------|
| `pay_type` | Type of payment reference | 'Invoice' or 'JobCard' |
| `pay_ref_id` | Reference ID | Invoice ID (when pay_type='Invoice') or JobCard ID (when pay_type='JobCard') |
| `pay_header_id` | Links to pay_header | Payment header ID |
| `invoice_id` | May exist but not used for regular payments | - |

## Files Updated

1. ✅ `AdminPortalController.php` - Fixed payment queries (2 locations)
2. ✅ `ADMIN_PORTAL_TABLE_RELATIONS.md` - Updated relationship documentation
3. ✅ `ADMIN_PORTAL_QUICK_REFERENCE.md` - Updated code snippets

## Impact

This correction ensures:
- Payments are correctly linked to invoices via `pay_ref_id`
- Only payments with `pay_type='Invoice'` are retrieved
- No confusion between regular payments and JobCard advance payments
- Proper cancellation of all linked payments
