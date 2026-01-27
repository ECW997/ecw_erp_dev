<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include APPPATH . "views/include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-calendar-day mr-2"></i>Cashier Daily Summary Report</h1>
                </div>
            </div>
            <div class="container-fluid mt-2">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="d-flex flex-wrap align-items-center">
                            <label for="reportDate" class="font-weight-bold mb-0 mr-2">Select Date</label>
                            <input 
                                type="date" 
                                class="form-control form-control-sm mr-2" 
                                id="reportDate" 
                                value="<?= date('Y-m-d') ?>"
                                style="max-width: 170px;"
                            >
                            <button class="btn btn-primary btn-sm mr-2" onclick="loadReport()">
                                <i class="fas fa-search mr-1"></i>Generate Report
                            </button>
                            <button class="btn btn-success btn-sm" onclick="exportReport()">
                                <i class="fas fa-file-excel mr-1"></i>Export
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="reportContent">
                            <p class="text-center text-muted">Select date and click Generate Report</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>
<?php include APPPATH . "views/include/footerscripts.php"; ?>
<script>
function loadReport() {
    let date = $('#reportDate').val();
    if(!date) {
        error_toastify('Please select a date');
        return;
    }

    $.ajax({
        url: '<?= base_url("Cashier/Report/dailySummary") ?>',
        type: 'GET',
        dataType: 'json',
        data: { date: date },
        success: function(res) {
            if(res.status && res.data) {
                renderReport(res.data);
            } else {
                $('#reportContent').html('<p class="text-center text-danger">No data found for selected date</p>');
            }
        },
        error: function() {
            error_toastify('Error loading report');
        }
    });
}

function renderReport(data) {
    let html = `
        <div class="mb-4">
            <h5 class="mb-3">Daily Summary - ${data.date || $('#reportDate').val()}</h5>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <strong>Total Shifts:</strong> ${data.daily_totals?.total_shifts || 0}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Cash Book Summary Section -->
        <div class="card mb-4 border-primary">
            <div class="card-header bg-primary text-white font-weight-bold" style="font-size: 1.1rem; padding: 12px 20px;">
                <i class="fas fa-book mr-2"></i> Daily Cash Book Summary
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Cash Inflows</h6>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th>Opening Balance</th>
                                <td class="text-right"><strong>${formatMoney(data.daily_totals?.opening_balance || 0)}</strong></td>
                            </tr>
                            <tr class="table-info">
                                <th><i class="fas fa-arrow-down text-success"></i> Transaction Ledger Cash In</th>
                                <td class="text-right"><strong class="text-success">${formatMoney(data.daily_totals?.transaction_ledger_cash_in || 0)}</strong></td>
                            </tr>
                            <tr class="table-info">
                                <th><i class="fas fa-arrow-down text-success"></i> Cash Movement Cash In</th>
                                <td class="text-right"><strong class="text-success">${formatMoney(data.daily_totals?.cash_movement_cash_in || 0)}</strong></td>
                            </tr>
                            <tr>
                                <th>Adjustments (In)</th>
                                <td class="text-right"><strong>${formatMoney(Math.max(0, data.daily_totals?.adjustments || 0))}</strong></td>
                            </tr>
                            <tr class="table-success">
                                <th><strong>Total Cash In</strong></th>
                                <td class="text-right"><strong>${formatMoney((data.daily_totals?.opening_balance || 0) + (data.daily_totals?.transaction_ledger_cash_in || 0) + (data.daily_totals?.cash_movement_cash_in || 0) + Math.max(0, data.daily_totals?.adjustments || 0))}</strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Cash Outflows</h6>
                        <table class="table table-sm table-bordered">
                            <tr class="table-danger">
                                <th><i class="fas fa-arrow-up text-danger"></i> Transaction Ledger Cash Out</th>
                                <td class="text-right"><strong class="text-danger">${formatMoney(data.daily_totals?.transaction_ledger_cash_out || 0)}</strong></td>
                            </tr>
                            <tr class="table-danger">
                                <th><i class="fas fa-arrow-up text-danger"></i> Cash Movement Cash Out</th>
                                <td class="text-right"><strong class="text-danger">${formatMoney(data.daily_totals?.cash_movement_cash_out || 0)}</strong></td>
                            </tr>
                            <tr>
                                <th>Adjustments (Out)</th>
                                <td class="text-right"><strong>${formatMoney(Math.abs(Math.min(0, data.daily_totals?.adjustments || 0)))}</strong></td>
                            </tr>
                            <tr class="table-danger">
                                <th><strong>Total Cash Out</strong></th>
                                <td class="text-right"><strong>${formatMoney((data.daily_totals?.transaction_ledger_cash_out || 0) + (data.daily_totals?.cash_movement_cash_out || 0) + Math.abs(Math.min(0, data.daily_totals?.adjustments || 0)))}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="alert alert-info mb-0">
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Expected Cash:</strong><br>
                                    <span class="h5">${formatMoney(data.daily_totals?.expected_cash || 0)}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Actual Cash:</strong><br>
                                    <span class="h5">${data.daily_totals?.actual_cash !== null && data.daily_totals?.actual_cash !== undefined ? formatMoney(data.daily_totals.actual_cash) : 'N/A'}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Variance:</strong><br>
                                    <span class="h5 ${data.daily_totals?.variance !== null && data.daily_totals?.variance !== undefined ? (data.daily_totals.variance > 0 ? 'text-success' : data.daily_totals.variance < 0 ? 'text-danger' : '') : ''}">
                                        ${data.daily_totals?.variance !== null && data.daily_totals?.variance !== undefined ? formatMoney(data.daily_totals.variance) : 'N/A'}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sales Summary Section -->
        <div class="card mb-4 border-success">
            <div class="card-header bg-success text-white font-weight-bold" style="font-size: 1.1rem; padding: 12px 20px;">
                <i class="fas fa-chart-line mr-2"></i> Daily Sales Summary
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Total Invoices</th>
                            <th>Total Sales</th>
                            <th>Cash</th>
                            <th>Card</th>
                            <th>Cheque</th>
                            <th>Online</th>
                            <th>Other</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><strong>${data.daily_totals?.total_invoices || 0}</strong></td>
                            <td class="text-right"><strong>${formatMoney(data.daily_totals?.total_sales || 0)}</strong></td>
                            <td class="text-right"><strong>${formatMoney(data.daily_totals?.cash_total || 0)}</strong></td>
                            <td class="text-right"><strong>${formatMoney(data.daily_totals?.card_total || 0)}</strong></td>
                            <td class="text-right"><strong>${formatMoney(data.daily_totals?.cheque_total || 0)}</strong></td>
                            <td class="text-right"><strong>${formatMoney(data.daily_totals?.online_total || 0)}</strong></td>
                            <td class="text-right"><strong>${formatMoney(data.daily_totals?.other_total || 0)}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Shift Details Section -->
        <div class="card border-secondary">
            <div class="card-header bg-secondary text-white font-weight-bold" style="font-size: 1.1rem; padding: 12px 20px;">
                <i class="fas fa-list mr-2"></i> Shift Details
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Code</th>
                            <th>Cashier</th>
                            <th>Opened At</th>
                            <th>Closed At</th>
                            <th>Status</th>
                            <th>Opening Balance</th>
                            <th>Expected Cash</th>
                            <th>Actual Cash</th>
                            <th>Variance</th>
                        </tr>
                    </thead>
                    <tbody>
    `;
    
    if(data.shifts && data.shifts.length > 0) {
        data.shifts.forEach(function(shift) {
            let cashBook = shift.cash_book_summary || {};
            let varianceClass = '';
            if (cashBook.variance !== null && cashBook.variance !== undefined) {
                if (cashBook.variance > 0) {
                    varianceClass = 'text-success';
                } else if (cashBook.variance < 0) {
                    varianceClass = 'text-danger';
                }
            }
            html += `
                <tr>
                    <td class="text-center">${shift.code || '-'}</td>
                    <td>${shift.cashier_name || '-'}</td>
                    <td>${shift.opened_at || '-'}</td>
                    <td>${shift.closed_at || '-'}</td>
                    <td><span class="badge badge-${shift.status === 'closed' ? 'success' : shift.status === 'open' ? 'warning' : 'info'}">${shift.status || '-'}</span></td>
                    <td class="text-right">${formatMoney(cashBook.opening_balance || 0)}</td>
                    <td class="text-right">${formatMoney(cashBook.expected_cash || 0)}</td>
                    <td class="text-right">${cashBook.actual_cash !== null && cashBook.actual_cash !== undefined ? formatMoney(cashBook.actual_cash) : 'N/A'}</td>
                    <td class="text-right ${varianceClass}">${cashBook.variance !== null && cashBook.variance !== undefined ? formatMoney(cashBook.variance) : 'N/A'}</td>
                </tr>
            `;
        });
    } else {
        html += '<tr><td colspan="9" class="text-center">No shifts found</td></tr>';
    }
    
    html += `
                    </tbody>
                    <tfoot class="bg-light font-weight-bold">
                        <tr>
                            <td colspan="5" class="text-right">DAILY TOTALS:</td>
                            <td class="text-right">${formatMoney(data.daily_totals?.opening_balance || 0)}</td>
                            <td class="text-right">${formatMoney(data.daily_totals?.expected_cash || 0)}</td>
                            <td class="text-right">${data.daily_totals?.actual_cash !== null && data.daily_totals?.actual_cash !== undefined ? formatMoney(data.daily_totals.actual_cash) : 'N/A'}</td>
                            <td class="text-right ${data.daily_totals?.variance !== null && data.daily_totals?.variance !== undefined ? (data.daily_totals.variance > 0 ? 'text-success' : data.daily_totals.variance < 0 ? 'text-danger' : '') : ''}">${data.daily_totals?.variance !== null && data.daily_totals?.variance !== undefined ? formatMoney(data.daily_totals.variance) : 'N/A'}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    `;
    
    $('#reportContent').html(html);
}

function formatMoney(value) {
    return Number(value ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function exportReport() {
    let date = $('#reportDate').val();
    if(!date) {
        error_toastify('Please select a date');
        return;
    }
    window.open(`<?= base_url("Cashier/Report/dailySummary") ?>?date=${date}&export=excel`, '_blank');
}
</script>
<?php include APPPATH . "views/include/footer.php"; ?>

