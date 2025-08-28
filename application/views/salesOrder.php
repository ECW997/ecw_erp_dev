<?php 
include "include/v2/header.php";  
include "include/v2/topnavbar.php"; 
?>

<style>
.table-container {
	/* max-height: 350px; */
	overflow-y: auto;
}

.job-row {
	cursor: pointer;
	transition: background-color 0.3s;
}

.job-row:hover {
	background-color: #f8f9fa;
}

.selected-row {
	background-color: #e3f2fd !important;
}

.transfer-btn {
	font-size: 0.8rem;
	padding: 0.25rem 0.5rem;
}

.price-summary {
	background-color: #f8f9fa;
	border-radius: 0.375rem;
	padding: 1.5rem;
}

.status-badge {
	font-size: 0.75rem;
}

/* .control-panel {
	background-color: #fff;
	border-radius: 0.375rem;
	padding: 1.5rem;
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
} */

</style>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <?php
    $is_approve = (isset($relationDetails['status']) && $relationDetails['status'] === 'Approved');
    $is_button_hidden = $is_edit ? $editcheck == 0 : $addcheck == 0;
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-gray shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-1">
                        <div class="row d-flex align-items-center">
                            <div class="col-4">
                                <h1 class="page-header-title">Sales Order</h1>
                            </div>
                            <div class="col-md-8 text-md-end">
                                <button type="button" class="btn btn-warning rounded-2 action-btn px-3 py-2 fs-6"
                                    onclick="window.location.href='<?= base_url('SalesOrder') ?>'">
                                    <i class="fas fa-arrow-left me-1 text-dark"></i>
                                    <i class="fas fa-file-invoice me-1 text-dark"></i>
                                    <span class="text-dark fw-bold">Sales Order List</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0">
                <div class="card form-card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-12 text-right">
                                <?php if ($is_approve): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php else: ?>
                                    <button type="button"
                                        class="btn btn-success btn-sm rounded-2 action-btn-fixed <?= ($approve1check == 0 || !$is_edit) ? 'd-none' : '' ?>"
                                        onclick="approveConfirm();">
                                        <i class="fas fa-check me-1"></i> Approve
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mb-4">
                             <div class="col-12">
                                <div class="control-panel">
                                    <div class="row align-items-end">
                                        <div class="col-md-6">
                                            <label for="jobCardSelect" class="form-label">Select Job Card</label>
                                            <select class="form-select" id="job_card_number" name="job_card_number" <?= $is_edit ? 'disabled' : ''; ?>>
                                                <option value=""> Select Job Card </option>
                                                <?php if (!empty($relationDetails['jobcard_id'])): ?>
                                                <option value="<?= $relationDetails['jobcard_id'] ?>" selected>
                                                    <?= $relationDetails['jobcard_no'] ?>
                                                </option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="confirmedOrderValue" class="form-label">Confirmed Order Value (Price)</label>
                                            <input type="number" class="form-control" id="confirmedOrderValue" 
                                            value="<?= isset($relationDetails['confirmed_order_value']) ? $relationDetails['confirmed_order_value'] : '' ?>" 
                                            placeholder="Enter order value/price" min="0" step="0.01" onkeyup="updatePriceSummary()" <?= $is_approve ? 'disabled' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Available Jobs</h5>
                                        <span class="badge bg-primary" id="availableCount">0</span>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-container">
                                            <table class="table table-bordered table-sm" id="availableJobsTable">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Description</th>
                                                        <th class="text-center">QTY</th>
                                                        <th class="text-end">Total Price</th>
                                                        <th class="text-center <?= $is_approve ? 'd-none' : ''; ?>">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Exclude Jobs</h5>
                                        <span class="badge bg-success" id="selectedCount">0</span>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-container">
                                            <table class="table table-bordered table-sm" id="excludeJobsTable">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Description</th>
                                                        <th class="text-center">QTY</th>
                                                        <th class="text-end">Total Price</th>
                                                        <th class="text-center <?= $is_approve ? 'd-none' : ''; ?>">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                        	<div class="col-md-8">
                        		<div class="price-summary">
                        			<div class="row text-center">
                        				<div class="col-md-3">
                        					<h6 class="text-gray-800">Total Jobs Price</h6>
                        					<h4 class="text-primary" id="totalJobsPrice">0.00</h4>
                                            <input type="hidden" id="totalJobsPriceHidden">
                        				</div>
                        				<div class="col-md-3">
                        					<h6 class="text-gray-800">Confirmed Order Value</h6>
                        					<h4 class="text-info" id="displayOrderValue">0.00</h4>
                        				</div>
                        				<div class="col-md-3">
                        					<h6 class="text-gray-800">Difference</h6>
                        					<h4 id="priceDifference">0.00</h4>
                        				</div>
                        				<div class="col-md-3">
                        					<h6 class="text-gray-800">Status</h6>
                        					<span class="badge status-badge" id="priceStatus">Pending</span>
                        				</div>
                        			</div>
                        		</div>
                        	</div>
                             <?php if ($is_approve): ?>
                                <div class="col-md-4 d-flex align-items-center justify-content-end">
                                    <span class="badge bg-success">This order has been approved and cannot be modified.</span>
                                </div>
                            <?php else: ?>
                        	<div class="col-md-4 d-flex align-items-center justify-content-end">
                        		<button class="btn btn-primary btn-sm px-4 <?= $is_button_hidden ? 'd-none' : '' ?>" id="confirmBtn" onclick="confirmOrder();" disabled>
                        			<i class="bi bi-check-circle"></i> <?= $is_edit ? 'Update' : 'Create'; ?> Order
                        		</button>
                        	</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            </main>

            <div id="loading-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.28); z-index: 9999; display: flex; justify-content: center; align-items: center;">
                <div class="text-center">
                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h4 class="mt-3">Loading Sales Order Data...</h4>
                </div>
            </div>
        <?php include "include/v2/footerbar.php"; ?>
    </div>
</div>
<?php include "include/v2/footerscripts.php"; ?>
<script>
var addcheck = '<?php echo $addcheck; ?>';
var editcheck = '<?php echo $editcheck; ?>';
var statuscheck = '<?php echo $statuscheck; ?>';
var deletecheck = '<?php echo $deletecheck; ?>';
var approve1check = '<?php echo $approve1check; ?>';
var approve2check = '<?php echo $approve2check; ?>';
var approve3check = '<?php echo $approve3check; ?>';
var approve4check = '<?php echo $approve4check; ?>';
var cancelcheck = '<?php echo $cancelcheck; ?>';

let company_id = "<?php echo ucfirst($_SESSION['company_id']); ?>";
let branch_id = "<?php echo ucfirst($_SESSION['branch_id']); ?>";

let availableJobs = [];
let selectedJobs = [];

let tempAvailableJobs = [];
let tempSelectedJobs = [];

if (<?php echo json_encode($is_edit); ?>) {
    let salesOrderDetails = <?php echo json_encode($salesOrderDetails); ?>;
    let excludeSalesOrderDetails = <?php echo json_encode($excludeSalesOrderDetails); ?>;

    salesOrderDetails.forEach(section => {
        section.details.forEach(detail => {
            availableJobs.push({
                jobId: detail.parent_id,
                subCategory: section.job_sub_category_text,
                optionGroup: detail.option_group_text,
                option: detail.combined_option,
                qty: detail.qty,
                price: parseFloat(detail.price).toFixed(2),
                list_price: parseFloat(detail.list_price).toFixed(2),
                total: parseFloat(detail.total).toFixed(2),
                line_discount: parseFloat(detail.line_discount).toFixed(2),
                net_amount: parseFloat(detail.net_amount).toFixed(2) 
            });
        });
    })

    excludeSalesOrderDetails.forEach(section => {
        section.details.forEach(detail => {
            selectedJobs.push({
                jobId: detail.parent_id,
                subCategory: section.job_sub_category_text,
                optionGroup: detail.option_group_text,
                option: detail.combined_option,
                qty: detail.qty,
                price: parseFloat(detail.price).toFixed(2),
                list_price: parseFloat(detail.list_price).toFixed(2),
                total: parseFloat(detail.total).toFixed(2),
                line_discount: parseFloat(detail.line_discount).toFixed(2),
                net_amount: parseFloat(detail.net_amount).toFixed(2) 
            });
        });
    })
    
    tempAvailableJobs = JSON.parse(JSON.stringify(availableJobs));
    tempSelectedJobs = JSON.parse(JSON.stringify(selectedJobs));
}

$(document).ready(function () {
    $('#loading-overlay').show();
    let loadingPromises = [];

    header_id = "<?= $payment_main_data['id'] ?? 0 ?>";
    if(header_id != 0){
        loadingPromises.push(
            getCustomerJobOrInvoiceDetails().then(function() {
                return loadPayDetail(header_id);
            })
        );
    }

    Promise.all(loadingPromises)
        .then(function() {
            $('#loading-overlay').fadeOut(300);
        })
        .catch(function(error) {
            console.error("Error loading data:", error);
            $('#loading-overlay').html(`
                <div class="text-center text-danger">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <h4>Error loading data</h4>
                    <p>${error.message || 'Please try again'}</p>
                    <button class="btn btn-primary mt-2" onclick="location.reload()">Reload Page</button>
                </div>
            `);
    });

    let jobCardNumber = $('#job_card_number');

    jobCardNumber.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>Invoice/getJobcardNumbers',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                }
            },
            cache: true,
            processResults: function(data) {
                if (data.status == true) {
                    return {
                        results: data.data.item,
                        pagination: {
                            more: data.data.item.length > 0
                        }
                    }
                } else {
                    falseResponse(data);
                }
            }
        }
    });

    $('#job_card_number').on('change', loadJobCard);

});

function loadJobCard() {
    availableJobs = [];
    selectedJobs = [];
    renderTables();
    updatePriceSummary();
	const selectedCard = $('#job_card_number').val();

	if (selectedCard) {
         $('#loading-overlay').show();
		$.ajax({
			url: '<?php echo base_url("Invoice/getJobCardDetails"); ?>',
			type: 'POST',
			data: {
				job_card_id: selectedCard
			},
			dataType: 'json',
			success: function (res) {
				if (res.status && res.data) {
					let data = res.data.main_data[0];
					let index = 1;
					const tbody = $('#availableJobsTable tbody');
					tbody.empty();

					res.data.details_data.forEach(section => {
						section.details.forEach(detail => {
							availableJobs.push({
								jobId: detail.parent_id,
								subCategory: section.job_sub_category_text,
								optionGroup: detail.option_group_text,
								option: detail.combined_option,
								qty: detail.qty,
								price: parseFloat(detail.price).toFixed(2),
                                list_price: parseFloat(detail.list_price).toFixed(2),
                                total: parseFloat(detail.total).toFixed(2),
                                line_discount: parseFloat(detail.line_discount).toFixed(2),
                                net_amount: parseFloat(detail.net_amount).toFixed(2)
							});
							selectedJobs = [];
							renderTables();
							updatePriceSummary();
						});
					});

				} else {
					alert("Job card details not found.");
					availableJobs = [];
					selectedJobs = [];
					renderTables();
					updatePriceSummary();
				}
                $('#loading-overlay').fadeOut(300);
			},
			error: function (xhr) {
				alert("Error fetching job card details.");
				availableJobs = [];
				selectedJobs = [];
				renderTables();
				updatePriceSummary();
                $('#loading-overlay').fadeOut(300);
			}
		});
	}

}

function renderTables() {
	renderAvailableJobs();
	renderSelectedJobs();
	updateCounts();
}

function renderAvailableJobs() {
	const tbody = $('#availableJobsTable tbody');
	tbody.empty();
	let rowCnt = 1;
	$.each(availableJobs, function (index, job) {
		const row = $(`
                        <tr class="job-row" data-job-id="${job.jobId}">
                            <td class="text-center">${rowCnt++}</td>
                            <td class="text-left">${job.subCategory}-${job.optionGroup}-${job.option}</td>
                            <td class="text-center">${job.qty}</td>
                            <td class="text-right">${(parseFloat(job.net_amount).toFixed(2))}</td>
                            <td class="text-center <?= $is_approve ? 'd-none' : ''; ?>">
                                <button class="btn btn-sm btn-primary transfer-btn move-to-selected" data-job-id="${job.jobId}"> <i class="fas fa-arrow-right"></i> </button>
                            </td>
                        </tr>
                    `);
		tbody.append(row);
	});
    
}

$(document).on('click', '.move-to-selected', function () {
	const jobId = $(this).data('job-id');
	moveToSelected(jobId);
});

function renderSelectedJobs() {
	const tbody = $('#excludeJobsTable tbody');
	tbody.empty();
    let rowCnt = 1;
    
	$.each(selectedJobs, function (index, job) {
		const row = $(`
                         <tr class="job-row" data-job-id="${job.jobId}">
                            <td class="text-center">${rowCnt++}</td>
                            <td class="text-left">${job.subCategory}-${job.optionGroup}-${job.option}</td>
                            <td class="text-center">${job.qty}</td>
                            <td class="text-right">${(parseFloat(job.net_amount).toFixed(2))}</td>
                            <td class="text-center <?= $is_approve ? 'd-none' : ''; ?>">
                                <button class="btn btn-sm btn-danger transfer-btn move-to-available" data-job-id="${job.jobId}">
                                     <i class="fas fa-undo"></i>
                                </button>
                            </td>
                        </tr>
                    `);
		tbody.append(row);
	});
}

$(document).on('click', '.move-to-available', function () {
	const jobId = $(this).data('job-id');
	moveToAvailable(jobId);
});

function moveToSelected(jobId) {
	const jobIndex = availableJobs.findIndex(job => job.jobId === jobId);
	if (jobIndex !== -1) {
		const job = availableJobs.splice(jobIndex, 1)[0];
		selectedJobs.push(job);
		renderTables();
		updatePriceSummary();


		// Add animation effect
		$(`#excludeJobsTable tbody tr[data-job-id="${jobId}"]`).addClass('table-success').delay(500).queue(function () {
			$(this).removeClass('table-success').dequeue();
		});
	}
}

function moveToAvailable(jobId) {
	const jobIndex = selectedJobs.findIndex(job => job.jobId === jobId);
	if (jobIndex !== -1) {
		const job = selectedJobs.splice(jobIndex, 1)[0];
		availableJobs.push(job);
		renderTables();
		updatePriceSummary();
		$(`#availableJobsTable tbody tr[data-job-id="${jobId}"]`).addClass('table-warning').delay(500).queue(function () {
			$(this).removeClass('table-warning').dequeue();
		});
	}
}

function updateCounts() {
	$('#availableCount').text(availableJobs.length);
	$('#selectedCount').text(selectedJobs.length);
}

function updatePriceSummary() {
    const totalAvailablePrice = availableJobs.reduce((sum, job) => sum + parseFloat(job.total || 0), 0);
	const orderValue = parseFloat($('#confirmedOrderValue').val()) || 0;
	const difference = totalAvailablePrice - orderValue;

	$('#totalJobsPrice').text(`${totalAvailablePrice.toFixed(2)}`);
    $('#totalJobsPriceHidden').val(totalAvailablePrice.toFixed(2));
	$('#displayOrderValue').text(`${orderValue.toFixed(2)}`);

	const $differenceElement = $('#priceDifference');
	const $statusElement = $('#priceStatus');

	if (difference == 0 && totalAvailablePrice > 0 && orderValue > 0) {
		$differenceElement.text(`${difference.toFixed(2)}`).removeClass().addClass('text-success');
		$statusElement.text('Match').removeClass().addClass('badge status-badge bg-success');
		$('#confirmBtn').prop('disabled', false);
	} else if (difference > 0) {
		$differenceElement.text(`+${difference.toFixed(2)}`).removeClass().addClass('text-warning');
		$statusElement.text('Over Budget').removeClass().addClass('badge status-badge bg-warning');
		$('#confirmBtn').prop('disabled', true);
	} else if (difference < 0 && orderValue > 0) {
		$differenceElement.text(`${difference.toFixed(2)}`).removeClass().addClass('text-danger');
		$statusElement.text('Under Budget').removeClass().addClass('badge status-badge bg-info');
		$('#confirmBtn').prop('disabled', false);
	} else {
		$differenceElement.text('0.00').removeClass().addClass('text-muted');
		$statusElement.text('Pending').removeClass().addClass('badge status-badge bg-secondary');
		$('#confirmBtn').prop('disabled', true);
	}
}

function confirmOrder() {
	
    $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                recordID: "<?= $relationDetails ? $relationDetails['id'] : 0; ?>",
                recordOption: "<?= $is_edit ? 2 : 1; ?>",
                availableJobs:availableJobs,
                selectedJobs:selectedJobs,
                tempAvailableJobs: tempAvailableJobs,
                tempSelectedJobs: tempSelectedJobs,
                jobCardId: $('#job_card_number').val(),
                confirmedOrderValue: $('#confirmedOrderValue').val()
            },
            url: '<?php echo base_url() ?>SalesOrder/SalesOrderInsertUpdate',
            success: function(result) {
                if (result.status == true) {  
                    success_toastify(result.message);
                    setTimeout(function() {
                        window.location.href = '<?= base_url("SalesOrder/salesOrderDetailIndex/") ?>' + result.data.relation_id;
                    }, 500)
                } else {
                    falseResponse(result);
                }
            }
        });

		// $('#jobCardSelect').val('');
		// $('#confirmedOrderValue').val('');
		// availableJobs = [];
		// selectedJobs = [];
		// renderTables();
		// updatePriceSummary();

		// // Add success animation to confirm button
		// $('#confirmBtn').removeClass('btn-success').addClass('btn-outline-success').text('Confirmed!');
		// setTimeout(() => {
		// 	$('#confirmBtn').removeClass('btn-outline-success').addClass('btn-success').html('<i class="bi bi-check-circle"></i> Confirm Order');
		// }, 2000);
}

function approveConfirm() {
    var recordID = "<?= $relationDetails ? $relationDetails['id'] : 0; ?>";
    if (confirm("Are you sure you want to approve this?")) {
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                recordID: recordID,
            },
            url: '<?php echo base_url() ?>SalesOrder/Approve',
            success: function(result) {
                if (result.status == true) {
                    success_toastify(result.message);
                    setTimeout(function() {
                        window.location.href = '<?= base_url("SalesOrder/salesOrderDetailIndex/") ?>' + recordID;
                    }, 500)
                } else {
                    falseResponse(result);
                }
            }
        });
    }
}


renderTables();
updatePriceSummary();

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