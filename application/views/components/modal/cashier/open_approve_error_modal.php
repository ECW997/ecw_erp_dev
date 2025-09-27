<div class="modal fade" id="financeErrorModal" tabindex="-1" role="dialog" aria-labelledby="financeErrorModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content border-warning">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="financeErrorModalLabel">Opening Balance Not Approved</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>
                    <strong>Message:</strong> The opening balance has not been approved by the Finance Department.  
                    Please contact Finance to approve the balance before proceeding.
                </p>
                <?php if(isset($check_cashier_shift['shift']['cashier_name'])): ?>
                <p>
                    <strong>Cashier:</strong> <?php echo $check_cashier_shift['shift']['cashier_name']; ?>
                </p>
                <?php endif; ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
