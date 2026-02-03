# Admin Portal - Unified Cancellation Approach

## Overview

The Admin Portal implements a **unified cancellation action** that handles Sales Order Relations and ALL their linked items together as one integrated operation.

## Key Principle

**All linked items are cancelled together in a single transaction, not as separate operations.**

## What Gets Cancelled (Unified Action)

When a Sales Order Relation is cancelled, the following items are ALL cancelled together:

1. **Sales Order Relation** (Main Entity)
   - `sales_order_relation` - Status set to 'CANCELLED'

2. **Linked Sales Orders**
   - `sales_orders_header` - Status set to 'CANCELLED'
   - `sales_orders_details` - Status set to 'CANCELLED'

3. **Linked Exclude Sales Orders**
   - `exclude_sales_orders_header` - Status set to 'CANCELLED'
   - `exclude_sales_orders_details` - Status set to 'CANCELLED'

4. **Linked Invoices**
   - `inv_header` - Status set to 'CANCELLED'
   - `inv_details` - Status set to 'CANCELLED'

5. **Linked Exclude Invoices**
   - `exclude_inv_header` - Status set to 'CANCELLED'
   - `exclude_inv_details` - Status set to 'CANCELLED'

6. **Linked Payments**
   - `pay_header` - Status set to 'CANCELLED'
   - `pay_details` - Status set to 'CANCELLED'
   - `pay_allocation` - Status set to 'CANCELLED'

7. **Linked Temp Payments**
   - `temp_pay_header` - Status set to 'CANCELLED'
   - `temp_pay_details` - Status set to 'CANCELLED'
   - `temp_pay_allocation` - Status set to 'CANCELLED'

## Important Points

### ✅ What This Means
- **One Action**: Single unified cancellation operation
- **All Items Together**: Sales orders, invoices, payments, temp payments all cancelled together
- **Single Transaction**: All or nothing - if any item fails, entire operation rolls back
- **One Log Entry**: Single log entry records cancellation of all linked items
- **Data Integrity**: Ensures all related records are cancelled consistently

### ❌ What This Does NOT Mean
- **No Separate Actions**: There are NO separate cancellation actions for:
  - Invoices alone
  - Payments alone
  - Sales Orders alone
- **No Partial Cancellation**: You cannot cancel just an invoice or just a payment - they are all cancelled together as part of the Sales Order Relation cancellation

## Action Type Registry

The system uses one action type:

```php
'SALES_ORDER_RELATION_CANCEL' => [
    'name' => 'Sales Order Relation Cancellation',
    'description' => 'Cancel sales order relation and ALL linked records as one unified action',
    'cancels_linked_items' => [
        'sales_orders' => true,
        'exclude_sales_orders' => true,
        'invoices' => true,
        'exclude_invoices' => true,
        'payments' => true,
        'temp_payments' => true
    ]
]
```

## Database Transaction Flow

```
1. Start Transaction
   ↓
2. Cancel Sales Order Header & Details
   ↓
3. Cancel Exclude Sales Order Header & Details
   ↓
4. Cancel Linked Invoices & Invoice Details
   ↓
5. Cancel Linked Exclude Invoices & Details
   ↓
6. Cancel Linked Temp Payments (Header, Details, Allocations)
   ↓
7. Cancel Linked Regular Payments (Header, Details, Allocations)
   ↓
8. Cancel Sales Order Relation (Main Entity)
   ↓
9. Create Log Entry (records all cancelled items)
   ↓
10. Commit Transaction (ALL items cancelled together)
```

**If any step fails**: Entire transaction rolls back, nothing is cancelled.

## Logging

One log entry is created that records:
- Sales Order Relation ID
- All cancelled Sales Order IDs
- All cancelled Exclude Sales Order IDs
- All cancelled Invoice IDs
- All cancelled Exclude Invoice IDs
- All cancelled Payment IDs
- All cancelled Temp Payment IDs
- Job Card ID
- Reason for cancellation
- User and Branch information
- Status (SUCCESS/FAILED)

## Benefits of Unified Approach

1. **Data Integrity**: All related records cancelled together ensures consistency
2. **Simpler Process**: One action instead of multiple separate actions
3. **Atomic Operation**: All or nothing - no partial cancellations
4. **Complete Audit Trail**: One log entry shows everything that was cancelled
5. **Reduced Risk**: No chance of cancelling some items but not others

## Example Scenario

**Scenario**: Admin needs to cancel Sales Order Relation ID 123

**What Happens**:
1. Admin enters Sales Order Relation ID: 123
2. System shows ALL linked items:
   - Sales Order: SO-001
   - Exclude Sales Order: ESO-001
   - Invoice: INV-001, INV-002
   - Exclude Invoice: EINV-001
   - Payment: PAY-001, PAY-002
   - Temp Payment: TEMP-001
3. Admin confirms cancellation with reason
4. System cancels ALL items together in one transaction:
   - Sales Order Relation 123 → CANCELLED
   - SO-001 → CANCELLED
   - ESO-001 → CANCELLED
   - INV-001, INV-002 → CANCELLED
   - EINV-001 → CANCELLED
   - PAY-001, PAY-002 → CANCELLED
   - TEMP-001 → CANCELLED
5. One log entry created showing all cancelled items

**Result**: All linked items cancelled together, ensuring data integrity.

## Summary

The Admin Portal provides a **unified cancellation action** that:
- Cancels Sales Order Relation and ALL linked items together
- Ensures data integrity through atomic transactions
- Provides comprehensive audit logging
- Simplifies the cancellation process
- Prevents partial cancellations

There are NO separate cancellation actions for individual item types - everything is handled as one unified operation.
