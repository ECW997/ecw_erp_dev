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
                                                <label for="jobCardSelect" class="form-label">Select Job Card</label>
                                                <select class="form-select" id="job_card_number" name="job_card_number">
                                                    <option value=""> Select Job Card </option>
                                                    <?php if (!empty($relationDetails['jobcard_id'])): ?>
                                                    <option value="<?= $relationDetails['jobcard_id'] ?>" selected>
                                                        <?= $relationDetails['jobcard_no'] ?>
                                                    </option>
                                                    <?php endif; ?>
                                                </select>
                                                <input class="form-control form-control-sm job_card_number_show d-none"
                                                    name="job_card_number_show" id="job_card_number_show" readonly>
                                            </div>
                                            <input type="hidden" name="recordOption" id="recordOption" value="1">
                                            <input type="hidden" name="recordID" id="recordID" value="">
                                        </div>
                                        <div class="col-3">
                                            <label class="small font-weight-bold text-dark">Assign
                                                Supervisor*</label><br>
                                            <button type="button" id="supervisorModelBtn"
                                                class="btn btn-info btn-sm px-4"><i
                                                    class="fas fa-user-tag"></i></button>
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
                                            <input type="submit" id="submitBtn" hidden />
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
    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';

    // $('#job_card_number').select2({
    //     width: '100%',
    // });

    let s_compnay = $('#s_compnay');
    let s_department = $('#s_department');
    let s_supervisor = $('#s_supervisor');


    let jobCardNumber = $('#job_card_number');

    jobCardNumber.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>SalesOrder/getJobcardNumbers',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                }
            },
            cache: true,
            processResults: function(data) {
                console.log('AJAX response:', data);
                if (data.status == true) {
                    return {
                        results: data.data.item,
                        pagination: {
                            more: data.data.item.length > 0
                        }
                    }
                } else {
                    falseResponse(data);
                }
            }
        }
    });



    $("#job_card_number").change(function() {
        var id = $(this).val();
        // alert(id);
        if (id) {
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>AssignEmployeeToJob/getJobcardJobs',
                success: function(result) { alert(result);
                    $('#jobDetailsList').html(result);

                    $('.customselect2').select2({
                        width: '100%',
                        placeholder: "Select"
                    });
                }
            });
        } else {
            $('#jobDetailsList').empty();
        }
    })






    s_department.select2({
        placeholder: 'Select...',
        dropdownParent: $('#supervisorModalCenter'),
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>AssignEmployeeToJob/department_list_sel2',
            dataType: 'json',
            // delay: 250,
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    company: s_compnay.val()
                }
            },
            processResults: function(data) {
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