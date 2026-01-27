<?php include "../include/header.php"; ?>
<?php include "../include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include "../include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-file-invoice mr-2 text-danger"></i>Outstanding IOUs Report</h1>
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
                            <div class="col-md-3 d-flex align-items-end">
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
                            <p class="text-center text-muted">Select shift ID (optional) and click Generate Report</p>
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
    let params = shiftId ? { shift_id: shiftId } : {};

    $.ajax({
        url: '<?= base_url("Cashier/Report/outstandingIous") ?>',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function(res) {
            if(res.status && res.data) {
                renderReport(res.data);
            } else {
                $('#reportContent').html('<p class="text-center text-success">No outstanding IOUs</p>');
            }
        },
        error: function() {
            error_toastify('Error loading report');
        }
    });
}

function renderReport(data) {
    let html = `
        <h5 class="mb-3">Outstanding IOUs Report</h5>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Shift ID</th>
                    <th>Movement ID</th>
                    <th>Payee Code</th>
                    <th>Payee Name</th>
                    <th>Amount</th>
                    <th>Payment Type</th>
                    <th>Created At</th>
                    <th>Days Outstanding</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    if(data.outstanding_ious && data.outstanding_ious.length > 0) {
        data.outstanding_ious.forEach(function(item) {
            let daysOutstanding = item.days_outstanding || 0;
            let daysClass = daysOutstanding > 30 ? 'text-danger font-weight-bold' : daysOutstanding > 14 ? 'text-warning' : '';
            html += `
                <tr>
                    <td class="text-center">${item.cashier_shift_id || '-'}</td>
                    <td class="text-center">${item.id || '-'}</td>
                    <td>${item.payee_code || '-'}</td>
                    <td>${item.payee_name || '-'}</td>
                    <td class="text-right">${formatMoney(item.amount)}</td>
                    <td class="text-capitalize">${item.payment_type || '-'}</td>
                    <td>${item.created_at || '-'}</td>
                    <td class="text-center ${daysClass}">${daysOutstanding} days</td>
                    <td>${item.remarks || '-'}</td>
                </tr>
            `;
        });
    } else {
        html += '<tr><td colspan="9" class="text-center text-success">No outstanding IOUs</td></tr>';
    }
    
    html += `
            </tbody>
            <tfoot class="bg-light font-weight-bold">
                <tr>
                    <td colspan="4" class="text-right">TOTAL OUTSTANDING:</td>
                    <td class="text-right">${formatMoney(data.total_outstanding)}</td>
                    <td colspan="4"></td>
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
    let shiftId = $('#shiftId').val();
    let params = shiftId ? `shift_id=${shiftId}&` : '';
    window.open(`<?= base_url("Cashier/Report/outstandingIous") ?>?${params}export=excel`, '_blank');
}
</script>
<?php include "../include/footer.php"; ?>

