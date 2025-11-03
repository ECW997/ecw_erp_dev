<?php include "include/header.php"; ?>
<?php include "include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
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
                                    <!-- <?php if ($check_cashier_shift['code'] == 200): ?>
                                        <button class="btn btn-warning ml-3" id="cashierShiftBtn">Cashier Shift Open</button>
                                    <?php elseif ($check_cashier_shift['code'] == 403): ?>
                                        <span class="ml-3 text-white bg-danger p-2 rounded">
                                            <?= $check_cashier_shift['message']; ?>
                                        </span>
                                    <?php endif; ?> -->
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
        <?php include "components/modal/cashier/open_approve_error_modal.php";  ?>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    let checkCashierShift = <?= json_encode($check_cashier_shift) ?>;

    if(checkCashierShift.logs){
        $('#shiftTable').DataTable({
            data: checkCashierShift.logs,
            destroy: true, 
            order: [[0, 'desc']],
            columns: [
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
                            return `<button class="btn btn-success btn-sm" onclick="viewShift();"><i class="fas fa-eye"></i></button>`;
                        } else {
                            return `<span class="text-white bg-danger p-2 rounded" onclick="viewcloseShift('${rowData}');"><i class="fas fa-lock"></i></span>`;
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
            url: '<?php echo base_url() ?>CashierShift/startCashierShift',
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

    $('#cashierShiftBtn').click(function(){
        $('#cashierShiftContent').html('<div class="text-center"><div class="spinner-grow text-primary" role="status"></div></div>');
        $('#cashierShiftFooter').html('');
        $('#cashierShiftModal').modal('show');

        getCashierShiftDetails();
    });

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
                url: '<?php echo base_url(); ?>CashierShift/closeCashierShift',
                type: 'POST',
                data: $('#closeShiftForm').serialize(),
                dataType: 'json',
                success: function(result) {
                    if(result.status) {
                        success_toastify(result.message);
                        $('#cashierShiftModal').modal('hide');
                        window.location.href = '<?php echo base_url("Auth/Dashboard"); ?>';
                    } else {
                        alert('Error: ' + res.message);
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
                url: '<?php echo base_url(); ?>CashierShift/updateShiftOpeningBalances',
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
                        alert('Error: ' + res.message);
                        $btn.prop('disabled', false).text('Update Balances');
                    }
                },
                error: function(xhr) {
                    alert('Error closing shift (Code ' + xhr.status + ')');
                    $btn.prop('disabled', false).text('Update Balances'); 
                }
            });
        }

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

            if (shift_data.opening_approved_at == 'null') { //uncheck condition...if want to check using null without qoutation
                $('#financeErrorModal').modal('show');
                $('#cashierShiftModal').modal('hide');
            } else {
                // $('#cashierShiftModal').modal('show');

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
                                            <tbody>
                        `;

                if (shift_data.opening_approved_at == null) {
                    modalBody += `
                                <tr>
                                    <td><b>Opening Cash</b></td>
                                    <td class="text-right">
                                        <input type="text" class="form-control form-control-sm text-right price-input" 
                                            id="input_opening_balance_cash" name="input_opening_balance_cash"
                                            value="${Number(shift_data.opening_balance_cash ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}" required>
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
                                        <button type="button" class="btn btn-primary btn-sm" id="updateOpeningBalancesBtn">
                                            <i class="fas fa-save mr-2"></i> Update Balances
                                        </button>
                                    </td>
                                </tr>
                            `;
                } else {
                    modalBody += `
                                <tr>
                                    <td><b>Opening Cash</b></td>
                                    <td class="text-right">${Number(shift_data.opening_balance_cash).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                </tr>
                                <tr>
                                    <td><b>Opening Slips</b></td>
                                    <td class="text-right">${Number(shift_data.opening_balance_slips).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                </tr>
                                <tr>
                                    <td><b>Opening Cheques</b></td>
                                    <td class="text-right">${Number(shift_data.opening_balance_cheques).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                </tr>
                            `;
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
                                                    <th class="text-start">Cash</th>
                                                    <td><input type="text" class="form-control form-control-sm text-right price-input" name="cash" placeholder="0.00" required></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-start">Slips</th>
                                                    <td><input type="text" class="form-control form-control-sm text-right price-input" name="slips" placeholder="0.00" required></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-start">Cheques</th>
                                                    <td><input type="text" class="form-control form-control-sm text-right price-input" name="cheques" placeholder="0.00" required></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        `;

                modalFooter = `
                            <button class="btn btn-danger" id="closeShiftBtn">
                                <i class="fas fa-lock mr-2"></i> Close Shift
                            </button>
                        `;
            }

        } else {
            modalBody = $('#startShiftFormContainer').html();
        }

        $('#cashierShiftContent').html(modalBody);
        $('#cashierShiftFooter').html(modalFooter);
    }

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
                                <td><b>Opening Cash</b></td>
                                <td class="text-right">${Number(shift_data.opening_balance_cash ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
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
                                <th class="text-start">Closing Cash</th>
                                <td class="text-right">${Number(shift_data.closing_balance_cash ?? 0).toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})}</td>
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
            </div>
        `;

        let modalFooter = `
            <button class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="fas fa-times"></i> Close
            </button>
        `;

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

    $(document).on("input", ".price-input", function() {
        let value = $(this).val().replace(/,/g, "");
        if (!isNaN(value) && value !== "") {
            let parts = value.split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $(this).val(parts.join("."));
        }
    });
</script>
<?php include "include/footer.php"; ?>
