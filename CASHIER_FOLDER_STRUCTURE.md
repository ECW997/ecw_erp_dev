# Cashier Module - New Folder Structure

## Backend (Laravel API)

### Controllers
Located in: `app/Http/Controllers/v1/Cashier/`

- ✅ `ShiftController.php` - Shift management (start, close, verify, approve)
- ✅ `HandoverController.php` - Cash handover management
- ✅ `ShiftSummaryController.php` - Shift summaries
- ✅ `TransactionLedgerController.php` - Transaction ledger
- ✅ `CashMovementController.php` - Cash movements (in/out)
- ✅ `ShiftAdjustmentController.php` - Shift adjustments

### Models
Located in: `app/Models/Cashier/`

- ✅ `Shift.php` - Cashier shift model
- ✅ `HandOverLogs.php` - Cash handover logs model
- ✅ `ShiftSummary.php` - Shift summary model
- ✅ `ShiftAdjustment.php` - Shift adjustment model
- ✅ `CashMovement.php` - Cash movement model
- ✅ `TransactionLedger.php` - Transaction ledger model

### Routes
File: `routes/api.php`

**New Routes (Recommended):**
```php
Route::prefix('cashier')->group(function () {
    Route::apiResource('shift', CashierShiftController::class);
    Route::get('/shift/get_all_cashier_log', [CashierShiftController::class, 'get_all_cashier_log']);
    Route::put('/shift/{id}/update_opening_balance', [CashierShiftController::class, 'update_shift_opening_balance']);
    Route::put('/shift/{id}/approve_opening_balance', [CashierShiftController::class, 'approve_shift_opening_balance']);
    Route::put('/shift/{id}/verify_closing_balance', [CashierShiftController::class, 'verify_closing_balance']);
    Route::put('/shift/{id}/update_closing_balance', [CashierShiftController::class, 'update_closing_balance']);
    
    Route::apiResource('handover', CashierHandoverController::class);
    Route::put('/handover/{id}/verify', [CashierHandoverController::class, 'verify_handover']);
    
    Route::apiResource('shift_summary', CashierShiftSummaryController::class);
    Route::apiResource('transaction_ledger', CashierTransactionLedgerController::class);
    Route::get('/transaction_ledger/by_shift/{shiftId}', [CashierTransactionLedgerController::class, 'getByShift']);
    Route::get('/transaction_ledger/reversals', [CashierTransactionLedgerController::class, 'getReversals']);
    
    Route::apiResource('cash_movement', CashierCashMovementController::class);
    Route::apiResource('shift_adjustment', CashierShiftAdjustmentController::class);
});
```

**Legacy Routes (Backward Compatibility):**
- Old routes still work but use new controllers
- `cashier_shift_v1` → Uses new `Cashier\ShiftController`
- `cashier_handover_v1` → Uses new `Cashier\HandoverController`
- etc.

---

## Frontend (CodeIgniter 3)

### Controllers
Located in: `application/controllers/Cashier/`

- ✅ `Shift.php` - Shift management controller
- ✅ `Adjustment.php` - Adjustment controller

**To Create:**
- `Handover.php` - Handover controller
- `CashMovement.php` - Cash movement controller
- `TransactionLedger.php` - Transaction ledger controller
- `Summary.php` - Summary controller

### Models
Located in: `application/models/Cashier/`

- ✅ `Shiftinfo.php` - Shift API model
- ✅ `Adjustmentinfo.php` - Adjustment API model
- ✅ `CashMovementinfo.php` - Cash movement API model

**To Create:**
- `Handoverinfo.php` - Handover API model
- `TransactionLedgerinfo.php` - Transaction ledger API model
- `Summaryinfo.php` - Summary API model

---

## API Endpoint Mapping

### New Structure (Recommended)
| Feature | Endpoint |
|---------|----------|
| Check Shift | `GET /api/v1/cashier/shift` |
| Start Shift | `POST /api/v1/cashier/shift` |
| Close Shift | `PUT /api/v1/cashier/shift/{id}` |
| Update Opening Balance | `PUT /api/v1/cashier/shift/{id}/update_opening_balance` |
| Approve Opening Balance | `PUT /api/v1/cashier/shift/{id}/approve_opening_balance` |
| Verify Closing Balance | `PUT /api/v1/cashier/shift/{id}/verify_closing_balance` |
| Update Closing Balance | `PUT /api/v1/cashier/shift/{id}/update_closing_balance` |
| Get All Logs | `GET /api/v1/cashier/shift/get_all_cashier_log` |
| Handover List | `GET /api/v1/cashier/handover` |
| Verify Handover | `PUT /api/v1/cashier/handover/{id}/verify` |
| Adjustments | `GET/POST/PUT/DELETE /api/v1/cashier/shift_adjustment` |
| Cash Movements | `GET/POST/PUT/DELETE /api/v1/cashier/cash_movement` |
| Transaction Ledger | `GET /api/v1/cashier/transaction_ledger` |
| Transaction by Shift | `GET /api/v1/cashier/transaction_ledger/by_shift/{shiftId}` |

### Legacy Endpoints (Still Work)
| Feature | Endpoint |
|---------|----------|
| Check Shift | `GET /api/v1/cashier_shift_v1` |
| Start Shift | `POST /api/v1/cashier_shift_v1` |
| Close Shift | `PUT /api/v1/cashier_shift_v1/{id}` |

---

## Namespace Changes

### Backend Controllers
**Old:**
```php
namespace App\Http\Controllers\v1;
use App\Models\CashierShift;
```

**New:**
```php
namespace App\Http\Controllers\v1\Cashier;
use App\Models\Cashier\Shift;
```

### Backend Models
**Old:**
```php
namespace App\Models;
class CashierShift extends Model
```

**New:**
```php
namespace App\Models\Cashier;
class Shift extends Model
```

---

## Migration Guide

### For Backend API Calls
1. Update imports to use new namespace
2. Update model references (e.g., `CashierShift` → `Shift`)
3. Use new route prefixes if desired, or keep legacy routes

### For Frontend (CodeIgniter)
1. Update model paths: `$this->load->model('Cashier/Shiftinfo')`
2. Update controller paths: `application/controllers/Cashier/Shift.php`
3. Update API endpoint calls in models to use new endpoints

---

## Next Steps

1. ✅ Backend controllers created in `Cashier/` folder
2. ✅ Backend models created in `Cashier/` folder
3. ✅ Routes updated with new structure
4. ✅ Frontend controllers started in `Cashier/` folder
5. ✅ Frontend models started in `Cashier/` folder

**Remaining:**
- Complete remaining frontend controllers
- Complete remaining frontend models
- Update existing views to use new controller paths
- Test all endpoints
- Update any hardcoded API endpoints in frontend JavaScript

---

## File Structure Summary

```
Backend (Laravel):
api.ecw.lk/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── v1/
│   │           └── Cashier/
│   │               ├── ShiftController.php
│   │               ├── HandoverController.php
│   │               ├── ShiftSummaryController.php
│   │               ├── TransactionLedgerController.php
│   │               ├── CashMovementController.php
│   │               └── ShiftAdjustmentController.php
│   └── Models/
│       └── Cashier/
│           ├── Shift.php
│           ├── HandOverLogs.php
│           ├── ShiftSummary.php
│           ├── ShiftAdjustment.php
│           ├── CashMovement.php
│           └── TransactionLedger.php
└── routes/
    └── api.php

Frontend (CodeIgniter):
ecw_erp_dev/
├── application/
│   ├── controllers/
│   │   └── Cashier/
│   │       ├── Shift.php
│   │       └── Adjustment.php
│   └── models/
│       └── Cashier/
│           ├── Shiftinfo.php
│           ├── Adjustmentinfo.php
│           └── CashMovementinfo.php
```

