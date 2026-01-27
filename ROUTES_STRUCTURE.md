# Cashier Routes Structure - Backend API

## Overview
This document explains the dual routing structure for the Cashier module:
1. **OLD Routes** - Continue using existing controllers (unchanged)
2. **NEW Routes** - Use new organized controllers in `Cashier/` folder

---

## OLD Routes (Existing - DO NOT CHANGE)

### Controllers Location
- `App\Http\Controllers\v1\CashierShiftController`
- `App\Http\Controllers\v1\CashierHandoverController`
- `App\Http\Controllers\v1\CashierShiftSummaryController`
- `App\Http\Controllers\v1\CashierTransactionLedgerController`
- `App\Http\Controllers\CashierCashMovementsController`

### Models Used
- `App\Models\CashierShift`
- `App\Models\CashierHandOverLogs`
- `App\Models\CashierShiftSummary`
- `App\Models\CashierTransactionLedger`
- `App\Models\CashierCashMovement`

### Endpoints
```
GET    /api/v1/cashier_shift
POST   /api/v1/cashier_shift
PUT    /api/v1/cashier_shift/{id}
DELETE /api/v1/cashier_shift/{id}

GET    /api/v1/get_all_cashier_log
PUT    /api/v1/update_shift_opening_balance/{id}
PUT    /api/v1/approve_shift_opening_balance/{id}

GET    /api/v1/cashier_handover
POST   /api/v1/cashier_handover
PUT    /api/v1/cashier_handover/{id}
DELETE /api/v1/cashier_handover/{id}

GET    /api/v1/cashier_shift_summary
POST   /api/v1/cashier_shift_summary
PUT    /api/v1/cashier_shift_summary/{id}
DELETE /api/v1/cashier_shift_summary/{id}

GET    /api/v1/cashier_shift_transaction_ledger
POST   /api/v1/cashier_shift_transaction_ledger
PUT    /api/v1/cashier_shift_transaction_ledger/{id}
DELETE /api/v1/cashier_shift_transaction_ledger/{id}
```

**Status**: ✅ These routes remain **UNCHANGED** and continue to work with existing functionality.

---

## NEW Routes (v1 Organized Structure)

### Controllers Location
- `App\Http\Controllers\v1\Cashier\ShiftController`
- `App\Http\Controllers\v1\Cashier\HandoverController`
- `App\Http\Controllers\v1\Cashier\ShiftSummaryController`
- `App\Http\Controllers\v1\Cashier\TransactionLedgerController`
- `App\Http\Controllers\v1\Cashier\CashMovementController`
- `App\Http\Controllers\v1\Cashier\ShiftAdjustmentController`
- `App\Http\Controllers\v1\Cashier\IouSettlementController`
- `App\Http\Controllers\v1\Cashier\AuthController`
- `App\Http\Controllers\v1\Cashier\ReportController`

### Models Used
- `App\Models\Cashier\Shift`
- `App\Models\Cashier\HandOverLogs`
- `App\Models\Cashier\ShiftSummary`
- `App\Models\Cashier\TransactionLedger`
- `App\Models\Cashier\CashMovement`
- `App\Models\Cashier\ShiftAdjustment`
- `App\Models\Cashier\IouSettlement`
- `App\Models\Cashier\Session` (optional)

### Endpoints

#### Organized Structure (`/api/v1/cashier/*`)
```
# Shift Management
GET    /api/v1/cashier/shift
POST   /api/v1/cashier/shift
PUT    /api/v1/cashier/shift/{id}
DELETE /api/v1/cashier/shift/{id}
GET    /api/v1/cashier/shift/get_all_cashier_log
PUT    /api/v1/cashier/shift/{id}/update_opening_balance
PUT    /api/v1/cashier/shift/{id}/approve_opening_balance
PUT    /api/v1/cashier/shift/{id}/verify_closing_balance
PUT    /api/v1/cashier/shift/{id}/update_closing_balance

# Handover
GET    /api/v1/cashier/handover
POST   /api/v1/cashier/handover
PUT    /api/v1/cashier/handover/{id}
DELETE /api/v1/cashier/handover/{id}
PUT    /api/v1/cashier/handover/{id}/verify
GET    /api/v1/cashier/handover/{id}/voucher

# Shift Summary
GET    /api/v1/cashier/shift_summary
POST   /api/v1/cashier/shift_summary
PUT    /api/v1/cashier/shift_summary/{id}
DELETE /api/v1/cashier/shift_summary/{id}

# Transaction Ledger
GET    /api/v1/cashier/transaction_ledger
POST   /api/v1/cashier/transaction_ledger
PUT    /api/v1/cashier/transaction_ledger/{id}
DELETE /api/v1/cashier/transaction_ledger/{id}
GET    /api/v1/cashier/transaction_ledger/by_shift/{shiftId}
GET    /api/v1/cashier/transaction_ledger/reversals

# Cash Movements
GET    /api/v1/cashier/cash_movement
POST   /api/v1/cashier/cash_movement
PUT    /api/v1/cashier/cash_movement/{id}
DELETE /api/v1/cashier/cash_movement/{id}

# Shift Adjustments
GET    /api/v1/cashier/shift_adjustment
POST   /api/v1/cashier/shift_adjustment
PUT    /api/v1/cashier/shift_adjustment/{id}
DELETE /api/v1/cashier/shift_adjustment/{id}

# IOU Settlements
GET    /api/v1/cashier/iou_settlement
POST   /api/v1/cashier/iou_settlement
PUT    /api/v1/cashier/iou_settlement/{id}
DELETE /api/v1/cashier/iou_settlement/{id}
GET    /api/v1/cashier/iou_settlement/outstanding/list

# Cashier Authorization
POST   /api/v1/cashier/auth/authorize
GET    /api/v1/cashier/auth/session
POST   /api/v1/cashier/auth/logout

# Reports
GET    /api/v1/cashier/reports/daily_summary
GET    /api/v1/cashier/reports/payment_summary
GET    /api/v1/cashier/reports/discrepancy
GET    /api/v1/cashier/reports/cash_out_summary
GET    /api/v1/cashier/reports/outstanding_ious
```

#### Legacy Format (for Frontend Compatibility)
```
# Additional endpoints matching frontend API config
PUT    /api/v1/verify_shift_closing_balance/{id}
PUT    /api/v1/update_shift_closing_balance/{id}
PUT    /api/v1/verify_cash_handover/{id}
GET    /api/v1/cashier_handover_voucher/{id}
GET    /api/v1/transaction_ledger_by_shift/{shiftId}
GET    /api/v1/transaction_ledger_reversals

GET    /api/v1/cashier_cash_movement
POST   /api/v1/cashier_cash_movement
PUT    /api/v1/cashier_cash_movement/{id}
DELETE /api/v1/cashier_cash_movement/{id}

GET    /api/v1/cashier_shift_adjustment
POST   /api/v1/cashier_shift_adjustment
PUT    /api/v1/cashier_shift_adjustment/{id}
DELETE /api/v1/cashier_shift_adjustment/{id}

GET    /api/v1/iou_settlement
POST   /api/v1/iou_settlement
PUT    /api/v1/iou_settlement/{id}
DELETE /api/v1/iou_settlement/{id}
GET    /api/v1/outstanding_ious

POST   /api/v1/cashier_auth_authorize
GET    /api/v1/cashier_auth_session
POST   /api/v1/cashier_auth_logout

GET    /api/v1/cashier_report_daily_summary
GET    /api/v1/cashier_report_payment_summary
GET    /api/v1/cashier_report_discrepancy
GET    /api/v1/cashier_report_cash_out_summary
GET    /api/v1/cashier_report_outstanding_ious
```

**Status**: ✅ These routes use the **NEW** organized controllers and models.

---

## Key Differences

| Aspect | OLD Routes | NEW Routes |
|--------|-----------|------------|
| **Controller Location** | `v1/Cashier*Controller.php` | `v1/Cashier/*Controller.php` |
| **Model Location** | `App\Models\Cashier*` | `App\Models\Cashier\*` |
| **Route Structure** | Flat (`/v1/cashier_*`) | Organized (`/v1/cashier/*`) |
| **Namespace** | `App\Http\Controllers\v1` | `App\Http\Controllers\v1\Cashier` |
| **Status** | ✅ Unchanged | ✅ New Development |

---

## Frontend Compatibility

The frontend uses the legacy endpoint structure (`*_v1` format) which maps to:
- **Legacy format routes** (for backward compatibility)
- All routes under `/api/v1/cashier/*` also available

---

## Migration Path

1. **Existing Functionality**: Continue using OLD routes - they remain unchanged
2. **New Development**: Use NEW routes under `/api/v1/cashier/*`
3. **Frontend**: Can gradually migrate from legacy endpoints to new organized structure
4. **Both structures work simultaneously** - no breaking changes

---

## Notes

- ✅ OLD controllers are **NOT modified**
- ✅ NEW controllers are in organized `Cashier/` folder
- ✅ Both routing structures coexist
- ✅ Frontend can use either structure
- ✅ All new features use NEW structure
- ✅ Existing features continue working with OLD structure

