<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>


<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php 
        include "include/menubar.php";
         ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <h1 class="page-header-title d-flex align-items-center mb-0">
                                    <div class="page-header-icon me-2"><i class="fas fa-laptop"></i></div>
                                    <span>Dashboard</span>
                                </h1>
                                <button type="button" id="btnBackup" class="btn btn-primary secure_section d-none">
                                    <i class="fas fa-database mr-2"></i> Backup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-3">
                <div class="card" style="background-color: #fdfafaff;">
                    <div class="card-body watermarked-card">
                        <div class="card-body p-0 p-2">
                            <div class="row">

                                <!-- Total Inquiry  -->

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <div class="card-dash" id="total_inquiryCard"
                                        style="border-bottom: 5px solid #0061f2; border-radius: 18 18 18px 18px;">
                                        <div class="row no-gutters h-100">
                                            <div class="col">
                                                <div class="card-body p-0 px-3 py-4 text-left">
                                                    <h3 class="card-title text-primary m-0 font-weight-bold"
                                                        style="font-size: 1.2rem;">
                                                        <a class="text-dark" href="#"> Job Card
                                                            (75)
                                                        </a>

                                                    </h3>
                                                    <span class="badge badge-pill badge-success mt-2">Updated</span>
                                                </div>
                                            </div>
                                            <div class="col-auto p-3 text-primary">
                                                <lord-icon src="https://cdn.lordicon.com/hnqamtrw.json" trigger="loop"
                                                    delay="2000" colors="primary:#3080e8,secondary:#ffffff"
                                                    style="width:75px;height:75px">
                                                </lord-icon>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Appointments  -->

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <div class="card-dash" id="lowstockCard"
                                        style="border-bottom: 5px solid #17a2b8; border-radius: 18 18 18px 18px;">
                                        <div class="row no-gutters h-100">
                                            <div class="col">
                                                <div class="card-body p-0 px-3 py-4 text-left">
                                                    <h3 class="card-title text-info m-0 font-weight-bold"
                                                        style="font-size: 1.2rem;">
                                                        <a class="text-dark" href="#"> Invoice
                                                            (35)
                                                        </a>
                                                    </h3>
                                                    <span class="badge badge-pill badge-success mt-2">Updated</span>
                                                </div>
                                            </div>
                                            <div class="col-auto p-3 text-info">
                                                <lord-icon src="https://cdn.lordicon.com/tobsqthh.json" trigger="loop"
                                                    delay="2000"
                                                    colors="primary:#66d7ee,secondary:#ffffff,tertiary:#000000"
                                                    style="width:75px;height:75px">
                                                </lord-icon>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Total Non-Appointment  -->

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <div class="card-dash" id="sparepartsCard"
                                        style="border-bottom: 5px solid #f4a100; border-radius: 18 18 18px 18px;">
                                        <div class="row no-gutters h-100">
                                            <div class="col">
                                                <div class="card-body p-0 px-3 py-4 text-left">
                                                    <h3 class="card-title text-warning m-0 font-weight-bold">
                                                    </h3>
                                                    <span class="badge badge-pill badge-success mt-2">Updated</span>
                                                </div>
                                            </div>
                                            <div class="col-auto p-3 text-warning">
                                                <lord-icon src="https://cdn.lordicon.com/tobsqthh.json" trigger="loop"
                                                    delay="2000"
                                                    colors="primary:#f4a100,secondary:#ffffff,tertiary:#000000"
                                                    style="width:75px;height:75px">
                                                </lord-icon>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Total Cancel Inquiry  -->

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <div class="card-dash" id="matchineCard"
                                        style="border-bottom: 5px solid #e81500; border-radius: 18 18 18px 18px;">
                                        <div class="row no-gutters h-100">
                                            <div class="col">
                                                <div class="card-body p-0 px-3 py-4 text-left">
                                                    <h3 class="card-title text-danger m-0 font-weight-bold">
                                                    </h3>
                                                    <span class="badge badge-pill badge-success mt-2">Updated</span>
                                                </div>
                                            </div>
                                            <div class="col-auto p-3 text-danger">
                                                <lord-icon src="https://cdn.lordicon.com/bjdrneur.json" trigger="loop"
                                                    delay="2000" colors="primary:#ffffff,secondary:#e83a30"
                                                    style="width:75px;height:75px">
                                                </lord-icon>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Total Complete follow-up Inquiry  -->

                                <!-- <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <div class="card-dash" id="materalCard"
                                        style="border-bottom: 3px solid #dee2e6; border-radius: 18 18 18px 18px;">
                                        <div class="row no-gutters h-100">
                                            <div class="col">
                                                <div class="card-body p-0 px-3 py-4 text-left">
                                                    <h3 class="card-title text-dark m-0 font-weight-bold">
                                                    </h3>
                                                    <span class="badge badge-pill badge-success mt-2">Updated</span>
                                                </div>
                                            </div>
                                            <div class="col-auto p-3 text-gray">
                                                <lord-icon src="https://cdn.lordicon.com/abhwievu.json" trigger="loop"
                                                    colors="primary:#e8308c,secondary:#ffffff,tertiary:#ffffff,quaternary:#ffffff"
                                                    style="width:75px;height:75px">
                                                </lord-icon>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->


                                <!-- Total Job Done Inquiry  -->

                                <!-- <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <div class="card-dash" id="materiaCard"
                                        style="border-bottom: 3px solid #00ac69; border-radius: 18 18 18px 18px;">
                                        <div class="row no-gutters h-100">
                                            <div class="col">
                                                <div class="card-body p-0 px-3 py-4 text-left">
                                                    <h3 class="card-title text-success m-0 font-weight-bold">

                                                    </h3>
                                                    <span class="badge badge-pill badge-success mt-2">Updated</span>
                                                </div>
                                            </div>
                                            <div class="col-auto p-3 text-success">
                                                <lord-icon src="https://cdn.lordicon.com/hrtsficn.json" trigger="loop"
                                                    delay="2000" colors="primary:#16c72e"
                                                    style="width:75px;height:75px">
                                                </lord-icon>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->


                                <!-- Total Transfer Inquiry  -->

                                <!-- <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <div class="card-dash" id="materiaCard"
                                        style="border-bottom: 3px solid #6900c7; border-radius: 18 18 18px 18px;">
                                        <div class="row no-gutters h-100">
                                            <div class="col">
                                                <div class="card-body p-0 px-3 py-4 text-left">
                                                    <h3 class="card-title text-purple m-0 font-weight-bold">

                                                    </h3>
                                                    <span class="badge badge-pill badge-success mt-2">Updated</span>
                                                </div>
                                            </div>
                                            <div class="col-auto p-3">
                                                <lord-icon src="https://cdn.lordicon.com/xfdmycri.json" trigger="loop"
                                                    delay="2000" colors="primary:#7166ee"
                                                    style="width:75px;height:75px">
                                                </lord-icon>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->


                                <!-- Total Complaint  -->

                                <!-- <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <div class="card-dash" id="materialCrd"
                                        style="border-bottom: 3px solid #f76400 ; border-radius: 18 18 18px 18px;">
                                        <div class="row no-gutters h-100">
                                            <div class="col">
                                                <div class="card-body p-0 px-3 py-4 text-left">
                                                    <h3 class="card-title text-orange m-0 font-weight-bold">

                                                    </h3>
                                                    <span class="badge badge-pill badge-success mt-2">Updated</span>
                                                </div>
                                            </div>
                                            <div class="col-auto p-3">
                                                <lord-icon src="https://cdn.lordicon.com/jrvgxhep.json" trigger="loop"
                                                    style="width:75px;height:75px">
                                                </lord-icon>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row"> -->
                <!-- Dashboard Cards -->
                <!-- <div class="col-md-3">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Sales</h5>
                                <h2>$12,345</h2>
                                <p class="card-text">Updated Today</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Orders</h5>
                                <h2>1,234</h2>
                                <p class="card-text">This Month</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Active Users</h5>
                                <h2>567</h2>
                                <p class="card-text">Last 24 Hours</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Revenue</h5>
                                <h2>$8,765</h2>
                                <p class="card-text">This Quarter</p>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Sales Chart -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Sales Overview</h5>
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Recent Orders</h5>
                                <ul class="list-group">
                                    <li class="list-group-item">Order #1001 - $120</li>
                                    <li class="list-group-item">Order #1002 - $340</li>
                                    <li class="list-group-item">Order #1003 - $75</li>
                                    <li class="list-group-item">Order #1004 - $210</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>


<?php include "include/footerscripts.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


<script>
$(document).ready(function() {
    const greetingMessage = "<?php echo $this->session->flashdata('greeting_message'); ?>";
    if (greetingMessage) {
        Toastify({
            text: greetingMessage,
            duration: 5000, // 5 seconds
            close: true,
            gravity: "top", // Position at the top
            position: "right", // Align to the right
            backgroundColor: "linear-gradient(to right, #28a745, #218838)", // Green gradient
            style: {
                color: "#fff", // White text color for contrast
                fontSize: "16px",
                borderRadius: "15px", // Rounded corners
                padding: "18px 30px",
                boxShadow: "0px 4px 8px rgba(0, 0, 0, 0.2)" // Soft shadow
            },
        }).showToast();
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('salesChart').getContext('2d');
var salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Sales ($)',
            data: [1200, 1900, 3000, 5000, 2000, 3000],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script>
    $(document).ready(function() {
        let typed = "";
        $(document).on("keydown", function (e) {
            typed += e.key.toLowerCase();

            if (typed.includes("show")) {
                $(".secure_section").removeClass("d-none");
                typed = ""; 
            }
            if (typed.includes("hide")) {
                $(".secure_section").addClass("d-none");
                typed = ""; 
            }
            if (typed.length > 10) typed = typed.slice(-10);
        });
    });

    $('#btnBackup').on('click', function() {
        if (!confirm('⚠️ Are you sure you want to back up the database?')) {
            return; 
        }
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Backing up...');

        $.ajax({
            url: apiBaseUrl + '/v1/backup_database',
            type: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + api_token
            },
            success: function(response) {
                if (response.status) {
                    success_toastify(response.message || 'Database backup completed successfully.');
                } else {
                    error_toastify(response.message || 'Backup failed.');
                }
            },
            error: function(xhr, status, error) {
                error_toastify('Backup request failed: ' + error);
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="fas fa-database me-1"></i> Backup');
            }
        });
    });
</script>

<?php include "include/footer.php"; ?>