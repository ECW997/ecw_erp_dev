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
                            <div class="page-header-icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
                            <span>Finance Approvals</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="mb-0">Finance Approvals</h5>
                        <button type="button" id="addApprovalBtn" class="btn btn-primary btn-sm <?php if($addcheck==0){echo 'd-none';} ?>"
                            onclick="showAddApprovalModal();">
                            <i class="fas fa-plus mr-2"></i>New Approval Request
                        </button>
                    </div>
                    <div class="card-body p-0 p-2">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#" data-filter="all">All</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-filter="pending">Pending</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-filter="approved">Approved</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-filter="rejected">Rejected</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered table-striped table-sm nowrap w-100" id="approvalTable">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Reference</th>
                                            <th>Amount</th>
                                            <th>Requester</th>
                                            <th>Approver</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                            <th>Requested At</th>
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

        <!-- Approval Modal -->
        <div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="approvalForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="approvalModalLabel">New Approval Request</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="approval_type">Approval Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="approval_type" name="approval_type" required>
                                    <option value="">Select Type</option>
                                    <option value="cash_movement">Cash Movement</option>
                                    <option value="expense">Expense</option>
                                    <option value="payment">Payment</option>
                                    <option value="adjustment">Adjustment</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reference_type">Reference Type <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="reference_type" name="reference_type" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reference_id">Reference ID <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="reference_id" name="reference_id" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="approval_amount">Amount <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="approval_amount" name="amount" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="approval_priority">Priority</label>
                                        <select class="form-control" id="approval_priority" name="priority">
                                            <option value="low">Low</option>
                                            <option value="medium" selected>Medium</option>
                                            <option value="high">High</option>
                                            <option value="urgent">Urgent</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="approver_id">Approver <span class="text-danger">*</span></label>
                                <select class="form-control" id="approver_id" name="approver_id" required>
                                    <option value="">Select Approver</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="approval_description">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="approval_description" name="description" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Approval Action Modal -->
        <div class="modal fade" id="approvalActionModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="approvalActionForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="approvalActionModalLabel">Approval Action</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="approval_action_id">
                            <div class="form-group">
                                <label id="approvalActionRemarksLabel">Remarks</label>
                                <textarea class="form-control" id="approval_action_remarks" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-success" id="btnApproveAction">Approve</button>
                            <button type="button" class="btn btn-danger" id="btnRejectAction">Reject</button>
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
var approvalFilter = 'all';

$(document).ready(function() {
    initializeApprovalTable();
});

function initializeApprovalTable() {
    if ($.fn.DataTable.isDataTable('#approvalTable')) {
        $('#approvalTable').DataTable().destroy();
    }

    $('#approvalTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: apiBaseUrl + '/v1/finance/approval',
            type: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + api_token
            },
            data: function(d) {
                if (approvalFilter !== 'all') {
                    d.status = approvalFilter;
                }
            },
            dataSrc: function(json) {
                if (json.status === false && json.code === 401) {
                    falseResponse(errorObj);
                    return [];
                }
                return json.data || [];
            }
        },
        columns: [
            { 
                data: 'approval_type', 
                title: 'Type',
                render: function(data) {
                    return data ? data.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) : '';
                }
            },
            { 
                data: null,
                title: 'Reference',
                render: function(data) {
                    return (data.reference_type || '') + ' #' + (data.reference_id || '');
                }
            },
            { 
                data: 'amount', 
                title: 'Amount',
                render: function(data) {
                    return data ? parseFloat(data).toLocaleString('en-US', {minimumFractionDigits: 2}) : '0.00';
                }
            },
            { data: 'requester_name', title: 'Requester' },
            { data: 'approver_name', title: 'Approver' },
            { 
                data: 'priority', 
                title: 'Priority',
                render: function(data) {
                    let badgeClass = 'badge-secondary';
                    if (data === 'urgent') badgeClass = 'badge-danger';
                    else if (data === 'high') badgeClass = 'badge-warning';
                    else if (data === 'medium') badgeClass = 'badge-info';
                    return '<span class="badge ' + badgeClass + '">' + (data ? data.charAt(0).toUpperCase() + data.slice(1) : '') + '</span>';
                }
            },
            { 
                data: 'status', 
                title: 'Status',
                render: function(data) {
                    let badgeClass = 'badge-secondary';
                    if (data === 'approved') badgeClass = 'badge-success';
                    else if (data === 'rejected') badgeClass = 'badge-danger';
                    else if (data === 'pending') badgeClass = 'badge-warning';
                    return '<span class="badge ' + badgeClass + '">' + (data ? data.charAt(0).toUpperCase() + data.slice(1) : '') + '</span>';
                }
            },
            { 
                data: 'requested_at', 
                title: 'Requested At',
                render: function(data) {
                    return data ? new Date(data).toLocaleString() : '-';
                }
            },
            {
                data: null,
                title: 'Actions',
                orderable: false,
                render: function(data, type, row) {
                    let buttons = '';
                    if (row.status === 'pending') {
                        buttons += '<button class="btn btn-sm btn-success mr-1" onclick="showApprovalAction(' + row.id + ', \'approve\')" title="Approve"><i class="fas fa-check"></i></button>';
                        buttons += '<button class="btn btn-sm btn-danger" onclick="showApprovalAction(' + row.id + ', \'reject\')" title="Reject"><i class="fas fa-times"></i></button>';
                    }
                    return buttons;
                }
            }
        ]
    });

    $('.nav-pills a[data-filter]').on('click', function(e) {
        e.preventDefault();
        $('.nav-pills a').removeClass('active');
        $(this).addClass('active');
        approvalFilter = $(this).data('filter');
        $('#approvalTable').DataTable().ajax.reload();
    });
}

function showAddApprovalModal() {
    $('#approvalForm')[0].reset();
    $('#approvalModalLabel').text('New Approval Request');
    loadApprovers();
    $('#approvalModal').modal('show');
}

function loadApprovers() {
    $.ajax({
        url: apiBaseUrl + '/v1/users',
        type: 'GET',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + api_token
        },
        success: function(response) {
            if (response.status && response.data) {
                let options = '<option value="">Select Approver</option>';
                response.data.forEach(function(user) {
                    options += '<option value="' + user.id + '">' + user.name + '</option>';
                });
                $('#approver_id').html(options);
            }
        }
    });
}

function showApprovalAction(id, action) {
    $('#approval_action_id').val(id);
    $('#approval_action_remarks').val('');
    if (action === 'approve') {
        $('#approvalActionModalLabel').text('Approve Request');
        $('#approvalActionRemarksLabel').text('Approval Remarks (Optional)');
        $('#btnApproveAction').show();
        $('#btnRejectAction').hide();
    } else {
        $('#approvalActionModalLabel').text('Reject Request');
        $('#approvalActionRemarksLabel').text('Rejection Remarks *');
        $('#btnApproveAction').hide();
        $('#btnRejectAction').show();
    }
    $('#approvalActionModal').modal('show');
}

$('#btnApproveAction').on('click', function() {
    let id = $('#approval_action_id').val();
    let remarks = $('#approval_action_remarks').val();
    
    $.ajax({
        url: apiBaseUrl + '/v1/finance/approval/' + id + '/approve',
        type: 'POST',
        data: { approval_remarks: remarks },
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + api_token
        },
        success: function(response) {
            if (response.status) {
                success_toastify(response.message || 'Request approved successfully');
                $('#approvalActionModal').modal('hide');
                $('#approvalTable').DataTable().ajax.reload();
            } else {
                error_toastify(response.message || 'Failed to approve request');
            }
        }
    });
});

$('#btnRejectAction').on('click', function() {
    let id = $('#approval_action_id').val();
    let remarks = $('#approval_action_remarks').val();
    
    if (!remarks) {
        error_toastify('Rejection remarks are required');
        return;
    }
    
    $.ajax({
        url: apiBaseUrl + '/v1/finance/approval/' + id + '/reject',
        type: 'POST',
        data: { rejection_remarks: remarks },
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + api_token
        },
        success: function(response) {
            if (response.status) {
                success_toastify(response.message || 'Request rejected successfully');
                $('#approvalActionModal').modal('hide');
                $('#approvalTable').DataTable().ajax.reload();
            } else {
                error_toastify(response.message || 'Failed to reject request');
            }
        }
    });
});

$('#approvalForm').on('submit', function(e) {
    e.preventDefault();
    let formData = {
        approval_type: $('#approval_type').val(),
        reference_type: $('#reference_type').val(),
        reference_id: $('#reference_id').val(),
        amount: $('#approval_amount').val(),
        approver_id: $('#approver_id').val(),
        priority: $('#approval_priority').val(),
        description: $('#approval_description').val()
    };

    $.ajax({
        url: apiBaseUrl + '/v1/finance/approval',
        type: 'POST',
        data: formData,
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + api_token
        },
        success: function(response) {
            if (response.status) {
                success_toastify(response.message || 'Approval request submitted successfully');
                $('#approvalModal').modal('hide');
                $('#approvalTable').DataTable().ajax.reload();
            } else {
                error_toastify(response.message || 'Failed to submit approval request');
            }
        }
    });
});
</script>
<?php include APPPATH . "views/include/footer.php"; ?>

