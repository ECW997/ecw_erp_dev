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
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card">
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
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </main>

        <?php include "include/v2/footerbar.php"; ?>
    </div>
</div>
<?php include "include/v2/footerscripts.php"; ?>
<script>

let company_id = "<?php echo ucfirst($_SESSION['company_id']); ?>";
let branch_id = "<?php echo ucfirst($_SESSION['branch_id']); ?>";

let availableJobs = [];

let tempAvailableJobs = [];

if (<?php echo json_encode($is_edit); ?>) {
    let salesOrderDetails = <?php echo json_encode($salesOrderDetails); ?>;

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
    tempAvailableJobs = JSON.parse(JSON.stringify(availableJobs));
}


let totalFullJobPrice = 0;

function renderTables() {
	renderAvailableJobs();
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
renderTables();

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
                $('#paymenttype').removeClass('d-none');
                buffer = "";
            }
            if (buffer === hideSecret) {
                $('#excludeReceiptBtn').hide();
                $('#paymenttype').addClass('d-none');
                buffer = "";
            }
        }
    });
});
</script>
<?php include "include/footer.php"; ?>