<div class="modal fade" id="startShiftModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="startShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-xl" role="document">
        <div class="modal-content">
            <form id="startShiftForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="startShiftModalLabel">Start Cashier Shift</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="opening_balance_cash">Opening Cash</label>
                        <input type="text" step="0.01" class="form-control price-input" id="opening_balance_cash" name="opening_balance_cash" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="opening_balance_slips">Opening Slips</label>
                        <input type="text" step="0.01" class="form-control price-input" id="opening_balance_slips" name="opening_balance_slips" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="opening_balance_cheques">Opening Cheques</label>
                        <input type="text" step="0.01" class="form-control price-input" id="opening_balance_cheques" name="opening_balance_cheques" required min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="startShiftBtn">
                        <i class="fas fa-key mr-2"></i> Start Shift
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "open_approve_error_modal.php";  ?>
<script>

$(document).ready(function(){

    let page = '';

    $('.start-shift-link').click(function(){
        page = $(this).data('page');

        $.ajax({
            url: '<?php echo base_url() ?>Cashier/checkCashierShift',
            type: "GET",
            dataType: 'json',
            success: function(res){
                if (res.code === 200 && res.status === true) {
                    if(res.shift.opening_approved_at == 'null'){  //uncheck condition...if want to check using null without qoutation
                        $('#financeErrorModal').modal('show');
                    }else{
                        window.location.href = '<?php echo base_url(); ?>' + page;
                    }
                } else if (res.code === 404) {
                    $('#startShiftModal').modal('show');
                } else {
                    falseResponse(res.message || "Unexpected error checking shift");
                }
            },
            error: function (xhr) {
                falseResponse("Error: Unable to check shift (Code " + xhr.status + ")");
            }
        });
    });

    $('#startShiftForm').submit(function(e){
        e.preventDefault();

        if (!this.checkValidity()) {
            this.reportValidity(); 
            return false;
        }

        if(!confirm("Are you sure you want to start your cashier shift1?")) {
            return false; 
        }

        $(".price-input").each(function() {
            $(this).val($(this).val().replace(/,/g, ""));
        });

        $.ajax({
            url: '<?php echo base_url() ?>Cashier/startCashierShift',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res){
                if(res.status == 'success'){
                    $('#startShiftModal').modal('hide');
                    success_toastify(res.message);
                    $('#financeErrorModal').modal('show');
                    // window.location.href = '<?php echo base_url(); ?>' + page;
                } else {
                    falseResponse(res);
                }
            }
        });
    });
});

$(document).on("input", ".price-input", function() {
    let value = $(this).val().replace(/,/g, "");
    if (!isNaN(value) && value !== "") {
        let parts = value.split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $(this).val(parts.join("."));
    }
});
</script>