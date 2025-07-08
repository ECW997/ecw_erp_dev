<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-secondary text-white rounded-top">
        <h5 class="modal-title text-white">
          <i class="fas fa-cash-register me-2"></i>
          Payments
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body p-4">
        <div class="payment-type-selection mb-4 p-3 border rounded">
          <h6 class="section-title p-2 mb-3 rounded">Select Payment Type</h6>
          <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-outline-primary payment-type-btn active" data-type="advanced">
              <i class="fas fa-tools me-2"></i> Advanced Payment (Job Card)
            </button>
            <button type="button" class="btn btn-outline-primary payment-type-btn" data-type="direct">
              <i class="fas fa-hand-holding-usd me-2"></i> Direct Payment
            </button>
            <button type="button" class="btn btn-outline-primary payment-type-btn" data-type="invoice">
              <i class="fas fa-file-invoice-dollar me-2"></i> Invoice Payment
            </button>
          </div>
        </div>

        <div class="payment-content">

          <div class="payment-section" id="advanced-payment-section">
            <div class="row g-4">
              <!-- Job Card Selection -->
              <div class="col-md-6">
                <div class="job-card-details p-3 border rounded h-100">
                  <h6 class="section-title p-2 mb-3 rounded">Job Card Details</h6>
                  <div class="form-group mb-3">
                    <label class="form-label small fw-bold text-dark">Select Job Card</label>
                    <select class="form-select form-select-sm job-card-select input-highlight">
                      <option value="">Select Job Card</option>
                      <option value="JC-1001">JC-1001 - Toyota Corolla - Engine Repair</option>
                      <option value="JC-1002">JC-1002 - Honda Civic - Brake Service</option>
                      <option value="JC-1003">JC-1003 - Nissan Sunny - AC Repair</option>
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
                      <span class="customer-name small text-dark">No customer selected</span>
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
                      <span class="fw-bold text-success paid-amount">Rs. 0.00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span class="small text-muted">Balance:</span>
                      <span class="fw-bold text-danger balance-amount">Rs. 0.00</span>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="form-label small fw-bold text-dark">Payment Amount</label>
                    <div class="input-group input-group-sm">
                      <span class="input-group-text">Rs.</span>
                      <input type="number" class="form-control form-control-sm payment-amount input-highlight" placeholder="0.00" min="0" step="0.01">
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
                  <h6 class="section-title p-2 mb-3 rounded">Direct Payment Details</h6>
                  <div class="form-group mb-3">
                    <label class="form-label small fw-bold text-dark">Customer (Optional)</label>
                    <select class="form-select form-select-sm customer-select input-highlight">
                      <option value="">Select Customer (Optional)</option>
                      <option value="1">John Doe (+94 76 123 4567)</option>
                      <option value="2">Jane Smith (+94 77 987 6543)</option>
                      <option value="3">Robert Johnson (+94 71 555 1234)</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="form-label small fw-bold text-dark">Payment Amount</label>
                    <div class="input-group input-group-sm">
                      <span class="input-group-text">Rs.</span>
                      <input type="number" class="form-control form-control-sm direct-amount input-highlight" placeholder="0.00" min="0" step="0.01">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label small fw-bold text-dark">Payment Purpose</label>
                    <input type="text" class="form-control form-control-sm payment-purpose input-highlight" placeholder="Service payment, Advance, etc.">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="direct-payment-summary p-3 border rounded h-100">
                  <h6 class="section-title p-2 mb-3 rounded">Payment Summary</h6>
                  <div class="alert alert-warning py-2 mb-3">
                    <small><i class="fas fa-exclamation-circle me-2"></i> Direct payments are not linked to any job card or invoice.</small>
                  </div>
                  <div class="payment-preview p-2 bg-light rounded">
                    <div class="d-flex justify-content-between mb-2">
                      <span class="small text-muted">Payment Type:</span>
                      <span class="fw-bold text-dark">Direct Payment</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                      <span class="small text-muted">Amount:</span>
                      <span class="fw-bold direct-preview-amount text-dark">Rs. 0.00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span class="small text-muted">Customer:</span>
                      <span class="fw-bold direct-preview-customer text-dark">Not specified</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="payment-section d-none" id="invoice-payment-section">
            <div class="row g-4">
              <div class="col-md-6">
                <div class="invoice-details-section p-3 border rounded h-100">
                  <h6 class="section-title p-2 mb-3 rounded">Invoice Details</h6>
                  <div class="form-group mb-3">
                    <label class="form-label small fw-bold text-dark">Select Invoice</label>
                    <select class="form-select form-select-sm invoice-select input-highlight" onchange="getInvoiceDetails(this.value);" id="invoice_s" name="invoice_s">
                      <option value="">Select Invoice</option>
                      
                    </select>
                  </div>
                  <div class="invoice-info invoice-details mb-3">
                    <div class="alert alert-info py-2 mb-0">
                      <small>Select an invoice to view details</small>
                    </div>
                  </div>
                  <div class="form-check form-switch mb-3">
                    <input class="form-check-input installment-toggle input-highlight" type="checkbox" id="installmentToggle">
                    <label class="form-check-label small text-dark" for="installmentToggle">This is an installment payment</label>
                  </div>
                  <div class="installment-details d-none">
                    <div class="form-group mb-3">
                      <label class="form-label small fw-bold text-dark">Installment Number</label>
                      <input type="number" class="form-control form-control-sm installment-number input-highlight" min="1" value="1">
                    </div>
                    <div class="form-group">
                      <label class="form-label small fw-bold text-dark">Total Installments</label>
                      <input type="number" class="form-control form-control-sm total-installments input-highlight" min="1" value="1">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="invoice-payment-section p-3 border rounded h-100">
                  <h6 class="section-title p-2 mb-3 rounded">Payment Calculation</h6>
                  <div class="invoice-summary mb-4 p-2 bg-light rounded">
                    <div class="d-flex justify-content-between mb-2">
                      <span class="small text-muted">Invoice Total:</span>
                      <span class="fw-bold invoice-total text-dark">Rs. 0.00</span>
                      <input type="hidden" id="hide_invoice-total" value="0">
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                      <span class="small text-muted">Paid Amount:</span>
                      <span class="fw-bold text-success invoice-paid">Rs. 0.00</span>
                      <input type="hidden" id="hide_invoice-paid" value="0">
                    </div>
                    <div class="d-flex justify-content-between">
                      <span class="small text-muted">Balance:</span>
                      <span class="fw-bold text-danger invoice-balance">Rs. 0.00</span>
                      <input type="hidden" id="hide_invoice-balance" value="0">
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label class="form-label small fw-bold text-dark">Payment Amount</label>
                    <div class="input-group input-group-sm">
                      <span class="input-group-text">Rs.</span>
                      <input type="number" class="form-control form-control-sm invoice-amount input-highlight" placeholder="0.00" min="0" step="0.01">
                    </div>
                  </div>
                  <div class="alert alert-light py-2">
                    <small class="text-muted">After this payment:</small>
                    <div class="d-flex justify-content-between mt-1">
                      <span class="small text-dark">New Balance:</span>
                      <span class="fw-bold text-danger new-balance">Rs. 0.00</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="payment-methods-section mt-4 p-3 border rounded">
          <h6 class="section-title p-2 mb-3 rounded">Payment Method</h6>
          <div class="row g-3">
            <!-- Cash -->
            <div class="col-md-4">
              <div class="payment-method-card h-100 p-3 border rounded">
                <div class="form-check mb-3">
                  <input class="form-check-input payment-method input-highlight" type="radio" name="paymentMethod" id="cashMethod" value="cash" checked>
                  <label class="form-check-label fw-bold text-dark" for="cashMethod">
                    <i class="fas fa-money-bill-wave text-success me-2"></i> Cash
                  </label>
                </div>
                <div class="payment-method-details" id="cashDetails">
                  <div class="form-group mb-3">
                    <label class="form-label small fw-bold text-dark">Amount Received</label>
                    <div class="input-group input-group-sm">
                      <span class="input-group-text">Rs.</span>
                      <input type="number" class="form-control form-control-sm cash-received input-highlight" placeholder="0.00" min="0" step="0.01">
                    </div>
                  </div>
                  <div class="alert alert-light py-2 mb-0 d-flex justify-content-between">
                    <small class="text-muted">Change:</small>
                    <strong class="cash-change text-dark">Rs. 0.00</strong>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Cheque -->
            <div class="col-md-4">
              <div class="payment-method-card h-100 p-3 border rounded">
                <div class="form-check mb-3">
                  <input class="form-check-input payment-method input-highlight" type="radio" name="paymentMethod" id="chequeMethod" value="cheque">
                  <label class="form-check-label fw-bold text-dark" for="chequeMethod">
                    <i class="fas fa-money-check-alt text-warning me-2"></i> Cheque
                  </label>
                </div>
                <div class="payment-method-details d-none" id="chequeDetails">
                  <div class="form-group mb-3">
                    <label class="form-label small fw-bold text-dark">Cheque Number</label>
                    <input type="text" class="form-control form-control-sm cheque-number input-highlight" placeholder="CHQ-123456">
                  </div>
                  <div class="form-group mb-3">
                    <label class="form-label small fw-bold text-dark">Bank Name</label>
                    <select class="form-select form-select-sm cheque-bank input-highlight">
                      <option value="">Select Bank</option>
                      <option>Commercial Bank</option>
                      <option>People's Bank</option>
                      <option>Bank of Ceylon</option>
                      <option>Hatton National Bank</option>
                      <option>Sampath Bank</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="form-label small fw-bold text-dark">Cheque Date</label>
                    <input type="date" class="form-control form-control-sm cheque-date input-highlight">
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Bank Transfer -->
            <div class="col-md-4">
              <div class="payment-method-card h-100 p-3 border rounded">
                <div class="form-check mb-3">
                  <input class="form-check-input payment-method input-highlight" type="radio" name="paymentMethod" id="bankMethod" value="bank">
                  <label class="form-check-label fw-bold text-dark" for="bankMethod">
                    <i class="fas fa-university text-info me-2"></i> Bank Transfer
                  </label>
                </div>
                <div class="payment-method-details d-none" id="bankDetails">
                  <div class="form-group mb-3">
                    <label class="form-label small fw-bold text-dark">Reference Number</label>
                    <input type="text" class="form-control form-control-sm bank-reference input-highlight" placeholder="TRN-789012">
                  </div>
                  <div class="form-group mb-3">
                    <label class="form-label small fw-bold text-dark">Bank Name</label>
                    <select class="form-select form-select-sm bank-name input-highlight">
                      <option value="">Select Bank</option>
                      <option>Commercial Bank</option>
                      <option>People's Bank</option>
                      <option>Bank of Ceylon</option>
                      <option>Hatton National Bank</option>
                      <option>Sampath Bank</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="form-label small fw-bold text-dark">Transfer Date</label>
                    <input type="date" class="form-control form-control-sm bank-date input-highlight">
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
              <div class="form-group mb-3">
                <label class="form-label small fw-bold text-dark">Payment Date</label>
                <input type="date" class="form-control form-control-sm payment-date input-highlight" value="<?php echo date('Y-m-d'); ?>">
              </div>
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
                <textarea class="form-control form-control-sm payment-notes input-highlight" rows="3" placeholder="Any additional notes about this payment..."></textarea>
              </div>
            </div>
          </div>
        </div>
        
        <div class="mt-4 rounded-bottom d-flex justify-content-end align-items-center gap-2 flex-wrap">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times me-1"></i> Cancel
        </button>

        <button type="button" class="btn btn-sm btn-primary" id="verifyPaymentBtn">
          <i class="fas fa-check-circle me-1"></i> Verify Payment
        </button>

        <button type="button" class="btn btn-sm btn-success" id="confirmPaymentBtn" disabled>
          <i class="fas fa-check-double me-1"></i> Confirm Payment
        </button>
      </div>

        <div class="transactions-history-section mt-4 p-3 border rounded">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="section-title p-2 mb-0 rounded">Payment Transactions</h6>
            <div>
              <button class="btn btn-sm btn-outline-primary me-2" id="printTransactions">
                <i class="fas fa-print me-1"></i> Print
              </button>
              <button class="btn btn-sm btn-outline-secondary" id="refreshTransactions">
                <i class="fas fa-sync-alt me-1"></i> Refresh
              </button>
            </div>
          </div>
          
          <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0" id="transactionsTable">
              <thead class="bg-light">
                <tr>
                  <th class="ps-3 small fw-bold text-dark">Date</th>
                  <th class="small fw-bold text-dark">Type</th>
                  <th class="small fw-bold text-dark">Reference</th>
                  <th class="small fw-bold text-dark">Method</th>
                  <th class="text-end small fw-bold text-dark">Amount</th>
                  <th class="small fw-bold text-dark">Status</th>
                  <th class="text-center small fw-bold text-dark">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="7" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </td>
                </tr>
              </tbody>
              <tfoot class="bg-light">
                <tr>
                  <td colspan="4" class="fw-bold small text-dark">Total</td>
                  <td class="text-end fw-bold text-dark" id="totalTransactions">Rs. 0.00</td>
                  <td colspan="2"></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="transactionDetailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white rounded-top">
        <h5 class="modal-title text-white">
          <i class="fas fa-receipt me-2"></i>
          Transaction Details - <span id="transactionIdDisplay">TXN-1001</span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4" id="transactionDetailsContent">
        <!-- Details will be loaded here -->
      </div>
      <div class="modal-footer bg-light rounded-bottom">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times me-1"></i> Close
        </button>
        <button type="button" class="btn btn-primary" id="printTransactionBtn">
          <i class="fas fa-print me-1"></i> Print Receipt
        </button>
      </div>
    </div>
  </div>
</div>

<script>
   let invoice_s = $('#invoice_s');

  $(document).on('click', '.open-payment-modal', function () {
    var paymentType = $(this).data('payment-type');
    var parentId = $(this).data('parent-id');
    var parentNo = $(this).data('parent-no');

    // $('#hiddenParentId').val(parentId);

    $('.payment-type-btn').removeClass('active');
    $(`.payment-type-btn[data-type="${paymentType}"]`).addClass('active');

    $('.payment-section').addClass('d-none');
    $(`#${paymentType}-payment-section`).removeClass('d-none');

    $('.payment-method').prop('checked', false);
    $('#cashMethod').prop('checked', true);
    $('.payment-method-details').addClass('d-none');
    $('#cashDetails').removeClass('d-none');

    $('#confirmPaymentBtn').prop('disabled', true);

    if(paymentType == 'invoice'){
        if (parentId && parentNo) {
            var option = new Option(parentNo, parentId, true, true);
            invoice_s.append(option).trigger('change');
        }
    }
});

// Invoice selection
$('.invoice-select').change(function() {
  const invoiceId = $(this).val();
  if (invoiceId) {
    // Clear invoice details area and show loading spinner or message if needed
    $('.invoice-details').html(`
      <div class="alert alert-info py-2 mb-0">
        <small>Loading invoice details...</small>
      </div>
    `);
    // Fetch invoice details via AJAX and update all fields
    getInvoiceDetails(invoiceId);
  } else {
    $('.invoice-details').html(`
      <div class="alert alert-info py-2 mb-0">
        <small>Select an invoice to view details</small>
      </div>
    `);
    $('.invoice-total, .invoice-paid, .invoice-balance, .new-balance').text('Rs. 0.00');
    $('.invoice-amount').val('');
  }
});

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

        // Update invoice summary fields
        $('.invoice-total').text('Rs. ' + addCommas(grandTotal.toFixed(2)));
        $('#hide_invoice-total').val(grandTotal.toFixed(2));
        $('.invoice-paid').text('Rs. ' + addCommas(totalPaid.toFixed(2)));
        $('#hide_invoice-paid').val(totalPaid.toFixed(2));
        $('.invoice-balance').text('Rs. ' + addCommas(balance.toFixed(2)));
        $('#hide_invoice-balance').val(balance.toFixed(2));

        // Set payment amount to balance and trigger calculation
        $('.invoice-amount').val(balance.toFixed(2)).trigger('input');

        // Update invoice details area with dynamic data
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

 $(document).ready(function() {
  initPaymentModal();
  
  $('#paymentModal').on('shown.bs.modal', function() {
    initTransactionTable();
  });

  invoice_s.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>Invoice/getInvoiceNo',
            dataType: 'json',
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

  // Payment type selection
  $('.payment-type-btn').click(function() {
    $('.payment-type-btn').removeClass('active');
    $(this).addClass('active');
    $('.payment-section').addClass('d-none');
    
    const paymentType = $(this).data('type');
    $(`#${paymentType}-payment-section`).removeClass('d-none');
    
    // Reset payment method to cash when changing type
    $('.payment-method').prop('checked', false);
    $('#cashMethod').prop('checked', true);
    $('.payment-method-details').addClass('d-none');
    $('#cashDetails').removeClass('d-none');
    
    // Reset confirm button
    $('#confirmPaymentBtn').prop('disabled', true);
  });
  
  // Payment method selection
  $('.payment-method').change(function() {
    const method = $(this).val();
    $('.payment-method-details').addClass('d-none');
    $(`#${method}Details`).removeClass('d-none');
  });
  
  // Job card selection
  $('.job-card-select').change(function() {
    const jobCardId = $(this).val();
    if (jobCardId) {
      // Simulate loading job card details
      $('.job-card-details').html(`
        <div class="d-flex justify-content-between mb-2">
          <span class="small text-muted">Vehicle:</span>
          <span class="small fw-bold">Toyota Corolla (CAB-1234)</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="small text-muted">Service:</span>
          <span class="small fw-bold">Engine Repair</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="small text-muted">Started:</span>
          <span class="small fw-bold">2023-10-15</span>
        </div>
        <div class="d-flex justify-content-between">
          <span class="small text-muted">Status:</span>
          <span class="badge bg-warning rounded-pill small">In Progress</span>
        </div>
      `);
      
      // Update customer info
      $('.customer-name').text('John Doe');
      $('.customer-phone').text('+94 76 123 4567');
      $('.customer-vehicle').text('Toyota Corolla (CAB-1234)');
      
      // Update payment summary
      $('.job-total').text('Rs. 25,000.00');
      $('.paid-amount').text('Rs. 5,000.00');
      $('.balance-amount').text('Rs. 20,000.00');
      
      // Set payment amount to balance
      $('.payment-amount').val('20000.00');
    } else {
      $('.job-card-details').html(`
        <div class="alert alert-info py-2 mb-0">
          <small>Select a job card to view details</small>
        </div>
      `);
      $('.customer-name').text('No customer selected');
      $('.customer-phone').text('-');
      $('.customer-vehicle').text('-');
      $('.job-total, .paid-amount, .balance-amount').text('Rs. 0.00');
      $('.payment-amount').val('');
    }
  });
  
  // Invoice selection
  $('.invoice-select').change(function() {
    const invoiceId = $(this).val();
    if (invoiceId) {
      // Clear invoice details area and show loading spinner or message if needed
      $('.invoice-details').html(`
        <div class="alert alert-info py-2 mb-0">
          <small>Loading invoice details...</small>
        </div>
      `);
      // Fetch invoice details via AJAX and update all fields
      getInvoiceDetails(invoiceId);
    } else {
      $('.invoice-details').html(`
        <div class="alert alert-info py-2 mb-0">
          <small>Select an invoice to view details</small>
        </div>
      `);
      $('.invoice-total, .invoice-paid, .invoice-balance, .new-balance').text('Rs. 0.00');
      $('.invoice-amount').val('');
    }
  });
  
  // Installment toggle
  $('.installment-toggle').change(function() {
    if ($(this).is(':checked')) {
      $('.installment-details').removeClass('d-none');
    } else {
      $('.installment-details').addClass('d-none');
    }
  });
  
  // Calculate cash change
  $('.cash-received').on('input', function() {
    const received = parseFloat($(this).val()) || 0;
    const amount = parseFloat($('.payment-amount').val()) || 
                  parseFloat($('.invoice-amount').val()) || 
                  parseFloat($('.direct-amount').val()) || 0;
    
    const change = received - amount;
    $('.cash-change').text(`Rs. ${change.toFixed(2)}`);
  });
  
  // Calculate new balance for invoice payments
  $('.invoice-amount').on('input', updateNewBalance);
  
  function updateNewBalance() {
    const balance = parseFloat($('.invoice-balance').text().replace('Rs. ', '').replace(',', '')) || 0;
    const payment = parseFloat($('.invoice-amount').val()) || 0;
    const newBalance = balance - payment;
    $('.new-balance').text(`Rs. ${newBalance.toFixed(2)}`);
  }
  
  // Customer selection for direct payments
  $('.customer-select').change(function() {
    const customerId = $(this).val();
    if (customerId) {
      const customerName = $(this).find('option:selected').text().split(' (')[0];
      $('.direct-preview-customer').text(customerName);
    } else {
      $('.direct-preview-customer').text('Not specified');
    }
  });
  
  // Direct payment amount preview
  $('.direct-amount').on('input', function() {
    const amount = parseFloat($(this).val()) || 0;
    $('.direct-preview-amount').text(`Rs. ${amount.toFixed(2)}`);
  });
  
  // Verify payment button
  $('#verifyPaymentBtn').click(function() {
    // Validate payment based on type
    const activeType = $('.payment-type-btn.active').data('type');
    let isValid = false;
    
    if (activeType === 'advanced') {
      const jobCard = $('.job-card-select').val();
      const amount = parseFloat($('.payment-amount').val()) || 0;
      const balance = parseFloat($('.balance-amount').text().replace('Rs. ', '').replace(',', '')) || 0;
      
      if (!jobCard) {
        showAlert('Please select a job card', 'danger');
      } else if (amount <= 0) {
        showAlert('Please enter a valid payment amount', 'danger');
      } else if (amount > balance) {
        showAlert('Payment amount cannot exceed the balance', 'danger');
      } else {
        isValid = true;
      }
    } 
    else if (activeType === 'direct') {
      const amount = parseFloat($('.direct-amount').val()) || 0;
      
      if (amount <= 0) {
        showAlert('Please enter a valid payment amount', 'danger');
      } else {
        isValid = true;
      }
    }
    else if (activeType === 'invoice') {
      const invoice = $('.invoice-select').val();
      const amount = parseFloat($('.invoice-amount').val()) || 0;
      const balance = parseFloat($('.invoice-balance').text().replace('Rs. ', '').replace(',', '')) || 0;
      
      if (!invoice) {
        showAlert('Please select an invoice', 'danger');
      } else if (amount <= 0) {
        showAlert('Please enter a valid payment amount', 'danger');
      } else if (amount > balance) {
        showAlert('Payment amount cannot exceed the invoice balance', 'danger');
      } else {
        isValid = true;
      }
    }
    
    if (isValid) {
      // Validate payment method
      const method = $('.payment-method:checked').val();
      
      if (method === 'cash') {
        const received = parseFloat($('.cash-received').val()) || 0;
        const amount = parseFloat($('.payment-amount').val()) || 
                      parseFloat($('.invoice-amount').val()) || 
                      parseFloat($('.direct-amount').val()) || 0;
        
        if (received < amount) {
          showAlert('Received amount is less than payment amount', 'danger');
          return;
        }
      } 
      else if (method === 'cheque') {
        if (!$('.cheque-number').val()) {
          showAlert('Please enter cheque number', 'danger');
          return;
        }
        if (!$('.cheque-bank').val()) {
          showAlert('Please select bank', 'danger');
          return;
        }
        if (!$('.cheque-date').val()) {
          showAlert('Please enter cheque date', 'danger');
          return;
        }
      } 
      else if (method === 'bank') {
        if (!$('.bank-reference').val()) {
          showAlert('Please enter reference number', 'danger');
          return;
        }
        if (!$('.bank-name').val()) {
          showAlert('Please select bank', 'danger');
          return;
        }
        if (!$('.bank-date').val()) {
          showAlert('Please enter transfer date', 'danger');
          return;
        }
      }
      
      // Validate additional details
      if (!$('.payment-date').val()) {
        showAlert('Please select payment date', 'danger');
        return;
      }
      if (!$('.received-by').val()) {
        showAlert('Please select staff member who received payment', 'danger');
        return;
      }
      
      // If all validations pass
      showAlert('Payment verified successfully', 'success');
      $('#confirmPaymentBtn').prop('disabled', false);
    }
  });
  
  // Confirm payment button
  $('#confirmPaymentBtn').click(function() {
    // Here you would typically submit the payment data to your backend
    const activeType = $('.payment-type-btn.active').data('type');
    let paymentData = {
      type: activeType,
      method: $('.payment-method:checked').val(),
      amount: 0,
      date: $('.payment-date').val(),
      receivedBy: $('.received-by').val(),
      notes: $('.payment-notes').val()
    };
    
    // Set type-specific data
    if (activeType === 'advanced') {
      paymentData.jobCardId = $('.job-card-select').val();
      paymentData.amount = parseFloat($('.payment-amount').val());
    } 
    else if (activeType === 'direct') {
      paymentData.customerId = $('.customer-select').val();
      paymentData.amount = parseFloat($('.direct-amount').val());
      paymentData.purpose = $('.payment-purpose').val();
    }
    else if (activeType === 'invoice') {
      paymentData.invoiceId = $('.invoice-select').val();
      paymentData.amount = parseFloat($('.invoice-amount').val());
      paymentData.isInstallment = $('.installment-toggle').is(':checked');
      
      if (paymentData.isInstallment) {
        paymentData.installmentNumber = $('.installment-number').val();
        paymentData.totalInstallments = $('.total-installments').val();
      }
    }
    
    // Set method-specific data
    if (paymentData.method === 'cash') {
      paymentData.cashReceived = parseFloat($('.cash-received').val());
      paymentData.cashChange = parseFloat($('.cash-change').text().replace('Rs. ', ''));
    }
    else if (paymentData.method === 'cheque') {
      paymentData.chequeNumber = $('.cheque-number').val();
      paymentData.chequeBank = $('.cheque-bank').val();
      paymentData.chequeDate = $('.cheque-date').val();
    }
    else if (paymentData.method === 'bank') {
      paymentData.referenceNumber = $('.bank-reference').val();
      paymentData.bankName = $('.bank-name').val();
      paymentData.transferDate = $('.bank-date').val();
    }
    
    // In a real application, you would send this data to your server
    console.log('Payment data:', paymentData);
    
    // Show success message
    showAlert('Payment processed successfully!', 'success');
    
    // Add to transaction table
    addNewTransaction(paymentData);
    
    // Close modal after 2 seconds
    setTimeout(() => {
      $('#paymentModal').modal('hide');
    }, 2000);
  });
  
  // View transaction details
  $(document).on('click', '.view-transaction', function() {
    const transactionId = $(this).closest('tr').data('id');
    showTransactionDetails(transactionId);
  });
  
  // Delete transaction
  $(document).on('click', '.delete-transaction', function() {
    const transactionId = $(this).closest('tr').data('id');
    if (confirm('Are you sure you want to delete this transaction?')) {
      $(this).closest('tr').remove();
      // In a real app, you would also delete from your backend
      const currentTransactions = getCurrentTransactions();
      renderTransactions(currentTransactions);
    }
  });
  
  // Refresh transactions
  $('#refreshTransactions').click(function() {
    initTransactionTable();
  });
  
  // Print transactions
  $('#printTransactions').click(function() {
    // In a real app, you would implement proper print functionality
    alert('Print functionality would be implemented here');
  });
  
  // Print transaction receipt
  $('#printTransactionBtn').click(function() {
    // In a real app, you would implement proper print functionality
    alert('Print receipt functionality would be implemented here');
  });
  
  // Helper functions
  function initPaymentModal() {
    // Initialize date fields with today's date
    $('.payment-date').val(new Date().toISOString().split('T')[0]);
    $('.cheque-date, .bank-date').val(new Date().toISOString().split('T')[0]);
    
    // Set default payment type to advanced
    $('.payment-type-btn[data-type="advanced"]').click();
  }
  
  function showAlert(message, type) {
    // Remove any existing alerts
    $('.alert-dismissible').remove();
    
    const alert = $(`
      <div class="alert alert-${type} alert-dismissible fade show mb-4">
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `);
    
    // Insert after the payment type selection
    $('.payment-content').before(alert);
    
    // Auto dismiss after 5 seconds
    setTimeout(() => {
      alert.alert('close');
    }, 5000);
  }
  
  function initTransactionTable() {
    // Sample data - in a real app, you would fetch this from your backend
    const transactions = [
      {
        id: 'TXN-1001',
        date: '2023-10-15',
        type: 'Job Card',
        reference: 'JC-1001',
        method: 'Cash',
        amount: 5000.00,
        status: 'completed',
        details: {
          customer: 'John Doe',
          vehicle: 'Toyota Corolla (CAB-1234)',
          service: 'Engine Repair',
          receivedBy: 'Sarah Johnson',
          notes: 'Advance payment for parts'
        }
      },
      {
        id: 'TXN-1002',
        date: '2023-10-18',
        type: 'Invoice',
        reference: 'INV-1001',
        method: 'Cheque',
        amount: 10000.00,
        status: 'pending',
        details: {
          customer: 'John Doe',
          invoiceDate: '2023-10-10',
          dueDate: '2023-11-10',
          bank: 'Commercial Bank',
          chequeNo: 'CHQ-789012',
          receivedBy: 'Michael Brown',
          notes: 'First installment payment'
        }
      },
      {
        id: 'TXN-1003',
        date: '2023-10-20',
        type: 'Direct',
        reference: 'DP-1001',
        method: 'Bank Transfer',
        amount: 7500.00,
        status: 'completed',
        details: {
          customer: 'Jane Smith',
          purpose: 'Service Advance',
          referenceNo: 'TRN-345678',
          bank: 'Sampath Bank',
          receivedBy: 'John Smith',
          notes: 'Advance payment for upcoming service'
        }
      }
    ];

    // Render transactions
    renderTransactions(transactions);
  }
  
  function renderTransactions(transactions) {
    const tbody = $('#transactionsTable tbody');
    tbody.empty();
    
    let totalAmount = 0;
    
    if (transactions.length === 0) {
      tbody.append(`
        <tr>
          <td colspan="7" class="text-center py-4 text-muted">
            <i class="fas fa-info-circle me-2"></i> No transactions found
          </td>
        </tr>
      `);
      return;
    }
    
    transactions.forEach(transaction => {
      totalAmount += transaction.amount;
      
      // Determine status badge
      let statusBadge;
      if (transaction.status === 'completed') {
        statusBadge = '<span class="badge bg-success rounded-pill small">Completed</span>';
      } else if (transaction.status === 'pending') {
        statusBadge = '<span class="badge bg-warning rounded-pill small">Pending</span>';
      } else {
        statusBadge = '<span class="badge bg-secondary rounded-pill small">' + transaction.status + '</span>';
      }
      
      // Determine method icon
      let methodIcon;
      if (transaction.method === 'Cash') {
        methodIcon = '<i class="fas fa-money-bill-wave text-success me-1"></i>';
      } else if (transaction.method === 'Cheque') {
        methodIcon = '<i class="fas fa-money-check-alt text-warning me-1"></i>';
      } else if (transaction.method === 'Bank Transfer') {
        methodIcon = '<i class="fas fa-university text-info me-1"></i>';
      } else {
        methodIcon = '<i class="fas fa-credit-card text-primary me-1"></i>';
      }
      
      // Add row to table
      tbody.append(`
        <tr data-id="${transaction.id}">
          <td class="ps-3 small">${transaction.date}</td>
          <td class="small">${transaction.type}</td>
          <td class="small">${transaction.reference}</td>
          <td class="small">${methodIcon} ${transaction.method}</td>
          <td class="text-end fw-bold small">Rs. ${transaction.amount.toFixed(2)}</td>
          <td>${statusBadge}</td>
          <td class="text-center">
            <button class="btn btn-sm btn-outline-primary view-transaction" title="View Details">
              <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger delete-transaction ms-1" title="Delete">
              <i class="fas fa-trash-alt"></i>
            </button>
          </td>
        </tr>
      `);
    });
    
    // Update total
    $('#totalTransactions').text('Rs. ' + totalAmount.toFixed(2));
  }
  
  function showTransactionDetails(transactionId) {
    // In a real app, you would fetch this from your backend
    const transaction = {
      id: 'TXN-1001',
      date: '2023-10-15',
      type: 'Job Card',
      reference: 'JC-1001',
      method: 'Cash',
      amount: 5000.00,
      status: 'completed',
      details: {
        customer: 'John Doe',
        vehicle: 'Toyota Corolla (CAB-1234)',
        service: 'Engine Repair',
        receivedBy: 'Sarah Johnson',
        notes: 'Advance payment for parts'
      }
    };
    
    $('#transactionIdDisplay').text(transaction.id);
    
    let detailsHtml = `
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label small fw-bold">Transaction Date</label>
            <p>${transaction.date}</p>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold">Payment Type</label>
            <p>${transaction.type}</p>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold">Reference</label>
            <p>${transaction.reference}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label small fw-bold">Payment Method</label>
            <p>${transaction.method}</p>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold">Amount</label>
            <p class="fw-bold">Rs. ${transaction.amount.toFixed(2)}</p>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold">Status</label>
            <p>${transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1)}</p>
          </div>
        </div>
      </div>
      <hr>
    `;
    
    // Add type-specific details
    if (transaction.type === 'Job Card') {
      detailsHtml += `
        <h6 class="mb-3">Job Card Details</h6>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label small fw-bold">Customer</label>
              <p>${transaction.details.customer}</p>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-bold">Vehicle</label>
              <p>${transaction.details.vehicle}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label small fw-bold">Service</label>
              <p>${transaction.details.service}</p>
            </div>
          </div>
        </div>
      `;
    } 
    else if (transaction.type === 'Invoice') {
      detailsHtml += `
        <h6 class="mb-3">Invoice Details</h6>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label small fw-bold">Customer</label>
              <p>${transaction.details.customer}</p>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-bold">Invoice Date</label>
              <p>${transaction.details.invoiceDate}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label small fw-bold">Due Date</label>
              <p>${transaction.details.dueDate}</p>
            </div>
            ${transaction.method === 'Cheque' ? `
              <div class="mb-3">
                <label class="form-label small fw-bold">Cheque Details</label>
                <p>${transaction.details.bank} - ${transaction.details.chequeNo}</p>
              </div>
            ` : ''}
          </div>
        </div>
      `;
    }
    else if (transaction.type === 'Direct') {
      detailsHtml += `
        <h6 class="mb-3">Direct Payment Details</h6>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label small fw-bold">Customer</label>
              <p>${transaction.details.customer || 'Not specified'}</p>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-bold">Purpose</label>
              <p>${transaction.details.purpose}</p>
            </div>
          </div>
          <div class="col-md-6">
            ${transaction.method === 'Bank Transfer' ? `
              <div class="mb-3">
                <label class="form-label small fw-bold">Bank Details</label>
                <p>${transaction.details.bank} - ${transaction.details.referenceNo}</p>
              </div>
            ` : ''}
          </div>
        </div>
      `;
    }
    
    // Add common details
    detailsHtml += `
      <hr>
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label small fw-bold">Received By</label>
            <p>${transaction.details.receivedBy}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label small fw-bold">Notes</label>
            <p>${transaction.details.notes || 'No notes available'}</p>
          </div>
        </div>
      </div>
    `;
    
    $('#transactionDetailsContent').html(detailsHtml);
    $('#transactionDetailsModal').modal('show');
  }
  
  function addNewTransaction(paymentData) {
    // Determine transaction type
    let transactionType, reference;
    if (paymentData.type === 'advanced') {
      transactionType = 'Job Card';
      reference = paymentData.jobCardId;
    } else if (paymentData.type === 'invoice') {
      transactionType = 'Invoice';
      reference = paymentData.invoiceId;
    } else {
      transactionType = 'Direct';
      reference = 'DP-' + Math.floor(1000 + Math.random() * 9000);
    }
    
    // Determine method display
    let methodDisplay;
    if (paymentData.method === 'cash') {
      methodDisplay = 'Cash';
    } else if (paymentData.method === 'cheque') {
      methodDisplay = 'Cheque';
    } else {
      methodDisplay = 'Bank Transfer';
    }
    
    // Create new transaction object
    const newTransaction = {
      id: 'TXN-' + Math.floor(1000 + Math.random() * 9000),
      date: paymentData.date,
      type: transactionType,
      reference: reference,
      method: methodDisplay,
      amount: paymentData.amount,
      status: 'completed',
      details: {
        receivedBy: $('.received-by option:selected').text(),
        notes: paymentData.notes
      }
    };
    
    // Add type-specific details
    if (paymentData.type === 'advanced') {
      newTransaction.details.customer = $('.customer-name').text();
      newTransaction.details.vehicle = $('.customer-vehicle').text();
      newTransaction.details.service = 'Service from job card';
    } 
    else if (paymentData.type === 'invoice') {
      newTransaction.details.customer = $('.invoice-select option:selected').text().split(' - ')[1];
      newTransaction.details.invoiceDate = new Date().toISOString().split('T')[0];
      newTransaction.details.dueDate = new Date(new Date().setMonth(new Date().getMonth() + 1)).toISOString().split('T')[0];
      
      if (paymentData.method === 'cheque') {
        newTransaction.details.bank = paymentData.chequeBank;
        newTransaction.details.chequeNo = paymentData.chequeNumber;
      }
    }
    else if (paymentData.type === 'direct') {
      newTransaction.details.customer = $('.customer-select option:selected').text().split(' (')[0];
      newTransaction.details.purpose = paymentData.purpose;
      
      if (paymentData.method === 'bank') {
        newTransaction.details.bank = paymentData.bankName;
        newTransaction.details.referenceNo = paymentData.referenceNumber;
      }
    }
    
    // In a real app, you would send this to your backend first
    // For this demo, we'll add it directly to the table
    const currentTransactions = getCurrentTransactions();
    currentTransactions.unshift(newTransaction); // Add to beginning
    renderTransactions(currentTransactions);
  }
  
  function getCurrentTransactions() {
    const transactions = [];
    $('#transactionsTable tbody tr').each(function() {
      if ($(this).data('id')) {
        transactions.push({
          id: $(this).data('id'),
          date: $(this).find('td:eq(0)').text(),
          type: $(this).find('td:eq(1)').text(),
          reference: $(this).find('td:eq(2)').text(),
          method: $(this).find('td:eq(3)').text().trim(),
          amount: parseFloat($(this).find('td:eq(4)').text().replace('Rs. ', '')),
          status: $(this).find('td:eq(5) span').text().toLowerCase()
        });
      }
    });
    return transactions;
  }
});
</script>