<div class="row p-3">
    <div class="col-3">
        <div class="row mb-4 mx-auto">
            <div class="border border-1 p-2 section_border_with_shadow">
                <h6>Job Summary</h6>
                <table class="w-100">
                    <tr>
                        <td class="text-left">Seat Cover x 4</td>
                        <td class="text-right">235,000</td>
                    </tr>
                    <tr>
                        <td class="text-left">Seat Repai x 1</td>
                        <td class="text-right">235,000</td>
                    </tr>
                    <tr>
                        <td class="text-left" style="padding-top: 20px;">Discount (10%)</td>
                        <td class="text-right" style="padding-top: 20px;">-23,800</td>
                    </tr>
                    <tr style="border-top: 1px solid #000; border-bottom: 3px double #000;">
                        <td class="text-left fw-bold">Total</td>
                        <td class="text-right fw-bold">214,200</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- <div class="row mb-4 mx-auto">
			<div class="col-6">
				<button type="button" class="btn btn-info rounded-3 w-100 btn-sm" onclick="showAddJobItemModal();"><i class="fas fa-plus-circle me-2"></i>Door Board</button>
			</div>
		</div> -->


        <div class="row mb-4 mx-auto">
            <div class="row" id="buttonsContainer">

            </div>
        </div>
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
                        <td colspan="2" class="text-left fw-bold text-danger"><?php echo $is_edit? 'DRAFT' : ''; ?></td>
                    </tr>
                    <tr>
                        <td class="text-left" id="content_address"><?= $job_main_data[0]['address'] ?? '' ?>,
                            <?= $job_main_data[0]['address_2'] ?? '' ?></td>
                        <td class="text-left" id="content_inq_date"><?= $job_main_data[0]['inquery_date'] ?? '' ?>
                        </td>
                        <td class="text-left fw-bold">Handover Date</td>
                        <td class="text-left fw-bold">Days</td>
                        <td colspan="3" class="text-left"></td>
                    </tr>
                    <tr>
                        <td class="text-left" id="content_cus_contact">
                            <?= $job_main_data[0]['customer_mobile_num'] ?? '' ?></td>
                        <td class="text-left"></td>
                        <td class="text-left" id="content_hand_over_date">
                            <?= $job_main_data[0]['handover_date'] ?? '' ?></td>
                        <td class="text-left fw-bold text-success" style="font-size: 25px;">
                            <?= $job_main_data[0]['total_days'] ?? '' ?></td>
                        <td colspan="2" class="text-left"></td>
                        <td class="text-right"><button type="button" title="Edit Header" class="btn btn-sm btn-warning"
                                data-bs-toggle="modal" data-bs-target="#jobHeaderModal_edit" id="openEditModalBtn"><i
                                    class="fas fa-edit"></i></button></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row mb-4 mx-auto">
            <h5>Job Details</h5>
            <?php 
            if($job_detail_data){
            foreach ($job_detail_data as $group): ?>
                <div class="details_section mb-2">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th colspan="2" style="width:40%"><?php echo $group['job_sub_category_text']; ?></th>
                                <th class="text-right" style="width:10%">Price</th>
                                <th class="text-right" style="width:10%">QTY</th>
                                <th class="text-right" style="width:10%">Total</th>
                                <th class="text-right" style="width:10%">O.Charges</th>
                                <th class="text-right" style="width:10%">Discount</th>
                                <th class="text-right" style="width:10%">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($group['details'] as $detail): ?>
                                <tr>
                                    <td class="text-left" style="width:20%">
                                        <?php echo $detail['option_group_text']; ?>
                                    </td>
                                    <td class="text-left" style="width:20%">
                                        <?php echo $detail['combined_option']; ?>
                                    </td>
                                    <td class="text-right" style="width:10%">
                                        <?php echo number_format($detail['list_price'], 0); ?>
                                    </td>
                                    <td class="text-right" style="width:10%">
                                        <?php echo $detail['qty']; ?>
                                    </td>
                                    <td class="text-right" style="width:10%">
                                        <?php echo number_format($detail['total'], 0); ?>
                                    </td>
                                    <td class="text-right" style="width:10%">
                                       
                                    </td>
                                    <td class="text-right" style="width:10%">
                                        <?php echo number_format($detail['line_discount'], 0); ?>
                                    </td>
                                    <td class="text-right" style="width:10%">
                                        <?php echo number_format($detail['net_amount'], 0); ?>
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

<script>
$(document).ready(function() {
    $('#openEditModalBtn').on('click', function() {

        var customerName = $('#content_customer_name').text().trim();
        var contactNo = $('#content_cus_contact').text().trim();
        var address = $('#content_address').text().trim().split(',');
        var scheduleDate = $('#content_schedule_date').text().trim();
        var deliveryDate = $('#content_hand_over_date').text().trim();
        var priceCategory = $('#p_category').text().trim();

        // Fill modal fields
        $('#edit_cus_name').val(customerName);
        $('#edit_contact_no').val(contactNo);
        $('#edit_address1').val(address[0] ? address[0].trim() : '');
        $('#edit_address2').val(address[1] ? address[1].trim() : '');
        $('#edit_schedule_date').val(scheduleDate);
        $('#edit_delivery_date').val(deliveryDate);

        // Set the price category dropdown
        $('#p_category option').each(function() {
            if ($(this).text().toLowerCase() === priceCategory.toLowerCase()) {
                $(this).prop('selected', true);
            }
        });
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
    getSubCategoryListBaseOnMain(MainJobId);
    // Show the modal
    $('#addJobItemModal').modal('show');

    // Pass the jobId and jobName to the modal and display them in the labels
    $('#jobIdLabel').text(MainJobId); // Display jobId in the modal label
    $('#jobNameLabel').text(MainjobName); // Display jobName in the modal label

}

function getSubCategoryListBaseOnMain(MainJobId) {
    let idtbl_jobcard = <?= json_encode($job_main_data[0]['idtbl_jobcard'] ?? '') ?>;
    
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
</script>