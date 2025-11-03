<?php include "include/header.php"; ?>
<?php include "include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include "include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <!-- Page Header -->
            <div class="page-header bg-white shadow-sm border-bottom">
                <div class="container-fluid py-3 d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">
                        <i class="fa fa-users mr-2 text-primary"></i>Debtor List
                    </h1>
                    <button class="btn btn-primary" id="addDebtorBtn"><i class="fa fa-plus"></i> Add Debtor</button>
                </div>
            </div>

            <!-- Debtor Table -->
            <div class="container-fluid mt-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                         <div class="scrollbar pb-3" id="style-2">
                            <table id="debtorTable" class="table table-bordered w-100" style="white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Job No</th>
                                        <th>Sale Person</th>
                                        <th>Customer Name</th>
                                        <th>Phone No</th>
                                        <th>Vehicle No</th>
                                        <th>Vehicle Type</th>
                                        <th class="text-right">Inv Amount</th>
                                        <th class="text-right">Advance Amount</th>
                                        <th class="text-right">Balance Amount</th>
                                        <th>Days</th>
                                        <th>Approved By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Credit Settlement Table -->
            <div class="page-header bg-white shadow-sm border-bottom mt-4">
                <div class="container-fluid py-3">
                    <h1 class="mb-0"><i class="fa fa-credit-card mr-2 text-primary"></i> Credit Settlement List</h1>
                </div>
            </div>
            <div class="container-fluid mt-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="scrollbar pb-3" id="style-2">
                            <table id="creditTable" class="table table-bordered w-100" style="white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Credited Date</th>
                                        <th>Job No</th>
                                        <th>Sale Person</th>
                                        <th>Customer Name</th>
                                        <th>Phone No</th>
                                        <th>Vehicle No</th>
                                        <th>Vehicle Type</th>
                                        <th class="text-right">Inv Amount</th>
                                        <th class="text-right">Advance Amount</th>
                                        <th class="text-right">Balance Amount</th>
                                        <th>Settlement Date</th>
                                        <th>Payment Details</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include "include/footerbar.php"; ?>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="debtorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="debtorForm">
                <div class="modal-header">
                    <h5 class="modal-title">Debtor Form</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="debtor_id" name="debtor_id">
                    <input type="hidden" id="recordOption" name="recordOption" value="1">
                    <div class="row">
                        <?php
                        $fields = [
                            ['Date', 'date', 'date', true],
                            ['Job No', 'job_no', 'text', true],
                            ['Sale Person', 'sale_person', 'text', false],
                            ['Customer Name', 'customer_name', 'text', true],
                            ['Phone No', 'phone_no', 'text', false],
                            ['Vehicle No', 'vehicle_no', 'text', false],
                            ['Vehicle Type', 'vehicle_type', 'text', false],
                            ['Inv Amount', 'inv_amount', 'number', false],
                            ['Advance Amount', 'advance_amount', 'number', false],
                            ['Balance Amount', 'balance_amount', 'number', false],
                            ['Number Of Days', 'number_of_days', 'number', false],
                        ];
                        foreach ($fields as [$label, $id, $type, $req]) {
                            $readonly = ($id === 'balance_amount') ? 'readonly' : '';
                            echo "<div class='col-md-4 mb-2'><label>$label</label><input type='$type' step='0.01' class='form-control' id='$id' name='$id' $readonly ".($req?'required':'')."></div>";
                        }
                        ?>
                        <div class='col-md-4 mb-2'>
                            <label>Approved By</label>
                            <select class='form-control' id='approved_by' name='approved_by'>
                                <option value=''>Select Approver</option>
                                <option value='MD'>MD</option>
                                <option value='Mr.Manusha'>Mr. Manusha</option>
                                <option value='Miss.Madhu'>Miss. Madhu</option>
                                <option value='Mr.Heshan'>Mr. Heshan</option>
                                <option value='Mr.Pathum'>Mr. Pathum</option>
                                <option value='Mr.Madhuranga'>Mr. Madhuranga</option>
                                <option value='Other'>Other</option>
                            </select>
                            <input type="text" id="approved_by_other" name="approved_by_other" class="form-control mt-2" placeholder="Enter approver name" style="display:none;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Transfer Modal -->
<div class="modal fade" id="transferModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="transferForm">
                <div class="modal-header">
                    <h5 class="modal-title">Transfer to Credit Settlement</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="transfer_debtor_id" name="debtor_id">
                    <div class="mb-3">
                        <label>Settlement Date</label>
                        <input type="date" class="form-control" name="settlement_date" required>
                    </div>
                    <div class="mb-3">
                        <label>Payment Details</label>
                        <input type="text" class="form-control" name="payment_details" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Transfer</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "include/footerscripts.php"; ?>

<script>
$(document).ready(function() {
    // Debtor Table
    var table = $('#debtorTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: apiBaseUrl + '/v1/cashier_debitor',
            type: 'GET',
            headers: { 'Authorization': 'Bearer ' + api_token }
        },
        columns: [
            { data: 'id' },
            { data: 'date' },
            { data: 'job_no' },
            { data: 'sale_person' },
            { data: 'customer_name' },
            { data: 'phone_no' },
            { data: 'vehicle_no' },
            { data: 'vehicle_type' },
            {
                data: 'inv_amount',
                className: 'text-right',
                render: function(data, type, row) {
                    if (data === null || data === '') return '0.00';
                    return parseFloat(data).toLocaleString(undefined, { minimumFractionDigits: 2 });
                }
            },
            {
                data: 'advance_amount',
                className: 'text-right',
                render: function(data, type, row) {
                    if (data === null || data === '') return '0.00';
                    return parseFloat(data).toLocaleString(undefined, { minimumFractionDigits: 2 });
                }
            },
            {
                data: 'balance_amount',
                className: 'text-right',
                render: function(data, type, row) {
                    if (data === null || data === '') return '0.00';
                    return parseFloat(data).toLocaleString(undefined, { minimumFractionDigits: 2 });
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    const today = new Date();
                    const recordDate = new Date(row.date);
                    const diffDays = Math.floor((today - recordDate) / (1000 * 60 * 60 * 24));
                    return diffDays >= 0 ? diffDays : 0;
                }
            },
            { data: 'approved_by' },
            {
                data: 'id',
                render: function(data) {
                    return `
                        <button class="btn btn-sm btn-success transferBtn" data-id="${data}" title="Transfer">
                            <i class="fas fa-exchange-alt"></i>
                        </button>
                        <button class="btn btn-sm btn-primary editBtn" data-id="${data}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="${data}" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `;
                }

            }
        ],
        order: [[0, 'desc']]
    });

    // Credit Table
    var creditTable = $('#creditTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: apiBaseUrl + '/v1/credit_settlement_list',
            type: 'GET',
            headers: { 'Authorization': 'Bearer ' + api_token }
        },
        columns: [
            { data: 'id' },
            { data: 'credited_date' },
            { data: 'job_no' },
            { data: 'sale_person' },
            { data: 'customer_name' },
            { data: 'phone_no' },
            { data: 'vehicle_no' },
            { data: 'vehicle_type' },
            {
                data: 'inv_amount',
                className: 'text-right',
                render: function(data, type, row) {
                    if (data === null || data === '') return '0.00';
                    return parseFloat(data).toLocaleString(undefined, { minimumFractionDigits: 2 });
                }
            },
            {
                data: 'advance_amount',
                className: 'text-right',
                render: function(data, type, row) {
                    if (data === null || data === '') return '0.00';
                    return parseFloat(data).toLocaleString(undefined, { minimumFractionDigits: 2 });
                }
            },
            {
                data: 'balance_amount',
                className: 'text-right',
                render: function(data, type, row) {
                    if (data === null || data === '') return '0.00';
                    return parseFloat(data).toLocaleString(undefined, { minimumFractionDigits: 2 });
                }
            },
            { data: 'settlement_date' },
            { data: 'payment_details' }
        ]
    });

    $('#approved_by').on('change', function() {
        if ($(this).val() === 'Other') {
            $('#approved_by_other').show().attr('required', true);
        } else {
            $('#approved_by_other').hide().val('').removeAttr('required');
        }
    });

    $('#inv_amount, #advance_amount').on('keyup change', function() {
        let inv = parseFloat($('#inv_amount').val()) || 0;
        let adv = parseFloat($('#advance_amount').val()) || 0;
        let balance = inv - adv;
        if (balance < 0) balance = 0;
        $('#balance_amount').val(balance.toFixed(2));
    });

    // Add Debtor
    $('#addDebtorBtn').click(function() {
        $('#debtorForm')[0].reset();
        $('#debtor_id').val('');
        $('#debtorModal').modal('show');
    });

    // Save/Add Debtor
    $('#debtorForm').submit(function(e) {
        e.preventDefault();

        if ($('#approved_by').val() === 'Other') {
            var otherValue = $('#approved_by_other').val();
            $('#approved_by').val(otherValue); 
        }

        var id = $('#debtor_id').val();
        var method = id ? 'PUT' : 'POST';
        var url = '<?= base_url("CashierDebitor/debtorInsertUpdate") ?>';
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            headers: { 'Authorization': 'Bearer ' + api_token },
            data: $(this).serialize(),
            success: function(res) {
                if(res.status){
                    success_toastify(res.message);
                    table.ajax.reload();
                    $('#debtorModal').modal('hide');
                } else {
                    error_toastify(res.message);
                }
            },
            error: () => alert('Save failed!')
        });
    });

    // Edit
    $('#debtorTable').on('click', '.editBtn', function() {
        const id = $(this).data('id');
        $('#recordOption').val('2');
        $('#debtor_id').val(id);
        $.ajax({
            url: '<?= base_url("CashierDebitor/debtorEdit") ?>/'+id,
            type: 'GET',
            dataType: 'json',
            headers: { 'Authorization': 'Bearer ' + api_token },
            success: function(result) {
                $('#date').val(result.data.date);
                $('#job_no').val(result.data.job_no);
                $('#sale_person').val(result.data.sale_person);
                $('#customer_name').val(result.data.customer_name);
                $('#phone_no').val(result.data.phone_no);
                $('#vehicle_no').val(result.data.vehicle_no);
                $('#vehicle_type').val(result.data.vehicle_type);
                $('#inv_amount').val(result.data.inv_amount);
                $('#advance_amount').val(result.data.advance_amount);
                $('#balance_amount').val(result.data.balance_amount);
                $('#number_of_days').val(result.data.number_of_days);
                $('#approved_by').val(result.data.approved_by);

                $('#debtorModal').modal('show');
            }
        });
    });

    // Delete
    $('#debtorTable').on('click', '.deleteBtn', function() {
        if (confirm('Are you sure to delete this debtor?')) {
            const id = $(this).data('id');
            $.ajax({
                url: '<?= base_url("CashierDebitor/debtorDelete") ?>/'+id,
                type: 'DELETE',
                dataType: 'json',
                headers: { 'Authorization': 'Bearer ' + api_token },
                success: function(res) {
                    if(res.status){
                        success_toastify(res.message);
                        table.ajax.reload();
                    } else {
                        error_toastify(res.message);
                    }
                }
            });
        }
    });

    // Transfer to Credit
    $('#debtorTable').on('click', '.transferBtn', function() {
        $('#transfer_debtor_id').val($(this).data('id'));
        $('#transferModal').modal('show');
    });

    $('#transferForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= base_url("CashierDebitor/debtorTransferToCredit") ?>',
            type: 'POST',
            dataType: 'json',
            headers: { 'Authorization': 'Bearer ' + api_token },
            data: $(this).serialize(),
            success: function(res) {
                if(res.status){
                    success_toastify(res.message);
                    $('#transferModal').modal('hide');
                    table.ajax.reload();
                    creditTable.ajax.reload();
                } else {
                    error_toastify(res.message);
                }
            },
            error: () => alert('Transfer failed!')
        });
    });
});
</script>

<?php include "include/footer.php"; ?>
