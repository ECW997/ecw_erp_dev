
<hr class="custom-blue-hr">
<div class="card invoice-card">
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="table-responsive" id="tableorder-wrapper">
                    <table class="table table-hover table-bordered table-sm invoice-table" id="tableorder">
                        <thead class="table-primary">
                            <tr>
                                <th width="40%">Job Description</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Discount(%)</th>
                                <th class="text-center">Tax</th>
                                <th class="text-end">Total Amount</th>
                                <th class="text-center <?= (isset($invoice_main_data[0]['invoice_type'])) && $invoice_main_data[0]['invoice_type'] == 'direct' ? '' : 'd-none' ?>">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableorderBody" class="table-group-divider">
                            <?php if (!empty($invoice_detail_data)): ?>
                                <?php foreach ($invoice_detail_data as $item): ?>
                                    <tr>
                                        <td><?php echo $item['description']; ?></td>
                                        <td class="text-center"><?php echo $item['quantity']; ?></td>
                                        <td class="text-center"><?php echo $item['unit']; ?></td>
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
                                        <td class="text-center <?= (isset($invoice_main_data[0]['invoice_type'])) && $invoice_main_data[0]['invoice_type'] == 'direct' ? '' : 'd-none' ?>">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" title="Edit" class="btn btn-primary" id="<?php echo $item['id']; ?>" onclick="editRow(this)">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <button type="button" title="Delete" class="btn btn-danger" id="<?php echo $item['id']; ?>" onclick="deleteRow(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="col text-end">
                        <div class="total-display">
                            <span class="total-label text-dark">Sub Total:</span>
                            <span class="total-amount" id="divtotal">Rs. 0.00</span>
                            <input type="hidden" id="hidetotalorder" value="0">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-auto px-0">
                <div class="vr h-100" style="border-left: 2px dashed #dee2e6;"></div>
            </div>

            <div class="col-lg">
                <div class="extra-charges-card border">
                    <h6 class="section-title p-2 mb-3 rounded">Extra Charges</h6>
                    
                    <form id="expensesform" autocomplete="off" class="mb-3">
                        <div class="row g-2">
                            <div class="col-7">
                                <label class="small form-label text-dark">Charge Type</label>
                                <input type="text" id="chargetype" name="chargetype" class="form-control form-control-sm" />
                            </div>
                            <div class="col-5">
                                <label class="small form-label text-dark">Amount</label>
                                <input type="number" step="any" name="chargeamount" class="form-control form-control-sm text-end" id="chargeamount" required>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="button" title="Insert" id="secondformsubmit" class="btn btn-success btn-sm add-extra-charge-btn" onclick="insertExtraCharge();">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" title="Update" id="secondupdateformsubmit" class="btn btn-warning btn-sm d-none update-extra-charge-btn" onclick="updateExtraCharge();">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive" id="chargetable-wrapper">
                        <table class="table table-sm small" id="chargetableorder">
                            <thead class="table-light">
                                <tr>
                                    <th>Charge Type</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-end">Action</th>
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
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" title="Edit" class="btn btn-primary" id="<?php echo $item['id']; ?>" onclick="editExtraChargeRow(this)">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                    <button type="button" title="Delete" class="btn btn-danger" id="<?php echo $item['id']; ?>" onclick="deleteExtraChargeRow(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <input name="extra_charge_row_id" type="number" id="extra_charge_row_id" value="0" class="d-none">
                        
                        <div class="row mt-2">
                            <div class="col text-end">
                                <div class="total-display">
                                    <span class="total-label text-dark">Charges Total:</span>
                                    <span class="total-amount" id="divchargestotal">Rs. 0.00</span>
                                    <input type="hidden" id="hidechargestotal" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="payment-summary mt-4">
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="small form-label text-dark">Payment Type</label>
                    <select class="form-select form-select-sm" name="payment_type" id="payment_type" required>
                        <option value="">Select Payment Type</option>
                        <option value="1" <?= ($selected_payment == '1') ? 'selected' : '' ?>>Cash</option>
                        <option value="2" <?= ($selected_payment == '2') ? 'selected' : '' ?>>Cheque</option>
                        <option value="3" <?= ($selected_payment == '3') ? 'selected' : '' ?>>Bank Transfer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="small form-label text-dark">Sub Total</label>
                    <input type="number" step="any" name="hiddenfulltotal" class="form-control form-control-sm" id="hiddenfulltotal" readonly>
                </div>
                <div class="col-md-2">
                    <label class="small form-label text-dark">VAT (%)</label>
                    <input type="number" id="vat" name="vat" class="form-control form-control-sm" value="<?= isset($invoice_main_data[0]['inv_tax_pc']) ? $invoice_main_data[0]['inv_tax_pc'] : '18' ?>" onkeyup="finaltotalcalculate();" required>
                </div>
                <div class="col-md-2">
                    <label class="small form-label text-dark">VAT Amount</label>
                    <input type="number" id="vatamount" name="vatamount" class="form-control form-control-sm" value="0" required readonly>
                </div>
                <div class="col-md-4">
                    <label class="small form-label text-dark fw-bold">Total Payment</label>
                    <input type="number" step="any" name="modeltotalpayment" class="form-control form-control-sm fw-bold" id="modeltotalpayment" readonly>
                </div>
                <div class="col-12">
                    <label class="small form-label text-dark">Remarks</label>
                    <textarea name="remark" id="remark" class="form-control form-control-sm" rows="2"><?= $invoice_main_data[0]['notes'] ?? '' ?></textarea>
                </div>
                <input name="invoice_record_id" type="number" id="invoice_record_id" value="<?= $invoice_main_data[0]['id'] ?? '' ?>" class="d-none">
                
                <div class="col-12 text-end mt-3">
                    <button type="button" id="btncreateorder" class="btn btn-primary" onclick="createInvoice();">
                        <i class="fas fa-save me-2"></i><?php echo $is_edit ? 'Update' : 'Create'; ?> Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<?php if (!empty($invoice_detail_data)) : ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            allItemsTotalCalculation();
        });
    </script>
<?php endif; ?>

<?php if (!empty($extra_charge_data)) : ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            allExtraChargeCalculation();
        });
    </script>
<?php endif; ?>


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
			'</td><td class="text-end d-none insert_status">new</td><td class="text-end d-none row_id">0</td>'+
            '<td><button type="button" title="Delete" onclick= "extraChageSoftDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash"></i></button></td> </tr>'
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

		$('#chargetableorder > tbody:last').append('<tr class="pointer recently-edited-row"><td name="chargetype">' +
			chargetype + '</td><td name="chargeamount" class="text-right chargesamount">' +
			chargeamount +
			'</td><td class="text-end d-none insert_status">updated</td><td class="text-end d-none row_id">'+rowId+'</td>'+
            '<td class="text-end"><div class="btn-group btn-group-sm" role="group">'+
            '<button type="button" title="Edit" class="btn btn-primary btn-sm" id="'+rowId+'" onclick="editExtraChargeRow(this)"><i class="fas fa-pen"></i></button>'+
            '<button type="button" title="Delete" class="btn btn-danger btn-sm" id="'+rowId+'" onclick="deleteExtraChargeRow(this)"><i class="fas fa-trash"></i></button></div></td></tr>'
		);

        // let $newRow = $('#chargetableorder > tbody:last tr:last');
        // highlightEditedRow($newRow);

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

    $('#divchargestotal').html('<strong style=""> Rs. <strong>' + showsum);

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


// Soft Delete Functions
function ItemSoftDelete(button) {
    if (confirm("Are you sure you want to delete this charge?")) {
        const row = $(button).closest('tr');
        row.remove();
        allItemsTotalCalculation();
    }
}
function extraChageSoftDelete(button) {
    if (confirm("Are you sure you want to delete this charge?")) {
        const row = $(button).closest('tr');
        row.remove();
        allExtraChargeCalculation();
    }
}

//Highlight Edited Row
function highlightEditedRow($row) {
    $row.addClass('highlight-active');
    setTimeout(() => {
        $row.removeClass('highlight-active');
    }, 1500);
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