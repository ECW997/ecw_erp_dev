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
                                        <div class="job-card-details p-3 border rounded h-100">
                                            <h6 class="section-title p-2 mb-3 rounded">Job Card Details</h6>
                                            <div class="row">
                                    			<div class="col-3 mb-3">
                                    				<label class="form-label small fw-bold text-dark">Select Customer</label>
                                    				<select
                                    					class="form-select form-select-sm invoice-select input-highlight"
                                    					onchange="getCustomerJobCardDetails(this.value);" id="job_customer"
                                    					name="job_customer">
                                    					<option value="">Select Customer</option>
                                    				</select>
                                    			</div>
                                    			<div class="col-12 mb-3">
                                    				<label class="form-label small fw-bold text-dark">Job Cards</label>
                                    				<div class="table-responsive">
                                    					<table class="table table-sm table-bordered mb-0"
                                    						id="customerJobCardTable">
                                    						<thead class="table-light">
                                    							<tr>
                                    								<th>Job Card No</th>
                                    								<th>Job Card Date</th>
                                    								<th class="text-end">Total</th>
                                    								<th class="text-end">Paid</th>
                                    								<th class="text-end">Balance</th>
                                    								<th class="text-center">Action</th>
                                    							</tr>
                                    						</thead>
                                    						<tbody>
                                    							<tr>
                                    								<td colspan="7" class="text-center text-muted">
                                    									Select a customer to view Job Cards
                                    								</td>
                                    							</tr>
                                    						</tbody>
                                    					</table>
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
                                    				<label class="form-label small fw-bold text-dark">Invoices</label>
                                    				<div class="table-responsive">
                                    					<table class="table table-sm table-bordered mb-0"
                                    						id="customerOutstandingTable">
                                    						<thead class="table-light">
                                    							<tr>
                                    								<th>Invoice No</th>
                                    								<th>Invoice Date</th>
                                    								<th class="text-end">Total</th>
                                    								<th class="text-end">Paid</th>
                                    								<th class="text-end">Balance</th>
                                    								<th class="text-center">Action</th>
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
                                    <div class="row mb-2 d-none" id="invoice_no_row">
                                        <div class="col-3">
                                            <label class="form-label small fw-bold text-dark">Invoice No</label>
                                            <span id="selected_invoice_no" class="fw-bold text-success">Not Applicable</span>
                                            <input type="hidden" id="selected_invoice_id" value="">
                                        </div>
                                    </div>
                                    <div class="row mb-2 d-none" id="jobcard_no_row">
                                        <div class="col-3">
                                            <label class="form-label small fw-bold text-dark">Job Card No</label>
                                            <span id="selected_jobcard_no" class="fw-bold text-success">Not Applicable</span>
                                            <input type="hidden" id="selected_jobcard_id" value="">
                                        </div>
                                    </div>
                    				<div class="row g-3">
                                        <div class="col-md-3">
                    						<div class="form-group">
                    							<label class="form-label small fw-bold text-dark">Date</label>
                    							<input type="date" class="form-control form-control-sm received-by input-highlight"
                    								id="confirm_date" name="confirm_date" value="<?php echo date('Y-m-d'); ?>">
                    						</div>
                    					</div>
                    					<div class="col-md-3">
                    						<div class="form-group">
                    							<label class="form-label small fw-bold text-dark">Received By</label>
                    							<select class="form-select form-select-sm received-by input-highlight" id="cashier" name="cashier">
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
                    								placeholder="Any additional notes about this payment..." id="notes" name="notes"></textarea>
                    						</div>
                    					</div>
                    				</div>
                    			</div>

                    			<div
                    				class="mt-4 rounded-bottom d-flex justify-content-end align-items-center gap-2 flex-wrap">
                    				<button type="button" class="btn btn-sm btn-success" id="confirmPaymentBtn" onclick="confirmPayment()"
                    					>
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
            					<i class="fas fa-money-check-alt me-2"></i> Allocate Payment
            				</h5>
            				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
            					aria-label="Close"></button>
            			</div>
            			<div class="modal-body">
            				<form id="allocatePaymentForm">
            					<div class="mb-3">
            						<label class="form-label fw-bold" id="documentNumberLabel">Document Number</label>
            						<input type="text" class="form-control form-control-sm" id="allocateDocumentNumber"
            							readonly>
            					</div>
            					<div class="mb-3">
            						<label class="form-label fw-bold">Outstanding Balance</label>
            						<input type="text" class="form-control form-control-sm" id="allocateDocumentBalance"
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
            						<label class="form-label fw-bold">Cheque Date</label>
            						<input type="date" class="form-control form-control-sm" id="allocateChequeDate">
            					</div>
            					<div class="mb-3 d-none" id="allocateBankDetails">
            						<label class="form-label fw-bold">Reference Number</label>
            						<input type="text" class="form-control form-control-sm mb-2"
            							id="allocateBankReference" placeholder="TRN-789012">
            						<label class="form-label fw-bold">Transfer Date</label>
            						<input type="date" class="form-control form-control-sm" id="allocateBankDate">
            					</div>
            				</form>
            			</div>
            			<div class="modal-footer bg-light">
            				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            					<i class="fas fa-times me-1"></i> Cancel
            				</button>
            				<button type="button" class="btn btn-primary" id="allocatePaymentSubmitBtn" onclick="insertPayment();">
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

let company_id = "<?php echo ucfirst($_SESSION['company_id']); ?>";
let branch_id = "<?php echo ucfirst($_SESSION['branch_id']); ?>";

let allocatedPayments = [];
let verifiedPayments = [];
let MainPaymentType = 'advanced'; // Default payment type
let currentDocumentType = ''; // 'invoice' or 'jobcard'

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

        if (paymentType === 'invoice') {
            $('#invoice_no_row').removeClass('d-none');
            $('#jobcard_no_row').addClass('d-none');
            currentDocumentType = 'invoice';
        } else if (paymentType === 'advanced') {
            $('#jobcard_no_row').removeClass('d-none');
            $('#invoice_no_row').addClass('d-none');
            currentDocumentType = 'jobcard';
        } else {
            $('#invoice_no_row').addClass('d-none');
            $('#jobcard_no_row').addClass('d-none');
            currentDocumentType = '';
        }

        $('#cashMethod').prop('checked', true);
        $('.payment-method-details').addClass('d-none');
        $('#cashDetails').removeClass('d-none');
        
        MainPaymentType = paymentType; 
    });

    const inv_customer = $('#inv_customer');
    const job_customer = $('#job_customer');

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

    job_customer.select2({
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

    $('#allocatePaymentMethod').on('change', function() {
        const method = $(this).val();
        $('#allocateChequeDetails, #allocateBankDetails').addClass('d-none');
        if (method == '2') {
            $('#allocateChequeDetails').removeClass('d-none');
        } else if (method === '3') {
            $('#allocateBankDetails').removeClass('d-none');
        }
    });

});

function getCustomerJobCardDetails(customerId) {
    if (!customerId) {
        $('#customerJobCardTable tbody').html('<tr><td colspan="7" class="text-center text-muted">Select a customer to view job cards</td></tr>');
        return;
    }
    $('#customerJobCardTable tbody').html('<tr><td colspan="7" class="text-center text-muted">Loading...</td></tr>');
    $.ajax({
        url: '<?php echo base_url(); ?>Payment/getJobCardsByCustomer/' + customerId,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res && res.status && Array.isArray(res.data) && res.data.length > 0) {
                let rows = '';
                res.data.forEach(function(jbc) {
                    let status = parseFloat(jbc.balance) > 0 ? '<span class="badge bg-danger">Pending</span>' : '<span class="badge bg-success">Paid</span>';
                    let payBtn = '';
                    if (parseFloat(jbc.balance) > 0) {
                        payBtn = `<button type="button" class="btn btn-sm btn-primary allocate-payment-btn" 
                                    data-jobcard-id="${jbc.jobcard.idtbl_jobcard}" 
                                    data-jobcard-number="${jbc.jobcard.job_card_number}" 
                                    data-balance="${jbc.balance}"
                                    title="Allocate Payment" data-bs-toggle="modal" data-bs-target="#allocatePaymentModal">
                                    <i class="fas fa-money-check-alt"></i>
                                </button>`;
                    } else if (parseFloat(jbc.balance) === 0 && !jbc.is_verified) {
                        payBtn = `<span class="badge bg-danger">Verify Pending</span>`;
                    } else if (jbc.is_verified) {
                        payBtn = `<span class="badge bg-success">Paid</span>`;
                    }

                    rows += `<tr 
                                class="jobcard-row ${jbc.is_verified == false ? 'bg-warning' : ''}" 
                                data-jobcard-id="${jbc.jobcard.id}" 
                                style="cursor: pointer;" 
                                onclick="handleJobcardRowClick(this, ${jbc.jobcard.id}, ${customerId})">
                                <td>${jbc.jobcard.job_card_number || '-'}</td>
                                <td>${jbc.jobcard.jobcard_date || '-'}</td>
                                <td class="text-end">${Number(jbc.total || 0).toLocaleString('en-LK', { style: 'currency', currency: 'LKR' })}</td>
                                <td class="text-end">${Number(jbc.paid || 0).toLocaleString('en-LK', { style: 'currency', currency: 'LKR' })}</td>
                                <td class="text-end">${Number(jbc.balance || 0).toLocaleString('en-LK', { style: 'currency', currency: 'LKR' })}</td>
                                <td class="text-center">${payBtn}</td>
                            </tr>`;

                });
                $('#customerJobCardTable tbody').html(rows);
            } else {
                $('#customerJobCardTable tbody').html('<tr><td colspan="7" class="text-center text-muted">No job cards found for this customer.</td></tr>');
            }
        },
        error: function() {
            $('#customerJobCardTable tbody').html('<tr><td colspan="7" class="text-center text-danger">Error loading job cards.</td></tr>');
        }
    });
}

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
                    } else if (parseFloat(inv.outstanding) === 0 && !inv.is_verified) {
                        payBtn = `<span class="badge bg-danger">Verify Pending</span>`;
                    } else if (inv.is_verified) {
                        payBtn = `<span class="badge bg-success">Paid</span>`;
                    }

                    rows += `<tr 
                                class="invoice-row ${inv.is_verified == false ? 'bg-warning' : ''}" 
                                data-invoice-id="${inv.invoice.id}" 
                                style="cursor: pointer;" 
                                onclick="handleInvoiceRowClick(this, ${inv.invoice.id}, ${customerId})">
                                <td>${inv.invoice.invoice_number || '-'}</td>
                                <td>${inv.invoice.invoice_date || '-'}</td>
                                <td class="text-end">${Number(inv.total || 0).toLocaleString('en-LK', { style: 'currency', currency: 'LKR' })}</td>
                                <td class="text-end">${Number(inv.paid || 0).toLocaleString('en-LK', { style: 'currency', currency: 'LKR' })}</td>
                                <td class="text-end">${Number(inv.outstanding || 0).toLocaleString('en-LK', { style: 'currency', currency: 'LKR' })}</td>
                                <td class="text-center">${payBtn}</td>
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

function handleJobcardRowClick(row, jobcardId, customerId) {
    $('.jobcard-row').removeClass('table-active'); 
    $(row).addClass('table-active');              
    getJobcardRowDetails(jobcardId, customerId);
}

function handleInvoiceRowClick(row, invoiceId, customerId) {
    $('.invoice-row').removeClass('table-active'); 
    $(row).addClass('table-active');              
    getInvoiceRowDetails(invoiceId, customerId);
}

function getJobcardRowDetails(jobcardId, customerId) {
    $.ajax({
        url: '<?php echo base_url(); ?>Payment/getAllocatedJobcardPayments/' + jobcardId,
        method: 'GET',
        dataType: 'json',
        success: function(res) {     
            if (res.status) {
                const jobcard_number = res.data.jobcard_number;
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
                        customerId: customerId,
                        row_id: p.id || 0,
                        date: p.payment_date || '-',
                        jobcardId: jobcardId,
                        jobcardNumber: jobcard_number || '-',  
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
                        customerId: customerId,
                        row_id: p.id || 0,
                        date: p.payment_date || '-',
                        jobcardId: jobcardId,
                        jobcardNumber: jobcard_number || '-',  
                        balance: parseFloat(balance || 0),
                        amount: parseFloat(p.payment || 0),
                        payment_type: p.payment_type == '1' ? 'Advance ' : '',
                        method: method,
                        methodText: methodText 
                    };
                });

                renderAllocatedPaymentsTable();
                $('#selected_jobcard_no').text(jobcard_number);
                $('#selected_jobcard_id').val(jobcardId);
                
                if (res.data.is_verified) {
                    $('#confirmPaymentBtn').prop('disabled', true);
                } else {
                    $('#confirmPaymentBtn').prop('disabled', false);
                }
            } else {
                allocatedPayments = [];
                verifiedPayments = [];
                renderAllocatedPaymentsTable(); 
                $('#selected_jobcard_no').text('Not Applicable');
                $('#selected_jobcard_id').val('');
            }
        },
        error: function() {
            alert('Failed to load allocated payments.');
        }
    });
}

function getInvoiceRowDetails(invoiceId, customerId) {
    $.ajax({
        url: '<?php echo base_url(); ?>Payment/getAllocatedPayments/' + invoiceId,
        method: 'GET',
        dataType: 'json',
        success: function(res) {     
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
                        customerId: customerId,
                        row_id: p.id || 0,
                        date: p.payment_date || '-',
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
                        customerId: customerId,
                        row_id: p.id || 0,
                        date: p.payment_date || '-',
                        invoiceId: invoiceId,
                        invoiceNumber: invoice_number || '-',  
                        balance: parseFloat(balance || 0),
                        amount: parseFloat(p.payment || 0),
                        payment_type: p.payment_type == '1' ? 'Advance ' : '',
                        method: method,
                        methodText: methodText 
                    };
                });

                renderAllocatedPaymentsTable();
                $('#selected_invoice_no').text(invoice_number);
                $('#selected_invoice_id').val(invoiceId);
                
                if (res.data.is_verified) {
                    $('#confirmPaymentBtn').prop('disabled', true);
                } else {
                    $('#confirmPaymentBtn').prop('disabled', false);
                }
            } else {
                allocatedPayments = [];
                verifiedPayments = [];
                renderAllocatedPaymentsTable(); 
                $('#selected_invoice_no').text('Not Applicable');
                $('#selected_invoice_id').val('');
            }
        },
        error: function() {
            alert('Failed to load allocated payments.');
        }
    });
}

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
                    <td>${p.invoiceNumber || p.jobcardNumber || '-'}</td>
                    <td>${p.methodText}</td>
                    <td class="text-end">${Number(p.amount).toLocaleString('en-LK', { style: 'currency', currency: 'LKR' })}</td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" title="Verify Payment" class="btn btn-success" id="${p.row_id}" 
                                data-${p.invoiceId ? 'invoice' : 'jobcard'}-id="${p.invoiceId || p.jobcardId}" 
                                data-customer-id="${p.customerId}" 
                                onclick="verifyRow(this)">
                                <i class="fas fa-check-circle"></i>
                            </button>
                            <button type="button" title="Delete Payment" class="btn btn-danger" id="${p.row_id}" 
                                data-${p.invoiceId ? 'invoice' : 'jobcard'}-id="${p.invoiceId || p.jobcardId}" 
                                data-customer-id="${p.customerId}" 
                                onclick="deleteRow(this)">
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
                    <td>${p.invoiceNumber || p.jobcardNumber || '-'}</td>
                    <td>${p.methodText}</td>
                    <td>${p.payment_type}</td>
                    <td class="text-end">${Number(p.amount || 0).toLocaleString('en-LK', { style: 'currency', currency: 'LKR' })}</td>
                    <td class="text-center">
                        <button type="button" title="Print Receipt" class="btn btn-sm btn-info" 
                            data-${p.invoiceId ? 'invoice' : 'jobcard'}-id="${p.invoiceId || p.jobcardId}" 
                            onclick="printReceipt(this)">
                            <i class="fas fa-receipt"></i>
                        </button>
                    </td>
                </tr>`;
        });
    }

    // entire layout
    if ($('#allocatedPaymentsWrapper').length === 0) {
        $('#customerOutstandingTable, #customerJobCardTable').parent().after(`
            <div class="row mt-3" id="allocatedPaymentsWrapper">
                <!-- Allocated Payments Table -->
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark">Allocated Pending Payments</label>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0" id="allocatedPaymentsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Document No</th>
                                    <th>Method</th>
                                    <th class="text-end">Allocated Amount</th>
                                    <th class="text-center">Action</th>
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
                                    <th>Document No</th>
                                    <th>Method</th>
                                    <th>Details</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="successfulPaymentsBody">${verifiedHtml}</tbody>
                        </table>
                    </div>
                </div>
            </div>
        `);
    } else {
        $('#allocatedPaymentsTable tbody').html(pendingHtml);
        $('#successfulPaymentsTable tbody').html(verifiedHtml);
    }
}

$(document).on('click', '.allocate-payment-btn', function() {
    if ($(this).data('invoice-number')) {
        // Invoice payment
        currentDocumentType = 'invoice';
        $('#documentNumberLabel').text('Invoice Number');
        const invoiceNumber = $(this).data('invoice-number');
        const balance = $(this).data('balance');
        $('#allocateDocumentNumber').val(invoiceNumber);
        $('#allocateDocumentBalance').val((parseFloat(balance).toFixed(2)));
        $('#allocatePaymentAmount').val(balance);
        $('#allocatePaymentModal').data('invoice-id', $(this).data('invoice-id'));
        $('#allocatePaymentModal').data('jobcard-id', '');
    } else if ($(this).data('jobcard-number')) {
        // Jobcard payment
        currentDocumentType = 'jobcard';
        $('#documentNumberLabel').text('Job Card Number');
        const jobcardNumber = $(this).data('jobcard-number');
        const balance = $(this).data('balance');
        $('#allocateDocumentNumber').val(jobcardNumber);
        $('#allocateDocumentBalance').val((parseFloat(balance).toFixed(2)));
        $('#allocatePaymentAmount').val(balance);
        $('#allocatePaymentModal').data('jobcard-id', $(this).data('jobcard-id'));
        $('#allocatePaymentModal').data('invoice-id', '');
    }
    
    $('#allocatePaymentMethod').val('');
    $('#allocateChequeDetails, #allocateBankDetails').addClass('d-none');
    $('#allocateChequeNumber, #allocateChequeBank, #allocateChequeDate, #allocateBankReference, #allocateBankName, #allocateBankDate').val('');
});

function insertPayment() {
    const date = $('#allocatePaymentDate').val();
    const amount = parseFloat($('#allocatePaymentAmount').val()) || 0;
    const balance = parseFloat($('#allocateDocumentBalance').val()) || 0;
    const method = $('#allocatePaymentMethod').val();
    const chequeNumber = $('#allocateChequeNumber').val();
    const bankReference = $('#allocateBankReference').val();
    const allocateBankDate = $('#allocateBankDate').val();
    const allocateChequeDate = $('#allocateChequeDate').val();
    const methodText = $('#allocatePaymentMethod option:selected').text(); 
    
    let documentId, customerId;
    
    if (currentDocumentType === 'invoice') {
        documentId = $('#allocatePaymentModal').data('invoice-id');
        customerId = $('#inv_customer').val();
    } else if (currentDocumentType === 'jobcard') {
        documentId = $('#allocatePaymentModal').data('jobcard-id');
        customerId = $('#job_customer').val();
    } else {
        alert('Invalid document type');
        return;
    }

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

    $.ajax({
        url: '<?php echo base_url() ?>Payment/insertORUpdatePayment', 
        method: 'POST',
        dataType: 'json',
        data: {
            payment_date: date,
            invoice_id: currentDocumentType === 'invoice' ? documentId : null,
            jobcard_id: currentDocumentType === 'jobcard' ? documentId : null,
            payment_option: method,
            cheque_number: chequeNumber,
            bank_reference: bankReference,
            allocateBankDate: allocateBankDate,
            allocateChequeDate: allocateChequeDate,
            payment: amount,
            branch_id: branch_id,
            company_id: company_id,
        },
        success: function(result) {
            if (result.status == true) {
                if (currentDocumentType === 'invoice') {
                    getInvoiceRowDetails(documentId, customerId);
                } else if (currentDocumentType === 'jobcard') {
                    getJobcardRowDetails(documentId, customerId);
                }
                
                $('#allocatePaymentModal').modal('hide');
                setTimeout(() => {
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = 'auto';
                    document.body.style.paddingRight = '';
                }, 500);
            } else {
                console.log(result.message);
            }
        },
        error: function() {
            alert(`Error while saving payment`);
        }
    });
}

function verifyRow(button) {
    const id = button.id;
    const invoiceId = button.getAttribute('data-invoice-id');
    const jobcardId = button.getAttribute('data-jobcard-id');
    const customerId = button.getAttribute('data-customer-id');

    if (confirm("Are you sure you want to Verify this payment?")) {
        $.ajax({
            url: '<?php echo base_url() ?>Payment/verifyPayment',
            method: 'POST',
            dataType: 'json',
            data: {
                recordID: id,
            },
            success: function(result) {
                if (result.status == true) {
                    success_toastify(result.message);
                    if (invoiceId) {
                        getInvoiceRowDetails(invoiceId, customerId);
                        getCustomerDetails(customerId);
                    } else if (jobcardId) {
                        getJobcardRowDetails(jobcardId, customerId);
                        getCustomerJobCardDetails(customerId);
                    }
                } else {
                    alert(result.message);
                }
            },
            error: function() {
                alert('Error verifying payment. Please try again.');
            }
        });
    }
}

function deleteRow(button) {
    const id = button.id;
    const invoiceId = button.getAttribute('data-invoice-id');
    const jobcardId = button.getAttribute('data-jobcard-id');
    const customerId = button.getAttribute('data-customer-id');

    if (confirm("Are you sure you want to delete this payment?")) {
        $.ajax({
            url: '<?php echo base_url() ?>Payment/deletePayment/'+id,
            method: 'DELETE',
            dataType: 'json',
            success: function(result) {
                if (result.status == true) {
                    success_toastify(result.message);
                    if (invoiceId) {
                        getInvoiceRowDetails(invoiceId, customerId);
                        getCustomerDetails(customerId);
                    } else if (jobcardId) {
                        getJobcardRowDetails(jobcardId, customerId);
                        getCustomerJobCardDetails(customerId);
                    }
                } else {
                    alert(result.message);
                }
            },
            error: function() {
                alert('Error deleting payment. Please try again.');
            }
        });
    }
}

function confirmPayment(){
    var selectedDocumentId = 0;
    var customerId = 0;
    
    if (MainPaymentType === 'invoice') {
        selectedDocumentId = $('#selected_invoice_id').val(); 
        customerId = $('#inv_customer').val();
        
        if (!selectedDocumentId) {
            alert('Please select an invoice before proceeding.');
            return false;
        }
    } else if (MainPaymentType === 'advanced') {
        selectedDocumentId = $('#selected_jobcard_id').val();
        customerId = $('#job_customer').val();
        
        if (!selectedDocumentId) {
            alert('Please select a job card before proceeding.');
            return false;
        }
    }

    let cashier = $('#cashier').val();
    if (!cashier) {
        alert('Please select a cashier before proceeding.');
        return false;
    }

    let cashier_text = $('#cashier option:selected').text();
    let confirm_date = $('#confirm_date').val();
    let notes = $('#notes').val();

    $.ajax({
        url: '<?php echo base_url() ?>Payment/confirmPayment', 
        method: 'POST',
        dataType: 'json',
        data: {
            jobcard_id: MainPaymentType === 'advanced' ? selectedDocumentId : null,
            invoice_id: MainPaymentType === 'invoice' ? selectedDocumentId : null,
            cashier: cashier,
            cashier_text: cashier_text,
            confirm_date: confirm_date,
            notes: notes,
            main_payment_type: MainPaymentType,
        },
        success: function(result) {
            if (result.status == true) {
                success_toastify(result.message);
                $('#confirmPaymentBtn').prop('disabled', true);

                if(MainPaymentType === 'invoice'){
                    getCustomerDetails(customerId);
                } else if(MainPaymentType === 'advanced') {
                    getCustomerJobCardDetails(customerId);
                }
            } else {
                error_toastify(result.message);
            }
        }
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