<style>
.tooltip-inner {
    max-width: none !important;
    padding: 0;
    text-align: left;
}

.custom-tooltip-box {
    width: 240px;
    padding: 8px;
    border-radius: 4px;
}

.vertical-menu {
    list-style: none;
    margin: 0;
    padding: 0;
    width: 220px;
    background: #fff;
    border-right: 1px solid #ddd;
}

.vertical-menu>li {
    position: relative;
}

.vertical-menu>li>a {
    display: block;
    padding: 12px 16px;
    text-decoration: none;
    color: #333;
    font-weight: bold;
    border-bottom: 1px solid #eee;
    cursor: pointer;
}

.vertical-menu>li:hover>a {
    background: #f8f9fa;
    color: #007bff;
}

.vertical-menu .dropdown {
    display: none;
    position: absolute;
    top: 0;
    left: 100%;
    min-width: 220px;
    background: white;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    z-index: 999;
    padding: 0;
}

.vertical-menu>li:hover .dropdown {
    display: block;
}

.vertical-menu .dropdown li a {
    display: block;
    padding: 10px 16px;
    color: #333;
    text-decoration: none;
    font-weight: 500;
    white-space: nowrap;
    border-bottom: 1px solid #eee;
}

.vertical-menu .dropdown li a:hover {
    background: linear-gradient(90deg, #74ebd5, #acb6e5);
    color: #000;
}
</style>
<div class="row p-3">
    <div class="col-3">
        <div class="row mb-4 mx-auto">
            <div class="border border-1 p-2 section_border_with_shadow">
                <h6>Job Summary</h6>
                <table class="w-100">
                    <?php 
                    $net_total=0;
                    if($summary_data){
                    foreach ($summary_data as $summlist): 
                        $header_approved_check = $is_header_discount_approved ? '<span style="font-size:smaller;color: blue;"></span>' : '<span style="font-size:smaller;color: red;"><i class="fas fa-circle fa-sm"></i></span>';
                        $line_approved_check = $is_line_discount_approved ? '<span style="font-size:smaller;color: blue;"></span>' : '<span style="font-size:smaller;color: red;"><i class="fas fa-circle fa-sm"></i></span>';
                        foreach ($summlist['summary_list'] as $list): ?>
                    <tr>
                        <td class="text-left"><?= $list['job_sub_category_text']; ?> x <?= $list['total_job_cnt']; ?>
                        </td>
                        <td class="text-right"><?= number_format($list['sub_total'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td class="text-left" style="padding-top: 20px;">Line Discount <?= $line_approved_check ?></td>
                        <td class="text-right" style="padding-top: 20px;">
                            <?= number_format($summlist['total_line_discount'],2) ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">Hole Discount (<?= number_format($summlist['discount'],0) ?>%)
                            <?= $header_approved_check ?></td>
                        <td class="text-right"><?= number_format($summlist['discount_amount'],2) ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">Advance</td>
                        <td class="text-right"><?= number_format($summlist['advance'],2) ?></td>
                    </tr>
                    <tr style="border-top: 1px solid #000; border-bottom: 3px double #000;">
                        <td class="text-left fw-bold">Total</td>
                        <td class="text-right fw-bold"><?= number_format($summlist['net_total'],2) ?></td>
                    </tr>
                    <?php endforeach;  }?>
                </table>
            </div>
        </div>
        <ul class="vertical-menu <?= ($addcheck == 0) ? 'd-none' : '' ?>" id="mainCategoryGroupMenu"></ul>
    </div>

    <div class="col-9">
        <div class="row mb-4 mx-auto">
            <div class="border border-1 p-2 section_border_with_shadow">
                <table class="w-100">
                    <tr>
                        <td class="text-left fw-bold">Customer Info</td>
                        <td class="text-left fw-bold">Inquiry No</td>
                        <td colspan="2" class="text-left fw-bold">Schedule Date</td>
                        <td class="text-left fw-bold">P. Cate.</td>
                        <td colspan="2" class="text-left fw-bold">Status</td>
                    </tr>
                    <tr>
                        <td class="text-left" id="content_customer_name">
                            <?= $job_main_data[0]['customer_name'] ?? '' ?></td>
                        <td class="text-left" id="content_inq_no"><?= $job_main_data[0]['inquiry_number'] ?? '' ?>
                        </td>
                        <td colspan="2" class="text-left" id="content_schedule_date">
                            <?= $job_main_data[0]['job_start_datetime'] ?? '' ?></td>
                        <td class="text-left" id="p_category"><?= $job_main_data[0]['price_category_type'] ?? '' ?>
                        </td>

                        <?php
                        $statusText = $job_main_data[0]['status'] ?? '';
                        $style = '';

                        switch ($statusText) {
                            case 'Draft':
                                $style = 'color: #6B7280;';  
                                break;
                            case 'Pending':
                                $style = 'color: #F59E0B;';  
                                break;
                            case 'Approved':
                                $style = 'color: #10B981;';  
                                break;
                            case 'Cancelled':
                                $style = 'color: #EF4444;'; 
                                break;
                            case 'Re-Approve Pending':
                                $style = 'color: #F97316;';  
                                break;
                            case 'Re-Approved':
                                $style = 'color: #059669;';  
                                break;
                            default:
                                $style = 'color: #4B5563;'; 
                                break;
                        }
                                                ?>
                        <td colspan="2" class="text-left fw-bold" id="main_status_stage" style="<?= $style ?>">
                            <?= $statusText ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" id="content_address"><?= $job_main_data[0]['address'] ?? '' ?>,
                            <?= $job_main_data[0]['address_2'] ?? '' ?></td>
                        <td class="text-left" id="content_inq_date"><?= $job_main_data[0]['inquery_date'] ?? '' ?>
                        </td>
                        <td class="text-left fw-bold">Handover Date</td>
                        <td class="text-left fw-bold">Days</td>
                        <td class="text-left fw-bold">Payment Method</td>
                        <td colspan="2" class="text-left"></td>
                    </tr>
                    <tr>
                        <td class="text-left" id="content_cus_contact">
                            <?= $job_main_data[0]['customer_mobile_num'] ?? '' ?></td>
                        <td class="text-left"></td>
                        <td class="text-left" id="content_hand_over_date">
                            <?= $job_main_data[0]['handover_date'] ?? '' ?></td>
                        <td class="text-left fw-bold text-success" style="font-size: 25px;">
                            <?= $job_main_data[0]['total_days'] ?? '' ?></td>
                        <td class="text-left fw-bold text-success">
                            <?= $job_main_data[0]['payment_type'] ?? '' ?></td>
                        <td class="text-left"></td>
                        <td class="text-right"><button type="button" title="Edit Header"
                                class="btn btn-sm btn-warning <?= ($editcheck == 0) ? 'd-none' : '' ?>"
                                data-bs-toggle="modal" data-bs-target="#jobHeaderModal_edit" id="openEditModalBtn"><i
                                    class="fas fa-edit"></i></button></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row mb-4 mx-auto">
            <h5>Job Details</h5>
            <div style="overflow-x: auto; white-space: nowrap; max-height: 52vh;">
                <?php 
            if($job_detail_data){
            foreach ($job_detail_data as $group): ?>
                <div class="details_section mb-2">
                    <table class="w-100 table table-bordered">
                        <thead>
                            <tr>
                                <th
                                    style="width:20%; word-wrap: break-word; word-break: break-word; white-space: normal;">
                                    <?php echo $group['job_sub_category_text']; ?></th>
                                <th
                                    style="width:20%; word-wrap: break-word; word-break: break-word; white-space: normal;">
                                    Description</th>
                                <th
                                    style="width:15%; word-wrap: break-word; word-break: break-word; white-space: normal;">
                                    Remark</th>
                                <th style="width:8%" class="text-right">Price</th>
                                <th style="width:6%" class="text-right">QTY</th>
                                <th style="width:9%" class="text-right">Total</th>
                                <th style="width:7%" class="text-right">O.Charges</th>
                                <th style="width:7%" class="text-right">Discount</th>
                                <th style="width:8%" class="text-right">Sub Total</th>
                                <th style="width:8%" class="text-right <?= ($deletecheck == 0) ? 'd-none' : '' ?>">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($group['details'] as $detail): ?>
                            <?php
                                    $isPriceChanged = $detail['list_price'] != $detail['price'];
                                    $priceChangeHighlight = $isPriceChanged ? 'bg-warning text-dark' : '';
                                    $listPrice = $detail['list_price'];
                                    $currentPrice = $detail['price'];
                                    $changeAmount = $listPrice - $currentPrice;
                                    $changePercentage = $listPrice != 0 ? ($changeAmount / $listPrice) * 100 : 0;

                                    $tooltipText = '
                                        <div class="custom-tooltip-box text-start">
                                            <div class="d-flex justify-content-between">
                                                <span>Standard Price:</span>
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


                                <tr>
                                    <td style="width:20%; vertical-align: middle; word-wrap: break-word; word-break: break-word; white-space: normal;"><?= $detail['option_group_text'] ?> - <?= $detail['option_text'] ?></td>
                                    <td style="width:20%; vertical-align: middle; word-wrap: break-word; word-break: break-word; white-space: normal;"><?= $detail['combined_option'] ?></td>
                                    <td style="width:15%; vertical-align: middle; word-wrap: break-word; word-break: break-word; white-space: normal;"><?= isset($detail['remark']) ? $detail['remark'] : '-' ?></td>
                                    <td style="width:8%; vertical-align: middle;" class="text-right"><?= number_format($detail['list_price'], 2) ?></td>
                                    <td style="width:6%; vertical-align: middle;" class="text-right"><?= $detail['qty'] ?></td>
                                    <td style="width:9%; vertical-align: middle;" class="text-right"><?= number_format($detail['total'], 2) ?></td>
                                    <td style="width:7%; vertical-align: middle;" class="text-right">-</td>
                                    <td style="width:7%; vertical-align: middle;" class="text-right"><?= $is_line_discount_approved ? number_format($detail['line_discount'], 2) : number_format(0, 2) ?></td>
                                    <td style="width:8%; vertical-align: middle;" class="text-right">
                                        <span class="pe-2 ps-2 <?= $priceChangeHighlight ?>"
                                            <?= $isPriceChanged ? 'data-bs-toggle="tooltip" style="cursor: help;" data-bs-placement="top" data-bs-html="true" title="' . htmlspecialchars($tooltipText, ENT_QUOTES) . '"' : '' ?>>
                                            <?= $is_line_discount_approved ? number_format($detail['net_amount'], 2) : number_format($detail['total'], 2) ?>
                                        </span>
                                    </td>
                                    <td style="width:8%; vertical-align: middle;" class="text-right">
                                        <button type="button" title="Edit" class="btn btn-sm btn-primary <?= ($editcheck == 0) ? 'd-none' : '' ?>"
                                                id="<?= $detail['parent_id'] ?>" 
                                                job_card_id="<?= $job_main_data[0]['idtbl_jobcard'] ?? '' ?>" 
                                                onclick="editJobItems(this)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" title="Delete" class="btn btn-sm btn-danger <?= ($deletecheck == 0) ? 'd-none' : '' ?>"
                                                id="<?= $detail['parent_id'] ?>" 
                                                job_card_id="<?= $job_main_data[0]['idtbl_jobcard'] ?? '' ?>" 
                                                onclick="deleteJobItems(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endforeach; }else { ?>
                <div class="details_section mb-2">
                    <table class="w-100">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="text-center">Record not found!</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="editJobItemModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Job Item</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editJobItemForm" class="jobcard-body">
                    <input type="hidden" name="parent_id" id="edit_parent_id">
                    <input type="hidden" name="job_card_id" id="edit_job_card_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="updateToJobCardBtn"
                    onclick="addToJobCard(1)">Update</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="recordOption" value="add">
<input type="hidden" id="edit_line_price_category" value="0">
<script>
$(document).ready(function() {
    $('#openEditModalBtn').on('click', function() {

        $('#edit_cus_name').val(<?= json_encode($job_main_data[0]['customer_name'] ?? '') ?>);
        $('#edit_contact_no').val(<?= json_encode($job_main_data[0]['customer_mobile_num'] ?? '') ?>);
        $('#edit_nic_number').val(<?= json_encode($job_main_data[0]['nic_number'] ?? '') ?>);
        $('#edit_address1').val(<?= json_encode($job_main_data[0]['address'] ?? '') ?>);
        $('#edit_address2').val(<?= json_encode($job_main_data[0]['address_2'] ?? '') ?>);
        $('#edit_email').val(<?= json_encode($job_main_data[0]['email'] ?? '') ?>);
        $('#edit_schedule_date').val(<?= json_encode($job_main_data[0]['job_start_datetime'] ?? '') ?>);
        $('#edit_delivery_date').val(<?= json_encode($job_main_data[0]['handover_date'] ?? '') ?>);
        $('#edit_vat_reg_type').val(<?= json_encode($job_main_data[0]['tax_type'] ?? '') ?>);
        $('#edit_vat_number').val(<?= json_encode($job_main_data[0]['tax_number'] ?? '') ?>);


        $('#edit_price_category').append(
            new Option(<?= json_encode($job_main_data[0]['price_category_type'] ?? '') ?>,
                <?= json_encode($job_main_data[0]['price_cat'] ?? '') ?>, true, true)
        ).trigger('change');

        $('#edit_payment_method').append(
            new Option(<?= json_encode($job_main_data[0]['payment_type'] ?? '') ?>,
                <?= json_encode($job_main_data[0]['peyment_method'] ?? '') ?>, true, true)
        ).trigger('change');

        // $('#p_category option').each(function() {
        //     if ($(this).text().toLowerCase() === priceCategory.toLowerCase()) {
        //         $(this).prop('selected', true);
        //     }
        // });
    });

    $('[data-bs-toggle="tooltip"]').tooltip({
        container: 'body',
        html: true
    });
});

function showAddJobItemModal(button) {
    var MainJobId = $(button).data('id');
    var MainjobName = $(button).data('name');
    const currentWrapper = $(this).closest('.job-option-wrapper');
    const currentLevel = parseInt(currentWrapper.data('level'));
    $('.job-option-wrapper').each(function() {
        if (parseInt($(this).data('level')) > currentLevel) {
            $(this).remove();
        }
    });
    $('#jobCardForm').empty();
    reSetContent('#jobCardForm');
    getSubCategoryListBaseOnMain(MainJobId);
    // Show the modal
    $('#addJobItemModal').modal('show');

    $('#jobIdLabel').text(MainJobId);
    $('#jobNameLabel').text(MainjobName);
    $('#recordOption').val('add');
}

function getSubCategoryListBaseOnMain(MainJobId) {
    let idtbl_jobcard =
        <?= isset($job_main_data[0]['idtbl_jobcard']) ? json_encode($job_main_data[0]['idtbl_jobcard']) : 0 ?>;

    if (idtbl_jobcard === 0) {
        error_toastify('Job Card Not Created or Selected!');
        return false;
    }

    $('#jobCardForm').empty();
    $.ajax({
        type: "GET",
        url: '<?php echo base_url() ?>JobCard/getSubJob/' + MainJobId + '/' + idtbl_jobcard,
        success: function(result) {
            if (result) {
                $('#jobCardForm').append(result);
            }
        },
        error: function() {
            $('#jobCardForm').html('<p class="text-center text-danger">Error fetching data!</p>');
        }
    });
}

function editJobItems(btn) {
    let parentId = $(btn).attr('id');
    let jobCardId = $(btn).attr('job_card_id');

    $('#edit_parent_id').val(parentId);
    $('#edit_job_card_id').val(jobCardId);
    $('#editJobItemModal').modal('show');
    reSetContent('#editJobItemForm');
    $('#editJobItemForm').empty();
    $('#recordOption').val('edit');
    $.ajax({
        url: '<?= base_url("JobCard/getJobCardEditDetails") ?>',
        type: 'POST',
        data: {
            parent_id: parentId,
            job_card_id: jobCardId
        },
        success: function(result) {
            if (result) {
                $('#editJobItemForm').append(result);
            }
        },
        error: function() {
            $('#editJobItemForm').html('<p class="text-center text-danger">Error fetching data!</p>');
        }
    });
}

function deleteJobItems(elem) {
    var r = confirm("Are you sure, You want to Delete this ? ");
    if (r == true) {
        var id = $(elem).attr('id');
        var job_card_id = $(elem).attr('job_card_id');
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                id: id,
                job_card_id: job_card_id
            },
            url: '<?php echo base_url() ?>JobCard/jobCardItemDelete',
            success: function(result) {
                if (result.status) {
                    success_toastify(result.message);
                    setTimeout(function() {
                        location.reload();
                    }, 200)
                } else {
                    error_toastify(result.message);
                }
            }
        });
    }
}
</script>