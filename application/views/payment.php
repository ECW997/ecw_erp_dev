<?php 
include "include/v2/header.php";  
include "include/v2/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-gray shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-1">
                        <div class="row d-flex align-items-center">
                            <div class="col-4">
                                <h1 class="page-header-title">Payment</h1>
                            </div>
                            <div class="col-md-8 text-md-end">
                                <button type="button" class="btn btn-warning rounded-2 action-btn px-3 py-2 fs-6"
                                    onclick="window.location.href='<?= base_url('Payment') ?>'">
                                    <i class="fas fa-arrow-left me-1 text-dark"></i>
                                    <i class="fas fa-file-invoice me-1 text-dark"></i>
                                    <span class="text-dark fw-bold">Payment List</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-2">
                <div class="card form-card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-header mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="button" class="btn btn-primary btn-sm rounded-2 action-btn print_receipt <?= isset($payment_main_data['status']) && $payment_main_data['status'] == 'Approved' ? '' : 'd-none' ?>"
                                            onclick="exportPaymentReceipt(<?= isset($payment_main_data['id']) ? $payment_main_data['id'] : 0 ?>)">
                                            <i class="fas fa-cash-register me-1"></i> Print Receipt
                                        </button>
                                        <span class="badge bg-secondary">
                                            Receipt No: 
                                            <?= $is_edit 
                                                ? (!empty($payment_main_data['receipt_number']) 
                                                    ? $payment_main_data['receipt_number'] 
                                                    : ($payment_main_data['draft_receipt_number'] ?? ''))
                                                : strtoupper($draft_receipt_no) ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-section mb-4 p-3 border rounded">
                                    <h6 class="section-title p-2 mb-3 rounded">Payment Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label small fw-bold text-dark">Payment Date</label>
                                                <input type="date" class="form-control form-control-sm input-highlight" 
                                                    name="paymentDate" id="paymentDate"
                                                    value="<?= $is_edit ? $payment_main_data['receipt_date'] ?? date('Y-m-d') : date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label small fw-bold text-dark">Customer <span class="text-danger">*</span></label>
                                                <select class="form-select form-select-sm input-highlight" 
                                                    id="customer" name="customer" onchange="getCustomerJObOrInvoiceDetails();">
                                                    <option value="">Select Customer</option>
                                                    <?php if (!empty($payment_main_data['receipt_cus_id'])): ?>
                                                    <option value="<?= $payment_main_data['receipt_cus_id'] ?>" selected>
                                                        <?= $payment_main_data['customer_name'] ?>
                                                    </option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label small fw-bold text-dark">Payment By</label>
                                                <input type="text" class="form-control form-control-sm input-highlight" 
                                                    name="paymentBy" id="paymentBy"
                                                    value="<?= isset($payment_main_data['customer_name']) ? $payment_main_data['customer_name'] : '' ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label small fw-bold text-dark">Payment Note</label>
                                                <input type="text" class="form-control form-control-sm input-highlight" 
                                                    name="paymentNote" id="paymentNote"
                                                    value="<?= isset($payment_main_data['remarks']) ? $payment_main_data['remarks'] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="payment_record_id" name="payment_record_id"
                                        value="<?= isset($payment_main_data['id']) ? $payment_main_data['id'] : '' ?>">
                                    <input type="hidden" id="status" name="status"
                                        value="<?= isset($payment_main_data['status']) ? $payment_main_data['status'] : '' ?>">
                                </div>
                                <div class="row form-section mb-4 p-3 border rounded <?= isset($payment_main_data['status']) && $payment_main_data['status'] == 'Approved' ? 'd-none' : '' ?>">
                                    <div class="col-6">
                                        <h6 class="section-title p-2 mb-3 rounded">Payment Entry</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label small fw-bold text-dark">Amount <span class="text-danger">*</span></label>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Rs</span>
                                                        <input type="number" step="0.01" class="form-control text-end input-highlight"
                                                            placeholder="0.00" name="paymentAmount" id="paymentAmount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label small fw-bold text-dark">Payment Method <span class="text-danger">*</span></label>
                                                    <select class="form-select form-select-sm input-highlight" name="paymentMethod" id="paymentMethod">
                                                        <option value="">Select Method</option>
                                                        <option value="CASH">Cash</option>
                                                        <option value="BANK_TRANSFER">Bank Transfer</option>
                                                        <option value="CREDIT_CARD">Credit Card</option>
                                                        <option value="CHEQUE">Cheque</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-flex align-items-end">
                                                <button type="button" class="btn btn-primary btn-sm w-100 action-btn" id="addPaymentBtn" onclick="addPayment()">
                                                    <i class="fas fa-plus me-1"></i> Add Payment
                                                </button>
                                            </div>
                                        </div>
                                        <div id="bankTransferDetails" class="row g-3 mt-2 d-none">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label small fw-bold text-dark">Bank Name</label>
                                                    <input type="text" class="form-control form-control-sm input-highlight" name="bank_name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label small fw-bold text-dark">Transaction ID</label>
                                                    <input type="text" class="form-control form-control-sm input-highlight" name="transaction_id">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="chequeDetails" class="row g-3 mt-2 d-none">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label small fw-bold text-dark">Cheque Number</label>
                                                    <input type="text" class="form-control form-control-sm input-highlight" name="cheque_number">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label small fw-bold text-dark">Bank Name</label>
                                                    <input type="text" class="form-control form-control-sm input-highlight" name="cheque_bank">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label small fw-bold text-dark">Cheque Date</label>
                                                    <input type="date" class="form-control form-control-sm input-highlight" name="cheque_date">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label small fw-bold text-dark">Clearance Date</label>
                                                    <input type="date" class="form-control form-control-sm input-highlight" name="cheque_clearance_date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="section-title p-2 mb-3 rounded">Payment Details</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-sm w-100" id="paymentDetailsTable">
                                                <thead>
                                                    <tr class="table-light">
                                                        <th width="20%">Method</th>
                                                        <th width="30%">Details</th>
                                                        <th width="20%" class="text-end">Amount</th>
                                                        <th width="20%" class="text-end">Balance</th>
                                                        <th width="10%" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted py-3">No payments added yet</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-section mb-4 p-3 border rounded <?= isset($payment_main_data['status']) && $payment_main_data['status'] == 'Approved' ? 'd-none' : '' ?>">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label small fw-bold text-dark">Payment Type</label>
                                                <select class="form-select form-select-sm input-highlight" name="PaymentType" id="PaymentType" 
                                                    onchange="getCustomerJObOrInvoiceDetails();">
                                                    <option value="">Select Type</option>
                                                    <option value="JobCard" <?= isset($payment_main_data['payment_type']) && $payment_main_data['payment_type'] === 'JobCard' ? 'selected' : '' ?>>
                                                        Job card Advance
                                                    </option>
                                                    <option value="Invoice" <?= isset($payment_main_data['payment_type']) && $payment_main_data['payment_type'] === 'Invoice' ? 'selected' : '' ?>>
                                                        Invoice Payment
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-section mb-4 p-3 border rounded">
                                    <h6 class="section-title p-2 mb-3 rounded">Customer Outstanding</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered w-100" id="customerOutstandingTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Reference No</th>
                                                    <th>Date</th>
                                                    <th class="text-end">Total</th>
                                                    <th class="text-end">Paid</th>
                                                    <th class="text-end">Balance</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">Select a customer to view outstanding payments</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-section mb-4 p-3 border rounded">
                                    <h6 class="section-title p-2 mb-3 rounded">Allocated Payment Summary</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm w-100" id="allocationSummaryTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Reference ID</th>
                                                    <th>Payment Method</th>
                                                    <th class="text-end">Allocated Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">No allocations yet</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-actions d-flex justify-content-end gap-2 mt-4">
                                    <button type="button" class="btn btn-success btn-sm action-btn" id="confirmPaymentBtn" 
                                        onclick="confirmPayment()"
                                        <?= isset($payment_main_data['status']) && $payment_main_data['status'] == 'Approved' ? 'disabled' : '' ?>>
                                        <i class="fas fa-check-double me-1"></i> Approve Payment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </main>

            <div class="modal fade" id="allocatePaymentModal" tabindex="-1" aria-labelledby="allocatePaymentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Allocate Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="allocatePaymentForm">
                        <div class="mb-3">
                            <label for="paymentMethodDropdown" class="form-label">Select Payment Method</label>
                            <select class="form-select" id="paymentMethodDropdown" required></select>
                        </div>
                        <div class="mb-3">
                            <label for="allocateAmount" class="form-label">Enter Amount</label>
                            <input type="number" class="form-control" id="allocateAmount" step="0.01" min="0" required>
                            <div class="form-text text-muted" id="maxAmountInfo"></div>
                        </div>
                        <input type="hidden" id="targetRowId">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="confirmAllocateBtn">Allocate</button>
                    </div>
                    </div>
                </div>
            </div>

            <div id="loading-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.28); z-index: 9999; display: flex; justify-content: center; align-items: center;">
                <div class="text-center">
                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h4 class="mt-3">Loading Payment Data...</h4>
                </div>
            </div>
        <?php include "include/v2/footerbar.php"; ?>
    </div>
</div>
<?php include "include/v2/footerscripts.php"; ?>
<script>

let company_id = "<?php echo ucfirst($_SESSION['company_id']); ?>";
let branch_id = "<?php echo ucfirst($_SESSION['branch_id']); ?>";
let header_id = 0;
let paymentData = [];

$(document).ready(function () {
    $('#loading-overlay').show();
    let loadingPromises = [];

    header_id = "<?= $payment_main_data['id'] ?? 0 ?>";
    if(header_id != 0){
        loadingPromises.push(
            getCustomerJObOrInvoiceDetails().then(function() {
                return loadPayDetail(header_id);
            })
        );
    }

    Promise.all(loadingPromises)
        .then(function() {
            $('#loading-overlay').fadeOut(300);
        })
        .catch(function(error) {
            console.error("Error loading data:", error);
            $('#loading-overlay').html(`
                <div class="text-center text-danger">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <h4>Error loading data</h4>
                    <p>${error.message || 'Please try again'}</p>
                    <button class="btn btn-primary mt-2" onclick="location.reload()">Reload Page</button>
                </div>
            `);
    });
});

const customer = $('#customer');

customer.select2({
    placeholder: 'Select...',
    width: '100%',
    allowClear: true,
    minimumInputLength: 1, 
    ajax: {
        url: '<?php echo base_url() ?>Payment/getCustomer',
        dataType: 'json',
        delay: 300,
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
                    results: data.data.item,
                    pagination: {
                        more: data.data.item.length > 0
                    }
                }
            } else {
                falseResponse(data);
            }
        }
    }
});

$('#paymentMethod').on('change', function () {
    const method = $(this).val();
    $('#bankTransferDetails, #chequeDetails').addClass('d-none');

    if (method === 'BANK_TRANSFER') {
        $('#bankTransferDetails').removeClass('d-none');
    } else if (method === 'CHEQUE') {
        $('#chequeDetails').removeClass('d-none');
    }
});

function setupAllocationEditHandlers() {
    $('.edit-allocation').off('click');

    $('.edit-allocation').on('click', function () {
        const $row = $(this).closest('tr');

        let allocatedAmount = 0;
        let maxAmount = 0;
        let refId = null;

        if ($row.hasClass('invoice-row') || $row.hasClass('jobcard-row')) {
            allocatedAmount = parseFloat(
                $row.find('.allocated-info').text().replace('Allocated: Rs. ', '')
            );
            const $paymentRow = $row.data('allocatedFrom')?.row;
            maxAmount = parseFloat($paymentRow.find('.pay_balance').text()) + allocatedAmount;
            refId = $row.data('refId');
        } else {
            allocatedAmount = parseFloat(
                $row.find('.allocate_amount').val()
            );
            maxAmount = allocatedAmount; 
            refId = $row.data('refId');
        }

        $('#allocatePaymentModal').modal('show');
        $('#allocatePaymentModal .modal-title').text('Edit Allocation');
        $('#allocateAmount').val(allocatedAmount.toFixed(2));
        $('#maxAmountInfo').text(`Max: Rs. ${maxAmount.toFixed(2)}`);
        $('#allocateAmount').attr('max', maxAmount.toFixed(2));

        $('#allocatePaymentModal').data('editingRow', $row);
        $('#allocatePaymentModal').data('refId', refId);
    });
}

$('#confirmAllocateBtn').on('click', function() {
    const selectedIndex = $('#paymentMethodDropdown').val();
    const allocateAmount = parseFloat($('#allocateAmount').val());
    const isEditing = $('#allocatePaymentModal').data('editingRow');
    
    if (isNaN(allocateAmount) || allocateAmount <= 0) {
        alert("Please enter a valid amount.");
        return;
    }

        if (!selectedIndex) {
            alert("Please select a payment method.");
            return;
        }

        let data = paymentMap[selectedIndex];
        if (!data || allocateAmount > data.amount) {
            alert("Amount exceeds available balance.");
            return;
        }

        selectedTargetRow.data('allocatedFrom', {
            index: selectedIndex,
            amount: allocateAmount
        });

        let $summaryTable = $('#allocationSummaryTable tbody');
        if ($summaryTable.find('tr').length === 1 && $summaryTable.find('td').attr('colspan')) {
            $summaryTable.empty(); 
        }

        let refNo = selectedTargetRow.find('.ref_no').text();
        let refDate = selectedTargetRow.find('td').eq(1).text();
        let refTotal = selectedTargetRow.find('.ref_total').text();
        let refPaid = selectedTargetRow.find('.ref_paid').text();
        let refBalance = selectedTargetRow.find('.ref_balance').text();
        let refId = selectedTargetRow.find('.ref_id').text();
        let selectedOption = $('#paymentMethodDropdown option:selected');
        let fullText = selectedOption.text();   
        let rowId = selectedOption.data('row-id');                    
        let method = selectedOption.data('method');       
        let paymentMethod = fullText.split('-')[0].trim(); 
        let payment_type = $('#PaymentType').val();
        let isDuplicate = false;

        $('#allocationSummaryTable tbody tr').each(function () {
            let existingRefId = $(this).find('.ref_id').text().trim();
            let existingMethod = $(this).find('.payment_method_id').text().trim();
            let existingstatus = $(this).find('.row_status').text().trim();

            if (existingRefId === refId && existingMethod === method && existingstatus == 1) {
                isDuplicate = true;
                return false; 
            }
        });

        if (isDuplicate) {
            alert("This reference and payment method combination is already allocated.");
            return; 
        }


        $summaryTable.append(`
            <tr data-ref-id="${refId}">
                <td class="ref_no">${refNo}</td>
                <td class="">${paymentMethod}</td>
                <td class="text-end"><input type="number" step="0.01" class="form-control text-end allocate_amount" placeholder="0.00" value="${allocateAmount.toFixed(2)}"></td>
                <td class="d-none ref_id">${refId}</td>
                <td class="d-none payment_type">${payment_type}</td>
                <td class="d-none payment_method_id">${method}</td>
                <td class="d-none pay_details_id">${rowId}</td>
            </tr>
        `);

        selectedTargetRow.addClass('table-success');
        $('#allocatePaymentModal').modal('hide');

    createReceipt();
    setupAllocationEditHandlers();
    updateBalances();

    $summaryTable.find('.allocate_amount').off('keydown').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            
            if (!updateBalances()) return false;
            createReceipt();
        }
    });
});

function addPayment() {
    let method = $('#paymentMethod').val();
    let amount = parseFloat($('#paymentAmount').val()) || 0;
    let bankName = $('input[name="bank_name"]').val() || '';
    let transactionId = $('input[name="transaction_id"]').val() || '';
    let chequeNumber = $('input[name="cheque_number"]').val() || '';
    let chequeDate = $('input[name="cheque_date"]').val() || '';
    let clearanceDate = $('input[name="cheque_clearance_date"]').val() || '';
    
    if (!amount || amount <= 0 || !method) {
        alert('Please enter a valid amount and select payment method');
        return;
    }

    paymentData.push({
        method: method,
        pay_amount: parseFloat(amount),
        bank_name: bankName || null,
        transaction_id: transactionId || null,
        cheque_number: chequeNumber || null,
        cheque_date: chequeDate || null,
        clearance_date: clearanceDate || null
    });

    createReceipt();
}

let selectedTargetRow = null;
let paymentMap = {};

$(document).on('click', '.allocate-payment-btn', function () {
    selectedTargetRow = $(this).closest('tr');
    selectedTargetRow.data('allocatedFrom', null);

    $('#paymentMethodDropdown').empty();
    paymentMap = {};

    $('#paymentDetailsTable tbody tr').each(function (index) {
        let methodId = $(this).find('.pay_method_id').text();
        let rowId = $(this).find('.row_id').text();
        let methodText = $(this).find('td:eq(0)').text();
        let availableAmount = parseFloat($(this).find('.pay_balance').text());

        if (methodId && availableAmount > 0) {
             $('#paymentMethodDropdown').append(
                $('<option>', {
                    value: index,
                    text: `${methodText} - Rs. ${availableAmount.toFixed(2)}`
                })
                .attr('data-row-id', rowId)
                .attr('data-method', methodId)
            );
            paymentMap[index] = {
                methodId,
                amount: availableAmount,
                row: $(this)
            };
        }
    });

    $('#allocateAmount').val('');
    $('#maxAmountInfo').text('');
    $('#allocatePaymentModal').modal('show');
});

$('#paymentMethodDropdown').on('change', function () {
    let selectedIndex = $(this).val();
    let data = paymentMap[selectedIndex];

    if (data) {
        $('#allocateAmount').attr('max', data.amount.toFixed(2));
        $('#maxAmountInfo').text(`Max: Rs. ${data.amount.toFixed(2)}`);
    }
});

function getCustomerJObOrInvoiceDetails() {
    return new Promise(function(resolve, reject) {
        const paymentType = $('#PaymentType').val();
        const customerId = $('#customer').val();
        const receipt_status = $('#status').val();

        if (!paymentType || !customerId) {
            reject('Payment type or customer not selected');
            return;
        }

        const url = paymentType == 'JobCard'
            ? '<?php echo base_url(); ?>Payment/getJobCardsByCustomer/' + customerId
            : '<?php echo base_url(); ?>Payment/getOutstandingInvoicesByCustomer/' + customerId;

        $('#customerOutstandingTable tbody').html('<tr><td colspan="6" class="text-center text-muted">Loading...</td></tr>');

        $.getJSON(url)
            .done(function(res) {
                if (res.status && res.data.length > 0) {
                    let rows = '';
                    res.data.forEach(entry => {
                        const isJob = paymentType == 'JobCard';
                        const ref_id = isJob ? entry.jobcard.idtbl_jobcard : entry.invoice.id;
                        const ref = isJob ? entry.jobcard.job_card_number : entry.invoice.invoice_number;
                        const date = isJob ? entry.jobcard.jobcard_date : entry.invoice.invoice_date;
                        const id = isJob ? entry.jobcard.idtbl_jobcard : entry.invoice.id;
                        const advance_paid = parseFloat(isJob ? 0: entry.invoice.inv_advance_total);
                        const total = parseFloat(isJob ? entry.total : entry.total);
                        const paid = parseFloat(isJob ? entry.paid : entry.paid);
                        const bal = parseFloat(isJob ? entry.balance : entry.outstanding);

                        let actionBtn = '';
                        if (bal > 0) {
                            if(receipt_status != 'Approved'){
                                actionBtn = `<button type="button" class="btn btn-sm btn-primary allocate-payment-btn">
                                                <i class="fas fa-money-check-alt"></i>
                                            </button>`;
                            }else{
                                actionBtn = `<span class="badge bg-secondary">Receipt Approved</span>`;
                            }
                        } else {
                            actionBtn = `<span class="badge bg-success">Paid</span>`;
                        }

                        let allocated_details = <?= json_encode($payment_allocation_detail_data ?? []) ?>;

                        if(receipt_status == 'Approved'){
                            const isAllocated = allocated_details.some(item => 
                                item.pay_ref_id == ref_id && item.pay_ref_no == ref
                            );
                            
                            if (!isAllocated) {
                                return; 
                            }
                        }
                        
                        rows += `
                        <tr>
                        <td class="ref_no">${ref}</td>
                        <td>${date}</td>
                        <td class="text-end ref_total">${Number(entry.total || 0).toFixed(2)}</td>
                        <td class="text-end ref_paid_show">${Number(entry.paid || 0).toFixed(2)}</td>
                        <td class="text-end ref_paid d-none">0</td>
                        <td class="text-end ref_advance_paid d-none">${Number(advance_paid || 0).toFixed(2)}</td>
                        <td class="text-end ref_balance">${Number(bal || 0).toFixed(2)}</td>
                        <td class="text-center">${actionBtn}</td>
                        <td class="text-center d-none ref_id">${ref_id}</td>
                        </tr>`;
                    });
                    $('#customerOutstandingTable tbody').html(rows);
                    resolve(); 
                } else {
                    $('#customerOutstandingTable tbody').html('<tr><td colspan="6" class="text-center text-muted">No data found.</td></tr>');
                    resolve(); 
                }
            })
            .fail(function() {
                $('#customerOutstandingTable tbody').html('<tr><td colspan="6" class="text-center text-danger">Error loading data</td></tr>');
                reject('Failed to load data');
            });
    });
}

function createReceipt(){
    let draft_receipt_no = "<?php echo $is_edit? $payment_main_data['draft_receipt_number'] ?? '' : strtoupper($draft_receipt_no);?>";
    let date = $('#paymentDate').val();
    let customer_id = $('#customer').val();
    let payment_by = $('#paymentBy').val();
    let payment_note = $('#paymentNote').val();
    let payment_type = $('#PaymentType').val();

    let allocationData = [];

    $('#allocationSummaryTable tbody tr').each(function () {
        const $row = $(this);

        let refId = $row.data('ref-id')||''; 
        let refNo = $row.find('.ref_no').text().trim()||'';
        let PaymentType = $row.find('.payment_type').text().trim()||'';
        let paymentMethod = $row.find('.payment_method_id').text().trim()||'';
        let pay_details_id = $row.find('.pay_details_id').text().trim()||'';
        let allocateAmount = parseFloat($row.find('.allocate_amount').val()) || 0;
        let row_status = $row.find('.row_status').text().trim()||1;

        allocationData.push({
            ref_id: refId,
            ref_no: refNo,
            payment_method: paymentMethod,
            allocate_amount: allocateAmount,
            Payment_type:PaymentType,
            pay_details_id:pay_details_id,
            status: row_status
        });
    });
    console.log(allocationData);
    
    $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                draft_receipt_no:draft_receipt_no,
                date:date,
                customer_id: customer_id,
                payment_by: payment_by,
                payment_type: payment_type,
                payment_note: payment_note,
                company_id: company_id,
                branch_id: branch_id,
                payment_data:paymentData,
                allocation_data:allocationData
            },
            url: '<?php echo base_url() ?>Payment/createReceipt',
            success: function(result) {
                if (result.status == true) {
                    // success_toastify(result.message);
                    $('#payment_record_id').val(result.pay_header_id);
                    loadPayDetail(result.pay_header_id);
                    console.log(result.pay_header_id,result.message);
                } else {
                    console.log(result.message);
                    // falseResponse(result.message);
                }
            }
    });

    paymentData = [];
    $('#paymentAmount').val('');
    $('#paymentMethod').val('');
    $('#paymentAmount').focus();
    $('input[name="bank_name"], input[name="transaction_id"], input[name="cheque_number"], input[name="cheque_date"], input[name="cheque_clearance_date"]').val('');
}

function loadPayDetail(header_id) {
    if (!header_id) {
        error_toastify("No header ID provided.");
        return;
    }
    
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: '<?php echo base_url() ?>Payment/getPayDetails/'+header_id,
        success: function(result) {
            if (result.status == true) {
                let $tbody = $('#paymentDetailsTable tbody');
                $tbody.empty();
                
                if (result.data.length === 0) {
                    $tbody.html('<tr><td colspan="5" class="text-center text-muted py-3">No payments added yet</td></tr>');
                    loadPayAllocationDetail(header_id);
                } else {
                    let animationPromises = [];
                    
                    result.data.forEach(item => {
                        let methodText = item.pay_method.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        let methodId = item.pay_method || '';
                        let amount = parseFloat(item.amount) || 0;

                        let bankName = item.cheque_bank_name || '';
                        let transactionId = item.cc_last_four_digits || '';
                        let chequeNumber = item.cheque_number || '';
                        let chequeDate = item.cheque_date || '';
                        let clearanceDate = item.cleared_date || '';
                        let rowId = item.id || '';

                        let $newRow = $('<tr>').addClass('new-payment').hide();

                        $newRow.append(
                            $('<td>').text(methodText),
                            $('<td>').text('Payment Received'),
                            $('<td class="text-end pay_amount">').text(amount.toFixed(2)),
                            $('<td class="text-end pay_balance">').text(amount.toFixed(2)),
                            $('<td class="text-end d-none pay_method_id">').text(methodId),
                            $('<td class="text-end d-none pay_bank_name">').text(bankName),
                            $('<td class="text-end d-none pay_transaction_id">').text(transactionId),
                            $('<td class="text-end d-none pay_cheque_number">').text(chequeNumber),
                            $('<td class="text-end d-none pay_cheque_date">').text(chequeDate),
                            $('<td class="text-end d-none pay_clearance_date">').text(clearanceDate),
                            $('<td class="text-end d-none row_id">').text(rowId),
                            $('<td class="text-center">').append(
                                $('<button class="btn btn-sm btn-outline-danger delete-payment" id="'+rowId+'" onclick="deleteRow(this,1)">')
                                    .html('<i class="fas fa-trash"></i>')
                            )
                        );

                        $tbody.append($newRow); 
                        animationPromises.push(new Promise(resolve => {
                            $newRow.fadeIn(300, resolve);
                        }));
                    }); 
                    Promise.all(animationPromises).then(() => {
                        loadPayAllocationDetail(header_id);
                    });
                }
            } else {
                error_toastify(result.message);
            }
        },
        error: function(xhr, status, error) {
            error_toastify("Error loading payment details: " + error);
        }
    });
}

function loadPayAllocationDetail(header_id){
    if (!header_id) {
            error_toastify("No header ID provided.");
            return;
        }
    const receipt_status = $('#status').val();

    $.ajax({
            type: "GET",
            dataType: 'json',
            url: '<?php echo base_url() ?>Payment/getPayAllocationDetails/'+header_id,
            success: function(result) {
                if (result.status == true) {
                	let $tbody = $('#allocationSummaryTable tbody');
                	$tbody.empty();
                	if (result.data.length === 0) {
                		$tbody.html('<tr><td colspan="3" class="text-center text-muted py-3">No payments Allocated yet</td></tr>');
                	} else {
                		let totalAllocated = 0;
                		result.data.forEach(item => {
                			let refId = item.pay_ref_id || 0;
                			let refNo = item.pay_ref_no || 0;
                			let paymentMethod = item.pay_method_label || 0;
                			let allocateAmount = parseFloat(item.allocated_amount) || 0;
                			let payment_type = item.pay_type;
                			let method = item.pay_method || 0;
                			let pay_details_id = item.pay_details_id || 0;
                			let row_id = item.id || 0;
                			let status = item.status || 1;
                            totalAllocated += allocateAmount;

                			let $row = $(`
                                        <tr data-ref-id="${refId}">
                                            <td class="ref_no">${refNo}</td>
                                            <td class="">${paymentMethod}</td>
                                            <td class="text-end">
                                                <input type="number" step="0.01" class="form-control text-end allocate_amount" placeholder="0.00" value="${allocateAmount.toFixed(2)}" ${status != 1 ? 'disabled' : ''}>
                                            </td>
                                            <td class="d-none ref_id">${refId}</td>
                                            <td class="d-none payment_type">${payment_type}</td>
                                            <td class="d-none payment_method_id">${method}</td>
                                            <td class="d-none pay_details_id">${pay_details_id}</td>
                                            <td class="d-none row_id">${row_id}</td>
                                            <td class="d-none row_status">${status}</td>
                                        </tr>
                                    `);

                			$tbody.append($row);

                			$row.find('.allocate_amount').off('keydown').on('keydown', function (e) {
                				if (e.key === 'Enter') {
                					e.preventDefault();
                					if (!updateBalances()) return false;
                					createReceipt();
                				}
                			});

                			$('#customerOutstandingTable tbody tr').each(function () {
                				const $outstand_row = $(this);
                				let outstand_refId = $outstand_row.find('.ref_id').text().trim();

                				if (outstand_refId == refId) {
                					$outstand_row.addClass('table-success');
                				}
                			});
                		});
                		if (receipt_status == 'Approved') {
                			let $totalRow = $(`
                                <tr class="fw-bold table-border-top">
                                    <td colspan="2" class="text-end">Total Paid</td>
                                    <td class="text-end">${totalAllocated.toFixed(2)}</td>
                                </tr>
                            `);
                			$tbody.append($totalRow);
                		}
                		updateBalances();
                	}
                } else {
                	error_toastify(result.message);
                }
            }
    });
}

function deleteRow(button,table) {
    const id = button.id;
    const header_id = $('#payment_record_id').val();
    if (confirm("Are you sure you want to delete this payment?")) {
        $.ajax({
            url: '<?php echo base_url() ?>Payment/deletePayment/'+id+'/'+table,
            method: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.status == true) {
                    success_toastify(result.message);
                    if(header_id != 0){
                        loadPayDetail(header_id); 
                    }
                } else {
                    alert(result.message);
                }
            },
            error: function() {
                 error_toastify('Error deleting payment. Please try again.');
            }
        });
    }
}

function updateBalances() {
    let allocations = [];
    let total_allocated_amount = 0;
    let errorFlag = false;

    $('#allocationSummaryTable tbody tr').each(function () {
        let $row = $(this);
              
        let paymentMethod = $row.find('td').eq(1).text().trim();      
        let allocateAmountText = $row.find('.allocate_amount').val();
        let allocateAmount = parseFloat(allocateAmountText) || 0;
        let refNo = $row.find('td').eq(0).text().trim();    
        let refId = $row.find('.ref_id').text().trim();     
        let payment_type = $row.find('.payment_type').text().trim();     
        let row_status = $row.find('.row_status').text().trim();                   

        total_allocated_amount += allocateAmount;

        allocations.push({
            payment_type:payment_type,
            ref_no: refNo,
            payment_method: paymentMethod,
            allocate_amount: allocateAmount,
            ref_id: refId,
            row_status:row_status
        });

    });
  
    $('#customerOutstandingTable tbody tr').each(function () {
        const $row = $(this);
        const row_ref_id = $row.find('.ref_id').text().trim();
        const matchedAllocations = allocations.filter(a => a.ref_id === row_ref_id);

        if (matchedAllocations.length > 0) {
            const original_ref_total = parseFloat($row.find('.ref_total').text().replace(',', '').trim()) || 0;
            const original_ref_paid = parseFloat($row.find('.ref_paid').text().replace(',', '').trim()) || 0;
            const original_ref_advance_paid = parseFloat($row.find('.ref_advance_paid').text().replace(',', '').trim()) || 0;
            let totalAllocated = matchedAllocations.reduce((sum, a) => sum + parseFloat(a.allocate_amount), 0);
            totalAllocated += original_ref_advance_paid;
            const new_balance = Math.max(0, original_ref_total - totalAllocated);

            $row.find('.ref_paid').text(totalAllocated.toFixed(2));
            $row.find('.ref_balance').text(new_balance.toFixed(2));
            $row.find('.ref_paid_show').text(totalAllocated.toFixed(2));

        }
    });

     $('#paymentDetailsTable tbody tr').each(function () {
        const $row = $(this);
        const methodName = $row.find('td:eq(0)').text().trim(); 
        let originalAmount = parseFloat($row.find('.pay_amount').text().replace(',', '').trim());
        let newBalance = originalAmount;
        allocations.forEach(allocation => {
            if (allocation.payment_method === methodName && allocation.row_status == 1) {
                if(allocation.allocate_amount > newBalance){
                    alert("Allocation amount exceeds available balance for " + methodName);
                    errorFlag = true;
                    return;
                }
                newBalance -= allocation.allocate_amount;
            }
        });

        $row.find('.pay_balance').text(newBalance.toFixed(2));
    });

    if (errorFlag) {
        return false; 
    }

    return true;
}

function confirmPayment() {
    const btn = document.getElementById('confirmPaymentBtn');
    let pay_header_id = $('#payment_record_id').val();
    if (pay_header_id !='') {
        btn.disabled = true;
        btn.innerHTML = `Approving <span class="spinner-border spinner-border-sm ml-2" role="status" aria-hidden="true"></span>`;
    }else{
        error_toastify('Please allocate payments first.');
        return false;
    }

    if (confirm("Are you sure you want to Approve this payment?")) {
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                recordID:pay_header_id,
            },
            url: '<?php echo base_url() ?>Payment/verifyPayment',
            success: function(result) {
                if (result.status == true) {
                    success_toastify(result.message);
                    btn.disabled = false;
                    btn.innerHTML = `<i class="fas fa-check-double me-1"></i> Approve Payment`;
                    setTimeout(function() {
                        window.location.href = '<?= base_url("Payment/paymentDetailIndex/") ?>' + pay_header_id;
                    }, 500)
                } else {
                    error_toastify(result.message);
                    btn.disabled = false;
                    btn.innerHTML = `<i class="fas fa-check-double me-1"></i> Approve Payment`;
                }
            }
        });
    }else{
        btn.disabled = false;
        btn.innerHTML = `<i class="fas fa-check-double me-1"></i> Approve Payment`;
    }
}

function exportPaymentReceipt(receipt_id) {
    const baseUrl = "<?php echo base_url(); ?>Payment/paymentReceiptPDF";
    const url = `${baseUrl}?receipt_id=${encodeURIComponent(receipt_id)}`;
    window.open(url, '_blank');
}

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to active this?");
}

function delete_confirm() {
    return confirm("Are you sure you want to remove this?");
}

// Initialize edit handlers when page loads
$(document).ready(function() {
    setupAllocationEditHandlers();
});
</script>
<?php include "include/footer.php"; ?>