<?php 
include "include/header.php";  

include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <style>
        

        .custom-modal .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }
        
        .section-header {
            color: #495057;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .detail-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .detail-card-header {
            background-color: #f8f9fa;
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            border-radius: 8px 8px 0 0;
            font-weight: 600;
            color: #495057;
        }
        
        .detail-card-body {
            padding: 15px;
        }
        
        .detail-table {
            margin-bottom: 0;
        }
        
        .detail-table th {
            width: 40%;
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            padding: 0.50rem
        }

        .detail-table td {
            padding: 0.50rem
        }
        
        .action-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 600;
        }
        
        .status-open {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-closed {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-verified {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        </style>
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa fa-coins" aria-hidden="true"></i></div>
                            <span>Finance</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-end">
                        <div class="row">
                            <div class="col">
                                <button type="button" id="addBtn"
                                    class="btn btn-primary btn-sm px-4 mt-auto p-2 <?php if($addcheck==0){echo 'd-none';} ?>"
                                    onclick="showInsertModal();">
                                    <i class="fas fa-plus mr-3"></i>Job Option</button>
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
                                                <th>Cashier</th>
                                                <th>Open at</th>
                                                <!-- <th>Opening Balance Cash</th>
                                                <th>Opening Balance Slips</th>
                                                <th>Opening Balance Cheques</th> -->
                                                <th>Opening Balance Approve Status</th>
                                                <th>Closed at </th>
                                                <!-- <th>Closing Balance Cash</th>
                                                <th>Closing Balance Slips</th>
                                                <th>Closing Balance Cheques</th> -->
                                                <th>Closing Balance Approve Status</th>
                                                <th>Shift Status</th>
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

        <div class="modal fade custom-modal" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="viewModalLabel">
                            <i class="fas fa-clipboard-list mr-2"></i>Shift Details
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                
                    <div class="modal-body">
                        <div class="text-center"><div class="spinner-grow text-primary" role="status"></div></div>
                        <div class="detail-card d-none">
                            <div class="detail-card-header">
                                <i class="fas fa-door-open "></i>Opening Details
                            </div>
                            <div class="detail-card-body">
                                <table class="table table-bordered detail-table">
                                    <tbody>
                                        <tr>
                                            <th>Cashier</th>
                                            <td id="modal_cashier_name">John Doe</td>
                                        </tr>
                                        <tr>
                                            <th>Opened At</th>
                                            <td id="modal_opened_at"></td>
                                        </tr>
                                        <tr>
                                            <th>Opening Balance (Cash)</th>
                                            <td id="modal_opening_balance_cash"></td>
                                        </tr>
                                        <tr>
                                            <th>Opening Balance (Slips)</th>
                                            <td id="modal_opening_balance_slips"></td>
                                        </tr>
                                        <tr>
                                            <th>Opening Balance (Cheques)</th>
                                            <td id="modal_opening_balance_cheques"></td>
                                        </tr>
                                        <tr>
                                            <th>Opening Approved By</th>
                                            <td id="modal_opening_approved_by"></td>
                                        </tr>
                                        <tr>
                                            <th>Opening Approved At</th>
                                            <td id="modal_opening_approved_at"></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="action-section" id="opening_approve_section">
                                    <button type="button" class="btn btn-success btn-sm d-flex align-items-center" id="btnApproveOpening">
                                        <i class="fas fa-check-circle mr-2"></i> Approve Opening
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="detail-card d-none">
                            <div class="detail-card-header">
                                <i class="fas fa-door-closed "></i>Closing Details
                            </div>
                            <div class="detail-card-body">
                                <table class="table table-bordered detail-table">
                                    <tbody>
                                        <tr>
                                            <th>Closed At</th>
                                            <td id="modal_closed_at"></td>
                                        </tr>
                                        <tr>
                                            <th>Closing Balance (Cash)</th>
                                            <td id="modal_closing_balance_cash">/td>
                                        </tr>
                                        <tr>
                                            <th>Closing Balance (Slips)</th>
                                            <td id="modal_closing_balance_slips"></td>
                                        </tr>
                                        <tr>
                                            <th>Closing Balance (Cheques)</th>
                                            <td id="modal_closing_balance_cheques"></td>
                                        </tr>
                                         <tr>
                                            <th>Closing Verified By</th>
                                            <td id="modal_closing_verified_by"></td>
                                        </tr>
                                        <tr>
                                            <th>Closing Verified At</th>
                                            <td id="modal_closing_verified_at"></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="status-badge status-verified" id="modal_status"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Remarks</th>
                                            <td id="modal_remarks"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="action-section">
                                    <div class="shift-sales mb-3 p-2 border rounded bg-light">
                                        <strong>Shift Sales Amount:</strong>
                                        <span id="modal_shift_sales_amount"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="selectCashHandover" class="font-weight-bold">Cash Handover By</label>
                                        <select class="form-control" id="selectCashHandover">
                                            <option value="">Select Cash Handover By</option>
                                            <option value="1">Manager - Jane Smith</option>
                                            <option value="2">Supervisor - Robert Johnson</option>
                                            <option value="3">Assistant Manager - Sarah Williams</option>
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center" id="btnVerifyClosing">
                                        <i class="fas fa-clipboard-check mr-2"></i> Verify Closing
                                    </button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="recordId" name="recordId"/>
                    </div>
                    
                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm d-flex align-items-center" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i> Close
                        </button>
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

    $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-5'><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        "buttons": [{
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                title: 'Job Option Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Job Option Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Job Option Information',
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
            url: apiBaseUrl + '/v1/get_all_cashier_log',
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
       "columns": [
            { "data": "cashier_name" },
            { "data": "opened_at" },
            // {
            //     "data": "opening_balance_cash",
            //     "className": "text-right",
            //     "render": function(data) {
            //         return data && !isNaN(data) 
            //             ? parseFloat(data).toLocaleString('en-US', {minimumFractionDigits: 2}) 
            //             : data;
            //     }
            // },
            // {
            //     "data": "opening_balance_slips",
            //     "className": "text-right",
            //     "render": function(data) {
            //         return data && !isNaN(data) 
            //             ? parseFloat(data).toLocaleString('en-US', {minimumFractionDigits: 2}) 
            //             : data;
            //     }
            // },
            // {
            //     "data": "opening_balance_cheques",
            //     "className": "text-right",
            //     "render": function(data) {
            //         return data && !isNaN(data) 
            //             ? parseFloat(data).toLocaleString('en-US', {minimumFractionDigits: 2}) 
            //             : data;
            //     }
            // },
            { 
                "data": "opening_status",
                "className": "text-center",
                "render": function(data) {
                    let baseClasses = "badge badge-pill";
                    let style = "";

                    switch (data) {
                        case 'Not Approved':
                            style = 'background-color: #EF4444; color: #FFFFFF;'; 
                            break;
                        case 'Approved':
                            style = 'background-color: #10B981; color: #FFFFFF;'; 
                            break;
                        default:
                            style = 'background-color: #6B7280; color: #FFFFFF;'; 
                            break;
                    }
                    return `<span class="${baseClasses}" style="${style}">${data}</span>`;
                }
            },
            { "data": "closed_at" },
            // {
            //     "data": "closing_balance_cash_display",
            //     "className": "text-right",
            //     "render": function(data) {
            //         return data && !isNaN(data) 
            //             ? parseFloat(data).toLocaleString('en-US', {minimumFractionDigits: 2}) 
            //             : data;
            //     }
            // },
            // {
            //     "data": "closing_balance_slips_display",
            //     "className": "text-right",
            //     "render": function(data) {
            //         return data && !isNaN(data) 
            //             ? parseFloat(data).toLocaleString('en-US', {minimumFractionDigits: 2}) 
            //             : data;
            //     }
            // },
            // {
            //     "data": "closing_balance_cheques_display",
            //     "className": "text-right",
            //     "render": function(data) {
            //         return data && !isNaN(data) 
            //             ? parseFloat(data).toLocaleString('en-US', {minimumFractionDigits: 2}) 
            //             : data;
            //     }
            // },
            { 
                "data": "closing_status",
                "className": "text-center",
                "render": function(data) {
                    let baseClasses = "badge badge-pill";
                    let style = "";

                    switch (data) {
                        case 'Not Verified':
                            style = 'background-color: #EF4444; color: #FFFFFF;'; 
                            break;
                        case 'Verified':
                            style = 'background-color: #10B981; color: #FFFFFF;'; 
                            break;
                        default:
                            style = 'background-color: #6B7280; color: #FFFFFF;'; 
                            break;
                    }
                    return `<span class="${baseClasses}" style="${style}">${data}</span>`;
                }
            },
            { 
                "data": "shift_status",
                "className": "text-center",
                "render": function(data) {
                    let baseClasses = "badge badge-pill";
                    let style = "";

                    switch (data) {
                        case 'Open':
                            style = 'background-color: #10B981; color: #FFFFFF;'; 
                            break;
                        case 'Closed':
                            style = 'background-color: #6B7280; color: #FFFFFF;'; 
                            break;
                        case 'Verified':
                            style = 'background-color: #3B82F6; color: #FFFFFF;'; 
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
                "render": function(data, type, full) {
                    var button = '';
                    button +=
                        '<button title="View" class="btn btn-secondary btn-sm btnView mr-1 " onclick="showViewModal(' +
                        full['id'] +
                        ');"><i class="fas fa-eye"></i></button>';
                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

});

$(document).on('click', '#btnApproveOpening', function () {
    let $btn = $(this); 

    if (confirm("Are you sure you want to updat the open balances?")) {
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Approving...');

        let id = $('#recordId').val();
        $.ajax({
            url: '<?php echo base_url(); ?>Cashier/approveShiftOpeningBalances',
            type: 'POST',
            data: { record_id: id },
            dataType: 'json',
            success: function(result) {
                if(result.status) {
                    success_toastify(result.message);
                    $('.detail-card').addClass('d-none');
                    $('.spinner-grow').removeClass('d-none');
                    showViewModal(id);
                } else {
                    alert('Error: ' + res.message);
                    $btn.prop('disabled', false).text('<i class="fas fa-check-circle mr-2"></i> Approve Opening');
                }
            },
            error: function(xhr) {
                alert('Error closing shift (Code ' + xhr.status + ')');
                $btn.prop('disabled', false).text('<i class="fas fa-check-circle mr-2"></i> Approve Opening'); 
            }
        });
    }

});

function showViewModal(id) {
    $('#viewModal').modal('show');
    $.ajax({
            url: '<?php echo base_url() ?>Cashier/getCashierShiftRecDetails/'+id,
            type: "GET",
            dataType: 'json',
            success: function(res){
                if (res.status === true) {
                    let data = res.shift;
                    $('.detail-card').removeClass('d-none');
                    $('.spinner-grow').addClass('d-none');

                    $('#modal_cashier_name').text(data.cashier_name);
                    $('#modal_opened_at').text(data.opened_at);
                    $('#modal_opening_balance_cash').text(data.opening_balance_cash != null ? parseFloat(data.opening_balance_cash).toLocaleString('en-US', { minimumFractionDigits: 2 }) : '0.00');
                    $('#modal_opening_balance_slips').text(data.opening_balance_slips != null ? parseFloat(data.opening_balance_slips).toLocaleString('en-US', { minimumFractionDigits: 2 }) : '0.00');
                    $('#modal_opening_balance_cheques').text(data.opening_balance_cheques != null ? parseFloat(data.opening_balance_cheques).toLocaleString('en-US', { minimumFractionDigits: 2 }) : '0.00');
                    $('#modal_opening_approved_at').text(data.opening_approved_at ?? '-');
                    $('#modal_opening_approved_by').text(data.opening_approver);
                    $('#modal_closed_at').text(data.closed_at ?? '-');
                    $('#modal_closing_balance_cash').text(data.closing_balance_cash != null ? parseFloat(data.closing_balance_cash).toLocaleString('en-US', { minimumFractionDigits: 2 }) : '0.00');
                    $('#modal_closing_balance_slips').text(data.closing_balance_slips != null ? parseFloat(data.closing_balance_slips).toLocaleString('en-US', { minimumFractionDigits: 2 }) : '0.00');
                    $('#modal_closing_balance_cheques').text(data.closing_balance_cheques != null ? parseFloat(data.closing_balance_cheques).toLocaleString('en-US', { minimumFractionDigits: 2 }) : '0.00');
                    $('#modal_closing_verified_at').text(data.closing_verified_at ?? '-');
                    $('#modal_closing_verified_by').text(data.verifier_name);
                    $('#modal_status').text(data.status_text);
                    $('#modal_remarks').text(data.remarks);
                    $('#modal_shift_sales_amount').text(data.shift_total_sales != null ? parseFloat(data.shift_total_sales).toLocaleString('en-US', { minimumFractionDigits: 2 }) : '0.00');
                    $('#recordId').val(data.id);

                    console.log(data.opening_approved_at);
                    
                    data.opening_approved_at == null ? $('#opening_approve_section').removeClass('d-none') : $('#opening_approve_section').addClass('d-none');
                    
                } else {
                    falseResponse(res.message || "Unexpected error checking shift");
                }
            },
            error: function (xhr) {
                falseResponse("Error: Unable to check shift (Code " + xhr.status + ")");
            }
    });
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