<?php 
include "include/header.php";  

include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <style>
        .table_1 thead th {
            background-color: #cf1349 !important;
            color: #fff !important;
        }

        /* .table_1 td {
            background-color: #e6e6e6ff !important;
            color: #000 !important;
        }

        .table_2 tbody tr:hover td {
            background-color: #f9ce7a !important;
        } */
        </style>
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-chart-pie"></i></div>
                            <span>Sales Target</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="container-fluid mt-2 p-0 p-2">

                            <div class="card mb-3 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <i class="fas fa-bullseye"></i>&nbsp; Month Sales Target
                                </div>
                                <div class="card-body">
                                    <form id="salesTargetForm"
                                        action="<?php echo base_url() ?>SalesTarget/salesTargetInsertUpdate"
                                        method="post" autocomplete="off">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-3">
                                                <label class="small font-weight-bold text-dark">Month*</label>
                                                <input type="month" class="form-control form-control-sm"
                                                    id="targetMonth" name="targetMonth" required
                                                    min="<?= date('Y-m') ?>" value="<?= date('Y-m') ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="small font-weight-bold text-dark">Total Monthly
                                                    Target*</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="monthlyTarget" id="monthlyTarget" required>
                                            </div>
                                            <!-- <div class="col-md-3">
                                                <button type="submit" class="btn btn-success mt-4 px-4">
                                                    <i class="fas fa-save"></i>&nbsp; Save Target
                                                </button>
                                            </div> -->
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card mb-3 shadow-sm">
                                <div class="card-header bg-info text-white">
                                    <i class="fas fa-users"></i>&nbsp;Assign Target to Sales Agent
                                </div>
                                <div class="card">
                                    <div class="card-body p-0 p-2">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mb-3">
                                                <form id="assignTargetForm" autocomplete="off">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6 mb-2">
                                                            <label class="small font-weight-bold text-dark">Sales
                                                                Agent*</label>
                                                            <select id="sales_agent"
                                                                class="custom-select custom-select-sm" required>
                                                                <option value="">Select Sales Agent</option>
                                                                <?php if (!empty($sales_agents)) : ?>
                                                                <?php foreach ($sales_agents as $agent) : ?>
                                                                <option value="<?= $agent['idtbl_sales_person']; ?>">
                                                                    <?= htmlspecialchars($agent['sales_person_name']); ?>
                                                                </option>
                                                                <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-md-6 mb-2">
                                                            <label class="small font-weight-bold text-dark">Assign
                                                                Target*</label>
                                                            <input type="number" class="form-control form-control-sm"
                                                                name="personTarget" id="personTarget" required>
                                                        </div>
                                                        <div class="col-9">
                                                        </div>
                                                        <div class="col-3">
                                                            <button type="button" id="formsubmit"
                                                                class="btn btn-primary btn-sm mt-2 px-4"
                                                                <?php if($addcheck==0){echo 'disabled';} ?>>
                                                                <i class="fas fa-plus"></i>&nbsp;Add to list
                                                            </button>
                                                            <button type="button" name="Btnupdatelist"
                                                                id="Btnupdatelist" class="btn btn-secondary btn-sm px-4"
                                                                style="display:none;">
                                                                <i class="fas fa-plus"></i>&nbsp;Update List
                                                            </button>
                                                            <input name="submitBtn" type="submit" value="Save"
                                                                id="submitBtn" class="d-none">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <table
                                                    class="table_1 table-bordered table-striped table-sm nowrap w-100"
                                                    id="tempTargetTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Sales Agent</th>
                                                            <th class="text-center">Assigned Target</th>
                                                            <th class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                                <div id="targetSummary"></div>
                                                <div class="d-flex justify-content-end mt-4">
                                                    <button id="saveAllBtn" class="btn btn-success">Save All
                                                        Targets</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="container-fluid mt-2 p-0 p-2">
                                    <div class="card">
                                        <div class="card-body p-0 p-2">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="scrollbar pb-3" id="style-2">
                                                        <table
                                                            class="table_1 table-bordered table-striped table-sm nowrap w-100"
                                                            id="dataTable">
                                                            <thead>
                                                                <tr>
                                                                    </th>
                                                                    <th>Month</th>
                                                                    <th>Month Target</th>
                                                                    <th>Sales Agent</th>
                                                                    <th>Agent Target</th>
                                                                    <th>Target Percentage</th>
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
var addcheck = '<?php echo $addcheck; ?>';
var editcheck = '<?php echo $editcheck; ?>';
var statuscheck = '<?php echo $statuscheck; ?>';
var deletecheck = '<?php echo $deletecheck; ?>';
$(document).ready(function() {
    let addcheck = '<?php echo $addcheck; ?>';

    function updateTargetSummary() {
        let monthlyTarget = parseFloat($('#monthlyTarget').val()) || 0;
        let allocated = 0;
        $('#tempTargetTable tbody tr').each(function() {
            allocated += parseFloat($(this).find('td.target').text()) || 0;
        });
        let toBeAllocated = monthlyTarget - allocated;
        $('#targetSummary').html(
            `<div class="mt-2">
                    <span class="badge badge-success">Allocated Target: ${allocated.toFixed(2)}</span>
                    <span class="badge badge-warning ml-2">Remaining Target: ${toBeAllocated.toFixed(2)}</span>
                </div>`
        );
    }

    $("#formsubmit").click(function() {
        if (!$("#assignTargetForm")[0].checkValidity()) {
            $("#submitBtn").click();
        } else {
            var agentId = $('#sales_agent').val();
            var agentName = $('#sales_agent option:selected').text();
            var target = $('#personTarget').val();
            var monthlyTarget = parseFloat($('#monthlyTarget').val()) || 0;

            if (!agentId || !target) {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Data',
                    text: 'Please select a sales agent and enter a target.',
                });
                return;
            }

            // Duplicate check
            var duplicate = false;
            $('#tempTargetTable > tbody > tr').each(function() {
                var existingAgentId = $(this).find('td.agentid').text();
                if (existingAgentId === agentId) {
                    duplicate = true;
                    return false;
                }
            });

            if (duplicate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Duplicate Entry',
                    text: 'This sales agent has already been added to the table.',
                });
            } else {
                // Validate total allocation
                let allocated = 0;
                $('#tempTargetTable tbody tr').each(function() {
                    allocated += parseFloat($(this).find('td.target').text()) || 0;
                });
                let newTotal = allocated + parseFloat(target);
                if (monthlyTarget > 0 && newTotal > monthlyTarget) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Allocation Exceeded',
                        text: 'Allocated targets exceed the monthly target!',
                    });
                    return;
                }

                $('#tempTargetTable > tbody').append(
                    `<tr>
                            <td>${agentName}</td>
                            <td class="agentid d-none">${agentId}</td>
                            <td class="target text-right">${target}</td>
                            <td class="target text-center">
                                <button type="button" onclick="targetDelete(this);" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>`
                );
                $('#sales_agent').val('');
                $('#personTarget').val('');
                $('#sales_agent').focus();
                updateTargetSummary();
            }
        }
    });

    $('#monthlyTarget').on('input', updateTargetSummary);

    window.targetDelete = function(btn) {
        if (confirm("Are you sure you want to delete this Sales Agent Target?")) {
            btn.closest('tr').remove();
            updateTargetSummary();
            Toastify({
                text: "Sales Agent Target Deleted Successfully",
                duration: 2000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#4CAF50",
                stopOnFocus: true,
            }).showToast();
        }
    };

    updateTargetSummary();


    $('#dataTable').DataTable({
        destroy: true,
        processing: true,
        serverSide: false, // We'll handle everything client-side
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        buttons: [{
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                title: 'Sales Target Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV'
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Sales Target Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF'
            },
            {
                extend: 'print',
                title: 'Sales Target Information',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ],
        ajax: {
            url: apiBaseUrl + '/v1/sales_target',
            type: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + api_token
            },
            dataSrc: function(json) {
                if (json.status === false && json.code === 401) {
                    falseResponse(errorObj);
                    return [];
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
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: "target_name",
                render: function(data, type, full) {
                    return `${data} <br><small>(${full.target_date_from} to ${full.target_date_to})</small>`;
                }
            },
            {
                data: "monthly_target_amount",
                className: "text-right",
                render: function(data) {
                    return "Rs. " + parseFloat(data).toLocaleString();
                }
            },
            {
                data: "details",
                className: "text-right",
                render: function(details) {
                    if (!details || details.length === 0) return '-';
                    return details.map(d => `<div>${d.sales_agent_name}</div>`).join('') +
                        `<div class='fw-bold text-primary border-top mt-1 pt-1'><b>Remaining Target</b></div>`;
                }
            },
            {
                data: null,
                className: "text-right",
                render: function(data) {
                    const monthlyTarget = parseFloat(data.monthly_target_amount);
                    const totalAssigned = data.details.reduce((sum, d) => sum + parseFloat(d
                        .amount), 0);
                    const remaining = monthlyTarget - totalAssigned;

                    let html = data.details.map(d =>
                        `<div class="text-right">Rs. ${parseFloat(d.amount).toLocaleString()}</div>`
                    ).join('');

                    html +=
                        `<div class='fw-bold text-primary border-top mt-1 pt-1 text-right'><b>Rs. ${remaining.toLocaleString()}</b></div>`;
                    return html;
                }
            },
            {
                data: null,
                className: "text-right",
                render: function(data) {
                    const monthlyTarget = parseFloat(data.monthly_target_amount);
                    const totalAssigned = data.details.reduce((sum, d) => sum + parseFloat(d
                        .amount), 0);
                    const remaining = monthlyTarget - totalAssigned;

                    let html = data.details.map(d => {
                        const percentage = ((parseFloat(d.amount) / monthlyTarget) *
                            100).toFixed(2);
                        return `<div>${percentage}%</div>`;
                    }).join('');

                    html += `<div class='fw-bold text-primary border-top mt-1 pt-1'>–</div>`;
                    return html;
                }
            },
            {
                data: null,
                className: 'text-right',
                render: function(data, type, full) {
                    let button = `
                        <button title="Edit" class="btn btn-primary btn-sm mr-1" 
                            onclick="showEditModal(${full.id});">
                            <i class="fas fa-edit"></i>
                        </button>
                    `;
                    button +=
                        '<a title="Delete" href="<?php echo base_url() ?>SalesTarget/salesTargetDelete/' +
                        full['id'] +
                        '" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';
                    if (deletecheck != 1) {
                        button += 'd-none';
                    }
                    button += '"><i class="fas fa-trash-alt"></i></a>';
                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });



    $(document).on('click', '#saveAllBtn', function() {
        var targetMonth = $('#targetMonth').val();
        var monthlyTarget = parseFloat($('#monthlyTarget').val()) || 0;

        if (!targetMonth || !monthlyTarget) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Data',
                text: 'Please select a month and enter the total monthly target.',
            });
            return;
        }

        // Parse target month into start and end dates
        var monthParts = targetMonth.split("-");
        var targetYear = monthParts[0];
        var targetMonthNum = monthParts[1];
        var firstDay = `${targetYear}-${targetMonthNum}-01`;
        var lastDay = new Date(targetYear, targetMonthNum, 0).getDate();
        var endDate = `${targetYear}-${targetMonthNum}-${lastDay}`;

        // Collect agent target data
        var agentTargets = [];
        $('#tempTargetTable tbody tr').each(function() {
            var agentId = $(this).find('td.agentid').text();
            var agentName = $(this).find('td:first').text();
            var target = parseFloat($(this).find('td.target').first().text()) || 0;

            agentTargets.push({
                type: "Agent",
                sales_agent_name: agentName,
                sales_agent_id: parseInt(agentId),
                amount: target
            });
        });

        if (agentTargets.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'No Targets Added',
                text: 'Please add at least one sales agent target before saving.',
            });
            return;
        }

        // Create target name like "October Target"
        var monthName = new Date(firstDay).toLocaleString('default', {
            month: 'long'
        });
        var targetName = monthName + " Target";

        // Build JSON payload
        var payload = {
            type: "1",
            target_name: targetName,
            target_date_from: firstDay,
            target_date_to: endDate,
            monthly_target_amount: monthlyTarget,
            details: agentTargets
        };

        console.log("Sending payload:", payload);

        $.ajax({
            url: apiBaseUrl + '/v1/sales_target',
            type: "POST",
            data: JSON.stringify(payload),
            contentType: "application/json",
            dataType: "json",
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + api_token
            },
            success: function(result) {
                if (result.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: result.message || 'Sales target saved successfully!'
                    });
                    $('#tempTargetTable tbody').empty();
                    $('#sales_agent').val('');
                    $('#personTarget').val('');
                    $('#monthlyTarget').val('');
                    updateTargetSummary();
                    $('#dataTable').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message || 'Failed to save target.'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: xhr.responseJSON?.message || 'Unable to save target.'
                });
            }
        });
    });




});
function delete_confirm() {
    return confirm("Are you sure you want to remove this?");
}
</script>

<script>
function targetDelete(btn) {
    if (confirm("Are you sure you want to delete this Sales Agent Target?")) {
        btn.closest('tr').remove();

        Toastify({
            text: "Sales Agent Target Deleted Successfully",
            duration: 2000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#4CAF50",
            stopOnFocus: true,
        }).showToast();
    }
}
</script>
<?php include "include/footer.php"; ?>