<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<style>
.card-header {
    background-color: white;
    border-bottom: 1px solid #6c757d;
    padding: 1rem 2rem;
}

label {
    color: #6c757d;
    font-weight: 700;
    font-size: 0.85rem;
    white-space: nowrap;
    margin-bottom: 0;
    line-height: 1.5;
}

.form-control-sm,
.custom-select-sm {
    font-size: 0.85rem;
    padding: 0.25rem 0.5rem;
    height: 1.9rem;
}

#filterBtn {
    min-width: 100px;
    height: 1.9rem;
    font-size: 0.85rem;
    padding: 0 0.75rem;
}

.input-group-text {
    background-color: #e9ecef;
    border-right: 0;
    font-weight: 700;
    color: #6c757d;
    white-space: nowrap;
    height: 1.9rem;
    padding: 0 0.5rem;
    line-height: 1.9rem;
}

.badge-gate-pass {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}

.badge-in { background-color: #28a745; color: #000;}
.badge-out { background-color: #dc3545; color: #000;}
.badge-temp-in { background-color: #17a2b8; color: #000;}
.badge-temp-out { background-color: #ffc107; color: #000; }
.badge-main { background-color: #007bff; color: #000;}
.badge-internal { background-color: #6f42c1; color: #000;}
.badge-external { background-color: #fd7e14; color: #000;}
</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include APPPATH . "views/include/menubar.php"; ?>
    </div>
    <?php
    // Gate Pass permissions (Menu ID: 42) are set in menubar.php when on GatePass; ensure they exist to avoid undefined vars/function.
    if (!isset($addcheck)) $addcheck = 0;
    if (!isset($editcheck)) $editcheck = 0;
    if (!isset($statuscheck)) $statuscheck = 0;
    if (!isset($deletecheck)) $deletecheck = 0;
    if (!isset($printcheck)) $printcheck = 0;
    if (!isset($approvecheck)) $approvecheck = 0;
    if (!isset($re_print_approvecheck)) $re_print_approvecheck = 0;
    if (!isset($approve4check)) $approve4check = 0;
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3 d-flex justify-content-between align-items-center">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-id-card"></i></div>
                            <span>Gate Pass List</span>
                        </h1>
                        <div>
                            <?php if ($approve4check == 1) : ?>
                            <a href="<?= base_url('GatePass/vehicleTracking') ?>" class="btn btn-info btn-sm px-4 p-2 ml-2">
                                <i class="fas fa-car mr-2"></i>Vehicle Tracking
                            </a>
                            <?php endif; ?>
                            <?php if ($addcheck == 1) : ?>
                            <a href="<?= base_url('GatePass/generateForm') ?>" class="btn btn-primary btn-sm px-4 p-2">
                                <i class="fas fa-plus mr-2"></i>Generate Gate Pass
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="p-2">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3 d-flex align-items-center justify-content-start">
                                <label for="date_from" class="mb-0 mr-2">Date Filter</label>
                                <div class="input-group">
                                    <input type="date" id="date_from" class="form-control form-control-sm" aria-label="Date From" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">to</span>
                                    </div>
                                    <input type="date" id="date_to" class="form-control form-control-sm" aria-label="Date To" />
                                </div>
                            </div>

                            <div class="col-12 col-md-9 d-flex align-items-center justify-content-end flex-wrap">
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="gate_pass_type" class="mb-0 mr-2">Type</label>
                                    <select id="gate_pass_type" class="custom-select custom-select-sm" style="min-width: 130px;">
                                        <option value="">All Types</option>
                                        <option value="IN">IN</option>
                                        <option value="OUT">OUT</option>
                                        <option value="TEMP_IN">Temp IN</option>
                                        <option value="TEMP_OUT">Temp OUT</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="pass_category" class="mb-0 mr-2">Category</label>
                                    <select id="pass_category" class="custom-select custom-select-sm" style="min-width: 130px;">
                                        <option value="">All Categories</option>
                                        <option value="MAIN">Main</option>
                                        <option value="INTERNAL">Internal</option>
                                        <option value="EXTERNAL">External</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="status" class="mb-0 mr-2">Status</label>
                                    <select id="status" class="custom-select custom-select-sm" style="min-width: 130px;">
                                        <option value="">All Status</option>
                                        <option value="ACTIVE">Active</option>
                                        <option value="COMPLETED">Completed</option>
                                        <option value="CANCELLED">Cancelled</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="job_card_id" class="mb-0 mr-2">Job Card</label>
                                    <input type="text" id="job_card_id" class="form-control form-control-sm" placeholder="Job Card ID" style="min-width: 120px;" />
                                </div>
                                <button class="btn btn-secondary btn-sm" id="filterBtn" style="height: 1.9rem; font-size: 0.85rem;">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                                <button class="btn btn-outline-secondary btn-sm ml-2" id="clearFilterBtn">Clear</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Gate Pass No</th>
                                                <th>Type</th>
                                                <th>Category</th>
                                                <th>Job Card No</th>
                                                <th>Vehicle No</th>
                                                <th>Chassis No</th>
                                                <th>Customer</th>
                                                <th>Gate Location</th>
                                                <th>Status</th>
                                                <th>Created By</th>
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
            <?php if (isset($re_print_approvecheck) && $re_print_approvecheck == 1) : ?>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-header py-2 d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-clock mr-1"></i> Pending Reprint Approve Requests</span>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="refreshReprintRequests"><i class="fas fa-sync-alt"></i> Refresh</button>
                    </div>
                    <div class="card-body p-2">
                        <div id="reprintRequestsList">Loading...</div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>

        <!-- Request Reprint Approve Modal (cashier/other user) -->
        <div class="modal fade" id="requestReprintApproveModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Request Reprint Approve</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small">Gate Pass: <strong id="requestModalGatePassNumber"></strong></p>
                        <label for="reprintRequestReason">Reason <span class="text-danger">*</span></label>
                        <textarea id="reprintRequestReason" class="form-control" rows="3" maxlength="1000" placeholder="e.g. Lost copy, customer request..."></textarea>
                        <small class="text-muted">Finance manager will review and approve. After approval you can reprint.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="submitReprintRequestBtn">Submit Request</button>
                    </div>
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
var deletecheck = '<?php echo $deletecheck; ?>';
var printcheck = '<?php echo $printcheck; ?>';
var approvecheck = '<?php echo $approvecheck; ?>';
var re_print_approvecheck = '<?php echo $re_print_approvecheck; ?>';
var base_url = '<?= base_url() ?>';

$(document).ready(function() {
    // Check if table exists before initializing
    if ($('#dataTable').length === 0) {
        console.error('DataTable element not found');
        return;
    }
    
    // Initialize DataTable with error handling
    var table;
    try {
        table = $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": base_url + "GatePass/getGatePasses",
            "type": "GET",
            "data": function(d) {
                // Add filter parameters to DataTables request
                d.date_from = $('#date_from').val();
                d.date_to = $('#date_to').val();
                d.gate_pass_type = $('#gate_pass_type').val();
                d.pass_category = $('#pass_category').val();
                d.status = $('#status').val();
                d.job_card_id = $('#job_card_id').val();
            },
            "error": function(xhr, error, thrown) {
                console.error("Error loading gate passes:", error, xhr.responseText);
                showAlert("Error loading gate passes. Please try again.", "danger");
            }
        },
        "columns": [
            { "data": null, "orderable": true, "defaultContent": "" },
            { 
                "data": "created_at",
                "render": function(data) {
                    return data ? new Date(data).toLocaleDateString() : '-';
                }
            },
            { "data": "gate_pass_number" },
            { 
                "data": "gate_pass_type",
                "render": function(data) {
                    var badgeClass = 'badge-secondary';
                    if (data === 'IN') badgeClass = 'badge-in';
                    else if (data === 'OUT') badgeClass = 'badge-out';
                    else if (data === 'TEMP_IN') badgeClass = 'badge-temp-in';
                    else if (data === 'TEMP_OUT') badgeClass = 'badge-temp-out';
                    return '<span class="badge badge-gate-pass ' + badgeClass + '">' + data + '</span>';
                }
            },
            { 
                "data": "pass_category",
                "render": function(data) {
                    var badgeClass = 'badge-secondary';
                    if (data === 'MAIN') badgeClass = 'badge-main';
                    else if (data === 'INTERNAL') badgeClass = 'badge-internal';
                    else if (data === 'EXTERNAL') badgeClass = 'badge-external';
                    return '<span class="badge badge-gate-pass ' + badgeClass + '">' + data + '</span>';
                }
            },
            { 
                "data": "job_card",
                "render": function(data) {
                    return data ? (data.job_card_number2 || data.job_card_number || '-') : '-';
                }
            },
            { 
                "data": "job_card",
                "render": function(data) {
                    return data ? (data.vehicle_number || '-') : '-';
                }
            },
            { 
                "data": "job_card",
                "render": function(data) {
                    return data ? (data.chassis_number || '-') : '-';
                }
            },
            { 
                "data": "customer",
                "defaultContent": "-",
                "render": function(data, type, row) {
                    // Try customer directly, then job_card.customer as fallback
                    if (data && typeof data === 'object' && data.customer_name) {
                        return data.customer_name;
                    }
                    if (row && row.job_card && row.job_card.customer && row.job_card.customer.customer_name) {
                        return row.job_card.customer.customer_name;
                    }
                    return '-';
                }
            },
            { 
                "data": "location",
                "render": function(data) {
                    return data ? data.location_name : '-';
                }
            },
            { 
                "data": "status",
                "render": function(data) {
                    var badgeClass = 'badge-secondary';
                    if (data === 'APPROVED') badgeClass = 'badge-success';
                    else if (data === 'DRAFT') badgeClass = 'badge-warning';
                    else if (data === 'ACTIVE') badgeClass = 'badge-success'; // Backward compatibility
                    else if (data === 'COMPLETED') badgeClass = 'badge-info';
                    else if (data === 'CANCELLED') badgeClass = 'badge-danger';
                    return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                }
            },
            { 
                "data": "creator",
                "render": function(data) {
                    return data ? data.name : '-';
                }
            },
            {
                "data": null,
                "className": "text-right",
                "orderable": false,
                "defaultContent": "",
                "render": function(data, type, row) {
                    if (!row || !row.id) {
                        return '';
                    }
                    var actions = '<div class="btn-group btn-group-sm">';
                    actions += '<a href="' + base_url + 'GatePass/view/' + row.id + '" class="btn btn-info btn-sm" title="View"><i class="fas fa-eye"></i></a>';
                    // Approve button for DRAFT gate passes (using printcheck permission for approval)
                    if (row.status === 'DRAFT' && approvecheck == 1) {
                        actions += '<button class="btn btn-success btn-sm approve-gate-pass" data-id="' + row.id + '" data-number="' + (row.gate_pass_number || '') + '" title="Approve"><i class="fas fa-check"></i></button>';
                    }
                    // Request Reprint Approve: only when doc_access active, no pending request, no approved unconsumed request. Hide when request sent (pending) or when approved/rejected.
                    var docAccessActive = row.latest_doc_access_active === true || row.latest_doc_access_active === 1;
                    var hasPending = row.has_pending_reprint_request === true || row.has_pending_reprint_request === 1;
                    var hasApproved = row.has_approved_reprint_request === true || row.has_approved_reprint_request === 1;
                    if (re_print_approvecheck == 0 && (row.status === 'APPROVED' || row.status === 'ACTIVE') && printcheck == 1 && docAccessActive && !hasPending && !hasApproved) {
                        actions += '<button class="btn btn-secondary btn-sm request-reprint-approve" data-id="' + row.id + '" data-number="' + (row.gate_pass_number || '') + '" title="Request Reprint Approve"><i class="fas fa-paper-plane"></i></button>';
                    }
                    
                    actions += '</div>';
                    return actions;
                }
            }
        ],
        "order": [[1, "desc"]],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
        "language": {
            "processing": "Loading gate passes...",
            "emptyTable": "No gate passes found",
            "zeroRecords": "No matching gate passes found"
        }
    });
    } catch (error) {
        console.error('Error initializing DataTable:', error);
        showAlert("Error initializing table. Please refresh the page.", "danger");
        return;
    }

    // Row numbering - update on draw event for server-side pagination
    table.on('draw', function() {
        var info = table.page.info();
        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
            cell.innerHTML = info.start + i + 1;
        });
    });

    // Filter button
    $('#filterBtn').on('click', function() {
        var dateFrom = $('#date_from').val();
        var dateTo = $('#date_to').val();
        var gatePassType = $('#gate_pass_type').val();
        var passCategory = $('#pass_category').val();
        var status = $('#status').val();
        var jobCardId = $('#job_card_id').val();

        var url = base_url + "GatePass/getGatePasses?";
        var params = [];
        
        if (dateFrom) params.push("date_from=" + dateFrom);
        if (dateTo) params.push("date_to=" + dateTo);
        if (gatePassType) params.push("gate_pass_type=" + gatePassType);
        if (passCategory) params.push("pass_category=" + passCategory);
        if (status) params.push("status=" + status);
        if (jobCardId) params.push("job_card_id=" + jobCardId);

        url += params.join("&");
        
        table.ajax.url(url).load();
    });

    // Clear filter
    $('#clearFilterBtn').on('click', function() {
        $('#date_from').val('');
        $('#date_to').val('');
        $('#gate_pass_type').val('');
        $('#pass_category').val('');
        $('#status').val('');
        $('#job_card_id').val('');
        table.ajax.url(base_url + "GatePass/getGatePasses").load();
    });

    // Request Reprint Approve: open modal (cashier/other user)
    var requestReprintGatePassId = null;
    $(document).on('click', '.request-reprint-approve', function() {
        requestReprintGatePassId = $(this).data('id');
        $('#requestModalGatePassNumber').text($(this).data('number') || requestReprintGatePassId);
        $('#reprintRequestReason').val('');
        $('#requestReprintApproveModal').modal('show');
    });
    $('#submitReprintRequestBtn').on('click', function() {
        var reason = $('#reprintRequestReason').val().trim();
        if (!reason) {
            error_toastify('Please enter a reason', 'danger');
            return;
        }
        if (!requestReprintGatePassId) return;
        var $btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: base_url + 'GatePass/createReprintApproveRequest/' + requestReprintGatePassId,
            type: 'POST',
            data: { reason: reason },
            dataType: 'json',
            success: function(response) {
                if (response.status === true || response.code === 200) {
                    success_toastify(response.message || 'Request submitted. Finance manager will review.', 'success');
                    $('#requestReprintApproveModal').modal('hide');
                    table.ajax.reload();
                } else {
                    error_toastify(response.message || 'Failed to submit request', 'danger');
                }
                $btn.prop('disabled', false).html('Submit Request');
            },
            error: function(xhr) {
                error_toastify(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Failed to submit request', 'danger');
                $btn.prop('disabled', false).html('Submit Request');
            }
        });
    });

    // Pending Reprint Requests (finance manager): load list
    function loadReprintRequests() {
        if (typeof re_print_approvecheck === 'undefined' || re_print_approvecheck != 1) return;
        $.ajax({
            url: base_url + 'GatePass/listReprintRequests',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var list = response.data || [];
                var html = list.length === 0 ? '<p class="text-muted mb-0">No pending requests.</p>' : '<table class="table table-sm table-bordered"><thead><tr><th>Gate Pass</th><th>Job Card</th><th>Requested By</th><th>Reason</th><th>Date</th><th></th></tr></thead><tbody>';
                list.forEach(function(r) {
                    html += '<tr><td>' + (r.gate_pass_number || '-') + '</td><td>' + (r.job_card_number || '-') + '</td><td>' + (r.requested_by_name || '-') + '</td><td>' + (r.reason || '-').substring(0, 80) + (r.reason && r.reason.length > 80 ? '...' : '') + '</td><td>' + (r.created_at ? r.created_at.substring(0, 16) : '-') + '</td><td class="text-right"><button class="btn btn-success btn-sm approve-reprint-request" data-id="' + r.id + '">Approve</button></td></tr>';
                });
                if (list.length > 0) html += '</tbody></table>';
                $('#reprintRequestsList').html(html);
            },
            error: function() {
                $('#reprintRequestsList').html('<p class="text-danger">Failed to load requests.</p>');
            }
        });
    }
    if (typeof re_print_approvecheck !== 'undefined' && re_print_approvecheck == 1) {
        loadReprintRequests();
    }
    $('#refreshReprintRequests').on('click', function() { loadReprintRequests(); });
    $(document).on('click', '.approve-reprint-request', function() {
        var requestId = $(this).data('id');
        if (!confirm('Approve this reprint request? The requester will be able to reprint the gate pass.')) return;
        var $btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: base_url + 'GatePass/approveReprintRequest/' + requestId,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.status === true || response.code === 200) {
                    success_toastify(response.message || 'Request approved.', 'success');
                    loadReprintRequests();
                    table.ajax.reload();
                } else {
                    error_toastify(response.message || 'Failed to approve', 'danger');
                }
                $btn.prop('disabled', false).html('Approve');
            },
            error: function(xhr) {
                error_toastify(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Failed to approve', 'danger');
                $btn.prop('disabled', false).html('Approve');
            }
        });
    });

    // Reprint: ignore doc_access then print (e.g. when doc_access still active and user has no request flow)
    $(document).on('click', '.reprint-gate-pass', function() {
        var gatePassId = $(this).data('id');
        var gatePassNumber = $(this).data('number');
        if (!confirm('Reprint gate pass "' + gatePassNumber + '"? This will mark the latest doc access as ignore and then print.')) return;
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: base_url + 'GatePass/ignoreDocAccess/' + gatePassId,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.status === true || response.code === 200) {
                    $.ajax({
                        url: base_url + 'GatePass/printGatePass/' + gatePassId,
                        type: 'POST',
                        dataType: 'json',
                        success: function(printResp) {
                            if (printResp.status) {
                                success_toastify('Reprint completed successfully', 'success');
                                table.ajax.reload();
                            } else {
                                error_toastify(printResp.message || 'Print failed', 'danger');
                            }
                            $btn.prop('disabled', false).html('<i class="fas fa-print"></i>');
                        },
                        error: function(xhr) {
                            error_toastify(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Print failed', 'danger');
                            $btn.prop('disabled', false).html('<i class="fas fa-print"></i>');
                        }
                    });
                } else {
                    error_toastify(response.message || 'Failed to allow reprint', 'danger');
                    $btn.prop('disabled', false).html('<i class="fas fa-print"></i>');
                }
            },
            error: function(xhr) {
                error_toastify(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Failed to allow reprint', 'danger');
                $btn.prop('disabled', false).html('<i class="fas fa-print"></i>');
            }
        });
    });

    // Approve gate pass
    $(document).on('click', '.approve-gate-pass', function() {
        var gatePassId = $(this).data('id');
        var gatePassNumber = $(this).data('number');
        
        if (!confirm('Are you sure you want to approve gate pass "' + gatePassNumber + '"?\n\nThis will generate the final gate pass number and update the status to APPROVED.')) {
            return;
        }
        
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: base_url + 'GatePass/approveGatePass/' + gatePassId,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.status === true || response.code === 200) {
                    success_toastify('Gate pass approved successfully!', 'success');
                    table.ajax.reload();
                } else {
                    error_toastify(response.message || 'Failed to approve gate pass', 'danger');
                    $btn.prop('disabled', false).html('<i class="fas fa-check"></i>');
                }
            },
            error: function(xhr) {
                var errorMsg = 'Failed to approve gate pass';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                error_toastify(errorMsg, 'danger');
                $btn.prop('disabled', false).html('<i class="fas fa-check"></i>');
            }
        });
    });

    // Print gate pass
    $(document).on('click', '.print-gate-pass', function() {
        var gatePassId = $(this).data('id');
        printGatePass(gatePassId);
    });

    function printGatePass(id) {
        if (!confirm('Print this gate pass?')) return;

        $.ajax({
            url: base_url + "GatePass/printGatePass/" + id,
            type: "POST",
            success: function(response) {
                if (response.status) {
                    showAlert("Gate pass printed successfully", "success");
                    table.ajax.reload();
                } else {
                    showAlert(response.message || "Error printing gate pass", "danger");
                }
            },
            error: function(xhr) {
                var errorMsg = "Error printing gate pass";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showAlert(errorMsg, "danger");
            }
        });
    }

    function showAlert(message, type) {
        var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            message +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button></div>';
        $('.container-fluid').first().prepend(alertHtml);
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 3000);
    }
});
</script>

