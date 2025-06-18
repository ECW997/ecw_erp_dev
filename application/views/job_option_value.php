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
                            <div class="page-header-icon"><i class="fa fa-bars" aria-hidden="true"></i></div>
                            <span>Job Option Value</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-end flex-wrap">
                        <div class="d-flex flex-wrap">
                            <div class="me-5 mb-2" style="min-width: 300px;">
                                <label class="small font-weight-bold text-dark">Main Job Category*</label>
                                <select class="form-control form-control-sm" name="main_job_category"
                                    id="main_job_category" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="me-5 mb-2" style="min-width: 50px;">
                            </div>
                            <div class="me-5 mb-2" style="min-width: 300px;">
                                <label class="small font-weight-bold text-dark">Sub Job Category*</label>
                                <select class="form-control form-control-sm" name="sub_job_category"
                                    id="sub_job_category" onchange="showdatatable(this.value);" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>


                        <div class="mb-2">
                            <button type="button" id="addBtn"
                                class="btn btn-primary btn-sm px-4 p-2 <?php if($addcheck==0){echo 'd-none';} ?>"
                                onclick="showInsertModal();">
                                <i class="fas fa-plus mr-2"></i>Option Value
                            </button>
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
                                                <th>Job Option Group</th>
                                                <th>Job Option</th>
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
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Option Value</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <form action="<?php echo base_url() ?>JobOptionGroup/jobOptionGroupInsertUpdate"
                                    method="post" autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Job Option*</label>
                                        <select class="form-control form-control-sm " name="job_option" id="job_option"
                                            onchange="showDetailsList(this.value,1);" required>
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1 d-flex justify-content-end gap-2">
                                        <button title="Select Image" type="button" id="addImageBtn"
                                            class="btn btn-warning btn-sm px-2 p-2 mr-2" data-btn-type="image">
                                            <i class="fas fa-images"></i>
                                        </button>
                                        <button title="Select File" type="button" id="addFileBtn"
                                            class="btn btn-primary btn-sm px-2 p-2 mr-2" data-btn-type="file">
                                            <i class="fas fa-file-alt"></i>
                                        </button>
                                        <button title="Select PDF" type="button" id="addPdfBtn"
                                            class="btn btn-danger btn-sm px-2 p-2" data-btn-type="pdf">
                                            <i class="fas fa-file-pdf"></i>
                                        </button>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Value Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="value_name"
                                            id="value_name" data-field="ValueName" onkeyup="checkedDublicate(this)"
                                            required>
                                        <div id="ValueName_errorMsg"
                                            style="color: red; display: none;font-size: 0.8rem;"></div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Parent Option Value*</label>
                                        <select class="form-control form-control-sm " name="parent_option_value"
                                            id="parent_option_value">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="small font-weight-bold">Status*</label>
                                        <select class="form-control form-control-sm " name="status" id="status">
                                            <option value="">Select</option>
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>
                                        </select>
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
                        <h5 class="modal-title" id="viewModalLabel">View Option Value</h5>
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

        <div class="modal fade" id="fileLoadModal" tabindex="-1" role="dialog" aria-labelledby="fileLoadModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fileLoadModalLabel">View Option Value</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                     <div class="modal-body">
                        <div class="form-group">
                            <label class="small font-weight-bold" for="category">Category<span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm selecter2" name="category" id="category" required>
                                <option value="">Select</option>
                                <option value="1">Stitching Design</option>
                                <option value="2">Marketing</option>
                                <option value="3">Production</option>
                            </select>
                            <div id="imagePreview" class="mt-3 row"></div>
                            <input type="hidden" id="btn_type" name="btn_type" />
                        </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-primary btn-sm" id="selectFileBtn" data-dismiss="modal"><i class="fas fa-check-circle mr-2"></i>Select</button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-window-close mr-2"></i>Close</button>
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
    let main_job_category = $('#main_job_category');
    let sub_job_category = $('#sub_job_category');

    $('[data-btn-type]').on('click', function () {
            var btnType = $(this).data('btn-type');
            var title = '';

            switch (btnType) {
                case 'image':
                    title = 'Select Image';
                    break;
                case 'file':
                    title = 'Select File';
                    break;
                case 'pdf':
                    title = 'Select PDF';
                    break;
                default:
                    title = 'View Option Value';
            }

            $('#fileLoadModalLabel').text(title);
            $('#btn_type').val(btnType);

            $('#fileLoadModal').modal('show');
    });

     $('#category').on('change', function () {
            var categoryId = $(this).val();
            var btn_type = $('#btn_type').val();

            if (categoryId) {
                $.ajax({
                    url: '<?= base_url("JobOptionValue/getImagesByCategory") ?>',
                    type: 'POST',
                    data: { 
                        category_id: categoryId,
                        btn_type:btn_type },
                    dataType: 'json',
                    beforeSend: function () {
                        $('#imagePreview').html('<div class="col-12 text-center text-secondary">Loading...</div>');
                    },
                    success: function (response) {
                        var html = '';
                        if (response.status && response.data.length > 0) {
                            $.each(response.data, function (index, image) {
                                html += `
                                    <div class="col-md-3 mb-2">
                                       <img src="${image.public_url}" class="img-fluid rounded border selectable-image" data-filename="${image.file_name}" data-filepath="${image.file_path}" alt="Image">
                                    </div>`;
                            });
                        } else {
                            html = '<div class="col-12 text-muted">No images found for this category.</div>';
                        }
                        $('#imagePreview').html(html);
                    },
                    error: function () {
                        $('#imagePreview').html('<div class="col-12 text-danger">Error loading images.</div>');
                    }
                });
            } else {
                $('#imagePreview').html('');
            }
    });

    let selectedFilePath = '';
    $(document).on('click', '.selectable-image', function () {
        $('.selectable-image').removeClass('border-primary').addClass('border');
        $(this).addClass('border-primary');
        selectedFilePath = $(this).data('filepath');
    });

    $('#selectFileBtn').on('click', function () {
        if (selectedFilePath !== '') {
            $('#value_name').val(selectedFilePath);
        } else {
            alert('Please select an image first.');
        }
    });

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

    showdatatable(sub_job_category.val());
});



$(document).ready(function() {
    let job_option = $('#job_option');
    let parent_option_value = $('#parent_option_value');


    $('#addModal').on('shown.bs.modal', function() {
        $('#job_option').select2({
            dropdownParent: $('#addModal'),
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            ajax: {
                url: '<?php echo base_url() ?>JobOptionValue/getJobOption',
                dataType: 'json',
                data: function(params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1,
                    }
                },
                processResults: function(data) {
                    if (data.status == true) {
                        return {
                            results: data.data.item,
                            pagination: {
                                more: data.data.pagination.more
                            }
                        }
                    }
                }
            }
        });
    });

    $('#parent_option_value').select2({
        dropdownParent: $('#addModal'),
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>JobOptionValue/getJobOptionValue',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                };
            },
            processResults: function(data) {
                if (data.status == true) {
                    return {
                        results: data.data.item,
                        pagination: {
                            more: data.data.pagination.more
                        }
                    };
                } else {
                    falseResponse(data);
                }
            }
        }
    });



    $(document).on('click', '#addtolistBtn', function() {
        var job_option = $('#job_option').val();
        var value_name = $('#value_name').val();
        var parent_option_value = $('#parent_option_value').val();
        var status = $('#status').val();
        var recordID = $('#recordID').val();
        var recordOption = $('#recordOption').val();

        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                job_option: job_option,
                value_name: value_name,
                parent_option_value: parent_option_value,
                status: status,
                recordOption: recordOption,
                recordID: recordID
            },
            url: '<?php echo base_url() ?>JobOptionValue/jobOptionValueInsertUpdate',
            success: function(result) {
                if (result.status == true) {
                    cancelBtn();
                    success_toastify(result.message);
                    showDetailsList(job_option, 1);
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
                url: '<?php echo base_url() ?>JobOptionValue/jobOptionValueEdit/' + id,
                success: function(result) {
                    if (result.status) {
                        $('#recordID').val(result.data.id);
                        $('#value_name').val(result.data.ValueName);
                        $('#parent_option_value').val(result.data.ParentOptionValueID);
                        setSelect2Value(parent_option_value, result.data
                            .ParentOptionValueID, result.data.parent_value_name);
                        $('#status').val(result.data.IsActive);

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
            var job_option_id = $(this).attr('job_option_id');
            $.ajax({
                type: "PUT",
                dataType: 'json',
                url: '<?php echo base_url() ?>JobOptionValue/jobOptionValueStatus/' + id + '/' +
                    status,
                success: function(result) {
                    if (result.status) {
                        showDetailsList(job_option_id, 1);
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
            var job_option_id = $(this).attr('job_option_id');
            $.ajax({
                type: "DELETE",
                dataType: 'json',
                url: '<?php echo base_url() ?>JobOptionValue/jobOptionValueDelete/' + id,
                success: function(result) {
                    if (result.status) {
                        showDetailsList(job_option_id, 1);
                        success_toastify(result.message);
                    } else {
                        falseResponse(result);
                    }
                }
            });
        }
    });
});

// console.log(showdatatable);
// alert(sub_job_category);

function showdatatable(sub_job_category) {

    $('#dataTable').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [25, 50, -1],
            [25, 50, 'All'],
        ],
        buttons: [{
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                title: 'Job Option Value Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Job Option Value Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Job Option Value Information',
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
            url: apiBaseUrl + '/v1/job_option_value',
            data: {
                sub_job_category: sub_job_category
            },
            type: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + api_token
            },
            dataSrc: function(json) {
                if (json.status === false && json.code === 401) {
                    falseResponse(errorObj);
                    return [];
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
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: "JobOptionID"
            },
            {
                data: "sub_job_category"
            },
            {
                data: "GroupName"
            },
            {
                data: "OptionName"
            },
            {
                targets: -1,
                className: 'text-right',
                data: null,
                render: function(data, type, full) {
                    return '<button title="View" class="btn btn-secondary btn-sm btnView mr-1" onclick="showViewModal(' +
                        full['JobOptionID'] + ');"><i class="fas fa-eye"></i></button>';
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

}













function setSelect2Value(selectElement, id, text) {
    console.log(id);

    if (id) {
        var newOption = new Option(text, id, true, true);
        selectElement.append(newOption).trigger('change');
    } else {
        selectElement.val('').trigger('change');
    }
}

function showInsertModal() {
    $('#job_option').val('').trigger('change');
    $("#crudTable").html('');
    $('#addModal').modal('show');
    cancelBtn();
}

function showViewModal(job_option) {
    showDetailsList(job_option, 2);
    $('#viewModal').modal('show');
}

function showDetailsList(job_option, modalOption) {
    if (job_option == '') {
        return false;
    }

    var tableOption = (modalOption == '2') ? 'viewTable' : 'crudTable';
    $("#" + tableOption + "").html('');
    $.ajax({
        type: "GET",
        url: '<?php echo base_url() ?>JobOptionValue/jobOptionValueDetailsList',
        data: {
            job_option: job_option,
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
    $('#value_name').val('');
    $('#parent_option_value').val('').trigger('change');
    $('#status').val('');
    $('#recordID').val('');
    $('#recordOption').val('1');
    $('#cancellistBtn').addClass('d-none');
    $('#addtolistBtn').html('<i class="fas fa-plus mr-2"></i>Add to list')
}

function checkedDublicate(input) {
    var inputValue = input.value;
    var table_name = 'ValueName';
    var columnName = input.getAttribute('data-field');

    var whereConditions = {
        'JobOptionID': $('#job_option').val()
    };

    $.ajax({
        url: '<?php echo base_url() ?>CheckDublicate/check_duplicate',
        type: 'POST',
        dataType: 'json',
        data: {
            input_value: inputValue,
            table_name: table_name,
            column_name: columnName,
            where: whereConditions
        },
        dataType: 'json',
        success: function(response) {
            if (response.status) {
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