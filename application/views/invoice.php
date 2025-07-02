<?php 
include "include/v2/header.php";  
include "include/v2/topnavbar.php"; 
?>
<?php
// Retrieve the customer_id from the URL
$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
?>
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
                            <div class="col-2">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row mb-3">
                            <div class="col-8">
                                <div class="row g-2 p-3">
                                    <div class="col-12 col-sm-6 col-md-2 d-grid">
                                        <button type="button" class="btn btn-primary btn-sm rounded-2 w-100"
                                            data-bs-toggle="modal" data-bs-target="#selectCustomerInquiryModal">
                                            <i class="fas fa-plus me-2"></i> New Invoice
                                        </button>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-2 d-grid">
                                        <button type="button" class="btn btn-primary btn-sm rounded-2 w-100"
                                            data-bs-toggle="modal" data-bs-target="#jobcardApproveModel">
                                            <i class="fas fa-check me-2"></i> Approve
                                        </button>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-2 d-grid">
                                        <button type="button" class="btn btn-primary btn-sm rounded-2 w-100"
                                            onclick="exportJobCardInvoice(<?= $job_main_data[0]['idtbl_jobcard'] ?? '' ?>);">
                                            <i class="fas fa-print me-2"></i>Invoice Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
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
        customer_name: $('#customer_name').val(),
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
        alert('❌ Invoice data is missing.');
        return false;
    }

    let payment_type = $('#payment_type').val();
    if(payment_type ==''){
         alert('⚠️ Payment Type Not Selected!');
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