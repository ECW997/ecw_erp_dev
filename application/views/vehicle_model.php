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
                            <div class="page-header-icon"><i class='fas fa-car-alt'></i></div>
                            <span>Vehicle Model</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo base_url() ?>Vehicle_model/Vehicle_modelinsertupdate"
                                    method="post" autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Vehicle Brand Name*</label>
                                        <div id="brand_Div">
                                            <select class="form-control form-control-sm " name="vehicle_brand_id"
                                                id="vehicle_brand_id" required>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        <input type="text" name="brand_text" class="form-control form-control-sm d-none" id="brand_text" readonly>
                                        <div style="text-align:right; margin-top:3px;">
                                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                                data-target="#brandModal">Add Brand</button>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Vehicle Type*</label>
                                        <select class="form-control form-control-sm " name="vehicle_type_id"
                                            id="vehicle_type_id" required>
                                            <option value="">Select</option>
                                            <?php foreach($typelist->result() as $rowtypelist){ ?>
                                            <option value="<?php echo $rowtypelist->idtbl_vehicle_type ?>">
                                                <?php echo $rowtypelist->vehicle_type_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Vehicle Series*</label>
                                        <select class="form-control form-control-sm " name="vehicle_series_id"
                                            id="vehicle_series_id">
                                            <option value="">Select</option>
                                            <?php foreach($serieslist->result() as $rowserieslist){ ?>
                                            <option value="<?php echo $rowserieslist->idtbl_vehicle_series ?>">
                                                <?php echo $rowserieslist->series_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Vehicle Generation*</label>
                                        <select class="form-control form-control-sm " name="vehicle_generation_id"
                                            id="vehicle_generation_id">
                                            <option value="">Select</option>
                                            <?php foreach($generationlist->result() as $rowgenerationlist){ ?>
                                            <option value="<?php echo $rowgenerationlist->idtbl_vehicle_generation ?>">
                                                <?php echo $rowgenerationlist->generation_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Vehicle Year*</label>
                                        <select class="form-control form-control-sm " name="vehicle_year_id"
                                            id="vehicle_year_id" required>
                                            <option value="">Select</option>
                                            <?php foreach($yearlist->result() as $rowyearlist){ ?>
                                            <option value="<?php echo $rowyearlist->idtbl_vehicle_year ?>">
                                                <?php echo $rowyearlist->year_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Price Category Type*</label>
                                        <select class="form-control form-control-sm " name="price_category_id"
                                            id="price_category_id" required>
                                            <option value="">Select</option>
                                            <?php foreach($price_categorylist->result() as $rowprice_categorylist){ ?>
                                            <option value="<?php echo $rowprice_categorylist->idtbl_price_category_type ?>">
                                                <?php echo $rowprice_categorylist->price_category_type ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Vehicle Model*</label>
                                        <input type="text" class="form-control form-control-sm" name="model_name"
                                            id="model_name" required>
                                    </div>
                                    <div class="form-group mt-2 text-right">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
                                            <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                            <div class="col-9">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap w-100"
                                        id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Vehicle Model Name</th>
                                                <th>Vehicle Brand Name</th>
                                                <th>Vehicle Type</th>
                                                <th>Vehicle Generation</th>
                                                <th>Vehicle series</th>
                                                <th>Vehicle year</th>
                                                <th>Price Category Type</th>
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

<!-- Brand Modal -->
<div class="modal fade" id="brandModal" tabindex="-1" role="dialog" aria-labelledby="brandModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createorderform" method="post" autocomplete="off">
                    <div class="form-group mb-1">
                        <label class="small font-weight-bold">Vehicle Brand Name*</label>
                        <input type="text" class="form-control form-control-sm" name="brand_name" id="brand_name"
                            data-field="brand_name" onkeyup="checkedDublicate(this)" required>
                        <div id="brand_name_errorMsg" style="color: red; display: none;font-size: 0.8rem;"></div>
                    </div>
                    <input name="add_brand_submitBtn" type="submit" value="Save" id="add_brand_submitBtn" class="d-none">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addBrand" name="addBrand" <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Save changes</button>
            </div>
        </div>
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

    $('#vehicle_type_id').select2({
        width: '100%',
    });
    $('#vehicle_series_id').select2({
        width: '100%',
    });

    $('#vehicle_generation_id').select2({
        width: '100%',
    });

    $('#vehicle_year_id').select2({
        width: '100%',
    });
    $('#price_category_id').select2({
        width: '100%',
    });


    $('#vehicle_brand_id').select2({
        ajax: {
            url: '<?php echo base_url() ?>Vehicle_model/Get_vehicle_brand',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term || '',
                    page: params.page || 1
                };
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
        },
        placeholder: 'Search Brand',
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
                title: 'Vehicle Model Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Vehicle Model Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Vehicle Model Information',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            },
            // 'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/vehiclemodellist.php",
            type: "POST", // you can use GET
            // data: function(d) {}
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "idtbl_vehicle_model"
            },
            {
                "data": "model_name"
            },
            {
                "data": "brand_name"
            },
            {
                "data": "vehicle_type_name"
            },
            {
                "data": "generation_name"
            },
            {
                "data": "series_name"
            },
            {
                "data": "year_name"
            },
            {
                "data": "price_category_type"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '" id="' + full['idtbl_vehicle_model'] +
                        '"><i class="fas fa-pen"></i></button>';
                    if (full['status'] == 1) {
                        button +=
                            '<a href="<?php echo base_url() ?>Vehicle_model/Vehicle_modelstatus/' +
                            full['idtbl_vehicle_model'] +
                            '/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></a>';
                    } else {
                        button +=
                            '<a href="<?php echo base_url() ?>Vehicle_model/Vehicle_modelstatus/' +
                            full['idtbl_vehicle_model'] +
                            '/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-times"></i></a>';
                    }
                    button +=
                        '<a href="<?php echo base_url() ?>Vehicle_model/Vehicle_modelstatus/' +
                        full['idtbl_vehicle_model'] +
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
    $('#dataTable tbody').on('click', '.btnEdit', function() {
        var r = confirm("Are you sure, You want to Edit this ? ");
        if (r == true) {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Vehicle_model/Vehicle_modeledit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);

                    $('#brand_Div').addClass('d-none');
                    $('#vehicle_brand_id').prop('required',false);
                    $('#brand_text').removeClass('d-none');

                    $('#recordID').val(obj.id);
                    $('#brand_text').val(obj.brand_name);
                    $('#model_name').val(obj.model_name);
                    $('#vehicle_brand_id').val(obj.vehicle_brand_id).trigger('change');
                    $('#vehicle_series_id').val(obj.vehicle_series_id).trigger('change');
                    $('#vehicle_generation_id').val(obj.vehicle_generation_id).trigger('change');
                    $('#vehicle_year_id').val(obj.vehicle_year_id).trigger('change');
                    $('#price_category_id').val(obj.price_category_id).trigger('change');
                    $('#vehicle_type_id').val(obj.vehicle_type_id).trigger('change');

                    // $('#job_name').val(obj.job_name).trigger('change');  

                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        }
    });


    $('#addBrand').click(function() { //alert('IN');
        if (!$("#createorderform")[0].checkValidity()) {
            $("#add_brand_submitBtn").click();
        } else {
        //alert("click");
            var brand_name = $('#brand_name').val();
        
            $.ajax({
                type: "POST",
                dataType: 'json',
                data: {
                    brand_name: brand_name,
                },
                url: 'Vehicle_model/Brand_insert',
                success: function(response) { //alert(result);
                if (response.status === 'success') {
                    toastr.success(response.message, 'Success');
                } else {
                    toastr.error(response.message, 'Error');
                }
                $('#brandModal').modal('hide');
                $('#brand_name').val('');
                }
            });
        }
    });
});

function checkedDublicate(input) {

var inputValue = input.value;
var tablename = 'tbl_vehicle_brand';
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
            $('#' + columnName + '_errorMsg').text(response.message).show();
            $('#addBrand').prop('disabled',true);
        } else {
            $('#' + columnName + '_errorMsg').hide();
            $('#addBrand').prop('disabled',false);
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