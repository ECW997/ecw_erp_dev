<div class="modal fade" id="jobcarddiscountModel" tabindex="-1" aria-labelledby="jobcarddiscountModelLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="jobcarddiscountModelLabel">Job Card Header Discount</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">

                    <div class="row mb-3 align-items-center">
                        <div class="col-6">
                            <label class="fw-bold">Standard Price:</label>
                        </div>
                        <div class="col-6 text-end">
                            <span class="text-primary fw-bold" id="standard_price_display">Rs. 250,000.00</span>
                            <input type="hidden" id="standard_price" value="250000">
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

                </div>
            </div>
            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-2"> </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-light w-100"
                            style="border-radius: 12px; font-weight:bold;">Close</button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-success w-100"
                            style="border-radius: 12px; ">Approve</button>
                    </div>
                    <div class="col-2"> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
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
            discountPercentInput.value = ((discount / standardPrice) * 100).toFixed(2);
        } else if (discountPercent > 0) {
            discount = (standardPrice * discountPercent) / 100;
            discountPriceInput.value = discount.toFixed(2);
        }

        const net = standardPrice - discount;
        totalDiscountInput.value = `Rs. ${discount.toFixed(2)}`;
        netPriceInput.value = `Rs. ${net.toFixed(2)}`;
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

function submitDiscount() {
    alert("Discount submitted successfully!");
}
</script>