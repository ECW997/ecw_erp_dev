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
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <style>
        .main-group-menu {
            display: inline-block;
            width: 180px;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        </style>
        <main>
            <div class="page-header page-header-light bg-gray shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-1">
                        <div class="row d-flex align-items-center">
                            <div class="col-2">
                                <h1 class="page-header-title">Job Card</h1>
                            </div>
                            <div class="col-2 text-end">
                                <h2 class="job-header-title" id="top_nav_customer_name">
                                    <?= $job_main_data[0]['customer_name'] ?? '' ?>
                            </div>
                            <div class="col-2 text-end">
                                <h2 class="job-header-title" id="top_nav_vehicle_no">
                                    <?= $job_main_data[0]['vehicle_number'] ?? '' ?></h2>
                            </div>
                            <div class="col-2 text-end">
                                <h2 class="job-header-title" id="top_nav_vehicle">
                                    <?= $job_main_data[0]['brand_name'] ?? '' ?> -
                                    <?= $job_main_data[0]['model_name'] ?? '' ?></h2>
                            </div>
                            <div class="col-2 text-end">
                                <h2 class="job-header-title text-primary" id="top_nav_job_card_no">
                                    <?= $job_main_data[0]['job_card_number'] ?? '' ?></h2>
                            </div>
                            <div class="col-2 text-end">
                                <button type="button" class="btn btn-warning rounded-2 action-btn px-3 py-2 fs-6"
                                    onclick="window.location.href='<?= base_url('JobCard') ?>'">
                                    <i class="fas fa-arrow-left me-1 text-dark"></i>
                                    <i class="fas fa-file-invoice me-1 text-dark"></i>
                                    <span class="text-dark fw-bold">Job Card List</span>
                                </button>
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
                                <?php $is_confirmed = $job_main_data[0]['approve_request_status'] ?? 0; ?>
                                <div class="row g-2 p-3">
                                    <div class="col-12 col-sm-6 col-md-2 d-grid">
                                        <button type="button" class="btn btn-primary btn-sm rounded-2 w-100"
                                            data-bs-toggle="modal" data-bs-target="#selectCustomerInquiryModal">
                                            <i class="fas fa-plus me-2"></i> New Job Card
                                        </button>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-2 d-grid">
                                        <button type="button"
                                            class="btn btn-primary btn-sm rounded-2 w-100 openJobCardDiscountModal"
                                            data-bs-toggle="modal" data-bs-target="#jobcarddiscountModel">
                                            <i class="fa fa-percent me-2"></i> Discounts
                                        </button>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-2 d-grid">
                                        <button type="button" class="btn btn-primary btn-sm rounded-2 w-100"
                                            data-bs-toggle="modal" data-bs-target="#jobcardApproveModel">
                                            <i class="fas fa-check me-2"></i> Approve
                                        </button>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-2 d-grid">
                                        <button type="button" class="btn btn-primary btn-sm rounded-2 w-100" <?= $is_confirmed == 2 ? '' : 'disabled' ?>
                                            onclick="exportJobCardSummary(<?= $job_main_data[0]['idtbl_jobcard'] ?? '' ?>);">
                                            <i class="fas fa-print me-2"></i>Job Summary Print
                                        </button>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-2 d-grid">
                                        <button type="button" class="btn btn-primary btn-sm rounded-2 w-100" <?= $is_confirmed == 2 ? '' : 'disabled' ?>
                                            onclick="exportJobCardPDF(<?= $job_main_data[0]['idtbl_jobcard'] ?? '' ?>);">
                                            <i class="fas fa-print me-2"></i>JobCard Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div id="jobCardContent">
                                <?php include "components/modal/job_card/job_card_content.php"; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php include "components/modal/job_card/select_customer_inquiry.php"; ?>
        <?php include "components/modal/job_card/job_header.php"; ?>
        <?php include "components/modal/job_card/add_job_item.php"; ?>
        <?php include "components/modal/job_card/job_card_approval.php"; ?>
        <?php include "components/modal/job_card/job_card_header_discount.php"; ?>

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
    price_category_name: "",
    sales_person_name: "",
    schedule_date: "",
    handover_date: "",
    days: "",
    status: "",
    company_id: "<?php echo ucfirst($_SESSION['company_id']); ?>",
    branch_id: "<?php echo ucfirst($_SESSION['branch_id']); ?>"
};

$(document).ready(function() {

    // $.ajax({
    //     url: apiBaseUrl + '/v1/main_job_category',
    //     type: "GET",
    //     headers: {
    //         'Accept': 'application/json',
    //         'Content-Type': 'application/json',
    //         'Authorization': 'Bearer ' + api_token
    //     },
    //     success: function(json) {
    //         if (json.status === false && json.code === 401) {
    //             falseResponse(errorObj);
    //             return;
    //         }
    //         let data = json.data;
    //         $('#buttonsContainer').empty();

    //         data.forEach(function(job) {
    //             var buttonHtml = `
    //                 <div class="col-6 mb-3">
    //                     <button type="button"
    //                         class="btn btn-info rounded-3 w-100 btn-sm d-flex align-items-center justify-content-start"
    //                         style="padding-left: 20px;"
    //                         data-id="${job.id}"
    //                         data-name="${job.name}" onclick="showAddJobItemModal(this);">
    //                         <i class="fas fa-plus-circle me-2"></i>${job.name}
    //                     </button>
    //                 </div>
    //             `;
    //             $('#buttonsContainer').append(buttonHtml);
    //         });
    //     },
    //     error: function(xhr, status, error) {
    //         console.error("AJAX Error:", error);
    //         alert('Failed to load main job categories.');
    //     }
    // });



    $.ajax({
        url: apiBaseUrl + '/v1/main_category_group',
        type: "GET",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + api_token
        },
        success: function(json) {
            $('#mainCategoryGroupMenu').empty();
            json.data.forEach(group => {
                const groupId = group.id;
                const groupName = group.group_name;

                //             <a href="#"><span class="main-group-menu badge bg-dark text-white px-3 py-2 rounded-pill pointer"
                //      style="cursor:pointer; font-size:1rem;">
                //     ${groupName}
                // </span></a>

                const groupHtml = `
                             <li>
                             <a href="#">
                        <span class="main-group-menu badge bg-dark text-white px-3 py-2 rounded-pill pointer"
                            style="cursor:pointer; font-size:1rem;">
                            ${groupName}
                        </span>
                        </a>
                    <ul class="dropdown" id="dropdown-${groupId}">
                        <li><a href="#">Loading...</a></li>
                    </ul>
                </li>
            `;
                $('#mainCategoryGroupMenu').append(groupHtml);

                $.ajax({
                    url: apiBaseUrl + '/v1/main_group_assigned_job_categories/' +
                        groupId,
                    type: "GET",
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + api_token
                    },
                    success: function(res) {
                        const $dropdown = $(`#dropdown-${groupId}`);
                        $dropdown.empty();
                        if (res.status && res.main_job_categories.length > 0) {
                            res.main_job_categories.forEach(cat => {
                                $dropdown.append(`
                                <li>
                                    <a href="#" class="job-category-item" data-id="${cat.idtbl_main_job_category}">
                                        ${cat.main_job_category}
                                    </a>
                                </li>
                            `);
                            });
                        } else {
                            $dropdown.append(
                                `<li><a href="#" class="text-muted">No Categories</a></li>`
                            );
                        }
                    }
                });
            });
        }
    });


    $(document).on('click', '.job-category-item', function() {
        showAddJobItemModal(this);
    });



    $(document).on('click', '.openJobCardDiscountModal', function() {
        const jobcard_id = $('#jobcard_id').val();

        if (jobcard_id) {
            fetchJobCardDiscountDetails(jobcard_id);
            $('#jobcarddiscountModel').modal('show');
        } else {
            alert('Invalid Job Card ID.');
        }
    });
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

function fetchJobCardDiscountDetails(jobcard_id) {
    $.ajax({
        url: '<?= base_url("JobCard/getDiscount/") ?>' + jobcard_id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === true) {
                const data = response.data;

                $('#discount_precentage').val(data.discount || '');
                $('#discount_price').val(data.discount_amount || '');

                const standardPrice = parseFloat($('#standard_price').val()) || 0;
                const discountAmt = parseFloat(data.discount_amount) || 0;
                const net = standardPrice - discountAmt;



                // console.log("Standard Price:", standardPrice);
                // console.log("Discount Amount:", discountAmt);
                // console.log("Net Price:", net);

                $('#net_amount').val(net.toFixed(2));
                $('#total_discount').val(discountAmt.toFixed(2));

            } else {
                alert('Failed to fetch discount details.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
            alert('Something went wrong fetching discount data.');
        }
    });
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