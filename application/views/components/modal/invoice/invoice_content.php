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
                                <th class="text-center">Discount</th>
                                <th class="text-center">Tax</th>
                                <th class="text-right">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody id="tableorderBody">
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
                            <button type="button" id="secondformsubmit" class="btn btn-secondary btn-sm"><i
                                    class="fas fa-plus"></i>&nbsp;Add</button>
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
                        <tbody></tbody>
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




    <div class="card-body p-0 p-2">
        <div class="container-fluid mt-2 p-0 p-2">
            <div class="row">
                <div class="col-2">
                    <label class="small font-weight-bold text-dark">Payment Type </label>
                    <select class="form-control form-control-sm" name="payment_type" id="payment_type" required>
                        <option value="">Select Payment Type</option>
                        <option value="1">Cash</option>
                        <option value="2">Cheque</option>
                        <option value="3">Bank Transfer</option>
                        
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
                <div class="col-2">
                    <label class="small font-weight-bold text-dark">Discount Amount*</label>
                    <input type="number" id="discountamount" name="discountamount" class="form-control form-control-sm" value="0"
                        required readonly>
                </div>
                <div class="col-2">
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

            <div class="row">
                <div class="col-12">
                    <div class="form-group mt-2">
                        <button type="button" id="btncreateorder"
                            class="btn btn-outline-primary btn-sm fa-pull-right"><i class="fas fa-save"></i>&nbsp;Create
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
    if (!$("#expensesform")[0].checkValidity()) {

        $("#chargesubmitBtn").click();
    } else {
        var chargetype = $('#chargetype').val();
        var chargeamount = $('#chargeamount').val();
        // var chargetype = $("#chargetype option:selected").text();



        $('#chargetableorder > tbody:last').append('<tr class="pointer"><td name="chargetype">' +
            chargetype + '</td><td name="chargeamount" class="text-right chargesamount">' +
            chargeamount +
            '</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
        );


        $('#chargetype').val('');
        $('#chargeamount').val('0');

        /////////////////////////////////////////////////Final Total/////////////////////////////////////////////////
        var sum = 0;
        $(".chargesamount").each(function() {
            sum += parseFloat($(this).text());
        });

        var showsum = addCommas(parseFloat(sum).toFixed(2));

        $('#divchargestotal').html('<strong style="background-color: yellow;"> Rs. <strong>' +
            showsum);

        // html('<strong style="background-color: yellow;">Final Price</strong> &nbsp; &nbsp;<strong>Rs.<strong> <strong>' +
        // 		showgrosstot);
        $('#hidechargestotal').val(sum);
        $('#job').focus();

    }

    finaltotalcalculate();

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