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
                                <h1 class="page-header-title">Job Card</h1>
                            </div>
                            <div class="col-2">
                                <h2 class="job-header-title">Mr. Harshana Lakmal </h2>
                            </div>
                            <div class="col-2">
                                <h2 class="job-header-title">CAB-4455</h2>
                            </div>
                            <div class="col-2">
                                <h2 class="job-header-title">Toyota - Prado</h2>
                            </div>
                            <div class="col-2">
                                <h2 class="job-header-title text-primary">JCN-2503-1012</h2>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row mb-3">
                            <div class="col-5">
                                <div class="row g-2 justify-content-center">
                                    <div class="col-12 col-sm-6 col-md-3 d-grid">
                                        <button type="button" class="btn btn-primary btn-sm rounded-2 w-100"
                                            data-bs-toggle="modal" data-bs-target="#selectCustomerInquiryModal">
                                            <i class="fas fa-plus me-2"></i> New Job Card
                                        </button>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3 d-grid">
                                        <button type="button" class="btn btn-primary btn-sm rounded-2 w-100">
                                            <i class="fa fa-percent me-2"></i> Discounts
                                        </button>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3 d-grid">
                                        <button type="button" class="btn btn-primary btn-sm rounded-2 w-100">
                                            <i class="fas fa-check me-2"></i> Approve
                                        </button>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3 d-grid">
                                        <button type="button" class="btn btn-primary btn-sm rounded-2 w-100">
                                            <i class="fas fa-print me-2"></i> Print
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

        <?php include "include/v2/footerbar.php"; ?>
    </div>
</div>
<?php include "include/v2/footerscripts.php"; ?>


<script>
$(document).ready(function() {
    $.ajax({
        url: apiBaseUrl + '/v1/main_job_category',
        type: "GET",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + api_token
        },
        success: function(json) {
            console.log("API Response:", json);

            if (json.status === false && json.code === 401) {
                falseResponse(errorObj);
                return;
            }
            let data = json.data;
            $('#buttonsContainer').empty();

            // Loop and create buttons
            data.forEach(function(job) {
                var buttonHtml = `
                    <div class="col-6 mb-3">
                        <button type="button"
                            class="btn btn-info rounded-3 w-100 btn-sm d-flex align-items-center justify-content-start"
                            style="padding-left: 20px;">
                            <i class="fas fa-plus-circle me-2"></i>${job.name}
                        </button>
                    </div>
                `;
                $('#buttonsContainer').append(buttonHtml);
            });
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            alert('Failed to load main job categories.');
        }
    });
});


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