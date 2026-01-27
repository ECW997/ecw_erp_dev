# Numeric ID Implementation for Combined Dropdown

## ✅ Updated Implementation

The dropdown now uses **actual numeric table IDs** instead of prefixed IDs, with type tracking via data attributes.

---

## 🔧 How It Works

### Backend Response Format

```json
{
  "results": [
    {
      "id": 45,                              // ⭐ Actual employee table ID
      "text": "👤 EMP001 - John Doe",
      "type": "employee",
      "payee_code": "EMP001",
      "payee_name": "John Doe",
      "employee_id": 45,                     // For backend processing
      "epf_no": "ETF12345"
    },
    {
      "id": 12,                              // ⭐ Actual supplier table ID
      "text": "🏢 SUP001 - ABC Suppliers",
      "type": "supplier",
      "payee_code": "SUP001",
      "payee_name": "ABC Suppliers",
      "supplier_id": 12                      // For backend processing
    },
    {
      "id": 8,                               // ⭐ Actual payee_masters table ID
      "text": "💼 PAY/25/D/1001 - ABC Company",
      "type": "payee",
      "payee_code": "PAY/25/D/1001",
      "payee_name": "ABC Company"
    }
  ]
}
```

---

## 📊 Type Identification System

### When User Selects an Item:

```javascript
$payeeSelect.on('select2:select', function(e) {
    let data = e.params.data;
    let $card = $(this).closest('.payee-card');
    
    // Set visible fields
    $card.find('.payee-code').val(data.payee_code);
    $card.find('.payee-name').val(data.payee_name);
    
    // ⭐ Store type and specific IDs in data attributes
    $card.attr('data-payee-type', data.type);
    
    if (data.type === 'employee') {
        $card.attr('data-employee-id', data.employee_id);
        $card.attr('data-epf-no', data.epf_no);
    } else if (data.type === 'supplier') {
        $card.attr('data-supplier-id', data.supplier_id);
    }
    // For 'payee' type, ID is stored in the select2 value
});
```

---

## 💾 Form Submission

### Reading Data from Cards:

```javascript
let payeeType = $payeeCard.attr('data-payee-type') || 'payee';
let payeeData = {
    payee_code: payeeCode,
    payee_name: payeeName.trim(),
    line_items: payeeLineItems
};

// Set appropriate IDs based on type
if (payeeType === 'employee') {
    payeeData.payee_id = null;                                      // Not in payee_masters
    payeeData.employee_id = parseInt($payeeCard.attr('data-employee-id'), 10);
    payeeData.epf_no = $payeeCard.attr('data-epf-no');
} else if (payeeType === 'supplier') {
    payeeData.payee_id = null;                                      // Not in payee_masters
    payeeData.supplier_id = parseInt($payeeCard.attr('data-supplier-id'), 10);
} else {
    // Regular payee
    payeeData.payee_id = parseInt(selectedPayeeId, 10);            // From payee_masters
}

payees.push(payeeData);
```

---

## 📤 Data Sent to Backend

### Example 1: Employee Payment

**User Action:**
```
Select: 👤 EMP001 - John Doe (ID: 45)
```

**Data Sent:**
```json
{
  "payees": [{
    "payee_id": null,
    "employee_id": 45,              // ⭐ Actual employee table ID
    "epf_no": "ETF12345",
    "payee_code": "EMP001",
    "payee_name": "John Doe",
    "line_items": [
      {
        "account_master_id": 10,
        "amount": 5000,
        "memo": "Salary advance"
      }
    ]
  }]
}
```

### Example 2: Supplier Payment

**User Action:**
```
Select: 🏢 SUP001 - ABC Suppliers (ID: 12)
```

**Data Sent:**
```json
{
  "payees": [{
    "payee_id": null,
    "supplier_id": 12,              // ⭐ Actual supplier table ID
    "payee_code": "SUP001",
    "payee_name": "ABC Suppliers",
    "line_items": [
      {
        "account_master_id": 15,
        "amount": 10000,
        "memo": "Office supplies"
      }
    ]
  }]
}
```

### Example 3: Regular Payee

**User Action:**
```
Select: 💼 PAY/25/D/1001 - ABC Company (ID: 8)
```

**Data Sent:**
```json
{
  "payees": [{
    "payee_id": 8,                  // ⭐ Actual payee_masters table ID
    "payee_code": "PAY/25/D/1001",
    "payee_name": "ABC Company",
    "line_items": [
      {
        "account_master_id": 20,
        "amount": 15000,
        "memo": "Consulting fee"
      }
    ]
  }]
}
```

### Example 4: Mixed Payees

**User Actions:**
```
Payee 1: 👤 Employee (ID: 45)
Payee 2: 🏢 Supplier (ID: 12)
Payee 3: 💼 Payee (ID: 8)
```

**Data Sent:**
```json
{
  "payees": [
    {
      "payee_id": null,
      "employee_id": 45,            // ⭐ Employee
      "epf_no": "ETF12345",
      "payee_code": "EMP001",
      "payee_name": "John Doe",
      "line_items": [...]
    },
    {
      "payee_id": null,
      "supplier_id": 12,            // ⭐ Supplier
      "payee_code": "SUP001",
      "payee_name": "ABC Suppliers",
      "line_items": [...]
    },
    {
      "payee_id": 8,                // ⭐ Payee
      "payee_code": "PAY/25/D/1001",
      "payee_name": "ABC Company",
      "line_items": [...]
    }
  ]
}
```

---

## 🗄️ Data Attributes Storage

### On the Payee Card Element:

```html
<!-- Employee Selected -->
<div class="payee-card" 
     data-payee-type="employee" 
     data-employee-id="45"
     data-epf-no="ETF12345">
  ...
</div>

<!-- Supplier Selected -->
<div class="payee-card" 
     data-payee-type="supplier" 
     data-supplier-id="12">
  ...
</div>

<!-- Regular Payee Selected -->
<div class="payee-card" 
     data-payee-type="payee">
  <!-- ID is in the Select2 value -->
  ...
</div>
```

---

## 🔄 Clear Event Handling

When user clears the dropdown:

```javascript
$payeeSelect.on('select2:clear', function() {
    let $card = $(this).closest('.payee-card');
    
    // Clear visible fields
    $card.find('.payee-code').val('');
    $card.find('.payee-name').val('');
    
    // ⭐ Clear all data attributes
    $card.removeAttr('data-payee-type');
    $card.removeAttr('data-employee-id');
    $card.removeAttr('data-supplier-id');
    $card.removeAttr('data-epf-no');
});
```

---

## ✅ Benefits of Numeric IDs

| Benefit | Description |
|---------|-------------|
| **Database Standard** | Uses actual table primary keys |
| **Type Safe** | IDs are integers, no parsing issues |
| **Flexible** | Type stored separately in data attributes |
| **Backend Ready** | IDs can be used directly for queries |
| **Validation Pass** | Integer IDs pass validation rules |
| **Traceable** | Can link back to source tables |

---

## 🔍 ID Flow Diagram

```
User Selects → Dropdown ID → Data Attributes → Form Submission → Backend
───────────────────────────────────────────────────────────────────────────

EMPLOYEE:
👤 EMP001     id: 45        data-employee-id: 45      employee_id: 45
                            data-type: employee        payee_id: null

SUPPLIER:
🏢 SUP001     id: 12        data-supplier-id: 12      supplier_id: 12
                            data-type: supplier        payee_id: null

PAYEE:
💼 PAY/001    id: 8         (in Select2 value)        payee_id: 8
                            data-type: payee
```

---

## 🧪 Testing Checklist

### Test 1: Employee Selection
✅ Steps:
1. Select Petty Cash + Add Payee
2. Select: 👤 EMP001 - John Doe
3. Check `data-payee-type` = "employee"
4. Check `data-employee-id` = numeric ID (e.g., 45)
5. Submit → Verify `employee_id: 45`, `payee_id: null`

### Test 2: Supplier Selection
✅ Steps:
1. Select Petty Cash + Add Payee
2. Select: 🏢 SUP001 - ABC Suppliers
3. Check `data-payee-type` = "supplier"
4. Check `data-supplier-id` = numeric ID (e.g., 12)
5. Submit → Verify `supplier_id: 12`, `payee_id: null`

### Test 3: Regular Payee Selection
✅ Steps:
1. Select Petty Cash + Add Payee
2. Select: 💼 PAY/25/D/1001 - ABC Company
3. Check `data-payee-type` = "payee"
4. Submit → Verify `payee_id: 8` (numeric)

### Test 4: Clear Selection
✅ Steps:
1. Select any item from dropdown
2. Click clear (×) button
3. Check all data attributes removed
4. Check payee_code and payee_name cleared

### Test 5: Mixed Types Submission
✅ Steps:
1. Add 3 payees:
   - Payee 1: Employee
   - Payee 2: Supplier
   - Payee 3: Regular Payee
2. Submit form
3. Verify all three sent with correct ID fields

---

## 🎯 Summary

| Type | Dropdown ID | Stored In | Submitted As | Backend Field |
|------|------------|-----------|--------------|---------------|
| Employee | `45` | `data-employee-id` | `employee_id: 45` | `employee_id` |
| Supplier | `12` | `data-supplier-id` | `supplier_id: 12` | `supplier_id` |
| Payee | `8` | Select2 value | `payee_id: 8` | `payee_id` |

**All IDs are actual numeric table primary keys!** ✅

---

**Status**: ✅ Implemented  
**Date**: December 31, 2025  
**Files Modified**:
- `CashierCashMovement.php` (Backend - return numeric IDs with type)
- `CashMovement.php` (Frontend - store type and handle IDs correctly)


