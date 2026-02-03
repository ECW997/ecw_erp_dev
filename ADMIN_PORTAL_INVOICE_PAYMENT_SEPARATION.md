# Admin Portal - Invoice and Payment Separation

## Overview
Regular invoices and exclude invoices are handled **separately** when linking to payments. They use different payment systems and should never be merged.

## Key Principle

**Regular invoices (`inv_header`) and exclude invoices (`exclude_inv_header`) link to payments through DIFFERENT mechanisms:**

1. **Regular Invoices** → **Regular Payments** (`pay_allocation`)
2. **Exclude Invoices** → **Temp Payments** (`temp_pay_allocation`)

## Payment Linking Rules

### Regular Payments (pay_allocation)
- **Links to**: Regular invoices (`inv_header`) ONLY
- **Mechanism**: `pay_allocation.pay_ref_id` = `inv_header.id` WHERE `pay_allocation.pay_type = 'Invoice'`
- **DO NOT** include exclude invoice IDs when querying regular payments

### Temp Payments (temp_pay_allocation)
- **Links to**: Exclude invoices (`exclude_inv_header`) ONLY
- **Mechanism**: 
  - `temp_pay_allocation.invoice_id` = `exclude_inv_header.id` WHERE `pay_type = 'Invoice'`
- **DO NOT** mix with regular payment queries

## Correct Implementation Pattern

### ❌ WRONG - Merging Invoice IDs
```php
// DON'T DO THIS - Merging regular and exclude invoice IDs
$invoiceIds = $invoices->pluck('id')->merge($excludeInvoiceIds);

// This would incorrectly try to find regular payments for exclude invoices
$paymentIds = DB::table('pay_allocation')
    ->where('pay_type', 'Invoice')
    ->whereIn('pay_ref_id', $invoiceIds)  // WRONG: includes exclude invoice IDs
    ->pluck('pay_header_id')
    ->unique()
    ->toArray();
```

### ✅ CORRECT - Separate Handling
```php
// Regular payments - only use regular invoice IDs
$invoiceIds = $invoices->pluck('id');
$paymentIds = [];
if (!empty($invoiceIds)) {
    $paymentIds = DB::table('pay_allocation')
        ->where('pay_type', 'Invoice')
        ->whereIn('pay_ref_id', $invoiceIds)  // CORRECT: only regular invoice IDs
        ->pluck('pay_header_id')
        ->unique()
        ->toArray();
}
$payments = !empty($paymentIds) ? PayHeader::whereIn('id', $paymentIds)->get() : collect([]);

// Temp payments - use exclude invoice IDs separately
$excludeInvoiceIds = $excludeInvoices->pluck('id');
$tempPaymentIds = [];
if (!empty($excludeInvoiceIds)) {
    $tempPaymentIds = DB::table('temp_pay_allocation')
        ->whereIn('invoice_id', $excludeInvoiceIds)  // CORRECT: exclude invoice IDs
        ->pluck('pay_header_id')
        ->unique()
        ->toArray();
}
```

## Why This Separation Matters

1. **Different Payment Systems**: Regular payments and temp payments are separate systems with different purposes
2. **Different Table Structures**: `pay_allocation` and `temp_pay_allocation` have different schemas and relationships
3. **Data Integrity**: Merging them could cause incorrect payment linking and cancellation
4. **Business Logic**: Exclude invoices represent different transaction types (exchanges, returns) that use temp payments

## Implementation Locations

This separation is enforced in:

1. **`getSalesOrderDetails()`** method (Line 100-112)
   - Regular payments: Uses only `$invoices->pluck('id')`
   - Temp payments: Uses only `$excludeInvoiceIds`

2. **`executeEmergencyAction()`** method (Line 492-504)
   - Regular payments: Uses only `$invoices->pluck('id')`
   - Temp payments: Uses only `$excludeInvoiceIds`

## Related Documentation

- `ADMIN_PORTAL_TABLE_RELATIONS.md` - Complete table relationships
- `ADMIN_PORTAL_QUICK_REFERENCE.md` - Code snippets guide
- `ADMIN_PORTAL_TEMP_PAYMENTS.md` - Temp payments documentation
