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
                                    <?= $job_main_data[0]['customer_name'] ?? '' ?>
                            </div>
                            <div class="col-2">
                                <h2 class="job-header-title" id="top_nav_vehicle_no">
                                    <?= $job_main_data[0]['vehicle_number'] ?? '' ?></h2>
                            </div>
                            <div class="col-2">
                                <h2 class="job-header-title" id="top_nav_vehicle">
                                    <?= $job_main_data[0]['brand_name'] ?? '' ?> -
                                    <?= $job_main_data[0]['model_name'] ?? '' ?></h2>
                            </div>
                            <div class="col-2">
                                <h2 class="job-header-title text-primary" id="top_nav_job_card_no">
                                    <?= $job_main_data[0]['job_card_number'] ?? '' ?></h2>
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
                            <?php
                                // include "components/modal/invoice/direct_invoice_content_header.php";
                                include "components/modal/invoice/jobcard_invoice_content_header.php";
                                include "components/modal/invoice/invoice_content.php";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <!-- Invoice Type Modal -->
        <div class="modal fade" id="invoiceTypeModal" tabindex="-1" aria-labelledby="invoiceTypeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h5 class="modal-title" id="invoiceTypeModalLabel">Invoice Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <button type="button" class="btn btn-primary btn-sm mb-2 w-100" id="btnDirectInvoice">
                            Direct Invoice
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm w-100" id="btnJobCardInvoice">
                            Job Card Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>



        <?php include "include/v2/footerbar.php"; ?>
    </div>
</div>
<?php include "include/v2/footerscripts.php"; ?>


<script>
const customerData = {
    name: "",
    email: "",
    address1: "",
    address2: "",
    city: "",
    district: "",
    nic: "",
    contact: "",
    contact2: "",
    dob: "",
    inquiry_id: "",
    inquiry_no: "",
    inquiry_date: "",
    vehicle_no: "",
    vehicle_brand: "",
    vehicle_brand_id: "",
    vehicle_model: "",
    vehicle_model_id: "",
    vehicle_type: "",
    vehicle_type_id: "",
    vehicle_gen: "",
    vehicle_gen_id: "",
    vehicle_year: "",
    vehicle_year_id: "",
    price_category: "",
    sales_person_name: "",
    schedule_date: "",
    handover_date: "",
    days: "",
    status: "",
    company_id: "<?php echo ucfirst($_SESSION['company_id']); ?>",
    branch_id: "<?php echo ucfirst($_SESSION['branch_id']); ?>"
};

$(document).ready(function() {


});


function exportJobCardPDF(jobcard_id) {
    const baseUrl = "<?php echo base_url(); ?>JobCard/jobCardPDF";
    const url = `${baseUrl}?jobcard_id=${encodeURIComponent(jobcard_id)}`;
    window.open(url, '_blank');
}

function exportJobCardSummary(jobcard_id) {
    const baseUrl = "<?php echo base_url(); ?>JobCard/jobSummaryPDF";
    const url = `${baseUrl}?jobcard_id=${encodeURIComponent(jobcard_id)}`;
    window.open(url, '_blank');
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