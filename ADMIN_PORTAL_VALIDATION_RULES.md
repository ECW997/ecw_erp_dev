# Admin Portal - Validation Rules for Invoice Linking

## Overview
Before linking invoices to sales orders, the system validates that both the sales order headers and invoices meet specific conditions.

## Validation Rules

### Sales Order Header Validation
Before linking invoices to a sales order header, the following conditions must ALL be true:

1. **salesorder_no is NOT NULL**
   ```php
   !is_null($salesOrderHeader->salesorder_no)
   ```

2. **net_total > 0**
   ```php
   $salesOrderHeader->net_total > 0
   ```

3. **status IN ['Approved', 'Re-Approved']**
   ```php
   in_array($salesOrderHeader->status, ['Approved', 'Re-Approved'])
   ```

### Exclude Sales Order Header Validation
Before linking exclude invoices to an exclude sales order header, the following conditions must ALL be true:

1. **salesorder_no is NOT NULL**
   ```php
   !is_null($excludeSalesOrderHeader->salesorder_no)
   ```

2. **net_total > 0**
   ```php
   $excludeSalesOrderHeader->net_total > 0
   ```

3. **status IN ['Approved', 'Re-Approved']**
   ```php
   in_array($excludeSalesOrderHeader->status, ['Approved', 'Re-Approved'])
   ```

### Invoice Validation
Invoices must meet the following condition:

1. **inv_status IN ['1', '2']**
   ```php
   ->whereIn('inv_status', ['1', '2'])
   ```

## Complete Validation Pattern

### For Regular Invoices
```php
use App\Models\SalesOrderHeader;
use App\Models\Invoice;

$invoices = collect([]);
if ($relation->sales_orders_header_id) {
    // Step 1: Validate sales order header
    $salesOrderHeader = SalesOrderHeader::find($relation->sales_orders_header_id);
    
    // Step 2: Check all conditions
    if ($salesOrderHeader && 
        !is_null($salesOrderHeader->salesorder_no) && 
        $salesOrderHeader->net_total > 0 && 
        in_array($salesOrderHeader->status, ['Approved', 'Re-Approved'])) {
        
        // Step 3: Get invoices with valid invoice_status
        $invoices = Invoice::where('job_card_id', $relation->sales_orders_header_id)
            ->whereIn('inv_status', ['1', '2'])
            ->get();
    }
}
```

### For Exclude Invoices
```php
use App\Models\ExcludeSalesOrderHeader;
use App\Models\ExcludeInvoice;

$excludeInvoices = collect([]);
if ($relation->exclude_sales_orders_header_id) {
    // Step 1: Validate exclude sales order header
    $excludeSalesOrderHeader = ExcludeSalesOrderHeader::find($relation->exclude_sales_orders_header_id);
    
    // Step 2: Check all conditions
    if ($excludeSalesOrderHeader && 
        !is_null($excludeSalesOrderHeader->salesorder_no) && 
        $excludeSalesOrderHeader->net_total > 0 && 
        in_array($excludeSalesOrderHeader->status, ['Approved', 'Re-Approved'])) {
        
        // Step 3: Get exclude invoices with valid invoice_status
        $excludeInvoices = ExcludeInvoice::where('job_card_id', $relation->exclude_sales_orders_header_id)
            ->whereIn('inv_status', ['1', '2'])
            ->get();
    }
}
```

## Validation Logic Flow

```
1. Check if sales_orders_header_id exists
   ↓
2. Load SalesOrderHeader
   ↓
3. Validate:
   - salesorder_no is NOT NULL?
   - net_total > 0?
   - status IN ['Approved', 'Re-Approved']?
   ↓
4. If ALL validations pass:
   - Query invoices with inv_status IN ['1', '2']
   ↓
5. If ANY validation fails:
   - Skip invoice linking (empty collection)
```

## Why These Validations?

1. **salesorder_no NOT NULL**: Ensures sales order has been properly generated
2. **net_total > 0**: Ensures there's an actual order value (not zero or negative)
3. **status IN ['Approved', 'Re-Approved']**: Only process approved orders
4. **inv_status IN ['1', '2']**: Only link active invoices (status 1 or 2)

## Implementation Locations

These validations are applied in:

1. **`getSalesOrderDetails()`** - When displaying linked items
2. **`executeEmergencyAction()`** - When cancelling linked items

Both methods use the same validation logic to ensure consistency.

## See Also

- `ADMIN_PORTAL_TABLE_RELATIONS.md` - Table relationships reference
- `ADMIN_PORTAL_QUICK_REFERENCE.md` - Code snippets guide
- `AdminPortalController.php` - Full implementation
