# Admin Portal - Quick Reference Guide

## Quick Code Snippets for Development

### 1. Get Sales Order Relation with Relationships

```php
use App\Models\SalesOrderRelation;

$relation = SalesOrderRelation::with([
    'salesOrderHeader',
    'excludeSalesOrderHeader',
    'jobCard'
])->find($id);
```

### 2. Get Linked Invoices

```php
use App\Models\Invoice;
use App\Models\ExcludeInvoice;
use App\Models\SalesOrderHeader;
use App\Models\ExcludeSalesOrderHeader;

// Regular invoices
// Note: inv_header.job_card_id field actually stores sales_orders_header.id
// One sales order links to one invoice only (one-to-one relationship)
// Validation: Check sales order header conditions before linking invoices
$invoice = null;
if ($relation->sales_orders_header_id) {
    $salesOrderHeader = SalesOrderHeader::find($relation->sales_orders_header_id);
    if ($salesOrderHeader && 
        !is_null($salesOrderHeader->salesorder_no) && 
        $salesOrderHeader->net_total > 0 && 
        in_array($salesOrderHeader->status, ['Approved', 'Re-Approved'])) {
        
        // Get single invoice with invoice_status in ['1','2']
        $invoice = Invoice::where('job_card_id', $relation->sales_orders_header_id)
            ->whereIn('inv_status', ['1', '2'])
            ->first();
    }
}

// Exclude invoices
// Note: exclude_inv_header.job_card_id field actually stores exclude_sales_orders_header.id
// One exclude sales order links to one exclude invoice only (one-to-one relationship)
// Validation: Check exclude sales order header conditions before linking invoices
$excludeInvoice = null;
if ($relation->exclude_sales_orders_header_id) {
    $excludeSalesOrderHeader = ExcludeSalesOrderHeader::find($relation->exclude_sales_orders_header_id);
    if ($excludeSalesOrderHeader && 
        !is_null($excludeSalesOrderHeader->salesorder_no) && 
        $excludeSalesOrderHeader->net_total > 0 && 
        in_array($excludeSalesOrderHeader->status, ['Approved', 'Re-Approved'])) {
        
        // Get single exclude invoice with invoice_status in ['1','2']
        $excludeInvoice = ExcludeInvoice::where('job_card_id', $relation->exclude_sales_orders_header_id)
            ->whereIn('inv_status', ['1', '2'])
            ->first();
    }
}
```

### 3. Get Linked Payments (via pay_allocation)

```php
use App\Models\PayHeader;
use Illuminate\Support\Facades\DB;

// Regular payments only link to regular invoices (inv_header), NOT exclude invoices
// Exclude invoices link to temp payments separately (see snippet 4)
// One sales order links to one invoice only, so use single invoice ID

// Get payment IDs via pay_allocation
// Note: pay_allocation uses pay_ref_id (not invoice_id) and pay_type='Invoice'
$paymentIds = [];
if ($invoice && $invoice->id) {
    $paymentIds = DB::table('pay_allocation')
        ->where('pay_type', 'Invoice')
        ->where('pay_ref_id', $invoice->id)
        ->pluck('pay_header_id')
        ->unique()
        ->toArray();
}

// Get payments
$payments = !empty($paymentIds) ? PayHeader::whereIn('id', $paymentIds)->get() : collect([]);
```
<｜tool▁calls▁begin｜><｜tool▁call▁begin｜>
read_file

### 4. Get Linked Temp Payments

```php
use Illuminate\Support\Facades\DB;

$tempPaymentIds = [];

// From exclude invoices only
// One exclude sales order links to one exclude invoice only, so use single invoice ID
// Note: temp_pay_allocation uses pay_type='Invoice' for invoice-linked temp payments
if ($excludeInvoice && $excludeInvoice->id) {
    $tempPaymentIds = DB::table('temp_pay_allocation')
        ->where('invoice_id', $excludeInvoice->id)
        ->where('pay_type', 'Invoice')
        ->pluck('pay_header_id')
        ->unique()
        ->toArray();
}

// Get temp payment headers
$tempPayments = !empty($tempPaymentIds) ? DB::table('temp_pay_header')->whereIn('id', $tempPaymentIds)->get() : collect([]);
```

### 5. Cancel Sales Order Header & Details

```php
use App\Models\SalesOrderHeader;
use App\Models\SalesOrderDetail;
use Carbon\Carbon;

if ($relation->sales_orders_header_id) {
    $salesOrderHeader = SalesOrderHeader::find($relation->sales_orders_header_id);
    if ($salesOrderHeader) {
        // Cancel header
        $salesOrderHeader->status = 'CANCELLED';
        $salesOrderHeader->status_upd = 'CANCELLED';
        $salesOrderHeader->status_upd_at = Carbon::now();
        $salesOrderHeader->save();

        // Cancel details
        SalesOrderDetail::where('sales_orders_header_id', $salesOrderHeader->id)
            ->update([
                'status' => 'CANCELLED',
                'status_upd' => 'CANCELLED',
                'status_upd_at' => Carbon::now()
            ]);
    }
}
```

### 6. Cancel Exclude Sales Order Header & Details

```php
use App\Models\ExcludeSalesOrderHeader;
use App\Models\ExcludeSalesOrderDetail;

if ($relation->exclude_sales_orders_header_id) {
    $excludeSalesOrderHeader = ExcludeSalesOrderHeader::find($relation->exclude_sales_orders_header_id);
    if ($excludeSalesOrderHeader) {
        // Cancel header
        $excludeSalesOrderHeader->status = 'CANCELLED';
        $excludeSalesOrderHeader->status_upd = 'CANCELLED';
        $excludeSalesOrderHeader->status_upd_at = Carbon::now();
        $excludeSalesOrderHeader->save();

        // Cancel details
        ExcludeSalesOrderDetail::where('exclude_sales_orders_header_id', $excludeSalesOrderHeader->id)
            ->update([
                'status' => 'CANCELLED',
                'status_upd' => 'CANCELLED',
                'status_upd_at' => Carbon::now()
            ]);
    }
}
```

### 7. Cancel Invoices & Invoice Details

```php
use App\Models\Invoice;
use App\Models\InvoiceDetail;

// One sales order links to one invoice only
if ($invoice) {
    // Cancel header
    $invoice->status = 'CANCELLED';
    $invoice->inv_status = 'CANCELLED';
    $invoice->status_upd = 'CANCELLED';
    $invoice->status_upd_at = Carbon::now();
    $invoice->save();

    // Cancel details
    InvoiceDetail::where('invoice_id', $invoice->id)
        ->update([
            'status' => 'CANCELLED',
            'status_upd' => 'CANCELLED',
            'status_upd_at' => Carbon::now()
        ]);

    $cancelledInvoice = [
        'id' => $invoice->id,
        'invoice_number' => $invoice->invoice_number
    ];
}
```

### 8. Cancel Exclude Invoices & Details

```php
use App\Models\ExcludeInvoice;
use App\Models\ExcludeInvoiceDetail;

// One exclude sales order links to one exclude invoice only
if ($excludeInvoice) {
    // Cancel header
    $excludeInvoice->status = 'CANCELLED';
    $excludeInvoice->inv_status = 'CANCELLED';
    $excludeInvoice->status_upd = 'CANCELLED';
    $excludeInvoice->status_upd_at = Carbon::now();
    $excludeInvoice->save();

    // Cancel details
    ExcludeInvoiceDetail::where('invoice_id', $excludeInvoice->id)
        ->update([
            'status' => 'CANCELLED',
            'status_upd' => 'CANCELLED',
            'status_upd_at' => Carbon::now()
        ]);

    $cancelledExcludeInvoice = [
        'id' => $excludeInvoice->id,
        'invoice_number' => $excludeInvoice->invoice_number
    ];
}
```

### 9. Cancel Temp Payments

```php
use Illuminate\Support\Facades\DB;

$cancelledTempPayments = [];
if (!empty($tempPaymentIds)) {
    foreach ($tempPaymentIds as $tempPayHeaderId) {
        // Cancel temp_pay_header
        DB::table('temp_pay_header')
            ->where('id', $tempPayHeaderId)
            ->update([
                'status' => 'CANCELLED',
                'cancelled_at' => Carbon::now(),
                'cancelled_by' => $user->id,
                'status_upd' => 'CANCELLED',
                'status_upd_at' => Carbon::now()
            ]);

        // Cancel temp_pay_details
        DB::table('temp_pay_details')
            ->where('pay_header_id', $tempPayHeaderId)
            ->update([
                'status' => 'CANCELLED',
                'status_upd' => 'CANCELLED',
                'status_upd_at' => Carbon::now()
            ]);

        // Cancel temp_pay_allocation
        DB::table('temp_pay_allocation')
            ->where('pay_header_id', $tempPayHeaderId)
            ->update([
                'status' => 'CANCELLED',
                'status_upd' => 'CANCELLED',
                'status_upd_at' => Carbon::now()
            ]);

        $tempPayHeader = DB::table('temp_pay_header')->where('id', $tempPayHeaderId)->first();
        if ($tempPayHeader) {
            $cancelledTempPayments[] = [
                'id' => $tempPayHeaderId,
                'receipt_number' => $tempPayHeader->receipt_number ?? $tempPayHeader->draft_receipt_number ?? 'N/A'
            ];
        }
    }
}
```

### 10. Cancel Regular Payments

```php
use App\Models\PayHeader;
use App\Models\PayDetails;
use App\Models\PayAllocation;

$cancelledPayments = [];
foreach ($payments as $payment) {
    // Cancel header
    $payment->status = 'CANCELLED';
    $payment->cancelled_at = Carbon::now();
    $payment->cancelled_by = $user->id;
    $payment->status_upd = 'CANCELLED';
    $payment->status_upd_at = Carbon::now();
    $payment->save();

    // Cancel details
    PayDetails::where('pay_header_id', $payment->id)
        ->update([
            'status' => 'CANCELLED',
            'status_upd' => 'CANCELLED',
            'status_upd_at' => Carbon::now()
        ]);

    // Cancel allocations
    PayAllocation::where('pay_header_id', $payment->id)
        ->update([
            'status' => 'CANCELLED',
            'status_upd' => 'CANCELLED',
            'status_upd_at' => Carbon::now()
        ]);

    $cancelledPayments[] = [
        'id' => $payment->id,
        'receipt_number' => $payment->receipt_number
    ];
}
```

### 11. Cancel Sales Order Relation

```php
$relation->status = 'CANCELLED';
$relation->status_upd = 'CANCELLED';
$relation->status_upd_at = Carbon::now();
$relation->save();
```

### 12. Complete Transaction Pattern

```php
use Illuminate\Support\Facades\DB;

DB::beginTransaction();

try {
    // 1. Cancel Sales Order Header & Details
    // ... (code from snippet 5)
    
    // 2. Cancel Exclude Sales Order Header & Details
    // ... (code from snippet 6)
    
    // 3. Cancel Invoices & Details
    // ... (code from snippet 7)
    
    // 4. Cancel Exclude Invoices & Details
    // ... (code from snippet 8)
    
    // 5. Cancel Temp Payments
    // ... (code from snippet 9)
    
    // 6. Cancel Regular Payments
    // ... (code from snippet 10)
    
    // 7. Cancel Sales Order Relation
    // ... (code from snippet 11)
    
    // 8. Create log entry
    $log = SalesOrderCancellationLog::create([...]);
    
    DB::commit();
    
    return response()->json([
        'status' => true,
        'message' => 'Emergency action executed successfully'
    ]);
    
} catch (\Exception $e) {
    DB::rollBack();
    
    // Log failed action
    SalesOrderCancellationLog::create([
        'status' => 'FAILED',
        'error_message' => $e->getMessage(),
        ...
    ]);
    
    throw $e;
}
```

## Required Imports

```php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

// Models
use App\Models\SalesOrderRelation;
use App\Models\SalesOrderHeader;
use App\Models\SalesOrderDetail;
use App\Models\ExcludeSalesOrderHeader;
use App\Models\ExcludeSalesOrderDetail;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\ExcludeInvoice;
use App\Models\ExcludeInvoiceDetail;
use App\Models\PayHeader;
use App\Models\PayDetails;
use App\Models\PayAllocation;
use App\Models\AdminPortal\SalesOrderCancellationLog;
```

## Status Field Patterns

### Header Tables
- `status` = 'CANCELLED'
- `status_upd` = 'CANCELLED'
- `status_upd_at` = Carbon::now()
- `cancelled_at` = Carbon::now() (if exists)
- `cancelled_by` = $user->id (if exists)

### Detail Tables
- `status` = 'CANCELLED'
- `status_upd` = 'CANCELLED'
- `status_upd_at` = Carbon::now()

### Invoice Tables (Additional)
- `inv_status` = 'CANCELLED' (for inv_header and exclude_inv_header)

## Common Patterns

### Pattern 1: Get IDs from Collection
```php
$ids = $collection->pluck('id');
```

### Pattern 2: Merge Collections
```php
$allIds = $collection1->pluck('id')->merge($collection2->pluck('id'));
```

### Pattern 3: Get Unique IDs from Allocation Table
```php
$ids = DB::table('allocation_table')
    ->whereIn('foreign_key', $foreignIds)
    ->pluck('primary_key')
    ->unique();
```

### Pattern 4: Check Empty Before whereIn
```php
if (!empty($ids)) {
    $results = Model::whereIn('id', $ids)->get();
}
```

### Pattern 5: Map Collection for Response
```php
$mapped = $collection->map(function($item) {
    return [
        'id' => $item->id,
        'name' => $item->name
    ];
});
```

## Error Handling Pattern

```php
try {
    // Operation
} catch (\Exception $e) {
    return response()->json([
        'status' => false,
        'message' => 'Error: ' . $e->getMessage()
    ], 500);
}
```

## See Also

- `ADMIN_PORTAL_TABLE_RELATIONS.md` - Complete table relationships reference
- `AdminPortalController.php` - Full implementation example (located at `app/Http/Controllers/v1/AdminPortal/AdminPortalController.php`)
- `ADMIN_PORTAL_UNIFIED_APPROACH.md` - Unified cancellation approach explanation
- `ADMIN_PORTAL_API_STRUCTURE.md` - API folder structure documentation
