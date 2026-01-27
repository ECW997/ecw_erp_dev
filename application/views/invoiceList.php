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
        .text-end {
            text-align: right !important;
        }
        </style>
        <style>
        .modal-content {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .btn-option {
            transition: all 0.2s ease;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef !important;
        }

        .btn-option:hover {
            background-color: #f1f3f5;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .btn-option:active {
            transform: translateY(0);
        }

        .bg-light-blue {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .bg-light-orange {
            background-color: rgba(255, 193, 7, 0.1);
        }

        .rounded-circle {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .position-absolute {
            position: absolute;
        }

        .text-left {
            text-align: left;
        }

        .btn-option:focus {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
        }
        #filterBtn {
        min-width: 100px;
        height: 1.9rem;
        font-size: 0.85rem;
        padding: 0 0.75rem;
        }
        .input-group-text {
        background-color: #e9ecef;
        border-right: 0;
        font-weight: 700;
        color: #6c757d;
        white-space: nowrap;
        height: 1.9rem;
        padding: 0 0.5rem;
        line-height: 1.9rem;
        }
        .input-group > .form-control:first-child {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        }
        .input-group > .form-control:last-child {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-left: 0;
        }
        </style>

        <?php
            $shift_status = 'not_started'; 

            if (!empty($check_cashier_shift['status']) && $check_cashier_shift['status']) {
                if ($check_cashier_shift['code'] == 200) {
                    $shift_status = 'current_user';
                } else {
                    $shift_status = 'other_user';
                }
            }
        ?>

        <main>
            <div class="page-header page-header-light bg-white shadow">
        	    <div class="container-fluid">
        			<div class="page-header-content py-3 d-flex justify-content-between align-items-center">
        				<h1 class="page-header-title">
        					<div class="page-header-icon"><i class="fas fa-list-ul"></i></div>
        					<span>Invoice List</span>
        				</h1>
                        <?php if ($shift_status === 'current_user'): ?>
                            <button
                                class="btn btn-primary btn-sm px-4 mt-auto p-2 <?php if ($addcheck == 0) echo 'd-none'; ?>"
                                data-toggle="modal" data-target="#invoiceTypeModal">
                                <i class="fas fa-plus mr-3"></i>Create New Invoice
                            </button>
                        <?php endif; ?>
        			</div>
        		</div>
        	</div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="p-2 ">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3 d-flex align-items-center justify-content-start"></div>
                            <div class="col-12 col-md-9 d-flex align-items-center justify-content-end flex-wrap">
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="date_from" class="mb-0 mr-2">Date Filter</label>
                                    <div class="input-group">
                                        <input type="date" id="date_from" class="form-control form-control-sm" aria-label="Date From" />
                                        <div class="input-group-append">
                                        <span class="input-group-text">to</span>
                                        </div>
                                        <input type="date" id="date_to" class="form-control form-control-sm" aria-label="Date To" />
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="status" class="mb-0 mr-2">Status</label>
                                    <select id="status" class="custom-select custom-select-sm" style="min-width: 130px;">
                                        <option value="">All Status</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Approved</option>
                                        <option value="2">Cancelled</option>
                                    </select>
                                </div>
                                <button class="btn btn-secondary btn-sm" id="filterBtn" style="height: 1.9rem; font-size: 0.85rem;">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                                <button class="btn btn-outline-secondary btn-sm ml-2" id="clearFilterBtn">Clear</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap w-100"
                                        id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Invoice No</th>
                                                <th>JobCard No</th>
                                                <th>Customer Name</th>
                                                <th>Invoice Date</th>
                                                <th>Invoice Type</th>
                                                <th>Approve Status</th>
                                                <th>Invoice Amount</th>
                                                <th>Invoice Status</th>
                                                <th>Payment Status</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="secure_section" class="d-none">
            	<div class="container-fluid mt-2 p-0 p-2">
            		<div class="card">
            			<div class="p-2 ">
            				<div class="row align-items-center">
            					<div class="col-12 col-md-3 d-flex align-items-center justify-content-start"></div>
            					<div class="col-12 col-md-9 d-flex align-items-center justify-content-end flex-wrap">
            						<div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
            							<label for="date_from" class="mb-0 mr-2">Date Filter</label>
            							<div class="input-group">
            								<input type="date" id="date_from" class="form-control form-control-sm"
            									aria-label="Date From" />
            								<div class="input-group-append">
            									<span class="input-group-text">to</span>
            								</div>
            								<input type="date" id="date_to" class="form-control form-control-sm"
            									aria-label="Date To" />
            							</div>
            						</div>
            						<div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
            							<label for="status" class="mb-0 mr-2">Status</label>
            							<select id="status" class="custom-select custom-select-sm"
            								style="min-width: 130px;">
            								<option value="">All Status</option>
            								<option value="0">Pending</option>
            								<option value="1">Approved</option>
            								<option value="2">Cancelled</option>
            							</select>
            						</div>
            						<button class="btn btn-secondary btn-sm" id="filterBtn"
            							style="height: 1.9rem; font-size: 0.85rem;">
            							<i class="fas fa-filter mr-1"></i> Filter
            						</button>
            						<button class="btn btn-outline-secondary btn-sm ml-2"
            							id="clearFilterBtn">Clear</button>
            					</div>
            				</div>
            			</div>
            			<hr>
            			<div class="card-body p-0 p-2">
            				<div class="row">
            					<div class="col-12">
            						<div class="scrollbar pb-3" id="style-2">
            							<table class="table table-bordered table-striped table-sm nowrap w-100"
            								id="temp_dataTable">
            								<thead>
            									<tr>
            										<th>#</th>
            										<th>Invoice No</th>
            										<th>JobCard No</th>
            										<th>Customer Name</th>
            										<th>Invoice Date</th>
            										<th>Invoice Type</th>
            										<th>Approve Status</th>
            										<th>Invoice Amount</th>
            										<th>Invoice Status</th>
            										<th>Payment Status</th>
            										<th class="text-right">Actions</th>
            									</tr>
            								</thead>
            							</table>
            						</div>
            					</div>
            				</div>
            			</div>
            		</div>
            	</div>
            </div>
        </main>


        <!-- Invoice Type Modal -->
        <div class="modal fade" id="invoiceTypeModal" tabindex="-1" role="dialog"
            aria-labelledby="invoiceTypeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content border-0">
                    <div class="modal-header bg-primary text-white p-3">
                        <div class="w-100 text-center">
                            <i class="fas fa-file-invoice fa-2x mb-2"></i>
                            <h5 class="modal-title font-weight-bold text-white mb-0" id="invoiceTypeModalLabel">
                                SELECT INVOICE TYPE
                            </h5>
                        </div>
                        <button type="button" class="close position-absolute" style="right: 1rem; top: 1rem;"
                            data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="d-flex flex-column" style="gap: 1rem;">
                            <button type="button" class="btn btn-option btn-light p-3 rounded text-left border"
                                id="direct" onclick="selectInvoiceType('direct')">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light-blue p-2 mr-3">
                                        <i class="fas fa-file-invoice text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">Direct Invoice</div>
                                        <small class="text-muted d-block">For direct product sales</small>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="btn btn-option btn-light p-3 rounded text-left border d-none"
                                id="indirect" onclick="selectInvoiceType('indirect')">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light-orange p-2 mr-3">
                                        <i class="fas fa-car text-warning"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">Sales Order Invoice</div>
                                        <small class="text-muted d-block">For service jobs</small>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer bg-light justify-content-center py-2 border-top">
                        <small class="text-muted">Choose an invoice type to continue</small>
                    </div>
                </div>
            </div>
        </div>

        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
<script>
var addcheck = '<?php echo $addcheck; ?>';
var editcheck = '<?php echo $editcheck; ?>';
var statuscheck = '<?php echo $statuscheck; ?>';
var deletecheck = '<?php echo $deletecheck; ?>';
var approve1check = '<?php echo $approve1check; ?>';
var approve2check = '<?php echo $approve2check; ?>';
var approve3check = '<?php echo $approve3check; ?>';
var approve4check = '<?php echo $approve4check; ?>';
var cancelcheck = '<?php echo $cancelcheck; ?>';
var shift_status = '<?php echo $shift_status; ?>';
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {
    loadPaymentListTable();
    loadTempPaymentListTable();

    let typed = "";
    $(document).on("keydown", function (e) {
        typed += e.key.toLowerCase();

        if (typed.includes("boom")) {
            $("#secure_section").removeClass("d-none");
            typed = ""; 
        }
        if (typed.includes("hide")) {
            $("#secure_section").addClass("d-none");
            typed = ""; 
        }
        if (typed.length > 10) typed = typed.slice(-10);
    });

    $('#filterBtn').on('click', function() {
        loadPaymentListTable();
    });

    $('#clearFilterBtn').on('click', function() {
        $('#date_from, #date_to, #status').val('');
        loadPaymentListTable();
    });

    // Add this block for delete functionality
    // $(document).on('click', '.btnDeleteInvoice', function() {
    //     var invoiceId = $(this).data('id');

    //     if (!confirm("Are you sure you want to delete this invoice?")) {
    //         return;
    //     }

    //     $.ajax({
    //         url: base_url + "Invoice/deleteInvoice",
    //         type: "POST",
    //         data: {
    //             id: invoiceId
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             if (response && response.status == true) {
    //                 success_toastify(response.message);
    //                 $('#dataTable').DataTable().ajax.reload(null,
    //                     false);
    //             } else {
    //                 falseResponse(response);
    //             }
    //         },
    //         error: function() {
    //             alert("Server error occurred.");
    //         }
    //     });
    // });

});

function loadPaymentListTable(){
    var base_url = "<?php echo base_url(); ?>";

    $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [15, 30, 50, -1],
            [15, 30, 50, 'All'],
        ],
        "buttons": [{
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                title: 'Invoice List',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Invoice List',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Invoice List',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            },
        ],
        ajax: {
            url: apiBaseUrl + '/v1/invoice',
            type: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + api_token
            },
            data: function(d) {
                    d.date_from = $('#date_from').val();
                    d.date_to = $('#date_to').val();
                    d.status = $('#status').val();
                    d.series = '1';
            },
            dataSrc: function(json) {
                if (json.status === false && json.code === 401) {
                    falseResponse(errorObj);
                } else {
                    return json.data;
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) {
                    falseResponse(errorObj);
                }
            }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "id"
            },
            {
                "data": null,
                "render": function(data, type, full) {
                    if (full.invoice_number && full.invoice_number !== "") {
                        return full.invoice_number;
                    } else if (full.draft_number && full.draft_number !== "") {
                        return '<span class="text-muted">' + full.draft_number + '</span>';
                    } else {
                        return '<span class="text-danger">N/A</span>';
                    }
                }
            },
            {
                "data": "jobcard_no"
            },
            {
                "data": "customer_name"
            },
            {
                "data": "invoice_date"
            },
            {
                "data": "invoice_type",
                "render": function(data, type, full) {
                    if (data === "direct") {
                        return '<span class="text-info" style="font-weight: 600;">Direct Invoice</span>';
                    } else if (data === "indirect") {
                        return '<span class="text-primary" style="font-weight: 600;">Job Card Invoice</span>';
                    } else {
                        return data;
                    }
                }
            },
            {
                "data": "inv_status_text",
                "className": "text-center",
                "render": function(data, type, full) {
                    let colorClass = "";

                    if (data === "Pending") {
                        colorClass = "text-warning";
                    } else if (data === "Approved") {
                        colorClass = "text-success";
                    } else if (data === "Cancelled") {
                        colorClass = "text-danger";
                    }

                    return `<span class="${colorClass}" style="font-weight: 600;">${data}</span>`;
                }
            },
            {
                "data": "inv_grand_total",
                "className": "text-end",
                "render": function(data, type, full) {
                    let formatted = addCommas(parseFloat(data).toFixed(2));
                    return `<span class="text-dark" style="font-weight: 600;">${formatted}</span>`;
                }
            },
            {
                "data": "inv_status",
                "className": "text-center",
                "render": function(data, type, full) {
                    if (data === "1") {

                        return '<span class="text-success" style="font-weight: 600;">Active</span>';
                    } else if (data === "3") {
                        return '<span class="text-danger" style="font-weight: 600;">Deleted</span>';
                    } else {
                        return data;
                    }
                }
            },
            {
                "data": "inv_payment_status",
                "className": "text-center",
                "render": function(data, type, full) {
                    if (data === "0") {
                        return '<span class="text-danger" style="font-weight: 600;">Payment Pending</span>';
                    } else if (data === "1") {
                        return '<span class="text-success" style="font-weight: 600;">Payment Paid</span>';
                    } else {
                        return data;
                    }
                }
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button += '<a href="' + base_url + 'Invoice/invoiceDetailIndex/' + full['id'] + '/1' +
                        '" title="View" class="btn btn-secondary btn-sm btnView mr-1">' +
                        '<i class="fas fa-external-link-alt"></i></a>';

                    // Excel export (current row summary)
                    button +=
                        '<button title="Export to Excel" class="btn btn-success btn-sm btnExportInvoice mr-1">' +
                        '<i class="fas fa-file-excel"></i></button>';


                    if (full['is_confirmed'] == "0" && deletecheck == 1 && full['inv_status'] != "3" && shift_status === "current_user") {
                        button +=
                            '<button title="Delete" class="btn btn-danger btn-sm btnDeleteInvoice" data-id="' +
                            full['id'] + '">' +
                            '<i class="fas fa-trash-alt"></i></button>';
                    }

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

  
    $(document).on('click', '.btnDeleteInvoice', function() {
        var invoiceId = $(this).data('id');

        if (!confirm("Are you sure you want to delete this invoice?")) {
            return;
        }

        $.ajax({
            url: base_url + "Invoice/deleteInvoice/" + invoiceId,
            type: "POST",
            dataType: "json",
            success: function(response) {
                if (response && response.status == true) {
                    success_toastify(response.message);
                    $('#dataTable').DataTable().ajax.reload(null, false);
                } else {
                    falseResponse(response);
                }
            },
            error: function() {
                alert("Server error occurred.");
            }
        });
    });

};

function loadTempPaymentListTable(){
    var base_url = "<?php echo base_url(); ?>";

    $('#temp_dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [15, 30, 50, -1],
            [15, 30, 50, 'All'],
        ],
        "buttons": [{
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                title: 'Invoice List',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Invoice List',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Invoice List',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            },
        ],
        ajax: {
            url: apiBaseUrl + '/v1/invoice',
            type: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + api_token
            },
            data: function(d) {
                    d.date_from = $('#date_from').val();
                    d.date_to = $('#date_to').val();
                    d.status = $('#status').val();
                    d.series = '2';
            },
            dataSrc: function(json) {
                if (json.status === false && json.code === 401) {
                    falseResponse(errorObj);
                } else {
                    return json.data;
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) {
                    falseResponse(errorObj);
                }
            }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "id"
            },
            {
                "data": null,
                "render": function(data, type, full) {
                    if (full.invoice_number && full.invoice_number !== "") {
                        return full.invoice_number;
                    } else if (full.draft_number && full.draft_number !== "") {
                        return '<span class="text-muted">' + full.draft_number + '</span>';
                    } else {
                        return '<span class="text-danger">N/A</span>';
                    }
                }
            },
            {
                "data": "jobcard_no"
            },
            {
                "data": "customer_name"
            },
            {
                "data": "invoice_date"
            },
            {
                "data": "invoice_type",
                "render": function(data, type, full) {
                    if (data === "direct") {
                        return '<span class="text-info" style="font-weight: 600;">Direct Invoice</span>';
                    } else if (data === "indirect") {
                        return '<span class="text-primary" style="font-weight: 600;">Job Card Invoice</span>';
                    } else {
                        return data;
                    }
                }
            },
            {
                "data": "inv_status_text",
                "className": "text-center",
                "render": function(data, type, full) {
                    let colorClass = "";

                    if (data === "Pending") {
                        colorClass = "text-warning";
                    } else if (data === "Approved") {
                        colorClass = "text-success";
                    } else if (data === "Cancelled") {
                        colorClass = "text-danger";
                    }

                    return `<span class="${colorClass}" style="font-weight: 600;">${data}</span>`;
                }
            },
            {
                "data": "inv_grand_total",
                "className": "text-end",
                "render": function(data, type, full) {
                    let formatted = addCommas(parseFloat(data).toFixed(2));
                    return `<span class="text-dark" style="font-weight: 600;">${formatted}</span>`;
                }
            },
            {
                "data": "inv_status",
                "className": "text-center",
                "render": function(data, type, full) {
                    if (data === "1") {

                        return '<span class="text-success" style="font-weight: 600;">Active</span>';
                    } else if (data === "3") {
                        return '<span class="text-danger" style="font-weight: 600;">Deleted</span>';
                    } else {
                        return data;
                    }
                }
            },
            {
                "data": "inv_payment_status",
                "className": "text-center",
                "render": function(data, type, full) {
                    if (data === "0") {
                        return '<span class="text-danger" style="font-weight: 600;">Payment Pending</span>';
                    } else if (data === "1") {
                        return '<span class="text-success" style="font-weight: 600;">Payment Paid</span>';
                    } else {
                        return data;
                    }
                }
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button += '<a href="' + base_url + 'Invoice/invoiceDetailIndex/' + full[
                            'id'] + '/2' +
                        '" title="View" class="btn btn-secondary btn-sm btnView mr-1">' +
                        '<i class="fas fa-external-link-alt"></i></a>';


                    if (full['is_confirmed'] == "0" && deletecheck == 1 && full['inv_status'] != "3" && shift_status === "current_user") {
                        button +=
                            '<button title="Delete" class="btn btn-danger btn-sm btnDeleteInvoice" data-id="' +
                            full['id'] + '">' +
                            '<i class="fas fa-trash-alt"></i></button>';
                    }

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

  
    $(document).on('click', '.btnDeleteInvoice', function() {
        var invoiceId = $(this).data('id');

        if (!confirm("Are you sure you want to delete this invoice?")) {
            return;
        }

        $.ajax({
            url: base_url + "Invoice/deleteInvoice/" + invoiceId,
            type: "POST",
            dataType: "json",
            success: function(response) {
                if (response && response.status == true) {
                    success_toastify(response.message);
                    $('#dataTable').DataTable().ajax.reload(null, false);
                } else {
                    falseResponse(response);
                }
            },
            error: function() {
                alert("Server error occurred.");
            }
        });
    });

    // Excel export for a single invoice row using ExcelJS on client-side
    $(document).on('click', '.btnExportInvoice', function() {
        var $btn = $(this);
        var table = $('#dataTable').DataTable();
        var row = table.row($btn.closest('tr')).data();

        if (!row) {
            alert('Unable to fetch invoice data for export.');
            return;
        }

        var invoiceId = row.id;
        var seriesId = row.series_type || '1';

        if (!invoiceId) {
            alert('Missing invoice ID to export.');
            return;
        }

        $.ajax({
            url: base_url + 'Invoice/invoiceExcelData',
            type: 'GET',
            dataType: 'json',
            data: {
                invoice_id: invoiceId,
                series_id: seriesId
            },
            success: function(res) {
                if (!res || res.status === false || res.code !== 200) {
                    alert('Failed to fetch invoice data for Excel.');
                    return;
                }

                var data = res.data || {};
                var main = (data.main_data && data.main_data[0]) ? data.main_data[0] : {};
                var details = data.details_data || [];
                var extraCharges = data.extra_charge_data || [];

                var taxPerLine = 0;
                if (main.inv_add_vat == 1 && details.length > 0) {
                    var totalTax = parseFloat(main.inv_total_tax || 0);
                    taxPerLine = totalTax / details.length;
                }

                var invGrossTotal = parseFloat(main.inv_gross_total || 0);
                var invDiscountAmount = parseFloat(main.inv_discount_amount || 0);
                var totalDiscount = invDiscountAmount;
                var totalTaxAdded = (main.inv_add_vat == 1) ? parseFloat(main.inv_total_tax || 0) : 0;
                var netTotalAfterDiscount = invGrossTotal - totalDiscount + totalTaxAdded;
                var advance = parseFloat(main.inv_advance_total || 0);
                var grandTotal = invGrossTotal - (totalDiscount + advance) + totalTaxAdded;
                var totalPaid = parseFloat((data.total_paid_for_ref || 0));
                var totalNetBalance = grandTotal - totalPaid;

                // Load logo image and convert SVG social media logos to PNG
                var logoUrl = base_url + 'assets/img/logo-icon.png';
                
                // Function to load image as base64
                function loadImageAsBase64(url) {
                    return fetch(url)
                        .then(function(response) {
                            if (!response.ok) throw new Error('Image not found: ' + url);
                            return response.blob();
                        })
                        .then(function(blob) {
                            return new Promise(function(resolve, reject) {
                                var reader = new FileReader();
                                reader.onloadend = function() {
                                    var base64 = reader.result.split(',')[1];
                                    resolve(base64);
                                };
                                reader.onerror = reject;
                                reader.readAsDataURL(blob);
                            });
                        });
                }
                
                // Function to convert SVG to base64 PNG
                function svgToPngBase64(svgString) {
                    return new Promise(function(resolve, reject) {
                        var canvas = document.createElement('canvas');
                        var ctx = canvas.getContext('2d');
                        var img = new Image();
                        
                        canvas.width = 24;
                        canvas.height = 24;
                        
                        var svgBlob = new Blob([svgString], { type: 'image/svg+xml;charset=utf-8' });
                        var url = URL.createObjectURL(svgBlob);
                        
                        img.onload = function() {
                            ctx.drawImage(img, 0, 0, 24, 24);
                            var pngBase64 = canvas.toDataURL('image/png').split(',')[1];
                            URL.revokeObjectURL(url);
                            resolve(pngBase64);
                        };
                        
                        img.onerror = function() {
                            URL.revokeObjectURL(url);
                            reject(new Error('Failed to load SVG'));
                        };
                        
                        img.src = url;
                    });
                }
                
                // Social media SVG icons
                var socialSvgIcons = {
                    facebook: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z" fill="#000000"/></svg>',
                    tiktok: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25v178.72A162.55 162.55 0 1 1 185 188.31v89.89a74.62 74.62 0 1 0 52.23 71.18V0h88a121.18 121.18 0 0 0 1.86 22.17A122.18 122.18 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14Z" fill="#000000"/></svg>',
                    instagram: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" fill="#000000"/></svg>',
                    youtube: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z" fill="#000000"/></svg>'
                };
                
                // Convert SVG icons to PNG base64
                var socialLogoPromises = Object.keys(socialSvgIcons).map(function(key) {
                    return svgToPngBase64(socialSvgIcons[key]).catch(function() { return null; });
                });
                
                // Load logo and convert social media SVGs
                Promise.all([
                    loadImageAsBase64(logoUrl).catch(function() { return null; }),
                    socialLogoPromises[0], // facebook
                    socialLogoPromises[1], // tiktok
                    socialLogoPromises[2], // instagram
                    socialLogoPromises[3]  // youtube
                ]).then(function(results) {
                    var logoBase64 = results[0];
                    var socialLogos = {
                        facebook: results[1],
                        tiktok: results[2],
                        instagram: results[3],
                        youtube: results[4]
                    };
                    generateExcelWithLogo(logoBase64, socialLogos);
                }).catch(function(err) {
                    console.log('Error loading images, generating without logos:', err);
                    generateExcelWithLogo(null, {});
                });

                function generateExcelWithLogo(logoBase64, socialLogos) {
                    // --- ExcelJS workbook & worksheet matching PDF layout EXACTLY ---
                    var workbook = new ExcelJS.Workbook();
                    var worksheet = workbook.addWorksheet('Invoice', {
                        properties: { defaultRowHeight: 18 }
                    });
                    // Page setup to match PDF print (A4, portrait, fit to page)
                    worksheet.pageSetup = {
                        paperSize: 9,          // A4
                        orientation: 'portrait',
                        fitToPage: true,
                        fitToWidth: 1,
                        fitToHeight: 0,
                        horizontalCentered: true,
                        verticalCentered: false,
                        margins: {
                            left: 0.2, right: 0.2, top: 0.4, bottom: 0.4, header: 0.2, footer: 0.2
                        }
                    };

                    // Set column widths (matching new A-G table structure)
                    worksheet.columns = [
                        { width: 15 },  // A: Labels in header / # in table
                        { width: 50 },  // B: Values in header / DESCRIPTION in table
                        { width: 8 },   // C: QTY
                        { width: 8 },   // D: UNIT
                        { width: 14 },  // E: RATE
                        { width: 8 },   // F: DISC. (same width as UNIT)
                        { width: 16 }   // G: AMOUNT
                    ];

                    var currentRow = 1;

                    // === HEADER SECTION (matching your manual Excel shell) ===
                    // Logo in A1 only (not merged to avoid conflict with INVOICE)
                    worksheet.getRow(1).height = 40;

                    // Add logo image if available
                    if (logoBase64) {
                        try {
                            var imageId = workbook.addImage({
                                base64: logoBase64,
                                extension: 'png'
                            });
                            // Position logo in A1 (spans A1:B1 visually but not merged)
                            worksheet.addImage(imageId, {
                                tl: { col: 0, row: 0 },
                                ext: { width: 100, height: 40 }
                            });
                        } catch (e) {
                            console.log('Error adding logo image:', e);
                            // Fallback to placeholder
                            worksheet.getCell('A1').value = '[LOGO]';
                            worksheet.getCell('A1').font = { size: 10, italic: true, color: { argb: 'FF999999' } };
                            worksheet.getCell('A1').alignment = { horizontal: 'left', vertical: 'middle' };
                        }
                    } else {
                        // Placeholder if logo not available
                        worksheet.getCell('A1').value = '[LOGO]';
                        worksheet.getCell('A1').font = { size: 10, italic: true, color: { argb: 'FF999999' } };
                        worksheet.getCell('A1').alignment = { horizontal: 'left', vertical: 'middle' };
                    }

                    // INVOICE title centered across B1:G1 (no overlap with logo)
                    worksheet.mergeCells('B1:G1');
                    worksheet.getCell('B1').value = 'INVOICE';
                    worksheet.getCell('B1').font = { bold: true, size: 16, color: { argb: 'FF000000' } };
                    worksheet.getCell('B1').alignment = { horizontal: 'center', vertical: 'middle' };

                    // Move to row 2 for customer & invoice info
                    currentRow = 2;

                    // === CUSTOMER & INVOICE INFO (matching manual Excel) ===
                    // Row 2: Cus. Code & Invoice No.
                    worksheet.getCell('A' + currentRow).value = 'Cus. Code';
                    worksheet.getCell('B' + currentRow).value = ': ' + (main.customer_code || '');
                    worksheet.getCell('E' + currentRow).value = 'Invoice No.';
                    worksheet.getCell('F' + currentRow).value = ':';
                    worksheet.getCell('G' + currentRow).value = (main.invoice_number || '');
                    currentRow++;

                    // Row 3: Cus Name & Date
                    worksheet.getCell('A' + currentRow).value = 'Cus Name';
                    worksheet.getCell('B' + currentRow).value = ': ' + (main.customer_name || '');
                    worksheet.getCell('E' + currentRow).value = 'Date';
                    worksheet.getCell('F' + currentRow).value = ':';
                    var invDate = main.invoice_date ? new Date(main.invoice_date).toLocaleDateString('en-GB') : '';
                    worksheet.getCell('G' + currentRow).value = invDate;
                    currentRow++;

                    // Row 4: Address & S.P.Code
                    var address = main.invoice_type == 'indirect' 
                        ? (main.address || '') + ' ' + (main.address_2 || '') + ' ' + (main.city || '') + ' ' + (main.district || '')
                        : (main.customer_address || '');
                    worksheet.getCell('A' + currentRow).value = 'Address';
                    worksheet.getCell('B' + currentRow).value = ': ' + address;
                    worksheet.getCell('E' + currentRow).value = 'S.P.Code';
                    worksheet.getCell('F' + currentRow).value = ':';
                    worksheet.getCell('G' + currentRow).value = (main.sales_person_code || 'N/A');
                    currentRow++;

                    // Row 5: Vehicle No & Invoice Type (if indirect)
                    if (main.invoice_type != 'direct') {
                        worksheet.getCell('A' + currentRow).value = 'Vehicle No';
                        worksheet.getCell('B' + currentRow).value = ': ' + (main.vehicle_number || 'N/A');
                        worksheet.getCell('E' + currentRow).value = 'Invoice Type';
                        worksheet.getCell('F' + currentRow).value = ':';
                        worksheet.getCell('G' + currentRow).value = (main.invoice_type == 'direct' ? 'Direct' : 'JobCard');
                        currentRow++;
                    }

                    // Row 6: Vehicle Type & JobCard No
                    var vehicleType = (main.brand_name || '') + (main.model_name ? ', ' + main.model_name : '');
                    worksheet.getCell('A' + currentRow).value = 'Vehicle Type.';
                    worksheet.getCell('B' + currentRow).value = ': ' + vehicleType;
                    worksheet.getCell('E' + currentRow).value = 'JobCard No';
                    worksheet.getCell('F' + currentRow).value = ':';
                    worksheet.getCell('G' + currentRow).value = (main.real_jobcard_no || '');
                    currentRow += 2; // Blank row after header block

                    // === ITEM DETAILS TABLE HEADER (matching PDF: thick borders) ===
                    // Header in columns A-G: #, DESCRIPTION, QTY, UNIT, RATE, DISC., AMOUNT
                    worksheet.getRow(currentRow).values = ['#', 'DESCRIPTION', 'QTY', 'UNIT', 'RATE', 'DISC.', 'AMOUNT'];
                    var headerRow = worksheet.getRow(currentRow);
                    headerRow.font = { bold: true, size: 10 };
                    headerRow.alignment = { horizontal: 'center', vertical: 'middle' };
                    headerRow.fill = {
                        type: 'pattern',
                        pattern: 'solid',
                        fgColor: { argb: 'FFEFEFEF' } // Light grey matching PDF
                    };
                    // Thick top and bottom borders only (no left/right borders) - columns A-G (indices 1-7)
                    for (var c = 1; c <= 7; c++) {
                        headerRow.getCell(c).border = {
                            top: { style: 'medium', color: { argb: 'FF000000' } },
                            bottom: { style: 'medium', color: { argb: 'FF000000' } }
                        };
                    }
                    currentRow++;

                    // === ITEM DETAILS ROWS (matching PDF borders) ===
                    var detailStartRow = currentRow;
                    details.forEach(function(item, index) {
                        var lineTotal = parseFloat(item.line_total_after_discount || 0);
                        var unitPrice = parseFloat(item.unit_price || 0);

                        if (taxPerLine > 0) {
                            var qty = parseFloat(item.quantity || 0);
                            var taxPerUnit = qty > 0 ? taxPerLine / qty : 0;
                            unitPrice += taxPerUnit;
                            lineTotal += taxPerLine;
                        }

                        var isExchange = (item.description || '').toLowerCase().indexOf('exchange') !== -1;
                        var discPc = item.line_total_after_discount == 0 ? '' : item.line_discount_pc;
                        var amountVal = lineTotal == 0 ? '' : (isExchange ? -lineTotal : lineTotal);

                        var row = worksheet.getRow(currentRow);
                        row.getCell(1).value = index + 1; // Column A: #
                        row.getCell(2).value = item.description || ''; // Column B: Description
                        row.getCell(3).value = item.quantity !== undefined && item.quantity !== null && item.quantity !== '' ? Number(item.quantity) : null; // Column C: Qty
                        row.getCell(4).value = item.unit || ''; // Column D: Unit
                        row.getCell(5).value = Number(unitPrice.toFixed(2)); // Column E: Rate
                        row.getCell(6).value = discPc !== undefined && discPc !== null && discPc !== '' ? Number(discPc) : null; // Column F: Discount %
                        row.getCell(7).value = amountVal !== '' ? Number(lineTotal.toFixed(2)) : null; // Column G: Amount

                        // Formatting (matching PDF)
                        row.getCell(3).numFmt = '#,##0'; // Qty
                        row.getCell(5).numFmt = '#,##0.00'; // Rate
                        row.getCell(6).numFmt = '0'; // Discount % (no decimals in PDF)
                        row.getCell(7).numFmt = '#,##0.00'; // Amount
                        row.getCell(1).alignment = { horizontal: 'center' };
                        row.getCell(3).alignment = { horizontal: 'center' };
                        row.getCell(4).alignment = { horizontal: 'center' };
                        row.getCell(5).alignment = { horizontal: 'right' };
                        row.getCell(6).alignment = { horizontal: 'right' };
                        row.getCell(7).alignment = { horizontal: 'right' };

                        // No borders on detail rows (borders only on header and last row)

                        currentRow++;
                    });
                    var detailEndRow = currentRow - 1;
                    
                    // Add thick bottom border only to last detail row (no other borders) - columns A-G (indices 1-7)
                    var lastDetailRow = worksheet.getRow(detailEndRow);
                    for (var c = 1; c <= 7; c++) {
                        lastDetailRow.getCell(c).border = {
                            bottom: { style: 'medium', color: { argb: 'FF000000' } }
                        };
                    }
                    
                    currentRow += 2; // Blank row

                    // === FOOTER SECTION (matching PDF: Extra Charges Left, Summary Right) ===
                    var footerStartRow = currentRow;

                    // Left column: Extra Charges (columns A-B)
                    var extraChargeRow = footerStartRow;
                    extraCharges.forEach(function(charge) {
                        var row = worksheet.getRow(extraChargeRow);
                        row.getCell(1).value = charge.charge_type || '';
                        row.getCell(2).value = Number(parseFloat(charge.charge_amount || 0).toFixed(2));
                        row.getCell(2).numFmt = '#,##0.00';
                        row.getCell(2).alignment = { horizontal: 'right' };
                        extraChargeRow++;
                    });

                    // Summary Totals section (merged D:E for Label + Colon, Value in G)
                    var summaryRow = footerStartRow;
                    function addSummaryRowRight(label, value, isBold, hasBottomBorder) {
                        var row = worksheet.getRow(summaryRow);
                        // Merge columns D and E for label + colon
                        var colD = String.fromCharCode(68); // 'D'
                        var colE = String.fromCharCode(69); // 'E'
                        var colG = String.fromCharCode(71); // 'G'
                        worksheet.mergeCells(colD + summaryRow + ':' + colE + summaryRow);
                        
                        // Set merged cell value (label only, colon is in column F)
                        row.getCell(4).value = label; // Merged D:E: Label (no colon)
                        row.getCell(4).alignment = { horizontal: 'left' };
                        
                        // Add colon in column F
                        row.getCell(6).value = ':'; // Column F: Colon
                        row.getCell(6).alignment = { horizontal: 'center' };
                        
                        // Value in column G
                        row.getCell(7).value = value; // Column G: Value
                        row.getCell(7).alignment = { horizontal: 'right' };
                        row.getCell(7).numFmt = '#,##0.00';
                        
                        if (isBold) {
                            row.getCell(4).font = { bold: true };
                            row.getCell(6).font = { bold: true };
                            row.getCell(7).font = { bold: true };
                        }
                        if (hasBottomBorder) {
                            row.getCell(7).border = row.getCell(7).border || {};
                            row.getCell(7).border.bottom = { style: 'thin', color: { argb: 'FF000000' } };
                        }
                        summaryRow++;
                    }

                    addSummaryRowRight('Grand Total', invGrossTotal, false, false);
                    // Discount Total: Show in parentheses format like (1,200)
                    var discountVal = totalDiscount > 0 ? -totalDiscount : totalDiscount;
                    var discountRow = worksheet.getRow(summaryRow);
                    // Merge columns D and E for label + colon
                    var colD = String.fromCharCode(68); // 'D'
                    var colE = String.fromCharCode(69); // 'E'
                    worksheet.mergeCells(colD + summaryRow + ':' + colE + summaryRow);
                    discountRow.getCell(4).value = 'Discount Total';
                    discountRow.getCell(4).alignment = { horizontal: 'left' };
                    discountRow.getCell(6).value = ':';
                    discountRow.getCell(6).alignment = { horizontal: 'center' };
                    discountRow.getCell(7).value = discountVal;
                    discountRow.getCell(7).alignment = { horizontal: 'right' };
                    discountRow.getCell(7).numFmt = '#,##0.00;(#,##0.00)'; // Show negative numbers in parentheses
                    discountRow.getCell(7).border = discountRow.getCell(7).border || {};
                    discountRow.getCell(7).border.bottom = { style: 'thin', color: { argb: 'FF000000' } };
                    summaryRow++;
                    addSummaryRowRight('Net Amount', netTotalAfterDiscount, false, false);
                    addSummaryRowRight('Advance', advance > 0 ? (advance) : advance, false, true);
                    addSummaryRowRight('Total Paid', totalPaid + advance, true, false);
                    
                    // Net Balance with top and double bottom border (matching PDF) - merged D:E, colon in F, value in G
                    var netBalanceRow = worksheet.getRow(summaryRow);
                    // Merge columns D and E for "Net Balance :"
                    var colD = String.fromCharCode(68); // 'D'
                    var colE = String.fromCharCode(69); // 'E'
                    worksheet.mergeCells(colD + summaryRow + ':' + colE + summaryRow);
                    
                    netBalanceRow.getCell(4).value = 'Net Balance'; // Merged D:E: Label (no colon, colon is in column F)
                    netBalanceRow.getCell(6).value = ':'; // Column F: Colon
                    netBalanceRow.getCell(7).value = totalNetBalance; // Column G: Value
                    netBalanceRow.getCell(4).font = { bold: true };
                    netBalanceRow.getCell(6).font = { bold: true };
                    netBalanceRow.getCell(7).font = { bold: true };
                    netBalanceRow.getCell(4).alignment = { horizontal: 'left' };
                    netBalanceRow.getCell(6).alignment = { horizontal: 'center' };
                    netBalanceRow.getCell(7).alignment = { horizontal: 'right' };
                    netBalanceRow.getCell(7).numFmt = '#,##0.00';
                    // Top and double bottom border matching PDF - apply to all columns D, E (merged), F, G
                    // Column D (merged D:E)
                    netBalanceRow.getCell(4).border = {
                        top: { style: 'thin', color: { argb: 'FF000000' } },
                        bottom: { style: 'double', color: { argb: 'FF000000' } }
                    };
                    // Column F (colon)
                    netBalanceRow.getCell(6).border = {
                        top: { style: 'thin', color: { argb: 'FF000000' } },
                        bottom: { style: 'double', color: { argb: 'FF000000' } }
                    };
                    // Column G (value)
                    netBalanceRow.getCell(7).border = {
                        top: { style: 'thin', color: { argb: 'FF000000' } },
                        bottom: { style: 'double', color: { argb: 'FF000000' } }
                    };

                    // === BOTTOM FOOTER (company info + social text) ===
                    // Leave one blank row after totals block
                    currentRow = summaryRow + 3;

                    // Company name (left side) - merge A:D only (leaving E and F free)
                    worksheet.mergeCells('A' + currentRow + ':D' + currentRow);
                    var companyRow = worksheet.getCell('A' + currentRow);
                    companyRow.value = 'Edirisingha Cushion Works (Pvt) Ltd';
                    companyRow.font = { bold: true, size: 11 };
                    companyRow.alignment = { horizontal: 'left', vertical: 'middle' };

                    // "FIND US" title in column E, first row
                    var findUsStartRow = currentRow;
                    var findUsRow = worksheet.getCell('E' + findUsStartRow);
                    findUsRow.value = 'FIND US';
                    findUsRow.font = { bold: true, size: 11 };
                    findUsRow.alignment = { horizontal: 'left', vertical: 'middle' };

                    currentRow++;

                    // Head office contact info (left) - merge A:D only (leaving E and F free)
                    worksheet.mergeCells('A' + currentRow + ':D' + currentRow);
                    var contactRow = worksheet.getCell('A' + currentRow);
                    contactRow.value = 'Head Office - Nittambuwa 0332 286 729';
                    contactRow.font = { size: 10 };
                    contactRow.alignment = { horizontal: 'left', vertical: 'middle' };
                    
                    // "FOLLOW US" title in column E, second row
                    var followUsRow = worksheet.getCell('E' + currentRow);
                    followUsRow.value = 'FOLLOW US';
                    followUsRow.font = { bold: true, size: 11 };
                    followUsRow.alignment = { horizontal: 'left', vertical: 'middle' };

                    // Set row heights for merged cells
                    worksheet.getRow(findUsStartRow).height = 25;
                    worksheet.getRow(currentRow).height = 25;
                    
                    // Social media logos in columns F and G, merged across 2 rows
                    // Merge columns F and G across 2 rows for logo placement (column E is used for "FIND US")
                    worksheet.mergeCells('F' + findUsStartRow + ':G' + currentRow);
                    
                    var socialLogoKeys = ['facebook', 'tiktok', 'instagram', 'youtube'];
                    var centerRow = findUsStartRow - 0.5; // Center of merged cell vertically (0-based)
                    var logoSize = 18;
                    var baseCol = 5; // Column F index (0-based)
                    var spacing = 0.35; // Column spacing between logos (adjusted to fit 4 icons in 2 columns)
                    var totalSpacing = spacing * (socialLogoKeys.length - 1);
                    var startColOffset = -totalSpacing / 2; // Center the group within F-G merged area
                    
                    socialLogoKeys.forEach(function(key, index) {
                        if (socialLogos && socialLogos[key]) {
                            try {
                                var imageId = workbook.addImage({
                                    base64: socialLogos[key],
                                    extension: 'png'
                                });
                                // Position logos horizontally within merged F-G area with proper spacing
                                var colOffset = startColOffset + (index * spacing);
                                worksheet.addImage(imageId, {
                                    tl: { col: baseCol + colOffset, row: centerRow - 0.2 },
                                    ext: { width: logoSize, height: logoSize }
                                });
                            } catch (e) {
                                console.log('Error adding ' + key + ' logo:', e);
                            }
                        }
                    });
                    
                    // Fallback text if logos not available
                    if (!socialLogos || !socialLogos.facebook) {
                        var socialRow = worksheet.getCell('G' + findUsStartRow);
                        socialRow.value = 'Facebook  |  Instagram  |  TikTok  |  YouTube';
                        socialRow.font = { size: 10 };
                        socialRow.alignment = { horizontal: 'right', vertical: 'middle' };
                    }

                    currentRow++;

                    // Tagline centered across columns A-G
                    worksheet.mergeCells('A' + currentRow + ':G' + currentRow);
                    var taglineRow = worksheet.getCell('A' + currentRow);
                    taglineRow.value = "SOUTH ASIA'S LARGEST INTERIOR MODIFICATION CENTER";
                    taglineRow.font = { size: 10 };
                    taglineRow.alignment = { horizontal: 'center', vertical: 'middle' };

                    var lastRowNumber = currentRow;

                    // Generate and download file
                    var fileName = (main.invoice_number || ('invoice_' + invoiceId)) + ".xlsx";

                    workbook.xlsx.writeBuffer().then(function(buffer) {
                        var blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                        var link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.download = fileName;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        URL.revokeObjectURL(link.href);
                    }).catch(function(err) {
                        console.error('Error generating Excel file:', err);
                        alert('Error generating Excel file.');
                    });
                } // End of generateExcelWithLogo function
            },
            error: function() {
                alert('Server error occurred while fetching invoice details.');
            }
        });
    });

    // Print invoice details using existing invoicePDF endpoint
    $(document).on('click', '.btnPrintInvoice', function() {
        var invoiceId = $(this).data('id');
        var seriesId = $(this).data('series') || '';

        if (!invoiceId) {
            alert('Missing invoice ID to print.');
            return;
        }

        var url = base_url + 'Invoice/invoicePDF?invoice_id=' +
            encodeURIComponent(invoiceId) + '&series_id=' + encodeURIComponent(seriesId);

        window.open(url, '_blank');
    });

};


function selectInvoiceType(type) {
    const baseUrl = "<?= base_url('Invoice/invoiceDetailIndex/') ?>";
    window.location.href = baseUrl + type;
}

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}


function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to active this?");
}

function delete_confirm() {
    return confirm("Are you sure you want to remove this?");
}
</script>
<?php include "include/footer.php"; ?>