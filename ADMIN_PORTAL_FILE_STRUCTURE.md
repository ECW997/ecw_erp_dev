# Admin Portal - Modular File Structure

## Overview
The Admin Portal is designed with a modular structure to support multiple emergency action types. Each action type has its own dedicated files and folders, while common functionality is shared through the framework.

## Complete File Structure

```
ecw_erp_dev/
├── application/
│   ├── controllers/
│   │   └── AdminPortal/
│   │       ├── AdminPortal.php                    # Main controller (Common Framework)
│   │       ├── Actions/
│   │       │   ├── SalesOrderCancellation.php     # Sales Order Cancellation Controller
│   │       │   ├── InvoiceCancellation.php        # Invoice Cancellation Controller (Future)
│   │       │   └── PaymentCancellation.php         # Payment Cancellation Controller (Future)
│   │       └── Common/
│   │           └── LogsController.php              # Common logs controller
│   │
│   ├── models/
│   │   └── AdminPortal/
│   │       ├── AdminPortalinfo.php                # Common model (API communication)
│   │       └── Actions/
│   │           ├── SalesOrderCancellationinfo.php # Sales Order Cancellation Model
│   │           ├── InvoiceCancellationinfo.php     # Invoice Cancellation Model (Future)
│   │           └── PaymentCancellationinfo.php      # Payment Cancellation Model (Future)
│   │
│   ├── views/
│   │   └── AdminPortal/
│   │       ├── Common/
│   │       │   ├── index.php                      # Main portal dashboard (Common)
│   │       │   └── view_log.php                    # Log details view (Common)
│   │       └── Actions/
│   │           ├── SalesOrderCancellation/
│   │           │   ├── form.php                   # Sales Order Cancellation form
│   │           │   └── details.php                 # Sales Order details display
│   │           ├── InvoiceCancellation/
│   │           │   ├── form.php                   # Invoice Cancellation form (Future)
│   │           │   └── details.php                 # Invoice details display (Future)
│   │           └── PaymentCancellation/
│   │               ├── form.php                   # Payment Cancellation form (Future)
│   │               └── details.php                 # Payment details display (Future)
│   │
│   └── config/
│       └── api_config.php                         # API endpoints config
│
├── database/
│   └── admin_portal/
│       ├── sales_order_cancellation_tables.sql    # Sales Order Cancellation tables
│       ├── invoice_cancellation_tables.sql        # Invoice Cancellation tables (Future)
│       └── payment_cancellation_tables.sql        # Payment Cancellation tables (Future)
│
└── Documentation/
    ├── ADMIN_PORTAL_SETUP.md
    ├── ADMIN_PORTAL_SUMMARY.md
    ├── ADMIN_PORTAL_TEMP_PAYMENTS.md
    ├── ADMIN_PORTAL_FULL_PLAN.md
    └── ADMIN_PORTAL_FILE_STRUCTURE.md             # This file

api.ecw.lk/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── v1/
│   │           └── AdminPortal/
│   │               ├── AdminPortalController.php   # Main controller (Common Framework)
│   │               └── Actions/
│   │                   ├── SalesOrderCancellationController.php
│   │                   ├── InvoiceCancellationController.php    # Future
│   │                   └── PaymentCancellationController.php   # Future
│   │
│   └── Models/
│       └── AdminPortal/
│           ├── Common/
│           │   └── BaseActionLog.php              # Base log model (if needed)
│           └── Actions/
│               ├── SalesOrderCancellationLog.php
│               ├── InvoiceCancellationLog.php      # Future
│               └── PaymentCancellationLog.php      # Future
│
└── routes/
    └── api.php                                     # API routes
```

## Structure Explanation

### Frontend (CodeIgniter) Structure

#### 1. Controllers (`application/controllers/AdminPortal/`)
- **AdminPortal.php** - Main controller with common framework:
  - Admin access check
  - Branch verification
  - Common routing
  - Log viewing (common)
  
- **Actions/** - Action-specific controllers:
  - **SalesOrderCancellation.php** - Handles sales order cancellation
  - **InvoiceCancellation.php** - Handles invoice cancellation (Future)
  - **PaymentCancellation.php** - Handles payment cancellation (Future)

#### 2. Models (`application/models/AdminPortal/`)
- **AdminPortalinfo.php** - Common API communication model
- **Actions/** - Action-specific models:
  - **SalesOrderCancellationinfo.php** - Sales order cancellation API calls
  - **InvoiceCancellationinfo.php** - Invoice cancellation API calls (Future)
  - **PaymentCancellationinfo.php** - Payment cancellation API calls (Future)

#### 3. Views (`application/views/AdminPortal/`)
- **Common/** - Shared views:
  - **index.php** - Main dashboard showing all action logs
  - **view_log.php** - Generic log details view
  
- **Actions/** - Action-specific views:
  - **SalesOrderCancellation/** - Sales order cancellation forms and displays
  - **InvoiceCancellation/** - Invoice cancellation forms (Future)
  - **PaymentCancellation/** - Payment cancellation forms (Future)

### Backend (Laravel API) Structure

#### 1. Controllers (`app/Http/Controllers/v1/AdminPortal/`)
- **AdminPortalController.php** - Common framework controller
- **Actions/** - Action-specific controllers:
  - **SalesOrderCancellationController.php** - Sales order cancellation logic
  - **InvoiceCancellationController.php** - Invoice cancellation logic (Future)
  - **PaymentCancellationController.php** - Payment cancellation logic (Future)

#### 2. Models (`app/Models/AdminPortal/`)
- **Actions/** - Action-specific log models:
  - **SalesOrderCancellationLog.php** - Sales order cancellation logs
  - **InvoiceCancellationLog.php** - Invoice cancellation logs (Future)
  - **PaymentCancellationLog.php** - Payment cancellation logs (Future)

### Database Structure

#### Tables (`database/admin_portal/`)
- **sales_order_cancellation_tables.sql** - Sales Order Cancellation tables
- **invoice_cancellation_tables.sql** - Invoice Cancellation tables (Future)
- **payment_cancellation_tables.sql** - Payment Cancellation tables (Future)

## Benefits of This Structure

1. **Modularity**: Each action type is self-contained
2. **Scalability**: Easy to add new action types
3. **Maintainability**: Changes to one action type don't affect others
4. **Clarity**: Clear separation between common and specific code
5. **Reusability**: Common framework can be reused across all action types

## Adding a New Action Type

### Step 1: Create Database Tables
Create SQL file: `database/admin_portal/{action_name}_tables.sql`

### Step 2: Create Backend Model
Create: `app/Models/AdminPortal/Actions/{ActionName}Log.php`

### Step 3: Create Backend Controller
Create: `app/Http/Controllers/v1/AdminPortal/Actions/{ActionName}Controller.php`

### Step 4: Create Frontend Model
Create: `application/models/AdminPortal/Actions/{ActionName}info.php`

### Step 5: Create Frontend Controller
Create: `application/controllers/AdminPortal/Actions/{ActionName}.php`

### Step 6: Create Frontend Views
Create folder: `application/views/AdminPortal/Actions/{ActionName}/`
- `form.php` - Action form
- `details.php` - Details display

### Step 7: Add Routes
- Add API routes in `routes/api.php`
- Add frontend routes in CodeIgniter routes config

### Step 8: Update Common Files
- Add action type to main dashboard
- Add menu item (if needed)
- Update API config

## Current Implementation Status

### ✅ Phase 1: Sales Order Cancellation
- [x] Database tables created
- [x] Backend model created
- [x] Backend controller created
- [x] Frontend model created
- [x] Frontend controller created
- [x] Frontend views created
- [x] Routes configured

### ⏳ Phase 2: Invoice Cancellation (Future)
- [ ] Database tables
- [ ] Backend model
- [ ] Backend controller
- [ ] Frontend model
- [ ] Frontend controller
- [ ] Frontend views
- [ ] Routes

### ⏳ Phase 3: Payment Cancellation (Future)
- [ ] Database tables
- [ ] Backend model
- [ ] Backend controller
- [ ] Frontend model
- [ ] Frontend controller
- [ ] Frontend views
- [ ] Routes

## Migration from Current Structure

To migrate to this new structure:

1. **Move existing files**:
   - `AdminPortal.php` → `AdminPortal/AdminPortal.php`
   - `AdminPortalinfo.php` → `AdminPortal/AdminPortalinfo.php`
   - Views → `AdminPortal/Common/` and `AdminPortal/Actions/SalesOrderCancellation/`

2. **Create action-specific files**:
   - Extract sales order cancellation logic to separate controller
   - Create action-specific model
   - Create action-specific views

3. **Update routes**:
   - Update CodeIgniter routes
   - Update API routes

4. **Update references**:
   - Update all file includes/requires
   - Update API config
   - Update documentation
