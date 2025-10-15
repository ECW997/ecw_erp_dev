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
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            <span>User Roles</span>
                        </h1>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card mb-3">
                    <div class="card-header">
                        <?php if (in_array('create_role', $permissions)): ?>
                            <button class="btn btn-primary float-right raised" data-toggle="modal" data-target="#createRoleModal">
                                <i class="fas fa-plus"></i>&nbsp;Add Role
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap w-100" id="roleTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th width="40%" class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($roles as $role): ?>
                                    <tr>
                                        <td><?= $role['id'] ?></td>
                                        <td><?= $role['name'] ?></td>
                                        <td class="text-right">
                                            <?php if (in_array('update_role', $permissions)): ?>
                                                <button class="btn btn-warning btn-sm raised" onclick="openPermissionModal(<?= $role['id'] ?>)">
                                                    <i class="fas fa-pen"></i>&nbsp;Add/Edit Permission
                                                </button>
                                            <?php endif; ?>
                                            <?php if (in_array('update_role', $permissions)): ?>
                                                <button class="btn btn-success btn-sm raised" onclick="openEditModal(<?= $role['id'] ?>)">
                                                    <i class="fas fa-edit"></i>&nbsp;Edit
                                                </button>
                                            <?php endif; ?>
                                            <?php if (in_array('delete_role', $permissions)): ?>
                                                <a href="<?= base_url('UserRole/delete/'.$role['id']) ?>" class="btn btn-danger btn-sm raised" onclick="return confirm('Are you sure?')">
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

<!-- CREATE ROLE MODAL -->
<div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?= base_url('UserRole/create') ?>" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="createRoleLabel">Create Role</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Role Name</label>
            <input type="text" name="role" id="role" class="form-control" required />
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

<!-- EDIT ROLE MODAL -->
<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="editRoleLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="editRoleForm" method="POST">
        <input type="hidden" name="_method" value="PUT" />
        <div class="modal-header">
          <h5 class="modal-title" id="editRoleLabel">Edit Role</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Role Name</label>
            <input type="text" name="editRoleName" id="editRoleName" class="form-control" required />
            <input type="hidden" name="recordID" id="recordID" class="form-control" required />
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

<!-- PERMISSION MODAL -->
<div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="permissionLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <form id="permissionRoleForm" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="permissionLabel">Role Permissions</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="permissionsContainer">
          <!-- Permissions checkboxes will be loaded dynamically -->
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
    $('#roleTable').DataTable();
});

function openEditModal(roleId) {
    $.ajax({
        url: '<?= base_url("UserRole/edit") ?>/' + roleId, 
        type: 'GET',
        dataType: 'json',
        success: function(result) {
            if(result.status){
                $('#editRoleName').val(result.data.name);
                $('#recordID').val(result.data.id);
                $('#editRoleForm').attr('action', '<?= base_url("UserRole/update") ?>/' + roleId);
                $('#editRoleModal').modal('show');
            }
        },
        error: function(xhr, status, error) {
            alert('Failed to fetch role data.');
        }
    });
}

function openPermissionModal(roleId) {
    $('#permissionModal').modal('show');
    $('#permissionsContainer').html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading permissions...</p></div>');

    $.ajax({
         url: '<?= base_url("UserRole/permissions") ?>/' + roleId, 
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if(res.status) {
                renderPermissions(res.data.permissions, res.data.role_permissions, roleId);
            } else {
                showError('Failed to load permissions.');
            }
        },
        error: function(err) {
            showError('Error fetching permissions.');
        }
    });
}

function renderPermissions(permissions, rolePermissions, roleId) {
                let html = '';
    const groupedPermissions = groupPermissionsByModule(permissions);
    
    for(let module in groupedPermissions) {
        html += createModuleCard(module, groupedPermissions[module], rolePermissions);
    }
    
    $('#permissionsContainer').html(html);
    $('#permissionRoleForm').attr('action', '<?= base_url("UserRole/updatePermission") ?>/' + roleId);
}

function groupPermissionsByModule(permissions) {
                let grouped = {};
                permissions.forEach(p => {
                    let module = p.module_name || 'General';
                    if(!grouped[module]) grouped[module] = [];
                    grouped[module].push(p);
                });
    return grouped;
}

function createModuleCard(moduleName, permissions, rolePermissions) {
    let permissionsHtml = '';
    
    permissions.forEach(permission => {
        const checked = rolePermissions.includes(permission.id.toString()) ? 'checked' : '';
        permissionsHtml += `
            <div class="form-check col-md-6">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="${permission.name}" id="perm_${permission.id}" ${checked}>
                <label class="form-check-label" for="perm_${permission.id}">
                    ${permission.name.replace(/_/g, ' ')}
                </label>
            </div>`;
    });

    return `
        <div class="card module-card mb-4 shadow-sm border-0">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <strong class="module-title">${moduleName}</strong>
                <small class="text-muted">${permissions.length} permissions</small>
            </div>
            <div class="card-body p-3">
                <div class="row g-2">
                    ${permissionsHtml}
                </div>
            </div>
        </div>`;
}

function formatPermissionName(name) {
    return name
        .replace(/([A-Z])/g, ' $1')
        .replace(/_/g, ' ')
        .replace(/\b\w/g, l => l.toUpperCase())
        .trim();
}

function showError(message) {
    $('#permissionsContainer').html(`
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-triangle me-2"></i>
            ${message}
        </div>
    `);
}

</script>

<?php include __DIR__ . "/../include/footer.php"; ?>
