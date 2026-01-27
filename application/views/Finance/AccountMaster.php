<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include APPPATH . "views/include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa fa-book" aria-hidden="true"></i></div>
                            <span>Account Master</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="mb-0">Account Master</h5>
                        <button type="button" id="addAccountBtn" class="btn btn-primary btn-sm <?php if($addcheck==0){echo 'd-none';} ?>"
                            onclick="showAddAccountModal();">
                            <i class="fas fa-plus mr-2"></i>Add Account
                        </button>
                    </div>
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered table-striped table-sm nowrap w-100" id="accountMasterTable">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Account Code</th>
                                            <th>Account Name</th>
                                            <th>Account Type</th>
                                            <th>Parent Account</th>
                                            <th>Bank Account No</th>
                                            <th>Description</th>
                                            <th>Status</th>
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

        <!-- Account Master Modal -->
        <div class="modal fade" id="accountMasterModal" tabindex="-1" role="dialog" aria-labelledby="accountMasterModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="accountMasterForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="accountMasterModalLabel">Add Account Master</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="account_id" name="id">
                            <div class="form-group" id="code_display_group" style="display: none;">
                                <label for="display_code">Generated Code</label>
                                <input type="text" class="form-control" id="display_code" readonly style="background-color: #e9ecef;">
                                <small class="form-text text-muted">Auto-generated code</small>
                            </div>
                            <div class="form-group">
                                <label for="account_code">Account Code</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="account_code" name="account_code" readonly style="background-color: #e9ecef;">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="btnGenerateCode" title="Generate Code from Account Type">
                                            <i class="fas fa-sync-alt"></i> Generate
                                        </button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Auto-generated from Account Type prefix. Select Account Type and click Generate, or enter manually.</small>
                            </div>
                            <div class="form-group">
                                <label for="account_name">Account Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="account_name" name="account_name" required>
                            </div>
                            <div class="form-group">
                                <label for="account_type_id">Account Type <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-control" id="account_type_id" name="account_type_id" required>
                                        <option value="">Select Type</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-danger" type="button" id="btnAddAccountType" title="Add New Account Type">
                                            <i class="fas fa-plus"></i> add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="parent_account_id">Parent Account</label>
                                <select class="form-control" id="parent_account_id" name="parent_account_id">
                                    <option value="">None (Root Account)</option>
                                </select>
                            </div>
                            <div class="form-group" id="bank_account_no_group" style="display: none;">
                                <label for="bank_account_no">Bank Account Number</label>
                                <input type="text" class="form-control" id="bank_account_no" name="bank_account_no" placeholder="Enter bank account number">
                                <small class="form-text text-muted">Required when Account Type is Bank</small>
                            </div>
                            <div class="form-group">
                                <label for="account_description">Description</label>
                                <textarea class="form-control" id="account_description" name="description" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="account_is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="account_is_active">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Account Type Modal -->
        <div class="modal fade" id="accountTypeModal" tabindex="-1" role="dialog" aria-labelledby="accountTypeModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="accountTypeForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="accountTypeModalLabel">Add Account Type</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="account_type_modal_id" name="id">
                            <div class="form-group">
                                <label for="type_code">Type Code</label>
                                <input type="text" class="form-control" id="type_code" name="type_code" placeholder="(Auto-generated: ACT001, ACT002...)" readonly style="background-color: #e9ecef;">
                                <small class="form-text text-muted">Auto-generated with ACT prefix and global sequence (e.g., ACT001, ACT002). All account types share this sequence.</small>
                            </div>
                            <div class="form-group">
                                <label for="type_name">Type Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="type_name" name="type_name" placeholder="e.g., Asset, Liability" required>
                            </div>
                            <div class="form-group">
                                <label for="type_prefix">Prefix <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="type_prefix" name="prefix" placeholder="e.g., CASH, BANK, EXP" maxlength="20" required>
                                <small class="form-text text-muted">Prefix used for auto-generating Account Master codes (e.g., EXP001, CASH001). Required field.</small>
                            </div>
                            <div class="form-group">
                                <label for="type_description">Description</label>
                                <textarea class="form-control" id="type_description" name="description" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="account_type_is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="account_type_is_active">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>
<?php include APPPATH . "views/include/footerscripts.php"; ?>
<script>
var addcheck = '<?php echo $addcheck; ?>';
var editcheck = '<?php echo $editcheck; ?>';
var statuscheck = '<?php echo $statuscheck; ?>';
var deletecheck = '<?php echo $deletecheck; ?>';

// Function to toggle bank account number field based on account type
function toggleBankAccountNoField() {
    let selectedOption = $('#account_type_id option:selected');
    let typeName = selectedOption.data('type-name') || selectedOption.text();
    
    // Check if the account type name contains "Bank" (case insensitive)
    if (typeName && typeName.toLowerCase().includes('bank')) {
        $('#bank_account_no_group').show();
        $('#bank_account_no').prop('required', true);
    } else {
        $('#bank_account_no_group').hide();
        $('#bank_account_no').prop('required', false);
        $('#bank_account_no').val(''); // Clear value when hidden
    }
}

$(document).ready(function() {
    // Initialize DataTable after DOM is ready
    setTimeout(function() {
        initializeAccountMasterTable();
    }, 100);
    
    loadAccountTypes();
    
    // Toggle bank account no field when account type changes
    $(document).on('change', '#account_type_id', function() {
        toggleBankAccountNoField();
    });
});

function loadAccountTypes() {
    $.ajax({
        url: apiBaseUrl + '/v1/finance/account_type',
        type: 'GET',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + api_token
        },
        data: { is_active: 1 }, // Only load active types
        success: function(response) {
            if (response.status && response.data) {
                let options = '<option value="">Select Type</option>';
                response.data.forEach(function(type) {
                    options += '<option value="' + type.id + '" data-type-name="' + type.type_name + '">' + type.type_name + '</option>';
                });
                $('#account_type_id').html(options);
                
                // Trigger change to check if bank account field should be shown (for edit mode)
                $('#account_type_id').trigger('change');
            }
        },
        error: function(xhr) {
            console.error('Error loading account types:', xhr);
        }
    });
}

function initializeAccountMasterTable() {
    // Check if DataTable is already initialized and destroy it
    if ($.fn.DataTable.isDataTable('#accountMasterTable')) {
        $('#accountMasterTable').DataTable().clear().destroy();
    }

    // Verify table element exists
    if ($('#accountMasterTable').length === 0) {
        console.error('Account Master table element not found');
        return;
    }

    $('#accountMasterTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: apiBaseUrl + '/v1/finance/account_master',
            type: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + api_token
            },
            dataSrc: function(json) {
                console.log('Account Master API Response:', json);
                if (json.status === false) {
                    if (json.code === 401) {
                        falseResponse(errorObj);
                    } else {
                        console.error('API Error:', json.message || 'Unknown error');
                        error_toastify(json.message || 'Failed to load account masters');
                    }
                    return [];
                }
                if (!json.data) {
                    console.warn('No data in response');
                    return [];
                }
                return json.data;
            },
            error: function(xhr, error, thrown) {
                console.error('DataTable AJAX Error:', {
                    xhr: xhr,
                    error: error,
                    thrown: thrown,
                    responseText: xhr.responseText
                });
                error_toastify('Failed to load account masters: ' + (xhr.responseJSON?.message || error || 'Unknown error'));
            }
        },
        columns: [
            { data: 'code', title: 'Code', defaultContent: '-' },
            { data: 'account_code', title: 'Account Code' },
            { data: 'account_name', title: 'Account Name' },
            { 
                data: 'account_type_name', 
                title: 'Account Type',
                defaultContent: '-'
            },
            { 
                data: 'parent_account_id', 
                title: 'Parent Account',
                defaultContent: '-'
            },
            { 
                data: 'bank_account_no', 
                title: 'Bank Account No',
                defaultContent: '-'
            },
            { 
                data: 'description', 
                title: 'Description',
                defaultContent: '-'
            },
            { 
                data: 'is_active', 
                title: 'Status',
                render: function(data) {
                    return data ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>';
                }
            },
            {
                data: null,
                title: 'Actions',
                orderable: false,
                render: function(data, type, row) {
                    let buttons = '';
                    if (editcheck == 1) {
                        buttons += '<button class="btn btn-sm btn-info mr-1" onclick="editAccount(' + row.id + ')" title="Edit"><i class="fas fa-edit"></i></button>';
                    }
                    if (deletecheck == 1) {
                        buttons += '<button class="btn btn-sm btn-danger" onclick="deleteAccount(' + row.id + ')" title="Delete"><i class="fas fa-trash"></i></button>';
                    }
                    return buttons;
                }
            }
        ]
    });

    loadParentAccounts();
}

function loadParentAccounts() {
    $.ajax({
        url: apiBaseUrl + '/v1/finance/account_master',
        type: 'GET',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + api_token
        },
        success: function(response) {
            if (response.status && response.data) {
                let options = '<option value="">None (Root Account)</option>';
                response.data.forEach(function(account) {
                    options += '<option value="' + account.id + '">' + account.account_code + ' - ' + account.account_name + '</option>';
                });
                $('#parent_account_id').html(options);
            }
        }
    });
}

function showAddAccountModal() {
    $('#accountMasterForm')[0].reset();
    $('#account_id').val('');
    $('#code_display_group').hide(); // Hide code display for new records
    $('#display_code').val('');
    $('#bank_account_no_group').hide(); // Hide bank account no field initially
    $('#accountMasterModalLabel').text('Add Account Master');
    loadAccountTypes();
    loadParentAccounts();
    $('#accountMasterModal').modal('show');
}

function editAccount(id) {
    $.ajax({
        url: apiBaseUrl + '/v1/finance/account_master/' + id,
        type: 'GET',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + api_token
        },
        success: function(response) {
            if (response.status && response.data) {
                let data = response.data;
                $('#account_id').val(data.id);
                $('#account_code').val(data.account_code);
                // Make account_code editable in edit mode
                $('#account_code').removeAttr('readonly').css('background-color', '').removeClass('readonly');
                $('#account_name').val(data.account_name);
                $('#account_type_id').val(data.account_type_id);
                $('#parent_account_id').val(data.parent_account_id);
                $('#bank_account_no').val(data.bank_account_no || '');
                $('#account_description').val(data.description);
                $('#account_is_active').prop('checked', data.is_active == 1);
                
                // Show and populate generated code field for edit mode
                if (data.code) {
                    $('#code_display_group').show();
                    $('#display_code').val(data.code);
                } else {
                    $('#code_display_group').hide();
                }
                
                // Toggle bank account no field based on selected account type
                setTimeout(function() {
                    toggleBankAccountNoField();
                }, 100);
                
                $('#accountMasterModalLabel').text('Edit Account Master');
                loadAccountTypes();
                loadParentAccounts();
                $('#accountMasterModal').modal('show');
            }
        }
    });
}

function deleteAccount(id) {
    if (confirm('Are you sure you want to delete this account?')) {
        $.ajax({
            url: apiBaseUrl + '/v1/finance/account_master/' + id,
            type: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + api_token
            },
            success: function(response) {
                if (response.status) {
                    success_toastify(response.message || 'Account deleted successfully');
                    $('#accountMasterTable').DataTable().ajax.reload();
                } else {
                    error_toastify(response.message || 'Failed to delete account');
                }
            }
        });
    }
}

// Account Type Modal Functions
$('#btnAddAccountType').on('click', function() {
    $('#accountTypeForm')[0].reset();
    $('#account_type_modal_id').val('');
    $('#type_code').val('(Auto-generated: ACT001, ACT002...)').prop('readonly', true).css('background-color', '#e9ecef');
    $('#accountTypeModalLabel').text('Add Account Type');
    $('#accountTypeModal').modal('show');
});

// Edit Account Type function (call this from table or elsewhere)
function editAccountType(id) {
    $.ajax({
        url: apiBaseUrl + '/v1/finance/account_type/' + id,
        type: 'GET',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + api_token
        },
        success: function(response) {
            if (response.status && response.data) {
                let data = response.data;
                $('#account_type_modal_id').val(data.id);
                $('#type_code').val(data.type_code);
                // Make type_code editable in edit mode
                $('#type_code').removeAttr('readonly').css('background-color', '').removeClass('readonly');
                $('#type_name').val(data.type_name);
                $('#type_prefix').val(data.prefix);
                $('#type_description').val(data.description);
                $('#account_type_is_active').prop('checked', data.is_active == 1);
                $('#accountTypeModalLabel').text('Edit Account Type');
                $('#accountTypeModal').modal('show');
            }
        },
        error: function(xhr) {
            error_toastify('Error loading account type: ' + (xhr.responseJSON?.message || 'Unknown error'));
        }
    });
}

$('#accountTypeForm').on('submit', function(e) {
    e.preventDefault();
    
    // If type_code is placeholder, send empty to let backend generate
    let typeCode = $('#type_code').val();
    if (typeCode === '(Auto-generated: ACT001, ACT002...)' || typeCode === '(Auto-generated on save)') {
        typeCode = '';
    }
    
    let formData = {
        type_code: typeCode || null, // Send null to let backend generate (only for new records)
        type_name: $('#type_name').val(),
        prefix: $('#type_prefix').val(),
        description: $('#type_description').val(),
        is_active: $('#account_type_is_active').is(':checked') ? 1 : 0
    };

    let id = $('#account_type_modal_id').val();
    let url = apiBaseUrl + '/v1/finance/account_type';
    let method = 'POST';

    if (id) {
        url += '/' + id;
        method = 'PUT';
    }

    $.ajax({
        url: url,
        type: method,
        data: formData,
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + api_token
        },
        success: function(response) {
            if (response.status) {
                success_toastify(response.message || 'Account type saved successfully');
                // Update type_code field with generated value
                if (response.data && response.data.type_code) {
                    $('#type_code').val(response.data.type_code);
                }
                $('#accountTypeModal').modal('hide');
                loadAccountTypes(); // Reload the dropdown
            } else {
                error_toastify(response.message || 'Failed to save account type');
            }
        },
        error: function(xhr) {
            let errorMsg = 'Failed to save account type';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                errorMsg = Object.values(errors).flat().join(', ');
            }
            error_toastify(errorMsg);
        }
    });
});

$('#accountMasterForm').on('submit', function(e) {
    e.preventDefault();
    
    let id = $('#account_id').val();
    let accountCode = $('#account_code').val();
    
    // If creating new and account_code is placeholder, let backend generate
    if (!id) {
        if (accountCode === '(Auto-generated on save)' || accountCode === '') {
            accountCode = null; // Send null to let backend generate
        }
    } else {
        // For edit mode, account_code is required - use the value from field
        if (!accountCode) {
            accountCode = $('#account_code').val();
        }
    }
    
    let formData = {
        account_code: accountCode,
        account_name: $('#account_name').val(),
        account_type_id: $('#account_type_id').val(),
        parent_account_id: $('#parent_account_id').val() || null,
        bank_account_no: $('#bank_account_no').val() || null,
        description: $('#account_description').val(),
        is_active: $('#account_is_active').is(':checked') ? 1 : 0
    };

    let url = apiBaseUrl + '/v1/finance/account_master';
    let method = 'POST';

    if (id) {
        url += '/' + id;
        method = 'PUT';
    }

    $.ajax({
        url: url,
        type: method,
        data: formData,
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + api_token
        },
        success: function(response) {
            if (response.status) {
                success_toastify(response.message || 'Account saved successfully');
                
                // Update account_code field with generated value
                if (response.data && response.data.account_code) {
                    $('#account_code').val(response.data.account_code);
                }
                
                // If this was a create operation and we got the code back, show it briefly
                if (response.data && response.data.code && !id) {
                    $('#code_display_group').show();
                    $('#display_code').val(response.data.code);
                    setTimeout(function() {
                        $('#accountMasterModal').modal('hide');
                        $('#accountMasterTable').DataTable().ajax.reload();
                    }, 1500); // Show for 1.5 seconds then close
                } else {
                    $('#accountMasterModal').modal('hide');
                    $('#accountMasterTable').DataTable().ajax.reload();
                }
            } else {
                error_toastify(response.message || 'Failed to save account');
            }
        },
        error: function(xhr) {
            let errorMsg = 'Failed to save account';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                errorMsg = Object.values(errors).flat().join(', ');
            }
            error_toastify(errorMsg);
        }
    });
});
</script>
<?php include APPPATH . "views/include/footer.php"; ?>

