<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include APPPATH . "views/include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-credit-card mr-2"></i>Payment Summary by Method Report</h1>
                </div>
            </div>
            <div class="container-fluid mt-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="date" class="form-control" id="startDate" value="<?= date('Y-m-d', strtotime('-7 days')) ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="date" class="form-control" id="endDate" value="<?= date('Y-m-d') ?>">
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
                            <p class="text-center text-muted">Select date range and click Generate Report</p>
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
    let startDate = $('#startDate').val();
    let endDate = $('#endDate').val();
    
    if(!startDate || !endDate) {
        error_toastify('Please select both start and end dates');
        return;
    }

    $.ajax({
        url: '<?= base_url("Cashier/Report/paymentSummary") ?>',
        type: 'GET',
        dataType: 'json',
        data: { start_date: startDate, end_date: endDate },
        success: function(res) {
            if(res.status && res.data) {
                renderReport(res.data);
            } else {
                $('#reportContent').html('<p class="text-center text-danger">No data found for selected period</p>');
            }
        },
        error: function() {
            error_toastify('Error loading report');
        }
    });
}

function renderReport(data) {
    let html = `
        <h5 class="mb-3">Payment Summary - ${$('#startDate').val()} to ${$('#endDate').val()}</h5>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Date</th>
                    <th>Cash</th>
                    <th>Card</th>
                    <th>Cheque</th>
                    <th>Online Transfer</th>
                    <th>Other</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    if(data.summary && data.summary.length > 0) {
        data.summary.forEach(function(item) {
            let total = (item.cash_total || 0) + (item.card_total || 0) + (item.cheque_total || 0) + (item.online_total || 0) + (item.other_total || 0);
            html += `
                <tr>
                    <td>${item.date || '-'}</td>
                    <td class="text-right">${formatMoney(item.cash_total)}</td>
                    <td class="text-right">${formatMoney(item.card_total)}</td>
                    <td class="text-right">${formatMoney(item.cheque_total)}</td>
                    <td class="text-right">${formatMoney(item.online_total)}</td>
                    <td class="text-right">${formatMoney(item.other_total)}</td>
                    <td class="text-right font-weight-bold">${formatMoney(total)}</td>
                </tr>
            `;
        });
    } else {
        html += '<tr><td colspan="7" class="text-center">No data found</td></tr>';
    }
    
    html += `
            </tbody>
            <tfoot class="bg-light font-weight-bold">
                <tr>
                    <td>TOTAL:</td>
                    <td class="text-right">${formatMoney(data.totals?.cash_total)}</td>
                    <td class="text-right">${formatMoney(data.totals?.card_total)}</td>
                    <td class="text-right">${formatMoney(data.totals?.cheque_total)}</td>
                    <td class="text-right">${formatMoney(data.totals?.online_total)}</td>
                    <td class="text-right">${formatMoney(data.totals?.other_total)}</td>
                    <td class="text-right">${formatMoney(data.totals?.grand_total)}</td>
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
    let startDate = $('#startDate').val();
    let endDate = $('#endDate').val();
    window.open(`<?= base_url("Cashier/Report/paymentSummary") ?>?start_date=${startDate}&end_date=${endDate}&export=excel`, '_blank');
}
</script>
<?php include APPPATH . "views/include/footer.php"; ?>

