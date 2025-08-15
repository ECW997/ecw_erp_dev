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
        </style>
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-file-alt"></i></div>
                            <span>Customer Invoice Outstanding Report</span>
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
                                            <div class="col-md-3">
                                                <label class="small font-weight-bold"> Customer Name*</label>
                                                <select name="customer_id" id="customer_id"
                                                    class="form-control form-control-sm select2" style="width: 100%;">
                                                    <option value="">-- Select Customer --</option>
                                                    <?php if (!empty($_POST['customer_name'])): ?>
                                                    <option value="<?= htmlspecialchars($_POST['customer_name']) ?>"
                                                        selected>
                                                        <?= htmlspecialchars($_POST['customer_name']) ?>
                                                    </option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
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

                                    <?php if ($this->input->method() === 'post' && !empty($report['data'])): ?>
                                    <div class="table-responsive">
                                        <table class="table_1 table-bordered table-striped table-sm nowrap w-100"
                                            id="outstandingTable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Invoice Date</th>
                                                    <th>Invoice Number</th>
                                                    <th>Customer Name</th>
                                                    <th style="text-align: right;">Total Invoice Amount</th>
                                                    <th style="text-align: right;">Outstanding Invoice Amount</th>
                                                    <th style="text-align: center;">Due Date</th>
                                                    <th style="text-align: center;">Age</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($report['data'] as $row): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row['invoice']['invoice_date'] ?? '') ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($row['invoice']['invoice_number'] ?? '') ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($row['invoice']['customer_name'] ?? '') ?>
                                                    </td>
                                                    <td style="text-align: right;">
                                                        <?= number_format($row['invoice']['inv_grand_total'] ?? 0, 2) ?>
                                                    </td>
                                                    <td style="text-align: right;">
                                                        <?= number_format($row['invoice']['inv_payble_total'] ?? 0, 2) ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?= htmlspecialchars($row['invoice']['due_date'] ?? '') ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php
                                                            $due_date = $row['invoice']['due_date'] ?? '';
                                                            $age = '';
                                                            $color = '';
                                                            if ($due_date) {
                                                                $due = new DateTime($due_date);
                                                                $today = new DateTime(date('Y-m-d'));
                                                                $interval = $today->diff($due);
                                                                $days = (int)$interval->format('%r%a');
                                                                $age = $days;
                                                                if ($days < 0) {
                                                                    $color = 'color: #d90429; font-weight: bold;'; // red
                                                                } elseif ($days > 0) {
                                                                    $color = 'color: #2ecc40; font-weight: bold;'; // green
                                                                } else {
                                                                    $color = 'color: #000; font-weight: bold;'; // black for zero
                                                                }
                                                            }
                                                            if ($age !== '') {
                                                                echo '<span style="' . $color . '">' . $age . ' days</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php elseif ($this->input->method() === 'post'): ?>
                                    <div class="alert alert-info mt-4">No outstanding invoices found.</div>
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
    $('#outstandingTable').DataTable({
        "destroy": true,
        "processing": true,
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        buttons: [{
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                text: '<i class="fas fa-file-excel mr-2"></i> Excel',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                exportOptions: {
                    columns: ':visible'
                },
                orientation: 'landscape',
                pageSize: 'A4',
                customize: function(doc) {
                    doc.styles.tableHeader.fillColor = '#cf1349';
                    doc.styles.tableHeader.color = '#fff';
                }
            },
            {
                text: '<i class="fas fa-print me-2"></i> All Summary PDF',
                className: 'btn btn-primary btn-sm rounded-2',
                action: function(e, dt, node, config) {
                    window.open('<?= base_url('InvoiceOutstandingReport/exportPDF') ?>',
                        '_blank');
                }
            }
        ],
        order: [
            [0, "desc"]
        ],
        pageLength: 25
    });
});
</script>
<script>
$(document).ready(function() {
    $('#customer_id').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        minimumInputLength: 1,
        ajax: {
            url: '<?php echo base_url() ?>Payment/getCustomer',
            dataType: 'json',
            delay: 300,
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                }
            },
            cache: true,
            processResults: function(data) {
                if (data.status == true) {
                    return {
                        results: data.data.item,
                        pagination: {
                            more: data.data.item.length > 0
                        }
                    }
                } else {}
            }
        }
    });
});
</script>
<!-- Loading Overlay -->
<div id="loadingOverlay" style="
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    z-index: 9999;
    display: none;
    display: flex; /* Add flexbox */
    align-items: center;
    justify-content: center;
">
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
        $('#loadingOverlay').show();
    });
    $('#outstandingTable').on('draw.dt', function() {
        $('#loadingOverlay').hide();
    });
    $(document).ajaxStop(function() {
        $('#loadingOverlay').hide();
    });

    $(window).on('load', function() {
        $('#loadingOverlay').hide();
    });
});
</script>