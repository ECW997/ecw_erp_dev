<?php 
include "include/v2/header.php";  
include "include/v2/topnavbar.php"; 
?>
<?php
// Retrieve the customer_id from the URL
$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
?>
<style>

</style>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <style>
        .action-btn-fixed {
            min-width: 140px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }
        </style>
        <main>
            <div class="page-header page-header-light bg-gray shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-1">
                        <div class="row d-flex align-items-center">
                            <div class="col-4">
                                <h1 class="page-header-title">Invoice</h1>
                            </div>
                            <div class="col-md-8 text-md-end">
                                <button type="button" class="btn btn-warning rounded-2 action-btn px-3 py-2 fs-6"
                                    onclick="window.location.href='<?= base_url('Invoice') ?>'">
                                    <i class="fas fa-arrow-left me-1 text-dark"></i>
                                    <i class="fas fa-file-invoice me-1 text-dark"></i>
                                    <span class="text-dark fw-bold">Invoice List</span>
                                </button>
                            </div>
                            <!-- <div class="col-2">
                                <h2 class="job-header-title" id="top_nav_customer_name">
                                    <?= isset($invoice_main_data[0]['customer_id']) && $invoice_main_data[0]['customer_id'] 
                                        ? ($invoice_main_data[0]['jobcard_customer'] ?? '') 
                                        : ($invoice_main_data[0]['customer_name'] ?? '') ?>
                                </h2>
                            </div>
                            <div class="col-2">
                                <h2 class="job-header-title" id="top_nav_vehicle_no">
                                    <?= $invoice_main_data[0]['vehicle_number'] ?? '' ?>
                                </h2>
                            </div>
                            <div class="col-2">
                                <h2 class="job-header-title" id="top_nav_vehicle">
                                    <?= $invoice_main_data[0]['brand_name'] ?? '' ?> - <?= $invoice_main_data[0]['model_name'] ?? '' ?>
                                </h2>
                            </div>
                            <div class="col-2">
                                <h2 class="job-header-title text-primary" id="top_nav_job_card_no">
                                    <?= $invoice_main_data[0]['invoice_number'] ?? '' ?>
                                </h2>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0">
                <div class="card invoice-actions-card">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-primary btn-sm rounded-2 action-btn-fixed"
                                    data-bs-toggle="modal" data-bs-target="#invoiceTypeModal">
                                    <i class="fas fa-plus me-1"></i> New Invoice
                                </button>

                                <button type="button" class="btn btn-success btn-sm rounded-2 action-btn-fixed"
                                    data-bs-toggle="modal" data-bs-target="#invoiceApproveModal">
                                    <i class="fas fa-check me-1"></i> Approve
                                </button>


                                <button type="button" class="btn btn-info btn-sm rounded-2 action-btn-fixed"
                                    onclick="exportJobCardInvoice(<?= $job_main_data[0]['idtbl_jobcard'] ?? '' ?>);">
                                    <i class="fas fa-print me-1"></i> Print Invoice
                                </button>


                                <button type="button" class="btn btn-secondary btn-sm rounded-2 action-btn open-payment-modal" 
                                        data-bs-toggle="modal" data-bs-target="#paymentModal" data-payment-type="invoice" data-parent-id="<?= $invoice_main_data[0]['id'] ?? '' ?>" data-parent-no="<?= $invoice_main_data[0]['invoice_number'] ?? '' ?>">
                                    <i class="fas fa-cash-register me-1"></i> Payment
                                </button>

                                <input type="text" name="invoice_id"
                                    class="form-control form-control-sm input-highlight" id="invoice_id"
                                    value="<?= isset($invoice_main_data[0]['id']) ? $invoice_main_data[0]['id'] : '' ?>"
                                    required>
                                <input type="text" name="approve_id"
                                    class="form-control form-control-sm input-highlight" id="approve_id"
                                    value="<?= isset($invoice_main_data[0]['is_confirmed']) ? $invoice_main_data[0]['is_confirmed'] : '' ?>"
                                    required>

                            </div>

                            <div class="invoice-status-badge">
                                <span class="badge bg-secondary">
                                    <?= strtoupper($invoice_type == 'direct' ? 'Direct' : 'Job Card') ?> INVOICE
                                </span>
                            </div>
                        </div>

                        <div class="invoice-content-section">
                            <div id="jobCardContent">
                                <?php if ($invoice_type == 'direct'): ?>
                                <?php include "components/modal/invoice/direct_invoice_content_header.php"; ?>
                                <?php elseif ($invoice_type == 'indirect'): ?>
                                <?php include "components/modal/invoice/jobcard_invoice_content_header.php"; ?>
                                <?php endif; ?>
                                <?php include "components/modal/invoice/invoice_content.php"; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Invoice Type Modal -->

        <div class="modal fade" id="invoiceTypeModal" tabindex="-1" aria-labelledby="invoiceTypeModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content border-0" style="box-shadow: 0 5px 20px rgba(0,0,0,0.15);">
                    <div class="modal-header bg-primary text-white p-3">
                        <div class="w-100 text-center">
                            <i class="fas fa-file-invoice fa-2x mb-2"></i>
                            <h5 class="modal-title font-weight-bold text-white mb-0" id="invoiceTypeModalLabel">
                                SELECT INVOICE TYPE
                            </h5>
                        </div>
                        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="d-grid gap-3">
                            <button type="button" class="btn btn-option p-3 rounded-3 border-0 text-start" id="direct"
                                onclick="selectInvoiceType('direct')">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-blue-soft me-3">
                                        <i class="fas fa-file-invoice text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Direct Invoice</div>
                                        <small class="text-muted d-block">For direct product sales</small>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="btn btn-option p-3 rounded-3 border-0 text-start" id="indirect"
                                onclick="selectInvoiceType('indirect')">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-orange-soft me-3">
                                        <i class="fas fa-car text-warning"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Job Card Invoice</div>
                                        <small class="text-muted d-block">For service jobs</small>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer bg-light justify-content-center py-2 border-top">
                        <small class="text-muted">Choose an invoice type to continue</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Approve Modal -->

        <div class="modal fade" id="invoiceApproveModal" tabindex="-1" aria-labelledby="invoiceApproveModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0" style="box-shadow: 0 5px 20px rgba(0,0,0,0.15);">
                    <div class="modal-header bg-warning text-white p-3">
                        <div class="w-100 text-left">
                            <h5 class="modal-title text-dark fw-bold" id="jobcardApproveModelLabel">Invoice Approval
                            </h5>
                        </div>

                    </div>
                    <div class="modal-body p-4">
                        <div class="d-grid gap-3">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <h6 class="text-dark fw-bold">Sub total + Extra charges: </h6>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="text-dark fw-bold" id="subtotal_with_extra_price">
                                        Rs. <?= number_format($invoice_main_data[0]['inv_gross_total'] ?? 0, 2) ?>
                                    </span>
                                    <input type="text" name="invoice_id"
                                        class="form-control form-control-sm input-highlight" id="invoice_id"
                                        value="<?= isset($invoice_main_data[0]['id']) ? $invoice_main_data[0]['id'] : '' ?>">
                                    <input type="text" name="approve_id"
                                        class="form-control form-control-sm input-highlight" id="approve_id"
                                        value="<?= isset($invoice_main_data[0]['is_confirmed']) ? $invoice_main_data[0]['is_confirmed'] : '' ?>">
                                    <input type="text" name="jobcard_id"
                                        class="form-control form-control-sm input-highlight" id="approve_id"
                                        value="<?= isset($invoice_main_data[0]['job_card_id']) ? $invoice_main_data[0]['job_card_id'] : '' ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <h6 class="fw-bold">Total Discount Amount: </h6>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="text-danger fw-bold" id="discount_price">
                                        Rs. <?= number_format($invoice_main_data[0]['inv_discount_amount'] ?? 0, 2) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <h6 class="fw-bold">Total Vat Amount: </h6>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="text-success fw-bold" id="vat_price">
                                        Rs. <?= number_format($invoice_main_data[0]['inv_total_tax'] ?? 0, 2) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <h6 class="fw-bold">Total Payment Amount: </h6>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="text-dark fw-bold" id="grand_price">
                                        Rs. <?= number_format($invoice_main_data[0]['inv_grand_total'] ?? 0, 2) ?>
                                    </span>

                                    <input type="text" class="form-control form-control-sm" id="grand_price_input"
                                        value="<?= $invoice_main_data[0]['inv_grand_total'] ?? 0 ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <h6 class="fw-bold">Advance Payment Amount: </h6>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="text-danger fw-bold" id="advance_price">
                                        Rs. <?= number_format($invoice_main_data[0]['payment'] ?? 0, 2) ?>
                                    </span>

                                    <input type="text" class="form-control form-control-sm" id="advance_price_input"
                                        value="<?= $invoice_main_data[0]['payment'] ?? 0 ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <h4 class="fw-bold">Total Payble Amount: </h4>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="text-primary fw-bold" id="total_payble_price_show">
                                    </span>

                                    <input type="text" class="form-control form-control-sm" id="total_payble_price">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row w-100">
                            <div class="col-4">
                                <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal"
                                    style="border-radius: 12px; font-weight:bold;">Close</button>
                            </div>
                            <div class="col-4">
                                <?php if (($invoice_main_data[0]['is_confirmed'] ?? '0') == '0'): ?>
                                <button type="button" class="btn btn-success w-100" id="approveJobcardBtn"
                                    style="border-radius: 12px;" onclick="approveInvoice()">Approve</button>
                                <?php else: ?>
                                <button type="button" class="btn btn-success w-100" id="approveJobcardBtn"
                                    style="border-radius: 12px;" disabled>Approve</button>
                                <?php endif; ?>
                            </div>
                            <div class="col-4">
                                <?php if (($invoice_main_data[0]['is_confirmed'] ?? '0') == '0'): ?>
                                <button type="button" class="btn btn-danger w-100" id="deniedJobcardBtn"
                                    style="border-radius: 12px;" onclick="deleteInvoice()">Delete</button>
                                <?php else: ?>
                                <button type="button" class="btn btn-danger w-100" id="deniedJobcardBtn"
                                    style="border-radius: 12px;" disabled>Delete</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light justify-content-center py-2 border-top">
                        <small class="text-muted">
                            <div id="jobcard_status_message" class="mt-2 fw-bold"></div>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <?php include "components/modal/payment/payment_content.php"; ?>
        <?php include "include/v2/footerbar.php"; ?>
    </div>
</div>
<?php include "include/v2/footerscripts.php"; ?>

<script>
function calculateTotalPayable() {
    const grandPrice = parseFloat(document.getElementById('grand_price_input').value) || 0;
    const advancePrice = parseFloat(document.getElementById('advance_price_input').value) || 0;

    const totalPayable = grandPrice - advancePrice;
    document.getElementById('total_payble_price').value = totalPayable.toFixed(2);

    const formatted = new Intl.NumberFormat('en-LK', {
        style: 'currency',
        currency: 'LKR',
        minimumFractionDigits: 2
    }).format(totalPayable).replace("LKR", "Rs.");

    document.getElementById('total_payble_price_show').textContent = formatted;
}
calculateTotalPayable();

document.getElementById('grand_price_input').addEventListener('input', calculateTotalPayable);
document.getElementById('advance_price_input').addEventListener('input', calculateTotalPayable);
</script>

<script>
function showJobCardStatusMessage() {
    const status = document.getElementById('approve_id').value;
    const messageDiv = document.getElementById('jobcard_status_message');

    if (status === '1') {
        messageDiv.textContent = "This Invoice is already Approved";
        messageDiv.classList.remove('text-danger');
        messageDiv.classList.add('text-success');
    } else {
        messageDiv.textContent = "";
        messageDiv.classList.remove('text-success', 'text-danger');
    }
}

showJobCardStatusMessage();
</script>
<script>
function createInvoice() {
    let jobtable_data = [];
    let charge_details = [];

    let invoice_record_id = $('#invoice_record_id').val();
    let main_insert_status = "<?php echo $is_edit? 'edit' : 'insert';?>";

    $('#tableorder tbody tr').each(function() {
        jobtable_data.push({
            item_id: $(this).find('.item_id').text().trim(),
            item_name: $(this).find('td:eq(0)').text().trim(),
            qty: parseFloat($(this).find('td:eq(1)').text()) || 0,
            unit: $(this).find('td:eq(2)').text().trim(),
            price: parseFloat($(this).find('td:eq(3)').text()) || 0,
            sub_total: parseFloat($(this).find('.sub_total').text()) || 0,
            discount_percent: parseFloat($(this).find('td:eq(5)').text().replace('%', '')) || 0,
            discount_amount: parseFloat($(this).find('.discount_amount').text().replace('%', '')) || 0,
            total_after_discount: parseFloat($(this).find('.total_after_discount').text()) || 0,
            tax: parseFloat($(this).find('td:eq(8)').text()) || 0,
            total_after_tax: parseFloat($(this).find('.total_after_tax').text()) || 0,
            insert_status: $(this).find('.insert_status').text().trim(),
            row_id: $(this).find('.row_id').text().trim(),
        });
    });

    $('#chargetableorder tbody tr').each(function() {
        charge_details.push({
            charge_type: $(this).find('td[name="chargetype"]').text().trim(),
            charge_amount: parseFloat($(this).find('td[name="chargeamount"]').text()) || 0,
            insert_status: $(this).find('.insert_status').text().trim(),
            row_id: $(this).find('.row_id').text().trim(),
        });
    });

    let invoiceMeta = {
        invoice_record_id: invoice_record_id,
        main_insert_status: main_insert_status,
        date: $('#date').val(),
        invoice_type: <?= json_encode($invoice_type); ?>,
        job_card_id: $('#job_card_number').val(),
        job_card_no: $('#job_card_number option:selected').text(),
        customer_id: $('#customer_id').val(),
        customer_name: $('#customer_name').val(),
        vehicle_no: $('#vehicle_no').val(),
        vat_reg_no: $('#vat_reg_no').val(),
        vehicle_in_date: $('#vehicle_in_date').val(),
        customer_address: $('#customer_address').val(),
        contact_no: $('#customer_contact').val(),
        // payment_type: $('#payment_type').val(),
        sub_total: parseFloat($('#total_sub_amount').val()) || 0,
        discount_pc: 0,
        discount_amount: parseFloat($('#total_discount').val()) || 0,
        vat: parseFloat($('#vat').val()) || 0,
        vat_amount: parseFloat($('#vatamount').val()) || 0,
        total_payment: parseFloat($('#modeltotalpayment').val()) || 0,
        remark: $('#remark').val(),
        company_id: "<?php echo ucfirst($_SESSION['company_id']); ?>",
        branch_id: "<?php echo ucfirst($_SESSION['branch_id']); ?>"
    };

    let invoiceData = {
        invoice_meta: invoiceMeta,
        items: jobtable_data,
        items_total: $('#hidetotalorder').val(),
        charges: charge_details,

        charges_total: $('#hidechargestotal').val()
        payment_data: payment_parsed_data,

    };


    console.log(invoiceData);

    if (!jobtable_data || Object.keys(jobtable_data).length === 0) {
        alert('Invoice data is missing.');
        return false;
    }



    const btn = document.getElementById('btncreateorder');
    btn.disabled = true;
    btn.innerHTML =
        `Creating <span class="spinner-border spinner-border-sm ml-2" role="status" aria-hidden="true"></span>`;

    $.ajax({
        type: "POST",
        dataType: 'json',
        data: {
            recordID: invoice_record_id,
            main_insert_status: main_insert_status,
            invoiceData: invoiceData
        },
        url: '<?php echo base_url() ?>Invoice/insertORUpdateInvoice',
        success: function(result) {
            if (result.status == true) {
                success_toastify(result.message);
                btn.disabled = false;
                btn.innerHTML = `Update Invoice <i class="fas fa-plus-circle ml-2"></i>`;
                setTimeout(function() {
                    window.location.href = '<?= base_url("Invoice/invoiceDetailIndex/") ?>' + result
                        .data;
                }, 500)
            } else {
                falseResponse(result);
                btn.disabled = false;
                btn.innerHTML = `Update Invoice <i class="fas fa-plus-circle ml-2"></i>`;
            }
        }
    });
}

// Approve invoice

function approveInvoice() {

    const approveData = {
        id: $('#invoice_id').val()
    };

    console.log("Collected Approve Data:", approveData);

    $.ajax({
        url: '<?php echo base_url() ?>Invoice/approveInvoice',
        type: 'POST',
        dataType: 'json',
        data: approveData,
        success: function(result) {
            if (result.status == true) {
                success_toastify(result.message);
                setTimeout(function() {
                    window.location.href = '<?= base_url("Invoice/invoiceDetailIndex/") ?>' +
                        approveData.id;
                }, 1000);
            } else {
                falseResponse(result);
            }
        }
    });

}

// Delete invoice

function deleteInvoice() {

    const approveData = {
        id: $('#invoice_id').val()
    };

    console.log("Collected Delete Data:", approveData);

    $.ajax({
        url: '<?php echo base_url() ?>Invoice/deleteInvoice',
        type: 'POST',
        dataType: 'json',
        data: approveData,
        success: function(result) {
            if (result.status == true) {
                success_toastify(result.message);
                setTimeout(function() {
                    window.location.href = '<?= base_url('Invoice') ?>';
                }, 1000);
            } else {
                falseResponse(result);
            }
        }
    });
}


function exportJobCardInvoice(jobcard_id) {
    const baseUrl = "<?php echo base_url(); ?>JobCard/jobInvoicePDF";
    const url = `${baseUrl}?jobcard_id=${encodeURIComponent(jobcard_id)}`;
    window.open(url, '_blank');
}

function selectInvoiceType(type) {
    const baseUrl = "<?= base_url('Invoice/invoiceDetailIndex/') ?>";
    window.location.href = baseUrl + type;
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
<?php include "include/v2/footer.php"; ?>