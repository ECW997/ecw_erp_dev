<?php 
include "include/header.php";  

include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <style>
        .custom-modal {
            max-width: 65vw;
            /* Adjusts modal width to 95% of the viewport */
            width: 65vw;
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
                            <div class="page-header-icon"><i class="fa fa-cog" aria-hidden="true"></i></div>
                            <span>Job Option</span>
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
                                                <th>#</th>
                                                <th>Sub Job Category</th>
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

        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered custom-modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Options</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <form action="<?php echo base_url() ?>JobOption/jobOptionInsertUpdate" method="post"
                                    autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Company*</label>
                                        <input type="text" id="f_company_name" name="f_company_name"
                                            class="form-control form-control-sm" required readonly>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Company
                                            Branch*</label>
                                        <input type="text" id="f_branch_name" name="f_branch_name"
                                            class="form-control form-control-sm" required readonly>
                                    </div>
                                    <input type="hidden" id="company_id" name="company_id">
                                    <input type="hidden" id="branch_id" name="branch_id">

                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Main Job Category*</label>
                                        <select class="form-control form-control-sm " name="main_job_category"
                                            id="main_job_category" required>
                                            <option value="">Select</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Sub Job Category*</label>
                                        <select class="form-control form-control-sm " name="sub_job_category"
                                            id="sub_job_category" onchange="showGroupDetailsList(this.value,1);"
                                            required>
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Option Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="option_name"
                                            id="option_name" data-field="GroupName" onkeyup="checkedDublicate(this)"
                                            required>
                                        <div id="GroupName_errorMsg"
                                            style="color: red; display: none;font-size: 0.8rem;"></div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Option Type*</label>
                                        <select class="form-control form-control-sm " name="option_type"
                                            id="option_type" required>
                                            <option value="">Select</option>
                                            <option value="Primary">Primary</option>
                                            <option value="Conditional">Conditional</option>
                                            <option value="Type">Type</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Option Group*</label>
                                        <select class="form-control form-control-sm " name="option_group_id"
                                            id="option_group_id" required>
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Required Status*</label>
                                        <select class="form-control form-control-sm " name="required_status"
                                            id="required_status" required>
                                            <option value="">Select</option>
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                            			<label class="small font-weight-bold">Description*</label>
                            			<input type="text" class="form-control form-control-sm" name="description"
                            				id="description">
                            		</div>
                                    <div class="form-group mb-1">
                                        <button type="button" id="addtolistBtn"
                                            class="btn btn-primary btn-sm px-4 mt-auto p-2">
                                            <i class="fas fa-plus mr-2"></i>Add to list</button>
                                        <button type="button" id="cancellistBtn"
                                            class="btn btn-warning btn-sm px-4 mt-auto p-2 d-none"
                                            onclick="cancelBtn();">
                                            <i class="fas fa-times mr-2"></i>Cancel Edit</button>
                                    </div>
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                </form>
                            </div>
                            <div class="col-8">
                                <div class="scrollbar pb-3" id="style-2">
                                    <div id="crudTable"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fas fa-window-close mr-2"></i>Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">View Job Option</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <div id="viewTable"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fas fa-window-close mr-2"></i>Close</button>
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

    sessionStorage.clear();

    $('#company_id').val('<?php echo ($_SESSION['company_id']); ?>');
    $('#f_company_name').val('<?php echo ($_SESSION['companyname']); ?>');
    $('#branch_id').val('<?php echo ($_SESSION['branch_id']); ?>');
    $('#f_branch_name').val('<?php echo ($_SESSION['branchname']); ?>');

    let main_job_category = $('#main_job_category');
    let sub_job_category = $('#sub_job_category');
    let option_group = $('#option_group_id');

    main_job_category.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>SubJobCategory/getMainJob',
            dataType: 'json',
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
                } else {
                    falseResponse(data);
                }
            }
        }
    });

    sub_job_category.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>SubJobCategory/getSubJob',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    mainJob: main_job_category.val()
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
                } else {
                    falseResponse(data);
                }
            }
        }
    });


    option_group.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>JobOption/getOptionGroup',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    sub_job_category:sub_job_category.val()
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
                } else {
                    falseResponse(data);
                }
            }
        }
    });

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
            url: apiBaseUrl + '/v1/job_option',
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
                "data": "idtbl_sub_job_category"
            },
            {
                "data": "sub_job_category"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button +=
                        '<button title="View" class="btn btn-secondary btn-sm btnView mr-1 " onclick="showViewModal(' +
                        full['idtbl_sub_job_category'] +
                        ');"><i class="fas fa-eye"></i></button>';
                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $(document).on('click', '#addtolistBtn', function() {
        var sub_job_category = $('#sub_job_category').val();
        var option_name = $('#option_name').val();
        var option_type = $('#option_type').val();
        var option_group_id = $('#option_group_id').val();
        var required_status = $('#required_status').val();
        var description = $('#description').val();
        var company_id = $('#company_id').val();
        var branch_id = $('#branch_id').val();
        var recordID = $('#recordID').val();
        var recordOption = $('#recordOption').val();

        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                sub_job_category: sub_job_category,
                option_name: option_name,
                option_type: option_type,
                option_group_id: option_group_id,
                required_status: required_status,
                description: description,
                company_id: company_id,
                branch_id: branch_id,
                recordOption: recordOption,
                recordID: recordID
            },
            url: '<?php echo base_url() ?>JobOption/jobOptionInsertUpdate',
            success: function(result) {
                if (result.status == true) {
                    cancelBtn();
                    success_toastify(result.message);
                    showGroupDetailsList(sub_job_category, 1);
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
                url: '<?php echo base_url() ?>JobOption/jobOptionEdit/' + id,
                success: function(result) {
                    if (result.status) {
                        var Option_Group = new Option(result.data.option_group_name, result.data.option_group, true, true);
                        $('#option_group_id').append(Option_Group).trigger('change');

                        $('#recordID').val(result.data.id);
                        $('#option_name').val(result.data.option_name);
                        $('#option_type').val(result.data.option_type);

                        // $('#option_group_id').val(result.data.option_group);
                        $('#required_status').val(result.data.is_required);
                        $('#description').val(result.data.description);

                        $('#recordOption').val('2');
                        $('#addtolistBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                        $('#cancellistBtn').removeClass('d-none');
                    } else {
                        falseResponse(result);
                    }
                }
            });
        }
    });

    $(document).on('click', '.detailStatusBtn', function() {
        var status = $(this).attr('status');
        var r = (status == '1' ? confirm("Are you sure, You want to Active this ? ") : confirm(
            "Are you sure, You want to Deactive this ? "));
        if (r == true) {
            var id = $(this).attr('id');
            var sub_id = $(this).attr('sub_id');
            $.ajax({
                type: "PUT",
                dataType: 'json',
                url: '<?php echo base_url() ?>JobOption/jobOptionStatus/' + id + '/' +
                    status,
                success: function(result) {
                    if (result.status) {
                        showGroupDetailsList(sub_id, 1);
                        success_toastify(result.message);
                    } else {
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
                url: '<?php echo base_url() ?>JobOption/jobOptionDelete/' + id,
                success: function(result) {
                    if (result.status) {
                        showGroupDetailsList(sub_id, 1);
                        success_toastify(result.message);
                    } else {
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
    showGroupDetailsList(sub_id, 2);
    $('#viewModal').modal('show');
}

function showGroupDetailsList(sub_id, modalOption) {
    if (sub_id == '') {
        return false;
    }

    var tableOption = (modalOption == '2') ? 'viewTable' : 'crudTable';
    $("#" + tableOption + "").html('');
    $.ajax({
        type: "GET",
        url: '<?php echo base_url() ?>JobOption/jobOptionDetailsList',
        data: {
            sub_id: sub_id,
            modalOption: modalOption,
            editcheck: editcheck,
            statuscheck: statuscheck,
            deletecheck: deletecheck
        },
        success: function(result) {
            if (result) {
                $("#" + tableOption + "").html(result);
            }
        },
        error: function() {
            $("#" + tableOption).html('<p class="text-center text-danger">Error fetching data!</p>');
        }
    });
}

function cancelBtn() {
    $('#option_name').val('');
    $('#option_type').val('');
    $('#option_group_id').val('').trigger('change');
    $('#description').val('');
    $('#required_status').val('');
    $('#recordID').val('');
    $('#recordOption').val('1');
    $('#cancellistBtn').addClass('d-none');
    $('#addtolistBtn').html('<i class="fas fa-plus mr-2"></i>Add to list')
}

function checkedDublicate(input) {
    var inputValue = input.value;
    var table_name = 'job_options';
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