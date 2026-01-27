# Payee Type Implementation

## 📋 Overview

Added a comprehensive payee type tracking system to the `cashier_cash_movement_payees` table that allows proper identification and linking of different payee types: **Payees**, **Employees**, and **Suppliers**.

### 🎯 Design Approach

**Clean Single-Column Design:**
- Uses **ONE common ID column** (`payee_entity_id`) instead of three separate columns
- `payee_type` ENUM identifies which table the ID references
- Cleaner, more normalized database design
- Easier to maintain and query

```
✅ IMPLEMENTED:
payee_type + payee_entity_id (single column)

❌ NOT USED:
payee_id + employee_id + supplier_id (three separate columns)
```

---

## 🗄️ Database Schema Changes

### New Columns in `cashier_cash_movement_payees`:

| Column | Type | Description |
|--------|------|-------------|
| `payee_type` | ENUM('payee', 'employee', 'supplier') | Identifies the type of payee |
| `payee_entity_id` | INT NULL | **Single common ID column** - References different tables based on `payee_type` |
| `epf_no` | VARCHAR(50) NULL | EPF/ETF number for employee payees |

### How `payee_entity_id` Works:
- **payee_type = 'payee'** → `payee_entity_id` references `cashier_payee_masters.id`
- **payee_type = 'employee'** → `payee_entity_id` references `employees.id` (external)
- **payee_type = 'supplier'** → `payee_entity_id` references `suppliers.id`

### Indexes Created:
- `idx_payee_type` on `payee_type`
- `idx_payee_entity_id` on `payee_entity_id`
- `idx_payee_type_entity` on (`payee_type`, `payee_entity_id`) - Composite index

### Foreign Keys:
- **No foreign key constraint** on `payee_entity_id` since it references different tables based on type

---

## 💾 Data Storage Logic

### Based on `payee_type`, `payee_entity_id` references different tables:

| payee_type | `payee_entity_id` References | Additional Columns | Example |
|------------|------------------------------|-------------------|---------|
| **'employee'** | `employees.id` (external table) | `epf_no`, `payee_code`, `payee_name` | payee_entity_id=45, epf_no='ETF12345' |
| **'supplier'** | `suppliers.id` | `payee_code`, `payee_name` | payee_entity_id=12 |
| **'payee'** | `cashier_payee_masters.id` | `payee_code`, `payee_name` | payee_entity_id=8 |

**Key Benefit**: One ID column (`payee_entity_id`) instead of three separate columns (`payee_id`, `employee_id`, `supplier_id`). Cleaner and more normalized! ✅

---

## 🔄 Complete Data Flow

### Step 1: User Selects Payee

```
User clicks dropdown in Petty Cash section
→ Select: 👤 EMP001 - John Doe
```

### Step 2: Frontend Captures Selection

```javascript
$payeeSelect.on('select2:select', function(e) {
    let data = e.params.data;
    
    // Store in data attributes
    $card.attr('data-payee-type', 'employee');
    $card.attr('data-employee-id', 45);
    $card.attr('data-epf-no', 'ETF12345');
});
```

### Step 3: Form Submission

```javascript
let payeeData = {
    payee_type: 'employee',       // ⭐ Type identifier
    payee_entity_id: 45,          // ⭐ Single ID column (employee table ID)
    epf_no: 'ETF12345',           // ⭐ EPF number
    payee_code: 'EMP001',
    payee_name: 'John Doe',
    line_items: [...]
};
```

### Step 4: Backend Receives and Validates

```php
// CashMovementController.php - Validation
'payees.*.payee_type' => 'nullable|in:payee,employee,supplier',
'payees.*.payee_entity_id' => 'nullable|integer',
'payees.*.epf_no' => 'nullable|string|max:50',
```

### Step 5: Backend Saves to Database

```php
$createdPayee = CashMovementPayee::create([
    'cash_movement_id' => $movement->id,
    'payee_type' => 'employee',       // ⭐ Type identifier
    'payee_entity_id' => 45,          // ⭐ Single ID column
    'payee_code' => 'EMP001',
    'payee_name' => 'John Doe',
    'epf_no' => 'ETF12345',           // ⭐ EPF number
    // ... other fields
]);
```

### Step 6: Database Record

```sql
INSERT INTO cashier_cash_movement_payees (
    cash_movement_id,
    payee_type,
    payee_entity_id,
    payee_code,
    payee_name,
    epf_no
) VALUES (
    123,              -- movement ID
    'employee',       -- ⭐ Type identifier
    45,               -- ⭐ Single ID column (employee table ID)
    'EMP001',         -- Code for display
    'John Doe',       -- Name for display
    'ETF12345'        -- ⭐ EPF number
);
```

---

## 📊 Data Examples

### Example 1: Employee Payment

**Dropdown Selection:**
```
👤 EMP001 - John Doe (ID: 45)
```

**Frontend Data:**
```javascript
{
  "payee_type": "employee",
  "payee_entity_id": 45,
  "epf_no": "ETF12345",
  "payee_code": "EMP001",
  "payee_name": "John Doe",
  "line_items": [...]
}
```

**Database Record:**
```
| payee_type | payee_entity_id | epf_no    | payee_code | payee_name |
|------------|-----------------|-----------|------------|------------|
| employee   | 45              | ETF12345  | EMP001     | John Doe   |
```

### Example 2: Supplier Payment

**Dropdown Selection:**
```
🏢 SUP001 - ABC Suppliers (ID: 12)
```

**Frontend Data:**
```javascript
{
  "payee_type": "supplier",
  "payee_entity_id": 12,
  "payee_code": "SUP001",
  "payee_name": "ABC Suppliers",
  "line_items": [...]
}
```

**Database Record:**
```
| payee_type | payee_entity_id | epf_no | payee_code | payee_name    |
|------------|-----------------|--------|------------|---------------|
| supplier   | 12              | NULL   | SUP001     | ABC Suppliers |
```

### Example 3: Regular Payee

**Dropdown Selection:**
```
💼 PAY/25/D/1001 - ABC Company (ID: 8)
```

**Frontend Data:**
```javascript
{
  "payee_type": "payee",
  "payee_entity_id": 8,
  "payee_code": "PAY/25/D/1001",
  "payee_name": "ABC Company",
  "line_items": [...]
}
```

**Database Record:**
```
| payee_type | payee_entity_id | epf_no | payee_code     | payee_name  |
|------------|-----------------|--------|----------------|-------------|
| payee      | 8               | NULL   | PAY/25/D/1001  | ABC Company |
```

---

## 🔍 Querying by Type

### Get all employee payees for a movement:

```php
$employeePayees = CashMovementPayee::where('cash_movement_id', $movementId)
    ->where('payee_type', 'employee')
    ->get();

foreach ($employeePayees as $payee) {
    echo "Employee ID: " . $payee->payee_entity_id;  // Single ID column
    echo "EPF No: " . $payee->epf_no;
}
```

### Get all supplier payees:

```php
$supplierPayees = CashMovementPayee::where('cash_movement_id', $movementId)
    ->ofType('supplier')  // Using scope
    ->get();
```

### Get payee with relationship:

```php
$payees = CashMovementPayee::with('payeeMaster')
    ->where('payee_type', 'payee')
    ->get();

foreach ($payees as $payee) {
    if ($payee->payeeMaster) {
        echo $payee->payeeMaster->contact_person;
    }
}
```

---

## 📈 Reporting Benefits

### Before (Without payee_type):
```sql
-- Hard to identify payee source
SELECT * FROM cashier_cash_movement_payees
WHERE payee_code LIKE 'EMP%'  -- Fragile!
```

### After (With payee_type):
```sql
-- Clean, reliable queries
SELECT * FROM cashier_cash_movement_payees
WHERE payee_type = 'employee'  -- ✅ Reliable!
```

### Advanced Reporting:

```sql
-- Total paid by type
SELECT 
    payee_type,
    COUNT(*) as payment_count,
    SUM(amount) as total_amount
FROM cashier_cash_movement_payees p
JOIN cashier_cash_movement_items i ON p.id = i.payee_id
WHERE p.cash_movement_id = 123
GROUP BY payee_type;

-- Result:
-- payee_type | payment_count | total_amount
-- employee   | 5             | 25000.00
-- supplier   | 3             | 45000.00
-- payee      | 2             | 15000.00
```

---

## 🔗 Relationship Tracking

### Employee Payments:
```sql
-- Join with external employees table
SELECT 
    p.*,
    e.emp_name,
    e.department
FROM cashier_cash_movement_payees p
LEFT JOIN hr_employees e ON p.payee_entity_id = e.id  -- Single ID column
WHERE p.payee_type = 'employee';
```

### Supplier Payments:
```sql
-- Join with suppliers table
SELECT 
    p.*,
    s.supplier_name,
    s.contact_phone
FROM cashier_cash_movement_payees p
LEFT JOIN suppliers s ON p.payee_entity_id = s.id  -- Single ID column
WHERE p.payee_type = 'supplier';
```

### Regular Payee Payments:
```sql
-- Join with payee_masters table
SELECT 
    p.*,
    pm.contact_person,
    pm.contact_email
FROM cashier_cash_movement_payees p
LEFT JOIN cashier_payee_masters pm ON p.payee_entity_id = pm.id  -- Single ID column
WHERE p.payee_type = 'payee';
```

---

## ✅ Benefits

| Benefit | Description |
|---------|-------------|
| **Type Safety** | Explicit type tracking prevents confusion |
| **Data Integrity** | Proper foreign keys ensure referential integrity |
| **Query Performance** | Indexed type column allows fast filtering |
| **Reporting** | Easy to generate type-specific reports |
| **Traceability** | Clear audit trail for each payee type |
| **Flexibility** | Can extend with more types in future |
| **Backward Compatible** | Defaults to 'payee' if not specified |

---

## 🧪 Testing Checklist

### Test 1: Save Employee Payee
✅ Steps:
1. Create cash movement with employee payee
2. Check `payee_type` = 'employee'
3. Check `payee_entity_id` is populated with employee ID
4. Check `epf_no` is populated

### Test 2: Save Supplier Payee
✅ Steps:
1. Create cash movement with supplier payee
2. Check `payee_type` = 'supplier'
3. Check `payee_entity_id` is populated with supplier ID

### Test 3: Save Regular Payee
✅ Steps:
1. Create cash movement with regular payee
2. Check `payee_type` = 'payee'
3. Check `payee_entity_id` is populated with payee master ID

### Test 4: Mixed Payees
✅ Steps:
1. Create cash movement with all three types
2. Verify each record has correct `payee_type`
3. Verify corresponding ID fields are populated
4. Query by type - verify filtering works

### Test 5: Update Movement
✅ Steps:
1. Edit existing cash movement
2. Change payee from employee to supplier
3. Verify `payee_type` updates correctly
4. Verify `payee_entity_id` now contains supplier ID instead of employee ID

---

## 📁 Files Modified

### Database:
- ✅ `add_payee_type_to_cash_movement_payees.sql` - Migration script

### Backend (API):
- ✅ `app/Models/Cashier/CashMovementPayee.php` - Model updated
- ✅ `app/Http/Controllers/v1/Cashier/CashMovementController.php` - Controller updated

### Frontend:
- ✅ `application/views/Cashier/CashMovement.php` - Form submission updated

---

## 🚀 Migration Steps

### Step 1: Run SQL Migration
```bash
mysql -u root -p ecw_software < add_payee_type_to_cash_movement_payees.sql
```

### Step 2: Verify Columns
```sql
DESCRIBE cashier_cash_movement_payees;
-- Should see new columns: payee_type, payee_id, employee_id, supplier_id, epf_no
```

### Step 3: Test API
```bash
# Create a test cash movement with employee payee
# Verify payee_type is saved correctly
```

### Step 4: Test Frontend
- Open Cash Movement form
- Select Petty Cash
- Add employee, supplier, and payee
- Submit and verify database records

---

**Status**: ✅ Implemented  
**Date**: December 31, 2025  
**Version**: 1.0  
**Database Impact**: Adds 5 new columns to `cashier_cash_movement_payees`

