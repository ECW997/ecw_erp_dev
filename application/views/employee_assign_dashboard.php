<?php 

include "include/header.php";  

include "include/topnavbar.php"; 
?>
<style>
.custom-column1-width {
    width: 130px !important;
    min-width: 130px;
    max-width: 130px;
}
.custom-column2-width {
    width: 200px !important;
    min-width: 200px;
    max-width: 200px;
}
.custom-column3-width {
    width: 320px !important;
    min-width: 320px;
    max-width: 320px;
}
.custom-column4-width {
    width: 150px !important;
    min-width: 150px;
    max-width: 150px;
}
</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class='fas fa-tachometer-alt'></i></div>
                            <span>Job Dashboad</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 justify-content-end mb-3" style="display:flex;">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button class="dropdown-item" type="button" id="f_progress_0" name="f_progress_0" value="0" onclick="filterTable(this.value);">All</button>
                                        <button class="dropdown-item" type="button" id="f_progress_1" name="f_progress_1" value="1" onclick="filterTable(this.value);">Corrently Working</button>
                                        <button class="dropdown-item" type="button" id="f_progress_2" name="f_progress_2" value="2" onclick="filterTable(this.value);">Done Jobs</button>
                                        <button class="dropdown-item" type="button" id="f_progress_3" name="f_progress_3" value="3" onclick="filterTable(this.value);">Pending Jobs</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap w-100"
                                        id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>Job Card Number</th>
                                                <th>Job Progress</th>
                                                <th>Due Date</th>
                                                <th>Supervisor</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dataTableList"></tbody>
                                    </table>
                                </div>
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
<script>
$(document).ready(function() {

    filterTable('0');
    
});

function filterTable(value){
    $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-5'l><'col-sm-2'><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/assignemployee_dashboardlist.php",
            type: "POST", // you can use GET
            "data": function(d) {
                    return $.extend({}, d, {
                        "company_branch_id": '<?php echo ($_SESSION['branch_id']); ?>',
                        "filter_value": value,
                    });
                }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "job_card_number",
                "className": "custom-column1-width"
            },
            {
                "data": null,
                "className": "custom-column2-width",
                "render": function(data, type, full) {
                        var status = full['job_progress_status'];
                        if(status=='0'){
                            return '<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%">Emp Assigned</div></div>';
                        }else if(status=='1'){
                            return '<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">Started</div></div>';
                        }else if(status=='2'){
                            return '<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Job Done</div></div>';
                        }else{
                            if(full['calling_name'] != null){
                                return '<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%">Superv.</div></div>';
                            }else{
                                return '<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width: 5%"></div></div>';
                            }
                           
                        }
                    }
            },
            {
                "data": null,
                "className": "custom-column3-width",
                "render": function(data, type, full) {
                    var status = full['job_progress_status'];
                    var begin_date = full['job_begin_datetime'];
                    var end_date = full['job_end_datetime'];

                    if(status!=null){
                        return '('+begin_date+') <span class="font-weight-bold text-danger">To</span> ('+end_date+')';
                    }else{
                        return 'Not Assign';
                    }
                }
            },
            {
                "data": null,
                "className": "custom-column4-width",
                "render": function(data, type, full) {
                    var supervisor = full['calling_name'];

                    if(supervisor!=null){
                        return supervisor;
                    }else{
                        return 'Not Assign';
                    }
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
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
<?php include "include/footer.php"; ?>