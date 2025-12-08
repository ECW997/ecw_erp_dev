<div class="card invoice-card">
    <div class="card-body p-3">
        <form id="createorderform" autocomplete="off">
            <!-- Header Section -->
            <div class="row invoice-header mb-4">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label small fw-bold text-dark">Date <span
                                class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm input-highlight" name="date" id="date"
                            value="<?= isset($invoice_main_data[0]['invoice_date']) ? $invoice_main_data[0]['invoice_date'] : date('Y-m-d') ?>"
                            required readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label small fw-bold text-dark">Sales Person <span
                        		class="text-danger">*</span></label>
                        <select id="sales_person_id" class="custom-select custom-select-sm" style="min-width: 130px;">
                        	<option value="">All</option>
                        	<?php if (!empty($sales_agents)) : ?>
                                  <?php 
                                    $selectedSalesman = isset($invoice_main_data[0]['salesman_id']) 
                                        ? $invoice_main_data[0]['salesman_id'] 
                                        : 0; 
                                    ?>
                        	<?php foreach ($sales_agents as $agent) : ?>
                        	<option value="<?= $agent['idtbl_sales_person']; ?>"
                                <?= $selectedSalesman == $agent['idtbl_sales_person'] ? 'selected' : ''; ?>>
                        		<?= htmlspecialchars($agent['sales_person_name']); ?>
                        	</option>
                        	<?php endforeach; ?>
                        	<?php endif; ?>
                        </select>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label small fw-bold text-dark">Customer Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="customer_name" class="form-control form-control-sm input-highlight"
                                id="customer_name"
                                value="<?= isset($invoice_main_data[0]['customer_name']) ? $invoice_main_data[0]['customer_name'] : '' ?>"
                                required <?= $is_confirmed == 0 ? '' : 'readonly' ?>>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label small fw-bold text-dark">Customer Address <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="customer_address"
                                class="form-control form-control-sm input-highlight" id="customer_address"
                                value="<?= isset($invoice_main_data[0]['customer_address']) ? $invoice_main_data[0]['customer_address'] : '' ?>"
                                required <?= $is_confirmed == 0 ? '' : 'readonly' ?>>
                            <input type="hidden" name="customer_id" id="customer_id"
                                value="<?= isset($invoice_main_data[0]['customer_id']) ? $invoice_main_data[0]['customer_id'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label small fw-bold text-dark">Contact No <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="customer_contact"
                                class="form-control form-control-sm input-highlight" id="customer_contact"
                                value="<?= isset($invoice_main_data[0]['contact_no']) ? $invoice_main_data[0]['contact_no'] : '' ?>"
                                required <?= $is_confirmed == 0 ? '' : 'readonly' ?>>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label small fw-bold text-dark">Nic No <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="customer_nic"
                                class="form-control form-control-sm input-highlight" id="customer_nic"
                                value="<?= isset($invoice_main_data[0]['nic_number']) ? $invoice_main_data[0]['nic_number'] : '' ?>"
                                required <?= $is_confirmed == 0 ? '' : 'readonly' ?>>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item Details Section -->
            <div class="invoice-items mb-4 p-3 border rounded <?= $is_confirmed == 0 ? '' : 'd-none' ?>">
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
                            <button type="button" class="btn btn-sm btn-warning mt-2 <?= ($addcheck == 0) ? 'd-none' : '' ?>" data-bs-toggle="modal" data-bs-target="#addNewItemModal">Add New Item</button>
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
                    <div class="col-md-1 d-flex align-items-center">
                        <button type="button" id="formsubmit" title="Insert"
                            class="btn btn-success btn-sm w-100 add-to-list-btn me-2 <?= ($addcheck == 0) ? 'd-none' : '' ?>" onclick="addToList();">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" id="formsubmit" title="Update"
                            class="btn btn-warning btn-sm w-100 d-none update-to-list-btn <?= ($editcheck == 0) ? 'd-none' : '' ?>" onclick="updateToList();">
                            <i class="fas fa-sync"></i>
                        </button>
                        <button type="button" id="formsubmit" title="Clear"
                            class="btn btn-secondary btn-sm w-100 clear-list-btn" onclick="clearList();">
                            <i class="fas fa-eraser"></i>
                        </button>
                    </div>
                </div>

                <input name="available_qty" type="number" id="available_qty" class="d-none">
                <input name="row_id" type="number" id="row_id" value="0" class="d-none">
                <input name="pre_item" type="number" id="pre_item" class="d-none" value="0">
                <input name="pre_qty" type="number" id="pre_qty" class="d-none" value="0">
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="addNewItemModal" tabindex="-1" aria-labelledby="addNewItemModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="addNewItemModalLabel">
                    Add New Item
                </h5>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="addNewItemForm">
                    <div class="row">
                        <div class="col-3">
                            <label class="form-label small fw-bold text-dark">Item Name <span class="text-danger">*</span></label>
                            <input type="text" name="item_name" class="form-control form-control-sm" id="item_name" required>
                        </div>
                        <div class="col-3">
                            <label class="form-label small fw-bold text-dark">UOM <span class="text-danger">*</span></label>
                            <input type="text" name="uom" class="form-control form-control-sm" id="uom" required>
                        </div>
                        <div class="col-3">
                            <label class="form-label small fw-bold text-dark">Unit Price <span class="text-danger">*</span></label>
                            <input type="text" name="unit_price" class="form-control form-control-sm" id="unit_price" required>
                        </div>
                        <div class="col-3">
                            <label class="form-label small fw-bold text-dark">Sales Price <span class="text-danger">*</span></label>
                            <input type="text" name="sales_price" class="form-control form-control-sm" id="sales_price" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                         <div class="col-3">
                            <label class="form-label small fw-bold text-dark">Minimum Qty <span class="text-danger">*</span></label>
                            <input type="text" name="minimum_qty" class="form-control form-control-sm" id="minimum_qty" required>
                        </div>
                        <div class="col-3">
                            <label class="form-label small fw-bold text-dark">Qty <span class="text-danger">*</span></label>
                            <input type="text" name="order_qty" class="form-control form-control-sm" id="order_qty" required>
                        </div>
                        <div class="col-3">
                            <label class="form-label small fw-bold text-dark">Usable Type <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm input-highlight" name="usable_type" id="usable_type" required>
                                <option value="">Select Type</option>
                                <option value="All">All</option>
                                <option value="Production">Production</option>
                                <option value="DirectSale">DirectSale</option>
                            </select>
                        </div>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" id="addNewItemdBtn" class="btn btn-primary" onclick="addNewItem();">Add New Item<i
						class="fas fa-plus-circle ml-2"></i></i></button>
			</div>
		</div>
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

    $('#customer_contact, #customer_nic').on('keyup change', function () {
        let value = $(this).val().trim();

        if (value.length >= 8) { 
            $.ajax({
                url: '<?php echo base_url() ?>Invoice/searchCustomer/' + value,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.status) {
                        $('#customer_name').val(res.data.customer_name);
                        $('#customer_address').val(res.data.address);
                        $('#customer_contact').val(res.data.customer_mobile_num);
                        $('#customer_nic').val(res.data.nic_number);
                        $('#customer_id').val(res.data.idtbl_customer);
                    }
                }
            });
        }
    });

    // $('#series_type').val('1').trigger('change');
});

function getDirectSalesItemDetails(item_id) {
    if (item_id === '') return false;

    $.ajax({
        type: "GET",
        dataType: 'json',
        url: '<?php echo base_url() ?>Invoice/getDirectSalesItemDetails/' + item_id,
        success: function(result) {
            if (result.status) {
                $('#unit').val(result.data[0].uom);
                $('#original_price_show').text(result.data[0].sale_price);
                $('#available_qty_show').text('(Availablity ' + (result.data[0].qty - result.data[0].issued_qty) + ')');
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

    const itemId = $('#item').val();

    let itemExists = false;

    $('#tableorder tbody tr').each(function () {
        const existingItemId = $(this).find('.item_id').text().trim();
        if (existingItemId === itemId) {
            itemExists = true;
            return false; 
        }
    });

    if (itemExists) {
        alert('This item with the same unit already exists in the list.');
        clearItemFields();
        return;
    }

    const date = $('#date').val();
    const customerName = $('#customer_name').val();
    const customerAddress = $('#customer_address').val();
    const customerContact = $('#customer_contact').val();
    const customerNic = $('#customer_nic').val();
    const item = $('#item option:selected').text();
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
            <td class="text-end d-none pre_item">0</td>
            <td class="text-end d-none pre_qty">0</td>
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

    const itemId = $('#item').val();
    const rowId = $('#row_id').val();

    let itemExists = false;

    $('#tableorder tbody tr').each(function () {
        const existingItemId = $(this).find('.item_id').text().trim();
        if (existingItemId === itemId && rowId == '0') {
            itemExists = true;
            return false; 
        }
    });

    if (itemExists) {
        alert('This item with the same unit already exists in the list.');
        clearItemFields();
        return;
    }

    const date = $('#date').val();
    const customerName = $('#customer_name').val();
    const customerAddress = $('#customer_address').val();
    const customerContact = $('#customer_contact').val();
    const customerNic = $('#customer_nic').val();
    const item = $('#item option:selected').text();
    const unit = $('#unit').val();
    const price = parseFloat($('#price').val()) || 0;
    const qty = parseFloat($('#qty').val()) || 0;
    const discountPercent = parseFloat($('#discount').val()) || 0;
    const pre_itemId = $('#pre_item').val();
    const pre_qty = parseFloat($('#pre_qty').val()) || 0;

    const subtotal = price * qty;
    const discountAmount = (discountPercent / 100) * subtotal;
    const total = subtotal - discountAmount;

    const tax = 0;
    const totalAfterTax = total - tax;

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
            <td class="text-end d-none pre_item">${pre_itemId}</td>
            <td class="text-end d-none pre_qty">${pre_qty}</td>
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
        const pre_itemId = row.find('.pre_item').text();
        const pre_qty = row.find('.pre_qty').text();

        if (itemId && itemName) {
            let option = new Option(itemName, itemId, true, true);
            $('#item').append(option).trigger('change');
        }

        $('#unit').val(unit);
        $('#price').val(price);
        $('#qty').val(qty);
        $('#discount').val(discountPercent);

        $('#row_id').val(rowId);
        $('#pre_item').val(pre_itemId);
        $('#pre_qty').val(pre_qty);

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

function addNewItem(){
    var form = $('#addNewItemForm')[0];
     if (form.checkValidity()) {

        const btn = document.getElementById('addNewItemdBtn');
        btn.disabled = true;
        btn.innerHTML = `Adding <span class="spinner-border spinner-border-sm ml-2" role="status" aria-hidden="true"></span>`;

        var item_name = $('#item_name').val();
        var usable_type = $('#usable_type').val();
        var uom = $('#uom').val();
        var unit_price = $('#unit_price').val();
        var sales_price = $('#sales_price').val();
        var minimum_qty = $('#minimum_qty').val();
        var qty = $('#order_qty').val();

        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                item_name: item_name,
                usable_type: usable_type,
                uom: uom,
                unit_price: unit_price,
                sales_price: sales_price,
                minimum_qty: minimum_qty,
                qty: qty,
                company_id: "<?php echo ucfirst($_SESSION['company_id']); ?>",
                branch_id: "<?php echo ucfirst($_SESSION['branch_id']); ?>"
            },
            url: '<?php echo base_url() ?>Invoice/insertNewItem',
            success: function(result) {
                if (result.status == true) {
                    success_toastify(result.message);
                    btn.disabled = false;
                    btn.innerHTML = `Add New Item <i class="fas fa-plus-circle ml-2"></i>`;
                    $('#item').append(
                        new Option(item_name, result.data, true, true)
                    ).trigger('change');
                    $('#addNewItemForm')[0].reset();
                    $('#addNewItemModal').modal('hide');
                    $('.modal-backdrop').remove();
                } else {
                    falseResponse(result);
                    btn.disabled = false;
                    btn.innerHTML = `Add New Item <i class="fas fa-plus-circle ml-2"></i>`;
                }
            }
        });

    } else {
        form.reportValidity();
    }
}

function clearList(){
    $('#item').val('').trigger('change');
    $('#unit').val('');
    $('#price').val('');
    $('#original_price_show').text('');
    $('#qty').val('');
    $('#available_qty_show').text('');
    $('#discount').val('');
}
</script>