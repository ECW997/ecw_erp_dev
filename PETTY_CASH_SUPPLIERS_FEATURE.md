# Petty Cash Suppliers Feature

## 📋 Overview

When **Cash Out** → **Petty Cash** is selected, the payee dropdowns in the **multiple payees section** now load **Suppliers** instead of regular payees.

---

## ✨ **Feature Summary**

### **Source-Based Dropdown Logic:**

| Movement Type | Source | Multiple Payees Dropdown Shows |
|--------------|--------|------------------------------|
| **Cash Out** | **Petty Cash** | 🏢 **Suppliers** |
| Cash Out | IOU | 👤 Payees |
| Cash Out | Refund | 👤 Payees |
| Cash Out | Other | 👤 Payees |
| Cash In | Salary Cash | 🧑‍💼 Employees (single dropdown) |
| Cash In | Advance Cash | 🧑‍💼 Employees (single dropdown) |
| Cash In | Other | 👤 Payees (single dropdown) |

---

## 🎯 **Key Changes**

### **1. Petty Cash → Suppliers**
When you select **Petty Cash** as source:
- ✅ Card header changes: **"Payee 1"** → **"Supplier 1"**
- ✅ Label changes: **"Payee"** → **"Supplier"**
- ✅ Placeholder changes: "Select Payee" → **"Select Supplier"**
- ✅ **"Add Payee"** button **hides** (can't add suppliers inline)
- ✅ Dropdown loads **supplier list** from `getSuppliers` API
- ✅ Shows: `SUP001 - ABC Suppliers`, `SUP002 - XYZ Trading`, etc.
- ✅ Search works for supplier names/codes

### **2. Other Sources → Payees**
When you select other sources (IOU, Refund, etc.):
- ✅ Card header: **"Payee 1"**
- ✅ Label: **"Payee"**
- ✅ Placeholder: "Select Payee"
- ✅ **"Add Payee"** button **visible**
- ✅ Dropdown loads **payee list** from `getPayees` API
- ✅ Shows: `PAY/25/D/1001 - ABC Company`, etc.
- ✅ Search works for payee names/codes

---

## 🎬 **User Flow Example**

### **Scenario: Petty Cash Payment to Supplier**
```
1. Select Movement Type: "Cash Out"
   └─> Modal opens

2. Select Source: "Petty Cash"
   └─> Payment Category section appears

3. Leave Payment Category empty (for multiple payees)
   └─> Multiple payees section shows

4. Click "+ Add Payee" button
   └─> Card appears with title "Supplier 1"
   └─> Label shows "Supplier *"
   └─> "Add Payee" button is HIDDEN

5. Click Supplier dropdown
   └─> Supplier list loads
   └─> Shows: "SUP001 - ABC Suppliers"

6. Search "ABC"
   └─> Filters to matching suppliers

7. Select supplier
   └─> Supplier code and name saved

8. Add account detail for this supplier
   └─> Select account and enter amount

9. Submit form
   └─> Petty cash payment saved with supplier details
```

### **Scenario: Switching Sources**
```
1. Select Source: "Petty Cash"
   └─> Add Payee creates "Supplier 1" card
   └─> Dropdown shows suppliers

2. Change Source to: "IOU"
   └─> All existing cards remain
   └─> Re-initialize dropdowns
   └─> Cards now show "Payee 1" 
   └─> Dropdowns switch to payees
   └─> "Add Payee" buttons appear
```

---

## 🔧 **Technical Implementation**

### **1. initializePayeeDropdownInCard() Function**

Updated to detect source and load appropriate data:

```javascript
function initializePayeeDropdownInCard(payeeId) {
    let currentSource = $('#source').val();
    let loadSuppliers = (currentSource === 'petty');
    
    // Configure API URL
    let url = loadSuppliers 
        ? '<?= base_url("Cashier/CashMovement/getSuppliers") ?>'
        : '<?= base_url("Cashier/CashMovement/getPayees") ?>';
    
    // Configure placeholder
    let placeholder = loadSuppliers ? 'Select Supplier' : 'Select Payee';
    
    // Format data based on type
    processResults: function(data) {
        if (loadSuppliers) {
            // Format supplier data
            return {
                results: data.results.map(function(item) {
                    return {
                        id: item.id,
                        text: item.text,
                        payee_code: item.supplier_code || item.id,
                        payee_name: item.supplier_name || item.text
                    };
                })
            };
        } else {
            // Format payee data
            // ...
        }
    }
}
```

### **2. addPayee() Function**

Updated to generate appropriate labels:

```javascript
function addPayee() {
    let currentSource = $('#source').val();
    let isSupplier = (currentSource === 'petty');
    let labelText = isSupplier ? 'Supplier' : 'Payee';
    let headerText = isSupplier ? 'Supplier' : 'Payee';
    
    // Generate card with dynamic labels
    let payeeCard = `
        <div class="card-header">
            <strong>${headerText} ${payeeIndex}</strong>
        </div>
        <div class="card-body">
            <label>${labelText} <span class="text-danger">*</span></label>
            <button class="btn-add-payee-inline" style="display: ${isSupplier ? 'none' : 'inline-block'};">
                Add New ${labelText}
            </button>
        </div>
    `;
}
```

### **3. Source Change Event**

Re-initializes all payee cards when source changes:

```javascript
$(document).on('change', '#source', function() {
    toggleAccountMasterField();
    
    setTimeout(function() {
        // Re-initialize single payee dropdown
        initializePayeeDropdown();
        
        // Re-initialize all existing payee cards
        $('.payee-card').each(function() {
            let payeeId = $(this).data('payee-id');
            if (payeeId) {
                initializePayeeDropdownInCard(payeeId);
            }
        });
    }, 100);
});
```

---

## 📊 **Data Mapping**

### **Suppliers (from getSuppliers API):**
```json
{
    "results": [
        {
            "id": 1,
            "text": "SUP001 - ABC Suppliers",
            "supplier_code": "SUP001",
            "supplier_name": "ABC Suppliers"
        }
    ],
    "pagination": { "more": false }
}
```

**Mapped to:**
```javascript
{
    id: 1,
    text: "SUP001 - ABC Suppliers",
    payee_code: "SUP001",      // supplier_code saved as payee_code
    payee_name: "ABC Suppliers" // supplier_name saved as payee_name
}
```

### **Payees (from getPayees API):**
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

**Mapped to:**
```javascript
{
    id: 1,
    text: "PAY/25/D/1001 - ABC Company",
    payee_code: "PAY/25/D/1001",
    payee_name: "ABC Company"
}
```

---

## 🧪 **Testing Checklist**

### **Test 1: Petty Cash → Suppliers**
✅ **Steps:**
1. Open Add Cash Movement modal
2. Select Movement Type: "Cash Out"
3. Select Source: "Petty Cash"
4. Don't select Payment Category (leave empty)
5. **Expected**: Multiple payees section shows
6. Click "+ Add Payee"
7. **Expected**: Card title is "Supplier 1"
8. **Expected**: Label is "Supplier *"
9. **Expected**: "Add Payee" button is HIDDEN
10. Click Supplier dropdown
11. **Expected**: Supplier list loads
12. Search for a supplier
13. **Expected**: Search works, filters suppliers

### **Test 2: IOU → Payees**
✅ **Steps:**
1. Select Movement Type: "Cash Out"
2. Select Source: "IOU"
3. **Expected**: Single payee section shows (not multiple)
4. **Expected**: Label is "Payee *"
5. **Expected**: "Add Payee" button is visible
6. Click Payee dropdown
7. **Expected**: Payee list loads

### **Test 3: Switch from Petty to IOU**
✅ **Steps:**
1. Select Source: "Petty Cash"
2. Leave Payment Category empty
3. Click "+ Add Payee" (creates Supplier 1 card)
4. Select a supplier
5. Change Source to: "IOU"
6. **Expected**: 
   - Single payee section shows
   - Multiple payees section hides
   - Previous data cleared

### **Test 4: Petty Cash with Payment Category**
✅ **Steps:**
1. Select Source: "Petty Cash"
2. Select Payment Category: "Advance Payment"
3. **Expected**: Single payee section shows (not multiple)
4. **Expected**: Regular payee dropdown (not suppliers)

### **Test 5: Multiple Suppliers**
✅ **Steps:**
1. Select Source: "Petty Cash"
2. Leave Payment Category empty
3. Click "+ Add Payee" (creates Supplier 1)
4. Click "+ Add Payee" again (creates Supplier 2)
5. **Expected**: Both cards show "Supplier" labels
6. Select different suppliers in each
7. Add account details for each
8. Submit form
9. **Expected**: Both suppliers saved correctly

---

## 💾 **Form Submission**

When submitting a petty cash payment with suppliers:

```javascript
{
    "movement_type": "cash_out",
    "source": "petty",
    "payees": [
        {
            "payee_code": "SUP001",      // Supplier code
            "payee_name": "ABC Suppliers", // Supplier name
            "line_items": [
                {
                    "account_master_id": 10,
                    "amount": 1000,
                    "memo": "Office supplies"
                }
            ]
        }
    ]
}
```

**Backend receives:** Supplier codes/names in `payee_code` and `payee_name` fields, which is compatible with the existing data structure! ✅

---

## 🔍 **UI Comparison**

### **Before:**
```
Petty Cash (No category selected):
┌─────────────────────────────┐
│ Payee 1                  [×]│
├─────────────────────────────┤
│ Payee: [Select Payee ▼]    │
│        [+ Add Payee]        │
│                             │
│ Account Line Items:         │
│ ...                         │
└─────────────────────────────┘
```

### **After:**
```
Petty Cash (No category selected):
┌─────────────────────────────┐
│ Supplier 1               [×]│
├─────────────────────────────┤
│ Supplier: [Select Supplier ▼]│
│                             │  ← "Add Payee" button HIDDEN
│ Account Line Items:         │
│ ...                         │
└─────────────────────────────┘
```

---

## ✅ **Benefits**

| Benefit | Description |
|---------|-------------|
| **Context-Aware** | Shows suppliers for petty cash, payees for other sources |
| **Clear Labels** | "Supplier" vs "Payee" prevents confusion |
| **Proper Data** | Suppliers loaded from supplier API, not payee master |
| **Search Works** | Both suppliers and payees are searchable |
| **Automatic Switching** | Changes when source changes |
| **Backward Compatible** | Existing petty cash with payees still works |

---

## 🚀 **Future Enhancements (Optional)**

If needed, we could add:
1. **Supplier Categories**: Filter suppliers by category (wholesale, retail, services)
2. **Recent Suppliers**: Show frequently used suppliers first
3. **Supplier Details**: Display contact info, outstanding balance in dropdown
4. **Quick Add**: Allow creating suppliers inline (like payees)

---

**Status**: ✅ Implemented and Ready  
**Date**: December 30, 2025  
**Feature Type**: Dynamic dropdown with source-based supplier/payee loading  
**Files Modified**: `CashMovement.php` (View)

