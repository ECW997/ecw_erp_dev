<?php 
include "include/header.php";  

include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <style>
        #porderviewmodal .modal-content {
            border: 4px solid #0982e6;
            border-radius: 25px;
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
                            <div class="page-header-icon"><i class='fas fa-id-card'></i></div>
                            <span>Pricing</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <form id="createorderform" autocomplete="off">
                                    <div class="form-row mb-1">
                                        <div class="col-3">
                                            <label class="small font-weight-bold">Main Job Category*</label>
                                            <select class="form-control form-control-sm " name="main_job_category"
                                                id="main_job_category" required>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label class="small font-weight-bold">Sub Job Category*</label>
                                            <select class="form-control form-control-sm " name="sub_job_category"
                                                id="sub_job_category" onchange="showGroupDetailsList(this.value,1);"
                                                required>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body p-0 p-2">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap w-100"
                                        id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Main Job Category</th>
                                                <th>Sub Job Category</th>
                                                <th>Job Description</th>
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

<!-- Modal -->
<div id="purchaseview">
    <div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: blue;">View Job Price Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 text-left">
                            <img src="./images/ecw_logo_2.jpg" alt="" width="40%" style="margin-top: -15px;">
                        </div>
                        <div class="col-6">
                            <h2 style="margin-bottom: 2px; color: black;font-family: cursive;font-size:20px;font-weight: bold; padding:0;"
                                class="text-right"><span id="jobname"></span></h2>
                            <!-- <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"><span id="viewcompanyname"></span>
                            </p>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"> <span id="viewbranchname"></span>
                            </p> -->

                        </div>
                    </div>
                    </br>

                    <div id="viewhtml"></div>

                </div>
                <input type="hidden" class="form-control form-control-sm" name="tableId" id="tableId" required readonly>
            </div>
        </div>
    </div>
</div>


<?php include "include/footerscripts.php"; ?>

<script>
function checkedDublicate(input) {

    var inputValue = input.value;
    var tablename = 'tbl_job_price';
    var columnName = input.getAttribute('data-field');

    $.ajax({
        url: '<?php echo base_url() ?>CheckDublicate/check_duplicate',
        type: 'POST',
        data: {
            input_value: inputValue,
            tablename: tablename,
            column_name: columnName
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'error') {
                $('#' + columnName + '_errorMsg').text(
                        "This Job is already Priced.Please Edit it or add another job ")
                    .css('font-weight', 'bold')
                    .show();
            } else {
                $('#' + columnName + '_errorMsg').hide();
            }
        }
    });
}
</script>

<script>
function productDelete(btn) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to remove this Job?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $(btn).closest('tr').remove();
            Swal.fire(
                'Deleted!',
                'The job has been removed.',
                'success'
            );
        }
    });
}
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function() {
    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';

    let main_job_category = $('#main_job_category');
    let sub_job_category = $('#sub_job_category');

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
                title: 'Job Price Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                className: 'btn btn-danger btn-sm',
                title: 'Job Price Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                action: function(e, dt, node, config) {
                    exportPDF();
                }
            },
            {
                extend: 'print',
                title: 'Job Price Information',
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
            url: "<?php echo base_url() ?>scripts/jobprice_detail_list.php",
            type: "POST",
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "idtbl_job_price"
            },
            {
                "data": "main_job_category"
            },
            {
                "data": "sub_job_category"
            },
            {
                "data": "sales_job_name"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button += `
                        <button class="btn btn-dark btn-sm btnview mr-1" 
                                id="${full['idtbl_job_price']}" 
                                sub_job_category_id="${full['sub_job_category_id']}" 
                                title="View Inquiry & Follow ups">
                            <i class="fas fa-eye"></i>
                        </button>`;

                    button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '" id="' + full['idtbl_job_price'] + '" sub_job_category_id="' +
                        full['sub_job_category_id'] + '"><i class="fas fa-pen"></i></button>';
                    if (full['status'] == 1) {
                        button +=
                            '<a href="<?php echo base_url() ?>Job_price_details/Job_price_details_status/' +
                            full['idtbl_job_price'] +
                            '/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></a>';
                    } else {
                        button +=
                            '<a href="<?php echo base_url() ?>Job_price_details/Job_price_details_status/' +
                            full['idtbl_job_price'] +
                            '/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-times"></i></a>';
                    }
                    button +=
                        '<a href="<?php echo base_url() ?>Job_price_details/Job_price_details_status/' +
                        full['idtbl_job_price'] +
                        '/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';
                    if (deletecheck != 1) {
                        button += 'd-none';
                    }
                    button += '"><i class="fas fa-trash-alt"></i></a>';

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });


});


function setEditFieldValue(selector, value) {
    return new Promise(function(resolve) {
        $(selector).val(value).trigger('change');
        setTimeout(() => resolve(), 500);
    });
}

function resetInputFields() {
    $('#recordID').val('');
    $('#main_job_category').val('').trigger('change');
    $('#sub_job_category').val('').trigger('change');
    $('#job_price').val('');
    $('#price_category_id').val('').trigger('change');
    $('#job_name').val('').trigger('change');

    $('#seat_condition_id').val('').trigger('change');
    $('#seat_type_id').val('').trigger('change');
    $('#recordOption').val('1');

    $('#inquryid').val('');
    $('#inqurydeiailsid').val('');
    $("#tbljobpricebody").empty();
    $("#tblseattypejobpricebody").empty();

    $("#tblseat_repairjobpricebody").empty();

}

function exportPDF() {
    const baseUrl = "<?php echo base_url(); ?>Job_price_details/job_price_details_pdf";
    const url = `${baseUrl}`;
    window.open(url, '_blank');
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