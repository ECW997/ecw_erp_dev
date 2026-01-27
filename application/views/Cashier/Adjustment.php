<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include APPPATH . "views/include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-adjust mr-2"></i>Cashier Shift Adjustments</h1>
                </div>
            </div>
            <div class="container-fluid mt-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Adjustments List</h5>
                        <div>
                            <button type="button" id="toggleAdjustmentSeries2Btn" class="btn btn-warning btn-sm mr-2" style="display: none;" title="Hide Series 2" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-eye-slash"></i> Hide Series 2
                            </button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addAdjustmentModal">
                                <i class="fas fa-plus mr-2"></i>Add Adjustment
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="adjustmentsTable" class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Shift ID</th>
                                    <th>Adjustment Type</th>
                                    <th>Amount</th>
                                    <th>Remarks</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <div class="modal fade" id="addAdjustmentModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="addAdjustmentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="addAdjustmentForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addAdjustmentModalLabel">Add Shift Adjustment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Hidden field for current user's active shift -->
                            <input type="hidden" id="cashier_shift_id" name="cashier_shift_id" required>
                            <div class="form-group">
                                <label for="adjustment_type">Adjustment Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="adjustment_type" name="adjustment_type" required>
                                    <option value="">Select Type</option>
                                    <option value="invoice_void">Invoice Void</option>
                                    <option value="correction">Correction</option>
                                    <option value="manual">Manual</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount <span class="text-danger">*</span></label>
                                <input type="text" class="form-control price-input text-right" id="amount" name="amount" required placeholder="0.00">
                            </div>
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveAdjustmentBtn" title="Save Adjustment" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editAdjustmentModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="editAdjustmentForm">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Adjustment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="editAdjustmentContent">
                            <!-- Dynamic content -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" title="Cancel" data-toggle="tooltip" data-placement="top"><i class="fas fa-times"></i></button>
                            <button type="submit" class="btn btn-primary" title="Update Adjustment" data-toggle="tooltip" data-placement="top"><i class="fas fa-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>
<?php include APPPATH . "views/include/footerscripts.php"; ?>
<script>
// Global function to format number with thousand separators (supports negative numbers)
function formatPriceWithCommas(value) {
    if (!value || value === '') return '';
    
    let strValue = value.toString().trim();
    
    // Check if negative (must be at the start)
    let isNegative = strValue.startsWith('-');
    
    // Remove all commas and non-numeric characters except decimal point
    // Process absolute value (remove minus sign for processing)
    let numValue = strValue.replace(/[^0-9.]/g, '');
    
    if (numValue === '' || numValue === '.') return isNegative ? '-' : '';
    
    // Split integer and decimal parts
    let parts = numValue.split('.');
    let integerPart = parts[0] || '0';
    let decimalPart = parts.length > 1 ? '.' + parts[1].substring(0, 2) : '';
    
    // Add thousand separators to integer part
    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    
    // Add back minus sign if original was negative (and value is not zero)
    if (isNegative && integerPart !== '0' && (integerPart !== '' || decimalPart !== '')) {
        return '-' + integerPart + decimalPart;
    }
    
    return integerPart + decimalPart;
}

// Global function to remove commas and get clean numeric value
function getCleanNumericValue(value) {
    if (!value || value === '') return '';
    // Remove all commas and return clean number
    return value.toString().replace(/,/g, '');
}

// Background typing detection for "boom" secret code to show/hide Series 2
const SERIES_SECRET_CODE = 'boom';
var adjustmentSeriesCodeBuffer = '';
var adjustmentLastKeyTime = 0;
var showAdjustmentSeries2 = false; // Toggle to show both Series 1 and Series 2

// Ensure variable is available in global scope for DataTable callbacks
window.showAdjustmentSeries2 = showAdjustmentSeries2;

$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Re-initialize tooltips after DataTable is drawn
    $('#adjustmentsTable').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    
    // Format price inputs with thousand separators on input, paste, and blur
    $(document).on("input paste keyup blur", ".price-input", function(e) {
        let $input = $(this);
        
        if (e.type === 'keyup') {
            if ([37, 38, 39, 40, 8, 46, 9, 16, 17, 18, 91, 93, 35, 36].includes(e.keyCode)) {
                return;
            }
        }
        
        setTimeout(function() {
            let currentValue = $input.val();
            let cleanValue = getCleanNumericValue(currentValue);
            let formatted = formatPriceWithCommas(cleanValue);
            
            if (currentValue !== formatted) {
                let cursorPos = $input.prop('selectionStart') || 0;
                let oldLength = currentValue.length;
                $input.val(formatted);
                
                let newLength = formatted.length;
                let newCursorPos = cursorPos + (newLength - oldLength);
                $input.prop('selectionStart', newCursorPos);
                $input.prop('selectionEnd', newCursorPos);
            }
        }, 0);
    });
    
    // On focus, remove commas for easier editing
    $(document).on("focus", ".price-input", function() {
        let $input = $(this);
        let value = getCleanNumericValue($input.val());
        if (value !== '') {
            $input.val(value);
        }
    });
    
    // Background typing detection for "boom" secret code
    $(document).on('keypress', function(e) {
        // Ignore if typing in an input field or textarea
        if ($(e.target).is('input, textarea, select')) {
            return;
        }
        
        var now = Date.now();
        var keyChar = String.fromCharCode(e.which).toLowerCase();
        
        // Handle Adjustment DataTable Series 2 toggle
        if (now - adjustmentLastKeyTime > 2000) {
            adjustmentSeriesCodeBuffer = '';
        }
        adjustmentLastKeyTime = now;
        
        adjustmentSeriesCodeBuffer += keyChar;
        if (adjustmentSeriesCodeBuffer.length > SERIES_SECRET_CODE.length) {
            adjustmentSeriesCodeBuffer = adjustmentSeriesCodeBuffer.slice(-SERIES_SECRET_CODE.length);
        }
        
        if (adjustmentSeriesCodeBuffer === SERIES_SECRET_CODE) {
            // Toggle Series 2 visibility in Adjustment DataTable
            showAdjustmentSeries2 = !showAdjustmentSeries2;
            window.showAdjustmentSeries2 = showAdjustmentSeries2; // Update global scope
            
            if (showAdjustmentSeries2) {
                $('#toggleAdjustmentSeries2Btn').show();
            } else {
                $('#toggleAdjustmentSeries2Btn').hide();
            }
            
            // Reload table with new filter
            if ($.fn.DataTable.isDataTable('#adjustmentsTable')) {
                $('#adjustmentsTable').DataTable().ajax.reload();
            } else {
                initializeAdjustmentsTable();
            }
            
            adjustmentSeriesCodeBuffer = '';
            adjustmentLastKeyTime = 0;
        }
    });

    // Toggle Series 2 button click handler
    $('#toggleAdjustmentSeries2Btn').on('click', function() {
        showAdjustmentSeries2 = false;
        window.showAdjustmentSeries2 = false; // Update global scope
        $('#toggleAdjustmentSeries2Btn').hide();
        
        // Reload table to show only Series 1
        if ($.fn.DataTable.isDataTable('#adjustmentsTable')) {
            $('#adjustmentsTable').DataTable().ajax.reload();
        } else {
            initializeAdjustmentsTable();
        }
    });

    initializeAdjustmentsTable();
    loadActiveShift();

    // Load active shift when modal opens
    $('#addAdjustmentModal').on('show.bs.modal', function() {
        loadActiveShift();
    });
    
    $('#addAdjustmentForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate active shift exists
        let shiftId = $('#cashier_shift_id').val();
        if (!shiftId || shiftId === '') {
            error_toastify('No active shift found. Please open a cashier shift first.');
            return;
        }
        
        // Get clean numeric values (remove commas) before submitting
        let amountValue = getCleanNumericValue($('#amount').val());
        if (!amountValue || amountValue === '' || isNaN(amountValue) || parseFloat(amountValue) === 0) {
            error_toastify('Please enter a valid amount (positive or negative, but not zero).');
            return;
        }
        
        let formData = {
            cashier_shift_id: shiftId,
            adjustment_type: $('#adjustment_type').val(),
            amount: amountValue, // Clean numeric value without commas
            remarks: $('#remarks').val()
        };

        $.ajax({
            url: '<?= base_url("Cashier/Adjustment/create") ?>',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(res) {
                if(res.status) {
                    success_toastify(res.message);
                    $('#addAdjustmentModal').modal('hide');
                    $('#addAdjustmentForm')[0].reset();
                    // Reload active shift after form reset
                    loadActiveShift();
                    // Reload DataTable
                    if ($.fn.DataTable.isDataTable('#adjustmentsTable')) {
                        $('#adjustmentsTable').DataTable().ajax.reload();
                    }
                } else {
                    error_toastify(res.message || 'Failed to create adjustment');
                }
            },
            error: function() {
                error_toastify('Server error. Please try again.');
            }
        });
    });
});

// Removed loadShifts() function - shift is automatically set from active shift

function loadActiveShift() {
    $.ajax({
        url: '<?= base_url("Cashier/Shift/checkCashierShift") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if(res.status && res.shift && res.shift.id) {
                $('#cashier_shift_id').val(res.shift.id);
            } else {
                $('#cashier_shift_id').val('');
                if ($('#addAdjustmentModal').hasClass('show')) {
                    warning_toastify('No active shift found. Please open a cashier shift first.');
                }
            }
        },
        error: function() {
            $('#cashier_shift_id').val('');
            if ($('#addAdjustmentModal').hasClass('show')) {
                error_toastify('Failed to load active shift. Please try again.');
            }
        }
    });
}

function initializeAdjustmentsTable() {
    if ($.fn.DataTable.isDataTable('#adjustmentsTable')) {
        $('#adjustmentsTable').DataTable().destroy();
    }

    $('#adjustmentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= base_url("Cashier/Adjustment/datatable") ?>',
            type: 'POST',
            data: function(d) {
                // Include Series 2 (is_confirm = 0) only when showAdjustmentSeries2 is true
                // Access from window scope to ensure it's available in callback
                var showSeries2 = (typeof window.showAdjustmentSeries2 !== 'undefined' ? window.showAdjustmentSeries2 : (typeof showAdjustmentSeries2 !== 'undefined' ? showAdjustmentSeries2 : false));
                d.include_series2 = showSeries2 ? 1 : 0;
            },
            error: function(xhr, error, code) {
                console.error('DataTable error:', error, code);
                error_toastify('Failed to load adjustments. Please try again.');
            }
        },
        order: [[6, 'desc']],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
        columns: [
            { 
                data: 'code', 
                title: 'Code',
                className: 'text-center'
            },
            { 
                data: 'cashier_shift_id', 
                title: 'Shift ID',
                className: 'text-center'
            },
            { 
                data: 'adjustment_type', 
                title: 'Adjustment Type',
                className: 'text-center text-capitalize',
                render: function(d) {
                    return d.replace('_', ' ');
                }
            },
            { 
                data: 'amount', 
                title: 'Amount',
                className: 'text-right',
                render: function(d) {
                    return Number(d ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            { 
                data: 'remarks', 
                title: 'Remarks',
                defaultContent: '-'
            },
            { 
                data: 'created_by_user.name', 
                title: 'Created By',
                defaultContent: '-',
                render: function(data, type, row) {
                    return data || (row.created_by_user && row.created_by_user.name) || '-';
                }
            },
            { 
                data: 'created_at', 
                title: 'Created At',
                className: 'text-center'
            },
            { 
                data: null, 
                title: 'Action',
                className: 'text-center',
                orderable: false,
                render: function(row) {
                    let encoded = encodeURIComponent(JSON.stringify(row));
                    return `
                        <button class="btn btn-sm btn-primary" onclick="editAdjustment('${encoded}')" title="Edit Adjustment" data-toggle="tooltip" data-placement="top">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteAdjustment(${row.id})" title="Delete Adjustment" data-toggle="tooltip" data-placement="top">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                }
            }
        ]
    });
}

function editAdjustment(encodedRow) {
    let row = JSON.parse(decodeURIComponent(encodedRow));
    let html = `
        <input type="hidden" id="edit_adjustment_id" value="${row.id}">
        <div class="form-group">
            <label>Adjustment Type</label>
            <select class="form-control" id="edit_adjustment_type">
                <option value="invoice_void" ${row.adjustment_type === 'invoice_void' ? 'selected' : ''}>Invoice Void</option>
                <option value="correction" ${row.adjustment_type === 'correction' ? 'selected' : ''}>Correction</option>
                <option value="manual" ${row.adjustment_type === 'manual' ? 'selected' : ''}>Manual</option>
            </select>
        </div>
        <div class="form-group">
            <label>Amount</label>
            <input type="text" class="form-control price-input text-right" id="edit_amount" placeholder="0.00">
        </div>
        <div class="form-group">
            <label>Remarks</label>
            <textarea class="form-control" id="edit_remarks" rows="3">${row.remarks || ''}</textarea>
        </div>
    `;
    $('#editAdjustmentContent').html(html);
    $('#editAdjustmentModal').modal('show');
    
    // Set formatted amount value after modal is shown
    setTimeout(function() {
        let cleanAmount = getCleanNumericValue(row.amount);
        $('#edit_amount').val(formatPriceWithCommas(cleanAmount));
        // Re-initialize tooltips for dynamically added content
        $('[data-toggle="tooltip"]').tooltip();
    }, 100);
}

$('#editAdjustmentForm').on('submit', function(e) {
    e.preventDefault();
    let id = $('#edit_adjustment_id').val();
    
    // Get clean numeric values (remove commas) before submitting
    let amountValue = getCleanNumericValue($('#edit_amount').val());
    if (!amountValue || amountValue === '' || isNaN(amountValue) || parseFloat(amountValue) === 0) {
        error_toastify('Please enter a valid amount (positive or negative, but not zero).');
        return;
    }
    
    let formData = {
        adjustment_type: $('#edit_adjustment_type').val(),
        amount: amountValue, // Clean numeric value without commas
        remarks: $('#edit_remarks').val()
    };

    $.ajax({
        url: `<?= base_url("Cashier/Adjustment/update") ?>/${id}`,
        type: 'POST',
        dataType: 'json',
        data: formData,
        success: function(res) {
            if(res.status) {
                success_toastify(res.message);
                $('#editAdjustmentModal').modal('hide');
                // Reload DataTable
                if ($.fn.DataTable.isDataTable('#adjustmentsTable')) {
                    $('#adjustmentsTable').DataTable().ajax.reload();
                }
            } else {
                error_toastify(res.message || 'Failed to update adjustment');
            }
        }
    });
});

function deleteAdjustment(id) {
    if(confirm('Are you sure you want to delete this adjustment?')) {
        $.ajax({
            url: `<?= base_url("Cashier/Adjustment/delete") ?>/${id}`,
            type: 'POST',
            dataType: 'json',
            success: function(res) {
                if(res.status) {
                    success_toastify(res.message);
                    // Reload DataTable
                    if ($.fn.DataTable.isDataTable('#adjustmentsTable')) {
                        $('#adjustmentsTable').DataTable().ajax.reload();
                    }
                } else {
                    error_toastify(res.message || 'Failed to delete adjustment');
                }
            }
        });
    }
}
</script>
<?php include APPPATH . "views/include/footer.php"; ?>

