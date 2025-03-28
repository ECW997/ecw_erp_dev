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
                                <form action="<?php echo base_url() ?>User/Userprivilegeinsertupdate" method="post" autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">User*</label>
                                        <select type="text" class="form-control form-control-sm" name="userlist" id="userlist" required>
                                            <option value="">Select</option>
                                            <?php foreach ($useraccount->result() as $rowuseraccount) { ?>
                                            <option value="<?php echo $rowuseraccount->idtbl_user ?>"><?php echo $rowuseraccount->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Access Menu*</label>
                                        <select type="text" class="form-control form-control-sm" name="menulist[]" id="menulist" required multiple>
                                            <?php foreach ($menulist->result() as $rowmenulist) { ?>
                                            <option value="<?php echo $rowmenulist->idtbl_menu_list ?>"><?php echo $rowmenulist->menu ?></option>
                                            <?php } ?>
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
                                            <input class="custom-control-input" type="checkbox" value="1" id="approvecheck" name="approvecheck">
                                            <label class="custom-control-label" for="approvecheck">
                                                Approve Privilege
                                            </label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" value="1" id="allfollowupcheck" name="allfollowupcheck">
                                            <label class="custom-control-label" for="allfollowupcheck">
                                                All Followup Privilege
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
                                            <th>Approve</th>
                                            <th>All Followup</th>
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
                url: "<?php echo base_url() ?>scripts/userprivilegelist.php",
                type: "POST", // you can use GET
                data: function(d) {
                    d.userID = '<?php echo $_SESSION['userid']; ?>';
                }
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_user_privilege"
                },
                {
                    "data": "name"
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
                        if(full['approve']==1){
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
                        if(full['all_followup']==1){
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
                        button+='<a href="<?php echo base_url() ?>User/Userprivilegestatus/'+full['idtbl_user_privilege']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck==0){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else {
                        button+='<a href="<?php echo base_url() ?>User/Userprivilegestatus/'+full['idtbl_user_privilege']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck==0){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>User/Userprivilegestatus/'+full['idtbl_user_privilege']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck==0){button+='d-none';}button+='"><i class="far fa-trash-alt"></i></a>';
                        
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
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>User/Userprivilegeedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#userlist').val(obj.user);

                        var menulist = obj.menu;
                        var menulistoption = [];
                        $.each(menulist, function(i, item) {
                            menulistoption.push(menulist[i].menulistID);
                        });

                        $('#menulist').val(menulistoption);
                        $('#menulist').trigger('change');

                        if(obj.add==1){$('#addcheck').prop('checked', true);}
                        if(obj.edit==1){$('#editcheck').prop('checked', true);}
                        if(obj.statuschange==1){$('#statuscheck').prop('checked', true);}
                        if(obj.remove==1){$('#removecheck').prop('checked', true);}
                        if(obj.approve==1){$('#approvecheck').prop('checked', true);}
                        if(obj.all_followup==1){$('#allfollowupcheck').prop('checked', true);}

                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
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
