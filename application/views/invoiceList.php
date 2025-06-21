<?php 
include "include/header.php";  

include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
        <div class="page-header page-header-light bg-white shadow">
        		<div class="container-fluid">
        			<div class="page-header-content py-3">
        				<h1 class="page-header-title">
        					<div class="page-header-icon"><i class="fas fa-align-left"></i></div>
        					<span>Invoice List</span>
        				</h1>
        			</div>
        		</div>
        	</div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-end">
                        <div class="row">
                            <div class="col">
                                <a href="<?= base_url('Invoice/jobCardDetailIndex') ?>" 
                                class="btn btn-primary btn-sm px-4 mt-auto p-2 <?php if($addcheck==0){echo 'd-none';} ?>">
                                <i class="fas fa-plus mr-3"></i>Create New Invoice
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
        								<thead>
        									<tr>
                                                <th>#</th>
                                                <th>Invoice No</th>
                                                <th>Customer Name</th>
                                                <th>Invoice Date</th>
                                                <th>Status</th>
                                                <th>Amount</th>
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
    var addcheck='<?php echo $addcheck; ?>';
    var editcheck='<?php echo $editcheck; ?>';
    var statuscheck='<?php echo $statuscheck; ?>';
    var deletecheck='<?php echo $deletecheck; ?>';

    $(document).ready(function() {
      var base_url = "<?php echo base_url(); ?>";

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Invoice List', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Invoice List', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Invoice List',
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
                    "data": "job_card_number"
                },
                 {
                    "data": "job_progress_status_text"
                },
                 {
                    "data": "job_start_date"
                },
                 {
                    "data": "complete_date"
                },
                 {
                    "data": "handover_date"
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
