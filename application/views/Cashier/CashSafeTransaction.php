<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include APPPATH . "views/include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-shield"></i>Cash Safe Transactions</h1>
                </div>
            </div>

            <div class="container-fluid mt-2">
                <?php if (isset($active_shift_id) && $active_shift_id): ?>
                <script>
                    var activeShiftId = <?= $active_shift_id ?>;
                </script>
                <?php endif; ?>

                <style>
                /* Series selection styles */
                #transactionModal .modal-content.border-primary {
                    border-width: 3px !important;
                }

                #transactionModal .modal-content.border-danger {
                    border-width: 3px !important;
                }

                #transactionModal .modal-content.border-warning {
                    border-width: 3px !important;
                }

                #series {
                    font-weight: bold;
                    text-align: center;
                    font-size: 14px;
                    transition: all 0.2s ease;
                }

                #series:hover {
                    box-shadow: 0 0 0 2px rgba(255, 193, 7, 0.5);
                    transform: scale(1.02);
                }

                kbd {
                    background-color: #f7f7f7;
                    border: 1px solid #ccc;
                    border-radius: 3px;
                    box-shadow: 0 1px 0 rgba(0,0,0,0.2), 0 0 0 2px #fff inset;
                    color: #333;
                    display: inline-block;
                    font-family: Arial, sans-serif;
                    font-size: 11px;
                    line-height: 1.4;
                    margin: 0 .1em;
                    padding: .1em .6em;
                    text-shadow: 0 1px 0 #fff;
                }
                </style>
                <!-- Summary Cards -->
                <div class="row mb-4" id="summaryCards">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">Total Transactions</h5>
                                        <h3 class="mb-0" id="totalTransactions">0</h3>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fa fa-list fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">Cash In</h5>
                                        <h3 class="mb-0" id="totalCashIn">Rs. 0.00</h3>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fa fa-arrow-up fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">Cash Out</h5>
                                        <h3 class="mb-0" id="totalCashOut">Rs. 0.00</h3>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fa fa-arrow-down fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-info text-white mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">Net Amount</h5>
                                        <h3 class="mb-0" id="netAmount">Rs. 0.00</h3>
                                    </div>
                                    <div class="card-icon">
                                        <i class="fa fa-balance-scale fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Cash Safe Transactions</h5>
                        <div>
                            <button class="btn btn-primary" id="addTransactionBtn" data-toggle="modal" data-target="#transactionModal">
                                <i class="fa fa-plus mr-2"></i> Add Transaction
                            </button>
                            <button class="btn btn-warning ml-2" id="bulkCashOutBtn" data-toggle="modal" data-target="#bulkCashOutModal">
                                <i class="fa fa-arrow-down mr-2"></i> Cash Out
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <select class="form-control" id="filterTransactionType">
                                    <option value="">All Types</option>
                                    <option value="cash_in">Cash In</option>
                                    <option value="cash_out">Cash Out</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" id="filterDateFrom" placeholder="From Date">
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" id="filterDateTo" placeholder="To Date">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-secondary" id="filterBtn">
                                    <i class="fa fa-filter"></i> Filter
                                </button>
                                <button class="btn btn-outline-secondary" id="clearFilterBtn">
                                    <i class="fa fa-times"></i> Clear
                                </button>
                            </div>
                        </div>

                        <!-- Transactions Table -->
                        <table id="transactionsTable" class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Input Method</th>
                                    <th>Added By / Out By</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <!-- Transaction Modal -->
        <div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="transactionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transactionModalLabel">Add Cash Safe Transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="transactionForm">
                        <div class="modal-body">
                            <input type="hidden" id="transactionId" name="transaction_id">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="transactionType">Transaction Type <span class="text-danger">*</span></label>
                                        <select class="form-control" id="transactionType" name="transaction_type" required>
                                            <option value="">Select Type</option>
                                            <option value="cash_in">Cash In</option>
                                            <option value="cash_out">Cash Out</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">Amount <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="amount" name="amount_display" placeholder="0.00" required>
                                        <input type="hidden" id="amount_actual" name="amount">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputMethod">Input Method <span class="text-danger">*</span></label>
                                        <select class="form-control" id="inputMethod" name="input_method" required>
                                            <option value="">Select Method</option>
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 d-none">
                                    <div class="form-group">
                                        <label for="series">Series <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="series" name="series" readonly style="background-color: #fff3cd; cursor: pointer;" placeholder="Click to select or use Page Up/Down" title="Click to cycle through series or use Page Up/Down keys">
                                        <small class="form-text text-muted">Click to select Series 1/2 or use: <kbd>Page Up</kbd> (Series 1 - Blue) | <kbd>Page Down</kbd> (Series 2 - Red) | <strong class="text-danger">Required</strong></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="transactionDate">Transaction Date</label>
                                        <small class="form-text text-muted">Automatically set to current date/time</small>
                                        <input type="datetime-local" class="form-control" id="transactionDate" name="transaction_date" readonly value="<?php echo date('Y-m-d\TH:i'); ?>" style="background-color: #f8f9fa; cursor: not-allowed;">
                                    </div>
                                </div>
                            </div>

                            <!-- Cheque-specific fields -->
                            <div class="row" id="chequeFields" style="display: none;">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="chequeNo">Cheque Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="chequeNo" name="cheque_no" placeholder="Enter cheque number">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bank">Bank <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="bank" name="bank" placeholder="Enter bank name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="chequeDate">Cheque Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="chequeDate" name="cheque_date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jobCardNo">Job Card Number</label>
                                        <input type="text" class="form-control" id="jobCardNo" name="job_card_no" placeholder="Enter job card number">
                                    </div>
                                </div>
                            </div>

                            <!-- Conditional fields based on transaction type -->
                            <div class="row" id="cashInFields" style="display: none;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="addedBy">Added By (Current Cashier)</label>
                                        <input type="text" class="form-control" id="addedBy" name="added_by_display" readonly>
                                        <input type="hidden" id="addedById" name="added_by">
                                        <small class="form-text text-muted">Automatically set to current shift cashier</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="cashOutFields" style="display: none;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="outBy">Out By <span class="text-danger">*</span></label>
                                        <select class="form-control" id="outBy" name="out_by">
                                            <option value="">Select person authorizing the cash out</option>
                                        </select>
                                        <small class="form-text text-muted">Select the person authorizing this cash out transaction</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remarks">Remarks</label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="3" maxlength="1000"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveTransactionBtn">
                                <i class="fa fa-save"></i> Save Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this cash safe transaction?</p>
                        <p class="text-danger">This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>

<!-- Bulk Cash Out Modal -->
<div class="modal fade" id="bulkCashOutModal" tabindex="-1" role="dialog" aria-labelledby="bulkCashOutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkCashOutModalLabel">
                    <i class="fa fa-money"></i> Bulk Cash Out
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> Select one or more cash-in transactions below to create corresponding cash-out entries.
                </div>

                <!-- Cash In Transactions Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="cashInTable">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%"><input type="checkbox" id="selectAllCashIn"></th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Added By</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="cashInTableBody">
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    Loading cash-in transactions...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Bulk Cash Out Form -->
                <div id="bulkCashOutForm" style="display: none;">
                    <hr>
                    <h6><i class="fa fa-cogs"></i> Cash Out Details (Applied to All Selected Transactions)</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulkOutBy">Out By <span class="text-danger">*</span></label>
                                <select class="form-control" id="bulkOutBy" required>
                                    <option value="">Select person authorizing the cash out</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulkRemark">Remark</label>
                                <textarea class="form-control" id="bulkRemark" rows="2" placeholder="Common remark for all cash-out transactions"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <strong>Selected Transactions:</strong> <span id="selectedCount">0</span>
                        <br>
                        <strong>Note:</strong> This will create individual cash-out records for each selected cash-in transaction.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-success" id="proceedBulkCashOut" style="display: none;">
                    <i class="fa fa-money"></i> Proceed Bulk Cash Out
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Moment.js for date handling -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<!-- DataTables JS for this page -->
<?php include APPPATH . "views/include/footerscripts.php"; ?>

<script>
$(document).ready(function() {
    let transactionsTable;
    let currentTransactionId = null;

    // Track secret code state for showing both series
    let showBothSeries = false;
    let secretCodeBuffer = '';

    // Track bulk cash out series visibility
    let bulkCashOutShowBothSeries = false;

    // Initialize DataTable
    if ($('#transactionsTable').length) {
        transactionsTable = $('#transactionsTable').DataTable({
        ajax: {
            url: '<?php echo base_url("CashSafeTransaction/datatable"); ?>',
            type: 'POST',
            data: function(d) {
                // Default to current active shift if available
                d.shift_id = (typeof activeShiftId !== 'undefined' && activeShiftId) ? activeShiftId : $('#filterShiftId').val();
                d.transaction_type = $('#filterTransactionType').val();
                d.date_from = $('#filterDateFrom').val();
                d.date_to = $('#filterDateTo').val();
                d.show_both_series = showBothSeries ? 1 : 0; // Send flag to backend
            }
        },
        serverSide: true,
        processing: true,
            columns: [
            {
                data: 'code',
                render: function(data, type, row) {
                    if (data && data.startsWith('DRFT-')) {
                        return `<span class="badge badge-warning" title="Draft Code">${data}</span>`;
                    } else {
                        return `<span class="badge badge-primary">${data}</span>`;
                    }
                }
            },
            {
                data: 'transaction_type',
                render: function(data) {
                    return data === 'cash_in' ?
                        '<span class="badge badge-success">Cash In</span>' :
                        '<span class="badge badge-danger">Cash Out</span>';
                }
            },
            {
                data: 'transaction_date',
                render: function(data) {
                    return moment(data).format('Y-MM-DD HH:mm');
                }
            },
            {
                data: 'amount',
                render: function(data) {
                    return 'Rs. ' + parseFloat(data).toLocaleString('en-US', {minimumFractionDigits: 2});
                }
            },
            {
                data: 'input_method',
                render: function(data) {
                    return data === 'cash' ? 'Cash' : 'Cheque';
                }
            },
            {
                data: null,
                render: function(data) {
                    if (data.transaction_type === 'cash_in') {
                        return data.added_by_name || 'N/A';
                    } else {
                        return data.out_by || 'N/A';
                    }
                }
            },
            {
                data: 'status',
                render: function(data) {
                    const statusClasses = {
                        'draft': 'badge-warning',
                        'approved': 'badge-success',
                        'cancel': 'badge-danger'
                    };
                    const statusLabels = {
                        'draft': 'Draft',
                        'approved': 'Approved',
                        'cancel': 'Cancelled'
                    };
                    return `<span class="badge ${statusClasses[data] || 'badge-secondary'}">${statusLabels[data] || data}</span>`;
                }
            },
            {
                data: null,
                orderable: false,
                className: 'text-right',
                render: function(data) {
                    let actions = '';

                    if (data.record_status !== 'delete') {
                        if (data.status === 'draft') {
                            // Draft transactions: Edit, Delete, Approve, Cancel
                            actions += `<button class="btn btn-sm btn-info edit-btn" data-id="${data.id}" title="Edit Transaction Details">
                                <i class="fa fa-edit"></i>
                            </button> `;

                            actions += `<button class="btn btn-sm btn-warning approve-btn" data-id="${data.id}" title="Approve Transaction (Generates Final Code)">
                                <i class="fa fa-thumbs-up"></i>
                            </button> `;

                            actions += `<button class="btn btn-sm btn-danger cancel-btn" data-id="${data.id}" title="Cancel Transaction">
                                <i class="fa fa-ban"></i>
                            </button> `;

                            actions += `<button class="btn btn-sm btn-danger delete-btn" data-id="${data.id}" title="Delete Transaction">
                                <i class="fa fa-trash"></i>
                            </button>`;
                        } else if (data.status === 'approved') {
                            // Approved transactions: Cancel only
                            actions += `<button class="btn btn-sm btn-danger cancel-btn" data-id="${data.id}" title="Revoke Transaction Approval">
                                <i class="fa fa-undo"></i>
                            </button> `;

                            actions += `<button class="btn btn-sm btn-success" disabled title="Transaction Approved">
                                <i class="fa fa-check-circle"></i>
                            </button> `;
                        } else if (data.status === 'cancel') {
                            // Cancelled transactions: Show cancelled status
                            actions += `<button class="btn btn-sm btn-secondary" disabled title="Transaction Cancelled">
                                <i class="fa fa-ban"></i>
                            </button> `;
                        }
                    }

                    return actions;
                }
            }
        ],
        pageLength: 25,
        order: [[2, 'desc']], // Sort by transaction date descending
        responsive: true,
        rowCallback: function(row, data) {
            // Color rows based on is_confirm value (similar to CashMovement.php)
            if (data.is_confirm == 0) {
                $(row).css('background-color', '#f7cac1'); // Light red/pink background for series 2
            }
        }
    });
    } else {
        console.error('DataTable element #transactionsTable not found');
    }

    // Load summary data
    loadSummary();

    // Load form options (dropdowns)
    loadFormOptions().catch(function(error) {
        console.error('Failed to load initial form options:', error);
    });

    // Initialize series as empty (yellow color)
    $('#series').val('');
    updateModalBorderBySeries();

    // Initialize bulk cash out functionality
    initializeBulkCashOut();

    // Initialize secret code functionality for showing both series
    initializeSecretCode();

    // Initialize amount formatting with thousand separators
    initializeAmountFormatting();

    // Transaction type change handler
    $('#transactionType').change(function() {
        const transactionType = $(this).val();

        if (transactionType === 'cash_in') {
            $('#cashInFields').show();
            $('#cashOutFields').hide();
            $('#outBy').prop('required', false);
            $('#addedBy').prop('required', true);
            // Set current user as added by
            setCurrentCashier();
        } else if (transactionType === 'cash_out') {
            $('#cashInFields').hide();
            $('#cashOutFields').show();
            $('#outBy').prop('required', true);
            $('#addedBy').prop('required', false);
        } else {
            $('#cashInFields, #cashOutFields').hide();
            $('#outBy, #addedBy').prop('required', false);
        }
    });

    // Input method change handler - show/hide cheque fields
    $('#inputMethod').change(function() {
        const inputMethod = $(this).val();
        
        if (inputMethod === 'cheque') {
            $('#chequeFields').show();
            // Make cheque fields required
            $('#chequeNo, #bank, #chequeDate').prop('required', true);
        } else {
            $('#chequeFields').hide();
            // Remove required attribute and clear values
            $('#chequeNo, #bank, #chequeDate, #jobCardNo').prop('required', false).val('');
        }
    });

    // Add transaction button
    $('#addTransactionBtn').click(function() {
        resetTransactionForm();
        $('#transactionModalLabel').text('Add Cash Safe Transaction');

        // Ensure form options are loaded before showing modal
        loadFormOptions().then(function() {
            $('#transactionModal').modal('show');
        }).catch(function() {
            // Show modal even if options fail to load
            $('#transactionModal').modal('show');
        });
    });

    // Edit button
    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        editTransaction(id);
    });

    // Confirm button
    $(document).on('click', '.confirm-btn', function() {
        const id = $(this).data('id');
        confirmTransaction(id);
    });

    // Approve button
    $(document).on('click', '.approve-btn', function() {
        const id = $(this).data('id');
        approveTransaction(id);
    });

    // Cancel button
    $(document).on('click', '.cancel-btn', function() {
        const id = $(this).data('id');
        cancelTransaction(id);
    });

    // Delete button
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        currentTransactionId = id;
        $('#deleteModal').modal('show');
    });

    // Confirm delete
    $('#confirmDeleteBtn').click(function() {
        if (currentTransactionId) {
            deleteTransaction(currentTransactionId);
        }
    });

    // Filter button
    $('#filterBtn').click(function() {
        transactionsTable.ajax.reload();
        loadSummary();
    });

    // Clear filter button
    $('#clearFilterBtn').click(function() {
        $('#filterTransactionType, #filterDateFrom, #filterDateTo').val('');
        transactionsTable.ajax.reload();
        loadSummary();
    });

    // Form submission
    $('#transactionForm').submit(function(e) {
        e.preventDefault();
        saveTransaction();
    });

    function resetTransactionForm() {
        $('#transactionForm')[0].reset();
        $('#transactionId').val('');
        $('#cashInFields, #cashOutFields, #chequeFields').hide();
        $('#series').val('');
        updateModalBorderBySeries();
        $('#transactionModalLabel').text('Add Cash Safe Transaction');

        // Reset cheque fields
        $('#chequeNo, #bank, #chequeDate, #jobCardNo').val('').prop('required', false);

        // Reset amount fields
        $('#amount, #amount_actual').val('');

        // Set default current date/time for new transactions
        $('#transactionDate').val(moment().format('YYYY-MM-DDTHH:mm'));
    }

    function setCurrentCashier() {
        // This would be set from the current shift/session data
        // For now, we'll get it from the auth user
        $('#addedBy').val('<?php echo ucfirst($_SESSION['name']); ?>');
        $('#addedById').val('<?php echo $_SESSION['userid']; ?>');
    }

    function saveTransaction() {
        // Validate series selection
        const seriesValue = $('#series').val();
        if (!seriesValue || (seriesValue !== '1' && seriesValue !== '0')) {
            toastr.error('Please select a Series by clicking the Series field or using Page Up (Series 1) / Page Down (Series 2) keys.');
            $('#series').focus();
            return;
        }

        // Validate and prepare amount
        let amountValue = $('#amount_actual').val();
        if (!amountValue || parseFloat(amountValue) <= 0) {
            // Try to parse from display field if actual is empty
            amountValue = parseFormattedNumber($('#amount').val());
            if (!amountValue || parseFloat(amountValue) <= 0) {
                toastr.error('Please enter a valid amount.');
                $('#amount').focus();
                return;
            }
            $('#amount_actual').val(amountValue);
        }

        // Validate cheque fields if input method is cheque
        const inputMethod = $('#inputMethod').val();
        if (inputMethod === 'cheque') {
            const chequeNo = $('#chequeNo').val().trim();
            const bank = $('#bank').val().trim();
            const chequeDate = $('#chequeDate').val();

            if (!chequeNo) {
                toastr.error('Please enter the cheque number.');
                $('#chequeNo').focus();
                return;
            }

            if (!bank) {
                toastr.error('Please enter the bank name.');
                $('#bank').focus();
                return;
            }

            if (!chequeDate) {
                toastr.error('Please select the cheque date.');
                $('#chequeDate').focus();
                return;
            }
        }

        const formData = new FormData($('#transactionForm')[0]);
        const transactionId = $('#transactionId').val();

        // Ensure amount is set to actual numeric value (remove display field if it exists)
        formData.delete('amount_display');
        if (!formData.has('amount') || formData.get('amount') === '') {
            formData.set('amount', amountValue);
        }

        // Add series value as is_confirm (1 for series 1, 0 for series 2)
        const isConfirm = seriesValue === '1' ? 1 : 0;
        formData.append('is_confirm', isConfirm);

        // Add status (draft for new transactions)
        if (!transactionId) {
            formData.append('status', 'draft');
        }

        // Add current shift ID if available
        if (typeof activeShiftId !== 'undefined' && activeShiftId) {
            formData.append('shift_id', activeShiftId);
        }

        const url = transactionId ?
            '<?php echo base_url("CashSafeTransaction/update/"); ?>' + transactionId :
            '<?php echo base_url("CashSafeTransaction/create"); ?>';

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                // Check if response exists and has success property
                if (response && typeof response === 'object' && response.success === true) {
                    try {
                        $('#transactionModal').modal('hide');
                        transactionsTable.ajax.reload();
                        loadSummary();
                        toastr.success(response.message || 'Transaction saved successfully');
                    } catch (error) {
                        console.error('Error in success processing:', error);
                        toastr.error('Transaction saved but UI update failed');
                    }
                } else {
                    toastr.error(response && response.message ? response.message : 'Failed to save transaction');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred while saving the transaction');
                console.error(error);
            }
        });
    }

    function editTransaction(id) {
        $.ajax({
            url: '<?php echo base_url("CashSafeTransaction/getById/"); ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const transaction = response.data;
                    populateTransactionForm(transaction);
                    $('#transactionModalLabel').text('Edit Cash Safe Transaction');
                    $('#transactionModal').modal('show');
                } else {
                    toastr.error(response.message || 'Failed to load transaction');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred while loading the transaction');
                console.error(error);
            }
        });
    }

    function populateTransactionForm(transaction) {
        $('#transactionId').val(transaction.id);
        $('#transactionType').val(transaction.transaction_type).trigger('change');
        
        // Format amount with thousand separators
        if (transaction.amount) {
            let formattedAmount = formatNumberWithCommas(parseFloat(transaction.amount).toFixed(2));
            $('#amount').val(formattedAmount);
            $('#amount_actual').val(transaction.amount);
        } else {
            $('#amount, #amount_actual').val('');
        }
        
        $('#inputMethod').val(transaction.input_method).trigger('change');
        $('#transactionDate').val(moment(transaction.transaction_date).format('YYYY-MM-DDTHH:mm'));
        $('#remarks').val(transaction.remarks);

        // Populate cheque fields if input method is cheque
        if (transaction.input_method === 'cheque') {
            $('#chequeNo').val(transaction.cheque_no || '');
            $('#bank').val(transaction.bank || '');
            $('#chequeDate').val(transaction.cheque_date ? moment(transaction.cheque_date).format('YYYY-MM-DD') : '');
            $('#jobCardNo').val(transaction.job_card_no || '');
        }

        // Set series based on is_confirm (1 = Series 1, 0 = Series 2, null/undefined = empty for yellow)
        let seriesValue = '';
        if (transaction.is_confirm === 1) {
            seriesValue = '1';
        } else if (transaction.is_confirm === 0) {
            seriesValue = '0';
        }
        // If is_confirm is null/undefined, seriesValue remains empty (yellow)
        $('#series').val(seriesValue);
        updateModalBorderBySeries();

        if (transaction.transaction_type === 'cash_in') {
            $('#addedBy').val(transaction.added_by['name'] || '');
            $('#addedById').val(transaction.added_by['id'] || '');
        } else if (transaction.transaction_type === 'cash_out') {
            $('#outBy').val(transaction.out_by || '');
        }
    }

    function confirmTransaction(id) {
        if (confirm('Are you sure you want to confirm this transaction?')) {
            $.ajax({
                url: '<?php echo base_url("CashSafeTransaction/confirm/"); ?>' + id,
                type: 'POST',
                success: function(response) {
                if (response.success) {
                    transactionsTable.ajax.reload();
                    loadSummary();
                    toastr.success(response.message || 'Transaction confirmed successfully');
                } else {
                    toastr.error(response.message || 'Failed to confirm transaction');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred while confirming the transaction');
                console.error(error);
            }
        });
        }
    }

    function approveTransaction(id) {
        if (confirm('Are you sure you want to approve this transaction? Once approved, it cannot be edited or deleted.')) {
            $.ajax({
                url: '<?php echo base_url("CashSafeTransaction/approve/"); ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        transactionsTable.ajax.reload();
                        loadSummary();
                        toastr.success(response.message || 'Transaction approved successfully');
                    } else {
                        toastr.error(response.message || 'Failed to approve transaction');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while approving the transaction');
                    console.error(error);
                }
            });
        }
    }

    function cancelTransaction(id) {
        if (confirm('Are you sure you want to cancel this transaction? This action cannot be undone.')) {
            $.ajax({
                url: '<?php echo base_url("CashSafeTransaction/cancel/"); ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        transactionsTable.ajax.reload();
                        loadSummary();
                        toastr.success(response.message || 'Transaction cancelled successfully');
                    } else {
                        toastr.error(response.message || 'Failed to cancel transaction');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while cancelling the transaction');
                    console.error(error);
                }
            });
        }
    }

    function deleteTransaction(id) {
        $.ajax({
            url: '<?php echo base_url("CashSafeTransaction/delete/"); ?>' + id,
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    $('#deleteModal').modal('hide');
                    transactionsTable.ajax.reload();
                    loadSummary();
                    toastr.success(response.message || 'Transaction deleted successfully');
                } else {
                    toastr.error(response.message || 'Failed to delete transaction');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred while deleting the transaction');
                console.error(error);
            }
        });
    }

    function loadSummary() {
        const params = {
            date_from: $('#filterDateFrom').val(),
            date_to: $('#filterDateTo').val(),
            shift_id: (typeof activeShiftId !== 'undefined' && activeShiftId) ? activeShiftId : $('#filterShiftId').val(),
            show_both_series: showBothSeries ? 1 : 0 // Include series visibility flag
        };

        $.ajax({
            url: '<?php echo base_url("CashSafeTransaction/getSummary"); ?>',
            type: 'GET',
            data: params,
            dataType: 'json',
            success: function(response) {
                // Handle both string and object responses
                if (typeof response === 'string') {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.error('Error parsing summary response:', e);
                        return;
                    }
                }

                if (response && response.success && response.data) {
                    const summary = response.data;
                    $('#totalTransactions').text(summary.total_transactions || 0);
                    
                    // Format amounts with thousand separators
                    const totalCashIn = parseFloat(summary.total_cash_in || 0);
                    const totalCashOut = parseFloat(summary.total_cash_out || 0);
                    const netAmount = parseFloat(summary.net_amount || 0);
                    
                    $('#totalCashIn').text('Rs. ' + totalCashIn.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                    $('#totalCashOut').text('Rs. ' + totalCashOut.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                    $('#netAmount').text('Rs. ' + netAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                } else {
                    console.error('Invalid summary response structure:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading summary:', error);
                console.error('Response:', xhr.responseText);
            }
        });
    }

    // Function to load form options (dropdowns)
    function loadFormOptions() {
        return new Promise(function(resolve, reject) {
            // First try to load from API
            $.ajax({
                url: '<?php echo base_url("CashSafeTransaction/getOptions"); ?>',
                type: 'GET',
                success: function(response) {
                    if (response && response.success && response.data) {
                        // Populate out_by dropdown
                        if (response.data.out_by_options) {
                            populateOutByDropdown(response.data.out_by_options);
                            resolve();
                        } else {
                            loadFallbackOptions();
                            resolve();
                        }
                    } else {
                        loadFallbackOptions();
                        resolve();
                    }
                },
                error: function(xhr, status, error) {
                   
                    loadFallbackOptions();
                    resolve(); 
                }
            });
        });
    }

    // Function to populate out_by dropdown
    function populateOutByDropdown(options) {
        const outBySelect = $('#outBy');
        outBySelect.empty();
        outBySelect.append('<option value="">Select person authorizing the cash out</option>');

        options.forEach(function(option) {
            outBySelect.append(`<option value="${option.value}">${option.label}</option>`);
        });
    }

    // Fallback options in case API fails
    function loadFallbackOptions() {
        const fallbackOptions = [
            {value: 'MD', label: 'MD'},
            {value: 'Mr.Manusha', label: 'Mr. Manusha'},
            {value: 'Miss.Madhu', label: 'Miss Madhu'},
            {value: 'Madam', label: 'Madam'},
            {value: 'Other', label: 'Other'}
        ];
        populateOutByDropdown(fallbackOptions);
    }

    // Manual series selection by clicking (Empty -> Series 1 -> Series 2 -> Series 1...)
    $('#series').on('click', function() {
        const currentValue = $(this).val();
        let nextValue = '1'; // Default for empty state

        if (currentValue === '1') {
            nextValue = '0'; // Series 1 -> Series 2
        } else if (currentValue === '0') {
            nextValue = '1'; // Series 2 -> Series 1
        }
        // If empty, set to Series 1

        $(this).val(nextValue);
        updateModalBorderBySeries();
    });

    // Series selection with Page Up/Down keys
    $(document).on('keydown', function(e) {
        // Check if modal is open
        const isModalOpen = $('#transactionModal').hasClass('show');

        if (!isModalOpen) {
            return; // Only work when modal is open
        }

        // Ignore if typing in an input field or textarea (except series field itself)
        if ($(e.target).is('input:not(#series), textarea, select:not(#series)')) {
            return;
        }

        // Page Up key (keyCode 33) - SELECT SERIES 1
        if (e.keyCode === 33 || e.which === 33) {
            e.preventDefault(); // Prevent page scroll

            // Set Series 1
            $('#series').val('1');

            // Update modal border to PRIMARY (BLUE)
            updateModalBorderBySeries();

        }

        // Page Down key (keyCode 34) - SELECT SERIES 2
        if (e.keyCode === 34 || e.which === 34) {
            e.preventDefault(); // Prevent page scroll

            // Set Series 2
            $('#series').val('0');

            // Update modal border to DANGER (RED)
            updateModalBorderBySeries();

        }
    });

    // Update modal border color based on selected series
    function updateModalBorderBySeries() {
        const seriesValue = $('#series').val();

        // Remove any existing series border classes
        $('#transactionModal .modal-content').removeClass('border-primary border-danger border-warning');

        if (seriesValue === '1') {
            // Series 1 - PRIMARY (BLUE) border
            $('#transactionModal .modal-content').addClass('border-primary');
            $('#series').css('background-color', '#cce5ff'); // Light blue background
        } else if (seriesValue === '0') {
            // Series 2 - DANGER (RED) border
            $('#transactionModal .modal-content').addClass('border-danger');
            $('#series').css('background-color', '#f8d7da'); // Light red background
        } else {
            // Null/Empty - WARNING (YELLOW) border
            $('#transactionModal .modal-content').addClass('border-warning');
            $('#series').css('background-color', '#fff3cd'); // Light yellow background
        }
    }

    // Bulk Cash Out functionality
    function initializeBulkCashOut() {
        // Handle bulk cash out modal show
        $('#bulkCashOutModal').on('show.bs.modal', function() {
            loadCashInTransactions();
            loadBulkFormOptions();
        });

        // Handle bulk cash out modal hide - reset to default view
        $('#bulkCashOutModal').on('hide.bs.modal', function() {
            // Reset to show only is_confirm = 1 when modal closes
            bulkCashOutShowBothSeries = false;
        });

        // Handle select all checkbox
        $('#selectAllCashIn').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('#cashInTableBody input[type="checkbox"]').prop('checked', isChecked);
            updateSelectedCount();
        });

        // Handle individual checkbox changes
        $(document).on('change', '#cashInTableBody input[type="checkbox"]', function() {
            updateSelectedCount();
        });

        // Handle proceed bulk cash out
        $('#proceedBulkCashOut').on('click', function() {
            proceedBulkCashOut();
        });

        // Handle Page Up/Down keys for bulk cash out modal
        $(document).on('keydown', function(e) {
            // Only handle when bulk cash out modal is visible
            if (!$('#bulkCashOutModal').hasClass('show')) {
                return;
            }

            if (e.keyCode === 33) { // Page Up key
                e.preventDefault();
                bulkCashOutShowBothSeries = true;
                loadCashInTransactions(); // Reload with both series
                toastr.info('Bulk Cash Out: Showing both Series 1 and Series 2');
            } else if (e.keyCode === 34) { // Page Down key
                e.preventDefault();
                bulkCashOutShowBothSeries = false;
                loadCashInTransactions(); // Reload with series 1 only
                toastr.info('Bulk Cash Out: Showing Series 1 only');
            }
        });
    }

    function initializeAmountFormatting() {
        // Format amount with thousand separators on input
        $('#amount').on('input', function(e) {
            let value = $(this).val().replace(/[^\d.]/g, ''); // Remove all non-numeric characters except decimal point
            
            // Ensure only one decimal point
            let parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
            }
            
            // Limit decimal places to 2
            if (parts.length === 2 && parts[1].length > 2) {
                value = parts[0] + '.' + parts[1].substring(0, 2);
            }
            
            // Store the actual numeric value in hidden field
            $('#amount_actual').val(value || '');
            
            // Format with thousand separators for display
            if (value) {
                let formatted = formatNumberWithCommas(value);
                $(this).val(formatted);
            } else {
                $(this).val('');
            }
        });

        // Handle backspace and delete to allow proper editing
        $('#amount').on('keydown', function(e) {
            // Allow: backspace, delete, tab, escape, enter, decimal point
            if ([46, 8, 9, 27, 13, 110, 190].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (e.keyCode === 65 && e.ctrlKey === true) ||
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 86 && e.ctrlKey === true) ||
                (e.keyCode === 88 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        // Handle paste event
        $('#amount').on('paste', function(e) {
            e.preventDefault();
            let paste = (e.originalEvent || e).clipboardData.getData('text/plain');
            let numericValue = paste.replace(/[^\d.]/g, '');
            $(this).val('');
            $(this).val(numericValue).trigger('input');
        });
    }

    function formatNumberWithCommas(value) {
        // Split integer and decimal parts
        let parts = value.toString().split('.');
        let integerPart = parts[0];
        let decimalPart = parts[1] || '';
        
        // Add thousand separators to integer part
        integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        
        // Combine with decimal part
        return decimalPart ? integerPart + '.' + decimalPart : integerPart;
    }

    function parseFormattedNumber(value) {
        // Remove thousand separators and return numeric value
        return value.toString().replace(/,/g, '');
    }

    function initializeSecretCode() {
        // Listen for secret code 'boom' to toggle showing both series
        $(document).on('keypress', function(e) {
            secretCodeBuffer += String.fromCharCode(e.which).toLowerCase();

            // Keep only last 4 characters
            if (secretCodeBuffer.length > 4) {
                secretCodeBuffer = secretCodeBuffer.slice(-4);
            }

            // Check if secret code 'boom' was entered
            if (secretCodeBuffer === 'boom') {
                showBothSeries = !showBothSeries; // Toggle the flag
                secretCodeBuffer = ''; // Reset buffer

                // Reload the table and summary with new series visibility
                transactionsTable.ajax.reload();
                loadSummary();

                // Show feedback to user
                if (showBothSeries) {
                    toastr.info('Series visibility: Showing both Series 1 and Series 2');
                } else {
                    toastr.info('Series visibility: Showing Series 1 only');
                }
            }
        });
    }

    function loadCashInTransactions() {
        $('#cashInTableBody').html(`
            <tr>
                <td colspan="6" class="text-center">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    Loading cash-in transactions...
                </td>
            </tr>
        `);

        $.ajax({
            url: '<?php echo base_url("CashSafeTransaction/datatable"); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                transaction_type: 'cash_in',
                status: 'approved',
                shift_id: (typeof activeShiftId !== 'undefined' && activeShiftId) ? activeShiftId : $('#filterShiftId').val(),
                exclude_bulk_processed: true,
                show_both_series: bulkCashOutShowBothSeries ? 1 : 0
            },
            success: function(response) {
                if (response && response.data && Array.isArray(response.data) && response.data.length > 0) {
                    populateCashInTable(response.data);
                } else {
                    $('#cashInTableBody').html(`
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No approved cash-in transactions found.
                            </td>
                        </tr>
                    `);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading cash-in transactions:', error);
                $('#cashInTableBody').html(`
                    <tr>
                        <td colspan="6" class="text-center text-danger">
                            Error loading transactions. Please try again.
                        </td>
                    </tr>
                `);
            }
        });
    }

    function populateCashInTable(transactions) {
        let html = '';

        if (transactions.length === 0) {
            html = `
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No approved cash-in transactions found.
                    </td>
                </tr>
            `;
        } else {
            transactions.forEach(function(transaction) {
                const dateFormatted = moment(transaction.transaction_date).format('Y-MM-DD HH:mm');
                html += `
                    <tr>
                        <td>
                            <input type="checkbox" class="cash-in-checkbox" value="${transaction.id}" data-amount="${transaction.amount}" data-is-confirm="${transaction.is_confirm}" data-input-method="${transaction.input_method}">
                        </td>
                        <td>${transaction.code || '-'}</td>
                        <td><span class="badge badge-success">Cash In</span></td>
                        <td>Rs. ${parseFloat(transaction.amount).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                        <td>${transaction.added_by || '-'}</td>
                        <td>${dateFormatted}</td>
                    </tr>
                `;
            });
        }

        $('#cashInTableBody').html(html);
        $('#selectAllCashIn').prop('checked', false);
        updateSelectedCount();
    }

    function loadBulkFormOptions() {
        // Load out_by options for bulk cash out
        loadFormOptions().then(function() {
            // Copy options to bulk modal
            const bulkOutBy = $('#bulkOutBy');
            const originalOutBy = $('#outBy');

            bulkOutBy.html(originalOutBy.html());
        }).catch(function(error) {
            console.error('Failed to load bulk form options:', error);
        });
    }

    function updateSelectedCount() {
        const selectedCount = $('#cashInTableBody input[type="checkbox"]:checked').length;
        $('#selectedCount').text(selectedCount);

        if (selectedCount > 0) {
            $('#bulkCashOutForm').show();
            $('#proceedBulkCashOut').show();
        } else {
            $('#bulkCashOutForm').hide();
            $('#proceedBulkCashOut').hide();
        }
    }

    function proceedBulkCashOut() {
        const selectedTransactions = $('#cashInTableBody input[type="checkbox"]:checked');
        const outBy = $('#bulkOutBy').val();
        const remark = $('#bulkRemark').val();

        if (selectedTransactions.length === 0) {
            toastr.error('Please select at least one transaction.');
            return;
        }

        if (!outBy) {
            toastr.error('Please select "Out By" person.');
            $('#bulkOutBy').focus();
            return;
        }

        if (!confirm(`Are you sure you want to create cash-out entries for ${selectedTransactions.length} selected transaction(s)?`)) {
            return;
        }

        // Collect transaction data (ID, is_confirm, amount, and input_method)
        const transactionData = [];
        selectedTransactions.each(function() {
            transactionData.push({
                id: $(this).val(),
                is_confirm: $(this).data('is-confirm'),
                amount: $(this).data('amount'),
                input_method: $(this).data('input-method')
            });
        });

        // Process bulk cash out
        processBulkCashOut(transactionData, outBy, remark);
    }

    function processBulkCashOut(transactionData, outBy, remark) {
        $('#proceedBulkCashOut').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

        let processed = 0;
        let errors = 0;

        // Process each transaction sequentially
        function processNext() {
            console.log('processNext called - processed:', processed, 'total:', transactionData.length, 'errors:', errors);

            if (processed + errors >= transactionData.length) {
                // All done (processed + errors should equal total transactions)
                console.log('All transactions processed. Processed:', processed, 'Errors:', errors);
                $('#proceedBulkCashOut').prop('disabled', false).html('<i class="fa fa-money"></i> Proceed Bulk Cash Out');

                if (errors === 0) {
                    toastr.success(`Successfully created ${processed} cash-out transactions.`);
                    $('#bulkCashOutModal').modal('hide');
                    transactionsTable.ajax.reload();
                    loadSummary();
                } else {
                    toastr.warning(`Processed ${processed - errors} transactions successfully. ${errors} failed.`);
                }
                return;
            }

            const currentTransaction = transactionData[processed];

            // Create cash out transaction
            const formData = new FormData();
            formData.append('transaction_type', 'cash_out');
            formData.append('amount', currentTransaction.amount); // Use amount from original cash-in transaction
            formData.append('input_method', currentTransaction.input_method); // Use input_method from original cash-in transaction
            formData.append('out_by', outBy);
            formData.append('remarks', remark);
            formData.append('is_confirm', currentTransaction.is_confirm); // Use is_confirm from original cash-in transaction
            formData.append('status', 'approved'); // Auto-approve bulk cash outs
            formData.append('reference_transaction_id', currentTransaction.id);

            // Add current shift ID
            if (typeof activeShiftId !== 'undefined' && activeShiftId) {
                formData.append('shift_id', activeShiftId);
            }

            $.ajax({
                url: '<?php echo base_url("CashSafeTransaction/create"); ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    console.log('AJAX response for transaction', currentTransaction.id, ':', response);

                    if (response && typeof response === 'object' && response.success) {
                        processed++;
                        console.log('Successfully processed transaction', currentTransaction.id, 'Total processed:', processed);
                    } else {
                        errors++;
                        console.error('Failed to create cash-out for transaction', currentTransaction.id, response);
                    }
                    processNext();
                },
                error: function(xhr, status, error) {
                    errors++;
                    console.error('Error creating cash-out for transaction', currentTransaction.id, error);
                    processNext();
                }
            });
        }

        // Start processing
        processNext();
    }
});
</script>

<?php include APPPATH . "views/include/footer.php"; ?>