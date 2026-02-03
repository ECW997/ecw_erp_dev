<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<style>
.card-header {
    background-color: white;
    border-bottom: 1px solid #6c757d;
    padding: 1rem 2rem;
}

.info-row {
    padding: 0.75rem 0;
    border-bottom: 1px solid #e9ecef;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #6c757d;
    min-width: 150px;
    display: inline-block;
}

.badge-gate-pass {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}

.badge-in { background-color: #28a745; }
.badge-out { background-color: #dc3545; }
.badge-temp-in { background-color: #17a2b8; }
.badge-temp-out { background-color: #ffc107; color: #000; }
.badge-main { background-color: #007bff; }
.badge-internal { background-color: #6f42c1; }
.badge-external { background-color: #fd7e14; }
</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include APPPATH . "views/include/menubar.php"; ?>
    </div>
    <?php
    // Gate Pass permissions (Menu ID: 42) are set in menubar.php when on GatePass; ensure they exist
    if (!isset($addcheck)) $addcheck = 0;
    if (!isset($editcheck)) $editcheck = 0;
    if (!isset($statuscheck)) $statuscheck = 0;
    if (!isset($deletecheck)) $deletecheck = 0;
    if (!isset($printcheck)) $printcheck = 0;
    
    // Get current user type ID from session
    $current_user_type_id = $this->session->userdata('user_type_id');

    // Define allowed user types for MAIN IN/OUT printing (adjust these IDs as needed)
    // Common user types: Admin=1, Cashier=11,  etc.
    $allowed_user_types_for_main = [1, 11]; // Add your specific user type IDs here
    
    // Check if user can print MAIN IN/OUT gate passes
    $can_print_main = false;
    if ($printcheck == 1) {
        // if (isset($gate_pass) && $gate_pass && isset($gate_pass->pass_category) && $gate_pass->pass_category === 'MAIN') {
        //     // For MAIN IN/OUT, check both printcheck AND user type
        //     $can_print_main = in_array($current_user_type_id, $allowed_user_types_for_main);
        // } else {
        //     // For INTERNAL/EXTERNAL, only check printcheck
        //     $can_print_main = true;
        // }
        $can_print_main = in_array($current_user_type_id, $allowed_user_types_for_main);
    }
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3 d-flex justify-content-between align-items-center">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-id-card"></i></div>
                            <span>Gate Pass Details</span>
                        </h1>
                        <div>
                            <a href="<?= base_url('GatePass') ?>" class="btn btn-secondary btn-sm px-4 p-2">
                                <i class="fas fa-arrow-left mr-2"></i>Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-2">
                <?php if (isset($gate_pass) && $gate_pass) : ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Gate Pass Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="info-row">
                                    <span class="info-label">Gate Pass Number:</span>
                                    <strong><?= htmlspecialchars($gate_pass->gate_pass_number ?? '-') ?></strong>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Type:</span>
                                    <?php 
                                    $type = $gate_pass->gate_pass_type ?? '-';
                                    $badgeClass = 'badge-secondary';
                                    if ($type === 'IN') $badgeClass = 'badge-in';
                                    else if ($type === 'OUT') $badgeClass = 'badge-out';
                                    else if ($type === 'TEMP_IN') $badgeClass = 'badge-temp-in';
                                    else if ($type === 'TEMP_OUT') $badgeClass = 'badge-temp-out';
                                    ?>
                                    <span class="badge badge-gate-pass <?= $badgeClass ?>"><?= $type ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Category:</span>
                                    <?php 
                                    $category = $gate_pass->pass_category ?? '-';
                                    $badgeClass = 'badge-secondary';
                                    if ($category === 'MAIN') $badgeClass = 'badge-main';
                                    else if ($category === 'INTERNAL') $badgeClass = 'badge-internal';
                                    else if ($category === 'EXTERNAL') $badgeClass = 'badge-external';
                                    ?>
                                    <span class="badge badge-gate-pass <?= $badgeClass ?>"><?= $category ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Status:</span>
                                    <?php 
                                    $status = $gate_pass->status ?? '-';
                                    $badgeClass = 'badge-secondary';
                                    if ($status === 'ACTIVE') $badgeClass = 'badge-success';
                                    else if ($status === 'COMPLETED') $badgeClass = 'badge-info';
                                    else if ($status === 'CANCELLED') $badgeClass = 'badge-danger';
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
                                </div>
                                <?php
                                $reprint_req = isset($gate_pass->reprint_request) && $gate_pass->reprint_request ? $gate_pass->reprint_request : null;
                                if ($reprint_req && in_array($gate_pass->status ?? '', ['APPROVED', 'ACTIVE'])) :
                                    $req_status = is_object($reprint_req) ? ($reprint_req->status ?? '') : ($reprint_req['status'] ?? '');
                                    $req_reason = is_object($reprint_req) ? ($reprint_req->reason ?? '') : ($reprint_req['reason'] ?? '');
                                    $req_requested_at = is_object($reprint_req) ? ($reprint_req->requested_at ?? '') : ($reprint_req['requested_at'] ?? '');
                                    $req_approved_at = is_object($reprint_req) ? ($reprint_req->approved_at ?? '') : ($reprint_req['approved_at'] ?? '');
                                    $req_consumed_at = is_object($reprint_req) ? ($reprint_req->consumed_at ?? '') : ($reprint_req['consumed_at'] ?? '');
                                    $doc_access_active = isset($gate_pass->latest_doc_access_active) && ($gate_pass->latest_doc_access_active === true || $gate_pass->latest_doc_access_active === 1);
                                    $doc_access_has_any = isset($gate_pass->doc_access_has_any_record) && ($gate_pass->doc_access_has_any_record === true || $gate_pass->doc_access_has_any_record === 1);
                                    $doc_access_ignore = !$doc_access_active;
                                    $stage_class = 'secondary';
                                    $stage_text = '';
                                    if ($req_status === 'PENDING') {
                                        $stage_class = 'warning';
                                        $stage_text = 'Pending – Awaiting finance manager approval';
                                    } elseif ($req_status === 'APPROVED') {
                                        if ($req_consumed_at) {
                                            $stage_class = 'secondary';
                                            $stage_text = 'Approved – Already used (reprint done)';
                                        } elseif ($doc_access_ignore && $doc_access_has_any) {
                                            $stage_class = 'success';
                                            $stage_text = 'Approved – You can reprint';
                                        } elseif (!$doc_access_has_any) {
                                            $stage_class = 'info';
                                            $stage_text = 'Approved – Print once first, then reprint';
                                        } else {
                                            $stage_class = 'info';
                                            $stage_text = 'Approved – Awaiting unlock';
                                        }
                                    } elseif ($req_status === 'REJECTED') {
                                        $stage_class = 'danger';
                                        $stage_text = 'Rejected';
                                    } else {
                                        $stage_text = $req_status;
                                    }
                                ?>
                                <div class="info-row">
                                    <span class="info-label">Reprint request stage:</span>
                                    <span class="badge badge-<?= $stage_class ?> badge-gate-pass"><?= htmlspecialchars($stage_text) ?></span>
                                </div>
                                <?php if ($req_reason) : ?>
                                <div class="info-row">
                                    <span class="info-label">Request reason:</span>
                                    <?= htmlspecialchars($req_reason) ?>
                                </div>
                                <?php endif; ?>
                                <?php if ($req_requested_at) : ?>
                                <div class="info-row">
                                    <span class="info-label">Requested at:</span>
                                    <?= date('Y-m-d H:i', strtotime($req_requested_at)) ?>
                                </div>
                                <?php endif; ?>
                                <?php if ($req_approved_at && $req_status === 'APPROVED') : ?>
                                <div class="info-row">
                                    <span class="info-label">Approved at:</span>
                                    <?= date('Y-m-d H:i', strtotime($req_approved_at)) ?>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                                <div class="info-row">
                                    <span class="info-label">Location:</span>
                                    <?= isset($gate_pass->location) ? htmlspecialchars($gate_pass->location->location_name) : '-' ?>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Created At:</span>
                                    <?= isset($gate_pass->created_at) ? date('Y-m-d H:i:s', strtotime($gate_pass->created_at)) : '-' ?>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Print Count:</span>
                                    <?= $gate_pass->print_count ?? 0 ?>
                                </div>
                                <?php if (isset($gate_pass->remarks) && $gate_pass->remarks) : ?>
                                <div class="info-row">
                                    <span class="info-label">Remarks:</span>
                                    <?= htmlspecialchars($gate_pass->remarks) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (isset($gate_pass->job_card) && $gate_pass->job_card) : ?>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="mb-0">Job Card Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="info-row">
                                    <span class="info-label">Job Card Number:</span>
                                    <?= htmlspecialchars($gate_pass->job_card->job_card_number2 ?? $gate_pass->job_card->job_card_number ?? '-') ?>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Vehicle Number:</span>
                                    <?= htmlspecialchars($gate_pass->job_card->vehicle_number ?? '-') ?>
                                </div>
                                <?php if (isset($gate_pass->job_card->customer) && $gate_pass->job_card->customer) : ?>
                                <div class="info-row">
                                    <span class="info-label">Customer:</span>
                                    <?= htmlspecialchars($gate_pass->job_card->customer->customer_name ?? '-') ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (isset($gate_pass) && $gate_pass && isset($gate_pass->pass_category) && $gate_pass->pass_category === 'EXTERNAL') : ?>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="mb-0">External Party Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="info-row">
                                    <span class="info-label">External Party Name:</span>
                                    <?= htmlspecialchars($gate_pass->external_party_name ?? '-') ?>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">External Party Type:</span>
                                    <?= htmlspecialchars($gate_pass->external_party_type ?? '-') ?>
                                </div>
                                <?php if (isset($gate_pass->external_party_contact) && $gate_pass->external_party_contact) : ?>
                                <div class="info-row">
                                    <span class="info-label">Contact:</span>
                                    <?= htmlspecialchars($gate_pass->external_party_contact) ?>
                                </div>
                                <?php endif; ?>
                                <?php if (isset($gate_pass->external_party_address) && $gate_pass->external_party_address) : ?>
                                <div class="info-row">
                                    <span class="info-label">Address:</span>
                                    <?= htmlspecialchars($gate_pass->external_party_address) ?>
                                </div>
                                <?php endif; ?>
                                <div class="info-row">
                                    <span class="info-label">Transfer Purpose:</span>
                                    <?= htmlspecialchars($gate_pass->external_transfer_purpose ?? '-') ?>
                                </div>
                                <?php if (isset($gate_pass->expected_return_date) && $gate_pass->expected_return_date) : ?>
                                <div class="info-row">
                                    <span class="info-label">Expected Return Date:</span>
                                    <?= date('Y-m-d', strtotime($gate_pass->expected_return_date)) ?>
                                </div>
                                <?php endif; ?>
                                <?php if (isset($gate_pass->actual_return_date) && $gate_pass->actual_return_date) : ?>
                                <div class="info-row">
                                    <span class="info-label">Actual Return Date:</span>
                                    <?= date('Y-m-d', strtotime($gate_pass->actual_return_date)) ?>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (isset($gate_pass->company_driver_name) || isset($gate_pass->company_worker_name)) : ?>
                                <h6 class="mt-3 mb-2">Company Driver/Worker</h6>
                                <?php if (isset($gate_pass->company_driver_name) && $gate_pass->company_driver_name) : ?>
                                <div class="info-row">
                                    <span class="info-label">Driver:</span>
                                    <?= htmlspecialchars($gate_pass->company_driver_name) ?>
                                    <?php if (isset($gate_pass->company_driver_contact) && $gate_pass->company_driver_contact) : ?>
                                    <span class="text-muted ml-2">(<?= htmlspecialchars($gate_pass->company_driver_contact) ?>)</span>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <?php if (isset($gate_pass->company_worker_name) && $gate_pass->company_worker_name) : ?>
                                <div class="info-row">
                                    <span class="info-label">Worker:</span>
                                    <?= htmlspecialchars($gate_pass->company_worker_name) ?>
                                    <?php if (isset($gate_pass->company_worker_contact) && $gate_pass->company_worker_contact) : ?>
                                    <span class="text-muted ml-2">(<?= htmlspecialchars($gate_pass->company_worker_contact) ?>)</span>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (isset($gate_pass) && $gate_pass && isset($gate_pass->pass_category) && $gate_pass->pass_category === 'INTERNAL') : ?>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="mb-0">Internal Transfer Information</h5>
                            </div>
                            <div class="card-body">
                                <?php if (isset($gate_pass->from_location) && $gate_pass->from_location) : ?>
                                <div class="info-row">
                                    <span class="info-label">From Location:</span>
                                    <?= htmlspecialchars($gate_pass->from_location->location_name) ?>
                                </div>
                                <?php endif; ?>
                                <?php if (isset($gate_pass->to_location) && $gate_pass->to_location) : ?>
                                <div class="info-row">
                                    <span class="info-label">To Location:</span>
                                    <?= htmlspecialchars($gate_pass->to_location->location_name) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Actions</h5>
                            </div>
                            <div class="card-body">
                                <?php if (isset($gate_pass) && $gate_pass && isset($gate_pass->pass_category) && $gate_pass->pass_category === 'EXTERNAL' && isset($gate_pass->gate_pass_type) && $gate_pass->gate_pass_type === 'TEMP_OUT' && (!isset($gate_pass->actual_return_date) || !$gate_pass->actual_return_date) && $editcheck == 1) : ?>
                                <button class="btn btn-success btn-block mb-2" id="markReturnBtn">
                                    <i class="fas fa-check-circle mr-2"></i>Mark as Returned
                                </button>
                                <?php endif; ?>
                                <?php if ($can_print_main) : ?>
                                <button class="btn btn-primary btn-block" id="printBtn">
                                    <i class="fas fa-print mr-2"></i>Print Gate Pass
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="mb-0">Print History</h5>
                            </div>
                            <div class="card-body">
                                <div class="info-row">
                                    <span class="info-label">Print Count:</span>
                                    <strong><?= $gate_pass->print_count ?? 0 ?></strong>
                                </div>
                                <?php if (isset($gate_pass->first_print_at) && $gate_pass->first_print_at) : ?>
                                <div class="info-row">
                                    <span class="info-label">First Printed:</span>
                                    <?= date('Y-m-d H:i:s', strtotime($gate_pass->first_print_at)) ?>
                                </div>
                                <?php endif; ?>
                                <?php if (isset($gate_pass->last_print_at) && $gate_pass->last_print_at) : ?>
                                <div class="info-row">
                                    <span class="info-label">Last Printed:</span>
                                    <?= date('Y-m-d H:i:s', strtotime($gate_pass->last_print_at)) ?>
                                </div>
                                <?php endif; ?>
                                <?php if (isset($gate_pass->printer) && $gate_pass->printer) : ?>
                                <div class="info-row">
                                    <span class="info-label">Printed By:</span>
                                    <?= htmlspecialchars($gate_pass->printer->name ?? '-') ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else : ?>
                <div class="alert alert-warning">
                    Gate pass not found or could not be loaded.
                </div>
                <?php endif; ?>
            </div>
        </main>

        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>
<?php include APPPATH . "views/include/footerscripts.php"; ?>
<script>
var base_url = '<?= base_url() ?>';
var gatePassId = '<?= isset($gate_pass) && $gate_pass ? $gate_pass->id : '' ?>';
var printcheck = '<?php echo $printcheck ?? 0; ?>';

$(document).ready(function() {
    $('#printBtn').on('click', function() {
        if (!gatePassId) return;
        if (!confirm('Print this gate pass?')) return;

        // Check with backend if print is allowed (prevents duplicate prints)
        $.ajax({
            url: base_url + 'GatePass/checkPrintAllowed/' + gatePassId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status && response.data && response.data.allowed) {
                    // Print is allowed - Open PDF in new window
                    const pdfUrl = base_url + 'GatePass/gatePassPDF?gate_pass_id=' + encodeURIComponent(gatePassId);
                    window.open(pdfUrl, '_blank');
                    
                    // Reload page after a short delay to update print status
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    // Print not allowed - show error message
                    const errorMsg = response.message || response.data?.message || 'This gate pass cannot be printed. It may have already been printed.';
                    alert(errorMsg);
                }
            },
            error: function(xhr) {
                // If check fails, still allow print (backend will handle validation)
                const pdfUrl = base_url + 'GatePass/gatePassPDF?gate_pass_id=' + encodeURIComponent(gatePassId);
                window.open(pdfUrl, '_blank');
                
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }
        });
    });

    $('#markReturnBtn').on('click', function() {
        if (!gatePassId) return;
        if (!confirm('Mark this external transfer as returned?')) return;

        $.ajax({
            url: base_url + 'GatePass/markExternalReturn/' + gatePassId,
            type: 'POST',
            success: function(response) {
                if (response.status) {
                    alert('External transfer marked as returned successfully');
                    location.reload();
                } else {
                    alert(response.message || 'Error marking as returned');
                }
            },
            error: function(xhr) {
                var errorMsg = 'Error marking as returned';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                alert(errorMsg);
            }
        });
    });
});
</script>

