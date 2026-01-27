# Cashier Views - Complete Folder Structure

## Overview
All cashier views are now organized in the `Cashier/` folder structure, following the same pattern as controllers and models.

## Folder Structure

```
application/views/
├── Cashier/
│   ├── Shift.php                 - Cashier shift management
│   ├── Handover.php              - Cash handover management
│   ├── Summary.php               - Shift summary view
│   ├── TransactionLedger.php     - Transaction ledger view
│   ├── CashMovement.php          - Cash movements (in/out)
│   ├── Adjustment.php            - Shift adjustments
│   ├── IouSettlement.php         - IOU settlements
│   └── Report/
│       ├── DailySummary.php      - Daily summary report
│       ├── PaymentSummary.php    - Payment summary by method
│       ├── Discrepancy.php       - Shift discrepancy report
│       ├── CashOutSummary.php    - Cash out summary report
│       └── OutstandingIous.php   - Outstanding IOUs report
│
└── (Previous views remain unchanged)
    ├── cashier_shift.php         - Old view (unchanged)
    ├── cashier_handover.php      - Old view (unchanged)
    └── ...
```

## Views Created

### Main Views (`Cashier/`)

1. **Shift.php**
   - Start/Close shift
   - Update opening/closing balances
   - View shift details
   - Approve/verify operations

2. **Handover.php**
   - List handover logs
   - Edit handover amounts
   - Verify handovers

3. **Summary.php**
   - View shift summaries
   - Payment breakdowns by method
   - Shift statistics

4. **TransactionLedger.php**
   - View all transactions per shift
   - Filter by shift
   - Transaction details

5. **CashMovement.php**
   - Create cash in/out movements
   - Approve cash out movements
   - Filter by shift
   - View movement history

6. **Adjustment.php**
   - Add/edit/delete adjustments
   - Adjustment types: Invoice Void, Correction, Manual
   - Filter by shift

7. **IouSettlement.php**
   - Outstanding IOUs display
   - Create/edit settlements
   - Settlement types: Cash Return, Expense Claim, Payroll Deduction

### Report Views (`Cashier/Report/`)

1. **DailySummary.php**
   - Daily summary by date
   - Shift-wise breakdown
   - Totals by payment method

2. **PaymentSummary.php**
   - Payment summary by date range
   - Breakdown by method (Cash, Card, Cheque, Online, Other)
   - Export functionality

3. **Discrepancy.php**
   - Shift discrepancy analysis
   - System calculated vs actual cash
   - Filter by shift/date range

4. **CashOutSummary.php**
   - All cash out movements
   - Filter by shift/date range
   - Approval status tracking

5. **OutstandingIous.php**
   - Outstanding IOUs list
   - Days outstanding calculation
   - Filter by shift

## Include Paths

All views in `Cashier/` folder use relative paths:
- `../include/header.php`
- `../include/footer.php`
- `../components/modal/...`

## URL Routes

All views are accessible via:
- `base_url('Cashier/Shift')`
- `base_url('Cashier/Handover')`
- `base_url('Cashier/Summary')`
- `base_url('Cashier/TransactionLedger')`
- `base_url('Cashier/CashMovement')`
- `base_url('Cashier/Adjustment')`
- `base_url('Cashier/IouSettlement')`
- `base_url('Cashier/Report/dailySummary')`
- `base_url('Cashier/Report/paymentSummary')`
- `base_url('Cashier/Report/discrepancy')`
- `base_url('Cashier/Report/cashOutSummary')`
- `base_url('Cashier/Report/outstandingIous')`

## Menubar Links

All links updated in `menubar.php`:
- Cashier Shift → `Cashier/Shift`
- Cash Handover → `Cashier/Handover`
- Shift Summary → `Cashier/Summary`
- Transaction Ledger → `Cashier/TransactionLedger`
- Cash Movements → `Cashier/CashMovement`
- Adjustments → `Cashier/Adjustment`
- IOU Settlements → `Cashier/IouSettlement`
- Reports submenu → All 5 report views

## Features

### Common Features Across All Views:
- ✅ Consistent styling with existing cashier views
- ✅ DataTables integration for listing
- ✅ Modal forms for add/edit
- ✅ AJAX-based operations
- ✅ Toast notifications
- ✅ Responsive design
- ✅ Currency formatting
- ✅ Status badges
- ✅ Action buttons with icons

### Specific Features:
- **Shift View**: Opening/closing balance management, approval workflow
- **Handover View**: Cash handover verification
- **Adjustment View**: Shift adjustments with types
- **IOU Settlement**: Outstanding tracking, settlement management
- **Reports**: Date filters, export options, summary totals

## Previous Views Status

✅ **All previous cashier views remain unchanged:**
- `cashier_shift.php` - Still works
- `cashier_handover.php` - Still works
- `cashier_shift_summary.php` - Still works
- `cashier_transaction_ledger.php` - Still works
- `cashier_cash_movements.php` - Still works
- `cashier_adjustments.php` - Still works
- `cashier_iou_settlements.php` - Still works

New organized views in `Cashier/` folder work alongside existing views.

## Notes

- All views follow the same structure and styling as existing cashier views
- Include paths are updated to work from subfolder location
- Controllers need to load views from `Cashier/` folder
- Menu links point to new organized structure
- Both old and new views can coexist

