<div class="modal fade" id="jobcardApproveModel" tabindex="-1" aria-labelledby="jobcardApproveModelLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-black" id="jobcardApproveModelLabel">Job Card Approval</h5>
                <!-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h5>Standard Price: </h5>
                        </div>
                        <div class="col-6 text-end">
                            <span class="text-primary fw-bold" id="standard_price_display">
                                Rs. <?= number_format($summary_data[0]['sub_total'] ?? 0, 2) ?>
                            </span>
                            <input type="hidden" id="standard_price" value="<?= $summary_data[0]['sub_total'] ?? 0 ?>">
                            <input type="hidden" id="jobcard_id"
                                value="<?= $job_main_data[0]['idtbl_jobcard'] ?? $jobcard_id ?? '' ?>">
                            <input type="hidden" id="jobcard_approve_status"
                                value="<?= $job_main_data[0]['approve_request_status'] ?? '' ?>">
                        </div>
                    </div>
                    <div id="jobcard_status_message" class="mt-2 fw-bold" style="margin-bottom: 50px;"></div>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td><label class="small fw-bold">Line Change</label></td>
                                <td class="text-danger">
                                    <span id="line_discount_precentage_show">
                                    </span>
                                    <input type="hidden" class="form-control form-control-sm"
                                        id="line_discount_precentage" placeholder="Enter amount">
                                </td>

                                <td class="text-danger text-end">
                                    <span id="line_discount_show">
                                        Rs. <?= number_format($summary_data[0]['total_line_discount'] ?? 0, 2) ?>
                                    </span>
                                    <input type="hidden" class="form-control form-control-sm" id="line_discount"
                                        value="<?= $summary_data[0]['total_line_discount'] ?? $jobcard_id ?? '' ?>">
                                </td>
                            </tr>


                            <tr>
                                <td><label class="small fw-bold ">Header Discount</label></td>

                                <td class="text-danger"><span id="header_discount_precentage_show">
                                        <?= number_format($job_main_data[0]['discount'] ?? 0, 2) ?>%
                                        <input type="hidden" class="form-control form-control-sm"
                                            id="header_discount_precentage"
                                            value="<?= $job_main_data[0]['discount'] ?? 0 ?>"></td>

                                <td class="text-danger text-end"><span id="header_discount_show">
                                        Rs. <?= number_format($job_main_data[0]['discount_amount'] ?? 0, 2) ?>
                                        <input type="hidden" class="form-control form-control-sm" id="header_discount"
                                            value="<?= $job_main_data[0]['discount_amount'] ?? 0 ?>"></td>
                            </tr>



                            <tr>
                                <td><label class="small fw-bold ">Net Discount </label></td>

                                <td class="text-danger">
                                    <span id="net_discount_precentage_show">

                                    </span>
                                    <input type="hidden" class="form-control form-control-sm"
                                        id="net_discount_precentage" placeholder="Enter amount">
                                </td>

                                <td class="text-danger text-end">
                                    <span id="net_discount_show">

                                    </span>
                                    <input type="hidden" class="form-control form-control-sm" id="net_discount"
                                        placeholder="Enter amount">
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="row mt-4">
                        <div class="col-6">
                            <h5>Net Price: </h5>
                        </div>
                        <div class="col-6 text-end">
                            <span class="text-dark fw-bold" id="net_price_show">
                            </span>
                            <input type="hidden" class="form-control form-control-sm" id="net_price"
                                placeholder="Enter amount">

                        </div>
                    </div>


                    <?php
                                    $currentPrice = $summary_data[0]['sub_total'] ?? 0;
                                    $changeAmount = $summary_data[0]['total_line_discount'] ?? 0;
                                    $changePercentage = $job_main_data[0]['discount'] ?? 0;
                                    $listPrice = $job_main_data[0]['sub_total'] ?? 0;

                                    $tooltipText = '
                                     <div class="custom-tooltip-box text-start">
                                        <div class="d-flex justify-content-between">
                                            <span>Standard :</span>
                                            <span class="ml-3 text-success">' . number_format($currentPrice, 2) . '</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Change Amount:</span>
                                            <span class="ml-3 text-danger">' . number_format($changeAmount, 2) . '</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Change %:</span>
                                            <span class="ml-3 text-danger">' . number_format($changePercentage, 2) . '%</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Price:</span>
                                            <span class="ml-3">' . number_format($listPrice, 2) . '</span>
                                        </div>
                                    </div>';
                                    ?>

                    <div class="row mt-4">
                        <div class="col-2">
                            <button type="button" class="btn btn-primary btn-sm" id="logsBtn"
                                style="border-radius: 12px;" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-html="true" title="<?= htmlspecialchars($tooltipText, ENT_QUOTES); ?>">
                                <i class="fa-solid fa-file me-1"></i> Logs
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-4">
                        <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal"
                            style="border-radius: 12px; font-weight:bold;">Close</button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-success w-100" id="approveJobcardBtn"
                            style="border-radius: 12px;" onclick="approveJobcard()">Approve</button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-danger w-100" id="deniedJobcardBtn"
                            style="border-radius: 12px;" onclick="deniedJobcard()">Denied</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- <div class="modal fade" id="hoverModal" tabindex="-1" aria-labelledby="hoverModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                Are you sure you want to approve this job card?
            </div>
        </div>
    </div>
</div> -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('jobcardApproveModel');
    modal.addEventListener('shown.bs.modal', function() {
        calculateLineDiscountPercentage();
        calculateNetDiscount();
        calculateNetPrice();

        const status = document.getElementById('jobcard_approve_status').value;
        const discount = document.getElementById('net_discount').value;
        const approveBtn = document.getElementById('approveJobcardBtn');
        const deniedBtn = document.getElementById('deniedJobcardBtn');

        console.log("Job Card discount:", discount);
        console.log("Job Card status:", status);

        approveBtn.style.display = "block";
        deniedBtn.style.display = "block";
        approveBtn.disabled = false;
        deniedBtn.disabled = false;

        if (parseFloat(discount) === 0) {
            approveBtn.disabled = true;
            deniedBtn.disabled = true;
            return;
        }

        if (status === '0' || status === '1') {} else if (status === '2') {
            approveBtn.disabled = true;
        } else if (status === '3') {
            deniedBtn.disabled = true;
        } else {
            approveBtn.style.display = "none";
            deniedBtn.style.display = "none";
        }
    });

});
</script>


<script>
function showJobCardStatusMessage() {
    const status = document.getElementById('jobcard_approve_status').value;
    const messageDiv = document.getElementById('jobcard_status_message');

    if (status === '2') {
        messageDiv.textContent = "This Job Card is already Approved";
        messageDiv.classList.remove('text-danger');
        messageDiv.classList.add('text-success');
    } else if (status === '3') {
        messageDiv.textContent = "This Job Card is already Rejected";
        messageDiv.classList.remove('text-success');
        messageDiv.classList.add('text-danger');
    } else {
        messageDiv.textContent = "";
        messageDiv.classList.remove('text-success', 'text-danger');
    }
}

showJobCardStatusMessage();
</script>

<script>
function calculateLineDiscountPercentage() {
    let price = parseFloat(document.getElementById('standard_price').value) || 0;
    let lineDiscountValue = parseFloat(document.getElementById('line_discount').value) || 0;

    if (price === 0) {
        document.getElementById('line_discount_precentage').value = 0;
        document.getElementById('line_discount_precentage_show').textContent = '0%';
        return;
    }

    let percentage = (lineDiscountValue / price) * 100;
    document.getElementById('line_discount_precentage_show').textContent = percentage.toFixed(2) + '%';
    document.getElementById('line_discount_precentage').value = percentage.toFixed(2);

}

function calculateNetDiscount() {
    let price = parseFloat(document.getElementById('standard_price')?.value) || 0;
    let lineDiscount = parseFloat(document.getElementById('line_discount')?.value) || 0;
    let headerDiscount = parseFloat(document.getElementById('header_discount')?.value) || 0;

    console.log(price);
    // console.log(lineDiscount);
    // console.log(headerDiscount);

    let netDiscount = lineDiscount + headerDiscount;
    let netDiscountPercentage = price === 0 ? 0 : (netDiscount / price) * 100;

    document.getElementById('net_discount').value = netDiscount.toFixed(2);
    document.getElementById('net_discount_precentage').value = netDiscountPercentage.toFixed(2);

    const spanPercentage = document.getElementById('net_discount_precentage_show');
    if (spanPercentage) {
        spanPercentage.textContent = netDiscountPercentage.toFixed(2) + '%';
    }

    const spanAmount = document.getElementById('net_discount_show');
    if (spanAmount) {
        spanAmount.textContent = 'Rs. ' + netDiscount.toFixed(2);
    }
}

function calculateNetPrice() {
    let standardPrice = parseFloat(document.getElementById('standard_price')?.value) || 0;
    let netDiscount = parseFloat(document.getElementById('net_discount')?.value) || 0;

    let netPrice = standardPrice - netDiscount;
    netPrice = netPrice < 0 ? 0 : netPrice;

    document.getElementById('net_price').value = netPrice.toFixed(2);
    document.getElementById('net_price_show').textContent = 'Rs. ' + netPrice.toFixed(2);
}


function approveJobcard() {

    const approveData = {
        id: $('#jobcard_id').val(),
        net_total: $('#net_price').val(),
        header_discount_price: $('#header_discount').val(),
        line_discount_price: $('#line_discount').val()

    };

    console.log("Collected Approve Data:", approveData);

    $.ajax({
        url: '<?php echo base_url() ?>JobCard/approveJobcard',
        type: 'POST',
        dataType: 'json',
        data: approveData,
        success: function(result) {
            if (result.status == true) {
                success_toastify(result.message);
                setTimeout(function() {
                    window.location.href = '<?= base_url("JobCard/jobCardDetailIndex/") ?>' +
                        approveData.id;
                }, 1000);
            } else {
                falseResponse(result);
            }
        }
    });

}


function deniedJobcard() {

    const approveData = {
        id: $('#jobcard_id').val(),
        // net_total: $('#net_price').val()
        header_discount_price: $('#header_discount').val(),
        line_discount_price: $('#line_discount').val()
    };

    console.log("Collected Approve Data:", approveData);

    $.ajax({
        url: '<?php echo base_url() ?>JobCard/deniedJobcard',
        type: 'POST',
        dataType: 'json',
        data: approveData,
        success: function(result) {
            if (result.status == true) {
                success_toastify(result.message);
                setTimeout(function() {
                    window.location.href = '<?= base_url("JobCard/jobCardDetailIndex/") ?>' +
                        approveData.id;
                }, 1000);
            } else {
                falseResponse(result);
            }
        }
    });

}
</script>