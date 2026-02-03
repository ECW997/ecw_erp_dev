# Admin Portal Module - Implementation Summary

## What Was Created

### 1. Frontend (CodeIgniter) Files

#### Controller
- **`application/controllers/AdminPortal.php`**
  - Main controller with admin access checks
  - Methods: index, emergencyActionForm, getSalesOrderDetails, executeEmergencyAction, getEmergencyActionLogs, viewLog
  - Admin user type check in constructor
  - Branch verification before actions

#### Model
- **`application/models/AdminPortalinfo.php`**
  - Model for API communication
  - Methods for getting sales order details, executing actions, and retrieving logs

#### Views
- **`application/views/AdminPortal/index.php`**
  - Main portal page with logs list
  - DataTable with filtering capabilities
  - Shows all emergency action logs

- **`application/views/AdminPortal/emergency_action_form.php`**
  - Emergency action form
  - Sales order relation verification
  - Shows linked records before cancellation
  - Confirmation checkbox and reason field

- **`application/views/AdminPortal/view_log.php`**
  - Detailed log view
  - Shows complete action details and results

### 2. Backend (Laravel API) Files

#### Controller
- **`app/Http/Controllers/v1/AdminPortalController.php`**
  - Complete emergency action implementation
  - Cancels sales order relation and all linked records:
    - Sales Order Header & Details
    - Exclude Sales Order Header & Details
    - Invoices & Invoice Details
    - Exclude Invoices & Exclude Invoice Details
    - Payments, Payment Details & Payment Allocations
    - Temp Payments (temp_pay_header, temp_pay_details, temp_pay_allocation) - linked to exclude invoices or jobcard advance payments
  - Transaction-safe operations
  - Comprehensive logging

#### Model
- **`app/Models/AdminPortal/SalesOrderCancellationLog.php`**
  - Model for sales order cancellation logs table
  - Relationships with User model

#### Model Updates
- **`app/Models/PayHeader.php`** - Added allocations() and details() relationships
- **`app/Models/SalesOrderRelation.php`** - Added salesOrderHeader(), excludeSalesOrderHeader(), and jobCard() relationships

### 3. Database

#### SQL Script
- **`database/admin_portal_tables.sql`**
  - Creates `admin_portal_sales_order_cancellation_logs` table
  - Creates `admin_portal_settings` table (for future use)

### 4. Configuration

#### API Config
- **`application/config/api_config.php`**
  - Added admin portal API endpoints:
    - `admin_portal_get_sales_order_details_v1`
    - `admin_portal_get_relation_details_v1`
    - `admin_portal_emergency_action_v1`
    - `admin_portal_get_logs_v1`
    - `admin_portal_get_log_v1`

#### Routes
- **`routes/api.php`**
  - Added admin portal routes under `/v1/admin-portal/`

## Admin Tables Identification

### Primary Admin Table
**`admin_portal_sales_order_cancellation_logs`**
- Stores all emergency actions performed by admins
- Contains: action_type, sales_order_relation_id, reason, status, user_id, branch_id, action_details, error_message
- Indexed for performance on: sales_order_relation_id, user_id, branch_id, action_type, status, created_at

### Supporting Admin Table
**`admin_portal_settings`**
- For future configuration storage
- Currently not used but available for settings

### How to Identify Admin Tables
Admin tables can be identified by:
1. **Table prefix**: `admin_portal_*`
2. **Purpose**: Tables related to admin-only emergency actions
3. **Location**: Created in `database/admin_portal_tables.sql`

## Admin User Type Configuration

### Where to Configure
1. **Frontend**: `application/controllers/AdminPortal.php` - Line 9
   ```php
   protected $admin_user_types = [1]; // Add your admin user type IDs
   ```

2. **Backend**: `app/Http/Controllers/v1/AdminPortalController.php` - Line 18
   ```php
   $adminUserTypes = [1]; // Add your admin user type IDs
   ```

### How to Identify Admin User Types
- Check `tbl_user_type` table
- Look for user types that should have admin privileges
- Common admin user types: Super Admin, System Admin, etc.
- Update both frontend and backend arrays with the correct IDs

## Security Features Implemented

1. **Admin-Only Access**
   - User type check in controller constructor
   - API endpoint admin checks
   - Redirects non-admin users

2. **Branch Verification**
   - Double-check: User branch vs Record branch
   - Prevents cross-branch actions
   - Logs include branch information

3. **Transaction Safety**
   - All cancellations wrapped in DB transactions
   - Rollback on errors
   - Failed actions logged separately

4. **Audit Trail**
   - Every action logged
   - Includes user, branch, reason, details
   - Error messages logged for failed actions

## Usage Flow

1. Admin logs in → Access checked
2. Navigate to Admin Portal → Shows logs list
3. Click "Emergency Action" → Form opens
4. Enter Sales Order Relation ID → Verify button
5. System loads details → Shows all linked records
6. Enter reason → Check confirmation
7. Execute → System cancels all linked records
8. Action logged → Success/failure recorded
9. View logs → Audit trail available

## Next Steps

1. **Run Database Script**: Execute `database/admin_portal_tables.sql`
2. **Configure Admin Types**: Update admin user type IDs in both frontend and backend
3. **Add Menu Item**: Add Admin Portal to your menu system
4. **Test**: Test with a non-critical sales order relation first
5. **Train Admins**: Ensure admins understand the irreversible nature of actions

## Important Notes

- ⚠️ **Irreversible**: Emergency actions cannot be undone
- 🔒 **Admin Only**: Only configured admin user types can access
- 🌿 **Branch Restricted**: Users can only act on their branch
- 📝 **Fully Logged**: All actions are logged for audit
- ✅ **Transaction Safe**: All operations are transaction-protected
