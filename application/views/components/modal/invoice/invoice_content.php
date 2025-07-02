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

.disabled-pointer-events {
    pointer-events: none;
}

.vl {
    border-left: 4px solid rgb(60, 90, 180);
    height: 100px;
}

.font-weight-600 {
    font-weight: 600;
}

.custom-blue-hr {
    height: 5px;
    border: none;
    background-color: rgb(2, 4, 133);
}
</style>

<hr class="custom-blue-hr">
<div class="card">
    <div class="card-body p-0 p-2">
        <div class="row">

            <div class="col-lg-8">
                <div id="tableorder-wrapper">
                    <table class="table table-striped table-bordered table-sm small" id="tableorder">
                        <thead>
                            <tr>
                                <th>Job Description</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Discount(%)</th>
                                <th class="text-center">Tax</th>
                                <th class="text-right">Total Amount</th>
                            </tr>
                        </thead>
                       <tbody>
                        <?php if (!empty($invoice_detail_data)): ?>
                            <?php foreach ($invoice_detail_data as $item): ?>
                                <tr>
                                    <td><?php echo $item['description']; ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo $item['unit']; ?></td>
                                    <td class="text-end"><?php echo ($item['unit_price']); ?></td>
                                    <td class="text-end d-none sub_total"><?php echo ($item['sub_total']); ?></td>
                                    <td class="text-end"><?php echo $item['line_discount_pc']; ?></td>
                                    <td class="text-end d-none discount_amount"><?php echo ($item['line_discount_amount']); ?></td>
                                    <td class="text-end d-none total_after_discount"><?php echo ($item['line_total_after_discount']); ?></td>
                                    <td class="text-end"><?php echo ($item['line_tax_amount']); ?></td>
                                    <td class="text-end total_after_tax"><?php echo ($item['line_total_after_tax']); ?></td>
                                    <td class="text-end d-none insert_status">existing</td>
                                    <td class="text-end d-none item_id"><?php echo $item['item_id']; ?></td>
                                    <td class="text-end d-none row_id"><?php echo $item['id']; ?></td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-primary btn-sm" id="<?php echo $item['id']; ?>" onclick="editRow(this)">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" id="<?php echo $item['id']; ?>" onclick="deleteRow(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if (!empty($invoice_detail_data)) : ?>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    allItemsTotalCalculation();
                                });
                            </script>
                        <?php endif; ?>
                    </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col text-right">
                        <h4 class="font-weight-600" id="divtotal">Rs. 0.00</h4>
                    </div>
                    <input type="hidden" id="hidetotalorder" value="0">
                </div>
            </div>


            <div class="col-auto d-flex justify-content-center align-items-center">
                <div style="border-left: 4px solid #3c5ab4; height: 100%;"></div>
            </div>

            <div class="col-lg-3">
                <form id="expensesform" autocomplete="off">
                    <div class="row">
                        <div class="col-6">
                            <label class="small font-weight-bold text-dark">Extra Charge</label>
                            <input type="text" id="chargetype" name="chargetype" class="form-control form-control-sm" />
                        </div>
                        <div class="col-4">
                            <label class="small font-weight-bold text-dark">Amount</label>
                            <input type="number" step="any" name="chargeamount" class="form-control form-control-sm"
                                id="chargeamount" required>
                        </div>
                        <div class="col-2 d-flex align-items-end">
                            <button type="button" id="secondformsubmit" class="btn btn-primary btn-sm add-extra-charge-btn" onclick="insertExtraCharge();"><i
                                    class="fas fa-plus"></i>&nbsp;Add</button>
                            <button type="button" id="secondupdateformsubmit" class="btn btn-secondary btn-sm d-none update-extra-charge-btn" onclick="updateExtraCharge();"><i
                                    class="fas fa-plus"></i>&nbsp;Update</button>
                        </div>
                    </div>
                </form>

                <br>
                <div id="chargetable-wrapper">
                    <table class="table table-striped table-bordered table-sm small" id="chargetableorder">
                        <thead>
                            <tr>
                                <th>Charge Type</th>
                                <th class="text-right">Amount</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($extra_charge_data)): ?>
                            <?php foreach ($extra_charge_data as $item): ?>
                                <tr>
                                    <td name="chargetype"><?php echo $item['charge_type']; ?></td>
                                    <td class="text-end chargesamount" name="chargeamount"><?php echo ($item['charge_amount']); ?></td>
                                    <td class="text-end d-none insert_status">existing</td>
                                    <td class="text-end d-none row_id"><?php echo $item['id']; ?></td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-primary btn-sm" id="<?php echo $item['id']; ?>" onclick="editExtraChargeRow(this)">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" id="<?php echo $item['id']; ?>" onclick="deleteExtraChargeRow(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if (!empty($extra_charge_data)) : ?>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    allExtraChargeCalculation();
                                });
                            </script>
                        <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col text-right">
                            <h4 class="font-weight-600" id="divchargestotal">Rs. 0.00</h4>
                            <input type="hidden" id="hidechargestotal" value="0">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php $selected_payment = isset($invoice_main_data[0]['payment_term_id']) ? $invoice_main_data[0]['payment_term_id'] : ''; ?>
    <div class="card-body p-0 p-2">
        <div class="container-fluid mt-2 p-0 p-2">
            <div class="row">
                <div class="col-2">
                    <label class="small font-weight-bold text-dark">Payment Type </label>
                    <select class="form-control form-control-sm" name="payment_type" id="payment_type" required>
                        <option value="">Select Payment Type</option>
                        <option value="1" <?= ($selected_payment == '1') ? 'selected' : '' ?>>Cash</option>
                        <option value="2" <?= ($selected_payment == '2') ? 'selected' : '' ?>>Cheque</option>
                        <option value="3" <?= ($selected_payment == '3') ? 'selected' : '' ?>>Bank Transfer</option>
                    </select>
                </div>
                <div class="col-2">
                    <label class="small font-weight-bold text-dark">Sub Total </label>
                    <input type="number" step="any" name="hiddenfulltotal" class="form-control form-control-sm"
                        id="hiddenfulltotal" readonly>
                </div>
                <div class="col-2">
                    <label class="small font-weight-bold text-dark">Vat (%)*</label>
                    <input type="number" id="vat" name="vat" class="form-control form-control-sm" value="18"
                        onkeyup="finaltotalcalculate();" required>
                </div>

                <div class="col-2">
                    <label class="small font-weight-bold text-dark">Vat Amount*</label>
                    <input type="number" id="vatamount" name="vatamount" class="form-control form-control-sm" value="0"
                        required readonly>
                </div>
                <div class="col-4">
                    <label class="small font-weight-bold text-dark"><b>Total
                            Payment</b></label>
                    <input type="number" step="any" name="modeltotalpayment"
                        class="form-control form-control-sm small font-weight-bold text-dark" id="modeltotalpayment"
                        readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="small font-weight-bold text-dark">Remark</label>
                <textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
            </div>

            <input name="invoice_record_id" type="number" id="invoice_record_id" value="<?= $invoice_main_data[0]['id'] ?? '' ?>" class="d-none">
            <div class="row">
                <div class="col-12">
                    <div class="form-group mt-2">
                        <button type="button" id="btncreateorder"
                            class="btn btn-outline-primary btn-sm fa-pull-right" onclick="createInvoice();"><i class="fas fa-save me-2"></i><?php echo $is_edit? 'Update' : 'Create'; ?>
                            Invoice</button>
                    </div>
                </div>

            </div>
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

        $('#edit_cus_name').val(customerName);
        $('#edit_contact_no').val(contactNo);
        $('#edit_address1').val(address[0] ? address[0].trim() : '');
        $('#edit_address2').val(address[1] ? address[1].trim() : '');
        $('#edit_schedule_date').val(scheduleDate);
        $('#edit_delivery_date').val(deliveryDate);

        $('#p_category option').each(function() {
            if ($(this).text().toLowerCase() === priceCategory.toLowerCase()) {
                $(this).prop('selected', true);
            }
        });
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
    getSubCategoryListBaseOnMain(MainJobId);
    // Show the modal
    $('#addJobItemModal').modal('show');

    $('#jobIdLabel').text(MainJobId);
    $('#jobNameLabel').text(MainjobName);

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

$("#secondformsubmit").click(function() {
});

function insertExtraCharge() {
	if (!$("#expensesform")[0].checkValidity()) {

		$("#chargesubmitBtn").click();
	} else {
		var chargetype = $('#chargetype').val();
		var chargeamount = $('#chargeamount').val();
		// var chargetype = $("#chargetype option:selected").text();

		$('#chargetableorder > tbody:last').append('<tr class="pointer"><td name="chargetype">' +
			chargetype + '</td><td name="chargeamount" class="text-right chargesamount">' +
			chargeamount +
			'</td><td class="text-end d-none insert_status">new</td><td class="text-end d-none row_id">0</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash"></i></button></td> </tr>'
		);


		$('#chargetype').val('');
		$('#chargeamount').val('0');

		allExtraChargeCalculation();
		$('#job').focus();

	}
}

function updateExtraCharge() {
	if (!$("#expensesform")[0].checkValidity()) {

		$("#chargesubmitBtn").click();
	} else {
		var chargetype = $('#chargetype').val();
		var chargeamount = $('#chargeamount').val();
		const rowId = $('#extra_charge_row_id').val();

		$('#chargetableorder > tbody:last').append('<tr class="pointer"><td name="chargetype">' +
			chargetype + '</td><td name="chargeamount" class="text-right chargesamount">' +
			chargeamount +
			'</td><td class="text-end d-none insert_status">updated</td><td class="text-end d-none row_id">'+rowId+'</td>'+
            '<td class="text-end"> <button type="button" class="btn btn-primary btn-sm" id="'+rowId+'" onclick="editExtraChargeRow(this)"><i class="fas fa-pen"></i></button>'+
            '<button type="button" class="btn btn-danger btn-sm ml-1" id="'+rowId+'" onclick="deleteExtraChargeRow(this)"><i class="fas fa-trash"></i></button></td></tr>'
		);

		$('#chargetype').val('');
		$('#chargeamount').val('0');
        $('#extra_charge_row_id').val(0);
        deletedUpdatedExtraChargeRow(rowId);

        $('.update-extra-charge-btn').addClass('d-none');
        $('.add-extra-charge-btn').removeClass('d-none');
		$('#job').focus();

		allExtraChargeCalculation();
	}
}

function editExtraChargeRow(button) {
    if (confirm("Are you sure you want to edit this row?")) {
        const row = $(button).closest('tr');

        const chargeName = row.find('td:eq(0)').text();
        const price = parseFloat(row.find('td:eq(1)').text());
        const rowId = row.find('.row_id').text();

        $('#chargetype').val(chargeName);
        $('#chargeamount').val(price);
        $('#extra_charge_row_id').val(rowId);

        $('.update-extra-charge-btn').removeClass('d-none');
        $('.add-extra-charge-btn').addClass('d-none');
        // row.remove();
    }
}

function deletedUpdatedExtraChargeRow(rowId){
    $('#chargetableorder tbody tr').each(function () {
        const insertStatus = $(this).find('.insert_status').text().trim();
        const rowIdFromTable = $(this).find('.row_id').text().trim();

        if ((insertStatus === 'existing' || insertStatus === 'updated') && rowIdFromTable == rowId) {
            $(this).remove(); 
            return false; 
        }
    });
}

function deleteExtraChargeRow(button) {
     if (confirm("Are you sure you want to delete this row?")) {
        const row = $(button).closest('tr');
        row.find('.insert_status').text('deleted');
        row.addClass('d-none');
        allExtraChargeCalculation();
    }
}

function allItemsTotalCalculation(){
    let totalSum = 0;
    $('#tableorder tbody tr').each(function () {
        const insertStatus = $(this).find('.insert_status').text().trim();
        if (insertStatus !== 'deleted') {
            const value = parseFloat($(this).find('.total_after_tax').text()) || 0;
            totalSum += value;
        }
    });
    var showsum = addCommas(parseFloat(totalSum).toFixed(2));
    $('#divtotal').text('Rs. '+ showsum)
    $('#hidetotalorder').val(totalSum.toFixed(2))
    finaltotalcalculate();
}

function allExtraChargeCalculation(){
    var sum = 0;
    $('#chargetableorder tbody tr').each(function () {
        const insertStatus = $(this).find('.insert_status').text().trim();
        if (insertStatus !== 'deleted') {
            const value = parseFloat($(this).find('.chargesamount').text()) || 0;
            sum += value;
        }
    });
    var showsum = addCommas(parseFloat(sum).toFixed(2));

    $('#divchargestotal').html('<strong style="background-color: yellow;"> Rs. <strong>' + showsum);

    $('#hidechargestotal').val(sum);
    finaltotalcalculate();
}

function finaltotalcalculate(){
    let tableTotal = parseFloat($('#hidetotalorder').val()) || 0;
    let extrachargeTotal = parseFloat($('#hidechargestotal').val()) || 0;

    let subTotal = tableTotal + extrachargeTotal;
    $('#hiddenfulltotal').val(subTotal.toFixed(2)); 

    let vatPercent = parseFloat($('#vat').val()) || 0;
    let vatamount = (subTotal * vatPercent) / 100;
    $('#vatamount').val(vatamount.toFixed(2)); 

    let totalPayment = subTotal + vatamount;
    $('#modeltotalpayment').val(totalPayment.toFixed(2)); 
    
}

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
</script>