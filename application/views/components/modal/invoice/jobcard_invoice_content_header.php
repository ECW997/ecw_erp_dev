<div class="card invoice-card">
    <div class="card-body p-3">
        <form id="createorderform" autocomplete="off">
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label small fw-bold">Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm input-field" name="date" id="date"
                            value="<?= isset($invoice_main_data[0]['invoice_date']) ? $invoice_main_data[0]['invoice_date'] : date('Y-m-d') ?>"
                            required readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label small fw-bold">Job Card No <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm input-field" name="job_card_number"
                            id="job_card_number" required>
                            <option value="">Select</option>
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

            <div class="customer-details mb-4 p-3 border rounded">
                <h6 class="section-title p-2 mb-3 rounded">Customer & Vehicle Information</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label small fw-bold">Customer Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="customer_name" class="form-control form-control-sm input-field"
                                id="customer_name"
                                value="<?= isset($invoice_main_data[0]['customer_name']) ? $invoice_main_data[0]['customer_name'] : '' ?>"
                                required>
                            <input type="hidden" name="customer_id" id="customer_id"
                                value="<?= isset($invoice_main_data[0]['customer_id']) ? $invoice_main_data[0]['customer_id'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label small fw-bold">Address <span class="text-danger">*</span></label>
                            <input type="text" name="customer_address" class="form-control form-control-sm input-field"
                                id="customer_address"
                                value="<?= isset($invoice_main_data[0]['customer_address']) ? $invoice_main_data[0]['customer_address'] : '' ?>"
                                required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label small fw-bold">Vehicle No <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="vehicle_no" class="form-control form-control-sm input-field"
                                id="vehicle_no" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label small fw-bold">VAT Reg No</label>
                            <input type="text" name="vat_reg_no" class="form-control form-control-sm input-field"
                                id="vat_reg_no" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label small fw-bold">Vehicle In Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm input-field" name="vehicle_in_date"
                                id="vehicle_in_date" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="hidden" id="jobcardid" name="jobcardid" class="form-control form-control-sm" />
                        <input type="hidden" id="header_discount_total" name="header_discount_total"
                            class="form-control form-control-sm" value="0" />
                    </div>
                </div>
            </div>
            <input type="text" name="status_id" class="form-control form-control-sm input-highlight" id="status_id"
                value="<?= isset($invoice_main_data[0]['inv_status']) ? $invoice_main_data[0]['inv_status'] : '' ?>"
                required>

            <input type="hidden" name="refillprice" id="refillprice" value="">
            <input type="hidden" name="recordOption" id="recordOption" value="1">
        </form>
    </div>
</div>


<div class="modal fade" id="jobcarddetailsModal" tabindex="-1" aria-labelledby="jobHeaderModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="jobHeaderModalLabel"></h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <div class="col">
                        <h6 class="col-form-label me-2 text-nowrap">Customer Information</h6>
                        <input type="text" class="form-control mb-2 required-field" id="modal_customer_name"
                            name="modal_customer_name" placeholder="Customer Name" readonly>
                        <input type="text" class="form-control mb-2" id="modal_customer_number"
                            name="modal_customer_number" placeholder="Contact No" readonly>
                        <input type="text" class="form-control" id="modal_customer_taxtype"
                            name="modal_customer_taxtype" placeholder="Customer Tax Type" readonly>
                    </div>
                    <div class="col">
                        <h6 class="col-form-label me-2 text-nowrap">Address</h6>
                        <input type="text" class="form-control mb-2 required-field" id="modal_customer_address"
                            name="modal_customer_address" placeholder="Address 1" readonly>
                        <input type="text" class="form-control mb-2" id="modal_customer_address_2"
                            name="modal_customer_address_2" placeholder="Address 2" readonly>
                        <input type="text" class="form-control" id="modal_customer_taxnumber"
                            name="modal_customer_taxnumber" placeholder="Customer Tax Number" readonly>
                    </div>
                </div>


                <div class="mb-3 row">
                    <div class="col-6">
                        <h6 class="col-form-label me-2 text-nowrap">Vehicle Information</h6>
                        <input type="text" class="form-control mb-2 required-field" id="modal_Vehicle_number"
                            name="modal_Vehicle_number" placeholder="Vehicle Number" readonly>
                        <input type="text" class="form-control mb-2 required-field" id="modal_Vehicle_brand"
                            name="modal_Vehicle_brand" placeholder="Vehicle Brand Name" readonly>
                    </div>
                    <div class="col-6">
                        <h6 class="col-form-label me-2 text-nowrap">Vehicle in date</h6>
                        <input type="date" class="form-control mb-2 required-field" id="modal_Vehicle_indate"
                            name="modal_Vehicle_indate" placeholder="Vehicle in Date" readonly>
                        <input type="text" class="form-control mb-2 required-field" id="modal_Vehicle_model"
                            name="modal_Vehicle_model" placeholder="Vehicle Model Name" readonly>




                        <!-- <input type="text" name="jobcard_id" class="form-control form-control-sm input-highlight"
                            id="jobcard_id"> -->


                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-6">
                        <h6 class="col-form-label me-2 text-nowrap">Job Details</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="jobCardDetailsTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-left">Job Description</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-right">Unit Price</th>
                                        <th class="text-right">Total Price</th>
                                        <th class="text-right">Discount</th>
                                        <th class="text-right">Tax</th>
                                        <th class="text-right">Sub Total Price</th>
                                    </tr>
                                </thead>
                                <tbody id="jobCardDetailsBody">
                                    <?php if (isset($details_data) && !empty($details_data)) : ?>
                                    <?php foreach ($details_data as $index => $item) : ?>
                                    <tr>
                                        <td class="text-center"><?= $index + 1 ?></td>
                                        <td class="text-left"><?= $item['job_sub_category_text'] ?></td>
                                        <td class="text-center"><?= $item['qty'] ?></td>
                                        <td class="text-right"><?= addCommas($item['list_price']) ?></td>
                                        <td class="text-right"><?= addCommas($item['total']) ?></td>
                                        <td class="text-right"><?= addCommas($item['line_discount']) ?></td>
                                        <td class="text-right"><?= addCommas(0.00) ?></td>
                                        <td class="text-right"><?= addCommas($item['net_amount']) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No job details found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <h6 class="col-form-label me-2 text-nowrap">Summary Information</h6>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-3">
                        <label class="form-label fw-bold">Sub Total</label>
                        <input type="text" class="form-control mb-2 required-field" id="modal_sub_total"
                            name="modal_sub_total" placeholder="Sub Total" readonly>
                    </div>
                    <div class="col-3">
                        <label class="form-label fw-bold">Total Line Discount</label>
                        <input type="text" class="form-control mb-2 required-field" id="modal_line_discount"
                            name="modal_line_discount" placeholder="Total Line Discount" readonly>
                    </div>
                    <div class="col-3">
                        <label class="form-label fw-bold">Total Header Discount</label>
                        <input type="text" class="form-control mb-2 required-field" id="modal_header_discount"
                            name="modal_header_discount" placeholder="Total Header Discount" readonly>
                    </div>
                    <div class="col-3">
                        <label class="form-label fw-bold">Net Total</label>
                        <input type="text" class="form-control mb-2 required-field" id="modal_net_total"
                            name="modal_net_total" placeholder="Net Total" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <h6 class="col-form-label me-2 text-nowrap" id="discount_approval_status">Discount approve</h6>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-success" id="readyToInvoiceBtn">
                    <i class="fas fa-arrow-right me-2"></i>Ready to Invoice
                </button>

            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function() {
    function toggleJobCardNumber() {
        let statusId = $('#status_id').val();
        if (statusId && statusId !== '') {
            $('#job_card_number').prop('disabled', true);
        } else {
            $('#job_card_number').prop('disabled', false);
        }
    }
    toggleJobCardNumber();
    $('#status_id').on('change', function() {
        toggleJobCardNumber();
    });
});

$(document).ready(function() {

    let jobCardNumber = $('#job_card_number');

    jobCardNumber.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>Invoice/getJobcardNumbers',
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

    jobCardNumber.on('change', function() {
        let selectedId = $(this).val();

        if (selectedId) {
            $.ajax({
                url: '<?php echo base_url("Invoice/getJobCardDetails"); ?>',
                type: 'POST',
                data: {
                    job_card_id: selectedId
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status && res.data) {
                        let data = res.data.main_data[0];

                        $('#jobcarddetailsModal').modal('show');

                        $('#jobHeaderModalLabel').text(data.job_card_number +
                            ' - Job Card Details');

                        $('#customer_id').val(data.customer_id);
                        $('#modal_customer_name').val(data.customer_name);
                        $('#modal_customer_number').val(data.customer_mobile_num);
                        $('#modal_customer_address').val(data.address);
                        $('#modal_customer_address_2').val(data.address_2);
                        $('#modal_customer_taxtype').val(data.tax_type_name);
                        $('#modal_customer_taxnumber').val(data.tax_number);
                        $('#modal_Vehicle_number').val(data.vehicle_number);
                        $('#modal_Vehicle_indate').val(data.job_start_datetime.split(' ')[
                            0]);
                        $('#modal_Vehicle_brand').val(data.brand_name);
                        $('#modal_Vehicle_model').val(data.model_name);

                        $('#jobcard_id').val(data.idtbl_jobcard);


                        let index = 1;
                        $('#jobCardDetailsBody').empty();

                        res.data.details_data.forEach(section => {
                            section.details.forEach(detail => {
                                let row = `
                                    <tr>
                                        <td class="text-center">${index++}</td>
                                        <td class="text-left">${section.job_sub_category_text} - ${detail.option_group_text} (${detail.combined_option})</td>
                                        <td class="text-center">${detail.qty}</td>
                                        <td class="text-right">${(parseFloat(detail.list_price).toFixed(2))}</td>
                                        <td class="text-right">${(parseFloat(detail.total).toFixed(2))}</td>
                                        <td class="text-right">${(parseFloat(detail.line_discount).toFixed(2))}</td>
                                        <td class="text-right">${(parseFloat(0).toFixed(2))}</td>
                                        <td class="text-right">${(parseFloat(detail.net_amount).toFixed(2))}</td>
                                        <td class="text-right d-none line_discount_type">${(parseFloat(detail.line_discount_type).toFixed(2))}</td>
                                        <td class="text-right d-none line_discount_pc">${(parseFloat(detail.line_discount_pc).toFixed(2))}</td>
                                        <td class="text-right d-none line_discount">${(parseFloat(detail.line_discount).toFixed(2))}</td>

                                    </tr>
                                `;
                                $('#jobCardDetailsBody').append(row);
                            });
                        });



                        let summary = res.data.summary_data[0];
                        let approveRequestStatus = data.approve_request_status;

                        $('#modal_sub_total').val(addCommas(parseFloat(summary.sub_total)
                            .toFixed(2)));
                        $('#modal_line_discount').val(addCommas(parseFloat(summary
                            .total_line_discount).toFixed(2)));
                        $('#modal_header_discount').val(addCommas(parseFloat(summary
                            .discount_amount).toFixed(2)));
                        $('#modal_net_total').val(addCommas(parseFloat(summary.net_total)
                            .toFixed(2)));

                        if (summary.is_discount_approved) {
                            $('#discount_approval_status')
                                .text('Discount Approved')
                                .css({
                                    color: 'green',
                                    fontWeight: 'bold'
                                });
                        } else {
                            $('#discount_approval_status')
                                .text('Discount Approval Pending')
                                .css({
                                    color: 'orange',
                                    fontWeight: 'bold'
                                });
                        }



                        let $invoiceBtn = $('#readyToInvoiceBtn');
                        if (summary.is_discount_approved === true || approveRequestStatus !=
                            1) {
                            $invoiceBtn.prop('disabled', false).removeClass('disabled');
                        } else {
                            $invoiceBtn.prop('disabled', true).addClass('disabled');
                        }




                    } else {
                        alert("Job card details not found.");
                    }
                },
                error: function(xhr) {
                    alert("Error fetching job card details.");
                }
            });
        }
    });


    $('#readyToInvoiceBtn').click(function() {
        $('#customer_name').val($('#modal_customer_name').val());
        $('#customer_address').val($('#modal_customer_address').val());
        $('#vat_reg_no').val($('#modal_customer_taxnumber').val());
        $('#vehicle_no').val($('#modal_Vehicle_number').val());
        $('#vehicle_in_date').val($('#modal_Vehicle_indate').val());
        $('#jobcardid').val($('#job_card_number').val());
        $('#header_discount_total').val($('#modal_header_discount').val());

        $('#jobcarddetailsModal').modal('hide');

        let $tableBodyMain = $('#tableorderBody');
        $tableBodyMain.empty();

        $('#jobCardDetailsBody tr').each(function() {
            const tds = $(this).find('td');

            const item = tds.eq(1).text().trim();
            const itemId = 0;
            const qty = parseFloat(tds.eq(2).text()) || 0;
            const unit = "EA";
            const price = parseFloat(tds.eq(3).text()) || 0;

            const line_discount_type = tds.eq(8).text().trim();
            const line_discount_pc = parseFloat(tds.eq(9).text()) || 0;
            const discountAmount = parseFloat(tds.eq(10).text()) || 0;

            const subtotal = price * qty;
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
                    <td class="text-end">${line_discount_pc.toFixed(2)}</td>
                    <td class="text-end d-none discount_amount">${discountAmount.toFixed(2)}</td>
                    <td class="text-end d-none total_after_discount">${total.toFixed(2)}</td>
                    <td class="text-end">${tax.toFixed(2)}</td>
                    <td class="text-end total_after_tax">${totalAfterTax.toFixed(2)}</td>
                    <td class="text-end d-none insert_status">new</td>
                    <td class="text-end d-none item_id">${itemId}</td>
                    <td class="text-end d-none row_id">0</td>
                </tr>
            `;

            $tableBodyMain.append(newRow);
            allItemsTotalCalculation();
        });
    });

});



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