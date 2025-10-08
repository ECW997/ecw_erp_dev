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
                                    <form id="salesTargetForm" autocomplete="off">
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

    // Update summary when monthly target changes
    $('#monthlyTarget').on('input', updateTargetSummary);

    // Update summary after delete
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

    // Initial summary
    updateTargetSummary();
});
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