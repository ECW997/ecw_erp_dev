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
                        <i class="fa fa-users mr-2 text-primary"></i>Debtor List <span class="ml-2 text-danger" id="headerTag"></span>
                    </h1>
                    <button class="btn btn-primary" id="addDebtorBtn"><i class="fa fa-plus"></i> Add Debtor</button>
                </div>
            </div>

            <!-- Debtor Table -->
            <div class="container-fluid mt-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        
                        <div class="col-12 col-md-12 d-flex align-items-center justify-content-end flex-wrap">
                            <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                <label for="sales_agent" class="mb-0 mr-2 " style="white-space: nowrap;">Sales Agent</label>
                                <select id="sales_agent" class="custom-select custom-select-sm"
                                    style="min-width: 130px;">
                                     <option value="">All</option>
                                    <?php if (!empty($sales_agents)) : ?>
                                    <?php foreach ($sales_agents as $agent) : ?>
                                    <option value="<?= $agent['idtbl_sales_person']; ?>">
                                        <?= htmlspecialchars($agent['sales_person_name']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <button class="btn btn-secondary btn-sm" id="filterBtn"
                                style="height: 1.9rem; font-size: 0.85rem;">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            <button class="btn btn-outline-secondary btn-sm ml-2" id="clearFilterBtn">Clear</button>
                        </div>

                         <div class="scrollbar pb-3" id="style-2">
                            <table id="debtorTable" class="table table-bordered table-sm w-100" style="white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Job No</th>
                                        <th>Sale Person Code</th>
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
                                <tfoot>
                                    <tr>
                                        <th colspan="9" class="text-right">Total:</th>
                                        <th id="total_inv" class="text-right"></th>
                                        <th id="total_advance" class="text-right"></th>
                                        <th id="total_balance" class="text-right"></th>
                                        <th colspan="3"></th>
                                    </tr>
                                </tfoot>
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
                            <table id="creditTable" class="table table-bordered table-sm w-100" style="white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Credited Date</th>
                                        <th>Job No</th>
                                        <th>Sale Person Code</th>
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
                                <tfoot>
                                    <tr>
                                        <th colspan="9" class="text-right">Total:</th>
                                        <th id="total_inv2" class="text-right"></th>
                                        <th id="total_advance2" class="text-right"></th>
                                        <th id="total_balance2" class="text-right"></th>
                                        <th colspan="2"></th>
                                    </tr>
                                </tfoot>
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
                            ['Sale Person', 'sale_person', 'text', true], // We'll replace this manually
                            ['Customer Name', 'customer_name', 'text', true],
                            ['Phone No', 'phone_no', 'text', false],
                            ['Vehicle No', 'vehicle_no', 'text', false],
                            ['Vehicle Type', 'vehicle_type', 'text', false],
                            ['Inv Amount', 'inv_amount', 'number', true],
                            ['Advance Amount', 'advance_amount', 'number', false],
                            ['Balance Amount', 'balance_amount', 'number', false],
                            ['Number Of Days', 'number_of_days', 'number', false],
                            ['Series', 'series', 'number', true],
                        ];

                        foreach ($fields as [$label, $id, $type, $req]) {
                            echo "<div class='col-md-4 mb-2'><label>$label</label>";

                            if ($id === 'sale_person') {
                                echo '<select id="sale_person" name="sale_person" class="custom-select custom-select-sm" style="min-width: 130px;" '.($req?'required':'').'>';
                                echo '<option value="">All</option>';
                                if (!empty($sales_agents)) {
                                    foreach ($sales_agents as $agent) {
                                        echo '<option value="' . htmlspecialchars($agent['idtbl_sales_person']) . '">' . htmlspecialchars($agent['sales_person_name']) . '</option>';
                                    }
                                }
                                echo '</select>';
                            }
                            else if ($id === 'series') {
                                echo '<select id="series" name="series" class="custom-select custom-select-sm" '.($req?'required':'').'>';
                                echo '<option value="">Select Series</option>';
                                echo '<option value="1">Series 1</option>';
                                echo '<option value="2">Series 2</option>';
                                echo '</select>';
                            }
                            else {
                                $readonly = ($id === 'balance_amount') ? 'readonly' : '';
                                echo "<input type='$type' step='0.01' class='form-control' id='$id' name='$id' $readonly ".($req?'required':'').">";
                            }

                            echo "</div>";
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
                        <select id="payment_details" name="payment_details" class="form-control" required>
                            <option value="">Select Details</option>
                        </select>
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

    loadDebtorTable(1);
    loadCreditTable(1);

    // $('#filterBtn').on('click', function() {
    //     $('#dataTable').DataTable().ajax.reload();
    // });

    // $('#clearFilterBtn').on('click', function() {
    //     $('#date_from, #date_to, #sales_agent, #job_status, #status, #payment_status').val('');
    //     $('#dataTable').DataTable().ajax.reload();
    // });

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

        const series = $(this).data('series');

        const paymentDropdown = $('#payment_details');
        paymentDropdown.empty().append('<option value="">Select Payment Detail</option>');
        if(series==1){
            const options = [
                'Cash',
                'Bank Transfer - ECW Com',
                'Cheque - ECW COM',
                'Cheque - BOC Nittambuwa',
                'Other'
            ];
            options.forEach(opt => {
                paymentDropdown.append(`<option value="${opt}">${opt}</option>`);
            });
        }else if(series==2){
            const options = [
                'Cash',
                'Other'
            ];
            options.forEach(opt => {
                paymentDropdown.append(`<option value="${opt}">${opt}</option>`);
            });
        }else{
            paymentDropdown.empty().append('<option value="">Select Payment Detail</option>');
        }
        
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

function loadDebtorTable(series){
    if ($.fn.DataTable.isDataTable('#debtorTable')) {
        $('#debtorTable').DataTable().clear().destroy();
    }

    var table = $('#debtorTable').DataTable({
        processing: true,
        serverSide: true,
        dom: 'Bfrtip',
        buttons: [
            // {
            //     extend: 'excelHtml5',
            //     title: 'Debtor List',
            //     exportOptions: { columns: ':visible' }
            // },
            // {
            //     text: 'S1 & S2 Debtor PDF', 
            //     action: function (e, dt, node, config) {
            //         exportPDF('debitor', 3); 
            //     },
            //     className: 'btn btn-danger btn-sm d-none',
            //     attr: { id: 'btnS1S2Debtor' }
            // },
            {
                text: 'Debtor PDF', 
                action: function (e, dt, node, config) {
                    exportPDF('debitor', series); 
                },
                className: 'btn btn-danger btn-sm',
                attr: { id: 'btnDebtor' }
            }
        ],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pageLength: -1,
        ajax: {
            url: apiBaseUrl + '/v1/cashier_debitor?series=' + encodeURIComponent(series),
            type: 'GET',
            headers: { 'Authorization': 'Bearer ' + api_token }
        },
        columns: [
            { data: 'id' },
            { data: 'date' },
            { data: 'job_no' },
            { data: 'sales_person_code' },
            { data: 'sales_person_name' },
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
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-success transferBtn" 
                            data-id="${row.id}" 
                            data-series="${row.series}" 
                            title="Transfer">
                            <i class="fas fa-exchange-alt"></i>
                        </button>
                        <button class="btn btn-sm btn-primary editBtn" 
                            data-id="${row.id}" 
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteBtn" 
                            data-id="${row.id}" 
                            title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `;
                }
            }
        ],
        order: [[0, 'desc']],
        footerCallback: function(row, data, start, end, display) {
            let api = this.api();

            const pageTotal = (index) => api.column(index, { page: 'current' }).data().reduce((a, b) => parseFloat(a) + parseFloat(b || 0), 0);
            $('#total_inv').html(pageTotal(9).toLocaleString(undefined, { minimumFractionDigits: 2 }));
            $('#total_advance').html(pageTotal(10).toLocaleString(undefined, { minimumFractionDigits: 2 }));
            $('#total_balance').html(pageTotal(11).toLocaleString(undefined, { minimumFractionDigits: 2 }));
        }
    });
}

function loadCreditTable(series){
    if ($.fn.DataTable.isDataTable('#creditTable')) {
        $('#creditTable').DataTable().clear().destroy();
    }

    var creditTable = $('#creditTable').DataTable({
        processing: true,
        serverSide: true,
        dom: 'Bfrtip',
        buttons: [
            // {
            //     extend: 'excelHtml5',
            //     title: 'Credit List',
            //     exportOptions: { columns: ':visible' }
            // },
            // {
            //     text: 'S1 & S2 Credit List PDF', 
            //     action: function (e, dt, node, config) {
            //         exportPDF('credit', 3); 
            //     },
            //     className: 'btn btn-danger btn-sm d-none',
            //     attr: { id: 'btnS1S2List' }
            // },
            {
                text: 'Credit List PDF', 
                action: function (e, dt, node, config) {
                    exportPDF('credit', series); 
                },
                className: 'btn btn-danger btn-sm',
                attr: { id: 'btnList' }
            }
        ],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pageLength: -1,
        ajax: {
            url: apiBaseUrl + '/v1/credit_settlement_list?series=' + encodeURIComponent(series),
            type: 'GET',
            headers: { 'Authorization': 'Bearer ' + api_token }
        },
        columns: [
            { data: 'id' },
            { data: 'credited_date' },
            { data: 'job_no' },
            { data: 'sales_person_code' },
            { data: 'sales_person_name' },
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
        ],
        order: [[0, 'desc']],
        footerCallback: function(row, data, start, end, display) {
            let api2 = this.api();
      
            const pageTotal2 = (index) => api2.column(index, { page: 'current' }).data().reduce((a, b) => a + parseFloat((b || '0').toString().replace(/,/g, '')), 0);
            $('#total_inv2').html(pageTotal2(9).toLocaleString(undefined, { minimumFractionDigits: 2 }));
            $('#total_advance2').html(pageTotal2(10).toLocaleString(undefined, { minimumFractionDigits: 2 }));
            $('#total_balance2').html(pageTotal2(11).toLocaleString(undefined, { minimumFractionDigits: 2 }));

        }
    });
}

function exportPDF(type, series) {
    const baseUrl = "<?php echo base_url(); ?>CashierDebitor/exportPDF";
    const url = `${baseUrl}?type=${encodeURIComponent(type)}&series=${encodeURIComponent(series)}`;
    window.open(url, '_blank');
}

$(document).ready(function() {
    let showSecret = "boom";
    let hideSecret = "hide";
    let buffer = "";

    $(document).on('keydown', function(e) {
        if (e.key.length === 1 && /[a-zA-Z]/.test(e.key)) {
            buffer += e.key.toLowerCase();
            if (buffer.length > Math.max(showSecret.length, hideSecret.length)) {
                buffer = buffer.slice(-Math.max(showSecret.length, hideSecret.length));
            }
            if (buffer === showSecret) {
                $('#btnS1S2Debtor').removeClass('d-none');
                $('#btnS1S2List').removeClass('d-none');
                loadDebtorTable(3);
                loadCreditTable(3);
                $('#headerTag').text('Both Series');
                buffer = "";
            }
            if (buffer === hideSecret) {
                $('#btnS1S2Debtor').addClass('d-none');
                $('#btnS1S2List').addClass('d-none');
                loadDebtorTable(1);
                loadCreditTable(1);
                $('#headerTag').text('');
                buffer = "";
            }
        }
    });
});
</script>

<?php include "include/footer.php"; ?>
