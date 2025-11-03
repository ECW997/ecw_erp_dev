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

/* Modern Approval Modal */
.approval-modal {
    border-radius: 20px;
    border: none;
    padding: 20px 25px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    animation: fadeInScale 0.3s ease-in-out;
}

.approval-modal .modal-body {
    padding: 1rem;
}

.approval-modal .modal-title {
    font-weight: 600;
    font-size: 1.2rem;
    color: #2c3e50;
}

.approval-modal p {
    font-size: 0.95rem;
}

.check-icon {
    font-size: 3rem;
    color: #28a745;
    animation: popIn 0.4s ease;
}

/* Button styling */
.approval-modal .btn {
    border-radius: 30px;
    padding: 10px 15px;
    font-weight: 500;
    transition: all 0.25s ease;
}

.approval-modal .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Animations */
@keyframes fadeInScale {
    0% { opacity: 0; transform: scale(0.9); }
    100% { opacity: 1; transform: scale(1); }
}

@keyframes popIn {
    0% { transform: scale(0.5); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.stylish-invoice-btn {
            background: linear-gradient(90deg, #ffd700 0%, #ffb347 100%);
            transition: box-shadow 0.2s, transform 0.2s, background 0.2s;
        }

        .stylish-invoice-btn:hover {
            background: linear-gradient(90deg, #ffb347 0%, #ffd700 100%);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px) scale(1.03);
        }

        .stylish-invoice-btn .fa-arrow-left,
        .stylish-invoice-btn .fa-file-invoice {
            font-size: 1.1em;
        }


        .stylish-payment-btn {
            background: linear-gradient(90deg, #ec5b78ff 0%, #f30a35ff 100%);
            transition: box-shadow 0.2s, transform 0.2s, background 0.2s;
            font-weight: 600;
            border: none;
            box-shadow: 0 4px 12px rgba(236, 9, 54, 0.15);
        }

        .stylish-payment-btn:hover {
            background: linear-gradient(90deg, #ec5b78ff 0%, #f30a35ff 100%);
            box-shadow: 0 6px 18px rgba(245, 3, 52, 0.25);
            transform: translateY(-2px) scale(1.03);
        }

        .stylish-payment-btn .fa-arrow-right,
        .stylish-payment-btn .fa-money-check-alt {
            font-size: 1.1em;
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
                                <div class="d-inline-flex gap-2">
                                    <button type="button"
                                        class="btn rounded-3 action-btn-fixed px-4 py-2 fs-6 stylish-payment-btn"
                                        style="min-width:180px; height:44px;"
                                        onclick="window.location.href='<?= base_url('JobCard') ?>'">
                                        <span class="d-flex align-items-center justify-content-center gap-2">
                                            <i class="fas fa-file-invoice text-white"></i>
                                            <i class="fas fa-arrow-left text-white"></i>
                                            <span class="fw-bold text-white">Job Card List</span>
                                        </span>
                                    </button>
                                    <button type="button"
                                        class="btn btn-warning rounded-3 action-btn-fixed px-4 py-2 fs-6 stylish-invoice-btn"
                                        style="min-width:180px; height:44px; font-weight:600; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none;"
                                        onclick="window.location.href='<?= base_url('SalesOrder') ?>'">
                                        <span class="d-flex align-items-center justify-content-center gap-2">
                                            <i class="fas fa-arrow-left text-dark"></i>
                                            <i class="fas fa-money-check-alt text-dark"></i>
                                            <span class="text-dark fw-bold">Sales Order List</span>
                                        </span>
                                    </button>
                                </div>
                            </div>


                            <!-- <div class="col-md-8 text-md-end">
                                <button type="button" class="btn btn-warning rounded-2 action-btn px-3 py-2 fs-6"
                                    onclick="window.location.href='<?= base_url('SalesOrder') ?>'">
                                    <i class="fas fa-arrow-left me-1 text-dark"></i>
                                    <i class="fas fa-file-invoice me-1 text-dark"></i>
                                    <span class="text-dark fw-bold">Sales Order List</span>
                                </button>
                            </div> -->
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
                                        onclick="approveConfirm();" id="approve-btn">
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
                                         <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-primary" id="availableCount">0</span>
                                            <button title="All Transfer" class="btn btn-sm btn-danger all-transfer-btn <?= $is_approve ? 'd-none' : '' ?>" onclick="moveAllToSelected()">
                                                <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-container">
                                            <table class="table table-bordered table-sm" id="availableJobsTable">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Description</th>
                                                        <th class="text-center">QTY</th>
                                                        <th class="text-end">Sub Total</th>
                                                        <th class="text-end">Line Discount</th>
                                                        <th class="text-end">Total Price</th>
                                                        <th class="text-center <?= $is_approve ? 'd-none' : ''; ?>">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot class="table-group-divider">
                                                    <tr>
                                                        <th colspan="3" class="text-end">Total</th>
                                                        <th class="text-end" id="availableJobsSubTotal">0.00</th>
                                                        <th class="text-end" id="availableJobsLineDiscount">0.00</th>
                                                        <th class="text-end" id="availableJobsTotalPrice">0.00</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Exclude Jobs</h5>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="input-group input-group-sm">
                                                <select class="form-control form-control-sm selecter2 px-2 d-none" name="paymenttype"
                                                    id="paymenttype" required>
                                                    <option value="1" <?= (isset($relationDetails['payment_type']) && $relationDetails['payment_type'] == '1') ? 'selected' : '' ?>>
                                                        Non-Credit
                                                    </option>
                                                    <option value="2" <?= (isset($relationDetails['payment_type']) && $relationDetails['payment_type'] == '2') ? 'selected' : '' ?>>
                                                        Credit
                                                    </option>
                                                </select>
                                            </div>
                                            <button title="Receipt" id="excludeReceiptBtn" class="btn btn-sm btn-info exclude-receipt-btn" style="display:none;"onclick="exportPaymentReceiptV2(<?= isset($excludeSalesOrderHeader[0]['exclude_invoice_id']) ? $excludeSalesOrderHeader[0]['exclude_invoice_id'] : 0 ?>)">
                                                <i class="fas fa-file-invoice"></i>
                                            </button>
                                            <button title="Receipt" id="excludeReceiptBtn_1" class="btn btn-sm btn-secondary exclude-receipt-btn" style="display:none;"onclick="exportPaymentReceiptV1(<?= isset($excludeSalesOrderHeader[0]['exclude_invoice_id']) ? $excludeSalesOrderHeader[0]['exclude_invoice_id'] : 0 ?>)">
                                                <i class="fas fa-file-invoice"></i>
                                            </button>
                                            <button title="All Transfer" class="btn btn-sm btn-danger all-transfer-btn <?= $is_approve ? 'd-none' : '' ?>" onclick="moveAllToAvailable()">
                                                <i class="fas fa-arrow-left"></i>
                                            </button>
                                            <span class="badge bg-success" id="selectedCount">0</span>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-container">
                                            <table class="table table-bordered table-sm" id="excludeJobsTable">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Description</th>
                                                        <th class="text-center">QTY</th>
                                                        <th class="text-end">Sub Total</th>
                                                        <th class="text-end">Line Discount</th>
                                                        <th class="text-end">Total Price</th>
                                                        <th class="text-center <?= $is_approve ? 'd-none' : ''; ?>">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot class="table-group-divider">
                                                    <tr>
                                                        <th colspan="3" class="text-end">Total</th>
                                                        <th class="text-end" id="selectedJobsSubTotal">0.00</th>
                                                        <th class="text-end" id="selectedJobsLineDiscount">0.00</th>
                                                        <th class="text-end" id="selectedJobsTotalPrice">0.00</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                        	<div class="col-md-10">
                        		<div class="price-summary">
                        			<div class="row text-center">
                                        <div class="col-md-2">
                        					<h6 class="text-gray-800">Sub Total</h6>
                        					<h4 class="text-primary d-none" id="subTotal">0.00</h4>
                                            <h4 class="text-primary" id="subTotalText">0.00</h4>
                        				</div>
                                        <div class="col-md-2">
                        					<h6 class="text-gray-800">Header Discount</h6>
                        					<h4 class="text-warning d-none" id="HeaderDiscountPrice"><?= isset($relationDetails['header_discount']) ? $relationDetails['header_discount'] : '0.00' ?></h4>
                                            <h4 class="text-warning" id="HeaderDiscountPriceText"><?= isset($relationDetails['header_discount']) ? number_format($relationDetails['header_discount'], 2) : '0.00' ?></h4>
                        				</div> 
                        				<div class="col-md-2">
                        					<h6 class="text-gray-800">Total Payble Jobs Price</h6>
                        					<h4 class="text-primary d-none" id="totalJobsPrice">0.00</h4>
                                            <h4 class="text-primary" id="totalJobsPriceText">0.00</h4>
                                            <input type="hidden" id="totalJobsPriceHidden">
                        				</div>
                        				<div class="col-md-2">
                        					<h6 class="text-gray-800">Confirmed Order Value</h6>
                        					<h4 class="text-info d-none" id="displayOrderValue">0.00</h4>
                                            <h4 class="text-info" id="displayOrderValueText">0.00</h4>
                        				</div>
                        				<div class="col-md-2 d-none">
                        					<h6 class="text-gray-800">Cash</h6>
                        					<h4 class="d-none" id="priceDifference">0.00</h4>
                                            <h4 id="priceDifferenceText">0.00</h4>
                        				</div>
                        				<!-- <div class="col-md-3">
                        					<h6 class="text-gray-800">Status</h6>
                        					<span class="badge status-badge" id="priceStatus">Pending</span>
                        				</div> -->
                        			</div>
                        		</div>
                        	</div>
                             <?php if ($is_approve): ?>
                                <div class="col-md-2 d-flex align-items-center justify-content-end">
                                    <span class="badge bg-success">This order has been approved and cannot be modified.</span>
                                </div>
                            <?php else: ?>
                        	<div class="col-md-2 d-flex align-items-center justify-content-end">
                        		<button class="btn btn-primary btn-sm px-4 <?= $is_button_hidden ? 'd-none' : '' ?>" id="confirmBtn" onclick="confirmOrder();">
                        			<i class="bi bi-check-circle"></i> <?= $is_edit ? 'Update' : 'Create'; ?> Order
                        		</button>
                        	</div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-2">
                        	<h6 class="text-gray-800">Advance Payment</h6>
                        	<h4 class="text-warning d-none" id="HeaderAdvancepaymentPrice">
                                <?= isset($relationDetails['advance_payment_series']) 
                                    ? ($relationDetails['advance_payment_series'] == 1 
                                        ? $relationDetails['advance_total_s1'] 
                                        : $relationDetails['advance_total_s2']) 
                                    : '0.00' ?>
                            </h4>
                            <h4 class="<?= (isset($relationDetails['advance_payment_series']) && $relationDetails['advance_payment_series'] == 2) ? 'text-danger' : 'text-warning' ?>" 
                                id="HeaderAdvancepaymentPriceText">
                                <?= isset($relationDetails['advance_payment_series']) 
                                    ? number_format(
                                        $relationDetails['advance_payment_series'] == 1 
                                            ? $relationDetails['advance_total_s1'] 
                                            : $relationDetails['advance_total_s2'], 
                                        2
                                    ) 
                                    : '0.00' ?>
                            </h4>
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

            <div class="modal fade" id="approveInvoiceModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content approval-modal">
                    <div class="modal-body text-center">
                        <div class="check-icon mb-3">
                        <i class="fas fa-check-circle"></i>
                        </div>
                        <h5 class="modal-title mb-2">Approval Successful</h5>
                        <p class="text-muted mb-4">The sales order has been approved.<br>What would you like to do next?</p>
                        <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary d-none" id="btnGoInvoice">
                            <i class="fas fa-file-invoice me-3"></i> Go to Invoice
                        </button>
                        <button type="button" class="btn btn-primary d-none" id="printReceipt">
                            <i class="fas fa-file-invoice me-3"></i> Print Receipt
                        </button>
                        <button type="button" class="btn btn-success" id="btnNewSalesOrder">
                            <i class="fas fa-plus-circle me-3"></i> Create New Sales Order
                        </button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-3"></i> Cancel
                        </button>
                        </div>
                    </div>
                    </div>
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

let realJobCardId = "<?php echo $jobCardId ?? ''; ?>";
let realJobCardNo = "<?php echo $jobCardNo ?? ''; ?>";

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

    let jobCardNumber = $('#job_card_number');

    if (realJobCardId && realJobCardNo) {
        loadingPromises.push(
            new Promise(function(resolve) {
                let jobCardNumber = $('#job_card_number');
                var option = new Option(realJobCardNo, realJobCardId, true, true);
                jobCardNumber.append(option).trigger('change');
                resolve(); 
            }).then(function() {
                return loadJobCard();
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

    jobCardNumber.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>SalesOrder/getJobcardNumbers',
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
let totalFullJobPrice = 0;
function loadJobCard() {
	return new Promise(function (resolve, reject) {
		availableJobs = [];
		selectedJobs = [];
		renderTables();
		updatePriceSummary();
		const selectedCard = $('#job_card_number').val();

		if (!selectedCard) {
			resolve();
			return;
		}
		//  $('#loading-overlay').show();
		$.ajax({
			url: '<?php echo base_url("SalesOrder/getJobCardDetails"); ?>',
			type: 'POST',
			data: {
				job_card_id: selectedCard
			},
			dataType: 'json',
			success: function (res) {
				if (res.status && res.data) {
					let data = res.data.main_data[0];
                    let summary_data = res.data.summary_data[0];
                    
					let index = 1;
					const tbody = $('#availableJobsTable tbody');
					tbody.empty();
					res.data.details_data.forEach(section => {
						section.details.forEach(detail => {
							const net_amount = parseFloat(detail.net_amount) || 0;
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
							totalFullJobPrice += net_amount;
							selectedJobs = [];
							renderTables();
						});
					});

					$('#totalJobsPriceHidden').val(parseFloat(res.data.main_data[0].net_total).toFixed(2));
					$('#confirmedOrderValue').val(parseFloat(res.data.main_data[0].net_total).toFixed(2));
					$('#subTotal').text(parseFloat(totalFullJobPrice).toFixed(2));
					$('#subTotalText').text(formatCurrency(totalFullJobPrice));

                    $('#HeaderAdvancepaymentPrice').text(summary_data.advance);
                    $('#HeaderAdvancepaymentPriceText').text(formatCurrency(summary_data.advance));
                    if (summary_data.advance_payment_series === 2) {
                        $('#HeaderAdvancepaymentPriceText')
                            .removeClass('text-warning')
                            .addClass('text-danger');
                    } else {
                        $('#HeaderAdvancepaymentPriceText')
                            .removeClass('text-danger')
                            .addClass('text-warning');
                    }
					if (res.data.header_discount_status == 'Approved') {
						$('#HeaderDiscountPrice').text(parseFloat(res.data.main_data[0].discount_amount).toFixed(2));
						$('#HeaderDiscountPriceText').text(formatCurrency(res.data.main_data[0].discount_amount));
					} else {
						$('#HeaderDiscountPrice').text('0.00');
						$('#HeaderDiscountPriceText').text('0.00');
					}

					$('#totalJobsPrice').text(parseFloat(res.data.main_data[0].net_total).toFixed(2));
					$('#totalJobsPriceText').text(formatCurrency(res.data.main_data[0].net_total));
					updatePriceSummary();
					resolve(res);
				} else {
					alert("Job card details not found.");
					availableJobs = [];
					selectedJobs = [];
					renderTables();
					updatePriceSummary();
					$('#totalJobsPriceHidden').val(totalFullJobPrice);
					$('#confirmedOrderValue').val(totalFullJobPrice);
					resolve();
				}
				// $('#loading-overlay').fadeOut(300);
			},
			error: function (xhr) {
				alert("Error fetching job card details.");
				availableJobs = [];
				selectedJobs = [];
				renderTables();
				updatePriceSummary();
				// $('#loading-overlay').fadeOut(300);
				$('#totalJobsPriceHidden').val(totalFullJobPrice);
				$('#confirmedOrderValue').val(totalFullJobPrice);
				reject(new Error('Failed to load job card details'));
			}
		});
	});

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

    let subTotalSum = 0;
    let lineDiscountSum = 0;
    let totalPriceSum = 0;

	$.each(availableJobs, function (index, job) {
		const row = $(`
                        <tr class="job-row" data-job-id="${job.jobId}">
                            <td class="text-center">${rowCnt++}</td>
                            <td class="text-left">${job.subCategory}-${job.optionGroup}-${job.option}</td>
                            <td class="text-center">${job.qty}</td>
                            <td class="text-right">${job.total}</td>
                            <td class="text-right">${job.line_discount}</td>
                            <td class="text-right">${(parseFloat(job.net_amount).toFixed(2))}</td>
                            <td class="text-center <?= $is_approve ? 'd-none' : ''; ?>">
                                <button class="btn btn-sm btn-primary transfer-btn move-to-selected" data-job-id="${job.jobId}"> <i class="fas fa-arrow-right"></i> </button>
                            </td>
                        </tr>
                    `);
		tbody.append(row);

        subTotalSum += parseFloat(job.total) || 0;
        lineDiscountSum += parseFloat(job.line_discount) || 0;
        totalPriceSum += parseFloat(job.net_amount) || 0;
	});

    $('#availableJobsSubTotal').text(formatCurrency(subTotalSum));
    $('#availableJobsLineDiscount').text(formatCurrency(lineDiscountSum));
    $('#availableJobsTotalPrice').text(formatCurrency(totalPriceSum));
    
}

$(document).on('click', '.move-to-selected', function () {
	const jobId = $(this).data('job-id');
	moveToSelected(jobId);
});

function renderSelectedJobs() {
	const tbody = $('#excludeJobsTable tbody');
	tbody.empty();
    let rowCnt = 1;

    let subTotalSum = 0;
    let lineDiscountSum = 0;
    let totalPriceSum = 0;
    
	$.each(selectedJobs, function (index, job) {
		const row = $(`
                         <tr class="job-row" data-job-id="${job.jobId}">
                            <td class="text-center">${rowCnt++}</td>
                            <td class="text-left">${job.subCategory}-${job.optionGroup}-${job.option}</td>
                            <td class="text-center">${job.qty}</td>
                            <td class="text-right">${job.total}</td>
                            <td class="text-right">${job.line_discount}</td>
                            <td class="text-right">${(parseFloat(job.net_amount).toFixed(2))}</td>
                            <td class="text-center <?= $is_approve ? 'd-none' : ''; ?>">
                                <button class="btn btn-sm btn-danger transfer-btn move-to-available" data-job-id="${job.jobId}">
                                     <i class="fas fa-undo"></i>
                                </button>
                            </td>
                        </tr>
                    `);
		tbody.append(row);

        subTotalSum += parseFloat(job.total) || 0;
        lineDiscountSum += parseFloat(job.line_discount) || 0;
        totalPriceSum += parseFloat(job.net_amount) || 0;
	});

    $('#selectedJobsSubTotal').text(formatCurrency(subTotalSum));
    $('#selectedJobsLineDiscount').text(formatCurrency(lineDiscountSum));
    $('#selectedJobsTotalPrice').text(formatCurrency(totalPriceSum));
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

function moveAllToSelected() {
    if (availableJobs.length > 0) {
        selectedJobs = selectedJobs.concat(availableJobs);
        availableJobs = [];

        renderTables();
        updatePriceSummary();

        $('#excludeJobsTable tbody tr').addClass('table-success').delay(500).queue(function () {
            $(this).removeClass('table-success').dequeue();
        });

        $('#confirmedOrderValue').val('0');
        $('#displayOrderValue').text('0');
        $('#displayOrderValueText').text('0.00');
    }
}

function moveAllToAvailable() {
    if (selectedJobs.length > 0) {
        availableJobs = availableJobs.concat(selectedJobs);
        selectedJobs = [];

        renderTables();
        updatePriceSummary();

        $('#availableJobsTable tbody tr').addClass('table-warning').delay(500).queue(function () {
            $(this).removeClass('table-warning').dequeue();
        });

        let totalJobsPrice = parseFloat($('#totalJobsPriceHidden').val()) || 0;
        $('#confirmedOrderValue').val(totalJobsPrice);
        $('#displayOrderValue').text(totalJobsPrice);
        $('#displayOrderValueText').text(formatCurrency(totalJobsPrice));
    }
}

function updateCounts() {
	$('#availableCount').text(availableJobs.length);
	$('#selectedCount').text(selectedJobs.length);
}

function updatePriceSummary() {
    const totalAvailablePrice = availableJobs.reduce((sum, job) => sum + parseFloat(job.net_amount || 0), 0);
    
    const headerDiscount = parseFloat($('#HeaderDiscountPrice').text()) || 0;
    const totalAvailableJobprice = totalAvailablePrice - headerDiscount;
	const orderValue = parseFloat($('#confirmedOrderValue').val()) || 0;
	const difference = totalAvailableJobprice - orderValue;

    $('#subTotal').text(`${totalAvailablePrice.toFixed(2)}`);
    $('#subTotalText').text(formatCurrency(totalAvailablePrice));
	$('#totalJobsPrice').text(`${totalAvailableJobprice.toFixed(2)}`);
    $('#totalJobsPriceText').text(formatCurrency(totalAvailableJobprice));
	$('#displayOrderValue').text(`${orderValue.toFixed(2)}`);
    $('#displayOrderValueText').text(formatCurrency(orderValue));
    $('#confirmedOrderValue').val(totalAvailableJobprice < 0 ? 0 : totalAvailableJobprice);

	const $differenceElement = $('#priceDifference');
    const $differenceElementText = $('#priceDifferenceText');
	const $statusElement = $('#priceStatus');

	if (difference == 0 && totalAvailableJobprice > 0 && orderValue > 0) {
		$differenceElement.text(`${difference.toFixed(2)}`).removeClass().addClass('text-success d-none');
        $differenceElementText.text(formatCurrency(difference)).removeClass().addClass('text-success');
		$statusElement.text('Match').removeClass().addClass('badge status-badge bg-success');
		// $('#confirmBtn').prop('disabled', false);
	} else if (difference > 0) {
		$differenceElement.text(`+${difference.toFixed(2)}`).removeClass().addClass('text-warning d-none');
        $differenceElementText.text(formatCurrency(difference)).removeClass().addClass('text-warning');
		$statusElement.text('Over Budget').removeClass().addClass('badge status-badge bg-warning');
		// $('#confirmBtn').prop('disabled', true);
	} else if (difference < 0 && orderValue > 0) {
		$differenceElement.text(`${difference.toFixed(2)}`).removeClass().addClass('text-danger d-none');
        $differenceElementText.text(formatCurrency(difference)).removeClass().addClass('text-danger');
		$statusElement.text('Under Budget').removeClass().addClass('badge status-badge bg-info');
		// $('#confirmBtn').prop('disabled', false);
	} else {
		$differenceElement.text('0.00').removeClass().addClass('text-muted d-none');
        $differenceElementText.text('0.00').removeClass().addClass('text-muted');
		$statusElement.text('Pending').removeClass().addClass('badge status-badge bg-secondary');
		// $('#confirmBtn').prop('disabled', true);
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
                confirmedOrderValue: $('#confirmedOrderValue').val(),
                headerDiscount: $('#HeaderDiscountPrice').text(),
                paymenttype: $('#paymenttype').val()
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
        $('#approve-btn').prop('disabled', true);
        $('#confirmBtn').prop('disabled', true);
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
                        if (result.data) {
                            $("#approveInvoiceModal").modal("show");

                            if(result.data.invoice_id){
                                $('#btnGoInvoice').removeClass('d-none');
                                $("#btnGoInvoice").off("click").on("click", function() {
                                    window.location.href = '<?= base_url("Invoice/invoiceDetailIndex/") ?>' + result.data.invoice_id + '/1';
                                 });
                            }else{
                                if(result.data.payment_type == '1'){
                                    $('#printReceipt').removeClass('d-none');
                                    $("#printReceipt").off("click").on("click", function() {
                                        exportPaymentReceiptV2(result.data.exclude_invoice_id);
                                    });
                                }else{
                                    $('#btnGoInvoice').removeClass('d-none');
                                    $("#btnGoInvoice").off("click").on("click", function() {
                                        window.location.href = '<?= base_url("Invoice/invoiceDetailIndex/") ?>' + result.data.exclude_invoice_id + '/2';
                                    });
                                }
                            }
                           
                            $("#btnNewSalesOrder").off("click").on("click", function() {
                                $('#approve-btn').prop('disabled', false);
                                window.location.href = '<?= base_url('SalesOrder/salesOrderDetailIndex') ?>';
                            });
                        } else {
                            $('#approve-btn').prop('disabled', false);
                            window.location.href = '<?= base_url("SalesOrder/salesOrderDetailIndex/") ?>' + recordID;
                        }
                    }, 500)
                } else {
                    $('#approve-btn').prop('disabled', false);
                    falseResponse(result);
                }
            }
        });
    }
}

function exportPaymentReceiptV2(invoice_id) {
    const type = "full";
    const baseUrl = "<?php echo base_url(); ?>Payment/paymentReceiptV2PDF";
    const url = `${baseUrl}?receipt_id=${encodeURIComponent(invoice_id)}&type=${encodeURIComponent(type)}`;
    window.open(url, '_blank');
}

function exportPaymentReceiptV1(invoice_id) {
    const type = "full";
    const baseUrl = "<?php echo base_url(); ?>Payment/paymentReceiptV3PDF";
    const url = `${baseUrl}?receipt_id=${encodeURIComponent(invoice_id)}&type=${encodeURIComponent(type)}`;
    window.open(url, '_blank');
}

renderTables();
updatePriceSummary();

function formatCurrency(value) {
    if (!value || isNaN(value)) return "0.00";
    return parseFloat(value).toLocaleString(undefined, { 
        minimumFractionDigits: 2, 
        maximumFractionDigits: 2 
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

<script>
$(document).ready(function() {
    let showSecret = "boom";
    let hideSecret = "hide";
    let buffer = "";

    $(document).on('keydown', function(e) {
        if (e.key.length === 1 && /[a-zA-Z]/.test(e.key)) {
            buffer += e.key.toLowerCase();
            if (buffer.length > Math.max(showSecret.length, hideSecret.length)) {
                buffer = buffer.slice(-Math.max(showSecret.length, hideSecret.length));
            }
            if (buffer === showSecret) {
                $('#excludeReceiptBtn').show();
                $('#excludeReceiptBtn_1').show();
                $('#paymenttype').removeClass('d-none');
                buffer = "";
            }
            if (buffer === hideSecret) {
                $('#excludeReceiptBtn').hide();
                $('#excludeReceiptBtn_1').hide();
                $('#paymenttype').addClass('d-none');
                buffer = "";
            }
        }
    });
});
</script>
<?php include "include/footer.php"; ?>