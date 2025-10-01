<div class="modal fade" id="cashierErrorModal" tabindex="-1" role="dialog" aria-labelledby="cashierErrorModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="cashierErrorModalLabel">Active Cashier Shift</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>
                    <strong>Message:</strong> Another cashier has an active shift. Please wait until it is closed.
                </p>
                <?php if(isset($check_cashier_shift['shift']['cashier_name'])): ?>
                <p>
                    <strong>Cashier:</strong> <?php echo $check_cashier_shift['shift']['cashier_name']; ?>
                </p>
                <?php endif; ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#cashierErrorModal').modal('show');
});
</script>
