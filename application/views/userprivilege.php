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
                        <h1 class="page-header-title font-weight-light">
                            <div class="page-header-icon"><i data-feather="user-check"></i></div>
                            <span>User Privilege</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo base_url() ?>User/privilegeInsertUpdate" method="post" autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">User*</label>
                                        <select type="text" class="form-control form-control-sm" name="userlist" id="userlist" required>
                                            <option value="">Select</option>
                                            <?php foreach($users as $user): ?>
                                                <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Access Menu*</label>
                                        <select type="text" class="form-control form-control-sm" name="menulist[]" id="menulist" required multiple>
                                            <option value="">Select</option>
                                            <?php foreach($menulist as $menu): ?>
                                                <option value="<?php echo $menu['idtbl_menu_list']; ?>"><?php echo $menu['menu']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="small font-weight-bold">User Privilege*</label><br>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="1" id="addcheck" name="addcheck">
                                            <label class="custom-control-label" for="addcheck">
                                                Add Privilege
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="1" id="editcheck" name="editcheck">
                                            <label class="custom-control-label" for="editcheck">
                                                Edit Privilege
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="1" id="statuscheck" name="statuscheck">
                                            <label class="custom-control-label" for="statuscheck">
                                                Status Privilege
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="1" id="removecheck" name="removecheck">
                                            <label class="custom-control-label" for="removecheck">
                                                Delete Privilege
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="1" id="approve1check" name="approve1check">
                                            <label class="custom-control-label" for="approve1check">
                                                Approve 1 Privilege
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="1" id="approve2check" name="approve2check">
                                            <label class="custom-control-label" for="approve2check">
                                                Approve 2 Privilege
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="1" id="approve3check" name="approve3check">
                                            <label class="custom-control-label" for="approve3check">
                                                Approve 3 Privilege
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="1" id="approve4check" name="approve4check">
                                            <label class="custom-control-label" for="approve4check">
                                                Approve 4 Privilege
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="1" id="cancelcheck" name="cancelcheck">
                                            <label class="custom-control-label" for="cancelcheck">
                                                Cancel Privilege
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2 text-right">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                            <div class="col-9">
                                <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Menu</th>
                                            <th>Add</th>
                                            <th>Edit</th>
                                            <th>Active | Deactive</th>
                                            <th>Delete</th>
                                            <th>Approve 1</th>
                                            <th>Approve 2</th>
                                            <th>Approve 3</th>
                                            <th>Approve 4</th>
                                            <th>Cancel</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
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

        $("#menulist").select2();

        $('#dataTable').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: apiBaseUrl + '/v1/user_privilege',
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
                    "data": "idtbl_user_privilege"
                },
                {
                    "data": "user"
                },
                {
                    "data": "menu"
                },
                {
                    "targets": -1,
                    "className": 'text-center',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['add']==1){
                            return '<i class="fas fa-check text-success mt-2"></i>';
                        }
                        else{
                            return '<i class="fas fa-times text-danger mt-2"></i>';
                        }
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-center',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['edit']==1){
                            return '<i class="fas fa-check text-success mt-2"></i>';
                        }
                        else{
                            return '<i class="fas fa-times text-danger mt-2"></i>';
                        }
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-center',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['statuschange']==1){
                            return '<i class="fas fa-check text-success mt-2"></i>';
                        }
                        else{
                            return '<i class="fas fa-times text-danger mt-2"></i>';
                        }
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-center',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['remove']==1){
                            return '<i class="fas fa-check text-success mt-2"></i>';
                        }
                        else{
                            return '<i class="fas fa-times text-danger mt-2"></i>';
                        }
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-center',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['approve1']==1){
                            return '<i class="fas fa-check text-success mt-2"></i>';
                        }
                        else{
                            return '<i class="fas fa-times text-danger mt-2"></i>';
                        }
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-center',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['approve2']==1){
                            return '<i class="fas fa-check text-success mt-2"></i>';
                        }
                        else{
                            return '<i class="fas fa-times text-danger mt-2"></i>';
                        }
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-center',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['approve3']==1){
                            return '<i class="fas fa-check text-success mt-2"></i>';
                        }
                        else{
                            return '<i class="fas fa-times text-danger mt-2"></i>';
                        }
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-center',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['approve4']==1){
                            return '<i class="fas fa-check text-success mt-2"></i>';
                        }
                        else{
                            return '<i class="fas fa-times text-danger mt-2"></i>';
                        }
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-center',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['cancel']==1){
                            return '<i class="fas fa-check text-success mt-2"></i>';
                        }
                        else{
                            return '<i class="fas fa-times text-danger mt-2"></i>';
                        }
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck==0){button+='d-none';}button+='" id="'+full['idtbl_user_privilege']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                        button+='<a href="<?php echo base_url() ?>User/privilegeStatus/'+full['idtbl_user_privilege']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck==0){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else {
                        button+='<a href="<?php echo base_url() ?>User/privilegeStatus/'+full['idtbl_user_privilege']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck==0){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>User/privilegeDelete/'+full['idtbl_user_privilege']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck==0){button+='d-none';}button+='"><i class="far fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        } );
        $('#dataTable tbody').on('click', '.btnEdit', function() {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    dataType : "json",
                    url: '<?php echo base_url() ?>User/privilegeEdit/'+id,
                    success: function(result) { //alert(result);
                        if (result.status) {
                            $('#recordID').val(result.data.idtbl_user_privilege);
                            $('#userlist').val(result.data.user_id);

                            // var menulist = result.data.menu;
                            // var menulistoption = [];
                            // $.each(menulist, function(i, item) {
                            //     menulistoption.push(menulist[i].menulistID);
                            // });

                            $('#menulist').val(result.data.tbl_menu_list_idtbl_menu_list);
                            $('#menulist').trigger('change');

                            if(result.data.add==1){$('#addcheck').prop('checked', true);}
                            if(result.data.edit==1){$('#editcheck').prop('checked', true);}
                            if(result.data.statuschange==1){$('#statuscheck').prop('checked', true);}
                            if(result.data.remove==1){$('#removecheck').prop('checked', true);}
                            if(result.data.approve1==1){$('#approve1check').prop('checked', true);}
                            if(result.data.approve2==1){$('#approve2check').prop('checked', true);}
                            if(result.data.approve3==1){$('#approve3check').prop('checked', true);}
                            if(result.data.approve4==1){$('#approve4check').prop('checked', true);}
                            if(result.data.cancel==1){$('#cancelcheck').prop('checked', true);}

                            $('#recordOption').val('2');
                            $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                        }
                    }
                });
            }
        });
    });

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
