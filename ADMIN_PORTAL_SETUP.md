# Admin Portal - Emergency Actions Module

## Overview
The Admin Portal module provides emergency action capabilities for administrators to cancel sales order relations and all linked records (sales orders, exclude sales orders, invoices, exclude invoices, and payments). All actions are logged for audit purposes.

## Features
- **Admin-Only Access**: Only users with admin user type IDs can access this module
- **Branch Verification**: Double-check ensures users can only perform actions on their own branch
- **Comprehensive Cancellation**: Cancels sales order relation and all linked records:
  - Sales Order Header and Details
  - Exclude Sales Order Header and Details
  - Linked Invoices and Invoice Details
  - Linked Exclude Invoices and Exclude Invoice Details
  - Linked Payments, Payment Details, and Payment Allocations
  - Linked Temp Payments (temp_pay_header, temp_pay_details, temp_pay_allocation) - linked to exclude invoices or jobcard advance payments
- **Audit Logging**: All actions are logged with:
  - Action type
  - User information
  - Branch information
  - Reason for action
  - Detailed action results
  - Timestamp

## Installation Steps

### 1. Database Setup
Run the SQL script to create the required tables:
```bash
mysql -u your_username -p your_database < database/admin_portal_tables.sql
```

Or execute the SQL file manually in your database:
- `admin_portal_sales_order_cancellation_logs` table
- `admin_portal_settings` table (for future use)

### 2. Configure Admin User Types
Edit the following files to set which user types have admin access:

**Frontend (CodeIgniter):**
- `application/controllers/AdminPortal.php` - Line 9: `protected $admin_user_types = [1];`
- Update the array with your admin user type IDs

**Backend (Laravel API):**
- `app/Http/Controllers/v1/AdminPortalController.php` - Line 18: `$adminUserTypes = [1];`
- Update the array with your admin user type IDs

### 3. Menu Configuration
Add a menu item for Admin Portal in your menu management system:
- Menu Name: "Admin Portal"
- Menu URL: `AdminPortal`
- Menu Icon: `fas fa-shield-alt`
- Required Privileges: Only assign to admin user types

### 4. File Structure
The module consists of:

**Frontend (CodeIgniter):**
```
application/
├── controllers/
│   └── AdminPortal.php
├── models/
│   └── AdminPortalinfo.php
└── views/
    └── AdminPortal/
        ├── index.php (Logs list)
        ├── emergency_action_form.php (Action form)
        └── view_log.php (Log details)
```

**Backend (Laravel API):**
```
app/
├── Http/
│   └── Controllers/
│       └── v1/
│           └── AdminPortalController.php
└── Models/
    └── AdminPortal/
        └── SalesOrderCancellationLog.php
```

**Database:**
```
database/
└── admin_portal_tables.sql
```

### 5. API Endpoints
The following API endpoints are available:

- `GET /api/v1/admin-portal/sales-order/{id}` - Get sales order details for verification
- `GET /api/v1/admin-portal/sales-order-relation/{id}` - Get sales order relation details
- `POST /api/v1/admin-portal/emergency-action` - Execute emergency action
- `POST /api/v1/admin-portal/logs` - Get emergency action logs (with filters)
- `GET /api/v1/admin-portal/logs/{id}` - Get specific log details

### 6. Routes Configuration
Routes are already configured in:
- `routes/api.php` - Admin Portal routes are added under `/v1/admin-portal/`

### 7. Access URLs
After setup, access the Admin Portal at:
- Main Portal: `http://your-domain/AdminPortal`
- Emergency Action Form: `http://your-domain/AdminPortal/emergencyActionForm`
- View Log: `http://your-domain/AdminPortal/viewLog/{log_id}`

## Usage

### Performing an Emergency Action

1. Navigate to Admin Portal → Emergency Action
2. Enter the Sales Order Relation ID
3. Click "Verify & Load Details" to see all linked records
4. Review the details carefully
5. Enter a detailed reason for the action
6. Check the confirmation checkbox
7. Click "Execute Emergency Action"

### Viewing Logs

1. Navigate to Admin Portal main page
2. Use filters to search logs by:
   - Date range
   - Action type
   - User
3. Click "View" on any log to see detailed information

## Security Features

1. **Admin-Only Access**: Controller constructor checks user type on every request
2. **Branch Verification**: Double-check ensures users can only act on their branch
3. **Transaction Safety**: All cancellations are wrapped in database transactions
4. **Audit Trail**: Every action is logged with full details
5. **Error Handling**: Failed actions are logged with error messages

## Important Notes

- **Irreversible Actions**: Emergency actions cannot be undone. Use with extreme caution.
- **Branch Restriction**: Users can only perform actions on records belonging to their branch
- **Log Retention**: Logs are kept indefinitely for audit purposes
- **Admin User Types**: Make sure to configure the correct admin user type IDs

## Troubleshooting

### Access Denied Errors
- Verify user has admin user type ID configured in both frontend and backend
- Check user's branch_id matches the record's branch

### Database Errors
- Ensure all tables exist (run SQL script)
- Check database user has proper permissions
- Verify foreign key relationships exist

### API Errors
- Check API routes are properly registered
- Verify JWT token is valid
- Check API base URL in `application/config/api_config.php`

## Future Enhancements

- Additional emergency action types (invoice cancellation, payment cancellation)
- Email notifications for emergency actions
- Approval workflow for critical actions
- Export logs to CSV/PDF
- Dashboard with statistics
