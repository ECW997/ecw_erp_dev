<?php include "include/header.php"; ?>
<?php include "include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include "include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-calendar-check mr-2"></i>Cashier Shift Summary</h1>
                </div>
            </div>

            <div class="container-fluid mt-2">
                <div class="card">
                    <div class="card-body">
                        <table id="shiftSummaryTable" class="table table-bordered w-100">
                            <thead>
                                <tr>
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

        <!-- Modal -->
        <div class="modal fade" id="shiftSummaryModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Shift Summary Details</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                </div>
            </div>
        </div>

        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>

<script>
let ShiftSummaryData = <?= json_encode($shift_summaries ?? []) ?>;
console.log(ShiftSummaryData);

if (ShiftSummaryData.logs && ShiftSummaryData.logs.length) {
    $('#shiftSummaryTable').DataTable({
        data: ShiftSummaryData.logs,
        destroy: true,
        order: [[1, 'desc']], 
        columns: [
            { 
                data: 'shift.cashier.name', 
                title: 'Cashier', 
                defaultContent: '-', 
                className: 'text-center'
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
                render: function(row) {
                    let encoded = encodeURIComponent(JSON.stringify(row));
                        return `
                            <button class="btn btn-primary btn-sm" onclick="viewShiftSummary('${encoded}')">
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

function formatMoney(d){
    return Number(d ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function viewShiftSummary(encodedRow){
    let row = JSON.parse(decodeURIComponent(encodedRow));
    
    let cashierName = row.shift?.cashier?.name ?? `Cashier ID: ${row.shift?.cashier_id ?? '-'}`;

    let openedAt = row.shift?.opened_at ?? '-';
    let closedAt = row.shift?.closed_at ?? '-';
    let shiftStatus = row.shift?.status ?? '-';
    
    let modalHtml = `
        <table class="table table-sm table-bordered">
            <tr><th>Cashier</th><td>${cashierName}</td></tr>
            <tr><th>Shift ID</th><td>${row.cashier_shift_id}</td></tr>
            <tr><th>Shift Opened At</th><td>${openedAt}</td></tr>
            <tr><th>Shift Closed At</th><td>${closedAt}</td></tr>
            <tr><th>Shift Status</th><td>${shiftStatus}</td></tr>
            <tr><th>Total Invoices</th><td>${row.total_invoices}</td></tr>
            <tr><th>Total Sales</th><td class="text-right">${formatMoney(row.total_sales)}</td></tr>
            <tr><th>Cash</th><td class="text-right">${formatMoney(row.cash_total)}</td></tr>
            <tr><th>Card</th><td class="text-right">${formatMoney(row.card_total)}</td></tr>
            <tr><th>Cheque</th><td class="text-right">${formatMoney(row.cheque_total)}</td></tr>
            <tr><th>Online</th><td class="text-right">${formatMoney(row.online_total)}</td></tr>
            <tr><th>Other</th><td class="text-right">${formatMoney(row.other_total)}</td></tr>
            <tr><th>Status</th><td>${row.locked == 1 ? '<span class="badge badge-success">Locked</span>' : '<span class="badge badge-warning">Open</span>'}</td></tr>
        </table>
    `;
    
    $('#shiftSummaryModal .modal-body').html(modalHtml);
    $('#shiftSummaryModal').modal('show');
}

</script>
<?php include "include/footer.php"; ?>
