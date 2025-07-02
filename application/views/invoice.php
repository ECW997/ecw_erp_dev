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
        <?php include "include/v2/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-gray shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-1">
                        <div class="row d-flex align-items-center">
                            <div class="col-4">
                                <h1 class="page-header-title">Invoice</h1>
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
                                <button type="button" class="btn btn-primary btn-sm rounded-2 action-btn" 
                                        data-bs-toggle="modal" data-bs-target="#invoiceTypeModal">
                                    <i class="fas fa-plus me-1"></i> New Invoice
                                </button>
                                
                                <button type="button" class="btn btn-success btn-sm rounded-2 action-btn" 
                                        data-bs-toggle="modal" data-bs-target="#jobcardApproveModel">
                                    <i class="fas fa-check me-1"></i> Approve
                                </button>
                                
                                <button type="button" class="btn btn-info btn-sm rounded-2 action-btn" 
                                        onclick="exportJobCardInvoice(<?= $job_main_data[0]['idtbl_jobcard'] ?? '' ?>);">
                                    <i class="fas fa-print me-1"></i> Print Invoice
                                </button>
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

        <div class="modal fade" id="invoiceTypeModal" tabindex="-1" aria-labelledby="invoiceTypeModalLabel"
        	aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        	<div class="modal-dialog modal-sm modal-dialog-centered">
        		<div class="modal-content border-0" style="box-shadow: 0 5px 20px rgba(0,0,0,0.15);">
        			<div class="modal-header bg-primary text-white p-3">
        				<div class="w-100 text-center">
        					<i class="fas fa-file-invoice fa-2x mb-2"></i>
        					<h5 class="modal-title fs-5 fw-bold mb-0" id="invoiceTypeModalLabel">
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

        <?php include "include/v2/footerbar.php"; ?>
    </div>
</div>
<?php include "include/v2/footerscripts.php"; ?>


<script>

function createInvoice() {
    let jobtable_data = [];
    let charge_details = [];

    let invoice_record_id = $('#invoice_record_id').val();
    let main_insert_status = "<?php echo $is_edit? 'edit' : 'insert';?>";

    $('#tableorder tbody tr').each(function () {
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

    $('#chargetableorder tbody tr').each(function () {
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
        payment_type: $('#payment_type').val(),
        sub_total: parseFloat($('#hiddenfulltotal').val()) || 0,
        discount_pc: 0,
        discount_amount: 0,
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
    };

    console.log(invoiceData); 

    if (!jobtable_data || Object.keys(jobtable_data).length === 0) {
        alert('Invoice data is missing.');
        return false;
    }

    let payment_type = $('#payment_type').val();
    if(payment_type ==''){
         alert('Payment Type Not Selected!');
        $('#payment_type').focus();
        return false;
    }

    const btn = document.getElementById('btncreateorder');
    btn.disabled = true;
    btn.innerHTML = `Creating <span class="spinner-border spinner-border-sm ml-2" role="status" aria-hidden="true"></span>`;

    $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                recordID:invoice_record_id,
                main_insert_status:main_insert_status,
                invoiceData: invoiceData
            },
            url: '<?php echo base_url() ?>Invoice/insertORUpdateInvoice',
            success: function(result) {
                if (result.status == true) {
                        success_toastify(result.message);
                        btn.disabled = false;
                        btn.innerHTML = `Update Invoice <i class="fas fa-plus-circle ml-2"></i>`;
                        setTimeout(function() {
                            window.location.href = '<?= base_url("Invoice/invoiceDetailIndex/") ?>' + result.data;
                        }, 500)
                } else {
                    falseResponse(result);
                    btn.disabled = false;
                    btn.innerHTML = `Update Invoice <i class="fas fa-plus-circle ml-2"></i>`;
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