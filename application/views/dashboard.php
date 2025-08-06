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
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <h1 class="page-header-title ">
                                    <div class="page-header-icon"><i class="fas fa-laptop"></i></div>
                                    <span>Dashboard</span>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-3">
    <div class="row">
        <!-- Dashboard Cards -->
        <div class="col-md-3">
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
    </div>

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

<?php include "include/footer.php"; ?>