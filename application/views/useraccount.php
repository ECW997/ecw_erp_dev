<?php 
include "include/header.php";  

include "include/topnavbar.php"; 

$companyaql="SELECT * FROM `tbl_company`";
$companylist = $this->db->query($companyaql);
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
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            <span>User Account</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo base_url() ?>User/userAccountInsertUpdate" method="post" autocomplete="off">
                                <label class="small font-weight-bold text-dark">Company*</label>
                                    <select class="form-control form-control-sm " name="company_id" id="company_id"
                                        required>
                                        <option value="">Select</option>
                                        <?php foreach($companylist->result() as $rowcompanylist){ ?>
                                        <option value="<?php echo $rowcompanylist->idtbl_company ?>">
                                            <?php echo $rowcompanylist->company ?></option>
                                        <?php } ?>
                                    </select>
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold text-dark">Company Branch*</label>
                                    <select class="form-control form-control-sm" name="branch_id" id="branch_id"
                                        required>
                                        <option value="">Select</option>
                                        
                                    </select>
                                </div>
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold text-dark">Employee*</label>
                                    <select class="form-control form-control-sm" name="employee" id="employee"
                                        required>
                                        <option value="">Select</option>
                                        <?php foreach($employeelist->result() as $rowemployeelist){ ?>
                                        <option value="<?php echo $rowemployeelist->id ?>">
                                            <?php echo $rowemployeelist->calling_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Account Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="accountname" id="accountname" required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Username*</label>
                                        <input type="text" class="form-control form-control-sm" name="username" id="username" required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Password*</label>
                                        <input type="password" class="form-control form-control-sm" name="password" id="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="small font-weight-bold">User Type*</label>
                                        <select class="form-control form-control-sm" name="usertype" id="usertype" required>
                                            <option value="">Select</option>
                                           <?php foreach($usertype as $user): ?>
                                                <option value="<?php echo $user['idtbl_user_type']; ?>"><?php echo $user['type']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group mt-2 text-right">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                            <div class="col-9">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Type</th>
                                                <th>Company</th>
                                                <th>Branch</th>
                                                <th class="text-right">&nbsp;</th>
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
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        $('#company_id').select2({
            width: '100%',
        });
        $('#branch_id').select2({
            width: '100%',
        });
        $('#employee').select2({
            width: '100%',
        });

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: apiBaseUrl + '/v1/user_account',
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
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "id"
                },
                {
                    "data": "name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "user_type"
                },
                {
                    "data": "company_name"
                },
                {
                    "data": "branch_name"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['id']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>User/userAccountStatus/'+full['id']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>User/userAccountStatus/'+full['id']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>User/userAccountStatus/'+full['id']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';
                        
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
                    dataType: "json",
                    url: '<?php echo base_url() ?>User/userAccountEdit/'+id,
                    success: function(result) { //alert(result);
                        if (result.status) {
                            $('#recordID').val(result.data.id);
                            // $('#company_id').val(result.data.company_id).trigger('change');
                            // $('#branch_id').val(result.data.branch_id).trigger('change');
                            $('#employee').val(result.data.employee_id).trigger('change');   
                            $('#accountname').val(result.data.name); 
                            $('#username').val(result.data.email); 
                            $('#usertype').val(result.data.user_type_id); 
                            $('#password').val(result.data.emp_password); 
                            // $('#password').removeAttr("required");

                            setEditFieldValue('#company_id', result.data.company_id)
                            .then(function() {
                                return setEditFieldValue('#branch_id', result.data.branch_id);
                            })
                            .catch(function(error) {
                                console.error(error);
                            });

                            $('#recordOption').val('2');
                            $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                        } else {
                            falseResponse(result);
                        }
                    }
                });
            }
        });


        $('#company_id').change(function() {
            var company_id = $(this).val();
            if (company_id != '') {
                $.ajax({
                    url: '<?php echo base_url('Company/Getcompanybranch'); ?>', // Replace with your actual controller and method
                    type: 'post',
                    data: {company_id: company_id},
                    dataType: 'json',
                    success:function(response) {
                        var len = response.length;
                        $('#branch_id').empty();
                        $('#branch_id').append("<option value=''>Select</option>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['idtbl_company_branch'];
                            var name = response[i]['branch'];
                            $('#branch_id').append("<option value='" + id + "'>" + name + "</option>");
                        }
                    }
                });
            } else {
                $('#branch_id').empty();
                $('#branch_id').append("<option value=''>Select</option>");
            }
        });


        $('#branch_id').change(function() {
            var companyname = $("#company_id option:selected").text().trim();;
            var branchname = $("#branch_id option:selected").text().trim();;

            $('#company_text').val(companyname);
            $('#branch_text').val(branchname);
        })

        $('#emp').change(function(){
            var employee_id = $(this).val();
            if (employee_id != '') {
                $.ajax({
                    url: '<?php echo base_url('User/Getemployeedetails'); ?>', 
                    type: 'post',
                    data: {employee_id: employee_id},
                    success:function(result) {
                        var obj = JSON.parse(result);
                        $('#accountname').val(obj.calling_name);
                    }
                });
            } else {
                $('#accountname').val('');
            }
        })
    });

    function setEditFieldValue(selector, value) {
        return new Promise(function(resolve) {
            $(selector).val(value).trigger('change');
            setTimeout(() => resolve(), 200);
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
