<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<style>
.bg-success-light {
    background-color: rgba(40, 167, 69, 0.12);
}

.bg-danger-light {
    background-color: rgba(220, 53, 69, 0.12);
}
@keyframes pulseFinal {
    0% { box-shadow: 0 0 0 0 rgba(40,167,69,.4); }
    70% { box-shadow: 0 0 0 10px rgba(40,167,69,0); }
    100% { box-shadow: 0 0 0 0 rgba(40,167,69,0); }
}

.final-highlight {
    animation: pulseFinal 1.5s ease-out;
}
</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include APPPATH . "views/include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa fa-coins"></i></div>
                            <span>Cashier Shift</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-end">
                        <div class="row">
                            <div class="col">
                               <?php if (isset($check_cashier_shift['status']) && $check_cashier_shift['status']): ?>
                                <?php else: ?>
                                    <button class="btn btn-primary ml-3" id="cashierShiftOpenBtn" data-toggle="modal" data-target="#startShiftModal">Open Cashier Shift</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="shiftTable" class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Opened At</th>
                                    <th>Opening Approve Status</th>
                                    <th>Closed At</th>
                                    <th>Closing Approve Status</th>
                                    <th>Shift Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>

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
                            <div id="startShiftSpinner" class="text-center py-5" style="display:none;">
                                <div class="spinner-border text-primary" role="status"></div>
                                <div class="mt-2">Loading opening balance...</div>
                            </div>
                            <div id="startShiftFormContent">
                                <div id="previous_shift_info_alert" class="alert alert-info" style="display: none;">
                                    <i class="fas fa-info-circle"></i> <strong>Auto-filled:</strong> Opening balance carried forward from <span id="previous_shift_code"></span> (Closed: <span id="previous_shift_closed_at"></span>)
                                    <br>
                                    <span id="previous_shift_cash_1">System Opening Cash: Rs. <span class="text-success" id="previous_shift_cash_main_value"></span></span>
                                    <br>
                                    <span id="previous_shift_cash_2">System Opening Cash 2: Rs. <span class="text-warning" id="previous_shift_cash_petty_value"></span></span>
                                    <br>
                                    <span id="previous_shift_cash_total">System Total Cash: Rs. <span class="text-danger" id="previous_shift_cash_total_value"></span></span>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6" id="opening_cash_series_1_container">
                                        <label>System Opening Cash</label>
                                        <input type="text" class="form-control price-input text-right opening-cash" id="opening_cash_series_1" name="opening_cash_series_1" required placeholder="0.00" readonly>
                                    </div>

                                    <div class="col-md-6" id="opening_cash_series_2_container">
                                        <label>System Opening Cash 2</label>
                                        <input type="text" class="form-control price-input text-right opening-cash series-2" id="opening_cash_series_2" name="opening_cash_series_2" value="0.00" required placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="mb-3 d-none" id="previous_manual_closing_cash_container">
                                        <label>Previous Manual Closing Cash</label>
                                        <input type="text" class="form-control price-input text-right" id="previous_manual_closing_cash" name="previous_manual_closing_cash" required placeholder="0.00" readonly>
                                </div>
                                <div class="mb-3" id="opening_balance_cash_container">
                                    <label for="opening_balance_manual_cash">Opening Cash</label>
                                    <input type="text" class="form-control price-input text-right" id="opening_balance_manual_cash" name="opening_balance_manual_cash" required placeholder="0.00">
                                </div>
                                <div class="mb-3 d-none input-group" id="difference_between_previous_manual_closing_cash_and_opening_cash_container">
                                        <label>Difference Between Previous Manual Closing Cash and Opening Cash</label>
                                        <input type="text" class="form-control price-input text-right" id="difference_between_previous_manual_closing_cash_and_opening_cash" name="difference_between_previous_manual_closing_cash_and_opening_cash" required placeholder="0.00" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="difference_icon"></span>
                                        </div>
                                    </div>
                                <div class="mb-3">
                                    <label for="opening_balance_slips">Opening Slips</label>
                                    <input type="text" class="form-control price-input text-right" id="opening_balance_slips" name="opening_balance_slips" required placeholder="0.00">
                                </div>
                                <div class="mb-3">
                                    <label for="opening_balance_cheques">Opening Cheques</label>
                                    <input type="text" class="form-control price-input text-right" id="opening_balance_cheques" name="opening_balance_cheques" required placeholder="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- add checkox for enable or disable openining manual cash required or not -->
                            <div class="form-group">
                                <input class="form-check-input" type="checkbox" id="opening_manual_cash_required" name="opening_manual_cash_required">
                            </div>
                            <button type="submit" class="btn btn-primary" id="startShiftBtn" title="Start Shift" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-key"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="cashierShiftModal" tabindex="-1" role="dialog" aria-labelledby="cashierShiftModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cashierShiftModalLabel">Cashier Shift</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="cashierShiftContent">
                        <div class="text-center"><div class="spinner-grow text-primary" role="status"></div></div>
                    </div>
                    <div class="modal-footer" id="cashierShiftFooter">
                        <!-- Buttons will be added dynamically -->
                    </div>
                </div>
            </div>
        </div>
        <?php include APPPATH . "views/components/modal/cashier/open_approve_error_modal.php";  ?>
        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>
<?php include APPPATH . "views/include/footerscripts.php"; ?>
<script>
    // Initialize tooltips
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        lockSeries();
    });
    
    let checkCashierShift = <?= json_encode($check_cashier_shift) ?>;

    // Load suggested opening balance when the start shift modal is shown
    $('#startShiftModal').on('show.bs.modal', function (e) {
        $('#startShiftSpinner').show();
        $('#startShiftFormContent').hide();
        loadSuggestedOpeningBalance();
    });

    // Function to fetch and pre-fill suggested opening balance from previous shift
    function loadSuggestedOpeningBalance() {
        $.ajax({
            url: '<?= base_url("Cashier/Shift/getSuggestedOpeningBalance") ?>',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status && res.data) {
                    const data = res.data;
                    
                    // Pre-fill the form fields
                    if (data.source === 'previous_shift' && data.previous_shift) {
                        // Format numbers with commas
                        $('#opening_cash_series_1').val(formatPriceWithCommas(data.cash_main));
                        $('#opening_cash_series_2').val(formatPriceWithCommas(data.cash_petty));
                        $('#opening_balance_cash').val(formatPriceWithCommas(data.cash));
                        $('#previous_manual_closing_cash').val(formatPriceWithCommas(data.closing_balance_manual_cash));
                        $('#opening_balance_slips').val(formatPriceWithCommas(data.slips));
                        $('#opening_balance_cheques').val(formatPriceWithCommas(data.cheques));
                        
                        // Show info alert with previous shift details
                        $('#previous_shift_code').text(data.previous_shift.code || 'N/A');
                        $('#previous_shift_closed_at').text(data.previous_shift.closed_at || 'N/A');
                        $('#previous_shift_cash_main_value').text(formatPriceWithCommas(data.cash_main));
                        $('#previous_shift_cash_petty_value').text(formatPriceWithCommas(data.cash_petty));
                        $('#previous_shift_cash_total_value').text(formatPriceWithCommas(data.cash));
                        $('#previous_shift_info_alert').show();
                    } else {
                        // No previous shift - set default zeros
                        $('#opening_cash_series_1').val('0.00');
                        $('#opening_cash_series_2').val('0.00');
                        $('#opening_balance_cash').val('0.00');
                        $('#previous_manual_closing_cash').val('0.00');
                        $('#opening_balance_slips').val('0.00');
                        $('#opening_balance_cheques').val('0.00');
                        $('#previous_shift_info_alert').hide();
                    }
                } else {
                    // Failed to get suggested balance - use defaults
                    $('#opening_cash_series_1').val('0.00');
                    $('#opening_cash_series_2').val('0.00');
                    $('#opening_balance_cash').val('0.00');
                    $('#previous_manual_closing_cash').val('0.00');
                    $('#opening_balance_slips').val('0.00');
                    $('#opening_balance_cheques').val('0.00');
                    $('#previous_shift_info_alert').hide();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading suggested opening balance:', error);
                // On error, set defaults
                $('#opening_cash_series_1').val('0.00');
                $('#opening_cash_series_2').val('0.00');
                $('#opening_balance_cash').val('0.00');
                $('#previous_manual_closing_cash').val('0.00');
                $('#opening_balance_slips').val('0.00');
                $('#opening_balance_cheques').val('0.00');
                $('#previous_shift_info_alert').hide();
            },
            complete: function () {
                $('#startShiftSpinner').hide();
                $('#startShiftFormContent').fadeIn(200);
            }
        });
    }

    $('#previous_manual_closing_cash').on('input', function() {
        calculateDifference();
    });

    $('#opening_balance_manual_cash').on('input', function() {
        calculateDifference();
    });

    function calculateDifference(){
        let previousManualClosingCash = Number($('#previous_manual_closing_cash').val().replace(/,/g, "")) ?? 0;
        let openingCash = Number($('#opening_balance_manual_cash').val().replace(/,/g, "")) ?? 0;
        let difference = openingCash - previousManualClosingCash;
        let $diffField = $('#difference_between_previous_manual_closing_cash_and_opening_cash');
        let $icon = $('#difference_icon');

        $diffField.val(
        difference.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
            })
        );

        // Reset styles
        $diffField.removeClass('text-danger text-success text-info');
        $icon.removeClass('text-danger text-success text-info').html('');

        if (difference > 0) {
            $diffField.addClass('text-info');
            $icon.addClass('text-info')
                .html('<i class="fas fa-arrow-up"></i>');
        } 
        else if (difference < 0) {
            $diffField.addClass('text-danger');
            $icon.addClass('text-danger')
                .html('<i class="fas fa-arrow-down"></i>');
        } 
        else {
            $diffField.addClass('text-success');
            $icon.addClass('text-success')
                .html('<i class="fas fa-equals"></i>');
        }
    }

    if(checkCashierShift.logs){
        $('#shiftTable').DataTable({
            data: checkCashierShift.logs,
            destroy: true, 
            order: [[1, 'desc']],
            columns: [
                { 
                    data: "code", 
                    title: "Code",
                    className: 'text-center'
                },
                { data: "opened_at" },
                { 
                    data: "opening_approved_at",
                    className: 'text-center',
                    render: d => {
                        let baseClasses = "badge badge-pill";
                        return d 
                            ? `<span class="${baseClasses} bg-success text-white">Approved</span>` 
                            : `<span class="${baseClasses} bg-danger text-white">Pending</span>`;
                    }
                },
                { 
                    data: "closed_at",
                    render: d => d ? d : '<span class="text-danger">Not Closed</span>'
                },
                { 
                    data: "closing_verified_at",
                    className: 'text-center',
                    render: d => {
                        let baseClasses = "badge badge-pill";
                        return d 
                            ? `<span class="${baseClasses} bg-success text-white">Approved</span>` 
                            : `<span class="${baseClasses} bg-danger text-white">Pending</span>`;
                    }
                },
                { 
                    data: "status",
                    className: 'text-center',
                    render: d => {
                        let baseClasses = "badge badge-pill";
                        if (d === 'open') {
                            return `<span class="${baseClasses} bg-success text-white">Open</span>`;
                        } else if (d === 'verified') {
                            return `<span class="${baseClasses} bg-info text-white">Verified</span>`;
                        } else if (d === 'closed') {
                            return `<span class="${baseClasses} bg-danger text-white">Closed</span>`;
                        } else {
                            return `<span class="${baseClasses} bg-secondary text-white">Unknown</span>`;
                        }
                    }
                },
                { 
                    data: null,
                    className: 'text-center',
                    render: function(row) {
                        let rowData = encodeURIComponent(JSON.stringify(row));
                        if (row.status === 'open') {
                            return `<button class="btn btn-success btn-sm" onclick="viewShift();" title="View Shift" data-toggle="tooltip" data-placement="top"><i class="fas fa-eye"></i></button>`;
                        } else {
                            return `<button class="btn btn-danger btn-sm" onclick="viewcloseShift('${rowData}');" title="View Closed Shift" data-toggle="tooltip" data-placement="top"><i class="fas fa-lock"></i></button>`;
                        }
                    }
                }
            ]
        });
    }

    $('#startShiftForm').submit(function(e){
        e.preventDefault();
        if (!this.checkValidity()) {
            this.reportValidity(); 
            return false;
        }
        if(!confirm("Are you sure you want to start your cashier shift?")) {
            return false; 
        }
        $(".price-input").each(function() {
            $(this).val($(this).val().replace(/,/g, ""));
        });
        $.ajax({
            url: '<?php echo base_url() ?>Cashier/Shift/startCashierShift',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res){
                if(res.status){
                    $('#startShiftModal').modal('hide');
                    success_toastify(res.message);
                    $('#financeErrorModal').modal('show');
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                } else {
                    falseResponse(res);
                }
            }
        });
    });

    function viewShift(){
        $('#cashierShiftContent').html('<div class="text-center"><div class="spinner-grow text-primary" role="status"></div></div>');
        $('#cashierShiftFooter').html('');
        $('#cashierShiftModal').modal('show');
        getCashierShiftDetails();
    }

    function getCashierShiftDetails(){
        let res = checkCashierShift;
        let modalBody = '';
        let modalFooter = '';
        if (res.shift) {
            let shift_data = res.shift;
            if (shift_data.opening_approved_at == 'null') {
                $('#financeErrorModal').modal('show');
                $('#cashierShiftModal').modal('hide');
            } else {
                modalBody = `
                    <div class="row">
                        <div class="col-12 mb-3">
                            <p><b>Cashier:</b> ${shift_data.cashier_name}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p><b>Shift Opened At:</b> ${shift_data.opened_at}</p>
                            <form id="updateShiftForm">
                                <table class="table table-sm table-bordered mb-0">
                                    <tbody>`;
                if (shift_data.opening_approved_at == null) {
                    modalBody += `
                        <tr>
                            <td><b>System Opening Cash</b></td>
                            <td class="text-right">
                                <input type="text" class="form-control form-control-sm text-right price-input" 
                                    id="input_opening_cash_series_1" name="input_opening_cash_series_1"
                                    value="${Number(shift_data.opening_balance_cash_main ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}" readonly required>
                            </td>
                        </tr>
                        <tr id="opening_cash_series_2_container2" class="d-none">
                            <td><b>System Opening Cash 2</b></td>
                            <td class="text-right">
                                <input type="text" class="form-control form-control-sm text-right price-input" 
                                    id="input_opening_cash_series_2" name="input_opening_cash_series_2"
                                    value="${Number(shift_data.opening_balance_cash_petty ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}" readonly required>
                            </td>
                        </tr>
                        <tr id="opening_balance_manual_cash_container" class="d-none">
                            <td><b>Opening Cash</b></td>
                            <td class="text-right">
                                <input type="text" class="form-control form-control-sm text-right price-input" 
                                    id="input_opening_balance_manual_cash" name="input_opening_balance_manual_cash"
                                    value="${Number(shift_data.opening_balance_manual_cash ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}" required>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Opening Slips</b></td>
                            <td class="text-right">
                                <input type="text" class="form-control form-control-sm text-right price-input" 
                                    id="input_opening_balance_slips" name="input_opening_balance_slips"
                                    value="${Number(shift_data.opening_balance_slips ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}" required>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Opening Cheques</b></td>
                            <td class="text-right">
                                <input type="text" class="form-control form-control-sm text-right price-input" 
                                    id="input_opening_balance_cheques" name="input_opening_balance_cheques"
                                    value="${Number(shift_data.opening_balance_cheques ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}" required>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right">
                                <button type="button" class="btn btn-primary btn-sm" id="updateOpeningBalancesBtn" title="Update Balances" data-toggle="tooltip" data-placement="top">
                                    <i class="fas fa-save"></i>
                                </button>
                            </td>
                        </tr>`;
                } else {
                    modalBody += `
                        <tr>
                            <td><b>System Opening Cash</b></td>
                            <td class="text-right">${Number(shift_data.opening_balance_cash_main).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        </tr>
                        <tr id="opening_cash_series_2_container3" class="d-none">
                            <td><b>System Opening Cash 2</b></td>
                            <td class="text-right">${Number(shift_data.opening_balance_cash_petty).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        </tr>
                        <tr id="total_opening_balance_cash_container" class="d-none">
                            <td><b>System Total Opening Cash</b></td>
                            <td class="text-right">${Number(shift_data.opening_balance_cash).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        </tr>
                        <tr id="opening_balance_manual_cash_container3" class="d-none">
                            <td><b>Opening Cash</b></td>
                            <td class="text-right">${Number(shift_data.opening_balance_manual_cash).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        </tr>
                        <tr>
                            <td><b>Opening Slips</b></td>
                            <td class="text-right">${Number(shift_data.opening_balance_slips).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        </tr>
                        <tr>
                            <td><b>Opening Cheques</b></td>
                            <td class="text-right">${Number(shift_data.opening_balance_cheques).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        </tr>`;
                }
                modalBody += `
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div class="col-6">
                            <form id="closeShiftForm">
                                <p><b>Enter Closing Balances:</b></p>
                                <table class="table table-sm table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="text-start">System Cash</th>
                                            <td><input type="text" class="form-control form-control-sm text-right price-input" id="closing_cash_series_1" name="closing_cash_series_1" placeholder="0.00" readonly required></td>
                                        </tr>
                                        <tr id="closing_cash_series_2_container" class="d-none">
                                            <th class="text-start">System Cash 2</th>
                                            <td><input type="text" class="form-control form-control-sm text-right price-input" id="closing_cash_series_2" name="closing_cash_series_2" placeholder="0.00" value="0.00" readonly required></td>
                                        </tr>
                                        <tr id="total_closing_balance_cash_container" class="d-none">
                                            <th class="text-start">System Total Closing Cash</th>
                                            <td><input type="text" class="form-control form-control-sm text-right price-input" id="total_closing_balance_cash" name="total_closing_balance_cash" placeholder="0.00" value="0.00" readonly required></td>
                                        </tr>
                                        <tr id="closing_manual_cash_container" class="d-none">
                                            <th class="text-start">Closing Cash</th>
                                            <td><input type="text" class="form-control form-control-sm text-right price-input" id="closing_manual_cash" name="closing_manual_cash" placeholder="0.00" required></td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">Slips</th>
                                            <td><input type="text" class="form-control form-control-sm text-right price-input" id="closing_slips" name="closing_slips" placeholder="0.00" required></td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">Cheques</th>
                                            <td><input type="text" class="form-control form-control-sm text-right price-input" id="closing_cheques" name="closing_cheques" placeholder="0.00" required></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div id="realTimeCashProgressSection">
                                <div class="text-center">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div> 
                                    <span class="ml-2">Loading Real-Time Cash Progress...</span>
                                </div>
                            </div>
                        </div>
                    </div>`;
                modalFooter = `<button class="btn btn-danger" id="closeShiftBtn" title="Close Shift" data-toggle="tooltip" data-placement="top"><i class="fas fa-lock"></i></button>`;
                
                // Load real-time cash progress for active shift
                if (res.shift && res.shift.id) {
                    loadRealTimeCashProgress(res.shift.id);
                }
            }
        }
        $('#cashierShiftContent').html(modalBody);
        $('#cashierShiftFooter').html(modalFooter);
    }

    $(document).on('click', '#closeShiftBtn', function (e) {
        e.preventDefault();
        let form = $('#closeShiftForm')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        if (confirm("Are you sure you want to close the shift?")) {
            $('#closeShiftForm .price-input').each(function() {
                $(this).val($(this).val().replace(/,/g, "").trim());
            });
            $.ajax({
                url: '<?php echo base_url(); ?>Cashier/Shift/closeCashierShift',
                type: 'POST',
                data: $('#closeShiftForm').serialize(),
                dataType: 'json',
                success: function(result) {
                    if(result.status) {
                        success_toastify(result.message);
                        $('#cashierShiftModal').modal('hide');
                        window.location.href = '<?php echo base_url("Auth/Dashboard"); ?>';
                    } else {
                        alert('Error: ' + result.message);
                    }
                },
                error: function(xhr) {
                    alert('Error closing shift (Code ' + xhr.status + ')');
                }
            });
        }
    });

    $(document).on('click', '#updateOpeningBalancesBtn', function (e) {
        e.preventDefault();
        let $btn = $(this); 
        let form = $('#updateShiftForm')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        if (confirm("Are you sure you want to update the open balances?")) {
            $btn.prop('disabled', true).text('Updating...');
            $('#updateShiftForm .price-input').each(function() {
                $(this).val($(this).val().replace(/,/g, "").trim());
            });
            $.ajax({
                url: '<?php echo base_url(); ?>Cashier/Shift/updateShiftOpeningBalances',
                type: 'POST',
                data: $('#updateShiftForm').serialize(),
                dataType: 'json',
                success: function(result) {
                    if(result.status) {
                        success_toastify(result.message);
                        $('#cashierShiftContent').html('');
                        $('#cashierShiftFooter').html('');
                        $('#cashierShiftContent').html('<div class="text-center"><div class="spinner-grow text-primary" role="status"></div></div>');
                        $btn.prop('disabled', false).text('Update Balances'); 
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    } else {
                        alert('Error: ' + result.message);
                        $btn.prop('disabled', false).text('Update Balances');
                    }
                },
                error: function(xhr) {
                    alert('Error updating balances (Code ' + xhr.status + ')');
                    $btn.prop('disabled', false).text('Update Balances'); 
                }
            });
        }
    });

    function viewcloseShift(data) {
        let shift_data = JSON.parse(decodeURIComponent(data));
        let modalBody = `
            <div class="row">
                <div class="col-12 mb-3">
                    <p><b>Cashier:</b> ${shift_data.cashier_name}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><b>Shift Opened At:</b> ${shift_data.opened_at}</p>
                    <table class="table table-sm table-bordered mb-0">
                        <tbody>
                            <tr>
                                <td><b>System Opening Cash</b></td>
                                <td class="text-right">${Number(shift_data.opening_balance_cash_main ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                            <tr id="opening_cash_series_2_container4" class="d-none">
                                <td><b>System Opening Cash 2</b></td>
                                <td class="text-right">${Number(shift_data.opening_balance_cash_petty ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                            <tr id="opening_cash_series_2_container5" class="d-none">
                                <td><b>System Total Opening Cash</b></td>
                                <td class="text-right">${Number(shift_data.opening_balance_cash ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                            <tr id="opening_balance_manual_cash_container2" class="d-none">
                                <td><b>Opening Cash</b></td>
                                <td class="text-right">${Number(shift_data.opening_balance_manual_cash ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                            <tr>
                                <td><b>Opening Slips</b></td>
                                <td class="text-right">${Number(shift_data.opening_balance_slips ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                            <tr>
                                <td><b>Opening Cheques</b></td>
                                <td class="text-right">${Number(shift_data.opening_balance_cheques ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-6">
                    <p><b>Shift Closed At:</b> ${shift_data.closed_at ?? '-'}</p>
                    <table class="table table-sm table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th class="text-start">System Closing Cash</th>
                                <td class="text-right">${Number(shift_data.closing_balance_cash_main ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                            <tr id="closing_cash_series_2_container2" class="d-none">
                                <th class="text-start">System Closing Cash 2</th>
                                <td class="text-right">${Number(shift_data.closing_balance_cash_petty ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                            <tr id="closing_cash_series_2_container3" class="d-none">
                                <th class="text-start">System Total Closing Cash</th>
                                <td class="text-right">${Number(shift_data.closing_balance_cash ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                            <tr id="closing_manual_cash_container2" class="d-none">
                                <th class="text-start">Closing Cash</th>
                                <td class="text-right">${Number(shift_data.closing_balance_manual_cash ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                            <tr>
                                <th class="text-start">Closing Slips</th>
                                <td class="text-right">${Number(shift_data.closing_balance_slips ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                            <tr>
                                <th class="text-start">Closing Cheques</th>
                                <td class="text-right">${Number(shift_data.closing_balance_cheques ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                            </tr>
                            <tr>
                                <th class="text-start">Verified</th>
                                <td>${shift_data.closing_verified_at 
                                    ? '<span class="text-success">Approved</span>' 
                                    : '<span class="text-danger">Pending</span>'}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>`;
        let modalFooter = `<button class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>`;
        $('#cashierShiftContent').html(modalBody);
        $('#cashierShiftFooter').html(modalFooter);
        $('#cashierShiftModal').modal('show');
    }

    function formatCurrency(value) {
        if (!value) return '';
        return Number(value.replace(/,/g, '')).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    $(document).on('blur', '.price-input', function () {
        let val = $(this).val().replace(/,/g, '');
        if (val && !isNaN(val)) {
            $(this).val(formatCurrency(val));
        }
    });

    // Global function to format number with thousand separators
    function formatPriceWithCommas(value) {
        if (!value || value === '') return '';
        // Remove all commas and non-numeric characters except decimal point
        let numValue = value.toString().replace(/[^0-9.]/g, '');
        if (numValue === '' || numValue === '.') return '';
        
        // Split integer and decimal parts
        let parts = numValue.split('.');
        let integerPart = parts[0];
        let decimalPart = parts.length > 1 ? '.' + parts[1].substring(0, 2) : '';
        
        // Add thousand separators to integer part
        integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        
        return integerPart + decimalPart;
    }

    // Global function to remove commas and get clean numeric value
    function getCleanNumericValue(value) {
        if (!value || value === '') return '';
        // Remove all commas and return clean number
        return value.toString().replace(/,/g, '');
    }

    // Format price inputs with thousand separators on input
    $(document).on("input blur", ".price-input", function() {
        let $input = $(this);
        let value = getCleanNumericValue($input.val());
        
        if (value !== '' && !isNaN(value) && parseFloat(value) >= 0) {
            let formatted = formatPriceWithCommas(value);
            $input.val(formatted);
        } else if (value === '') {
            $input.val('');
        }
    });
    
    // On focus, remove commas for easier editing
    $(document).on("focus", ".price-input", function() {
        let $input = $(this);
        let value = getCleanNumericValue($input.val());
        if (value !== '') {
            $input.val(value);
        }
    });

    // Real-time cash progress variables
    let cashProgressInterval = null;
    let currentShiftId = null;

    function formatMoney(d) {
        return Number(d ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function loadRealTimeCashProgress(shiftId) {
        currentShiftId = shiftId;
        
        $.ajax({
            url: '<?= base_url("Cashier/Shift/getRealTimeCashProgress") ?>/' + shiftId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status && response.data) {
                    calculateClosingCash(response.data);
                    displayRealTimeCashProgress(response.data);
                    
                    // Clear existing interval and set up auto-refresh (every 30 seconds)
                    if (cashProgressInterval) {
                        clearInterval(cashProgressInterval);
                    }
                    cashProgressInterval = setInterval(function() {
                        if (currentShiftId && $('#cashierShiftModal').is(':visible')) {
                            loadRealTimeCashProgress(currentShiftId);
                        }
                    }, 30000); // Refresh every 30 seconds
                } else {
                    $('#realTimeCashProgressSection').html(`
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> ${response.message || 'Failed to load cash progress'}
                        </div>
                    `);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading cash progress:', xhr, status, error);
                $('#realTimeCashProgressSection').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> Error loading cash progress: ${error || 'Unknown error'}
                    </div>
                `);
            }
        });
    }

    function calculateClosingCash(data) {
        let seriesBreakdown = data.series_breakdown || null;
        let res = checkCashierShift;
        if (res.shift) {

            let s1_system_opening_cash = Number(res.shift.opening_balance_cash_main) || 0;
            let s2_system_opening_cash = Number(res.shift.opening_balance_cash_petty) || 0;
            let total_system_opening_cash = Number(res.shift.opening_balance_cash) || 0;

            if (seriesBreakdown) {
                let s1_transaction_net_cash = Number(seriesBreakdown.series_1.net) || 0;
                let s2_transaction_net_cash = Number(seriesBreakdown.series_2.net) || 0;
                let total_transaction_net_cash = Number(seriesBreakdown.total.net) || 0;
                
                let s1_expected_closing_cash = Number(s1_system_opening_cash + s1_transaction_net_cash) || 0;
                let s2_expected_closing_cash = Number(s2_system_opening_cash + s2_transaction_net_cash) || 0;
                let total_expected_closing_cash = Number(total_system_opening_cash + total_transaction_net_cash) || 0;

                $('#closing_cash_series_1').val(formatMoney(s1_expected_closing_cash));
                $('#closing_cash_series_2').val(formatMoney(s2_expected_closing_cash));
                $('#total_closing_balance_cash').val(formatMoney(total_expected_closing_cash));
            }
            
        }
    }

    function displayRealTimeCashProgress(data) {
        let cashBook = data.cash_book_summary || data;
        let seriesBreakdown = data.series_breakdown || null;
        
        // Calculate current expected cash
        // Ensure all values are numbers before calculations (handle null, undefined, NaN)
        let expectedCash = parseFloat(cashBook.expected_cash || 0) || 0;


        let s1_system_opening_cash = Number(cashBook.s1_opening_balance) || 0;
        let s2_system_opening_cash = Number(cashBook.s2_opening_balance) || 0;
        let total_system_opening_cash = Number(cashBook.total_opening_balance) || 0;
        let manual_opening_cash = Number(cashBook.manual_opening_balance) || 0;

        let transactionLedgerCashIn_s1 = Number(cashBook.transaction_ledger_cash_in_s1) || 0;
        let transactionLedgerCashOut_s1 = Number(cashBook.transaction_ledger_cash_out_s1) || 0;
        let transactionLedgerCashIn_s2 = Number(cashBook.transaction_ledger_cash_in_s2) || 0;
        let transactionLedgerCashOut_s2 = Number(cashBook.transaction_ledger_cash_out_s2) || 0;
        let total_transactionLedgerCashIn = Number(cashBook.transaction_ledger_cash_in) || 0;
        let total_transactionLedgerCashOut = Number(cashBook.transaction_ledger_cash_out) || 0;

        let cashMovementCashIn_s1 = Number(cashBook.cash_movement_cash_in_s1) || 0;
        let cashMovementCashOut_s1 = Number(cashBook.cash_movement_cash_out_s1) || 0;
        let cashMovementCashIn_s2 = Number(cashBook.cash_movement_cash_in_s2) || 0;
        let cashMovementCashOut_s2 = Number(cashBook.cash_movement_cash_out_s2) || 0;
        let total_cashMovementCashIn = Number(cashBook.cash_movement_cash_in) || 0;
        let total_cashMovementCashOut = Number(cashBook.cash_movement_cash_out) || 0;

        let adjustments_s1 = Number(cashBook.s1_adjustments) || 0;
        let adjustments_s2 = Number(cashBook.s2_adjustments) || 0;
        let total_adjustments = Number(cashBook.adjustments) || 0;

        let s1_expectedCash = Number(cashBook.s1_expected_cash) || 0;
        let s2_expectedCash = Number(cashBook.s2_expected_cash) || 0;
        let total_expectedCash = Number(cashBook.total_expected_cash ) || 0;

        let s1_variance = Number(cashBook.s1_variance) || 0;
        let s2_variance = Number(cashBook.s2_variance) || 0;
        let total_variance = Number(cashBook.total_variance) || 0;

        let openingBalance = parseFloat(cashBook.opening_balance || cashBook.opening_balance_cash || 0) || 0;
        let transactionLedgerCashIn = parseFloat(cashBook.transaction_ledger_cash_in || 0) || 0;
        let cashMovementCashIn = parseFloat(cashBook.cash_movement_cash_in || 0) || 0;
        let transactionLedgerCashOut = parseFloat(cashBook.transaction_ledger_cash_out || 0) || 0;
        let cashMovementCashOut = parseFloat(cashBook.cash_movement_cash_out || 0) || 0;
        let adjustmentsNet = parseFloat(cashBook.adjustments || 0) || 0;

        let s1_safe_cash_in = parseFloat(cashBook.s1_safe_cash_in) || 0;
        let s2_safe_cash_in = parseFloat(cashBook.s2_safe_cash_in) || 0;
        let total_safe_cash_in = parseFloat(cashBook.total_safe_cash_in) || 0;
        let s1_safe_cash_out = parseFloat(cashBook.s1_safe_cash_out) || 0;
        let s2_safe_cash_out = parseFloat(cashBook.s2_safe_cash_out) || 0;
        let total_safe_cash_out = parseFloat(cashBook.total_safe_cash_out) || 0;
        let total_safe_cash = parseFloat(cashBook.total_safe_cash) || 0;
        
        // Split adjustments into cash in (positive) and cash out (negative)
        let adjustmentsIn = adjustments_s1 > 0 ? adjustments_s1 : 0;
        let adjustmentsOut = adjustments_s1 < 0 ? Math.abs(adjustments_s1) : 0;
        
        // Calculate totals (Note: Total Cash In includes opening balance)
        let cashIn = s1_system_opening_cash + transactionLedgerCashIn_s1 + cashMovementCashIn_s1 + adjustmentsIn;
        let cashOut = transactionLedgerCashOut_s1 + cashMovementCashOut_s1 + adjustmentsOut;

        let s1_cash_in_hand = s1_expectedCash - s1_safe_cash_in + s1_safe_cash_out;
        let s2_cash_in_hand = s2_expectedCash - s2_safe_cash_in + s2_safe_cash_out;
        let total_cash_in_hand = total_expectedCash - total_safe_cash_in + total_safe_cash_out;

        let s1_safe_cash = s1_safe_cash_in - s1_safe_cash_out;
        let s2_safe_cash = s2_safe_cash_in - s2_safe_cash_out;
        
        // Ensure totals are valid numbers (not NaN)
        if (isNaN(cashIn)) cashIn = 0;
        if (isNaN(cashOut)) cashOut = 0;
        
        let cashProgressHtml = `
            <div class="card border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-chart-line"></i> Real-Time Cash Progress</h6>
                    <small><i class="fas fa-sync-alt fa-spin"></i> Auto-updating every 30 seconds</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2">Cash Inflows</h6>
                            <table class="table table-sm table-bordered mb-0">
                                <tr>
                                    <th>Opening Balance (Cash)</th>
                                    <td class="text-right"><strong>${formatMoney(s1_system_opening_cash)}</strong></td>
                                </tr>
                                <tr class="table-info">
                                    <th><i class="fas fa-arrow-down text-success"></i> Transaction Ledger Cash In</th>
                                    <td class="text-right"><strong class="text-success">${formatMoney(transactionLedgerCashIn_s1 || 0)}</strong></td>
                                </tr>
                                <tr class="table-info">
                                    <th><i class="fas fa-arrow-down text-success"></i> Cash Movement Cash In</th>
                                    <td class="text-right"><strong class="text-success">${formatMoney(cashMovementCashIn_s1 || 0)}</strong></td>
                                </tr>
                                <tr>
                                    <th>Adjustments (In)</th>
                                    <td class="text-right"><strong>${formatMoney(adjustmentsIn)}</strong></td>
                                </tr>
                                <tr class="table-success">
                                    <th><strong>Total Cash In</strong></th>
                                    <td class="text-right"><strong>${formatMoney(cashIn)}</strong></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2">Cash Outflows</h6>
                            <table class="table table-sm table-bordered mb-0">
                                <tr class="table-danger">
                                    <th><i class="fas fa-arrow-up text-danger"></i> Transaction Ledger Cash Out</th>
                                    <td class="text-right"><strong class="text-danger">${formatMoney(transactionLedgerCashOut_s1 || 0)}</strong></td>
                                </tr>
                                <tr class="table-danger">
                                    <th><i class="fas fa-arrow-up text-danger"></i> Cash Movement Cash Out</th>
                                    <td class="text-right"><strong class="text-danger">${formatMoney(cashMovementCashOut_s1 || 0)}</strong></td>
                                </tr>
                                <tr>
                                    <th>Adjustments (Out)</th>
                                    <td class="text-right"><strong>${formatMoney(adjustmentsOut)}</strong></td>
                                </tr>
                                <tr class="table-danger">
                                    <th><strong>Total Cash Out</strong></th>
                                    <td class="text-right"><strong>${formatMoney(cashOut)}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3" id="show_safe_cash_section">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2"><i class="fas fa-shield-alt"></i> Safe Cash</h6>
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-right">Cash In Hand</th>
                                        <th class="text-right">Safe In</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-right">${formatMoney(s1_cash_in_hand || 0)}</td>
                                        <td class="text-right">${formatMoney(s1_safe_cash)}</td>
                                        <td class="text-right">${formatMoney(s1_expectedCash || 0)}</td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3 d-none" id="hide_safe_cash_section">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2"><i class="fas fa-shield-alt"></i> Safe Cash</h6>
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th></th>
                                        <th class="text-right">Cash In Hand</th>
                                        <th class="text-right">Safe In</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Series 1</strong></td>
                                        <td class="text-right">${formatMoney(s1_cash_in_hand || 0)}</td>
                                        <td class="text-right">${formatMoney(s1_safe_cash)}</td>
                                        <td class="text-right">${formatMoney(s1_expectedCash || 0)}</td>
                                    </tr>
                                <tr>
                                    <td><strong>Series 2</strong></td>
                                    <td class="text-right">${formatMoney(s2_cash_in_hand || 0)}</td>
                                    <td class="text-right">${formatMoney(s2_safe_cash)}</td>
                                    <td class="text-right">${formatMoney(s2_expectedCash || 0)}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td class="text-right"><strong>${formatMoney(total_cash_in_hand || 0)}</strong></td>
                                    <td class="text-right"><strong>${formatMoney(total_safe_cash)}</strong></td>
                                    <td class="text-right"><strong>${formatMoney(total_expectedCash ||0)}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="alert alert-info mb-0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Opening Balance:</strong><br>
                                        <span class="h5">${formatMoney(s1_system_opening_cash)}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Expected Current Balance:</strong><br>
                                        <span class="h5 text-primary">${formatMoney(s1_expectedCash)}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Net Change:</strong><br>
                                        <span class="h5 ${(s1_expectedCash - s1_system_opening_cash) >= 0 ? 'text-success' : 'text-danger'}">
                                            ${(s1_expectedCash - s1_system_opening_cash) >= 0 ? '+' : ''}${formatMoney(s1_expectedCash - s1_system_opening_cash)}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="series2_cash_progress_section" class="d-none">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="alert alert-warning mb-0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Opening Balance Series 2:</strong><br>
                                        <span class="h5">${formatMoney(s2_system_opening_cash)}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Expected Current Balance Series 2:</strong><br>
                                        <span class="h5 text-primary">${formatMoney(s2_expectedCash)}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Net Change Series 2:</strong><br>
                                        <span class="h5 ${(s2_expectedCash - s2_system_opening_cash) >= 0 ? 'text-success' : 'text-danger'}">
                                            ${(s2_expectedCash - s2_system_opening_cash) >= 0 ? '+' : ''}${formatMoney(s2_expectedCash - s2_system_opening_cash)}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="alert alert-primary mb-0">
                                <div class="row align-items-center">

                                    <div class="col-md-4">
                                        <strong>Opening Balance Total</strong><br>
                                        <span class="h5">
                                            ${formatMoney(total_system_opening_cash)}
                                        </span>
                                    </div>

                                    <div class="col-md-4">
                                        <strong>Expected Current Balance Total</strong><br>
                                        <span class="h5 text-primary">
                                            ${formatMoney(total_expectedCash)}
                                        </span>
                                    </div>

                                    <!-- ⭐ FINAL HIGHLIGHT -->
                                    <div class="col-md-4">
                                        <div class="p-3 rounded border
                                            ${(total_expectedCash - total_system_opening_cash) >= 0
                                                ? 'bg-success-light border-success'
                                                : 'bg-danger-light border-danger'}">

                                            <strong class="d-block">Net Change (FINAL)</strong>

                                            <span class="display-6 font-weight-bold
                                                ${(total_expectedCash - total_system_opening_cash) >= 0
                                                    ? 'text-success'
                                                    : 'text-danger'}">

                                                <i class="fas
                                                    ${(total_expectedCash - total_system_opening_cash) >= 0
                                                        ? 'fa-arrow-up'
                                                        : 'fa-arrow-down'} mr-2"></i>

                                                ${(total_expectedCash - total_system_opening_cash) >= 0 ? '+' : ''}
                                                ${formatMoney(total_expectedCash - total_system_opening_cash)}
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    ${seriesBreakdown ? `
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2"><i class="fas fa-chart-pie"></i> Series Breakdown (For Reference)</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th rowspan="2">Series</th>
                                            <th colspan="2" class="text-center">Transaction Ledger</th>
                                            <th colspan="2" class="text-center">Cash Movement</th>
                                            <th colspan="2" class="text-center">Total</th>
                                            <th rowspan="2" class="text-right">Net</th>
                                        </tr>
                                        <tr>
                                            <th class="text-right">Cash In</th>
                                            <th class="text-right">Cash Out</th>
                                            <th class="text-right">Cash In</th>
                                            <th class="text-right">Cash Out</th>
                                            <th class="text-right">Cash In</th>
                                            <th class="text-right">Cash Out</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Series 1</strong></td>
                                            <td class="text-right">${formatMoney(seriesBreakdown.series_1?.transaction_ledger_cash_in || 0)}</td>
                                            <td class="text-right">${formatMoney(seriesBreakdown.series_1?.transaction_ledger_cash_out || 0)}</td>
                                            <td class="text-right">${formatMoney(seriesBreakdown.series_1?.cash_movement_cash_in || 0)}</td>
                                            <td class="text-right">${formatMoney(seriesBreakdown.series_1?.cash_movement_cash_out || 0)}</td>
                                            <td class="text-right"><strong>${formatMoney(seriesBreakdown.series_1?.total_cash_in || 0)}</strong></td>
                                            <td class="text-right"><strong>${formatMoney(seriesBreakdown.series_1?.total_cash_out || 0)}</strong></td>
                                            <td class="text-right ${(seriesBreakdown.series_1?.net || 0) >= 0 ? 'text-success' : 'text-danger'}">
                                                <strong>${formatMoney(seriesBreakdown.series_1?.net || 0)}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Series 2</strong></td>
                                            <td class="text-right">${formatMoney(seriesBreakdown.series_2?.transaction_ledger_cash_in || 0)}</td>
                                            <td class="text-right">${formatMoney(seriesBreakdown.series_2?.transaction_ledger_cash_out || 0)}</td>
                                            <td class="text-right">${formatMoney(seriesBreakdown.series_2?.cash_movement_cash_in || 0)}</td>
                                            <td class="text-right">${formatMoney(seriesBreakdown.series_2?.cash_movement_cash_out || 0)}</td>
                                            <td class="text-right"><strong>${formatMoney(seriesBreakdown.series_2?.total_cash_in || 0)}</strong></td>
                                            <td class="text-right"><strong>${formatMoney(seriesBreakdown.series_2?.total_cash_out || 0)}</strong></td>
                                            <td class="text-right ${(seriesBreakdown.series_2?.net || 0) >= 0 ? 'text-success' : 'text-danger'}">
                                                <strong>${formatMoney(seriesBreakdown.series_2?.net || 0)}</strong>
                                            </td>
                                        </tr>
                                        <tr class="table-primary">
                                            <td><strong>Total (Series 1 + Series 2)</strong></td>
                                            <td class="text-right"><strong>${formatMoney(seriesBreakdown.total?.transaction_ledger_cash_in || 0)}</strong></td>
                                            <td class="text-right"><strong>${formatMoney(seriesBreakdown.total?.transaction_ledger_cash_out || 0)}</strong></td>
                                            <td class="text-right"><strong>${formatMoney(seriesBreakdown.total?.cash_movement_cash_in || 0)}</strong></td>
                                            <td class="text-right"><strong>${formatMoney(seriesBreakdown.total?.cash_movement_cash_out || 0)}</strong></td>
                                            <td class="text-right"><strong>${formatMoney(seriesBreakdown.total?.total_cash_in || 0)}</strong></td>
                                            <td class="text-right"><strong>${formatMoney(seriesBreakdown.total?.total_cash_out || 0)}</strong></td>
                                            <td class="text-right ${(seriesBreakdown.total?.net || 0) >= 0 ? 'text-success' : 'text-danger'}">
                                                <strong>${formatMoney(seriesBreakdown.total?.net || 0)}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    ` : ''}
                    </div>
                </div>
            </div>
        `;
        
        $('#realTimeCashProgressSection').html(cashProgressHtml);
    }

    // Clear interval when modal is hidden
    $('#cashierShiftModal').on('hidden.bs.modal', function () {
        if (cashProgressInterval) {
            clearInterval(cashProgressInterval);
            cashProgressInterval = null;
        }
        currentShiftId = null;
    });

    //series secret code to unlock series 2
    /* ---------- LAYOUT CONTROL ---------- */
    function lockSeries() {
        seriesUnlocked = false;

        // shift opening model
        // Hide Series 2
        $('#opening_cash_series_2_container').addClass('d-none');
        $('#opening_cash_series_2_container2').addClass('d-none');
        $('#opening_cash_series_2_container3').addClass('d-none');
        $('#opening_cash_series_2_container4').addClass('d-none');
        $('#opening_cash_series_2_container5').addClass('d-none');
        $('#opening_balance_cash_container').addClass('d-none');
        $('#total_opening_balance_cash_container').addClass('d-none');
        $('#opening_balance_manual_cash_container').addClass('d-none');
        $('#opening_balance_manual_cash_container2').addClass('d-none');
        $('#opening_balance_manual_cash_container3').addClass('d-none');
        $('#previous_manual_closing_cash_container').addClass('d-none');
        $('#difference_between_previous_manual_closing_cash_and_opening_cash_container').addClass('d-none');
        $('#previous_shift_cash_2').addClass('d-none');
        $('#previous_shift_cash_total').addClass('d-none');

        // Expand Series 1
        $('#opening_cash_series_1_container')
            .removeClass('col-md-6')
            .addClass('col-md-12');

        // shift closing model
        $('#closing_cash_series_2_container').addClass('d-none');
        $('#closing_cash_series_2_container2').addClass('d-none');
        $('#closing_cash_series_2_container3').addClass('d-none');
        $('#closing_manual_cash_container').addClass('d-none');
        $('#closing_manual_cash_container2').addClass('d-none');
        $('#total_closing_balance_cash_container').addClass('d-none');

        // Hide Series 2 cash progress section
        $('#series2_cash_progress_section').addClass('d-none');
        $('#show_safe_cash_section').removeClass('d-none');
        $('#hide_safe_cash_section').addClass('d-none');
    }

    function unlockSeries() {
        seriesUnlocked = true;

        // Show Series 2
        $('#opening_cash_series_2_container').removeClass('d-none');
        $('#opening_cash_series_2_container2').removeClass('d-none');
        $('#opening_cash_series_2_container3').removeClass('d-none');
        $('#opening_cash_series_2_container4').removeClass('d-none');
        $('#opening_cash_series_2_container5').removeClass('d-none');
        $('#opening_balance_cash_container').removeClass('d-none');
        $('#total_opening_balance_cash_container').removeClass('d-none');
        $('#opening_balance_manual_cash_container').removeClass('d-none');
        $('#opening_balance_manual_cash_container2').removeClass('d-none');
        $('#opening_balance_manual_cash_container3').removeClass('d-none');
        $('#previous_manual_closing_cash_container').removeClass('d-none');
        $('#difference_between_previous_manual_closing_cash_and_opening_cash_container').removeClass('d-none');
        $('#previous_shift_cash_2').removeClass('d-none');
        $('#previous_shift_cash_total').removeClass('d-none');

        // Resize both columns
        $('#opening_cash_series_1_container')
            .removeClass('col-md-12')
            .addClass('col-md-6');

        // shift closing model
        $('#closing_cash_series_2_container').removeClass('d-none');
        $('#closing_cash_series_2_container2').removeClass('d-none');
        $('#closing_cash_series_2_container3').removeClass('d-none');
        $('#closing_manual_cash_container').removeClass('d-none');
        $('#closing_manual_cash_container2').removeClass('d-none');
        $('#total_closing_balance_cash_container').removeClass('d-none');

        // Show Series 2 cash progress section
        $('#series2_cash_progress_section').removeClass('d-none');
        $('#show_safe_cash_section').addClass('d-none');
        $('#hide_safe_cash_section').removeClass('d-none');

    }

    /* ---------- KEYBOARD LISTENER ---------- */
    $(document).on('keydown', function (e) {
        // Ignore typing in inputs
        if ($(e.target).is('input, textarea, select')) return;

        switch (e.key) {
            case 'PageUp':   // Show Series 2
                unlockSeries();
                break;
            case 'PageDown': // Hide Series 2
                lockSeries();
                break;
        }
    });

    /* ---------- MODAL EVENTS ---------- */
    $('#startShiftModal').on('hidden.bs.modal', function () {
        lockSeries();
    });

    $('#opening_manual_cash_required').on('change', function() {
        if($(this).is(':checked')) {
            $('#opening_balance_manual_cash').prop('required', false).val($('#previous_manual_closing_cash').val());
            calculateDifference();
        } else {
            $('#opening_balance_manual_cash').prop('required', true).val('');
            calculateDifference();
        }
    });

</script>
<?php include APPPATH . "views/include/footer.php"; ?>

