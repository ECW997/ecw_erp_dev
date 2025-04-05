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
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <div class="row d-flex align-items-center">
                            <div class="col-4"><h1 class="page-header-title">Job Card</h1></div>
                            <div class="col-2"><h2 class="job-header-title" id="top_nav_customer_name">Mr. Harshana Lakmal </h2></div>
                            <div class="col-2"><h2 class="job-header-title" id="top_nav_vehicle_no">CAB-4455</h2></div>
                            <div class="col-2"><h2 class="job-header-title" id="top_nav_vehicle">Toyota - Prado</h2></div>
                            <div class="col-2"><h2 class="job-header-title text-primary" id="top_nav_job_card_no">JCN-2503-1012</h2></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row mb-3">
                        	<div class="col-md-6 col-sm-12">
                        		<div class="row justify-content-start mx-auto">
                        			<div class="col-2 d-grid">
                        				<button type="button" class="btn btn-primary btn-sm rounded-2" data-bs-toggle="modal" data-bs-target="#selectCustomerInquiryModal"><i class="fas fa-plus-circle me-2"></i>New Job Card</button>
                        			</div>
                        			<div class="col-2 d-grid">
                        				<button type="button" class="btn btn-primary btn-sm rounded-2"><i class="fas fa-tags me-2"></i>Discount</button>
                        			</div>
                        			<div class="col-2 d-grid">
                        				<button type="button" class="btn btn-primary btn-sm rounded-2"><i class="fas fa-check-circle me-2"></i>Approve</button>
                        			</div>
                        			<div class="col-2 d-grid">
                        				<button type="button" class="btn btn-primary btn-sm rounded-2"><i class="fas fa-print me-2"></i>Print</button>
                        			</div>
                        		</div>
                        	</div>
                        </div>
                        <div class="row mb-3">
                            <div class="div" id="jobCardContent">
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
  nic: "",
  contact: "",
  inquiry_id: "",
  inquiry_no: "",
  inquiry_date: "",
  vehicle_no: "",
  vehicle_brand: "",
  vehicle_model: "",
  vehicle_type: "",
  vehicle_gen: "",
  vehicle_year: "",
  price_category: "",
  sales_person_name: ""
};

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