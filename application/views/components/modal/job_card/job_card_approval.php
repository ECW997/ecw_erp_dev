<div class="modal fade" id="jobcardApproveModel" tabindex="-1" aria-labelledby="jobcardApproveModelLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-black" id="jobcardApproveModelLabel">Job Card Approval</h5>
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
                                value="<?= $job_main_data[0]['status'] ?? '' ?>">
                        </div>
                    </div>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td><label class="small fw-bold">Total Line Discount</label></td>
                                <td class="text-danger">
                                    <span id="line_discount_precentage_show">
                                        <?= number_format(($summary_data[0]['sub_total'] ?? 0) > 0 ? (($summary_data[0]['total_line_discount'] ?? 0) / $summary_data[0]['sub_total']) * 100 : 0, 2) ?>%
                                    </span>
                                    <span>(From Total)</span>
                                </td>
                                <td class="text-danger text-end">
                                    <span id="line_discount_show">
                                        Rs. <?= number_format($summary_data[0]['total_line_discount'] ?? 0, 2) ?>
                                    </span>
                                    <input type="hidden" id="line_discount" value="<?= $summary_data[0]['total_line_discount'] ?? 0 ?>">
                                    <input type="hidden" id="line_discount_status" value="<?= $job_main_data[0]['line_discount_approve'] ?? 'Pending' ?>">
                                </td>
                                <td class="text-end ">
                                    <?php if(($summary_data[0]['total_line_discount'] ?? 0) > 0): ?>
                                    <div class="btn-group btn-group-sm line-discount-actions">
                                        <?php 
                                        $lineStatus = $job_main_data[0]['line_discount_approve'] ?? 'Pending';
                                        if($lineStatus === 'Approved'): ?>
                                            <span class="badge badge-pill text-bg-success"><i class="fas fa-check-circle me-2"></i>Approved</span>
                                        <?php elseif($lineStatus === 'Denied'): ?>
                                            <span class="badge badge-pill text-bg-danger"><i class="fas fa-times-circle me-2"></i>Denied</span>
                                        <?php else: ?>
                                            <?php if($approve2check==1){ ?>
                                                <button type="button" class="btn btn-success btn-sm approve-line-discount" 
                                                    onclick="approveDiscount('line')">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm deny-line-discount"
                                                    onclick="denyDiscount('line')">
                                                    <i class="fas fa-times"></i> Deny
                                                </button>
                                            <?php } else { ?>
                                                <span class="badge badge-pill text-bg-danger"><i class="fas fa-times-circle me-2"></i>Not Approved</span>
                                            <?php } ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <tr>
                                <td><label class="small fw-bold">Header Discount</label></td>
                                <td class="text-danger">
                                    <span id="header_discount_precentage_show">
                                        <?= number_format($job_main_data[0]['discount'] ?? 0, 2) ?>%
                                    </span>
                                </td>
                                <td class="text-danger text-end">
                                    <span id="header_discount_show">
                                        Rs. <?= number_format($job_main_data[0]['discount_amount'] ?? 0, 2) ?>
                                    </span>
                                    <input type="hidden" id="header_discount" value="<?= $job_main_data[0]['discount_amount'] ?? 0 ?>">
                                    <input type="hidden" id="header_discount_status" value="<?= $job_main_data[0]['header_discount_approve'] ?? 'Pending' ?>">
                                </td>
                                <td class="text-end ">
                                    <?php if(($job_main_data[0]['discount_amount'] ?? 0) > 0): ?>
                                    <div class="btn-group btn-group-sm header-discount-actions">
                                        <?php 
                                        $headerStatus = $job_main_data[0]['header_discount_approve'] ?? 'Pending';
                                        if($headerStatus === 'Approved'): ?>
                                            <span class="badge badge-pill text-bg-success"><i class="fas fa-check-circle me-2"></i>Approved</span>
                                        <?php elseif($headerStatus === 'Denied'): ?>
                                            <span class="badge badge-pill text-bg-danger"><i class="fas fa-times-circle me-2"></i>Denied</span>
                                        <?php else: ?>
                                            <?php if($approve2check==1){ ?>
                                                <button type="button" class="btn btn-success btn-sm approve-header-discount"
                                                    onclick="approveDiscount('header')">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm deny-header-discount"
                                                    onclick="denyDiscount('header')">
                                                    <i class="fas fa-times"></i> Deny
                                                </button>
                                            <?php } else { ?>
                                                <span class="badge badge-pill text-bg-danger"><i class="fas fa-times-circle me-2"></i>Not Approved</span>
                                            <?php } ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label class="small fw-bold">Net Discount</label></td>
                                <td class="text-danger">
                                    <span id="net_discount_precentage_show"></span>
                                </td>
                                <td class="text-danger text-end">
                                    <span id="net_discount_show"></span>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row mt-4">
                        <div class="col-6">
                            <h5>Net Price: </h5>
                        </div>
                        <div class="col-6 text-end">
                            <span class="text-dark fw-bold" id="net_price_show">
                                Rs. 
                            </span>
                            <input type="hidden" id="net_price" value="">
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
                    <?php if($approve1check==1): ?>
                    <div class="col-4">
                        <button type="button" class="btn btn-success w-100 <?= $showApproveBtn ? '' : 'd-none' ?>" id="approveJobcardBtn" style="border-radius: 12px;" onclick="approveJobcard()">
                            Approve
                        </button>
                    </div>
                    <?php endif; ?>
                    <?php if($cancelcheck==1): ?>
                    <div class="col-4">
                        <button type="button" class="btn btn-danger w-100 <?= $is_confirmed ? '' : 'd-none' ?>" id="deniedJobcardBtn"
                            style="border-radius: 12px;" onclick="deniedJobcard()">Denied</button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer bg-light justify-content-center py-2 border-top">
                <small class="text-muted"><div id="jobcard_status_message" class="mt-2 fw-bold"></div></small>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function() {
    <?php if ($is_edit == '1'): ?>
        checkDiscountApprovals();
        recalculateNetPrice();
    <?php endif; ?>
});

function approveDiscount(type){
    if (!confirm(`Are you sure you want to approve the ${type} discount?`)) {
        return;
    }

    $(`.approve-${type}-discount, .deny-${type}-discount`).prop('disabled', true);

    $.ajax({
        url: '<?php echo base_url() ?>JobCard/approveDiscount',
        type: 'POST',
        dataType: 'json',
         data: {
            jobcard_id: <?= json_encode($job_main_data[0]['idtbl_jobcard'] ?? 0) ?>,
            discount_type: type,
            action: 'Approved'
        },
        success: function(result) {
            if (result.status == true) {
                success_toastify(result.message);
                $(`.${type}-discount-actions`).html(`
                     <span class="badge badge-pill text-bg-success"><i class="fas fa-check-circle me-2"></i>Approved</span>
                `);
                $(`#${type}_discount_status`).val('Approved');
                $('#main_status_stage').html('Pending').css('color', '#FB923C');
                checkDiscountApprovals();
                recalculateNetPrice();
            } else {
                error_toastify(result.message);
                $(`.approve-${type}-discount, .deny-${type}-discount`).prop('disabled', false);
            }
        },
        error: function() {
            $(`.approve-${type}-discount, .deny-${type}-discount`).prop('disabled', false);
            error_toastify('Error processing request');
        }
    });
}

function denyDiscount(type) {
    if (!confirm(`Are you sure you want to denide the ${type} discount?`)) {
        return;
    }

    $(`.approve-${type}-discount, .deny-${type}-discount`).prop('disabled', true);
    
    $.ajax({
        url: '<?php echo base_url() ?>JobCard/deniedDiscount',
        type: 'POST',
        dataType: 'json',
        data: {
            jobcard_id: <?= json_encode($job_main_data[0]['idtbl_jobcard'] ?? 0) ?>,
            discount_type: type,
            action: 'Denied'
        },
        success: function(result) {
            if(result.status == true) {
                success_toastify(result.message);
                $(`.${type}-discount-actions`).html(`
                    <span class="badge badge-pill text-bg-danger"><i class="fas fa-times-circle me-2"></i>Denied</span>
                `);
                
                $(`#${type}_discount_status`).val('Denied');
                $('#main_status_stage').html('Pending').css('color', '#FB923C');
                recalculateNetPrice();
                checkDiscountApprovals();
            } else {
                $(`.approve-${type}-discount, .deny-${type}-discount`).prop('disabled', false);
                error_toastify(result.message);
            }
        },
        error: function() {
            $(`.approve-${type}-discount, .deny-${type}-discount`).prop('disabled', false);
            error_toastify('Error processing request');
        }
    });
}

function checkDiscountApprovals() {
    let lineStatus = $('#line_discount_status').val();
    let headerStatus = $('#header_discount_status').val();
    let hasLineDiscount = parseFloat($('#line_discount').val()) > 0;
    let hasHeaderDiscount = parseFloat($('#header_discount').val()) > 0;
    
    let is_jobcard_approved = <?= (isset($job_main_data[0]['status']) && $job_main_data[0]['status'] === 'Approved') ? 'true' : 'false' ?>;
    let enableApproval = true;

    if(is_jobcard_approved){
        enableApproval = false;
    }else{
        if(hasLineDiscount && lineStatus === 'Pending') {
                enableApproval = false;
            }
        
        if(hasHeaderDiscount && headerStatus === 'Pending') {
            enableApproval = false;
        }
    }
    
    $('#approveJobcardBtn').prop('disabled', !enableApproval);
}

function recalculateNetPrice() {
    let standardPrice = parseFloat($('#standard_price').val());
    let lineDiscount = parseFloat($('#line_discount').val());
    let headerDiscount = parseFloat($('#header_discount').val());
    let lineStatus = $('#line_discount_status').val();
    let headerStatus = $('#header_discount_status').val();
    
    let netDiscount = 0;
    
    if(lineStatus === 'Approved') netDiscount += lineDiscount;
    if(headerStatus === 'Approved') netDiscount += headerDiscount;
    
    let netPrice = standardPrice - netDiscount;
    
    $('#net_price').val(netPrice.toFixed(2));
    $('#net_price_show').text('Rs. ' + netPrice.toFixed(2));
    $('#net_discount_show').text('Rs. ' + netDiscount.toFixed(2));

    if (standardPrice > 0) {
        let discountPercent = (netDiscount / standardPrice) * 100;
        $('#net_discount_precentage_show').text(discountPercent.toFixed(2) + '%');
    } else {
        $('#net_discount_precentage_show').text('0.00%');
    }
}

function approveJobcard() {
    if (!confirm(`Are you sure you want to approve jobcard?`)) {
        return;
    }

    let lineDiscount = parseFloat($('#line_discount').val());
    let lineStatus = $('#line_discount_status').val();
    let line_discount_price = (lineStatus === 'Approved') ? lineDiscount : 0;

    let headerDiscount = parseFloat($('#header_discount').val());
    let headerStatus = $('#header_discount_status').val();
    let header_discount_price = (headerStatus === 'Approved') ? headerDiscount : 0;

    const approveData = {
        id: <?= json_encode($job_main_data[0]['idtbl_jobcard'] ?? 0) ?>,
        net_total: $('#net_price').val(),
        header_discount_price: header_discount_price,
        line_discount_price: line_discount_price

    };

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
    if (!confirm(`Are you sure you want to denide jobcard?`)) {
        return;
    }

    let lineDiscount = parseFloat($('#line_discount').val());
    let lineStatus = $('#line_discount_status').val();
    let line_discount_price = (lineStatus === 'Approved') ? lineDiscount : 0;

    let headerDiscount = parseFloat($('#header_discount').val());
    let headerStatus = $('#header_discount_status').val();
    let header_discount_price = (headerStatus === 'Approved') ? headerDiscount : 0;

    const approveData = {
        id: <?= json_encode($job_main_data[0]['idtbl_jobcard'] ?? 0) ?>,
        net_total: $('#net_price').val(),
        header_discount_price: header_discount_price,
        line_discount_price: line_discount_price

    };

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