# Admin Portal - Modular Structure Implementation Guide

## Overview
This guide explains how the Admin Portal is structured for unified emergency actions. The current implementation provides a unified Sales Order Relation Cancellation that handles ALL linked items (sales orders, invoices, payments, temp payments) as one integrated operation.

## Current Implementation (Phase 1)

### File Organization

#### Frontend (CodeIgniter)
```
ecw_erp_dev/
├── application/
│   ├── controllers/
│   │   └── AdminPortal.php                    # Main controller
│   ├── models/
│   │   └── AdminPortalinfo.php                # Common API communication
│   ├── views/
│   │   └── AdminPortal/
│   │       ├── index.php                      # Main dashboard (shows all logs)
│   │       ├── emergency_action_form.php      # Sales Order Cancellation form
│   │       └── view_log.php                    # Log details (common)
│   └── config/
│       ├── api_config.php                     # API endpoints
│       └── admin_portal_actions.php            # Action type registry
```

#### Backend (Laravel API)
```
api.ecw.lk/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── v1/
│   │           └── AdminPortal/
│   │               └── AdminPortalController.php   # Main API controller
│   └── Models/
│       └── AdminPortal/
│           └── SalesOrderCancellationLog.php
└── routes/
    └── api.php                                     # API routes
```

### Action Type Registry
The `admin_portal_actions.php` config file registers the unified action:
- **SALES_ORDER_RELATION_CANCEL** - Currently enabled
  - Unified cancellation of Sales Order Relation and ALL linked items:
    - Sales Orders (Header & Details)
    - Exclude Sales Orders (Header & Details)
    - Invoices (Header & Details)
    - Exclude Invoices (Header & Details)
    - Payments (Header, Details, Allocations)
    - Temp Payments (Header, Details, Allocations)

## How It Works

### 1. Common Framework
The main `AdminPortal` controller provides:
- Admin access checking
- Branch verification
- Common log viewing
- Action type routing

### 2. Unified Cancellation Implementation
The unified cancellation action has:
- **Database Table**: `admin_portal_sales_order_cancellation_logs`
- **Backend Model**: `SalesOrderCancellationLog.php`
- **Backend Controller Methods**: In `AdminPortalController.php` (handles all linked items)
- **Frontend Model Methods**: In `AdminPortalinfo.php`
- **Frontend Views**: Unified cancellation form

**Key Feature**: All linked items (sales orders, invoices, payments, temp payments) are cancelled together in a single transaction, not as separate operations.

### 3. Dynamic Menu Generation
The main dashboard (`index.php`) uses the registry to:
- Generate action buttons dynamically
- Show only enabled action types
- Display action icons and names from registry

## Adding a New Action Type

### Step 1: Register Action Type
Add to `application/config/admin_portal_actions.php`:
```php
'INVOICE_CANCEL' => [
    'name' => 'Invoice Cancellation',
    'description' => 'Cancel invoice and all linked payments',
    'controller' => 'AdminPortal', // or separate controller
    'action_method' => 'invoiceCancellationForm',
    'model' => 'AdminPortalinfo',
    'log_model' => 'InvoiceCancellationLog',
    'log_table' => 'admin_portal_invoice_cancellation_logs',
    'enabled' => true, // Set to true when ready
    'menu_icon' => 'fas fa-file-invoice',
    'menu_order' => 2,
    'requires_id_type' => 'invoice_id',
    'api_endpoints' => [
        'get_details' => 'admin_portal_get_invoice_details_v1',
        'execute' => 'admin_portal_invoice_cancellation_v1'
    ]
]
```

### Step 2: Create Database Table
Create: `database/admin_portal/invoice_cancellation_tables.sql`
```sql
CREATE TABLE `admin_portal_invoice_cancellation_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_type` varchar(50) NOT NULL DEFAULT 'INVOICE_CANCEL',
  `invoice_id` int(11) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `reason` text NOT NULL,
  `action_details` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'PENDING',
  `error_message` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_invoice_id` (`invoice_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_branch_id` (`branch_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Step 3: Create Backend Model
Create: `app/Models/AdminPortal/Actions/InvoiceCancellationLog.php`
```php
<?php
namespace App\Models\AdminPortal\Actions;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class InvoiceCancellationLog extends Model
{
    protected $table = 'admin_portal_invoice_cancellation_logs';
    
    protected $fillable = [
        'action_type',
        'invoice_id',
        'payment_id',
        'reason',
        'action_details',
        'status',
        'error_message',
        'user_id',
        'branch_id'
    ];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'idtbl_user');
    }
}
```

### Step 4: Add Backend Controller Methods
Add to `app/Http/Controllers/v1/AdminPortalController.php`:
```php
public function getInvoiceDetails($id) {
    // Admin check, branch verification, get invoice details
}

public function executeInvoiceCancellation(Request $request) {
    // Admin check, branch verification, cancellation logic, logging
}
```

### Step 5: Add Frontend Model Methods
Add to `application/models/AdminPortalinfo.php`:
```php
public function getInvoiceDetailsForEmergency($api_token, $invoice_id) {
    $headers = get_api_headers($api_token);
    return call_api('GET', 'admin_portal_get_invoice_details_v1', $invoice_id, $headers);
}

public function executeInvoiceCancellation($api_token, $form_data) {
    $headers = get_api_headers($api_token);
    return call_api('POST', 'admin_portal_invoice_cancellation_v1', $form_data, $headers);
}
```

### Step 6: Add Frontend Controller Methods
Add to `application/controllers/AdminPortal.php`:
```php
public function invoiceCancellationForm() {
    $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token, '')['data'] ?? []));
    $this->load->view('AdminPortal/Actions/InvoiceCancellation/form', $result);
}

public function executeInvoiceCancellation() {
    // Handle invoice cancellation execution
}
```

### Step 7: Create Frontend Views
Create: `application/views/AdminPortal/Actions/InvoiceCancellation/form.php`
- Similar structure to Sales Order Cancellation form
- Invoice-specific fields and validation

### Step 8: Add API Routes
Add to `routes/api.php`:
```php
Route::prefix('admin-portal')->group(function () {
    // Existing routes...
    
    // Invoice Cancellation routes
    Route::get('/invoice/{id}', [AdminPortalController::class, 'getInvoiceDetails']);
    Route::post('/invoice-cancellation', [AdminPortalController::class, 'executeInvoiceCancellation']);
});
```

### Step 9: Add API Endpoints to Config
Add to `application/config/api_config.php`:
```php
'admin_portal_get_invoice_details_v1' => '/v1/admin-portal/invoice', // GET: /v1/admin-portal/invoice/{id}
'admin_portal_invoice_cancellation_v1' => '/v1/admin-portal/invoice-cancellation',
```

### Step 10: Enable Action Type
Set `'enabled' => true` in `admin_portal_actions.php` registry

## Benefits of Current Structure

1. **Simple Start**: Current structure is straightforward for Phase 1
2. **Easy Expansion**: New action types can be added to same controller
3. **Shared Code**: Common functionality reused across actions
4. **Clear Separation**: Each action type has its own table and log model
5. **Registry-Based**: Configuration-driven, easy to manage

## Future Modular Structure (Optional Migration)

When the system grows, you can migrate to a fully modular structure:

```
AdminPortal/
├── Controllers/
│   ├── AdminPortal.php                    # Common framework
│   └── Actions/
│       ├── SalesOrderCancellation.php     # Separate controller
│       ├── InvoiceCancellation.php       # Separate controller
│       └── PaymentCancellation.php        # Separate controller
```

**Migration Benefits**:
- Better code organization
- Easier team collaboration
- Independent testing
- Clearer separation of concerns

**Migration Considerations**:
- More files to manage
- Requires updating all references
- More complex routing
- Better for larger teams

## Best Practices

1. **Naming Conventions**:
   - Action Type Code: `UPPER_SNAKE_CASE` (e.g., `SALES_ORDER_CANCEL`)
   - Controller Methods: `camelCase` (e.g., `invoiceCancellationForm`)
   - Database Tables: `snake_case` (e.g., `admin_portal_invoice_cancellation_logs`)
   - Models: `PascalCase` (e.g., `InvoiceCancellationLog`)

2. **Consistency**:
   - All action types follow same pattern
   - Same security checks (admin, branch)
   - Same logging structure
   - Same error handling

3. **Documentation**:
   - Document each action type's cancellation logic
   - Document which tables are affected
   - Document API endpoints
   - Document frontend flow

4. **Testing**:
   - Test each action type independently
   - Test common framework separately
   - Test integration between action types
   - Test registry functionality

## Action Type Checklist

When adding a new action type, ensure:

- [ ] Action type registered in `admin_portal_actions.php`
- [ ] Database table created with proper indexes
- [ ] Backend log model created
- [ ] Backend controller methods implemented
- [ ] Frontend model methods added
- [ ] Frontend controller methods added
- [ ] Frontend views created
- [ ] API routes added
- [ ] API endpoints added to config
- [ ] Admin access check implemented
- [ ] Branch verification implemented
- [ ] Transaction safety implemented
- [ ] Error logging implemented
- [ ] Success logging implemented
- [ ] Unit tests written
- [ ] Integration tests written
- [ ] Documentation updated
- [ ] Action type enabled in registry

## Summary

The Admin Portal provides a **unified cancellation action** that handles Sales Order Relations and ALL their linked items together:

1. **Unified Action** - Single operation cancels Sales Order Relation and all linked items:
   - Sales Orders
   - Exclude Sales Orders
   - Invoices
   - Exclude Invoices
   - Payments
   - Temp Payments

2. **Common Framework** - Shared admin check, branch verification, logging

3. **Single Transaction** - All items cancelled together (all or nothing)

4. **Comprehensive Logging** - One log entry records cancellation of all linked items

**Key Principle**: All linked items are handled as ONE unified cancellation action, not as separate operations. This ensures data integrity and simplifies the cancellation process.
