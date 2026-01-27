<?php include APPPATH . "views/include/header.php"; ?>
<style>
    /* Improve modal layout for multiple payees */
    #addMovementModal .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
    
    #addMovementModal .card {
        margin-bottom: 15px;
    }
    
    #addMovementModal .card-body {
        padding: 15px;
    }
    
    /* Default z-index for Select2 */
    .select2-container {
        z-index: 1000;
    }
    
    /* When modal is open, ensure Select2 dropdowns outside modals stay below modal */
    /* Bootstrap modal backdrop: 1040, modal: 1050 */
    body.modal-open .select2-container {
        z-index: 1030 !important; /* Below modal backdrop (1040) */
    }
    
    /* Ensure Select2 dropdown results outside modals also respect z-index */
    body.modal-open .select2-dropdown {
        z-index: 1030 !important;
    }
    
    /* Higher z-index for Select2 inside modals (needs to be above modal content) */
    /* These more specific selectors must come AFTER the general ones to override them */
    .modal .select2-container,
    .modal .select2-container--open,
    .modal .select2-dropdown {
        z-index: 9999 !important;
    }
    
    /* Even more specific: Select2 inside modals when body has modal-open class */
    body.modal-open .modal .select2-container,
    body.modal-open .modal .select2-dropdown,
    body.modal-open .modal .select2-container--open {
        z-index: 9999 !important;
    }
    
    /* Improve table layout */
    .payee-line-items-table {
        font-size: 13px;
    }
    
    .payee-line-items-table th,
    .payee-line-items-table td {
        padding: 8px;
        vertical-align: middle;
    }
    
    /* Make Select2 search input more visible */
    .select2-search__field {
        width: 100% !important;
        padding: 6px !important;
    }
    
    /* Compact filter area styling */
    #shiftFilter.select2-container,
    #filterSource.select2-container {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single {
        height: 32px !important;
        line-height: 32px !important;
        border: 1px solid #ced4da !important;
        min-height: 32px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 32px !important;
        padding-left: 8px !important;
        padding-right: 20px !important;
        font-size: 0.875rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 30px !important;
        right: 1px !important;
        top: 1px !important;
    }
    #filterMovementType.form-control,
    #filterStatus.form-control,
    #filterDateFrom.form-control,
    #filterDateTo.form-control {
        height: 32px !important;
        line-height: 32px !important;
        font-size: 0.875rem !important;
        padding: 0.25rem 0.5rem !important;
    }
    .card-body label.small {
        font-size: 0.75rem !important;
        margin-bottom: 0 !important;
        white-space: nowrap;
    }
    
    /* Entry Type Radio Button Styling */
    #advance_month_common_group .form-check-input {
        cursor: pointer;
        margin-top: 0.35rem;
    }
    
    #advance_month_common_group .form-check-label {
        cursor: pointer;
        transition: color 0.2s ease;
    }
    
    #advance_month_common_group .form-check-label:hover {
        color: #007bff;
    }
    
    #advance_month_common_group .form-check-input:checked ~ .form-check-label {
        font-weight: 600;
        color: #007bff;
    }
    
    /* Border styling for entry type sections */
    #advance_month_common_group .border {
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    
    #advance_month_common_group .border:hover {
        border-color: #007bff !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
    }
    
    /* Better spacing for entry type section */
    #advance_month_common_group .bg-light {
        background-color: #f8f9fa !important;
    }
    
    /* Icon styling */
    #advance_month_common_group .fas {
        margin-right: 5px;
    }
    
    /* Font weight for labels */
    .font-weight-semibold {
        font-weight: 600;
    }
    
    /* Readonly employee rows styling (for bulk-loaded rows) */
    tr.employee-row-readonly {
        background-color: #f8f9fa;
        opacity: 0.9;
    }
    
    tr.employee-row-readonly td input[readonly],
    tr.employee-row-readonly td select:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
    
    tr.employee-row-readonly .select2-container--disabled {
        opacity: 0.6;
    }
    
    tr.employee-row-readonly .select2-container--disabled .select2-selection {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
</style>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include APPPATH . "views/include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow-sm border-bottom">
                <div class="container-fluid py-3 d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">
                        <i class="fa fa-money-bill-wave mr-2 text-primary"></i>Cash Movements
                    </h1>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addMovementModal">
                        <i class="fas fa-plus mr-2"></i>Add Movement
                    </button>
                </div>
            </div>

            <div class="container-fluid mt-3">
                <div class="card shadow-sm">
                    <div class="card-body py-2">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-md-2 col-sm-4 col-6 mb-2">
                                        <label for="shiftFilter" class="small mb-0 mr-1">Shift:</label>
                                        <select id="shiftFilter" class="form-control form-control-sm select2" style="width: 100% !important;" <?= (isset($active_shift_id) && $active_shift_id) ? 'data-default-shift="' . $active_shift_id . '"' : '' ?>>
                                            <option value="">-- All --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-6 mb-2">
                                        <label for="filterMovementType" class="small mb-0 mr-1">Type:</label>
                                        <select id="filterMovementType" class="form-control form-control-sm" style="height: 32px;">
                                            <option value="">-- All --</option>
                                            <option value="cash_in">Cash In</option>
                                            <option value="cash_out">Cash Out</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-6 mb-2">
                                        <label for="filterSource" class="small mb-0 mr-1">Source:</label>
                                        <select id="filterSource" class="form-control form-control-sm select2" style="width: 100% !important;">
                                            <option value="">-- All --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 col-sm-3 col-6 mb-2">
                                        <label for="filterStatus" class="small mb-0 mr-1">Status:</label>
                                        <select id="filterStatus" class="form-control form-control-sm" style="height: 32px;">
                                            <option value="">-- All --</option>
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="settled">Settled</option>
                                            <option value="cancel">Cancelled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-6 mb-2">
                                        <label for="filterDateFrom" class="small mb-0 mr-1">Date From:</label>
                                        <input type="date" id="filterDateFrom" class="form-control form-control-sm" style="height: 32px;">
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-6 mb-2">
                                        <label for="filterDateTo" class="small mb-0 mr-1">Date To:</label>
                                        <input type="date" id="filterDateTo" class="form-control form-control-sm" style="height: 32px;">
                                    </div>
                                    <div class="col-md-1 col-sm-12 mb-2 text-right">
                                        <button type="button" id="toggleSeries2Btn" class="btn btn-sm btn-secondary mb-1" style="display: none;" title="Hide Series 2" data-toggle="tooltip" data-placement="top">
                                            <i class="fas fa-eye-slash"></i>
                                        </button>
                                        <button type="button" id="clearFiltersBtn" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-times"></i> Clear
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table id="movementsTable" class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Shift ID</th>
                                    <th>Movement Type</th>
                                    <th>Source</th>
                                    <th>Payee</th>
                                    <th>Amount</th>
                                    <th>Payment Type</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Approved By</th>
                                    <th>Remarks</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <!-- Add Movement Modal -->
        <div class="modal fade" id="addMovementModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document" style="max-width: 95%; width: 1400px;">
                <div class="modal-content">
                    <form id="addMovementForm">
                        <input type="hidden" id="movement_id" name="movement_id" value="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMovementModalLabel">Add Cash Movement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Loading indicator -->
                            <div id="modalLoadingIndicator" class="text-center py-5" style="display: none;">
                                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <p class="mt-3 text-muted"><strong>Loading form data...</strong></p>
                                <p class="text-muted small">Please wait while we prepare the form</p>
                            </div>
                            
                            <!-- Form content (hidden while loading) -->
                            <div id="modalFormContent">
                            <!-- Hidden field for current user's active shift -->
                            <input type="hidden" id="cashier_shift_id" name="cashier_shift_id" value="">
                            
                            <!-- Common Fields Section -->
                            <div class="card mb-3">
                                <div class="card-header bg-white border-bottom">
                                    <strong class="text-dark">Common Information</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="movement_type">Movement Type <span class="text-danger">*</span></label>
                                                <select class="form-control" id="movement_type" name="movement_type" required>
                                                    <option value="">Select Type</option>
                                                    <option value="cash_in">Cash In</option>
                                                    <option value="cash_out">Cash Out</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="source">Source <span class="text-danger">*</span></label>
                                                <select class="form-control" id="source" name="source" required>
                                                    <option value="">Select Source</option>
                                                    <!-- Sources will be loaded dynamically from API based on movement type -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="payment_type">Payment Type</label>
                                                <select class="form-control" id="payment_type" name="payment_type">
                                                    <option value="cash">Cash</option>
                                                    <option value="cheque">Cheque</option>
                                                    <option value="transfer">Transfer</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4" id="series_group" style="display: none;">
                                            <div class="form-group">
                                                <label for="series">Series <span class="text-danger">*</span></label>
                                                <select class="form-control" id="series" name="series" required>
                                                    <option value="">Select Series</option>
                                                    <option value="1">Series 1</option>
                                                    <option value="0">Series 2</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Category Section (for Petty Cash only) -->
                            <div class="card mb-3" id="payment_category_section" style="display: none;">
                                <div class="card-header bg-white border-bottom">
                                    <strong class="text-dark">Payment Category</strong>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="payment_category">Payment Category</label>
                                        <div class="input-group">
                                            <select class="form-control select2" id="payment_category" name="payment_category" style="width: 100%;">
                                                <option value="">Select Payment Category (Optional)</option>
                                                <!-- Payment categories will be loaded dynamically from API -->
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-sm btn-success" id="btnAddPaymentCategory" title="Add New Payment Category" data-toggle="tooltip" data-placement="top">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Select a category to use employee-based payment. Leave empty for multiple payees with accounts.</small>
                                    </div>
                                    
                                    <!-- Account Master Selection (for Advance Payment category only) -->
                                    <div class="form-group" id="account_master_group" style="display: none;">
                                        <label for="account_master_id">Account Master <span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="account_master_id" name="account_master_id" style="width: 100%;">
                                            <option value="">Select Account Master</option>
                                           
                                        </select>
                                        <small class="form-text text-muted">Select the account master for this advance payment</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Payees Section for Petty Cash (Multiple Payees & Accounts) -->
                            <div class="card mb-3" id="line_items_section" style="display: none;">
                                <div class="card-header bg-white border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong class="text-dark">Payment Details (Multiple Payees & Accounts)</strong>
                                        <!-- <button type="button" class="btn btn-sm btn-primary" id="btnAddPayee" title="Add New Payee">
                                            <i class="fas fa-plus"></i> Add Payee
                                        </button> -->
                                    </div>
                                </div>
                                <div class="card-body" id="payeesContainer">
                                    <!-- Payees will be added here dynamically -->
                                </div>
                                <div class="card-footer bg-light">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <h5 class="mb-0"><strong>Grand Total: <span id="grandTotal" class="text-primary">0.00</span></strong></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Single Payee Section (for non-petty sources) -->
                            <div class="card mb-3" id="single_payee_section">
                                <div class="card-header bg-white border-bottom">
                                    <strong class="text-dark">Payment Details</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Payee Selection Dropdown (replaces Payee Code and Payee Name) -->
                                            <div class="form-group" id="payee_select_group">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label for="payee_id">Payee <span class="text-danger">*</span></label>
                                                    <button type="button" class="btn btn-sm btn-success" id="btnAddPayee" title="Add New Payee">
                                                        <i class="fas fa-plus"></i> Add Payee
                                                    </button>
                                                </div>
                                                <select class="form-control" id="payee_id" name="payee_id" style="width: 100%;">
                                                    <option value="">Select Payee</option>
                                                </select>
                                                <!-- Hidden fields to store payee_code and payee_name for form submission -->
                                                <input type="hidden" id="payee_code" name="payee_code">
                                                <input type="hidden" id="payee_name" name="payee_name">
                                                <!-- Hidden field for settlement_id when creating petty cash after IOU settlement -->
                                                <input type="hidden" id="iou_settlement_id" name="iou_settlement_id">
                                            </div>
                                            
                                            <!-- GRN Code Table (for supplier source) -->
                                            <div class="form-group" id="grn_code_group" style="display: none;">
                                                <!-- Supplier Selection (Must be selected first) -->
                                                <div class="form-group mb-3">
                                                    <label for="grn_supplier">Select Supplier <span class="text-danger">*</span></label>
                                                    <select class="form-control select2" id="grn_supplier" name="grn_supplier" style="width: 100%;" required>
                                                        <option value="">Search and Select Supplier</option>
                                                    </select>
                                                    <small class="form-text text-muted">Select supplier first to load GRN codes</small>
                                                </div>
                                                
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label class="mb-0">GRN Code(s) & Amounts <span class="text-danger">*</span></label>
                                                    <button type="button" class="btn btn-sm btn-success" id="btnAddGrnRow" title="Add GRN Row" disabled>
                                                        <i class="fas fa-plus"></i> Add GRN
                                                    </button>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm" id="grnAmountsTable" style="margin-bottom: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 25%;">Supplier</th>
                                                                <th style="width: 25%;">GRN Code</th>
                                                                <th style="width: 15%;">Amount</th>
                                                                <th style="width: 25%;">Remark</th>
                                                                <th style="width: 10%;">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="grnAmountsBody">
                                                            <!-- GRN rows will be added here dynamically -->
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td class="text-right" colspan="2"><strong>Total:</strong></td>
                                                                <td class="text-right"><strong id="grnAmountsTotal">0.00</strong></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <small class="form-text text-muted">Select supplier first, then add GRN codes and specify amount for each</small>
                                            </div>
                                            
                                            <!-- Advance Payment Type Selection (Employee/Supplier/Out Source Supplier) -->
                                            <div class="form-group" id="advance_payment_type_group" style="display: none;">
                                                <label>Select Type <span class="text-danger">*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="advance_payment_type" id="advance_type_employee" value="employee" checked>
                                                    <label class="form-check-label" for="advance_type_employee">Employee</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="advance_payment_type" id="advance_type_supplier" value="supplier">
                                                    <label class="form-check-label" for="advance_type_supplier">Supplier</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="advance_payment_type" id="advance_type_outsource_supplier" value="outsource_supplier">
                                                    <label class="form-check-label" for="advance_type_outsource_supplier">Out Source Supplier</label>
                                                </div>
                                            </div>
                                            
                                            <!-- Final Payment Type Selection (Supplier/Out Source Supplier only) -->
                                            <div class="form-group" id="final_payment_type_group" style="display: none;">
                                                <label>Select Type <span class="text-danger">*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="final_payment_type" id="final_type_supplier" value="supplier" checked>
                                                    <label class="form-check-label" for="final_type_supplier">Supplier</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="final_payment_type" id="final_type_outsource_supplier" value="outsource_supplier">
                                                    <label class="form-check-label" for="final_type_outsource_supplier">Out Source Supplier</label>
                                                </div>
                                            </div>
                                            
                                            <!-- Entry Type Selection and Advance Payment Fields (moved from Common Information) -->
                                            <div id="advance_month_common_group" style="display: none;">
                                                <div class="row align-items-start">
                                                    <!-- Entry Type Selection -->
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="font-weight-bold mb-2">
                                                                <i class="fas fa-cog text-primary"></i> Entry Type <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="border rounded p-3 bg-light">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" name="advance_entry_type" id="advance_entry_manual" value="manual" checked>
                                                                    <label class="form-check-label font-weight-normal" for="advance_entry_manual">
                                                                        <i class="fas fa-edit text-info"></i> Manual Entry
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="advance_entry_type" id="advance_entry_automated" value="automated">
                                                                    <label class="form-check-label font-weight-normal" for="advance_entry_automated">
                                                                        <i class="fas fa-sync-alt text-success"></i> Automated Entry
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <small class="form-text text-muted mt-2">
                                                                <i class="fas fa-info-circle"></i> Choose how to enter advance payment details
                                                            </small>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Manual Entry Section -->
                                                    <div class="col-md-9" id="manual_entry_group" style="display: none;">
                                                        <div class="form-group mb-3">
                                                            <label class="font-weight-bold mb-2">
                                                                <i class="fas fa-calendar-alt text-primary"></i> Advance Payment Applicable Year-Month <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="border rounded p-3 bg-light">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label class="small font-weight-semibold mb-1">Year <span class="text-danger">*</span></label>
                                                                        <select class="form-control" id="advance_applicable_year" name="advance_applicable_year">
                                                                            <option value="">Select Year</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="small font-weight-semibold mb-1">Month <span class="text-danger">*</span></label>
                                                                        <select class="form-control" id="advance_applicable_month" name="advance_applicable_month">
                                                                            <option value="">Select Month</option>
                                                                            <option value="1">January</option>
                                                                            <option value="2">February</option>
                                                                            <option value="3">March</option>
                                                                            <option value="4">April</option>
                                                                            <option value="5">May</option>
                                                                            <option value="6">June</option>
                                                                            <option value="7">July</option>
                                                                            <option value="8">August</option>
                                                                            <option value="9">September</option>
                                                                            <option value="10">October</option>
                                                                            <option value="11">November</option>
                                                                            <option value="12">December</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <small class="form-text text-muted mt-2">
                                                                <i class="fas fa-info-circle"></i> Select the year and month for this advance payment
                                                            </small>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Automated Entry Section -->
                                                    <div class="col-md-9" id="automated_entry_group" style="display: none;">
                                                        <div class="form-group mb-3">
                                                            <label class="font-weight-bold mb-2">
                                                                <i class="fas fa-clock text-primary"></i> Pay Cycle & Schedule Groups
                                                            </label>
                                                            <div class="border rounded p-3 bg-light">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label class="small font-weight-semibold mb-1">
                                                                            <i class="fas fa-calendar-week text-info"></i> Pay Cycle <span class="text-danger">*</span>
                                                                        </label>
                                                                        <select class="form-control" id="pay_cycle" name="pay_cycle" style="width: 100%;">
                                                                            <option value="">Select Pay Cycle</option>
                                                                        </select>
                                                                        <small class="form-text text-muted mt-1">Select pay cycle to load pre-configured data</small>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="small font-weight-semibold mb-1">
                                                                            <i class="fas fa-users text-success"></i> Schedule Groups
                                                                        </label>
                                                                        <select class="form-control" id="schedule_groups" name="schedule_groups" style="width: 100%;">
                                                                            <option value="">Select Schedule Groups (Optional)</option>
                                                                        </select>
                                                                        <small class="form-text text-muted mt-1">Optional: Automatically load employees with amounts</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Employee Table -->
                                            <div class="form-group" id="employee_dropdown_group" style="display: none;">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label class="mb-0">Employee(s) & Amounts <span class="text-danger">*</span></label>
                                                    <!-- <button type="button" class="btn btn-sm btn-success" id="btnAddEmployeeRow" title="Add Employee Row">
                                                        <i class="fas fa-plus"></i> Add Employee
                                                    </button> -->
                                                </div>
                                                <!-- Employee Type Selection (Casual/Medical) - Only for Advance Payment -->
                                                <div class="form-group mb-2" id="employee_type_selection_group" style="display: none;">
                                                    <label class="mb-1">Employee Type <span class="text-danger">*</span></label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="employee_type" id="employee_type_casual" value="casual" checked>
                                                        <label class="form-check-label" for="employee_type_casual">Casual</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="employee_type" id="employee_type_medical" value="medical">
                                                        <label class="form-check-label" for="employee_type_medical">Medical</label>
                                                    </div>
                                                    <small class="form-text text-muted d-block">Select the type of advance payment for employees</small>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm" id="employeeAmountsTable" style="margin-bottom: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 25%;">Employee</th>
                                                                <th style="width: 15%;">Amount</th>
                                                                <th style="width: 20%;">Remark</th>
                                                                <th style="width: 15%;" id="employee_type_column_header" style="display: none;">Type</th>
                                                                <th style="width: 10%;" id="employee_mark_column_header" style="display: none;">Mark</th>
                                                                <th style="width: 10%;" id="employee_image_column_header" style="display: none;">Image</th>
                                                                <!-- <th style="width: 10%;" style="display: none;">Actions</th> -->
                                                            </tr>
                                                        </thead>
                                                        <tbody id="employeeAmountsBody">
                                                            <!-- Employee rows will be added here dynamically -->
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td class="text-right" colspan="2"><strong>Total:</strong></td>
                                                                <td class="text-right"><strong id="employeeAmountsTotal">0.00</strong></td>
                                                                <td id="employee_type_total_cell" style="display: none;"></td>
                                                                <td id="employee_mark_total_cell" style="display: none;"></td>
                                                                <td id="employee_image_total_cell" style="display: none;"></td>
                                                                <td></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <small class="form-text text-muted">Add employees and specify amount for each</small>
                                            </div>
                                            
                                            <!-- Supplier Table -->
                                            <div class="form-group" id="supplier_dropdown_group" style="display: none;">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label class="mb-0">Supplier(s) & Amounts <span class="text-danger">*</span></label>
                                                    <button type="button" class="btn btn-sm btn-success" id="btnAddSupplierRow" title="Add Supplier Row">
                                                        <i class="fas fa-plus"></i> Add Supplier
                                                    </button>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm" id="supplierAmountsTable" style="margin-bottom: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 35%;">Supplier</th>
                                                                <th style="width: 25%;">Amount</th>
                                                                <th style="width: 30%;">Remark</th>
                                                                <th style="width: 10%;">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="supplierAmountsBody">
                                                            <!-- Supplier rows will be added here dynamically -->
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td class="text-right" colspan="2"><strong>Total:</strong></td>
                                                                <td class="text-right"><strong id="supplierAmountsTotal">0.00</strong></td>
                                                                <td></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <small class="form-text text-muted">Add suppliers and specify amount for each</small>
                                            </div>
                                            
                                            <!-- Out Source Supplier Section -->
                                            <div class="form-group" id="outsource_supplier_group" style="display: none;">
                                                <div class="card border-primary">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0"><i class="fas fa-briefcase mr-2"></i>Out Source Supplier Job Details</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <!-- Supplier Selection -->
                                                        <div class="form-group">
                                                            <label for="outsource_supplier_select">Select Supplier <span class="text-danger">*</span></label>
                                                            <select class="form-control select2" id="outsource_supplier_select" name="outsource_supplier_id" style="width: 100%;">
                                                                <option value="">Search and Select Supplier</option>
                                                            </select>
                                                            <small class="form-text text-muted">Select supplier to view/create jobs</small>
                                                        </div>
                                                        
                                                        <!-- Job Selection -->
                                                        <div class="form-group">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <label for="outsource_job_select">Select Job <span class="text-danger">*</span></label>
                                                                <button type="button" class="btn btn-sm btn-info" id="btnCreateNewJob" title="Create New Job" disabled>
                                                                    <i class="fas fa-plus-circle mr-1"></i>Create New Job
                                                                </button>
                                                            </div>
                                                            <select class="form-control select2" id="outsource_job_select" name="supplier_job_id" style="width: 100%;" required disabled>
                                                                <option value="">Select Supplier First</option>
                                                            </select>
                                                            <small class="form-text text-muted">Select existing job or create a new one</small>
                                                        </div>
                                                        
                                                        <!-- Advance/Final Date -->
                                                        <div class="form-group">
                                                            <label for="outsource_advance_date"><span id="outsource_date_label">Advance</span> Date <span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control" id="outsource_advance_date" name="outsource_advance_date">
                                                            <small class="form-text text-muted" id="outsource_date_help">Date when the advance payment is applicable</small>
                                                        </div>
                                                        
                                                        <!-- Job Details Display -->
                                                        <div id="job_details_display" style="display: none;">
                                                            <div class="card bg-light">
                                                                <div class="card-body p-3">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <small class="text-muted d-block">Job Value:</small>
                                                                            <strong id="job_value_display">0.00</strong>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <small class="text-muted d-block"><span id="total_advances_label">Total Advances</span>:</small>
                                                                            <strong id="total_advances_display">0.00</strong>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <small class="text-muted d-block">
                                                                                Remaining Balance:
                                                                                <button type="button" class="btn btn-link p-1 ml-2" id="btnViewAdvancePayments" title="View Advance Payment Details" style="display: none;">
                                                                                    <i class="fas fa-list-alt text-primary" style="font-size: 1.2em;"></i>
                                                                                </button>
                                                                            </small>
                                                                            <strong id="remaining_balance_display" class="text-success">0.00</strong>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Advance/Final Amount for Outsource Supplier -->
                                                        <div class="form-group mt-3">
                                                            <label for="outsource_advance_amount"><span id="outsource_amount_label">Advance</span> Amount <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control price-input text-right" id="outsource_advance_amount" name="outsource_advance_amount" placeholder="0.00">
                                                            <small class="form-text text-muted" id="outsource_amount_help">Advance amount for selected job</small>
                                                            <small class="form-text text-danger" id="outsource_amount_error" style="display: none;"></small>
                                                        </div>
                                                        
                                                        <!-- Remarks for Outsource Supplier -->
                                                        <div class="form-group">
                                                            <label for="outsource_remarks">Remarks</label>
                                                            <textarea class="form-control" id="outsource_remarks" name="outsource_remarks" rows="2" placeholder="Enter remarks for this payment"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group" id="main_amount_group">
                                                <label for="amount">Amount <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control price-input text-right" id="amount" name="amount" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Additional Fields -->
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                            </div>
                            </div>
                            <!-- End of modalFormContent -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" title="Cancel" data-toggle="tooltip" data-placement="top"><i class="fas fa-times"></i></button>
                            <button type="submit" class="btn btn-primary" id="btnSubmitMovement" title="Save Movement" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Payee Modal -->
        <div class="modal fade" id="addPayeeModal" tabindex="-1" role="dialog" aria-labelledby="addPayeeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPayeeModalLabel">Add New Payee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addPayeeForm">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="new_payee_name">Payee Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="new_payee_name" name="payee_name" required>
                            </div>
                            <div class="form-group">
                                <label for="new_contact_person">Contact Person</label>
                                <input type="text" class="form-control" id="new_contact_person" name="contact_person">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_contact_phone">Contact Phone</label>
                                        <input type="text" class="form-control" id="new_contact_phone" name="contact_phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_contact_email">Contact Email</label>
                                        <input type="email" class="form-control" id="new_contact_email" name="contact_email">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new_address">Address</label>
                                <textarea class="form-control" id="new_address" name="address" rows="2"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="new_description">Description</label>
                                <textarea class="form-control" id="new_description" name="description" rows="2"></textarea>
                            </div>
                            <small class="form-text text-muted">Payee Code will be auto-generated by the system.</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="btnSavePayee">
                                <i class="fas fa-save"></i> Save Payee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Add Payee Modal -->

        <!-- Create New Supplier Job Modal -->
        <div class="modal fade" id="createSupplierJobModal" tabindex="-1" role="dialog" aria-labelledby="createSupplierJobModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="createSupplierJobModalLabel">
                            <i class="fas fa-plus-circle mr-2"></i>Create New Supplier Job
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="createSupplierJobForm">
                        <div class="modal-body">
                            <input type="hidden" id="new_job_supplier_id" name="supplier_id">
                            
                            <div class="form-group">
                                <label for="new_job_name">Job Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="new_job_name" name="job_name" placeholder="Enter job name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="new_job_description">Job Description</label>
                                <textarea class="form-control" id="new_job_description" name="job_description" rows="3" placeholder="Enter job description"></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_job_value">Job Value <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control price-input text-right" id="new_job_value" name="job_value" placeholder="0.00" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_job_status">Job Status</label>
                                        <select class="form-control" id="new_job_status" name="job_status">
                                            <option value="active" selected>Active</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_job_start_date">Start Date</label>
                                        <input type="date" class="form-control" id="new_job_start_date" name="start_date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_job_expected_completion_date">Expected Completion Date</label>
                                        <input type="date" class="form-control" id="new_job_expected_completion_date" name="expected_completion_date">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="new_job_account_master">Account Master <span class="text-danger">*</span></label>
                                <select class="form-control account-select" id="new_job_account_master" name="account_master_id" style="width: 100%;" required>
                                    <option value="">Select Account Master</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Create Job
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Advance Payments Modal -->
        <div class="modal fade" id="advancePaymentsModal" tabindex="-1" role="dialog" aria-labelledby="advancePaymentsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="advancePaymentsModalLabel">
                            <i class="fas fa-list-alt mr-2"></i>Advance Payment Details
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="advancePaymentsContent">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <p class="mt-2">Loading advance payments...</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Payment Details Modal -->
        <div class="modal fade" id="jobPaymentDetailsModal" tabindex="-1" role="dialog" aria-labelledby="jobPaymentDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="jobPaymentDetailsModalLabel">
                            <i class="fas fa-file-invoice-dollar mr-2"></i>Job-wise Payment Details
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Supplier Selection -->
                        <div class="form-group">
                            <label for="payment_details_supplier">Select Supplier</label>
                            <select class="form-control select2" id="payment_details_supplier" style="width: 100%;">
                                <option value="">Select Supplier</option>
                            </select>
                        </div>
                        
                        <!-- Summary Section -->
                        <div id="payment_details_summary" style="display: none;" class="card bg-light mb-3">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <small class="text-muted d-block">Total Jobs</small>
                                        <h4 id="summary_total_jobs">0</h4>
                                    </div>
                                    <div class="col-md-3">
                                        <small class="text-muted d-block">Total Job Value</small>
                                        <h4 id="summary_total_value">0.00</h4>
                                    </div>
                                    <div class="col-md-3">
                                        <small class="text-muted d-block">Total Advances Paid</small>
                                        <h4 id="summary_total_advances" class="text-warning">0.00</h4>
                                    </div>
                                    <div class="col-md-3">
                                        <small class="text-muted d-block">Total Remaining</small>
                                        <h4 id="summary_total_remaining" class="text-success">0.00</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Jobs List -->
                        <div id="jobs_list_container">
                            <div class="text-center py-5">
                                <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Select a supplier to view job-wise payment details</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Master Selection Modal -->
        <div class="modal fade" id="accountMasterSelectionModal" tabindex="-1" role="dialog" aria-labelledby="accountMasterSelectionModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="accountMasterSelectionModalLabel">Select Account Master</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm" id="accountMasterSelectionTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Account Code</th>
                                        <th>Account Name</th>
                                        <th>Account Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>

<!-- Movement Details Modal -->
<div class="modal fade" id="movementDetailsModal" tabindex="-1" role="dialog" aria-labelledby="movementDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="movementDetailsModalLabel">
                    <i class="fas fa-info-circle mr-2"></i>Cash Movement Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="movementDetailsContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Loading details...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btnApproveFromDetails" style="display: none;" onclick="approveMovementFromDetails()">
                    <i class="fas fa-check mr-2"></i>Approve
                </button>
                <button type="button" class="btn btn-warning" id="btnCancelFromDetails" style="display: none;" onclick="cancelMovementFromDetails()">
                    <i class="fas fa-times mr-2"></i>Cancel Approval
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Reason Modal -->
<div class="modal fade" id="cancelReasonModal" tabindex="-1" role="dialog" aria-labelledby="cancelReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="cancelReasonModalLabel">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Cancel Movement Approval
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Note:</strong> You are about to cancel the approval of this cash movement. Please provide a reason for cancellation.
                </div>
                <form id="cancelReasonForm">
                    <div class="form-group">
                        <label for="cancel_reason" class="font-weight-semibold">
                            Cancel Reason <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            class="form-control" 
                            id="cancel_reason" 
                            name="cancel_reason" 
                            rows="4" 
                            placeholder="Please enter the reason for cancelling this movement approval..."
                            required
                            maxlength="1000"></textarea>
                        <small class="form-text text-muted">
                            <span id="cancel_reason_count">0</span> / 1000 characters
                        </small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Close
                </button>
                <button type="button" class="btn btn-warning" id="btnConfirmCancel" onclick="confirmCancelWithReason()">
                    <i class="fas fa-check mr-2"></i>Confirm Cancellation
                </button>
            </div>
        </div>
    </div>
</div>

<?php include APPPATH . "views/include/footerscripts.php"; ?>
<script>
<?php if (isset($active_shift_id) && $active_shift_id): ?>
var activeShiftId = <?= $active_shift_id ?>;
<?php else: ?>
var activeShiftId = null;
<?php endif; ?>

// Code-level flag to enable/disable readonly shift filter (set to false to allow shift selection changes)
var ENABLE_READONLY_SHIFT_FILTER = true; // Set to false in code to allow changing shift filter

// Background typing detection for "boom" secret code to show/hide Series dropdown (for modal)
var seriesSecretCodeBuffer = '';
var seriesLastKeyTime = 0;
var showSeriesDropdown = false;

// Background typing detection for "boom" secret code to show/hide Series 2 in DataTable
const SERIES_SECRET_CODE = 'boom';
var tableSeriesCodeBuffer = '';
var tableLastKeyTime = 0;
var showSeries2 = false; // Toggle to show both Series 1 and Series 2 in table

// Global function to format number with thousand separators
function formatPriceWithCommas(value) {
    if (!value || value === '') return '';
    // Remove all commas and non-numeric characters except decimal point
    let numValue = value.toString().replace(/[^0-9.]/g, '');
    if (numValue === '' || numValue === '.') return '';
    
    // Split integer and decimal parts
    let parts = numValue.split('.');
    let integerPart = parts[0];
    let decimalPart = parts.length > 1 ? '.' + parts[1].substring(0, 2) : '';
    
    // Add thousand separators to integer part
    if (integerPart && integerPart.length > 0) {
        integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
    
    return integerPart + decimalPart;
}

// Global function to remove commas and get clean numeric value
function getCleanNumericValue(value) {
    if (!value || value === '') return '';
    // Remove all commas and return clean number
    return value.toString().replace(/,/g, '');
}

// Function to initialize price formatting on an input element
function formatPriceInput($input) {
    if (!$input || $input.length === 0) return;
    
    // Get current value and format it
    let currentValue = $input.val();
    if (currentValue && currentValue !== '') {
        let cleanValue = getCleanNumericValue(currentValue);
        if (cleanValue !== '' && !isNaN(cleanValue) && parseFloat(cleanValue) >= 0) {
            $input.val(formatPriceWithCommas(cleanValue));
        }
    }
}

// Function to parse pay cycle and extract year and month
// Expected format: pay cycle value should contain year and month info
// This can be adjusted based on actual pay cycle data structure
function parsePayCycle(payCycleValue) {
    if (!payCycleValue) return null;
    
    // If pay cycle value is an object with year and month properties
    if (typeof payCycleValue === 'object' && payCycleValue.year && payCycleValue.month) {
        return {
            year: payCycleValue.year,
            month: payCycleValue.month
        };
    }
    
    // If pay cycle value is a string in format "YYYY-MM" or similar
    if (typeof payCycleValue === 'string') {
        // Try to extract from option data attributes if using Select2
        let $option = $('#pay_cycle').find('option[value="' + payCycleValue + '"]');
        if ($option.length > 0) {
            let year = $option.data('year') || $option.attr('data-year');
            let month = $option.data('month') || $option.attr('data-month');
            if (year && month) {
                return {
                    year: year,
                    month: month
                };
            }
        }
        
        // Try parsing string format "YYYY-MM"
        let parts = payCycleValue.split('-');
        if (parts.length >= 2) {
            let year = parts[0];
            let month = parts[1];
            if (year && month) {
                return {
                    year: parseInt(year, 10),
                    month: parseInt(month, 10)
                };
            }
        }
    }
    
    return null;
}

// Function to toggle account master field based on source
let payeeIndex = 0;
let lineItemIndex = 0;
let employeeRowIndex = 0;
let employeesPerRow = 3; // Number of employees per row (can be 3 or 4)
let supplierRowIndex = 0;
let grnRowIndex = 0;

function toggleAccountMasterField() {
    let source = $('#source').val();
    
    if (source === 'petty') {
        // Show payment category section for petty cash
        $('#payment_category_section').show();
        $('#amount').prop('required', false);
        
        // Reset and clear all payment detail sections first
        $('#line_items_section').hide();
        $('#single_payee_section').hide();
        $('#employee_dropdown_group').hide();
        $('#supplier_dropdown_group').hide();
        $('#outsource_supplier_group').hide();
        $('#advance_payment_type_group').hide();
        $('#employee_type_selection_group').hide();
        $('#advance_month_common_group').hide();
        $('#schedule_groups_group').hide();
        $('#grn_code_group').hide(); // Hide GRN group for petty cash
        // Remove required from grn_supplier when hidden to avoid validation error
        $('#grn_supplier').prop('required', false);
        $('#grn_supplier').val(''); // Clear value when hidden
        
        // Clear all tables and reset counters
        $('#payeesContainer').empty();
        $('#employeeAmountsBody').empty();
        $('#supplierAmountsBody').empty();
        $('#grnAmountsBody').empty(); // Clear GRN table
        employeeRowIndex = 0;
        supplierRowIndex = 0;
        payeeIndex = 0;
        lineItemIndex = 0;
        grnRowIndex = 0;
        
        // Reset column headers visibility
        $('#employee_type_column_header').hide();
        $('#employee_mark_column_header').hide();
        $('#employee_image_column_header').hide();
        
        // Reset form fields
        $('#payee_id').val(null).trigger('change');
        $('#payee_code').val('');
        $('#payee_name').val('');
        $('#amount').val('');
        $('#pay_cycle').val('').trigger('change');
        $('#pay_cycle').prop('required', false);
        $('#schedule_groups').val('').trigger('change');
        $('#schedule_groups').prop('required', false);
        $('#outsource_advance_date').val('');
        
        // Check if payment category is selected
        let paymentCategory = $('#payment_category').val();
        if (paymentCategory) {
            // Reset category first to clear all sections, then reload with current category
            $('#payment_category').val('').trigger('change');
            // Reload with the category after a short delay to ensure reset is complete
            setTimeout(function() {
                $('#payment_category').val(paymentCategory).trigger('change');
            }, 100);
        } else {
            // No category selected - show multiple payees section by default
            handlePaymentCategoryChange('');
        }
    } else {
        // Hide payment category section for other sources
        $('#payment_category_section').hide();
        $('#line_items_section').hide();
        $('#single_payee_section').show();
        $('#employee_dropdown_group').hide();
        $('#supplier_dropdown_group').hide();
        $('#outsource_supplier_group').hide();
        $('#advance_payment_type_group').hide();
        $('#employee_type_selection_group').hide();
        $('#advance_month_common_group').hide();
        // Remove required from advance month fields for IOU and other non-petty sources
        $('#advance_applicable_year').prop('required', false).removeAttr('required');
        $('#advance_applicable_month').prop('required', false).removeAttr('required');
        $('#pay_cycle').prop('required', false).removeAttr('required');
        $('#schedule_groups').prop('required', false).removeAttr('required');
        // Remove required from outsource supplier fields when hidden (for IOU and other sources)
        $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required');
        $('#outsource_advance_date').prop('required', false).removeAttr('required');
        $('#supplier_job_id').prop('required', false).removeAttr('required');
        $('#amount').prop('required', true);
        
        // Show appropriate fields based on source
        if (source === 'supplier') {
            // For supplier source: Show GRN Code table
            $('#payee_select_group').hide();
            $('#grn_code_group').show();
            // Make grn_supplier required when shown
            $('#grn_supplier').prop('required', true);
            
            // Add default GRN row if table is empty
            if ($('#grnAmountsBody tr').length === 0) {
                addGrnRow();
            }
        } else {
            // For other sources: Show Payee dropdown
            $('#payee_select_group').show();
            $('#grn_code_group').hide();
            // Remove required from grn_supplier when hidden to avoid validation error
            $('#grn_supplier').prop('required', false);
            $('#grn_supplier').val(''); // Clear value when hidden
        }
        
        // Reset column headers visibility
        $('#employee_type_column_header').hide();
        $('#employee_mark_column_header').hide();
        $('#employee_image_column_header').hide();
        
        // Clear all tables and reset counters
        $('#payeesContainer').empty();
        $('#employeeAmountsBody').empty();
        $('#supplierAmountsBody').empty();
        $('#grnAmountsBody').empty();
        employeeRowIndex = 0;
        supplierRowIndex = 0;
        grnRowIndex = 0;
        payeeIndex = 0;
        lineItemIndex = 0;
        
        // Reset payment category (but don't clear payee code and name)
        $('#payment_category').val('').trigger('change');
        
        // Only reset advance month field and amount, keep payee_code and payee_name values
        $('#pay_cycle').val('').trigger('change');
        $('#schedule_groups').val('').trigger('change');
        $('#pay_cycle').prop('required', false);
        $('#schedule_groups').prop('required', false);
        // Hide schedule groups and automated entry (manual entry is default)
        $('#schedule_groups_group').hide();
        $('#automated_entry_group').hide();
        // Don't clear payee_code and payee_name - keep their values
        // $('#payee_code').val(''); // Commented out - keep value
        // $('#payee_name').val(''); // Commented out - keep value
        updateGrandTotal();
    }
}

function handlePaymentCategoryChange(paymentCategory) {
    // Only handle if source is petty
    if ($('#source').val() !== 'petty') {
        return;
    }
    
    // First, hide and reset all sections
    $('#line_items_section').hide();
    $('#single_payee_section').hide();
    $('#employee_dropdown_group').hide();
    $('#supplier_dropdown_group').hide();
    $('#outsource_supplier_group').hide();
    $('#advance_payment_type_group').hide();
    $('#employee_type_selection_group').hide();
    $('#advance_month_common_group').hide();
    $('#schedule_groups_group').hide();
    $('#employee_type_column_header').hide();
    $('#employee_mark_column_header').hide();
    $('#employee_image_column_header').hide();
    
    // Clear all tables
    $('#payeesContainer').empty();
    $('#employeeAmountsBody').empty();
    $('#supplierAmountsBody').empty();
    
    // Reset counters
    employeeRowIndex = 0;
    supplierRowIndex = 0;
    payeeIndex = 0;
    lineItemIndex = 0;
    
    // Reset form fields (only clear payee_code and payee_name if source is petty cash)
    // For other sources, keep payee_code and payee_name values
    if ($('#source').val() === 'petty') {
        $('#payee_code').val('');
        $('#payee_name').val('');
    }
    $('#amount').val('');
    $('#pay_cycle').val('').trigger('change');
    $('#schedule_groups').val('').trigger('change');
    
    if (!paymentCategory) {
        // No category selected - show multiple payees section
        $('#line_items_section').show();
        $('#payee_select_group').hide(); // Hide payee dropdown (using multiple payees with accounts)
        $('#pay_cycle').prop('required', false);
        $('#schedule_groups').prop('required', false);
        // Ensure outsource supplier group is hidden when no category selected
        $('#outsource_supplier_group').hide();
        // Remove required from outsource fields when hidden
        $('#outsource_advance_amount').prop('required', false).removeAttr('required');
        $('#outsource_advance_date').prop('required', false).removeAttr('required');
        $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required');
        // Hide main amount field when using multiple payees (amount comes from line items)
        $('#main_amount_group').hide();
        $('#amount').prop('required', false).removeAttr('required');
        
        // Hide account master field when no category selected
        $('#account_master_group').hide();
        $('#account_master_id').val('');
        $('#account_master_id').prop('required', true);
        $('#account_master_display').val('');
        
        // Reset type options visibility (show all)
        $('#advance_type_employee').closest('.form-check').show();
        $('#advance_type_supplier').closest('.form-check').show();
        $('#advance_type_outsource_supplier').closest('.form-check').show();
        
        // Hide series in common section (series is handled at movement level)
        $('#series_group').hide();
        
        // Add first payee if container is empty
        if ($('#payeesContainer .payee-card').length === 0) {
            addPayee();
        }
        return;
    }
    
    let $categoryOption = $('#payment_category').find('option:selected');
    let categoryText = $categoryOption.length > 0 ? ($categoryOption.text() || '') : '';
    let isFinalPayment = paymentCategory === 'final_payment' || (categoryText && categoryText.toLowerCase().includes('final payment'));
    let requiresEmployee = $categoryOption.data('requires-employee') == 1 || paymentCategory === 'advance_payment' || paymentCategory === 'loan';
    
    if (requiresEmployee || isFinalPayment) {
        // Hide multiple payees section, show single payee with employee/supplier selection
        $('#line_items_section').hide();
        $('#single_payee_section').show();
        $('#payee_select_group').hide(); // Hide payee dropdown (using employee/supplier selection)
        
        // Check if it's advance payment (which has employee/supplier selection), final payment (supplier/outsource only), or loan (employee only)
        let isAdvancePayment = paymentCategory === 'advance_payment';
        let categoryText2 = $categoryOption.length > 0 ? ($categoryOption.text() || '') : '';
        let isFinalPayment = paymentCategory === 'final_payment' || (categoryText2 && categoryText2.toLowerCase().includes('final payment'));
        
        if (isFinalPayment) {
            // Final Payment - only supplier and outsource supplier
            $('#final_payment_type_group').show();
            $('#advance_payment_type_group').hide();
            $('#employee_type_selection_group').hide();
            $('#advance_month_common_group').hide(); // No advance months for final payment
            $('#schedule_groups_group').hide();
            $('#pay_cycle').prop('required', false).removeAttr('required');
            $('#schedule_groups').prop('required', false).removeAttr('required');
            
            // Show supplier/outsource_supplier dropdown based on selection
            let finalType = $('input[name="final_payment_type"]:checked').val();
            if (finalType === 'supplier') {
                $('#supplier_dropdown_group').show();
                $('#employee_dropdown_group').hide();
                $('#outsource_supplier_group').hide();
                $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required'); // Remove required when hiding
                $('#employee_type_column_header').hide();
                // Hide advance month fields for final payment supplier type
                $('#advance_month_common_group').hide();
                $('#schedule_groups_group').hide();
                $('#advance_applicable_year').prop('required', false).removeAttr('required');
                $('#advance_applicable_month').prop('required', false).removeAttr('required');
                $('#pay_cycle').prop('required', false).removeAttr('required');
                $('#schedule_groups').prop('required', false).removeAttr('required');
                // Show main amount field for supplier type
                $('#main_amount_group').show();
                $('#amount').prop('required', true);
            } else if (finalType === 'outsource_supplier') {
                $('#outsource_supplier_group').show();
                $('#outsource_supplier_select, #outsource_supplier_id').prop('required', true); // Add required when showing
                $('#outsource_advance_date').prop('required', true); // Add required when showing
                $('#supplier_job_id').prop('required', true); // Add required when showing
                $('#supplier_dropdown_group').hide();
                $('#employee_dropdown_group').hide();
                $('#employee_type_column_header').hide();
                // Hide main amount field for outsource supplier (they use advance amount in the section instead)
                $('#main_amount_group').hide();
                $('#amount').prop('required', false);
                // Hide advance month fields for final payment outsource supplier
                $('#advance_month_common_group').hide();
                $('#schedule_groups_group').hide();
                $('#advance_applicable_year').prop('required', false).removeAttr('required');
                $('#advance_applicable_month').prop('required', false).removeAttr('required');
                $('#pay_cycle').prop('required', false).removeAttr('required');
                $('#schedule_groups').prop('required', false).removeAttr('required');
                // Set default advance date to today if not set
                if (!$('#outsource_advance_date').val()) {
                    $('#outsource_advance_date').val(new Date().toISOString().split('T')[0]);
                }
                // Load suppliers for outsource supplier
                loadOutsourceSuppliers();
                
                // Update labels for final payment
                updateOutsourceSupplierLabels(true);
            }
            
            // Set default to supplier if not selected
            if (!finalType) {
                $('input[name="final_payment_type"][value="supplier"]').prop('checked', true);
                finalType = 'supplier';
            }
        } else if (isAdvancePayment) {
            // Show advance payment type selection (Employee/Supplier/Out Source Supplier)
            $('#advance_payment_type_group').show();
            // Show all type options for Advance Payment
            $('#advance_type_employee').closest('.form-check').show();
            $('#advance_type_supplier').closest('.form-check').show();
            $('#advance_type_outsource_supplier').closest('.form-check').show();
            
            // Show account master field for Advance Payment
            $('#account_master_group').show();
            
            // Show employee/supplier/outsource_supplier dropdown based on selection
            let advanceType = $('input[name="advance_payment_type"]:checked').val();
            if (advanceType === 'supplier') {
                $('#supplier_dropdown_group').show();
                $('#employee_dropdown_group').hide();
                $('#outsource_supplier_group').hide();
                $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required'); // Remove required when hiding
                $('#employee_type_selection_group').hide();
                $('#employee_type_column_header').hide();
                // Show main amount field for supplier type
                $('#main_amount_group').show();
                $('#amount').prop('required', true);
                // Explicitly remove required from outsource fields when supplier is selected
                $('#outsource_advance_amount').prop('required', false).removeAttr('required');
                $('#outsource_advance_date').prop('required', false).removeAttr('required');
                // Hide and remove required from pay cycle and schedule groups for supplier
                $('#advance_month_common_group').hide();
                $('#schedule_groups_group').hide();
                $('#pay_cycle').prop('required', false).removeAttr('required');
                $('#schedule_groups').prop('required', false).removeAttr('required');
            } else if (advanceType === 'outsource_supplier') {
                $('#outsource_supplier_group').show();
                $('#outsource_supplier_select, #outsource_supplier_id').prop('required', true); // Add required when showing
                $('#outsource_advance_date').prop('required', true); // Add required when showing
                $('#supplier_job_id').prop('required', true); // Add required when showing
                $('#supplier_dropdown_group').hide();
                $('#employee_dropdown_group').hide();
                $('#employee_type_selection_group').hide();
                $('#employee_type_column_header').hide();
                // Hide main amount field for outsource supplier (they use advance amount in the section instead)
                $('#main_amount_group').hide();
                $('#amount').prop('required', false);
                // Hide pay cycle and schedule groups for outsource supplier (they use advance date instead)
                $('#advance_month_common_group').hide();
                $('#schedule_groups_group').hide();
                $('#pay_cycle').prop('required', false).removeAttr('required');
                $('#schedule_groups').prop('required', false).removeAttr('required');
                // Remove required attribute from employee fields to avoid validation errors
                // Remove required attribute from employee fields to avoid validation errors
                // Use both prop and removeAttr to ensure it's completely removed
                $('#employeeAmountsBody .employee-select').prop('required', false).removeAttr('required');
                $('#employeeAmountsBody .employee-amount').prop('required', false).removeAttr('required');
                $('#employeeAmountsBody .employee-type-select').prop('required', false).removeAttr('required');
                // Set default advance date to today if not set
                if (!$('#outsource_advance_date').val()) {
                    $('#outsource_advance_date').val(new Date().toISOString().split('T')[0]);
                }
                // Load suppliers for outsource supplier
                loadOutsourceSuppliers();
                
                // Update labels for advance payment
                updateOutsourceSupplierLabels(false);
            } else {
                $('#employee_dropdown_group').show();
                $('#supplier_dropdown_group').hide();
                $('#outsource_supplier_group').hide();
                // Remove required from outsource supplier fields when employee is selected
                $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required');
                $('#outsource_advance_amount').prop('required', false).removeAttr('required');
                $('#outsource_advance_date').prop('required', false).removeAttr('required');
                // Show main amount field for employee/supplier types
                $('#main_amount_group').show();
                $('#amount').prop('required', true);
                // Restore required attribute for employee fields (for employee and loan types)
                $('#employeeAmountsBody .employee-select').prop('required', true);
                $('#employeeAmountsBody .employee-amount').prop('required', true);
                // Show employee type selection (Casual/Medical) only for advance payment employee
                $('#employee_type_selection_group').show();
                $('#employee_type_column_header').show();
                // Show Entry Type selection and appropriate fields for advance payment employee type
                if (!isFinalPayment && advanceType === 'employee' && (paymentCategory === 'advance_payment' || paymentCategory === 'loan')) {
                    $('#advance_month_common_group').show();
                    
                    // Ensure Manual Entry is selected by default
                    if (!$('input[name="advance_entry_type"]:checked').length) {
                        $('input[name="advance_entry_type"][value="manual"]').prop('checked', true);
                    }
                    
                    // Get selected entry type (default to manual if not set)
                    let entryType = $('input[name="advance_entry_type"]:checked').val() || 'manual';
                    if (typeof handleAdvanceEntryTypeChange === 'function') {
                        handleAdvanceEntryTypeChange(entryType);
                    } else {
                        // Fallback: manually show/hide fields for manual entry (default)
                        $('#manual_entry_group').show();
                        $('#automated_entry_group').hide();
                        $('#schedule_groups_group').hide();
                        $('#advance_applicable_year').prop('required', true);
                        $('#advance_applicable_month').prop('required', true);
                        $('#pay_cycle').prop('required', false).removeAttr('required');
                        $('#schedule_groups').prop('required', false).removeAttr('required');
                    }
                } else {
                    $('#advance_month_common_group').hide();
                    $('#manual_entry_group').hide();
                    $('#automated_entry_group').hide();
                    $('#schedule_groups_group').hide();
                    $('#pay_cycle').prop('required', false).removeAttr('required');
                    $('#schedule_groups').prop('required', false).removeAttr('required');
                    $('#advance_applicable_year').prop('required', false).removeAttr('required');
                    $('#advance_applicable_month').prop('required', false).removeAttr('required');
                }
            }
            
            // Set default to employee if not selected
            if (!advanceType) {
                $('input[name="advance_payment_type"][value="employee"]').prop('checked', true);
                advanceType = 'employee';
            }
        } else {
            // Loan - only show employee, hide supplier selection and employee type selection
            $('#advance_payment_type_group').show(); // Show the type selection group
            // Hide Supplier and Out Source Supplier options for Loan (only show Employee)
            $('#advance_type_supplier').closest('.form-check').hide();
            $('#advance_type_outsource_supplier').closest('.form-check').hide();
            $('#advance_type_employee').closest('.form-check').show();
            // Force Employee selection for Loan
            $('#advance_type_employee').prop('checked', true);
            
            $('#employee_dropdown_group').show();
            $('#supplier_dropdown_group').hide();
            $('#outsource_supplier_group').hide(); // Hide outsource supplier section for loan
            $('#employee_type_selection_group').hide(); // Hide Casual/Medical selection for Loan
            $('#employee_type_column_header').hide(); // Hide Type column header for Loan
            
            // Remove employee type cells from existing rows for Loan
            $('#employeeAmountsBody tr').each(function() {
                $(this).find('.employee-type-select').closest('td').remove();
            });
            
            // Clear supplier table
            $('#supplierAmountsBody').empty();
            supplierRowIndex = 0;
        }
        
        // Series in common section visibility is controlled by boom secret code
        // payee_select_group is already hidden above for employee/supplier-based payments
        
        // Check if outsource_supplier is selected - hide advance month fields if so
        let advanceType = $('input[name="advance_payment_type"]:checked').val();
        if (advanceType === 'outsource_supplier') {
            $('#advance_month_common_group').hide(); // Hide year-month fields for outsource supplier
            $('#schedule_groups_group').hide();
            $('#pay_cycle').prop('required', false).removeAttr('required');
            $('#schedule_groups').prop('required', false).removeAttr('required');
            // Remove required attribute from employee fields to avoid validation errors
            // Remove required attribute from employee fields to avoid validation errors
            // Use both prop and removeAttr to ensure it's completely removed
            $('#employeeAmountsBody .employee-select').prop('required', false).removeAttr('required');
            $('#employeeAmountsBody .employee-amount').prop('required', false).removeAttr('required');
            $('#employeeAmountsBody .employee-type-select').prop('required', false).removeAttr('required');
        } else if (advanceType === 'supplier') {
            // For supplier type, hide advance month fields and schedule groups, make them not required
            $('#advance_month_common_group').hide();
            $('#schedule_groups_group').hide();
            $('#pay_cycle').prop('required', false).removeAttr('required');
            $('#schedule_groups').prop('required', false).removeAttr('required');
            
            // Remove required from outsource fields
            $('#outsource_advance_amount').prop('required', false).removeAttr('required');
            $('#outsource_advance_date').prop('required', false).removeAttr('required');
        } else {
            // For employee type, check if it's final payment - if so, don't require advance month fields
            let paymentCategoryCheck = $('#payment_category').val();
            let $categoryOptionCheck = $('#payment_category').find('option:selected');
            let categoryTextCheck = $categoryOptionCheck.length > 0 ? ($categoryOptionCheck.text() || '') : '';
            let isFinalPaymentCheck = paymentCategoryCheck === 'final_payment' || (categoryTextCheck && categoryTextCheck.toLowerCase().includes('final payment'));
            
            // Only show Pay Cycle and Schedule Groups for advance payment employee type
            let advanceTypeCheck = $('input[name="advance_payment_type"]:checked').val();
            if (!isFinalPaymentCheck && advanceTypeCheck === 'employee' && (paymentCategoryCheck === 'advance_payment' || paymentCategoryCheck === 'loan')) {
                $('#advance_month_common_group').show();
                
                // Get selected entry type (default to manual if not set)
                let entryType = $('input[name="advance_entry_type"]:checked').val() || 'manual';
                if (typeof handleAdvanceEntryTypeChange === 'function') {
                    handleAdvanceEntryTypeChange(entryType);
                } else {
                    // Fallback: show manual entry by default
                    $('#manual_entry_group').show();
                    $('#automated_entry_group').hide();
                    $('#schedule_groups_group').hide();
                }
            } else {
                $('#advance_month_common_group').hide();
                $('#schedule_groups_group').hide();
                $('#pay_cycle').prop('required', false).removeAttr('required');
                $('#schedule_groups').prop('required', false).removeAttr('required');
            }
            
            // Remove required from outsource fields for employee type
            $('#outsource_advance_amount').prop('required', false).removeAttr('required');
            $('#outsource_advance_date').prop('required', false).removeAttr('required');
        }
        
        // Set current year as default if not already set
        if (!$('#advance_applicable_year').val()) {
            let currentYear = new Date().getFullYear();
            $('#advance_applicable_year').val(currentYear);
        }
        
        // Set current month as default if not already set
        if (!$('#advance_applicable_month').val()) {
            let currentMonth = new Date().getMonth() + 1; // getMonth() returns 0-11, so add 1 to get 1-12
            $('#advance_applicable_month').val(currentMonth.toString());
        }
        $('#payee_id').prop('required', false);
        // payee_select_group is already hidden above for employee/supplier-based payments
        // Only clear payee_code and payee_name if source is petty cash (they're already hidden anyway)
        if ($('#source').val() === 'petty') {
            $('#payee_code').val('');
            $('#payee_name').val(''); // Clear payee name
        }
        
        // Auto-fill remarks with category name
        let categoryName = $categoryOption.text();
        $('#remarks').val(categoryName);
        
        // Clear payees
        $('#payeesContainer').empty();
        updateGrandTotal();
        
        // Clear employee/supplier amounts tables and reset counters
        $('#employeeAmountsBody').empty();
        employeeRowIndex = 0;
        
        // Add first row based on category type
        if (isAdvancePayment) {
            let advanceType = $('input[name="advance_payment_type"]:checked').val();
            if (advanceType === 'supplier') {
                addSupplierRow(); // Add first supplier for advance payment
            } else {
                addEmployeeRow(); // Add first employee for advance payment
            }
        } else {
            // Loan - always use employee
            addEmployeeRow(); // Add first employee for loan
        }
    } else {
        // Hide advance month field when category doesn't require employee
        $('#advance_month_common_group').hide();
        $('#schedule_groups_group').hide();
        $('#advance_applicable_year').prop('required', false);
        $('#pay_cycle').prop('required', false);
        $('#schedule_groups').prop('required', false);
        // Category doesn't require employee - use multiple payees
        $('#line_items_section').show();
        $('#single_payee_section').hide();
        $('#payee_code_group').hide();
        $('#employee_dropdown_group').hide();
        
        // Add first payee if container is empty
        if ($('#payeesContainer .payee-card').length === 0) {
            addPayee();
        }
    }
}

// Add a new employee row for advance payment
// Employees are added one by one, 3-4 per row, then new row starts
function addEmployeeRow() {
    employeeRowIndex++;
    let rowId = 'employee_row_' + employeeRowIndex;
    
    // Check if employee type selection should be shown (only for advance_payment)
    let paymentCategory = $('#payment_category').val();
    let isAdvancePayment = paymentCategory === 'advance_payment';
    let selectedEmployeeType = $('input[name="employee_type"]:checked').val() || 'casual';
    
    // Count current employees
    let currentEmployeeCount = $('#employeeAmountsBody .employee-select').length;
    
    // Check if we need a new row (every 3-4 employees)
    let $lastRow = $('#employeeAmountsBody tr:last');
    let employeesInLastRow = $lastRow.length > 0 ? $lastRow.find('.employee-select').length : 0;
    let needsNewRow = $lastRow.length === 0 || employeesInLastRow >= employeesPerRow;
    
    // Build employee type cell (only for advance payment)
    let employeeTypeCell = '';
    let employeeMarkCell = '';
    let employeeImageCell = '';
    
    // Check if employee dropdown group is visible to determine if fields should be required
    let isEmployeeGroupVisible = $('#employee_dropdown_group').is(':visible');
    let requiredAttr = isEmployeeGroupVisible ? 'required' : '';
    
    if (isAdvancePayment) {
        
        // Mark checkbox cell
        employeeMarkCell = `
            <td class="text-center d-none">
                <div class="form-check d-inline-block">
                    <input type="checkbox" 
                           class="form-check-input employee-mark-checkbox" 
                           name="employee_amounts[${employeeRowIndex}][mark]" 
                           id="employee_mark_${employeeRowIndex}"
                           data-row-index="${employeeRowIndex}"
                           value="1"
                           checked> <!-- Checked by default so employees are inserted -->
                    <label class="form-check-label employee-mark-icon" for="employee_mark_${employeeRowIndex}" style="cursor: pointer;">
                        <i class="fas fa-check text-success" id="mark_icon_${employeeRowIndex}"></i>
                    </label>
                </div>
            </td>
        `;
        
        // Image upload cell
        employeeImageCell = `
            <td class="text-center d-none">
                <div class="employee-image-upload-container" data-row-index="${employeeRowIndex}">
                    <input type="file" 
                           class="form-control-file employee-image-input d-none" 
                           name="employee_amounts[${employeeRowIndex}][image]" 
                           id="employee_image_${employeeRowIndex}"
                           accept="image/*"
                           data-row-index="${employeeRowIndex}">
                    <button type="button" 
                            class="btn btn-sm btn-outline-primary btn-upload-image" 
                            data-row-index="${employeeRowIndex}"
                            data-target="employee_image_${employeeRowIndex}"
                            title="Upload Image">
                        <i class="fas fa-upload"></i>
                    </button>
                    <div class="employee-image-preview mt-1" id="image_preview_${employeeRowIndex}" style="display: none;">
                        <img src="" alt="Preview" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-image" data-row-index="${employeeRowIndex}" style="display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <input type="hidden" class="employee-image-url" name="employee_amounts[${employeeRowIndex}][image_url]" id="employee_image_url_${employeeRowIndex}">
                </div>
            </td>
        `;
    }
    
    let employeeRow = `
        <tr data-row-id="${rowId}" data-row-index="${employeeRowIndex}">
            <td>
                <select class="form-control employee-select select2" 
                        name="employee_amounts[${employeeRowIndex}][employee_id]" 
                        data-row-index="${employeeRowIndex}"
                        style="width: 100%;" ${requiredAttr}>
                    <option value="">Search and Select Employee</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control price-input text-right employee-amount" 
                       name="employee_amounts[${employeeRowIndex}][amount]" 
                       data-row-index="${employeeRowIndex}"
                       placeholder="0.00" ${requiredAttr}>
            </td>
            <td>
                <input type="text" class="form-control employee-remark" 
                       name="employee_amounts[${employeeRowIndex}][remark]" 
                       data-row-index="${employeeRowIndex}"
                       placeholder="Enter remark">
            </td>
             <td>
                <select class="form-control employee-type-select" 
                        name="employee_amounts[${employeeRowIndex}][employee_type]" 
                        data-row-index="${employeeRowIndex}"
                        style="width: 100%;" ${requiredAttr}>
                    <option value="casual" ${selectedEmployeeType === 'casual' ? 'selected' : ''}>Casual</option>
                    <option value="medical" ${selectedEmployeeType === 'medical' ? 'selected' : ''}>Medical</option>
                </select>
            </td>
            ${employeeMarkCell}
            ${employeeImageCell}
            <!--<td>
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-employee-row" data-row-id="${rowId}" title="Remove this employee">
                    <i class="fas fa-times"></i>
                </button>
            </td>-->
        </tr>
    `;
    
    if (needsNewRow) {
        // Create new row
        $('#employeeAmountsBody').append(employeeRow);
    } else {
        // This shouldn't happen with current logic, but keep as fallback
        $('#employeeAmountsBody').append(employeeRow);
    }
    
    // Initialize Select2 for the new employee dropdown
    let $select = $(`#employeeAmountsBody tr[data-row-id="${rowId}"] .employee-select`);
    initializeEmployeeSelect2ForRow($select);
    
    // Initialize price formatting
    formatPriceInput($(`#employeeAmountsBody tr[data-row-id="${rowId}"] .employee-amount`));
    
    // Ensure required attributes are correct based on visibility
    // This is critical - remove required if employee dropdown group is hidden
    if (!$('#employee_dropdown_group').is(':visible')) {
        $(`#employeeAmountsBody tr[data-row-id="${rowId}"] .employee-select`).prop('required', false).removeAttr('required');
        $(`#employeeAmountsBody tr[data-row-id="${rowId}"] .employee-amount`).prop('required', false).removeAttr('required');
        $(`#employeeAmountsBody tr[data-row-id="${rowId}"] .employee-type-select`).prop('required', false).removeAttr('required');
    }
    
    // Update total
    updateEmployeeAmountsTotal();
}

// Load employee details from API and populate mark/image
function loadEmployeeDetailsForRow(employeeId, rowIndex) {
    // Make API call to get employee details
    $.ajax({
        url: '<?= base_url("Cashier/CashMovement/getEmployeeDetails") ?>',
        type: 'GET',
        dataType: 'json',
        data: {
            employee_id: employeeId
        },
        success: function(response) {
            if (response.status && response.data) {
                let employeeData = response.data;
                
                // Set mark checkbox if employee has mark data
                if (employeeData.mark !== undefined) {
                    let $markCheckbox = $(`#employee_mark_${rowIndex}`);
                    let $markIcon = $(`#mark_icon_${rowIndex}`);
                    if (employeeData.mark == 1 || employeeData.mark === true) {
                        $markCheckbox.prop('checked', true);
                        $markIcon.removeClass('fa-times text-danger').addClass('fa-check text-success');
                    } else {
                        $markCheckbox.prop('checked', false);
                        $markIcon.removeClass('fa-check text-success').addClass('fa-times text-danger');
                    }
                }
                
                // Load image if employee has image URL
                if (employeeData.image_url) {
                    let $preview = $(`#image_preview_${rowIndex}`);
                    let $img = $preview.find('img');
                    let $imageUrl = $(`#employee_image_url_${rowIndex}`);
                    
                    $img.attr('src', employeeData.image_url);
                    $imageUrl.val(employeeData.image_url);
                    $preview.show();
                    $(`.btn-remove-image[data-row-index="${rowIndex}"]`).show();
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading employee details:', error);
            // Silently fail - user can manually enter data
        }
    });
}

// Handle image file upload
function handleEmployeeImageUpload(input, rowIndex) {
    if (input.files && input.files[0]) {
        let file = input.files[0];
        let maxSize = 5 * 1024 * 1024; // 5MB
        
        if (file.size > maxSize) {
            error_toastify('Image size should be less than 5MB');
            return;
        }
        
        // Validate image type
        if (!file.type.match('image.*')) {
            error_toastify('Please select a valid image file');
            return;
        }
        
        let reader = new FileReader();
        
        reader.onload = function(e) {
            let $preview = $(`#image_preview_${rowIndex}`);
            let $img = $preview.find('img');
            let $removeBtn = $(`.btn-remove-image[data-row-index="${rowIndex}"]`);
            
            $img.attr('src', e.target.result);
            $preview.show();
            $removeBtn.show();
        };
        
        reader.readAsDataURL(file);
        
        // Optionally upload to server immediately
        uploadEmployeeImageToServer(file, rowIndex);
    }
}

// Upload image to server
function uploadEmployeeImageToServer(file, rowIndex) {
    let formData = new FormData();
    formData.append('image', file);
    formData.append('employee_row_index', rowIndex);
    
    $.ajax({
        url: '<?= base_url("Cashier/CashMovement/uploadEmployeeImage") ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.status && response.data && response.data.image_url) {
                $(`#employee_image_url_${rowIndex}`).val(response.data.image_url);
                success_toastify('Image uploaded successfully');
            } else {
                error_toastify(response.message || 'Failed to upload image');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error uploading image:', error);
            error_toastify('Failed to upload image. Please try again.');
        }
    });
}

// Remove employee image
function removeEmployeeImage(rowIndex) {
    $(`#employee_image_${rowIndex}`).val('');
    $(`#employee_image_url_${rowIndex}`).val('');
    $(`#image_preview_${rowIndex}`).hide();
    $(`.btn-remove-image[data-row-index="${rowIndex}"]`).hide();
}

// Remove an employee row
function removeEmployeeRow(button) {
    $(button).closest('tr').remove();
    updateEmployeeAmountsTotal();
}

// Update total for employee amounts
function updateEmployeeAmountsTotal() {
    let total = 0;
    $('#employeeAmountsBody .employee-amount').each(function() {
        let amount = getCleanNumericValue($(this).val());
        if (amount && !isNaN(amount) && parseFloat(amount) >= 0) {
            total += parseFloat(amount);
        }
    });
    $('#employeeAmountsTotal').text(formatPriceWithCommas(total));
    
    // Also update the main amount field
    $('#amount').val(formatPriceWithCommas(total));
}

// Add a new GRN row for supplier source
function addGrnRow() {
    // Get selected supplier
    let selectedSupplierId = $('#grn_supplier').val();
    let selectedSupplierText = $('#grn_supplier option:selected').text();
    
    if (!selectedSupplierId) {
        error_toastify('Please select a supplier first before adding GRN rows.');
        return;
    }
    
    grnRowIndex++;
    let rowId = 'grn_row_' + grnRowIndex;
    
    let grnRow = `
        <tr data-row-id="${rowId}" data-row-index="${grnRowIndex}">
            <td>
                <input type="hidden" class="grn-supplier-id" name="grn_amounts[${grnRowIndex}][supplier_id]" value="${selectedSupplierId}">
                <span class="form-control-plaintext">${selectedSupplierText}</span>
            </td>
            <td>
                <select class="form-control grn-select select2" 
                        name="grn_amounts[${grnRowIndex}][grn_code]" 
                        data-row-index="${grnRowIndex}"
                        data-supplier-id="${selectedSupplierId}"
                        style="width: 100%;" required>
                    <option value="">Search and Select GRN Code</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control price-input text-right grn-amount" 
                       name="grn_amounts[${grnRowIndex}][amount]" 
                       data-row-index="${grnRowIndex}"
                       placeholder="0.00" required>
            </td>
            <td>
                <input type="text" class="form-control grn-remark" 
                       name="grn_amounts[${grnRowIndex}][remark]" 
                       data-row-index="${grnRowIndex}"
                       placeholder="Enter remark">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-grn-row" data-row-id="${rowId}" title="Remove this GRN">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>
    `;
    
    $('#grnAmountsBody').append(grnRow);
    
    // Initialize Select2 for the new GRN dropdown with supplier_id
    let $select = $(`#grnAmountsBody tr[data-row-id="${rowId}"] .grn-select`);
    initializeGrnCodeSelect2ForRow($select, selectedSupplierId);
    
    // Initialize price formatting
    formatPriceInput($(`#grnAmountsBody tr[data-row-id="${rowId}"] .grn-amount`));
    
    // Update total
    updateGrnAmountsTotal();
}

// Remove a GRN row
function removeGrnRow(button) {
    $(button).closest('tr').remove();
    updateGrnAmountsTotal();
}

// Update total for GRN amounts
function updateGrnAmountsTotal() {
    let total = 0;
    $('#grnAmountsBody .grn-amount').each(function() {
        let amount = getCleanNumericValue($(this).val());
        if (amount && !isNaN(amount) && parseFloat(amount) >= 0) {
            total += parseFloat(amount);
        }
    });
    $('#grnAmountsTotal').text(formatPriceWithCommas(total));
    
    // Also update the main amount field
    $('#amount').val(formatPriceWithCommas(total));
}

// Add a new supplier row for advance payment
function addSupplierRow() {
    supplierRowIndex++;
    let rowId = 'supplier_row_' + supplierRowIndex;
    
    let supplierRow = `
        <tr data-row-id="${rowId}" data-row-index="${supplierRowIndex}">
            <td>
                <select class="form-control supplier-select select2" 
                        name="supplier_amounts[${supplierRowIndex}][supplier_id]" 
                        data-row-index="${supplierRowIndex}"
                        style="width: 100%;" required>
                    <option value="">Search and Select Supplier</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control price-input text-right supplier-amount" 
                       name="supplier_amounts[${supplierRowIndex}][amount]" 
                       data-row-index="${supplierRowIndex}"
                       placeholder="0.00" required>
            </td>
            <td>
                <input type="text" class="form-control supplier-remark" 
                       name="supplier_amounts[${supplierRowIndex}][remark]" 
                       data-row-index="${supplierRowIndex}"
                       placeholder="Enter remark">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-supplier-row" data-row-id="${rowId}" title="Remove this supplier">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>
    `;
    
    $('#supplierAmountsBody').append(supplierRow);
    
    // Initialize Select2 for the new supplier dropdown
    let $select = $(`#supplierAmountsBody tr[data-row-id="${rowId}"] .supplier-select`);
    initializeSupplierSelect2ForRow($select);
    
    // Initialize price formatting
    formatPriceInput($(`#supplierAmountsBody tr[data-row-id="${rowId}"] .supplier-amount`));
    
    // Update total
    updateSupplierAmountsTotal();
}

// Remove a supplier row
function removeSupplierRow(button) {
    $(button).closest('tr').remove();
    updateSupplierAmountsTotal();
}

// Update total for supplier amounts
function updateSupplierAmountsTotal() {
    let total = 0;
    $('#supplierAmountsBody .supplier-amount').each(function() {
        let amount = getCleanNumericValue($(this).val());
        if (amount && !isNaN(amount) && parseFloat(amount) >= 0) {
            total += parseFloat(amount);
        }
    });
    $('#supplierAmountsTotal').text(formatPriceWithCommas(total));
    
    // Also update the main amount field
    $('#amount').val(formatPriceWithCommas(total));
}

// Update main amount field based on current payment type and source
function updateMainAmountField() {
    let paymentCategory = $('#payment_category').val();
    let advanceType = $('input[name="advance_payment_type"]:checked').val();
    let sourceValue = $('#source').val();
    
    // For outsource supplier advance payment, use the outsource advance amount
    if (paymentCategory === 'advance_payment' && advanceType === 'outsource_supplier') {
        let advanceAmount = getCleanNumericValue($('#outsource_advance_amount').val());
        if (advanceAmount && !isNaN(advanceAmount) && parseFloat(advanceAmount) >= 0) {
            $('#amount').val(formatPriceWithCommas(advanceAmount));
        } else {
            $('#amount').val('');
        }
        return;
    }
    
    // For supplier source with GRNs, use GRN amounts total
    if (sourceValue === 'supplier') {
        updateGrnAmountsTotal();
        return;
    }
    
    // For advance payment with supplier type, use supplier amounts total
    if (paymentCategory === 'advance_payment' && advanceType === 'supplier') {
        updateSupplierAmountsTotal();
        return;
    }
    
    // For advance payment or loan with employee type, use employee amounts total
    if (paymentCategory === 'advance_payment' || paymentCategory === 'loan') {
        updateEmployeeAmountsTotal();
        return;
    }
    
    // Default: clear amount field (will be set by other logic like payees)
    // Don't clear it here as other handlers might set it
}

// Initialize Select2 for a specific supplier dropdown in a row
function initializeSupplierSelect2ForRow($select) {
    if ($select.hasClass('select2-hidden-accessible')) {
        $select.select2('destroy');
    }
    
    $select.select2({
        ajax: {
            url: '<?= base_url("Cashier/CashMovement/getSuppliers") ?>',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page || 1
                };
            },
            processResults: function(data) {
                // Handle the response format from getSuppliers (Select2 AJAX format)
                if (data.results && Array.isArray(data.results)) {
                    return {
                        results: data.results,
                        pagination: data.pagination || { more: false }
                    };
                }
                return {
                    results: [],
                    pagination: { more: false }
                };
            },
            cache: false
        },
        dropdownParent: $('#addMovementModal'),
        placeholder: 'Search and Select Supplier',
        allowClear: true,
        width: '100%',
        minimumInputLength: 0
    });
}

// Initialize GRN Code Select2 for a specific row
function initializeGrnCodeSelect2ForRow($select, supplierId) {
    if ($select.hasClass('select2-hidden-accessible')) {
        $select.select2('destroy');
    }
    
    // Get supplier_id from data attribute if not provided
    if (!supplierId) {
        supplierId = $select.data('supplier-id');
    }
    
    if (!supplierId) {
        // Fallback: get from main supplier dropdown
        supplierId = $('#grn_supplier').val();
    }
    
    $select.select2({
        ajax: {
            url: '<?= base_url("Cashier/CashMovement/getGrnCodes") ?>',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term || '',
                    supplier_id: supplierId || '',
                    page: params.page || 1
                };
            },
            processResults: function(data) {
                // Handle the response format from getGrnCodes
                if (data.results && Array.isArray(data.results)) {
                    return {
                        results: data.results
                    };
                }
                // Alternative format: {status: true, data: [...]}
                if (data.status === true && data.data && Array.isArray(data.data)) {
                    return {
                        results: data.data
                    };
                }
                return {
                    results: []
                };
            },
            cache: false
        },
        dropdownParent: $('#addMovementModal'),
        placeholder: 'Search and Select GRN Code',
        allowClear: true,
        width: '100%',
        minimumInputLength: 0
    });
}

// Initialize GRN Supplier Select2 dropdown
function initializeGrnSupplierSelect2() {
    let $supplierSelect = $('#grn_supplier');
    
    // Destroy existing Select2 instance if it exists
    if ($supplierSelect.hasClass('select2-hidden-accessible')) {
        $supplierSelect.select2('destroy');
    }
    
    $supplierSelect.select2({
        ajax: {
            url: '<?= base_url("Cashier/CashMovement/getSuppliers") ?>',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term || '',
                    page: params.page || 1
                };
            },
            processResults: function(data) {
                // Handle the response format from getSuppliers (Select2 AJAX format)
                if (data.results && Array.isArray(data.results)) {
                    return {
                        results: data.results,
                        pagination: data.pagination || { more: false }
                    };
                }
                return {
                    results: [],
                    pagination: { more: false }
                };
            },
            cache: false
        },
        dropdownParent: $('#addMovementModal'),
        placeholder: 'Search and Select Supplier',
        allowClear: true,
        width: '100%',
        minimumInputLength: 0
    });
}

// Initialize Select2 for a specific employee dropdown in a row
function initializeEmployeeSelect2ForRow($select) {
    if ($select.hasClass('select2-hidden-accessible')) {
        $select.select2('destroy');
    }
    
    $select.select2({
        ajax: {
            url: '<?= base_url("Cashier/CashMovement/getEmployees") ?>',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term || '',
                    search: params.term || '' // Support both 'term' and 'search' parameters
                };
            },
            processResults: function(data) {
                // Handle new Select2 format (results + pagination)
                if (data.results && Array.isArray(data.results)) {
                    return {
                        results: data.results.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text,
                                emp_code: item.emp_no || '',
                                emp_name: item.emp_name || '',
                                employee_no: item.emp_no || '',
                                emp_etfno: item.emp_etfno || '' // Include emp_etfno for Series determination
                            };
                        }),
                        pagination: data.pagination || { more: false }
                    };
                }
                // Fallback for old format (backward compatibility)
                if (data.status === false || !data.data) {
                    return { results: [] };
                }
                let items = data.data || [];
                return {
                    results: items.map(function(item) {
                        let empNo = item.emp_no || '';
                        let employeeName = item.emp_name || '';
                        let displayText = item.text || (empNo ? (empNo + ' - ' + employeeName) : employeeName);
                        return {
                            id: item.id,
                            text: displayText,
                            emp_code: empNo,
                            emp_name: employeeName,
                            employee_no: empNo,
                            emp_etfno: item.epf_no || item.emp_etfno || '' // Include emp_etfno for Series determination
                        };
                    })
                };
            },
            cache: false
        },
        dropdownParent: $('#addMovementModal'),
        placeholder: 'Search and Select Employee',
        allowClear: true,
        width: '100%'
    });
    
    // Store employee_no and emp_etfno as data attributes when employee is selected
    // Also automatically set Series based on emp_etfno (even if dropdown is hidden)
    $select.on('select2:select', function(e) {
        let data = e.params.data;
        if (data && (data.emp_code || data.employee_no)) {
            let empNo = data.emp_code || data.employee_no;
            let empEtfno = data.emp_etfno || '';
            
            // Store in the option element for easy retrieval
            $(this).find('option:selected').attr('data-employee-no', empNo);
            $(this).find('option:selected').attr('data-emp-etfno', empEtfno);
            
            // Automatically set Series based on emp_etfno (works even if dropdown is hidden)
            // If emp_etfno is empty, null, or 0, set Series to "Series 2" (0)
            // Otherwise, set Series to "Series 1" (1)
            if ($('#series').length > 0) {
                let seriesValue = '1'; // Default to Series 1
                
                // Check if emp_etfno is empty, null, 0, or undefined
                if (!empEtfno || empEtfno === '' || empEtfno === '0' || empEtfno === null || empEtfno === undefined) {
                    seriesValue = '0'; // Series 2
                }
                
                // Set the Series dropdown value (even if hidden, it will be used during form submission)
                $('#series').val(seriesValue).trigger('change');
            }
        }
    });
}

// Initialize Payee dropdown in a specific payee card (for multiple payees section)
function initializePayeeDropdownInCard(payeeId) {
    let $payeeSelect = $(`.payee-card[data-payee-id="${payeeId}"] .payee-select`);
    
    // Destroy Select2 if already initialized
    if ($payeeSelect.hasClass('select2-hidden-accessible')) {
        $payeeSelect.select2('destroy');
    }
    
    $payeeSelect.select2({
        ajax: {
            url: '<?= base_url("Cashier/CashMovement/getPayees") ?>',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term || ''
                };
            },
            processResults: function(data) {
                if (data.status === false || !data.data) {
                    return { results: [] };
                }
                let items = data.data || data.results || [];
                return {
                    results: items.map(function(item) {
                        return {
                            id: item.id,
                            text: item.text || (item.payee_code + ' - ' + item.payee_name),
                            payee_code: item.payee_code,
                            payee_name: item.payee_name
                        };
                    })
                };
            },
            cache: true
        },
        placeholder: 'Select Payee',
        allowClear: true,
        dropdownParent: $('#addMovementModal')
    });
    
    // When payee is selected, update hidden fields in this card
    $payeeSelect.on('select2:select', function(e) {
        let data = e.params.data;
        let $card = $(this).closest('.payee-card');
        $card.find('.payee-code').val(data.payee_code || '');
        $card.find('.payee-name').val(data.payee_name || '');
    });
    
    // When payee is cleared, clear hidden fields in this card
    $payeeSelect.on('select2:clear', function() {
        let $card = $(this).closest('.payee-card');
        $card.find('.payee-code').val('');
        $card.find('.payee-name').val('');
    });
}

// Add a new payee with line items
function addPayee() {
    payeeIndex++;
    let payeeId = 'payee_' + payeeIndex;
    
    let payeeCard = `
        <div class="card mb-3 payee-card" data-payee-index="${payeeIndex}" data-payee-id="${payeeId}">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <strong class="text-dark">Payee ${payeeIndex}</strong>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-payee ml-3" data-payee-id="${payeeId}" title="Remove this payee" data-toggle="tooltip" data-placement="top">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="mb-0">Payee <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-success btn-add-payee-inline" data-payee-id="${payeeId}" title="Add New Payee" data-toggle="tooltip" data-placement="top">
                                    <i class="fas fa-plus"></i> Add Payee
                                </button>
                            </div>
                            <select class="form-control payee-select" name="payees[${payeeIndex}][payee_id]" data-payee-id="${payeeId}" style="width: 100%;" required>
                                <option value="">Select Payee</option>
                            </select>
                            <!-- Hidden fields for payee_code and payee_name -->
                            <input type="hidden" class="payee-code" name="payees[${payeeIndex}][payee_code]" data-payee-id="${payeeId}">
                            <input type="hidden" class="payee-name" name="payees[${payeeIndex}][payee_name]" data-payee-id="${payeeId}">
                        </div>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <button type="button" class="btn btn-sm btn-success btn-add-line-item" data-payee-id="${payeeId}" title="Add another account detail for this payee" data-toggle="tooltip" data-placement="top">
                        <i class="fas fa-plus"></i> Add Account Detail
                    </button>
                </div>
                <div class="table-responsive" style="overflow-x: auto; max-height: 400px; overflow-y: auto;">
                    <table class="table table-bordered table-sm payee-line-items-table" data-payee-id="${payeeId}" style="margin-bottom: 0;">
                        <thead>
                            <tr>
                                <th style="width: 35%; min-width: 250px;">Account</th>
                                <th style="width: 20%; min-width: 150px;">Amount</th>
                                <th style="width: 35%; min-width: 200px;">Memo</th>
                                <th style="width: 10%; min-width: 80px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="payee-line-items-body" data-payee-id="${payeeId}">
                            <!-- Line items will be added here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right"><strong>Subtotal:</strong></td>
                                <td class="text-right"><strong class="payee-subtotal" data-payee-id="${payeeId}">0.00</strong></td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    `;
    
    $('#payeesContainer').append(payeeCard);
    
    // Initialize Select2 for payee dropdown in this card
    initializePayeeDropdownInCard(payeeId);
    
    // Initialize Select2 for account dropdowns in this payee
    initializeAccountSelect2();
    
    // Initialize tooltips for new payee card
    $(`.payee-card[data-payee-id="${payeeId}"] [data-toggle="tooltip"]`).tooltip();
    
    // Add first line item to this payee
    addLineItemToPayee(payeeId);
}

// Add a line item to a specific payee
function addLineItemToPayee(payeeId) {
    lineItemIndex++;
    let $payeeCard = $(`.payee-card[data-payee-id="${payeeId}"]`);
    let payeeIndex = $payeeCard.data('payee-index');
    
    let row = `
        <tr data-line-index="${lineItemIndex}">
            <td>
                <select class="form-control account-select select2" 
                        name="payees[${payeeIndex}][line_items][${lineItemIndex}][account_master_id]" 
                        style="width: 100%;" required>
                    <option value="">Select Account</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control price-input text-right line-amount" 
                       name="payees[${payeeIndex}][line_items][${lineItemIndex}][amount]" 
                       placeholder="0.00" required>
            </td>
            <td>
                <input type="text" class="form-control line-memo" 
                       name="payees[${payeeIndex}][line_items][${lineItemIndex}][memo]" 
                       placeholder="Memo">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-line-item" title="Remove this account detail" data-toggle="tooltip" data-placement="top">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>
    `;
    
    $(`.payee-line-items-body[data-payee-id="${payeeId}"]`).append(row);
    
    // Initialize Select2 for the new account dropdown
    let $select = $(`.payee-line-items-body[data-payee-id="${payeeId}"] tr:last .account-select`);
    initializeAccountSelect2ForElement($select);
    
    // Initialize price formatting
    formatPriceInput($(`.payee-line-items-body[data-payee-id="${payeeId}"] tr:last .line-amount`));
    
    // Initialize tooltips for new buttons
    $(`.payee-line-items-body[data-payee-id="${payeeId}"] tr:last [data-toggle="tooltip"]`).tooltip();
    
    // Update subtotal for this payee
    updatePayeeSubtotal(payeeId);
}

// Remove a payee
function removePayee(button) {
    $(button).closest('.payee-card').remove();
    updateGrandTotal();
    
    // If no payees left and source is petty, add one
    if ($('#source').val() === 'petty' && $('#payeesContainer .payee-card').length === 0) {
        addPayee();
    }
}

// Remove a line item
function removeLineItem(button) {
    let $row = $(button).closest('tr');
    let $payeeCard = $row.closest('.payee-card');
    let payeeId = $payeeCard.data('payee-id');
    
    $row.remove();
    updatePayeeSubtotal(payeeId);
    updateGrandTotal();
}

// Update subtotal for a specific payee
function updatePayeeSubtotal(payeeId) {
    let total = 0;
    $(`.payee-line-items-body[data-payee-id="${payeeId}"] .line-amount`).each(function() {
        let amount = parseFloat($(this).val().toString().replace(/,/g, '')) || 0;
        total += amount;
    });
    $(`.payee-subtotal[data-payee-id="${payeeId}"]`).text(formatPriceWithCommas(total));
    updateGrandTotal();
}

// Update grand total (sum of all payees)
function updateGrandTotal() {
    let grandTotal = 0;
    $('.payee-subtotal').each(function() {
        let subtotal = parseFloat($(this).text().toString().replace(/,/g, '')) || 0;
        grandTotal += subtotal;
    });
    $('#grandTotal').text(formatPriceWithCommas(grandTotal));
}

// Initialize Select2 for account dropdowns
function initializeAccountSelect2() {
    $('.account-select:not(.select2-hidden-accessible)').each(function() {
        initializeAccountSelect2ForElement($(this));
    });
}

// Initialize Select2 for a specific account select element
function initializeAccountSelect2ForElement($select, customDropdownParent) {
    if ($select.hasClass('select2-hidden-accessible')) {
        $select.select2('destroy');
    }
    
    // Find the closest modal parent, or use provided parent, or default to addMovementModal
    let dropdownParent = customDropdownParent;
    if (!dropdownParent) {
        // Try to find the closest modal that contains this select element
        let $closestModal = $select.closest('.modal');
        if ($closestModal.length > 0) {
            dropdownParent = $closestModal;
        } else {
            // Fallback to default modal
            dropdownParent = $('#addMovementModal');
        }
    }
    
    $select.select2({
        ajax: {
            url: apiBaseUrl + '/v1/finance/account_master',
            type: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + api_token
            },
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term || '', // Search term from user input
                    length: -1 // Get all records
                };
            },
            processResults: function(data) {
                if (data.status === false) {
                    return { results: [] };
                }
                let items = data.data || [];
                return {
                    results: items.map(function(item) {
                        return {
                            id: item.id,
                            text: (item.account_code || '') + ' - ' + (item.account_name || ''),
                            account_code: item.account_code,
                            account_name: item.account_name
                        };
                    })
                };
            },
            cache: false // Disable cache for fresh search results
        },
        placeholder: 'Search or Select Account',
        allowClear: true,
        minimumInputLength: 0, // Allow typing/searching from the start
        dropdownParent: dropdownParent, // Ensure dropdown appears inside modal
        language: {
            searching: function() {
                return "Searching accounts...";
            },
            noResults: function() {
                return "No accounts found";
            },
            inputTooShort: function() {
                return "Type to search accounts";
            }
        },
        width: '100%' // Use full width of container
    });
    
    // Ensure search box is enabled and focused when dropdown opens
    $select.on('select2:open', function() {
        // Focus on search input when dropdown opens
        setTimeout(function() {
            $('.select2-search__field').focus().select();
        }, 100);
    });
}

// Initialize Account Master Selection Table
// callback: function to call when account is selected (for line items)
function initializeAccountMasterSelectionTable(callback) {
    if ($.fn.DataTable.isDataTable('#accountMasterSelectionTable')) {
        $('#accountMasterSelectionTable').DataTable().destroy();
    }
    
    // Store callback for later use
    window.accountSelectionCallback = callback || null;

    $('#accountMasterSelectionTable').DataTable({
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
                if (json.status === false) {
                    console.error('Error loading account masters:', json.message);
                    return [];
                }
                return json.data || [];
            }
        },
        columns: [
            { data: 'account_code', title: 'Account Code' },
            { data: 'account_name', title: 'Account Name' },
            { data: 'account_type_name', title: 'Account Type', defaultContent: '-' },
            {
                data: null,
                title: 'Actions',
                orderable: false,
                render: function(data, type, row) {
                    let displayText = (row.account_code || '') + ' - ' + (row.account_name || '');
                    // Store row data in data attribute
                    return '<button class="btn btn-sm btn-primary btn-select-account-from-table" ' +
                           'data-account-id="' + row.id + '" ' +
                           'data-account-code="' + (row.account_code || '') + '" ' +
                           'data-account-name="' + (row.account_name || '') + '">' +
                           '<i class="fas fa-check"></i> Select</button>';
                }
            }
        ],
        order: [[1, 'asc']],
        pageLength: 10
    });
}

// Function to select account master
function selectAccountMaster(id, displayText, rowData) {
    console.log('selectAccountMaster called - ID:', id, 'Display:', displayText);
    
    // If callback exists (for line items), use it
    if (window.accountSelectionCallback && typeof window.accountSelectionCallback === 'function') {
        // Get full account data from row
        let accountData = rowData || { id: id, account_name: displayText };
        window.accountSelectionCallback(accountData);
        window.accountSelectionCallback = null; // Clear callback
        window.currentLineItemRow = null; // Clear stored row
    } else {
        // Default behavior for single account selection
        $('#account_master_id').val(id);
        $('#account_master_display').val(displayText);
    }
    
    $('#accountMasterSelectionModal').modal('hide');
    
    // Verify the value was set (for single account)
    if (!window.accountSelectionCallback) {
        setTimeout(function() {
            let savedId = $('#account_master_id').val();
            console.log('Account Master ID after setting:', savedId, 'Type:', typeof savedId);
        }, 100);
    }
}

// Store original source options for filtering
// Cache for sources and payment categories (must be declared first, before any functions that use them)
let sourcesCache = {};
let paymentCategoriesCache = [];

// Fetch sources from API via controller (global function for access from editMovement)
function fetchSourcesFromAPI(movementType) {
    if (!movementType) {
        return Promise.resolve([]);
    }
    
    // Check cache first
    if (sourcesCache[movementType]) {
        return Promise.resolve(sourcesCache[movementType]);
    }
    
    return $.ajax({
        url: '<?= base_url("Cashier/CashMovement/getSources") ?>',
        method: 'GET',
        data: {
            movement_type: movementType
        }
    }).then(function(response) {
        // Handle both direct response and parsed JSON
        let data = typeof response === 'string' ? JSON.parse(response) : response;
        if (data.status && data.data) {
            sourcesCache[movementType] = data.data;
            return data.data;
        }
        return [];
    }).catch(function(error) {
        console.error('Error fetching sources:', error);
        return [];
    });
}

// Fetch payment categories from API via controller (global function for access from editMovement)
function fetchPaymentCategoriesFromAPI() {
    if (paymentCategoriesCache.length > 0) {
        return Promise.resolve(paymentCategoriesCache);
    }
    
    return $.ajax({
        url: '<?= base_url("Cashier/CashMovement/getPaymentCategories") ?>',
        method: 'GET'
    }).then(function(response) {
        // Handle both direct response and parsed JSON
        let data = typeof response === 'string' ? JSON.parse(response) : response;
        if (data.status && data.data) {
            paymentCategoriesCache = data.data;
            return data.data;
        }
        return [];
    }).catch(function(error) {
        console.error('Error fetching payment categories:', error);
        return [];
    });
}

$(document).ready(function() {
    
    // Initialize tooltips for all buttons
    $('[data-toggle="tooltip"]').tooltip();
    
    // Re-initialize tooltips after DataTable is drawn
    $('#movementsTable').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Toggle account master field when source changes
    $(document).on('change', '#source', function() {
        toggleAccountMasterField();
    });

    // Add payee button
    $(document).on('click', '#btnAddPayee', function(e) {
        e.preventDefault();
        addPayee();
    });
    
    // Remove payee button
    $(document).on('click', '.btn-remove-payee', function(e) {
        e.preventDefault();
        removePayee(this);
    });
    
    // Add line item to payee button
    $(document).on('click', '.btn-add-line-item', function(e) {
        e.preventDefault();
        let payeeId = $(this).data('payee-id');
        addLineItemToPayee(payeeId);
    });
    
    // Remove line item button
    $(document).on('click', '.btn-remove-line-item', function(e) {
        e.preventDefault();
        removeLineItem(this);
    });
    
    // Update subtotal when line item amounts change
    $(document).on('input change blur', '.line-amount', function() {
        let $payeeCard = $(this).closest('.payee-card');
        let payeeId = $payeeCard.data('payee-id') || $payeeCard.find('.payee-line-items-table').data('payee-id');
        updatePayeeSubtotal(payeeId);
    });

    // Open Account Master selection modal (for single account - backward compatibility)
    $(document).on('click', '#btnSelectAccountMaster', function() {
        initializeAccountMasterSelectionTable();
        $('#accountMasterSelectionModal').modal('show');
    });
    
    // Format price inputs with thousand separators on input, paste, and blur
    $(document).on("input paste keyup blur", ".price-input", function(e) {
        let $input = $(this);
        
        // For keyup, skip navigation and modifier keys
        if (e.type === 'keyup') {
            // Skip arrow keys, delete, backspace, tab, shift, ctrl, alt, cmd
            if ([37, 38, 39, 40, 8, 46, 9, 16, 17, 18, 91, 93, 35, 36].includes(e.keyCode)) {
                return;
            }
        }
        
        // Small delay for paste event to capture the pasted value
        setTimeout(function() {
            let currentValue = $input.val();
            let cleanValue = getCleanNumericValue(currentValue);
            
            // Don't format if the value is empty or just a decimal point
            if (cleanValue === '' || cleanValue === '.') {
                return;
            }
            
            // Check if it's a valid number
            if (!isNaN(cleanValue) && parseFloat(cleanValue) >= 0) {
                let formatted = formatPriceWithCommas(cleanValue);
                
                // Only update if the formatted value is different
                if (currentValue !== formatted) {
                    let cursorPos = $input.prop('selectionStart') || 0;
                    let oldLength = currentValue.length;
                    $input.val(formatted);
                    
                    // Try to maintain cursor position intelligently
                    let newLength = formatted.length;
                    let lengthDiff = newLength - oldLength;
                    let newCursorPos = Math.max(0, Math.min(cursorPos + lengthDiff, formatted.length));
                    
                    // Set cursor position
                    if ($input[0].setSelectionRange) {
                        $input[0].setSelectionRange(newCursorPos, newCursorPos);
                    }
                }
            }
        }, e.type === 'paste' ? 10 : 0);
    });
    
    // On focus, remove commas for easier editing
    $(document).on("focus", ".price-input", function() {
        let $input = $(this);
        let value = getCleanNumericValue($input.val());
        if (value !== '' && value !== $input.val()) {
            let cursorPos = $input.prop('selectionStart');
            $input.val(value);
            // Restore cursor position
            $input[0].setSelectionRange(cursorPos, cursorPos);
        }
    });
    
    // Also format when modal is shown (in case value is pre-filled)
    $('#addMovementModal').on('shown.bs.modal', function() {
        $('.price-input').each(function() {
            let $input = $(this);
            let value = getCleanNumericValue($input.val());
            if (value !== '' && !isNaN(value) && parseFloat(value) >= 0) {
                $input.val(formatPriceWithCommas(value));
            }
        });
        
        // Re-initialize Select2 for account dropdowns when modal is shown
        initializeAccountSelect2();
        
        // Initialize tooltips for dynamically added elements
        $('[data-toggle="tooltip"]').tooltip();
    });
    
    // Background typing detection for "boom" secret code (for modal dropdown)
    $(document).on('keypress', function(e) {
        // Ignore if typing in an input field or textarea
        if ($(e.target).is('input, textarea, select')) {
            return;
        }
        
        var now = Date.now();
        
        // Handle modal series dropdown toggle
        if (now - seriesLastKeyTime > 2000) {
            seriesSecretCodeBuffer = '';
        }
        seriesLastKeyTime = now;
        
        seriesSecretCodeBuffer += String.fromCharCode(e.which).toLowerCase();
        if (seriesSecretCodeBuffer.length > 4) {
            seriesSecretCodeBuffer = seriesSecretCodeBuffer.slice(-4);
        }
        
        if (seriesSecretCodeBuffer === 'boom') {
            // Toggle series dropdown visibility in modal
            showSeriesDropdown = !showSeriesDropdown;
            
            if (showSeriesDropdown) {
                $('#series_group').slideDown(200);
            } else {
                $('#series_group').slideUp(200);
                $('#series').val(''); // Reset to empty when hiding
            }
            
            seriesSecretCodeBuffer = '';
            seriesLastKeyTime = 0;
        }
        
        // Handle DataTable Series 2 toggle
        if (now - tableLastKeyTime > 2000) {
            tableSeriesCodeBuffer = '';
        }
        tableLastKeyTime = now;
        
        tableSeriesCodeBuffer += String.fromCharCode(e.which).toLowerCase();
        if (tableSeriesCodeBuffer.length > SERIES_SECRET_CODE.length) {
            tableSeriesCodeBuffer = tableSeriesCodeBuffer.slice(-SERIES_SECRET_CODE.length);
        }
        
        if (tableSeriesCodeBuffer === SERIES_SECRET_CODE) {
            // Toggle Series 2 visibility in DataTable
            showSeries2 = !showSeries2;
            
            if (showSeries2) {
                $('#toggleSeries2Btn').show();
            } else {
                $('#toggleSeries2Btn').hide();
            }
            
            // Reload table with new filter
            if ($.fn.DataTable.isDataTable('#movementsTable')) {
                $('#movementsTable').DataTable().ajax.reload();
            } else {
                loadCashMovements();
            }
            
            tableSeriesCodeBuffer = '';
            tableLastKeyTime = 0;
        }
    });
    
    // Toggle Series 2 button click handler
    $('#toggleSeries2Btn').on('click', function() {
        showSeries2 = false;
        $('#toggleSeries2Btn').hide();
        
        // Reload table to show only Series 1
        if ($.fn.DataTable.isDataTable('#movementsTable')) {
            $('#movementsTable').DataTable().ajax.reload();
        } else {
            loadCashMovements();
        }
    });
    
    // Initialize year dropdown for advance applicable month
    function initializeAdvanceYearDropdown() {
        let $yearSelect = $('#advance_applicable_year');
        $yearSelect.empty();
        $yearSelect.append('<option value="">Select Year</option>');
        
        let currentYear = new Date().getFullYear();
        // Add years from 5 years ago to 5 years ahead
        for (let year = currentYear - 5; year <= currentYear + 5; year++) {
            let $option = $(`<option value="${year}">${year}</option>`);
            // Set current year as selected by default
            if (year === currentYear) {
                $option.prop('selected', true);
            }
            $yearSelect.append($option);
        }
        
        // Set current year as default value
        $yearSelect.val(currentYear);
    }
    
    // Initialize on page load
    initializeAdvanceYearDropdown();
    
    // Load payment categories on page load
    fetchPaymentCategoriesFromAPI().then(function(categories) {
        // Populate payment category dropdown if needed
        let $categorySelect = $('#payment_category');
        if ($categorySelect.length && $categorySelect.find('option').length <= 1) {
            categories.forEach(function(category) {
                $categorySelect.append(`<option value="${category.code}" data-requires-employee="${category.requires_employee}" data-requires-supplier="${category.requires_supplier}">${category.name}</option>`);
            });
        }
    });
    
    // Load and set active shift when modal opens (only for new records, not edit)
    $('#addMovementModal').on('show.bs.modal', function(e) {
        // Only reset if not in edit mode (movement_id is empty)
        if (!$('#movement_id').val()) {
            // Reset modal title and button text for new record
            $('#addMovementModalLabel').text('Add Cash Movement');
            $('#btnSubmitText').text('Save Movement');
            $('#btnSubmitMovement').attr('title', 'Save Movement');
            $('#modalLoadingIndicator').hide();
            $('#modalFormContent').show();
            $('#btnSubmitMovement').prop('disabled', false).html('<i class="fas fa-save"></i>');
            
            // Check for URL parameters to pre-fill form (e.g., from IOU expense_claim settlement)
            const urlParams = new URLSearchParams(window.location.search);
            const movementTypeParam = urlParams.get('movement_type');
            const sourceParam = urlParams.get('source');
            const payeeCodeParam = urlParams.get('payee_code');
            const payeeNameParam = urlParams.get('payee_name');
            const settlementIdParam = urlParams.get('settlement_id');
            const remarksParam = urlParams.get('remarks');
            
            if (movementTypeParam && sourceParam) {
                // Show loading spinner and hide form content while loading data
                $('#modalLoadingIndicator').show();
                $('#modalFormContent').hide();
                $('#btnSubmitMovement').prop('disabled', true);
                
                // Step 1: Load sources from API first (will cache them)
                // This ensures sources are available before we try to set the source value
                fetchSourcesFromAPI(movementTypeParam).then(function(sources) {
                    // Step 2: Set movement_type value (don't trigger change yet to avoid duplicate API call)
                    $('#movement_type').val(movementTypeParam);
                    
                    // Step 3: Manually populate source dropdown using cached sources
                    // This avoids triggering the change event which would call filterSourceOptions again
                    let $sourceSelect = $('#source');
                    $sourceSelect.empty();
                    $sourceSelect.append('<option value="">Select Source</option>');
                    
                    sources.forEach(function(source) {
                        if (!source.id) return;
                        let sourceIdInt = parseInt(source.id, 10);
                        if (isNaN(sourceIdInt)) return;
                        
                        let $newOption = $('<option>', {
                            value: source.code,
                            text: source.name
                        });
                        $newOption.attr('data-movement-type', source.movement_type);
                        $newOption.attr('data-source-id', sourceIdInt);
                        
                        // Mark as selected if it matches the desired source
                        if (source.code === sourceParam) {
                            $newOption.prop('selected', true);
                        }
                        
                        $sourceSelect.append($newOption);
                    });
                    
                    // Step 4: Now set the source value and trigger change
                    // Wait a moment to ensure dropdown is fully rendered
                    setTimeout(function() {
                        $('#source').val(sourceParam).trigger('change');
                        
                        // Step 5: Wait for source change handler to complete (toggleAccountMasterField)
                        // toggleAccountMasterField clears payee_name when source is 'petty', and calls handlePaymentCategoryChange('')
                        // handlePaymentCategoryChange('') also clears payee_name, so we need to set it after ALL handlers complete
                        // Use longer delay to ensure all async operations complete
                        setTimeout(function() {
                            // Store payee values
                            let payeeCodeValue = payeeCodeParam && payeeCodeParam.trim() !== '' ? payeeCodeParam.trim() : '';
                            let payeeNameValue = payeeNameParam && payeeNameParam.trim() !== '' ? payeeNameParam.trim() : '';
                            
                            // For non-petty sources, search for payee in dropdown and select it
                            if (sourceParam !== 'petty' && (payeeCodeValue || payeeNameValue)) {
                                // Wait for payee dropdown to be initialized, then search for payee
                                setTimeout(function() {
                                    let payeeDropdown = $('#payee_id');
                                    if (payeeDropdown.length && payeeDropdown.data('select2')) {
                                        // Search for payee by code or name
                                        let searchTerm = payeeCodeValue || payeeNameValue;
                                        payeeDropdown.select2('open');
                                        payeeDropdown.select2('search', searchTerm);
                                        // After search, try to find and select matching option
                                        setTimeout(function() {
                                            let $options = payeeDropdown.find('option');
                                            let foundOption = null;
                                            $options.each(function() {
                                                let optionText = $(this).text();
                                                if (payeeCodeValue && optionText.includes(payeeCodeValue)) {
                                                    foundOption = $(this).val();
                                                    return false; // Break loop
                                                } else if (payeeNameValue && optionText.includes(payeeNameValue)) {
                                                    foundOption = $(this).val();
                                                    return false; // Break loop
                                                }
                                            });
                                            if (foundOption) {
                                                payeeDropdown.val(foundOption).trigger('change');
                                            }
                                            payeeDropdown.select2('close');
                                        }, 500);
                                    }
                                }, 1000);
                            }
                            
                            // Set payee_name - if source is petty, set it in the payees array (first payee card)
                            // Otherwise, payee is selected from dropdown above
                            setTimeout(function() {
                                if (payeeNameValue && sourceParam === 'petty') {
                                        // For petty cash, set payee name in the first payee card's payee-name field
                                        // handlePaymentCategoryChange('') should have created the first payee card
                                        let $firstPayeeCard = $('#payeesContainer .payee-card').first();
                                        if ($firstPayeeCard.length > 0) {
                                            let $payeeNameField = $firstPayeeCard.find('.payee-name');
                                            if ($payeeNameField.length > 0) {
                                                $payeeNameField.val(payeeNameValue);
                                                $payeeNameField.trigger('input');
                                                console.log('Payee name set in payees array:', payeeNameValue, 'Field value:', $payeeNameField.val());
                                            } else {
                                                // If payee card exists but name field not found, try after a short delay
                                                setTimeout(function() {
                                                    $firstPayeeCard.find('.payee-name').val(payeeNameValue).trigger('input');
                                                }, 100);
                                            }
                                        } else {
                                            // If no payee card exists yet, wait a bit more for addPayee() to complete
                                            setTimeout(function() {
                                                $('#payeesContainer .payee-card').first().find('.payee-name').val(payeeNameValue).trigger('input');
                                            }, 200);
                                        }
                                }
                            }, 100); // Small additional delay for payee_name specifically
                            
                            // Hide loading spinner and show form content (don't wait for payee_name if it's not provided)
                            setTimeout(function() {
                                // Set settlement_id if provided (for linking petty cash to IOU settlement)
                                if (settlementIdParam) {
                                    $('#iou_settlement_id').val(settlementIdParam);
                                }
                                
                                // Set remarks if provided (for IOU settlement details)
                                if (remarksParam) {
                                    $('#remarks').val(remarksParam);
                                }
                                
                                $('#modalLoadingIndicator').hide();
                                $('#modalFormContent').show();
                                $('#btnSubmitMovement').prop('disabled', false).html('<i class="fas fa-save"></i>');
                                
                                // Clear URL parameters after all values are set
                                window.history.replaceState({}, document.title, window.location.pathname);
                            }, 300); // Wait a bit longer to ensure payee_name is set in payees array if it was provided
                        }, 800); // Longer delay to ensure toggleAccountMasterField and handlePaymentCategoryChange complete
                    }, 200); // Wait for dropdown to be fully rendered
                }).catch(function(error) {
                    console.error('Error loading sources for movement type:', error);
                    // Hide loading spinner and show form content even on error
                    $('#modalLoadingIndicator').hide();
                    $('#modalFormContent').show();
                    $('#btnSubmitMovement').prop('disabled', false).html('<i class="fas fa-save"></i>');
                    
                    // Fallback: Set movement_type and trigger change, then try to set source
                    $('#movement_type').val(movementTypeParam).trigger('change');
                    setTimeout(function() {
                        $('#source').val(sourceParam).trigger('change');
                        setTimeout(function() {
                            if (payeeCodeParam) $('#payee_code').val(payeeCodeParam);
                            if (payeeNameParam) $('#payee_name').val(payeeNameParam);
                            if (settlementIdParam) $('#iou_settlement_id').val(settlementIdParam);
                            if (remarksParam) $('#remarks').val(remarksParam);
                            window.history.replaceState({}, document.title, window.location.pathname);
                        }, 400);
                    }, 500);
                });
            } else {
                // Clear URL parameters if required params are missing
                if (movementTypeParam || sourceParam || payeeCodeParam || payeeNameParam || settlementIdParam || remarksParam) {
                    window.history.replaceState({}, document.title, window.location.pathname);
                }
            }
        }
        
        loadActiveShift();
        // Ensure amount field is cleared when modal opens
        $('#amount').val('');
        // Reset form state
        $('#payment_category').val('').trigger('change');
        // payee_select_group visibility is controlled by toggleAccountMasterField based on source
        $('#employee_dropdown_group').hide();
        
                            // For IOU, refund, other source, or cash_in with advance/salary/md_cash_in/other, ensure advance month fields are not required
                            let currentSource = $('#source').val();
                            let movementType = $('#movement_type').val();
                            let isCashInExcludedSource = movementType === 'cash_in' && (currentSource === 'advance' || currentSource === 'salary' || currentSource === 'md_cash_in' || currentSource === 'other');
                            if (currentSource === 'iou' || currentSource === 'refund' || currentSource === 'other' || isCashInExcludedSource) {
                                $('#advance_applicable_year').prop('required', false).removeAttr('required');
                                $('#advance_applicable_month').prop('required', false).removeAttr('required');
                                $('#pay_cycle').prop('required', false).removeAttr('required');
                                $('#schedule_groups').prop('required', false).removeAttr('required');
                            }
        
        // Hide series dropdown by default
        $('#series_group').hide();
        $('#series').val(''); // No default selection - must be selected manually
        showSeriesDropdown = false;
        $('#remarks').val('');
        
        // Reset advance year-month and entry type
        $('#advance_applicable_year').val('');
        $('#advance_applicable_month').val('');
        // Reset entry type to manual (default) and hide automated fields
        $('input[name="advance_entry_type"][value="manual"]').prop('checked', true);
        $('#schedule_groups_group').hide();
        $('#automated_entry_group').hide();
        $('#manual_entry_group').hide(); // Will be shown when entry type section becomes visible
        
        // Apply source filter if movement type is selected
        setTimeout(function() {
            // Restore original options first, then filter
            // Load sources from API when movement type changes
            if (typeof filterSourceOptions === 'function') {
                filterSourceOptions();
            }
        }, 100);
    });
    
    // Reset form when modal is hidden
    $('#addMovementModal').on('hidden.bs.modal', function() {
        // Reset modal title and button text
        $('#addMovementModalLabel').text('Add Cash Movement');
        $('#btnSubmitText').text('Save Movement');
        $('#btnSubmitMovement').attr('title', 'Save Movement');
        $('#movement_id').val('');
        
        // Reset loading state
        $('#modalLoadingIndicator').hide();
        $('#modalFormContent').show();
        $('#btnSubmitMovement').prop('disabled', false).html('<i class="fas fa-save"></i>');
        
        $('#addMovementForm')[0].reset();
        $('#payment_category').val('').trigger('change');
        // payee_select_group visibility is controlled by toggleAccountMasterField based on source
        $('#employee_dropdown_group').hide();
        // Hide series dropdown by default
        $('#series_group').hide();
        $('#series').val(''); // No default selection
        $('#remarks').val('');
        // Hide GRN group and remove required attribute
        $('#grn_code_group').hide();
        $('#grn_supplier').prop('required', false);
        $('#grn_supplier').val('');
        
        // Load sources when form is reset (if movement type is selected)
        let movementType = $('#movement_type').val();
        if (movementType && typeof filterSourceOptions === 'function') {
            filterSourceOptions();
        }
        
        // Clear petty cash fields
        $('#payeesContainer').empty();
        $('#line_items_section').hide();
        $('#single_payee_section').show();
        payeeIndex = 0; // Reset payee index
        
        // Clear GRN table
        $('#grnAmountsBody').empty();
        grnRowIndex = 0;
        $('#grnAmountsTotal').text('0.00');
        
        // Clear advance year-month and entry type
        $('#advance_applicable_year').val('');
        $('#advance_applicable_month').val('');
        // Reset entry type to manual (default) and hide automated fields
        $('input[name="advance_entry_type"][value="manual"]').prop('checked', true);
        $('#schedule_groups_group').hide();
        $('#automated_entry_group').hide();
        $('#manual_entry_group').hide(); // Will be shown when entry type section becomes visible
        
        lineItemIndex = 0; // Reset line item index
        employeeRowIndex = 0; // Reset employee index
        supplierRowIndex = 0; // Reset supplier index
        
        // Clear employee and supplier tables
        $('#employeeAmountsBody').empty();
        $('#supplierAmountsBody').empty();
        $('#advance_payment_type_group').hide();
        $('#employee_dropdown_group').hide();
        $('#supplier_dropdown_group').hide();
        // Reset outsource supplier fields
        $('#outsource_supplier_select').val('').trigger('change');
        $('#outsource_job_select').val('').trigger('change');
        $('#outsource_advance_date').val('');
        $('#outsource_advance_amount').val('');
        $('#outsource_remarks').val('');
        $('#job_details_display').hide();
        $('#btnViewAdvancePayments').hide().removeData('job-id');
        $('#outsource_supplier_group').hide();
        
        // Destroy Select2 instances for employee selects
        $('#employeeAmountsBody .employee-select').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }
        });
        
        // Destroy Select2 instances for supplier selects
        $('#supplierAmountsBody .supplier-select').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }
        });
        
        // Destroy Select2 instances for outsource supplier and job selects
        if ($('#outsource_supplier_select').hasClass('select2-hidden-accessible')) {
            $('#outsource_supplier_select').select2('destroy');
        }
        if ($('#outsource_job_select').hasClass('select2-hidden-accessible')) {
            $('#outsource_job_select').select2('destroy');
        }
    });
    
    // Direct handler for amount field to ensure formatting works
    $('#amount').on('input', function() {
        let $input = $(this);
        let value = getCleanNumericValue($input.val());
        if (value !== '' && !isNaN(value) && parseFloat(value) >= 0) {
            let formatted = formatPriceWithCommas(value);
            if ($input.val() !== formatted) {
                $input.val(formatted);
            }
        }
    });
    
    // Also handle paste for amount field
    $('#amount').on('paste', function() {
        let $input = $(this);
        setTimeout(function() {
            let value = getCleanNumericValue($input.val());
            if (value !== '' && !isNaN(value) && parseFloat(value) >= 0) {
                $input.val(formatPriceWithCommas(value));
            }
        }, 10);
    });

    // Load payment categories from API
    function loadPaymentCategories() {
        fetchPaymentCategoriesFromAPI().then(function(categories) {
            let $dropdown = $('#payment_category');
            let currentValue = $dropdown.val();
            $dropdown.empty();
            $dropdown.append('<option value="">Select Payment Category (Optional)</option>');
            
            // Add categories from API
            categories.forEach(function(category) {
                $dropdown.append(`<option value="${category.code}" data-category-id="${category.id}" data-requires-employee="${category.requires_employee ? 1 : 0}" data-requires-supplier="${category.requires_supplier ? 1 : 0}">${category.name}</option>`);
            });
            
            // Restore selected value
            if (currentValue) {
                $dropdown.val(currentValue).trigger('change');
            }
            
            // Re-initialize Select2
            if ($dropdown.hasClass('select2-hidden-accessible')) {
                $dropdown.select2('destroy');
            }
            $dropdown.select2({
                dropdownParent: $('#addMovementModal'),
                placeholder: 'Select Payment Category (Optional)',
                allowClear: true
            });
        });
    }
    
    // Initialize page on load
    // Load active shift first, then shifts, then movements (for proper readonly filter setup)
    loadActiveShift();
    loadShifts();
    loadAllSourcesForFilter(); // Load all sources for filter dropdown
    // Initialize movements table after shifts are loaded (will use active shift if readonly mode enabled)
    setTimeout(function() {
        loadCashMovements();
    }, 100);
    loadEmployees();
    loadPaymentCategories();
    
    // Check for URL parameters to auto-open modal (e.g., from IOU expense_claim settlement)
    const urlParams = new URLSearchParams(window.location.search);
    const movementTypeParam = urlParams.get('movement_type');
    const sourceParam = urlParams.get('source');
    if (movementTypeParam && sourceParam) {
        // Wait for page to fully load, then open modal
        setTimeout(function() {
            $('#addMovementModal').modal('show');
        }, 500);
    }
    
    // Flag to prevent multiple API calls during filter reset
    let isResettingFilters = false;
    
    // Filter change handlers (excluding Select2 source filter)
    $('#filterMovementType, #filterStatus, #filterDateFrom, #filterDateTo').on('change', function() {
        // Skip reload if we're currently resetting filters
        if (isResettingFilters) {
            return;
        }
        if ($.fn.DataTable.isDataTable('#movementsTable')) {
            $('#movementsTable').DataTable().ajax.reload();
        }
    });
    
    // Separate handler for Select2 source filter (using event delegation)
    $(document).on('select2:select select2:clear', '#filterSource', function(e) {
        // Skip reload if we're currently resetting filters
        if (isResettingFilters) {
            return;
        }
        if ($.fn.DataTable.isDataTable('#movementsTable')) {
            $('#movementsTable').DataTable().ajax.reload();
        }
    });
    
    // Clear filters button - reset all filters without triggering multiple API calls
    $('#clearFiltersBtn').on('click', function() {
        isResettingFilters = true;
        
        // Clear all filter values (without triggering change events)
        $('#filterMovementType').val('');
        $('#filterStatus').val('');
        $('#filterDateFrom').val('');
        $('#filterDateTo').val('');
        
        // Clear Select2 source field without triggering change events
        if ($('#filterSource').hasClass('select2-hidden-accessible')) {
            $('#filterSource').val(null).trigger('change.select2');
        } else {
            $('#filterSource').val('');
        }
        
        // Reset flag and reload table only once after all filters are cleared
        setTimeout(function() {
            isResettingFilters = false;
            // Reload table only once after all filters are cleared
            if ($.fn.DataTable.isDataTable('#movementsTable')) {
                $('#movementsTable').DataTable().ajax.reload();
            }
        }, 150);
    });
    
    // Handle movement type change - load source options from API
    function filterSourceOptions() {
        let movementType = $('#movement_type').val();
        let $sourceSelect = $('#source');
        let currentSource = $sourceSelect.val();
        
        // Clear options
        $sourceSelect.empty();
        $sourceSelect.append('<option value="">Select Source</option>');
        
        // If no movement type selected, don't load sources
        if (!movementType || movementType === '') {
            return;
        }
        
        // Load sources from API based on movement type
        fetchSourcesFromAPI(movementType).then(function(sources) {
            console.log('Sources loaded from API:', sources);
            // Add sources from API
            sources.forEach(function(source) {
                // Ensure source.id exists and is valid
                if (!source.id) {
                    console.error('Source missing id:', source);
                    return; // Skip sources without id
                }
                
                let sourceIdInt = parseInt(source.id, 10);
                if (isNaN(sourceIdInt)) {
                    console.error('Source id is not a valid number:', source);
                    return;
                }
                
                let $newOption = $('<option>', {
                    value: source.code,
                    text: source.name
                });
                
                // Set data attributes explicitly using attr() for reliability
                $newOption.attr('data-movement-type', source.movement_type);
                $newOption.attr('data-source-id', sourceIdInt);
                
                // Restore selected state if it was the previously selected option
                if (source.code === currentSource) {
                    $newOption.prop('selected', true);
                }
                
                $sourceSelect.append($newOption);
                
                // Debug: log the created option
                console.log('Added source option:', {
                    code: source.code,
                    name: source.name,
                    id: sourceIdInt,
                    attr: $newOption.attr('data-source-id')
                });
            });
            
            // If current source is no longer available, reset it
            if (currentSource && $sourceSelect.find(`option[value="${currentSource}"]`).length === 0) {
                $sourceSelect.val('').trigger('change');
            }
        }).catch(function(error) {
            console.error('Error loading sources:', error);
        });
    }
    
    // Handle movement type change - filter source options
    $(document).on('change', '#movement_type', function() {
        filterSourceOptions();
    });
    
    // Toggle between multiple payees and employee-based payment based on payment category
    $(document).on('change', '#payment_category', function() {
        let selectedValue = $(this).val();
        handlePaymentCategoryChange(selectedValue);
    });
    
    // Initialize Account Master dropdown with Select2
    function initializeAccountMasterDropdown() {
        let $accountMasterSelect = $('#account_master_id');
        
        // Destroy Select2 if already initialized
        if ($accountMasterSelect.hasClass('select2-hidden-accessible')) {
            $accountMasterSelect.select2('destroy');
        }
        
        $accountMasterSelect.select2({
            ajax: {
                url: apiBaseUrl + '/v1/finance/account_master',
                type: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + api_token
                },
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term || '', // Search term from user input
                        length: -1 // Get all records
                    };
                },
                processResults: function(data) {
                    if (data.status === false) {
                        return { results: [] };
                    }
                    let items = data.data || [];
                    return {
                        results: items.map(function(item) {
                            return {
                                id: item.id,
                                text: (item.account_code || '') + ' - ' + (item.account_name || ''),
                                account_code: item.account_code,
                                account_name: item.account_name
                            };
                        })

                    };
                },
                cache: false // Disable cache for fresh search results
            },
            placeholder: 'Select Account Master',
            allowClear: true,
            dropdownParent: $('#addMovementModal'),
            minimumInputLength: 0, // Allow typing/searching from the start
            language: {
                searching: function() {
                    return "Searching accounts...";
                },
                noResults: function() {
                    return "No accounts found";
                },
                inputTooShort: function() {
                    return "Type to search accounts";
                }
            },
            width: '100%' // Use full width of container
        });
    }

    // Initialize Payee dropdown with Select2
    function initializePayeeDropdown() {
        let $payeeSelect = $('#payee_id');
        
        // Destroy Select2 if already initialized
        if ($payeeSelect.hasClass('select2-hidden-accessible')) {
            $payeeSelect.select2('destroy');
        }
        
        $payeeSelect.select2({
            ajax: {
                url: '<?= base_url("Cashier/CashMovement/getPayees") ?>',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term || ''
                    };
                },
                processResults: function(data) {
                    if (data.status === false || !data.data) {
                        return { results: [] };
                    }
                    let items = data.data || data.results || [];
                    return {
                        results: items.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text || (item.payee_code + ' - ' + item.payee_name),
                                payee_code: item.payee_code,
                                payee_name: item.payee_name
                            };
                        })
                    };
                },
                cache: true
            },
            placeholder: 'Select Payee',
            allowClear: true,
            dropdownParent: $('#addMovementModal')
        });
        
        // When payee is selected, update hidden fields
        $payeeSelect.on('select2:select', function(e) {
            let data = e.params.data;
            $('#payee_code').val(data.payee_code || '');
            $('#payee_name').val(data.payee_name || '');
        });
        
        // When payee is cleared, clear hidden fields
        $payeeSelect.on('select2:clear', function() {
            $('#payee_code').val('');
            $('#payee_name').val('');
        });
    }
    
    // Initialize payee dropdown on page load
    initializePayeeDropdown();
    
    // Initialize account master dropdown on page load
    // initializeAccountMasterDropdown();
    
    // Re-initialize dropdowns when modal opens
    $('#addMovementModal').on('shown.bs.modal', function() {
        initializePayeeDropdown();
        initializeAccountMasterDropdown();
    });
    
    // Add Payee button handler (main button in single payee section)
    $('#btnAddPayee').on('click', function() {
        $('#addPayeeForm')[0].reset();
        $('#addPayeeModal').modal('show');
    });
    
    // Add Payee button handler (inline button in multiple payees section)
    $(document).on('click', '.btn-add-payee-inline', function() {
        let payeeId = $(this).data('payee-id');
        // Store the payee ID so we know which dropdown to update after creating the payee
        $('#addPayeeModal').data('target-payee-id', payeeId);
        $('#addPayeeForm')[0].reset();
        $('#addPayeeModal').modal('show');
    });
    
    // Add Payee form submission
    $('#addPayeeForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = {
            payee_name: $('#new_payee_name').val().trim(),
            contact_person: $('#new_contact_person').val().trim(),
            contact_phone: $('#new_contact_phone').val().trim(),
            contact_email: $('#new_contact_email').val().trim(),
            address: $('#new_address').val().trim(),
            description: $('#new_description').val().trim()
        };
        
        if (!formData.payee_name) {
            error_toastify('Please enter a payee name.');
            return;
        }
        
        // Get the submit button
        let $submitBtn = $('#btnSavePayee');
        let originalBtnHtml = $submitBtn.html();
        
        // Disable button and show loading state
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        $.ajax({
            url: '<?= base_url("Cashier/CashMovement/createPayee") ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                if (res.status === true) {
                    success_toastify('Payee created successfully.');
                    
                    // Check if this was triggered from a multiple payees card
                    let targetPayeeId = $('#addPayeeModal').data('target-payee-id');
                    
                    if (targetPayeeId) {
                        // Update the payee dropdown in the specific payee card
                        let $card = $(`.payee-card[data-payee-id="${targetPayeeId}"]`);
                        let $payeeSelect = $card.find('.payee-select');
                        let option = new Option(res.data.text, res.data.id, true, true);
                        $payeeSelect.append(option).trigger('change');
                        
                        // Update hidden fields in the card
                        $card.find('.payee-code').val(res.data.payee_code);
                        $card.find('.payee-name').val(res.data.payee_name);
                        
                        // Trigger select2:select event manually
                        $payeeSelect.trigger({
                            type: 'select2:select',
                            params: {
                                data: {
                                    id: res.data.id,
                                    text: res.data.text,
                                    payee_code: res.data.payee_code,
                                    payee_name: res.data.payee_name
                                }
                            }
                        });
                        
                        // Clear the target payee ID
                        $('#addPayeeModal').removeData('target-payee-id');
                    } else {
                        // Update the main payee dropdown (single payee section)
                        let $payeeSelect = $('#payee_id');
                        let option = new Option(res.data.text, res.data.id, true, true);
                        $payeeSelect.append(option).trigger('change');
                        
                        // Update hidden fields
                        $('#payee_code').val(res.data.payee_code);
                        $('#payee_name').val(res.data.payee_name);
                        
                        // Trigger select2:select event manually
                        $payeeSelect.trigger({
                            type: 'select2:select',
                            params: {
                                data: {
                                    id: res.data.id,
                                    text: res.data.text,
                                    payee_code: res.data.payee_code,
                                    payee_name: res.data.payee_name
                                }
                            }
                        });
                    }
                    
                    $('#addPayeeModal').modal('hide');
                    
                    // Re-enable button and restore original text
                    $submitBtn.prop('disabled', false).html(originalBtnHtml);
                } else {
                    error_toastify(res.message || 'Failed to create payee.');
                    
                    // Re-enable button and restore original text
                    $submitBtn.prop('disabled', false).html(originalBtnHtml);
                }
            },
            error: function(xhr) {
                let errorMsg = 'Failed to create payee.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                error_toastify(errorMsg);
                
                // Re-enable button and restore original text
                $submitBtn.prop('disabled', false).html(originalBtnHtml);
            }
        });
    });
    
    // Clear target payee ID and reset button when modal is closed
    $('#addPayeeModal').on('hidden.bs.modal', function() {
        $(this).removeData('target-payee-id');
        
        // Reset submit button state
        $('#btnSavePayee').prop('disabled', false).html('<i class="fas fa-save"></i> Save Payee');
    });
    
    // Add Payment Category button
    $('#btnAddPaymentCategory').on('click', function() {
        $('#paymentCategoryForm')[0].reset();
        $('#paymentCategoryModal').modal('show');
    });
    
    // Save Payment Category
    $('#btnSavePaymentCategory').on('click', function() {
        let categoryName = $('#category_name').val().trim();
        if (!categoryName) {
            error_toastify('Please enter a category name.');
            return;
        }
        
        // Get existing categories
        let categories = JSON.parse(localStorage.getItem('payment_categories') || '[]');
        
        // Generate code if not provided
        let categoryCode = $('#category_code').val().trim() || categoryName.toLowerCase().replace(/\s+/g, '_');
        
        // Check if code already exists
        if (categories.some(cat => (cat.code || cat.name.toLowerCase().replace(/\s+/g, '_')) === categoryCode)) {
            error_toastify('This category code already exists.');
            return;
        }
        
        // Create new category
        let newCategory = {
            name: categoryName,
            code: categoryCode,
            description: $('#category_description').val().trim(),
            requires_employee: 0 // Default to 0, can be changed later
        };
        
        categories.push(newCategory);
        localStorage.setItem('payment_categories', JSON.stringify(categories));
        
        // Reload dropdown
        loadPaymentCategories();
        
        // Select the new category
        $('#payment_category').val(categoryCode).trigger('change');
        
        // Close modal
        $('#paymentCategoryModal').modal('hide');
        success_toastify('Payment category added successfully!');
    });

    // Add Employee Row button
    $(document).on('click', '#btnAddEmployeeRow', function(e) {
        e.preventDefault();
        addEmployeeRow();
    });
    
    // Handle GRN row addition
    // Handle final payment type selection (Supplier/Outsource Supplier)
    $(document).on('change', 'input[name="final_payment_type"]', function() {
        let selectedType = $(this).val();
        let paymentCategory = $('#payment_category').val();
        
        // Only allow supplier/outsource_supplier selection for final payment
        let $categoryOptionFinal = $('#payment_category').find('option:selected');
        let categoryTextFinal = $categoryOptionFinal.length > 0 ? ($categoryOptionFinal.text() || '') : '';
        if (paymentCategory !== 'final_payment' && !(categoryTextFinal && categoryTextFinal.toLowerCase().includes('final payment'))) {
            return;
        }
        
        if (selectedType === 'supplier') {
            // Show supplier table, hide outsource supplier group
            $('#supplier_dropdown_group').show();
            $('#outsource_supplier_group').hide();
            $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required'); // Remove required when hiding
            $('#employee_dropdown_group').hide();
            $('#employee_type_selection_group').hide();
            $('#employee_type_column_header').hide();
            // Hide advance month fields for final payment
            $('#advance_month_common_group').hide();
            $('#schedule_groups_group').hide();
            $('#pay_cycle').prop('required', false).removeAttr('required');
            $('#schedule_groups').prop('required', false).removeAttr('required');
            // Show main amount field for supplier type
            $('#main_amount_group').show();
            $('#amount').prop('required', true);
            
            // Clear employee table
            $('#employeeAmountsBody').empty();
            employeeRowIndex = 0;
            $('#employeeAmountsTotal').text('0.00');
            
            // Add first supplier if table is empty
            if ($('#supplierAmountsBody tr').length === 0) {
                addSupplierRow();
            }
        } else if (selectedType === 'outsource_supplier') {
            // Show outsource supplier group, hide supplier table
            $('#outsource_supplier_group').show();
            $('#outsource_supplier_select, #outsource_supplier_id').prop('required', true); // Add required when showing
            $('#outsource_advance_date').prop('required', true); // Add required when showing
            $('#supplier_job_id').prop('required', true); // Add required when showing
            $('#supplier_dropdown_group').hide();
            $('#employee_dropdown_group').hide();
            $('#employee_type_selection_group').hide();
            $('#employee_type_column_header').hide();
            // Hide main amount field for outsource supplier (they use advance amount in the section instead)
            $('#main_amount_group').hide();
            $('#amount').prop('required', false);
            
            // Clear supplier table
            $('#supplierAmountsBody').empty();
            supplierRowIndex = 0;
            $('#supplierAmountsTotal').text('0.00');
            
            // Set default advance date to today if not set
            if (!$('#outsource_advance_date').val()) {
                $('#outsource_advance_date').val(new Date().toISOString().split('T')[0]);
            }
            
            // Load suppliers for outsource supplier
            loadOutsourceSuppliers();
            
            // Update labels for final payment
            updateOutsourceSupplierLabels(true);
        }
    });
    
    // Handle advance payment type selection (Employee/Supplier/Out Source Supplier)
    // Note: This only applies to advance_payment, not loan
    $(document).on('change', 'input[name="advance_payment_type"]', function() {
        let selectedType = $(this).val();
        let paymentCategory = $('#payment_category').val();
        
        // Update required fields based on selected type
        updateRequiredFieldsForAdvanceType(selectedType);
        
        // Only allow supplier/outsource_supplier selection for advance payment
        if (paymentCategory !== 'advance_payment') {
            // For loan, force employee selection
            $('input[name="advance_payment_type"][value="employee"]').prop('checked', true);
            return;
        }
        
        if (selectedType === 'supplier') {
            // Show supplier table, hide employee table and employee type selection
            $('#supplier_dropdown_group').show();
            $('#employee_dropdown_group').hide();
            $('#outsource_supplier_group').hide();
            $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required'); // Remove required when hiding
            $('#employee_type_selection_group').hide();
            $('#employee_type_column_header').hide();
            // Show main amount field for supplier type
            $('#main_amount_group').show();
            $('#amount').prop('required', true);
            // Explicitly remove required from outsource fields when supplier is selected
            $('#outsource_advance_amount').prop('required', false).removeAttr('required');
            $('#outsource_advance_date').prop('required', false).removeAttr('required');
            // Hide and remove required from advance month fields for supplier
            $('#advance_month_common_group').hide();
            $('#pay_cycle').prop('required', false).removeAttr('required');
            $('#schedule_groups').prop('required', false).removeAttr('required');
            
            // Clear employee table
            $('#employeeAmountsBody').empty();
            employeeRowIndex = 0;
            $('#employeeAmountsTotal').text('0.00');
            
            // Add first supplier if table is empty
            if ($('#supplierAmountsBody tr').length === 0) {
                addSupplierRow();
            }
        } else if (selectedType === 'outsource_supplier') {
            // Show outsource supplier section, hide others
            $('#outsource_supplier_group').show();
            $('#outsource_supplier_select, #outsource_supplier_id').prop('required', true); // Add required when showing
            $('#outsource_advance_date').prop('required', true); // Add required when showing
            $('#supplier_job_id').prop('required', true); // Add required when showing
            $('#supplier_dropdown_group').hide();
            $('#employee_dropdown_group').hide();
            $('#employee_type_selection_group').hide();
            $('#employee_type_column_header').hide();
            // Hide main amount field for outsource supplier (they use advance amount in the section instead)
            $('#main_amount_group').hide();
            $('#amount').prop('required', false);
            // Hide advance month fields for outsource supplier (they use advance date instead)
            $('#advance_month_common_group').hide();
            $('#pay_cycle').prop('required', false).removeAttr('required');
            $('#schedule_groups').prop('required', false).removeAttr('required');
            // Make outsource fields required
            $('#outsource_advance_amount').prop('required', true);
            $('#outsource_advance_date').prop('required', true);
            // Set default advance date to today if not set
            if (!$('#outsource_advance_date').val()) {
                $('#outsource_advance_date').val(new Date().toISOString().split('T')[0]);
            }
            
            // Clear employee and supplier tables
            $('#employeeAmountsBody').empty();
            $('#supplierAmountsBody').empty();
            employeeRowIndex = 0;
            supplierRowIndex = 0;
            $('#employeeAmountsTotal').text('0.00');
            $('#supplierAmountsTotal').text('0.00');
            
            // Load suppliers for outsource supplier
            loadOutsourceSuppliers();
            
            // Update labels for advance payment (since this is advance_payment_type handler)
            updateOutsourceSupplierLabels(false);
        } else {
            // Show employee table, hide supplier table, show employee type selection
            $('#employee_dropdown_group').show();
            $('#supplier_dropdown_group').hide();
            // Show main amount field for employee type
            $('#main_amount_group').show();
            $('#amount').prop('required', true);
            // Show Pay Cycle and Schedule Groups ONLY for advance payment employee type
            let paymentCategoryCheck = $('#payment_category').val();
            let isAdvancePaymentCheck = paymentCategoryCheck === 'advance_payment' || paymentCategoryCheck === 'loan';
            let advanceTypeCheck = $('input[name="advance_payment_type"]:checked').val();
            if (isAdvancePaymentCheck && advanceTypeCheck === 'employee') {
                $('#advance_month_common_group').show();
                
                // Get selected entry type (default to manual if not set)
                let entryType = $('input[name="advance_entry_type"]:checked').val() || 'manual';
                if (typeof handleAdvanceEntryTypeChange === 'function') {
                    handleAdvanceEntryTypeChange(entryType);
                } else {
                    // Fallback: show manual entry by default
                    $('#manual_entry_group').show();
                    $('#automated_entry_group').hide();
                    $('#schedule_groups_group').hide();
                }
            } else {
                $('#advance_month_common_group').hide();
                $('#manual_entry_group').hide();
                $('#automated_entry_group').hide();
                $('#schedule_groups_group').hide();
                $('#pay_cycle').prop('required', false).removeAttr('required');
                $('#schedule_groups').prop('required', false).removeAttr('required');
            }
            $('#outsource_supplier_group').hide();
            $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required'); // Remove required when hiding
            $('#employee_type_selection_group').show();
            $('#employee_type_column_header').show();
            
            // Clear supplier table
            $('#supplierAmountsBody').empty();
            supplierRowIndex = 0;
            $('#supplierAmountsTotal').text('0.00');
            
            // Add first employee if table is empty
            if ($('#employeeAmountsBody tr').length === 0) {
                addEmployeeRow();
            } else {
                // Update existing employee rows to include type column if missing
                $('#employeeAmountsBody tr').each(function() {
                    if (!$(this).find('.employee-type-select').length) {
                        let $actionsCell = $(this).find('td').last();
                        let selectedType = $('input[name="employee_type"]:checked').val() || 'casual';
                        let employeeTypeCell = `
                            <td>
                                <select class="form-control employee-type-select" 
                                        name="employee_amounts[${$(this).data('row-index')}][employee_type]" 
                                        data-row-index="${$(this).data('row-index')}"
                                        style="width: 100%;" required>
                                    <option value="casual" ${selectedType === 'casual' ? 'selected' : ''}>Casual</option>
                                    <option value="medical" ${selectedType === 'medical' ? 'selected' : ''}>Medical</option>
                                </select>
                            </td>
                        `;
                        $actionsCell.before(employeeTypeCell);
                    }
                });
            }
        }
        
        // Update main amount field
        updateMainAmountField();
    });
    
    // Handle employee type (Casual/Medical) change - update all rows
    $(document).on('change', 'input[name="employee_type"]', function() {
        let selectedType = $(this).val();
        // Update all existing employee rows to match the selected type
        $('#employeeAmountsBody .employee-type-select').val(selectedType);
    });
    
    // Validate outsource amount against remaining balance
    function validateOutsourceAmount() {
        let $amountInput = $('#outsource_advance_amount');
        let $errorMsg = $('#outsource_amount_error');
        let amount = getCleanNumericValue($amountInput.val());
        let remainingBalance = parseFloat($('#outsource_job_select option:selected').data('remaining-balance') || 0);
        
        // Reset error state
        $amountInput.removeClass('is-invalid');
        $errorMsg.hide();
        
        // Only validate if job is selected and amount is entered
        if ($('#outsource_job_select').val() && amount !== '' && !isNaN(amount)) {
            let amountValue = parseFloat(amount);
            if (amountValue > remainingBalance) {
                let paymentType = 'Advance';
                let finalType = $('input[name="final_payment_type"]:checked').val();
                if (finalType === 'outsource_supplier') {
                    paymentType = 'Final';
                }
                $amountInput.addClass('is-invalid');
                $errorMsg.text(`${paymentType} amount cannot exceed remaining balance of ${formatPriceWithCommas(remainingBalance)}.`).show();
                return false;
            }
        }
        return true;
    }
    
    // Handle outsource advance/final amount change - update main amount field and validate
    $(document).on('input change blur', '#outsource_advance_amount', function() {
        let advanceType = $('input[name="advance_payment_type"]:checked').val();
        let finalType = $('input[name="final_payment_type"]:checked').val();
        
        // Validate amount against remaining balance
        validateOutsourceAmount();
        
        if (advanceType === 'outsource_supplier' || finalType === 'outsource_supplier') {
            updateMainAmountField();
        }
    });
    
    // Add supplier row button
    $(document).on('click', '#btnAddSupplierRow', function(e) {
        e.preventDefault();
        addSupplierRow();
    });
    
    // Remove supplier row
    $(document).on('click', '.btn-remove-supplier-row', function(e) {
        e.preventDefault();
        removeSupplierRow(this);
    });
    
    // Update supplier amounts total when amount changes
    $(document).on('change keyup', '.supplier-amount', function() {
        updateSupplierAmountsTotal();
    });
    
    // Remove Employee Row button
    $(document).on('click', '.btn-remove-employee-row', function(e) {
        e.preventDefault();
        removeEmployeeRow(this);
    });
    
    // Update total when employee amounts change
    $(document).on('input change blur', '.employee-amount', function() {
        updateEmployeeAmountsTotal();
    });
    
    // Handle GRN row addition
    $(document).on('click', '#btnAddGrnRow', function(e) {
        e.preventDefault();
        addGrnRow();
    });
    
    // Remove GRN row
    $(document).on('click', '.btn-remove-grn-row', function(e) {
        e.preventDefault();
        removeGrnRow(this);
    });
    
    // Update GRN amounts total when amount changes
    $(document).on('input change blur', '.grn-amount', function() {
        updateGrnAmountsTotal();
    });
    
    // Note: Payee name is not auto-populated for employee-based payments
    // Each employee row represents a separate record

    $('#shiftFilter').on('change', function() {
        // Only allow changes if readonly mode is disabled
        if (ENABLE_READONLY_SHIFT_FILTER) {
            // Revert to active shift if readonly mode is enabled
            if (activeShiftId) {
                $(this).val(activeShiftId).trigger('change.select2');
            }
            return;
        }
        
        // Reload table with new filter (only if readonly is disabled)
        if ($.fn.DataTable.isDataTable('#movementsTable')) {
            $('#movementsTable').DataTable().ajax.reload();
        } else {
            loadCashMovements($(this).val());
        }
    });

    $('#addMovementForm').on('submit', function(e) {
        e.preventDefault();
        
        // First, remove required from amount field if main_amount_group is hidden (multiple payees mode)
        if ($('#main_amount_group').is(':hidden') || !$('#main_amount_group').is(':visible')) {
            $('#amount').prop('required', false).removeAttr('required');
        }
        
        // Remove required from outsource fields if outsource_supplier_group is hidden
        if ($('#outsource_supplier_group').is(':hidden') || !$('#outsource_supplier_group').is(':visible')) {
            $('#outsource_advance_amount').prop('required', false).removeAttr('required');
            $('#outsource_advance_date').prop('required', false).removeAttr('required');
            $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required');
        }
        
        // Explicitly handle series field
        if ($('#series_group').is(':hidden') || !$('#series_group').is(':visible')) {
            $('#series').prop('required', false).removeAttr('required');
        }
        
        // Remove required attribute from hidden fields to prevent validation errors
        $('input[required], select[required], textarea[required]').each(function() {
            let $field = $(this);
            
            // Skip amount as we handle it above
            if ($field.attr('id') === 'amount' || $field.attr('name') === 'amount') {
                return;
            }
            
            // Skip outsource fields as we handle them above
            if ($field.attr('id') === 'outsource_advance_amount' || $field.attr('name') === 'outsource_advance_amount' ||
                $field.attr('id') === 'outsource_advance_date' || $field.attr('name') === 'outsource_advance_date' ||
                $field.attr('id') === 'outsource_supplier_select' || $field.attr('name') === 'outsource_supplier_id') {
                return;
            }
            
            // Skip series as we handle it above
            if ($field.attr('id') === 'series' || $field.attr('name') === 'series') {
                return;
            }
            
            // Check if field or its parent container is hidden
            if ($field.is(':hidden') || 
                $field.closest('[style*="display: none"], [style*="display:none"]').length > 0 ||
                $field.closest('.hide').length > 0 ||
                ($field.closest('#main_amount_group').length > 0 && $('#main_amount_group').is(':hidden')) ||
                ($field.closest('#grn_code_group').length > 0 && $('#grn_code_group').is(':hidden')) ||
                ($field.closest('#employee_dropdown_group').length > 0 && $('#employee_dropdown_group').is(':hidden')) ||
                ($field.closest('#supplier_dropdown_group').length > 0 && $('#supplier_dropdown_group').is(':hidden')) ||
                ($field.closest('#outsource_supplier_group').length > 0 && $('#outsource_supplier_group').is(':hidden')) ||
                ($field.closest('#advance_month_common_group').length > 0 && $('#advance_month_common_group').is(':hidden')) ||
                ($field.closest('#series_group').length > 0 && $('#series_group').is(':hidden'))) {
                $field.prop('required', false).removeAttr('required');
            }
        });
        
        // Also remove required from fields based on advance payment type (extra safety)
        let advanceType = $('input[name="advance_payment_type"]:checked').val();
        let finalType = $('input[name="final_payment_type"]:checked').val();
        let paymentCategory = $('#payment_category').val();
        let $categoryOptionFinal = $('#payment_category').find('option:selected');
        let categoryTextFinal2 = $categoryOptionFinal.length > 0 ? ($categoryOptionFinal.text() || '') : '';
        let isFinalPayment = paymentCategory === 'final_payment' || (categoryTextFinal2 && categoryTextFinal2.toLowerCase().includes('final payment'));
        
        // Update required fields based on selected type
        if (isFinalPayment && finalType) {
            if (finalType === 'outsource_supplier') {
                // Make outsource fields required
                $('#outsource_advance_amount').prop('required', true);
                $('#outsource_advance_date').prop('required', true);
            } else {
                // Remove required from outsource fields
                $('#outsource_advance_amount').prop('required', false).removeAttr('required');
                $('#outsource_advance_date').prop('required', false).removeAttr('required');
            }
        } else if (advanceType) {
            updateRequiredFieldsForAdvanceType(advanceType);
        }
        
        let movementId = $('#movement_id').val(); // Get movement ID if editing
        let isEditMode = !!movementId;
        
        // Validate that shift ID is set
        let shiftId = $('#cashier_shift_id').val();
        if (!shiftId) {
            error_toastify('No active shift found. Please open a cashier shift first.');
            return;
        }
        
        // Validate and collect data based on source
        // Note: sourceValue will be updated to sourceCode after getting source_id
        let sourceValue = $('#source').val();
        let lineItems = [];
        let amountValue = 0;
        paymentCategory = $('#payment_category').val() || null;
        
        // Initialize formData early to avoid "Cannot access before initialization" error
        // Will be fully populated later with all required fields
        let formData = {};
        
        // If payment category requires employee, validate employee selection (only for petty cash)
        // Skip employee validation for:
        // - Final payments (supplier / outsource supplier)
        // - Outsource supplier advance payments
        if (sourceValue === 'petty' && paymentCategory) {
            let $categoryOption = $('#payment_category').find('option:selected');
            let advanceType = $('input[name="advance_payment_type"]:checked').val();
            let categoryText3 = $categoryOption.length > 0 ? ($categoryOption.text() || '') : '';
            let isFinalPaymentCategory = paymentCategory === 'final_payment' || (categoryText3 && categoryText3.toLowerCase().includes('final payment'));
            let requiresEmployee = !isFinalPaymentCategory && (
                $categoryOption.data('requires-employee') == 1 ||
                paymentCategory === 'advance_payment' ||
                paymentCategory === 'loan'
            );
            
            // Skip employee validation if:
            // - Final payment category, or
            // - advance_payment_type is 'outsource_supplier' or 'supplier'
            if (requiresEmployee && advanceType !== 'outsource_supplier' && advanceType !== 'supplier') {
                // Validate employee rows (only for employee type)
                let hasValidEmployees = false;
                $('#employeeAmountsBody tr').each(function() {
                    let employeeId = $(this).find('.employee-select').val();
                    let amount = getCleanNumericValue($(this).find('.employee-amount').val());
                    if (employeeId && amount && !isNaN(amount) && parseFloat(amount) > 0) {
                        hasValidEmployees = true;
                        return false; // Break loop
                    }
                });
                
                if (!hasValidEmployees) {
                    let categoryName = $categoryOption.text();
                    error_toastify(`Please add at least one employee with amount for ${categoryName}.`);
                    return;
                }
            }
            
            // Validate pay cycle/schedule groups OR year/month for advance payment employee type
            if (advanceType === 'employee' && requiresEmployee) {
                let payCycle = $('#pay_cycle').val();
                let advanceYear = $('#advance_applicable_year').val();
                let advanceMonth = $('#advance_applicable_month').val();
                
                if (payCycle && payCycle !== '') {
                    // Pay cycle selected - no additional validation needed (schedule groups is optional)
                    // User can manually add employees or use schedule groups to load pre-created ones
                } else {
                    // No pay cycle - validate year and month (manual entry)
                    if (!advanceYear || !advanceMonth) {
                        error_toastify('Please select both year and month for advance payment applicable period, or select a pay cycle.');
                        return;
                    }
                }
            } else if (advanceType === 'outsource_supplier') {
                // Validate advance date for outsource supplier
                let advanceDate = $('#outsource_advance_date').val();
                if (!advanceDate) {
                    error_toastify('Please select an advance date for outsource supplier payment.');
                    return;
                }
            }
            // For supplier type, no additional validation needed (they use supplier amounts directly)
        }
        
        if (sourceValue === 'petty') {
            // Check if payment category is selected
            let shouldUseMultiplePayees = true;
            if (paymentCategory) {
                let $categoryOption = $('#payment_category').find('option:selected');
                let categoryText3 = $categoryOption.length > 0 ? ($categoryOption.text() || '') : '';
            let isFinalPaymentCategory = paymentCategory === 'final_payment' || (categoryText3 && categoryText3.toLowerCase().includes('final payment'));
                let requiresEmployee = !isFinalPaymentCategory && (
                    $categoryOption.data('requires-employee') == 1 || 
                    paymentCategory === 'advance_payment' || 
                    paymentCategory === 'loan'
                );
                
            if (requiresEmployee || isFinalPaymentCategory) {
                // Payment category with employee/supplier - calculate total from rows
                let isAdvancePayment = paymentCategory === 'advance_payment';
                let advanceType = null;
                let finalType = null;
                
                // Check for final payment type
                if (isFinalPaymentCategory) {
                    finalType = $('input[name="final_payment_type"]:checked').val();
                }
                
                // Only get advanceType for advance_payment (loan doesn't have supplier option)
                if (isAdvancePayment) {
                    advanceType = $('input[name="advance_payment_type"]:checked').val();
                } else if (!isFinalPaymentCategory && paymentCategory === 'loan') {
                    // Loan always uses employee only
                    advanceType = 'employee';
                }
                
                amountValue = 0;
                
                // Handle final payment supplier type
                if (isFinalPaymentCategory && finalType === 'supplier') {
                    // Collect supplier amounts for final payment
                    let supplierAmounts = [];
                    $('#supplierAmountsBody tr').each(function() {
                        let supplierId = $(this).find('.supplier-select').val();
                        let amount = getCleanNumericValue($(this).find('.supplier-amount').val());
                        let remark = $(this).find('.supplier-remark').val() || null;
                        if (supplierId && amount && !isNaN(amount) && parseFloat(amount) > 0) {
                            supplierAmounts.push({
                                supplier_id: parseInt(supplierId, 10),
                                amount: parseFloat(amount),
                                remark: remark
                            });
                            amountValue += parseFloat(amount);
                        }
                    });
                    
                    if (!amountValue || amountValue === '' || isNaN(amountValue) || parseFloat(amountValue) <= 0) {
                        error_toastify('Please enter valid amounts for suppliers.');
                        return;
                    }
                    
                    formData.supplier_amounts = supplierAmounts;
                    formData.final_payment_type = 'supplier';
                    // Explicitly remove advance_payment_type for final payment
                    if (formData.advance_payment_type) {
                        delete formData.advance_payment_type;
                    }
                } else if (isAdvancePayment && advanceType === 'supplier') {
                    // Collect supplier amounts (only for advance payment)
                    let supplierAmounts = [];
                    $('#supplierAmountsBody tr').each(function() {
                        let supplierId = $(this).find('.supplier-select').val();
                        let amount = getCleanNumericValue($(this).find('.supplier-amount').val());
                        let remark = $(this).find('.supplier-remark').val() || null;
                        if (supplierId && amount && !isNaN(amount) && parseFloat(amount) > 0) {
                            supplierAmounts.push({
                                supplier_id: parseInt(supplierId, 10),
                                amount: parseFloat(amount),
                                remark: remark
                            });
                            amountValue += parseFloat(amount);
                        }
                    });
                    
                    if (!amountValue || amountValue === '' || isNaN(amountValue) || parseFloat(amountValue) <= 0) {
                        error_toastify('Please enter valid amounts for suppliers.');
                        return;
                    }
                    
                    formData.supplier_amounts = supplierAmounts;
                    formData.advance_payment_type = 'supplier';
                    // Explicitly remove final_payment_type for advance payment
                    if (formData.final_payment_type) {
                        delete formData.final_payment_type;
                    }
                } else if ((isAdvancePayment && advanceType === 'outsource_supplier') || (isFinalPaymentCategory && finalType === 'outsource_supplier')) {
                    // Collect outsource supplier job data
                    let supplierJobId = $('#outsource_job_select').val();
                    let outsourceSupplierId = $('#outsource_supplier_select').val();
                    let advanceAmount = getCleanNumericValue($('#outsource_advance_amount').val());
                    let remarks = $('#outsource_remarks').val() || null;

                    if (!supplierJobId) {
                        error_toastify('Please select a job for outsource supplier.');
                        return;
                    }

                    if (!advanceAmount || isNaN(advanceAmount) || parseFloat(advanceAmount) <= 0) {
                        error_toastify('Please enter a valid final amount.');
                        return;
                    }

                    // Validate advance/final amount doesn't exceed remaining balance
                    let remainingBalance = parseFloat($('#outsource_job_select option:selected').data('remaining-balance') || 0);
                    // Check if this is a final payment with outsource supplier
                    let isFinalPaymentCheck = isFinalPaymentCategory && finalType === 'outsource_supplier';
                    let paymentType = isFinalPaymentCheck ? 'Final' : 'Advance';
                    
                    if (parseFloat(advanceAmount) > remainingBalance) {
                        error_toastify(`${paymentType} amount cannot exceed remaining balance of ${formatPriceWithCommas(remainingBalance)}.`);
                        return;
                    }
                    
                    // Also validate using the validation function
                    if (!validateOutsourceAmount()) {
                        return;
                    }

                    // Get advance date for outsource supplier
                    let advanceDate = $('#outsource_advance_date').val();
                    
                    formData.supplier_job_id = parseInt(supplierJobId, 10);
                    formData.outsource_supplier_id = parseInt(outsourceSupplierId, 10);
                    if (isFinalPaymentCheck) {
                        formData.final_payment_type = 'outsource_supplier';
                        // Explicitly remove advance_payment_type for final payment
                        if (formData.advance_payment_type) {
                            delete formData.advance_payment_type;
                        }
                    } else {
                        formData.advance_payment_type = 'outsource_supplier';
                        // Explicitly remove final_payment_type for advance payment
                        if (formData.final_payment_type) {
                            delete formData.final_payment_type;
                        }
                    }
                    formData.advance_date = advanceDate || null;
                    amountValue = parseFloat(advanceAmount);
                    formData.remarks = remarks;
                } else if (!isFinalPaymentCategory && paymentCategory && (advanceType === 'employee' || paymentCategory === 'loan')) {
                    // Collect employee amounts (for advance payment employee type and loan only, NOT for final payment)
                    // Only when payment category is actually selected
                    let employeeAmounts = [];
                    $('#employeeAmountsBody tr').each(function() {
                        let $employeeSelect = $(this).find('.employee-select');
                        let employeeId = $employeeSelect.val();
                        let amount = getCleanNumericValue($(this).find('.employee-amount').val());
                        let remark = $(this).find('.employee-remark').val() || null;
                        let employeeType = $(this).find('.employee-type-select').val() || null; // Casual or Medical (only for advance payment)
                        let mark = $(this).find('.employee-mark-checkbox').is(':checked') ? 1 : 0; // Mark (only for advance payment)
                        let imageUrl = $(this).find('.employee-image-url').val() || null; // Image URL (only for advance payment)
                        let epfNo = $(this).find('.employee-epf_no').val() || null; // EPF number (from bulk-loaded rows)
                        
                        // Get employee_no from selected option
                        let $selectedOption = $employeeSelect.find('option:selected');
                        let employeeNo = '';
                        
                        // Try multiple methods to get employee_no
                        // Method 1: From data attribute (set when option is selected)
                        if ($selectedOption.length > 0) {
                            employeeNo = $selectedOption.attr('data-employee-no') || '';
                        }
                        
                        // Method 2: From Select2 data
                        if (!employeeNo && $employeeSelect.data('select2')) {
                            try {
                                let select2Data = $employeeSelect.select2('data');
                                if (select2Data && select2Data.length > 0) {
                                    employeeNo = select2Data[0].emp_code || select2Data[0].employee_no || '';
                                }
                            } catch(e) {
                                // Select2 data access failed, continue to next method
                            }
                        }
                        
                        // Method 3: Extract from option text (format: "EMP001 - Name")
                        if (!employeeNo && $selectedOption.length > 0) {
                            let optionText = $selectedOption.text();
                            if (optionText && optionText.includes(' - ')) {
                                employeeNo = optionText.split(' - ')[0].trim();
                            }
                        }
                        
                        if (employeeId && amount && !isNaN(amount) && parseFloat(amount) > 0) {
                            let employeeData = {
                                employee_id: parseInt(employeeId, 10),
                                employee_no: employeeNo || '', // Required by API
                                amount: parseFloat(amount),
                                remark: remark
                            };
                            
                            // Include epf_no if available (from bulk-loaded rows)
                            if (epfNo) {
                                employeeData.epf_no = epfNo;
                            }
                            
                            // Include employee_type, mark, and image only for advance payment
                            if (isAdvancePayment) {
                                if (employeeType) {
                                    employeeData.employee_type = employeeType;
                                }
                                employeeData.mark = mark;
                                if (imageUrl) {
                                    employeeData.image_url = imageUrl;
                                }
                            }
                            
                            employeeAmounts.push(employeeData);
                            amountValue += parseFloat(amount);
                        }
                    });
                    
                    if (!amountValue || amountValue === '' || isNaN(amountValue) || parseFloat(amountValue) <= 0) {
                        error_toastify('Please enter valid amounts for employees.');
                        return;
                    }
                    
                    // Validate employee type for advance payment
                    if (isAdvancePayment) {
                        let hasInvalidType = false;
                        $('#employeeAmountsBody tr').each(function() {
                            let $typeSelect = $(this).find('.employee-type-select');
                            if ($typeSelect.length > 0 && !$typeSelect.val()) {
                                hasInvalidType = true;
                                return false;
                            }
                        });
                        
                        if (hasInvalidType) {
                            error_toastify('Please select employee type (Casual/Medical) for all employees.');
                            return;
                        }
                    }
                    
                    formData.employee_amounts = employeeAmounts;
                    // Only set advance_payment_type if payment category is selected and it's advance_payment
                    // Do NOT set for direct petty cash (no payment category)
                    let movementTypeCheck = $('#movement_type').val();
                    let isCashInExcludedSourceCheck = movementTypeCheck === 'cash_in' && (sourceValue === 'advance' || sourceValue === 'advance_cash' || sourceValue === 'salary' || sourceValue === 'md_cash_in' || sourceValue === 'other');
                    let hasPaymentCategory = paymentCategory && paymentCategory !== '';
                    if (isAdvancePayment && hasPaymentCategory && sourceValue === 'petty' && !isCashInExcludedSourceCheck) {
                        formData.advance_payment_type = 'employee';
                    } else if (sourceValue === 'iou' || sourceValue === 'refund' || sourceValue === 'other' || isCashInExcludedSourceCheck) {
                        // For IOU, refund, other, or cash_in with excluded sources, remove advance_payment_type if it was set
                        if (formData.advance_payment_type) {
                            delete formData.advance_payment_type;
                        }
                    }
                }
                
                shouldUseMultiplePayees = false; // Skip multiple payees
            }
            }
            
            // Multiple payees with accounts (either no category or category doesn't require employee)
            if (shouldUseMultiplePayees) {
                // For petty cash: collect multiple payees with their line items
                let payees = [];
                let hasValidPayees = false;
                
                $('.payee-card').each(function() {
                    let $payeeCard = $(this);
                    let selectedPayeeId = $payeeCard.find('.payee-select').val();
                    let payeeName = $payeeCard.find('.payee-name').val();
                    
                    if (!selectedPayeeId || !payeeName || payeeName.trim() === '') {
                        error_toastify('Please select a Payee for all payees.');
                        $payeeCard.find('.payee-select').select2('open');
                        return false;
                    }
                    
                    let payeeLineItems = [];
                    let payeeCardId = $payeeCard.find('.payee-line-items-table').data('payee-id');
                    let hasValidItems = false;
                    
                    $(`.payee-line-items-body[data-payee-id="${payeeCardId}"] tr`).each(function() {
                        let accountId = $(this).find('.account-select').val();
                        let amount = getCleanNumericValue($(this).find('.line-amount').val());
                        let memo = $(this).find('.line-memo').val();
                        
                        if (accountId && amount && !isNaN(amount) && parseFloat(amount) > 0) {
                            payeeLineItems.push({
                                account_master_id: parseInt(accountId, 10),
                                amount: parseFloat(amount),
                                memo: memo || null
                            });
                            amountValue += parseFloat(amount);
                            hasValidItems = true;
                        }
                    });
                    
                    if (!hasValidItems || payeeLineItems.length === 0) {
                        error_toastify('Each payee must have at least one valid line item with account and amount.');
                        return false;
                    }
                    
                    let payeeCode = $payeeCard.find('.payee-code').val();
                    
                    payees.push({
                        payee_id: parseInt(selectedPayeeId, 10),
                        payee_code: payeeCode,
                        payee_name: payeeName.trim(),
                        line_items: payeeLineItems
                    });
                    
                    hasValidPayees = true;
                });
                
                if (!hasValidPayees || payees.length === 0) {
                    error_toastify('Please add at least one payee with line items for Petty Cash.');
                    return false;
                }
                
                // Store payees data
                formData.payees = payees;
            }
        } else {
            // For other sources: use single amount field
            amountValue = getCleanNumericValue($('#amount').val());
            if (!amountValue || amountValue === '' || isNaN(amountValue) || parseFloat(amountValue) <= 0) {
                error_toastify('Please enter a valid amount.');
                return;
            }
        }
        
        // Get series value and map to is_confirm
        // Series 1 = 1, Series 2 = 0
        // For petty cash normal flow: series is in payee sections (handled in payees array)
        // Series is handled at movement level (common section)
        // Series value is automatically set based on employee's emp_etfno (even if dropdown is hidden)
        let seriesValue;
        if ($('#series_group').is(':visible')) {
            // If dropdown is visible in common section, user must select a value
            seriesValue = $('#series').val();
            if (!seriesValue || seriesValue === '') {
                error_toastify('Please select a Series value.');
                return;
            }
        } else {
            // If dropdown is hidden, check if Series value was automatically set (by employee selection)
            // Otherwise default to Series 1
            seriesValue = $('#series').val() || '1';
        }
        // Convert to integer: Series 1 = 1, Series 2 = 0
        let isConfirm = parseInt(seriesValue, 10) === 0 ? 0 : 1; // Ensure it's always 0 or 1 as integer
        
        // Debug log to verify value
        console.log('Series Value:', seriesValue, 'is_confirm:', isConfirm);
        
        // Get account_master_id - convert to integer if exists, otherwise null
        let accountMasterIdValue = $('#account_master_id').val();
        accountMasterIdValue = (accountMasterIdValue && accountMasterIdValue !== '' && accountMasterIdValue !== '0') ? parseInt(accountMasterIdValue, 10) : null;
        
        // Get source_id and source code from selected option
        let $selectedSource = $('#source option:selected');
        // Use attr() instead of data() for more reliable attribute access
        let sourceIdAttr = $selectedSource.attr('data-source-id');
        sourceValue = $selectedSource.val(); // Update sourceValue to source code for conditional logic
        
        // Convert sourceId to integer if it exists
        let sourceId = null;
        if (sourceIdAttr !== undefined && sourceIdAttr !== null && sourceIdAttr !== '') {
            sourceId = parseInt(sourceIdAttr, 10);
        }
        
        // Validate source selection
        if (!sourceId || isNaN(sourceId) || !sourceValue) {
            console.error('Source validation failed:', { 
                sourceIdAttr, 
                sourceId, 
                sourceValue, 
                selectedOptionHtml: $selectedSource[0]?.outerHTML 
            });
            error_toastify('Please select a valid source. Source ID: ' + (sourceIdAttr || 'not found'));
            return;
        }
        
        // Get payment_category_id from selected option (if payment category is selected)
        let $selectedCategory = $('#payment_category option:selected');
        let paymentCategoryId = null;
        if (paymentCategory && $selectedCategory.length > 0) {
            paymentCategoryId = $selectedCategory.data('category-id');
        }
        
        // Populate form data with all required fields (formData was initialized earlier)
        // Preserve existing properties from earlier formData (like advance_payment_type, supplier_job_id, advance_date, etc.)
        let existingFormData = formData || {};
        formData = {
            cashier_shift_id: shiftId,
            movement_type: $('#movement_type').val(),
            source_id: sourceId, // Use source_id for API
            source: sourceValue, // Keep source code for conditional logic
            payment_category_id: paymentCategoryId, // Use payment_category_id for API
            payment_category: paymentCategory, // Keep payment category code for conditional logic
            is_confirm: isConfirm, // Series 1 = 1, Series 2 = 0 (always present)
            amount: amountValue, // Total amount (sum of line items for petty, single amount for others)
            payment_type: $('#payment_type').val(),
            remarks: $('#remarks').val()
        };
        
        // Preserve important fields from existing formData (supplier_amounts, employee_amounts, payees, supplier_job_id, advance_date, outsource_supplier_id, etc.)
        // DO NOT preserve advance_payment_type or final_payment_type here - they will be set explicitly based on payment category below
        let isFinalPaymentCheck2 = paymentCategory === 'final_payment' || $('#payment_category').find('option:selected').text().toLowerCase().includes('final payment');
        // Skip preserving advance_payment_type here - it will be set explicitly later based on payment category
        
        // Preserve supplier_amounts
        if (existingFormData.supplier_amounts && Array.isArray(existingFormData.supplier_amounts)) {
            formData.supplier_amounts = existingFormData.supplier_amounts;
        }
        // Preserve employee_amounts
        if (existingFormData.employee_amounts && Array.isArray(existingFormData.employee_amounts)) {
            formData.employee_amounts = existingFormData.employee_amounts;
        }
        // Preserve payees
        if (existingFormData.payees && Array.isArray(existingFormData.payees)) {
            formData.payees = existingFormData.payees;
        }
        // Preserve other fields
        if (existingFormData.supplier_job_id) {
            formData.supplier_job_id = existingFormData.supplier_job_id;
        }
        if (existingFormData.advance_date !== undefined) {
            formData.advance_date = existingFormData.advance_date;
        }
        if (existingFormData.outsource_supplier_id) {
            formData.outsource_supplier_id = existingFormData.outsource_supplier_id;
        }
        if (existingFormData.grn_amounts && Array.isArray(existingFormData.grn_amounts)) {
            formData.grn_amounts = existingFormData.grn_amounts;
        }
        if (existingFormData.advance_months && Array.isArray(existingFormData.advance_months)) {
            formData.advance_months = existingFormData.advance_months;
        }
        if (existingFormData.advance_entry_type) {
            formData.advance_entry_type = existingFormData.advance_entry_type;
        }
        if (existingFormData.schedule_groups) {
            formData.schedule_groups = existingFormData.schedule_groups;
        }
        
        // Payees data - handle based on source and payment category
        if (sourceValue === 'petty' && paymentCategory) {
            // Petty cash with payment category - use single payee with employee
            let $categoryOption = $('#payment_category').find('option:selected');
            let requiresEmployee = $categoryOption.data('requires-employee') == 1 || paymentCategory === 'advance_payment' || paymentCategory === 'loan';
            
            if (requiresEmployee) {
                let selectedEmployees = $('#employee_id').val(); // Array of employee IDs
                // Collect employee amounts as array of objects
                let employeeAmounts = [];
                $('#employeeAmountsBody tr').each(function() {
                    let $employeeSelect = $(this).find('.employee-select');
                    let employeeId = $employeeSelect.val();
                    let amount = getCleanNumericValue($(this).find('.employee-amount').val());
                    let remark = $(this).find('.employee-remark').val() || null;
                    let employeeType = $(this).find('.employee-type-select').val() || null;
                    let epfNo = $(this).find('.employee-epf_no').val() || null; // EPF number (from bulk-loaded rows)
                    
                    // Get employee_no from selected option
                    let $selectedOption = $employeeSelect.find('option:selected');
                    let employeeNo = '';
                    
                    // Try multiple methods to get employee_no
                    // Method 1: From data attribute (set when option is selected)
                    if ($selectedOption.length > 0) {
                        employeeNo = $selectedOption.attr('data-employee-no') || '';
                    }
                    
                    // Method 2: From Select2 data
                    if (!employeeNo && $employeeSelect.data('select2')) {
                        try {
                            let select2Data = $employeeSelect.select2('data');
                            if (select2Data && select2Data.length > 0) {
                                employeeNo = select2Data[0].emp_code || select2Data[0].employee_no || '';
                            }
                        } catch(e) {
                            // Select2 data access failed, continue to next method
                        }
                    }
                    
                    // Method 3: Extract from option text (format: "EMP001 - Name")
                    if (!employeeNo && $selectedOption.length > 0) {
                        let optionText = $selectedOption.text();
                        if (optionText && optionText.includes(' - ')) {
                            employeeNo = optionText.split(' - ')[0].trim();
                        }
                    }
                    
                    if (employeeId && amount && !isNaN(amount) && parseFloat(amount) > 0) {
                        let employeeData = {
                            employee_id: parseInt(employeeId, 10),
                            employee_no: employeeNo || '', // Required by API
                            amount: parseFloat(amount),
                            remark: remark,
                            employee_type: employeeType
                        };
                        
                        // Include epf_no if available (from bulk-loaded rows)
                        if (epfNo) {
                            employeeData.epf_no = epfNo;
                        }
                        
                        employeeAmounts.push(employeeData);
                    }
                });
                
                formData.employee_amounts = employeeAmounts;
                
                // Extract year and month from pay cycle OR use year/month dropdowns
                // ONLY for advance payment employee type (skip for supplier, outsource_supplier, and final payment)
                let advanceType = $('input[name="advance_payment_type"]:checked').val();
                if (advanceType === 'employee') {
                    // Get entry type (manual or automated)
                    let entryType = $('input[name="advance_entry_type"]:checked').val() || 'manual';
                    formData.advance_entry_type = entryType;
                    
                    let payCycle = $('#pay_cycle').val();
                    let advanceYear = $('#advance_applicable_year').val();
                    let advanceMonth = $('#advance_applicable_month').val();
                    
                    // If pay cycle is selected (automated entry), use it; otherwise use year/month dropdowns (manual entry)
                    if (payCycle && payCycle !== '') {
                        // Parse pay cycle to extract year and month
                        let payCycleData = parsePayCycle(payCycle);
                        if (payCycleData && payCycleData.year && payCycleData.month) {
                            formData.advance_months = [{
                                advance_year: parseInt(payCycleData.year, 10),
                                advance_month: parseInt(payCycleData.month, 10)
                            }];
                        }
                        
                        // Add pay cycle ID to form data
                        formData.pay_cycle_id = payCycle;
                        
                        // Add schedule groups to form data if selected (optional)
                        let scheduleGroups = $('#schedule_groups').val();
                        if (scheduleGroups) {
                            formData.schedule_groups = scheduleGroups;
                            
                            // Get schedule group text from selected option
                            let $scheduleGroupOption = $('#schedule_groups option:selected');
                            let scheduleGroupText = $scheduleGroupOption.text();
                            if (scheduleGroupText && scheduleGroupText !== 'Select Schedule Groups (Optional)') {
                                formData.schedule_group_text = scheduleGroupText;
                            }
                        }
                    } else if (advanceYear && advanceMonth) {
                        // Use year/month dropdowns (manual entry)
                        formData.advance_months = [{
                            advance_year: parseInt(advanceYear, 10),
                            advance_month: parseInt(advanceMonth, 10)
                        }];
                    }
                }
                // Note: For outsource_supplier, the advance date is stored in outsource_advance_date field
                
                // Payee name is stored per employee in employee_amounts array
                formData.payee_name = null;
                formData.payee_code = null;
            }
        } else if (sourceValue !== 'petty') {
            // For non-petty: add single payee fields or supplier fields based on source
            if (sourceValue === 'supplier') {
                // For supplier source: collect GRN amounts
                let grnAmounts = [];
                let grnTotal = 0;
                
                $('#grnAmountsBody tr').each(function() {
                    let supplierId = $(this).find('.grn-supplier-id').val();
                    let grnCode = $(this).find('.grn-select').val();
                    let amount = getCleanNumericValue($(this).find('.grn-amount').val());
                    let remark = $(this).find('.grn-remark').val() || null;
                    
                    if (supplierId && grnCode && amount && !isNaN(amount) && parseFloat(amount) > 0) {
                        grnAmounts.push({
                            supplier_id: parseInt(supplierId, 10),
                            grn_code: grnCode,
                            amount: parseFloat(amount),
                            remark: remark
                        });
                        grnTotal += parseFloat(amount);
                    }
                });
                
                if (grnAmounts.length === 0) {
                    error_toastify('Please add at least one GRN code with amount.');
                    return;
                }
                
                // Update amount value to GRN total
                amountValue = grnTotal;
                formData.grn_amounts = grnAmounts;
                formData.payee_code = null;
                formData.payee_name = null;
            } else {
                // For other sources: add Payee ID, Code and Name
                formData.payee_master_id = $('#payee_id').val() || null;
                formData.payee_code = $('#payee_code').val() || null;
                formData.payee_name = $('#payee_name').val() || null;
                formData.grn_amounts = null;
            }
            
            // Add settlement_id if present (for linking petty cash to IOU settlement)
            formData.iou_settlement_id = $('#iou_settlement_id').val() || null;
        }
        
        // Add account_master_id (for Advance Payment category in Petty Cash source or other cases)
        // accountMasterIdValue is already declared earlier in this scope
        accountMasterIdValue = $('#account_master_id').val();
        if (accountMasterIdValue && accountMasterIdValue !== '' && accountMasterIdValue !== '0') {
            formData.account_master_id = parseInt(accountMasterIdValue, 10);
        }
        
        // Set payment type based on payment category - ONLY ONE should be set
        let isFinalPaymentCheck3 = paymentCategory === 'final_payment' || $('#payment_category').find('option:selected').text().toLowerCase().includes('final payment');
        
        if (isFinalPaymentCheck3) {
            // Final Payment: Only set final_payment_type, never advance_payment_type
            let finalPaymentTypeValue = $('input[name="final_payment_type"]:checked').val();
            if (finalPaymentTypeValue && (finalPaymentTypeValue === 'supplier' || finalPaymentTypeValue === 'outsource_supplier')) {
                formData.final_payment_type = finalPaymentTypeValue;
            }
            // Explicitly remove advance_payment_type if it exists (should not be set for final payments)
            if (formData.advance_payment_type) {
                delete formData.advance_payment_type;
            }
            
            // For outsource_supplier final payment, also preserve supplier_job_id, advance_date, and outsource_supplier_id
            if (finalPaymentTypeValue === 'outsource_supplier') {
                let supplierJobId = $('#outsource_job_select').val();
                let outsourceSupplierId = $('#outsource_supplier_select').val();
                let advanceDate = $('#outsource_advance_date').val();
                let finalAmount = getCleanNumericValue($('#outsource_advance_amount').val());
                
                // Validate final amount doesn't exceed remaining balance
                if (supplierJobId && finalAmount) {
                    let remainingBalance = parseFloat($('#outsource_job_select option:selected').data('remaining-balance') || 0);
                    if (parseFloat(finalAmount) > remainingBalance) {
                        error_toastify(`Final amount cannot exceed remaining balance of ${formatPriceWithCommas(remainingBalance)}.`);
                        return false;
                    }
                }
                
                // Also validate using the validation function
                if (!validateOutsourceAmount()) {
                    return false;
                }
                
                if (supplierJobId && supplierJobId !== '' && supplierJobId !== '0') {
                    formData.supplier_job_id = parseInt(supplierJobId, 10);
                }
                
                if (outsourceSupplierId && outsourceSupplierId !== '' && outsourceSupplierId !== '0') {
                    formData.outsource_supplier_id = parseInt(outsourceSupplierId, 10);
                }
                
                if (advanceDate && advanceDate !== '') {
                    formData.advance_date = advanceDate;
                }
            }
        }
        
        // Set advance_payment_type ONLY if it's NOT a final payment AND NOT IOU (final payments use final_payment_type instead, IOU doesn't use advance_payment_type)
        let isFinalPaymentCheck = paymentCategory === 'final_payment' || $('#payment_category').find('option:selected').text().toLowerCase().includes('final payment');
        let movementType = $('#movement_type').val();
        let isCashInExcludedSource = movementType === 'cash_in' && (sourceValue === 'advance' || sourceValue === 'advance_cash' || sourceValue === 'salary' || sourceValue === 'md_cash_in' || sourceValue === 'other');
        
        if (!isFinalPaymentCheck && sourceValue !== 'iou' && sourceValue !== 'refund' && sourceValue !== 'other' && !isCashInExcludedSource) {
            // Advance Payment: Only set advance_payment_type, never final_payment_type (but skip for IOU, refund, other, and cash_in with advance/salary/md_cash_in/other source)
            // Check radio button state to get advance_payment_type
            let advancePaymentTypeValue = $('input[name="advance_payment_type"]:checked').val();
            if (advancePaymentTypeValue && (advancePaymentTypeValue === 'outsource_supplier' || advancePaymentTypeValue === 'employee' || advancePaymentTypeValue === 'supplier')) {
                formData.advance_payment_type = advancePaymentTypeValue;
                // Explicitly remove final_payment_type if it exists (should not be set for advance payments)
                if (formData.final_payment_type) {
                    delete formData.final_payment_type;
                }
                
                // For outsource_supplier, also preserve supplier_job_id, advance_date, and outsource_supplier_id
                if (advancePaymentTypeValue === 'outsource_supplier') {
                let supplierJobId = $('#outsource_job_select').val();
                let outsourceSupplierId = $('#outsource_supplier_select').val();
                let advanceDate = $('#outsource_advance_date').val();
                
                console.log('Outsource supplier fields:', { supplierJobId, outsourceSupplierId, advanceDate });
                
                // Always include these fields when outsource_supplier is selected (required by validation)
                // supplier_job_id is required
                if (supplierJobId && supplierJobId !== '' && supplierJobId !== '0') {
                    formData.supplier_job_id = parseInt(supplierJobId, 10);
                }
                
                if (outsourceSupplierId && outsourceSupplierId !== '' && outsourceSupplierId !== '0') {
                    formData.outsource_supplier_id = parseInt(outsourceSupplierId, 10);
                }
                
                // advance_date is required
                if (advanceDate && advanceDate !== '') {
                    formData.advance_date = advanceDate;
                }
            }
            }
        }
        
        // Final check: If outsource_supplier is selected (advance or final), ensure required fields are present
        if (formData.advance_payment_type === 'outsource_supplier' || formData.final_payment_type === 'outsource_supplier') {
            if (!formData.supplier_job_id) {
                let supplierJobId = $('#outsource_job_select').val();
                if (supplierJobId && supplierJobId !== '' && supplierJobId !== '0') {
                    formData.supplier_job_id = parseInt(supplierJobId, 10);
                }
            }
            if (!formData.advance_date) {
                let advanceDate = $('#outsource_advance_date').val();
                if (advanceDate && advanceDate !== '') {
                    formData.advance_date = advanceDate;
                }
            }
        }
        
        // For IOU, refund, other source, or cash_in with excluded sources, explicitly remove advance_payment_type and final_payment_type if they exist (final cleanup)
        let movementTypeFinal = $('#movement_type').val();
        let isCashInExcludedSourceFinal = movementTypeFinal === 'cash_in' && (sourceValue === 'advance' || sourceValue === 'advance_cash' || sourceValue === 'salary' || sourceValue === 'md_cash_in' || sourceValue === 'other');
        if (sourceValue === 'iou' || sourceValue === 'refund' || sourceValue === 'other' || isCashInExcludedSourceFinal) {
            if (formData.advance_payment_type) {
                delete formData.advance_payment_type;
            }
            if (formData.final_payment_type) {
                delete formData.final_payment_type;
            }
        }
        
        // Add action parameter for edit
        if (isEditMode) {
            formData.action = 'edit';
        }

        console.log('Complete FormData being sent:', formData);
        console.log('Edit Mode:', isEditMode, 'Movement ID:', movementId);
        console.log('Source ID extracted:', sourceId, 'Type:', typeof sourceId);

        // Get submit button and disable it with loading state
        let $submitBtn = $('#btnSubmitMovement');
        let originalBtnHtml = $submitBtn.html();
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        // Determine URL based on edit mode
        let url = isEditMode 
            ? `<?= base_url("Cashier/CashMovement/updateCashMovement") ?>/${movementId}`
            : '<?= base_url("Cashier/CashMovement/createCashMovement") ?>';

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(res) {
                if(res.status) {
                    success_toastify(res.message || (isEditMode ? 'Movement updated successfully' : 'Movement created successfully'));
                    $('#addMovementModal').modal('hide');
                    
                    // Reload page after successful submission
                    setTimeout(function() {
                        location.reload();
                    }, 1000); // Wait 1 second to show success message before reload
                    return; // Exit early to prevent further execution
                    
                    $('#addMovementForm')[0].reset();
                    $('#movement_id').val(''); // Clear edit mode
                    $('#addMovementModalLabel').text('Add Cash Movement'); // Reset label
                    $('#btnSubmitText').text('Save Movement'); // Reset button text
                    $('#btnSubmitMovement').attr('title', 'Save Movement'); // Reset button title
                    // Reset checkbox state
                    $('#is_advance_payment').prop('checked', false);
                    // payee_select_group visibility is controlled by toggleAccountMasterField based on source
                    $('#employee_dropdown_group').hide();
                    $('#account_master_group').hide(); // Hide account master field
                    $('#account_master_id').val('');
                    $('#account_master_display').val('');
                    // Clear petty cash fields
                    $('#payeesContainer').empty();
                    $('#line_items_section').hide();
                    $('#single_payee_section').show();
                    payeeIndex = 0; // Reset payee index
                    lineItemIndex = 0; // Reset line item index
                    // Hide series dropdown by default
                    $('#series_group').hide();
                    $('#series').val(''); // No default selection
                    showSeriesDropdown = false;
                    // Reset outsource supplier fields
                    $('#outsource_supplier_select').val('').trigger('change');
                    $('#outsource_job_select').val('').trigger('change');
                    $('#outsource_advance_date').val('');
                    $('#outsource_advance_amount').val('');
                    $('#outsource_remarks').val('');
                    $('#job_details_display').hide();
                    $('#btnViewAdvancePayments').hide().removeData('job-id');
                    // Reset supplier and outsource supplier groups
                    $('#supplier_dropdown_group').hide();
                    $('#outsource_supplier_group').hide();
                    $('#advance_payment_type_group').hide();
                    // Clear supplier tables
                    $('#supplierAmountsBody').empty();
                    supplierRowIndex = 0;
                    $('#supplierAmountsTotal').text('0.00');
                    // Reload active shift after form reset (only for new records)
                    if (!isEditMode) {
                        loadActiveShift();
                    }
                    // Reload the DataTable
                    if ($.fn.DataTable.isDataTable('#movementsTable')) {
                        $('#movementsTable').DataTable().ajax.reload();
                    } else {
                        loadCashMovements();
                    }
                } else {
                    error_toastify(res.message || (isEditMode ? 'Failed to update movement' : 'Failed to create movement'));
                    // Re-enable button on error
                    $submitBtn.prop('disabled', false).html(originalBtnHtml);
                }
            },
            error: function() {
                error_toastify('Server error. Please try again.');
                // Re-enable button on error
                $submitBtn.prop('disabled', false).html(originalBtnHtml);
            }
        });
    });
});

function loadCashMovements(shiftId = '') {
    // For server-side processing, just re-initialize the table
    // The table will automatically fetch data via AJAX
    if ($.fn.DataTable.isDataTable('#movementsTable')) {
        // Update the table's filter and redraw
        let table = $('#movementsTable').DataTable();
        table.ajax.reload();
    } else {
        // Initialize table with server-side processing
        initializeMovementsTable(shiftId);
    }
}

function loadShifts() {
    $.ajax({
        url: '<?= base_url("Cashier/Shift/getAllCashierLog") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if(res.status && res.data) {
                let shiftOptions = '<option value="">-- All Shifts --</option>';
                res.data.forEach(function(shift) {
                    shiftOptions += `<option value="${shift.id}">Shift #${shift.id} - ${shift.opened_at || ''}</option>`;
                });
                $('#shiftFilter').html(shiftOptions);
                
                // Initialize or update Select2 based on readonly mode
                if (ENABLE_READONLY_SHIFT_FILTER && activeShiftId) {
                    // Set value first
                    $('#shiftFilter').val(activeShiftId);
                    // Destroy Select2 if already initialized
                    if ($('#shiftFilter').hasClass('select2-hidden-accessible')) {
                        $('#shiftFilter').select2('destroy');
                    }
                    // Make dropdown disabled and reinitialize Select2
                    $('#shiftFilter').prop('disabled', true);
                    $('#shiftFilter').select2({
                        disabled: true,
                        width: '100%'
                    });
                } else {
                    // Initialize Select2 normally (not readonly)
                    if (!$('#shiftFilter').hasClass('select2-hidden-accessible')) {
                        $('#shiftFilter').select2({
                            width: '100%'
                        });
                    }
                    // Set default to active shift if available (but allow changes)
                    if (activeShiftId) {
                        $('#shiftFilter').val(activeShiftId).trigger('change.select2');
                    }
                }
            }
        }
    });
}

function loadAllSourcesForFilter() {
    // Load all sources for filter dropdown (both cash_in and cash_out)
    $.ajax({
        url: '<?= base_url("Cashier/CashMovement/getSources") ?>',
        type: 'GET',
        data: {
            movement_type: '' // Empty to get all sources
        },
        dataType: 'json',
        success: function(res) {
            if(res.status && res.data && res.data.length > 0) {
                let sourceOptions = '<option value="">-- All Sources --</option>';
                res.data.forEach(function(source) {
                    if (source.id && source.code) {
                        sourceOptions += `<option value="${source.id}">${source.name || source.code}</option>`;
                    }
                });
                $('#filterSource').html(sourceOptions);
                
                // Initialize Select2 for source filter
                if (!$('#filterSource').hasClass('select2-hidden-accessible')) {
                    $('#filterSource').select2({
                        width: '100%',
                        placeholder: '-- All Sources --',
                        allowClear: true
                    });
                    
                }
            }
        },
        error: function() {
            console.error('Failed to load sources for filter');
        }
    });
}

function loadEmployees() {
    // Load employees for dropdown
    $.ajax({
        url: '<?= base_url("Cashier/CashMovement/getEmployees") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if(res.status && res.data) {
                let employeeDropdown = $('#employee_id');
                employeeDropdown.empty();
                employeeDropdown.append('<option value="">Select Employee(s)</option>');
                
                res.data.forEach(function(employee) {
                    // Format: emp_no (e.g., "ECW 001") - Employee Name
                    let empNo = employee.emp_no || '';
                    let employeeName = employee.calling_name || employee.emp_name_with_initial || 'Unknown';
                    
                    // Full display format: emp_no - Employee Name (e.g., "ECW 001 - John Doe")
                    let displayText = empNo ? (empNo + ' - ' + employeeName) : employeeName;
                    
                    employeeDropdown.append(
                        $('<option></option>')
                            .attr('value', employee.id)
                            .attr('data-code', empNo)
                            .attr('data-name', employeeName)
                            .text(displayText)
                    );
                });
                
                // Initialize Select2 with multiple selection and search functionality
                if ($.fn.select2) {
                    employeeDropdown.select2({
                        dropdownParent: $('#addMovementModal'),
                        placeholder: 'Select Employee(s)',
                        allowClear: true,
                        multiple: true,
                        closeOnSelect: false,
                        width: '100%'
                    });
                    
                    // Note: For multiple selection, we handle the change event instead of select2:select
                    // The change event handler is defined separately below
                }
            }
        },
        error: function() {
            console.error('Failed to load employees');
            error_toastify('Failed to load employee list. Please try again.');
        }
    });
}

function loadActiveShift() {
    $.ajax({
        url: '<?= base_url("Cashier/Shift/checkCashierShift") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if(res.status && res.shift && res.shift.id) {
                // Set the hidden field with active shift ID
                $('#cashier_shift_id').val(res.shift.id);
                activeShiftId = res.shift.id;
                
                // Update shift filter if readonly mode is enabled
                if (ENABLE_READONLY_SHIFT_FILTER) {
                    // Set value first
                    $('#shiftFilter').val(activeShiftId);
                    // Destroy Select2 if already initialized
                    if ($('#shiftFilter').hasClass('select2-hidden-accessible')) {
                        $('#shiftFilter').select2('destroy');
                    }
                    // Make dropdown disabled and reinitialize Select2
                    $('#shiftFilter').prop('disabled', true);
                    $('#shiftFilter').select2({
                        disabled: true,
                        width: '100%'
                    });
                }
            } else {
                // No active shift found - clear the hidden field
                $('#cashier_shift_id').val('');
                activeShiftId = null;
                // Show warning if trying to add movement without active shift
                if ($('#addMovementModal').hasClass('show')) {
                    warning_toastify('No active shift found. Please open a cashier shift first.');
                }
            }
        },
        error: function() {
            console.error('Failed to load active shift');
        }
    });
}

function initializeMovementsTable(shiftId = '') {
    if ($.fn.DataTable.isDataTable('#movementsTable')) {
        $('#movementsTable').DataTable().destroy();
    }

    // Use active shift as default if readonly mode is enabled, otherwise use provided shiftId or filter value
    let defaultShiftId = '';
    if (ENABLE_READONLY_SHIFT_FILTER && activeShiftId) {
        defaultShiftId = activeShiftId;
    } else {
        defaultShiftId = shiftId || $('#shiftFilter').val() || '';
    }

    $('#movementsTable').DataTable({
        processing: true,  // Show loading indicator
        serverSide: true,  // Enable server-side processing
        ajax: {
            url: '<?= base_url("Cashier/CashMovement/datatable") ?>',
            type: 'POST',
            data: function(d) {
                // Add custom filters
                d.shift_id = defaultShiftId;
                d.movement_type = $('#filterMovementType').val() || '';
                // Get source_id from Select2 filter (works with both Select2 and regular select)
                let sourceIdValue = $('#filterSource').val();
                d.source_id = sourceIdValue || '';
                // Debug: uncomment to check what value is being sent
                // console.log('Source ID filter value:', sourceIdValue);
                d.status = $('#filterStatus').val() || '';
                d.date_from = $('#filterDateFrom').val() || '';
                d.date_to = $('#filterDateTo').val() || '';
                // Include Series 2 (is_confirm = 0) only when showSeries2 is true
                d.include_series2 = showSeries2 ? 1 : 0;
            },
            error: function(xhr, error, code) {
                console.error('DataTable error:', error, code);
                error_toastify('Failed to load cash movements. Please try again.');
            }
        },
        order: [[11, 'desc']],
        pageLength: 25,  // Default records per page
        lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],  // Page size options
        columns: [
            { 
                data: 'code', 
                title: 'Code',
                className: 'text-center'
            },
            { 
                data: 'cashier_shift_id', 
                title: 'Shift ID',
                className: 'text-center'
            },
            { 
                data: 'movement_type', 
                title: 'Movement Type',
                className: 'text-center text-capitalize',
                render: function(d) {
                    let badgeClass = d === 'cash_in' ? 'success' : 'danger';
                    return `<span class="badge badge-${badgeClass}">${d.replace('_', ' ')}</span>`;
                }
            },
            { 
                data: 'source_name', 
                title: 'Source',
                className: 'text-center text-capitalize',
                defaultContent: '-',
                render: function(data, type, row) {
                    // Use source_name if available, fallback to source code
                    return data || row.source || '-';
                }
            },
            { 
                data: 'payee_name', 
                title: 'Payee',
                defaultContent: '-'
            },
            { 
                data: 'amount', 
                title: 'Amount',
                className: 'text-right',
                render: function(d) {
                    return Number(d ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            { 
                data: 'payment_type', 
                title: 'Payment Type',
                className: 'text-center text-capitalize'
            },
            { 
                data: 'status', 
                title: 'Status',
                className: 'text-center',
                render: function(d) {
                    if (d === 'approved') 
                        return '<span class="badge badge-success">Approved</span>';
                    else if (d === 'settled') 
                        return '<span class="badge badge-info">Settled</span>';
                    else 
                        return '<span class="badge badge-warning">Pending</span>';
                }
            },
            { 
                data: 'created_by', 
                title: 'Created By',
                defaultContent: '-',
                render: function(d) {
                    if (typeof d === 'object' && d !== null && d.name) {
                        return d.name;
                    }
                    if (typeof d === 'string' || typeof d === 'number') {
                        return d;
                    }
                    return '-';
                }
            },
            { 
                data: 'approved_by', 
                title: 'Approved By',
                defaultContent: '-',
                render: function(d) {
                    if (typeof d === 'object' && d !== null && d.name) {
                        return d.name;
                    }
                    if (typeof d === 'string' || typeof d === 'number') {
                        return d;
                    }
                    return '-';
                }
            },
            { 
                data: 'remarks', 
                title: 'Remarks',
                defaultContent: '-'
            },
            { 
                data: 'created_at', 
                title: 'Created At',
                className: 'text-center',
                render: function(d) {
                    if (!d) return '-';
                    // Handle ISO date format (e.g., "2025-12-08T11:25:24.000000Z")
                    try {
                        let date = new Date(d);
                        if (isNaN(date.getTime())) {
                            return d; // Return as-is if not a valid date
                        }
                        return date.toLocaleString();
                    } catch(e) {
                        return d;
                    }
                }
            },
            { 
                data: null, 
                title: 'Actions',
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function(row) {
                    let actions = '';
                    
                    // Show view details button for all movements
                    actions += `<button class="btn btn-sm btn-secondary" onclick="viewMovementDetails(${row.id})" title="View Details" data-toggle="tooltip" data-placement="top">
                        <i class="fas fa-eye"></i>
                    </button> `;
                    
                    // Show edit button for pending movements
                    if (row.status == 'pending') {
                        actions += `<button class="btn btn-sm btn-info" onclick="editMovement(${row.id})" title="Edit Movement" data-toggle="tooltip" data-placement="top">
                            <i class="fas fa-edit"></i>
                        </button> `;
                    }
                    
                    // Show approve button for pending cash_out movements
                    if (row.status == 'pending') {
                        actions += `<button class="btn btn-sm btn-success" onclick="approveMovement(${row.id})" title="Approve Movement" data-toggle="tooltip" data-placement="top">
                            <i class="fas fa-check"></i>
                        </button> `;
                    }
                    
                    // Show cancel button for approved movements (both cash_in and cash_out, except IOU with settlements)
                    // BUT hide cancel button if:
                    // 1. This is a reversal entry (is_reversal === 1 or reversed_movement_id exists)
                    // 2. This movement has been reversed (has_reversals > 0)
                    if (row.status == 'approved') {
                        // Check if this is a reversal entry (is_reversal === 1 OR reversed_movement_id exists)
                        let isReversalEntry = (row.is_reversal && row.is_reversal == 1) || (row.reversed_movement_id && row.reversed_movement_id > 0) || false;
                        // Check if this movement has been reversed (has_reversals > 0 means someone created a reversal for this movement)
                        let hasReversals = (row.has_reversals && row.has_reversals > 0) || false;
                        
                        // Don't show cancel button for reversal entries or movements that have been reversed
                        if (isReversalEntry || hasReversals) {
                            // Skip cancel button
                        } else {
                            // Check source code (handle both normalized structure and legacy format)
                            let sourceCode = row.source;
                            if (row.source && typeof row.source === 'object' && row.source.code) {
                                sourceCode = row.source.code;
                            }
                            
                            // Hide cancel button for approved IOUs with settlements (IOUs with settlements cannot be cancelled)
                            let hasSettlements = (row.settlements_count && row.settlements_count > 0) || false;
                            
                            // Show cancel button only if:
                            // 1. Not an IOU, OR
                            // 2. Is an IOU but has no settlements
                            // 3. Not an IOU settlement return (these are system-generated and cannot be cancelled)
                            if (sourceCode !== 'iou_settlement_return' && (sourceCode !== 'iou' || (sourceCode === 'iou' && !hasSettlements))) {
                                actions += `<button class="btn btn-sm btn-warning" onclick="cancelMovementApproval(${row.id})" title="Cancel Approval" data-toggle="tooltip" data-placement="top">
                                    <i class="fas fa-times"></i>
                                </button> `;
                            }
                        }
                        
                        // Check source code for print button (handle both normalized structure and legacy format)
                        let sourceCode = row.source;
                        if (row.source && typeof row.source === 'object' && row.source.code) {
                            sourceCode = row.source.code;
                        }
                        
                        // Show print button for approved petty cash movements
                        if (sourceCode === 'petty') {
                            actions += `<button class="btn btn-sm btn-info" onclick="printPettyCashVoucher(${row.id})" title="Print Voucher" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-print"></i>
                            </button> `;
                        }
                    }
                    
                    if (row.status == 'pending') {
                        actions += `<button class="btn btn-sm btn-danger" onclick="deleteMovement(${row.id})" title="Delete Movement" data-toggle="tooltip" data-placement="top">
                            <i class="fas fa-trash"></i>
                        </button>`;
                    }
                    
                    return actions || '-';
                }
            }
        ]
    });
}

// Helper function to handle advance/final payment type edit
function handleAdvancePaymentTypeEdit(data) {
    // Determine payment category and type
    let paymentCategory = data.payment_category ? (data.payment_category.code || data.payment_category.name) : null;
    let isFinalPaymentCategory = paymentCategory === 'final_payment' || 
        (data.payment_category && (data.payment_category.name || '').toLowerCase().includes('final payment'));
    let isAdvancePaymentCategory = paymentCategory === 'advance_payment' || 
        (data.payment_category && (data.payment_category.name || '').toLowerCase().includes('advance payment'));
    
    // Check if it's final payment or advance payment with outsource supplier
    let isFinalPaymentOutsource = isFinalPaymentCategory && data.final_payment_type === 'outsource_supplier';
    let isAdvancePaymentOutsource = isAdvancePaymentCategory && data.advance_payment_type === 'outsource_supplier';
    
    // First, check and set the radio button based on payment category
    if (isFinalPaymentCategory && data.final_payment_type) {
        // For final payment: set final_payment_type radio button
        $('input[name="final_payment_type"][value="' + data.final_payment_type + '"]').prop('checked', true).trigger('change');
        
        // After triggering change, ensure required attributes are properly set/removed
        setTimeout(function() {
            updateRequiredFieldsForAdvanceType(data.final_payment_type);
        }, 100);
    } else if (isAdvancePaymentCategory && data.advance_payment_type) {
        // For advance payment: set advance_payment_type radio button
        $('input[name="advance_payment_type"][value="' + data.advance_payment_type + '"]').prop('checked', true).trigger('change');
        
        // After triggering change, ensure required attributes are properly set/removed
        setTimeout(function() {
            updateRequiredFieldsForAdvanceType(data.advance_payment_type);
        }, 100);
    } else if (isAdvancePaymentCategory && !data.advance_payment_type) {
        // Handle other advance payment types (employee, supplier) - they don't have outsource supplier
        let advanceType = data.advance_payment_type || 'employee'; // Default to employee if not set
        if (advanceType === 'employee' || advanceType === 'supplier') {
            $('input[name="advance_payment_type"][value="' + advanceType + '"]').prop('checked', true).trigger('change');
            setTimeout(function() {
                updateRequiredFieldsForAdvanceType(advanceType);
            }, 100);
        }
    }
    
    // Update labels based on payment type
    if (isFinalPaymentOutsource || isAdvancePaymentOutsource) {
        updateOutsourceSupplierLabels(isFinalPaymentOutsource);
    }
    
    // Then handle outsource supplier details if it's outsource_supplier type (advance or final)
    if ((isAdvancePaymentOutsource || isFinalPaymentOutsource) && data.supplier_jobs && data.supplier_jobs.length > 0) {
        let supplierJob = data.supplier_jobs[0];
        let job = supplierJob.supplier_job || {};
        
        // Store advance_date for later use (in case job loading fails)
        let advanceDateToSet = supplierJob.advance_date;
        
        // Wait for outsource supplier section to show and Select2 to initialize
        setTimeout(function() {
            // Load suppliers first, then set supplier and job
            if (job.supplier_id) {
                // Load suppliers if not already loaded
                loadOutsourceSuppliers();
                
                // Wait for Select2 to initialize, then set supplier
                setTimeout(function() {
                    // Update new_job_supplier_id first
                    $('#new_job_supplier_id').val(job.supplier_id);
                    
                    // Now manually load jobs with callback FIRST (before setting supplier value)
                    // This ensures jobs are loaded before we set the supplier value
                    // Load jobs first (this populates the dropdown)
                    loadSupplierJobs(job.supplier_id, function(success) {
                        if (success) {
                            // Jobs are loaded, now set supplier value and update Select2 display
                            // Use a flag to prevent the change handler from clearing job
                            window._skipSupplierChangeHandler = true;
                            $('#outsource_supplier_select').val(job.supplier_id).trigger('change');
                            setTimeout(function() {
                                window._skipSupplierChangeHandler = false;
                            }, 100);
                            
                            // Now set the job value
                            let $jobSelect = $('#outsource_job_select');
                            
                            // Check if job option exists, if not add it
                            if ($jobSelect.find('option[value="' + job.id + '"]').length > 0) {
                                $jobSelect.val(job.id).trigger('change');
                            } else {
                                // If job option doesn't exist, add it with proper data attributes
                                let jobCode = job.code || '';
                                let jobName = job.job_name || '';
                                let jobValue = parseFloat(job.job_value || 0);
                                // Calculate total advances from all advance payments for this job
                                let totalAdvances = parseFloat(supplierJob.advance_amount || 0);
                                let remainingBalance = jobValue - totalAdvances;
                                
                                let optionText = jobCode + ' - ' + jobName + ' (Balance: ' + formatPriceWithCommas(remainingBalance) + ')';
                                let $newOption = new Option(optionText, job.id, true, true);
                                $jobSelect.append($newOption);
                                // Set data attributes for the option
                                $jobSelect.find('option[value="' + job.id + '"]')
                                    .attr('data-job-value', jobValue)
                                    .attr('data-total-advances', totalAdvances)
                                    .attr('data-remaining-balance', remainingBalance);
                                $jobSelect.val(job.id).trigger('change');
                            }
                            
                            // Set advance date using helper function
                            if (supplierJob.advance_date) {
                                setAdvanceDateValue(supplierJob.advance_date);
                            }
                            
                            // Set advance amount
                            if (supplierJob.advance_amount) {
                                $('#outsource_advance_amount').val(formatPriceWithCommas(supplierJob.advance_amount));
                            }
                            
                            // Set remarks for outsource supplier
                            if (supplierJob.remarks) {
                                $('#outsource_remarks').val(supplierJob.remarks);
                            }
                        } else {
                            // If job loading failed, still try to set advance_date
                            if (advanceDateToSet) {
                                setAdvanceDateValue(advanceDateToSet);
                            }
                        }
                    });
                }, 300);
            } else {
                // If no supplier_id, still try to set advance_date
                if (advanceDateToSet) {
                    setTimeout(function() {
                        setAdvanceDateValue(advanceDateToSet);
                    }, 500);
                }
            }
        }, 300);
    }
    
    // Handle employee data loading for advance payment employee type
    if (isAdvancePaymentCategory && data.advance_payment_type === 'employee' && data.employees && data.employees.length > 0) {
        setTimeout(function() {
            $('#employeeAmountsBody').empty();
            employeeRowIndex = 0;
            
            data.employees.forEach(function(emp, index) {
                addEmployeeRow();
                let $row = $('#employeeAmountsBody tr').last();
                
                // Set employee after Select2 is initialized
                let $employeeSelect = $row.find('.employee-select');
                // Use employee_id if available, otherwise employee_no
                let employeeId = emp.employee_id || emp.id || emp.employee_no;
                if (employeeId) {
                    // Wait for Select2 to initialize, then set value
                    setTimeout(function() {
                        // For Select2 AJAX, create option if it doesn't exist
                        if ($employeeSelect.find('option[value="' + employeeId + '"]').length === 0) {
                            // Create a new option (Select2 will fetch the data via AJAX when selected)
                            let displayText = emp.employee_no ? (emp.employee_no + ' - Loading...') : 'Loading...';
                            let newOption = new Option(displayText, employeeId, true, true);
                            $employeeSelect.append(newOption);
                        }
                        $employeeSelect.val(employeeId).trigger('change');
                        
                        // Set amount, employee type, and remark after a small delay to ensure Select2 has processed
                        setTimeout(function() {
                            if (emp.amount) {
                                $row.find('.employee-amount').val(formatPriceWithCommas(emp.amount));
                            }
                            
                            // Set employee type
                            if (emp.employee_type) {
                                $row.find('.employee-type-select').val(emp.employee_type);
                            }
                            
                            // Set remark
                            if (emp.remark) {
                                $row.find('.employee-remark').val(emp.remark);
                            }
                            
                            // Update total after all rows are processed
                            if (index === data.employees.length - 1) {
                                // Wait a bit more to ensure all amounts are set, then update total
                                setTimeout(function() {
                                    updateEmployeeAmountsTotal();
                                }, 200);
                            }
                        }, 100);
                    }, index * 200); // Stagger the loading to avoid race conditions
                }
            });
        }, 400);
    }
    
    // Handle supplier data loading for advance payment supplier type and final payment supplier type
    if (((isAdvancePaymentCategory && data.advance_payment_type === 'supplier') || 
         (isFinalPaymentCategory && data.final_payment_type === 'supplier')) && 
        data.suppliers && data.suppliers.length > 0) {
        setTimeout(function() {
            $('#supplierAmountsBody').empty();
            supplierRowIndex = 0;
            
            data.suppliers.forEach(function(supp, index) {
                addSupplierRow();
                let $row = $('#supplierAmountsBody tr').last();
                
                // Set supplier after Select2 is initialized
                let $supplierSelect = $row.find('.supplier-select');
                if (supp.supplier_id) {
                    // Wait for Select2 to initialize, then set value
                    setTimeout(function() {
                        // For Select2 AJAX, create option if it doesn't exist
                        if ($supplierSelect.find('option[value="' + supp.supplier_id + '"]').length === 0) {
                            // Create a new option (Select2 will fetch the data via AJAX when selected)
                            let newOption = new Option('Loading...', supp.supplier_id, true, true);
                            $supplierSelect.append(newOption);
                        }
                        $supplierSelect.val(supp.supplier_id).trigger('change');
                        
                        // Set amount after a small delay to ensure Select2 has processed
                        setTimeout(function() {
                            if (supp.amount) {
                                $row.find('.supplier-amount').val(formatPriceWithCommas(supp.amount));
                            }
                            
                            // Set remark
                            if (supp.remark) {
                                $row.find('.supplier-remark').val(supp.remark);
                            }
                            
                            // Update total after all rows are processed
                            if (index === data.suppliers.length - 1) {
                                // Wait a bit more to ensure all amounts are set, then update total
                                setTimeout(function() {
                                    updateSupplierAmountsTotal();
                                }, 200);
                            }
                        }, 100);
                    }, index * 200); // Stagger the loading to avoid race conditions
                }
            });
        }, 400);
    }
}

// Helper function to update required fields based on advance payment type
function updateRequiredFieldsForAdvanceType(advanceType) {
    // Check source first - for IOU, refund, other source, or cash_in with advance/salary/md_cash_in/other, never require advance month fields
    let currentSource = $('#source').val();
    let movementType = $('#movement_type').val();
    let isCashInExcludedSource = movementType === 'cash_in' && (currentSource === 'advance' || currentSource === 'salary' || currentSource === 'md_cash_in' || currentSource === 'other');
    let isIouSource = currentSource === 'iou' || currentSource === 'refund' || currentSource === 'other' || isCashInExcludedSource;
    
    if (advanceType === 'outsource_supplier') {
        // Remove required from employee fields when outsource_supplier is selected
        // Use both prop and removeAttr to ensure it's completely removed
        $('#employeeAmountsBody .employee-select').prop('required', false).removeAttr('required');
        $('#employeeAmountsBody .employee-amount').prop('required', false).removeAttr('required');
        $('#employeeAmountsBody .employee-type-select').prop('required', false).removeAttr('required');
        
        // Hide advance month fields and schedule groups
        $('#advance_month_common_group').hide();
        $('#schedule_groups_group').hide();
        $('#advance_applicable_year').prop('required', false).removeAttr('required');
        $('#advance_applicable_month').prop('required', false).removeAttr('required');
        $('#pay_cycle').prop('required', false).removeAttr('required');
        $('#schedule_groups').prop('required', false).removeAttr('required');
        
        // Ensure outsource advance date and amount are required
        $('#outsource_advance_date').prop('required', true);
        $('#outsource_advance_amount').prop('required', true);
    } else if (advanceType === 'supplier') {
        // For supplier type (not outsource), hide advance month fields and schedule groups, make them not required
        $('#advance_month_common_group').hide();
        $('#schedule_groups_group').hide();
        $('#advance_applicable_year').prop('required', false).removeAttr('required');
        $('#advance_applicable_month').prop('required', false).removeAttr('required');
        $('#pay_cycle').prop('required', false).removeAttr('required');
        $('#schedule_groups').prop('required', false).removeAttr('required');
        
        // Remove required from outsource fields
        $('#outsource_advance_date').prop('required', false).removeAttr('required');
        $('#outsource_advance_amount').prop('required', false).removeAttr('required');
        $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required');
        
        // Remove required from employee fields (supplier type doesn't use employees)
        $('#employeeAmountsBody .employee-select').prop('required', false).removeAttr('required');
        $('#employeeAmountsBody .employee-amount').prop('required', false).removeAttr('required');
        $('#employeeAmountsBody .employee-type-select').prop('required', false).removeAttr('required');
    } else {
        // For employee type, ensure employee fields are required if visible
        if ($('#employee_dropdown_group').is(':visible')) {
            $('#employeeAmountsBody .employee-select').prop('required', true);
            $('#employeeAmountsBody .employee-amount').prop('required', true);
        }
        
        // Show entry type selection for advance payment employee type (but not for final payment)
        let paymentCategory = $('#payment_category').val();
        let isFinalPaymentCheck = paymentCategory === 'final_payment' || $('#payment_category').find('option:selected').text().toLowerCase().includes('final payment');
        if ((paymentCategory === 'advance_payment' || paymentCategory === 'loan') && !isFinalPaymentCheck) {
            $('#advance_month_common_group').show();
            
            // Ensure Manual Entry is selected by default
            if (!$('input[name="advance_entry_type"]:checked').length) {
                $('input[name="advance_entry_type"][value="manual"]').prop('checked', true);
            }
            
            // Get selected entry type (default to manual if not set)
            let entryType = $('input[name="advance_entry_type"]:checked').val() || 'manual';
            if (typeof handleAdvanceEntryTypeChange === 'function') {
                handleAdvanceEntryTypeChange(entryType);
            } else {
                // Fallback: manually show/hide fields for manual entry (default)
                $('#manual_entry_group').show();
                $('#automated_entry_group').hide();
                $('#schedule_groups_group').hide();
                // Only set required if source is not IOU
                if (!isIouSource) {
                    $('#advance_applicable_year').prop('required', true);
                    $('#advance_applicable_month').prop('required', true);
                } else {
                    $('#advance_applicable_year').prop('required', false).removeAttr('required');
                    $('#advance_applicable_month').prop('required', false).removeAttr('required');
                }
                $('#pay_cycle').prop('required', false).removeAttr('required');
                $('#schedule_groups').prop('required', false).removeAttr('required');
            }
        } else {
            // Hide for final payment or other cases
            $('#advance_month_common_group').hide();
            $('#manual_entry_group').hide();
            $('#automated_entry_group').hide();
            $('#schedule_groups_group').hide();
            $('#pay_cycle').prop('required', false).removeAttr('required');
            $('#schedule_groups').prop('required', false).removeAttr('required');
            $('#advance_applicable_year').prop('required', false).removeAttr('required');
            $('#advance_applicable_month').prop('required', false).removeAttr('required');
        }
        
        // Remove required from outsource fields for employee type
        $('#outsource_advance_date').prop('required', false).removeAttr('required');
        $('#outsource_advance_amount').prop('required', false).removeAttr('required');
        $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required');
    }
    
        // Final cleanup: For IOU, refund, other source, or cash_in with advance/salary/md_cash_in/other, ensure advance month fields are not required
        if (isIouSource) {
            $('#advance_applicable_year').prop('required', false).removeAttr('required');
            $('#advance_applicable_month').prop('required', false).removeAttr('required');
            $('#pay_cycle').prop('required', false).removeAttr('required');
            $('#schedule_groups').prop('required', false).removeAttr('required');
        }
    
    // Also remove required from any hidden fields - do this more aggressively
    $('input[required], select[required], textarea[required]').each(function() {
        let $field = $(this);
        let $parentGroup = $field.closest('#employee_dropdown_group, #supplier_dropdown_group, #outsource_supplier_group, #grn_code_group');
        
        // Specifically handle outsource_advance_amount - only required when outsource_supplier_group is visible
        if ($field.attr('id') === 'outsource_advance_amount' || $field.attr('name') === 'outsource_advance_amount') {
            if (!$('#outsource_supplier_group').is(':visible')) {
                $field.prop('required', false).removeAttr('required');
            }
            return; // Skip further checks for this field
        }
        
        // For IOU, refund, other source, or cash_in with advance/salary/md_cash_in/other, remove required from advance month fields
        if (isIouSource && ($field.attr('id') === 'advance_applicable_year' || $field.attr('id') === 'advance_applicable_month' || 
            $field.attr('name') === 'advance_applicable_year' || $field.attr('name') === 'advance_applicable_month')) {
            $field.prop('required', false).removeAttr('required');
            return; // Skip further checks for this field
        }
        
        if ($field.is(':hidden') || 
            $field.closest('[style*="display: none"], [style*="display:none"]').length > 0 ||
            $field.closest('.hide').length > 0 ||
            ($field.closest('#grn_code_group').length > 0 && $('#grn_code_group').is(':hidden')) ||
            ($field.closest('#employee_dropdown_group').length > 0 && $('#employee_dropdown_group').is(':hidden')) ||
            ($field.closest('#supplier_dropdown_group').length > 0 && $('#supplier_dropdown_group').is(':hidden')) ||
            ($field.closest('#outsource_supplier_group').length > 0 && $('#outsource_supplier_group').is(':hidden')) ||
            ($parentGroup.length > 0 && $parentGroup.is(':hidden'))) {
            $field.prop('required', false);
            $field.removeAttr('required'); // Also remove the attribute completely
        }
    });
    
    // Special handling for employee fields - remove required if employee dropdown group is hidden
    // Check ALL employee fields, not just those with [required] attribute, because some may have it in HTML
    if ($('#employee_dropdown_group').is(':hidden')) {
        $('#employeeAmountsBody .employee-select, #employeeAmountsBody .employee-amount, #employeeAmountsBody .employee-type-select').each(function() {
            $(this).prop('required', false).removeAttr('required');
        });
    }
    
    // Special handling for supplier fields - remove required if supplier dropdown group is hidden
    if ($('#supplier_dropdown_group').is(':hidden')) {
        $('#supplierAmountsBody input[required], #supplierAmountsBody select[required]').each(function() {
            $(this).prop('required', false).removeAttr('required');
        });
    }
}

// Helper function to set advance date value with proper formatting
function setAdvanceDateValue(dateValue) {
    if (!dateValue) return;
    
    let advanceDate = dateValue;
    // If date is in a different format, convert it
    if (advanceDate.includes(' ')) {
        // If it has time, extract just the date part
        advanceDate = advanceDate.split(' ')[0];
    }
    // Ensure it's in YYYY-MM-DD format
    if (advanceDate.match(/^\d{4}-\d{2}-\d{2}$/)) {
        $('#outsource_advance_date').val(advanceDate);
    } else {
        // Try to parse and format
        let dateObj = new Date(advanceDate);
        if (!isNaN(dateObj.getTime())) {
            let year = dateObj.getFullYear();
            let month = String(dateObj.getMonth() + 1).padStart(2, '0');
            let day = String(dateObj.getDate()).padStart(2, '0');
            $('#outsource_advance_date').val(`${year}-${month}-${day}`);
        }
    }
    console.log('Setting advance_date:', dateValue, '->', $('#outsource_advance_date').val());
}

function editMovement(id) {
    // Show modal with loading indicator
    $('#addMovementModal').modal('show');
    
    // Show loading indicator, hide form content
    $('#modalLoadingIndicator').show();
    $('#modalFormContent').hide();
    $('#btnSubmitMovement').prop('disabled', true);
    
    // Declare variables in function scope for use in callbacks
    let isOutsourceSupplierEdit = false;
    let amountValue = 0;
    let remarksValue = '';
    
    $.ajax({
        url: `<?= base_url("Cashier/CashMovement/getCashMovement") ?>/${id}`,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if(res.status && res.data) {
                let data = res.data;
                
                console.log('Edit Movement Data:', data);
                console.log('Amount from API:', data.amount, 'Type:', typeof data.amount);
                console.log('Remarks from API:', data.remarks, 'Type:', typeof data.remarks);
                
                // Update modal title and button text for edit mode
                $('#addMovementModalLabel').text('Edit Cash Movement');
                $('#btnSubmitText').text('Update Movement');
                $('#btnSubmitMovement').attr('title', 'Update Movement');
                $('#movement_id').val(data.id);
                $('#cashier_shift_id').val(data.cashier_shift_id);
                
                // Determine if this is an outsource supplier edit (for both advance and final payment)
                let isAdvanceOutsource = data.source === 'petty' && data.payment_category && 
                    (data.payment_category.code === 'advance_payment' || data.payment_category.name === 'Advance Payment') &&
                    data.advance_payment_type === 'outsource_supplier';
                let isFinalOutsource = data.source === 'petty' && data.payment_category && 
                    (data.payment_category.code === 'final_payment' || data.payment_category.name === 'Final Payment') &&
                    data.final_payment_type === 'outsource_supplier';
                isOutsourceSupplierEdit = isAdvanceOutsource || isFinalOutsource;
                
                // STEP 1: Set movement type first
                $('#movement_type').val(data.movement_type);
                
                // STEP 2: Load sources based on movement type, then set source
                fetchSourcesFromAPI(data.movement_type).then(function(sources) {
                    // Populate source dropdown first
                    let $sourceSelect = $('#source');
                    let currentSource = data.source_id || data.source;
                    
                    // Clear existing options except the first one
                    $sourceSelect.find('option:not(:first)').remove();
                    
                    // Add sources from API
                    sources.forEach(function(source) {
                        if (!source.id) {
                            return; // Skip sources without id
                        }
                        
                        let sourceIdInt = parseInt(source.id, 10);
                        if (isNaN(sourceIdInt)) {
                            return;
                        }
                        
                        let $newOption = $('<option>', {
                            value: source.code,
                            text: source.name
                        });
                        
                        // Set data attributes
                        $newOption.attr('data-movement-type', source.movement_type);
                        $newOption.attr('data-source-id', sourceIdInt);
                        
                        $sourceSelect.append($newOption);
                    });
                    
                    // Find source by ID or code
                    let selectedSource = null;
                    if (data.source_id) {
                        selectedSource = sources.find(s => s.id == data.source_id);
                    } else if (data.source) {
                        selectedSource = sources.find(s => s.code === data.source || s.id == data.source);
                    }
                    
                    // Set the source value
                    if (selectedSource) {
                        $sourceSelect.val(selectedSource.code);
                    } else if (data.source) {
                        $sourceSelect.val(data.source);
                    }
                    
                    // STEP 3: Trigger source change to load payment categories if needed
                    setTimeout(function() {
                        $('#source').trigger('change');
                        
                        // STEP 4: If source is petty, load payment categories
                        if (data.source === 'petty' || (selectedSource && selectedSource.code === 'petty')) {
                            fetchPaymentCategoriesFromAPI().then(function(categories) {
                                // Populate payment category dropdown
                                let $categorySelect = $('#payment_category');
                                let categoryCode = data.payment_category ? (data.payment_category.code || data.payment_category.id) : null;
                                
                                if (categoryCode) {
                                    $categorySelect.val(categoryCode);
                                    
                                    // STEP 5: Trigger category change to show advance payment type UI
                                    setTimeout(function() {
                                        $('#payment_category').trigger('change');
                                        
                                        // STEP 6: Handle advance/final payment type after UI loads
                                        setTimeout(function() {
                                            handleAdvancePaymentTypeEdit(data);
                                            // After advance/final payment type is handled, populate other fields
                                            populateOtherEditFields(data);
                                            
                                            // Update required fields one more time after all data is loaded
                                            // Check both advance_payment_type and final_payment_type
                                            let paymentCategoryCheck = data.payment_category ? (data.payment_category.code || data.payment_category.name) : null;
                                            let isFinalPaymentCheck = paymentCategoryCheck === 'final_payment' || 
                                                (data.payment_category && (data.payment_category.name || '').toLowerCase().includes('final payment'));
                                            let paymentType = isFinalPaymentCheck ? data.final_payment_type : data.advance_payment_type;
                                            if (paymentType) {
                                                updateRequiredFieldsForAdvanceType(paymentType);
                                            } else {
                                                // No payment type - ensure outsource fields are not required (for multiple payees mode)
                                                if ($('#outsource_supplier_group').is(':hidden') || !$('#outsource_supplier_group').is(':visible')) {
                                                    $('#outsource_advance_amount').prop('required', false).removeAttr('required');
                                                    $('#outsource_advance_date').prop('required', false).removeAttr('required');
                                                    $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required');
                                                }
                                            }
                                            
                                            // All data loaded - hide loading indicator and show form content
                                            $('#modalLoadingIndicator').hide();
                                            $('#modalFormContent').show();
                                            $('#btnSubmitMovement').prop('disabled', false).html('<i class="fas fa-save"></i>');
                                        }, 300);
                                    }, 200);
                                } else {
                                    // No category, continue with other fields
                                    populateOtherEditFields(data);
                                    
                                    // Update required fields based on payment type if exists
                                    let paymentCategoryCheck2 = data.payment_category ? (data.payment_category.code || data.payment_category.name) : null;
                                    let isFinalPaymentCheck2 = paymentCategoryCheck2 === 'final_payment' || 
                                        (data.payment_category && (data.payment_category.name || '').toLowerCase().includes('final payment'));
                                    let paymentType2 = isFinalPaymentCheck2 ? data.final_payment_type : data.advance_payment_type;
                                    if (paymentType2) {
                                        updateRequiredFieldsForAdvanceType(paymentType2);
                                    } else {
                                        // No payment type - ensure outsource fields are not required (for multiple payees mode)
                                        if ($('#outsource_supplier_group').is(':hidden') || !$('#outsource_supplier_group').is(':visible')) {
                                            $('#outsource_advance_amount').prop('required', false).removeAttr('required');
                                            $('#outsource_advance_date').prop('required', false).removeAttr('required');
                                            $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required');
                                        }
                                    }
                                    
                                    // Final cleanup: For IOU, refund, other source, or cash_in with advance/salary/md_cash_in/other, ensure advance month fields are not required
                                    let currentSource2 = $('#source').val();
                                    let movementType2 = $('#movement_type').val();
                                    let isCashInExcludedSource2 = movementType2 === 'cash_in' && (currentSource2 === 'advance' || currentSource2 === 'salary' || currentSource2 === 'md_cash_in' || currentSource2 === 'other');
                                    if (currentSource2 === 'iou' || currentSource2 === 'refund' || currentSource2 === 'other' || isCashInExcludedSource2) {
                                        $('#advance_applicable_year').prop('required', false).removeAttr('required');
                                        $('#advance_applicable_month').prop('required', false).removeAttr('required');
                                        $('#pay_cycle').prop('required', false).removeAttr('required');
                                        $('#schedule_groups').prop('required', false).removeAttr('required');
                                    }
                                    
                                    // All data loaded - hide loading indicator and show form content
                                    $('#modalLoadingIndicator').hide();
                                    $('#modalFormContent').show();
                                    $('#btnSubmitMovement').prop('disabled', false).html('<i class="fas fa-save"></i>');
                                }
                            });
                        } else {
                            // Not petty source, continue with other fields
                            populateOtherEditFields(data);
                            
                            // For IOU, refund, other source, or cash_in with advance/salary/md_cash_in/other, ensure advance month fields are not required
                            let currentSource = $('#source').val();
                            let movementType = $('#movement_type').val();
                            let isCashInExcludedSource = movementType === 'cash_in' && (currentSource === 'advance' || currentSource === 'salary' || currentSource === 'md_cash_in' || currentSource === 'other');
                            if (currentSource === 'iou' || currentSource === 'refund' || currentSource === 'other' || isCashInExcludedSource) {
                                $('#advance_applicable_year').prop('required', false).removeAttr('required');
                                $('#advance_applicable_month').prop('required', false).removeAttr('required');
                                $('#pay_cycle').prop('required', false).removeAttr('required');
                                $('#schedule_groups').prop('required', false).removeAttr('required');
                            }
                            
                            // Update required fields based on payment type if exists
                            let paymentCategoryCheck3 = data.payment_category ? (data.payment_category.code || data.payment_category.name) : null;
                            let isFinalPaymentCheck3 = paymentCategoryCheck3 === 'final_payment' || 
                                (data.payment_category && (data.payment_category.name || '').toLowerCase().includes('final payment'));
                            let paymentType3 = isFinalPaymentCheck3 ? data.final_payment_type : data.advance_payment_type;
                            if (paymentType3) {
                                updateRequiredFieldsForAdvanceType(paymentType3);
                            } else {
                                // No payment type - ensure outsource fields are not required (for multiple payees mode)
                                if ($('#outsource_supplier_group').is(':hidden') || !$('#outsource_supplier_group').is(':visible')) {
                                    $('#outsource_advance_amount').prop('required', false).removeAttr('required');
                                    $('#outsource_advance_date').prop('required', false).removeAttr('required');
                                    $('#outsource_supplier_select, #outsource_supplier_id').prop('required', false).removeAttr('required');
                                }
                            }
                            
                            // Final cleanup: For IOU, refund, other source, or cash_in with advance/salary/md_cash_in/other, ensure advance month fields are not required
                            let movementTypeFinal = $('#movement_type').val();
                            let isCashInExcludedSourceFinal = movementTypeFinal === 'cash_in' && (currentSource === 'advance' || currentSource === 'salary' || currentSource === 'md_cash_in' || currentSource === 'other');
                            if (currentSource === 'iou' || currentSource === 'refund' || currentSource === 'other' || isCashInExcludedSourceFinal) {
                                $('#advance_applicable_year').prop('required', false).removeAttr('required');
                                $('#advance_applicable_month').prop('required', false).removeAttr('required');
                                $('#pay_cycle').prop('required', false).removeAttr('required');
                                $('#schedule_groups').prop('required', false).removeAttr('required');
                            }
                            
                            // All data loaded - hide loading indicator and show form content
                            $('#modalLoadingIndicator').hide();
                            $('#modalFormContent').show();
                            $('#btnSubmitMovement').prop('disabled', false).html('<i class="fas fa-save"></i>');
                        }
                    }, 200);
                });
                
                // Helper function to populate other fields (called after sequential loading)
                function populateOtherEditFields(data) {
                    // Normalize source check (handle both string and object formats)
                    let sourceCode = (typeof data.source === 'string') ? data.source : (data.source && data.source.code) ? data.source.code : null;
                    
                    // Populate fields based on source
                    if (sourceCode === 'supplier') {
                        // For supplier: populate GRN amounts table
                        $('#grnAmountsBody').empty();
                        grnRowIndex = 0;
                        
                        if (data.grn_amounts && Array.isArray(data.grn_amounts) && data.grn_amounts.length > 0) {
                            // Populate GRN rows from API data
                            data.grn_amounts.forEach(function(grnItem) {
                                addGrnRow();
                                let $row = $('#grnAmountsBody tr').last();
                                
                                // Set GRN Code
                                let $grnSelect = $row.find('.grn-select');
                                if (grnItem.grn_code) {
                                    // Create option if it doesn't exist
                                    if ($grnSelect.find('option[value="' + grnItem.grn_code + '"]').length === 0) {
                                        $grnSelect.append(new Option(grnItem.grn_code, grnItem.grn_code, true, true));
                                    }
                                    $grnSelect.val(grnItem.grn_code).trigger('change');
                                }
                                
                                // Set amount
                                if (grnItem.amount) {
                                    $row.find('.grn-amount').val(formatPriceWithCommas(grnItem.amount));
                                }
                                
                                // Set remark
                                if (grnItem.remark) {
                                    $row.find('.grn-remark').val(grnItem.remark);
                                }
                            });
                            
                            // Update total
                            updateGrnAmountsTotal();
                        } else {
                            // Fallback: if old format with single grn_code, create one row
                            if (data.grn_code) {
                                addGrnRow();
                                let $row = $('#grnAmountsBody tr').last();
                                let $grnSelect = $row.find('.grn-select');
                                
                                if ($grnSelect.find('option[value="' + data.grn_code + '"]').length === 0) {
                                    $grnSelect.append(new Option(data.grn_code, data.grn_code, true, true));
                                }
                                $grnSelect.val(data.grn_code).trigger('change');
                                
                                if (data.supplier_remark) {
                                    $row.find('.grn-remark').val(data.supplier_remark);
                                }
                                
                                if (data.amount) {
                                    $row.find('.grn-amount').val(formatPriceWithCommas(data.amount));
                                }
                                
                                updateGrnAmountsTotal();
                            }
                        }
                        
                        $('#payee_code').val('');
                        $('#payee_name').val('');
                    } else if (sourceCode === 'petty' && (!data.payment_category || !data.payment_category.code || !data.payment_category_id)) {
                        // For petty cash with no payment category (multiple payees mode): populate payees with line items
                        $('#payeesContainer').empty();
                        payeeIndex = 0;
                        lineItemIndex = 0;
                        
                        if (data.payees && Array.isArray(data.payees) && data.payees.length > 0) {
                            // Step 1: Create all payees and line items structure first
                            data.payees.forEach(function(payee, payeeIdx) {
                                // Add payee card
                                addPayee();
                                
                                // Use setTimeout to ensure DOM is ready
                                setTimeout(function() {
                                    let $payeeCard = $('#payeesContainer .payee-card').eq(payeeIdx);
                                    let payeeId = $payeeCard.data('payee-id');
                                    // Set payee name
                                    let $payeeNameField = $payeeCard.find('.payee-name');
                                    if ($payeeNameField.length > 0 && payee.payee_name) {
                                        $payeeNameField.val(payee.payee_name);
                                    }
                                    
                                    // Remove the default line item that addPayee() creates
                                    $payeeCard.find('.payee-line-items-body tr').remove();
                                    
                                    // Add line items structure for this payee (without values yet)
                                    if (payee.items && Array.isArray(payee.items) && payee.items.length > 0) {
                                        payee.items.forEach(function(item, itemIdx) {
                                            addLineItemToPayee(payeeId);
                                        });
                                    } else {
                                        // If no items, add one empty line item
                                        addLineItemToPayee(payeeId);
                                    }
                                }, payeeIdx * 50); // Stagger the setup to ensure DOM is ready
                            });
                            
                            // Step 2: Wait for all Select2 to initialize, then assign values
                            setTimeout(function() {
                                data.payees.forEach(function(payee, payeeIdx) {
                                    let $payeeCard = $('#payeesContainer .payee-card').eq(payeeIdx);
                                    let payeeId = $payeeCard.data('payee-id');
                                    
                                    // Now set values for line items after Select2 is initialized
                                    if (payee.items && Array.isArray(payee.items) && payee.items.length > 0) {
                                        payee.items.forEach(function(item, itemIdx) {
                                            let $lineItemRow = $payeeCard.find('.payee-line-items-body tr').eq(itemIdx);
                                            let $accountSelect = $lineItemRow.find('.account-select');
                                            
                                            // Set account master
                                            if (item.account_master_id && $accountSelect.length > 0) {
                                                // Wait a bit more to ensure Select2 is ready
                                                setTimeout(function() {
                                                    // Create option if it doesn't exist
                                                    if ($accountSelect.find('option[value="' + item.account_master_id + '"]').length === 0) {
                                                        let accountText = item.account_master ? 
                                                            (item.account_master.account_code + ' - ' + item.account_master.account_name) : 
                                                            'Account ID: ' + item.account_master_id;
                                                        let newOption = new Option(accountText, item.account_master_id, true, true);
                                                        $accountSelect.append(newOption);
                                                    }
                                                    $accountSelect.val(item.account_master_id).trigger('change');
                                                }, itemIdx * 50);
                                            }
                                            
                                            // Set amount (can be set immediately)
                                            if (item.amount) {
                                                $lineItemRow.find('.line-amount').val(formatPriceWithCommas(item.amount));
                                            }
                                            
                                            // Set memo (can be set immediately)
                                            if (item.memo) {
                                                $lineItemRow.find('.line-memo').val(item.memo);
                                            }
                                        });
                                        
                                        // Update subtotal after all items are populated
                                        setTimeout(function() {
                                            updatePayeeSubtotal(payeeId);
                                        }, (payee.items.length * 50) + 100);
                                    }
                                });
                                
                                // Update grand total after all payees are populated
                                setTimeout(function() {
                                    updateGrandTotal();
                                }, (data.payees.length * 100) + 300);
                            }, 500); // Wait 500ms for Select2 initialization to complete
                        } else {
                            // If no payees, add one empty payee (default behavior)
                            addPayee();
                        }
                    } else if (sourceCode !== 'petty') {
                        // For other sources (not petty): populate Payee Code and Payee Name
                        $('#payee_code').val(data.payee_code || '');
                        $('#payee_name').val(data.payee_name || '');
                        $('#grnAmountsBody').empty();
                        grnRowIndex = 0;
                    }
                    
                    // Handle account master for petty cash
                    if (sourceCode === 'petty' && data.account_master_id) {
                    let accountDisplay = '';
                    if (data.account_master) {
                        accountDisplay = data.account_master.account_code + ' - ' + data.account_master.account_name;
                    } else if (data.account_master_id) {
                        accountDisplay = 'Account ID: ' + data.account_master_id; // Fallback
                    }
                    $('#account_master_id').val(data.account_master_id);
                    $('#account_master_display').val(accountDisplay);
                    $('#account_master_group').show();
                }
                
                    // Toggle account master field based on source
                    toggleAccountMasterField();
                    
                    // Note: payee_code and payee_name are already set above based on source
                    
                    // Format and set amount - ensure it's a valid number
                    // For outsource supplier, amount is set in advance_amount field, not main amount field
                    // isOutsourceSupplierEdit is already defined in the outer scope
                    
                    if (!isOutsourceSupplierEdit) {
                        amountValue = data.amount;
                        console.log('Raw amount value:', amountValue);
                        
                        if (amountValue === null || amountValue === undefined || amountValue === '') {
                            amountValue = 0;
                        } else {
                            // Convert to number if string (remove commas if present)
                            amountValue = parseFloat(String(amountValue).replace(/,/g, '')) || 0;
                        }
                        
                        console.log('Parsed amount value:', amountValue);
                        
                        // Format with commas using the formatPriceWithCommas function
                        let formattedAmount = formatPriceWithCommas(amountValue);
                        console.log('Formatted amount:', formattedAmount);
                        $('#amount').val(formattedAmount);
                    } else {
                        // For outsource supplier, clear main amount field (it will be hidden anyway)
                        $('#amount').val('');
                    }
                    
                    // Verify the value was set
                    setTimeout(function() {
                        console.log('Amount field value after setting:', $('#amount').val());
                    }, 50);
                    
                    $('#payment_type').val(data.payment_type || 'cash');
                    
                    // Set remarks - handle null, undefined, and empty strings
                    // remarksValue is already declared in outer scope
                    remarksValue = data.remarks;
                    if (remarksValue === null || remarksValue === undefined) {
                        remarksValue = '';
                    }
                    console.log('Remarks from API:', remarksValue);
                    $('#remarks').val(remarksValue);
                    
                    // Verify remarks was set
                    setTimeout(function() {
                        console.log('Remarks field value after setting:', $('#remarks').val());
                    }, 50);
                    
                    // Set series (is_confirm: 1 = Series 1, 0 = Series 2)
                    let seriesValue = (data.is_confirm == 1 || data.is_confirm === null) ? '1' : '0';
                    $('#series').val(seriesValue);
                    
                    // Set advance entry type (manual or automated)
                    if (data.advance_entry_type) {
                        $('input[name="advance_entry_type"][value="' + data.advance_entry_type + '"]').prop('checked', true);
                    } else {
                        // Default to manual if not specified
                        $('input[name="advance_entry_type"][value="manual"]').prop('checked', true);
                    }
                    
                    // Set advance applicable year and month
                    let hasPayCycleData = false;
                    if (data.pay_cycle_id || data.pay_cycle) {
                        // If pay cycle exists, it's automated entry
                        hasPayCycleData = true;
                        if (data.pay_cycle_id) {
                            $('#pay_cycle').val(data.pay_cycle_id).trigger('change');
                        }
                        if (data.schedule_group_id || (data.schedule_groups && Array.isArray(data.schedule_groups) && data.schedule_groups.length > 0)) {
                            // Load schedule groups after pay cycle is set
                            let scheduleGroupId = data.schedule_group_id || (data.schedule_groups && data.schedule_groups.length > 0 ? data.schedule_groups[0] : null);
                            if (scheduleGroupId) {
                                setTimeout(function() {
                                    $('#schedule_groups').val(scheduleGroupId).trigger('change');
                                    // If schedule_group_text exists but option doesn't, create it
                                    if (data.schedule_group_text && $('#schedule_groups option[value="' + scheduleGroupId + '"]').length === 0) {
                                        let $newOption = $('<option></option>')
                                            .attr('value', scheduleGroupId)
                                            .text(data.schedule_group_text);
                                        $('#schedule_groups').append($newOption).val(scheduleGroupId).trigger('change');
                                    }
                                }, 500);
                            }
                        }
                    }
                    
                    if (data.advance_months && Array.isArray(data.advance_months) && data.advance_months.length > 0) {
                        // Use first advance month record
                        let advanceMonthData = data.advance_months[0];
                        if (advanceMonthData.advance_year) {
                            $('#advance_applicable_year').val(advanceMonthData.advance_year);
                        }
                        if (advanceMonthData.advance_month) {
                            $('#advance_applicable_month').val(advanceMonthData.advance_month);
                        }
                    } else if (data.advance_applicable_year && data.advance_applicable_month) {
                        // Fallback: direct fields (for backward compatibility)
                        $('#advance_applicable_year').val(data.advance_applicable_year);
                        $('#advance_applicable_month').val(data.advance_applicable_month);
                    } else if (data.advance_applicable_month) {
                        // Old format: single month field, extract year if date format
                        let monthValue = data.advance_applicable_month;
                        if (monthValue.includes('-')) {
                            // Date format: extract year and month
                            let dateParts = monthValue.split('-');
                            if (dateParts.length >= 2) {
                                $('#advance_applicable_year').val(dateParts[0]);
                                $('#advance_applicable_month').val(parseInt(dateParts[1], 10));
                            }
                        }
                    }
                    
                    // Trigger entry type change handler to show/hide appropriate fields
                    setTimeout(function() {
                        let entryType = $('input[name="advance_entry_type"]:checked').val() || 'manual';
                        if (typeof handleAdvanceEntryTypeChange === 'function') {
                            handleAdvanceEntryTypeChange(entryType);
                        }
                    }, 100);
                    
                    // Show series dropdown if secret code was used
                    if (showSeriesDropdown) {
                        $('#series_group').show();
                    }
                }
                
                // Modal is already shown at the start of editMovement function
                
                // Re-trigger amount formatting and remarks after modal is fully shown
                setTimeout(function() {
                    let currentAmount = $('#amount').val();
                    console.log('Amount after modal show:', currentAmount);
                    // Only re-set amount if it's not an outsource supplier edit and amount is empty
                    if (!isOutsourceSupplierEdit && (!currentAmount || currentAmount === '')) {
                        // Re-set if it was cleared by any event handlers
                        let cleanAmount = amountValue || 0;
                        $('#amount').val(formatPriceWithCommas(cleanAmount));
                        console.log('Re-set amount to:', formatPriceWithCommas(cleanAmount));
                    }
                    
                    // Also verify remarks is set correctly
                    let currentRemarks = $('#remarks').val();
                    console.log('Remarks after modal show:', currentRemarks);
                    if (!currentRemarks && remarksValue) {
                        $('#remarks').val(remarksValue);
                        console.log('Re-set remarks to:', remarksValue);
                    }
                    
                    // Final check after all async operations complete (employee/supplier rows loading)
                    // This ensures amount is set correctly even if update functions ran prematurely
                    setTimeout(function() {
                        if (!isOutsourceSupplierEdit && amountValue) {
                            // Check if amount field has a valid value, if not, set it from data.amount
                            let finalAmount = $('#amount').val();
                            let cleanFinalAmount = getCleanNumericValue(finalAmount);
                            if (!cleanFinalAmount || cleanFinalAmount === 0) {
                                // Amount was cleared or is 0, restore from original data
                                $('#amount').val(formatPriceWithCommas(amountValue));
                                console.log('Final re-set amount to:', formatPriceWithCommas(amountValue));
                            }
                        }
                    }, 2500); // Wait for all async operations (400ms initial + max 200ms * 10 rows + buffer)
                }, 200);
            } else {
                error_toastify(res.message || 'Failed to load movement data');
            }
        },
        error: function() {
            error_toastify('Server error. Please try again.');
        }
    });
}

function printPettyCashVoucher(id) {
    // Open voucher print page in new window
    window.open('<?= base_url("Cashier/CashMovement/printPettyCashVoucher") ?>/' + id, '_blank', 'width=800,height=600');
}

// Global variable to store current movement ID for approve/cancel from details modal
var currentMovementIdForAction = null;

// View movement details with all sub-details
function viewMovementDetails(id) {
    currentMovementIdForAction = id;
    
    // Reset modal content
    $('#movementDetailsContent').html(`
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2">Loading details...</p>
        </div>
    `);
    
    // Hide action buttons initially
    $('#btnApproveFromDetails').hide();
    $('#btnCancelFromDetails').hide();
    
    // Show modal
    $('#movementDetailsModal').modal('show');
    
    // Fetch movement details
    $.ajax({
        url: `<?= base_url("Cashier/CashMovement/getCashMovement") ?>/${id}`,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if(res.status && res.data) {
                let data = res.data;
                displayMovementDetails(data);
                
                // Show action buttons based on status (both cash_in and cash_out require approval)
                if (data.status === 'pending') {
                    $('#btnApproveFromDetails').show();
                }
                // Hide cancel button for approved IOUs with settlements (IOUs with settlements cannot be cancelled)
                // BUT also hide cancel button if:
                // 1. This is a reversal entry (is_reversal === 1 or reversed_movement_id exists)
                // 2. This movement has been reversed (reversals_count > 0)
                if (data.status === 'approved') {
                    // Check if this is a reversal entry (is_reversal === 1 OR reversed_movement_id exists)
                    let isReversalEntry = (data.is_reversal && data.is_reversal == 1) || (data.reversed_movement_id && data.reversed_movement_id > 0) || false;
                    // Check if this movement has been reversed (reversals_count > 0 means someone created a reversal for this movement)
                    let hasReversals = (data.reversals_count && data.reversals_count > 0) || false;
                    
                    // Don't show cancel button for reversal entries or movements that have been reversed
                    if (!isReversalEntry && !hasReversals) {
                        // Check if source is IOU
                        let sourceCode = data.source;
                        if (data.source && typeof data.source === 'object' && data.source.code) {
                            sourceCode = data.source.code;
                        }
                        
                        // Check if IOU has settlements
                        let hasSettlements = false;
                        if (sourceCode === 'iou') {
                            // Check settlements count or iou_settlements array
                            if ((data.iou_settlements_count && data.iou_settlements_count > 0) ||
                                (data.iou_settlements && data.iou_settlements.length > 0)) {
                                hasSettlements = true;
                            }
                        }
                        
                        // Only show cancel button if:
                        // 1. Not an IOU settlement return (these are system-generated and cannot be cancelled)
                        // 2. Not an IOU, or if IOU but has no settlements
                        if (sourceCode !== 'iou_settlement_return' && (sourceCode !== 'iou' || !hasSettlements)) {
                            $('#btnCancelFromDetails').show();
                        }
                    }
                }
            } else {
                $('#movementDetailsContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>Failed to load movement details.
                    </div>
                `);
            }
        },
        error: function() {
            $('#movementDetailsContent').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle mr-2"></i>Server error. Please try again.
                </div>
            `);
        }
    });
}

// Display movement details in modal
function displayMovementDetails(data) {
    let html = `
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Basic Information</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Code:</th>
                                <td>${data.code || '-'}</td>
                            </tr>
                            <tr>
                                <th>Movement Type:</th>
                                <td><span class="badge badge-${data.movement_type === 'cash_in' ? 'success' : 'danger'}">${(data.movement_type || '').replace('_', ' ').toUpperCase()}</span></td>
                            </tr>
                            <tr>
                                <th>Source:</th>
                                <td>${data.source ? (data.source.name || data.source.code || '-') : '-'}</td>
                            </tr>
                            <tr>
                                <th>Payment Category:</th>
                                <td>${data.payment_category ? (data.payment_category.name || data.payment_category.code || '-') : '-'}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td><span class="badge badge-${data.status === 'approved' ? 'success' : data.status === 'pending' ? 'warning' : 'secondary'}">${(data.status || '').toUpperCase()}</span></td>
                            </tr>
                            <tr>
                                <th>Payment Type:</th>
                                <td>${(data.payment_type || '-').toUpperCase()}</td>
                            </tr>
                            <tr>
                                <th>Amount:</th>
                                <td><strong>${formatPriceWithCommas(data.amount || 0)}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Additional Information</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Shift ID:</th>
                                <td>${data.cashier_shift_id || '-'}</td>
                            </tr>
                            <tr>
                                <th>Account Master:</th>
                                <td>${data.account_master ? (data.account_master.name || data.account_master.code || '-') : '-'}</td>
                            </tr>
                            <tr>
                                <th>Payee Code:</th>
                                <td>${data.payee_code || '-'}</td>
                            </tr>
                            <tr>
                                <th>Payee Name:</th>
                                <td>${data.payee_name || '-'}</td>
                            </tr>
                            <tr>
                                <th>Remarks:</th>
                                <td>${data.remarks || '-'}</td>
                            </tr>
                            <tr>
                                <th>Created By:</th>
                                <td>${data.created_by ? (data.created_by.name || '-') : '-'}</td>
                            </tr>
                            <tr>
                                <th>Approved By:</th>
                                <td>${data.approved_by ? (data.approved_by.name || '-') : '-'}</td>
                            </tr>
                            <tr>
                                <th>Created At:</th>
                                <td>${data.created_at ? new Date(data.created_at).toLocaleString() : '-'}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Add Outsource Supplier Payment section (for petty cash advance/final -> outsource supplier)
    const isPettySource = data.source && data.source.code === 'petty';
    const isAdvanceCategory = data.payment_category &&
        (data.payment_category.code === 'advance_payment' || data.payment_category.name === 'Advance Payment');
    const isFinalCategory = data.payment_category &&
        (data.payment_category.code === 'final_payment' || data.payment_category.name === 'Final Payment');
    const isAdvanceOutsource = isAdvanceCategory && data.advance_payment_type === 'outsource_supplier';
    const isFinalOutsource = isFinalCategory && data.final_payment_type === 'outsource_supplier';

    if (
        isPettySource &&
        (isAdvanceOutsource || isFinalOutsource) &&
        data.supplier_jobs &&
        data.supplier_jobs.length > 0
    ) {
        const link = data.supplier_jobs[0]; // One link per movement
        const job  = link.supplier_job || {};

        // Determine job status badge styling
        const jobStatus = job.job_status ? job.job_status.toLowerCase() : '';
        let statusBadgeClass = 'secondary';
        let statusBadgeText = jobStatus.toUpperCase() || '-';
        
        if (jobStatus === 'completed') {
            statusBadgeClass = 'success';
            statusBadgeText = 'COMPLETED';
        } else if (jobStatus === 'cancelled') {
            statusBadgeClass = 'danger';
            statusBadgeText = 'CANCELLED';
        } else if (jobStatus === 'active') {
            statusBadgeClass = 'warning';
            statusBadgeText = 'ACTIVE (IN PROGRESS)';
        }
        
        // Format dates
        const formatDate = (dateStr) => {
            if (!dateStr) return '-';
            try {
                const date = new Date(dateStr);
                return date.toLocaleDateString('en-GB', { year: 'numeric', month: '2-digit', day: '2-digit' });
            } catch (e) {
                return dateStr;
            }
        };

        const sectionTitle = isFinalOutsource
            ? 'Out Source Supplier Final Payment Details'
            : 'Out Source Supplier Advance Details';
        const paymentTitle = isFinalOutsource ? 'Final Payment' : 'Advance Payment';
        const amountHeader = isFinalOutsource ? 'Final Amount' : 'Advance Amount';
        const dateHeader = isFinalOutsource ? 'Final Date' : 'Advance Date';

        html += `
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <strong>${sectionTitle}</strong>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless mb-2">
                            <tr>
                                <th width="30%">Supplier Job Code:</th>
                                <td>${job.code || '-'}</td>
                            </tr>
                            <tr>
                                <th>Supplier Job Name:</th>
                                <td>${job.job_name || '-'}</td>
                            </tr>
                            <tr>
                                <th>Supplier ID:</th>
                                <td>${job.supplier_id || '-'}</td>
                            </tr>
                            <tr>
                                <th>Job Value:</th>
                                <td>${job.job_value ? formatPriceWithCommas(job.job_value) : '-'}</td>
                            </tr>
                            <tr>
                                <th>Job Status:</th>
                                <td><span class="badge badge-${statusBadgeClass}">${statusBadgeText}</span></td>
                            </tr>
                            ${job.start_date ? `
                            <tr>
                                <th>Start Date:</th>
                                <td>${formatDate(job.start_date)}</td>
                            </tr>
                            ` : ''}
                            ${job.expected_completion_date ? `
                            <tr>
                                <th>Expected Completion Date:</th>
                                <td>${formatDate(job.expected_completion_date)}</td>
                            </tr>
                            ` : ''}
                            ${job.actual_completion_date ? `
                            <tr>
                                <th>Actual Completion Date:</th>
                                <td><strong class="text-success">${formatDate(job.actual_completion_date)}</strong></td>
                            </tr>
                            ` : ''}
                        </table>

                        <h6 class="mt-3"><strong>${paymentTitle}</strong></h6>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>${amountHeader}</th>
                                    <th>${dateHeader}</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>${formatPriceWithCommas(link.advance_amount || 0)}</td>
                                    <td>${link.advance_date ? formatDate(link.advance_date) : '-'}</td>
                                    <td>${link.remarks || '-'}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
    }

    // Add Payees section if exists
    if (data.payees && data.payees.length > 0) {
        html += `
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <strong>Payees (${data.payees.length})</strong>
                </div>
                <div class="card-body">
        `;
        data.payees.forEach(function(payee, payeeIndex) {
            let payeeSubtotal = 0;
            if (payee.items && Array.isArray(payee.items)) {
                payee.items.forEach(function(item) {
                    payeeSubtotal += parseFloat(item.amount || 0);
                });
            }
            
            html += `
                    <div class="mb-4 ${payeeIndex > 0 ? 'border-top pt-3' : ''}">
                        <h6 class="mb-2"><strong>Payee ${payeeIndex + 1}: ${payee.payee_name || '-'}</strong></h6>
                        <table class="table table-sm table-bordered mb-2">
                            <tbody>
                                <tr>
                                    <th style="width: 150px;">Payee Code:</th>
                                    <td>${payee.payee_code || '-'}</td>
                                </tr>
                                <tr>
                                    <th>Payee Name:</th>
                                    <td>${payee.payee_name || '-'}</td>
                                </tr>
                            </tbody>
                        </table>
            `;
            
            // Add line items (account details) for this payee
            if (payee.items && Array.isArray(payee.items) && payee.items.length > 0) {
                html += `
                        <h6 class="mt-3 mb-2"><strong>Account Details (${payee.items.length})</strong></h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Account Code</th>
                                        <th>Account Name</th>
                                        <th>Amount</th>
                                        <th>Memo</th>
                                    </tr>
                                </thead>
                                <tbody>
                `;
                payee.items.forEach(function(item) {
                    let accountCode = item.account_master ? (item.account_master.account_code || '-') : '-';
                    let accountName = item.account_master ? (item.account_master.account_name || '-') : '-';
                    html += `
                                    <tr>
                                        <td>${accountCode}</td>
                                        <td>${accountName}</td>
                                        <td class="text-right">${formatPriceWithCommas(item.amount || 0)}</td>
                                        <td>${item.memo || '-'}</td>
                                    </tr>
                    `;
                });
                html += `
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right"><strong>Subtotal:</strong></td>
                                        <td class="text-right"><strong>${formatPriceWithCommas(payeeSubtotal)}</strong></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                `;
            } else {
                html += `
                        <p class="text-muted mb-0">No account details found for this payee.</p>
                `;
            }
            
            html += `
                    </div>
            `;
        });
        html += `
                </div>
            </div>
        `;
    }
    
    // Add Employees section if exists
    if (data.employees && data.employees.length > 0) {
        html += `
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <strong>Employees (${data.employees.length})</strong>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Employee No</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
        `;
        data.employees.forEach(function(emp) {
            html += `
                <tr>
                    <td>${emp.employee_no || '-'}</td>
                    <td>${formatPriceWithCommas(emp.amount || 0)}</td>
                    <td>${emp.employee_type ? emp.employee_type.toUpperCase() : '-'}</td>
                    <td>${emp.remark || '-'}</td>
                </tr>
            `;
        });
        html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Add Suppliers section if exists
    if (data.suppliers && data.suppliers.length > 0) {
        html += `
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <strong>Suppliers (${data.suppliers.length})</strong>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Supplier ID</th>
                                    <th>Supplier Name</th>
                                    <th>Amount</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
        `;
        data.suppliers.forEach(function(supp) {
            html += `
                <tr>
                    <td>${supp.supplier_id || '-'}</td>
                    <td>${supp.supplier_name || '-'}</td>
                    <td>${formatPriceWithCommas(supp.amount || 0)}</td>
                    <td>${supp.remark || '-'}</td>
                </tr>
            `;
        });
        html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Add GRNs section if exists
    if (data.grns && data.grns.length > 0) {
        html += `
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <strong>GRNs (${data.grns.length})</strong>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Supplier ID</th>
                                    <th>GRN Code</th>
                                    <th>Amount</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
        `;
        data.grns.forEach(function(grn) {
            html += `
                <tr>
                    <td>${grn.supplier_id || '-'}</td>
                    <td>${grn.grn_code || '-'}</td>
                    <td>${formatPriceWithCommas(grn.amount || 0)}</td>
                    <td>${grn.remark || '-'}</td>
                </tr>
            `;
        });
        html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Add Advance Months section if exists
    if (data.advance_months && data.advance_months.length > 0) {
        // Get entry type display text
        let entryTypeText = '-';
        let entryTypeBadge = '';
        if (data.advance_entry_type) {
            if (data.advance_entry_type === 'manual') {
                entryTypeText = 'Manual Entry';
                entryTypeBadge = '<span class="badge badge-info"><i class="fas fa-edit mr-1"></i>Manual Entry</span>';
            } else if (data.advance_entry_type === 'automated') {
                entryTypeText = 'Automated Entry (Pay Cycle)';
                entryTypeBadge = '<span class="badge badge-success"><i class="fas fa-sync-alt mr-1"></i>Automated Entry</span>';
            }
        }
        
        // Get schedule group text (for automated entry type)
        let scheduleGroupText = data.schedule_group_text || '-';
        
        html += `
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <strong>Advance Applicable Months (${data.advance_months.length})</strong>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Entry Type:</strong> ${entryTypeBadge || entryTypeText}
                        ${data.advance_entry_type === 'automated' && scheduleGroupText !== '-' ? `<br><strong>Schedule Group:</strong> <span class="badge badge-secondary">${scheduleGroupText}</span>` : ''}
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Month</th>
                                    ${data.advance_entry_type === 'automated' ? '<th>Schedule Group</th>' : ''}
                                </tr>
                            </thead>
                            <tbody>
        `;
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        data.advance_months.forEach(function(month) {
            html += `
                <tr>
                    <td>${month.advance_year || '-'}</td>
                    <td>${month.advance_month ? monthNames[month.advance_month - 1] : '-'}</td>
                    ${data.advance_entry_type === 'automated' ? `<td>${scheduleGroupText}</td>` : ''}
                </tr>
            `;
        });
        html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
    }
    
    $('#movementDetailsContent').html(html);
}

function approveMovement(id) {
    // Show details modal first, user can approve from there
    viewMovementDetails(id);
}

function approveMovementFromDetails() {
    if (currentMovementIdForAction) {
        if(confirm('Are you sure you want to approve this cash movement?')) {
            $.ajax({
                url: `<?= base_url("Cashier/CashMovement/approveCashMovement") ?>/${currentMovementIdForAction}`,
                type: 'POST',
                dataType: 'json',
                success: function(res) {
                    if(res.status) {
                        success_toastify(res.message || 'Movement approved successfully');
                        $('#movementDetailsModal').modal('hide');
                        // Reload the DataTable
                        if ($.fn.DataTable.isDataTable('#movementsTable')) {
                            $('#movementsTable').DataTable().ajax.reload();
                        } else {
                            loadCashMovements();
                        }
                    } else {
                        error_toastify(res.message || 'Failed to approve movement');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Failed to approve movement';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    error_toastify(errorMsg);
                }
            });
        }
    }
}

function cancelMovementApproval(id) {
    // Show details modal first, user can cancel from there
    viewMovementDetails(id);
}

function cancelMovementFromDetails() {
    if (currentMovementIdForAction) {
        // Clear previous cancel reason
        $('#cancel_reason').val('');
        $('#cancel_reason_count').text('0');
        
        // Show cancel reason modal
        $('#cancelReasonModal').modal('show');
    }
}

function confirmCancelWithReason() {
    let cancelReason = $('#cancel_reason').val().trim();
    
    // Validate cancel reason
    if (!cancelReason) {
        error_toastify('Please enter a cancel reason before proceeding.');
        $('#cancel_reason').focus();
        return;
    }
    
    if (cancelReason.length > 1000) {
        error_toastify('Cancel reason cannot exceed 1000 characters.');
        $('#cancel_reason').focus();
        return;
    }
    
    if (!currentMovementIdForAction) {
        error_toastify('No movement selected for cancellation.');
        return;
    }
    
    // Disable button to prevent double submission
    $('#btnConfirmCancel').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...');
    
    $.ajax({
        url: `<?= base_url("Cashier/CashMovement/cancelCashMovementApproval") ?>/${currentMovementIdForAction}`,
        type: 'POST',
        dataType: 'json',
        data: {
            cancel_reason: cancelReason
        },
        success: function(res) {
            if(res.status) {
                success_toastify(res.message || 'Movement approval cancelled successfully');
                $('#cancelReasonModal').modal('hide');
                $('#movementDetailsModal').modal('hide');
                // Clear cancel reason
                $('#cancel_reason').val('');
                $('#cancel_reason_count').text('0');
                // Reload the DataTable
                if ($.fn.DataTable.isDataTable('#movementsTable')) {
                    $('#movementsTable').DataTable().ajax.reload();
                } else {
                    loadCashMovements();
                }
            } else {
                error_toastify(res.message || 'Failed to cancel movement approval');
                // Re-enable button
                $('#btnConfirmCancel').prop('disabled', false).html('<i class="fas fa-check mr-2"></i>Confirm Cancellation');
            }
        },
        error: function(xhr) {
            let errorMsg = 'Failed to cancel movement approval';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.cancel_reason) {
                errorMsg = xhr.responseJSON.errors.cancel_reason[0];
            }
            error_toastify(errorMsg);
            // Re-enable button
            $('#btnConfirmCancel').prop('disabled', false).html('<i class="fas fa-check mr-2"></i>Confirm Cancellation');
        }
    });
}

// Character counter for cancel reason
$(document).on('input', '#cancel_reason', function() {
    let length = $(this).val().length;
    $('#cancel_reason_count').text(length);
    
    // Change color if approaching limit
    if (length > 900) {
        $('#cancel_reason_count').addClass('text-danger').removeClass('text-muted');
    } else {
        $('#cancel_reason_count').removeClass('text-danger').addClass('text-muted');
    }
});

function deleteMovement(id) {
    if(confirm('Are you sure you want to delete this movement?')) {
        $.ajax({
            url: `<?= base_url("Cashier/CashMovement/deleteCashMovement") ?>/${id}`,
            type: 'POST',
            dataType: 'json',
            success: function(res) {
                if(res.status) {
                    success_toastify(res.message);
                    // Reload the DataTable
                    if ($.fn.DataTable.isDataTable('#movementsTable')) {
                        $('#movementsTable').DataTable().ajax.reload();
                    } else {
                        loadCashMovements();
                    }
                } else {
                    error_toastify(res.message || 'Failed to delete movement');
                }
            }
        });
    }
}

    // ============================================
    // Out Source Supplier Functions
    // ============================================

    // Update outsource supplier labels based on payment type (advance or final)
    function updateOutsourceSupplierLabels(isFinalPayment) {
        if (isFinalPayment) {
            // Update labels for Final Payment
            $('#outsource_date_label').text('Final');
            $('#outsource_date_help').text('Date when the final payment is applicable');
            $('#outsource_amount_label').text('Final');
            $('#outsource_amount_help').text('Final payment amount for selected job');
            $('#outsource_remarks').attr('placeholder', 'Enter remarks for this final payment');
            $('#btnViewAdvancePayments').attr('title', 'View Final Payment Details');
            $('#advance_payments_modal_title').text('Final');
            $('#total_advances_label').text('Total Payments');
        } else {
            // Update labels for Advance Payment
            $('#outsource_date_label').text('Advance');
            $('#outsource_date_help').text('Date when the advance payment is applicable');
            $('#outsource_amount_label').text('Advance');
            $('#outsource_amount_help').text('Advance amount for selected job');
            $('#outsource_remarks').attr('placeholder', 'Enter remarks for this advance payment');
            $('#btnViewAdvancePayments').attr('title', 'View Advance Payment Details');
            $('#advance_payments_modal_title').text('Advance');
            $('#total_advances_label').text('Total Advances');
        }
    }
    
    // Load suppliers for outsource supplier dropdown with pagination
    function loadOutsourceSuppliers() {
        let $supplierSelect = $('#outsource_supplier_select');
        
        // Destroy existing select2 instance if exists
        if ($supplierSelect.hasClass('select2-hidden-accessible')) {
            $supplierSelect.select2('destroy');
        }
        
        // Initialize Select2 with AJAX pagination
        $supplierSelect.select2({
            ajax: {
                url: '<?= base_url("Cashier/CashMovement/getOutsourceSuppliers") ?>',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function(data) {
                    // Handle API response format
                    if (data.results && Array.isArray(data.results)) {
                        return {
                            results: data.results,
                            pagination: data.pagination || { more: false }
                        };
                    }
                    // Fallback if response format is different
                    if (data.status && data.results) {
                        return {
                            results: data.results,
                            pagination: { more: false }
                        };
                    }
                    return {
                        results: [],
                        pagination: { more: false }
                    };
                },
                cache: false
            },
            dropdownParent: $('#addMovementModal'),
            placeholder: 'Search and Select Supplier',
            allowClear: true,
            width: '100%',
            minimumInputLength: 0
        });
    }

    // Load jobs for selected supplier
    function loadSupplierJobs(supplierId, callback) {
        if (!supplierId) {
            $('#outsource_job_select').empty().append('<option value="">Select Supplier First</option>').prop('disabled', true);
            $('#btnCreateNewJob').prop('disabled', true);
            $('#job_details_display').hide();
            if (callback) callback(false);
            return;
        }

        let $jobSelect = $('#outsource_job_select');
        $jobSelect.empty().append('<option value="">Loading jobs...</option>').prop('disabled', true);
        
        $.ajax({
            url: '<?= base_url("Cashier/CashMovement/getSupplierJobsBySupplier/") ?>' + supplierId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $jobSelect.empty().append('<option value="">Select Job</option>');
                if (response.status && response.data && response.data.length > 0) {
                    response.data.forEach(function(job) {
                        let jobCode = job.job_code || '';
                        let jobName = job.job_name || '';
                        let jobValue = parseFloat(job.job_value || 0);
                        let totalAdvances = parseFloat(job.total_advance_paid || 0);
                        let remainingBalance = jobValue - totalAdvances;
                        $jobSelect.append(`<option value="${job.id}" 
                            data-job-value="${jobValue}" 
                            data-total-advances="${totalAdvances}"
                            data-remaining-balance="${remainingBalance}">
                            ${jobCode} - ${jobName} (Balance: ${formatPriceWithCommas(remainingBalance)})
                        </option>`);
                    });
                } else {
                    $jobSelect.append('<option value="">No jobs found. Create a new job.</option>');
                }
                $jobSelect.prop('disabled', false);
                $('#btnCreateNewJob').prop('disabled', false);
                if (callback) callback(true, response);
            },
            error: function(xhr) {
                console.error('Error loading jobs:', xhr);
                $jobSelect.empty().append('<option value="">Error loading jobs</option>');
                $('#btnCreateNewJob').prop('disabled', false);
                if (callback) callback(false);
            }
        });
    }

    // Handle supplier selection change
    $(document).on('change', '#outsource_supplier_select', function() {
        // Skip handler if flag is set (used during edit mode to prevent clearing job)
        if (window._skipSupplierChangeHandler) {
            return;
        }
        
        let supplierId = $(this).val();
        $('#new_job_supplier_id').val(supplierId);
        loadSupplierJobs(supplierId);
        $('#outsource_job_select').val('').trigger('change');
        $('#job_details_display').hide();
        // Hide button when supplier changes
        $('#btnViewAdvancePayments').hide().removeData('job-id');
    });

    // Handle job selection change
    $(document).on('change', '#outsource_job_select', function() {
        let $option = $(this).find('option:selected');
        let jobValue = parseFloat($option.data('job-value') || 0);
        let totalAdvances = parseFloat($option.data('total-advances') || 0);
        let remainingBalance = parseFloat($option.data('remaining-balance') || 0);
        let jobId = $(this).val();

        if ($(this).val()) {
            $('#job_value_display').text(formatPriceWithCommas(jobValue));
            $('#total_advances_display').text(formatPriceWithCommas(totalAdvances));
            $('#remaining_balance_display').text(formatPriceWithCommas(remainingBalance));
            $('#job_details_display').show();
            // Show button to view advance payments and store job ID
            $('#btnViewAdvancePayments').show().data('job-id', jobId);
            
            // Re-validate amount when job changes
            validateOutsourceAmount();
        } else {
            $('#job_details_display').hide();
            // Hide button when no job is selected
            $('#btnViewAdvancePayments').hide().removeData('job-id');
            // Clear validation error when job is deselected
            $('#outsource_advance_amount').removeClass('is-invalid');
            $('#outsource_amount_error').hide();
        }
    });

    // Handle view advance payments button click
    $(document).on('click', '#btnViewAdvancePayments', function() {
        let jobId = $(this).data('job-id');
        if (!jobId) {
            error_toastify('Please select a job first.');
            return;
        }
        viewAdvancePayments(jobId);
    });

    // Function to load and display advance payments for a job
    function viewAdvancePayments(jobId) {
        // Show modal with loading state
        $('#advancePaymentsContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Loading advance payments...</p>
            </div>
        `);
        $('#advancePaymentsModal').modal('show');

        // Load advance payments
        $.ajax({
            url: `<?= base_url("Cashier/CashMovement/getAdvancePaymentsByJob/") ?>${jobId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status && response.data) {
                    let payments = response.data.advance_payments || [];
                    let job = response.data.job || {};
                    
                    let html = `
                        <div class="mb-3">
                            <h6><strong>Job: ${job.job_code || job.code || '-'} - ${job.job_name || '-'}</strong></h6>
                            <p class="text-muted mb-0">Job Value: ${formatPriceWithCommas(job.job_value || 0)}</p>
                        </div>
                    `;

                    if (payments.length > 0) {
                        // Function to get ordinal suffix (1st, 2nd, 3rd, etc.)
                        function getOrdinalSuffix(num) {
                            let j = num % 10;
                            let k = num % 100;
                            if (j == 1 && k != 11) return num + 'st';
                            if (j == 2 && k != 12) return num + 'nd';
                            if (j == 3 && k != 13) return num + 'rd';
                            return num + 'th';
                        }

                        html += `
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Installment</th>
                                            <th>Payment Date</th>
                                            <th>Installment Amount</th>
                                            <th>Remark</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        `;

                        payments.forEach(function(payment, index) {
                            let installmentNumber = payment.installment_number || (index + 1);
                            let installmentAmount = payment.installment_amount || payment.advance_amount || 0;
                            let paymentDate = payment.payment_date ? new Date(payment.payment_date).toLocaleDateString('en-GB') : '-';
                            let status = payment.status || 'pending';
                            let statusBadge = status === 'approved' ? 'success' : status === 'pending' ? 'warning' : 'secondary';
                            let remarks = payment.remarks || '-';
                            
                            html += `
                                <tr>
                                    <td><strong>${getOrdinalSuffix(installmentNumber)}</strong></td>
                                    <td>${paymentDate}</td>
                                    <td class="text-right">${formatPriceWithCommas(installmentAmount)}</td>
                                    <td>${remarks}</td>
                                    <td><span class="badge badge-${statusBadge}">${status.toUpperCase()}</span></td>
                                </tr>
                            `;
                        });

                        html += `
                                    </tbody>
                                    <tfoot class="font-weight-bold">
                                        <tr>
                                            <td class="text-right">Total:</td>
                                            <td></td>
                                            <td class="text-right">${formatPriceWithCommas(payments.reduce((sum, p) => sum + parseFloat(p.installment_amount || p.advance_amount || 0), 0).toFixed(2))}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        `;
                    } else {
                        html += `
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle mr-2"></i>No advance payments found for this job.
                            </div>
                        `;
                    }

                    $('#advancePaymentsContent').html(html);
                } else {
                    $('#advancePaymentsContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle mr-2"></i>Failed to load advance payments.
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                console.error('Error loading advance payments:', xhr);
                $('#advancePaymentsContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>Error loading advance payments. Please try again.
                    </div>
                `);
            }
        });
    }

    // Handle create new job button click
    $(document).on('click', '#btnCreateNewJob', function() {
        let supplierId = $('#outsource_supplier_select').val();
        if (!supplierId) {
            error_toastify('Please select a supplier first.');
            return;
        }
        $('#new_job_supplier_id').val(supplierId);
        $('#createSupplierJobForm')[0].reset();
        $('#new_job_supplier_id').val(supplierId);
        $('#new_job_status').val('active');
        
        // Initialize Account Master Select2 for the new job modal
        if ($('#new_job_account_master').hasClass('select2-hidden-accessible')) {
            $('#new_job_account_master').select2('destroy');
        }
        // Pass the createSupplierJobModal as dropdown parent
        initializeAccountSelect2ForElement($('#new_job_account_master'), $('#createSupplierJobModal'));
        
        $('#createSupplierJobModal').modal('show');
    });

    // Handle create job form submission
    $(document).on('submit', '#createSupplierJobForm', function(e) {
        e.preventDefault();
        
        // Validate account master is required
        let accountMasterId = $('#new_job_account_master').val();
        if (!accountMasterId || accountMasterId === '' || accountMasterId === null) {
            error_toastify('Please select an Account Master.');
            $('#new_job_account_master').focus();
            return;
        }
        
        // Convert to integer
        accountMasterId = parseInt(accountMasterId);
        if (isNaN(accountMasterId)) {
            error_toastify('Please select a valid Account Master.');
            $('#new_job_account_master').focus();
            return;
        }
        
        let formData = {
            supplier_id: parseInt($('#new_job_supplier_id').val()),
            job_name: $('#new_job_name').val().trim(),
            job_description: $('#new_job_description').val().trim(),
            job_value: getCleanNumericValue($('#new_job_value').val()),
            job_status: $('#new_job_status').val(),
            account_master_id: accountMasterId,
            start_date: $('#new_job_start_date').val() || null,
            expected_completion_date: $('#new_job_expected_completion_date').val() || null
        };

        if (!formData.job_name || !formData.job_value || parseFloat(formData.job_value) <= 0) {
            error_toastify('Please fill in job name and valid job value.');
            return;
        }

        $.ajax({
            url: '<?= base_url("Cashier/CashMovement/createSupplierJob") ?>',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(response) {
                if (response.status) {
                    success_toastify('Job created successfully!');
                    $('#createSupplierJobModal').modal('hide');
                    // Reload jobs for the supplier
                    loadSupplierJobs(formData.supplier_id);
                    // Select the newly created job
                    setTimeout(function() {
                        $('#outsource_job_select').val(response.data.id).trigger('change');
                    }, 500);
                } else {
                    error_toastify(response.message || 'Failed to create job.');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Failed to create job.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                error_toastify(errorMsg);
            }
        });
    });

    // Format price input for outsource advance amount
    $(document).on('input paste', '#outsource_advance_amount', function() {
        let $input = $(this);
        setTimeout(function() {
            let value = getCleanNumericValue($input.val());
            if (value !== '' && !isNaN(value) && parseFloat(value) >= 0) {
                $input.val(formatPriceWithCommas(value));
            }
        }, 10);
    });
    
    // Handle advance entry type change (Manual vs Automated)
    function handleAdvanceEntryTypeChange(entryType) {
        // Check source first - for IOU, refund, other source, or cash_in with advance/salary/md_cash_in/other, never require advance month fields
        let currentSource = $('#source').val();
        let movementType = $('#movement_type').val();
        let isCashInExcludedSource = movementType === 'cash_in' && (currentSource === 'advance' || currentSource === 'salary' || currentSource === 'md_cash_in' || currentSource === 'other');
        let isIouSource = currentSource === 'iou' || currentSource === 'refund' || currentSource === 'other' || isCashInExcludedSource;
        
        // Always hide both groups first, then show the correct one
        $('#automated_entry_group').hide();
        $('#manual_entry_group').hide();
        
        if (entryType === 'automated') {
            // Show automated entry fields (includes pay cycle and schedule groups in same row)
            $('#automated_entry_group').show();
            $('#schedule_groups_group').show();
            
            // Set required attributes for automated (but not for IOU)
            if (!isIouSource) {
                $('#pay_cycle').prop('required', true);
            } else {
                $('#pay_cycle').prop('required', false).removeAttr('required');
            }
            $('#schedule_groups').prop('required', false).removeAttr('required'); // Optional
            $('#advance_applicable_year').prop('required', false).removeAttr('required');
            $('#advance_applicable_month').prop('required', false).removeAttr('required');
            
            // Enable/disable schedule_groups based on Series selection
            // Series 1 = "1", Series 2 = "0" - both should enable schedule groups
            let seriesValue = $('#series').val();
            if (seriesValue === '0' || seriesValue === '1') {
                // Enable schedule groups - remove disabled attribute
                $('#schedule_groups').prop('disabled', false).removeAttr('disabled');
                // Trigger change to update Select2
                $('#schedule_groups').trigger('change.select2');
            } else {
                // Disable schedule groups - add disabled attribute
                $('#schedule_groups').val(null);
                $('#schedule_groups').prop('disabled', true).attr('disabled', 'disabled');
                // Trigger change to update Select2
                $('#schedule_groups').trigger('change.select2');
            }
            
            // Clear manual entry fields
            $('#advance_applicable_year').val('');
            $('#advance_applicable_month').val('');
        } else {
            // Show manual entry fields (default)
            $('#manual_entry_group').show();
            $('#schedule_groups_group').hide();
            
            // Disable schedule_groups when manual entry is selected
            $('#schedule_groups').prop('disabled', true).trigger('change.select2');
            
            // Set required attributes for manual (but not for IOU)
            if (!isIouSource) {
                $('#advance_applicable_year').prop('required', true);
                $('#advance_applicable_month').prop('required', true);
            } else {
                $('#advance_applicable_year').prop('required', false).removeAttr('required');
                $('#advance_applicable_month').prop('required', false).removeAttr('required');
            }
            $('#pay_cycle').prop('required', false).removeAttr('required');
            $('#schedule_groups').prop('required', false).removeAttr('required');
            
            // Set current year as default if year field is empty
            if (!$('#advance_applicable_year').val()) {
                let currentYear = new Date().getFullYear();
                $('#advance_applicable_year').val(currentYear);
            }
            
            // Set current month as default if month field is empty
            if (!$('#advance_applicable_month').val()) {
                let currentMonth = new Date().getMonth() + 1; // getMonth() returns 0-11, so add 1 to get 1-12
                $('#advance_applicable_month').val(currentMonth.toString());
            }
            
            // Clear automated fields
            $('#pay_cycle').val(null).trigger('change');
            $('#schedule_groups').val(null).trigger('change');
        }
    }
    
    // Handle advance entry type radio button change
    $(document).on('change', 'input[name="advance_entry_type"]', function() {
        let entryType = $(this).val();
        if (typeof handleAdvanceEntryTypeChange === 'function') {
            handleAdvanceEntryTypeChange(entryType);
        }
    });
    
    // Initialize entry type on page load (ensure manual is default)
    $(document).ready(function() {
        // Set default to manual entry if not already set
        if (!$('input[name="advance_entry_type"]:checked').length) {
            $('input[name="advance_entry_type"][value="manual"]').prop('checked', true);
        }
        
        // Hide automated entry by default (manual entry is default)
        $('#automated_entry_group').hide();
        $('#manual_entry_group').hide(); // Will be shown when entry type section becomes visible
        
        // Apply default state if entry type section is visible
        setTimeout(function() {
            if ($('#advance_month_common_group').is(':visible')) {
                let entryType = $('input[name="advance_entry_type"]:checked').val() || 'manual';
                if (typeof handleAdvanceEntryTypeChange === 'function') {
                    handleAdvanceEntryTypeChange(entryType);
                } else {
                    // Fallback: manually set manual entry as default
                    $('#manual_entry_group').show();
                    $('#automated_entry_group').hide();
                    $('#schedule_groups_group').hide();
                }
            }
        }, 100);
    });
    
    // Initialize Pay Cycle Select2 dropdown
    if ($('#pay_cycle').length && typeof $.fn.select2 !== 'undefined') {
        $('#pay_cycle').select2({
            placeholder: 'Select Pay Cycle',
            allowClear: true,
            dropdownParent: $('#addMovementModal'),
            ajax: {
                url: 'https://pr.ecw.lk/api/advance/pay-cycles',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term || ''
                    };
                },
                processResults: function(response) {
                    // API returns: {"status": true, "data": [{"id":"87","text":"April 2027"},...]}
                    if (response && response.status === true && response.data && Array.isArray(response.data)) {
                        return {
                            results: response.data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.text
                                };
                            }),
                            pagination: {
                                more: false
                            }
                        };
                    }
                    // Fallback for old format with results property
                    if (response && response.results && Array.isArray(response.results)) {
                        return {
                            results: response.results.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.text
                                };
                            }),
                            pagination: {
                                more: false
                            }
                        };
                    }
                    return { results: [], pagination: { more: false } };
                },
                cache: true
            }
        });
    }
    
    // Initialize Schedule Groups Select2 dropdown
    if ($('#schedule_groups').length && typeof $.fn.select2 !== 'undefined') {
        $('#schedule_groups').select2({
            placeholder: 'Select Schedule Groups',
            allowClear: true,
            dropdownParent: $('#addMovementModal'),
            disabled: true, // Disabled by default - will be enabled when Series is selected
            ajax: {
                url: 'https://pr.ecw.lk/api/advance/schedule-groups',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    let payCycleId = $('#pay_cycle').val();
                    let seriesValue = $('#series').val();
                    let urlParams = {
                        search: params.term || ''
                    };
                    if (payCycleId) {
                        urlParams.pay_cycle_id = payCycleId;
                    }
                    // Include Series value if Series 1 ("1") or Series 2 ("0") is selected
                    // Map: UI value "1" → API value "1", UI value "0" → API value "2"
                    if (seriesValue === '0' || seriesValue === '1') {
                        urlParams.series = (seriesValue === '0') ? '2' : seriesValue;
                    }
                    return urlParams;
                },
                processResults: function(response) {
                    // API returns: {"status": true, "data": [{"id":"65","text":"...",...},...]}
                    // Convert to array format for Select2
                    let results = [];
                    
                    // Check for correct API format with status and data
                    if (response && response.status === true && response.data) {
                        if (Array.isArray(response.data)) {
                            results = response.data;
                        } else {
                            // Single object, convert to array
                            results = [response.data];
                        }
                        
                        results = results.map(function(item) {
                            // Use text field directly from API response
                            return {
                                id: item.id,
                                text: item.text || item.description
                            };
                        });
                    }
                    // Fallback for old format with results property
                    else if (response && response.results) {
                        if (Array.isArray(response.results)) {
                            results = response.results;
                        } else {
                            // Single object, convert to array
                            results = [response.results];
                        }
                        
                        results = results.map(function(item) {
                            // Use text field directly from API response
                            return {
                                id: item.id,
                                text: item.text || item.description
                            };
                        });
                    }
                    
                    return {
                        results: results,
                        pagination: {
                            more: false
                        }
                    };
                },
                cache: false // Disable cache to refresh when pay cycle changes
            }
        });
        
        // Disable schedule_groups initially
        $('#schedule_groups').prop('disabled', true).trigger('change.select2');
        
        // Function to update schedule_groups enabled state based on Series selection
        function updateScheduleGroupsEnabledState() {
            let seriesValue = $('#series').val();
            let entryType = $('input[name="advance_entry_type"]:checked').val();
            let isAutomatedEntry = entryType === 'automated';
            let isScheduleGroupVisible = $('#schedule_groups_group').is(':visible');
            
            // Enable if Series 1 or Series 2 is selected AND automated entry is selected (or schedule_groups_group is visible)
            if ((seriesValue === '0' || seriesValue === '1') && (isAutomatedEntry || isScheduleGroupVisible)) {
                // Enable schedule groups - remove disabled attribute
                $('#schedule_groups').prop('disabled', false).removeAttr('disabled');
                // Trigger change to update Select2
                $('#schedule_groups').trigger('change.select2');
            } else {
                // Disable schedule groups - add disabled attribute
                $('#schedule_groups').val(null);
                $('#schedule_groups').prop('disabled', true).attr('disabled', 'disabled');
                // Trigger change to update Select2
                $('#schedule_groups').trigger('change.select2');
            }
        }
        
        // Enable/disable schedule_groups based on Series selection
        $(document).on('change', '#series', function() {
            updateScheduleGroupsEnabledState();
        });
        
        // When pay cycle is selected/changed, load schedule groups
        $('#pay_cycle').on('change', function() {
            let payCycleId = $(this).val();
            
            if (payCycleId && payCycleId !== '') {
                // Clear existing schedule groups selection
                $('#schedule_groups').val(null).trigger('change');
                
                // Only load schedule groups if Series 1 ("1") or Series 2 ("0") is selected
                let seriesValue = $('#series').val();
                if (seriesValue !== '0' && seriesValue !== '1') {
                    // Series not selected (empty), disable schedule groups
                    $('#schedule_groups').prop('disabled', true).trigger('change.select2');
                    return;
                }
                
                // Build URL with pay cycle and series
                // Map: UI value "1" → API value "1", UI value "0" → API value "2"
                let apiSeriesValue = (seriesValue === '0') ? '2' : seriesValue;
                let apiUrl = 'https://pr.ecw.lk/api/advance/schedule-groups?pay_cycle_id=' + payCycleId + '&series=' + apiSeriesValue;
                
                // Load schedule groups for the selected pay cycle and series
                $.ajax({
                    url: apiUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // API returns: {"results":{"id":"65",...}} - single object
                        // Convert to array format
                        let results = [];
                        if (response && response.results) {
                            if (Array.isArray(response.results)) {
                                results = response.results;
                            } else {
                                results = [response.results];
                            }
                            
                            // Clear existing options
                            $('#schedule_groups').empty();
                            $('#schedule_groups').append('<option value="">Select Schedule Groups</option>');
                            
                            // Add new options
                            results.forEach(function(item) {
                                // Use text field directly from API response
                                let text = item.text || item.description;
                                let option = new Option(
                                    text,
                                    item.id,
                                    false,
                                    false
                                );
                                $('#schedule_groups').append(option);
                            });
                            
                            // Trigger change to update Select2
                            $('#schedule_groups').trigger('change');
                        }
                    },
                    error: function(xhr) {
                        console.error('Failed to load schedule groups:', xhr);
                        error_toastify('Failed to load schedule groups for the selected pay cycle.');
                    }
                });
            } else {
                // Clear schedule groups if pay cycle is cleared
                $('#schedule_groups').val(null).trigger('change');
            }
        });
        
        // When schedule group is selected, load pre-created employee list with amounts
        $('#schedule_groups').on('change', function() {
            let scheduleGroupId = $(this).val();
            let payCycleId = $('#pay_cycle').val();
            let seriesValue = $('#series').val();
            
            // Check if Series 1 ("1") or Series 2 ("0") is selected
            if (scheduleGroupId && payCycleId && (seriesValue === '0' || seriesValue === '1')) {
                // Load employees with amounts for this schedule group, pay cycle, and series
                $.ajax({
                    url: '<?= base_url("Cashier/CashMovement/getEmployeesByScheduleGroup") ?>',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        schedule_group_id: scheduleGroupId,
                        pay_cycle_id: payCycleId,
                        series: seriesValue
                    },
                    success: function(response) {
                        if (response.status && response.data && response.data.length > 0) {
                            // First, remove any empty rows (rows without employee selected)
                            $('#employeeAmountsBody tr').each(function() {
                                let $row = $(this);
                                let employeeId = $row.find('.employee-select').val();
                                // If row has no employee selected, remove it
                                if (!employeeId || employeeId === '' || employeeId === null) {
                                    $row.remove();
                                }
                            });
                            
                            // Filter out employees that already exist
                            let employeesToAdd = [];
                            response.data.forEach(function(emp) {
                                let employeeExists = false;
                                $('#employeeAmountsBody tr').each(function() {
                                    let existingEmployeeId = $(this).find('.employee-select').val();
                                    if (existingEmployeeId == emp.employee_id) {
                                        employeeExists = true;
                                        return false; // Break loop
                                    }
                                });
                                if (!employeeExists) {
                                    employeesToAdd.push(emp);
                                }
                            });
                            
                            if (employeesToAdd.length === 0) {
                                info_toastify('All employees from this schedule group are already added.');
                                return;
                            }
                            
                            // Show loading spinner
                            let $tableContainer = $('#employeeAmountsTable').closest('.table-responsive');
                            let $loadingOverlay = null;
                            if ($tableContainer.length) {
                                // Make container relative if not already
                                if ($tableContainer.css('position') === 'static') {
                                    $tableContainer.css('position', 'relative');
                                }
                                // Create and show loading overlay
                                $loadingOverlay = $('<div class="employee-loading-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.9); z-index: 9999; display: flex; align-items: center; justify-content: center; flex-direction: column;"><div class="spinner-border text-primary mb-2" role="status" style="width: 3rem; height: 3rem;"><span class="sr-only">Loading...</span></div><div class="text-muted employee-loading-text">Loading employees... (0/' + employeesToAdd.length + ')</div></div>');
                                $tableContainer.append($loadingOverlay);
                            }
                            
                            // OPTIMIZED: Batch load all employees at once for maximum speed
                            // Get current settings once (outside loop)
                            let paymentCategory = $('#payment_category').val();
                            let isAdvancePayment = paymentCategory === 'advance_payment';
                            let selectedEmployeeType = $('input[name="employee_type"]:checked').val() || 'casual';
                            let isEmployeeGroupVisible = $('#employee_dropdown_group').is(':visible');
                            let requiredAttr = isEmployeeGroupVisible ? 'required' : '';
                            
                            // Update progress
                            if ($loadingOverlay) {
                                $loadingOverlay.find('.employee-loading-text').text('Creating rows... (0/' + employeesToAdd.length + ')');
                            }
                            
                            // Step 1: Build all rows HTML at once (no DOM manipulation yet - fastest)
                            let allRowsHTML = '';
                            let rowDataMap = {}; // Store employee data by rowId
                            
                            employeesToAdd.forEach(function(emp) {
                                employeeRowIndex++;
                                let rowId = 'employee_row_' + employeeRowIndex;
                                
                                // Store employee data for later use
                                rowDataMap[rowId] = emp;
                                
                                // Build employee type cell (only for advance payment)
                                let employeeTypeCell = '';
                                let employeeMarkCell = '';
                                let employeeImageCell = '';
                                
                                if (isAdvancePayment) {
                                    
                                    employeeMarkCell = `
                                        <td class="text-center d-none">
                                            <div class="form-check d-inline-block">
                                                <input type="checkbox" 
                                                       class="form-check-input employee-mark-checkbox" 
                                                       name="employee_amounts[${employeeRowIndex}][mark]" 
                                                       id="employee_mark_${employeeRowIndex}"
                                                       data-row-index="${employeeRowIndex}"
                                                       value="1"
                                                       checked>
                                                <label class="form-check-label employee-mark-icon" for="employee_mark_${employeeRowIndex}" style="cursor: pointer;">
                                                    <i class="fas fa-check text-success" id="mark_icon_${employeeRowIndex}"></i>
                                                </label>
                                            </div>
                                        </td>
                                    `;
                                    
                                    employeeImageCell = `
                                        <td class="text-center d-none">
                                            <div class="employee-image-upload-container" data-row-index="${employeeRowIndex}">
                                                <input type="file" 
                                                       class="form-control-file employee-image-input d-none" 
                                                       name="employee_amounts[${employeeRowIndex}][image]" 
                                                       id="employee_image_${employeeRowIndex}"
                                                       accept="image/*"
                                                       data-row-index="${employeeRowIndex}">
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-primary btn-upload-image" 
                                                        data-row-index="${employeeRowIndex}"
                                                        data-target="employee_image_${employeeRowIndex}"
                                                        title="Upload Image">
                                                    <i class="fas fa-upload"></i>
                                                </button>
                                                <div class="employee-image-preview mt-1" id="image_preview_${employeeRowIndex}" style="display: none;">
                                                    <img src="" alt="Preview" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-image" data-row-index="${employeeRowIndex}" style="display: none;">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <input type="hidden" class="employee-image-url" name="employee_amounts[${employeeRowIndex}][image_url]" id="employee_image_url_${employeeRowIndex}">
                                            </div>
                                        </td>
                                    `;
                                }
                                
                                // Build display text
                                let displayText = (emp.emp_no || emp.employee_code || '') + ' - ' + (emp.emp_name || emp.employee_name || 'Unknown');
                                
                                // Append to batch HTML
                                allRowsHTML += `
                                    <tr data-row-id="${rowId}" data-row-index="${employeeRowIndex}">
                                        <td>
                                            <select class="form-control employee-select select2" 
                                                    name="employee_amounts[${employeeRowIndex}][employee_id]" 
                                                    data-row-index="${employeeRowIndex}"
                                                    style="width: 100%;" ${requiredAttr}>
                                                <option value="">Search and Select Employee</option>
                                                <option value="${emp.employee_id}" selected>${displayText}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control price-input text-right employee-amount" 
                                                   name="employee_amounts[${employeeRowIndex}][amount]" 
                                                   data-row-index="${employeeRowIndex}"
                                                   placeholder="0.00" 
                                                   value="${emp.amount ? formatPriceWithCommas(emp.amount) : ''}"
                                                   ${requiredAttr}>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control employee-remark" 
                                                   name="employee_amounts[${employeeRowIndex}][remark]" 
                                                   data-row-index="${employeeRowIndex}"
                                                   placeholder="Enter remark"
                                                   value="${emp.remark || ''}">
                                        </td>
                                        <td>
                                            <select class="form-control employee-type-select" 
                                                    name="employee_amounts[${employeeRowIndex}][employee_type]" 
                                                    data-row-index="${employeeRowIndex}"
                                                    style="width: 100%;" ${requiredAttr}>
                                                <option value="casual" ${selectedEmployeeType === 'casual' ? 'selected' : ''}>Casual</option>
                                                <option value="medical" ${selectedEmployeeType === 'medical' ? 'selected' : ''}>Medical</option>
                                            </select>
                                        </td>
                                        <td class="d-none">
                                            <input type="text" class="form-control employee-epf_no" 
                                                   name="employee_amounts[${employeeRowIndex}][epf_no]" 
                                                   data-row-index="${employeeRowIndex}"
                                                   value="${emp.emp_etfno || ''}" readonly>
                                        </td>
                                        ${employeeMarkCell}
                                        ${employeeImageCell}
                                        <!-- <td>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-employee-row" data-row-id="${rowId}" title="Remove this employee">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td> -->
                                    </tr>
                                `;
                            });
                            
                            // Step 2: Append all rows at once (single DOM operation - much faster)
                            $('#employeeAmountsBody').append(allRowsHTML);
                            
                            // Update progress
                            if ($loadingOverlay) {
                                $loadingOverlay.find('.employee-loading-text').text('Initializing... (' + employeesToAdd.length + '/' + employeesToAdd.length + ')');
                            }
                            
                            // Step 3: Initialize all Select2 instances and set values (batch operation)
                            // Use requestAnimationFrame to batch DOM operations for better performance
                            requestAnimationFrame(function() {
                                let initPromises = [];
                                
                                Object.keys(rowDataMap).forEach(function(rowId) {
                                    let emp = rowDataMap[rowId];
                                    let $row = $(`#employeeAmountsBody tr[data-row-id="${rowId}"]`);
                                    let $employeeSelect = $row.find('.employee-select');
                                    
                                    // Initialize Select2
                                    initializeEmployeeSelect2ForRow($employeeSelect);
                                    
                                    // Initialize price formatting
                                    formatPriceInput($row.find('.employee-amount'));
                                    
                                    // Set employee type if available
                                    if (emp.employee_type && isAdvancePayment) {
                                        $row.find('.employee-type-select').val(emp.employee_type).trigger('change');
                                    }
                                    
                                    // Create promise to wait for Select2 to be ready and value set
                                    let initPromise = new Promise(function(resolve) {
                                        // Wait for Select2 initialization
                                        function waitForSelect2() {
                                            if ($employeeSelect.data('select2')) {
                                                // Select2 is ready, set value (option already in HTML)
                                                $employeeSelect.val(emp.employee_id).trigger('change');
                                                
                                                // Make bulk-loaded rows readonly/disabled
                                                $employeeSelect.prop('disabled', true).trigger('change.select2');
                                                $row.find('.employee-amount').prop('readonly', true);
                                                $row.find('.employee-remark').prop('readonly', true);
                                                if (isAdvancePayment) {
                                                    $row.find('.employee-type-select').prop('disabled', true);
                                                }
                                                // Add readonly class to row for styling
                                                $row.addClass('employee-row-readonly');
                                                
                                                resolve();
                                            } else {
                                                requestAnimationFrame(waitForSelect2);
                                            }
                                        }
                                        waitForSelect2();
                                    });
                                    
                                    initPromises.push(initPromise);
                                });
                                
                                // Wait for all Select2 initializations to complete
                                Promise.all(initPromises).then(function() {
                                    // Update total
                                    updateEmployeeAmountsTotal();
                                    
                                    // Hide loading spinner
                                    if ($loadingOverlay) {
                                        $loadingOverlay.fadeOut(300, function() {
                                            $(this).remove();
                                            success_toastify('Loaded ' + employeesToAdd.length + ' employee(s) from schedule group.');
                                        });
                                    } else {
                                        success_toastify('Loaded ' + employeesToAdd.length + ' employee(s) from schedule group.');
                                    }
                                });
                            });
                        } else {
                            // No pre-created employees found - user can still add manually
                            // Don't show error, just allow manual addition
                        }
                    },
                    error: function(xhr) {
                        console.error('Failed to load employees:', xhr);
                        // Remove loading spinner if it exists
                        $('.employee-loading-overlay').remove();
                        // Don't show error toast - allow manual addition
                    }
                });
            }
        });
    }
</script>
<?php include APPPATH . "views/include/footer.php"; ?>

