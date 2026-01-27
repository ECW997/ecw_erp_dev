# Cashier Module Development Plan

## Current Implementation Status

### ✅ Completed Features

#### Database Structure
- ✅ `cashier_shifts` table and model
- ✅ `cash_handover_logs` table and model  
- ✅ `cashier_shift_summaries` table and model
- ✅ `cashier_shift_adjustments` table and model
- ✅ `cashier_transaction_ledger` table and model
- ✅ `cashier_cash_movements` table and model
- ⚠️ `iou_settlements` table - **MODEL NEEDS VERIFICATION**

#### API Endpoints (Backend - Laravel)
- ✅ `GET /cashier_shift_v1` - Check active shift
- ✅ `POST /cashier_shift_v1` - Start shift
- ✅ `PUT /cashier_shift_v1/{id}` - Close shift
- ✅ `GET /cashier_shift_v1/{id}` - Get shift details
- ✅ `PUT /update_shift_opening_balance_v1/{id}` - Edit opening balance
- ✅ `PUT /approve_shift_opening_balance_v1/{id}` - Approve opening balance
- ✅ `GET /get_all_cashier_log` - Get all shift logs
- ✅ `GET /cashier_handover_v1` - Get handover logs
- ✅ `PUT /cashier_handover_v1/{id}` - Update handover amount
- ✅ `GET /cashier_shift_summary_v1` - Get shift summaries
- ✅ `GET /cashier_shift_transaction_ledger_v1` - Transaction ledger endpoint exists
- ⚠️ `cashier_cash_movements_v1` - Controller exists but incomplete
- ⚠️ `cashier_shift_adjustments_v1` - **ENDPOINT MISSING**

#### Frontend (CodeIgniter)
- ✅ Cashier Shift Management View (`cashier_shift.php`)
- ✅ Start Shift Modal
- ✅ Close Shift Modal
- ✅ Shift Dashboard/Details View
- ✅ Cash Handover View (`cashier_handover.php`)
- ✅ Shift Summary View (`cashier_shift_summary.php`)
- ✅ Transaction Ledger View (`cashier_transaction_ledger.php`)
- ✅ Cash Movements View (`cashier_cash_movements.php`)
- ✅ Finance/Accounts View for Approvals
- ⚠️ IOU Settlements View exists but incomplete
- ⚠️ Adjustments View exists but incomplete

---

## ❌ Missing/Incomplete Features

### Phase 1: Core Shift Management (HIGH PRIORITY)

#### 1.1 Closing Balance Verification
**Status:** ❌ **MISSING**

**Required:**
- [ ] API Endpoint: `PUT /verify_shift_closing_balance_v1/{id}`
  - Verify closing balance by Accounts Department
  - Update `closing_verified_by`, `closing_verified_at`
  - Update shift status to 'verified'
  - Link to: `CashierShiftController@verify_closing_balance`
  
**Backend:**
- File: `api.ecw.lk/app/Http/Controllers/v1/CashierShiftController.php`
- Add method: `verify_closing_balance(Request $request, string $id)`
- Validation: Check shift is 'closed', not already verified
- Update shift status and verification fields

**Frontend:**
- File: `ecw_erp_dev/application/views/finance.php` or new view
- Add "Verify Closing Balance" button for Accounts users
- Show verification status in shift details

**Route:**
```php
Route::put('/verify_shift_closing_balance_v1/{id}', [CashierShiftController::class, 'verify_closing_balance'])
```

---

#### 1.2 Edit Closing Balance (Authorized Personnel)
**Status:** ❌ **MISSING**

**Required:**
- [ ] API Endpoint: `PUT /update_shift_closing_balance_v1/{id}`
  - Allow Accounts to edit closing balance after shift closed
  - Update closing_balance_cash, closing_balance_slips, closing_balance_cheques
  - Add remarks/log for audit trail
  - Only if status is 'closed' and not 'verified'
  
**Backend:**
- File: `api.ecw.lk/app/Http/Controllers/v1/CashierShiftController.php`
- Add method: `update_closing_balance(Request $request, string $id)`
- Validate permissions (Accounts role)
- Log changes for audit

**Frontend:**
- Add edit form in Finance view
- Show current values, allow editing
- Require reason/remarks for changes

**Route:**
```php
Route::put('/update_shift_closing_balance_v1/{id}', [CashierShiftController::class, 'update_closing_balance'])
```

---

#### 1.3 Cash Handover Verification
**Status:** ⚠️ **PARTIAL** - Update endpoint exists, verification endpoint missing

**Required:**
- [ ] API Endpoint: `PUT /verify_cash_handover_v1/{id}`
  - Verify cash handover by Accounts
  - Update `verified_by`, `verified_at`, `status` in `cash_handover_logs`
  - Calculate difference if any
  - Update shift status if all conditions met
  
**Backend:**
- File: `api.ecw.lk/app/Http/Controllers/v1/CashierHandoverController.php`
- Add method: `verify_handover(Request $request, string $id)`
- Calculate: `difference = actual_cash - declared_cash`
- If difference exists, may require adjustment entry

**Frontend:**
- Add verification button in handover view
- Show verified status
- Display difference if any

**Route:**
```php
Route::put('/verify_cash_handover_v1/{id}', [CashierHandoverController::class, 'verify_handover'])
```

---

### Phase 2: Shift Adjustments (HIGH PRIORITY)

#### 2.1 Create Shift Adjustment
**Status:** ❌ **MISSING**

**Required:**
- [ ] API Endpoint: `POST /cashier_shift_adjustments_v1`
  - Create adjustment record
  - Types: 'invoice_void', 'correction', 'manual'
  - Amount and remarks required
  - Link to shift ID
  
**Backend:**
- File: `api.ecw.lk/app/Http/Controllers/v1/CashierShiftAdjustmentController.php` - **CREATE FILE**
- Model: `CashierShiftAdjustment` exists
- Validation: shift exists, amount valid, type valid
- Add created_by automatically

**Frontend:**
- File: `ecw_erp_dev/application/controllers/CashierAdjustments.php` - exists but incomplete
- File: `ecw_erp_dev/application/views/cashier_adjustments/` - **CREATE VIEW**
- Form for adjustment entry
- List existing adjustments per shift

**Route:**
```php
Route::apiResource('cashier_shift_adjustments', CashierShiftAdjustmentController::class);
```

**Controller Structure:**
```php
class CashierShiftAdjustmentController extends Controller
{
    public function index() // List adjustments for shift
    public function store(Request $request) // Create adjustment
    public function show(string $id) // Get single adjustment
    public function destroy(string $id) // Delete adjustment (with restrictions)
}
```

---

#### 2.2 Adjustment Integration with Shift Close
**Status:** ❌ **MISSING**

**Required:**
- [ ] When closing shift, check for adjustments
- [ ] Include adjustments in shift summary calculations
- [ ] Show adjustments in shift close modal
- [ ] Allow adjustment entry during/after shift close if mismatch found

**Implementation:**
- Modify `CashierShiftController@update` (close shift method)
- Query adjustments for shift
- Include in calculations

---

### Phase 3: Transaction Ledger (MEDIUM PRIORITY)

#### 3.1 Transaction Ledger Auto-Recording
**Status:** ⚠️ **MODEL EXISTS, AUTO-RECORDING MISSING**

**Required:**
- [ ] Auto-record transactions when:
  - Invoice created → `transaction_type='invoice_payment'`, `doc_type='inv'`, `doc_id=invoice_id`
  - Receipt created/approved → Link to `receipt_id`
  - Payment collected → Record payment method, amount, received_at
  - Invoice/Receipt cancelled → Create reverse record (not delete/update)

**Backend:**
- File: `api.ecw.lk/app/Http/Controllers/v1/InvoiceController.php`
  - After invoice creation, record in ledger
- File: `api.ecw.lk/app/Http/Controllers/v1/PaymentController.php`
  - After payment approval, record in ledger
  - On payment cancellation, create reverse entry

**Helper:**
- File: `api.ecw.lk/app/Helpers/CashierHelper.php` - exists
- Add method: `recordTransaction($shiftId, $docType, $docId, $receiptId, $transactionType, $paymentMethod, $amount, $recordedBy)`
- Add method: `reverseTransaction($originalTransactionId, $reason)`

**Frontend:**
- Display ledger entries in Transaction Ledger view
- Filter by shift, date, type

---

#### 3.2 Transaction Ledger API Endpoints
**Status:** ⚠️ **PARTIAL**

**Required:**
- [ ] Complete `CashierTransactionLedgerController`
  - `index()` - List transactions with filters (shift_id, date range, type)
  - `show($id)` - Get single transaction
  - `getByShift($shiftId)` - Get all transactions for shift
  - `getReversals()` - Get all reversal transactions

**Backend:**
- File: `api.ecw.lk/app/Http/Controllers/v1/CashierTransactionLedgerController.php` - exists but incomplete

**Frontend:**
- File: `ecw_erp_dev/application/views/cashier_transaction_ledger.php` - exists
- Connect to API, display data with filters

---

### Phase 4: Cash Movements (MEDIUM PRIORITY)

#### 4.1 Cash Movements CRUD
**Status:** ⚠️ **CONTROLLER EXISTS BUT INCOMPLETE**

**Required:**
- [ ] Complete `CashierCashMovementsController`
  - `index()` - List movements (DONE)
  - `store()` - Create movement (DONE but verify)
  - `update()` - Approve cash out (DONE)
  - `show($id)` - Get single movement
  - Add validation for:
    - Only 1 active shift allowed per branch (unless multi-cashier)
    - Cash outs require approval before counted
    - IOUs cannot be deleted

**Backend:**
- File: `api.ecw.lk/app/Http/Controllers/v1/CashierCashMovementsController.php`
- Fix namespace (should be `App\Http\Controllers\v1`, not `App\Http\Controllers`)
- Add proper authorization checks
- Implement IOU restriction logic

**Frontend:**
- File: `ecw_erp_dev/application/views/cashier_cash_movements.php` - exists
- Complete CRUD forms
- Add approval workflow UI

**Routes:**
- Already in routes, verify working

---

#### 4.2 Cash Movements Integration
**Status:** ❌ **MISSING**

**Required:**
- [ ] Cash movements affect shift balance calculations
- [ ] Cash outs reduce available cash
- [ ] Cash ins increase available cash
- [ ] Unapproved cash outs block shift verification

**Implementation:**
- Modify shift close logic to check for unapproved cash outs
- Include cash movements in shift summary calculations
- Show cash movement summary in shift dashboard

---

### Phase 5: IOU Settlements (MEDIUM PRIORITY)

#### 5.1 IOU Settlements API
**Status:** ❌ **MISSING**

**Required:**
- [ ] API Endpoint: `POST /iou_settlements_v1`
  - Create settlement record
  - Types: 'cash_return', 'expense_claim', 'payroll_deduction'
  - Link to `cash_movement_id` (source='iou')
  - Only Accounts can create (not cashier)
  
**Backend:**
- File: `api.ecw.lk/app/Models/IouSettlement.php` - **CREATE IF MISSING**
- File: `api.ecw.lk/app/Http/Controllers/v1/IouSettlementController.php` - **CREATE**
- Validation:
  - Cash movement exists and is IOU type
  - Settlement amount cannot exceed IOU amount
  - Only accounts role can create

**Frontend:**
- File: `ecw_erp_dev/application/views/cashier_iou_settlements.php` - **CREATE OR COMPLETE**
- List pending IOUs
- Create settlement form
- Link to expense claim/payroll if applicable

**Route:**
```php
Route::apiResource('iou_settlements', IouSettlementController::class);
```

---

#### 5.2 IOU Settlement Reports
**Status:** ❌ **MISSING**

**Required:**
- [ ] Outstanding IOUs Report
  - List all IOUs not fully settled
  - Group by cashier, shift
  - Show settlement status

**Implementation:**
- Add report endpoint
- Create report view

---

### Phase 6: Cashier Authorization/Session (HIGH PRIORITY)

#### 6.1 Separate Cashier Login/Session
**Status:** ❌ **MISSING**

**Required:**
- [ ] Cashier authorization separate from ERP system login
- [ ] User must login to ERP first (for reports viewing)
- [ ] Then authorize as Cashier (for invoice/receipt creation)
- [ ] Store cashier session separate from system session

**Backend:**
- Consider adding `cashier_session` table:
  ```sql
  CREATE TABLE cashier_sessions (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT,
      shift_id INT,
      authorized_at DATETIME,
      last_activity DATETIME,
      status ENUM('active', 'logged_out') DEFAULT 'active'
  );
  ```
- Or use existing session but add cashier authorization flag

**Frontend:**
- Show "Authorize as Cashier" button when navigating to Invoice/Receipt
- Modal for cashier authorization
- Store cashier session in session storage
- Show "Cashier: [Name]" in top bar when authorized

**Implementation:**
- File: `ecw_erp_dev/application/controllers/Invoice.php`
  - Check for cashier authorization before allowing invoice creation
  - Show authorization modal if not authorized
- File: `ecw_erp_dev/application/controllers/Payment.php`
  - Same check for receipts

---

#### 6.2 Cashier Logout (with Balance Entry)
**Status:** ❌ **MISSING**

**Required:**
- [ ] Cashier logout button (separate from system logout)
- [ ] On logout, show current shift balance
- [ ] Allow entering closing balance if shift still open
- [ ] Logout cashier session, keep ERP session active

**Frontend:**
- Add "Logout Cashier" button in top bar
- Modal showing shift status and balance
- Option to close shift before logout (if open)
- Or just logout and leave shift open

**Backend:**
- Endpoint: `POST /cashier_logout_v1`
- Clear cashier authorization
- Optional: Close shift if requested

---

#### 6.3 Cashier Authorization Check
**Status:** ⚠️ **PARTIAL** - Check exists in Invoice controller but no separate auth

**Required:**
- [ ] Middleware or helper to check cashier authorization
- [ ] Redirect to authorization if not authorized
- [ ] Check active shift exists
- [ ] Check opening balance approved

**Implementation:**
- Helper function: `check_cashier_authorized()`
- Check: Active shift exists, opening approved, user authorized as cashier

---

### Phase 7: Reports (MEDIUM PRIORITY)

#### 7.1 Daily Cashier Summary Report
**Status:** ⚠️ **PARTIAL** - Shift summary exists, daily aggregation missing

**Required:**
- [ ] Report endpoint: `GET /reports/cashier/daily_summary`
  - Parameters: date, branch_id (optional)
  - Aggregate all shifts for date
  - Total sales, payments by method, adjustments
  
**Backend:**
- File: `api.ecw.lk/app/Http/Controllers/v1/Reports/CashierReportController.php` - **CREATE**
- Aggregate shift summaries by date
- Include adjustments, cash movements

**Frontend:**
- File: `ecw_erp_dev/application/views/reports/cashier_daily_summary.php` - **CREATE**
- Date picker
- Display summary table
- Export to PDF/Excel

---

#### 7.2 Payment Summary by Method Report
**Status:** ❌ **MISSING**

**Required:**
- [ ] Report endpoint: `GET /reports/cashier/payment_summary`
  - Parameters: date range, branch_id
  - Breakdown by payment method (Cash, Card, Cheque, Online, Other)
  - Per shift and total
  
**Backend:**
- Add to `CashierReportController`
- Query transaction ledger and shift summaries

**Frontend:**
- Create report view
- Charts/graphs optional

---

#### 7.3 Shift Discrepancy Report
**Status:** ❌ **MISSING**

**Required:**
- [ ] Report endpoint: `GET /reports/cashier/discrepancy`
  - Compare: System-calculated cash vs Actual cash declared
  - Highlight mismatches
  - Show adjustments made
  
**Backend:**
- Calculate expected cash from transaction ledger
- Compare with actual closing balance
- Show difference and adjustments

**Frontend:**
- Create report view
- Highlight discrepancies in red
- Show adjustment details

---

#### 7.4 Cash Out Summary by Shift Report
**Status:** ❌ **MISSING**

**Required:**
- [ ] Report endpoint: `GET /reports/cashier/cash_out_summary`
  - All cash out movements per shift
  - Group by source (IOU, Petty, Supplier, etc.)
  - Approval status
  
**Backend:**
- Query cash movements where movement_type='cash_out'
- Group by shift and source

**Frontend:**
- Create report view

---

#### 7.5 Outstanding IOUs Report
**Status:** ❌ **MISSING**

**Required:**
- [ ] Report endpoint: `GET /reports/cashier/outstanding_ious`
  - List all IOUs not fully settled
  - Show amount, date, cashier, settlement status
  - Link to settlement records
  
**Backend:**
- Query cash movements where source='iou'
- Check settlement status
- Calculate remaining balance

**Frontend:**
- Create report view
- Export functionality

---

### Phase 8: Business Logic & Validation (HIGH PRIORITY)

#### 8.1 Shift Constraints
**Status:** ⚠️ **PARTIAL**

**Required:**
- [ ] Only 1 active shift per branch (unless multi-cashier enabled)
  - ✅ Already implemented in check shift logic
- [ ] Shift cannot be closed if pending invoices exist
  - ❌ **MISSING** - Need to check for unconfirmed invoices in shift
- [ ] No new shift until last shift verified
  - ⚠️ **PARTIAL** - Check exists but may need refinement

**Implementation:**
- In `closeCashierShift` method:
  ```php
  // Check for pending invoices
  $pendingInvoices = DB::table('inv_header')
      ->where('cashier_shift_id', $shiftId)
      ->where('is_confirmed', 0)
      ->exists();
  
  if ($pendingInvoices) {
      return error('Cannot close shift. Pending invoices exist.');
  }
  ```

---

#### 8.2 Cash Handover Voucher Printing
**Status:** ❌ **MISSING**

**Required:**
- [ ] Print voucher when cash handed over
  - Show shift details
  - Opening/closing balances
  - Total collections
  - Cashier signature
  - Accounts signature (after verification)
  
**Backend:**
- Endpoint: `GET /cashier_handover_v1/{id}/voucher_pdf`
- Generate PDF using existing PDF library

**Frontend:**
- Print button in handover view
- PDF opens in new window

---

#### 8.3 Reverse Transaction Recording
**Status:** ❌ **MISSING**

**Required:**
- [ ] When invoice/receipt cancelled:
  - Create reverse entry in transaction ledger
  - Do NOT delete original entry
  - Link reversal to original transaction
  - Record reason
  
**Implementation:**
- In Invoice/Payment cancellation methods:
  - Find original ledger entry
  - Create new entry with negative amount or reversal flag
  - Link via `reversed_transaction_id` or similar

---

### Phase 9: UI Enhancements (LOW PRIORITY)

#### 9.1 Cashier Name Display
**Status:** ⚠️ **PARTIAL**

**Required:**
- [ ] Show cashier name in top bar when authorized
- [ ] Show "Logout Cashier" button
- [ ] Differentiate from system logout

**Frontend:**
- Modify top navbar
- Add cashier session indicator

---

#### 9.2 Shift Dashboard Enhancements
**Status:** ⚠️ **EXISTS BUT INCOMPLETE**

**Required:**
- [ ] Real-time balance updates
- [ ] Show pending approvals
- [ ] Show cash movements summary
- [ ] Quick actions (add adjustment, add cash movement)

**Frontend:**
- Enhance `cashier_shift_dashboard.php` or `cashier_shift_dashboard_v2.php`
- Add AJAX polling for updates
- Add quick action buttons

---

## Implementation Priority

### 🔴 Critical (Must Have)
1. Closing Balance Verification API
2. Edit Closing Balance API
3. Cash Handover Verification API
4. Shift Adjustment CRUD API
5. Cashier Authorization/Session Management
6. Shift Constraints Validation

### 🟡 High Priority
7. Transaction Ledger Auto-Recording
8. Cash Movements Completion
9. Cashier Logout with Balance
10. IOU Settlements API

### 🟢 Medium Priority
11. Reports (All 5 reports)
12. Voucher Printing
13. Reverse Transaction Recording

### 🔵 Low Priority
14. UI Enhancements
15. Dashboard Improvements

---

## Database Migrations Needed

### Verify/Create Missing Tables

1. **iou_settlements** table
   ```sql
   CREATE TABLE IF NOT EXISTS iou_settlements (
       id INT AUTO_INCREMENT PRIMARY KEY,
       cash_movement_id INT NOT NULL,
       settlement_type ENUM('cash_return','expense_claim','payroll_deduction') NOT NULL,
       settlement_amount DECIMAL(12,2) NOT NULL,
       settlement_date DATETIME NOT NULL,
       reference_id INT NULL,
       remarks TEXT NULL,
       settled_by INT NOT NULL,
       created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
       status_upd TINYINT(1) DEFAULT 0,
       status_upd_at DATETIME NULL
   );
   ```

2. **cashier_sessions** (optional, for separate cashier auth)
   ```sql
   CREATE TABLE IF NOT EXISTS cashier_sessions (
       id INT AUTO_INCREMENT PRIMARY KEY,
       user_id INT NOT NULL,
       shift_id INT NULL,
       authorized_at DATETIME NOT NULL,
       last_activity DATETIME NOT NULL,
       status ENUM('active', 'logged_out') DEFAULT 'active',
       created_at DATETIME DEFAULT CURRENT_TIMESTAMP
   );
   ```

3. **transaction_ledger_reversals** (optional, for reversal tracking)
   ```sql
   ALTER TABLE cashier_transaction_ledger 
   ADD COLUMN reversed_transaction_id INT NULL,
   ADD COLUMN reversal_reason TEXT NULL,
   ADD COLUMN is_reversal TINYINT(1) DEFAULT 0;
   ```

---

## API Routes to Add

```php
// In routes/api.php, inside v1 group

// Shift Management
Route::put('/verify_shift_closing_balance_v1/{id}', [CashierShiftController::class, 'verify_closing_balance']);
Route::put('/update_shift_closing_balance_v1/{id}', [CashierShiftController::class, 'update_closing_balance']);

// Cash Handover
Route::put('/verify_cash_handover_v1/{id}', [CashierHandoverController::class, 'verify_handover']);
Route::get('/cashier_handover_v1/{id}/voucher_pdf', [CashierHandoverController::class, 'generate_voucher']);

// Adjustments
Route::apiResource('cashier_shift_adjustments', CashierShiftAdjustmentController::class);

// Cash Movements (verify existing routes work)
Route::apiResource('cashier_cash_movements', CashierCashMovementsController::class);

// IOU Settlements
Route::apiResource('iou_settlements', IouSettlementController::class);

// Transaction Ledger
Route::get('/cashier_transaction_ledger_v1/by_shift/{shiftId}', [CashierTransactionLedgerController::class, 'getByShift']);
Route::get('/cashier_transaction_ledger_v1/reversals', [CashierTransactionLedgerController::class, 'getReversals']);

// Reports
Route::prefix('reports/cashier')->group(function () {
    Route::get('/daily_summary', [CashierReportController::class, 'dailySummary']);
    Route::get('/payment_summary', [CashierReportController::class, 'paymentSummary']);
    Route::get('/discrepancy', [CashierReportController::class, 'discrepancy']);
    Route::get('/cash_out_summary', [CashierReportController::class, 'cashOutSummary']);
    Route::get('/outstanding_ious', [CashierReportController::class, 'outstandingIous']);
});

// Cashier Auth
Route::post('/cashier_authorize_v1', [CashierAuthController::class, 'authorize']);
Route::post('/cashier_logout_v1', [CashierAuthController::class, 'logout']);
Route::get('/cashier_session_v1', [CashierAuthController::class, 'checkSession']);
```

---

## Testing Checklist

### Shift Management
- [ ] Start shift with opening balances
- [ ] Edit opening balance (authorized user)
- [ ] Approve opening balance
- [ ] Close shift with closing balances
- [ ] Edit closing balance (authorized user)
- [ ] Verify closing balance
- [ ] Cannot close shift with pending invoices
- [ ] Cannot start new shift if previous not verified

### Adjustments
- [ ] Create adjustment for shift
- [ ] View adjustments list
- [ ] Adjustment included in shift calculations

### Cash Movements
- [ ] Create cash in movement
- [ ] Create cash out movement
- [ ] Approve cash out (accounts)
- [ ] Cannot delete IOU movement
- [ ] Cash movements affect shift balance

### Transaction Ledger
- [ ] Auto-record on invoice creation
- [ ] Auto-record on payment approval
- [ ] Create reversal on cancellation
- [ ] View ledger by shift

### Handover
- [ ] Update handover amount
- [ ] Verify handover
- [ ] Print voucher

### Reports
- [ ] Daily summary report
- [ ] Payment summary report
- [ ] Discrepancy report
- [ ] Cash out summary report
- [ ] Outstanding IOUs report

---

## Notes

1. **Do not modify other modules** - Only work on cashier-related files
2. **Maintain existing API structure** - Follow existing patterns
3. **Use existing helper functions** - Leverage `CashierHelper` where possible
4. **Follow naming conventions** - Use existing route naming patterns
5. **Add proper validation** - All inputs should be validated
6. **Add error handling** - Proper error responses
7. **Add logging** - Log important actions for audit
8. **Test thoroughly** - Test each feature before moving to next

---

## Files to Create/Modify

### Backend (Laravel API)

**New Controllers:**
- `app/Http/Controllers/v1/CashierShiftAdjustmentController.php`
- `app/Http/Controllers/v1/IouSettlementController.php`
- `app/Http/Controllers/v1/CashierAuthController.php`
- `app/Http/Controllers/v1/Reports/CashierReportController.php`

**Modify Existing:**
- `app/Http/Controllers/v1/CashierShiftController.php` - Add verify/update closing balance
- `app/Http/Controllers/v1/CashierHandoverController.php` - Add verify endpoint
- `app/Http/Controllers/v1/CashierCashMovementsController.php` - Fix namespace, complete methods
- `app/Http/Controllers/v1/CashierTransactionLedgerController.php` - Complete implementation
- `app/Http/Controllers/v1/InvoiceController.php` - Add ledger recording
- `app/Http/Controllers/v1/PaymentController.php` - Add ledger recording, reversals

**New Models (if missing):**
- `app/Models/IouSettlement.php`
- `app/Models/CashierSession.php` (optional)

**Modify Existing:**
- `app/Models/CashierTransactionLedger.php` - Add reversal fields if needed

**Helpers:**
- `app/Helpers/CashierHelper.php` - Add transaction recording methods

### Frontend (CodeIgniter)

**New Views:**
- `application/views/cashier_adjustments/index.php`
- `application/views/reports/cashier_daily_summary.php`
- `application/views/reports/cashier_payment_summary.php`
- `application/views/reports/cashier_discrepancy.php`
- `application/views/reports/cashier_cash_out_summary.php`
- `application/views/reports/cashier_outstanding_ious.php`

**Modify Existing:**
- `application/views/cashier_shift.php` - Enhance UI
- `application/views/cashier_handover.php` - Add verification
- `application/views/finance.php` - Add closing balance verification
- `application/views/include/topnavbar.php` - Add cashier session indicator
- `application/controllers/Invoice.php` - Add cashier auth check
- `application/controllers/Payment.php` - Add cashier auth check

**New Controllers:**
- `application/controllers/CashierAuth.php` (optional, for frontend auth handling)
- `application/controllers/Reports/CashierReports.php`

**New Models:**
- `application/models/CashierAdjustmentsinfo.php` (if needed)
- `application/models/CashierReportinfo.php`

---

## Estimated Timeline

- **Phase 1 (Core Shift Management):** 3-4 days
- **Phase 2 (Adjustments):** 2-3 days
- **Phase 3 (Transaction Ledger):** 3-4 days
- **Phase 4 (Cash Movements):** 2-3 days
- **Phase 5 (IOU Settlements):** 2-3 days
- **Phase 6 (Cashier Auth):** 2-3 days
- **Phase 7 (Reports):** 4-5 days
- **Phase 8 (Business Logic):** 2-3 days
- **Phase 9 (UI Enhancements):** 2-3 days

**Total Estimated Time: 22-31 days**

---

## Next Steps

1. Review this plan with stakeholders
2. Prioritize phases based on business needs
3. Start with Phase 1 (Critical items)
4. Test each phase before moving to next
5. Document any deviations from plan
6. Update plan as development progresses

