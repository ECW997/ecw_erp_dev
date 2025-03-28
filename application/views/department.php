<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">

    <div id="layoutSidenav_nav">
        <style>
        /* body {
            background: url('<?php echo base_url("assets/img/bg_7.jpg"); ?>') no-repeat center center fixed;
            background-size: contain;
        }

        #layoutSidenav_content {
            background: url('<?php echo base_url("assets/img/bg_7.jpg"); ?>') no-repeat center center;
            background-size: cover;
        } */


        table {
            position: relative;
            z-index: 1;
        }

        table::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?php echo base_url("assets/img/b1.png"); ?>');
            background-size: cover;
            background-position: center;
            opacity: 0.3;
            /* Adjust the opacity level */
            z-index: -1;
        }
        </style>




        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="folder"></i></div>
                            <span>Department</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo base_url() ?>Department/Departmentinsertupdate" method="post"
                                    autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Company Name*</label>
                                        <select class="form-control form-control-sm " name="company_id" id="company_id"
                                            required readonly style="pointer-events:none">
                                            <option value="">Select</option>
                                            <?php foreach($companylist->result() as $rowcompanylist){ ?>
                                            <option value="<?php echo $rowcompanylist->idtbl_company ?>">
                                                <?php echo $rowcompanylist->company ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Department Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="department_name"
                                            id="department_name" data-field="department_name"
                                            onkeyup="checkedDublicate(this)" required>
                                        <div id="department_nameerrorMsg"
                                            style="color: red; display: none;font-size: 0.8rem;"></div>
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
                                                <th>Department Name</th>
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
$(document).ready(function() {
    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';

    $('#company_id').val(<?php echo ($_SESSION['company_id']); ?>);

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
                title: 'Department Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Department Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Department Information',
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
            url: "<?php echo base_url() ?>scripts/departmentlist.php",
            type: "POST", // you can use GET
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "id"
            },
            {
                "data": "department_name"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button +=
                        '<button title="Edit" class="btn btn-primary btn-sm btnEdit mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '" id="' + full['id'] +
                        '"><i class="fas fa-pen"></i></button>';
                    if (full['status'] == 1) {
                        button +=
                            '<a title="Deactive" href="<?php echo base_url() ?>Department/Departmentstatus/' +
                            full['id'] +
                            '/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></a>';
                    } else {
                        button +=
                            '<a title="Active" href="<?php echo base_url() ?>Department/Departmentstatus/' +
                            full['id'] +
                            '/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-times"></i></a>';
                    }
                    button +=
                        '<a title="Delete" href="<?php echo base_url() ?>Department/Departmentstatus/' +
                        full[
                            'id'] +
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
                url: '<?php echo base_url() ?>Department/Departmentedit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#recordID').val(obj.id);
                    $('#department_name').val(obj.department_name);

                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        }
    });

});

function checkedDublicate(input) {

    var inputValue = input.value;
    var tablename = 'departments';
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