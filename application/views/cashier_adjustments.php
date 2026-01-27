<?php include "include/header.php"; ?>
<?php include "include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include "include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-adjust mr-2"></i>Cashier Shift Adjustments</h1>
                </div>
            </div>
            <div class="container-fluid mt-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Adjustments List</h5>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addAdjustmentModal">
                            <i class="fas fa-plus mr-2"></i>Add Adjustment
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="adjustmentsTable" class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Shift ID</th>
                                    <th>Adjustment Type</th>
                                    <th>Amount</th>
                                    <th>Remarks</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <!-- Add Adjustment Modal -->
        <div class="modal fade" id="addAdjustmentModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="addAdjustmentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="addAdjustmentForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addAdjustmentModalLabel">Add Shift Adjustment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="cashier_shift_id">Shift <span class="text-danger">*</span></label>
                                <select class="form-control" id="cashier_shift_id" name="cashier_shift_id" required>
                                    <option value="">Select Shift</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="adjustment_type">Adjustment Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="adjustment_type" name="adjustment_type" required>
                                    <option value="">Select Type</option>
                                    <option value="invoice_void">Invoice Void</option>
                                    <option value="correction">Correction</option>
                                    <option value="manual">Manual</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control price-input" id="amount" name="amount" required min="0">
                            </div>
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveAdjustmentBtn">
                                <i class="fas fa-save mr-2"></i>Save Adjustment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Adjustment Modal -->
        <div class="modal fade" id="editAdjustmentModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="editAdjustmentForm">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Adjustment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="editAdjustmentContent">
                            <!-- Dynamic content -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Adjustment</button>
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
    loadAdjustments();
    loadShifts();

    $('#addAdjustmentForm').on('submit', function(e) {
        e.preventDefault();
        let formData = {
            cashier_shift_id: $('#cashier_shift_id').val(),
            adjustment_type: $('#adjustment_type').val(),
            amount: $('#amount').val(),
            remarks: $('#remarks').val()
        };

        $.ajax({
            url: '<?= base_url("Cashier/Adjustment/create") ?>',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(res) {
                if(res.status) {
                    success_toastify(res.message);
                    $('#addAdjustmentModal').modal('hide');
                    $('#addAdjustmentForm')[0].reset();
                    loadAdjustments();
                } else {
                    error_toastify(res.message || 'Failed to create adjustment');
                }
            },
            error: function() {
                error_toastify('Server error. Please try again.');
            }
        });
    });
});

function loadAdjustments() {
    $.ajax({
        url: '<?= base_url("Cashier/Adjustment") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if(res.status && res.data) {
                initializeTable(res.data);
            }
        }
    });
}

function loadShifts() {
    $.ajax({
        url: '<?= base_url("Cashier/Shift/getAllCashierLog") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if(res.status && res.data) {
                $('#cashier_shift_id').html('<option value="">Select Shift</option>');
                res.data.forEach(function(shift) {
                    let option = `<option value="${shift.id}">Shift #${shift.id} - ${shift.opened_at || ''}</option>`;
                    $('#cashier_shift_id').append(option);
                });
            }
        }
    });
}

function initializeTable(data) {
    if ($.fn.DataTable.isDataTable('#adjustmentsTable')) {
        $('#adjustmentsTable').DataTable().destroy();
    }

    $('#adjustmentsTable').DataTable({
        data: data,
        destroy: true,
        order: [[5, 'desc']],
        columns: [
            { 
                data: 'cashier_shift_id', 
                title: 'Shift ID',
                className: 'text-center'
            },
            { 
                data: 'adjustment_type', 
                title: 'Adjustment Type',
                className: 'text-center text-capitalize',
                render: function(d) {
                    return d.replace('_', ' ');
                }
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
                data: 'remarks', 
                title: 'Remarks',
                defaultContent: '-'
            },
            { 
                data: 'created_by_user.name', 
                title: 'Created By',
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
                        <button class="btn btn-sm btn-primary" onclick="editAdjustment('${encoded}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteAdjustment(${row.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                }
            }
        ]
    });
}

function editAdjustment(encodedRow) {
    let row = JSON.parse(decodeURIComponent(encodedRow));
    let html = `
        <input type="hidden" id="edit_adjustment_id" value="${row.id}">
        <div class="form-group">
            <label>Adjustment Type</label>
            <select class="form-control" id="edit_adjustment_type">
                <option value="invoice_void" ${row.adjustment_type === 'invoice_void' ? 'selected' : ''}>Invoice Void</option>
                <option value="correction" ${row.adjustment_type === 'correction' ? 'selected' : ''}>Correction</option>
                <option value="manual" ${row.adjustment_type === 'manual' ? 'selected' : ''}>Manual</option>
            </select>
        </div>
        <div class="form-group">
            <label>Amount</label>
            <input type="number" step="0.01" class="form-control" id="edit_amount" value="${row.amount}">
        </div>
        <div class="form-group">
            <label>Remarks</label>
            <textarea class="form-control" id="edit_remarks" rows="3">${row.remarks || ''}</textarea>
        </div>
    `;
    $('#editAdjustmentContent').html(html);
    $('#editAdjustmentModal').modal('show');
}

$('#editAdjustmentForm').on('submit', function(e) {
    e.preventDefault();
    let id = $('#edit_adjustment_id').val();
    let formData = {
        adjustment_type: $('#edit_adjustment_type').val(),
        amount: $('#edit_amount').val(),
        remarks: $('#edit_remarks').val()
    };

    $.ajax({
        url: `<?= base_url("Cashier/Adjustment/update") ?>/${id}`,
        type: 'POST',
        dataType: 'json',
        data: formData,
        success: function(res) {
            if(res.status) {
                success_toastify(res.message);
                $('#editAdjustmentModal').modal('hide');
                loadAdjustments();
            } else {
                error_toastify(res.message || 'Failed to update adjustment');
            }
        }
    });
});

function deleteAdjustment(id) {
    if(confirm('Are you sure you want to delete this adjustment?')) {
        $.ajax({
            url: `<?= base_url("Cashier/Adjustment/delete") ?>/${id}`,
            type: 'POST',
            dataType: 'json',
            success: function(res) {
                if(res.status) {
                    success_toastify(res.message);
                    loadAdjustments();
                } else {
                    error_toastify(res.message || 'Failed to delete adjustment');
                }
            }
        });
    }
}
</script>
<?php include "include/footer.php"; ?>

