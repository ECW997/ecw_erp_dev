<?php 
include "include/header.php";  

include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <style>
        .custom-file-input~.custom-file-label::after {
            content: "Browse";
        }

        #imagePreview {
            display: block;
            max-width: 100%;
            height: auto;
            border: 3px solid #007bff;
            /* Blue border */
            border-radius: 8px;
            padding: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Soft shadow for better aesthetics */
        }

        #addPriceModalCenter .modal-content {
            border: 4px solid #0982e6;
            /* Light blue color */
            border-radius: 25px;
            /* Optional: Add rounded corners */
        }
        </style>
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-drafting-compass"></i></div>
                            <span>Stitching Design</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo base_url() ?>Stitching_Design/Stitching_Designinsertupdate"
                                    method="post" autocomplete="off" enctype="multipart/form-data">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Stitching Design Code*</label>
                                        <input type="text" class="form-control form-control-sm" name="code" id="code"
                                            required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="small font-weight-bold">Upload Design Image</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="design_image"
                                                id="design_image" required onchange="previewImage(event)">
                                            <label class="custom-file-label" for="design_image">Choose image...</label>
                                        </div>
                                        <div class="mt-3">
                                            <img id="imagePreview" src="#" alt="Image Preview" style="display: none;">
                                        </div>
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
                                                <th>Stitching Design Code</th>
                                                <th>Design Image</th>
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


<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img id="modalImage" src="" class="img-fluid" alt="Large Image">
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addPriceModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="addSupervisorModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPriceModalLongTitle">Add Price</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="small font-weight-bold text-dark">Vehicle Type*</label>
                        <select class="form-control form-control-sm " name="vehicle_type_id" id="vehicle_type_id"
                            required>
                            <option value="">Select</option>
                            <option value="1">Vehicle</option>
                            <option value="2">Bike</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="small font-weight-bold text-dark">Price Category Type*</label>
                        <select class="form-control form-control-sm " name="price_category_id" id="price_category_id"
                            required>
                            <option value="">Select</option>
                            <?php foreach($price_categorylist->result() as $rowprice_categorylist){ ?>
                            <option value="<?php echo $rowprice_categorylist->idtbl_price_category_type ?>">
                                <?php echo $rowprice_categorylist->price_category_type ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="small font-weight-bold text-dark">Price</label>
                        <input type="number" step="any" class="form-control form-control-sm" name="price" id="price">
                    </div>
                    <div class="col-12 mt-3 text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="addPrice_btn"><i
                                class="fas fa-plus"></i>&nbsp;Add</button>
                    </div>
                </div>
                <input type="hidden" name="price_recordOption" id="price_recordOption" value="1">
                <input type="hidden" name="price_recordID" id="price_recordID" value="">
                <input type="hidden" name="main_table_id" id="main_table_id" value="">
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap w-100"
                                id="priceDetailsTable">
                                <thead>
                                    <tr>
                                        <th>Vehicle Type</th>
                                        <th>Price Category Type</th>
                                        <th>Price</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include "include/footerscripts.php"; ?>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');
    const fileName = input.files[0].name;
    const label = input.nextElementSibling;

    label.innerText = fileName;

    const reader = new FileReader();
    reader.onload = function() {
        preview.src = reader.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>

<script>
function viewLargeImage(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    $('#imageModal').modal('show');
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
                title: 'Stitching Design Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Stitching Design Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Stitching Design Information',
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
            url: "<?php echo base_url() ?>scripts/stitchingdesignlist.php",
            type: "POST", // you can use GET
            // data: function(d) {}
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "idtbl_stitching_design"
            },
            {
                "data": "stitching_code"
            },

            {
                "data": "image_path",
                "render": function(data, type, full) {
                    return `<img src="<?php echo base_url('images/Stitching_img/'); ?>${data}" 
                            class="img-thumbnail" style="width: 50px; height: 50px; cursor: pointer;" 
                            onclick="viewLargeImage('<?php echo base_url('images/Stitching_img/'); ?>${data}')">`;
                }
            },


            {
                "data": null,
                "className": 'text-right',
                "render": function(data, type, full) {
                    // Actions column as in original code
                    var button = '';
                    button +=
                        '<button title="Add Prices" class="btn btn-secondary btn-sm btnPriceAdd mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '" id="' + full['idtbl_stitching_design'] +
                        '"><i class="fas fa-hand-holding-usd"></i></button>';

                    button +=
                        '<button title="Edit" class="btn btn-primary btn-sm btnEdit mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '" id="' + full['idtbl_stitching_design'] +
                        '"><i class="fas fa-pen"></i></button>';
                    if (full['status'] == 1) {
                        button +=
                            '<a title="Deactive" href="<?php echo base_url() ?>Stitching_Design/Stitching_Designstatus/' +
                            full['idtbl_stitching_design'] +
                            '/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></a>';
                    } else {
                        button +=
                            '<a title="Active" href="<?php echo base_url() ?>Stitching_Design/Stitching_Designstatus/' +
                            full['idtbl_stitching_design'] +
                            '/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-times"></i></a>';
                    }
                    button +=
                        '<a title="Delete" href="<?php echo base_url() ?>Stitching_Design/Stitching_Designstatus/' +
                        full['idtbl_stitching_design'] +
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
                url: '<?php echo base_url() ?>Stitching_Design/Stitching_Designedit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#recordID').val(obj.id);
                    $('#code').val(obj.code);

                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        }
    });

    $('#dataTable tbody').on('click', '.btnPriceAdd', function() {
        var id = $(this).attr('id');
        $('#main_table_id').val(id);
        priceAddTable(id, addcheck, editcheck, statuscheck, deletecheck);
        $('#addPriceModalCenter').modal('show');
    })

    $('#addPrice_btn').click(function() {
        if ($('#price_category_id').val() != '' && $('#price').val() != '' && $('#vehicle_type_id')
            .val() != '') {
            $('#addPrice_btn').prop('disabled', true).html(
                '<i class="fas fa-circle-notch fa-spin mr-2"></i>');

            var main_table_id = $('#main_table_id').val();
            var price_category_id = $('#price_category_id').val();
            var price = $('#price').val();
            var vehicle_type_id = $('#vehicle_type_id').val();
            var recordOption = $('#price_recordOption').val();
            var recordID = $('#price_recordID').val();

            $.ajax({
                type: "POST",
                data: {
                    main_table_id: main_table_id,
                    price_category_id: price_category_id,
                    price: price,
                    vehicle_type_id: vehicle_type_id,
                    recordOption: recordOption,
                    recordID: recordID
                },
                url: '<?php echo base_url() ?>Stitching_Design/AddPriceinsertupdate',
                success: function(result) { //alert(result);
                    // console.log(result);
                    var objfirst = JSON.parse(result);
                    if (objfirst.status == 1) {
                        var actionData = JSON.parse(objfirst.action);
                        toastr.success(actionData.message, 'Success');
                        $('#priceDetailsTable').DataTable().ajax.reload();

                    } else {
                        var actionData = JSON.parse(objfirst.action);
                        toastr.error(actionData.message, 'Error');
                    }
                    $('#addPrice_btn').prop('disabled', false).html(
                        '<i class="fas fa-plus"></i>&nbsp;Add')

                    $('#price_recordOption').val('1');
                    $('#price_category_id').val('');
                    $('#vehicle_type_id').val('');
                    $('#price').val('');
                }
            });
        } else {
            toastr.error('Please Select Price Category & Price!', 'Error');
            return false;
        }

    });

    $('#priceDetailsTable tbody').on('click', '.btnEdit', function() {
        var r = confirm("Are you sure, You want to Edit this ? ");
        if (r == true) {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Stitching_Design/PriceCategoryedit',
                success: function(result) {
                    alert(result);
                    var obj = JSON.parse(result);
                    $('#price_recordID').val(obj.id);
                    $('#price').val(obj.price);
                    $('#vehicle_type_id').val(obj.vehicle_type);
                    $('#price_category_id').val(obj.price_category_type_id);

                    $('#price_recordOption').val('2');
                    $('#addPrice_btn').html('<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        }
    });
});

function priceAddTable(id, addcheck, editcheck, statuscheck, deletecheck) {
    $('#priceDetailsTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-3'l><'col-sm-2'><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/stitchingdesignpricelist.php",
            type: "POST", // you can use GET
            "data": function(d) {
                return $.extend({}, d, {
                    "company_branch_id": '<?php echo ($_SESSION['branch_id']); ?>',
                    "main_table_id": id
                });
            }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "vehicle_type",
                "render": function(data, type, row) {
                    return data == 1 ? "Vehicle" : data == 2 ? "Bike" : data;
                }
            },
            {
                "data": "price_category_type"
            },
            {
                "data": "price"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button += '<button title="Edit" class="btn btn-primary btn-sm btnEdit mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '" id="' + full['idtbl_stitching_design_price_details'] +
                        '"><i class="fas fa-pen"></i></button>';
                    button += '<button title="Delete" value="' + full[
                            'idtbl_stitching_design_price_details'] +
                        '" onclick="deleteSupervisor(this.value);" class="btn btn-danger btn-sm ';
                    if (deletecheck != 1) {
                        button += 'd-none';
                    }
                    button += '"><i class="fas fa-trash-alt"></i></button>';

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function deleteSupervisor(value) {
    var r = confirm("Are you sure you want to remove this? ");
    if (r == true) {
        $.ajax({
            type: "POST",
            data: {
                recordID: value,
                type: '3'
            },
            url: 'Stitching_Design/Priceremove',
            success: function(result) { //alert(result);
                var objfirst = JSON.parse(result);
                if (objfirst.status == 1) {
                    var actionData = JSON.parse(objfirst.action);
                    toastr.success(actionData.message, 'Success');
                    $('#priceDetailsTable').DataTable().ajax.reload();
                } else {
                    toastr.error(actionData.message, 'Error');
                }
            }
        });
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