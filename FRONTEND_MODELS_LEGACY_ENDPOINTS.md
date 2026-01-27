# Frontend Models - Legacy Endpoint Structure

All frontend models now use the legacy endpoint structure (`*_v1` format) matching the existing API config pattern.

## Updated Models

### Location: `application/models/Cashier/`

All models updated to use legacy endpoint format:

1. **Shiftinfo.php**
   - `checkCashierShift()` → `cashier_shift_v1` (GET)
   - `startCashierShift()` → `cashier_shift_v1` (POST)
   - `closeCashierShift()` → `cashier_shift_v1` (PUT)
   - `getCashierShiftRecDetails()` → `cashier_shift_v1` (GET with ID)
   - `updateShiftOpeningBalances()` → `update_shift_opening_balance_v1` (PUT)
   - `approveShiftOpeningBalances()` → `approve_shift_opening_balance_v1` (PUT)
   - `verifyClosingBalance()` → `verify_shift_closing_balance_v1` (PUT)
   - `updateClosingBalance()` → `update_shift_closing_balance_v1` (PUT)
   - `getAllCashierLog()` → `get_all_cashier_log_v1` (GET)

2. **Handoverinfo.php**
   - `getHandoverLogs()` → `cashier_handover_v1` (GET)
   - `getHandoverById()` → `cashier_handover_v1` (GET with ID)
   - `updateHandoverAmount()` → `cashier_handover_v1` (PUT)
   - `verifyHandover()` → `verify_cash_handover_v1` (PUT)
   - `generateVoucher()` → `cashier_handover_voucher_v1` (GET)

3. **Summaryinfo.php**
   - `getShiftSummaries()` → `cashier_shift_summary_v1` (GET)
   - `getSummaryById()` → `cashier_shift_summary_v1` (GET with ID)

4. **TransactionLedgerinfo.php**
   - `getTransactionLedgers()` → `cashier_shift_transaction_ledger_v1` (GET)
   - `getTransactionById()` → `cashier_shift_transaction_ledger_v1` (GET with ID)
   - `getByShift()` → `transaction_ledger_by_shift_v1` (GET with query params)
   - `getReversals()` → `transaction_ledger_reversals_v1` (GET)

5. **CashMovementinfo.php**
   - `getCashMovements()` → `cashier_cash_movement_v1` (GET)
   - `createCashMovement()` → `cashier_cash_movement_v1` (POST)
   - `approveCashMovement()` → `cashier_cash_movement_v1` (PUT)
   - `getCashMovementById()` → `cashier_cash_movement_v1` (GET with ID)
   - `deleteCashMovement()` → `cashier_cash_movement_v1` (DELETE)

6. **Adjustmentinfo.php**
   - `getAdjustments()` → `cashier_shift_adjustment_v1` (GET with optional query params)
   - `createAdjustment()` → `cashier_shift_adjustment_v1` (POST)
   - `updateAdjustment()` → `cashier_shift_adjustment_v1` (PUT)
   - `deleteAdjustment()` → `cashier_shift_adjustment_v1` (DELETE)
   - `getAdjustmentById()` → `cashier_shift_adjustment_v1` (GET with ID)

7. **IouSettlementinfo.php**
   - `getSettlements()` → `iou_settlement_v1` (GET with optional query params)
   - `getSettlementById()` → `iou_settlement_v1` (GET with ID)
   - `createSettlement()` → `iou_settlement_v1` (POST)
   - `updateSettlement()` → `iou_settlement_v1` (PUT)
   - `deleteSettlement()` → `iou_settlement_v1` (DELETE)
   - `getOutstandingIous()` → `outstanding_ious_v1` (GET)

8. **Authinfo.php**
   - `authorize()` → `cashier_auth_authorize_v1` (POST)
   - `checkSession()` → `cashier_auth_session_v1` (GET)
   - `logout()` → `cashier_auth_logout_v1` (POST)

9. **Reportinfo.php**
   - `dailySummary()` → `cashier_report_daily_summary_v1` (GET with query params)
   - `paymentSummary()` → `cashier_report_payment_summary_v1` (GET with query params)
   - `discrepancy()` → `cashier_report_discrepancy_v1` (GET with optional query params)
   - `cashOutSummary()` → `cashier_report_cash_out_summary_v1` (GET with optional query params)
   - `outstandingIous()` → `cashier_report_outstanding_ious_v1` (GET with optional query params)

---

## API Config Endpoints Added

All endpoints added to `application/config/api_config.php`:

```php
'cashier_shift_v1' => '/v1/cashier_shift',
'update_shift_opening_balance_v1' => '/v1/update_shift_opening_balance',
'approve_shift_opening_balance_v1' => '/v1/approve_shift_opening_balance',
'verify_shift_closing_balance_v1' => '/v1/verify_shift_closing_balance',
'update_shift_closing_balance_v1' => '/v1/update_shift_closing_balance',
'get_all_cashier_log_v1' => '/v1/get_all_cashier_log',

'cashier_handover_v1' => '/v1/cashier_handover',
'verify_cash_handover_v1' => '/v1/verify_cash_handover',
'cashier_handover_voucher_v1' => '/v1/cashier_handover_voucher',

'cashier_shift_summary_v1' => '/v1/cashier_shift_summary',

'cashier_shift_transaction_ledger_v1' => '/v1/cashier_shift_transaction_ledger',
'transaction_ledger_by_shift_v1' => '/v1/transaction_ledger_by_shift',
'transaction_ledger_reversals_v1' => '/v1/transaction_ledger_reversals',

'cashier_cash_movement_v1' => '/v1/cashier_cash_movement',

'cashier_shift_adjustment_v1' => '/v1/cashier_shift_adjustment',

'iou_settlement_v1' => '/v1/iou_settlement',
'outstanding_ious_v1' => '/v1/outstanding_ious',

'cashier_auth_authorize_v1' => '/v1/cashier_auth_authorize',
'cashier_auth_session_v1' => '/v1/cashier_auth_session',
'cashier_auth_logout_v1' => '/v1/cashier_auth_logout',

'cashier_report_daily_summary_v1' => '/v1/cashier_report_daily_summary',
'cashier_report_payment_summary_v1' => '/v1/cashier_report_payment_summary',
'cashier_report_discrepancy_v1' => '/v1/cashier_report_discrepancy',
'cashier_report_cash_out_summary_v1' => '/v1/cashier_report_cash_out_summary',
'cashier_report_outstanding_ious_v1' => '/v1/cashier_report_outstanding_ious',
```

---

## Backend Routes Structure

Backend routes maintain both structures:
- **New structure**: `/v1/cashier/*` (for future use)
- **Legacy structure**: `/v1/cashier_*_v1` (for frontend compatibility)

All legacy routes map to the new controllers in `Cashier/` folder.

---

## call_api Helper Enhancement

Updated `application/helpers/api_helper.php` to properly handle:
- GET requests with query parameters (as array)
- GET requests with IDs (as string/number)
- PUT requests with `recordID` or `id`
- DELETE requests with IDs

Example usage:
```php
// GET with query params
call_api('GET', 'cashier_report_daily_summary_v1', ['date' => '2024-01-15'], $headers);

// GET with ID
call_api('GET', 'cashier_shift_v1', '123', $headers);

// PUT with recordID
call_api('PUT', 'cashier_shift_v1', ['recordID' => 123, 'data' => '...'], $headers);
```

---

## Complete Endpoint Mapping

| Frontend Method | API Config Key | Backend Endpoint | Method |
|----------------|---------------|------------------|--------|
| Shiftinfo->checkCashierShift() | cashier_shift_v1 | /v1/cashier_shift | GET |
| Shiftinfo->startCashierShift() | cashier_shift_v1 | /v1/cashier_shift | POST |
| Shiftinfo->closeCashierShift() | cashier_shift_v1 | /v1/cashier_shift/{id} | PUT |
| Shiftinfo->updateShiftOpeningBalances() | update_shift_opening_balance_v1 | /v1/update_shift_opening_balance/{id} | PUT |
| Shiftinfo->approveShiftOpeningBalances() | approve_shift_opening_balance_v1 | /v1/approve_shift_opening_balance/{id} | PUT |
| Shiftinfo->verifyClosingBalance() | verify_shift_closing_balance_v1 | /v1/verify_shift_closing_balance/{id} | PUT |
| Shiftinfo->updateClosingBalance() | update_shift_closing_balance_v1 | /v1/update_shift_closing_balance/{id} | PUT |
| Shiftinfo->getAllCashierLog() | get_all_cashier_log_v1 | /v1/get_all_cashier_log | GET |
| Handoverinfo->getHandoverLogs() | cashier_handover_v1 | /v1/cashier_handover | GET |
| Handoverinfo->verifyHandover() | verify_cash_handover_v1 | /v1/verify_cash_handover/{id} | PUT |
| Adjustmentinfo->createAdjustment() | cashier_shift_adjustment_v1 | /v1/cashier_shift_adjustment | POST |
| CashMovementinfo->createCashMovement() | cashier_cash_movement_v1 | /v1/cashier_cash_movement | POST |
| IouSettlementinfo->createSettlement() | iou_settlement_v1 | /v1/iou_settlement | POST |
| IouSettlementinfo->getOutstandingIous() | outstanding_ious_v1 | /v1/outstanding_ious | GET |
| Authinfo->authorize() | cashier_auth_authorize_v1 | /v1/cashier_auth_authorize | POST |
| Reportinfo->dailySummary() | cashier_report_daily_summary_v1 | /v1/cashier_report_daily_summary | GET |

All endpoints follow the legacy `*_v1` naming convention for consistency with existing codebase.

