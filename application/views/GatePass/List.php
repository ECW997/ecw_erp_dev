<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<style>
.card-header {
    background-color: white;
    border-bottom: 1px solid #6c757d;
    padding: 1rem 2rem;
}

label {
    color: #6c757d;
    font-weight: 700;
    font-size: 0.85rem;
    white-space: nowrap;
    margin-bottom: 0;
    line-height: 1.5;
}

.form-control-sm,
.custom-select-sm {
    font-size: 0.85rem;
    padding: 0.25rem 0.5rem;
    height: 1.9rem;
}

#filterBtn {
    min-width: 100px;
    height: 1.9rem;
    font-size: 0.85rem;
    padding: 0 0.75rem;
}

.input-group-text {
    background-color: #e9ecef;
    border-right: 0;
    font-weight: 700;
    color: #6c757d;
    white-space: nowrap;
    height: 1.9rem;
    padding: 0 0.5rem;
    line-height: 1.9rem;
}

.badge-gate-pass {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}

.badge-in { background-color: #28a745; color: #000;}
.badge-out { background-color: #dc3545; color: #000;}
.badge-temp-in { background-color: #17a2b8; color: #000;}
.badge-temp-out { background-color: #ffc107; color: #000; }
.badge-main { background-color: #007bff; color: #000;}
.badge-internal { background-color: #6f42c1; color: #000;}
.badge-external { background-color: #fd7e14; color: #000;}
</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include APPPATH . "views/include/menubar.php"; ?>
    </div>
    <?php
    // Check permissions using menuaccess (Menu ID: 42 for Gate Pass)
    // Note: checkprivilege() function is defined in menubar.php, so we call it after including menubar.php
    $addcheck = isset($menuaccess) ? checkprivilege($menuaccess, 42, 1) : 0; // Add permission
    $editcheck = isset($menuaccess) ? checkprivilege($menuaccess, 42, 2) : 0; // Edit permission
    $statuscheck = isset($menuaccess) ? checkprivilege($menuaccess, 42, 3) : 0; // Status permission
    $deletecheck = isset($menuaccess) ? checkprivilege($menuaccess, 42, 4) : 0; // Delete permission
    $printcheck = isset($menuaccess) ? checkprivilege($menuaccess, 42, 5) : 0; // Print permission (approve1)
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3 d-flex justify-content-between align-items-center">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-id-card"></i></div>
                            <span>Gate Pass List</span>
                        </h1>
                        <div>
                            <a href="<?= base_url('GatePass/vehicleTracking') ?>" class="btn btn-info btn-sm px-4 p-2 ml-2">
                                <i class="fas fa-car mr-2"></i>Vehicle Tracking
                            </a>
                            <?php if ($addcheck == 1) : ?>
                            <a href="<?= base_url('GatePass/generateForm') ?>" class="btn btn-primary btn-sm px-4 p-2">
                                <i class="fas fa-plus mr-2"></i>Generate Gate Pass
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="p-2">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3 d-flex align-items-center justify-content-start">
                                <label for="date_from" class="mb-0 mr-2">Date Filter</label>
                                <div class="input-group">
                                    <input type="date" id="date_from" class="form-control form-control-sm" aria-label="Date From" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">to</span>
                                    </div>
                                    <input type="date" id="date_to" class="form-control form-control-sm" aria-label="Date To" />
                                </div>
                            </div>

                            <div class="col-12 col-md-9 d-flex align-items-center justify-content-end flex-wrap">
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="gate_pass_type" class="mb-0 mr-2">Type</label>
                                    <select id="gate_pass_type" class="custom-select custom-select-sm" style="min-width: 130px;">
                                        <option value="">All Types</option>
                                        <option value="IN">IN</option>
                                        <option value="OUT">OUT</option>
                                        <option value="TEMP_IN">Temp IN</option>
                                        <option value="TEMP_OUT">Temp OUT</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="pass_category" class="mb-0 mr-2">Category</label>
                                    <select id="pass_category" class="custom-select custom-select-sm" style="min-width: 130px;">
                                        <option value="">All Categories</option>
                                        <option value="MAIN">Main</option>
                                        <option value="INTERNAL">Internal</option>
                                        <option value="EXTERNAL">External</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="status" class="mb-0 mr-2">Status</label>
                                    <select id="status" class="custom-select custom-select-sm" style="min-width: 130px;">
                                        <option value="">All Status</option>
                                        <option value="ACTIVE">Active</option>
                                        <option value="COMPLETED">Completed</option>
                                        <option value="CANCELLED">Cancelled</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="job_card_id" class="mb-0 mr-2">Job Card</label>
                                    <input type="text" id="job_card_id" class="form-control form-control-sm" placeholder="Job Card ID" style="min-width: 120px;" />
                                </div>
                                <button class="btn btn-secondary btn-sm" id="filterBtn" style="height: 1.9rem; font-size: 0.85rem;">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                                <button class="btn btn-outline-secondary btn-sm ml-2" id="clearFilterBtn">Clear</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Gate Pass No</th>
                                                <th>Type</th>
                                                <th>Category</th>
                                                <th>Job Card No</th>
                                                <th>Vehicle No</th>
                                                <th>Chassis No</th>
                                                <th>Customer</th>
                                                <th>Gate Location</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>
<?php include APPPATH . "views/include/footerscripts.php"; ?>
<script>
var addcheck = '<?php echo $addcheck; ?>';
var editcheck = '<?php echo $editcheck; ?>';
var deletecheck = '<?php echo $deletecheck; ?>';
var printcheck = '<?php echo $printcheck; ?>';
var base_url = '<?= base_url() ?>';

$(document).ready(function() {
    // Initialize DataTable
    var table = $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": base_url + "GatePass/getGatePasses",
            "type": "GET",
            "dataSrc": function(json) {
                if (json.status && json.data) {
                    return json.data.data || json.data;
                }
                return [];
            },
            "error": function(xhr, error, thrown) {
                console.error("Error loading gate passes:", error);
                showAlert("Error loading gate passes. Please try again.", "danger");
            }
        },
        "columns": [
            { "data": null, "orderable": false, "defaultContent": "" },
            { 
                "data": "created_at",
                "render": function(data) {
                    return data ? new Date(data).toLocaleDateString() : '-';
                }
            },
            { "data": "gate_pass_number" },
            { 
                "data": "gate_pass_type",
                "render": function(data) {
                    var badgeClass = 'badge-secondary';
                    if (data === 'IN') badgeClass = 'badge-in';
                    else if (data === 'OUT') badgeClass = 'badge-out';
                    else if (data === 'TEMP_IN') badgeClass = 'badge-temp-in';
                    else if (data === 'TEMP_OUT') badgeClass = 'badge-temp-out';
                    return '<span class="badge badge-gate-pass ' + badgeClass + '">' + data + '</span>';
                }
            },
            { 
                "data": "pass_category",
                "render": function(data) {
                    var badgeClass = 'badge-secondary';
                    if (data === 'MAIN') badgeClass = 'badge-main';
                    else if (data === 'INTERNAL') badgeClass = 'badge-internal';
                    else if (data === 'EXTERNAL') badgeClass = 'badge-external';
                    return '<span class="badge badge-gate-pass ' + badgeClass + '">' + data + '</span>';
                }
            },
            { 
                "data": "job_card",
                "render": function(data) {
                    return data ? (data.job_card_number || data.job_card_number2 || '-') : '-';
                }
            },
            { 
                "data": "job_card",
                "render": function(data) {
                    return data ? (data.vehicle_number || '-') : '-';
                }
            },
            { 
                "data": "job_card",
                "render": function(data) {
                    return data ? (data.chassis_number || '-') : '-';
                }
            },
            { 
                "data": "job_card",
                "render": function(data) {
                    return data ? (data.customer_name || '-') : '-';
                }
            },
            { 
                "data": "location",
                "render": function(data) {
                    return data ? data.location_name : '-';
                }
            },
            { 
                "data": "status",
                "render": function(data) {
                    var badgeClass = 'badge-secondary';
                    if (data === 'ACTIVE') badgeClass = 'badge-success';
                    else if (data === 'COMPLETED') badgeClass = 'badge-info';
                    else if (data === 'CANCELLED') badgeClass = 'badge-danger';
                    return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                }
            },
            { "data": "print_count" },
            { 
                "data": "creator",
                "render": function(data) {
                    return data ? data.name : '-';
                }
            },
            {
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    var actions = '<div class="btn-group btn-group-sm">';
                    actions += '<a href="' + base_url + 'GatePass/view/' + row.id + '" class="btn btn-info btn-sm" title="View"><i class="fas fa-eye"></i></a>';
                    if (printcheck == 1) {
                        actions += '<button class="btn btn-primary btn-sm print-gate-pass" data-id="' + row.id + '" title="Print"><i class="fas fa-print"></i></button>';
                    }
                    actions += '</div>';
                    return actions;
                }
            }
        ],
        "order": [[1, "desc"]],
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
        "language": {
            "processing": "Loading gate passes...",
            "emptyTable": "No gate passes found",
            "zeroRecords": "No matching gate passes found"
        }
    });

    // Row numbering
    table.on('order.dt search.dt', function() {
        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    // Filter button
    $('#filterBtn').on('click', function() {
        var dateFrom = $('#date_from').val();
        var dateTo = $('#date_to').val();
        var gatePassType = $('#gate_pass_type').val();
        var passCategory = $('#pass_category').val();
        var status = $('#status').val();
        var jobCardId = $('#job_card_id').val();

        var url = base_url + "GatePass/getGatePasses?";
        var params = [];
        
        if (dateFrom) params.push("date_from=" + dateFrom);
        if (dateTo) params.push("date_to=" + dateTo);
        if (gatePassType) params.push("gate_pass_type=" + gatePassType);
        if (passCategory) params.push("pass_category=" + passCategory);
        if (status) params.push("status=" + status);
        if (jobCardId) params.push("job_card_id=" + jobCardId);

        url += params.join("&");
        
        table.ajax.url(url).load();
    });

    // Clear filter
    $('#clearFilterBtn').on('click', function() {
        $('#date_from').val('');
        $('#date_to').val('');
        $('#gate_pass_type').val('');
        $('#pass_category').val('');
        $('#status').val('');
        $('#job_card_id').val('');
        table.ajax.url(base_url + "GatePass/getGatePasses").load();
    });

    // Print gate pass
    $(document).on('click', '.print-gate-pass', function() {
        var gatePassId = $(this).data('id');
        printGatePass(gatePassId);
    });

    function printGatePass(id) {
        if (!confirm('Print this gate pass?')) return;

        $.ajax({
            url: base_url + "GatePass/printGatePass/" + id,
            type: "POST",
            success: function(response) {
                if (response.status) {
                    showAlert("Gate pass printed successfully", "success");
                    table.ajax.reload();
                } else {
                    showAlert(response.message || "Error printing gate pass", "danger");
                }
            },
            error: function(xhr) {
                var errorMsg = "Error printing gate pass";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showAlert(errorMsg, "danger");
            }
        });
    }

    function showAlert(message, type) {
        var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            message +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button></div>';
        $('.container-fluid').first().prepend(alertHtml);
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 3000);
    }
});
</script>

