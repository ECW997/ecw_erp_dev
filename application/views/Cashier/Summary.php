<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include APPPATH . "views/include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-calendar-check mr-2"></i>Cashier Shift Summary</h1>
                </div>
            </div>

            <div class="container-fluid mt-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Shift Summaries</h5>
                        <button type="button" id="toggleSummarySeries2Btn" class="btn btn-warning btn-sm" style="display: none;" title="Hide Series 2" data-toggle="tooltip" data-placement="top">
                            <i class="fas fa-eye-slash"></i> Hide Series 2
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="shiftSummaryTable" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Cashier</th>
                                    <th>Shift ID</th>
                                    <th>Total Invoices</th>
                                    <th>Total Sales</th>
                                    <th>Cash</th>
                                    <th>Card</th>
                                    <th>Cheque</th>
                                    <th>Online</th>
                                    <th>Other</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <div class="modal fade" id="shiftSummaryModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Shift Summary Details</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="shiftSummaryContent">
                        <div class="text-center"><div class="spinner-grow text-primary" role="status"></div></div>
                    </div>
                </div>
                </div>
            </div>
        </div>

        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>
<?php include APPPATH . "views/include/footerscripts.php"; ?>
<script>
// Background typing detection for "boom" secret code to show/hide Series 2
const SERIES_SECRET_CODE = 'boom';
var summarySeriesCodeBuffer = '';
var summaryLastKeyTime = 0;
var showSummarySeries2 = false; // Toggle to show both Series 1 and Series 2

// Initialize tooltips
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    
    // Re-initialize tooltips after DataTable is drawn
    $('#shiftSummaryTable').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Background typing detection for "boom" secret code
    $(document).on('keypress', function(e) {
        // Ignore if typing in an input field or textarea
        if ($(e.target).is('input, textarea, select')) {
            return;
        }
        
        var now = Date.now();
        var keyChar = String.fromCharCode(e.which).toLowerCase();
        
        // Handle Summary DataTable Series 2 toggle
        if (now - summaryLastKeyTime > 2000) {
            summarySeriesCodeBuffer = '';
        }
        summaryLastKeyTime = now;
        
        summarySeriesCodeBuffer += keyChar;
        if (summarySeriesCodeBuffer.length > SERIES_SECRET_CODE.length) {
            summarySeriesCodeBuffer = summarySeriesCodeBuffer.slice(-SERIES_SECRET_CODE.length);
        }
        
        if (summarySeriesCodeBuffer === SERIES_SECRET_CODE) {
            // Toggle Series 2 visibility in Summary DataTable
            showSummarySeries2 = !showSummarySeries2;
            
            if (showSummarySeries2) {
                $('#toggleSummarySeries2Btn').show();
            } else {
                $('#toggleSummarySeries2Btn').hide();
            }
            
            // Reload table with new filter
            if ($.fn.DataTable.isDataTable('#shiftSummaryTable')) {
                $('#shiftSummaryTable').DataTable().ajax.reload();
            } else {
                initializeSummaryTable();
            }
            
            summarySeriesCodeBuffer = '';
            summaryLastKeyTime = 0;
        }
    });

    // Toggle Series 2 button click handler
    $('#toggleSummarySeries2Btn').on('click', function() {
        showSummarySeries2 = false;
        $('#toggleSummarySeries2Btn').hide();
        
        // Reload table to show only Series 1
        if ($.fn.DataTable.isDataTable('#shiftSummaryTable')) {
            $('#shiftSummaryTable').DataTable().ajax.reload();
        } else {
            initializeSummaryTable();
        }
    });

    // Initial load
    initializeSummaryTable();
});

function initializeSummaryTable() {
    if ($.fn.DataTable.isDataTable('#shiftSummaryTable')) {
        $('#shiftSummaryTable').DataTable().destroy();
    }

    $('#shiftSummaryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= base_url("Cashier/Summary/datatable") ?>',
            type: 'POST',
            data: function(d) {
                // Include Series 2 (is_confirm = 0) only when showSummarySeries2 is true
                d.include_series2 = showSummarySeries2 ? 1 : 0;
            },
            error: function(xhr, error, code) {
                console.error('DataTable error:', error, code);
                error_toastify('Failed to load shift summaries. Please try again.');
            }
        },
        order: [[2, 'desc']],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
        columns: [
            { 
                data: 'code', 
                title: 'Code', 
                className: 'text-center'
            },
            { 
                data: 'shift.cashier.name', 
                title: 'Cashier', 
                defaultContent: '-', 
                className: 'text-center',
                render: function(data, type, row) {
                    return data || (row.shift && row.shift.cashier && row.shift.cashier.name) || '-';
                }
            },
            { 
                data: 'cashier_shift_id', 
                title: 'Shift ID', 
                className: 'text-center' 
            },
            { 
                data: 'total_invoices', 
                title: 'Total Invoices', 
                className: 'text-center' 
            },
            { 
                data: 'total_sales', 
                title: 'Total Sales', 
                className: 'text-right', 
                render: d => formatMoney(d)
            },
            { data: 'cash_total', className: 'text-right', render: formatMoney },
            { data: 'card_total', className: 'text-right', render: formatMoney },
            { data: 'cheque_total', className: 'text-right', render: formatMoney },
            { data: 'online_total', className: 'text-right', render: formatMoney },
            { data: 'other_total', className: 'text-right', render: formatMoney },
            { 
                data: 'locked', 
                title: 'Status',
                className: 'text-center',
                render: d => d == 1 
                    ? `<span class="badge badge-success">Locked</span>` 
                    : `<span class="badge badge-warning">Open</span>`
            },
            { 
                data: null, 
                title: 'Action',
                className: 'text-center',
                orderable: false,
                render: function(row) {
                    let encoded = encodeURIComponent(JSON.stringify(row));
                    return `<button class="btn btn-primary btn-sm" onclick="viewShiftSummary('${encoded}')" title="View Summary" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-eye"></i>
                            </button>`;
                }
            }
        ]
    });
}

function formatMoney(d){
    return Number(d ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function viewShiftSummary(encodedRow){
    let row = JSON.parse(decodeURIComponent(encodedRow));
    let shiftId = row.cashier_shift_id;
    let cashierName = row.shift?.cashier?.name ?? `Cashier ID: ${row.shift?.cashier_id ?? '-'}`;
    let openedAt = row.shift?.opened_at ?? '-';
    let closedAt = row.shift?.closed_at ?? '-';
    let shiftStatus = row.shift?.status ?? '-';
    
    // Show loading state
    $('#shiftSummaryContent').html('<div class="text-center"><div class="spinner-grow text-primary" role="status"></div></div>');
    $('#shiftSummaryModal').modal('show');
    
    // Build basic summary HTML
    let basicSummaryHtml = `
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="fas fa-info-circle"></i> Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered mb-0">
                            <tr><th>Cashier</th><td>${cashierName}</td></tr>
                            <tr><th>Shift ID</th><td>${row.cashier_shift_id}</td></tr>
                            <tr><th>Shift Opened At</th><td>${openedAt}</td></tr>
                            <tr><th>Shift Closed At</th><td>${closedAt}</td></tr>
                            <tr><th>Shift Status</th><td>${shiftStatus}</td></tr>
                            <tr><th>Status</th><td>${row.locked == 1 ? '<span class="badge badge-success">Locked</span>' : '<span class="badge badge-warning">Open</span>'}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-chart-line"></i> Sales Summary</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered mb-0">
                            <tr><th>Total Invoices</th><td>${row.total_invoices}</td></tr>
                            <tr><th>Total Sales</th><td class="text-right"><strong>${formatMoney(row.total_sales)}</strong></td></tr>
                            <tr><th>Cash</th><td class="text-right">${formatMoney(row.cash_total)}</td></tr>
                            <tr><th>Card</th><td class="text-right">${formatMoney(row.card_total)}</td></tr>
                            <tr><th>Cheque</th><td class="text-right">${formatMoney(row.cheque_total)}</td></tr>
                            <tr><th>Online</th><td class="text-right">${formatMoney(row.online_total)}</td></tr>
                            <tr><th>Other</th><td class="text-right">${formatMoney(row.other_total)}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="cashBookSummarySection" class="mt-3">
            <div class="text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading Cash Book Summary...</div>
        </div>
    `;
    
    $('#shiftSummaryContent').html(basicSummaryHtml);
    
    // Load cash book summary
    loadCashBookSummary(shiftId);
}

function loadCashBookSummary(shiftId) {
    $.ajax({
        url: '<?= base_url("Cashier/Summary/getCashBookSummary") ?>/' + shiftId,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status && response.data) {
                displayCashBookSummary(response.data);
            } else {
                // If summary not found, try to get calculated summary
                loadCalculatedSummary(shiftId);
            }
        },
        error: function(xhr, status, error) {
            // If 404, try calculated summary instead
            if (xhr.status === 404) {
                loadCalculatedSummary(shiftId);
            } else {
                $('#cashBookSummarySection').html(`
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Unable to load cash book summary. 
                        <button class="btn btn-sm btn-primary ml-2" onclick="loadCalculatedSummary(${shiftId})">
                            <i class="fas fa-calculator"></i> Calculate Summary
                        </button>
                    </div>
                `);
            }
        }
    });
}

function loadCalculatedSummary(shiftId) {
    $.ajax({
        url: '<?= base_url("Cashier/Summary/getCalculatedSummary") ?>/' + shiftId,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status && response.data) {
                displayCashBookSummary(response.data, true);
            } else {
                $('#cashBookSummarySection').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> Failed to calculate cash book summary: ${response.message || 'Unknown error'}
                    </div>
                `);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error calculating summary:', xhr, status, error);
            let errorMsg = 'Unknown error';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            } else if (xhr.status === 404) {
                errorMsg = 'Summary calculation endpoint not found. Please ensure the shift is closed.';
            } else if (xhr.status === 500) {
                errorMsg = 'Server error occurred while calculating summary.';
            }
            $('#cashBookSummarySection').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-times-circle"></i> Error calculating summary: ${errorMsg}
                    <br><small>HTTP Status: ${xhr.status}</small>
                </div>
            `);
        }
    });
}

function displayCashBookSummary(data, isCalculated = false) {
    let cashBook = data.cash_book_summary || data;
    let seriesBreakdown = data.series_breakdown || null;
    
    let varianceClass = '';
    let varianceIcon = '';
    if (cashBook.variance !== null && cashBook.variance !== undefined) {
        if (cashBook.variance > 0) {
            varianceClass = 'text-success';
            varianceIcon = '<i class="fas fa-arrow-up"></i>';
        } else if (cashBook.variance < 0) {
            varianceClass = 'text-danger';
            varianceIcon = '<i class="fas fa-arrow-down"></i>';
        } else {
            varianceClass = 'text-info';
            varianceIcon = '<i class="fas fa-equals"></i>';
        }
    }
    
    let calculatedBadge = isCalculated ? '<span class="badge badge-warning ml-2">Calculated (Not Saved)</span>' : '<span class="badge badge-success ml-2">Saved</span>';
    
    let cashBookHtml = `
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-book"></i> Cash Book Summary (Combined Series 1 + Series 2) ${calculatedBadge}</h6>
                ${isCalculated ? `<button class="btn btn-sm btn-light" onclick="saveCashBookSummary(${cashBook.cashier_shift_id || data.shift_id})">
                    <i class="fas fa-save"></i> Save Summary
                </button>` : ''}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Opening & Receipts</h6>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th>Opening Balance (Cash)</th>
                                <td class="text-right"><strong>${formatMoney(cashBook.opening_balance || cashBook.opening_balance_cash)}</strong></td>
                            </tr>
                            <tr class="table-info">
                                <th><i class="fas fa-arrow-down text-success"></i> Transaction Ledger Cash In</th>
                                <td class="text-right"><strong class="text-success">${formatMoney(cashBook.transaction_ledger_cash_in)}</strong></td>
                            </tr>
                            <tr class="table-info">
                                <th><i class="fas fa-arrow-down text-success"></i> Cash Movement Cash In</th>
                                <td class="text-right"><strong class="text-success">${formatMoney(cashBook.cash_movement_cash_in)}</strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Payments & Adjustments</h6>
                        <table class="table table-sm table-bordered">
                            <tr class="table-danger">
                                <th><i class="fas fa-arrow-up text-danger"></i> Transaction Ledger Cash Out</th>
                                <td class="text-right"><strong class="text-danger">${formatMoney(cashBook.transaction_ledger_cash_out)}</strong></td>
                            </tr>
                            <tr class="table-danger">
                                <th><i class="fas fa-arrow-up text-danger"></i> Cash Movement Cash Out</th>
                                <td class="text-right"><strong class="text-danger">${formatMoney(cashBook.cash_movement_cash_out)}</strong></td>
                            </tr>
                            <tr>
                                <th>Adjustments</th>
                                <td class="text-right"><strong>${formatMoney(cashBook.adjustments)}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h6 class="border-bottom pb-2">Balance Summary</h6>
                        <table class="table table-sm table-bordered">
                            <tr class="table-primary">
                                <th>Expected Closing Balance</th>
                                <td class="text-right"><strong>${formatMoney(cashBook.expected_cash)}</strong></td>
                            </tr>
                            <tr>
                                <th>Actual Cash</th>
                                <td class="text-right"><strong>${cashBook.actual_cash !== null && cashBook.actual_cash !== undefined ? formatMoney(cashBook.actual_cash) : '<span class="text-muted">Not Set</span>'}</strong></td>
                            </tr>
                            <tr class="${varianceClass}">
                                <th>Variance</th>
                                <td class="text-right"><strong>${varianceIcon} ${cashBook.variance !== null && cashBook.variance !== undefined ? formatMoney(Math.abs(cashBook.variance)) : '<span class="text-muted">N/A</span>'}</strong></td>
                            </tr>
                            <tr class="table-success">
                                <th><strong>Closing Balance</strong></th>
                                <td class="text-right"><strong>${formatMoney(cashBook.closing_balance || (cashBook.actual_cash !== null ? cashBook.actual_cash : cashBook.expected_cash))}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                ${seriesBreakdown ? `
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h6 class="border-bottom pb-2"><i class="fas fa-chart-pie"></i> Series Breakdown (For Reference)</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th rowspan="2">Series</th>
                                        <th colspan="2" class="text-center">Transaction Ledger</th>
                                        <th colspan="2" class="text-center">Cash Movement</th>
                                        <th colspan="2" class="text-center">Total</th>
                                        <th rowspan="2" class="text-right">Net</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Cash In</th>
                                        <th class="text-right">Cash Out</th>
                                        <th class="text-right">Cash In</th>
                                        <th class="text-right">Cash Out</th>
                                        <th class="text-right">Cash In</th>
                                        <th class="text-right">Cash Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Series 1</strong></td>
                                        <td class="text-right">${formatMoney(seriesBreakdown.series_1?.transaction_ledger_cash_in || 0)}</td>
                                        <td class="text-right">${formatMoney(seriesBreakdown.series_1?.transaction_ledger_cash_out || 0)}</td>
                                        <td class="text-right">${formatMoney(seriesBreakdown.series_1?.cash_movement_cash_in || 0)}</td>
                                        <td class="text-right">${formatMoney(seriesBreakdown.series_1?.cash_movement_cash_out || 0)}</td>
                                        <td class="text-right"><strong>${formatMoney(seriesBreakdown.series_1?.total_cash_in || 0)}</strong></td>
                                        <td class="text-right"><strong>${formatMoney(seriesBreakdown.series_1?.total_cash_out || 0)}</strong></td>
                                        <td class="text-right ${(seriesBreakdown.series_1?.net || 0) >= 0 ? 'text-success' : 'text-danger'}">
                                            <strong>${formatMoney(seriesBreakdown.series_1?.net || 0)}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Series 2</strong></td>
                                        <td class="text-right">${formatMoney(seriesBreakdown.series_2?.transaction_ledger_cash_in || 0)}</td>
                                        <td class="text-right">${formatMoney(seriesBreakdown.series_2?.transaction_ledger_cash_out || 0)}</td>
                                        <td class="text-right">${formatMoney(seriesBreakdown.series_2?.cash_movement_cash_in || 0)}</td>
                                        <td class="text-right">${formatMoney(seriesBreakdown.series_2?.cash_movement_cash_out || 0)}</td>
                                        <td class="text-right"><strong>${formatMoney(seriesBreakdown.series_2?.total_cash_in || 0)}</strong></td>
                                        <td class="text-right"><strong>${formatMoney(seriesBreakdown.series_2?.total_cash_out || 0)}</strong></td>
                                        <td class="text-right ${(seriesBreakdown.series_2?.net || 0) >= 0 ? 'text-success' : 'text-danger'}">
                                            <strong>${formatMoney(seriesBreakdown.series_2?.net || 0)}</strong>
                                        </td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td><strong>Total (Series 1 + Series 2)</strong></td>
                                        <td class="text-right"><strong>${formatMoney(seriesBreakdown.total?.transaction_ledger_cash_in || 0)}</strong></td>
                                        <td class="text-right"><strong>${formatMoney(seriesBreakdown.total?.transaction_ledger_cash_out || 0)}</strong></td>
                                        <td class="text-right"><strong>${formatMoney(seriesBreakdown.total?.cash_movement_cash_in || 0)}</strong></td>
                                        <td class="text-right"><strong>${formatMoney(seriesBreakdown.total?.cash_movement_cash_out || 0)}</strong></td>
                                        <td class="text-right"><strong>${formatMoney(seriesBreakdown.total?.total_cash_in || 0)}</strong></td>
                                        <td class="text-right"><strong>${formatMoney(seriesBreakdown.total?.total_cash_out || 0)}</strong></td>
                                        <td class="text-right ${(seriesBreakdown.total?.net || 0) >= 0 ? 'text-success' : 'text-danger'}">
                                            <strong>${formatMoney(seriesBreakdown.total?.net || 0)}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                ` : ''}
            </div>
        </div>
    `;
    
    $('#cashBookSummarySection').html(cashBookHtml);
}

function saveCashBookSummary(shiftId) {
    if (!confirm('Are you sure you want to save the cash book summary?')) {
        return;
    }
    
    $.ajax({
        url: '<?= base_url("Cashier/Summary/saveCashBookSummary") ?>/' + shiftId,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                alert('Cash book summary saved successfully!');
                loadCashBookSummary(shiftId);
            } else {
                alert('Failed to save: ' + (response.message || 'Unknown error'));
            }
        },
        error: function(xhr, status, error) {
            alert('Error saving cash book summary: ' + error);
        }
    });
}
</script>
<?php include APPPATH . "views/include/footer.php"; ?>

