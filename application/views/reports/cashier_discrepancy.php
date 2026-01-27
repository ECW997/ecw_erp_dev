<?php include "../include/header.php"; ?>
<?php include "../include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include "../include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-exclamation-triangle mr-2 text-warning"></i>Shift Discrepancy Report</h1>
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
                                    <input type="date" class="form-control" id="startDate" value="<?= date('Y-m-d', strtotime('-30 days')) ?>">
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
        <?php include "../include/footerbar.php"; ?>
    </div>
</div>
<?php include "../include/footerscripts.php"; ?>
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
        url: '<?= base_url("Cashier/Report/discrepancy") ?>',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function(res) {
            if(res.status && res.data) {
                renderReport(res.data);
            } else {
                $('#reportContent').html('<p class="text-center text-success">No discrepancies found</p>');
            }
        },
        error: function() {
            error_toastify('Error loading report');
        }
    });
}

function renderReport(data) {
    let html = `
        <h5 class="mb-3">Shift Discrepancy Report</h5>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Shift ID</th>
                    <th>Cashier</th>
                    <th>Date</th>
                    <th>System Calculated Cash</th>
                    <th>Actual Cash Declared</th>
                    <th>Difference</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    if(data.discrepancies && data.discrepancies.length > 0) {
        data.discrepancies.forEach(function(item) {
            let difference = (item.system_cash || 0) - (item.actual_cash || 0);
            let statusClass = Math.abs(difference) > 0.01 ? 'text-danger font-weight-bold' : 'text-success';
            html += `
                <tr>
                    <td class="text-center">${item.shift_id || '-'}</td>
                    <td>${item.cashier_name || '-'}</td>
                    <td>${item.shift_date || '-'}</td>
                    <td class="text-right">${formatMoney(item.system_cash)}</td>
                    <td class="text-right">${formatMoney(item.actual_cash)}</td>
                    <td class="text-right ${statusClass}">${formatMoney(difference)}</td>
                    <td class="text-center">
                        ${Math.abs(difference) > 0.01 
                            ? '<span class="badge badge-danger">Discrepancy</span>' 
                            : '<span class="badge badge-success">Match</span>'}
                    </td>
                </tr>
            `;
        });
    } else {
        html += '<tr><td colspan="7" class="text-center text-success">No discrepancies found</td></tr>';
    }
    
    html += `</tbody></table>`;
    $('#reportContent').html(html);
}

function formatMoney(value) {
    return Number(value ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}
</script>
<?php include "../include/footer.php"; ?>

