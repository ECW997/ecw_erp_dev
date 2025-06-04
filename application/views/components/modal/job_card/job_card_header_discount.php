<div class="modal fade" id="jobcarddiscountModel" tabindex="-1" aria-labelledby="jobcarddiscountModelLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="jobcarddiscountModelLabel">Job Card Header Discount</h5>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-3 align-items-center">
                        <div class="col-6">
                            <label class="fw-bold">Standard Price:</label>
                        </div>
                        <div class="col-6 text-end">
                            <span class="text-primary fw-bold" id="standard_price_display">
                                Rs. <?= number_format($summary_data[0]['sub_total'] ?? 0, 2) ?>
                            </span>
                            <input type="hidden" id="standard_price" value="<?= $summary_data[0]['sub_total'] ?? 0 ?>">
                            <input type="hidden" id="jobcard_id"
                                value="<?= $job_main_data[0]['idtbl_jobcard'] ?? $jobcard_id ?? '' ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold text-dark">Discount as Price (Rs)</label>
                            <input type="number" class="form-control form-control-sm" id="discount_price"
                                placeholder="Enter amount">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold text-dark">Discount as Percentage (%)</label>
                            <input type="number" class="form-control form-control-sm" id="discount_precentage"
                                placeholder="Enter %">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Total Discount</label>
                            <input type="text" class="form-control form-control-sm" id="total_discount" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Net Price</label>
                            <input type="text" class="form-control form-control-sm" id="net_price" readonly>
                        </div>

                    </div>
                    <form action="" id="jobCardForm"></form>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-2"> </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-light w-100 addJobItemCloseBtn" aria-label="Close"
                            style="border-radius: 12px; font-weight:bold;">Close</button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-success w-100" style="border-radius: 12px;"
                            onclick="confirmCreateDiscount()">Add
                            Discount</button>
                    </div>
                    <div class="col-2"> </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="CloseConfirmModal" tabindex="-1" aria-labelledby="CloseConfirmModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-confirmation">
            <div class="modal-header delete-header">
                <h5 class="delete-title" id="CloseConfirmModalLabel">Unsaved Changes</h5>
                <button type="button" class="btn-close delete-btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-question-circle delete-warning-icon"></i>
                <p class="mb-0">Are you sure you want to close this modal?<br>Any unsaved data will be lost.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary delete-btn-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary delete-btn-confirm" onclick="confirmCloseBtn()">
                    <i class="fas fa-arrow-right me-2"></i>Yes, Close Without Saving
                </button>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const standardPrice = parseFloat(document.getElementById('standard_price').value);

    const discountPriceInput = document.getElementById('discount_price');
    const discountPercentInput = document.getElementById('discount_precentage');
    const totalDiscountInput = document.getElementById('total_discount');
    const netPriceInput = document.getElementById('net_price');

    function updatePrices() {
        let discount = 0;

        const discountPrice = parseFloat(discountPriceInput.value) || 0;
        const discountPercent = parseFloat(discountPercentInput.value) || 0;

        if (discountPrice > 0) {
            discount = discountPrice;
            const calculatedPercent = ((discount / standardPrice) * 100);
            discountPercentInput.value = calculatedPercent.toFixed(2);

            if (calculatedPercent > 5) {
            alert("Approval request needed: Discount exceeds 5%");
        }

        } else if (discountPercent > 0) {
            discount = (standardPrice * discountPercent) / 100;
            discountPriceInput.value = discount.toFixed(2);

            if (discountPercent > 5) {
                alert("Approval request needed: Discount exceeds 5%");
            }
        }

        const net = standardPrice - discount;
        totalDiscountInput.value = `${discount.toFixed(2)}`;
        netPriceInput.value = `${net.toFixed(2)}`;
    }

    discountPriceInput.addEventListener('input', () => {
        discountPercentInput.value = '';
        updatePrices();
    });

    discountPercentInput.addEventListener('input', () => {
        discountPriceInput.value = '';
        updatePrices();
    });


});

$(document).on('click', '.addJobItemCloseBtn', function(e) {
    var net_price = $('#net_price').val().trim();

    if (net_price !== '') {
        e.preventDefault();
        $('#CloseConfirmModal').modal('show');
    } else {
        $('#jobcarddiscountModel').modal('hide');
        $('.modal-backdrop').remove();
        reSetContent('#jobCardForm');
    }
});

function submitDiscount() {
    alert("Discount submitted successfully!");
}


function confirmCloseBtn() {
    $('#CloseConfirmModal').modal('hide');

    setTimeout(() => {
        $('#jobcarddiscountModel').modal('hide');
        $('.modal-backdrop').remove();
        reSetContent('#jobCardForm');
        location.reload();
    }, 500);
}


function confirmCreateDiscount() {

    const discountData = {
        id: $('#jobcard_id').val(),
        discount: $('#discount_precentage').val(),
        discount_amount: $('#discount_price').val(),
        // net_total: $('#net_price').val()
    };

    console.log("Collected Discount Data:", discountData);

    $.ajax({
        url: '<?php echo base_url() ?>JobCard/updatediscount',
        type: 'POST',
        dataType: 'json',
        data: discountData,
        success: function(result) {
            if (result.status == true) {
                success_toastify(result.message);
                setTimeout(function() {
                    window.location.href = '<?= base_url("JobCard/jobCardDetailIndex/") ?>' +
                        discountData.id;
                }, 1000);
            } else {
                falseResponse(result);
            }
        }
    });

}
</script>