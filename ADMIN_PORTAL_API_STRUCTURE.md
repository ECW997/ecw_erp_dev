# Admin Portal - API Folder Structure

## Backend API Structure (Laravel)

### Current Structure
```
api.ecw.lk/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── v1/
│   │           └── AdminPortal/
│   │               └── AdminPortalController.php
│   └── Models/
│       └── AdminPortal/
│           └── SalesOrderCancellationLog.php
└── routes/
    └── api.php
```

## API Routes Structure

### Route Group: `/api/v1/admin-portal`

```php
Route::prefix('admin-portal')->group(function () {
    // Sales Order Details
    Route::get('/sales-order/{id}', [AdminPortalController::class, 'getSalesOrderDetails']);
    
    // Sales Order Relation Details
    Route::get('/sales-order-relation/{id}', [AdminPortalController::class, 'getSalesOrderRelationDetails']);
    
    // Execute Emergency Action
    Route::post('/emergency-action', [AdminPortalController::class, 'executeEmergencyAction']);
    
    // Logs
    Route::post('/logs', [AdminPortalController::class, 'getLogs']);
    Route::get('/logs/{id}', [AdminPortalController::class, 'getLog']);
});
```

## Controller Structure

### Namespace
```php
namespace App\Http\Controllers\v1\AdminPortal;
```

### Controller Class
```php
class AdminPortalController extends Controller
{
    // Methods:
    // - getSalesOrderDetails($id)
    // - getSalesOrderRelationDetails($id)
    // - executeEmergencyAction(Request $request)
    // - getLogs(Request $request)
    // - getLog($id)
    // - checkAdminAccess($user) // Private method
}
```

## API Endpoints

| Method | Endpoint | Controller Method | Description |
|--------|----------|-------------------|-------------|
| GET | `/api/v1/admin-portal/sales-order/{id}` | `getSalesOrderDetails` | Get sales order details with all linked items |
| GET | `/api/v1/admin-portal/sales-order-relation/{id}` | `getSalesOrderRelationDetails` | Get relation details for branch verification |
| POST | `/api/v1/admin-portal/emergency-action` | `executeEmergencyAction` | Execute unified cancellation |
| POST | `/api/v1/admin-portal/logs` | `getLogs` | Get logs with filters |
| GET | `/api/v1/admin-portal/logs/{id}` | `getLog` | Get specific log details |

## Request/Response Examples

### Get Sales Order Details
**Request:**
```
GET /api/v1/admin-portal/sales-order/123
Headers: Authorization: Bearer {token}
```

**Response:**
```json
{
    "status": true,
    "data": {
        "id": 123,
        "jobcard_id": 456,
        "sales_orders_header_id": 789,
        "exclude_sales_orders_header_id": 101,
        "linked_invoices": [...],
        "linked_exclude_invoices": [...],
        "linked_payments": [...],
        "linked_temp_payments": [...]
    }
}
```

### Execute Emergency Action
**Request:**
```
POST /api/v1/admin-portal/emergency-action
Headers: Authorization: Bearer {token}
Body: {
    "sales_order_relation_id": 123,
    "reason": "Customer cancellation request",
    "branch_id": 1
}
```

**Response:**
```json
{
    "status": true,
    "message": "Emergency action executed successfully",
    "data": {
        "log_id": 456,
        "cancelled_records": {
            "sales_order": {...},
            "invoices": [...],
            "payments": [...],
            "temp_payments": [...]
        }
    }
}
```

## Folder Organization Benefits

1. **Separation**: Admin Portal APIs are isolated in their own folder
2. **Scalability**: Easy to add more Admin Portal controllers (e.g., LogsController, SettingsController)
3. **Consistency**: Follows same pattern as Cashier and GatePass modules
4. **Maintainability**: Clear organization makes code easier to find and maintain

## Future Expansion

If more Admin Portal controllers are needed:

```
app/Http/Controllers/v1/AdminPortal/
├── AdminPortalController.php          # Main controller (current)
├── LogsController.php                # Future: Dedicated logs controller
└── SettingsController.php            # Future: Admin settings controller
```

## Migration Notes

- ✅ Controller moved from `v1/AdminPortalController.php` to `v1/AdminPortal/AdminPortalController.php`
- ✅ Namespace updated from `App\Http\Controllers\v1` to `App\Http\Controllers\v1\AdminPortal`
- ✅ Routes updated to use new namespace
- ✅ Old controller file deleted

## See Also

- `ADMIN_PORTAL_FULL_PLAN.md` - Complete project plan
- `ADMIN_PORTAL_TABLE_RELATIONS.md` - Table relationships reference
- `ADMIN_PORTAL_QUICK_REFERENCE.md` - Code snippets guide
