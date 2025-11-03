<?php include __DIR__ . "/../include/header.php"; ?>
<?php include __DIR__ . "/../include/topnavbar.php"; ?>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include __DIR__ . "/../include/menubar.php"; ?>
    </div>

	<style>
	
	</style>

    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="users"></i></div>
                            <span>Users</span>
                        </h1>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt-2 p-2">
                <div class="card mb-3">
                    <div class="card-header">
                        <?php if (in_array('create_user', $permissions)): ?>
                            <button class="btn btn-primary float-right raised" data-toggle="modal" data-target="#createUserModal">
                                <i class="fas fa-plus"></i>&nbsp;Add User
                            </button>
                        <?php endif; ?>
                    </div>

                    <div class="card-body">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap w-100" id="userTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th class="text-center">Roles</th>
										<th>Branch</th>
										<th class="text-center">Status</th>
                                        <th width="30%" class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $user): ?>
                                        <tr>
                                            <td><?= $user['id'] ?></td>
                                            <td><?= ($user['name']) ?></td>
                                            <td><?= ($user['email']) ?></td>
                                            <td class="text-center">
                                                <?php if (!empty($user['roles'])): ?>
                                                    <?php foreach ($user['roles'] as $role): ?>
                                                        <span class="badge bg-primary text-white"><?= ($role) ?></span>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </td>
											<td><?= $user['branch_id'] == 1 ? 'Nittambuwa' : ($user['branch_id'] == 2 ? 'Negombo' : 'Unknown') ?></td>
											<td class="text-center">
												<span class="badge <?= $user['status'] == 1 ? 'bg-success text-white' : ($user['status'] == 2 ? 'bg-danger text-white' : 'bg-secondary') ?>">
													<?= $user['status'] == 1 ? 'Active' : ($user['status'] == 2 ? 'De-Active' : 'Unknown') ?>
												</span>
											</td>
                                            <td class="text-right">
                                                <?php if (in_array('update_user', $permissions)): ?>
                                                    <button class="btn btn-success btn-sm raised" onclick="openEditModal(<?= $user['id'] ?>)">
                                                        <i class="fas fa-edit"></i>&nbsp;Edit
                                                    </button>
                                                <?php endif; ?>
												<?php if (in_array('update_user', $permissions)): ?>
													<button class="btn btn-info btn-sm raised" onclick="openPermissionsModal(<?= $user['id'] ?>)">
														<i class="fas fa-shield-alt"></i>&nbsp;Permissions
													</button>
												<?php endif; ?>
												<?php if (in_array('update_user', $permissions)): ?>
													<?php if ($user['status'] == '1'): ?>
														<a href="<?= base_url('User_v2/deactivate/'.$user['id']) ?>" 
														class="btn btn-warning btn-sm raised" 
														onclick="return confirm('Are you sure to deactivate this user?')">
															<i class="fas fa-times"></i>&nbsp;Deactivate
														</a>
													<?php else: ?>
														<a href="<?= base_url('User_v2/activate/'.$user['id']) ?>" 
														class="btn btn-success btn-sm raised" 
														onclick="return confirm('Are you sure to activate this user?')">
															<i class="fas fa-check"></i>&nbsp;Activate
														</a>
													<?php endif; ?>
												<?php endif; ?>
                                                <?php if (in_array('delete_user', $permissions)): ?>
                                                    <a href="<?= base_url('User_v2/delete/'.$user['id']) ?>" class="btn btn-danger btn-sm raised" onclick="return confirm('Are you sure?')">
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

<!-- CREATE USER MODAL -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?= base_url('User_v2/create') ?>" method="POST">
				<div class="modal-header">
					<h5 class="modal-title" id="createUserLabel">Create User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" required />
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" class="form-control" required />
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control" required />
					</div>
					<div class="form-group">
						<label>Roles</label>
						<select name="roles[]" class="form-control" multiple>
							<?php foreach ($roles as $role): ?>
							<option value="<?= $role ?>"><?= ucfirst($role) ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label>Company</label>
						<select name="company_id" id="company_id" class="form-control" required>
							<option value="">Select Company</option>
							<option value="1">ECW</option>
							<option value="2">INT</option>
						</select>
					</div>
					<div class="form-group">
						<label>Branch</label>
						<select name="branch_id" id="branch_id" class="form-control" required>
							<option value="">Select Branch</option>
							<option value="1">Nittambuwa</option>
							<option value="2">Negombo</option>
						</select>
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

<!-- EDIT USER MODAL -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="editUserForm" method="POST">
				<input type="hidden" name="_method" value="PUT" />
				<div class="modal-header">
					<h5 class="modal-title" id="editUserLabel">Edit User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="recordID" name="recordID">
					<div class="form-group">
						<label>Name</label>
						<input type="text" id="editName" name="editName" class="form-control" required />
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" id="editEmail" name="editEmail" class="form-control" readonly />
					</div>
					<div class="form-group">
						<label>Password (leave blank to keep current)</label>
						<input type="password" id="editPassword" name="editPassword" class="form-control" />
					</div>
					<div class="form-group">
						<label>Roles</label>
						<select id="editRoles" name="editRoles[]" class="form-control" multiple>
							<?php foreach ($roles as $role): ?>
							<option value="<?= $role ?>"><?= ucfirst($role) ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label>Company</label>
						<select name="editCompany_id" id="editCompany_id" class="form-control" required>
							<option value="">Select Company</option>
							<option value="1">ECW</option>
							<option value="2">INT</option>
						</select>
					</div>

					<div class="form-group">
						<label>Branch</label>
						<select name="editBranch_id" id="editBranch_id" class="form-control" required>
							<option value="">Select Branch</option>
							<option value="1">Nittambuwa</option>
							<option value="2">Negombo</option>
						</select>
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

<!-- USER PERMISSION OVERRIDES MODAL -->
<div class="modal fade" id="userPermissionsModal" tabindex="-1" role="dialog" aria-labelledby="userPermissionsLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <form id="userPermissionsForm">
        <div class="modal-header">
          <h5 class="modal-title" id="userPermissionsLabel">User Permission Overrides</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <div id="permissionsContainer"></div>

          <div class="alert alert-info mt-3">
            <strong>Tip:</strong> Checked (✅) = Allowed, Crossed (🚫) = Denied.  
            Click “Reset to Role Defaults” to remove all user overrides.
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="resetPermissionsBtn">Reset to Role Defaults</button>
          <button type="submit" class="btn btn-primary">Save Overrides</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#userTable').DataTable();
});

function openEditModal(userId) {
    $.ajax({
        url: '<?= base_url("User_v2/edit") ?>/' + userId,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
            if(result.status){
                $('#editName').val(result.data.user.name);
                $('#editEmail').val(result.data.user.email);
                $('#editCompany_id').val(result.data.user.company_id);
                $('#editBranch_id').val(result.data.user.branch_id);
                $('#recordID').val(result.data.user.id);
                $('#editUserForm').attr('action', '<?= base_url("User_v2/update") ?>/' + userId);

                // Set selected roles
                $('#editRoles option').prop('selected', false);
                if (result.data.user_roles) {
					Object.values(result.data.user_roles).forEach(role => {
						$('#editRoles option[value="' + role + '"]').prop('selected', true);
					});
				}

                $('#editUserModal').modal('show');
            }
        },
        error: function() {
            alert('Failed to fetch user data.');
        }
    });
}

let currentPermissionsData = null;

function openPermissionsModal(userId) {
    $.ajax({
        url: '<?= base_url("User_v2/permissions/") ?>' + userId,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
            if (!result.status) {
                $('#permissionsContainer').html('<p class="text-danger">Failed to load permissions.</p>');
                return;
            }

            currentPermissionsData = result.data;

            // Parse overrides if stored as JSON string
            if (typeof currentPermissionsData.overrides === 'string') {
                try {
                    currentPermissionsData.overrides = JSON.parse(currentPermissionsData.overrides);
                } catch (e) {
                    currentPermissionsData.overrides = { allow: [], deny: [] };
                }
            }

            let html = '';

            $.each(currentPermissionsData.modules, function(module, permissions) {
                html += `
                    <h6 class="mt-3 text-primary fw-bold border-bottom pb-1">${module}</h6>
                    <div class="row">
                `;

                permissions.forEach(p => {
                    const isRolePermission = currentPermissionsData.role_permissions.includes(p.name);
                    const allowOverride = currentPermissionsData.overrides.allow.includes(p.name);
                    const denyOverride = currentPermissionsData.overrides.deny.includes(p.name);

                    let allowChecked = false;
                    let denyChecked = false;
                    let inherited = false;

                    if (allowOverride) {
                        allowChecked = true;
                    } else if (denyOverride) {
                        denyChecked = true;
                    } else if (isRolePermission) {
                        allowChecked = true;
                        inherited = true;
                    } else {
                        denyChecked = true;
                        inherited = false;
                    }

                    const isOverridden = allowOverride || denyOverride;

                    html += `
                        <div class="col-md-3 mb-2 border-secondary">
                            <div class="border ${denyChecked ? 'border-danger' : 'border-secondary'} rounded p-2 position-relative permission-box 
                                ${isOverridden ? 'bg-warning-subtle border-warning' : inherited ? 'bg-light' : 'bg-white'}">
                                
                                <strong class="d-block text-dark">${p.label}</strong>
                                <small class="text-muted">${p.name}</small>

                                <div class="mt-1">
                                    <label class="text-success me-3">
                                        <input type="checkbox" class="allow-check" name="allow_permissions[]" value="${p.name}" ${allowChecked ? 'checked' : ''}> Allow
                                    </label>
                                    <label class="text-danger me-3">
                                        <input type="checkbox" class="deny-check" name="deny_permissions[]" value="${p.name}" ${denyChecked ? 'checked' : ''}> Deny
                                    </label>
                                    <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" data-name="${p.name}" style="padding:1px 6px;font-size:12px;" title="Reset this permission">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </div>

                                ${isOverridden ? `<span class="badge bg-warning text-dark position-absolute top-0 end-0 m-1">Overridden</span>` : ''}
                                ${inherited && !isOverridden ? `<span class="badge bg-secondary text-white position-absolute bottom-0 end-0 m-1" style="font-size:10px;">Defult</span>` : ''}
                            </div>
                        </div>
                    `;
                });

                html += `</div>`;
            });

            $('#permissionsContainer').html(html);
            $('#userPermissionsForm').attr('action', '<?= base_url("User_v2/updateOverrides/") ?>' + userId);
            $('#userPermissionsModal').modal('show');

            // --- Toggle mutually exclusive checkboxes ---
            $('#permissionsContainer').on('change', '.allow-check', function() {
                const name = $(this).val();
                if ($(this).is(':checked')) $(`.deny-check[value="${name}"]`).prop('checked', false);
                updateHighlight(name);
            });

            $('#permissionsContainer').on('change', '.deny-check', function() {
                const name = $(this).val();
                if ($(this).is(':checked')) $(`.allow-check[value="${name}"]`).prop('checked', false);
                updateHighlight(name);
            });

            // --- Reset individual permission ---
            $('#permissionsContainer').on('click', '.reset-btn', function() {
                const name = $(this).data('name');
                const box = $(`.allow-check[value="${name}"]`).closest('.permission-box');
                const inRole = currentPermissionsData.role_permissions.includes(name);

                $(`.allow-check[value="${name}"], .deny-check[value="${name}"]`).prop('checked', false);
                if (inRole) $(`.allow-check[value="${name}"]`).prop('checked', true);
                else $(`.deny-check[value="${name}"]`).prop('checked', true);

                box.removeClass('bg-warning-subtle border-warning').addClass('bg-light');
                box.find('.badge.bg-warning').remove();
                if (inRole && !box.find('.badge.bg-secondary').length) {
                    box.append(`<span class="badge bg-secondary text-white position-absolute bottom-0 end-0 m-1" style="font-size:10px;">Defult</span>`);
                }
            });

            // --- Highlight overridden permissions ---
            function updateHighlight(name) {
                const box = $(`.allow-check[value="${name}"]`).closest('.permission-box');
                const allowOverride = $(`.allow-check[value="${name}"]`).is(':checked') && !currentPermissionsData.role_permissions.includes(name);
                const denyOverride = $(`.deny-check[value="${name}"]`).is(':checked') && currentPermissionsData.role_permissions.includes(name);

                box.removeClass('bg-light bg-white bg-warning-subtle border-warning');
                box.find('.badge').remove();

                if (allowOverride || denyOverride) {
                    box.addClass('bg-warning-subtle border-warning');
                    box.append(`<span class="badge bg-warning text-dark position-absolute top-0 end-0 m-1">Overridden</span>`);
                } else {
                    box.addClass('bg-light');
                    if (currentPermissionsData.role_permissions.includes(name)) {
                        box.append(`<span class="badge bg-secondary text-white position-absolute bottom-0 end-0 m-1" style="font-size:10px;">Defult</span>`);
                    }
                }
            }
        },
        error: function() {
            $('#permissionsContainer').html('<p class="text-danger">Error loading permissions.</p>');
        }
    });
}

// --- Submit only manual overrides ---
$('#userPermissionsForm').on('submit', function(e) {
    e.preventDefault();
    if (!currentPermissionsData) return alert('Permissions data not loaded');

    const allow = [];
    const deny = [];

    $('#permissionsContainer .permission-box').each(function() {
        const name = $(this).find('.allow-check, .deny-check').first().val();
        const isAllowChecked = $(this).find('.allow-check').is(':checked');
        const isDenyChecked = $(this).find('.deny-check').is(':checked');

        if (isAllowChecked && !currentPermissionsData.role_permissions.includes(name)) allow.push(name);
        if (isDenyChecked && !currentPermissionsData.role_permissions.includes(name)) deny.push(name);
    });

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: { allow, deny }, 
        success: function (res) {
            if (res.status && res.user_id) {
                success_toastify(res.message);
                openPermissionsModal(res.user_id);
            } else {
                error_toastify(res.message || 'Something went wrong.');
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
            error_toastify('Failed to update permissions.');
        }
    });
});
// --- Submit only overridden permissions ---
$('#userPermissionsForm').on('submit', function(e) {
    e.preventDefault();

    const allow = [];
    const deny = [];

    $('#permissionsContainer .permission-box').each(function() {
        const name = $(this).find('.allow-check, .deny-check').first().val();
        const isAllowChecked = $(this).find('.allow-check').is(':checked');
        const isDenyChecked = $(this).find('.deny-check').is(':checked');
        const isInRole = $(this).find('.allow-check').is(':checked') && $(this).find('.allow-check').val() === name;

        // Only include overrides (not inherited role permissions)
        if (isAllowChecked && !$(this).find('.allow-check').val() in data.role_permissions) allow.push(name);
        if (isDenyChecked && !$(this).find('.deny-check').val() in data.role_permissions) deny.push(name);
    });

    $.post($(this).attr('action'), { allow, deny }, function(res) {
        alert(res.message);
        if (res.status) {
            // Optionally reload modal to reflect updated overrides
            openPermissionsModal(res.data.user_id || <?= $user_id ?? 0 ?>);
        }
        $('#userPermissionsModal').modal('hide');
    });
});



// $('#userPermissionsForm').on('submit', function(e){
//     e.preventDefault();
//     const formData = $(this).serialize();
//     $.post($(this).attr('action'), formData, function(res){
//         alert(res.message);
//         $('#userPermissionsModal').modal('hide');
//     });
// });

$('#resetPermissionsBtn').on('click', function(){
    const userId = $('#userPermissionsForm').attr('action').split('/').pop();
    if (confirm('Reset user permissions to role defaults?')) {
        $.get('<?= base_url("User_v2/resetOverrides/") ?>' + userId, function(res){
            alert(res.message);
            $('#userPermissionsModal').modal('hide');
        });
    }
});


</script>

<?php include __DIR__ . "/../include/footer.php"; ?>
