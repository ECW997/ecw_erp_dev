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
                            <span class="text-primary"><strong>242,500</strong></span>

                        </div>
                    </div>

                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Line Change</td>
                                <td class="text-danger">-0.019%</td>
                                <td class="text-danger text-end">-4,500</td>
                            </tr>
                            <tr>
                                <td>Header Discount</td>
                                <td class="text-danger">-10.000%</td>
                                <td class="text-danger text-end">-23,800</td>
                            </tr>
                            <tr>
                                <td>Net Discount</td>
                                <td class="text-danger">-10.000%</td>
                                <td class="text-danger text-end">-23,800</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="row mt-4">
                        <div class="col-6">
                            <h4>Price: </h4>
                        </div>
                        <div class="col-6 text-end">
                        <span class="text-dark"><strong>214,200</strong></span>
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


    <div class="modal fade" id="createJobCardConfirmModal" tabindex="-1"
        aria-labelledby="createJobCardConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content next-step-confirmation">
                <div class="modal-header next-step-header">
                    <h5 class="next-step-title" id="createJobCardConfirmModalLabel">Proceed to Create Job Card</h5>
                    <button type="button" class="btn-close next-step-btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-question-circle next-step-icon"></i>
                    <p class="mb-0">Are you sure you want to proceed?<br>This action will create a new Job Card and
                        cannot
                        be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary next-step-btn-cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-primary next-step-btn-confirm"
                        onclick="confirmCreateJobCard()">
                        <i class="fas fa-arrow-right me-2"></i>Proceed
                    </button>
                </div>
            </div>
        </div>
    </div>



    <script>
    $(document).ready(function() {


    });
    </script>