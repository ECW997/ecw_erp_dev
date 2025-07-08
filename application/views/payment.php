<?php 
include "include/v2/header.php";  

include "include/v2/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/v2/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa fa-cash-register" aria-hidden="true"></i></div>
                            <span>Payments</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                    	<div class="row">
                    		<div class="col-12">
                    			<div class="payment-type-selection mb-4 p-3 border rounded">
                    				<h6 class="section-title p-2 mb-3 rounded">Select Payment Type</h6>
                    				<div class="d-flex flex-wrap gap-2">
                    					<button type="button" class="btn btn-outline-primary payment-type-btn active"
                    						data-type="advanced">
                    						<i class="fas fa-tools me-2"></i> Advanced Payment (Job Card)
                    					</button>
                    					<button type="button" class="btn btn-outline-primary payment-type-btn"
                    						data-type="direct">
                    						<i class="fas fa-hand-holding-usd me-2"></i> Direct Payment
                    					</button>
                    					<button type="button" class="btn btn-outline-primary payment-type-btn"
                    						data-type="invoice">
                    						<i class="fas fa-file-invoice-dollar me-2"></i> Invoice Payment
                    					</button>
                    				</div>
                    			</div>

                    			<div class="payment-content">
                    				<div class="payment-section" id="advanced-payment-section">
                    					<div class="row g-4">
                    						<div class="col-md-6">
                    							<div class="job-card-details p-3 border rounded h-100">
                    								<h6 class="section-title p-2 mb-3 rounded">Job Card Details</h6>
                    								<div class="form-group mb-3">
                    									<label class="form-label small fw-bold text-dark">Select Job
                    										Card</label>
                    									<select
                    										class="form-select form-select-sm job-card-select input-highlight">
                    										<option value="">Select Job Card</option>
                    										<option value="JC-1001">JC-1001 - Toyota Corolla - Engine
                    											Repair</option>
                    										<option value="JC-1002">JC-1002 - Honda Civic - Brake
                    											Service</option>
                    										<option value="JC-1003">JC-1003 - Nissan Sunny - AC Repair
                    										</option>
                    									</select>
                    								</div>
                    								<div class="job-card-info">
                    									<div class="alert alert-info py-2 mb-0">
                    										<small>Select a job card to view details</small>
                    									</div>
                    								</div>
                    							</div>
                    						</div>

                    						<!-- Customer & Payment Info -->
                    						<div class="col-md-6">
                    							<div class="customer-payment-info p-3 border rounded h-100">
                    								<h6 class="section-title p-2 mb-3 rounded">Customer & Payment</h6>
                    								<div class="customer-details mb-4">
                    									<div class="d-flex align-items-center mb-2">
                    										<i class="fas fa-user me-2 text-muted"></i>
                    										<span class="customer-name small text-dark">No customer
                    											selected</span>
                    									</div>
                    									<div class="d-flex align-items-center mb-2">
                    										<i class="fas fa-phone me-2 text-muted"></i>
                    										<span class="customer-phone small text-dark">-</span>
                    									</div>
                    									<div class="d-flex align-items-center">
                    										<i class="fas fa-car me-2 text-muted"></i>
                    										<span class="customer-vehicle small text-dark">-</span>
                    									</div>
                    								</div>

                    								<div class="payment-summary mb-3 p-2 bg-light rounded">
                    									<div class="d-flex justify-content-between mb-2">
                    										<span class="small text-muted">Job Card Total:</span>
                    										<span class="fw-bold job-total text-dark">Rs. 0.00</span>
                    									</div>
                    									<div class="d-flex justify-content-between mb-2">
                    										<span class="small text-muted">Paid Amount:</span>
                    										<span class="fw-bold text-success paid-amount">Rs.
                    											0.00</span>
                    									</div>
                    									<div class="d-flex justify-content-between">
                    										<span class="small text-muted">Balance:</span>
                    										<span class="fw-bold text-danger balance-amount">Rs.
                    											0.00</span>
                    									</div>
                    								</div>

                    								<div class="form-group">
                    									<label class="form-label small fw-bold text-dark">Payment
                    										Amount</label>
                    									<div class="input-group input-group-sm">
                    										<span class="input-group-text">Rs.</span>
                    										<input type="number"
                    											class="form-control form-control-sm payment-amount input-highlight"
                    											placeholder="0.00" min="0" step="0.01">
                    									</div>
                    								</div>
                    							</div>
                    						</div>
                    					</div>
                    				</div>

                    				<div class="payment-section d-none" id="direct-payment-section">
                    					<div class="row g-4">
                    						<div class="col-md-6">
                    							<div class="direct-payment-details p-3 border rounded h-100">
                    								<h6 class="section-title p-2 mb-3 rounded">Direct Payment Details
                    								</h6>
                    								<div class="form-group mb-3">
                    									<label class="form-label small fw-bold text-dark">Customer
                    										(Optional)</label>
                    									<select
                    										class="form-select form-select-sm customer-select input-highlight">
                    										<option value="">Select Customer (Optional)</option>
                    										<option value="1">John Doe (+94 76 123 4567)</option>
                    										<option value="2">Jane Smith (+94 77 987 6543)</option>
                    										<option value="3">Robert Johnson (+94 71 555 1234)</option>
                    									</select>
                    								</div>
                    								<div class="form-group mb-3">
                    									<label class="form-label small fw-bold text-dark">Payment
                    										Amount</label>
                    									<div class="input-group input-group-sm">
                    										<span class="input-group-text">Rs.</span>
                    										<input type="number"
                    											class="form-control form-control-sm direct-amount input-highlight"
                    											placeholder="0.00" min="0" step="0.01">
                    									</div>
                    								</div>
                    								<div class="form-group">
                    									<label class="form-label small fw-bold text-dark">Payment
                    										Purpose</label>
                    									<input type="text"
                    										class="form-control form-control-sm payment-purpose input-highlight"
                    										placeholder="Service payment, Advance, etc.">
                    								</div>
                    							</div>
                    						</div>
                    						<div class="col-md-6">
                    							<div class="direct-payment-summary p-3 border rounded h-100">
                    								<h6 class="section-title p-2 mb-3 rounded">Payment Summary</h6>
                    								<div class="alert alert-warning py-2 mb-3">
                    									<small><i class="fas fa-exclamation-circle me-2"></i> Direct
                    										payments are not linked to any job card or invoice.</small>
                    								</div>
                    								<div class="payment-preview p-2 bg-light rounded">
                    									<div class="d-flex justify-content-between mb-2">
                    										<span class="small text-muted">Payment Type:</span>
                    										<span class="fw-bold text-dark">Direct Payment</span>
                    									</div>
                    									<div class="d-flex justify-content-between mb-2">
                    										<span class="small text-muted">Amount:</span>
                    										<span class="fw-bold direct-preview-amount text-dark">Rs.
                    											0.00</span>
                    									</div>
                    									<div class="d-flex justify-content-between">
                    										<span class="small text-muted">Customer:</span>
                    										<span class="fw-bold direct-preview-customer text-dark">Not
                    											specified</span>
                    									</div>
                    								</div>
                    							</div>
                    						</div>
                    					</div>
                    				</div>

                                    <div class="payment-section d-none" id="invoice-payment-section">
                                    	<div class="invoice-details-section p-3 border rounded h-100">
                                    		<h6 class="section-title p-2 mb-3 rounded">Invoice Details</h6>
                                    		<div class="row">
                                    			<div class="col-3 mb-3">
                                    				<label class="form-label small fw-bold text-dark">Select Customer</label>
                                    				<select
                                    					class="form-select form-select-sm invoice-select input-highlight"
                                    					onchange="getCustomerDetails(this.value);" id="inv_customer"
                                    					name="inv_customer">
                                    					<option value="">Select Customer</option>
                                    				</select>
                                    			</div>
                                    			<div class="col-12 mb-3">
                                    				<label class="form-label small fw-bold text-dark">Outstanding Invoices</label>
                                    				<div class="table-responsive">
                                    					<table class="table table-sm table-bordered mb-0"
                                    						id="customerOutstandingTable">
                                    						<thead class="table-light">
                                    							<tr>
                                    								<th>Invoice No</th>
                                    								<th>Invoice Date</th>
                                    								<th>Total</th>
                                    								<th>Paid</th>
                                    								<th>Balance</th>
                                    								<th>Action</th>
                                    							</tr>
                                    						</thead>
                                    						<tbody>
                                    							<tr>
                                    								<td colspan="7" class="text-center text-muted">
                                    									Select a customer to view outstanding invoices
                                    								</td>
                                    							</tr>
                                    						</tbody>
                                    					</table>
                                    				</div>
                                    			</div>
                                    		</div>
                                    	</div>
                                    </div>
                    			</div>

                    			<div class="additional-details-section mt-4 p-3 border rounded">
                    				<h6 class="section-title p-2 mb-3 rounded">Additional Details</h6>
                    				<div class="row g-3">
                    					<div class="col-md-6">
                    						<div class="form-group">
                    							<label class="form-label small fw-bold text-dark">Received By</label>
                    							<select class="form-select form-select-sm received-by input-highlight">
                    								<option value="">Select Staff Member</option>
                    								<option value="1">John Smith</option>
                    								<option value="2">Sarah Johnson</option>
                    								<option value="3">Michael Brown</option>
                    							</select>
                    						</div>
                    					</div>
                    					<div class="col-md-6">
                    						<div class="form-group">
                    							<label class="form-label small fw-bold text-dark">Notes</label>
                    							<textarea
                    								class="form-control form-control-sm payment-notes input-highlight"
                    								rows="3"
                    								placeholder="Any additional notes about this payment..."></textarea>
                    						</div>
                    					</div>
                    				</div>
                    			</div>

                    			<div
                    				class="mt-4 rounded-bottom d-flex justify-content-end align-items-center gap-2 flex-wrap">
                    				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                    					<i class="fas fa-times me-1"></i> Cancel
                    				</button>

                    				<button type="button" class="btn btn-sm btn-primary" id="verifyPaymentBtn">
                    					<i class="fas fa-check-circle me-1"></i> Verify Payment
                    				</button>

                    				<button type="button" class="btn btn-sm btn-success" id="confirmPaymentBtn"
                    					disabled>
                    					<i class="fas fa-check-double me-1"></i> Confirm Payment
                    				</button>
                    			</div>
                    		</div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="allocatePaymentModal" tabindex="-1" aria-labelledby="allocatePaymentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            	<div class="modal-dialog modal-dialog-centered modal-md">
            		<div class="modal-content border-0 shadow-lg">
            			<div class="modal-header bg-primary text-white rounded-top">
            				<h5 class="modal-title text-white" id="allocatePaymentModalLabel">
            					<i class="fas fa-money-check-alt me-2"></i> Allocate Payment to Invoice
            				</h5>
            				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
            					aria-label="Close"></button>
            			</div>
            			<div class="modal-body">
            				<form id="allocatePaymentForm">
            					<div class="mb-3">
            						<label class="form-label fw-bold">Invoice Number</label>
            						<input type="text" class="form-control form-control-sm" id="allocateInvoiceNumber"
            							readonly>
            					</div>
            					<div class="mb-3">
            						<label class="form-label fw-bold">Outstanding Balance</label>
            						<input type="text" class="form-control form-control-sm" id="allocateInvoiceBalance"
            							readonly>
            					</div>
            					<div class="mb-3">
            						<label class="form-label fw-bold">Payment Amount</label>
            						<input type="number" class="form-control form-control-sm" id="allocatePaymentAmount"
            							min="0" step="0.01" placeholder="0.00">
            					</div>
            					<div class="mb-3">
            						<label class="form-label fw-bold">Payment Date</label>
            						<input type="date" class="form-control form-control-sm" id="allocatePaymentDate"
            							value="<?php echo date('Y-m-d'); ?>">
            					</div>
            					<div class="mb-3">
            						<label class="form-label fw-bold">Payment Method</label>
            						<select class="form-select form-select-sm" id="allocatePaymentMethod">
            							<option value="">Select Payment Method</option>
            							<option value="1">Cash</option>
            							<option value="2">Cheque</option>
            							<option value="3">Bank Transfer</option>
            						</select>
            					</div>
            					<div class="mb-3 d-none" id="allocateChequeDetails">
            						<label class="form-label fw-bold">Cheque Number</label>
            						<input type="text" class="form-control form-control-sm mb-2"
            							id="allocateChequeNumber" placeholder="CHQ-123456">
            						<label class="form-label fw-bold">Bank Name</label>
            						<input type="text" class="form-control form-control-sm mb-2" id="allocateChequeBank"
            							placeholder="Bank Name">
            						<label class="form-label fw-bold">Cheque Date</label>
            						<input type="date" class="form-control form-control-sm" id="allocateChequeDate">
            					</div>
            					<div class="mb-3 d-none" id="allocateBankDetails">
            						<label class="form-label fw-bold">Reference Number</label>
            						<input type="text" class="form-control form-control-sm mb-2"
            							id="allocateBankReference" placeholder="TRN-789012">
            						<label class="form-label fw-bold">Bank Name</label>
            						<input type="text" class="form-control form-control-sm mb-2" id="allocateBankName"
            							placeholder="Bank Name">
            						<label class="form-label fw-bold">Transfer Date</label>
            						<input type="date" class="form-control form-control-sm" id="allocateBankDate">
            					</div>
            				</form>
            			</div>
            			<div class="modal-footer bg-light">
            				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            					<i class="fas fa-times me-1"></i> Cancel
            				</button>
            				<button type="button" class="btn btn-primary" id="allocatePaymentSubmitBtn">
            					<i class="fas fa-check me-1"></i> Allocate Payment
            				</button>
            			</div>
            		</div>
            	</div>
            </div>
            </main>

        <?php include "include/v2/footerbar.php"; ?>
    </div>
</div>
<?php include "include/v2/footerscripts.php"; ?>
<script>
var addcheck = '<?php echo $addcheck; ?>';
var editcheck = '<?php echo $editcheck; ?>';
var statuscheck = '<?php echo $statuscheck; ?>';
var deletecheck = '<?php echo $deletecheck; ?>';

$(document).ready(function() {

    $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        "buttons": [{
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                title: 'Job Option Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Job Option Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Job Option Information',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            },
        ],
        ajax: {
            url: apiBaseUrl + '/v1/job_option',
            type: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + api_token
            },
            dataSrc: function(json) {
                if (json.status === false && json.code === 401) {
                    falseResponse(errorObj);
                } else {
                    return json.data;
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) {
                    falseResponse(errorObj);
                }
            }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "idtbl_sub_job_category"
            },
            {
                "data": "sub_job_category"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button +=
                        '<button title="View" class="btn btn-secondary btn-sm btnView mr-1 " onclick="showViewModal(' +
                        full['idtbl_sub_job_category'] +
                        ');"><i class="fas fa-eye"></i></button>';
                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('.payment-type-btn').click(function() {
        $('.payment-type-btn').removeClass('active');
        $(this).addClass('active');
        $('.payment-section').addClass('d-none');
        
        const paymentType = $(this).data('type');
        $(`#${paymentType}-payment-section`).removeClass('d-none');
        
        $('.payment-method').prop('checked', false);
        $('#cashMethod').prop('checked', true);
        $('.payment-method-details').addClass('d-none');
        $('#cashDetails').removeClass('d-none');
        
        $('#confirmPaymentBtn').prop('disabled', true);
    });

    const inv_customer = $('#inv_customer');
    const invoice_s = $('#invoice_s');

    inv_customer.select2({
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

    invoice_s.select2({
            placeholder: 'Select...',
            width: '100%',
            allowClear: true,
            minimumInputLength: 1, 
            ajax: {
                url: '<?php echo base_url() ?>Invoice/getInvoiceNo',
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

    $('.invoice-payment-method').on('change', function () {
    	var method = $(this).val();
    	$('.invoice-method-cash, .invoice-method-cheque, .invoice-method-bank').addClass('d-none');
    	if (method === 'cash') {
    		$('.invoice-method-cash').removeClass('d-none');
    	} else if (method === 'cheque') {
    		$('.invoice-method-cheque').removeClass('d-none');
    	} else if (method === 'bank') {
    		$('.invoice-method-bank').removeClass('d-none');
    	}
    });

    $('.invoice-cash-received, .invoice-amount').on('input', function () {
        var received = parseFloat($('.invoice-cash-received').val()) || 0;
        var amount = parseFloat($('.invoice-amount').val()) || 0;
        var change = received > amount ? (received - amount) : 0;
        $('.invoice-cash-change').text('Rs. ' + change.toFixed(2));
    });

    $(document).on('click', '.allocate-payment-btn', function() {
        const invoiceNumber = $(this).data('invoice-number');
        const balance = $(this).data('balance');
        $('#allocateInvoiceNumber').val(invoiceNumber);
        $('#allocateInvoiceBalance').val((parseFloat(balance).toFixed(2)));
        $('#allocatePaymentAmount').val(balance);
        $('#allocatePaymentMethod').val('');
        $('#allocateChequeDetails, #allocateBankDetails').addClass('d-none');
        $('#allocateChequeNumber, #allocateChequeBank, #allocateChequeDate, #allocateBankReference, #allocateBankName, #allocateBankDate').val('');
        $('#allocatePaymentModal').data('invoice-id', $(this).data('invoice-id'));
    });

    $('#allocatePaymentMethod').on('change', function() {
        const method = $(this).val();
        $('#allocateChequeDetails, #allocateBankDetails').addClass('d-none');
        if (method == '2') {
            $('#allocateChequeDetails').removeClass('d-none');
        } else if (method === '3') {
            $('#allocateBankDetails').removeClass('d-none');
        }
    });

    $('#allocatePaymentSubmitBtn').on('click', function() {
        const date = $('#allocatePaymentDate').val();
        const amount = parseFloat($('#allocatePaymentAmount').val()) || 0;
        const balance = parseFloat($('#allocateInvoiceBalance').val()) || 0;
        const method = $('#allocatePaymentMethod').val();
        const methodText = $('#allocatePaymentMethod option:selected').text(); 
        const invoiceId = $('#allocatePaymentModal').data('invoice-id');
        const invoiceNumber = $('#allocateInvoiceNumber').val();

        if (amount <= 0) {
            alert('Enter a valid payment amount.');
            return;
        }
        if (amount > balance) {
            alert('Payment amount cannot exceed outstanding balance.');
            return;
        }
        if (!method) {
            alert('Select a payment method.');
            return;
        }

         if (!date) {
            alert('Select a payment date.');
            return;
        }

        addAllocatedPayment({
            date: date,
            invoiceId: invoiceId,
            invoiceNumber: invoiceNumber,
            balance: balance,
            amount: amount,
            method: method,
            methodText:methodText
        });

        $('#allocatePaymentModal').modal('hide');
        setTimeout(() => {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

            document.body.classList.remove('modal-open');
            document.body.style.overflow = 'auto';
            document.body.style.paddingRight = '';
        }, 500);
      
    });

    let allocatedPayments = [];
    let verifiedPayments = [];

    function addAllocatedPayment(payment) {
        const idx = allocatedPayments.findIndex(p => p.invoiceId === payment.invoiceId);
        if (idx !== -1) {
            allocatedPayments[idx] = payment;
        } else {
            allocatedPayments.push(payment);
        }
        renderAllocatedPaymentsTable();
    }

    $(document).on('click', '.remove-allocated-payment', function() {
        if (confirm("Are you sure you want to delete this row?")) {
            $(this).closest('tr').remove(); 
        }
    });

    function renderAllocatedPaymentsTable() {
        let pendingHtml = '';
        let verifiedHtml = '';

        // pending payments table
        if (allocatedPayments.length === 0) {
            pendingHtml = '<tr><td colspan="5" class="text-center text-muted">No payments allocated yet.</td></tr>';
        } else {
            allocatedPayments.forEach(function (p) {
                pendingHtml += `<tr>
                    <td>${p.date || '-'}</td>
                    <td>${p.invoiceNumber}</td>
                    <td>${p.methodText}</td>
                    <td class="text-end">
                        <input type="number" 
                            class="form-control form-control-sm allocated-amount-input" 
                            data-date="${p.date}" 
                            data-invoice-id="${p.invoiceId}" 
                            data-payment-option="${p.method || 0}" 
                            data-balance="${p.balance}" 
                            value="${p.amount}" 
                            min="0" 
                            max="${p.balance}" 
                            step="0.01" 
                            style="width:100px;">
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" title="Verify Payment" class="btn btn-success" data-invoice-id="${p.invoiceId}" onclick="verifyRow(this)">
                                <i class="fas fa-check-circle"></i>
                            </button>
                            <button type="button" title="Delete Payment" class="btn btn-danger" data-invoice-id="${p.invoiceId}" onclick="deleteRow(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;
            });
        }

        // successful payments table 
        if (verifiedPayments.length === 0) {
            verifiedHtml = '<tr><td colspan="6" class="text-center text-muted">No successful payments yet.</td></tr>';
        } else {
            verifiedPayments.forEach(function (p) {
                verifiedHtml += `<tr>
                    <td>${p.date || '-'}</td>
                    <td>${p.invoiceNumber}</td>
                    <td>${p.methodText}</td>
                    <td>-</td> <!-- You can add cheque/bank details here if needed -->
                    <td class="text-end">Rs. ${parseFloat(p.amount || 0).toFixed(2)}</td>
                    <td class="text-center">
                        <button type="button" title="Delete Payment" class="btn btn-danger btn-sm" data-invoice-id="${p.invoiceId}" onclick="deleteRow(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
            });
        }

        // entire layout
        if ($('#allocatedPaymentsWrapper').length === 0) {
            $('#customerOutstandingTable').parent().after(`
                <div class="row mt-3" id="allocatedPaymentsWrapper">
                    <!-- Allocated Payments Table -->
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-dark">Allocated Pending Payments</label>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0" id="allocatedPaymentsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Invoice No</th>
                                        <th>Method</th>
                                        <th>Allocated Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>${pendingHtml}</tbody>
                            </table>
                            <div class="mt-2" id="allocatedTotals"></div>
                        </div>
                    </div>

                    <!-- Successful Payments Table -->
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-success">Successful Payments</label>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0" id="successfulPaymentsTable">
                                <thead class="table-success">
                                    <tr>
                                        <th>Date</th>
                                        <th>Invoice No</th>
                                        <th>Method</th>
                                        <th>Details</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="successfulPaymentsBody">${verifiedHtml}</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `);
        } else {
            // Only update rows if wrapper exists
            $('#allocatedPaymentsTable tbody').html(pendingHtml);
            $('#successfulPaymentsTable tbody').html(verifiedHtml);
        }
    }


    $(document).off('keydown', '.allocated-amount-input').on('keydown', '.allocated-amount-input', function (e) {
        if (e.key === 'Enter') {
            insertPayment();
        }
    });

    $(document).off('click', '.invoice-row').on('click', '.invoice-row', function () {
        const invoiceId = $(this).data('invoice-id');
        
        $('.invoice-row').removeClass('table-active');
        $(this).addClass('table-active');
        
        $.ajax({
            url: 'Payment/getAllocatedPayments'+ '/' + invoiceId, 
            method: 'GET',
            dataType: 'json',
            success: function (res) {     
                 if (res.status) {
                    const invoice_number = res.data.invoice_number;
                    const rawPendingPayments = res.data.pending_payments;
                    const rawVerifyPayments = res.data.verify_payments;
                    const paidTotal = res.data.paid_total;
                    const balance = res.data.balance;
                    const total = res.data.total;

                    allocatedPayments = rawPendingPayments.map(p => {
                        const method = p.payment_option || 0;
                        methodText='';
                        if(method == 1) {
                            methodText = 'Cash';
                        } else if(method == 2) {
                            methodText = 'Cheque';
                        } else if(method == 3) {
                            methodText = 'Bank Transfer';
                        } else {
                            methodText = 'Unknown';
                        }

                        return {
                            date: p.created_at || '-',
                            invoiceId: invoiceId,
                            invoiceNumber: invoice_number || '-',  
                            balance: parseFloat(balance || 0),
                            amount: parseFloat(p.payment || 0),
                            method: method,
                            methodText: methodText 
                        };
                    });

                    verifiedPayments = rawVerifyPayments.map(p => {
                        const method = p.payment_option || 0;
                        methodText='';
                        if(method == 1) {
                            methodText = 'Cash';
                        } else if(method == 2) {
                            methodText = 'Cheque';
                        } else if(method == 3) {
                            methodText = 'Bank Transfer';
                        } else {
                            methodText = 'Unknown';
                        }

                        return {
                            date: p.created_at || '-',
                            invoiceId: invoiceId,
                            invoiceNumber: invoice_number || '-',  
                            balance: parseFloat(balance || 0),
                            amount: parseFloat(p.payment || 0),
                            method: method,
                            payment_type: p.payment_type || 0,
                            methodText: methodText 
                        };
                    });

                    renderAllocatedPaymentsTable();
                } else {
                    allocatedPayments = [];
                    verifiedPayments = [];
                    renderAllocatedPaymentsTable(); 
                }
            },
            error: function () {
                alert('Failed to load allocated payments.');
            }
        });
    });
});

function getCustomerDetails(customerId) {
    if (!customerId) {
        $('#customerOutstandingTable tbody').html('<tr><td colspan="7" class="text-center text-muted">Select a customer to view outstanding invoices</td></tr>');
        return;
    }
    $('#customerOutstandingTable tbody').html('<tr><td colspan="7" class="text-center text-muted">Loading...</td></tr>');
    $.ajax({
        url: '<?php echo base_url(); ?>Payment/getOutstandingInvoicesByCustomer/' + customerId,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res && res.status && Array.isArray(res.data) && res.data.length > 0) {
                let rows = '';
                res.data.forEach(function(inv) {
                    let status = parseFloat(inv.outstanding) > 0 ? '<span class="badge bg-danger">Pending</span>' : '<span class="badge bg-success">Paid</span>';
                    let payBtn = '';
                    if (parseFloat(inv.outstanding) > 0) {
                        payBtn = `<button type="button" class="btn btn-sm btn-primary allocate-payment-btn" 
                            data-invoice-id="${inv.invoice.id}" 
                            data-invoice-number="${inv.invoice.invoice_number}" 
                            data-balance="${inv.outstanding}"
                            title="Allocate Payment" data-bs-toggle="modal" data-bs-target="#allocatePaymentModal">
                            <i class="fas fa-money-check-alt"></i>
                        </button>`;
                    }
                    rows += `<tr class="invoice-row ${inv.payment_status == 0 ? 'bg-warning' : ''}" data-invoice-id="${inv.invoice.id}" style="cursor: pointer;">
                        <td>${inv.invoice.invoice_number || '-'}</td>
                        <td>${inv.invoice.invoice_date || '-'}</td>
                        <td>Rs. ${addCommas((parseFloat(inv.total) || 0).toFixed(2))}</td>
                        <td>Rs. ${addCommas((parseFloat(inv.paid) || 0).toFixed(2))}</td>
                        <td>Rs. ${addCommas((parseFloat(inv.outstanding) || 0).toFixed(2))}</td>
                        <td>${payBtn}</td>
                    </tr>`;
                });
                $('#customerOutstandingTable tbody').html(rows);
            } else {
                $('#customerOutstandingTable tbody').html('<tr><td colspan="7" class="text-center text-muted">No outstanding invoices found for this customer.</td></tr>');
            }
        },
        error: function() {
            $('#customerOutstandingTable tbody').html('<tr><td colspan="7" class="text-center text-danger">Error loading outstanding invoices.</td></tr>');
        }
    });
}

function getInvoiceDetails(invoice_id){
  $.ajax({
    type: "GET",
    url: '<?php echo base_url() ?>Invoice/getInvoiceDetails/' + invoice_id,
    dataType: "json",
    success: function(result) {
      if (result && result.status && result.data && result.data.main_data.length > 0) {
        const data = result.data;
        const mainData = data.main_data[0];
        const payments = data.invoice_payment_details;

        const grandTotal = parseFloat(mainData['inv_grand_total']) || 0;
        let totalPaid = 0;
        payments.forEach(function(payment) {
          totalPaid += parseFloat(payment.payment) || 0;
        });
        const balance = grandTotal - totalPaid;

        $('.invoice-total').text('Rs. ' + addCommas(grandTotal.toFixed(2)));
        $('#hide_invoice-total').val(grandTotal.toFixed(2));
        $('.invoice-paid').text('Rs. ' + addCommas(totalPaid.toFixed(2)));
        $('#hide_invoice-paid').val(totalPaid.toFixed(2));
        $('.invoice-balance').text('Rs. ' + addCommas(balance.toFixed(2)));
        $('#hide_invoice-balance').val(balance.toFixed(2));

        $('.invoice-amount').val(balance.toFixed(2)).trigger('input');

        $('.invoice-details').html(`
          <div class="d-flex justify-content-between mb-2">
            <span class="small text-muted">Customer:</span>
            <span class="small fw-bold">${mainData['customer_name'] || '-'}</span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span class="small text-muted">Date:</span>
            <span class="small fw-bold">${mainData['inv_date'] || '-'}</span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span class="small text-muted">Due Date:</span>
            <span class="small fw-bold">${mainData['inv_due_date'] || '-'}</span>
          </div>
          <div class="d-flex justify-content-between">
            <span class="small text-muted">Status:</span>
            <span class="badge ${balance > 0 ? 'bg-danger' : 'bg-success'} rounded-pill small">
              ${balance > 0 ? 'Pending' : 'Paid'}
            </span>
          </div>
        `);
      } else {
        $('.invoice-details').html(`
          <div class="alert alert-danger py-2 mb-0">
            <small>Failed to fetch invoice data</small>
          </div>
        `);
        $('.invoice-total, .invoice-paid, .invoice-balance, .new-balance').text('Rs. 0.00');
        $('.invoice-amount').val('');
      }
    },
    error: function() {
      $('.invoice-details').html(`
        <div class="alert alert-danger py-2 mb-0">
          <small>Error loading invoice details</small>
        </div>
      `);
      $('.invoice-total, .invoice-paid, .invoice-balance, .new-balance').text('Rs. 0.00');
      $('.invoice-amount').val('');
    }
  });
}

function insertPayment() {
  $('#allocatedPaymentsTable .allocated-amount-input').each(function () {
        const customerId = $('#inv_customer').val();
        const amount = parseFloat($(this).val()) || 0;
        const max = parseFloat($(this).data('balance')) || 0;
        const invoiceId = $(this).data('invoice-id');
        const paymentOption = $(this).data('payment-option') || 1;
        const date = $(this).data('date');

        if (isNaN(amount) || amount < 0) {
            alert(`Invalid amount for Invoice ${invoiceId}. Must be a positive number.`);
            return;
        }

        if (amount > max) {
            alert(`Amount exceeds balance for Invoice ${invoiceId}. Max allowed is ${max.toFixed(2)}.`);
            return;
        }

        $.ajax({
            url: '<?php echo base_url() ?>Payment/insertORUpdatePayment', 
            method: 'POST',
            dataType: 'json',
            data: {
                date:date,
                invoice_id: invoiceId,
                payment_option: paymentOption,
                payment: amount
            },
            success: function(result) {
                if (result.status == true) {
                    getCustomerDetails(customerId);
                    console.log(result.message,customerId);
                } else {
                    console.log(result.message);
                }
            },
            error: function () {
                alert(`Error while saving payment for invoice ${invoiceId}`);
            }
        });
    });
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
</script>
<?php include "include/footer.php"; ?>

