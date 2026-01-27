# Keyboard Shortcuts for Series Selection

## 🎹 Quick Reference

| Key | Action | Result |
|-----|--------|--------|
| **Page Up ⬆️** | Select **Series 1** | Modal border turns 🔵 **BLUE** |
| **Page Down ⬇️** | Select **Series 2** | Modal border turns 🔴 **RED** |

---

## ✨ How It Works

### **Simple & Fast:**
1. Open the Cash Movement modal (border starts 🟠 **ORANGE**)
2. Press **Page Up** → Series 1 selected, border turns 🔵 **BLUE**
3. Press **Page Down** → Series 2 selected, border turns 🔴 **RED**

### **Key Features:**
- ✅ **No need to show series dropdown** - it stays hidden
- ✅ **Instant visual feedback** - border color changes immediately
- ✅ **Works from anywhere** in the modal (except when typing in input fields)
- ✅ **Prevents page scroll** - keys only control series selection
- ✅ **Secret feature** - only cashiers who know the shortcuts can use it

---

## 🎨 Visual Feedback

### **Modal Border Colors:**

```
🟠 ORANGE (#ffc107) = No series selected yet
🔵 BLUE (#007bff)   = Series 1 selected
🔴 RED (#dc3545)    = Series 2 selected
```

### **Border Style:**
- **Width**: 4px (prominent and easily visible)
- **Applies to**: Entire modal content area
- **Updates**: Instantly when Page Up/Down pressed

---

## 🔧 Technical Details

### **Keyboard Events:**
- **Event**: `keydown` (captures Page Up/Down keys)
- **Keys**: Page Up (keyCode 33), Page Down (keyCode 34)
- **Scope**: Only works when modal is open
- **Ignored**: When typing in input/textarea/select fields

### **Series Values:**
- **Series 1**: Value = `'1'` → `is_confirm` = 1 in database
- **Series 2**: Value = `'0'` → `is_confirm` = 0 in database

### **Implementation:**
```javascript
// Page Up → Series 1
if (e.keyCode === 33) {
    $('#series').val('1');      // Set hidden field
    updateModalBorderBySeries(); // Blue border
}

// Page Down → Series 2
if (e.keyCode === 34) {
    $('#series').val('0');      // Set hidden field
    updateModalBorderBySeries(); // Red border
}
```

---

## 📖 User Guide

### **Example Workflow:**

#### **Scenario 1: Quick Series 1 Entry**
```
1. Click "Add Cash Movement"
   └─> Modal opens, border is 🟠 ORANGE
        │
2. Press Page Up ⬆️
   └─> Border turns 🔵 BLUE (Series 1 selected)
        │
3. Fill in other fields
   └─> Border stays 🔵 BLUE
        │
4. Submit
   └─> Saved with Series 1
```

#### **Scenario 2: Switching Between Series**
```
1. Modal opens (🟠 ORANGE)
        │
2. Press Page Up ⬆️
   └─> 🔵 BLUE (Series 1)
        │
3. Change mind, press Page Down ⬇️
   └─> 🔴 RED (Series 2)
        │
4. Press Page Up ⬆️ again
   └─> 🔵 BLUE (back to Series 1)
```

#### **Scenario 3: With Auto Checkbox**
```
1. Modal opens (🟠 ORANGE)
        │
2. Check "Auto" checkbox
   └─> 🔵 BLUE (Series 1 auto-selected)
        │
3. Press Page Down ⬇️ (override auto)
   └─> 🔴 RED (Series 2)
        │
Note: Auto checkbox is automatically unchecked
      when using keyboard shortcuts
```

---

## 🧪 Testing Checklist

### **Test 1: Page Up → Series 1**
✅ **Steps:**
1. Open Cash Movement modal
2. Press **Page Up** key
3. **Expected**: Border turns 🔵 BLUE
4. Submit form
5. **Expected**: Record saved with `is_confirm = 1` (Series 1)

### **Test 2: Page Down → Series 2**
✅ **Steps:**
1. Open Cash Movement modal
2. Press **Page Down** key
3. **Expected**: Border turns 🔴 RED
4. Submit form
5. **Expected**: Record saved with `is_confirm = 0` (Series 2)

### **Test 3: Switch Between Series**
✅ **Steps:**
1. Open modal (🟠 ORANGE)
2. Press Page Up (🔵 BLUE)
3. Press Page Down (🔴 RED)
4. Press Page Up (🔵 BLUE)
5. **Expected**: Border changes correctly each time

### **Test 4: Keys Don't Work When Typing**
✅ **Steps:**
1. Open modal
2. Click in "Amount" input field
3. Press Page Up/Down
4. **Expected**: Keys don't change series (prevents accidental changes)
5. Click outside input field
6. Press Page Up/Down
7. **Expected**: Keys work normally

### **Test 5: Keys Only Work in Modal**
✅ **Steps:**
1. Close modal (on main page)
2. Press Page Up/Down
3. **Expected**: Page scrolls normally (no series selection)
4. Open modal
5. Press Page Up/Down
6. **Expected**: Series selection works

### **Test 6: Override Auto Checkbox**
✅ **Steps:**
1. Open modal
2. Check "Auto" checkbox (🔵 BLUE, Series 1)
3. Press Page Down
4. **Expected**: Border turns 🔴 RED (Series 2)
5. **Expected**: Auto checkbox is unchecked

---

## 🎯 Benefits

| Benefit | Description |
|---------|-------------|
| **Speed** | Change series with one key press |
| **No Mouse** | Keyboard-only workflow |
| **Visual** | Instant border color feedback |
| **Hidden** | Series field never shows (clean UI) |
| **Secret** | Only trained cashiers know the shortcuts |
| **Error Prevention** | Border color prevents confusion |

---

## ⚙️ Integration with Existing Features

### **Works With:**
- ✅ **Auto S1 Checkbox**: Can override auto-selection with Page Down
- ✅ **Form Validation**: Series value still validated on submit
- ✅ **Edit Mode**: Can change series when editing
- ✅ **IOU Redirect**: Can override pre-filled series
- ✅ **Modal Border Colors**: Syncs perfectly with color system

### **Series Field State:**
- **Always hidden** via CSS (`display: none` on `#series_group`)
- **Value set silently** in background
- **No UI disruption** - users never see the dropdown
- **Form submission** includes series value normally

---

## 🔍 Console Logs

For debugging:

```javascript
// Page Up pressed
"Series 1 selected (Page Up pressed) - Modal border: BLUE"

// Page Down pressed
"Series 2 selected (Page Down pressed) - Modal border: RED"

// Modal border updates
"Modal border: Blue (Series 1)"
"Modal border: Red (Series 2)"
"Modal border: Orange (No series selected)"
```

---

## 💡 Why This Design?

### **Problem Solved:**
- Series selection was hidden and required secret "boom" code
- Typing "boom" felt unnatural
- Users wanted faster, more intuitive method

### **Solution:**
- **Page Up/Down** are rarely used in modal dialogs
- Keys are easy to remember: **Up** = 1 (first), **Down** = 2 (second)
- Border colors provide instant feedback
- No UI clutter (field stays hidden)

---

## 🚀 Training Tips

### **For Cashiers:**
1. **Remember**: Page Up = Series 1 (Blue), Page Down = Series 2 (Red)
2. **Watch the border**: Color shows which series is active
3. **Quick switch**: Press keys anytime to change series
4. **No scroll**: Keys won't scroll the page in modal

### **Quick Mnemonic:**
- **Page UP** ⬆️ = First series = **1** 🔵
- **Page DOWN** ⬇️ = Second series = **2** 🔴

---

**Status**: ✅ Implemented and Ready  
**Date**: December 30, 2025  
**Feature Type**: Hidden keyboard shortcut for power users  
**Files Modified**: `CashMovement.php`  
**Key Bindings**: Page Up (Series 1), Page Down (Series 2)

