<div class="card invoice-card">
    <div class="card-body p-3">
        <form id="createorderform" autocomplete="off">
            <!-- Header Section -->
            <div class="row invoice-header mb-4">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label small fw-bold text-dark">Date <span
                                class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm input-highlight" name="date" id="date"
                            value="<?= isset($invoice_main_data[0]['invoice_date']) ? $invoice_main_data[0]['invoice_date'] : date('Y-m-d') ?>"
                            required readonly>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="invoice-number mt-1">
                        <span class="small fw-bold text-dark">Invoice #</span>
                        <span class="badge bg-primary">
                            <?= !empty($invoice_main_data[0]['invoice_number']) 
                            ? $invoice_main_data[0]['invoice_number'] 
                            : (!empty($invoice_main_data[0]['draft_number']) 
                                ? $invoice_main_data[0]['draft_number'] 
                                : 'New') ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Customer Information Section -->
            <div class="customer-details mb-4 p-3 border rounded ">
                <h6 class="section-title p-2 mb-3 rounded">Customer Information</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label small fw-bold text-dark">Customer Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="customer_name" class="form-control form-control-sm input-highlight"
                                id="customer_name"
                                value="<?= isset($invoice_main_data[0]['customer_name']) ? $invoice_main_data[0]['customer_name'] : '' ?>"
                                required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label small fw-bold text-dark">Customer Address <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="customer_address"
                                class="form-control form-control-sm input-highlight" id="customer_address"
                                value="<?= isset($invoice_main_data[0]['customer_address']) ? $invoice_main_data[0]['customer_address'] : '' ?>"
                                required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label small fw-bold text-dark">Contact No <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="customer_contact"
                                class="form-control form-control-sm input-highlight" id="customer_contact"
                                value="<?= isset($invoice_main_data[0]['contact_no']) ? $invoice_main_data[0]['contact_no'] : '' ?>"
                                required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item Details Section -->
            <div class="invoice-items mb-4 p-3 border rounded ">
                <h6 class="section-title p-2 mb-3 rounded">Item Details</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label small fw-bold text-dark">Item <span
                                    class="text-danger">*</span></label>
                            <select class="form-select form-select-sm input-highlight" name="item" id="item"
                                onchange="getDirectSalesItemDetails(this.value)" required>
                                <option value="">Select Item</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label small fw-bold text-dark">Unit <span
                                    class="text-danger">*</span></label>
                            <input type="text" step="any" name="unit"
                                class="form-control form-control-sm input-highlight" id="unit" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label small fw-bold text-dark">Price <span class="text-danger"><span
                                        id="original_price_show"></span>*</span></label>
                            <input type="number" step="any" name="price"
                                class="form-control form-control-sm text-end input-highlight" id="price" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label small fw-bold text-dark">Qty <span class="text-danger"><span
                                        id="available_qty_show"></span>*</span></label>
                            <input type="number" step="any" name="qty"
                                class="form-control form-control-sm text-end input-highlight" id="qty"
                                onkeyup="checkQtyValidation();" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label small fw-bold text-dark">Discount(%)</label>
                            <input type="number" step="any" name="discount"
                                class="form-control form-control-sm text-end input-highlight" id="discount" value="0">
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" id="formsubmit" title="Insert"
                            class="btn btn-success btn-sm w-100 add-to-list-btn" onclick="addToList();">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" id="formsubmit" title="Update"
                            class="btn btn-warning btn-sm w-100 d-none update-to-list-btn" onclick="updateToList();">
                            <i class="fas fa-sync"></i>
                        </button>
                    </div>
                </div>

                <input name="available_qty" type="number" id="available_qty" class="d-none">
                <input name="row_id" type="number" id="row_id" value="0" class="d-none">
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {

    let item = $('#item');

    item.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>Invoice/getDirectSalesItem',
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
});

function getDirectSalesItemDetails(item_id) {
    if (item_id === '') return false;

    $.ajax({
        type: "GET",
        dataType: 'json',
        url: '<?php echo base_url() ?>Invoice/getDirectSalesItemDetails/' + item_id,
        success: function(result) {
            if (result.status) {
                // $('#price').val(result.data[0].sale_price);
                $('#original_price_show').text(result.data[0].sale_price);
                $('#available_qty_show').text('(Availablity ' + result.data[0].qty + ')');
                $('#available_qty').val(result.data[0].qty);
            } else {
                falseResponse(result);
            }
        }
    });
}

function addToList() {
    const form = $('#createorderform')[0];

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const date = $('#date').val();
    const customerName = $('#customer_name').val();
    const customerAddress = $('#customer_address').val();
    const item = $('#item option:selected').text();
    const itemId = $('#item').val();
    const unit = $('#unit').val();
    const price = parseFloat($('#price').val()) || 0;
    const qty = parseFloat($('#qty').val()) || 0;
    const discountPercent = parseFloat($('#discount').val()) || 0;

    const subtotal = price * qty;
    const discountAmount = (discountPercent / 100) * subtotal;
    const total = subtotal - discountAmount;

    const tax = 0;
    const totalAfterTax = total + tax;

    const newRow = `
        <tr>
            <td>${item}</td>
            <td>${qty}</td>
            <td>${unit}</td>
            <td class="text-end">${price.toFixed(2)}</td>
            <td class="text-end d-none sub_total">${subtotal.toFixed(2)}</td>
            <td class="text-end">${discountPercent}</td>
            <td class="text-end d-none discount_amount">${discountAmount}</td>
            <td class="text-end d-none total_after_discount">${total.toFixed(2)}</td>
            <td class="text-end">${tax.toFixed(2)}</td>
            <td class="text-end total_after_tax">${totalAfterTax.toFixed(2)}</td>
            <td class="text-end d-none insert_status">new</td>
            <td class="text-end d-none item_id">${itemId}</td>
            <td class="text-end d-none row_id">0</td>
            <td class="text-center">
                <button type="button" title="Edit" class="btn btn-primary btn-sm d-none" id="0" onclick="editRow(this)"><i class="fas fa-pen"></i></button>
                <button type="button" title="Delete" class="btn btn-danger btn-sm" id="0" onclick="ItemSoftDelete(this)"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    `;

    $('#tableorder tbody').append(newRow);
    allItemsTotalCalculation();
    clearItemFields();
    $('.update-to-list-btn').addClass('d-none');
    $('.add-to-list-btn').removeClass('d-none');
}

function updateToList() {
    const form = $('#createorderform')[0];

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const date = $('#date').val();
    const customerName = $('#customer_name').val();
    const customerAddress = $('#customer_address').val();
    const item = $('#item option:selected').text();
    const itemId = $('#item').val();
    const unit = $('#unit').val();
    const price = parseFloat($('#price').val()) || 0;
    const qty = parseFloat($('#qty').val()) || 0;
    const discountPercent = parseFloat($('#discount').val()) || 0;

    const subtotal = price * qty;
    const discountAmount = (discountPercent / 100) * subtotal;
    const total = subtotal - discountAmount;

    const tax = 0;
    const totalAfterTax = total - tax;

    const rowId = $('#row_id').val();

    const newRow = `
        <tr class="recently-edited-row">
            <td>${item}</td>
            <td>${qty}</td>
            <td>${unit}</td>
            <td class="text-end">${price.toFixed(2)}</td>
            <td class="text-end d-none sub_total">${subtotal.toFixed(2)}</td>
            <td class="text-end">${discountPercent}</td>
            <td class="text-end d-none discount_amount">${discountAmount}</td>
            <td class="text-end d-none total_after_discount">${total.toFixed(2)}</td>
            <td class="text-end">${tax.toFixed(2)}</td>
            <td class="text-end total_after_tax">${totalAfterTax.toFixed(2)}</td>
            <td class="text-end d-none insert_status">updated</td>
            <td class="text-end d-none item_id">${itemId}</td>
            <td class="text-end d-none row_id">${rowId}</td>
            <td class="text-center">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" title="Edit" class="btn btn-primary btn-sm" id="${rowId}" onclick="editRow(this)"><i class="fas fa-pen"></i></button>
                    <button type="button" title="Delete" class="btn btn-danger btn-sm" id="${rowId}" onclick="deleteRow(this)"><i class="fas fa-trash"></i></button>
                </div>
            </td>
        </tr>
    `;

    $('#tableorder tbody').append(newRow);
    // let $editedRow = $('#tableorder > tbody:last tr:last');
    // highlightEditedRow($editedRow);
    deletedUpdatedRow(rowId);
    $('#row_id').val(0);
    $('.update-to-list-btn').addClass('d-none');
    $('.add-to-list-btn').removeClass('d-none');
    allItemsTotalCalculation();
    clearItemFields();
}

function checkQtyValidation() {
    const availableQty = parseFloat($('#available_qty').val()) || 0;
    const qty = parseFloat($('#qty').val()) || 0;

    if (qty > availableQty) {
        alert('Requested quantity exceeds available quantity.');
        $('#qty').val('');
        $('#qty').focus();
        return false;
    } else if (qty <= 0) {
        alert('Quantity must be greater than 0.');
        $('#qty').val('');
        $('#qty').focus();
        return false;
    }
    return true;
}

function editRow(button) {
    if (confirm("Are you sure you want to edit this row?")) {
        const row = $(button).closest('tr');

        const itemName = row.find('td:eq(0)').text();
        const qty = parseFloat(row.find('td:eq(1)').text());
        const unit = row.find('td:eq(2)').text();
        const price = parseFloat(row.find('td:eq(3)').text());
        const discountPercent = parseFloat(row.find('td:eq(5)').text());
        const itemId = row.find('.item_id').text();
        const rowId = row.find('.row_id').text();

        if (itemId && itemName) {
            let option = new Option(itemName, itemId, true, true);
            $('#item').append(option).trigger('change');
        }

        $('#unit').val(unit);
        $('#price').val(price);
        $('#qty').val(qty);
        $('#discount').val(discountPercent);

        $('#row_id').val(rowId);

        $('.update-to-list-btn').removeClass('d-none');
        $('.add-to-list-btn').addClass('d-none');
        // row.remove();
    }
}

function deletedUpdatedRow(rowId) {
    $('#tableorder tbody tr').each(function() {
        const insertStatus = $(this).find('.insert_status').text().trim();
        const rowIdFromTable = $(this).find('.row_id').text().trim();

        if ((insertStatus === 'existing' || insertStatus === 'updated') && rowIdFromTable == rowId) {
            $(this).remove();
            return false;
        }
    });
}

function deleteRow(button) {
    if (confirm("Are you sure you want to delete this row?")) {
        const row = $(button).closest('tr');
        row.find('.insert_status').text('deleted');
        row.addClass('d-none');
        allItemsTotalCalculation();
    }

}

function clearItemFields() {
    $('#item').val('').trigger('change');
    $('#price').val('');
    $('#original_price_show').text('');
    $('#qty').val('');
    $('#available_qty_show').text('');
    $('#unit').val('');
    $('#discount').val(0);
}
</script>