# Dynamic Payee/Employee Dropdown Feature

## 📋 Overview

The **Payee dropdown** now dynamically switches between loading **Employees** or **Payees** based on the selected **Source**.

---

## ✨ **How It Works**

### **Source-Based Logic:**

| Movement Type | Source | Payee Dropdown Shows | Add Button |
|--------------|--------|---------------------|-----------|
| **Cash In** | **Salary Cash** | 🧑‍💼 **Employees** | Hidden |
| **Cash In** | **Advance Cash** | 🧑‍💼 **Employees** | Hidden |
| Cash In | MD Cash In | 👤 Payees | Visible |
| Cash In | Other | 👤 Payees | Visible |
| **Cash Out** | IOU | 👤 Payees | Visible |
| Cash Out | Petty Cash | 👤 Payees (multiple) | Visible |
| Cash Out | Refund | 👤 Payees | Visible |
| Cash Out | Supplier | 🏢 Suppliers (GRN) | Hidden |
| Cash Out | Other | 👤 Payees | Visible |

---

## 🎯 **Key Features**

### **1. Automatic Switching**
- When you select **Salary Cash** or **Advance Cash** → Dropdown loads **Employees**
- When you select other sources → Dropdown loads **Payees**
- Switching is **instant** and **automatic**

### **2. Label Changes**
```
Salary Cash → Label: "Employee *"
Other Sources → Label: "Payee *"
```

### **3. Button Visibility**
- **"Add Payee" button is hidden** when loading employees
- **"Add Payee" button is visible** when loading payees

### **4. Placeholder Text**
```
Employees: "Select Employee"
Payees: "Select Payee"
```

---

## 🔧 **Technical Implementation**

### **1. initializePayeeDropdown() Function**

The function now checks the current source and configures Select2 accordingly:

```javascript
function initializePayeeDropdown() {
    let currentSource = $('#source').val();
    let loadEmployees = (currentSource === 'salary' || currentSource === 'advance');
    
    // Update UI
    if (loadEmployees) {
        $('label[for="payee_id"]').html('Employee <span class="text-danger">*</span>');
        $('#btnAddPayee').hide();
    } else {
        $('label[for="payee_id"]').html('Payee <span class="text-danger">*</span>');
        $('#btnAddPayee').show();
    }
    
    // Configure AJAX URL
    let url = loadEmployees 
        ? '<?= base_url("Cashier/CashMovement/getEmployees") ?>'
        : '<?= base_url("Cashier/CashMovement/getPayees") ?>';
    
    // Configure Select2 with appropriate settings
    // ...
}
```

### **2. Source Change Event**

When the source changes, the dropdown is re-initialized:

```javascript
$(document).on('change', '#source', function() {
    toggleAccountMasterField();
    
    // Re-initialize payee dropdown
    setTimeout(function() {
        initializePayeeDropdown();
    }, 100);
});
```

### **3. Data Mapping**

**For Employees:**
```javascript
{
    id: item.id,
    text: item.emp_no + ' - ' + item.emp_name,
    payee_code: item.emp_no,
    payee_name: item.emp_name
}
```

**For Payees:**
```javascript
{
    id: item.id,
    text: item.payee_code + ' - ' + item.payee_name,
    payee_code: item.payee_code,
    payee_name: item.payee_name
}
```

---

## 🎬 **User Flow Examples**

### **Example 1: Salary Cash (Employees)**
```
1. Select Movement Type: "Cash In"
   └─> Modal opens

2. Select Source: "Salary Cash"
   └─> Label changes to "Employee *"
   └─> "Add Payee" button hides
   └─> Dropdown placeholder: "Select Employee"

3. Click Employee dropdown
   └─> Employee list loads (from getEmployees API)
   └─> Shows: "EMP001 - John Doe", "EMP002 - Jane Smith", etc.

4. Search "John"
   └─> Filters to matching employees

5. Select employee
   └─> Employee code and name saved to hidden fields
```

### **Example 2: IOU (Payees)**
```
1. Select Movement Type: "Cash Out"
   └─> Modal opens

2. Select Source: "IOU"
   └─> Label shows "Payee *"
   └─> "Add Payee" button visible
   └─> Dropdown placeholder: "Select Payee"

3. Click Payee dropdown
   └─> Payee list loads (from getPayees API)
   └─> Shows: "PAY/25/D/1001 - ABC Company", etc.

4. Search "ABC"
   └─> Filters to matching payees

5. Select payee
   └─> Payee code and name saved to hidden fields
```

### **Example 3: Switching Sources**
```
1. Select Source: "Salary Cash"
   └─> Dropdown shows employees

2. Change Source to: "IOU"
   └─> Dropdown automatically switches to payees
   └─> Previous selection cleared
   └─> Label and button update
```

---

## 📊 **API Endpoints**

### **Get Employees:**
- **URL**: `Cashier/CashMovement/getEmployees`
- **Method**: GET
- **Parameters**: 
  - `term` or `search`: Search term
- **Response Format**:
```json
{
    "results": [
        {
            "id": 123,
            "text": "EMP001 - John Doe",
            "emp_no": "EMP001",
            "emp_name": "John Doe",
            "emp_etfno": "12345"
        }
    ],
    "pagination": { "more": false }
}
```

### **Get Payees:**
- **URL**: `Cashier/CashMovement/getPayees`
- **Method**: GET
- **Parameters**: 
  - `search`: Search term
  - `page`: Page number (optional)
- **Response Format**:
```json
{
    "status": true,
    "data": [
        {
            "id": 1,
            "text": "PAY/25/D/1001 - ABC Company",
            "payee_code": "PAY/25/D/1001",
            "payee_name": "ABC Company"
        }
    ]
}
```

---

## 🧪 **Testing Checklist**

### **Test 1: Salary Cash → Employees**
✅ **Steps:**
1. Open Add Cash Movement modal
2. Select Movement Type: "Cash In"
3. Select Source: "Salary Cash"
4. **Expected**: 
   - Label shows "Employee *"
   - "Add Payee" button is hidden
   - Placeholder is "Select Employee"
5. Click dropdown
6. **Expected**: Employee list loads
7. Search for an employee
8. **Expected**: Search works, filters employees

### **Test 2: Advance Cash → Employees**
✅ **Steps:**
1. Select Movement Type: "Cash In"
2. Select Source: "Advance Cash"
3. **Expected**: Same as Salary Cash (employees load)

### **Test 3: IOU → Payees**
✅ **Steps:**
1. Select Movement Type: "Cash Out"
2. Select Source: "IOU"
3. **Expected**:
   - Label shows "Payee *"
   - "Add Payee" button is visible
   - Placeholder is "Select Payee"
4. Click dropdown
5. **Expected**: Payee list loads
6. Search for a payee
7. **Expected**: Search works, filters payees

### **Test 4: Switch Between Sources**
✅ **Steps:**
1. Select Source: "Salary Cash" (employees load)
2. Select an employee
3. Change Source to: "IOU"
4. **Expected**:
   - Dropdown clears
   - Label changes to "Payee *"
   - Dropdown now shows payees
   - "Add Payee" button appears

### **Test 5: Form Submission**
✅ **Steps:**
1. Select Source: "Salary Cash"
2. Select Employee: "EMP001 - John Doe"
3. Fill other fields
4. Submit form
5. **Expected**:
   - `payee_code` = "EMP001"
   - `payee_name` = "John Doe"
   - Record saves successfully

---

## 🔍 **Troubleshooting**

### **Problem 1: Dropdown doesn't switch**
**Solution**: Check that `$('#source').on('change')` event is firing and calling `initializePayeeDropdown()`

### **Problem 2: Search not working**
**Solution**: Verify that:
- For employees: `getEmployees` endpoint accepts `term` or `search` parameter
- For payees: `getPayees` endpoint accepts `search` parameter

### **Problem 3: Label doesn't update**
**Solution**: Check that `$('label[for="payee_id"]')` selector is finding the label correctly

### **Problem 4: Button doesn't hide/show**
**Solution**: Verify `$('#btnAddPayee')` selector matches the button ID

---

## 💡 **Benefits**

| Benefit | Description |
|---------|-------------|
| **Context-Aware** | Shows relevant data based on transaction type |
| **Better UX** | Users see employees for salary/advance, payees for other transactions |
| **Cleaner Interface** | No need for separate "Employee" field |
| **Consistent** | Same dropdown mechanism for all data types |
| **Search Works** | Both employees and payees are searchable |
| **Automatic** | No manual switching required |

---

## 🚀 **Future Enhancements (Optional)**

If needed, we could add:
1. **More Source Types**: Extend to other sources that need specific data types
2. **Custom Filtering**: Filter employees by department, location, etc.
3. **Multi-Select**: Allow selecting multiple employees at once
4. **Recent Selections**: Show recently used employees/payees first

---

**Status**: ✅ Implemented and Ready  
**Date**: December 30, 2025  
**Feature Type**: Dynamic dropdown with source-based data loading  
**Files Modified**: 
- `CashMovement.php` (View)
- `CashierCashMovement.php` (Controller - getPayees method)

