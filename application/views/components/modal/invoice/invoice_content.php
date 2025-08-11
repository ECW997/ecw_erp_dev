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
                                <th
                                    class="text-center <?= ($is_confirmed == 0 && $invoice_type == 'direct' && ($deletecheck != 0 || $editcheck != 0)) ? '' : 'd-none' ?>">
                                    Action</th>
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
                                <td class="text-end d-none discount_amount">
                                    <?php echo ($item['line_discount_amount']); ?></td>
                                <td class="text-end d-none total_after_discount">
                                    <?php echo ($item['line_total_after_discount']); ?></td>
                                <td class="text-end"><?php echo ($item['line_tax_amount']); ?></td>
                                <td class="text-end total_after_tax"><?php echo ($item['line_total_after_tax']); ?></td>
                                <td class="text-end d-none insert_status">existing</td>
                                <td class="text-end d-none item_id"><?php echo $item['item_id']; ?></td>
                                <td class="text-end d-none row_id"><?php echo $item['id']; ?></td>
                                <td class="text-end d-none pre_item"><?php echo $item['item_id']; ?></td>
                                <td class="text-end d-none pre_qty"><?php echo $item['quantity']; ?></td>
                                <td
                                    class="text-center <?= $is_confirmed == 0 ? '' : 'd-none' ?> <?= (isset($invoice_main_data[0]['invoice_type'])) && $invoice_main_data[0]['invoice_type'] == 'direct' ? '' : 'd-none' ?>">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" title="Edit"
                                            class="btn btn-primary <?= ($editcheck == 0) ? 'd-none' : '' ?>"
                                            id="<?php echo $item['id']; ?>" onclick="editRow(this)">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button" title="Delete"
                                            class="btn btn-danger <?= ($deletecheck == 0) ? 'd-none' : '' ?>"
                                            id="<?php echo $item['id']; ?>" onclick="deleteRow(this)">
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
                    <div class="col-md-6 offset-md-6">
                        <div class="total-display d-flex justify-content-between">
                            <span class="total-label text-dark">Sub Total:</span>
                            <span class="total-amount" id="divtotal">Rs. 0.00</span>
                            <input type="hidden" id="hidetotalorder" value="0">
                        </div>

                        <div class="total-display d-flex justify-content-between mt-2">
                            <span class="total-label text-dark">Line Discount:</span>
                            <span class="total-amount text-danger" id="div_line_discount_total">- Rs. 0.00</span>
                            <input type="hidden" id="hide_line_discount_totalorder" value="0">
                        </div>

                        <div class="total-display d-flex justify-content-between mt-2">
                            <span class="total-label text-dark">Header Discount:</span>
                            <span class="total-amount text-danger" id="div_header_discount_total">- Rs. 0.00</span>
                            <input type="hidden" id="hide_header_discount_totalorder" value="0">
                        </div>

                        <!-- <div class="total-display d-flex justify-content-between mt-2 border-top pt-2">
                            <span class="total-label fw-bold text-dark">Grand Total:</span>
                            <span class="total-amount fw-bold" id="div_grand_total">Rs. 0.00</span>
                            <input type="hidden" id="hide_grand_total" value="0">
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="col-auto px-0">
                <div class="vr h-100" style="border-left: 2px dashed #dee2e6;"></div>
            </div>

            <div class="col-lg">
                <div class="extra-charges-card border">
                    <h6 class="section-title p-2 mb-3 rounded">Extra Charges</h6>

                    <form id="expensesform" autocomplete="off" class="mb-3 <?= $is_confirmed == 0 ? '' : 'd-none' ?>">
                        <div class="row g-2">
                            <div class="col-7">
                                <label class="small form-label text-dark">Charge Type</label>
                                <input type="text" id="chargetype" name="chargetype"
                                    class="form-control form-control-sm" />
                            </div>
                            <div class="col-5">
                                <label class="small form-label text-dark">Amount</label>
                                <input type="number" step="any" name="chargeamount"
                                    class="form-control form-control-sm text-end" id="chargeamount" required>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="button" title="Insert" id="secondformsubmit"
                                        class="btn btn-success btn-sm add-extra-charge-btn <?= ($addcheck == 0) ? 'd-none' : '' ?>"
                                        onclick="insertExtraCharge();">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" title="Update" id="secondupdateformsubmit"
                                        class="btn btn-warning btn-sm d-none update-extra-charge-btn <?= ($editcheck == 0) ? 'd-none' : '' ?>"
                                        onclick="updateExtraCharge();">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="" id="chargetable-wrapper">
                        <table class="table table-sm small" id="chargetableorder">
                            <thead class="table-light">
                                <tr>
                                    <th>Charge Type</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-end  <?= $is_confirmed == 0 ? '' : 'd-none' ?>">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($extra_charge_data)): ?>
                                <?php foreach ($extra_charge_data as $item): ?>
                                <tr>
                                    <td name="chargetype"><?php echo $item['charge_type']; ?></td>
                                    <td class="text-end chargesamount" name="chargeamount">
                                        <?php echo ($item['charge_amount']); ?></td>
                                    <td class="text-end d-none insert_status">existing</td>
                                    <td class="text-end d-none row_id"><?php echo $item['id']; ?></td>
                                    <td class="text-end <?= $is_confirmed == 0 ? '' : 'd-none' ?>">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" title="Edit"
                                                class="btn btn-primary <?= ($editcheck == 0) ? 'd-none' : '' ?>"
                                                id="<?php echo $item['id']; ?>" onclick="editExtraChargeRow(this)">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button type="button" title="Delete"
                                                class="btn btn-danger <?= ($deletecheck == 0) ? 'd-none' : '' ?>"
                                                id="<?php echo $item['id']; ?>" onclick="deleteExtraChargeRow(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <input name="extra_charge_row_id" type="number" id="extra_charge_row_id" value="0"
                            class="d-none">

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
                <!-- Invoice Summary Card -->
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <input type="hidden" id="invoice_type" name="invoice_type" value="<?= $invoice_type ?>">
                            <div class="row" id="advance_section">
                                <div class="col-md-12">
                                    <div class="row g-3">
                                        <div class="col-lg">
                                            <div class="extra-charges-card border">
                                                <h6 class="section-title p-2 mb-3 rounded">Advance Payments</h6>
                                                <form id="advance_recieptform" autocomplete="off"
                                                    class="mb-3 <?= $is_confirmed == 0 ? '' : 'd-none' ?>">
                                                    <div class="row g-2">
                                                        <div class="col-4">
                                                            <label class="small form-label text-dark">Reciepts
                                                                Number</label>
                                                            <select class="form-select form-select-sm input-field"
                                                                name="reciept_no" id="reciept_no" required>
                                                                <option value="">Select</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-8">
                                                            <label
                                                                class="small form-label text-dark d-none">Reciepts</label>
                                                        </div>

                                                        <div class="col-4 mt-2">
                                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                                <button type="button" title="Insert"
                                                                    class="btn btn-success btn-sm add-receipt-btn <?= ($addcheck == 0) ? 'd-none' : '' ?>"
                                                                    onclick="insertReciept();">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>

                                                                <button type="button" title="Update"
                                                                    class="btn btn-warning btn-sm d-none update-receipt-btn <?= ($editcheck == 0) ? 'd-none' : '' ?>"
                                                                    onclick="updateReciept();">
                                                                    <i class="fas fa-sync"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                <div class="" id="reciepttable-wrapper">
                                                    <table class="table table-sm small" id="reciepttableorder">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th style="width:20%;">Receipt Number</th>
                                                                <th style="width:20%;">Jobcard Number</th>
                                                                <th style="width:15%;">Pay Date</th>
                                                                <th class="text-center" style="width:15%;">Payment
                                                                    Method</th>
                                                                <th class="text-end" style="width:15%;">Amount</th>
                                                                <th
                                                                    class="text-end <?= $is_confirmed == 0 ? '' : 'd-none' ?>">
                                                                    Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($reciept_data)): ?>
                                                            <?php foreach ($reciept_data as $item): ?>
                                                            <tr>
                                                                <td name="receiptnumber">
                                                                    <?php echo $item['receipt_no']; ?></td>
                                                                <td name="jobcardnumber">
                                                                    <?php echo ($item['jobcard_no']); ?></td>
                                                                <td name="paydate">
                                                                    <?php echo ($item['payment_date']); ?></td>
                                                                <td class="text-center" name="paymenttype">
                                                                    <?php echo ($item['payment_option']); ?></td>
                                                                <td class="text-end receiptsamount"
                                                                    name="receiptamount">
                                                                    <?php echo ($item['amount']); ?></td>

                                                                <td class="text-end d-none insert_status">existing</td>
                                                                <td class="text-end d-none row_id">
                                                                    <?php echo $item['id']; ?></td>
                                                                <td
                                                                    class="text-end <?= $is_confirmed == 0 ? '' : 'd-none' ?>">
                                                                    <div class="btn-group btn-group-sm" role="group">
                                                                        <button type="button" title="Edit_2"
                                                                            class="btn btn-primary <?= ($editcheck == 0) ? 'd-none' : '' ?>"
                                                                            id="<?php echo $item['id']; ?>"
                                                                            onclick="editAdvancePaymentRow(this)">
                                                                            <i class="fas fa-pen"></i>
                                                                        </button>
                                                                        <button type="button" title="Delete"
                                                                            class="btn btn-danger <?= ($deletecheck == 0) ? 'd-none' : '' ?>"
                                                                            id="<?php echo $item['id']; ?>"
                                                                            onclick="deleteAdvancePaymentRow(this)">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                    <input name="advance_payment_row_id" type="number"
                                                        id="advance_payment_row_id" value="0" class="d-none">

                                                    <div class="row mt-2">
                                                        <div class="col-12 text-end">
                                                            <div class="total-display">
                                                                <span class="total-label text-dark">Advance Payment
                                                                    Total:</span>
                                                                <span class="total-amount" id="advancetotal">Rs.
                                                                    0.00</span>
                                                                <input type="hidden" id="hideadvancetotal" value="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="row g-3">
                                        <div class="col">
                                            <label class="small form-label text-dark mb-1">Sub Total + Extra
                                                Charges</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-light">Rs.</span>
                                                <input type="number" step="any" id="total_sub_amount"
                                                    name="total_sub_amount" class="form-control text-end bg-light"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="small form-label text-dark mb-1">Total Discount</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-light">Rs.</span>
                                                <input type="number" step="any" id="total_discount"
                                                    name="total_discount" class="form-control text-end bg-light"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col d-none">
                                            <label class="small form-label text-dark mb-1">Grand Total</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-light">Rs.</span>
                                                <input type="number" step="any" id="hiddenfulltotal"
                                                    name="hiddenfulltotal" class="form-control text-end bg-light"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="small form-label text-dark mb-1">VAT (%)</label>
                                            <div class="input-group input-group-sm">
                                                <input type="number" id="vat" name="vat" class="form-control text-end"
                                                    value="<?= isset($invoice_main_data[0]['inv_tax_pc']) ? $invoice_main_data[0]['inv_tax_pc'] : '0' ?>"
                                                    onkeyup="finaltotalcalculate();" required
                                                    <?= $is_confirmed == 0 ? '' : 'disabled' ?>>
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="small form-label text-dark mb-1">VAT Amount</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-light">Rs.</span>
                                                <input type="number" id="vatamount" name="vatamount"
                                                    class="form-control text-end bg-light" value="0" readonly>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="small form-label text-dark mb-1">Total Advance Amount</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-light">Rs.</span>
                                                <input type="number" id="advanceamount" name="advanceamount"
                                                    class="form-control text-end bg-light" value="0" readonly>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="small form-label text-dark mb-1">Total invoice Amount</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-warning text-white fw-bold">Rs.</span>
                                                <input type="number" step="any" id="modeltotalpayment"
                                                    name="modeltotalpayment"
                                                    class="form-control text-end bg-warning text-white fw-bold"
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <label class="small form-label text-dark mb-1">Total Payable Amount</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-success text-white fw-bold">Rs.</span>
                                                <input type="number" step="any" id="modeltotalpayablepayment"
                                                    name="modeltotalpayablepayment"
                                                    class="form-control text-end bg-success text-white fw-bold"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-3">
                                <?php $selected_series_type = $invoice_main_data[0]['series_type'] ?? ''; ?>
                                <div class="col-2">
                                    <label class="small form-label text-dark mb-1">Invoice Series Type</label>
                                    <div class="input-group input-group-sm">
                                        <select class="form-control form-control-sm selecter2 px-0" name="series_type"
                                            id="series_type" required <?= $is_confirmed == 0 ? '' : 'disabled' ?>>
                                            <option value=" " <?= $selected_series_type == ' ' ? 'selected' : '' ?>>
                                                Select Series Type</option>
                                            <option value="1" <?= $selected_series_type == '1' ? 'selected' : '' ?>>
                                                Series 01</option>
                                            <option value="2" <?= $selected_series_type == '2' ? 'selected' : '' ?>>
                                                Series 02</option>
                                        </select>
                                    </div>
                                </div>
                                <?php $selected_payment_type = $invoice_main_data[0]['payment_type'] ?? ''; ?>
                                <div class="col-2">
                                    <label class="small form-label text-dark mb-1">Payment Method</label>
                                    <div class="input-group input-group-sm">
                                        <select class="form-control form-control-sm selecter2 px-0" name="paymenttype"
                                            id="paymenttype" required <?= $is_confirmed == 0 ? '' : 'disabled' ?>>
                                            <option value=" " <?= $selected_payment_type == ' ' ? 'selected' : '' ?>>
                                                Select Payment Method</option>
                                            <option value="1" <?= $selected_payment_type == '1' ? 'selected' : '' ?>>
                                                Cash</option>
                                            <option value="2" <?= $selected_payment_type == '2' ? 'selected' : '' ?>>
                                                Credit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2" id="predict_days_col">
                                    <label class="small form-label text-dark mb-1">Predict Days</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="predict_days"
                                            class="form-control form-control-sm input-highlight" id="predict_days"
                                            value="<?= isset($invoice_main_data[0]['predict_days']) ? $invoice_main_data[0]['predict_days'] : '' ?>"
                                             <?= $is_confirmed == 0 ? '' : 'disabled' ?>>
                                    </div>
                                </div>
                                <div class="col-2" id="due_date_col">
                                    <label class="form-label small fw-bold">Due Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-sm input-field" name="due_date"
                                        id="due_date"
                                        value="<?= isset($invoice_main_data[0]['due_date']) ? $invoice_main_data[0]['due_date'] : date('Y-m-d') ?>"
                                        <?= $is_confirmed == 0 ? '' : 'disabled' ?>>
                                </div>
                                <div class="col-md">
                                    <label class="small form-label text-dark">Remarks</label>
                                    <textarea name="remark" id="remark" class="form-control form-control-sm" rows="2"
                                        <?= $is_confirmed == 0 ? '' : 'disabled' ?>><?= $invoice_main_data[0]['notes'] ?? '' ?></textarea>


                                    <input type="hidden" name="jobcard_id"
                                        class="form-control form-control-sm input-highlight" id="jobcard_id"
                                        value="<?= isset($invoice_main_data[0]['job_card_id']) ? $invoice_main_data[0]['job_card_id'] : '' ?>">

                                    <input type="hidden" name="approve_id"
                                        class="form-control form-control-sm input-highlight" id="approve_id"
                                        value="<?= isset($invoice_main_data[0]['is_confirmed']) ? $invoice_main_data[0]['is_confirmed'] : '' ?>"
                                        required>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <?php
                                    $is_button_hidden = ($is_confirmed != 0) || ($is_edit ? $editcheck == 0 : $addcheck == 0);
                                    ?>
                                    <button type="button" id="btncreateorder"
                                        class="btn btn-primary w-100 fw-bold <?= $is_button_hidden ? 'd-none' : '' ?>"
                                        onclick="createInvoice();">
                                        <i class="fas fa-save me-2"></i><?= $is_edit ? 'Update' : 'Create'; ?> Invoice
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Hidden Fields -->
                <input name="invoice_record_id" type="number" id="invoice_record_id"
                    value="<?= $invoice_main_data[0]['id'] ?? '' ?>" class="d-none">
            </div>
        </div>
    </div>
</div>
<style>
.payment-method-card {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
    height: 100%;
    transition: all 0.3s ease;
}

.payment-method-card.active {
    border-color: #0d6efd;
    background-color: #f8f9fa;
}
</style>

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


<?php if (!empty($reciept_data)) : ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    //  calculateAdvanceTotal();
    alladvancepaymentCalculation();
});
</script>
<?php endif; ?>

<script>
$(document).ready(function() {
    const approveVal = $('#approve_id').val();
    if (approveVal === "1" || approveVal === "2") {
        $('#btncreateorder').prop('disabled', true);
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const invoiceType = document.getElementById('invoice_type').value;
    const advanceSection = document.getElementById('advance_section');

    if (invoiceType.toLowerCase() === 'direct') {
        advanceSection.style.display = 'none';
    } else {
        advanceSection.style.display = 'block';
    }
});
</script>

<script>
$(document).ready(function() {
    function toggleDueFields() {
        const paymentType = $('#paymenttype').val();
        if (paymentType === '2') {
            $('#predict_days_col').show();
            $('#due_date_col').show();
            $('#predict_days').prop('required', true);
            $('#due_date').prop('required', true);
        } else {
            $('#predict_days_col').hide();
            $('#due_date_col').hide();
            $('#predict_days').prop('required', false).val('');
            $('#due_date').prop('required', false).val('');
        }
    }

    // Initial check
    toggleDueFields();

    // Listen for Select2 change event
    $('#paymenttype').on('change.select2 change', toggleDueFields);
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const dueDateInput = document.getElementById('due_date');
    if (!dueDateInput.value) {
        const today = new Date();
        dueDateInput.value = today.toISOString().slice(0, 10);
    }

    const predictDaysInput = document.getElementById('predict_days');
    predictDaysInput.addEventListener('input', function() {
        const days = parseInt(this.value, 10);
        if (!isNaN(days)) {
            const today = new Date();
            today.setDate(today.getDate() + days);
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            dueDateInput.value = `${yyyy}-${mm}-${dd}`;
        }
    });
});
</script>

<script>
$(document).ready(function() {
    $('#series_type').select2({
        width: '100%',
    });
    $('#paymenttype').select2({
        width: '100%',
        // placeholder: 'Select Payment Type',
        // allowClear: true
    });


    $('#reciept_no').select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>Invoice/getAdvancePayments',
            dataType: 'json',
            data: function(params) {
                return {
                    jobcard_id: $('#jobcard_id').val(),
                    page: params.page || 1
                };
            },
            cache: true,
            processResults: function(data) {
                if (data.status === true) {
                    return {
                        results: data.data.item.map(item => ({
                            id: item.id,
                            text: item.receiptnumber + ' / ' + item.jobcard_number,
                            receiptnumber: item.receiptnumber,
                            jobcard_number: item.jobcard_number,
                            amount: item.amount,
                            pay_date: item.pay_date,
                            payment_type: item.payment_type,
                            jobcard_id: item.jobcard_id,
                        })),
                        pagination: {
                            more: data.data.pagination.more
                        }
                    };
                }
            }
        }
    });

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

    $('.payment-toggle').change(function() {
        const card = $(this).closest('.payment-method-card');
        const details = card.find('.amount-input, .payment-details');

        if ($(this).is(':checked')) {
            card.addClass('active');
            details.slideDown();
        } else {
            card.removeClass('active');
            details.slideUp();
            card.find('input').val('');
        }
        finaltotalcalculate();
    });

    // Update payment data when amounts change
    $('.payment-method-card').on('input', 'input', function() {
        finaltotalcalculate();
    });

});

function insertReciept() {
    const form = $("#advance_recieptform")[0];

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const selected = $('#reciept_no').select2('data')[0];

    if (!selected || !selected.receiptnumber) {
        alert("Please select a receipt.");
        return;
    }

    const {
        receiptnumber,
        jobcard_number,
        jobcard_id,
        payment_type,
        pay_date,
        amount
    } = selected;

    if (!receiptnumber || !jobcard_number || !amount || !pay_date) {
        alert("Some receipt details are missing.");
        return;
    }

    const isDuplicate = $('#reciepttableorder tbody tr').toArray().some(row => {
        const existing = $(row).find('td[name="receiptnumber"]').text().trim();
        const existingJobcard = $(row).find('td[name="jobcardnumber"]').text().trim();
        return existing === receiptnumber && existingJobcard === jobcard_number;
    });

    if (isDuplicate) {
        alert("This receipt is already added.");
        return;
    }

    const paymenttypeTextMap = {
        CASH: 'Cash',
        CHEQUE: 'Cheque',
        BANK_TRANSFER: 'Bank Transfer',
        CREDIT_CARD: 'Credit Card'
    };

    const payment_type_text = paymenttypeTextMap[payment_type] || 'Unknown';

    $('#reciepttableorder > tbody:last').append(`
        <tr class="pointer">
            <td name="receiptnumber">${receiptnumber}</td>
            <td name="jobcardnumber">${jobcard_number}</td>
            <td name="paydate">${pay_date}</td>
            <td name="paymenttype" class="text-center">${payment_type_text}</td>
            <td name="receiptamount" class="text-end receiptsamount">${parseFloat(amount).toFixed(2)}</td>
            <td class="text-end d-none insert_status">new</td>
            <td class="text-end d-none row_id">0</td>
            <td class="text-end d-none jobcard_id">${jobcard_id}</td>
            <td>
                <button type="button" title="Delete" onclick="advancePaymentSoftDelete(this);" class="btn btn-danger btn-sm float-right">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `);

    $('#reciept_no').val(null).trigger('change');
    alladvancepaymentCalculation();
    $('#reciept_no').focus();
}


function updateReciept() {
    const form = $("#advance_recieptform")[0];

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const selected = $('#reciept_no').select2('data')[0];

    if (!selected || !selected.receiptnumber) {
        alert("Please select a receipt.");
        return;
    }

    const {
        receiptnumber,
        jobcard_number,
        jobcard_id,
        payment_type,
        pay_date,
        amount
    } = selected;

    if (!receiptnumber || !jobcard_number || !amount || !pay_date) {
        alert("Some receipt details are missing.");
        return;
    }

    const rowId = $('#advance_payment_row_id').val();

    // Prevent duplicate except for the row being updated
    const isDuplicate = $('#reciepttableorder tbody tr').toArray().some(row => {
        const existing = $(row).find('td[name="receiptnumber"]').text().trim();
        const existingJobcard = $(row).find('td[name="jobcardnumber"]').text().trim();
        const existingRowId = $(row).find('.row_id').text().trim();
        return existing === receiptnumber && existingJobcard === jobcard_number && existingRowId !== rowId;
    });

    if (isDuplicate) {
        alert("This receipt is already added.");
        return;
    }

    const paymenttypeTextMap = {
        CASH: 'Cash',
        CHEQUE: 'Cheque',
        BANK_TRANSFER: 'Bank Transfer',
        CREDIT_CARD: 'Credit Card',
        1: 'Cash',
        2: 'Cheque',
        3: 'Bank Transfer',
        4: 'Credit Card'
    };
    const payment_type_text = paymenttypeTextMap[payment_type] || payment_type || 'Unknown';

    $('#reciepttableorder > tbody:last').append(`
        <tr class="pointer recently-edited-row">
            <td name="receiptnumber">${receiptnumber}</td>
            <td name="jobcardnumber">${jobcard_number}</td>
            <td name="paydate">${pay_date}</td>
            <td name="paymenttype" class="text-center">${payment_type_text}</td>
            <td name="receiptamount" class="text-end receiptsamount">${parseFloat(amount).toFixed(2)}</td>
            <td class="text-end d-none insert_status">updated</td>
            <td class="text-end d-none row_id">${rowId}</td>
            <td class="text-end d-none jobcard_id">${jobcard_id}</td>
            <td class="text-end">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" title="Edit" class="btn btn-primary btn-sm" id="${rowId}" onclick="editAdvancePaymentRow(this)">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button type="button" title="Delete" class="btn btn-danger btn-sm" id="${rowId}" onclick="deleteAdvancePaymentRow(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `);

    $('#reciept_no').val(null).trigger('change');
    $('#advance_payment_row_id').val(0);
    deletedUpdatedAdvanceRow(rowId);

    $('.update-receipt-btn').addClass('d-none');
    $('.add-receipt-btn').removeClass('d-none');
    $('#reciept_no').focus();

    alladvancepaymentCalculation();
}


function editAdvancePaymentRow(button) {
    if (confirm("Are you sure you want to edit this row?")) {
        const row = $(button).closest('tr');

        const receipt_number = row.find('td[name="receiptnumber"]').text().trim();
        const jobcard_number = row.find('td[name="jobcardnumber"]').text().trim();
        const pay_date = row.find('td[name="paydate"]').text().trim();
        const amount = parseFloat(row.find('td[name="receiptamount"]').text());
        const payment_type_text = row.find('td[name="paymenttype"]').text().trim();
        const rowId = row.find('.row_id').text().trim();

        $('#reciept_no option').each(function() {
            const opt = $(this);
            if (
                opt.data('receipt_number') === receipt_number &&
                opt.data('jobcard_number') === jobcard_number &&
                opt.data('pay_date') === pay_date &&
                parseFloat(opt.data('amount')) === amount
            ) {
                $('#reciept_no').val(opt.val()).trigger('change');
                return false;
            }
        });

        $('#advance_payment_row_id').val(rowId);


        $('.update-receipt-btn').removeClass('d-none');
        $('.add-receipt-btn').addClass('d-none');
    }
}


function deletedUpdatedAdvanceRow(rowId) {
    $('#reciepttableorder tbody tr').each(function() {
        const insertStatus = $(this).find('.insert_status').text().trim();
        const rowIdFromTable = $(this).find('.row_id').text().trim();

        if ((insertStatus === 'existing' || insertStatus === 'updated') && rowIdFromTable == rowId) {
            $(this).remove();
            return false;
        }
    });
}


function deleteAdvancePaymentRow(button) {
    if (confirm("Are you sure you want to delete this row?")) {
        const row = $(button).closest('tr');
        row.find('.insert_status').text('deleted');
        row.addClass('d-none');
        alladvancepaymentCalculation();

    }
}


function alladvancepaymentCalculation() {
    var sum = 0;
    $('#reciepttableorder tbody tr').each(function() {
        const insertStatus = $(this).find('.insert_status').text().trim();
        if (insertStatus !== 'deleted') {
            const value = parseFloat($(this).find('.receiptsamount').text()) || 0;
            sum += value;
        }
    });
    var showsum = addCommas(parseFloat(sum).toFixed(2));

    $('#advancetotal').html('<strong style=""> Rs. <strong>' + showsum);

    $('#hideadvancetotal').val(sum);
    $('#advanceamount').val(sum.toFixed(2));
    finaltotalcalculate();
}


// function calculateAdvanceTotal() {
//     let total = 0;
//     $('.amount-cell').each(function() {
//         total += parseFloat($(this).text()) || 0;
//     });

//     $('#advancetotal').text('Rs. ' + total.toFixed(2));
//     $('#hideadvancetotal').val(total.toFixed(2));

//     $('#advanceamount').val(total.toFixed(2));

//     finaltotalcalculate();

// }

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

$("#secondformsubmit").click(function() {});

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
            '</td><td class="text-end d-none insert_status">new</td><td class="text-end d-none row_id">0</td>' +
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
            '</td><td class="text-end d-none insert_status">updated</td><td class="text-end d-none row_id">' +
            rowId + '</td>' +
            '<td class="text-end"><div class="btn-group btn-group-sm" role="group">' +
            '<button type="button" title="Edit" class="btn btn-primary btn-sm" id="' + rowId +
            '" onclick="editExtraChargeRow(this)"><i class="fas fa-pen"></i></button>' +
            '<button type="button" title="Delete" class="btn btn-danger btn-sm" id="' + rowId +
            '" onclick="deleteExtraChargeRow(this)"><i class="fas fa-trash"></i></button></div></td></tr>'
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

function deletedUpdatedExtraChargeRow(rowId) {
    $('#chargetableorder tbody tr').each(function() {
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

function allItemsTotalCalculation() {
    let totalSum = 0;
    let totalLineDiscount = 0;

    $('#tableorder tbody tr').each(function() {
        const insertStatus = $(this).find('.insert_status').text().trim();
        if (insertStatus !== 'deleted') {
            const value = parseFloat($(this).find('.sub_total').text()) || 0;
            totalSum += value;

            const discount_value = parseFloat($(this).find('.discount_amount').text()) || 0;
            totalLineDiscount += discount_value;
        }
    });

    var showsum = addCommas(parseFloat(totalSum).toFixed(2));
    $('#divtotal').text('Rs. ' + showsum);
    $('#hidetotalorder').val(totalSum.toFixed(2));

    var showLineDiscountsum = addCommas(parseFloat(totalLineDiscount).toFixed(2));
    $('#div_line_discount_total').text('Rs. ' + showLineDiscountsum);
    $('#hide_line_discount_totalorder').val(totalLineDiscount.toFixed(2));

    var header_discount;
    <?php if ($is_edit): ?>
    header_discount = <?php 
            $inv_discount = isset($invoice_main_data[0]['inv_discount_amount']) ? $invoice_main_data[0]['inv_discount_amount'] : 0;
            echo number_format($inv_discount, 2, '.', ''); 
        ?>;
    if (header_discount > 0) {
        header_discount = parseFloat(header_discount) - totalLineDiscount;
    } else {
        header_discount = 0;
    }

    <?php else: ?>
    header_discount = parseFloat($('#header_discount_total').val()) || 0;
    <?php endif; ?>

    var showHeaderDiscountsum = addCommas(parseFloat(header_discount).toFixed(2));
    $('#div_header_discount_total').text('Rs. ' + showHeaderDiscountsum);
    $('#hide_header_discount_totalorder').val(header_discount.toFixed(2));

    var totalDiscount = totalLineDiscount + header_discount;

    // var grandTotal=totalSum-totalDiscount;
    // var showGrandsum = addCommas(parseFloat(grandTotal).toFixed(2));
    // $('#div_grand_total').text('Rs. '+ showGrandsum);
    // $('#hide_grand_total').val(grandTotal.toFixed(2));

    $('#total_discount').val(totalDiscount.toFixed(2));

    finaltotalcalculate();
}

function allExtraChargeCalculation() {
    var sum = 0;
    $('#chargetableorder tbody tr').each(function() {
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

function finaltotalcalculate() {
    let tableTotal = parseFloat($('#hidetotalorder').val()) || 0;
    let extrachargeTotal = parseFloat($('#hidechargestotal').val()) || 0;

    let subTotal = parseFloat($('#hidetotalorder').val()) + extrachargeTotal;
    $('#total_sub_amount').val(subTotal.toFixed(2));

    let totalDiscount = parseFloat($('#total_discount').val()) || 0;

    let totalAdvance = parseFloat($('#advanceamount').val()) || 0;

    let lastTotal = (tableTotal + extrachargeTotal) - totalDiscount;
    $('#hiddenfulltotal').val(lastTotal.toFixed(2));

    let vatPercent = parseFloat($('#vat').val()) || 0;
    let vatamount = (lastTotal * vatPercent) / 100;
    $('#vatamount').val(vatamount.toFixed(2));

    let totalPayment = lastTotal + vatamount;
    let totalpayblePayment = (lastTotal + vatamount) - totalAdvance;
    var showsum = addCommas(parseFloat(totalPayment).toFixed(2));
    $('#grand-total-amount').text('Rs. ' + showsum);
    $('#payment_total_grand_amount').val(totalPayment.toFixed(2));
    $('#modeltotalpayment').val(totalPayment.toFixed(2));
    $('#modeltotalpayablepayment').val(totalpayblePayment.toFixed(2));

    let advancePayment = parseFloat($('#payment_total_advance_amount').val()) || 0;

    // const payments = [];
    // let totalPaid = 0;

    // $('.payment-toggle:checked').each(function() {
    //   const type = $(this).val();
    //   const card = $(this).closest('.payment-method-card');
    //   const amount = parseFloat(card.find('.amount-input input,.bank-amount').val()) || 0;

    //   const payment = { type, amount };
    //   if(type === '3') {
    //     payment.reference = card.find('.bank-reference').val() || '';
    //   }

    //   payments.push(payment);
    //   totalPaid += amount;
    // });

    // $('#payment_data').val(JSON.stringify(payments));

    // totalPaid = totalPaid + advancePayment;
    // $('#total-paid-amount').text('Rs. ' + addCommas(totalPaid.toFixed(2)));
    // $('#payment_total_paid_amount').val(totalPaid.toFixed(2));

    // var balancePayment = totalPayment - totalPaid;
    // balancePayment = balancePayment < 0 ? Math.abs(balancePayment) : 0;
    // $('#total-balance-amount').text('Rs. ' + addCommas(balancePayment.toFixed(2)));
    // $('#payment_total_balance_amount').val(balancePayment.toFixed(2));


    // var arrearsPayment = totalPayment - totalPaid;
    // arrearsPayment = arrearsPayment > 0 ? Math.abs(arrearsPayment) : 0;
    // $('#total-arrears-amount').text('Rs. ' + addCommas(arrearsPayment.toFixed(2)));
    // $('#payment_total_arrears_amount').val(arrearsPayment.toFixed(2));


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

function advancePaymentSoftDelete(button) {
    if (confirm("Are you sure you want to delete this Payment?")) {
        const row = $(button).closest('tr');
        row.remove();
        alladvancepaymentCalculation();
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