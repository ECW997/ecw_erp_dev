<style>

.accordion-button {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  font-weight: 500;
  background: transparent;
  border: none;
  padding: 0.75rem 1rem;
  text-align: left;
  transition: background 0.2s ease-in-out;
}

.accordion-button:focus {
  outline: none;
  box-shadow: none;
}

.accordion-button.collapsed {
  opacity: 0.85;
}

.accordion-body {
  border-top: 1px solid #dee2e6;
  font-size: 0.95rem;
}


.accordion-button i {
  margin-right: 8px;
}

.table-responsive {
    max-height: 300px; 
    overflow-y: auto;  
}

</style>

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
<?php include "open_approve_error_modal.php";  ?>
<script>
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
            url: '<?php echo base_url(); ?>Cashier/closeCashierShift',
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

    if (confirm("Are you sure you want to updat the open balances?")) {
        $btn.prop('disabled', true).text('Updating...');

        $('#updateShiftForm .price-input').each(function() {
            $(this).val($(this).val().replace(/,/g, "").trim());
        });

        $.ajax({
            url: '<?php echo base_url(); ?>Cashier/updateShiftOpeningBalances',
            type: 'POST',
            data: $('#updateShiftForm').serialize(),
            dataType: 'json',
            success: function(result) {
                if(result.status) {
                    success_toastify(result.message);

                    $('#cashierShiftContent').html('');
                    $('#cashierShiftFooter').html('');
                    $('#cashierShiftContent').html('<div class="text-center"><div class="spinner-grow text-primary" role="status"></div></div>');
                    getCashierShiftDetails();
                    $btn.prop('disabled', false).text('Update Balances'); 
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

function getCashierShiftDetails(){
    $.ajax({
        url: '<?php echo base_url(); ?>Cashier/checkCashierShift',
        type: 'GET',
        dataType: 'json',
        success: function(res){
            let modalBody = '';
            let modalFooter = '';

            if(res.shift) {
                let shift_data = res.shift;
                let log = res.logs;

                if(shift_data.opening_approved_at == 'null'){ //uncheck condition...if want to check using null without qoutation
                     $('#financeErrorModal').modal('show');
                     $('#cashierShiftModal').modal('hide');
                }else{
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

                        <hr>

                        <div class="accordion shadow rounded mt-3" id="accordionSummary">
                            <div class="card accordion-item mb-2 border-0">
                                <div class="card-header accordion-header bg-gray-600 text-white rounded" style="padding:0" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn accordion-button text-white" type="button"
                                                data-toggle="collapse" data-target="#collapseOne"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                aria-expanded="false" aria-controls="collapseOne">
                                            <i class="fas fa-list mr-2"></i> Log Summaries
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse accordion-collapse"
                                    aria-labelledby="headingOne"
                                    data-parent="#accordionSummary"
                                    data-bs-parent="#accordionSummary">
                                    <div class="card-body accordion-body bg-light">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-sm small" style="white-space: nowrap;" id="dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Open at </th>
                                                        <th>Opening Balance Cash</th>
                                                        <th>Opening Balance Slips</th>
                                                        <th>Opening Balance Cheques</th>
                                                        <th>Closed at </th>
                                                        <th>Closing Balance Cash</th>
                                                        <th>Closing Balance Slips</th>
                                                        <th>Closing Balance Cheques</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${log.map(item => `
                                                        <tr>
                                                            <td>${item.opened_at}</td>
                                                            <td class="text-right">${Number(item.opening_balance_cash).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                                            <td class="text-right">${Number(item.opening_balance_slips).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                                            <td class="text-right">${Number(item.opening_balance_cheques).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                                            <td class="${!item.closed_at ? 'text-danger' : ''}">${item.closed_at ? item.closed_at : 'Not Closed'}</td>
                                                            <td class="text-right">${Number(item.closing_balance_cash).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                                            <td class="text-right">${Number(item.closing_balance_slips).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                                            <td class="text-right">${Number(item.closing_balance_cheques).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                                        </tr>
                                                    `).join('')}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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
                // modalFooter = `
                //     <button type="submit" form="startShiftForm" class="btn btn-primary">
                //         <i class="fas fa-key mr-2"></i> Start Shift
                //     </button>
                // `;
            }

            $('#cashierShiftContent').html(modalBody);
            $('#cashierShiftFooter').html(modalFooter);

            let $tableRows = $('#dataTable tbody tr');
            if($tableRows.length >= 10) {
                let $container = $('#dataTable').closest('.table-responsive');
                $container.animate({
                    scrollTop: $tableRows.eq(9).position().top + $container.scrollTop()
                }, 500);

                $tableRows.eq(9).css('background-color', '#fffae6');
            }
        }
    });
}
</script>
