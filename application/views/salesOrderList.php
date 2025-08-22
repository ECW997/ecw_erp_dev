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
    .card-header {
      background-color: white;
      border-bottom: 1px solid #6c757d;
      padding: 1rem 2rem;
    }
    label {
      color: #6c757d;
      font-weight: 700;
      font-size: 0.85rem;
      white-space: nowrap;
      margin-bottom: 0;
      line-height: 1.5;
    }
    .form-control-sm, .custom-select-sm {
      font-size: 0.85rem;
      padding: 0.25rem 0.5rem;
      height: 1.9rem;
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
    @media (max-width: 575.98px) {
      .card-header .row > div {
        margin-bottom: 0.5rem;
      }
      .card-header .row > div:last-child {
        margin-bottom: 0;
      }
    } 
    </style>
        <main>
            <div class="page-header page-header-light bg-white shadow">
        	    <div class="container-fluid">
        			<div class="page-header-content py-3 d-flex justify-content-between align-items-center">
        				<h1 class="page-header-title">
        					<div class="page-header-icon"><i class="fas fa-list-ul"></i></div>
        					<span>Sales Order List</span>
        				</h1>
                        <a href="<?= base_url('SalesOrder/salesOrderDetailIndex') ?>" class="btn btn-primary btn-sm px-4 p-2 <?php if($addcheck==0){echo 'd-none';} ?>">
                            <i class="fas fa-plus mr-2"></i>Create New Sales Order
                        </a>
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
                                    <option value="Draft">Draft</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Cancelled">Cancelled</option>
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
                                                <th>Date</th>
                                                <th>Job Card No</th>
                                                <th>Customer</th>
                                                <th>Vehicle</th>
                                                <th>Scheduled</th>
                                                <th>Completed</th>
                                                <th>Handover</th>
                                                <th>Sales Agent</th>
                                                <th>Job Status</th>
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
var approve1check = '<?php echo $approve1check; ?>';
var approve2check = '<?php echo $approve2check; ?>';
var approve3check = '<?php echo $approve3check; ?>';
var approve4check = '<?php echo $approve4check; ?>';
var cancelcheck = '<?php echo $cancelcheck; ?>';
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {
    loadPaymentListTable();

    $('#filterBtn').on('click', function() {
        loadPaymentListTable();
    });

    $('#clearFilterBtn').on('click', function() {
        $('#date_from, #date_to, #status').val('');
        loadPaymentListTable();
    });
});

$(document).on('click', '.btnCancel', function(e) {
    e.preventDefault();
    const paymentId = $(this).data('id');

    if (confirm("Are you sure you want to cancel this payment?")) {
        $.ajax({
            url: '<?php echo base_url() ?>Payment/cancelPayment/' + paymentId,
            method: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.status == true) {
                    success_toastify(result.message);
                    loadPaymentListTable();
                } else {
                    alert(result.message);
                }
            },
            error: function() {
                error_toastify('Error canceling payment. Please try again.');
            }
        });
    }
});

function loadPaymentListTable(){
    $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-5'l><'col-sm-2'><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
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
            url: apiBaseUrl + '/v1/sales_order',
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
        		"data": "relation_id"
        	},
        	{
        		"data": "jobcard_date"
        	},
        	{
        		"data": "job_card_number"
        	},
        	{
        		"data": "customer_name"
        	},
        	{
        		"data": "vehicle_number"
        	},
        	{
        		"data": "job_start_date"
        	},
        	{
        		data: "complete_date",
        		className: "text-center",
        		render: function (data, type, row) {
        			if (row.job_progress_status_text !== "Completed") {
        				return `<i class="fas fa-hourglass-half text-muted" title="In Progress"></i>`;
        			}

        			return `<span class="text-success">${data}</span>`;
        		}
        	},
        	{
        		"data": "handover_date"
        	},
        	{
        		"data": "sales_person_name"
        	},
        	{
        		data: "job_progress_status_text",
        		className: "text-center",
        		render: function (data, type, row) {
        			let baseClasses = "badge badge-pill";
        			let style = "";

        			switch (data) {
        				case "Not Started":
        					style = "background-color: #D9D9D9; color: #6B7280;";
        					break;
        				case "In Progress":
        					style = "background-color: #BBF7D0; color: #15803D;";
        					break;
        				case "Completed":
        					style = "background-color: #22C55E; color: #D1FAE5;";
        					break;
        				case "On Hold":
        					style = "background-color: #DC2626; color: #FEE2E2;";
        					break;
        				case "Pending RM":
        					style = "background-color: #FB923C; color: #FFEDD5;";
        					break;
        				default:
        					style = "background-color: #1F2937; color: #F3F4F6;";
        			}

        			return `<span class="${baseClasses}" style="${style}">${data}</span>`;
        		}
        	},
        	{
        		data: "relation_status",
        		className: "text-center",
        		render: function (data, type, row) {
        			let baseClasses = "badge badge-pill";
        			let style = "";

        			switch (data) {
        				case 'Draft':
        					style = 'background-color: #6B7280; color: #FFFFFF;';
        					break;
        				case 'Pending':
        					style = 'background-color: #F59E0B; color: #1F2937;';
        					break;
        				case 'Approved':
        					style = 'background-color: #10B981; color: #FFFFFF;';
        					break;
        				case 'Cancelled':
        					style = 'background-color: #EF4444; color: #FFFFFF;';
        					break;
        				case 'Re-Approve Pending':
        					style = 'background-color: #F97316; color: #FFFFFF;';
        					break;
        				case 'Re-Approved':
        					style = 'background-color: #059669; color: #FFFFFF;';
        					break;
        				default:
        					style = 'background-color: #4B5563; color: #FFFFFF;';
        					break;
        			}


        			return `<span class="${baseClasses}" style="${style}">${data}</span>`;
        		}
        	},
        	{
        		"targets": -1,
        		"className": 'text-right',
        		"data": null,
        		"render": function (data, type, full) {
        			var button = '';
        			button += '<a href="' + base_url + 'SalesOrder/salesOrderDetailIndex/' + full['relation_id'] + '" title="View" class="btn btn-secondary btn-sm btnView mr-1">' +
        				'<i class="fas fa-external-link-alt"></i></a>';
                    button +=
                            '<button title="Delete" class="btn btn-danger btn-sm btnDelete" data-id="' +
                            full['relation_id'] + '">' +
                            '<i class="fas fa-trash-alt"></i></button>';
        			return button;
        		}
        	}
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

$(document).on('click', '.btnDelete', function () {
 	var mainId = $(this).data('id');

 	if (!confirm("Are you sure you want to delete this Sales Order?")) {
 		return;
 	}

 	$.ajax({
 		url: base_url + "SalesOrder/SalesOrderDelete/" + mainId,
 		type: "DELETE",
 		dataType: "json",
 		success: function (response) {
 			if (response && response.status == true) {
 				success_toastify(response.message);
 				loadPaymentListTable();
 			} else {
 				falseResponse(response);
 			}
 		},
 		error: function () {
 			alert("Server error occurred.");
 		}
 	});
});

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