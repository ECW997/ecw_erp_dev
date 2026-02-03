<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<style>
.card-header {
    background-color: white;
    border-bottom: 1px solid #6c757d;
    padding: 1rem 2rem;
}

.form-section {
    border-left: 3px solid #007bff;
    padding-left: 15px;
    margin-bottom: 20px;
}

.form-section h6 {
    color: #007bff;
    font-weight: 600;
}
</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include APPPATH . "views/include/menubar.php"; ?>
    </div>
    <?php
    // Check permissions using menuaccess (Menu ID: 42 for Gate Pass)
    // Note: checkprivilege() function is defined in menubar.php, so we call it after including menubar.php
    $addcheck = isset($menuaccess) ? checkprivilege($menuaccess, 42, 1) : 0; // Add permission
    $editcheck = isset($menuaccess) ? checkprivilege($menuaccess, 42, 2) : 0; // Edit permission
    $statuscheck = isset($menuaccess) ? checkprivilege($menuaccess, 42, 3) : 0; // Status permission
    $deletecheck = isset($menuaccess) ? checkprivilege($menuaccess, 42, 4) : 0; // Delete permission
    $printcheck = isset($menuaccess) ? checkprivilege($menuaccess, 42, 5) : 0; // Print permission (approve1)
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3 d-flex justify-content-between align-items-center">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-plus-circle"></i></div>
                            <span>Generate Gate Pass</span>
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
                <div class="card">
                    <div class="card-body">
                        <form id="gatePassForm">
                            <!-- Step 1: Job Card Selection (Must be selected first) -->
                            <div class="form-section">
                                <h6><i class="fas fa-step-1"></i> Step 1: Select Job Card</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Job Card <span class="text-danger">*</span></label>
                                        <select id="job_card_id" class="form-control select2" style="width: 100%;" required>
                                            <option value="">Select Job Card</option>
                                            <?php if (isset($job_card_id) && $job_card_id) : ?>
                                            <option value="<?= $job_card_id ?>" selected><?= $job_card_id ?></option>
                                            <?php endif; ?>
                                        </select>
                                        <small class="form-text text-muted">Search and select a job card to proceed</small>
                                        
                                        <!-- Gate Pass Status Alert -->
                                        <div id="gatePassStatusAlert" style="display: none; margin-top: 10px;"></div>
                                    </div>
                                </div>
                                <div class="row mt-2" id="jobCardInfo" style="display: <?= isset($job_card) && $job_card ? 'block' : 'none' ?>;">
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <?php if (isset($job_card) && $job_card) : ?>
                                            <strong>Job Card:</strong> <span id="jobCardNumber"><?= $job_card->job_card_number2 ?? $job_card->job_card_number ?? '-' ?></span><br>
                                            <strong>Vehicle:</strong> <span id="vehicleNumber"><?= $job_card->vehicle_number ?? '-' ?></span><br>
                                            <strong>Customer:</strong> <span id="customerName"><?= isset($job_card->customer) ? $job_card->customer->customer_name : '-' ?></span><br>
                                            <strong>Confirmation Status:</strong> <span id="jobCardConfirmationStatus"><?= $job_card->confirmation_status ?? '-' ?></span><br>
                                            <strong>Job Status:</strong> <span id="jobCardJobStatus"><?= $job_card->status ?? '-' ?></span> <span id="jobCardProgressStatus"></span><br>
                                            <strong>Payment Status:</strong> <span id="jobCardPaymentStatus">-</span>
                                            <?php else : ?>
                                            <strong>Job Card:</strong> <span id="jobCardNumber">-</span><br>
                                            <strong>Vehicle:</strong> <span id="vehicleNumber">-</span><br>
                                            <strong>Customer:</strong> <span id="customerName">-</span><br>
                                            <strong>Confirmation Status:</strong> <span id="jobCardConfirmationStatus">-</span><br>
                                            <strong>Job Status:</strong> <span id="jobCardJobStatus">-</span> <span id="jobCardProgressStatus"></span><br>
                                            <strong>Payment Status:</strong> <span id="jobCardPaymentStatus">-</span>
                                            <?php endif; ?>
                                        </div>
                                        <!-- Job Card Status Warnings -->
                                        <div id="jobCardStatusWarnings" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Gate Pass Type Selection (Enabled after job card selection) -->
                            <div class="form-section disabled-section" id="gatePassTypeSection">
                                <h6><i class="fas fa-list"></i> Step 2: Gate Pass Type</h6>
                                <div class="alert alert-info" id="step2Info">
                                    <i class="fas fa-info-circle"></i> Please select a job card first to enable this section.
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Category <span class="text-danger">*</span></label>
                                        <select id="pass_category" class="form-control" required disabled>
                                            <option value="">Select Category</option>
                                            <option value="MAIN">Main</option>
                                            <option value="INTERNAL">Internal</option>
                                            <option value="EXTERNAL">External</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Gate Pass Type <span class="text-danger">*</span></label>
                                        <select id="gate_pass_type" class="form-control" required disabled>
                                            <option value="">Select Type</option>
                                        </select>
                                        <small class="form-text text-muted" id="gate_pass_type_hint" style="display: none;">
                                            <i class="fas fa-info-circle"></i> This field is auto-selected based on vehicle tracking.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Location and Additional Information (Enabled after job card selection) -->
                            <div class="form-section disabled-section" id="locationSection">
                                <h6><i class="fas fa-map-marker-alt"></i> Step 3: Gate Location</h6>
                                <div class="alert alert-info" id="step3Info">
                                    <i class="fas fa-info-circle"></i> Please select a job card first to enable this section.
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Gate Location <span class="text-danger">*</span></label>
                                        <select id="location_id" class="form-control" required disabled>
                                            <option value="">Select Location</option>
                                            <?php if (!empty($locations) && is_array($locations)) : ?>
                                            <?php foreach ($locations as $location) : ?>
                                            <?php 
                                                // Handle both array and object formats
                                                $loc_id = is_array($location) ? (isset($location['id']) ? $location['id'] : null) : (isset($location->id) ? $location->id : null);
                                                $loc_name = is_array($location) ? (isset($location['location_name']) ? $location['location_name'] : '') : (isset($location->location_name) ? $location->location_name : '');
                                                $is_default = is_array($location) ? (isset($location['is_default']) ? $location['is_default'] : false) : (isset($location->is_default) ? $location->is_default : false);
                                            ?>
                                            <?php if ($loc_id && $loc_name) : ?>
                                            <option value="<?= $loc_id ?>" 
                                                <?= (isset($default_location_id) && $loc_id == $default_location_id) ? 'selected' : '' ?>
                                                data-is-default="<?= $is_default ? '1' : '0' ?>">
                                                <?= htmlspecialchars($loc_name) ?>
                                            </option>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php else : ?>
                                            <option value="">No locations available</option>
                                            <?php endif; ?>
                                        </select>
                                        <?php if (empty($locations) || !is_array($locations)) : ?>
                                        <small class="form-text text-danger">Warning: Locations could not be loaded. Please refresh the page.</small>
                                        <?php endif; ?>
                                        <small class="form-text text-muted" id="location_hint" style="display: none;">Default: Production location</small>
                                        <small class="form-text text-muted" id="location_explanation" style="display: none;">
                                            <strong>Purpose:</strong> This is the location where the gate pass is being issued/processed.
                                            <br><strong>MAIN:</strong> Production/Main location
                                            <br><strong>INTERNAL TEMP_IN:</strong> Auto-set to "To Location" (where vehicle enters)
                                            <br><strong>INTERNAL TEMP_OUT:</strong> Auto-set to "From Location" (where vehicle leaves)
                                            <br><strong>EXTERNAL:</strong> Company location handling the external transfer
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Internal Transfer Fields (for INTERNAL category) -->
                            <div class="form-section" id="internalFields" style="display: none;">
                                <h6><i class="fas fa-exchange-alt"></i> Internal Transfer Information</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>From Location <small class="text-muted">(Auto-filled based on tracking)</small></label>
                                        <select id="from_location_id" class="form-control" disabled>
                                            <option value="">Select From Location</option>
                                            <?php if (!empty($locations) && is_array($locations)) : ?>
                                            <?php foreach ($locations as $location) : ?>
                                            <?php 
                                                $loc_id = is_array($location) ? (isset($location['id']) ? $location['id'] : null) : (isset($location->id) ? $location->id : null);
                                                $loc_name = is_array($location) ? (isset($location['location_name']) ? $location['location_name'] : '') : (isset($location->location_name) ? $location->location_name : '');
                                            ?>
                                            <?php if ($loc_id && $loc_name) : ?>
                                            <option value="<?= $loc_id ?>"><?= htmlspecialchars($loc_name) ?></option>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <small class="form-text text-muted">This field is automatically set based on vehicle tracking and cannot be changed.</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label>To Location</label>
                                        <select id="to_location_id" class="form-control">
                                            <option value="">Select To Location</option>
                                            <?php if (!empty($locations) && is_array($locations)) : ?>
                                            <?php foreach ($locations as $location) : ?>
                                            <?php 
                                                $loc_id = is_array($location) ? (isset($location['id']) ? $location['id'] : null) : (isset($location->id) ? $location->id : null);
                                                $loc_name = is_array($location) ? (isset($location['location_name']) ? $location['location_name'] : '') : (isset($location->location_name) ? $location->location_name : '');
                                            ?>
                                            <?php if ($loc_id) : ?>
                                            <option value="<?= $loc_id ?>"><?= htmlspecialchars($loc_name) ?></option>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- External Transfer Fields (for EXTERNAL category) -->
                            <div class="form-section" id="externalFields" style="display: none;">
                                <!-- Common Transfer Purpose Section -->
                                <h6><i class="fas fa-info-circle"></i> Transfer Purpose (Common) <span id="transfer_purpose_required" style="display: none;">*</span></h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Transfer Purpose <span id="transfer_purpose_label_required" style="display: none;">*</span></label>
                                        <select id="external_transfer_purpose" class="form-control select2" style="width: 100%;">
                                            <option value="">Select Transfer Purpose</option>
                                            <?php if (!empty($transfer_purposes)) : ?>
                                            <?php foreach ($transfer_purposes as $purpose) : ?>
                                            <option value="<?= htmlspecialchars($purpose['name']) ?>"><?= htmlspecialchars($purpose['name']) ?></option>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <small class="form-text text-muted">Search and select from predefined purposes <span id="transfer_purpose_hint" style="display: none;">(Required for External OUT)</span></small>
                                        <input type="text" id="external_transfer_purpose_custom" class="form-control mt-2" placeholder="Or enter custom purpose" style="display: none;" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Expected Return Date</label>
                                        <input type="date" id="expected_return_date" class="form-control" />
                                    </div>
                                </div>

                                <h6 class="mt-3"><i class="fas fa-building"></i> External Party Information</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>External Party Name *</label>
                                        <input type="text" id="external_party_name" class="form-control" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>External Party Type *</label>
                                        <select id="external_party_type" class="form-control">
                                            <option value="">Select Type</option>
                                            <option value="Supplier">Supplier</option>
                                            <option value="Customer">Customer</option>
                                            <option value="Third Party">Third Party</option>
                                            <option value="Workshop">Workshop</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label>Contact</label>
                                        <input type="text" id="external_party_contact" class="form-control" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Address</label>
                                        <input type="text" id="external_party_address" class="form-control" />
                                    </div>
                                </div>

                                <h6 class="mt-3"><i class="fas fa-users"></i> Company Driver/Worker Information</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Driver (Employee ID)</label>
                                        <input type="number" id="company_driver_id" class="form-control" placeholder="Employee ID" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>Driver Name</label>
                                        <input type="text" id="company_driver_name" class="form-control" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>Driver Contact</label>
                                        <input type="text" id="company_driver_contact" class="form-control" />
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label>Worker (Employee ID)</label>
                                        <input type="number" id="company_worker_id" class="form-control" placeholder="Employee ID" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>Worker Name</label>
                                        <input type="text" id="company_worker_name" class="form-control" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>Worker Contact</label>
                                        <input type="text" id="company_worker_contact" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <!-- Remarks -->
                            <div class="form-section">
                                <h6>Additional Information</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <label>Remarks</label>
                                        <textarea id="remarks" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row mt-4">
                                <div class="col-12 text-right">
                                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
                                    <?php if ($addcheck == 1) : ?>
                                    <button type="submit" class="btn btn-primary ml-2">Generate Gate Pass</button>
                                    <?php else : ?>
                                    <button type="button" class="btn btn-primary ml-2" disabled title="You don't have permission to generate gate passes">Generate Gate Pass</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>
<?php include APPPATH . "views/include/footerscripts.php"; ?>
<script>
var base_url = '<?= base_url() ?>';
var availableTypes = <?= json_encode($available_types ?? []) ?>;
var jobCard = <?= json_encode($job_card ?? null) ?>;
var defaultLocationId = <?= json_encode($default_location_id ?? null) ?>;
var defaultLocationId = <?= json_encode($default_location_id ?? null) ?>;

// Store customer data globally for auto-fill
window.currentCustomerData = null;

$(document).ready(function() {
    // Initialize Job Card Select2
    var jobCardSelect = $('#job_card_id');
    
    jobCardSelect.select2({
        placeholder: 'Search and select job card...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: base_url + 'GatePass/getJobcardNumbers',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                }
            },
            cache: true,
            processResults: function(data) {
                if (data.status == true) {
                    return {
                        results: data.data.item || [],
                        pagination: {
                            more: (data.data.item || []).length > 0
                        }
                    }
                } else {
                    return {
                        results: []
                    }
                }
            }
        }
    });

    // Function to enable form sections after job card selection
    function enableFormSections() {
        $('#gatePassTypeSection, #locationSection').show().removeClass('disabled-section').addClass('enabled-section');
        $('#step2Info, #step3Info').hide();
        $('#pass_category, #gate_pass_type').prop('disabled', false);
        
        // Handle location_id based on category
        var category = $('#pass_category').val();
        if (category === 'INTERNAL') {
            // For INTERNAL, location_id should be readonly and auto-managed
            $('#location_id').prop('disabled', false).prop('readonly', true).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
        } else {
            // For other categories, location_id is editable
            $('#location_id').prop('disabled', false).prop('readonly', false).css('background-color', '').css('cursor', '');
            autoSelectedLocationId = null; // Clear auto-selected value
        }
        
        // Enable internal/external fields if they're visible
        if ($('#internalFields').is(':visible')) {
            $('#to_location_id').prop('disabled', false);
            // From location should remain readonly when INTERNAL is selected
            $('#from_location_id').prop('disabled', true).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
            // Auto-populate from location based on tracking
            autoPopulateFromLocation();
        }
        if ($('#externalFields').is(':visible')) {
            // Enable all external party and company/worker information fields together
            // Remove both disabled and readonly attributes, and reset styling
            var externalFields = '#external_party_name, #external_party_type, #external_transfer_purpose, #external_party_contact, #external_party_address, #expected_return_date, #company_driver_id, #company_driver_name, #company_driver_contact, #company_worker_id, #company_worker_name, #company_worker_contact, #external_transfer_purpose_custom';
            $(externalFields).prop('disabled', false).prop('readonly', false).removeAttr('readonly').css({
                'background-color': '',
                'cursor': '',
                'opacity': '1'
            });
        }
    }
    
    // Function to disable form sections when no job card is selected
    function disableFormSections() {
        $('#gatePassTypeSection, #locationSection').addClass('disabled-section').removeClass('enabled-section');
        $('#step2Info, #step3Info').show();
        // Only clear values, don't clear options - preserve location dropdown options
        $('#pass_category, #gate_pass_type').prop('disabled', true).val('');
        $('#location_id').prop('disabled', true); // Don't clear location_id value to preserve options
        
        // Disable all other fields (including all external party and company/worker fields)
        $('#from_location_id, #to_location_id, #external_party_name, #external_party_type, #external_transfer_purpose, #external_party_contact, #external_party_address, #expected_return_date, #company_driver_id, #company_driver_name, #company_driver_contact, #company_worker_id, #company_worker_name, #company_worker_contact, #external_transfer_purpose_custom').prop('disabled', true).val('');
        $('#from_location_id').css('background-color', '').css('cursor', '');
        
        // Hide internal/external fields
        $('#internalFields, #externalFields').hide();
    }

    // Job card change handler - load job card details
    jobCardSelect.on('change', function() {
        var jobCardId = $(this).val();
        if (jobCardId) {
            // Clear previous status
            window.currentGatePassStatus = {};
            $('#gatePassStatusAlert').hide().html('');
            $('#pass_category option[value="MAIN"]').prop('disabled', false);
            
            // Enable form sections after job card is selected
            enableFormSections();
            
            loadJobCardInfo(jobCardId);
        } else {
            // Disable form sections when job card is cleared
            disableFormSections();
            
            $('#jobCardInfo').hide();
            $('#gatePassStatusAlert').hide().html('');
            window.currentGatePassStatus = {};
            window.currentCustomerData = null; // Clear customer data
            $('#pass_category option[value="MAIN"]').prop('disabled', false);
            $('#pass_category').val('').trigger('change');
        }
    });

    // Load job card if ID provided in URL
    var urlParams = new URLSearchParams(window.location.search);
    var jobCardIdFromUrl = urlParams.get('job_card_id');
    if (jobCardIdFromUrl) {
        jobCardSelect.val(jobCardIdFromUrl).trigger('change');
        // Enable sections if job card is loaded from URL
        setTimeout(function() {
            enableFormSections();
        }, 100);
    } else {
        // Disable sections on initial load if no job card
        disableFormSections();
    }

    // Category change handler
    $('#pass_category').on('change', function() {
        var category = $(this).val();
        var status = window.currentGatePassStatus || {};
        
        // Check if Internal/External is selected but MAIN IN doesn't exist
        if ((category === 'INTERNAL' || category === 'EXTERNAL') && !status.has_in) {
            error_toastify('Cannot select ' + category + ' category. MAIN IN gate pass must be created first.');
            $(this).val('').trigger('change');
            return;
        }
        
        // Reset gate pass type readonly state when category changes
        // EXTERNAL and INTERNAL will be set to readonly after auto-selection
        if (category !== 'INTERNAL' && category !== 'EXTERNAL') {
            $('#gate_pass_type').prop('readonly', false).prop('disabled', false).css('background-color', '').css('cursor', '');
            $('#gate_pass_type_hint').hide();
        }
        
        updateGatePassTypeOptions();
        toggleFieldSections();
        updateLocationDefault();
        
        // Ensure external fields are enabled when EXTERNAL category is selected
        if (category === 'EXTERNAL') {
            // Enable all external party and company/worker information fields
            // Remove both disabled and readonly attributes, and reset styling
            var externalFields = '#external_party_name, #external_party_type, #external_transfer_purpose, #external_party_contact, #external_party_address, #expected_return_date, #company_driver_id, #company_driver_name, #company_driver_contact, #company_worker_id, #company_worker_name, #company_worker_contact, #external_transfer_purpose_custom';
            $(externalFields).prop('disabled', false).prop('readonly', false).removeAttr('readonly').css({
                'background-color': '',
                'cursor': '',
                'opacity': '1'
            });
        }
        
        // Auto-select type after options are updated (use setTimeout to ensure DOM is ready)
        setTimeout(function() {
            if (category === 'INTERNAL') {
                autoSelectInternalType();
            } else if (category === 'EXTERNAL') {
                autoSelectExternalType();
                // Update transfer purpose required status after type is selected
                updateTransferPurposeRequired();
            } else if (category === 'MAIN') {
                autoSelectMainType();
            }
        }, 100);
    });
    
    // Function to update location default based on category
    function updateLocationDefault() {
        var category = $('#pass_category').val();
        var locationSelect = $('#location_id');
        var locationHint = $('#location_hint');
        
        if (category === 'MAIN' && defaultLocationId) {
            // For MAIN category, select default Production location
            locationSelect.val(defaultLocationId).trigger('change');
            locationSelect.prop('readonly', false).prop('disabled', false);
            locationHint.show();
        } else if (category === 'INTERNAL') {
            // For INTERNAL category, location_id is readonly and auto-synced based on gate pass type
            // TEMP_IN: location_id = to_location_id (entering location)
            // TEMP_OUT: location_id = from_location_id (leaving location)
            locationSelect.prop('readonly', true).prop('disabled', false).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
            // Update location_id immediately when category changes to INTERNAL
            setTimeout(function() {
                updateInternalLocationId();
            }, 100);
            locationHint.hide();
        } else if (category === 'EXTERNAL') {
            // For EXTERNAL category, auto-select location based on gate pass type
            locationSelect.prop('readonly', true).prop('disabled', false).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
            // Update location_id immediately when category changes to EXTERNAL
            setTimeout(function() {
                updateExternalLocationId();
            }, 100);
            locationHint.hide();
        } else {
            // For other categories, clear selection and enable
            locationSelect.val('');
            locationSelect.prop('readonly', false).css('background-color', '').css('cursor', '');
            locationHint.hide();
            $('#location_explanation').hide();
            $('#location_id_hint').hide();
            autoSelectedLocationId = null; // Clear auto-selected value
        }
    }
    
    // Store the auto-selected location_id value to prevent manual changes
    var autoSelectedLocationId = null;
    
    // Function to update location_id for INTERNAL category based on gate pass type
    function updateInternalLocationId() {
        var category = $('#pass_category').val();
        if (category !== 'INTERNAL') {
            autoSelectedLocationId = null;
            return;
        }
        
        var gatePassType = $('#gate_pass_type').val();
        var locationSelect = $('#location_id');
        
        if (gatePassType === 'TEMP_IN') {
            // TEMP_IN: location_id = to_location_id (entering location)
            var toLocationId = $('#to_location_id').val();
            if (toLocationId) {
                autoSelectedLocationId = toLocationId;
                locationSelect.val(toLocationId).trigger('change');
                // Make it readonly to prevent manual changes
                locationSelect.prop('readonly', true).prop('disabled', false).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
                // Show hint
                $('#location_id_hint').show();
            } else {
                autoSelectedLocationId = null;
                locationSelect.val('');
                $('#location_id_hint').hide();
            }
        } else if (gatePassType === 'TEMP_OUT') {
            // TEMP_OUT: location_id = from_location_id (leaving location)
            var fromLocationId = $('#from_location_id').val();
            if (fromLocationId) {
                autoSelectedLocationId = fromLocationId;
                locationSelect.val(fromLocationId).trigger('change');
                // Make it readonly to prevent manual changes
                locationSelect.prop('readonly', true).prop('disabled', false).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
                // Show hint
                $('#location_id_hint').show();
            } else {
                autoSelectedLocationId = null;
                locationSelect.val('');
                $('#location_id_hint').hide();
            }
        } else {
            autoSelectedLocationId = null;
            locationSelect.val('');
            $('#location_id_hint').hide();
        }
    }
    
    // Function to update location_id for EXTERNAL category based on gate pass type
    function updateExternalLocationId() {
        var category = $('#pass_category').val();
        if (category !== 'EXTERNAL') {
            autoSelectedLocationId = null;
            return;
        }
        
        var gatePassType = $('#gate_pass_type').val();
        var locationSelect = $('#location_id');
        var status = window.currentGatePassStatus || {};
        
        if (gatePassType === 'TEMP_IN') {
            // TEMP_IN: Vehicle coming back to company -> use default/production location
            if (defaultLocationId) {
                autoSelectedLocationId = defaultLocationId;
                locationSelect.val(defaultLocationId).trigger('change');
                locationSelect.prop('readonly', true).prop('disabled', false).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
                $('#location_hint').show().text('Default: Production location (vehicle returning)');
            } else {
                autoSelectedLocationId = null;
                locationSelect.val('');
                $('#location_hint').hide();
            }
        } else if (gatePassType === 'TEMP_OUT') {
            // TEMP_OUT: Vehicle going out -> use current location from tracking
            var currentLocationId = getCurrentLocationFromTracking();
            if (currentLocationId) {
                autoSelectedLocationId = currentLocationId;
                locationSelect.val(currentLocationId).trigger('change');
                locationSelect.prop('readonly', true).prop('disabled', false).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
                $('#location_hint').show().text('Auto-selected: Current vehicle location (vehicle leaving)');
            } else {
                // Fallback to default location if current location not found
                if (defaultLocationId) {
                    autoSelectedLocationId = defaultLocationId;
                    locationSelect.val(defaultLocationId).trigger('change');
                    locationSelect.prop('readonly', true).prop('disabled', false).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
                    $('#location_hint').show().text('Default: Production location');
                } else {
                    autoSelectedLocationId = null;
                    locationSelect.val('');
                    $('#location_hint').hide();
                }
            }
        } else {
            autoSelectedLocationId = null;
            locationSelect.val('');
            $('#location_hint').hide();
        }
    }
    
    // Prevent manual changes to location_id when it's auto-selected for INTERNAL or EXTERNAL
    $('#location_id').on('change', function() {
        var category = $('#pass_category').val();
        if ((category === 'INTERNAL' || category === 'EXTERNAL') && autoSelectedLocationId !== null) {
            // If user tries to manually change an auto-selected value, revert it
            var currentValue = $(this).val();
            if (currentValue != autoSelectedLocationId) {
                var categoryName = category === 'INTERNAL' ? 'INTERNAL' : 'EXTERNAL';
                error_toastify('Gate Location is auto-managed for ' + categoryName + ' category and cannot be changed manually.');
                $(this).val(autoSelectedLocationId);
                if (category === 'INTERNAL') {
                    updateInternalLocationId();
                } else if (category === 'EXTERNAL') {
                    updateExternalLocationId();
                }
            }
        }
    });
    
    // Function to filter "To Location" options to exclude "From Location"
    function filterToLocationOptions() {
        var category = $('#pass_category').val();
        if (category !== 'INTERNAL') {
            return;
        }
        
        var fromLocationId = $('#from_location_id').val();
        var toLocationSelect = $('#to_location_id');
        var currentToValue = toLocationSelect.val();
        
        // If From Location is selected, disable that option in To Location dropdown
        if (fromLocationId) {
            toLocationSelect.find('option').each(function() {
                var $option = $(this);
                var optionValue = $option.val();
                
                if (optionValue && optionValue == fromLocationId) {
                    // Disable the option that matches From Location
                    $option.prop('disabled', true);
                } else {
                    // Enable all other options
                    $option.prop('disabled', false);
                }
            });
            
            // If current To Location is the same as From Location, clear it
            if (currentToValue == fromLocationId) {
                toLocationSelect.val('').trigger('change');
                error_toastify('To Location cannot be the same as From Location. Please select a different location.');
            }
        } else {
            // If no From Location selected, enable all options
            toLocationSelect.find('option').prop('disabled', false);
        }
    }
    
    // When "To Location" changes for INTERNAL category, update Location field if TEMP_IN
    $('#to_location_id').on('change', function() {
        var category = $('#pass_category').val();
        if (category === 'INTERNAL') {
            // Prevent same location in both fields
            var fromLocationId = $('#from_location_id').val();
            var toLocationId = $(this).val();
            
            if (fromLocationId && toLocationId && fromLocationId == toLocationId) {
                error_toastify('To Location cannot be the same as From Location. Please select a different location.');
                $(this).val('').trigger('change');
                updateInternalLocationId();
                return;
            }
            
            // Update location_id immediately when to_location_id changes
            updateInternalLocationId();
        }
    });
    
    // When "From Location" changes for INTERNAL category, update Location field if TEMP_OUT
    // Note: From Location is usually readonly/auto-populated, but we validate anyway
    $('#from_location_id').on('change', function() {
        var category = $('#pass_category').val();
        if (category === 'INTERNAL') {
            // Prevent same location in both fields
            var fromLocationId = $(this).val();
            var toLocationId = $('#to_location_id').val();
            
            if (fromLocationId && toLocationId && fromLocationId == toLocationId) {
                error_toastify('From Location cannot be the same as To Location. Please select a different To Location.');
                $('#to_location_id').val('').trigger('change');
                updateInternalLocationId();
                return;
            }
            
            updateInternalLocationId();
        }
    });
    
    // When gate pass type changes for INTERNAL or EXTERNAL, update location_id
    // Also check if user manually changed it (remove readonly if they did)
    $('#gate_pass_type').on('change', function() {
        var category = $('#pass_category').val();
        if (category === 'INTERNAL') {
            // Update location_id immediately when gate pass type changes
            // Use setTimeout to ensure DOM is updated
            setTimeout(function() {
                updateInternalLocationId();
            }, 50);
            
            // If user manually changed the value, allow editing (remove readonly)
            // This allows flexibility if user needs to override auto-selection
            var $this = $(this);
            if ($this.prop('readonly')) {
                // User manually changed a readonly field - allow them to keep editing
                $this.prop('readonly', false).css('background-color', '').css('cursor', '');
                $('#gate_pass_type_hint').hide();
            }
        } else if (category === 'EXTERNAL') {
            // Update location_id immediately when gate pass type changes for EXTERNAL
            setTimeout(function() {
                updateExternalLocationId();
            }, 50);
            
            // Update transfer purpose required status based on gate pass type
            updateTransferPurposeRequired();
            
            // If user manually changed the value, allow editing (remove readonly)
            var $this = $(this);
            if ($this.prop('readonly')) {
                $this.prop('readonly', false).css('background-color', '').css('cursor', '');
                $('#gate_pass_type_hint').hide();
            }
        }
    });
    
    // Function to update transfer purpose required status based on gate pass type
    function updateTransferPurposeRequired() {
        var category = $('#pass_category').val();
        var gatePassType = $('#gate_pass_type').val();
        
        if (category === 'EXTERNAL') {
            // Transfer purpose is required only for External OUT
            if (gatePassType === 'TEMP_OUT') {
                $('#external_transfer_purpose').prop('required', true);
                $('#transfer_purpose_required').show();
                $('#transfer_purpose_label_required').show();
                $('#transfer_purpose_hint').show();
            } else {
                // TEMP_IN - not required
                $('#external_transfer_purpose').prop('required', false);
                $('#transfer_purpose_required').hide();
                $('#transfer_purpose_label_required').hide();
                $('#transfer_purpose_hint').hide();
            }
        } else {
            // Not external category - remove required
            $('#external_transfer_purpose').prop('required', false);
            $('#transfer_purpose_required').hide();
            $('#transfer_purpose_label_required').hide();
            $('#transfer_purpose_hint').hide();
        }
    }
    
    /**
     * Check latest OUT gate pass (internal or external) and auto-trigger external type if needed
     */
    function checkAndAutoTriggerExternalType(status) {
        // Check if MAIN IN exists without MAIN OUT
        if (!status.has_in || status.has_out) {
            return; // Only trigger when MAIN IN exists without MAIN OUT
        }
        
        // Use latest_out_gate_pass from backend if available, otherwise find it manually
        var latestOutGatePass = status.latest_out_gate_pass || null;
        
        if (!latestOutGatePass) {
            // Fallback: Get latest OUT gate pass from gate passes array
            var gatePasses = status.gate_passes || [];
            var latestOutDate = null;
            
            gatePasses.forEach(function(gp) {
                if (gp.gate_pass_type === 'TEMP_OUT' && gp.status === 'ACTIVE') {
                    var gpDate = new Date(gp.created_at);
                    if (!latestOutDate || gpDate > latestOutDate) {
                        latestOutDate = gpDate;
                        latestOutGatePass = gp;
                    }
                }
            });
        }
        
        // If latest OUT is external, auto-trigger external category
        if (latestOutGatePass && latestOutGatePass.pass_category === 'EXTERNAL') {
            // Auto-select EXTERNAL category
            var currentCategory = $('#pass_category').val();
            if (currentCategory !== 'EXTERNAL') {
                $('#pass_category').val('EXTERNAL').trigger('change');
                
                // Show info message
                var alertHtml = '<div class="alert alert-info alert-dismissible fade show mt-2" role="alert">' +
                    '<strong><i class="fas fa-info-circle"></i> Auto-selected:</strong> ' +
                    'Latest gate pass OUT is External. External category has been auto-selected. ' +
                    'Please create External IN gate pass to bring the vehicle back.' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span></button></div>';
                
                // Append to gate pass status alert or show separately
                if ($('#gatePassStatusAlert').length) {
                    $('#gatePassStatusAlert').after(alertHtml);
                }
            }
        }
    }
    
    /**
     * Function to auto-select EXTERNAL gate pass type based on latest record
     * Logic: If any TEMP_OUT external exists (active), auto-select TEMP_IN, else auto-select TEMP_OUT
     */
    function autoSelectExternalType() {
        var category = $('#pass_category').val();
        if (category !== 'EXTERNAL') {
            // Reset readonly state if not EXTERNAL
            $('#gate_pass_type').prop('readonly', false).prop('disabled', false).css('background-color', '');
            $('#gate_pass_type_hint').hide();
            return; // Only for EXTERNAL category
        }
        
        var status = window.currentGatePassStatus || {};
        var gatePassTypeSelect = $('#gate_pass_type');
        var wasAutoSelected = false;
        
        var gatePasses = status.gate_passes || [];
        var hasActiveExternalOut = false;
        
        // Check latest_out_gate_pass from backend first (most reliable)
        var latestOutGatePass = status.latest_out_gate_pass || null;
        if (latestOutGatePass && 
            latestOutGatePass.pass_category === 'EXTERNAL' && 
            latestOutGatePass.gate_pass_type === 'TEMP_OUT' &&
            latestOutGatePass.status === 'ACTIVE') {
            hasActiveExternalOut = true;
        }
        
        // Also check gate passes array for any active TEMP_OUT external gate pass
        if (!hasActiveExternalOut) {
            gatePasses.forEach(function(gp) {
                if (gp.pass_category === 'EXTERNAL' && 
                    gp.gate_pass_type === 'TEMP_OUT' && 
                    gp.status === 'ACTIVE') {
                    hasActiveExternalOut = true;
                    return false; // Break loop
                }
            });
        }
        
        // Auto-select based on latest record
        // If any TEMP_OUT external exists (active), auto-select TEMP_IN, else auto-select TEMP_OUT
        if (hasActiveExternalOut) {
            // Vehicle is OUT (external) -> need TEMP_IN to bring back
            gatePassTypeSelect.val('TEMP_IN').trigger('change');
            wasAutoSelected = true;
        } else {
            // No active external OUT -> vehicle is IN -> can create TEMP_OUT
            gatePassTypeSelect.val('TEMP_OUT').trigger('change');
            wasAutoSelected = true;
        }
        
        // If auto-selected, make field readonly and update location
        if (wasAutoSelected) {
            gatePassTypeSelect.prop('readonly', true).prop('disabled', false).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
            $('#gate_pass_type_hint').show();
            // Update location after gate pass type is selected
            setTimeout(function() {
                updateExternalLocationId();
                // Update transfer purpose required status
                updateTransferPurposeRequired();
            }, 100);
        } else {
            // If not auto-selected, allow manual selection
            gatePassTypeSelect.prop('readonly', false).css('background-color', '').css('cursor', '');
            $('#gate_pass_type_hint').hide();
            // Update transfer purpose required status
            updateTransferPurposeRequired();
        }
    }
    
    // Function to auto-select INTERNAL gate pass type based on vehicle status
    function autoSelectInternalType() {
        var category = $('#pass_category').val();
        if (category !== 'INTERNAL') {
            // Reset readonly state if not INTERNAL
            $('#gate_pass_type').prop('readonly', false).prop('disabled', false).css('background-color', '');
            $('#gate_pass_type_hint').hide();
            return; // Only for INTERNAL category
        }
        
        var status = window.currentGatePassStatus || {};
        var gatePassTypeSelect = $('#gate_pass_type');
        var wasAutoSelected = false;
        
        // Check if MAIN IN exists and MAIN OUT doesn't exist
        if (status.has_in && !status.has_out) {
            // Vehicle is in the system (MAIN IN exists)
            // Determine if vehicle is currently IN or OUT based on temporary gate passes
            
            // Count temporary gate passes (INTERNAL only)
            var tempOutCount = status.temp_out_count || 0;
            var tempInCount = status.temp_in_count || 0;
            
            // If TEMP_OUT count > TEMP_IN count, vehicle is OUT -> need TEMP_IN
            // Otherwise, vehicle is IN -> need TEMP_OUT
            if (tempOutCount > tempInCount) {
                // Vehicle is OUT, auto-select TEMP_IN
                gatePassTypeSelect.val('TEMP_IN').trigger('change');
                wasAutoSelected = true;
            } else {
                // Vehicle is IN, auto-select TEMP_OUT
                gatePassTypeSelect.val('TEMP_OUT').trigger('change');
                wasAutoSelected = true;
            }
        } else if (!status.has_in && !status.has_out) {
            // No MAIN gate passes - default to TEMP_OUT (bringing vehicle in)
            gatePassTypeSelect.val('TEMP_OUT').trigger('change');
            wasAutoSelected = true;
        }
        
        // If auto-selected, make field readonly
        if (wasAutoSelected) {
            gatePassTypeSelect.prop('readonly', true).prop('disabled', false).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
            $('#gate_pass_type_hint').show();
        } else {
            // If not auto-selected (both MAIN IN and OUT exist), allow manual selection
            gatePassTypeSelect.prop('readonly', false).css('background-color', '').css('cursor', '');
            $('#gate_pass_type_hint').hide();
        }
    }
    
    // Initialize location default on page load if MAIN category is pre-selected
    if ($('#pass_category').val() === 'MAIN' && defaultLocationId) {
        $('#location_id').val(defaultLocationId);
    }

    // Initialize Transfer Purpose Select2
    var transferPurposeSelect = $('#external_transfer_purpose');
    
    transferPurposeSelect.select2({
        placeholder: 'Search and select transfer purpose...',
        width: '100%',
        allowClear: true
    });

    // Transfer purpose change handler - show custom input if "Other" is selected
    transferPurposeSelect.on('change', function() {
        if ($(this).val() === 'Other') {
            $('#external_transfer_purpose_custom').show().prop('required', true);
            transferPurposeSelect.prop('required', false);
        } else {
            $('#external_transfer_purpose_custom').hide().prop('required', false);
            transferPurposeSelect.prop('required', true);
        }
    });

    // External Party Type change handler - auto-fill customer details when "Customer" is selected
    $('#external_party_type').on('change', function() {
        var partyType = $(this).val();
        var category = $('#pass_category').val();
        
        // Only auto-fill if EXTERNAL category is selected
        if (category !== 'EXTERNAL') {
            return;
        }
        
        if (partyType === 'Customer' && window.currentCustomerData) {
            // Auto-fill external party information from customer data
            var customerData = window.currentCustomerData;
            var filledFields = [];
            
            if (customerData.name) {
                $('#external_party_name').val(customerData.name).trigger('change');
                filledFields.push('Name');
            }
            
            if (customerData.contact) {
                $('#external_party_contact').val(customerData.contact).trigger('change');
                filledFields.push('Contact');
            }
            
            if (customerData.address) {
                // Build full address including address_2, city, and district if available
                var fullAddress = customerData.address;
                if (customerData.address_2 && customerData.address_2.trim() !== '') {
                    fullAddress += ', ' + customerData.address_2;
                }
                if (customerData.city && customerData.city.trim() !== '') {
                    fullAddress += ', ' + customerData.city;
                }
                if (customerData.district && customerData.district.trim() !== '') {
                    fullAddress += ', ' + customerData.district;
                }
                $('#external_party_address').val(fullAddress).trigger('change');
                filledFields.push('Address');
            }
            
            // Show success message if any fields were filled
            if (filledFields.length > 0) {
                if (typeof success_toastify === 'function') {
                    success_toastify('Customer details auto-filled: ' + filledFields.join(', '));
                } else if (typeof toastify === 'function') {
                    toastify({
                        text: 'Customer details auto-filled: ' + filledFields.join(', '),
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                    }).showToast();
                } else {
                    console.log('Customer details auto-filled: ' + filledFields.join(', '));
                }
            } else {
                // No customer data available
                if (typeof error_toastify === 'function') {
                    error_toastify('Customer data not available for auto-fill.');
                } else {
                    console.warn('Customer data not available for auto-fill.');
                }
            }
        } else if (partyType === 'Customer' && !window.currentCustomerData) {
            // Customer selected but no customer data available
            if (typeof error_toastify === 'function') {
                error_toastify('Customer data not found. Please fill manually.');
            } else {
                console.warn('Customer data not found. Please fill manually.');
            }
        }
        // If partyType is not 'Customer', don't clear fields - allow user to keep data
    });

    // Form submit
    $('#gatePassForm').on('submit', function(e) {
        e.preventDefault();
        generateGatePass();
    });

    function updateGatePassTypeOptions() {
        var category = $('#pass_category').val();
        var status = window.currentGatePassStatus || {};
        var availableTypes = window.availableGatePassTypes || [];
        var options = '<option value="">Select Type</option>';
        
        if (category === 'MAIN') {
            // Check if MAIN OUT exists with completed job and payment - block all gate pass generation
            if (status.is_main_out_completed === true) {
                options += '<option value="IN" disabled>IN (MAIN OUT completed - no further gate passes allowed)</option>';
            } else if (status.has_in && !status.has_out) {
                // Only MAIN IN exists - disable IN option (one-time only)
                options += '<option value="IN" disabled>IN (Already exists - cannot create again)</option>';
            } else if (status.has_in && status.has_out) {
                // Both MAIN IN and OUT exist - allow IN (2) to start new cycle
                if (availableTypes.includes('IN') || availableTypes.includes('IN_1') || availableTypes.includes('IN_2')) {
                    options += '<option value="IN">IN</option>';
                } else {
                    options += '<option value="IN" disabled>IN (Not available - check job card status)</option>';
                }
            } else if (availableTypes.includes('IN') || availableTypes.includes('IN_1') || availableTypes.includes('IN_2')) {
                // IN is available - backend will determine which type (1 or 2) based on conditions
                options += '<option value="IN">IN</option>';
            } else {
                // No IN available
                options += '<option value="IN" disabled>IN (Not available - check job card status)</option>';
            }
            
            // Check OUT - backend will auto-determine type (1, 2, or 3) based on job_progress_status and payment status
            if (status.is_main_out_completed === true) {
                // MAIN OUT exists with completed job and payment - block all gate pass generation
                options += '<option value="OUT" disabled>OUT (MAIN OUT completed - no further gate passes allowed)</option>';
            } else if (status.has_out) {
                // MAIN OUT exists - but if both IN and OUT exist, allow generating new OUT (for new cycle)
                if (status.has_in && status.has_out) {
                    // Both MAIN IN and OUT exist - allow generating new MAIN gate passes
                    if (availableTypes.includes('OUT') || availableTypes.includes('OUT_1') || availableTypes.includes('OUT_2') || availableTypes.includes('OUT_3')) {
                        options += '<option value="OUT">OUT</option>';
                    } else {
                        options += '<option value="OUT" disabled>OUT (Not available - check job card status)</option>';
                    }
                } else {
                    // Only OUT exists - disable OUT option
                    options += '<option value="OUT" disabled>OUT (Already exists - cannot create again)</option>';
                }
            } else if (status.can_generate_main_out === false && !(status.has_in && status.has_out)) {
                // Vehicle is on temporary transfer (OUT) - must return first
                // Exception: If both MAIN IN and OUT exist, allow generating new MAIN gate passes
                options += '<option value="OUT" disabled>OUT (Vehicle is on temporary transfer - create TEMP IN first)</option>';
            } else {
                // Show OUT option - backend will determine which type (1, 2, or 3) based on job status
                // Check if OUT is available (generic 'OUT' type returned by API)
                if (availableTypes.includes('OUT') || availableTypes.includes('OUT_1') || availableTypes.includes('OUT_2') || availableTypes.includes('OUT_3')) {
                    options += '<option value="OUT">OUT</option>';
                } else {
                    options += '<option value="OUT" disabled>OUT (Not available - check job card status)</option>';
                }
            }
        } else if (category === 'INTERNAL') {
            options += '<option value="TEMP_IN">TEMP IN</option>';
            options += '<option value="TEMP_OUT">TEMP OUT</option>';
        } else if (category === 'EXTERNAL') {
            options += '<option value="TEMP_IN">TEMP IN</option>';
            options += '<option value="TEMP_OUT">TEMP OUT</option>';
        }
        
        $('#gate_pass_type').html(options);
        
        // Clear selection if current selection is disabled
        var currentValue = $('#gate_pass_type').val();
        if (currentValue) {
            var selectedOption = $('#gate_pass_type option:selected');
            if (selectedOption.prop('disabled')) {
                $('#gate_pass_type').val('').trigger('change');
            }
        }
    }
    
    // Function to auto-select MAIN gate pass type (IN or OUT) based on availability
    function autoSelectMainType() {
        var category = $('#pass_category').val();
        if (category !== 'MAIN') {
            return; // Only for MAIN category
        }
        
        var status = window.currentGatePassStatus || {};
        var availableTypes = window.availableGatePassTypes || [];
        var gatePassTypeSelect = $('#gate_pass_type');
        
        // Check if gate pass type field is disabled
        if (gatePassTypeSelect.prop('disabled')) {
            return; // Don't auto-select if field is disabled
        }
        
        // When both MAIN IN and MAIN OUT exist, prioritize OUT (since IN was likely just created)
        // Otherwise, prioritize IN first (for initial creation)
        if (status.has_in && status.has_out) {
            // Both exist - prioritize OUT first (typical flow: IN → OUT → IN → OUT)
            if ((availableTypes.includes('OUT') || availableTypes.includes('OUT_1') || availableTypes.includes('OUT_2') || availableTypes.includes('OUT_3'))) {
                var outOption = gatePassTypeSelect.find('option[value="OUT"]');
                if (outOption.length && !outOption.prop('disabled')) {
                    gatePassTypeSelect.val('OUT').trigger('change');
                    return;
                }
            }
            // If OUT not available, try IN
            if ((availableTypes.includes('IN') || availableTypes.includes('IN_1') || availableTypes.includes('IN_2'))) {
                var inOption = gatePassTypeSelect.find('option[value="IN"]');
                if (inOption.length && !inOption.prop('disabled')) {
                    gatePassTypeSelect.val('IN').trigger('change');
                    return;
                }
            }
        } else {
            // Only one or neither exists - prioritize IN first (initial creation)
            if ((availableTypes.includes('IN') || availableTypes.includes('IN_1') || availableTypes.includes('IN_2'))) {
                var inOption = gatePassTypeSelect.find('option[value="IN"]');
                if (inOption.length && !inOption.prop('disabled')) {
                    gatePassTypeSelect.val('IN').trigger('change');
                    return;
                }
            }
            // Then try OUT
            if ((availableTypes.includes('OUT') || availableTypes.includes('OUT_1') || availableTypes.includes('OUT_2') || availableTypes.includes('OUT_3'))) {
                var outOption = gatePassTypeSelect.find('option[value="OUT"]');
                if (outOption.length && !outOption.prop('disabled')) {
                    if (!status.has_out && status.can_generate_main_out !== false) {
                        gatePassTypeSelect.val('OUT').trigger('change');
                        return;
                    }
                }
            }
        }
        
        // If nothing is available, clear selection
        if (!gatePassTypeSelect.val()) {
            gatePassTypeSelect.val('').trigger('change');
        }
    }

    // Function to determine current location based on gate pass tracking
    // Includes INTERNAL, MAIN, and EXTERNAL gate passes to determine current location
    function getCurrentLocationFromTracking() {
        var status = window.currentGatePassStatus || {};
        var gatePasses = status.gate_passes || [];
        
        // Filter INTERNAL, MAIN, and EXTERNAL gate passes, sorted by date (newest first)
        var relevantGatePasses = gatePasses.filter(function(gp) {
            return gp.pass_category === 'INTERNAL' || gp.pass_category === 'MAIN' || gp.pass_category === 'EXTERNAL';
        });
        
        // Sort by created_at (newest first)
        relevantGatePasses.sort(function(a, b) {
            return new Date(b.created_at) - new Date(a.created_at);
        });
        
        // Start with MAIN IN location if it exists
        var mainIn = gatePasses.find(function(gp) {
            return gp.pass_category === 'MAIN' && gp.gate_pass_type === 'IN';
        });
        
        var currentLocationId = null;
        if (mainIn && mainIn.location_id) {
            currentLocationId = mainIn.location_id;
        }
        
        // Track through INTERNAL gate passes to determine current location
        // Process from oldest to newest to track the journey
        var sortedByDate = relevantGatePasses.filter(function(gp) {
            return gp.pass_category === 'INTERNAL';
        }).sort(function(a, b) {
            return new Date(a.created_at) - new Date(b.created_at);
        });
        
        sortedByDate.forEach(function(gp) {
            if (gp.pass_category === 'INTERNAL') {
                if (gp.gate_pass_type === 'TEMP_OUT') {
                    // Vehicle left from_location, so current location is now to_location
                    if (gp.to_location_id) {
                        currentLocationId = gp.to_location_id;
                    }
                } else if (gp.gate_pass_type === 'TEMP_IN') {
                    // Vehicle entered to_location, so current location is to_location
                    if (gp.to_location_id) {
                        currentLocationId = gp.to_location_id;
                    }
                }
            } else if (gp.pass_category === 'EXTERNAL') {
                if (gp.gate_pass_type === 'TEMP_OUT') {
                    // Vehicle went out to external party, current location is the location_id where it left from
                    if (gp.location_id) {
                        currentLocationId = gp.location_id;
                    }
                } else if (gp.gate_pass_type === 'TEMP_IN') {
                    // Vehicle returned from external party, current location is the location_id where it returned to
                    if (gp.location_id) {
                        currentLocationId = gp.location_id;
                    }
                }
            }
        });
        
        return currentLocationId;
    }
    
    // Function to auto-populate From Location based on tracking
    function autoPopulateFromLocation() {
        var category = $('#pass_category').val();
        if (category !== 'INTERNAL') {
            return;
        }
        
        var currentLocationId = getCurrentLocationFromTracking();
        var fromLocationSelect = $('#from_location_id');
        
        if (currentLocationId) {
            // Enable temporarily to set value, then disable again
            fromLocationSelect.prop('disabled', false);
            fromLocationSelect.val(currentLocationId);
            // Make it readonly (disabled) with visual indication
            fromLocationSelect.prop('disabled', true).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
            
            // Filter To Location options after From Location is set
            setTimeout(function() {
                filterToLocationOptions();
            }, 100);
        } else {
            // If no location found, still make it readonly but show message
            fromLocationSelect.prop('disabled', true).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
        }
    }

    function toggleFieldSections() {
        var category = $('#pass_category').val();
        
        if (category === 'INTERNAL') {
            $('#internalFields').show();
            $('#externalFields').hide();
            $('#to_location_id').prop('required', true).prop('disabled', false);
            // From location is readonly and auto-populated based on tracking
            $('#from_location_id').prop('required', true).prop('disabled', true).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
            $('#external_party_name, #external_party_type, #external_transfer_purpose').prop('required', false);
            
            // Make location_id readonly and auto-sync based on gate pass type
            // TEMP_IN: location_id = to_location_id (entering location)
            // TEMP_OUT: location_id = from_location_id (leaving location)
            $('#location_id').prop('readonly', true).prop('disabled', false).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
            // Update location_id with a slight delay to ensure all fields are ready
            setTimeout(function() {
                updateInternalLocationId();
            }, 100);
            
            // Auto-populate From Location based on tracking (readonly)
            autoPopulateFromLocation();
            
            // Filter To Location options to exclude From Location
            setTimeout(function() {
                filterToLocationOptions();
            }, 100);
        } else if (category === 'EXTERNAL') {
            $('#internalFields').hide();
            $('#externalFields').show();
            $('#from_location_id, #to_location_id').prop('required', false);
            $('#external_party_name, #external_party_type').prop('required', true);
            // Transfer purpose required status will be set by updateTransferPurposeRequired() based on gate pass type
            updateTransferPurposeRequired();
            
            // Enable all external party and company/worker information fields
            // Remove both disabled and readonly attributes, and reset styling to make them editable
            var externalFields = '#external_party_name, #external_party_type, #external_transfer_purpose, #external_party_contact, #external_party_address, #expected_return_date, #company_driver_id, #company_driver_name, #company_driver_contact, #company_worker_id, #company_worker_name, #company_worker_contact, #external_transfer_purpose_custom';
            $(externalFields).prop('disabled', false).prop('readonly', false).removeAttr('readonly').css({
                'background-color': '',
                'cursor': '',
                'opacity': '1'
            });
            
            // Make location_id readonly and auto-sync based on gate pass type for EXTERNAL
            // TEMP_IN: location_id = default/production location (vehicle returning)
            // TEMP_OUT: location_id = current location from tracking (vehicle leaving)
            $('#location_id').prop('readonly', true).prop('disabled', false).css('background-color', '#e9ecef').css('cursor', 'not-allowed');
            // Update location_id with a slight delay to ensure all fields are ready
            setTimeout(function() {
                updateExternalLocationId();
            }, 100);
        } else {
            $('#internalFields').hide();
            $('#externalFields').hide();
            $('#from_location_id, #to_location_id').prop('required', false);
            $('#external_party_name, #external_party_type, #external_transfer_purpose').prop('required', false);
            
            // Enable location_id for MAIN or other categories
            $('#location_id').prop('readonly', false).css('background-color', '').css('cursor', '');
            autoSelectedLocationId = null; // Clear auto-selected value
        }
    }

    function loadJobCardInfo(jobCardId) {
        $.ajax({
            url: base_url + "GatePass/getJobCardDetails",
            type: "POST",
            dataType: "json",
            data: {
                job_card_id: jobCardId
            },
            success: function(response) {
                // Handle string response (if double-encoded)
                if (typeof response === 'string') {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.error("Failed to parse response:", e);
                        error_toastify("Invalid response from server");
                        return;
                    }
                }
                console.log("Job Card Response:", response);
                console.log("Response status:", response.status);
                console.log("Response data:", response.data);
                console.log("Response data.main_data:", response.data ? response.data.main_data : 'N/A');
                
                // Handle both boolean true and string "true" for status
                var isSuccess = (response && (response.status === true || response.status === 'true' || response.status === 1) && response.data);
                
                if (isSuccess) {
                    var jobCard = null;
                    
                    // Handle different response structures
                    // API returns: {status: true, data: {main_data: [...], category_menu: [...], ...}}
                    if (response.data.main_data) {
                        if (Array.isArray(response.data.main_data) && response.data.main_data.length > 0) {
                            // API returns job card in data.main_data array
                            jobCard = response.data.main_data[0];
                            console.log("Found job card in main_data[0]:", jobCard);
                        } else if (response.data.main_data && typeof response.data.main_data === 'object' && !Array.isArray(response.data.main_data)) {
                            // If main_data is a single object
                            jobCard = response.data.main_data;
                            console.log("Found job card in main_data (object):", jobCard);
                        }
                    } else if (Array.isArray(response.data) && response.data.length > 0) {
                        // Fallback: if data is directly an array
                        jobCard = response.data[0];
                        console.log("Found job card in data[0]:", jobCard);
                    } else if (response.data && typeof response.data === 'object' && !Array.isArray(response.data)) {
                        // Fallback: if data is directly an object (check if it has job card properties)
                        if (response.data.job_card_number || response.data.job_card_number2 || response.data.idtbl_jobcard) {
                            jobCard = response.data;
                            console.log("Found job card in data (object):", jobCard);
                        }
                    }
                    
                    if (jobCard && (jobCard.job_card_number || jobCard.job_card_number2 || jobCard.idtbl_jobcard)) {
                        // Update job card info display
                        $('#jobCardNumber').text(jobCard.job_card_number2 || jobCard.job_card_number || '-');
                        $('#vehicleNumber').text(jobCard.vehicle_number || '-');
                        
                        // Handle customer - could be object or nested
                        var customerName = '-';
                        var customerData = null;
                        
                        if (jobCard.customer_name) {
                            customerName = jobCard.customer_name;
                            customerData = {
                                name: jobCard.customer_name,
                                contact: jobCard.customer_contact || jobCard.customer_phone || jobCard.customer_mobile_num || jobCard.customer_mobile || jobCard.contact || jobCard.phone || '',
                                address: jobCard.customer_address || jobCard.address || ''
                            };
                        } else if (jobCard.customer) {
                            if (typeof jobCard.customer === 'object') {
                                customerName = jobCard.customer.customer_name || jobCard.customer.name || '-';
                                
                                // Extract customer data with all address fields separately for proper handling
                                customerData = {
                                    name: jobCard.customer.customer_name || jobCard.customer.name || '',
                                    contact: jobCard.customer.customer_mobile_num || jobCard.customer.customer_mobile_num_2 || jobCard.customer.customer_contact || jobCard.customer.contact || jobCard.customer.phone || jobCard.customer.mobile || '',
                                    address: jobCard.customer.address || jobCard.customer.address_line1 || '',
                                    address_2: jobCard.customer.address_2 || '',
                                    city: jobCard.customer.city || '',
                                    district: jobCard.customer.district || ''
                                };
                            } else {
                                customerName = jobCard.customer;
                            }
                        }
                        
                        // Store customer data globally for auto-fill
                        window.currentCustomerData = customerData;
                        $('#customerName').text(customerName);
                        
                        // Update confirmation status
                        var confirmationStatus = jobCard.confirmation_status || '-';
                        $('#jobCardConfirmationStatus').text(confirmationStatus);
                        
                        // Update job status
                        var jobStatus = jobCard.status || '-';
                        var jobProgressStatus = jobCard.job_progress_status;
                        var jobStatusText = jobStatus;
                        if (jobProgressStatus !== undefined && jobProgressStatus !== null) {
                            // job_progress_status: 0=Pending, 1=In Progress, 2=Completed
                            var progressText = '';
                            if (jobProgressStatus == 2) {
                                progressText = '<span class="badge badge-success ml-1">Completed</span>';
                            } else if (jobProgressStatus == 1) {
                                progressText = '<span class="badge badge-warning ml-1">In Progress</span>';
                            } else {
                                progressText = '<span class="badge badge-secondary ml-1">Pending</span>';
                            }
                            jobStatusText = jobStatus + ' ' + progressText;
                        }
                        $('#jobCardJobStatus').html(jobStatusText);
                        
                        // Update payment status (check if payment is completed)
                        // Backend checks: invoice_status == 2 OR payment_status == 1
                        var paymentStatus = 'Pending';
                        var paymentStatusBadge = '';
                        var isPaymentCompleted = false;
                        
                        if (jobCard.invoice_status == 2 || jobCard.payment_status == 1) {
                            paymentStatus = 'Completed';
                            paymentStatusBadge = '<span class="badge badge-success ml-1">Completed</span>';
                            isPaymentCompleted = true;
                        } else if (jobCard.invoice_status !== undefined || jobCard.payment_status !== undefined) {
                            paymentStatus = 'Pending';
                            paymentStatusBadge = '<span class="badge badge-warning ml-1">Pending</span>';
                        } else {
                            paymentStatus = 'Not Set';
                            paymentStatusBadge = '<span class="badge badge-secondary ml-1">Not Set</span>';
                        }
                        $('#jobCardPaymentStatus').html(paymentStatus + ' ' + paymentStatusBadge);
                        
                        // Check MAIN OUT requirements and show warnings
                        checkMainOutRequirements(jobCard);
                        
                        $('#jobCardInfo').show();
                        
                        // Load gate pass status and available types
                        loadGatePassStatus(jobCardId);
                        loadAvailableTypes(jobCardId);
                    } else {
                        console.error("Job card data structure issue:", {
                            jobCard: jobCard,
                            responseData: response.data,
                            mainData: response.data ? response.data.main_data : null
                        });
                        $('#jobCardInfo').hide();
                        error_toastify("Job card data structure is invalid. Check console for details.");
                    }
                } else {
                    console.error("Invalid response structure:", response);
                    $('#jobCardInfo').hide();
                    var errorMsg = "Job card not found";
                    if (response && response.message) {
                        errorMsg = response.message;
                    }
                    error_toastify(errorMsg);
                }
            },
            error: function(xhr) {
                console.error("Error loading job card:", xhr);
                $('#jobCardInfo').hide();
                var errorMsg = "Error loading job card information";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                error_toastify(errorMsg);
            }
        });
    }

    // Function to check MAIN OUT requirements and show warnings
    function checkMainOutRequirements(jobCard) {
        var warnings = [];
        var warningsHtml = '';
        
        // Check confirmation status
        if (jobCard.confirmation_status !== 'Confirmed') {
            warnings.push('Job Card must be Confirmed');
        }
        
        // Check job status (must be Completed)
        var isJobCompleted = false;
        if (jobCard.status === 'Completed' || jobCard.job_progress_status == 2) {
            isJobCompleted = true;
        }
        if (!isJobCompleted) {
            warnings.push('Job Status must be Completed');
        }
        
        // Check payment status (Backend checks: invoice_status == 2 OR payment_status == 1)
        var isPaymentCompleted = false;
        if (jobCard.invoice_status == 2 || jobCard.payment_status == 1) {
            isPaymentCompleted = true;
        }
        if (!isPaymentCompleted) {
            warnings.push('Payment must be Completed');
        }
        
        // Display warnings if any
        if (warnings.length > 0) {
            warningsHtml = '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
            warningsHtml += '<strong><i class="fas fa-exclamation-circle"></i> MAIN OUT Requirements Not Met:</strong><ul class="mb-0 mt-2">';
            warnings.forEach(function(warning) {
                warningsHtml += '<li>' + warning + '</li>';
            });
            warningsHtml += '</ul>';
            warningsHtml += '<small class="text-muted">You cannot generate MAIN OUT gate pass until these requirements are met.</small>';
            warningsHtml += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            warningsHtml += '<span aria-hidden="true">&times;</span></button></div>';
        }
        
        $('#jobCardStatusWarnings').html(warningsHtml);
        if (warnings.length > 0) {
            $('#jobCardStatusWarnings').show();
        } else {
            $('#jobCardStatusWarnings').hide();
        }
    }

    function loadGatePassStatus(jobCardId) {
        $.ajax({
            url: base_url + "GatePass/getJobCardStatus/" + jobCardId,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status && response.data) {
                    var status = response.data;
                    var alertHtml = '';
                    var alertType = 'info';
                    
                    // Check if MAIN OUT exists with completed job and payment - block all gate pass generation
                    if (status.is_main_out_completed === true) {
                        // MAIN OUT exists with completed job and payment - block all gate pass generation
                        alertHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            '<strong><i class="fas fa-ban"></i> Restriction:</strong> ' +
                            'This job card has MAIN OUT with completed job and payment. No further gate passes can be generated for this job card.' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button></div>';
                        alertType = 'danger';
                        
                        // Disable all form sections
                        disableFormSections();
                        $('#pass_category').prop('disabled', true);
                        $('#gate_pass_type').prop('disabled', true);
                    } else if (status.has_in && status.has_out) {
                        // Both MAIN IN and OUT exist - allow generating new MAIN gate passes to start a new cycle
                        // Even if can_generate_main_out is false (temporary OUT), allow new MAIN gate passes
                        if (status.can_generate_main_out === false) {
                            // Vehicle is on temporary transfer, but both MAIN IN and OUT exist
                            alertHtml = '<div class="alert alert-info alert-dismissible fade show" role="alert">' +
                                '<strong><i class="fas fa-info-circle"></i> Status:</strong> ' +
                                'This vehicle has both MAIN IN and MAIN OUT gate passes. ' +
                                'You can generate new MAIN gate passes to start a new cycle, even though the vehicle is currently on temporary transfer.' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                '<span aria-hidden="true">&times;</span></button></div>';
                            alertType = 'info';
                        } else {
                            // Both MAIN IN and OUT exist - allow generating new MAIN gate passes
                            alertHtml = '<div class="alert alert-info alert-dismissible fade show" role="alert">' +
                                '<strong><i class="fas fa-info-circle"></i> Status:</strong> ' +
                                'This vehicle has both MAIN IN and MAIN OUT gate passes. ' +
                                'You can generate new MAIN gate passes to start a new cycle.' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                '<span aria-hidden="true">&times;</span></button></div>';
                            alertType = 'info';
                        }
                        
                        // Don't disable MAIN category - allow generating new MAIN gate passes
                        $('#pass_category option[value="MAIN"]').prop('disabled', false);
                    } else if (status.has_in && !status.has_out) {
                        // Only MAIN IN exists - allow temporary IN/OUT
                        // Check if MAIN OUT is blocked due to temporary OUT
                        if (status.can_generate_main_out === false) {
                            // Vehicle is on temporary transfer - show warning
                            alertHtml = '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                                '<strong><i class="fas fa-exclamation-triangle"></i> Restriction:</strong> ' +
                                'Vehicle is on temporary transfer (OUT). ' +
                                'You must create a temporary IN gate pass first to bring the vehicle back before generating MAIN OUT.' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                '<span aria-hidden="true">&times;</span></button></div>';
                            alertType = 'warning';
                        } else {
                            alertHtml = '<div class="alert alert-info alert-dismissible fade show" role="alert">' +
                                '<strong><i class="fas fa-info-circle"></i> Status:</strong> ' +
                                'This vehicle already has MAIN IN gate pass. ' +
                                'You cannot create another MAIN IN. MAIN OUT and Temporary (Internal/External) gate passes are allowed.' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                '<span aria-hidden="true">&times;</span></button></div>';
                            alertType = 'info';
                        }
                        
                        // Enable Internal/External categories (MAIN IN exists)
                        $('#pass_category option[value="INTERNAL"]').prop('disabled', false);
                        $('#pass_category option[value="EXTERNAL"]').prop('disabled', false);
                        
                        // Disable MAIN IN option (but allow MAIN OUT if not blocked)
                        // This will be handled in updateGatePassTypeOptions
                    } else if (!status.has_in) {
                        // No MAIN IN exists - disable Internal/External categories
                        alertHtml = '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                            '<strong><i class="fas fa-exclamation-triangle"></i> Requirement:</strong> ' +
                            'MAIN IN gate pass must be created first before generating Internal or External gate passes.' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button></div>';
                        alertType = 'warning';
                        
                        // Disable Internal/External categories
                        $('#pass_category option[value="INTERNAL"]').prop('disabled', true);
                        $('#pass_category option[value="EXTERNAL"]').prop('disabled', true);
                        
                        // If Internal or External is currently selected, clear it
                        if ($('#pass_category').val() === 'INTERNAL' || $('#pass_category').val() === 'EXTERNAL') {
                            $('#pass_category').val('').trigger('change');
                        }
                    } else if (!status.has_in && status.has_out) {
                        // Only MAIN OUT exists - restrict MAIN OUT
                        alertHtml = '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                            '<strong><i class="fas fa-exclamation-triangle"></i> Restriction:</strong> ' +
                            'This vehicle already has MAIN OUT gate pass. ' +
                            'You cannot create another MAIN OUT. MAIN IN and Temporary (Internal/External) gate passes are allowed.' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button></div>';
                        alertType = 'warning';
                    } else {
                        // No MAIN gate passes exist - all options available
                        alertHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            '<strong><i class="fas fa-check-circle"></i> Status:</strong> ' +
                            'No MAIN gate passes exist for this job card. All gate pass types are available.' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button></div>';
                        alertType = 'success';
                    }
                    
                    $('#gatePassStatusAlert').html(alertHtml).show();
                    
                    // Store status for use in updateGatePassTypeOptions
                    window.currentGatePassStatus = status;
                    
                    // Update gate pass type options based on status
                    updateGatePassTypeOptions();
                    
                    // Auto-select type based on category
                    var category = $('#pass_category').val();
                    if (category === 'INTERNAL') {
                        autoSelectInternalType();
                        autoPopulateFromLocation();
                    } else if (category === 'EXTERNAL') {
                        autoSelectExternalType();
                    } else if (category === 'MAIN') {
                        autoSelectMainType();
                    }
                    
                    // Auto-trigger external gate pass type if latest OUT is external
                    checkAndAutoTriggerExternalType(status);
                }
            },
            error: function(xhr) {
                console.error("Error loading gate pass status:", xhr);
                // Don't show error to user, just log it
            }
        });
    }

    // Store available types globally
    window.availableGatePassTypes = [];
    
    function loadAvailableTypes(jobCardId) {
        $.ajax({
            url: base_url + "GatePass/getAvailableTypes/" + jobCardId,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status && response.data) {
                    window.availableGatePassTypes = response.data.available_types || [];
                    console.log("Available gate pass types:", window.availableGatePassTypes);
                    console.log("Job card status:", response.data.job_card_status);
                    console.log("Existing gate passes:", response.data.existing_gate_passes);
                    
                    // Check if MAIN OUT is completed - block all gate pass generation
                    if (response.data.is_main_out_completed === true) {
                        // Show danger alert
                        var alertHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            '<strong><i class="fas fa-ban"></i> Restriction:</strong> ' +
                            'This job card has MAIN OUT with completed job and payment. No further gate passes can be generated for this job card.' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button></div>';
                        $('#gatePassStatusAlert').html(alertHtml).show();
                        
                        // Disable all form sections
                        disableFormSections();
                        $('#pass_category').prop('disabled', true);
                        $('#gate_pass_type').prop('disabled', true);
                        
                        // Clear available types
                        window.availableGatePassTypes = [];
                    } else {
                        // Update gate pass type options based on available types
                        updateGatePassTypeOptions();
                        
                        // Auto-select MAIN type if MAIN category is selected
                        // Use setTimeout to ensure options are updated before auto-selection
                        if ($('#pass_category').val() === 'MAIN') {
                            setTimeout(function() {
                                autoSelectMainType();
                            }, 100);
                        }
                    }
                } else {
                    console.error("Failed to load available types:", response);
                    window.availableGatePassTypes = [];
                }
            },
            error: function() {
                console.error("Error loading available types");
                window.availableGatePassTypes = [];
            }
        });
    }

    function generateGatePass() {
        var category = $('#pass_category').val();
        var type = $('#gate_pass_type').val();
        var jobCardId = $('#job_card_id').val(); // Select2 value
        var locationId = $('#location_id').val();
        var status = window.currentGatePassStatus || {};

        if (!category || !type || !jobCardId || !locationId) {
            error_toastify("Please fill all required fields");
            return;
        }

        // Validate job card is selected
        if (!jobCardId) {
            error_toastify("Please select a job card");
            $('#job_card_id').focus();
            return;
        }

        // Backend validation: Check Internal/External require MAIN IN
        if ((category === 'INTERNAL' || category === 'EXTERNAL') && !status.has_in) {
            error_toastify('Cannot generate ' + category + ' gate pass. MAIN IN gate pass must be created first.');
            return;
        }
        
        // Frontend validation: Check latest OUT gate pass for EXTERNAL category
        if (category === 'EXTERNAL') {
            // Use latest_out_gate_pass from backend if available
            var latestOutGatePass = status.latest_out_gate_pass || null;
            var gatePasses = status.gate_passes || [];
            
            // Fallback: Find latest OUT gate pass manually if not provided by backend
            if (!latestOutGatePass) {
                var latestOutDate = null;
                gatePasses.forEach(function(gp) {
                    if (gp.gate_pass_type === 'TEMP_OUT' && gp.status === 'ACTIVE') {
                        var gpDate = new Date(gp.created_at);
                        if (!latestOutDate || gpDate > latestOutDate) {
                            latestOutDate = gpDate;
                            latestOutGatePass = gp;
                        }
                    }
                });
            }
            
            // If MAIN IN exists without MAIN OUT, and latest OUT is external, must create External IN
            if (status.has_in && !status.has_out && latestOutGatePass) {
                if (latestOutGatePass.pass_category === 'EXTERNAL' && type === 'TEMP_OUT') {
                    error_toastify('Cannot generate External OUT. Latest gate pass OUT is External. Please create External IN gate pass first to bring the vehicle back.');
                    return;
                } else if (latestOutGatePass.pass_category === 'INTERNAL' && type === 'TEMP_OUT') {
                    error_toastify('Cannot generate External OUT. Latest gate pass OUT is Internal. Please create Internal IN or External IN gate pass first to bring the vehicle back.');
                    return;
                }
            }
            
            // Validate that if there's an active OUT (internal or external), next must be IN
            var hasActiveOut = false;
            var activeOutCategory = null;
            gatePasses.forEach(function(gp) {
                if (gp.gate_pass_type === 'TEMP_OUT' && gp.status === 'ACTIVE') {
                    hasActiveOut = true;
                    activeOutCategory = gp.pass_category;
                }
            });
            
            if (hasActiveOut && type === 'TEMP_OUT') {
                error_toastify('Cannot generate External OUT. Vehicle is currently OUT (' + activeOutCategory + '). Please create an IN gate pass first to bring the vehicle back.');
                return;
            }
        }

        // Backend validation: Check MAIN IN/OUT restrictions
        if (category === 'MAIN') {
            // Exception: If both MAIN IN and OUT exist, allow generating new MAIN IN (2) to start a new cycle
            // IN (2) is allowed when: hasIn=true, hasOut=true, job not completed OR payment not completed
            if (type === 'IN' && status.has_in && !(status.has_in && status.has_out)) {
                error_toastify("This vehicle already has MAIN IN gate pass. You cannot create another MAIN IN.");
                return;
            }
            // Note: If both MAIN IN and OUT exist, IN (2) is allowed (backend will validate job/payment status)
            // Check if MAIN OUT exists with completed job and payment - block all gate pass generation
            if (status.is_main_out_completed === true) {
                error_toastify("Cannot generate gate pass. This job card has MAIN OUT with completed job and payment. No further gate passes can be generated.");
                return;
            }
            // Check OUT (backend will auto-determine type)
            // Exception: If both MAIN IN and OUT exist, allow generating new MAIN OUT to start a new cycle
            if (type === 'OUT' && status.has_out && !(status.has_in && status.has_out)) {
                error_toastify("This vehicle already has MAIN OUT gate pass. You cannot create another MAIN OUT.");
                return;
            }
            // Check if MAIN OUT is blocked due to temporary OUT
            // Exception: If both MAIN IN and OUT exist, allow generating new MAIN OUT even if temporary OUT exists
            if (type === 'OUT' && status.can_generate_main_out === false && !(status.has_in && status.has_out)) {
                error_toastify("Cannot generate MAIN OUT. Vehicle is currently on temporary transfer (OUT). Please create a temporary IN gate pass first to bring the vehicle back before generating MAIN OUT.");
                return;
            }
            // Note: If both MAIN IN and OUT exist, allow generating new MAIN gate passes to start a new cycle
        }

        // Check if selected option is disabled
        var selectedOption = $('#gate_pass_type option:selected');
        if (selectedOption.prop('disabled')) {
            error_toastify("The selected gate pass type is not available. Please select a different option.");
            return;
        }

        // Check if MAIN category is disabled
        var categoryOption = $('#pass_category option:selected');
        if (categoryOption.prop('disabled')) {
            error_toastify("MAIN category is not available for this job card. Please select Internal or External category.");
            return;
        }

        // Validate transfer purpose for EXTERNAL category - only required for External OUT
        if (category === 'EXTERNAL') {
            var gatePassType = $('#gate_pass_type').val();
            
            // Transfer purpose is required only for External OUT (TEMP_OUT)
            if (gatePassType === 'TEMP_OUT') {
                var transferPurpose = $('#external_transfer_purpose').val();
                if (transferPurpose === 'Other') {
                    transferPurpose = $('#external_transfer_purpose_custom').val();
                    if (!transferPurpose) {
                        error_toastify("Please enter a custom transfer purpose");
                        $('#external_transfer_purpose_custom').focus();
                        return;
                    }
                }
                if (!transferPurpose) {
                    error_toastify("Please select or enter a transfer purpose (Required for External OUT)");
                    $('#external_transfer_purpose').focus();
                    return;
                }
            }
            // For External IN (TEMP_IN), transfer purpose is optional - no validation needed
        }

        var formData = {
            job_card_id: jobCardId,
            location_id: locationId,
            remarks: $('#remarks').val()
        };

        var endpoint = '';
        
        if (category === 'MAIN') {
            if (type === 'IN') {
                // Backend will auto-determine IN type (1 or 2) based on job card status
                endpoint = 'GatePass/generateIn';
            } else if (type === 'OUT') {
                // Backend will auto-determine OUT type (1, 2, or 3) based on job_progress_status and payment status
                endpoint = 'GatePass/generateOut';
            }
        } else if (category === 'INTERNAL') {
            formData.gate_pass_type = type;
            var fromLocationId = $('#from_location_id').val();
            var toLocationId = $('#to_location_id').val();
            
            // Validate that From and To locations are different
            if (fromLocationId && toLocationId && fromLocationId == toLocationId) {
                error_toastify('From Location and To Location cannot be the same. Please select different locations.');
                return;
            }
            
            formData.from_location_id = fromLocationId;
            formData.to_location_id = toLocationId;
            endpoint = 'GatePass/generateInternal';
        } else if (category === 'EXTERNAL') {
            formData.gate_pass_type = type;
            formData.external_party_name = $('#external_party_name').val();
            formData.external_party_type = $('#external_party_type').val();
            formData.external_party_contact = $('#external_party_contact').val();
            formData.external_party_address = $('#external_party_address').val();
            
            // Get transfer purpose - use custom if "Other" is selected
            var transferPurpose = $('#external_transfer_purpose').val();
            if (transferPurpose === 'Other') {
                transferPurpose = $('#external_transfer_purpose_custom').val();
            }
            formData.external_transfer_purpose = transferPurpose;
            
            formData.expected_return_date = $('#expected_return_date').val();
            formData.company_driver_id = $('#company_driver_id').val() || null;
            formData.company_driver_name = $('#company_driver_name').val();
            formData.company_driver_contact = $('#company_driver_contact').val();
            formData.company_worker_id = $('#company_worker_id').val() || null;
            formData.company_worker_name = $('#company_worker_name').val();
            formData.company_worker_contact = $('#company_worker_contact').val();
            
            if (type === 'TEMP_IN') {
                endpoint = 'GatePass/generateExternalIn';
            } else if (type === 'TEMP_OUT') {
                endpoint = 'GatePass/generateExternalOut';
            }
        }

        if (!endpoint) {
            error_toastify("Invalid gate pass type selection");
            return;
        }

        var submitBtn = $('#gatePassForm button[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Generating...');

        $.ajax({
            url: base_url + endpoint,
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("Gate Pass Generation Response:", response);
                
                // Handle string response (if double-encoded)
                if (typeof response === 'string') {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.error("Failed to parse response:", e);
                        error_toastify("Invalid response from server");
                        submitBtn.prop('disabled', false).html('Generate Gate Pass');
                        return;
                    }
                }
                
                if (response && response.status === true) {
                    success_toastify(response.message || "Gate pass generated successfully!");
                    setTimeout(function() {
                        if (response.data && response.data.id) {
                            window.location.href = base_url + 'GatePass/view/' + response.data.id;
                        } else {
                            window.location.href = base_url + 'GatePass';
                        }
                    }, 1500);
                } else {
                    var errorMsg = "Error generating gate pass";
                    if (response && response.message) {
                        errorMsg = response.message;
                    } else if (response && response.errors) {
                        // Handle validation errors
                        var errorList = [];
                        if (typeof response.errors === 'object') {
                            for (var key in response.errors) {
                                if (response.errors.hasOwnProperty(key)) {
                                    if (Array.isArray(response.errors[key])) {
                                        errorList = errorList.concat(response.errors[key]);
                                    } else {
                                        errorList.push(response.errors[key]);
                                    }
                                }
                            }
                        }
                        errorMsg = errorList.length > 0 ? errorList.join(', ') : errorMsg;
                    }
                    error_toastify(errorMsg);
                    submitBtn.prop('disabled', false).html('Generate Gate Pass');
                }
            },
            error: function(xhr, status, error) {
                console.error("Gate Pass Generation Error:", {
                    status: status,
                    error: error,
                    response: xhr.responseText,
                    responseJSON: xhr.responseJSON
                });
                
                var errorMsg = "Error generating gate pass";
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        var errorList = [];
                        for (var key in xhr.responseJSON.errors) {
                            if (xhr.responseJSON.errors.hasOwnProperty(key)) {
                                if (Array.isArray(xhr.responseJSON.errors[key])) {
                                    errorList = errorList.concat(xhr.responseJSON.errors[key]);
                                } else {
                                    errorList.push(xhr.responseJSON.errors[key]);
                                }
                            }
                        }
                        errorMsg = errorList.length > 0 ? errorList.join(', ') : errorMsg;
                    }
                } else if (xhr.responseText) {
                    try {
                        var parsed = JSON.parse(xhr.responseText);
                        if (parsed.message) {
                            errorMsg = parsed.message;
                        }
                    } catch (e) {
                        // If not JSON, use the response text
                        if (xhr.responseText.length < 200) {
                            errorMsg = xhr.responseText;
                        }
                    }
                }
                
                error_toastify(errorMsg);
                submitBtn.prop('disabled', false).html('Generate Gate Pass');
            }
        });
    }

});
</script>

