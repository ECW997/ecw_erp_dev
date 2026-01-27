<?php include "include/header.php"; ?>
<?php include "include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include "include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-file-invoice-dollar mr-2"></i>IOU Settlements</h1>
                </div>
            </div>
            <div class="container-fluid mt-2">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-exclamation-triangle mr-2"></i>Outstanding IOUs</h5>
                    </div>
                    <div class="card-body">
                        <table id="outstandingIousTable" class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Shift ID</th>
                                    <th>Payee</th>
                                    <th>Amount</th>
                                    <th>Payment Type</th>
                                    <th>Created At</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Settlements List</h5>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addSettlementModal">
                            <i class="fas fa-plus mr-2"></i>Add Settlement
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="settlementsTable" class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>IOU Movement ID</th>
                                    <th>Settlement Type</th>
                                    <th>Settlement Amount</th>
                                    <th>Settlement Date</th>
                                    <th>Reference ID</th>
                                    <th>Remarks</th>
                                    <th>Settled By</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <!-- Add Settlement Modal -->
        <div class="modal fade" id="addSettlementModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form id="addSettlementForm">
                        <div class="modal-header">
                            <h5 class="modal-title">Add IOU Settlement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="cash_movement_id">IOU Movement <span class="text-danger">*</span></label>
                                <select class="form-control" id="cash_movement_id" name="cash_movement_id" required>
                                    <option value="">Select IOU Movement</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="settlement_type">Settlement Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="settlement_type" name="settlement_type" required>
                                    <option value="">Select Type</option>
                                    <option value="cash_return">Cash Return</option>
                                    <option value="expense_claim">Expense Claim</option>
                                    <option value="payroll_deduction">Payroll Deduction</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="settlement_amount">Settlement Amount <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control price-input" id="settlement_amount" name="settlement_amount" required min="0">
                            </div>
                            <div class="form-group">
                                <label for="settlement_date">Settlement Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="settlement_date" name="settlement_date" required>
                            </div>
                            <div class="form-group">
                                <label for="reference_id">Reference ID</label>
                                <input type="number" class="form-control" id="reference_id" name="reference_id">
                            </div>
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Save Settlement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Settlement Modal -->
        <div class="modal fade" id="editSettlementModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form id="editSettlementForm">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Settlement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="editSettlementContent">
                            <!-- Dynamic content -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Settlement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
$(document).ready(function() {
    $('#settlement_date').val(new Date().toISOString().split('T')[0]);
    loadSettlements();
    loadOutstandingIous();
    loadIouMovements();

    $('#addSettlementForm').on('submit', function(e) {
        e.preventDefault();
        let formData = {
            cash_movement_id: $('#cash_movement_id').val(),
            settlement_type: $('#settlement_type').val(),
            settlement_amount: $('#settlement_amount').val(),
            settlement_date: $('#settlement_date').val(),
            reference_id: $('#reference_id').val() || null,
            remarks: $('#remarks').val()
        };

        $.ajax({
            url: '<?= base_url("Cashier/IouSettlement/createSettlement") ?>',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(res) {
                if(res.status) {
                    success_toastify(res.message);
                    $('#addSettlementModal').modal('hide');
                    $('#addSettlementForm')[0].reset();
                    $('#settlement_date').val(new Date().toISOString().split('T')[0]);
                    loadSettlements();
                    loadOutstandingIous();
                } else {
                    error_toastify(res.message || 'Failed to create settlement');
                }
            },
            error: function() {
                error_toastify('Server error. Please try again.');
            }
        });
    });
});

function loadSettlements() {
    $.ajax({
        url: '<?= base_url("Cashier/IouSettlement/getSettlements") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if(res.status && res.data) {
                initializeSettlementsTable(res.data);
            }
        }
    });
}

function loadOutstandingIous() {
    $.ajax({
        url: '<?= base_url("Cashier/IouSettlement/getOutstandingIous") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if(res.status && res.data) {
                initializeOutstandingTable(res.data);
            }
        }
    });
}

function loadIouMovements() {
    $.ajax({
        url: '<?= base_url("Cashier/CashMovement/getCashMovements") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if(res.status && res.data) {
                $('#cash_movement_id').html('<option value="">Select IOU Movement</option>');
                res.data.forEach(function(movement) {
                    if(movement.source === 'iou' && movement.status === 'pending') {
                        let option = `<option value="${movement.id}" data-amount="${movement.amount}">Shift #${movement.cashier_shift_id} - ${movement.payee_name} - ${movement.amount}</option>`;
                        $('#cash_movement_id').append(option);
                    }
                });
            }
        }
    });
}

$('#cash_movement_id').on('change', function() {
    let selectedOption = $(this).find('option:selected');
    let amount = selectedOption.data('amount');
    if(amount) {
        $('#settlement_amount').val(amount);
    }
});

function initializeSettlementsTable(data) {
    if ($.fn.DataTable.isDataTable('#settlementsTable')) {
        $('#settlementsTable').DataTable().destroy();
    }

    $('#settlementsTable').DataTable({
        data: data,
        destroy: true,
        order: [[7, 'desc']],
        columns: [
            { 
                data: 'cash_movement_id', 
                title: 'IOU Movement ID',
                className: 'text-center'
            },
            { 
                data: 'settlement_type', 
                title: 'Settlement Type',
                className: 'text-center text-capitalize',
                render: function(d) {
                    return d.replace('_', ' ');
                }
            },
            { 
                data: 'settlement_amount', 
                title: 'Settlement Amount',
                className: 'text-right',
                render: function(d) {
                    return Number(d ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            { 
                data: 'settlement_date', 
                title: 'Settlement Date',
                className: 'text-center'
            },
            { 
                data: 'reference_id', 
                title: 'Reference ID',
                className: 'text-center',
                defaultContent: '-'
            },
            { 
                data: 'remarks', 
                title: 'Remarks',
                defaultContent: '-'
            },
            { 
                data: 'settled_by_user.name', 
                title: 'Settled By',
                defaultContent: '-'
            },
            { 
                data: 'created_at', 
                title: 'Created At',
                className: 'text-center'
            },
            { 
                data: null, 
                title: 'Action',
                className: 'text-center',
                render: function(row) {
                    let encoded = encodeURIComponent(JSON.stringify(row));
                    return `
                        <button class="btn btn-sm btn-primary" onclick="editSettlement('${encoded}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteSettlement(${row.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                }
            }
        ]
    });
}

function initializeOutstandingTable(data) {
    if ($.fn.DataTable.isDataTable('#outstandingIousTable')) {
        $('#outstandingIousTable').DataTable().destroy();
    }

    $('#outstandingIousTable').DataTable({
        data: data,
        destroy: true,
        order: [[4, 'desc']],
        columns: [
            { 
                data: 'cashier_shift_id', 
                title: 'Shift ID',
                className: 'text-center'
            },
            { 
                data: 'payee_name', 
                title: 'Payee',
                defaultContent: '-'
            },
            { 
                data: 'amount', 
                title: 'Amount',
                className: 'text-right',
                render: function(d) {
                    return Number(d ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            { 
                data: 'payment_type', 
                title: 'Payment Type',
                className: 'text-center text-capitalize'
            },
            { 
                data: 'created_at', 
                title: 'Created At',
                className: 'text-center'
            },
            { 
                data: 'remarks', 
                title: 'Remarks',
                defaultContent: '-'
            },
            { 
                data: null, 
                title: 'Action',
                className: 'text-center',
                render: function(row) {
                    return `
                        <button class="btn btn-sm btn-success" onclick="settleIou(${row.id})">
                            <i class="fas fa-check mr-1"></i>Settle
                        </button>
                    `;
                }
            }
        ]
    });
}

function editSettlement(encodedRow) {
    let row = JSON.parse(decodeURIComponent(encodedRow));
    let html = `
        <input type="hidden" id="edit_settlement_id" value="${row.id}">
        <div class="form-group">
            <label>Settlement Type</label>
            <select class="form-control" id="edit_settlement_type">
                <option value="cash_return" ${row.settlement_type === 'cash_return' ? 'selected' : ''}>Cash Return</option>
                <option value="expense_claim" ${row.settlement_type === 'expense_claim' ? 'selected' : ''}>Expense Claim</option>
                <option value="payroll_deduction" ${row.settlement_type === 'payroll_deduction' ? 'selected' : ''}>Payroll Deduction</option>
            </select>
        </div>
        <div class="form-group">
            <label>Settlement Amount</label>
            <input type="number" step="0.01" class="form-control" id="edit_settlement_amount" value="${row.settlement_amount}">
        </div>
        <div class="form-group">
            <label>Settlement Date</label>
            <input type="date" class="form-control" id="edit_settlement_date" value="${row.settlement_date}">
        </div>
        <div class="form-group">
            <label>Reference ID</label>
            <input type="number" class="form-control" id="edit_reference_id" value="${row.reference_id || ''}">
        </div>
        <div class="form-group">
            <label>Remarks</label>
            <textarea class="form-control" id="edit_remarks" rows="3">${row.remarks || ''}</textarea>
        </div>
    `;
    $('#editSettlementContent').html(html);
    $('#editSettlementModal').modal('show');
}

$('#editSettlementForm').on('submit', function(e) {
    e.preventDefault();
    let id = $('#edit_settlement_id').val();
    let formData = {
        settlement_type: $('#edit_settlement_type').val(),
        settlement_amount: $('#edit_settlement_amount').val(),
        settlement_date: $('#edit_settlement_date').val(),
        reference_id: $('#edit_reference_id').val() || null,
        remarks: $('#edit_remarks').val()
    };

    $.ajax({
        url: `<?= base_url("Cashier/IouSettlement/updateSettlement") ?>/${id}`,
        type: 'POST',
        dataType: 'json',
        data: formData,
        success: function(res) {
            if(res.status) {
                success_toastify(res.message);
                $('#editSettlementModal').modal('hide');
                loadSettlements();
            } else {
                error_toastify(res.message || 'Failed to update settlement');
            }
        }
    });
});

function deleteSettlement(id) {
    if(confirm('Are you sure you want to delete this settlement?')) {
        $.ajax({
            url: `<?= base_url("Cashier/IouSettlement/deleteSettlement") ?>/${id}`,
            type: 'POST',
            dataType: 'json',
            success: function(res) {
                if(res.status) {
                    success_toastify(res.message);
                    loadSettlements();
                    loadOutstandingIous();
                } else {
                    error_toastify(res.message || 'Failed to delete settlement');
                }
            }
        });
    }
}

function settleIou(movementId) {
    $('#cash_movement_id').val(movementId).trigger('change');
    $('#addSettlementModal').modal('show');
}
</script>
<?php include "include/footer.php"; ?>

