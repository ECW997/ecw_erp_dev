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
                                <div class="flex space-x-4 mb-4">
      <button class="bg-gray-300 text-black rounded px-3 py-1 text-sm font-normal">New</button>
      <button class="bg-gray-300 text-black rounded px-3 py-1 text-sm font-normal">Approve</button>
      <button class="bg-gray-300 text-black rounded px-3 py-1 text-sm font-normal">Print</button>
    </div>
    <hr class="border-gray-300 mb-6" />
    <form>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 mb-8">
        <div>
          <div class="flex items-center space-x-2 mb-3">
            <label for="jobCardNumber" class="w-36 text-sm">Job Card Number</label>
            <input id="jobCardNumber" type="text" value="JC-01204" readonly class="border border-gray-300 rounded px-2 py-1 text-sm font-semibold w-40" />
            <button type="button" class="bg-gray-300 rounded px-2 py-1 text-sm font-normal">...</button>
          </div>
          <div class="flex items-center space-x-2 mb-3">
            <label for="customer" class="w-36 text-sm">Customer:</label>
            <input id="customer" type="text" class="border border-gray-300 rounded px-2 py-1 text-sm w-full" />
          </div>
          <div>
            <label for="address" class="w-36 text-sm inline-block mb-1">Address:</label>
            <input id="address" type="text" class="border border-gray-300 rounded px-2 py-1 text-sm w-full mb-1" />
            <input type="text" class="border border-gray-300 rounded px-2 py-1 text-sm w-full" />
          </div>
        </div>
        <div>
          <div class="flex items-center space-x-2 mb-3">
            <label for="vehicleDetails" class="w-36 text-sm">Vehicle Details:</label>
            <input id="vehicleDetails" type="text" class="border border-gray-300 rounded px-2 py-1 text-sm w-full" />
          </div>
          <div class="flex items-center space-x-2">
            <label for="jobDetails" class="w-36 text-sm">Job Details:</label>
            <input id="jobDetails" type="text" class="border border-gray-300 rounded px-2 py-1 text-sm w-full" />
          </div>
        </div>
      </div>
      <table class="w-full border-collapse border border-gray-300 text-sm">
        <thead>
          <tr>
            <th class="border-r border-gray-300 text-left px-2 py-1">Description</th>
            <th class="border-r border-gray-300 text-left px-2 py-1 w-16">Qty</th>
            <th class="border-r border-gray-300 text-left px-2 py-1 w-20">Price</th>
            <th class="border-r border-gray-300 text-left px-2 py-1 w-20">Discount</th>
            <th class="border-r border-gray-300 text-left px-2 py-1 w-20">Tax</th>
            <th class="text-left px-2 py-1 w-24">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr class="h-48">
            <td class="border-r border-gray-300 align-top px-2 py-1"></td>
            <td class="border-r border-gray-300 align-top px-2 py-1"></td>
            <td class="border-r border-gray-300 align-top px-2 py-1"></td>
            <td class="border-r border-gray-300 align-top px-2 py-1"></td>
            <td class="border-r border-gray-300 align-top px-2 py-1"></td>
            <td class="align-top px-2 py-1"></td>
          </tr>
        </tbody>
      </table>
    </form>
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
    sales_person_name: "",
    schedule_date: "",
    handover_date: "",
    days: "",
    status: "",
    company_id: "<?php echo ucfirst($_SESSION['company_id']); ?>",
    branch_id: "<?php echo ucfirst($_SESSION['branch_id']); ?>"
};

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
            if (json.status === false && json.code === 401) {
                falseResponse(errorObj);
                return;
            }
            let data = json.data;
            $('#buttonsContainer').empty();

            data.forEach(function(job) {
                var buttonHtml = `
                    <div class="col-6 mb-3">
                        <button type="button"
                            class="btn btn-info rounded-3 w-100 btn-sm d-flex align-items-center justify-content-start"
                            style="padding-left: 20px;"
                            data-id="${job.id}"
                            data-name="${job.name}" onclick="showAddJobItemModal(this);">
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