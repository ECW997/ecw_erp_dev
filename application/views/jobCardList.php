<?php 
include "include/header.php";  

include "include/topnavbar.php"; 
?>
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
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
        	    <div class="container-fluid">
        			<div class="page-header-content py-3 d-flex justify-content-between align-items-center">
        				<h1 class="page-header-title">
        					<div class="page-header-icon"><i class="fas fa-list-ul"></i></div>
        					<span>Job Card List</span>
        				</h1>
                        <a href="<?= base_url('JobCard/jobCardDetailIndex') ?>" class="btn btn-primary btn-sm px-4 p-2 <?php if($addcheck==0){echo 'd-none';} ?>">
                            <i class="fas fa-plus mr-2"></i>Create New JobCard
                        </a>
        			</div>
        		</div>
        	</div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="p-2">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3 d-flex align-items-center justify-content-start">
                                <label for="date_from" class="mb-0 mr-2">Date Filter</label>
                                <div class="input-group">
                                    <input type="date" id="date_from" class="form-control form-control-sm" aria-label="Date From" />
                                    <div class="input-group-append">
                                    <span class="input-group-text">to</span>
                                    </div>
                                    <input type="date" id="date_to" class="form-control form-control-sm" aria-label="Date To" />
                                </div>
                            </div>

                            <div class="col-12 col-md-9 d-flex align-items-center justify-content-end flex-wrap">
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="sales_agent" class="mb-0 mr-2">Sales Agent</label>
                                    <select id="sales_agent" class="custom-select custom-select-sm" style="min-width: 130px;">
                                    <option value="">All</option>
                                       <?php if (!empty($sales_agents)) : ?>
                                            <?php foreach ($sales_agents as $agent) : ?>
                                                <option value="<?= $agent['idtbl_sales_person']; ?>">
                                                    <?= htmlspecialchars($agent['sales_person_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="job_status" class="mb-0 mr-2">Job Status</label>
                                    <select id="job_status" class="custom-select custom-select-sm" style="min-width: 130px;">
                                    <option value="">All</option>
                                    <option value="0">Not Started</option>
                                    <option value="1">Started</option>
                                    <option value="2">Job Done</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="status" class="mb-0 mr-2">Status</label>
                                    <select id="status" class="custom-select custom-select-sm" style="min-width: 130px;">
                                    <option value="">All Status</option>
                                    <option value="Draft">Draft</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                                 <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="payment_status" class="mb-0 mr-2">Payment Status</label>
                                    <select id="payment_status" class="custom-select custom-select-sm" style="min-width: 130px;">
                                    <option value="">All Status</option>
                                    <option value="0">Payment Pending</option>
                                    <option value="1">Payment Paid</option>
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
                                <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
        								<thead>
        									<tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Job Card No</th>
                                                <th>Customer</th>
                                                <th>Vehicle Number</th>
                                                <th>Vehicle Brand</th>
                                                <th>Vehicle Model</th>
                                                <th>Scheduled</th>
                                                <th>Completed</th>
                                                <th>Handover</th>
                                                <th>Sales Agent</th>
                                                <th>Job Status</th>
                                                <th>Status</th>
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
        </main>

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



    $(document).ready(function() {
      var base_url = "<?php echo base_url(); ?>";

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'l><'col-sm-2'><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Job Card List', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Job Card List', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Job Card List',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
            ],
            ajax: {
                url: apiBaseUrl+'/v1/job_card', 
                type: "GET",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + api_token 
                }, 
                 data: function(d) {
                    d.date_from = $('#date_from').val();
                    d.date_to = $('#date_to').val();
                    d.sales_agent = $('#sales_agent').val();
                    d.job_status = $('#job_status').val();
                    d.status = $('#status').val();
                    d.payment_status = $('#payment_status').val();
                },
                dataSrc: function (json) {
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
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_jobcard"
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
                    "data": "brand_name"
                },
                {
                    "data": "model_name"
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
                    data: "status",
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
                    data: "payment_status",
                    className: "text-center",
                    render: function (data, type, row) {
                        let baseClasses = "badge badge-pill";
                        let style = "";
                        let status = "";

                        switch (data) {
                            case '0':
                                style = 'background-color: #e81500; color: #FFFFFF;'; 
                                status = 'Payment Pending';
                                break;
                            case '1':
                                style = 'background-color: #00ac69; color: #1F2937;'; 
                                status = 'Payment Paid';
                                break;
                            default:
                                style = 'background-color: #4B5563; color: #FFFFFF;'; 
                                break;
                        }
                        return `<span class="${baseClasses}" style="${style}">${status}</span>`;
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button += '<a href="' + base_url + 'JobCard/jobCardDetailIndex/' + full['idtbl_jobcard'] + '" title="View" class="btn btn-secondary btn-sm btnView mr-1">' +
                        '<i class="fas fa-external-link-alt"></i></a>';
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $(document).on('click', '#addtolistBtn', function(){
           var sub_job_category = $('#sub_job_category').val();
           var group_name = $('#group_name').val();
           var sort_order = $('#sort_order').val();
           var description = $('#description').val();
           var recordID = $('#recordID').val();
           var recordOption = $('#recordOption').val();

           $.ajax({
                type: "POST",
                dataType: 'json',
                data: {
                    sub_job_category: sub_job_category,
                    group_name: group_name,
                    sort_order: sort_order,
                    description: description,
                    recordOption: recordOption,
                    recordID: recordID
                },
                url: '<?php echo base_url() ?>JobOptionGroup/jobOptionGroupInsertUpdate',
                success: function(result) { 
                    if (result.status == true) {
                        cancelBtn();
                        success_toastify(result.message);
                        showGroupDetailsList(sub_job_category,1);
                    } else {
                        falseResponse(result);
                    }
                }
            });
        })
        
        $(document).on('click', '.detailEditBtn', function() {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: '<?php echo base_url() ?>JobOptionGroup/jobOptionGroupEdit/'+id,
                    success: function(result) { 
                        if(result.status){
                            $('#recordID').val(result.data.id);
                            $('#group_name').val(result.data.group_name);
                            $('#sort_order').val(result.data.sort_order);
                            $('#description').val(result.data.description);

                            $('#recordOption').val('2');
                            $('#addtolistBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                            $('#cancellistBtn').removeClass('d-none');
                        }else{
                            falseResponse(result);
                        }
                    }
                });
            }
        });

        $(document).on('click', '.detailStatusBtn', function() {
            var status = $(this).attr('status');
            var r = (status == '1'? confirm("Are you sure, You want to Active this ? ") : confirm("Are you sure, You want to Deactive this ? "));
            if (r == true) {
                var id = $(this).attr('id');
                var sub_id = $(this).attr('sub_id');
                $.ajax({
                    type: "PUT",
                    dataType: 'json',
                    url: '<?php echo base_url() ?>JobOptionGroup/jobOptionGroupStatus/'+id+'/'+status,
                    success: function(result) { 
                        if(result.status){
                            showGroupDetailsList(sub_id,1);
                            success_toastify(result.message);
                        }else{
                            falseResponse(result);
                        }
                    }
                });
            }
        });

        $(document).on('click', '.detailDeleteBtn', function() {
            var r = confirm("Are you sure, You want to Delete this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                var sub_id = $(this).attr('sub_id');
                $.ajax({
                    type: "DELETE",
                    dataType: 'json',
                    url: '<?php echo base_url() ?>JobOptionGroup/jobOptionGroupDelete/'+id,
                    success: function(result) { 
                        if(result.status){
                            showGroupDetailsList(sub_id,1);
                            success_toastify(result.message);
                        }else{
                            falseResponse(result);
                        }
                    }
                });
            }
        });

        $('#filterBtn').on('click', function() {
            $('#dataTable').DataTable().ajax.reload();
        });

        $('#clearFilterBtn').on('click', function() {
            $('#date_from, #date_to, #sales_agent, #job_status, #status, #payment_status').val('');
            $('#dataTable').DataTable().ajax.reload();
        });
    });

    function showInsertModal() {
        $('#main_job_category').val('').trigger('change');
        $('#sub_job_category').val('').trigger('change');
        $("#crudTable").html('');
        $('#addModal').modal('show');
        cancelBtn();
    }

    function showViewModal(sub_id) {
        showGroupDetailsList(sub_id,2);
        $('#viewModal').modal('show');
    }

    function showGroupDetailsList(sub_id,modalOption){  
        if(sub_id == ''){
            return false;
        }

        var tableOption = (modalOption == '2') ? 'viewTable' : 'crudTable';
        $("#"+tableOption+"").html('');
        $.ajax({
            type: "GET",
            url: '<?php echo base_url() ?>JobOptionGroup/jobOptionGroupDetailsList',
            data: { sub_id: sub_id, 
                    modalOption: modalOption,
                    editcheck: editcheck,
                    statuscheck: statuscheck,
                    deletecheck: deletecheck },
            success: function (result) {
                if(result){
                    $("#"+tableOption+"").html(result);
                }  
            },
            error: function () {
                $("#" + tableOption).html('<p class="text-center text-danger">Error fetching data!</p>');
            }
        });
    }

    function cancelBtn(){
        $('#group_name').val('');
        $('#sort_order').val('');
        $('#description').val('');
        $('#recordID').val('');
        $('#recordOption').val('1');
        $('#cancellistBtn').addClass('d-none');
        $('#addtolistBtn').html('<i class="fas fa-plus mr-2"></i>Add to list')
    }

    function checkedDublicate(input) {
        var inputValue = input.value;
        var table_name = 'job_optiongroups';
        var columnName = input.getAttribute('data-field');

        $.ajax({
            url: '<?php echo base_url() ?>CheckDublicate/check_duplicate',
            type: 'POST',
            dataType: 'json',
            data: {
                input_value: inputValue,
                table_name: table_name,
                column_name: columnName
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'error') {
                    $('#' + columnName + '_errorMsg').text(response.message).show();
                } else {
                    $('#' + columnName + '_errorMsg').hide();
                }
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
