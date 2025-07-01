<style>
#jobcarddetailsModal input::placeholder,
#jobcarddetailsModal select::placeholder,
#jobcarddetailsModal textarea::placeholder {
    color: orange !important;
}

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

#modal_net_total {
    background-color: #fff3cd;
    border: 2px solid #ffc107;
    font-weight: bold;
    color: #000;
}
</style>


<div class="card">
    <div class="card-body p-0 p-2">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form id="createorderform" autocomplete="off">
                    <div class="row">
                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" placeholder="" name="date" id="date"
                                value="<?php echo date('Y-m-d') ?>" required readonly>

                        </div>
                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">Job Card Number <span
                                    class="text-danger">*</span></label>
                            <select class="form-control form-control-sm  px-0" name="job_card_number"
                                id="job_card_number" required>
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">Customer <span
                                    class="text-danger">*</span></label>
                            <input type="text" step="any" name="customer_name" class="form-control form-control-sm"
                                id="customer_name" required>
                        </div>
                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">Address <span
                                    class="text-danger">*</span></label>
                            <input type="text" step="any" name="customer_address" class="form-control form-control-sm"
                                id="customer_address" required>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">Vehicle No <span
                                    class="text-danger">*</span></label>
                            <input type="text" step="any" name="vehicle_no" class="form-control form-control-sm"
                                id="vehicle_no" required>
                        </div>
                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">VAT Reg No </label>
                            <input type="text" step="any" name="vat_reg_no" class="form-control form-control-sm"
                                id="vat_reg_no" required>
                        </div>
                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">Vehicle In Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" placeholder=""
                                name="vehicle_in_date" id="vehicle_in_date" required>
                        </div>
                        <div class="col-3">
                            <input type="text" id="jobcardid" name="jobcardid" class="form-control form-control-sm" />
                        </div>
                    </div>



                    <!-- <div class="form-group mt-2 text-right">
                        <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4"><i
                                class="fas fa-plus"></i>&nbsp;Add
                            to
                            list</button>
                        <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                    </div> -->
                    <input type="hidden" name="refillprice" id="refillprice" value="">
                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                </form>

            </div>
        </div>
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


                        let index = 1;
                        $('#jobCardDetailsBody').empty();

                        res.data.details_data.forEach(section => {
                            section.details.forEach(detail => {
                                let row = `
                                    <tr>
                                        <td class="text-center">${index++}</td>
                                        <td class="text-left">${section.job_sub_category_text} - ${detail.option_group_text} (${detail.combined_option})</td>
                                        <td class="text-center">${detail.qty}</td>
                                        <td class="text-right">${addCommas(parseFloat(detail.list_price).toFixed(2))}</td>
                                        <td class="text-right">${addCommas(parseFloat(detail.total).toFixed(2))}</td>
                                        <td class="text-right">${addCommas(parseFloat(detail.line_discount).toFixed(2))}</td>
                                        <td class="text-right">${addCommas(parseFloat(0).toFixed(2))}</td>
                                        <td class="text-right">${addCommas(parseFloat(detail.net_amount).toFixed(2))}</td>
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

         $('#jobcarddetailsModal').modal('hide');

        let $tableBodyMain = $('#tableorderBody'); 
        $tableBodyMain.empty();

        $('#jobCardDetailsBody tr').each(function() {
            const tds = $(this).find('td');
            let newRow = `
            <tr>
                <td class="text-left">${tds.eq(1).text()}</td>
                <td class="text-center">${tds.eq(2).text()}</td>
                <td class="text-center">EA</td>
                <td class="text-right">${tds.eq(3).text()}</td>
                <td class="text-right">${tds.eq(5).text()}</td>
                <td class="text-right">${tds.eq(6).text()}</td>
                <td class="text-right">${tds.eq(7).text()}</td>
            </tr>
        `;
            $tableBodyMain.append(newRow);
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