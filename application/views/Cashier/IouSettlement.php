<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include APPPATH . "views/include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-file-invoice-dollar mr-2"></i>IOU Settlements</h1>
                </div>
            </div>
            <div class="container-fluid mt-2">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-exclamation-triangle mr-2"></i>Outstanding IOUs</h5>
                        <button id="toggleOutstandingSeries2Btn" class="btn btn-warning btn-sm" style="display: none;" title="Hide Series 2" data-toggle="tooltip" data-placement="top">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="outstandingIousTable" class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Shift</th>
                                    <th>Payee</th>
                                    <th>Amount</th>
                                    <th>Remaining</th>
                                    <th>Payment Type</th>
                                    <th>Created At</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Settlements List</h5>
                        <div>
                            <button id="toggleSeries2Btn" class="btn btn-warning btn-sm mr-2" style="display: none;" title="Hide Series 2" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addSettlementModal" title="Add Settlement" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="settlementsTable" class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>IOU Movement</th>
                                    <th>Settlement Type</th>
                                    <th>Settlement Amount</th>
                                    <th>Settlement Date</th>
                                    <th>Reference ID</th>
                                    <th>Remarks</th>
                                    <th>Settled By</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <div class="modal fade" id="addSettlementModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form id="addSettlementForm">
                        <div class="modal-header">
                            <h5 class="modal-title">Add IOU Settlement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Hidden field for IOU Movement ID (set automatically when "Settle" button is clicked) -->
                            <input type="hidden" id="cash_movement_id" name="cash_movement_id" required>
                            <div class="form-group">
                                <label for="settlement_type">Settlement Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="settlement_type" name="settlement_type" required>
                                    <option value="">Select Type</option>
                                    <option value="cash_return">Cash Return</option>
                                    <option value="expense_claim">Expense Claim</option>
                                    <option value="payroll_deduction">Payroll Deduction</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="settlement_amount">Settlement Amount <span class="text-danger">*</span></label>
                                <input type="text" class="form-control price-input text-right" id="settlement_amount" name="settlement_amount" required placeholder="0.00">
                            </div>
                            <div class="form-group">
                                <label for="settlement_date">Settlement Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="settlement_date" name="settlement_date" required>
                            </div>
                            <div class="form-group">
                                <label for="reference_id">Reference ID</label>
                                <input type="number" class="form-control" id="reference_id" name="reference_id">
                            </div>
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" title="Cancel" data-toggle="tooltip" data-placement="top"><i class="fas fa-times"></i></button>
                            <button type="submit" class="btn btn-primary" title="Save Settlement" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editSettlementModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form id="editSettlementForm">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Settlement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="editSettlementContent">
                            <!-- Dynamic content -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" title="Cancel" data-toggle="tooltip" data-placement="top"><i class="fas fa-times"></i></button>
                            <button type="submit" class="btn btn-primary" title="Update Settlement" data-toggle="tooltip" data-placement="top"><i class="fas fa-save"></i></button>
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
// Background typing detection for "boom" secret code to show/hide Series 2 in DataTable
const SERIES_SECRET_CODE = 'boom';
var tableSeriesCodeBuffer = '';
var tableLastKeyTime = 0;
var showSeries2 = false; // Toggle to show both Series 1 and Series 2 in settlements table

// Outstanding IOUs table Series 2 toggle
var outstandingSeriesCodeBuffer = '';
var outstandingLastKeyTime = 0;
var showOutstandingSeries2 = false; // Toggle to show both Series 1 and Series 2 in outstanding IOUs table

// Global function to format number with thousand separators
function formatPriceWithCommas(value) {
    if (!value || value === '') return '';
    // Remove all commas and non-numeric characters except decimal point
    let numValue = value.toString().replace(/[^0-9.]/g, '');
    if (numValue === '' || numValue === '.') return '';
    
    // Split integer and decimal parts
    let parts = numValue.split('.');
    let integerPart = parts[0];
    let decimalPart = parts.length > 1 ? '.' + parts[1].substring(0, 2) : '';
    
    // Add thousand separators to integer part
    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    
    return integerPart + decimalPart;
}

// Global function to remove commas and get clean numeric value
function getCleanNumericValue(value) {
    if (!value || value === '') return '';
    // Remove all commas and return clean number
    return value.toString().replace(/,/g, '');
}

$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Re-initialize tooltips after DataTables are drawn
    $('#settlementsTable').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    $('#outstandingIousTable').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    
    // Format price inputs with thousand separators on input
    $(document).on("input blur", ".price-input", function() {
        let $input = $(this);
        let value = getCleanNumericValue($input.val());
        
        if (value !== '' && !isNaN(value) && parseFloat(value) >= 0) {
            let formatted = formatPriceWithCommas(value);
            $input.val(formatted);
        } else if (value === '') {
            $input.val('');
        }
    });
    
    // On focus, remove commas for easier editing
    $(document).on("focus", ".price-input", function() {
        let $input = $(this);
        let value = getCleanNumericValue($input.val());
        if (value !== '') {
            $input.val(value);
        }
    });
    $('#settlement_date').val(new Date().toISOString().split('T')[0]);
    
    // Background typing detection for "boom" secret code
    $(document).on('keypress', function(e) {
        // Ignore if typing in an input field or textarea
        if ($(e.target).is('input, textarea, select')) {
            return;
        }
        
        var now = Date.now();
        var keyChar = String.fromCharCode(e.which).toLowerCase();
        
        // Handle Settlements DataTable Series 2 toggle
        if (now - tableLastKeyTime > 2000) {
            tableSeriesCodeBuffer = '';
        }
        tableLastKeyTime = now;
        
        tableSeriesCodeBuffer += keyChar;
        if (tableSeriesCodeBuffer.length > SERIES_SECRET_CODE.length) {
            tableSeriesCodeBuffer = tableSeriesCodeBuffer.slice(-SERIES_SECRET_CODE.length);
        }
        
        if (tableSeriesCodeBuffer === SERIES_SECRET_CODE) {
            // Toggle Series 2 visibility in Settlements DataTable
            showSeries2 = !showSeries2;
            
            if (showSeries2) {
                $('#toggleSeries2Btn').show();
            } else {
                $('#toggleSeries2Btn').hide();
            }
            
            // Reload table with new filter
            if ($.fn.DataTable.isDataTable('#settlementsTable')) {
                $('#settlementsTable').DataTable().ajax.reload();
            } else {
                initializeSettlementsTable();
            }
            
            tableSeriesCodeBuffer = '';
            tableLastKeyTime = 0;
        }
        
        // Handle Outstanding IOUs DataTable Series 2 toggle (separate buffer)
        if (now - outstandingLastKeyTime > 2000) {
            outstandingSeriesCodeBuffer = '';
        }
        outstandingLastKeyTime = now;
        
        outstandingSeriesCodeBuffer += keyChar;
        if (outstandingSeriesCodeBuffer.length > SERIES_SECRET_CODE.length) {
            outstandingSeriesCodeBuffer = outstandingSeriesCodeBuffer.slice(-SERIES_SECRET_CODE.length);
        }
        
        if (outstandingSeriesCodeBuffer === SERIES_SECRET_CODE) {
            // Toggle Series 2 visibility in Outstanding IOUs DataTable
            showOutstandingSeries2 = !showOutstandingSeries2;
            
            if (showOutstandingSeries2) {
                $('#toggleOutstandingSeries2Btn').show();
            } else {
                $('#toggleOutstandingSeries2Btn').hide();
            }
            
            // Reload table with new filter
            if ($.fn.DataTable.isDataTable('#outstandingIousTable')) {
                $('#outstandingIousTable').DataTable().ajax.reload();
            } else {
                initializeOutstandingTable();
            }
            
            outstandingSeriesCodeBuffer = '';
            outstandingLastKeyTime = 0;
        }
    });
    
    // Toggle Series 2 button click handler for Settlements
    $('#toggleSeries2Btn').on('click', function() {
        showSeries2 = false;
        $('#toggleSeries2Btn').hide();
        
        // Reload table to show only Series 1
        if ($.fn.DataTable.isDataTable('#settlementsTable')) {
            $('#settlementsTable').DataTable().ajax.reload();
        } else {
            initializeSettlementsTable();
        }
    });
    
    // Toggle Series 2 button click handler for Outstanding IOUs
    $('#toggleOutstandingSeries2Btn').on('click', function() {
        showOutstandingSeries2 = false;
        $('#toggleOutstandingSeries2Btn').hide();
        
        // Reload table to show only Series 1
        if ($.fn.DataTable.isDataTable('#outstandingIousTable')) {
            $('#outstandingIousTable').DataTable().ajax.reload();
        } else {
            initializeOutstandingTable();
        }
    });
    
    initializeSettlementsTable();
    initializeOutstandingTable();

    $('#addSettlementForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate required fields
        let cashMovementId = $('#cash_movement_id').val();
        if (!cashMovementId || cashMovementId === '') {
            error_toastify('IOU Movement is required. Please click "Settle" button from Outstanding IOUs table.');
            return;
        }
        
        // Get clean numeric value (remove commas)
        let settlementAmount = getCleanNumericValue($('#settlement_amount').val());
        if (!settlementAmount || settlementAmount === '' || isNaN(settlementAmount) || parseFloat(settlementAmount) <= 0) {
            error_toastify('Please enter a valid settlement amount.');
            return;
        }
        
        let formData = {
            cash_movement_id: cashMovementId,
            settlement_type: $('#settlement_type').val(),
            settlement_amount: settlementAmount, // Clean numeric value without commas
            settlement_date: $('#settlement_date').val(),
            reference_id: $('#reference_id').val() || null,
            remarks: $('#remarks').val()
        };

        $.ajax({
            url: '<?= base_url("Cashier/IouSettlement/createSettlement") ?>',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(res) {
                if(res.status) {
                    success_toastify(res.message);
                    $('#addSettlementModal').modal('hide');
                    $('#addSettlementForm')[0].reset();
                    // Clear hidden cash_movement_id and settlement_amount
                    $('#cash_movement_id').val('');
                    $('#settlement_amount').val('');
                    $('#settlement_date').val(new Date().toISOString().split('T')[0]);
                    
                    // If settlement type is expense_claim, redirect to cash movement view with pre-filled values
                    if (formData.settlement_type === 'expense_claim' && res.data) {
                        let settlementData = res.data;
                        // res.data is the settlement object itself, with cash_movement relationship loaded
                        let cashMovement = settlementData.cash_movement || {};
                        
                        // Get payee_code and payee_name from the original IOU cash movement
                        let payeeCode = cashMovement.payee_code || '';
                        let payeeName = cashMovement.payee_name || '';
                        
                        // Get the settlement ID, code, and original IOU code
                        // settlementData is the settlement object itself
                        let settlementId = settlementData.id || '';
                        let settlementCode = settlementData.code || '';
                        let originalIouCode = cashMovement.code || '';
                        
                        // Get series from the original IOU cash movement
                        let series = cashMovement.is_confirm || '';
                        
                        // Build remarks text
                        let remarks = 'IOU Expense Claim Settlement - Settlement: ' + settlementCode + ', Original IOU: ' + originalIouCode;
                        
                        console.log('IOU Settlement Redirect Data:', {
                            settlementData: settlementData,
                            payeeCode: payeeCode,
                            payeeName: payeeName,
                            settlementId: settlementId,
                            settlementCode: settlementCode,
                            originalIouCode: originalIouCode,
                            series: series
                        });
                        
                        // Build URL with parameters
                        let cashMovementUrl = '<?= base_url("Cashier/CashMovement") ?>';
                        let params = new URLSearchParams();
                        params.append('movement_type', 'cash_out');
                        params.append('source', 'petty');
                        if (payeeCode && payeeCode.trim() !== '') {
                            params.append('payee_code', payeeCode.trim());
                        }
                        if (payeeName && payeeName.trim() !== '') {
                            params.append('payee_name', payeeName.trim());
                        }
                        // Always pass settlement_id if available (required for linking petty cash to settlement)
                        if (settlementId) {
                            params.append('settlement_id', settlementId);
                        }
                        if (remarks) {
                            params.append('remarks', remarks);
                        }
                        if (series !== null && series !== undefined && series !== '') {
                            params.append('series', series);
                        }
                        
                        // Redirect to cash movement view with parameters
                        window.location.href = cashMovementUrl + '?' + params.toString();
                        return; // Don't reload tables since we're redirecting
                    }
                    
                    if ($.fn.DataTable.isDataTable('#settlementsTable')) {
                        $('#settlementsTable').DataTable().ajax.reload();
                    }
                    if ($.fn.DataTable.isDataTable('#outstandingIousTable')) {
                        $('#outstandingIousTable').DataTable().ajax.reload();
                    }
                } else {
                    // Display detailed error message with blockers and warnings
                    let errorMsg = res.message || 'Failed to create settlement';
                    
                    // Check for blockers (critical issues that prevent the operation)
                    if (res.blockers && Array.isArray(res.blockers) && res.blockers.length > 0) {
                        errorMsg += '\n\nBlocking Issues:';
                        res.blockers.forEach(function(blocker, index) {
                            errorMsg += '\n' + (index + 1) + '. ' + blocker;
                        });
                    }
                    
                    // Check for warnings (non-critical issues)
                    if (res.warnings && Array.isArray(res.warnings) && res.warnings.length > 0) {
                        errorMsg += '\n\nWarnings:';
                        res.warnings.forEach(function(warning, index) {
                            errorMsg += '\n' + (index + 1) + '. ' + warning;
                        });
                    }
                    
                    // Display error in alert for better visibility of detailed messages
                    if ((res.blockers && res.blockers.length > 0) || (res.warnings && res.warnings.length > 0)) {
                        alert(errorMsg);
                    } else {
                        error_toastify(errorMsg);
                    }
                }
            },
            error: function(xhr) {
                let errorMsg = 'Server error. Please try again.';
                
                // Try to parse error response
                if (xhr.responseJSON) {
                    let res = xhr.responseJSON;
                    errorMsg = res.message || errorMsg;
                    
                    // Check for blockers
                    if (res.blockers && Array.isArray(res.blockers) && res.blockers.length > 0) {
                        errorMsg += '\n\nBlocking Issues:';
                        res.blockers.forEach(function(blocker, index) {
                            errorMsg += '\n' + (index + 1) + '. ' + blocker;
                        });
                    }
                    
                    // Check for warnings
                    if (res.warnings && Array.isArray(res.warnings) && res.warnings.length > 0) {
                        errorMsg += '\n\nWarnings:';
                        res.warnings.forEach(function(warning, index) {
                            errorMsg += '\n' + (index + 1) + '. ' + warning;
                        });
                    }
                    
                    // Display in alert if there are blockers or warnings, otherwise use toast
                    if ((res.blockers && res.blockers.length > 0) || (res.warnings && res.warnings.length > 0)) {
                        alert(errorMsg);
                    } else {
                        error_toastify(errorMsg);
                    }
                } else {
                    error_toastify(errorMsg);
                }
            }
        });
    });
});

// Initialize DataTable with server-side processing
function initializeSettlementsTable() {
    if ($.fn.DataTable.isDataTable('#settlementsTable')) {
        $('#settlementsTable').DataTable().destroy();
    }

    $('#settlementsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= base_url("Cashier/IouSettlement/datatable") ?>',
            type: 'POST',
            data: function(d) {
                // Include Series 2 (is_confirm = 0) only when showSeries2 is true
                d.include_series2 = showSeries2 ? 1 : 0;
            },
            error: function(xhr, error, code) {
                console.error('DataTable error:', error, code);
                error_toastify('Failed to load settlements. Please try again.');
            }
        },
        order: [[8, 'desc']], // Order by Created At descending
        columns: [
            { 
                data: 'code', 
                title: 'Code',
                className: 'text-center'
            },
            { 
                data: 'cash_movement', 
                title: 'IOU Movement',
                className: 'text-center',
                render: function(data, type, row) {
                    if (data && data.code) {
                        return `<span class="badge badge-info">${data.code}</span><br><small>${data.payee_name || '-'}</small>`;
                    }
                    return row.cash_movement_id || '-';
                }
            },
            { 
                data: 'settlement_type', 
                title: 'Settlement Type',
                className: 'text-center text-capitalize',
                render: function(d) {
                    return d ? d.replace(/_/g, ' ') : '-';
                }
            },
            { 
                data: 'settlement_amount', 
                title: 'Settlement Amount',
                className: 'text-right',
                render: function(d) {
                    return d ? Number(d).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0.00';
                }
            },
            { 
                data: 'settlement_date', 
                title: 'Settlement Date',
                className: 'text-center',
                render: function(d) {
                    if (!d) return '-';
                    // Handle ISO date format (e.g., "2025-12-20T18:30:00.000000Z")
                    try {
                        let date = new Date(d);
                        if (isNaN(date.getTime())) {
                            return d; // Return as-is if not a valid date
                        }
                        return date.toLocaleString();
                    } catch(e) {
                        return d;
                    }
                }
            },
            { 
                data: 'reference_id', 
                title: 'Reference ID',
                className: 'text-center',
                defaultContent: '-'
            },
            { 
                data: 'remarks', 
                title: 'Remarks',
                defaultContent: '-'
            },
            { 
                data: 'settled_by_user', 
                title: 'Settled By',
                className: 'text-center',
                render: function(data) {
                    return data && data.name ? data.name : '-';
                },
                defaultContent: '-'
            },
            { 
                data: 'created_at', 
                title: 'Created At',
                className: 'text-center',
                render: function(d) {
                    if (!d) return '-';
                    // Handle ISO date format (e.g., "2025-12-21T03:19:52.000000Z")
                    try {
                        let date = new Date(d);
                        if (isNaN(date.getTime())) {
                            return d; // Return as-is if not a valid date
                        }
                        return date.toLocaleString();
                    } catch(e) {
                        return d;
                    }
                }
            },
            { 
                data: null, 
                title: 'Action',
                className: 'text-center',
                orderable: false,
                render: function(data, type, row) {
                    // Reserved for future use
                    // let encoded = encodeURIComponent(JSON.stringify(row));
                    // return `
                    //     <button class="btn btn-sm btn-primary" onclick="editSettlement('${encoded}')" title="Edit Settlement" data-toggle="tooltip" data-placement="top">
                    //         <i class="fas fa-edit"></i>
                    //     </button>
                    //     <button class="btn btn-sm btn-danger" onclick="deleteSettlement(${row.id})" title="Delete Settlement" data-toggle="tooltip" data-placement="top">
                    //         <i class="fas fa-trash"></i>
                    //     </button>
                    // `;
                    return '-';
                }
            }
        ]
    });
}

// Initialize Outstanding IOUs DataTable with server-side processing
function initializeOutstandingTable() {
    if ($.fn.DataTable.isDataTable('#outstandingIousTable')) {
        $('#outstandingIousTable').DataTable().destroy();
    }

    $('#outstandingIousTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= base_url("Cashier/IouSettlement/outstandingIousDatatable") ?>',
            type: 'POST',
            data: function(d) {
                // Include Series 2 (is_confirm = 0) only when showOutstandingSeries2 is true
                d.include_series2 = showOutstandingSeries2 ? 1 : 0;
            },
            error: function(xhr, error, code) {
                console.error('DataTable error:', error, code);
                error_toastify('Failed to load outstanding IOUs. Please try again.');
            }
        },
        order: [[6, 'desc']], // Order by Created At descending
        columns: [
            { 
                data: 'code', 
                title: 'Code',
                className: 'text-center'
            },
            { 
                data: 'shift_code', 
                title: 'Shift',
                className: 'text-center',
                render: function(data, type, row) {
                    return `<span class="badge badge-info">${data || row.cashier_shift_id || '-'}</span>`;
                }
            },
            { 
                data: 'payee_name', 
                title: 'Payee',
                render: function(data, type, row) {
                    return data || row.payee_code || '-';
                }
            },
            { 
                data: 'amount', 
                title: 'Amount',
                className: 'text-right',
                render: function(d) {
                    return d ? Number(d).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0.00';
                }
            },
            { 
                data: 'remaining_amount', 
                title: 'Remaining',
                className: 'text-right',
                render: function(d) {
                    let remaining = d || 0;
                    let badgeClass = remaining > 0 ? 'warning' : 'success';
                    return `<span class="badge badge-${badgeClass}">${Number(remaining).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>`;
                }
            },
            { 
                data: 'payment_type', 
                title: 'Payment Type',
                className: 'text-center text-capitalize'
            },
            { 
                data: 'created_at', 
                title: 'Created At',
                className: 'text-center',
                render: function(d) {
                    if (!d) return '-';
                    // Handle ISO date format (e.g., "2025-12-21T03:19:52.000000Z")
                    try {
                        let date = new Date(d);
                        if (isNaN(date.getTime())) {
                            return d; // Return as-is if not a valid date
                        }
                        return date.toLocaleString();
                    } catch(e) {
                        return d;
                    }
                }
            },
            { 
                data: 'remarks', 
                title: 'Remarks',
                defaultContent: '-'
            },
            { 
                data: null, 
                title: 'Action',
                className: 'text-center',
                orderable: false,
                render: function(data, type, row) {
                    // Pass both movement ID and amount to settleIou function
                    return `
                        <button class="btn btn-sm btn-success" onclick="settleIou(${row.id}, ${row.amount || 0})" title="Settle IOU" data-toggle="tooltip" data-placement="top">
                            <i class="fas fa-check"></i>
                        </button>
                    `;
                }
            }
        ]
    });
}

function editSettlement(encodedRow) {
    let row = JSON.parse(decodeURIComponent(encodedRow));
    let html = `
        <input type="hidden" id="edit_settlement_id" value="${row.id}">
        <div class="form-group">
            <label>Settlement Type</label>
            <select class="form-control" id="edit_settlement_type">
                <option value="cash_return" ${row.settlement_type === 'cash_return' ? 'selected' : ''}>Cash Return</option>
                <option value="expense_claim" ${row.settlement_type === 'expense_claim' ? 'selected' : ''}>Expense Claim</option>
                <option value="payroll_deduction" ${row.settlement_type === 'payroll_deduction' ? 'selected' : ''}>Payroll Deduction</option>
            </select>
        </div>
        <div class="form-group">
            <label>Settlement Amount</label>
            <input type="text" class="form-control price-input text-right" id="edit_settlement_amount" placeholder="0.00">
        </div>
        <div class="form-group">
            <label>Settlement Date</label>
            <input type="date" class="form-control" id="edit_settlement_date" value="${row.settlement_date}">
        </div>
        <div class="form-group">
            <label>Reference ID</label>
            <input type="number" class="form-control" id="edit_reference_id" value="${row.reference_id || ''}">
        </div>
        <div class="form-group">
            <label>Remarks</label>
            <textarea class="form-control" id="edit_remarks" rows="3">${row.remarks || ''}</textarea>
        </div>
    `;
    $('#editSettlementContent').html(html);
    $('#editSettlementModal').modal('show');
    
    // Set formatted amount value after modal is shown
    setTimeout(function() {
        let cleanAmount = getCleanNumericValue(row.settlement_amount);
        $('#edit_settlement_amount').val(formatPriceWithCommas(cleanAmount));
    }, 100);
}

$('#editSettlementForm').on('submit', function(e) {
    e.preventDefault();
    let id = $('#edit_settlement_id').val();
    // Get clean numeric values (remove commas) before submitting
    let settlementAmount = getCleanNumericValue($('#edit_settlement_amount').val());
    if (!settlementAmount || settlementAmount === '' || isNaN(settlementAmount) || parseFloat(settlementAmount) <= 0) {
        error_toastify('Please enter a valid settlement amount.');
        return;
    }
    
    let formData = {
        settlement_type: $('#edit_settlement_type').val(),
        settlement_amount: settlementAmount, // Clean numeric value without commas
        settlement_date: $('#edit_settlement_date').val(),
        reference_id: $('#edit_reference_id').val() || null,
        remarks: $('#edit_remarks').val()
    };

    $.ajax({
        url: `<?= base_url("Cashier/IouSettlement/updateSettlement") ?>/${id}`,
        type: 'POST',
        dataType: 'json',
        data: formData,
        success: function(res) {
            if(res.status) {
                success_toastify(res.message);
                $('#editSettlementModal').modal('hide');
                if ($.fn.DataTable.isDataTable('#settlementsTable')) {
                    $('#settlementsTable').DataTable().ajax.reload();
                }
            } else {
                error_toastify(res.message || 'Failed to update settlement');
            }
        }
    });
});

function deleteSettlement(id) {
    if(confirm('Are you sure you want to delete this settlement?')) {
        $.ajax({
            url: `<?= base_url("Cashier/IouSettlement/deleteSettlement") ?>/${id}`,
            type: 'POST',
            dataType: 'json',
            success: function(res) {
                if(res.status) {
                    success_toastify(res.message);
                    if ($.fn.DataTable.isDataTable('#settlementsTable')) {
                        $('#settlementsTable').DataTable().ajax.reload();
                    }
                    if ($.fn.DataTable.isDataTable('#outstandingIousTable')) {
                        $('#outstandingIousTable').DataTable().ajax.reload();
                    }
                } else {
                    // Display detailed error message with blockers and warnings
                    let errorMsg = res.message || 'Failed to delete settlement';
                    
                    if (res.blockers && Array.isArray(res.blockers) && res.blockers.length > 0) {
                        errorMsg += '\n\nBlocking Issues:';
                        res.blockers.forEach(function(blocker, index) {
                            errorMsg += '\n' + (index + 1) + '. ' + blocker;
                        });
                    }
                    
                    if (res.warnings && Array.isArray(res.warnings) && res.warnings.length > 0) {
                        errorMsg += '\n\nWarnings:';
                        res.warnings.forEach(function(warning, index) {
                            errorMsg += '\n' + (index + 1) + '. ' + warning;
                        });
                    }
                    
                    if ((res.blockers && res.blockers.length > 0) || (res.warnings && res.warnings.length > 0)) {
                        alert(errorMsg);
                    } else {
                        error_toastify(errorMsg);
                    }
                }
            },
            error: function(xhr) {
                let errorMsg = 'Server error. Please try again.';
                
                if (xhr.responseJSON) {
                    let res = xhr.responseJSON;
                    errorMsg = res.message || errorMsg;
                    
                    if (res.blockers && Array.isArray(res.blockers) && res.blockers.length > 0) {
                        errorMsg += '\n\nBlocking Issues:';
                        res.blockers.forEach(function(blocker, index) {
                            errorMsg += '\n' + (index + 1) + '. ' + blocker;
                        });
                    }
                    
                    if (res.warnings && Array.isArray(res.warnings) && res.warnings.length > 0) {
                        errorMsg += '\n\nWarnings:';
                        res.warnings.forEach(function(warning, index) {
                            errorMsg += '\n' + (index + 1) + '. ' + warning;
                        });
                    }
                    
                    if ((res.blockers && res.blockers.length > 0) || (res.warnings && res.warnings.length > 0)) {
                        alert(errorMsg);
                    } else {
                        error_toastify(errorMsg);
                    }
                } else {
                    error_toastify(errorMsg);
                }
            }
        });
    }
}

function settleIou(movementId, amount) {
    // Set the hidden cash_movement_id field
    $('#cash_movement_id').val(movementId);
    
    // Auto-fill settlement amount if provided
    if (amount && amount > 0) {
        $('#settlement_amount').val(formatPriceWithCommas(amount));
    } else {
        // If amount not provided or invalid, fetch it from the movement
        $.ajax({
            url: `<?= base_url("Cashier/CashMovement/getCashMovementById") ?>/${movementId}`,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if(res.status && res.data && res.data.amount) {
                    $('#settlement_amount').val(formatPriceWithCommas(res.data.amount));
                }
            },
            error: function() {
                error_toastify('Failed to load movement details. Please enter amount manually.');
            }
        });
    }
    
    // Open the modal
    $('#addSettlementModal').modal('show');
}
</script>
<?php include APPPATH . "views/include/footer.php"; ?>

