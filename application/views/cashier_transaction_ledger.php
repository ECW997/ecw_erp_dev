<?php include "include/header.php"; ?>
<?php include "include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include "include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow-sm border-bottom">
                <div class="container-fluid py-3 d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">
                        <i class="fa fa-book mr-2 text-primary"></i>Cashier Transaction Ledger
                    </h1>
                    <div>
                        <select id="shiftSelector" class="form-control form-control-sm">
                            <option value="">Select Shift</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt-3">
                <div id="shiftSummary" class="alert alert-info d-none"></div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <table id="ledgerTable" class="table table-bordered table-striped w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th>Doc Type</th>
                                    <th>Doc/Receipt No</th>
                                    <th>Transaction Type</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Received At</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                             <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total:</th>
                                    <th class="text-right"></th>
                                    <th colspan="3"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?php include "include/footerbar.php"; ?>
    </div>
</div>

<?php include "include/footerscripts.php"; ?>

<script>
    let ledgerData = <?= json_encode($transactions) ?>;

    $(document).ready(function() {
        $('#shiftSelector').select2({
            placeholder: 'Select Shift',
            allowClear: true,
            width: '250px'
        });

        if (!ledgerData || !ledgerData.logs || !ledgerData.logs.length) {
            $('#shiftSummary')
                .removeClass('d-none alert-info')
                .addClass('alert-warning')
                .html('No transaction data found.');
            return;
        }

        ledgerData.logs.forEach(shift => {
            let openTime = shift.opened_at ? shift.opened_at : '';
            $('#shiftSelector').append(`<option value="${shift.shift_id}">Shift ${shift.shift_id} (${openTime})</option>`);
        });

        $('#shiftSelector').on('change', function() {
            let shiftId = $(this).val();
            let shift = ledgerData.logs.find(s => s.shift_id == shiftId);

            if (!shift) return;

            let summaryHtml = `
                <strong>Shift:</strong> ${shift.shift_id} &nbsp;&nbsp; 
                <strong>Cashier:</strong> ${shift.cashier_name} &nbsp;&nbsp; 
                <strong>Opened:</strong> ${shift.opened_at ?? '-'} &nbsp;&nbsp; 
                <strong>Closed:</strong> ${shift.closed_at ?? '-'} &nbsp;&nbsp;
                <strong>Status:</strong> 
                <span class="badge badge-${shift.status === 'open' ? 'success' : 'secondary'}">${shift.status}</span>
            `;
            $('#shiftSummary').removeClass('d-none').html(summaryHtml);

            loadLedgerTable(shift.transactions);
        });
    });

    function loadLedgerTable(transactions) {
        if ($.fn.DataTable.isDataTable('#ledgerTable')) {
            $('#ledgerTable').DataTable().clear().destroy();
        }

        $('#ledgerTable').DataTable({
            data: transactions || [],
            destroy: true,
            order: [[5, 'desc']],
            pageLength: -1, 
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]], 
            columns: [
                { 
                    data: 'doc_type', 
                    title: 'Doc Type', 
                    className: 'text-center text-capitalize' 
                },
                { 
                    data: 'receipt_number', 
                    title: 'Doc/Receipt No', 
                    className: 'text-center'
                },
                { 
                    data: 'transaction_type', 
                    title: 'Transaction Type', 
                    className: 'text-center text-capitalize' 
                },
                { 
                    data: 'payment_method', 
                    title: 'Payment Method', 
                    className: 'text-center text-capitalize' 
                },
                { 
                    data: 'amount', 
                    title: 'Amount', 
                    className: 'text-right',
                    render: d => Number(d ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2 })
                },
                { 
                    data: 'received_at', 
                    title: 'Received At', 
                    className: 'text-center' 
                },
                { 
                    data: 'status', 
                    title: 'Status', 
                    className: 'text-center',
                    render: d => {
                        if (d === 'reconciled') 
                            return '<span class="badge badge-success">Reconciled</span>';
                        else if (d === 'excluded') 
                            return '<span class="badge badge-danger">Excluded</span>';
                        else 
                            return '<span class="badge badge-warning">Recorded</span>';
                    }
                },
                { 
                    data: 'remarks', 
                    title: 'Remarks', 
                    defaultContent: '-' 
                }
            ],
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();

                let total = api
                    .column(4, { page: 'current' })
                    .data()
                    .reduce((a, b) => a + parseFloat(b ?? 0), 0);

                $(api.column(4).footer()).html(
                    total.toLocaleString(undefined, { minimumFractionDigits: 2 })
                );
            }
        });
    }
</script>


<?php include "include/footer.php"; ?>
