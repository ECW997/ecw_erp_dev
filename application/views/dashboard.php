<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>

<?php

$company = $_SESSION['branch_id'];

// Total Inquiry
$sql = "SELECT COUNT(`idtbl_customer_inquiry`) AS stockcount 
        FROM `tbl_customer_inquiry` 
        WHERE `tbl_customer_inquiry`.`status` = 1 
        AND `tbl_customer_inquiry`.`company_branch_id` = ? 
        AND MONTH(`tbl_customer_inquiry`.`inquerydate`) = MONTH(CURDATE()) 
        AND YEAR(`tbl_customer_inquiry`.`inquerydate`) = YEAR(CURDATE())";
        
        $total_inquiry_info = $this->db->query($sql, array($company));

// Total Appointments
$sql = "SELECT COUNT(`idtbl_customer_inquiry`) AS stockcount 
        FROM `tbl_customer_inquiry` 
        WHERE `tbl_customer_inquiry`.`status` = 1 
        AND `tbl_customer_inquiry`.`company_branch_id` = ? 
        AND `tbl_customer_inquiry`.`cancel_status` = 0
        AND `tbl_customer_inquiry`.`appointment` = 1
        AND MONTH(`tbl_customer_inquiry`.`inquerydate`) = MONTH(CURDATE()) 
        AND YEAR(`tbl_customer_inquiry`.`inquerydate`) = YEAR(CURDATE())";

        $total_apointment_info = $this->db->query($sql, array($company));

// Total complete 
$sql = "SELECT COUNT(`idtbl_customer_inquiry`) AS stockcount 
        FROM `tbl_customer_inquiry` 
        WHERE `tbl_customer_inquiry`.`status` = 1 
        AND `tbl_customer_inquiry`.`company_branch_id` = ? 
        AND `tbl_customer_inquiry`.`third_follow_up` = 1
        AND MONTH(`tbl_customer_inquiry`.`inquerydate`) = MONTH(CURDATE()) 
        AND YEAR(`tbl_customer_inquiry`.`inquerydate`) = YEAR(CURDATE())";

        $complete_inquiry_info = $this->db->query($sql, array($company));

// Total Non-Appointments
$sql = "SELECT COUNT(`idtbl_customer_inquiry`) AS stockcount 
        FROM `tbl_customer_inquiry` 
        WHERE `tbl_customer_inquiry`.`status` = 1 
        AND `tbl_customer_inquiry`.`company_branch_id` = ? 
        AND `tbl_customer_inquiry`.`cancel_status` = 0
        AND `tbl_customer_inquiry`.`appointment` = 0
        AND MONTH(`tbl_customer_inquiry`.`inquerydate`) = MONTH(CURDATE()) 
        AND YEAR(`tbl_customer_inquiry`.`inquerydate`) = YEAR(CURDATE())";

$non_apointment_info = $this->db->query($sql, array($company));

// Total Cancel_inquiry
$sql = "SELECT COUNT(`idtbl_customer_inquiry`) AS stockcount 
        FROM `tbl_customer_inquiry` 
        WHERE `tbl_customer_inquiry`.`status` = 1 
        AND `tbl_customer_inquiry`.`company_branch_id` = ? 
        AND `tbl_customer_inquiry`.`cancel_status` = 1
        AND MONTH(`tbl_customer_inquiry`.`inquerydate`) = MONTH(CURDATE()) 
        AND YEAR(`tbl_customer_inquiry`.`inquerydate`) = YEAR(CURDATE())";

$cancel_inquiry_info = $this->db->query($sql, array($company));


// Total Transfer inquiry
$sql = "SELECT COUNT(`idtbl_customer_inquiry`) AS stockcount 
        FROM `tbl_customer_inquiry` 
        LEFT JOIN `tbl_inquiry_transfer`
        ON `tbl_inquiry_transfer`.`tbl_inquiry_id` = `tbl_customer_inquiry`.`idtbl_customer_inquiry`  
        WHERE `tbl_customer_inquiry`.`status` = 1 
        AND `tbl_customer_inquiry`.`company_branch_id` = ? 
        AND `tbl_customer_inquiry`.`cancel_status` = 0
        AND `tbl_customer_inquiry`.`transfer_status` = 1
        AND MONTH(`tbl_inquiry_transfer`.`approvedatetime`) = MONTH(CURDATE()) 
        AND YEAR(`tbl_inquiry_transfer`.`approvedatetime`) = YEAR(CURDATE())";

$transfer_inquiry_info = $this->db->query($sql, array($company));


// Total Recieved inquiry
$sql = "SELECT COUNT(`idtbl_customer_inquiry`) AS stockcount 
        FROM `tbl_customer_inquiry`
        LEFT JOIN `tbl_inquiry_transfer`
        ON `tbl_inquiry_transfer`.`received_inquery_id` = `tbl_customer_inquiry`.`idtbl_customer_inquiry`  
        WHERE `tbl_customer_inquiry`.`status` = 1 
        AND `tbl_inquiry_transfer`.`to_branch_id` = ? 
        AND MONTH(`tbl_inquiry_transfer`.`approvedatetime`) = MONTH(CURDATE()) 
        AND YEAR(`tbl_inquiry_transfer`.`approvedatetime`) = YEAR(CURDATE())";

$recieved_inquiry_info = $this->db->query($sql, array($company));


// Total Job Done inquiry
$sql = "SELECT COUNT(`idtbl_customer_inquiry`) AS stockcount 
        FROM `tbl_customer_inquiry` 
        WHERE `tbl_customer_inquiry`.`status` = 1 
        AND `tbl_customer_inquiry`.`job_done_status` = 1
        AND `tbl_customer_inquiry`.`company_branch_id` = ? 
        AND MONTH(`tbl_customer_inquiry`.`inquerydate`) = MONTH(CURDATE()) 
        AND YEAR(`tbl_customer_inquiry`.`inquerydate`) = YEAR(CURDATE())";

$jobdone_inquiry_info = $this->db->query($sql, array($company));


// Total Complaint
$sql = "SELECT COUNT(`idtbl_customer_complaint`) AS stockcount 
        FROM `tbl_customer_complaint` 
        WHERE `tbl_customer_complaint`.`status` = 1 
        AND `tbl_customer_complaint`.`company_branch_id` = ? 
        AND MONTH(`tbl_customer_complaint`.`insertdatetime`) = MONTH(CURDATE()) 
        AND YEAR(`tbl_customer_complaint`.`insertdatetime`) = YEAR(CURDATE())";

$complaint_info = $this->db->query($sql, array($company));


// Bar chart details get
$chartsql = "
SELECT 
    tbl_customer_inquiry.salesperson_id, 
    sp.sales_person_name, 
    COUNT(tbl_customer_inquiry.idtbl_customer_inquiry) AS salesperson_count,
    SUM(CASE WHEN tbl_customer_inquiry.first_follow_up = 1 AND 
        DATE_FORMAT(tbl_customer_inquiry.first_followup_datetime, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')
        THEN 1 ELSE 0 END) AS first_follow_up_only,

SUM(CASE WHEN tbl_customer_inquiry.first_follow_up = 1 AND tbl_customer_inquiry.second_follow_up = 1 AND 
        DATE_FORMAT(tbl_customer_inquiry.second_followup_datetime, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')
        THEN 1 ELSE 0 END) AS second_follow_up_only
FROM 
    tbl_customer_inquiry 
LEFT JOIN 
    tbl_sales_person AS sp ON sp.idtbl_sales_person = tbl_customer_inquiry.salesperson_id
WHERE 
    tbl_customer_inquiry.status = 1 
    AND  tbl_customer_inquiry.salesperson_id != 0 
    AND tbl_customer_inquiry.transfer_status IN (0)
    AND tbl_customer_inquiry.company_branch_id = ?
    
GROUP BY 
    tbl_customer_inquiry.salesperson_id
";


$total_chart_salesperson_info = $this->db->query($chartsql, array($company))->result_array();


//Line chart

$chartsql = "
SELECT 
    DATE(tbl_customer_inquiry.inquerydate) AS inquerydate, 
    COUNT(tbl_customer_inquiry.idtbl_customer_inquiry) AS total_inquiries,
    COUNT(CASE WHEN tbl_customer_inquiry.job_done_status = 1 THEN 1 ELSE NULL END) AS appointment_inquiries
FROM 
    tbl_customer_inquiry 
WHERE 
    tbl_customer_inquiry.status = 1 
    AND tbl_customer_inquiry.cancel_status IN (0)
    AND tbl_customer_inquiry.transfer_status IN (0)
    AND tbl_customer_inquiry.company_branch_id = ?
GROUP BY 
    DATE(tbl_customer_inquiry.inquerydate)
ORDER BY 
    inquerydate ASC
";

$total_chart_inquiries_info = $this->db->query($chartsql, array($company))->result_array();

$inquiriesData = json_encode($total_chart_inquiries_info);





// Chart details for total and confirmed inquiries
$totalConfirmedSql = "
SELECT 
    tbl_customer_inquiry.salesperson_id,
    sp.sales_person_name,
    COUNT(tbl_customer_inquiry.idtbl_customer_inquiry) AS total_inquiries,
    SUM(CASE WHEN tbl_customer_inquiry.appointment = 1 THEN 1 ELSE 0 END) AS confirmed_inquiries
FROM 
    tbl_customer_inquiry
LEFT JOIN 
    tbl_sales_person AS sp ON sp.idtbl_sales_person = tbl_customer_inquiry.salesperson_id
WHERE 
    tbl_customer_inquiry.status = 1 
    AND tbl_customer_inquiry.salesperson_id != 0 
    AND tbl_customer_inquiry.cancel_status IN (0) 
    AND tbl_customer_inquiry.transfer_status IN (0) 
    AND tbl_customer_inquiry.company_branch_id = ?
    AND MONTH(`tbl_customer_inquiry`.`inquerydate`) = MONTH(CURDATE()) 
    AND YEAR(`tbl_customer_inquiry`.`inquerydate`) = YEAR(CURDATE())
    
GROUP BY 
    tbl_customer_inquiry.salesperson_id
";

$total_confirmed_info = $this->db->query($totalConfirmedSql, array($company))->result_array();

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