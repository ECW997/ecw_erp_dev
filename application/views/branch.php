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
            <div class="page-header page-header-light bg-gray shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="folder"></i></div>
                            <span>Branch</span>
                        </h1>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo base_url() ?>Branch/Branchinsertupdate" method="post"
                                    autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Company Name*</label>
                                        <select class="form-control form-control-sm " name="company_id" id="company_id"
                                            required>
                                            <option value="">Select</option>
                                            <?php foreach($companylist->result() as $rowcompanylist){ ?>
                                            <option value="<?php echo $rowcompanylist->idtbl_company ?>">
                                                <?php echo $rowcompanylist->company ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Branch Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="branch_name"
                                            id="branch_name" data-field="branch" onkeyup="checkedDublicate(this)"
                                            required>
                                        <div id="branch_errorMsg" style="color: red; display: none;font-size: 0.8rem;">
                                        </div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Code*</label>
                                        <input type="text" class="form-control form-control-sm" name="code" id="code"
                                            data-field="code" onkeyup="checkedDublicate(this)" required>
                                        <div id="code_errorMsg" style="color: red; display: none;font-size: 0.8rem;">
                                        </div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Address*</label>
                                        <input type="text" class="form-control form-control-sm" name="address"
                                            id="address" required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Mobile No*</label>
                                        <input type="text" class="form-control form-control-sm" name="mobile_no"
                                            id="mobile_no" required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Email*</label>
                                        <input type="text" class="form-control form-control-sm" name="email" id="email"
                                            data-field="email" onkeyup="checkedDublicate(this)" required>
                                        <div id="email_errorMsg" style="color: red; display: none;font-size: 0.8rem;">
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
                                                <th>Branch Name</th>
                                                <th>Company Name</th>
                                                <th>Code</th>
                                                <th>Address</th>
                                                <th>Mobile No</th>
                                                <th>Email</th>
                                                <!-- <th>Company</th> -->
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

    $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        ajax: {
            url: "<?php echo base_url() ?>scripts/branchlist.php",
            type: "POST", // you can use GET
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "idtbl_company_branch"
            },
            {
                "data": "branch"
            },
            {
                "data": "company"
            },
            {
                "data": "code"
            },
            {
                "data": "address1"
            },
            {
                "data": "mobile"
            },
            {
                "data": "email"
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
                    button += '" id="' + full['idtbl_company_branch'] +
                        '"><i class="fas fa-pen"></i></button>';
                    if (full['status'] == 1) {
                        button += '<a href="<?php echo base_url() ?>Branch/Branchstatus/' +
                            full['idtbl_company_branch'] +
                            '/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></a>';
                    } else {
                        button += '<a href="<?php echo base_url() ?>Branch/Branchstatus/' +
                            full['idtbl_company_branch'] +
                            '/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-times"></i></a>';
                    }
                    button += '<a href="<?php echo base_url() ?>Branch/Branchstatus/' + full[
                            'idtbl_company_branch'] +
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
                url: '<?php echo base_url() ?>Branch/Branchedit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#recordID').val(obj.id);
                    $('#company_id').val(obj.company_id);
                    $('#branch_name').val(obj.branch_name);
                    $('#code').val(obj.code);
                    $('#address').val(obj.address);
                    $('#mobile_no').val(obj.mobile);
                    $('#email').val(obj.email);

                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        }
    });

});

function checkedDublicate(input) {

    var inputValue = input.value;
    var tablename = 'tbl_company_branch';
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