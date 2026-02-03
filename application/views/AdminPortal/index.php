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
.badge-emergency {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}
.badge-danger-action {
    background-color: #dc3545;
    color: #fff;
}
</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include APPPATH . "views/include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3 d-flex justify-content-between align-items-center">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-shield-alt"></i></div>
                            <span>Admin Portal - Emergency Actions</span>
                        </h1>
                        <div>
                            <?php
                            // Load action types config
                            $this->config->load('admin_portal_actions');
                            $actions = $this->config->item('admin_portal_actions');
                            $enabled_actions = array_filter($actions, function($action) {
                                return isset($action['enabled']) && $action['enabled'] === true;
                            });
                            
                            // Show action buttons for enabled action types
                            foreach ($enabled_actions as $action_type => $config):
                            ?>
                                <a href="<?= base_url('AdminPortal/' . $config['action_method']) ?>" 
                                   class="btn btn-danger btn-sm px-4 p-2 ml-2"
                                   title="<?= $config['description'] ?>">
                                    <i class="<?= $config['menu_icon'] ?> mr-2"></i><?= $config['name'] ?>
                                </a>
                            <?php endforeach; ?>
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
                                    <label for="action_type" class="mb-0 mr-2">Action Type</label>
                                    <select id="action_type" class="custom-select custom-select-sm" style="min-width: 150px;">
                                        <option value="">All Actions</option>
                                        <?php
                                        // Load action types from registry
                                        $this->config->load('admin_portal_actions');
                                        $actions = $this->config->item('admin_portal_actions');
                                        foreach ($actions as $action_type => $config):
                                            if (isset($config['enabled']) && $config['enabled']):
                                        ?>
                                            <option value="<?= $action_type ?>"><?= $config['name'] ?></option>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                    </select>
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
                                                <th>Date & Time</th>
                                                <th>Action Type</th>
                                                <th>Sales Order Relation ID</th>
                                                <th>Reason</th>
                                                <th>User</th>
                                                <th>Branch</th>
                                                <th>Status</th>
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
var base_url = '<?= base_url() ?>';

$(document).ready(function() {
    var table = $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": base_url + "AdminPortal/getEmergencyActionLogs",
            "type": "POST",
            "data": function(d) {
                return {
                    date_from: $('#date_from').val() || '',
                    date_to: $('#date_to').val() || '',
                    action_type: $('#action_type').val() || '',
                    user_id: ''
                };
            },
            "dataSrc": function(json) {
                if (json.status && json.data) {
                    // Response is now a direct array of logs
                    if (Array.isArray(json.data)) {
                        return json.data;
                    }
                    // Fallback: handle paginated response if needed
                    if (json.data.data && Array.isArray(json.data.data)) {
                        return json.data.data;
                    }
                }
                return [];
            },
            "error": function(xhr, error, thrown) {
                console.error("Error loading logs:", error, xhr.responseJSON);
                var errorMsg = "Error loading logs. Please try again.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showAlert(errorMsg, "danger");
            }
        },
        "columns": [
            { "data": null, "orderable": false, "defaultContent": "" },
            { 
                "data": "created_at",
                "render": function(data) {
                    return data ? new Date(data).toLocaleString() : '-';
                }
            },
            { 
                "data": "action_type",
                "render": function(data) {
                    var badgeClass = 'badge-secondary';
                    if (data === 'SALES_ORDER_CANCEL') badgeClass = 'badge-danger-action';
                    return '<span class="badge badge-emergency ' + badgeClass + '">' + (data || '-') + '</span>';
                }
            },
            { "data": "sales_order_relation_id" },
            { 
                "data": "reason",
                "render": function(data) {
                    return data ? (data.length > 50 ? data.substring(0, 50) + '...' : data) : '-';
                }
            },
            { 
                "data": "user",
                "render": function(data) {
                    return data ? data.name : '-';
                }
            },
            { 
                "data": "branch",
                "render": function(data) {
                    // Branch mapping: 1 = Nittambuwa, 2 = Negombo
                    var branchNames = {
                        1: 'Nittambuwa',
                        2: 'Negombo'
                    };
                    return data && branchNames[data] ? branchNames[data] : (data ? 'Branch ' + data : '-');
                }
            },
            { 
                "data": "status",
                "render": function(data) {
                    var badgeClass = 'badge-secondary';
                    if (data === 'SUCCESS') badgeClass = 'badge-success';
                    else if (data === 'FAILED') badgeClass = 'badge-danger';
                    return '<span class="badge ' + badgeClass + '">' + (data || '-') + '</span>';
                }
            },
            {
                "data": null,
                "className": "text-right",
                "orderable": false,
                "defaultContent": "",
                "render": function(data, type, row) {
                    if (!row || !row.id) {
                        return '';
                    }
                    var actions = '<div class="btn-group btn-group-sm">';
                    actions += '<a href="' + base_url + 'AdminPortal/viewLog/' + row.id + '" class="btn btn-info btn-sm" title="View"><i class="fas fa-eye"></i></a>';
                    actions += '</div>';
                    return actions;
                }
            }
        ],
        "order": [[1, "desc"]],
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
        "language": {
            "processing": "Loading logs...",
            "emptyTable": "No logs found",
            "zeroRecords": "No matching logs found"
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
        table.ajax.reload();
    });

    // Clear filter
    $('#clearFilterBtn').on('click', function() {
        $('#date_from').val('');
        $('#date_to').val('');
        $('#action_type').val('');
        table.ajax.reload();
    });

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
