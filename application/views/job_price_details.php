<?php 
include "include/header.php";  

include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <style>
        #porderviewmodal .modal-content {
            border: 4px solid #0982e6;
            /* Light blue color */
            border-radius: 25px;
            /* Optional: Add rounded corners */
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
                            <span>Job Price Details</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-4 col-xl-4">
                                <form id="createorderform" autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Main Job Category*</label>
                                        <select class="form-control form-control-sm " name="main_job_category"
                                            id="main_job_category" required>
                                            <option value="">Select</option>
                                            <?php foreach($mainjoblist->result() as $rowmainjoblist){ ?>
                                            <option value="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                <?php echo $rowmainjoblist->main_job_category ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Sub Job Category*</label>
                                        <select class="form-control form-control-sm " name="sub_job_category"
                                            id="sub_job_category">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Job
                                            Description*</label>
                                        <select class="form-control form-control-sm selecter2 px-0" name="job_name"
                                            data-field="sales_job_details_id" id="job_name"
                                            onchange="checkedDublicate(this)">
                                            <option value="">Select</option>
                                        </select>
                                        <div id="sales_job_details_id_errorMsg"
                                            style="color: red; display: none;font-size: 0.8rem;">
                                        </div>
                                    </div>

                                    <div class="form-group mb-1" id="seatTypeDiv">
                                        <label class="small font-weight-bold text-dark">Seat Type*</label>
                                        <select class="form-control form-control-sm " name="seat_type_id"
                                            id="seat_type_id">
                                            <option value="">Select</option>
                                        </select>
                                    </div>


                                    <div class="form-group mb-1" id="seatConditionDiv">
                                        <label class="small font-weight-bold text-dark">Seat Condition*</label>
                                        <select class="form-control form-control-sm " name="seat_condition_id"
                                            id="seat_condition_id">
                                            <option value="">Select</option>
                                            <?php foreach($seat_conditionlist->result() as $rowseat_conditionlist){ ?>
                                            <option value="<?php echo $rowseat_conditionlist->idtbl_seat_condition ?>">
                                                <?php echo $rowseat_conditionlist->condition_type ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group mb-1" id="price_cateDiv">
                                        <label class="small font-weight-bold text-dark">Price Category Type*</label>
                                        <select class="form-control form-control-sm " name="price_category_id"
                                            id="price_category_id">
                                            <option value="">Select</option>
                                            <?php foreach($price_categorylist->result() as $rowprice_categorylist){ ?>
                                            <option
                                                value="<?php echo $rowprice_categorylist->idtbl_price_category_type ?>">
                                                <?php echo $rowprice_categorylist->price_category_type ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group mb-1" id="seatRepairDiv">
                                        <label class="small font-weight-bold text-dark">Repair Type*</label>
                                        <select class="form-control form-control-sm " name="repair_type_id"
                                            id="repair_type_id">
                                            <option value="">Select</option>
                                        </select>
                                    </div>



                                    <div class="form-group mb-1" id="materialDiv">
                                        <label class="small font-weight-bold text-dark">Material*</label>
                                        <select class="form-control form-control-sm " name="material_id"
                                            id="material_id">
                                            <option value="">Select</option>
                                            <?php foreach($materiallist->result() as $rowmateriallist){ ?>
                                            <option value="<?php echo $rowmateriallist->idtbl_material ?>">
                                                <?php echo $rowmateriallist->material_type ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Job Price*</label>
                                        <input type="number" id="job_price" name="job_price"
                                            class="form-control form-control-sm" step="any" required>
                                    </div>

                                    <div class="form-group mt-2 text-right">
                                        <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4"
                                            <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                class="fas fa-plus"></i>&nbsp;Add to list</button>
                                        <button type="button" name="Btnupdatelist" id="Btnupdatelist"
                                            class="btn btn-secondary btn-sm px-4" style="display:none;"><i
                                                class="fas fa-plus"></i>&nbsp;Update List</button>
                                        <input name="submitBtn" type="submit" value="Save" id="submitBtn"
                                            class="d-none">
                                    </div>



                                    <div class="form-group mt-2">
                                        <input type="hidden" name="inquryid" class="form-control form-control-sm"
                                            id="inquryid">
                                        <input type="hidden" name="inqurydeiailsid" class="form-control form-control-sm"
                                            id="inqurydeiailsid">
                                    </div>
                                </form>
                            </div>


                            <div class="col-sm-14 col-md-14 col-lg-8 col-xl-8">

                                <div id="price_category_part">
                                    <table class="table table-striped table-bordered table-sm small" id="tableorder">
                                        <thead>
                                            <tr>
                                                <th class="text-left" style="width: 30%;">Price Category Type</th>
                                                <th class="text-left" style="width: 30%;">Material</th>
                                                <th class="text-left" style="width: 30%;">Job Price</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbljobpricebody">
                                        </tbody>
                                    </table>
                                </div>


                                <div id="seat_repair_part">
                                    <table class="table table-striped table-bordered table-sm small" id="tableorder_1">
                                        <thead>
                                            <tr>
                                                <th class="text-left" style="width: 30%;">Category Type</th>
                                                <th class="text-left" style="width: 30%;">Repair Type</th>
                                                <th class="text-left" style="width: 30%;">Job Price</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblseat_repairjobpricebody">
                                        </tbody>
                                    </table>
                                </div>


                                <div id="japan_seat_part">
                                    <table class="table table-striped table-bordered table-sm small" id="tableorder_2">
                                        <thead>
                                            <tr>
                                                <!-- <th class="text-left" style="width: 40%;">Job Description</th>
                                                <th class="d-none">JobID</th> -->
                                                <th class="text-left" style="width: 30%;">Seat Type</th>
                                                <th class="text-left" style="width: 30%;">Seat Condition</th>
                                                <th class="text-left" style="width: 30%;">Job Price</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblseattypejobpricebody">
                                        </tbody>
                                    </table>
                                </div>

                                <hr>
                                <div class="form-group mt-2">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <button type="button" id="btncreateorder"
                                        class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                            class="fas fa-save"></i>&nbsp;Create Job Price</button>
                                </div>

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

    $('#price_category_id').select2({
        width: '100%',
    });
    $('#seat_type_id').select2({
        width: '100%',
    });
    $('#seat_condition_id').select2({
        width: '100%',
    });
    $('#job_name').select2({
        width: '100%',
    });
    $('#sub_job_category').select2({
        width: '100%',
    })
    $('#main_job_category').select2({
        width: '100%',
    })
    $('#repair_type_id').select2({
        width: '100%',
    })



    // show hide div tags 

    $('#price_cateDiv').show();
    $('#seatTypeDiv').hide();
    $('#seatConditionDiv').hide();
    $('#seatRepairDiv').hide();
    $('#price_category_part').show();
    $('#japan_seat_part').hide();
    $('#seat_repair_part').hide();
    $('#materialDiv').show();

    $('#sub_job_category').on('change', function() {
        const selectedValue = $(this).val();

        if (selectedValue != 1 && selectedValue != 8 && selectedValue != 9) {
            $('#price_cateDiv').hide();
            $('#seatTypeDiv').show();
            $('#seatConditionDiv').show();
            $('#price_category_part').hide();
            $('#japan_seat_part').show();
            $('#materialDiv').hide();
            $('#seat_repair_part').hide();
            $('#seatRepairDiv').hide();
        } else if (selectedValue == 9) {
            $('#price_cateDiv').show();
            $('#seatTypeDiv').hide();
            $('#seatConditionDiv').hide();
            $('#seat_repair_part').show();
            $('#price_category_part').hide();
            $('#japan_seat_part').hide();
            $('#materialDiv').hide();
            $('#seatRepairDiv').show();
        } else {
            $('#price_cateDiv').show();
            $('#seatTypeDiv').hide();
            $('#seatConditionDiv').hide();
            $('#price_category_part').show();
            $('#japan_seat_part').hide();
            $('#materialDiv').show();
            $('#seat_repair_part').hide();
            $('#seatRepairDiv').hide();
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



    $('#dataTable').on('click', '.btnview', function() { 
        var id = $(this).attr('id');
        var sub_job_category_id = $(this).attr('sub_job_category_id');
        $('#tableId').val(id);
        $('#approvebtn').val(id);
        $('#procode').html(id);
        $.ajax({
            type: "POST",
            data: {
                recordID: id,
                sub_job_category_id: sub_job_category_id
            },
            url: '<?php echo base_url() ?>Job_price_details/Job_detailsview',
            success: function(result) { //alert(result);

                $('#porderviewmodal').modal('show');
                $('#viewhtml').html(result);
            }
        });

        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Job_price_details/Job_detailviewheader',
            success: function(result) { //alert(result);
                var obj = JSON.parse(result);
                $('#jobname').text(obj.jobname);
                //console.log(obj);
            }
        });


    });



    $("#formsubmit").click(function() {
        if (!$("#createorderform")[0].checkValidity()) {
            $("#submitBtn").click();
        } else {
            var jobID = $('#job_name').val();
            var job = $("#job_name option:selected").text();
            var price_cat_ID = $('#price_category_id').val();
            var price_cat = $("#price_category_id option:selected").text();
            var seat_type_ID = $('#seat_type_id').val();
            var seat_type = $("#seat_type_id option:selected").text();

            var seat_condition_ID = $('#seat_condition_id').val();
            var seat_condition = $("#seat_condition_id option:selected").text();

            var repair_type_ID = $('#repair_type_id').val();
            var repair_type = $("#repair_type_id option:selected").text();

            var material_ID = $('#material_id').val();
            var material_name = $("#material_id option:selected").text();
            var price = $('#job_price').val();
            var insertmethod = "NewRow";

            var subJobCategory = $('#sub_job_category').val();

            var duplicate = false;
            $('#tableorder > tbody > tr').each(function() {
                var existingCatID = $(this).find('td.price_cat_id').text();
                var existingMatID = $(this).find('td.material_id').text();

                if ((existingCatID == price_cat_ID) && (existingMatID == material_ID)) {
                    duplicate = true;
                    return false;
                }
            });

            if (duplicate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Duplicate Entry',
                    text: 'This Category Type has already been added to the table.',
                });
            } else {

                if (subJobCategory == 1 || subJobCategory == 8) {
                    $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + price_cat +
                        '</td><td class="d-none price_cat_id">' + price_cat_ID +
                        '</td><td class="material_name">' + material_name +
                        '</td><td class="d-none material_id">' + material_ID +
                        '</td><td>' + price +
                        '</td><td class="text-center d-none">' + insertmethod +
                        '</td><td><button type="button" onclick="productDelete(this);" id="btnDeleterow" class="btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
                    );

                    $('#price_category_part').show();
                    $('#seat_repair_part').hide();
                    $('#japan_seat_part').hide();

                } else if (subJobCategory == 9) {
                    $('#tableorder_1 > tbody:last').append('<tr class="pointer"><td>' + price_cat +
                        '</td><td class="d-none price_cat_id">' + price_cat_ID +
                        '</td><td class="repair_name">' + repair_type +
                        '</td><td class="d-none repair_type_id">' + repair_type_ID +
                        '</td><td>' + price +
                        '</td><td class="text-center d-none">' + insertmethod +
                        '</td><td><button type="button" onclick="productDelete(this);" id="btnDeleterow" class="btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
                    );

                    $('#price_category_part').hide();
                    $('#seat_repair_part').show();
                    $('#japan_seat_part').hide();

                } else {
                    $('#tableorder_2 > tbody:last').append('<tr class="pointer"><td>' + seat_type +
                        '</td><td class="d-none seat_type_id">' + seat_type_ID +
                        '</td><td>' + seat_condition +
                        '</td><td class="d-none seat_condition_id">' + seat_condition_ID +
                        '</td><td>' + price +
                        '</td><td class="text-center d-none">' + insertmethod +
                        '</td><td><button type="button" onclick="productDelete(this);" id="btnDeleterow" class="btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
                    );

                    $('#japan_seat_part').show();
                    $('#seat_repair_part').hide();
                    $('#price_category_part').hide();
                }


                $('#material_id').val('');
                $('#job_price').val('');
                $('#job_name').focus();
            }
        }
    });

    $('#btncreateorder').click(function() {

        $('#btncreateorder').prop('disabled', true).html(
            '<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Order');

        var subJobCategory = $('#sub_job_category').val();
        var main_job_category = $('#main_job_category').val();
        var job_name = $('#job_name').val();
        var recordOption = $('#recordOption').val();
        var recordID = $('#recordID').val();

        var tableData = [];
        $("#tableorder tbody tr").each(function() {
            var item = {};
            $(this).find('td').each(function(col_idx) {
                item["col_" + (col_idx + 1)] = $(this).text();
            });
            tableData.push(item);
        });

        var tableData2 = [];
        if (subJobCategory !== 1 && subJobCategory !== 8) {
            $("#tableorder_2 tbody tr").each(function() {
                var item = {};
                $(this).find('td').each(function(col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });
                tableData2.push(item);
            });
        }

        var tableData1 = [];
        if (subJobCategory == 9) {
            $("#tableorder_1 tbody tr").each(function() {
                var item = {};
                $(this).find('td').each(function(col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });
                tableData1.push(item);
            });
        }


        if (tableData.length === 0 && tableData2.length === 0 && tableData1.length === 0) {
        toastr.error("Can't create..Jobs table is empty!", 'Error', {
            positionClass: 'toast-top-center'
        });
        $('#btncreateorder').prop('disabled', false).html(
            '<i class="fas fa-save mr-2"></i> Create Job Price'
        );
        return false;
    }


        $.ajax({
            type: "POST",
            data: {
                tableData: tableData,
                tableData1: tableData1,
                tableData2: tableData2,
                main_job_category: main_job_category,
                sub_job_category: subJobCategory,
                job_name: job_name,
                recordOption: recordOption,
                recordID: recordID
            },
            url: 'Job_price_details/Job_price_details_insertupdate',
            success: function(result) {
                var objfirst = JSON.parse(result);
                if (objfirst.status == 1) {
                    var actionData = JSON.parse(objfirst.action);
                    toastr.success(actionData.message, 'Success');
                    $('#dataTable').DataTable().ajax.reload();
                    resetInputFields();
                } else {
                    toastr.error(actionData.message, 'Error');
                }
                $('#btncreateorder').prop('disabled', false).html(
                    '<i class="fas fa-save mr-2"></i> Create Job Price'
                );
            }
        });

    });



    $('#dataTable tbody').on('click', '.btnEdit', function() {
        var r = confirm("Are you sure, You want to Edit this ? ");
        if (r == true) {
            var id = $(this).attr('id');
            var sub_job_category_id = $(this).attr('sub_job_category_id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Job_price_details/Job_price_details_edit',
                success: function(result) {
                    //alert(result);
                    var obj = JSON.parse(result);
                    $('#recordID').val(obj.id);

                    setEditFieldValue('#main_job_category', obj.main_job_category_id)
                        .then(function() {
                            return setEditFieldValue('#sub_job_category', obj
                                .sub_job_category_id);
                        })
                        .then(function() {
                            return setEditFieldValue('#job_name', obj
                                .sales_job_details_id);
                        })
                        .catch(function(error) {
                            console.error(error);
                        });

                    $('#recordOption').val('2');
                    $('#btncreateorder').html('<i class="far fa-save"></i>&nbsp;Update');
                    $('#sales_job_details_id_errorMsg').addClass('d-none');
                }
            });
            $.ajax({
                type: "POST",
                data: {
                    recordID: id,
                    sub_job_category_id: sub_job_category_id
                },
                url: '<?php echo base_url() ?>Job_price_details/Job_price_details_editjobedit',
                success: function(result) {
                    //alert(result);
                    if (sub_job_category_id == 1) {
                        $('#tbljobpricebody').html(result);

                    } else {
                        $('#tblseattypejobpricebody').html(result);
                    }
                }
            });
        }
    });

    // edit JOB list table

    $(document).on('click', '.btnEditlist', function() {
        var r = confirm("Are you sure, You want to Edit this ? ");
        if (r == true) {
            var id = $(this).attr('id');

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Job_price_details/Job_price_detailsjoblistedit',
                success: function(result) {
                    //alert(result);
                    var obj = JSON.parse(result);
                    $('#inqurydeiailsid').val(obj.id);
                    $('#inquryid').val(obj.idtbl_job_price);
                    $('#price_category_id').val(obj.Cate_type).trigger('change');
                    $('#seat_type_id').val(obj.seat_type).trigger('change');
                    $('#seat_condition_id').val(obj.seat_condition).trigger('change');
                    $('#material_id').val(obj.material_id);
                    $('#job_price').val(obj.job_price);
                    $('#Btnupdatelist').show();
                    $('#formsubmit').hide();
                }
            });

        }
    });


    // update job  list 
    $(document).on("click", "#Btnupdatelist", function() {
        if (!$("#createorderform")[0].checkValidity()) {
            $("#submitBtn").click();
        } else {
            var price_cat_ID = $('#price_category_id').val();
            var price_cat = $("#price_category_id option:selected").text();
            var seat_type_ID = $('#seat_type_id').val();
            var seat_type = $("#seat_type_id option:selected").text();
            var seat_condition_ID = $('#seat_condition_id').val();
            var seat_condition = $("#seat_condition_id option:selected").text();
            var material_ID = $('#material_id').val();
            var material_name = $("#material_id option:selected").text();
            var price = $('#job_price').val();

            var subJobCategory = $('#sub_job_category').val();

            var inquryid = $('#inquryid').val();
            var inqurydetailid = $('#inqurydeiailsid').val();
            var insertmethod = "Updated";

            var duplicate = false;

            if (duplicate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Duplicate Entry',
                    text: 'This Category Type has already been added to the table.',
                });
            } else {

                if (subJobCategory == 1) {
                    $("#tableorder > tbody").find('input[name="hiddenid"]').each(function() {
                        var idhidden = $(this).val();
                        if (idhidden == inqurydetailid) {
                            $(this).parents("tr").remove();
                        }
                    });
                    $('#tableorder > tbody:last').append('<tr><td>' + price_cat +
                        '</td><td class="d-none price_cat_id">' + price_cat_ID +
                        '</td><td class="material_name">' + material_name +
                        '</td><td class="d-none material_id">' + material_ID +
                        '</td><td>' + price +
                        '</td><td class="text-center d-none">' + insertmethod +
                        '</td><td class=" d-none">' + inquryid + '</td><td class=" d-none">' +
                        inqurydetailid +
                        '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
                    );

                } else {
                    $("#tableorder_2 > tbody").find('input[name="hiddenid"]').each(function() {
                        var idhidden = $(this).val();
                        if (idhidden == inqurydetailid) {
                            $(this).parents("tr").remove();
                        }
                    });

                    $('#tableorder_2 > tbody:last').append('<tr><td>' + seat_type +
                        '</td><td class="d-none seat_type_id">' + seat_type_ID +
                        '</td><td>' + seat_condition +
                        '</td><td class="d-none seat_condition_id">' + seat_condition_ID +
                        '</td><td>' + price +
                        '</td><td class="text-center d-none">' + insertmethod +
                        '</td><td class=" d-none">' + inquryid + '</td><td class=" d-none">' +
                        inqurydetailid +
                        '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>'
                    );
                }

                $('#Btnupdatelist').hide();
                $('#formsubmit').show();
            }
        }
    });




    $('#main_job_category').change(function() {
        var main_job_category_id = $(this).val();
        if (main_job_category_id != '') {
            $.ajax({
                url: '<?php echo base_url('SalesJobsDetails/Getsubjobcategory'); ?>',
                type: 'post',
                data: {
                    main_job_category_id: main_job_category_id
                },
                dataType: 'json',
                success: function(response) {
                    var len = response.length;
                    $('#sub_job_category').empty();
                    $('#sub_job_category').append("<option value=''>Select</option>");

                    for (var i = 0; i < len; i++) {
                        var id = response[i]['idtbl_sub_job_category'];
                        var name = response[i]['sub_job_category'];

                        $('#sub_job_category').append("<option value='" + id + "'>" + name +
                            "</option>");
                    }
                }
            });
        } else {
            $('#sub_job_category').empty();
            $('#sub_job_category').append("<option value=''>Select</option>");
        }
    });

    $('#sub_job_category').change(function() {
        var main_job_category_id = $('#main_job_category').val();
        var sub_job_category_id = $(this).val();
        if (sub_job_category_id != '') {
            $.ajax({
                url: '<?php echo base_url('Job_price_details/Getsalesjobdetails'); ?>',
                type: 'post',
                data: {
                    main_job_category_id: main_job_category_id,
                    sub_job_category_id: sub_job_category_id
                },
                dataType: 'json',
                success: function(response) {
                    var len = response.length;
                    $('#job_name').empty();
                    $('#job_name').append("<option value=''>Select</option>");

                    for (var i = 0; i < len; i++) {
                        var id = response[i]['idtbl_sales_jobs_details'];
                        var name = response[i]['sales_job_name'];

                        $('#job_name').append("<option value='" + id + "'>" + name +
                            "</option>");
                    }
                }
            });
        } else {
            $('#job_name').empty();
            $('#job_name').append("<option value=''>Select</option>");
        }
    });



    $('#job_name').change(function() {
        var sub_job_category_id = $('#sub_job_category').val();

        var job_name_id = $(this).val();

        console.log(sub_job_category_id, job_name_id);
        if (job_name_id != '') {
            $.ajax({
                url: '<?php echo base_url('Job_price_details/Get_repair_type'); ?>',
                type: 'post',
                data: {
                    job_name_id: job_name_id,
                    sub_job_category_id: sub_job_category_id
                },
                dataType: 'json',
                success: function(response) {
                    var len = response.length;
                    $('#repair_type_id').empty();
                    $('#repair_type_id').append("<option value=''>Select</option>");

                    for (var i = 0; i < len; i++) {
                        var id = response[i]['idtbl_seat_repair_category'];
                        var name = response[i]['sub_Repair_job_name'];

                        $('#repair_type_id').append("<option value='" + id + "'>" + name +
                            "</option>");
                    }
                }
            });
        } else {
            $('#repair_type_id').empty();
            $('#repair_type_id').append("<option value=''>Select</option>");
        }
    });







    $('#sub_job_category').change(function() {
        var main_job_category_id = $('#main_job_category').val();
        var sub_job_category_id = $(this).val();
        if (sub_job_category_id != '') {
            $.ajax({
                url: '<?php echo base_url('Job_price_details/Getseat_type'); ?>',
                type: 'post',
                data: {
                    main_job_category_id: main_job_category_id,
                    sub_job_category_id: sub_job_category_id
                },
                dataType: 'json',
                success: function(response) {
                    var len = response.length;
                    $('#seat_type_id').empty();
                    $('#seat_type_id').append("<option value=''>Select</option>");

                    for (var i = 0; i < len; i++) {
                        var id = response[i]['idtbl_seat_type'];
                        var name = response[i]['seat_type'];

                        $('#seat_type_id').append("<option value='" + id + "'>" + name +
                            "</option>");
                    }
                }
            });
        } else {
            $('#seat_type_id').empty();
            $('#seat_type_id').append("<option value=''>Select</option>");
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