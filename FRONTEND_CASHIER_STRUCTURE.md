# Frontend Cashier Module - Complete Structure

## Controllers (CodeIgniter 3)

### Location: `application/controllers/Cashier/`

| Controller | File | Methods |
|-----------|------|---------|
| **Shift** | `Shift.php` | index, checkCashierShift, startCashierShift, closeCashierShift, getCashierShiftRecDetails, updateShiftOpeningBalances, approveShiftOpeningBalances, verifyClosingBalance, updateClosingBalance, getAllCashierLog |
| **Handover** | `Handover.php` | index, getHandoverLogs, updateHandoverAmount, verifyHandover, generateVoucher |
| **Summary** | `Summary.php` | index, getShiftSummaries, getSummaryById |
| **TransactionLedger** | `TransactionLedger.php` | index, getTransactionLedgers, getByShift, getReversals, getTransactionById |
| **CashMovement** | `CashMovement.php` | index, getCashMovements, createCashMovement, approveCashMovement, getCashMovementById, deleteCashMovement |
| **IouSettlement** | `IouSettlement.php` | index, getSettlements, getOutstandingIous, createSettlement, updateSettlement, deleteSettlement, getSettlementById |
| **Adjustment** | `Adjustment.php` | index, create, update, delete |
| **Auth** | `Auth.php` | authorize, checkSession, logout |
| **Report** | `Report.php` | dailySummary, paymentSummary, discrepancy, cashOutSummary, outstandingIous |

---

## Models (CodeIgniter 3)

### Location: `application/models/Cashier/`

| Model | File | Methods |
|------|------|---------|
| **Shiftinfo** | `Shiftinfo.php` | checkCashierShift, startCashierShift, closeCashierShift, getCashierShiftRecDetails, updateShiftOpeningBalances, approveShiftOpeningBalances, verifyClosingBalance, updateClosingBalance, getAllCashierLog |
| **Handoverinfo** | `Handoverinfo.php` | getHandoverLogs, getHandoverById, updateHandoverAmount, verifyHandover, generateVoucher |
| **Summaryinfo** | `Summaryinfo.php` | getShiftSummaries, getSummaryById |
| **TransactionLedgerinfo** | `TransactionLedgerinfo.php` | getTransactionLedgers, getTransactionById, getByShift, getReversals |
| **CashMovementinfo** | `CashMovementinfo.php` | getCashMovements, createCashMovement, approveCashMovement, getCashMovementById, deleteCashMovement, checkCashierShift |
| **Adjustmentinfo** | `Adjustmentinfo.php` | getAdjustments, createAdjustment, updateAdjustment, deleteAdjustment, getAdjustmentById |
| **IouSettlementinfo** | `IouSettlementinfo.php` | getSettlements, getSettlementById, createSettlement, updateSettlement, deleteSettlement, getOutstandingIous |
| **Authinfo** | `Authinfo.php` | authorize, checkSession, logout |
| **Reportinfo** | `Reportinfo.php` | dailySummary, paymentSummary, discrepancy, cashOutSummary, outstandingIous |

---

## URL Routes (CodeIgniter)

### Base URL Pattern
All routes follow: `base_url() . 'Cashier/{Controller}/{Method}'`

### Examples:
- `base_url() . 'Cashier/Shift'` - Shift management
- `base_url() . 'Cashier/Shift/startCashierShift'` - Start shift
- `base_url() . 'Cashier/Handover'` - Handover list
- `base_url() . 'Cashier/Adjustment'` - Adjustments
- `base_url() . 'Cashier/CashMovement'` - Cash movements
- `base_url() . 'Cashier/IouSettlement'` - IOU settlements
- `base_url() . 'Cashier/Auth/authorize'` - Authorize as cashier
- `base_url() . 'Cashier/Report/dailySummary'` - Daily summary report

---

## API Endpoint Mapping

All models use the new API endpoints under `/cashier` prefix:

| Frontend Model Method | Backend API Endpoint |
|----------------------|---------------------|
| `Shiftinfo->checkCashierShift()` | `GET /cashier/shift` |
| `Shiftinfo->startCashierShift()` | `POST /cashier/shift` |
| `Shiftinfo->closeCashierShift()` | `PUT /cashier/shift/{id}` |
| `Shiftinfo->updateShiftOpeningBalances()` | `PUT /cashier/shift/{id}/update_opening_balance` |
| `Shiftinfo->approveShiftOpeningBalances()` | `PUT /cashier/shift/{id}/approve_opening_balance` |
| `Shiftinfo->verifyClosingBalance()` | `PUT /cashier/shift/{id}/verify_closing_balance` |
| `Shiftinfo->updateClosingBalance()` | `PUT /cashier/shift/{id}/update_closing_balance` |
| `Handoverinfo->getHandoverLogs()` | `GET /cashier/handover` |
| `Handoverinfo->verifyHandover()` | `PUT /cashier/handover/{id}/verify` |
| `Adjustmentinfo->createAdjustment()` | `POST /cashier/shift_adjustment` |
| `CashMovementinfo->createCashMovement()` | `POST /cashier/cash_movement` |
| `IouSettlementinfo->createSettlement()` | `POST /cashier/iou_settlement` |
| `Authinfo->authorize()` | `POST /cashier/auth/authorize` |
| `Reportinfo->dailySummary()` | `GET /cashier/reports/daily_summary` |

---

## Usage Examples

### In Controllers:
```php
// Load model
$this->load->model('Cashier/Shiftinfo');

// Call API
$response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
```

### In Views (via AJAX):
```javascript
// Start Shift
$.ajax({
    url: '<?php echo base_url(); ?>Cashier/Shift/startCashierShift',
    type: 'POST',
    data: {
        opening_balance_cash: 5000,
        opening_balance_slips: 0,
        opening_balance_cheques: 0
    },
    success: function(response) {
        // Handle response
    }
});

// Authorize as Cashier
$.ajax({
    url: '<?php echo base_url(); ?>Cashier/Auth/authorize',
    type: 'POST',
    success: function(response) {
        // Handle authorization
    }
});
```

---

## File Structure

```
ecw_erp_dev/
├── application/
│   ├── controllers/
│   │   └── Cashier/
│   │       ├── Shift.php
│   │       ├── Handover.php
│   │       ├── Summary.php
│   │       ├── TransactionLedger.php
│   │       ├── CashMovement.php
│   │       ├── IouSettlement.php
│   │       ├── Adjustment.php
│   │       ├── Auth.php
│   │       └── Report.php
│   └── models/
│       └── Cashier/
│           ├── Shiftinfo.php
│           ├── Handoverinfo.php
│           ├── Summaryinfo.php
│           ├── TransactionLedgerinfo.php
│           ├── CashMovementinfo.php
│           ├── Adjustmentinfo.php
│           ├── IouSettlementinfo.php
│           ├── Authinfo.php
│           └── Reportinfo.php
```

---

## Migration Notes

### From Old Structure:
- Old: `$this->load->model('CashierShiftinfo')`
- New: `$this->load->model('Cashier/Shiftinfo')`

- Old: `redirect('CashierShift')`
- New: `redirect('Cashier/Shift')`

### Session Storage:
- Cashier authorization stored in: `$this->session->userdata('cashier_authorized')`
- Cashier session data: `$this->session->userdata('cashier_session')`

---

## Complete Controller Methods Summary

### Shift Controller
- ✅ `index()` - Main shift management view
- ✅ `checkCashierShift()` - Check active shift (AJAX)
- ✅ `startCashierShift()` - Start new shift
- ✅ `closeCashierShift()` - Close shift
- ✅ `getCashierShiftRecDetails($id)` - Get shift details
- ✅ `updateShiftOpeningBalances()` - Update opening balances
- ✅ `approveShiftOpeningBalances()` - Approve opening balances
- ✅ `verifyClosingBalance()` - Verify closing balance
- ✅ `updateClosingBalance()` - Update closing balance
- ✅ `getAllCashierLog()` - Get all shift logs

### Handover Controller
- ✅ `index()` - Handover list view
- ✅ `getHandoverLogs()` - Get handover logs (AJAX)
- ✅ `updateHandoverAmount()` - Update handover amount
- ✅ `verifyHandover()` - Verify handover
- ✅ `generateVoucher($id)` - Generate voucher PDF

### Summary Controller
- ✅ `index()` - Summary list view
- ✅ `getShiftSummaries()` - Get summaries (AJAX)
- ✅ `getSummaryById($id)` - Get single summary

### TransactionLedger Controller
- ✅ `index()` - Transaction ledger view
- ✅ `getTransactionLedgers()` - Get all transactions
- ✅ `getByShift($shiftId)` - Get by shift
- ✅ `getReversals()` - Get reversals
- ✅ `getTransactionById($id)` - Get single transaction

### CashMovement Controller
- ✅ `index()` - Cash movements view
- ✅ `getCashMovements()` - Get all movements
- ✅ `createCashMovement()` - Create movement
- ✅ `approveCashMovement($id)` - Approve movement
- ✅ `getCashMovementById($id)` - Get single movement
- ✅ `deleteCashMovement($id)` - Delete movement

### IouSettlement Controller
- ✅ `index()` - IOU settlements view
- ✅ `getSettlements()` - Get all settlements
- ✅ `getOutstandingIous()` - Get outstanding IOUs
- ✅ `createSettlement()` - Create settlement
- ✅ `updateSettlement($id)` - Update settlement
- ✅ `deleteSettlement($id)` - Delete settlement
- ✅ `getSettlementById($id)` - Get single settlement

### Adjustment Controller
- ✅ `index()` - Adjustments view
- ✅ `create()` - Create adjustment
- ✅ `update($id)` - Update adjustment
- ✅ `delete($id)` - Delete adjustment

### Auth Controller
- ✅ `authorize()` - Authorize as cashier
- ✅ `checkSession()` - Check cashier session
- ✅ `logout()` - Logout cashier

### Report Controller
- ✅ `dailySummary()` - Daily summary report view
- ✅ `paymentSummary()` - Payment summary report view
- ✅ `discrepancy()` - Discrepancy report view
- ✅ `cashOutSummary()` - Cash out summary report view
- ✅ `outstandingIous()` - Outstanding IOUs report view

---

All controllers and models are now organized in the `Cashier/` folder structure and ready for use!

