<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include APPPATH . "views/include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow-sm border-bottom">
                <div class="container-fluid py-3 d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">
                        <i class="fa fa-book mr-2 text-primary"></i>Cashier Transaction Ledger
                    </h1>
                    <div>
                        <button type="button" id="syncPaymentsBtn" class="btn btn-sm btn-primary mr-2" <?= (!isset($active_shift_id) || !$active_shift_id) ? 'disabled' : '' ?>>
                            <i class="fas fa-sync-alt"></i> Sync Payments
                        </button>
                        <button type="button" id="toggleTempBtn" class="btn btn-sm btn-secondary" style="display: none;">
                            <i class="fas fa-eye-slash"></i> Hide Temp Documents
                        </button>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt-3">
                <?php if (isset($active_shift_id) && $active_shift_id): ?>
                    <div class="alert alert-info">
                        <strong>Current Shift:</strong> Shift #<?= $active_shift_id ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <strong>No Active Shift:</strong> Please open a cashier shift first.
                    </div>
                <?php endif; ?>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table id="ledgerTable" class="table table-bordered table-striped w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Doc Type</th>
                                    <th>Doc/Receipt No</th>
                                    <th>Transaction Type</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Received At</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                             <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total:</th>
                                    <th></th>
                                    <th class="text-right"></th>
                                    <th colspan="4"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>

<!-- Sync Payments Modal -->
<div class="modal fade" id="syncPaymentsModal" tabindex="-1" role="dialog" aria-labelledby="syncPaymentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="syncPaymentsModalLabel">
                    <i class="fas fa-sync-alt mr-2"></i>Sync Payments
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="syncPaymentsLoading" class="text-center py-4" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Loading unsynced payments...</p>
                </div>
                <div id="syncPaymentsContent">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        This will show approved payments (from both regular and temp tables) that are not yet recorded in the transaction ledger. Each payment method will be shown as a separate entry.
                    </div>
                    <div id="unsyncedPaymentsList" class="table-responsive">
                        <table id="unsyncedPaymentsTable" class="table table-bordered table-striped w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th><input type="checkbox" id="selectAllPayments"></th>
                                    <th>Receipt No</th>
                                    <th>Invoice No</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Payment Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="unsyncedPaymentsTableBody">
                                <tr>
                                    <td colspan="7" class="text-center">Click "Check Unsynced Payments" to load data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" id="checkUnsyncedBtn">
                    <i class="fas fa-search mr-2"></i>Check Unsynced Payments
                </button>
                <button type="button" class="btn btn-primary" id="syncSelectedBtn" style="display: none;">
                    <i class="fas fa-sync-alt mr-2"></i>Sync Selected Payments
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

    var showTempDocuments = false; // Track if temp documents are visible
    const SECRET_CODE = 'boom'; // Secret code to show/hide temp documents
    var secretCodeBuffer = ''; // Buffer to track typed characters
    var lastKeyTime = 0; // Track time between key presses
    const CODE_TIMEOUT = 2000; // Reset buffer after 2 seconds of inactivity

    $(document).ready(function() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Re-initialize tooltips after DataTable is drawn
        $('#ledgerTable').on('draw.dt', function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        
        // Initialize DataTable with server-side processing
        // Automatically filter by current active shift
        initializeLedgerTable();

        // Secret code detection - works anywhere on the page (hidden/background)
        // User can type "boom" anywhere on the page to toggle temp documents
        $(document).on('keypress', function(e) {
            var currentTime = Date.now();
            
            // Reset buffer if too much time passed between keypresses
            if (currentTime - lastKeyTime > CODE_TIMEOUT) {
                secretCodeBuffer = '';
            }
            
            lastKeyTime = currentTime;
            
            // Ignore keypress if user is typing in an input field, textarea, or contenteditable
            var target = $(e.target);
            if (target.is('input, textarea') || target.attr('contenteditable') === 'true') {
                return;
            }
            
            // Append the typed character to buffer (convert to lowercase)
            secretCodeBuffer += String.fromCharCode(e.which).toLowerCase();
            
            // Keep buffer length same as secret code length
            if (secretCodeBuffer.length > SECRET_CODE.length) {
                secretCodeBuffer = secretCodeBuffer.substring(secretCodeBuffer.length - SECRET_CODE.length);
            }
            
            // Check if buffer matches secret code
            if (secretCodeBuffer === SECRET_CODE) {
                // Toggle temp documents visibility
                showTempDocuments = !showTempDocuments;
                
                // Reset buffer
                secretCodeBuffer = '';
                
                if (showTempDocuments) {
                    // Show temp documents
                    $('#toggleTempBtn').show();
                    success_toastify('Temp documents visible');
                } else {
                    // Hide temp documents
                    $('#toggleTempBtn').hide();
                    success_toastify('Temp documents hidden');
                }
                
                // Reload table with new filter
                if ($.fn.DataTable.isDataTable('#ledgerTable')) {
                    $('#ledgerTable').DataTable().ajax.reload();
                } else {
                    initializeLedgerTable();
                }
            }
        });

        // Toggle button handler
        $('#toggleTempBtn').on('click', function() {
            showTempDocuments = false;
            $('#toggleTempBtn').hide();
            success_toastify('Temp documents hidden');
            
            // Reset secret code buffer
            secretCodeBuffer = '';
            
            // Reload table
            if ($.fn.DataTable.isDataTable('#ledgerTable')) {
                $('#ledgerTable').DataTable().ajax.reload();
            } else {
                initializeLedgerTable();
            }
        });

        // Sync Payments button handler
        $('#syncPaymentsBtn').on('click', function() {
            if (!activeShiftId) {
                error_toastify('Please open a cashier shift first');
                return;
            }
            $('#syncPaymentsModal').modal('show');
            // Reset the table
            $('#unsyncedPaymentsTableBody').html('<tr><td colspan="7" class="text-center">Click "Check Unsynced Payments" to load data</td></tr>');
            $('#syncSelectedBtn').hide();
        });

        // Check Unsynced Payments button
        $('#checkUnsyncedBtn').on('click', function() {
            checkUnsyncedPayments();
        });

        // Select All checkbox
        $('#selectAllPayments').on('change', function() {
            $('.payment-checkbox').prop('checked', $(this).prop('checked'));
            updateSyncButtonVisibility();
        });

        // Individual checkbox change
        $(document).on('change', '.payment-checkbox', function() {
            updateSyncButtonVisibility();
            // Update select all checkbox state
            var totalCheckboxes = $('.payment-checkbox').length;
            var checkedCheckboxes = $('.payment-checkbox:checked').length;
            $('#selectAllPayments').prop('checked', totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes);
        });

        // Sync Selected Payments button
        $('#syncSelectedBtn').on('click', function() {
            syncSelectedPayments();
        });
    });

    function initializeLedgerTable() {
        if ($.fn.DataTable.isDataTable('#ledgerTable')) {
            $('#ledgerTable').DataTable().destroy();
        }

        // If no active shift, show empty table
        if (!activeShiftId) {
            $('#ledgerTable').DataTable({
                data: [],
                columns: [
                    { data: 'code', title: 'Code', className: 'text-center' },
                    { data: 'doc_type', title: 'Doc Type' },
                    { data: 'receipt_number', title: 'Doc/Receipt No' },
                    { data: 'transaction_type', title: 'Transaction Type' },
                    { data: 'payment_method', title: 'Payment Method' },
                    { data: 'amount', title: 'Amount' },
                    { data: 'received_at', title: 'Received At' },
                    { data: 'status', title: 'Status' },
                    { data: 'remarks', title: 'Remarks' }
                ]
            });
            return;
        }

        $('#ledgerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url("Cashier/TransactionLedger/datatable") ?>',
                type: 'POST',
                data: function(d) {
                    // Always filter by current active shift
                    d.shift_id = activeShiftId;
                    // Include temp documents only if secret code was entered
                    d.include_temp = showTempDocuments ? 1 : 0;
                },
                error: function(xhr, error, code) {
                    console.error('DataTable error:', error, code);
                    error_toastify('Failed to load transaction ledger. Please try again.');
                }
            },
            order: [[6, 'desc']],
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
            columns: [
                { 
                    data: 'code', 
                    title: 'Code', 
                    className: 'text-center' 
                },
                { 
                    data: 'doc_type', 
                    title: 'Doc Type', 
                    className: 'text-center text-capitalize' 
                },
                { 
                    data: 'receipt_number', 
                    title: 'Doc/Receipt No', 
                    className: 'text-center',
                    defaultContent: '-'
                },
                { 
                    data: 'transaction_type', 
                    title: 'Transaction Type', 
                    className: 'text-center text-capitalize' 
                },
                { 
                    data: 'payment_method', 
                    title: 'Payment Method', 
                    className: 'text-center text-capitalize' 
                },
                { 
                    data: 'amount', 
                    title: 'Amount', 
                    className: 'text-right',
                    render: function(d) {
                        return Number(d ?? 0).toLocaleString(undefined, { 
                            minimumFractionDigits: 2, 
                            maximumFractionDigits: 2 
                        });
                    }
                },
                { 
                    data: 'received_at', 
                    title: 'Received At', 
                    className: 'text-center',
                    render: function(d) {
                        if (!d) return '-';
                        try {
                            let date = new Date(d);
                            if (isNaN(date.getTime())) {
                                return d;
                            }
                            return date.toLocaleString();
                        } catch(e) {
                            return d;
                        }
                    }
                },
                { 
                    data: 'status', 
                    title: 'Status', 
                    className: 'text-center',
                    render: function(d) {
                        if (d === 'reconciled') 
                            return '<span class="badge badge-success">Reconciled</span>';
                        else if (d === 'excluded') 
                            return '<span class="badge badge-danger">Excluded</span>';
                        else 
                            return '<span class="badge badge-warning">Recorded</span>';
                    }
                },
                { 
                    data: 'remarks', 
                    title: 'Remarks', 
                    defaultContent: '-' 
                },
                { 
                    data: null, 
                    title: 'Actions',
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    render: function(row) {
                        let actions = '';
                        // Show reverse button only for non-reversal transactions that are not excluded
                        if (row.is_reversal == 0 && row.status !== 'excluded' && row.status !== 'reconciled') {
                            actions += `<button class="btn btn-sm btn-warning" onclick="reverseTransaction(${row.id})" title="Reverse Transaction" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-undo"></i>
                            </button>`;
                        }
                        // Show delete button
                        // if (row.is_reversal == 0 && row.status !== 'reconciled') {
                        //     actions += ` <button class="btn btn-sm btn-danger" onclick="deleteTransaction(${row.id})" title="Delete">
                        //         <i class="fas fa-trash"></i>
                        //     </button>`;
                        // }
                        return actions || '-';
                    }
                }
            ],
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();
                // Calculate total from Amount column (column 5, index 5)
                let total = api
                    .column(5, { page: 'current' })
                    .data()
                    .reduce(function(a, b) {
                        // Handle both string and number values, remove commas if present
                        let value = b;
                        if (typeof value === 'string') {
                            // Remove commas and parse
                            value = value.replace(/,/g, '');
                        }
                        return a + parseFloat(value ?? 0);
                    }, 0);
                // Display total in the Amount column footer (column 5)
                $(api.column(5).footer()).html(
                    '<strong>' + total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</strong>'
                );
            }
        });
    }

    function reverseTransaction(id) {
        // Prompt for reversal reason
        let reversalReason = prompt('Please enter the reason for reversing this transaction:');
        
        if (!reversalReason || reversalReason.trim() === '') {
            error_toastify('Reversal reason is required');
            return;
        }

        if (confirm('Are you sure you want to reverse this transaction? This action cannot be undone.')) {
            $.ajax({
                url: `<?= base_url("Cashier/TransactionLedger/reverseTransaction") ?>/${id}`,
                type: 'POST',
                dataType: 'json',
                data: {
                    reversal_reason: reversalReason.trim()
                },
                success: function(res) {
                    if(res.status) {
                        success_toastify(res.message || 'Transaction reversed successfully');
                        // Reload the DataTable
                        if ($.fn.DataTable.isDataTable('#ledgerTable')) {
                            $('#ledgerTable').DataTable().ajax.reload();
                        } else {
                            initializeLedgerTable();
                        }
                    } else {
                        error_toastify(res.message || 'Failed to reverse transaction');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Failed to reverse transaction';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    error_toastify(errorMsg);
                }
            });
        }
    }

    function deleteTransaction(id) {
        if(confirm('Are you sure you want to delete this transaction?')) {
            $.ajax({
                url: `<?= base_url("Cashier/TransactionLedger/getTransactionById") ?>/${id}`,
                type: 'DELETE',
                dataType: 'json',
                success: function(res) {
                    if(res.status) {
                        success_toastify(res.message || 'Transaction deleted successfully');
                        // Reload the DataTable
                        if ($.fn.DataTable.isDataTable('#ledgerTable')) {
                            $('#ledgerTable').DataTable().ajax.reload();
                        } else {
                            initializeLedgerTable();
                        }
                    } else {
                        error_toastify(res.message || 'Failed to delete transaction');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Failed to delete transaction';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    error_toastify(errorMsg);
                }
            });
        }
    }

    function checkUnsyncedPayments() {
        if (!activeShiftId) {
            error_toastify('No active shift found');
            return;
        }

        $('#syncPaymentsLoading').show();
        $('#syncPaymentsContent').hide();
        $('#unsyncedPaymentsTableBody').html('');

        $.ajax({
            url: '<?= base_url("Cashier/TransactionLedger/getUnsyncedPayments") ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                shift_id: activeShiftId
            },
            success: function(res) {
                $('#syncPaymentsLoading').hide();
                $('#syncPaymentsContent').show();

                if (res.status && res.data && res.data.length > 0) {
                    let html = '';
                    res.data.forEach(function(payment) {
                        // Create unique key for this payment method entry
                        let uniqueKey = payment.id + '_' + (payment.payment_method || 'cash');
                        let isTempBadge = payment.is_temp ? '<span class="badge badge-warning ml-1">Temp</span>' : '';
                        
                        html += `
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="payment-checkbox" value="${payment.id}" 
                                           data-receipt-id="${payment.id}" 
                                           data-payment-method="${payment.payment_method || 'cash'}"
                                           data-unique-key="${uniqueKey}">
                                </td>
                                <td class="text-center">${payment.receipt_number || '-'} ${isTempBadge}</td>
                                <td class="text-center">${payment.invoice_number || '-'}</td>
                                <td class="text-center text-capitalize">${payment.payment_method || 'cash'}</td>
                                <td class="text-right">${Number(payment.amount || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                <td class="text-center">${payment.payment_date || '-'}</td>
                                <td class="text-center">
                                    <span class="badge badge-success">Approved</span>
                                </td>
                            </tr>
                        `;
                    });
                    $('#unsyncedPaymentsTableBody').html(html);
                    $('#syncSelectedBtn').show();
                    success_toastify(`Found ${res.data.length} unsynced payment method(s)`);
                } else {
                    $('#unsyncedPaymentsTableBody').html('<tr><td colspan="7" class="text-center text-success">All approved payments are synced!</td></tr>');
                    $('#syncSelectedBtn').hide();
                    success_toastify('All approved payments are already synced');
                }
            },
            error: function(xhr) {
                $('#syncPaymentsLoading').hide();
                $('#syncPaymentsContent').show();
                let errorMsg = 'Failed to load unsynced payments';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                error_toastify(errorMsg);
                $('#unsyncedPaymentsTableBody').html('<tr><td colspan="7" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    }

    function updateSyncButtonVisibility() {
        var checkedCount = $('.payment-checkbox:checked').length;
        if (checkedCount > 0) {
            $('#syncSelectedBtn').show().html(`<i class="fas fa-sync-alt mr-2"></i>Sync Selected Payments (${checkedCount})`);
        } else {
            $('#syncSelectedBtn').hide();
        }
    }

    function syncSelectedPayments() {
        var selectedPayments = [];
        $('.payment-checkbox:checked').each(function() {
            selectedPayments.push($(this).data('receipt-id'));
        });

        if (selectedPayments.length === 0) {
            error_toastify('Please select at least one payment to sync');
            return;
        }

        // Remove duplicates (same receipt_id can appear multiple times for different payment methods)
        selectedPayments = [...new Set(selectedPayments)];

        if (!confirm(`Are you sure you want to sync ${selectedPayments.length} payment(s)? This will create transaction ledger entries for all payment methods in the selected payments.`)) {
            return;
        }

        // Disable button and show loading
        var $syncBtn = $('#syncSelectedBtn');
        var originalHtml = $syncBtn.html();
        $syncBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Syncing...');

        $.ajax({
            url: '<?= base_url("Cashier/TransactionLedger/syncPayments") ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                shift_id: activeShiftId,
                receipt_ids: selectedPayments
            },
            success: function(res) {
                $syncBtn.prop('disabled', false).html(originalHtml);
                
                if (res.status) {
                    success_toastify(res.message || `Successfully synced ${res.synced_count || selectedPayments.length} payment(s)`);
                    
                    // Reload the unsynced payments list
                    checkUnsyncedPayments();
                    
                    // Reload the main ledger table
                    if ($.fn.DataTable.isDataTable('#ledgerTable')) {
                        $('#ledgerTable').DataTable().ajax.reload();
                    } else {
                        initializeLedgerTable();
                    }
                } else {
                    error_toastify(res.message || 'Failed to sync payments');
                }
            },
            error: function(xhr) {
                $syncBtn.prop('disabled', false).html(originalHtml);
                let errorMsg = 'Failed to sync payments';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                error_toastify(errorMsg);
            }
        });
    }
</script>
<?php include APPPATH . "views/include/footer.php"; ?>

