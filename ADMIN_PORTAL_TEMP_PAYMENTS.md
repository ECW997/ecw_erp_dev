# Admin Portal - Temp Payments Integration

## Overview
The Admin Portal emergency action now includes cancellation of temp payment tables that are linked to exclude sales orders. Temp payments are advance payments or temporary payment records that are associated with exclude invoices or jobcards.

## Temp Payment Tables Structure

### Tables Involved:
1. **`temp_pay_header`** - Header table for temp payments
2. **`temp_pay_details`** - Payment method details (cash, card, cheque, etc.)
3. **`temp_pay_allocation`** - Links temp payments to invoices or jobcards

### Relationships:
- **Temp payments linked to Exclude Invoices**: 
  - `temp_pay_allocation.invoice_id` → `exclude_inv_header.id`
  - Used for advance payments against exclude invoices

- **Temp payments linked to Jobcard (Advance Payments)**:
  - `temp_pay_allocation.pay_type` = 'JobCard'
  - `temp_pay_allocation.pay_ref_id` = `jobcard_id`
  - Used for advance payments made before invoice creation

## Implementation Details

### 1. Sales Order Relation Structure
```
SalesOrderRelation (Main Table)
├── sales_orders_header_id → Sales Order Header
│   └── Links to: inv_header, pay_header
└── exclude_sales_orders_header_id → Exclude Sales Order Header
    └── Links to: exclude_inv_header, temp_pay_header
```

### 2. Cancellation Flow

When an emergency action is executed, the system cancels:

1. **Sales Order Header & Details**
2. **Exclude Sales Order Header & Details**
3. **Linked Invoices** (`inv_header` & `inv_details`)
4. **Linked Exclude Invoices** (`exclude_inv_header` & `exclude_inv_details`)
5. **Temp Payments** (NEW):
   - `temp_pay_header` - Sets status to 'CANCELLED'
   - `temp_pay_details` - Sets status to 'CANCELLED'
   - `temp_pay_allocation` - Sets status to 'CANCELLED'
6. **Regular Payments** (`pay_header`, `pay_details`, `pay_allocation`)
7. **Sales Order Relation** - Final cancellation

### 3. Temp Payment Detection

The system finds temp payments in two ways:

#### Method 1: Via Exclude Invoice IDs
```php
// Get temp payments linked to exclude invoices
$tempPaymentIdsFromInvoices = DB::table('temp_pay_allocation')
    ->whereIn('invoice_id', $excludeInvoiceIds)
    ->pluck('pay_header_id')
    ->unique();
```

#### Method 2: Via Jobcard (Advance Payments)
```php
// Get temp payments linked to jobcard (advance payments)
$tempPaymentIdsFromJobcard = DB::table('temp_pay_allocation')
    ->where('pay_type', 'JobCard')
    ->where('pay_ref_id', $relation->jobcard_id)
    ->pluck('pay_header_id')
    ->unique();
```

### 4. Cancellation Process

For each temp payment found:

```php
// 1. Cancel temp_pay_header
DB::table('temp_pay_header')
    ->where('id', $tempPayHeaderId)
    ->update([
        'status' => 'CANCELLED',
        'cancelled_at' => Carbon::now(),
        'cancelled_by' => $user->id,
        'status_upd' => 'CANCELLED',
        'status_upd_at' => Carbon::now()
    ]);

// 2. Cancel temp_pay_details
DB::table('temp_pay_details')
    ->where('pay_header_id', $tempPayHeaderId)
    ->update([
        'status' => 'CANCELLED',
        'status_upd' => 'CANCELLED',
        'status_upd_at' => Carbon::now()
    ]);

// 3. Cancel temp_pay_allocation
DB::table('temp_pay_allocation')
    ->where('pay_header_id', $tempPayHeaderId)
    ->update([
        'status' => 'CANCELLED',
        'status_upd' => 'CANCELLED',
        'status_upd_at' => Carbon::now()
    ]);
```

## UI Updates

### Emergency Action Form
- Added "Linked Temp Payments" field in the details display
- Shows count of temp payments that will be cancelled
- Warning message updated to mention temp payments

### Log Details
- Temp payments are included in the cancellation log
- Shows receipt numbers of cancelled temp payments

## Database Impact

### Tables Modified:
- `temp_pay_header` - Status set to 'CANCELLED'
- `temp_pay_details` - Status set to 'CANCELLED'
- `temp_pay_allocation` - Status set to 'CANCELLED'

### Audit Trail:
All cancelled temp payments are logged in `admin_portal_sales_order_cancellation_logs` table under `action_details` JSON field:

```json
{
  "cancelled_records": {
    "temp_payments": [
      {
        "id": 123,
        "receipt_number": "RCPT/26/1/0001"
      }
    ]
  }
}
```

## Important Notes

1. **Transaction Safety**: All temp payment cancellations are wrapped in database transactions
2. **Comprehensive Coverage**: Both invoice-linked and jobcard-linked temp payments are cancelled
3. **Status Consistency**: All related temp payment tables are updated consistently
4. **Audit Trail**: Complete record of cancelled temp payments is maintained
5. **Irreversible**: Temp payment cancellations cannot be undone

## Testing Checklist

- [ ] Verify temp payments linked to exclude invoices are cancelled
- [ ] Verify temp payments linked to jobcard (advance payments) are cancelled
- [ ] Verify temp_pay_header status is updated
- [ ] Verify temp_pay_details status is updated
- [ ] Verify temp_pay_allocation status is updated
- [ ] Verify temp payments appear in the verification details
- [ ] Verify temp payments are logged in action_details
- [ ] Verify transaction rollback on errors
- [ ] Verify branch restrictions apply to temp payments

## Related Files

- `app/Http/Controllers/v1/AdminPortalController.php` - Main controller with temp payment logic
- `application/views/AdminPortal/emergency_action_form.php` - UI form showing temp payments
- `ADMIN_PORTAL_SETUP.md` - Setup documentation
- `ADMIN_PORTAL_SUMMARY.md` - Implementation summary
