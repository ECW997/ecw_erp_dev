<?php include "include/header.php"; ?>
<?php include "include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include "include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-handshake mr-2"></i>Cash Handover</h1>
                </div>
            </div>
            <div class="container-fluid mt-2">
                <div class="card">
                    <div class="card-body">
                        <table id="handoverTable" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>Cashier</th>
                                    <th>Handover Date</th>
                                    <th>Amount</th>
                                    <th>Received By</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        
        <div class="modal fade" id="handoverModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Handover</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <!-- Dynamic content -->
                </div>
                </div>
            </div>
        </div>

        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    let CashHandOver = <?= json_encode($handover_logs) ?>;

    if(CashHandOver.logs){
        $('#handoverTable').DataTable({
            data: CashHandOver.logs,
            destroy: true, 
            order: [[0, 'desc']],
            columns: [
                { 
                    data: "declared_by_user.name", 
                    defaultContent: "-", 
                    title: "Cashier" 
                },
                { 
                    data: "declared_at", 
                    defaultContent: "-", 
                    title: "Handover Date" 
                },
                { 
                    data: "actual_cash", 
                    className: "text-right",
                    render: d => Number(d ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
                    title: "Amount" 
                },
                { 
                    data: "verified_by_user.name", 
                    defaultContent: '<span class="text-muted">Not Verified</span>', 
                    title: "Received By" 
                },
                { 
                    data: "status",
                    className: 'text-center',
                    render: d => {
                        let baseClasses = "badge badge-pill";
                        if (d === 'verified') {
                            return `<span class="${baseClasses} bg-success text-white">Verified</span>`;
                        } else if (d === 'rejected') {
                            return `<span class="${baseClasses} bg-danger text-white">Rejected</span>`;
                        } else {
                            return `<span class="${baseClasses} bg-warning text-dark">Pending</span>`;
                        }
                    },
                    title: "Status"
                },
                { 
                    data: null,
                    className: 'text-center',
                    render: function(row) {
                        let rowData = encodeURIComponent(JSON.stringify(row));

                        if(row.status === 'pending'){
                            return `<button class="btn btn-primary btn-sm" onclick="editHandover('${rowData}')">
                                        <i class="fas fa-edit"></i>
                                    </button>`;
                        } else {
                            return `<span class="text-muted"><i class="fas fa-lock"></i></span>`;
                        }
                    },
                    title: "Action"
                }
            ]

        });
    }
    

    function editHandover(encodedRow){
        let row = JSON.parse(decodeURIComponent(encodedRow));

        // Show modal with input field for actual_cash
        let modalHtml = `
            <div class="form-group">
                <label>Cashier: ${row.declared_by_user.name}</label>
            </div>
            <div class="form-group">
                <label>Handover Amount</label>
                <input type="number" step="0.01" class="form-control" id="editActualCash" value="${row.actual_cash}">
            </div>
            <div class="form-group text-right">
                <button class="btn btn-success" onclick="updateHandover(${row.id})">Update</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        `;

        $('#handoverModal .modal-body').html(modalHtml);
        $('#handoverModal').modal('show');
    }

    function updateHandover(handoverId){
        let newAmount = $('#editActualCash').val();

        $.ajax({
            url: '<?= base_url("CashierHandover/updateHandoverAmount") ?>', 
            type: 'POST',
            dataType: 'json',
            data: {
                id: handoverId,
                actual_cash: newAmount
            },
            success: function(res){
                if(res.status){
                    success_toastify(res.message);
                    $('#handoverModal').modal('hide');
                    location.reload(); 
                } else {
                    error_toastify(res.message);
                }
            }
        });
    }
    
</script>
<?php include "include/footer.php"; ?>
