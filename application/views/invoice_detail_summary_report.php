<?php
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <style>
        .table_1 thead th {
            background-color: #cf1349 !important;
            color: #fff !important;
        }

        .table_1 td {
            background-color: #e6e6e6ff !important;
            color: #000 !important;
        }

        .table_1 tbody tr:hover td {
            background-color: #f9ce7a !important;
        }

        .table_1 tfoot th,
        .table_1 tfoot td {
            background-color: #cce5ff !important;
            color: #000 !important;
        }

        /* .secret-col {
            display: none;
            width: 25%;
        } */

        #loadingOverlay {
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999 !important;
            display: none;
            /* background: rgba(255, 255, 255, 0.7); */
            align-items: center;
            justify-content: center;
        }

        #loadingOverlay.active {
            display: flex !important;
        }
        </style>
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-file-alt"></i></div>
                            <span>Invoice Summary Report</span>
                        </h1>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card" style="background-color:rgba(196, 196, 196, 1);">
                    <div class="container-fluid mt-2 p-0 p-2">
                        <div class="card">
                            <div class="card-body p-0 p-2">
                                <div class="col-12">
                                    <form method="post" class="mb-3">
                                        <div class="row align-items-end">
                                            <div class="col-md-2">
                                                <label class="small font-weight-bold"> Date From*</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="date" name="date_from" id="date_from"
                                                        class="form-control"
                                                        value="<?= htmlspecialchars($_POST['date_from'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="small font-weight-bold"> Date To*</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="date" name="date_to" id="date_to" class="form-control"
                                                        value="<?= htmlspecialchars($_POST['date_to'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <input type="hidden" name="f_branch_id" id="f_branch_id">
                                            <input type="hidden" id="f_branch_name" name="f_branch_name"
                                                class="form-control form-control-sm" required readonly>

                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                                    <i class="fas fa-search"></i> Search
                                                </button>
                                            </div>
                                            <!-- <div class="col-md-2">
                                                <button type="button" class="btn btn-primary btn-sm rounded-2 w-100"
                                                    onclick="window.open('<?= base_url('InvoiceOutstandingReport/exportPDF') ?>', '_blank');">
                                                    <i class="fas fa-print me-2"></i>Print
                                                </button>
                                            </div> -->
                                        </div>
                                    </form>

                                    <?php
                                    $total_ecw = 0;
                                    if (!empty($report['data'])) {
                                        foreach ($report['data'] as $row) {
                                            $total_ecw += $row['Invoice Amount'] ?? 0;
                                        }
                                    }
                                    ?>
                                    <?php if ($this->input->method() === 'post' && !empty($report['data'])): ?>
                                    <div class="table-responsive">
                                        <table class="table_1 table-bordered table-striped table-sm nowrap w-100"
                                            id="outstandingTable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="text-align: left; width:15%;">Invoice Date</th>
                                                    <th style="text-align: left; width:20%;">Invoice No</th>
                                                    <th style="text-align: left; width:20%;">Jobcard No</th>
                                                    <th style="text-align: left; width:25%;">Customer Name</th>
                                                    <th style="text-align: right; width:25%;">Invoice Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($report['data'] as $row): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row['Date'] ?? '') ?></td>
                                                    <td style="text-align: left;">
                                                        <?= htmlspecialchars($row['Invoice No'] ?? 0, 2) ?></td>
                                                    <td style="text-align: left;">
                                                        <?= htmlspecialchars($row['Jobcard No'] ?? 0, 2) ?></td>
                                                    <td style="text-align: left;">
                                                        <?= htmlspecialchars($row['Customer Name'] ?? '') ?></td>
                                                    <td style="text-align: right;">
                                                        <?= number_format($row['Invoice Amount'] ?? 0, 2) ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4" style="text-align: right;">Total Invoice Amount</th>
                                                    <th class="secret-col" style="text-align: right;">
                                                        <?= number_format($total_ecw, 2) ?>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <?php elseif ($this->input->method() === 'post'): ?>
                                    <div class="alert alert-info mt-4">No Daily sales found.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>


<script>
$(document).ready(function() {
    $('#f_branch_id').val('<?php echo ($_SESSION['branch_id']); ?>');
    $('#f_branch_name').val('<?php echo ($_SESSION['branchname']); ?>');

    var dtButtons = [{
        extend: 'pdf',
        className: 'btn btn-danger btn-sm',
        text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
        exportOptions: {
            columns: ':visible'
        },
        orientation: 'landscape',
        pageSize: 'A4',
        customize: function(doc) {
            doc.content[1].table.widths = ['20%', '20%', '20%', '20%', '20%'];

            doc.content.unshift({
                text: 'Invoice Summary Report',
                fontSize: 18,
                alignment: 'center',
                margin: [0, 0, 0, 10],
                bold: true,
                color: '#cf1349'
            });
            doc.styles.tableHeader.fillColor = '#cf1349';
            doc.styles.tableHeader.color = '#fff';


            doc['footer'] = function(page, pages) {
                return {
                    columns: [{
                            text: 'ECW Software',
                            alignment: 'left',
                            margin: [40, 0, 0, 0],
                            fontSize: 9
                        },
                        {
                            text: 'Page ' + page.toString() + ' of ' + pages,
                            alignment: 'right',
                            margin: [0, 0, 40, 0],
                            fontSize: 9
                        }
                    ]
                };
            };
        }
    }];

    var table = $('#outstandingTable').DataTable({
        "destroy": true,
        "processing": true,
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [50, 100, -1],
            [50, 100, 'All'],
        ],
        buttons: dtButtons,
        order: [
            [0, "asc"]
        ],
        pageLength: 50
    });
});
</script>
<script>
</script>
<!-- Loading -->
<div id="loadingOverlay">
    <div>
        <span class="spinner-border text-primary" style="width: 5rem; height: 5rem;"></span>
        <div style="color:#0000FF; font-weight:bold; margin-top:10px;">Loading Data...</div>
    </div>
</div>
<?php include "include/footer.php"; ?>
<?php
function exportExcel() {
   
}
function exportPDF() {
    
}
function exportSummaryPDF() {

}
?>
<script>
$(document).ready(function() {
    $('form').on('submit', function() {
        $('#loadingOverlay').addClass('active');
    });
    $('#outstandingTable').on('draw.dt', function() {
        $('#loadingOverlay').removeClass('active');
    });
    $(document).ajaxStop(function() {
        $('#loadingOverlay').removeClass('active');
    });
    $(window).on('load', function() {
        $('#loadingOverlay').removeClass('active');
    });
});
</script>

<script>
$(document).ready(function() {

    var table = $('#outstandingTable').DataTable();
    var extraButtons = [{
        extend: 'excelHtml5',
        className: 'btn btn-success btn-sm',
        text: '<i class="fas fa-file-excel mr-2"></i> Excel',
        exportOptions: {
            columns: ':visible'
        },
        customize: function(xlsx) {
            // Set sheet name
            var sheetName = $('#f_branch_name').val() || 'Invoice Summary Report';
            xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0].setAttribute('name', sheetName);

            var sheet = xlsx.xl.worksheets['sheet1.xml'];

            // Set column widths
            $('col', sheet).attr('width', 25);

            // Add custom title row
            var header = '<row r="1">' +
                '<c t="inlineStr" r="A1"><is><t>Invoice Summary Report</t></is></c>' +
                '</row>';
            sheet.childNodes[0].childNodes[1].innerHTML = header + sheet.childNodes[0].childNodes[1].innerHTML;

            // Style the title row
            $('row:eq(0) c', sheet).attr('s', '51');

            // Calculate total for Invoice Amount
            var totalInvoiceAmount = 0;
            $('#outstandingTable tbody tr').each(function() {
                var amount = parseFloat($(this).find('td:eq(4)').text().replace(/,/g, '')) || 0;
                totalInvoiceAmount += amount;
            });

            // Add totals row at the end
            var lastRow = $('sheetData row', sheet).length + 1;
            var totalsRow =
                '<row r="' + lastRow + '">' +
                '<c t="inlineStr" r="A' + lastRow + '"><is><t>Total</t></is></c>' +
                '<c r="B' + lastRow + '"/>' +
                '<c r="C' + lastRow + '"/>' +
                '<c r="D' + lastRow + '"/>' +
                '<c t="n" r="E' + lastRow + '"><v>' + totalInvoiceAmount.toFixed(2) + '</v></c>' +
                '</row>';

            $('sheetData', sheet).append(totalsRow);
        }
    },
        {
            text: '<i class="fas fa-print me-2"></i> All Summary PDF',
            className: 'btn btn-primary btn-sm rounded-2',
            action: function(e, dt, node, config) {
                var dateFrom = $('#date_from').val();
                var dateTo = $('#date_to').val();

                var form = $('<form>', {
                    action: '<?= base_url('InvoiceDetailsSummaryReport/exportPDF') ?>',
                    method: 'POST',
                    target: '_blank'
                }).append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'date_from',
                        value: dateFrom
                    }),
                    $('<input>', {
                        type: 'hidden',
                        name: 'date_to',
                        value: dateTo
                    })
                );

                $('body').append(form);
                form.submit();
                form.remove();
            }
        }
    ];

    extraButtons.forEach(function(btn) {
        table.button().add(null, btn);
    });


    // $(document).on('keydown', function(e) {
    //     if (e.key.length === 1 && /[a-zA-Z]/.test(e.key)) {
    //         buffer += e.key.toLowerCase();
    //         if (buffer.length > Math.max(showSecret.length, hideSecret.length)) {
    //             buffer = buffer.slice(-Math.max(showSecret.length, hideSecret.length));
    //         }
    //         if (buffer === showSecret) {
    //             $('.secret-col').show();
    //             extraButtons.forEach(function(btn) {
    //                 table.button().add(null, btn);
    //             });
    //             buffer = "";
    //         }
    //         if (buffer === hideSecret) {
    //             $('.secret-col').hide();
    //             table.buttons().remove();
    //             table.button().add(null, dtButtons[0]);
    //             buffer = "";
    //         }
    //     }
    // });
});
</script>

