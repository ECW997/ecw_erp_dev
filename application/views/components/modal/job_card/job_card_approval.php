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
                            <h5 >Standard Price: </h5>
                        </div>
                        <div class="col-6 text-end">
                            <span class="text-primary fw-bold" id="standard_price_display">
                                Rs. <?= number_format($job_main_data[0]['net_total'] ?? 0, 2) ?>

                                <input type="text" id="jobcard_id"
                                value="<?= $job_main_data[0]['idtbl_jobcard'] ?? $jobcard_id ?? '' ?>">
                            </span>

                        </div>
                    </div>

                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td><label class="small fw-bold">Line Change</label></td>

                                <td class="text-danger"><span id="standard_price_display">
                                        <?= number_format($job_main_data[0]['net_total'] ?? 0, 2) ?>%
                                        <input type="hidden" class="form-control form-control-sm" id="line_discount_precentage"
                                            placeholder="Enter amount"></td>

                                <td class="text-danger text-end"><span id="standard_price_display">
                                        Rs. <?= number_format($job_main_data[0]['net_total'] ?? 0, 2) ?>
                                        <input type="hidden" class="form-control form-control-sm" id="line_discount"
                                            placeholder="Enter amount"></td>
                            </tr>


                            <tr>
                                <td><label class="small fw-bold ">Header Discount</label></td>

                                <td class="text-danger"><span id="standard_price_display">
                                        <?= number_format($job_main_data[0]['discount'] ?? 0, 2) ?>%
                                        <input type="hidden" class="form-control form-control-sm" id="header_discount_precentage"
                                            placeholder="Enter amount"></td>

                                <td class="text-danger text-end"><span id="standard_price_display">
                                        Rs. <?= number_format($job_main_data[0]['discount_amount'] ?? 0, 2) ?>
                                        <input type="hidden" class="form-control form-control-sm" id="header_discount"
                                            placeholder="Enter amount"></td>
                            </tr>



                            <tr>
                                <td><label class="small fw-bold ">Net Discount </label></td>

                                <td class="text-danger"><span id="standard_price_display">
                                        <?= number_format($job_main_data[0]['net_total'] ?? 0, 2) ?>%
                                        <input type="hidden" class="form-control form-control-sm" id="net_discount_precentage"
                                            placeholder="Enter amount"></td>

                                <td class="text-danger text-end"><span id="standard_price_display">
                                        Rs. <?= number_format($job_main_data[0]['net_total'] ?? 0, 2) ?>
                                        <input type="hidden" class="form-control form-control-sm" id="net_discount"
                                            placeholder="Enter amount"></td>
                            </tr>




                        </tbody>
                    </table>

                    <div class="row mt-4">
                        <div class="col-6">
                            <h5>Net Price: </h5>
                        </div>
                        <div class="col-6 text-end">
                        <span class="text-dark fw-bold" id="standard_price_display">
                                Rs. <?= number_format($job_main_data[0]['net_total'] ?? 0, 2) ?>
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
$(document).ready(function() {


});
</script>