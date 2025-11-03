<?php include "include/header.php"; ?>
<?php include "include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include "include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow-sm border-bottom">
                <div class="container-fluid py-3 d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">
                        <i class="fa fa-book mr-2 text-primary"></i>Old Advance List
                    </h1>
                </div>
            </div>
            <div class="container-fluid mt-3">
            	<div class="card shadow-sm">
            		<div class="card-body">
            			<table id="movementsTable" class="table table-bordered w-100">
            				<thead>
            					<tr>
                                    <th>#</th>
            						<th>Advance Date </th>
            						<th>Job No</th>
            						<th>Customer Name</th>
            						<th>Vehicle No</th>
            						<th>Vehicle Type</th>
            						<th class="text-right">Amount </th>
            					</tr>
            				</thead>
            			</table>
            		</div>
            	</div>
            </div>
        </main>

        <?php include "include/footerbar.php"; ?>
    </div>
</div>

<?php include "include/footerscripts.php"; ?>

<script>
    $(document).ready(function() {
        $('#movementsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: apiBaseUrl + '/v1/cashier_old_advance',
                type: "GET",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + api_token
                },
                dataSrc: function(json) {
                    if (json.status === false && json.code === 401) {
                        falseResponse(errorObj);
                    } else {
                        return json.data;
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 401) {
                        falseResponse(errorObj);
                    }
                }
            },
            columns: [
                { data: 'id' },
                { data: 'advance_date' },
                { data: 'job_no' },
                { data: 'customer_name' },
                { data: 'vehicle_no' },
                { data: 'vehicle_type' },
                { 
                    data: 'amount',
                    className: 'text-right',
                    render: function(data, type, row) {
                        return parseFloat(data).toLocaleString(undefined, { minimumFractionDigits: 2 });
                    }
                }
            ],
            order: [[0, 'desc']],
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    });
</script>


<?php include "include/footer.php"; ?>
