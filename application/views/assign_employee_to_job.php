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
        					<div class="page-header-icon"><i class="fas fa-th"></i></div>
        					<span>Assign Employee To Job</span>
        				</h1>
        			</div>
        		</div>
        	</div>
            <div class="container-fluid mt-2 p-0 p-2">
            <div class="card">
                <div class="card-body p-0 p-2">
                    <div class="card">
                        <div class="card-body p-0 p-2">
                            <form id="mainform_id" autocomplete="off">
                                <div class="row mb-3">
                                    <div class="col-3">
                                        <div class="form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Job Card Number*</label>
                                            <div id="jobcardNoDiv">
                                                <select class="form-control form-control-sm job_card_number" name="job_card_number"
                                                    id="job_card_number" required>
                                                    <option value="">Select</option>
                                                    <?php foreach($jobcardlist->result() as $rowjobcardlist){ ?>
                                                    <option value="<?php echo $rowjobcardlist->idtbl_jobcard ?>">
                                                        <?php echo $rowjobcardlist->job_card_number ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <input class="form-control form-control-sm job_card_number_show d-none" name="job_card_number_show" id="job_card_number_show" readonly>
                                        </div>
                                        <input type="hidden" name="recordOption" id="recordOption" value="1">
                                        <input type="hidden" name="recordID" id="recordID" value="">
                                    </div>
                                    <div class="col-3">
                                    <label class="small font-weight-bold text-dark">Assign Supervisor*</label><br>
                                    <button type="button" id="supervisorModelBtn" class="btn btn-info btn-sm px-4"><i class="fas fa-user-tag"></i></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="scrollbar pb-3" id="style-2">
                                            <table class="table table-bordered table-striped table-sm nowrap w-100"
                                                id="jobDetails">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Job Description</th>
                                                        <th colspan="3">Employee</th>
                                                        <!-- <th class="text-right">Actions</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody id="jobDetailsList"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 text-right">
                                        <input type="submit" id="submitBtn" hidden/>
                                        <button type="button" id="addBtn" class="btn btn-primary btn-sm px-4"
                                            <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
             
                    <div class="card mt-3">
                        <div class="card-body p-0 p-2">
                            <div class="row">
                                <div class="col-12">
                                    <div class="scrollbar pb-3" id="style-2">
                                        <table class="table table-bordered table-striped table-sm nowrap w-100"
                                            id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Job Card Number</th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="dataTablelist"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </main>

        <!-- Modal -->
        <div class="modal fade" id="viewModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLongTitle">View Assign Employees</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap w-100"
                                        id="viewjobDetails">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Job Description</th>
                                                <th colspan="3">Employee</th>
                                                <!-- <th class="text-right">Actions</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="viewjobDetailsList"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="supervisorModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Assign Supervisor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <form id="supervisor_add_form" autocomplete="off">
                                    <div class="row">
                                        <div class="col-3">
                                            <label class="small font-weight-bold text-dark">Job Card Number</label>
                                            <input type="text" class="form-control form-control-sm" name="s_jobcard_no"
                                                id="s_jobcard_no" required readonly>
                                            <input type="hidden" name="s_jobcard_id" id="s_jobcard_id">
                                        </div>
                                        <div class="col-3">
                                            <label class="small font-weight-bold text-dark">Comapny*</label>
                                            <select class="form-control form-control-sm s_compnay" name="s_compnay"
                                                id="s_compnay" required>
                                                <option value="">Select</option>
                                                <?php foreach($companylist->result() as $rowcompanylist){ ?>
                                                <option value="<?php echo $rowcompanylist->idtbl_company ?>">
                                                    <?php echo $rowcompanylist->company ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label class="small font-weight-bold text-dark">Department*</label>
                                            <select class="form-control form-control-sm s_department"
                                                name="s_department" id="s_department" required>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label class="small font-weight-bold text-dark">Supervisor*</label>
                                            <select class="form-control form-control-sm s_supervisor"
                                                name="s_supervisor" id="s_supervisor" required>
                                                <option value="">Select</option>
                                                <?php foreach($jobcardlist->result() as $rowjobcardlist){ ?>
                                                <option value="<?php echo $rowjobcardlist->idtbl_jobcard ?>">
                                                    <?php echo $rowjobcardlist->job_card_number ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 d-flex align-content-end justify-content-end">
                                        <button type="submit" class="btn btn-primary btn-sm px-4"><i
                                        class="far fa-save"></i>&nbsp;Add</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="s_recordOption" id="s_recordOption" value="1">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap w-100"
                                id="supervisorDataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Job Card Number</th>
                                        <th>Supervisor Emp No</th>
                                        <th>Supervisor Name</th>
                                        <th>Department</th>
                                        <th>Allocate Date</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="supervisorDataTableList"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        $('#job_card_number').select2({
            width: '100%',
        });

        let s_compnay = $('#s_compnay');
        let s_department = $('#s_department');
        let s_supervisor = $('#s_supervisor');

        s_department.select2({
            placeholder: 'Select...',
            dropdownParent: $('#supervisorModalCenter'),
            width: '100%',
            allowClear: true,
            ajax: {
                url: '<?php echo base_url() ?>AssignEmployeeToJob/department_list_sel2',
                dataType: 'json',
                // delay: 250,
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        company: s_compnay.val()
                    }
                },
                processResults: function (data) {
                    return {
                        results: data.results,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            }
        });

        s_supervisor.select2({
            placeholder: 'Select...',
            dropdownParent: $('#supervisorModalCenter'),
            width: '100%',
            allowClear: true,
            ajax: {
                url: '<?php echo base_url() ?>AssignEmployeeToJob/supervisor_list_sel2',
                dataType: 'json',
                // delay: 250,
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                        department: s_department.val()
                    }
                },
                processResults: function (data) {
                    return {
                        results: data.results,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            }
        });

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/assign_emp_to_joblist.php",
                type: "POST", // you can use GET
                "data": function(d) {
                    return $.extend({}, d, {
                        "company_branch_id": '<?php echo ($_SESSION['branch_id']); ?>',
                    });
                }
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_assign_emp_to_job"
                },
                {
                    "data": "job_card_number"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button title="View" class="btn btn-secondary btn-sm btnView mr-1" id="'+full['idtbl_assign_emp_to_job']+'"><i class="fas fa-eye"></i></button>';
                        button+='<button title="Edit" class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_assign_emp_to_job']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a title="Deactive" href="<?php echo base_url() ?>AssignEmployeeToJob/AssignEmployeeToJobstatus/'+full['idtbl_assign_emp_to_job']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a title="Active" href="<?php echo base_url() ?>AssignEmployeeToJob/AssignEmployeeToJobstatus/'+full['idtbl_assign_emp_to_job']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a title="Delete" href="<?php echo base_url() ?>AssignEmployeeToJob/AssignEmployeeToJobstatus/'+full['idtbl_assign_emp_to_job']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $("#job_card_number").change(function() {
            var id = $(this).val(); 
            if(id){
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>AssignEmployeeToJob/getJobList',
                    success: function(result) { //alert(result);
                        $('#jobDetailsList').html(result);
                        
                        $('.customselect2').select2({
                            width: '100%',
                            placeholder: "Select"
                        });
                    }
                });
            }else{
                $('#jobDetailsList').empty();
            }
        })

        $("#addBtn").click(function() {
            if (!$("#mainform_id")[0].checkValidity()) {
                $("#submitBtn").click();
            } else {
                $('#addBtn').prop('disabled', true).html(
                    '<i class="fas fa-circle-notch fa-spin mr-2"></i> Adding');

                var data = [];
                $('#jobDetailsList tr').each(function() {
                    var rowData = {};
                
                    rowData['job_detail_id'] = $(this).find('.job_detail_id').text();
                    rowData['head_emp'] = $(this).find('.head_emp').val();
                
                    rowData['sub_worker1'] = [];
                    var empLevelCounter = 2;
                    $(this).find('.sub_worker1').each(function() {
                        var subWorkerData = {};
                        if($(this).val() != ''){
                            subWorkerData['emp_id'] = $(this).val();
                            subWorkerData['emp_level'] = empLevelCounter++;
                            rowData['sub_worker1'].push(subWorkerData);
                        }
                        
                    });
                    data.push(rowData);
                });

                var job_card_id = $('#job_card_number').val();
                var recordOption = $('#recordOption').val();
                var recordID = $('#recordID').val();  
                // console.log(data,recordOption,recordID,job_card_id);
                
                $.ajax({
                    type: "POST",
                    data: {
                        tableData: data,
                        job_card_id: job_card_id, 
                        recordOption: recordOption,
                        recordID: recordID

                    },
                    url: 'AssignEmployeeToJob/AssignEmployeeToJobinsertupdate',
                    success: function(result) { //alert(result);
                        // console.log(result);
                        var objfirst = JSON.parse(result);
                        if (objfirst.status == 1) {
                            var actionData = JSON.parse(objfirst.action);
                            toastr.success(actionData.message, 'Success');
                            $('#dataTable').DataTable().ajax.reload();
                            resetInputFields();
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        } else {
                            toastr.error(actionData.message, 'Error');
                        }
                        $('#addBtn').prop('disabled', false).html(
                            '<i class="fas fa-save mr-2"></i> Add')
                    }
                });
            }      
        });

        $(document).on('click', '.btnEdit', function () {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>AssignEmployeeToJob/AssignEmployeeToJobedit',
                    success: function (result) {
                        var obj = JSON.parse(result);
                        var job_card_no = obj.main_details.job_card_number;
                        var table = obj.table;
                        $('#job_card_number_show').val(job_card_no);
                        $('#jobDetailsList').html(table);

                        $('#recordOption').val('2');
                        $('#recordID').val(id);
                        $('#addBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                        $('.job_card_number').prop('required',false)
                        $('#jobcardNoDiv').addClass('d-none');
                        $('.job_card_number_show').removeClass('d-none');
                        select2FieldReArrange();
                    }
                    
                });
               
            }
        });

        $(document).on('click', '.btnView', function () {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>AssignEmployeeToJob/AssignEmployeeToJobView',
                success: function (result) {
                    $('#viewjobDetailsList').html(result);

                    $('#viewModalCenter').modal('show');

                }

            });
        });

        $(document).on('click', '#supervisorModelBtn', function () {
            var jobcard_no = $('#job_card_number').val();
            var jobcard_text = $('#job_card_number option:selected').text().trim();
            if(jobcard_no == ''){
                alert("Please Select Job Card Number First!");
                return false;
            }else{
                $('#s_jobcard_id').val(jobcard_no);
                $('#s_jobcard_no').val(jobcard_text);
                $('#supervisorModalCenter').modal('show');
                supervisorDataTable();
            }
        });

        $('#supervisor_add_form').on('submit', function(e) {
            e.preventDefault(); 
            let formData = $(this).serialize(); 

            $.ajax({
                url: '<?php echo base_url("AssignEmployeeToJob/insertupdateSupervisor"); ?>', 
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('button[type="submit"]').prop('disabled', true);
                },
                success: function(response) {
                    var objfirst = JSON.parse(response);
                        if (objfirst.status == 1) {
                            $('button[type="submit"]').prop('disabled', false);   
                            var actionData = JSON.parse(objfirst.action);
                            toastr.success(actionData.message, 'Success');
                            $('#supervisorDataTable').DataTable().ajax.reload();
                            // $('#supervisor_add_form')[0].reset(); 
                        } else {
                            toastr.error(actionData.message, 'Error');
                        }
                      
                },
                error: function(xhr, status, error) {
                    alert('AJAX Error: ' + error);
                }
            });
        });

    });

    function addSubWorker(button) {
        var container = $(button).closest('td').find('.worker-container');

        var originalSelect = container.find('select').last(); // Clone the last select for consistency
        originalSelect.select2('destroy');
        var clonedSelect = originalSelect.clone();
        originalSelect.select2({
            width: '100%',
            placeholder: "Select"
        });
        originalSelect.next('.select2').css('margin-bottom', '3px');

        clonedSelect.val('');
        container.append(clonedSelect);
        clonedSelect.select2({
            width: '100%',
            placeholder: "Select"
        });
        clonedSelect.next('.select2').css('margin-bottom', '3px');
        $(button).closest('td').find('.removeSubWorker').prop('disabled', false);
    }

    function removeSubWorker(button) {
        var container = $(button).closest('td').find('.worker-container');
        var currentSelects = container.find('select'); 

        if (currentSelects.length > 1) {
            $(button).prop('disabled', false);
            currentSelects.select2('destroy');
            container.find('.sub_worker1').last().remove();
            currentSelects.select2({
                width: '100%',
                placeholder: "Select"
            });
            currentSelects.next('.select2').css('margin-bottom', '3px');
        }
        disabledRemoveSubWorker(button);
    }

    function disabledRemoveSubWorker(button) {
        var container = $(button).closest('td').find('.worker-container');
        var currentSelects = container.find('select');
        if (currentSelects.length > 1) {
            $(button).prop('disabled', false);
        } else {
            $(button).prop('disabled', true);
        }
    }

    function resetInputFields(){
        $('#job_card_number').val('').trigger('change');
        $('#jobDetailsList').empty();
        $('.job_card_number').prop('required',true)
        $('#jobcardNoDiv').removeClass('d-none');
        $('.job_card_number_show').addClass('d-none');
    }

    function select2FieldReArrange() {
        var workerSelects = $('#jobDetailsList').find('.customselect2');

        workerSelects.select2({
            width: '100%',   
            placeholder: "Select"
        });

        workerSelects.next('.select2').css('margin-bottom', '3px');
    }

    function supervisorDataTable(){
        $('#supervisorDataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/assign_supervisor_to_joblist.php",
                type: "POST", // you can use GET
                "data": function(d) {
                    return $.extend({}, d, {
                        "company_branch_id": '<?php echo ($_SESSION['branch_id']); ?>',
                    });
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
                    "data": "emp_id"
                },
                {
                    "data": "calling_name"
                },
                {
                    "data": "department_name"
                },
                {
                    "data": "supervisor_assign_datetime"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button title="Delete" id="'+full['idtbl_jobcard']+'" class="btn btn-danger btn-sm delete_supervisor"><i class="fas fa-trash-alt"></i></button>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $(document).on('click', '.delete_supervisor', function () {
                user_id = $(this).attr('id');
                delete_confirmation_alert(user_id);
            });
    }

    function delete_confirmation_alert(id) {

        var r = confirm("Are you sure, You want to Delete this record? ");
        if (r == true) {
            
            $.ajax({
                url: '<?php echo base_url("AssignEmployeeToJob/AssignSupervisorToJobstatus"); ?>', 
                type: 'POST',
                data: {
                    recordID: id
                },
                success: function (response) {
                    var objfirst = JSON.parse(response);
                    if (objfirst.status == 1) {  
                            var actionData = JSON.parse(objfirst.action);
                            toastr.success(actionData.message, 'Success');
                            $('#supervisorDataTable').DataTable().ajax.reload();
                        } else {
                            toastr.error(actionData.message, 'Error');
                        }
                }
            })
        }
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
