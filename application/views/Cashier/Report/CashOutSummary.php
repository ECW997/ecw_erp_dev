<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include APPPATH . "views/include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-money-bill-wave mr-2"></i>Cash Out Summary Report</h1>
                </div>
            </div>
            <div class="container-fluid mt-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Shift ID (Optional)</label>
                                    <input type="number" class="form-control" id="shiftId" placeholder="Leave empty for all">
                                </div>
                            </div>
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
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary" onclick="loadReport()">
                                    <i class="fas fa-search mr-2"></i>Generate Report
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="reportContent">
                            <p class="text-center text-muted">Select filters and click Generate Report</p>
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
    let shiftId = $('#shiftId').val();
    let startDate = $('#startDate').val();
    let endDate = $('#endDate').val();
    
    let params = {};
    if(shiftId) params.shift_id = shiftId;
    if(startDate) params.start_date = startDate;
    if(endDate) params.end_date = endDate;

    $.ajax({
        url: '<?= base_url("Cashier/Report/cashOutSummary") ?>',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function(res) {
            if(res.status && res.data) {
                renderReport(res.data);
            } else {
                $('#reportContent').html('<p class="text-center text-danger">No data found</p>');
            }
        },
        error: function() {
            error_toastify('Error loading report');
        }
    });
}

function renderReport(data) {
    let html = `
        <h5 class="mb-3">Cash Out Summary Report</h5>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Shift ID</th>
                    <th>Movement ID</th>
                    <th>Source</th>
                    <th>Payee</th>
                    <th>Amount</th>
                    <th>Payment Type</th>
                    <th>Status</th>
                    <th>Approved By</th>
                    <th>Created At</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    if(data.cash_outs && data.cash_outs.length > 0) {
        data.cash_outs.forEach(function(item) {
            html += `
                <tr>
                    <td class="text-center">${item.cashier_shift_id || '-'}</td>
                    <td class="text-center">${item.id || '-'}</td>
                    <td class="text-capitalize">${item.source || '-'}</td>
                    <td>${item.payee_name || '-'}</td>
                    <td class="text-right">${formatMoney(item.amount)}</td>
                    <td class="text-capitalize">${item.payment_type || '-'}</td>
                    <td class="text-center">
                        ${item.status === 'approved' 
                            ? '<span class="badge badge-success">Approved</span>' 
                            : item.status === 'pending' 
                            ? '<span class="badge badge-warning">Pending</span>' 
                            : '<span class="badge badge-secondary">' + item.status + '</span>'}
                    </td>
                    <td>${item.approved_by_user?.name || '-'}</td>
                    <td>${item.created_at || '-'}</td>
                    <td>${item.remarks || '-'}</td>
                </tr>
            `;
        });
    } else {
        html += '<tr><td colspan="10" class="text-center">No cash out records found</td></tr>';
    }
    
    html += `
            </tbody>
            <tfoot class="bg-light font-weight-bold">
                <tr>
                    <td colspan="4" class="text-right">TOTAL:</td>
                    <td class="text-right">${formatMoney(data.total_amount)}</td>
                    <td colspan="5"></td>
                </tr>
            </tfoot>
        </table>
    `;
    
    $('#reportContent').html(html);
}

function formatMoney(value) {
    return Number(value ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}
</script>
<?php include APPPATH . "views/include/footer.php"; ?>

