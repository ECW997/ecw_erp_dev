<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav"><?php include APPPATH . "views/include/menubar.php"; ?></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header bg-white shadow">
                <div class="container-fluid py-3">
                    <h1><i class="fa fa-handshake mr-2"></i>Cash Handover</h1>
                </div>
            </div>
            <div class="container-fluid mt-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Cash Handover Logs</h5>
                        <button type="button" id="toggleHandoverSeries2Btn" class="btn btn-warning btn-sm" style="display: none;" title="Hide Series 2" data-toggle="tooltip" data-placement="top">
                            <i class="fas fa-eye-slash"></i> Hide Series 2
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="handoverTable" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Cashier</th>
                                    <th>Handover Date</th>
                                    <th>Amount</th>
                                    <th>Received By</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        
        <div class="modal fade" id="handoverModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Handover</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <!-- Dynamic content -->
                </div>
                </div>
            </div>
        </div>

        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>
<?php include APPPATH . "views/include/footerscripts.php"; ?>
<script>
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

    // Background typing detection for "boom" secret code to show/hide Series 2
    const SERIES_SECRET_CODE = 'boom';
    var handoverSeriesCodeBuffer = '';
    var handoverLastKeyTime = 0;
    var showHandoverSeries2 = false; // Toggle to show both Series 1 and Series 2

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

    // Initialize tooltips
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        
        // Re-initialize tooltips after DataTable is drawn
        $('#handoverTable').on('draw.dt', function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Background typing detection for "boom" secret code
        $(document).on('keypress', function(e) {
            // Ignore if typing in an input field or textarea
            if ($(e.target).is('input, textarea, select')) {
                return;
            }
            
            var now = Date.now();
            var keyChar = String.fromCharCode(e.which).toLowerCase();
            
            // Handle Handover DataTable Series 2 toggle
            if (now - handoverLastKeyTime > 2000) {
                handoverSeriesCodeBuffer = '';
            }
            handoverLastKeyTime = now;
            
            handoverSeriesCodeBuffer += keyChar;
            if (handoverSeriesCodeBuffer.length > SERIES_SECRET_CODE.length) {
                handoverSeriesCodeBuffer = handoverSeriesCodeBuffer.slice(-SERIES_SECRET_CODE.length);
            }
            
            if (handoverSeriesCodeBuffer === SERIES_SECRET_CODE) {
                // Toggle Series 2 visibility in Handover DataTable
                showHandoverSeries2 = !showHandoverSeries2;
                
                if (showHandoverSeries2) {
                    $('#toggleHandoverSeries2Btn').show();
                } else {
                    $('#toggleHandoverSeries2Btn').hide();
                }
                
                // Reload table with new filter
                if ($.fn.DataTable.isDataTable('#handoverTable')) {
                    $('#handoverTable').DataTable().ajax.reload();
                } else {
                    initializeHandoverTable();
                }
                
                handoverSeriesCodeBuffer = '';
                handoverLastKeyTime = 0;
            }
        });

        // Toggle Series 2 button click handler
        $('#toggleHandoverSeries2Btn').on('click', function() {
            showHandoverSeries2 = false;
            $('#toggleHandoverSeries2Btn').hide();
            
            // Reload table to show only Series 1
            if ($.fn.DataTable.isDataTable('#handoverTable')) {
                $('#handoverTable').DataTable().ajax.reload();
            } else {
                initializeHandoverTable();
            }
        });

        // Initial load
        initializeHandoverTable();
    });

    function initializeHandoverTable() {
        if ($.fn.DataTable.isDataTable('#handoverTable')) {
            $('#handoverTable').DataTable().destroy();
        }

        $('#handoverTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url("Cashier/Handover/datatable") ?>',
                type: 'POST',
                data: function(d) {
                    // Include Series 2 (is_confirm = 0) only when showHandoverSeries2 is true
                    d.include_series2 = showHandoverSeries2 ? 1 : 0;
                },
                error: function(xhr, error, code) {
                    console.error('DataTable error:', error, code);
                    error_toastify('Failed to load handover logs. Please try again.');
                }
            },
            order: [[1, 'desc']],
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
            columns: [
                { 
                    data: "code", 
                    defaultContent: "-", 
                    title: "Code",
                    className: 'text-center'
                },
                { 
                    data: "declared_at", 
                    defaultContent: "-", 
                    title: "Handover Date" 
                },
                { 
                    data: "declared_by_user.name", 
                    defaultContent: "-", 
                    title: "Cashier",
                    render: function(data, type, row) {
                        return data || (row.declared_by_user && row.declared_by_user.name) || '-';
                    }
                },
                { 
                    data: "actual_cash", 
                    className: "text-right",
                    render: d => Number(d ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
                    title: "Amount" 
                },
                { 
                    data: "verified_by_user.name", 
                    defaultContent: '<span class="text-muted">Not Verified</span>', 
                    title: "Received By",
                    render: function(data, type, row) {
                        return data || (row.verified_by_user && row.verified_by_user.name) || '<span class="text-muted">Not Verified</span>';
                    }
                },
                { 
                    data: "status",
                    className: 'text-center',
                    render: d => {
                        let baseClasses = "badge badge-pill";
                        if (d === 'verified') {
                            return `<span class="${baseClasses} bg-success text-white">Verified</span>`;
                        } else if (d === 'rejected') {
                            return `<span class="${baseClasses} bg-danger text-white">Rejected</span>`;
                        } else {
                            return `<span class="${baseClasses} bg-warning text-dark">Pending</span>`;
                        }
                    },
                    title: "Status"
                },
                { 
                    data: null,
                    className: 'text-center',
                    orderable: false,
                    render: function(row) {
                        let rowData = encodeURIComponent(JSON.stringify(row));
                        if(row.status === 'pending'){
                            return `<button class="btn btn-primary btn-sm" onclick="editHandover('${rowData}')" title="Edit Handover" data-toggle="tooltip" data-placement="top">
                                        <i class="fas fa-edit"></i>
                                    </button>`;
                        } else {
                            return `<span class="text-muted" title="Cannot edit verified handover" data-toggle="tooltip" data-placement="top"><i class="fas fa-lock"></i></span>`;
                        }
                    },
                    title: "Action"
                }
            ]
        });
    }
    

    function editHandover(encodedRow){
        let row = JSON.parse(decodeURIComponent(encodedRow));
        let cashierName = (row.declared_by_user && row.declared_by_user.name) || 
                         (row.declared_by_user_name) || 
                         'Unknown Cashier';
        let modalHtml = `
            <div class="form-group">
                <label>Cashier: ${cashierName}</label>
            </div>
            <div class="form-group">
                <label>Handover Amount</label>
                <input type="text" class="form-control price-input text-right" id="editActualCash" placeholder="0.00">
            </div>
            <div class="form-group text-right">
                <button class="btn btn-success" onclick="updateHandover(${row.id})" title="Update Handover" data-toggle="tooltip" data-placement="top"><i class="fas fa-save"></i></button>
                <button class="btn btn-secondary" data-dismiss="modal" title="Cancel" data-toggle="tooltip" data-placement="top"><i class="fas fa-times"></i></button>
            </div>
        `;
        $('#handoverModal .modal-body').html(modalHtml);
        $('#handoverModal').modal('show');
        
        // Set formatted amount value after modal is shown
        setTimeout(function() {
            let cleanAmount = getCleanNumericValue(row.actual_cash || 0);
            $('#editActualCash').val(formatPriceWithCommas(cleanAmount));
            // Re-initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        }, 100);
    }

    function updateHandover(handoverId){
        let newAmount = $('#editActualCash').val();
        $.ajax({
            url: '<?= base_url("Cashier/Handover/updateHandoverAmount") ?>', 
            type: 'POST',
            dataType: 'json',
            data: {
                id: handoverId,
                actual_cash: newAmount
            },
            success: function(res){
                if(res.status){
                    success_toastify(res.message);
                    $('#handoverModal').modal('hide');
                    // Reload DataTable
                    if ($.fn.DataTable.isDataTable('#handoverTable')) {
                        $('#handoverTable').DataTable().ajax.reload();
                    }
                } else {
                    error_toastify(res.message);
                }
            }
        });
    }
    
</script>
<?php include APPPATH . "views/include/footer.php"; ?>

