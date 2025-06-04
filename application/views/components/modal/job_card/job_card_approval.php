<div class="modal fade" id="jobcardApproveModel" tabindex="-1" aria-labelledby="jobcardApproveModelLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-black" id="jobcardApproveModelLabel">Job Card Approval</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h5>Standard Price: </h5>
                        </div>
                        <div class="col-6 text-end">
                            <span class="text-primary fw-bold" id="standard_price_display">
                                Rs. <?= number_format($summary_data[0]['sub_total'] ?? 0, 2) ?>
                            </span>
                            <input type="text" id="standard_price" value="<?= $summary_data[0]['sub_total'] ?? 0 ?>">
                            <input type="text" id="jobcard_id"
                                value="<?= $job_main_data[0]['idtbl_jobcard'] ?? $jobcard_id ?? '' ?>">


                        </div>
                    </div>

                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td><label class="small fw-bold">Line Change</label></td>

                                <td class="text-danger">
                                    <span id="line_discount_precentage_show">
                                    </span>
                                    <input type="text" class="form-control form-control-sm"
                                        id="line_discount_precentage" placeholder="Enter amount">
                                </td>

                                <td class="text-danger text-end">
                                    <span id="line_discount_show">
                                        Rs. <?= number_format($summary_data[0]['total_line_discount'] ?? 0, 2) ?>
                                    </span>
                                    <input type="text" class="form-control form-control-sm" id="line_discount"
                                        value="<?= $summary_data[0]['total_line_discount'] ?? $jobcard_id ?? '' ?>">
                                </td>
                            </tr>


                            <tr>
                                <td><label class="small fw-bold ">Header Discount</label></td>

                                <td class="text-danger"><span id="header_discount_precentage_show">
                                        <?= number_format($job_main_data[0]['discount'] ?? 0, 2) ?>%
                                        <input type="text" class="form-control form-control-sm"
                                            id="header_discount_precentage"
                                            value="<?= $job_main_data[0]['discount'] ?? 0 ?>"></td>

                                <td class="text-danger text-end"><span id="header_discount_show">
                                        Rs. <?= number_format($job_main_data[0]['discount_amount'] ?? 0, 2) ?>
                                        <input type="text" class="form-control form-control-sm" id="header_discount"
                                            value="<?= $job_main_data[0]['discount_amount'] ?? 0 ?>"></td>
                            </tr>



                            <tr>
                                <td><label class="small fw-bold ">Net Discount </label></td>

                                <td class="text-danger">
                                    <span id="net_discount_precentage_show">

                                    </span>
                                    <input type="text" class="form-control form-control-sm" id="net_discount_precentage"
                                        placeholder="Enter amount">
                                </td>

                                <td class="text-danger text-end">
                                    <span id="net_discount_show">

                                    </span>
                                    <input type="text" class="form-control form-control-sm" id="net_discount"
                                        placeholder="Enter amount">
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="row mt-4">
                        <div class="col-6">
                            <h5>Net Price: </h5>
                        </div>
                        <div class="col-6 text-end">
                            <span class="text-dark fw-bold" id="standard_price_display">
                                Rs. <?= number_format($summary_data[0]['net_total'] ?? 0, 2) ?>
                            </span>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-4">
                        <button type="button" class="btn btn-light w-100"
                            style="border-radius: 12px; font-weight:bold;">Close</button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-success w-100"
                            style="border-radius: 12px; ">Approve</button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-danger w-100" style="border-radius: 12px;">Denied</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('jobcardApproveModel');
    modal.addEventListener('shown.bs.modal', function() {
        calculateLineDiscountPercentage();
        calculateNetDiscount();
    });

});
</script>

<script>
function calculateLineDiscountPercentage() {
    let price = parseFloat(document.getElementById('standard_price').value) || 0;
    let lineDiscountValue = parseFloat(document.getElementById('line_discount').value) || 0;

    if (price === 0) {
        document.getElementById('line_discount_precentage').value = 0;
        document.getElementById('line_discount_precentage_show').textContent = '0%';
        return;
    }

    let percentage = (lineDiscountValue / price) * 100;
    document.getElementById('line_discount_precentage_show').textContent = percentage.toFixed(2) + '%';
    document.getElementById('line_discount_precentage').value = percentage.toFixed(2);

}

function calculateNetDiscount() {
    let price = parseFloat(document.getElementById('standard_price')?.value) || 0;
    let lineDiscount = parseFloat(document.getElementById('line_discount')?.value) || 0;
    let headerDiscount = parseFloat(document.getElementById('header_discount')?.value) || 0;

    console.log(price);
    // console.log(lineDiscount);
    // console.log(headerDiscount);

    let netDiscount = lineDiscount + headerDiscount;
    let netDiscountPercentage = price === 0 ? 0 : (netDiscount / price) * 100;

    document.getElementById('net_discount').value = netDiscount.toFixed(2);
    document.getElementById('net_discount_precentage').value = netDiscountPercentage.toFixed(2);

    const spanPercentage = document.getElementById('net_discount_precentage_show');
    if (spanPercentage) {
        spanPercentage.textContent = netDiscountPercentage.toFixed(2) + '%';
    }

    const spanAmount = document.getElementById('net_discount_show');
    if (spanAmount) {
        spanAmount.textContent = 'Rs. ' + netDiscount.toFixed(2);
    }
}
</script>