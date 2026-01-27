# Amount Field Show/Hide Issue - Fixed

## 🐛 **Problem**

The main amount field (`#main_amount_group`) was not properly showing/hiding when switching between different source types in Cash Movement.

### **Symptoms:**
- When switching from **Petty Cash** (with no category selected) to **IOU** or other sources, the amount field remained **hidden**
- The field would stay hidden even though it should be visible and required for non-petty sources
- Users couldn't enter the amount for IOU, Invoice, Direct Sale, etc.

---

## 🔍 **Root Cause**

In the `toggleAccountMasterField()` function (line 1256), when handling non-petty sources:

```javascript
// OLD CODE (Lines 1319-1339):
} else {
    // Hide payment category section for other sources
    $('#payment_category_section').hide();
    $('#line_items_section').hide();
    $('#single_payee_section').show();
    // ... other hide/show logic ...
    
    $('#amount').prop('required', true);  // ❌ Only sets required, doesn't show the field!
```

**The Problem:**
- The code only set `required=true` on the `#amount` input field
- It did **NOT** show the `#main_amount_group` div (the wrapper containing the amount field)
- If the amount field was previously hidden (e.g., when "no category" was selected in petty cash), it would remain hidden

---

## ✅ **Solution**

Added explicit show logic for `#main_amount_group` when non-petty sources are selected:

```javascript
// NEW CODE (Lines 1319-1342):
} else {
    // Hide payment category section for other sources
    $('#payment_category_section').hide();
    $('#line_items_section').hide();
    $('#single_payee_section').show();
    // ... other hide/show logic ...
    
    // ✅ Show main amount field for non-petty sources (IOU, Invoice, Direct Sale, etc.)
    $('#main_amount_group').show();
    $('#amount').prop('required', true);
```

---

## 📋 **Complete Logic Flow**

### **Source: Petty Cash**
```
1. User selects "Petty Cash"
   ↓
2. toggleAccountMasterField() runs
   ↓
3. Shows payment_category_section
   ↓
4. Calls handlePaymentCategoryChange('')
   ↓
5. handlePaymentCategoryChange decides:
   - No category → HIDE #main_amount_group (use line items)
   - Final Payment → SHOW #main_amount_group
   - Advance Payment (employee) → SHOW #main_amount_group
   - Advance Payment (supplier) → SHOW #main_amount_group
   - Advance Payment (outsource) → HIDE #main_amount_group (use outsource_advance_amount)
   - Loan → SHOW #main_amount_group
```

### **Source: IOU, Invoice, Direct Sale, Refund, Other**
```
1. User selects non-petty source (IOU, Invoice, etc.)
   ↓
2. toggleAccountMasterField() runs
   ↓
3. Hides payment_category_section
   ↓
4. ✅ Shows #main_amount_group
   ↓
5. Sets #amount required=true
   ↓
6. Shows single_payee_section
   ↓
Result: Amount field is VISIBLE and REQUIRED
```

### **Source: Supplier (with GRN)**
```
1. User selects "Supplier"
   ↓
2. toggleAccountMasterField() runs
   ↓
3. ✅ Shows #main_amount_group
   ↓
4. Shows grn_code_group
   ↓
5. Amount field is VISIBLE
   ↓
Note: Amount is calculated from GRN line items, but field is shown
```

---

## 🧪 **Testing Checklist**

### **Test 1: Petty Cash → IOU**
1. Open Add Cash Movement modal
2. Select Movement Type: **Cash Out**
3. Select Source: **Petty Cash**
4. Do NOT select any payment category
5. **Expected**: Amount field is HIDDEN (using line items)
6. Now change Source to: **IOU**
7. **✅ Expected**: Amount field should now be VISIBLE and required
8. **✅ Verified**: Can enter amount value

### **Test 2: IOU → Petty Cash (No Category)**
1. Open Add Cash Movement modal
2. Select Movement Type: **Cash Out**
3. Select Source: **IOU**
4. **Expected**: Amount field is VISIBLE
5. Now change Source to: **Petty Cash**
6. **Expected**: Amount field is HIDDEN (no category selected, uses line items)

### **Test 3: Invoice (Cash In)**
1. Open Add Cash Movement modal
2. Select Movement Type: **Cash In**
3. Select Source: **Invoice**
4. **✅ Expected**: Amount field is VISIBLE and required

### **Test 4: Direct Sale (Cash In)**
1. Open Add Cash Movement modal
2. Select Movement Type: **Cash In**
3. Select Source: **Direct Sale**
4. **✅ Expected**: Amount field is VISIBLE and required

### **Test 5: Advance Cash (Cash In)**
1. Open Add Cash Movement modal
2. Select Movement Type: **Cash In**
3. Select Source: **Advance Cash**
4. **✅ Expected**: Amount field is VISIBLE and required

### **Test 6: Petty Cash → Advance Payment (Employee)**
1. Select Source: **Petty Cash**
2. Select Payment Category: **Advance Payment**
3. Select Type: **Employee**
4. **Expected**: Amount field is VISIBLE and required

### **Test 7: Petty Cash → Advance Payment (Outsource Supplier)**
1. Select Source: **Petty Cash**
2. Select Payment Category: **Advance Payment**
3. Select Type: **Out Source Supplier**
4. **Expected**: Amount field is HIDDEN (uses `outsource_advance_amount` instead)

### **Test 8: Supplier with GRN**
1. Select Movement Type: **Cash Out**
2. Select Source: **Supplier**
3. **✅ Expected**: Amount field is VISIBLE
4. Add GRN line items
5. **Expected**: Amount auto-calculates from GRN totals

---

## 📊 **Amount Field Visibility Matrix**

| Movement Type | Source | Payment Category | Amount Field Visible? |
|--------------|--------|------------------|----------------------|
| Cash Out | IOU | N/A | ✅ YES |
| Cash Out | Petty | (none) | ❌ NO (line items) |
| Cash Out | Petty | Final Payment | ✅ YES |
| Cash Out | Petty | Advance (Employee) | ✅ YES |
| Cash Out | Petty | Advance (Supplier) | ✅ YES |
| Cash Out | Petty | Advance (Outsource) | ❌ NO (outsource amount) |
| Cash Out | Petty | Loan | ✅ YES |
| Cash Out | Refund | N/A | ✅ YES |
| Cash Out | Supplier | N/A | ✅ YES |
| Cash Out | Other | N/A | ✅ YES |
| Cash In | Invoice | N/A | ✅ YES |
| Cash In | Direct Sale | N/A | ✅ YES |
| Cash In | IOU Settlement | N/A | ✅ YES |
| Cash In | Advance Cash | N/A | ✅ YES |
| Cash In | Salary Cash | N/A | ✅ YES |
| Cash In | MD Cash In | N/A | ✅ YES |
| Cash In | Other | N/A | ✅ YES |

---

## ✅ **Conclusion**

The fix ensures that:
1. **Non-petty sources** (IOU, Invoice, etc.) → Amount field is **always visible**
2. **Petty cash source** → Amount field visibility is controlled by **payment category**
3. **Source switching** → Amount field properly shows/hides based on new source
4. **No UI confusion** → Users can always see the appropriate input fields

**Status**: ✅ Fixed and Tested  
**Date**: December 30, 2025  
**Lines Changed**: 1319-1342 in CashMovement.php

