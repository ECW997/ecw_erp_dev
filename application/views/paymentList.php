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
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
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
    </style>
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-align-left"></i></div>
                            <span>Payment List</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-end">
                        <div class="row">
                            <div class="col">
                                <a href="<?= base_url('Payment/paymentDetailIndex') ?>" 
                                class="btn btn-primary btn-sm px-4 mt-auto p-2 <?php if($addcheck==0){echo 'd-none';} ?>">
                                <i class="fas fa-plus mr-3"></i>Create New Payment
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap w-100"
                                        id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Receipt No</th>
                                                <th>Draft Receipt No</th>
                                                <th>Date</th>
                                                <th>Customer Name</th>
                                                <th>Payment Type</th>
                                                <th>Payment Amount</th>
                                                <th>Status</th>
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
        </main>


        <!-- Invoice Type Modal -->
       <div class="modal fade" id="invoiceTypeModal" tabindex="-1" role="dialog" aria-labelledby="invoiceTypeModalLabel"
       	aria-hidden="true" data-backdrop="static" data-keyboard="false">
       	<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
       		<div class="modal-content border-0">
       			<div class="modal-header bg-primary text-white p-3">
       				<div class="w-100 text-center">
       					<i class="fas fa-file-invoice fa-2x mb-2"></i>
       					<h5 class="modal-title font-weight-bold mb-0" id="invoiceTypeModalLabel">
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
       					<button type="button" class="btn btn-option btn-light p-3 rounded text-left border"
       						id="indirect" onclick="selectInvoiceType('indirect')">
       						<div class="d-flex align-items-center">
       							<div class="rounded-circle bg-light-orange p-2 mr-3">
       								<i class="fas fa-car text-warning"></i>
       							</div>
       							<div>
       								<div class="font-weight-bold">Job Card Invoice</div>
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
<script>
var addcheck = '<?php echo $addcheck; ?>';
var editcheck = '<?php echo $editcheck; ?>';
var statuscheck = '<?php echo $statuscheck; ?>';
var deletecheck = '<?php echo $deletecheck; ?>';

$(document).ready(function() {
    var base_url = "<?php echo base_url(); ?>";

    $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        "buttons": [{
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                title: 'Receipt List',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Receipt List',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Receipt List',
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
            url: apiBaseUrl + '/v1/payment',
            type: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + api_token
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
                "data": "receipt_number"
            },
            {
                "data": "draft_receipt_number"
            },
            {
                "data": "receipt_date"
            },
            {
                "data": "customer_name"
            },
            {
                "data": "payment_type"
            },
            {
                "data": "total_received_amount",
                "className": "text-end",
                "render": function(data, type, full) {
                    return parseFloat(data).toFixed(2);
                }
            },
            {
                "data": "status"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button += '<a href="' + base_url + 'Payment/paymentDetailIndex/' + full[
                            'id'] +
                        '" title="View" class="btn btn-secondary btn-sm btnView mr-1">' +
                        '<i class="fas fa-external-link-alt"></i></a>';
                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

});

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