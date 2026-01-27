<?php include "../include/header.php"; ?>
<?php include "../include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include "../include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-calendar-day mr-2"></i>Cashier Daily Summary Report</h1>
                </div>
            </div>
            <div class="container-fluid mt-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" class="form-control" id="reportDate" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button class="btn btn-primary" onclick="loadReport()">
                                    <i class="fas fa-search mr-2"></i>Generate Report
                                </button>
                                <button class="btn btn-success ml-2" onclick="exportReport()">
                                    <i class="fas fa-file-excel mr-2"></i>Export
                                </button>
                            </div>
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
        <?php include "../include/footerbar.php"; ?>
    </div>
</div>
<?php include "../include/footerscripts.php"; ?>
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
        <h5 class="mb-3">Daily Summary - ${data.date || $('#reportDate').val()}</h5>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Shift ID</th>
                    <th>Cashier</th>
                    <th>Opened At</th>
                    <th>Closed At</th>
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
    `;
    
    if(data.shifts && data.shifts.length > 0) {
        data.shifts.forEach(function(shift) {
            html += `
                <tr>
                    <td class="text-center">${shift.shift_id || '-'}</td>
                    <td>${shift.cashier_name || '-'}</td>
                    <td>${shift.opened_at || '-'}</td>
                    <td>${shift.closed_at || '-'}</td>
                    <td class="text-center">${shift.total_invoices || 0}</td>
                    <td class="text-right">${formatMoney(shift.total_sales)}</td>
                    <td class="text-right">${formatMoney(shift.cash_total)}</td>
                    <td class="text-right">${formatMoney(shift.card_total)}</td>
                    <td class="text-right">${formatMoney(shift.cheque_total)}</td>
                    <td class="text-right">${formatMoney(shift.online_total)}</td>
                    <td class="text-right">${formatMoney(shift.other_total)}</td>
                </tr>
            `;
        });
    } else {
        html += '<tr><td colspan="11" class="text-center">No shifts found</td></tr>';
    }
    
    html += `
            </tbody>
            <tfoot class="bg-light font-weight-bold">
                <tr>
                    <td colspan="5" class="text-right">TOTAL:</td>
                    <td class="text-right">${formatMoney(data.totals?.total_sales)}</td>
                    <td class="text-right">${formatMoney(data.totals?.cash_total)}</td>
                    <td class="text-right">${formatMoney(data.totals?.card_total)}</td>
                    <td class="text-right">${formatMoney(data.totals?.cheque_total)}</td>
                    <td class="text-right">${formatMoney(data.totals?.online_total)}</td>
                    <td class="text-right">${formatMoney(data.totals?.other_total)}</td>
                </tr>
            </tfoot>
        </table>
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
<?php include "../include/footer.php"; ?>

