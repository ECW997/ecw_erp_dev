<?php 

$addcheck = 1;
$editcheck = 1;
$statuscheck = 1;
$deletecheck = 1;

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
                            <div class="page-header-icon"><i data-feather="users"></i></div>
                            <span>Coordinator</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo base_url() ?>Coordinator/Coordinatorinsertupdate" method="post"
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
                                    <input type="hidden" name="f_company_id" id="f_company_id">
                                    <input type="hidden" name="f_branch_id" id="f_branch_id">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Coordinator Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="coordinator_name"
                                            id="coordinator_name" data-field="coordinator_name"
                                            onkeyup="checkedDublicate(this)" required>
                                        <div id="coordinator_name_errorMsg"
                                            style="color: red; display: none;font-size: 0.8rem;">
                                        </div>
                                        <div class="form-group mt-2 text-right">
                                            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
                                                <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                    class="far fa-save"></i>&nbsp;Add</button>
                                        </div>
                                        <input type="hidden" name="recordOption" id="recordOption" value="1">
                                        <input type="hidden" name="recordID" id="recordID" value="">
                                    </div>
                                </form>
                            </div>
                            <div class="col-9">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap w-100"
                                        id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Inquiry Source Name</th>
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
    // Open the modal when the page loads

    $('#f_company_id').val('<?php echo ($_SESSION['company_id']); ?>');
    $('#f_company_name').val('<?php echo ($_SESSION['companyname']); ?>');
    $('#f_branch_id').val('<?php echo ($_SESSION['branch_id']); ?>');
    $('#f_branch_name').val('<?php echo ($_SESSION['branchname']); ?>');


});
</script>

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
                title: 'Employee Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Employee Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Employee Information',
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
            url: "<?php echo base_url() ?>scripts/coordinatorlist.php",
            type: "POST", // you can use GET
            "data": function(d) {
                return $.extend({}, d, {
                    "company_branch_id": '<?php echo ($_SESSION['branch_id']); ?>',
                });
            }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "idtbl_coordinator"
            },
            {
                "data": "coordinator_name"
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
                    button += '" id="' + full['idtbl_coordinator'] +
                        '"><i class="fas fa-pen"></i></button>';
                    if (full['status'] == 1) {
                        button +=
                            '<a href="<?php echo base_url() ?>Coordinator/Coordinatorstatus/' +
                            full['idtbl_coordinator'] +
                            '/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></a>';
                    } else {
                        button +=
                            '<a href="<?php echo base_url() ?>Coordinator/Coordinatorstatus/' +
                            full['idtbl_coordinator'] +
                            '/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-times"></i></a>';
                    }
                    button +=
                        '<a href="<?php echo base_url() ?>Coordinator/Coordinatorstatus/' +
                        full['idtbl_coordinator'] +
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
                url: '<?php echo base_url() ?>Coordinator/Coordinatoredit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#recordID').val(obj.id);
                    $('#coordinator_name').val(obj.coordinator_name);
                    // $('#code').val(obj.code);      
                    // $('#address').val(obj.address);  
                    // $('#mobile_no').val(obj.mobile_no);  
                    // $('#email').val(obj.email);  

                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        }
    });
});

function checkedDublicate(input) {

    var inputValue = input.value;
    var tablename = 'tbl_coordinator';
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