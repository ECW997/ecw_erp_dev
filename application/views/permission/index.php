<?php include __DIR__ . "/../include/header.php"; ?>
<?php include __DIR__ . "/../include/topnavbar.php"; ?>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include __DIR__ . "/../include/menubar.php"; ?>
    </div>

    <div id="layoutSidenav_content">
        <style>
            .module-card {
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                border: 1px solid #e0e0e0;
            }
            .module-card .card-header {
                border-bottom: 1px solid #dee2e6;
            }
            .permission-item {
                padding: 8px 12px;
                border-radius: 4px;
                transition: background-color 0.2s;
            }
            .permission-item:hover {
                background-color: #f8f9fa;
            }
            .module-title {
                color: #495057;
                font-size: 1.1rem;
            }
        </style>

        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="lock"></i></div>
                            <span>Permissions</span>
                        </h1>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card mb-3">
                    <div class="card-header">
                        <?php if (in_array('create_permission', $permissions)): ?>
                            <button class="btn btn-primary float-right raised" data-toggle="modal" data-target="#createPermissionModal">
                                <i class="fas fa-plus"></i>&nbsp;Add Permission
                            </button>
                        <?php endif; ?>
                    </div>

                    <div class="card-body">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap w-100" id="permissionTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Permission Name</th>
                                        <th>Module Name</th>
                                        <th width="35%" class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($all_permissions as $perm): ?>
                                        <tr>
                                            <td><?= $perm['id'] ?></td>
                                            <td><?= ($perm['name']) ?></td>
                                            <td><?= ($perm['module_name'] ?? 'General') ?></td>
                                            <td class="text-right">
                                                <?php if (in_array('update_permission', $permissions)): ?>
                                                    <button class="btn btn-success btn-sm raised" onclick="openEditModal(<?= $perm['id'] ?>)">
                                                        <i class="fas fa-edit"></i>&nbsp;Edit
                                                    </button>
                                                <?php endif; ?>

                                                <?php if (in_array('delete_permission', $permissions)): ?>
                                                    <a href="<?= base_url('UserPermission/delete/'.$perm['id']) ?>" class="btn btn-danger btn-sm raised" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>&nbsp;Delete
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include __DIR__ . "/../include/footerbar.php"; ?>
    </div>
</div>

<?php include __DIR__ . "/../include/footerscripts.php"; ?>

<!-- CREATE PERMISSION MODAL -->
<div class="modal fade" id="createPermissionModal" tabindex="-1" role="dialog" aria-labelledby="createPermissionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?= base_url('UserPermission/create') ?>" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="createPermissionLabel">Create Permission</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Permission Name</label>
            <input type="text" name="name" id="name" class="form-control" required />
          </div>
          <div class="form-group">
            <label>Module Name</label>
            <input type="text" name="module_name" id="module_name" class="form-control" placeholder="(e.g. User Management, Accounting)" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- EDIT PERMISSION MODAL -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" role="dialog" aria-labelledby="editPermissionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="editPermissionForm" method="POST">
        <input type="hidden" name="_method" value="PUT" />
        <div class="modal-header">
          <h5 class="modal-title" id="editPermissionLabel">Edit Permission</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Permission Name</label>
            <input type="text" name="editName" id="editName" class="form-control" required />
          </div>
          <div class="form-group">
            <label>Module Name</label>
            <input type="text" name="editModule" id="editModule" class="form-control" />
            <input type="hidden" name="recordID" id="recordID" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#permissionTable').DataTable();
});

function openEditModal(permId) {
    $.ajax({
        url: '<?= base_url("UserPermission/edit") ?>/' + permId,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
            if(result.status){
                $('#editName').val(result.data.name);
                $('#editModule').val(result.data.module_name);
                $('#recordID').val(result.data.id);
                $('#editPermissionForm').attr('action', '<?= base_url("UserPermission/update") ?>/' + permId);
                $('#editPermissionModal').modal('show');
            }
        },
        error: function(xhr, status, error) {
            alert('Failed to fetch permission data.');
        }
    });
}
</script>

<?php include __DIR__ . "/../include/footer.php"; ?>
