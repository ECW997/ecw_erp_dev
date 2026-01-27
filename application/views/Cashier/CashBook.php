<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<style>
    /* International Cash Book - Modern Professional Design */
    :root {
        --primary-color: #2563eb;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --dark-color: #1f2937;
        --light-bg: #f9fafb;
        --border-color:rgb(183, 184, 187);
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .cash-book-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #ffffff 100%);
        padding: 30px;
        border-radius: 12px;
        box-shadow: var(--shadow-md);
    }

    .cash-book-section {
        background: #ffffff;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .cash-book-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary-color);
    }

    .cash-book-section:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 3px solid var(--primary-color);
        color: var(--dark-color);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--primary-color);
        font-size: 1.5rem;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 12px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        margin-bottom: 10px;
        background: var(--light-bg);
        border-radius: 8px;
        border-left: 4px solid var(--primary-color);
        transition: all 0.2s ease;
    }

    .summary-row:hover {
        background: #f3f4f6;
        transform: translateX(5px);
    }

    .summary-row-label {
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark-color);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-row-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-color);
        font-family: 'Courier New', monospace;
        letter-spacing: 0.5px;
    }

    .details-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 20px;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .details-table thead {
        background: linear-gradient(135deg, var(--primary-color) 0%, #3b82f6 100%);
        color: white;
    }

    .details-table thead th {
        font-weight: 600;
        padding: 14px 12px;
        text-align: left;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }

    .details-table thead th.text-right {
        text-align: right;
    }

    .details-table tbody td {
        padding: 12px;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .details-table tbody td.text-right {
        text-align: right;
        font-family: 'Courier New', monospace;
        font-weight: 500;
    }

    .details-table tbody tr {
        transition: all 0.2s ease;
    }

    /* Odd rows - light background (fallback if inline styles not applied) */
    .details-table tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    /* Even rows - slightly darker background (fallback if inline styles not applied) */
    .details-table tbody tr:nth-child(even) {
        background-color: #f9fafb;
    }
    
    /* Ensure rowspan cells inherit row background color */
    .details-table tbody tr td[rowspan] {
        background-color: inherit;
    }

    .details-table tbody tr:hover {
        background-color: #f0f9ff !important;
        transform: scale(1.01);
    }

    .details-table tbody tr:last-child td {
        border-bottom: none;
    }

    .details-table tbody tr.total-row {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%) !important;
        font-weight: 700;
        border-top: 2px solid var(--warning-color);
    }

    /* Breakdown rows should also follow odd/even pattern */
    .details-table tbody tr.breakdown-row:nth-child(odd) {
        background-color: #f8f9fa !important;
    }

    .details-table tbody tr.breakdown-row:nth-child(even) {
        background-color: #f1f3f5 !important;
    }

    .details-table tbody tr.total-row td {
        font-weight: 700;
        color: var(--dark-color);
        font-size: 1rem;
    }

    .series-2-section {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px dashed var(--border-color);
    }

    /* Series Tabs Styling */
    .series-tabs-container {
        background: white;
        padding: 0;
        border-radius: 10px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .series-tabs-container .nav-tabs {
        border-bottom: 2px solid var(--border-color);
        padding: 0;
        margin: 0;
    }

    .series-tabs-container .nav-item {
        margin-bottom: -2px;
    }

    .series-tabs-container .nav-link {
        padding: 15px 25px;
        font-weight: 600;
        color: #6b7280;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        background: transparent;
    }

    .series-tabs-container .nav-link:hover {
        color: var(--primary-color);
        background: #f9fafb;
        border-bottom-color: #e5e7eb;
    }

    .series-tabs-container .nav-link.active {
        color: var(--primary-color);
        background: white;
        border-bottom-color: var(--primary-color);
        font-weight: 700;
    }

    .series-tabs-container .nav-link i {
        margin-right: 8px;
    }

    .tab-content {
        margin-top: 0;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block;
    }

    .shift-selector {
        margin-bottom: 30px;
    }

    .shift-selector .form-group {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: var(--shadow-sm);
    }

    .shift-selector label {
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 10px;
        display: block;
    }

    /* Section-specific colors */
    .section-opening {
        border-left-color: #10b981;
    }
    .section-opening .section-title {
        border-bottom-color: #10b981;
    }
    .section-opening .section-title i {
        color: #10b981;
    }

    .section-receipt {
        border-left-color: #10b981;
    }
    .section-receipt .section-title {
        border-bottom-color: #10b981;
    }
    .section-receipt .section-title i {
        color: #10b981;
    }

    .section-iou {
        border-left-color: #f59e0b;
    }
    .section-iou .section-title {
        border-bottom-color: #f59e0b;
    }
    .section-iou .section-title i {
        color: #f59e0b;
    }

    .section-payment {
        border-left-color: #ef4444;
    }
    .section-payment .section-title {
        border-bottom-color: #ef4444;
    }
    .section-payment .section-title i {
        color: #ef4444;
    }

    .section-cashin {
        border-left-color: #3b82f6;
    }
    .section-cashin .section-title {
        border-bottom-color: #3b82f6;
    }
    .section-cashin .section-title i {
        color: #3b82f6;
    }

    .section-adjustment {
        border-left-color: #8b5cf6;
    }
    .section-adjustment .section-title {
        border-bottom-color: #8b5cf6;
    }
    .section-adjustment .section-title i {
        color: #8b5cf6;
    }

    .section-balance {
        border-left-color: #06b6d4;
    }
    .section-balance .section-title {
        border-bottom-color: #06b6d4;
    }
    .section-balance .section-title i {
        color: #06b6d4;
    }

    /* Badge styles */
    .amount-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .badge-positive {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-negative {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .cash-book-container {
            padding: 15px;
        }
        .cash-book-section {
            padding: 15px;
        }
        .summary-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        .details-table {
            font-size: 0.8rem;
        }
    }

    /* Print styles */
    @media print {
        .cash-book-section {
            page-break-inside: avoid;
            box-shadow: none;
            border: 1px solid #000;
        }
        .summary-row:hover {
            transform: none;
        }
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
                            <div class="page-header-icon"><i class="fa fa-book"></i></div>
                            <span>Cash Book - Shift Wise</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2">
                <div class="card shadow-lg border-0">
                    <div class="card-body" style="background: #f8fafc;">
                        <div class="shift-selector">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="filterType" class="font-weight-bold">
                                            <i class="fas fa-filter mr-2 text-primary"></i>
                                            Filter Type:
                                        </label>
                                        <select id="filterType" class="form-control form-control-lg" style="border-radius: 8px; border: 2px solid #e5e7eb;">
                                            <option value="shift">By Shift</option>
                                            <option value="daterange">By Date Range</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="shiftFilterGroup">
                                    <div class="form-group">
                                        <label for="shiftSelect" class="font-weight-bold">
                                            <i class="fas fa-clock mr-2 text-primary"></i>
                                            Select Shift:
                                        </label>
                                        <select id="shiftSelect" class="form-control form-control-lg" style="border-radius: 8px; border: 2px solid #e5e7eb;">
                                            <option value="">-- Select Shift --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3" id="dateRangeFilterGroup" style="display: none;">
                                    <div class="form-group">
                                        <label for="fromDate" class="font-weight-bold">
                                            <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                                            From Date:
                                        </label>
                                        <input type="date" id="fromDate" class="form-control form-control-lg" style="border-radius: 8px; border: 2px solid #e5e7eb;">
                                    </div>
                                </div>
                                <div class="col-md-3" id="dateRangeFilterGroup2" style="display: none;">
                                    <div class="form-group">
                                        <label for="toDate" class="font-weight-bold">
                                            <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                                            To Date:
                                        </label>
                                        <input type="date" id="toDate" class="form-control form-control-lg" style="border-radius: 8px; border: 2px solid #e5e7eb;">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 mt-3">
                                <button id="loadCashBookBtn" class="btn btn-primary btn-lg" onclick="loadCashBookByFilter()" style="border-radius: 8px;">
                                    <i class="fas fa-search mr-2"></i>Load Cash Book
                                </button>
                                <div class="export-buttons" id="exportButtons" style="display: none;">
                                    <button class="btn btn-danger btn-lg" onclick="exportToPDF()" title="Export to PDF">
                                        <i class="fas fa-file-pdf mr-2"></i>Export PDF
                                    </button>
                                    <button class="btn btn-success btn-lg" onclick="exportToExcel()" title="Export to Excel">
                                        <i class="fas fa-file-excel mr-2"></i>Export Excel
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="cashBookContent" style="display: none;">
                            <!-- Series Tabs - Hidden by default, shown only after typing 'boom' -->
                            <div id="seriesTabs" class="series-tabs-container" style="display: none; margin-bottom: 25px;">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="series1-tab" data-toggle="tab" href="#series1-content" role="tab" aria-controls="series1-content" aria-selected="true">
                                            <i class="fas fa-layer-group mr-2"></i>Series 1
                                        </a>
                                    </li>
                                    <li class="nav-item" id="series2TabItem" style="display: none;">
                                        <a class="nav-link" id="series2-tab" data-toggle="tab" href="#series2-content" role="tab" aria-controls="series2-content" aria-selected="false">
                                            <i class="fas fa-layer-group mr-2"></i>Series 2
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Tab Content -->
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="series1-content" role="tabpanel" aria-labelledby="series1-tab">
                                    <div class="cash-book-container" id="series1Container">
                                        <!-- Series 1 content will be populated by JavaScript -->
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="series2-content" role="tabpanel" aria-labelledby="series2-tab" style="display: none;">
                                    <div class="cash-book-container" id="series2Container">
                                        <!-- Series 2 content will be populated by JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="loadingMessage" style="text-align: center; padding: 60px;">
                            <div class="text-center">
                                <i class="fas fa-book-reader fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
                                <h5 class="text-muted font-weight-normal">Please select a shift to view cash book</h5>
                                <p class="text-muted small mt-2">Choose a shift from the dropdown above to generate the cash book report</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>
<?php include APPPATH . "views/include/footerscripts.php"; ?>
<script>
    // Cash Book Details - Tab-based Layout
    let secretCodeActive = false;
    let secretCodeBuffer = '';
    let showSeries2 = false;
    let showTotal = false;
    let currentSeries = 'series1';
    let cashBookData = null;

    // Load shifts on page load
    $(document).ready(function() {
        loadShifts();
        
        // Secret code detection (type 'boom' to show Series 2 tabs)
        $(document).keydown(function(e) {
            if (e.key.length === 1) {
                secretCodeBuffer += e.key.toLowerCase();
                if (secretCodeBuffer.length > 10) {
                    secretCodeBuffer = secretCodeBuffer.slice(-10);
                }
                
                // Check for 'boom' - Show Series 2 tab
                if (secretCodeBuffer.includes('boom')) {
                    showSeries2 = true;
                    showTotal = true;
                    $('#seriesTabs').slideDown(300);
                    $('#series2TabItem').slideDown(300);
                    // Switch to Series 2 tab if not already on it
                    if (currentSeries === 'series1') {
                        switchToSeries('series2');
                    }
                    secretCodeBuffer = '';
                }
                
                // Check for 'hide' - Hide Series 2 tab and go back to Series 1
                if (secretCodeBuffer.includes('hide')) {
                    showSeries2 = false;
                    showTotal = false;
                    $('#seriesTabs').slideUp(300);
                    $('#series2TabItem').slideUp(300);
                    switchToSeries('series1');
                    secretCodeBuffer = '';
                }
            }
        });

        // Tab click handlers
        $('#series1-tab').on('click', function(e) {
            e.preventDefault();
            switchToSeries('series1');
        });

        $('#series2-tab').on('click', function(e) {
            e.preventDefault();
            switchToSeries('series2');
        });
    });

    function loadShifts() {
        $.ajax({
            url: '<?php echo base_url(); ?>CashierCashBook/getAllCashierLog',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status && response.data) {
                    const select = $('#shiftSelect');
                    response.data.forEach(function(shift) {
                        const option = $('<option></option>')
                            .attr('value', shift.id)
                            .text(shift.code + ' - ' + (shift.opened_at || ''));
                        select.append(option);
                    });
                }
            },
            error: function() {
                console.error('Failed to load shifts');
            }
        });
    }

    // Filter type change handler
    $('#filterType').on('change', function() {
        const filterType = $(this).val();
        if (filterType === 'shift') {
            $('#shiftFilterGroup').show();
            $('#dateRangeFilterGroup').hide();
            $('#dateRangeFilterGroup2').hide();
        } else {
            $('#shiftFilterGroup').hide();
            $('#dateRangeFilterGroup').show();
            $('#dateRangeFilterGroup2').show();
        }
        // Clear and hide cash book content when switching filter types
        $('#cashBookContent').hide();
        $('#exportButtons').hide();
        $('#loadingMessage').show().html(`
            <div class="text-center">
                <i class="fas fa-book-reader fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
                <h5 class="text-muted font-weight-normal">Please select filter criteria</h5>
                <p class="text-muted small mt-2">Choose ${filterType === 'shift' ? 'a shift' : 'date range'} and click "Load Cash Book"</p>
            </div>
        `);
    });

    $('#shiftSelect').on('change', function() {
        const shiftId = $(this).val();
        if (shiftId && $('#filterType').val() === 'shift') {
            loadCashBookByFilter();
        }
    });

    // Load cash book by filter (shift or date range)
    function loadCashBookByFilter() {
        const filterType = $('#filterType').val();
        if (filterType === 'shift') {
            const shiftId = $('#shiftSelect').val();
            if (shiftId) {
                loadCashBook(shiftId);
            } else {
                alert('Please select a shift');
            }
        } else {
            const fromDate = $('#fromDate').val();
            const toDate = $('#toDate').val();
            if (fromDate && toDate) {
                loadCashBookByDateRange(fromDate, toDate);
            } else {
                alert('Please select both from date and to date');
            }
        }
    }

    function loadCashBook(shiftId) {
        // Clear containers before loading new data
        $('#series1Container').empty();
        $('#series2Container').empty();
        
        $('#loadingMessage').html(`
            <div class="text-center">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="sr-only">Loading...</span>
                </div>
                <h5 class="text-primary font-weight-normal">Loading cash book...</h5>
                <p class="text-muted small">Please wait while we fetch the data</p>
            </div>
        `);
        $('#loadingMessage').show();
        $('#cashBookContent').hide();

        $.ajax({
            url: '<?php echo base_url(); ?>CashierCashBook/getCashBook/' + shiftId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status && response.data) {
                    cashBookData = response.data;
                    currentSeries = 'series1';
                    showSeries2 = false;
                    showTotal = false;
                    $('#seriesTabs').hide();
                    $('#series2TabItem').hide();
                    renderCashBook(response.data);
                    $('#loadingMessage').hide();
                    $('#cashBookContent').show();
                    $('#exportButtons').show();
                    $('#exportButtons').show();
                } else {
                    $('#loadingMessage').html('<p>Failed to load cash book: ' + (response.message || 'Unknown error') + '</p>');
                }
            },
            error: function(xhr) {
                $('#loadingMessage').html('<p>Error loading cash book. Please try again.</p>');
                console.error('Error:', xhr);
            }
        });
    }

    function loadCashBookByDateRange(fromDate, toDate) {
        // Clear containers before loading new data
        $('#series1Container').empty();
        $('#series2Container').empty();
        
        $('#loadingMessage').html(`
            <div class="text-center">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="sr-only">Loading...</span>
                </div>
                <h5 class="text-primary font-weight-normal">Loading cash book...</h5>
                <p class="text-muted small">Please wait while we fetch the data</p>
            </div>
        `);
        $('#loadingMessage').show();
        $('#cashBookContent').hide();

        $.ajax({
            url: '<?php echo base_url(); ?>CashierCashBook/getCashBookByDateRange',
            type: 'POST',
            dataType: 'json',
            data: {
                from_date: fromDate,
                to_date: toDate
            },
            success: function(response) {
                if (response.status && response.data) {
                    cashBookData = response.data;
                    currentSeries = 'series1';
                    showSeries2 = false;
                    showTotal = false;
                    $('#seriesTabs').hide();
                    $('#series2TabItem').hide();
                    renderCashBook(response.data);
                    $('#loadingMessage').hide();
                    $('#cashBookContent').show();
                    $('#exportButtons').show();
                } else {
                    $('#loadingMessage').html('<p>Failed to load cash book: ' + (response.message || 'Unknown error') + '</p>');
                }
            },
            error: function(xhr) {
                $('#loadingMessage').html('<p>Error loading cash book. Please try again.</p>');
                console.error('Error:', xhr);
            }
        });
    }

    function renderCashBook(data) {
        // Clear containers first before rendering new data
        $('#series1Container').empty();
        $('#series2Container').empty();
        
        // Reset tab states
        $('#series1-tab').addClass('active').attr('aria-selected', 'true');
        $('#series2-tab').removeClass('active').attr('aria-selected', 'false');
        $('#series1-content').addClass('show active');
        $('#series2-content').removeClass('show active');
        
        // Render Series 1 (default view) - always render first
        renderSeriesView('series1', data);
        
        // Render Series 2 (will be shown when tab is clicked)
        renderSeriesView('series2', data);
        
        // Ensure Series 1 is visible by default, Series 2 is hidden
        $('#series1-content').show();
        $('#series1Container').show();
        $('#series2-content').hide();
        $('#series2Container').hide();
    }

    function renderSeriesView(series, data) {
        const isSeries1 = (series === 'series1');
        const container = isSeries1 ? $('#series1Container') : $('#series2Container');
        const seriesKey = isSeries1 ? 'series_1' : 'series_2';
        
        // Clear container first
        container.empty();

        // 1. Opening Balance
        if (data.opening_balance && data.opening_balance[seriesKey] !== undefined) {
            addSimpleSectionSingle(container, 'OPENING BALANCE', data.opening_balance[seriesKey], 'section-opening', 'fa-wallet');
        }

        // 2. Receipts Section
        if (data.receipts && data.receipts[seriesKey]) {
            const receiptsData = data.receipts[seriesKey];
            const details = receiptsData.details || {};
            addReceiptSectionSingle(container, 'RECEIPT', receiptsData, details);
        }

        // 3. Cash In Section (moved after Receipt)
        if (data.cash_in && data.cash_in[seriesKey]) {
            addPaymentSectionSingle(container, 'CASH IN', data.cash_in[seriesKey]);
        }

        // 4. IOU Settlement Section
        if (data.iou_settlements && data.iou_settlements[seriesKey]) {
            addIOUSectionSingle(container, 'IOU SETTLEMENT', data.iou_settlements[seriesKey]);
        }

        // 5. IOU Section
        if (data.iou && data.iou[seriesKey]) {
            addIOUSectionSingle(container, 'IOU', data.iou[seriesKey]);
        }

        // 6. Payment Section (Cash Out)
        if (data.cash_out && data.cash_out[seriesKey]) {
            addPaymentSectionSingle(container, 'PAYMENT', data.cash_out[seriesKey]);
        }

        // 7. Adjustments
        if (data.adjustments && data.adjustments[seriesKey] !== undefined) {
            addSimpleSectionSingle(container, 'ADJUSTMENTS', data.adjustments[seriesKey], 'section-adjustment', 'fa-adjust');
        }

        // 8. Cash In Hand Balance
        if (data.closing_balance && data.closing_balance[seriesKey] && data.closing_balance[seriesKey].calculated !== undefined) {
            const closingBalance = data.closing_balance[seriesKey].calculated;
            addBalanceSectionSingle(container, 'CASH IN HAND BALANCE', closingBalance);
        }
        
        // Ensure container is visible after rendering
        container.show();
    }

    function switchToSeries(series) {
        currentSeries = series;
        
        // Update tab active states
        if (series === 'series1') {
            // Update tab buttons
            $('#series1-tab').addClass('active').attr('aria-selected', 'true');
            $('#series2-tab').removeClass('active').attr('aria-selected', 'false');
            
            // Hide Series 2 content completely
            $('#series2-content').removeClass('show active').css('display', 'none');
            $('#series2Container').css('display', 'none');
            
            // Show Series 1 content
            $('#series1-content').addClass('show active').css('display', 'block');
            $('#series1Container').css('display', 'block');
            
            // Force visibility
            $('#series1-content').show();
            $('#series1Container').show();
        } else {
            // Update tab buttons
            $('#series2-tab').addClass('active').attr('aria-selected', 'true');
            $('#series1-tab').removeClass('active').attr('aria-selected', 'false');
            
            // Hide Series 1 content completely
            $('#series1-content').removeClass('show active').css('display', 'none');
            $('#series1Container').css('display', 'none');
            
            // Show Series 2 content
            $('#series2-content').addClass('show active').css('display', 'block');
            $('#series2Container').css('display', 'block');
            
            // Force visibility
            $('#series2-content').show();
            $('#series2Container').show();
        }
    }

    function addSimpleSection(container, title, items, sectionClass = '', icon = '') {
        const section = $('<div></div>').addClass('cash-book-section ' + sectionClass);
        const titleDiv = $('<div></div>').addClass('section-title');
        if (icon) {
            titleDiv.append($('<i></i>').addClass('fas ' + icon));
        }
        titleDiv.append($('<span></span>').text(title));
        section.append(titleDiv);
        
        items.forEach(function(item) {
            const row = $('<div></div>').addClass('summary-row');
            const label = $('<span></span>').addClass('summary-row-label').text(item.label);
            const valueContainer = $('<div></div>').css({'display': 'flex', 'gap': '20px', 'align-items': 'center'});
            const s1Value = $('<span></span>').addClass('summary-row-value series-1-value').text(formatMoney(item.s1));
            valueContainer.append(s1Value);
            
            if (showSeries2) {
                const s2Value = $('<span></span>').addClass('summary-row-value series-2-value').text(formatMoney(item.s2));
                valueContainer.append(s2Value);
            }
            if (showTotal) {
                const totalValue = $('<span></span>').addClass('summary-row-value total-value').text(formatMoney(item.total));
                valueContainer.append(totalValue);
            }
            
            row.append(label).append(valueContainer);
            section.append(row);
        });
        
        container.append(section);
    }

    function addSimpleSectionSingle(container, title, value, sectionClass = '', icon = '') {
        const section = $('<div></div>').addClass('cash-book-section ' + sectionClass);
        const titleDiv = $('<div></div>').addClass('section-title');
        if (icon) {
            titleDiv.append($('<i></i>').addClass('fas ' + icon));
        }
        titleDiv.append($('<span></span>').text(title));
        section.append(titleDiv);
        
        const row = $('<div></div>').addClass('summary-row');
        const label = $('<span></span>').addClass('summary-row-label').text(title.replace(/\s+/g, ' '));
        const valueSpan = $('<span></span>').addClass('summary-row-value').text(formatMoney(value));
        row.append(label).append(valueSpan);
        section.append(row);
        
        container.append(section);
    }

    function addBalanceSection(container, title, balanceData) {
        const section = $('<div></div>').addClass('cash-book-section section-balance');
        const titleDiv = $('<div></div>').addClass('section-title');
        titleDiv.append($('<i></i>').addClass('fas fa-money-bill-wave'));
        titleDiv.append($('<span></span>').text(title));
        section.append(titleDiv);
        
        const row = $('<div></div>').addClass('summary-row');
        const label = $('<span></span>').addClass('summary-row-label').text('Cash In Hand Balance');
        const valueContainer = $('<div></div>').css({'display': 'flex', 'gap': '20px', 'align-items': 'center'});
        
        // Always show Series 1
        const s1Value = $('<span></span>').addClass('summary-row-value series-1-value').text(formatMoney(balanceData.s1));
        valueContainer.append(s1Value);
        
        // Show Series 2 if secret code is active
        if (showSeries2) {
            const s2Value = $('<span></span>').addClass('summary-row-value series-2-value').text(formatMoney(balanceData.s2));
            valueContainer.append(s2Value);
        }
        
        // Always show Total (regardless of secret code)
        const totalValue = $('<span></span>').addClass('summary-row-value total-value').css({
            'font-size': '1.3rem',
            'color': '#10b981',
            'font-weight': '800'
        }).text(formatMoney(balanceData.total));
        valueContainer.append(totalValue);
        
        row.append(label).append(valueContainer);
        section.append(row);
        
        container.append(section);
    }

    function addBalanceSectionSingle(container, title, balanceValue) {
        const section = $('<div></div>').addClass('cash-book-section section-balance');
        const titleDiv = $('<div></div>').addClass('section-title');
        titleDiv.append($('<i></i>').addClass('fas fa-money-bill-wave'));
        titleDiv.append($('<span></span>').text(title));
        section.append(titleDiv);
        
        const row = $('<div></div>').addClass('summary-row');
        const label = $('<span></span>').addClass('summary-row-label').text('Cash In Hand Balance');
        const valueSpan = $('<span></span>').addClass('summary-row-value').css({
            'font-size': '1.3rem',
            'color': '#10b981',
            'font-weight': '800'
        }).text(formatMoney(balanceValue));
        
        row.append(label).append(valueSpan);
        section.append(row);
        
        container.append(section);
    }

    function addReceiptSectionSingle(container, title, receiptsData, details) {
        const section = $('<div></div>').addClass('cash-book-section section-receipt');
        const titleDiv = $('<div></div>').addClass('section-title');
        titleDiv.append($('<i></i>').addClass('fas fa-arrow-circle-down'));
        titleDiv.append($('<span></span>').text(title));
        section.append(titleDiv);
        
        const salesReceiptRow = $('<div></div>').addClass('summary-row');
        salesReceiptRow.append($('<span></span>').addClass('summary-row-label').text('SALES RECEIPT'));
        salesReceiptRow.append($('<span></span>').addClass('summary-row-value').text(formatMoney(receiptsData.receipts || receiptsData.total || 0)));
        section.append(salesReceiptRow);
        
        if (details && details.receipts && details.receipts.length > 0) {
            const headers = [
                {label: 'Code', field: 'code', width: '15%'},
                {label: 'Description', field: 'description', width: '45%'},
                {label: 'Date', field: 'date', width: '20%'},
                {label: 'Amount', field: 'amount', align: 'right', width: '20%'}
            ];
            const table = createDetailsTable(headers, details.receipts);
            section.append(table);
        }
        
        container.append(section);
    }

    function addIOUSectionSingle(container, title, iouData) {
        const section = $('<div></div>').addClass('cash-book-section section-iou');
        const titleDiv = $('<div></div>').addClass('section-title');
        titleDiv.append($('<i></i>').addClass('fas fa-file-invoice-dollar'));
        titleDiv.append($('<span></span>').text(title));
        section.append(titleDiv);
        
        const totalRow = $('<div></div>').addClass('summary-row');
        totalRow.append($('<span></span>').addClass('summary-row-label').text('Total'));
        totalRow.append($('<span></span>').addClass('summary-row-value').text(formatMoney(iouData.total || 0)));
        section.append(totalRow);
        
        if (iouData.details && iouData.details.length > 0) {
            // Different headers for IOU Settlement vs IOU
            let headers;
            if (title === 'IOU SETTLEMENT') {
                headers = [
                    {label: 'SETTLEMENT NO', field: 'settlement_code', width: '13%'},
                    {label: 'NAME', field: 'name', width: '18%'},
                    {label: 'ORIGINAL IOU', field: 'original_iou', width: '13%'},
                    {label: 'DESCRIPTION', field: 'description', width: '31%'},
                    {label: 'DATE', field: 'date', width: '10%'},
                    {label: 'AMOUNT', field: 'amount', align: 'right', width: '15%'}
                ];
            } else {
                headers = [
                    {label: 'IOU NO', field: 'code', width: '15%'},
                    {label: 'NAME', field: 'name', width: '22%'},
                    {label: 'DESCRIPTION', field: 'description', width: '35%'},
                    {label: 'DATE', field: 'date', width: '13%'},
                    {label: 'AMOUNT', field: 'amount', align: 'right', width: '15%'}
                ];
            }
            const table = createDetailsTable(headers, iouData.details);
            section.append(table);
        }
        
        container.append(section);
    }

    function addPaymentSectionSingle(container, title, paymentData) {
        const sectionClass = (title === 'PAYMENT') ? 'section-payment' : 'section-cashin';
        const icon = (title === 'PAYMENT') ? 'fa-arrow-circle-up' : 'fa-arrow-circle-down';
        const section = $('<div></div>').addClass('cash-book-section ' + sectionClass);
        const titleDiv = $('<div></div>').addClass('section-title');
        titleDiv.append($('<i></i>').addClass('fas ' + icon));
        titleDiv.append($('<span></span>').text(title));
        section.append(titleDiv);
        
        const totalRow = $('<div></div>').addClass('summary-row');
        totalRow.append($('<span></span>').addClass('summary-row-label').text('Total'));
        totalRow.append($('<span></span>').addClass('summary-row-value').text(formatMoney(paymentData.total || 0)));
        section.append(totalRow);
        
        if (paymentData.details && paymentData.details.length > 0) {
            const headers = [
                {label: 'VOUCHER NO', field: 'code', width: '11%'},
                {label: 'IOU NO', field: 'iou_no', width: '11%'},
                {label: 'PAYEE', field: 'payee', width: '13%'},
                {label: 'ACCOUNT', field: 'account', width: '16%'},
                {label: 'DESCRIPTION', field: 'description', width: '25%'},
                {label: 'DATE', field: 'date', width: '9%'},
                {label: 'AMOUNT', field: 'amount', align: 'right', width: '15%'}
            ];
            const table = createDetailsTable(headers, paymentData.details);
            section.append(table);
        }
        
        container.append(section);
    }

    function addReceiptSection(container, title, receiptsData) {
        const section = $('<div></div>').addClass('cash-book-section section-receipt');
        const titleDiv = $('<div></div>').addClass('section-title');
        titleDiv.append($('<i></i>').addClass('fas fa-arrow-circle-down'));
        titleDiv.append($('<span></span>').text(title));
        section.append(titleDiv);
        
        // Sales Receipt (Series 1 receipts)
        const salesReceiptRow = $('<div></div>').addClass('summary-row');
        salesReceiptRow.append($('<span></span>').addClass('summary-row-label').text('SALES RECEIPT'));
        salesReceiptRow.append($('<span></span>').addClass('summary-row-value').text(formatMoney(receiptsData.series_1.receipts)));
        section.append(salesReceiptRow);
        
        // Receipts Details Table (Series 1)
        if (receiptsData.series_1.details.receipts && receiptsData.series_1.details.receipts.length > 0) {
            const headers = [
                {label: 'Code', field: 'code', width: '15%'},
                {label: 'Description', field: 'description', width: '45%'},
                {label: 'Date', field: 'date', width: '20%'},
                {label: 'Amount', field: 'amount', align: 'right', width: '20%'}
            ];
            const table = createDetailsTable(headers, receiptsData.series_1.details.receipts, 'series1');
            section.append(table);
        }
        
        // Other Receipt (Series 2 receipts) - hidden by default
        if (receiptsData.series_2.details.receipts && receiptsData.series_2.details.receipts.length > 0) {
            const s2Section = $('<div></div>').addClass('series-2-section').css('display', showSeries2 ? 'block' : 'none');
            const otherReceiptRow = $('<div></div>').addClass('summary-row');
            otherReceiptRow.append($('<span></span>').addClass('summary-row-label').text('OTHER RECEIPT'));
            otherReceiptRow.append($('<span></span>').addClass('summary-row-value').text(formatMoney(receiptsData.series_2.receipts)));
            s2Section.append(otherReceiptRow);
            
            const headers = [
                {label: 'Code', field: 'code', width: '15%'},
                {label: 'Description', field: 'description', width: '45%'},
                {label: 'Date', field: 'date', width: '20%'},
                {label: 'Amount', field: 'amount', align: 'right', width: '20%'}
            ];
            const table = createDetailsTable(headers, receiptsData.series_2.details.receipts, 'series2');
            s2Section.append(table);
            section.append(s2Section);
        }
        
        container.append(section);
    }

    function addIOUSection(container, title, iouData) {
        const section = $('<div></div>').addClass('cash-book-section section-iou');
        const titleDiv = $('<div></div>').addClass('section-title');
        titleDiv.append($('<i></i>').addClass('fas fa-file-invoice-dollar'));
        titleDiv.append($('<span></span>').text(title));
        section.append(titleDiv);
        
        // Total amount row
        const totalRow = $('<div></div>').addClass('summary-row');
        totalRow.append($('<span></span>').addClass('summary-row-label').text('Total'));
        totalRow.append($('<span></span>').addClass('summary-row-value').text(formatMoney(iouData.series_1.total)));
        section.append(totalRow);
        
        // Series 1 Details Table
        if (iouData.series_1.details && iouData.series_1.details.length > 0) {
            const headers = [
                {label: 'IOU NO', field: 'code', width: '15%'},
                {label: 'NAME', field: 'name', width: '25%'},
                {label: 'DESCRIPTION', field: 'description', width: '40%'},
                {label: 'AMOUNT', field: 'amount', align: 'right', width: '20%'}
            ];
            const table = createDetailsTable(headers, iouData.series_1.details, 'series1');
            section.append(table);
        }
        
        // Series 2 Details Table (hidden by default)
        if (iouData.series_2.details && iouData.series_2.details.length > 0) {
            const s2Section = $('<div></div>').addClass('series-2-section').css('display', showSeries2 ? 'block' : 'none');
            const s2TotalRow = $('<div></div>').addClass('summary-row');
            s2TotalRow.append($('<span></span>').addClass('summary-row-label').text('Series 2 Total'));
            s2TotalRow.append($('<span></span>').addClass('summary-row-value').text(formatMoney(iouData.series_2.total)));
            s2Section.append(s2TotalRow);
            
            const headers = [
                {label: 'IOU NO', field: 'code', width: '15%'},
                {label: 'NAME', field: 'name', width: '25%'},
                {label: 'DESCRIPTION', field: 'description', width: '40%'},
                {label: 'AMOUNT', field: 'amount', align: 'right', width: '20%'}
            ];
            const table = createDetailsTable(headers, iouData.series_2.details, 'series2');
            s2Section.append(table);
            section.append(s2Section);
        }
        
        container.append(section);
    }

    function addPaymentSection(container, title, paymentData) {
        const sectionClass = title === 'PAYMENT' ? 'section-payment' : 'section-cashin';
        const icon = title === 'PAYMENT' ? 'fa-arrow-circle-up' : 'fa-arrow-circle-down';
        const section = $('<div></div>').addClass('cash-book-section ' + sectionClass);
        const titleDiv = $('<div></div>').addClass('section-title');
        titleDiv.append($('<i></i>').addClass('fas ' + icon));
        titleDiv.append($('<span></span>').text(title));
        section.append(titleDiv);
        
        // Total amount row
        const totalRow = $('<div></div>').addClass('summary-row');
        totalRow.append($('<span></span>').addClass('summary-row-label').text('Total'));
        totalRow.append($('<span></span>').addClass('summary-row-value').text(formatMoney(paymentData.series_1.total)));
        section.append(totalRow);
        
        // Series 1 Details Table
        if (paymentData.series_1.details && paymentData.series_1.details.length > 0) {
            const headers = [
                {label: 'VOURCHR NO', field: 'code', width: '15%'},
                {label: 'EXPENSE CATEGORY DESCRIPTION', field: 'description', width: '55%'},
                {label: 'AMOUNT', field: 'amount', align: 'right', width: '30%'}
            ];
            const table = createDetailsTable(headers, paymentData.series_1.details, 'series1');
            section.append(table);
        }
        
        // Series 2 Details Table (hidden by default)
        if (paymentData.series_2.details && paymentData.series_2.details.length > 0) {
            const s2Section = $('<div></div>').addClass('series-2-section').css('display', showSeries2 ? 'block' : 'none');
            const s2TotalRow = $('<div></div>').addClass('summary-row');
            s2TotalRow.append($('<span></span>').addClass('summary-row-label').text('Series 2 Total'));
            s2TotalRow.append($('<span></span>').addClass('summary-row-value').text(formatMoney(paymentData.series_2.total)));
            s2Section.append(s2TotalRow);
            
            const headers = [
                {label: 'VOURCHR NO', field: 'code', width: '10%'},
                {label: 'PAYEE', field: 'payee', width: '18%'},
                {label: 'ACCOUNT', field: 'account', width: '18%'},
                {label: 'EXPENSE CATEGORY DESCRIPTION', field: 'description', width: '34%'},
                {label: 'AMOUNT', field: 'amount', align: 'right', width: '20%'}
            ];
            const table = createDetailsTable(headers, paymentData.series_2.details, 'series2');
            s2Section.append(table);
            section.append(s2Section);
        }
        
        container.append(section);
    }

    
    function createDetailsTable(headers, data, showSeries) {
        const table = $('<table></table>').addClass('details-table');
        
        // Create header
        const thead = $('<thead></thead>');
        const headerRow = $('<tr></tr>');
        headers.forEach(function(header) {
            const th = $('<th></th>').text(header.label);
            if (header.align === 'right') {
                th.addClass('text-right');
            }
            if (header.width) {
                th.css('width', header.width);
            }
            headerRow.append(th);
        });
        thead.append(headerRow);
        table.append(thead);
        
        // Create body
        const tbody = $('<tbody></tbody>');
        let totalAmount = 0;
        let dataRowIndex = 0; // Track actual data row index for odd/even colors
        let movementRowIndex = 0; // Track movement index for Payment section (all items of same movement get same color)
        
        if (data && data.length > 0) {
            // Flatten data to include reversal entries
            const flattenedData = [];
            data.forEach(function(item) {
                // Add main item
                flattenedData.push(item);
                
                // If this item has reversal entries, add them after the main item
                if (item.reversal_entries && item.reversal_entries.length > 0) {
                    item.reversal_entries.forEach(function(reversalEntry) {
                        // Mark as reversal entry and preserve relationship info
                        const reversalItem = Object.assign({}, reversalEntry, {
                            is_reversal_entry: true,
                            original_movement: item
                        });
                        flattenedData.push(reversalItem);
                    });
                }
            });
            
            flattenedData.forEach(function(item, itemIndex) {
                // Check if this is Payment section by checking if iou_no field exists in headers
                const isPaymentSection = headers.some(function(h) {
                    return h.field === 'iou_no';
                });
                
                // Check if this is a reversal entry
                const isReversalEntry = item.is_reversal_entry || false;
                const originalMovement = isReversalEntry ? item.original_movement : null;
                
                // For Payment section: check if we have items to create separate rows
                let hasItems = false;
                let itemsToDisplay = [];
                if (isPaymentSection && item.items && item.items.length > 0) {
                    hasItems = true;
                    itemsToDisplay = item.items;
                } else if (isReversalEntry && originalMovement && originalMovement.items && originalMovement.items.length > 0) {
                    // For reversal entries, use original movement's items structure
                    hasItems = true;
                    itemsToDisplay = originalMovement.items;
                }
                
                // If Payment section with items, create separate rows for each item
                if (isPaymentSection && hasItems && itemsToDisplay.length > 0) {
                    // Get payee info map
                    const payeeMap = {};
                    if (item.payees && item.payees.length > 0) {
                        item.payees.forEach(function(payee) {
                            payeeMap[payee.id] = payee;
                        });
                    }
                    
                    // Get IOU info
                    let iouCode = null;
                    const iouSettlement = item.iou_settlement || item.iouSettlement;
                    if (iouSettlement) {
                        const cashMovement = iouSettlement.cash_movement || iouSettlement.cashMovement;
                        if (cashMovement && cashMovement.code) {
                            iouCode = cashMovement.code;
                        }
                    }
                    if (!iouCode && item.remarks) {
                        const originalIouMatch = item.remarks.match(/Original IOU:\s*([^\s,]+)/);
                        if (originalIouMatch && originalIouMatch[1]) {
                            iouCode = originalIouMatch[1];
                        }
                    }
                    
                    // Get IOU description
                    let iouDescription = null;
                    if (iouSettlement) {
                        const cashMovement = iouSettlement.cash_movement || iouSettlement.cashMovement;
                        if (cashMovement && cashMovement.remarks) {
                            iouDescription = cashMovement.remarks;
                        }
                    }
                    if (!iouDescription) {
                        iouDescription = item.remarks || null;
                    }
                    
                    // Group items by payee_id to calculate rowspan for payee column
                    const itemsByPayee = {};
                    itemsToDisplay.forEach(function(lineItem) {
                        const payeeId = lineItem.payee_id || 'no_payee';
                        if (!itemsByPayee[payeeId]) {
                            itemsByPayee[payeeId] = [];
                        }
                        itemsByPayee[payeeId].push(lineItem);
                    });
                    
                    // Sort items by payee_id so that items with the same payee are consecutive
                    // This allows rowspan to work correctly
                    const sortedItems = itemsToDisplay.slice().sort(function(a, b) {
                        const payeeIdA = a.payee_id || 'no_payee';
                        const payeeIdB = b.payee_id || 'no_payee';
                        if (payeeIdA < payeeIdB) return -1;
                        if (payeeIdA > payeeIdB) return 1;
                        return 0;
                    });
                    
                    // Create rows for each item - one row per item with its own account, description, amount
                    let globalRowIndex = 0;
                    // Track which payees have been shown to determine rowspan correctly
                    const payeeShown = {}; // Track if we've already shown this payee_id
                    
                    sortedItems.forEach(function(lineItem, itemArrayIndex) {
                        // Find which payee group this item belongs to
                        const payeeId = lineItem.payee_id || 'no_payee';
                        const payeeItems = itemsByPayee[payeeId] || [];
                        const payee = payeeMap[payeeId] || null;
                        const payeeRowspan = payeeItems.length;
                        // Check if this is the first occurrence of this payee in the items array
                        const isFirstPayeeOccurrence = !payeeShown[payeeId];
                        if (isFirstPayeeOccurrence) {
                            payeeShown[payeeId] = true;
                        }
                        
                        const row = $('<tr></tr>');
                        // For Payment section: apply color based on movement index (all items of same movement get same color)
                        // For other sections: apply color based on data row index
                        if (isPaymentSection) {
                            // Use movementRowIndex so all items of the same movement have the same color
                            if (globalRowIndex === 0) {
                                // First item of this movement - determine color based on movement index
                                if (movementRowIndex % 2 === 0) {
                                    // Even movement (0, 2, 4, ...) - white background
                                    row.css('background-color', '#ffffff');
                                } else {
                                    // Odd movement (1, 3, 5, ...) - light gray background
                                    row.css('background-color', '#f9fafb');
                                }
                            } else {
                                // Subsequent items of the same movement - inherit color from first row
                                // Find the first row of this movement to get its color
                                const firstRowColor = (movementRowIndex % 2 === 0) ? '#ffffff' : '#f9fafb';
                                row.css('background-color', firstRowColor);
                            }
                        } else {
                            // Regular rows - use data row index
                            if (dataRowIndex % 2 === 0) {
                                // Even row (0, 2, 4, ...) - white background
                                row.css('background-color', '#ffffff');
                            } else {
                                // Odd row (1, 3, 5, ...) - light gray background
                                row.css('background-color', '#f9fafb');
                            }
                        }
                        
                        headers.forEach(function(header, colIndex) {
                            const td = $('<td></td>');
                            let value = '-';
                            
                            if (header.field === 'code') {
                                // Voucher NO - show only on first row of movement, span all items
                                // For reversal entries, prefix with "REV-" to clearly mark as reversal
                                if (globalRowIndex === 0) {
                                    if (isReversalEntry) {
                                        value = 'REV-' + (item.code || '-');
                                        td.addClass('reversal-entry text-danger font-italic');
                                    } else {
                                        value = item.code || '-';
                                    }
                                    if (itemsToDisplay.length > 1) {
                                        td.attr('rowspan', itemsToDisplay.length);
                                    }
                                    // Mark reversal rows with special class
                                    if (isReversalEntry) {
                                        td.css('font-style', 'italic');
                                    }
                                } else {
                                    // Skip this cell - it's spanned from the first row
                                    return;
                                }
                            } else if (header.field === 'payee') {
                                // PAYEE - show only on first occurrence of this payee in the items array, span all items with same payee_id
                                if (isFirstPayeeOccurrence) {
                                    if (payee) {
                                        value = payee.payee_name || '-';
                                    } else {
                                        // No payee linked, show from employees or main payee_name
                                        if (item.employees && item.employees.length > 0) {
                                            const emp = item.employees[0];
                                            if (emp.employee_no && emp.employee_name) {
                                                value = emp.employee_no + ' - ' + emp.employee_name;
                                            } else {
                                                value = emp.employee_no || emp.employee_name || '-';
                                            }
                                        } else {
                                            value = item.payee_name || '-';
                                        }
                                    }
                                    // Always set rowspan if there are multiple items with this payee_id
                                    // This ensures the payee spans all rows that belong to it
                                    if (payeeRowspan > 1) {
                                        td.attr('rowspan', payeeRowspan);
                                    }
                                } else {
                                    // Skip this cell - it's spanned from the first occurrence of this payee
                                    return;
                                }
                            } else if (header.field === 'account') {
                                // ACCOUNT - show account for this item
                                if (lineItem.account_master) {
                                    value = lineItem.account_master.account_name || '';
                                } else if (item.account_master) {
                                    value = item.account_master.account_name || '';
                                }
                                if (!value) value = '-';
                            } else if (header.field === 'iou_no') {
                                // IOU NO - show only on first row of movement, span all items
                                if (globalRowIndex === 0) {
                                    value = iouCode || '-';
                                    if (itemsToDisplay.length > 1) {
                                        td.attr('rowspan', itemsToDisplay.length);
                                    }
                                } else {
                                    // Skip this cell - it's spanned from the first row
                                    return;
                                }
                            } else if (header.field === 'description') {
                                // DESCRIPTION - show memo for this item, or IOU description, or item remarks
                                // For reversal entries, show main record item memo and reverse reason only
                                if (isReversalEntry) {
                                    // Get memo from the original movement's item
                                    const memoParts = [];
                                    // Always prefix with "REVERSAL:" and include reversal code
                                    const reversalCode = item.code || '-';
                                    memoParts.push('REVERSAL (' + reversalCode + ')');
                                    if (lineItem.memo) {
                                        memoParts.push(lineItem.memo);
                                    }
                                    // Get reversal reason from reversal entry
                                    if (item.reversal_reason) {
                                        memoParts.push('(' + item.reversal_reason + ')');
                                    } else if (item.remarks) {
                                        // If no reversal_reason, try to extract from remarks (fallback)
                                        const reversalMatch = item.remarks.match(/Reversal:\s*(.+)/);
                                        if (reversalMatch && reversalMatch[1]) {
                                            memoParts.push('(' + reversalMatch[1] + ')');
                                        }
                                    }
                                    value = memoParts.length > 0 ? memoParts.join(': ') : 'REVERSAL (' + reversalCode + ')';
                                    td.addClass('text-danger font-italic');
                                    td.css('font-style', 'italic');
                                } else if (lineItem.memo) {
                                    value = lineItem.memo;
                                } else if (item.remarks) {
                                    value = item.remarks;
                                } else {
                                    value = iouDescription || '-';
                                }
                            } else if (header.field === 'date') {
                                // DATE - show created_at or received_at
                                value = item.created_at ? formatDate(item.created_at) : (item.received_at ? formatDate(item.received_at) : '-');
                            } else if (header.field === 'amount') {
                                // AMOUNT - show amount for this item
                                // For reversal entries, amount is already negative from backend
                                let itemAmount = 0;
                                if (isReversalEntry) {
                                    // For reversal entries, use the negative amount from the reversal entry itself
                                    // The amount should be based on the original item amount but negative
                                    itemAmount = -Math.abs(lineItem.amount || 0);
                                } else {
                                    itemAmount = parseFloat(lineItem.amount) || 0;
                                }
                                value = formatMoney(itemAmount);
                                totalAmount += itemAmount;
                                // Add class for reversal entries to style them differently if needed
                                if (isReversalEntry) {
                                    td.addClass('reversal-amount text-danger');
                                }
                            } else {
                                value = '-';
                            }
                            
                            td.text(value);
                            if (header.align === 'right') {
                                td.addClass('text-right');
                            }
                            row.append(td);
                        });
                        
                        tbody.append(row);
                        globalRowIndex++;
                    });
                    // Increment movement index after all items of this movement are processed
                    // This ensures the next movement gets a different color
                    movementRowIndex++;
                } else {
                    // Regular row display (non-Payment section or no items)
                    const row = $('<tr></tr>');
                    // Apply odd/even row colors based on actual data row index
                    if (dataRowIndex % 2 === 0) {
                        // Even row (0, 2, 4, ...) - white background
                        row.css('background-color', '#ffffff');
                    } else {
                        // Odd row (1, 3, 5, ...) - light gray background
                        row.css('background-color', '#f9fafb');
                    }
                    // Check if this is a receipt reversal entry
                    const isReceiptReversal = item.is_reversal_entry || false;
                    
                    // Check if this is IOU Settlement by checking if settlement_code or original_iou fields exist in headers
                    const isIOUSettlement = headers.some(function(h) {
                        return h.field === 'settlement_code' || h.field === 'original_iou';
                    });
                    
                    // Check if this is Payment section by checking if iou_no field exists in headers
                    const isPaymentSection = headers.some(function(h) {
                        return h.field === 'iou_no';
                    });
                    
                    // Check if this original entry has a reversal entry (next item in list is its reversal)
                    const hasReversalEntry = !isReversalEntry && !isReceiptReversal && itemIndex < flattenedData.length - 1 && 
                        (flattenedData[itemIndex + 1].is_reversal_entry || flattenedData[itemIndex + 1].reversed_transaction_id === item.id);
                    
                    headers.forEach(function(header) {
                        const td = $('<td></td>');
                        let value = '-';
                        
                        if (header.field === 'code') {
                            // For reversal entries (both payment and receipt), prefix with "REV-" to clearly mark as reversal
                            if (isReversalEntry || isReceiptReversal) {
                                value = 'REV-' + (item.code || '-');
                                td.addClass('reversal-entry text-danger font-italic');
                                td.css('font-style', 'italic');
                                // Add tooltip indicating this is a reverse entry
                                td.attr('title', 'Reverse entry - This entry reverses the transaction above');
                            } else {
                                value = item.code || '-';
                                // If this original entry has a reversal, add indicator
                                if (hasReversalEntry) {
                                    td.attr('title', 'With reversal entry - A reversal entry follows this transaction');
                                    // Use html() instead of text() to render the badge
                                    td.html(value + ' <span class="badge badge-warning badge-sm" style="font-size: 0.7em; margin-left: 5px;">with reversal</span>');
                                    value = null; // Mark that we've already set the HTML
                                }
                            }
                        } else if (header.field === 'settlement_code') {
                        // For IOU Settlement: show settlement code from iouSettlement
                        // Check both camelCase and snake_case for Laravel JSON response
                        const iouSettlement = item.iou_settlement || item.iouSettlement;
                        if (iouSettlement && iouSettlement.code) {
                            value = iouSettlement.code;
                        } else if (item.remarks) {
                            // Parse from remarks if relationship not loaded
                            // Format: "IOU Settlement - Settlement: IOU-STL/26/J/1015 (expense_claim), Original IOU: IOU/26/J/1007, Settlement Amount: 15000"
                            const settlementMatch = item.remarks.match(/Settlement:\s*([^\s,\(]+)/);
                            if (settlementMatch && settlementMatch[1]) {
                                value = settlementMatch[1];
                            } else {
                                value = item.code || '-';
                            }
                        } else {
                            value = item.code || '-';
                        }
                    } else if (header.field === 'original_iou') {
                        // For IOU Settlement: show original IOU code from cashMovement relationship
                        // Check both camelCase and snake_case for Laravel JSON response
                        const iouSettlement = item.iou_settlement || item.iouSettlement;
                        if (iouSettlement) {
                            const cashMovement = iouSettlement.cash_movement || iouSettlement.cashMovement;
                            if (cashMovement && cashMovement.code) {
                                value = cashMovement.code;
                            } else if (item.remarks) {
                                // Parse from remarks if relationship not loaded
                                // Format: "IOU Settlement - Settlement: IOU-STL/26/J/1015 (expense_claim), Original IOU: IOU/26/J/1007, Settlement Amount: 15000"
                                const originalIouMatch = item.remarks.match(/Original IOU:\s*([^\s,]+)/);
                                if (originalIouMatch && originalIouMatch[1]) {
                                    value = originalIouMatch[1];
                                } else {
                                    value = '-';
                                }
                            } else {
                                value = '-';
                            }
                        } else if (item.remarks) {
                            // Parse from remarks if relationship not loaded
                            const originalIouMatch = item.remarks.match(/Original IOU:\s*([^\s,]+)/);
                            if (originalIouMatch && originalIouMatch[1]) {
                                value = originalIouMatch[1];
                            } else {
                                value = '-';
                            }
                        } else {
                            value = '-';
                        }
                    } else if (header.field === 'name') {
                        value = item.payee_name || (item.source && item.source.name) || '-';
                    } else if (header.field === 'payee') {
                        // Display all payees and employees if multiple
                        let allNames = [];
                        
                        // Add payees
                        if (item.payees && item.payees.length > 0) {
                            item.payees.forEach(function(payee) {
                                if (payee.payee_name && allNames.indexOf(payee.payee_name) === -1) {
                                    allNames.push(payee.payee_name);
                                }
                            });
                        }
                        
                        // Add employees
                        if (item.employees && item.employees.length > 0) {
                            item.employees.forEach(function(employee) {
                                let empName = '';
                                if (employee.employee_no && employee.employee_name) {
                                    empName = employee.employee_no + ' - ' + employee.employee_name;
                                } else if (employee.employee_no) {
                                    empName = employee.employee_no;
                                } else if (employee.employee_name) {
                                    empName = employee.employee_name;
                                } else {
                                    empName = 'Emp #' + (employee.employee_id || '');
                                }
                                if (empName && allNames.indexOf(empName) === -1) {
                                    allNames.push(empName);
                                }
                            });
                        }
                        
                        // Fallback to main payee_name if no payees/employees
                        if (allNames.length === 0) {
                            value = item.payee_name || '-';
                        } else {
                            value = allNames.join(', ');
                        }
                    } else if (header.field === 'account') {
                        // Display account master information from items (multiple accounts per movement)
                        // Check if this is Payment section by checking if iou_no field exists in headers
                        const isPaymentSection = headers.some(function(h) {
                            return h.field === 'iou_no';
                        });
                        
                        let accountParts = [];
                        
                        // Check if movement has items with accounts
                        if (item.items && item.items.length > 0) {
                            item.items.forEach(function(lineItem) {
                                if (lineItem.account_master) {
                                    // For Payment section: show only account_name (without code)
                                    // For other sections: show account_name with code
                                    let accountInfo;
                                    if (isPaymentSection) {
                                        accountInfo = lineItem.account_master.account_name || '';
                                    } else {
                                        accountInfo = lineItem.account_master.account_name || lineItem.account_master.code || '';
                                        if (lineItem.account_master.code && lineItem.account_master.account_name) {
                                            accountInfo += ' (' + lineItem.account_master.code + ')';
                                        }
                                    }
                                    if (accountInfo && accountParts.indexOf(accountInfo) === -1) {
                                        accountParts.push(accountInfo);
                                    }
                                }
                            });
                        }
                        
                        // Fallback to main account_master if no items
                        if (accountParts.length === 0 && item.account_master) {
                            // For Payment section: show only account_name (without code)
                            // For other sections: show account_name with code
                            let accountInfo;
                            if (isPaymentSection) {
                                accountInfo = item.account_master.account_name || '';
                            } else {
                                accountInfo = item.account_master.account_name || item.account_master.code || '';
                                if (item.account_master.code && item.account_master.account_name) {
                                    accountInfo += ' (' + item.account_master.code + ')';
                                }
                            }
                            if (accountInfo) {
                                accountParts.push(accountInfo);
                            }
                        }
                        
                        value = accountParts.length > 0 ? accountParts.join(', ') : '-';
                    } else if (header.field === 'iou_no') {
                        // Show IOU NO if movement is IOU-based petty cash
                        // First try to get from iou_settlement relationship
                        let iouCode = null;
                        const iouSettlement = item.iou_settlement || item.iouSettlement;
                        if (iouSettlement) {
                            const cashMovement = iouSettlement.cash_movement || iouSettlement.cashMovement;
                            if (cashMovement && cashMovement.code) {
                                iouCode = cashMovement.code;
                            }
                        }
                        
                        // If not found from relationship, try to parse from remarks
                        // Format: "IOU Expense Claim Settlement - Settlement: IOU-STL/26/J/1015, Original IOU: IOU/26/J/1007"
                        if (!iouCode && item.remarks) {
                            const originalIouMatch = item.remarks.match(/Original IOU:\s*([^\s,]+)/);
                            if (originalIouMatch && originalIouMatch[1]) {
                                iouCode = originalIouMatch[1];
                            }
                        }
                        
                        value = iouCode || '-';
                    } else if (header.field === 'description') {
                        // For receipt reversal entries, show reversal code, original code, and reason
                        if (isReceiptReversal && !isIOUSettlement && !isPaymentSection) {
                            const memoParts = [];
                            const reversalCode = item.code || '-';
                            memoParts.push('REVERSAL (' + reversalCode + ')');
                            
                            // Get original receipt code from previous item (reversal is placed right after original)
                            let originalCode = '-';
                            if (itemIndex > 0 && flattenedData[itemIndex - 1] && !flattenedData[itemIndex - 1].is_reversal_entry) {
                                originalCode = flattenedData[itemIndex - 1].code || '-';
                            } else if (item.reversed_transaction_id) {
                                // Fallback: try to find original in the list
                                const originalReceipt = flattenedData.find(function(r) {
                                    return r.id === item.reversed_transaction_id && !r.is_reversal_entry;
                                });
                                if (originalReceipt) {
                                    originalCode = originalReceipt.code || '-';
                                }
                            }
                            
                            if (originalCode && originalCode !== '-') {
                                memoParts.push('Original: ' + originalCode);
                            }
                            
                            if (item.reversal_reason) {
                                memoParts.push('(' + item.reversal_reason + ')');
                            } else if (item.remarks) {
                                // Try to extract from remarks if available
                                const reversalMatch = item.remarks.match(/Reversal:\s*(.+)/);
                                if (reversalMatch && reversalMatch[1]) {
                                    memoParts.push('(' + reversalMatch[1] + ')');
                                } else {
                                    memoParts.push(item.remarks);
                                }
                            }
                            value = memoParts.join(': ');
                            td.addClass('text-danger font-italic');
                            td.css('font-style', 'italic');
                        } else if (isReversalEntry) {
                            const memoParts = [];
                            // Always prefix with "REVERSAL:" and include reversal code
                            const reversalCode = item.code || '-';
                            memoParts.push('REVERSAL (' + reversalCode + ')');
                            // Get item memos from original movement if available
                            if (originalMovement && originalMovement.items && originalMovement.items.length > 0) {
                                let itemMemos = [];
                                originalMovement.items.forEach(function(origItem) {
                                    if (origItem.memo && itemMemos.indexOf(origItem.memo) === -1) {
                                        itemMemos.push(origItem.memo);
                                    }
                                });
                                if (itemMemos.length > 0) {
                                    memoParts.push(itemMemos.join('; '));
                                }
                            } else if (item.items && item.items.length > 0) {
                                // Fallback: try to get from reversal entry's items if available
                                let itemMemos = [];
                                item.items.forEach(function(revItem) {
                                    if (revItem.memo && itemMemos.indexOf(revItem.memo) === -1) {
                                        itemMemos.push(revItem.memo);
                                    }
                                });
                                if (itemMemos.length > 0) {
                                    memoParts.push(itemMemos.join('; '));
                                }
                            }
                            // Get reversal reason from reversal entry
                            if (item.reversal_reason) {
                                memoParts.push('(' + item.reversal_reason + ')');
                            } else if (item.remarks) {
                                // If no reversal_reason, try to extract from remarks (fallback)
                                const reversalMatch = item.remarks.match(/Reversal:\s*(.+)/);
                                if (reversalMatch && reversalMatch[1]) {
                                    memoParts.push('(' + reversalMatch[1] + ')');
                                }
                            }
                            value = memoParts.length > 0 ? memoParts.join(': ') : 'REVERSAL (' + reversalCode + ')';
                            td.addClass('text-danger font-italic');
                            td.css('font-style', 'italic');
                        } else {
                            // For IOU Settlement: show original IOU remarks from iou_settlement.cash_movement.remarks
                        if (isIOUSettlement) {
                            // Check both camelCase and snake_case for Laravel JSON response
                            const iouSettlement = item.iou_settlement || item.iouSettlement;
                            if (iouSettlement) {
                                const cashMovement = iouSettlement.cash_movement || iouSettlement.cashMovement;
                                if (cashMovement && cashMovement.remarks) {
                                    value = cashMovement.remarks;
                                } else {
                                    // If no original IOU remarks, show empty or '-'
                                    value = '-';
                                }
                            } else {
                                // If no settlement found, show empty or '-'
                                value = '-';
                            }
                        } else if (isPaymentSection) {
                            // For Payment section: show item memos if available, otherwise original IOU remarks, otherwise main remark
                            // If movement has items, show item memos (comma-separated if multiple)
                            if (item.items && item.items.length > 0) {
                                let itemMemos = [];
                                item.items.forEach(function(lineItem) {
                                    if (lineItem.memo && itemMemos.indexOf(lineItem.memo) === -1) {
                                        itemMemos.push(lineItem.memo);
                                    }
                                });
                                if (itemMemos.length > 0) {
                                    value = itemMemos.join('; ');
                                } else {
                                    // No memos in items, check IOU settlement or main remarks
                                    const iouSettlement = item.iou_settlement || item.iouSettlement;
                                    if (iouSettlement) {
                                        const cashMovement = iouSettlement.cash_movement || iouSettlement.cashMovement;
                                        if (cashMovement && cashMovement.remarks) {
                                            value = cashMovement.remarks;
                                        } else {
                                            value = item.remarks || '-';
                                        }
                                    } else {
                                        value = item.remarks || '-';
                                    }
                                }
                            } else {
                                // No items, show original IOU remarks if available, otherwise main remark
                                const iouSettlement = item.iou_settlement || item.iouSettlement;
                                if (iouSettlement) {
                                    const cashMovement = iouSettlement.cash_movement || iouSettlement.cashMovement;
                                    if (cashMovement && cashMovement.remarks) {
                                        value = cashMovement.remarks;
                                    } else {
                                        value = item.remarks || '-';
                                    }
                                } else {
                                    value = item.remarks || '-';
                                }
                            }
                        } else {
                            // For receipt reversal entries, show reversal code, original code, and reason
                            if (isReceiptReversal) {
                                const memoParts = [];
                                const reversalCode = item.code || '-';
                                memoParts.push('REVERSAL (' + reversalCode + ')');
                                
                                // Get original receipt code from previous item (reversal is placed right after original)
                                let originalCode = '-';
                                if (itemIndex > 0 && flattenedData[itemIndex - 1] && !flattenedData[itemIndex - 1].is_reversal_entry) {
                                    originalCode = flattenedData[itemIndex - 1].code || '-';
                                } else if (item.reversed_transaction_id) {
                                    // Fallback: try to find original in the list
                                    const originalReceipt = flattenedData.find(function(r) {
                                        return r.id === item.reversed_transaction_id && !r.is_reversal_entry;
                                    });
                                    if (originalReceipt) {
                                        originalCode = originalReceipt.code || '-';
                                    }
                                }
                                
                                if (originalCode && originalCode !== '-') {
                                    memoParts.push('Original: ' + originalCode);
                                }
                                
                                if (item.reversal_reason) {
                                    memoParts.push('(' + item.reversal_reason + ')');
                                } else if (item.remarks) {
                                    // Try to extract from remarks if available
                                    const reversalMatch = item.remarks.match(/Reversal:\s*(.+)/);
                                    if (reversalMatch && reversalMatch[1]) {
                                        memoParts.push('(' + reversalMatch[1] + ')');
                                    } else {
                                        memoParts.push(item.remarks);
                                    }
                                }
                                value = memoParts.join(': ');
                                td.addClass('text-danger font-italic');
                                td.css('font-style', 'italic');
                            } else {
                                // For other sections (not IOU Settlement, not Payment), build description from various sources
                                let descriptionParts = [];
                            
                            // Add employee information if available
                            if (item.employees && item.employees.length > 0) {
                                let employeeInfo = [];
                                item.employees.forEach(function(employee) {
                                    let empDesc = employee.employee_no || ('Emp #' + (employee.employee_id || ''));
                                    if (employee.employee_type) {
                                        empDesc += ' (' + employee.employee_type + ')';
                                    }
                                    if (employee.remark) {
                                        empDesc += ' - ' + employee.remark;
                                    }
                                    employeeInfo.push(empDesc);
                                });
                                if (employeeInfo.length > 0) {
                                    descriptionParts.push('Employees: ' + employeeInfo.join(', '));
                                }
                            }
                        
                        // Add supplier job information if available (from outsource supplier advance payments)
                        if (item.supplier_jobs && item.supplier_jobs.length > 0) {
                            let supplierJobInfo = [];
                            item.supplier_jobs.forEach(function(supplierJob) {
                                let jobDesc = '';
                                if (supplierJob.supplier_job) {
                                    jobDesc = supplierJob.supplier_job.code || supplierJob.supplier_job.job_name || '';
                                    if (supplierJob.supplier_job.job_name && supplierJob.supplier_job.code) {
                                        jobDesc = supplierJob.supplier_job.job_name + ' (' + supplierJob.supplier_job.code + ')';
                                    }
                                }
                                if (supplierJob.advance_amount) {
                                    if (jobDesc) {
                                        jobDesc += ' - ' + formatMoney(supplierJob.advance_amount);
                                    } else {
                                        jobDesc = 'Advance: ' + formatMoney(supplierJob.advance_amount);
                                    }
                                }
                                if (supplierJob.remarks) {
                                    if (jobDesc) {
                                        jobDesc += ' - ' + supplierJob.remarks;
                                    } else {
                                        jobDesc = supplierJob.remarks;
                                    }
                                }
                                if (jobDesc) {
                                    supplierJobInfo.push(jobDesc);
                                }
                            });
                            if (supplierJobInfo.length > 0) {
                                descriptionParts.push('Supplier Jobs: ' + supplierJobInfo.join('; '));
                            }
                        }
                        
                        // Add item memos/details if available (accounts are shown in separate column)
                        if (item.items && item.items.length > 0) {
                            let itemDescriptions = [];
                            item.items.forEach(function(lineItem) {
                                if (lineItem.memo) {
                                    if (itemDescriptions.indexOf(lineItem.memo) === -1) {
                                        itemDescriptions.push(lineItem.memo);
                                    }
                                }
                            });
                            if (itemDescriptions.length > 0) {
                                descriptionParts.push(itemDescriptions.join('; '));
                            }
                        }
                        
                        // Add source name if available
                        if (item.source && item.source.name) {
                            if (descriptionParts.length > 0) {
                                descriptionParts.push(item.source.name);
                            } else {
                                descriptionParts.push(item.source.name);
                            }
                        }
                        
                        // Add remarks if available
                        if (item.remarks) {
                            if (descriptionParts.length > 0) {
                                descriptionParts.push(item.remarks);
                            } else {
                                descriptionParts.push(item.remarks);
                            }
                        }
                        
                        // For receipts: use transaction_type or doc_id
                        if (item.transaction_type) {
                            if (descriptionParts.length > 0) {
                                descriptionParts.push(item.transaction_type);
                            } else {
                                descriptionParts.push(item.transaction_type);
                            }
                            if (item.doc_id) {
                                descriptionParts.push('(Doc #' + item.doc_id + ')');
                            }
                        }
                        
                        value = descriptionParts.length > 0 ? descriptionParts.join(' | ') : '-';
                            }
                        }
                    }
                    } else if (header.field === 'amount') {
                        // If movement has items, show breakdown or total
                        // For reversal entries, amount should be negative
                        let amountValue = 0;
                        if (item.items && item.items.length > 0) {
                            let itemTotal = 0;
                            item.items.forEach(function(lineItem) {
                                const lineAmount = parseFloat(lineItem.amount) || 0;
                                itemTotal += lineAmount;
                            });
                            amountValue = itemTotal;
                            
                            // Add title attribute for hover tooltip showing breakdown if multiple items
                            if (item.items.length > 1) {
                                let breakdown = [];
                                item.items.forEach(function(lineItem) {
                                    const lineAmount = parseFloat(lineItem.amount) || 0;
                                    let lineDesc = '';
                                    if (lineItem.account_master) {
                                        lineDesc = (lineItem.account_master.account_name || lineItem.account_master.code || '') + ': ';
                                    }
                                    if (lineItem.memo) {
                                        lineDesc += lineItem.memo + ' ';
                                    }
                                    breakdown.push((lineDesc || 'Item') + formatMoney(lineAmount));
                                });
                                td.attr('title', breakdown.join('\n'));
                                td.css('cursor', 'help');
                            }
                        } else {
                            amountValue = parseFloat(item.amount) || 0;
                        }
                        
                        // For reversal entries (both payment and receipt), make amount negative
                        // Note: Receipt reversals already have negative amounts from backend, but ensure it's negative
                        if (isReversalEntry || isReceiptReversal) {
                            amountValue = -Math.abs(amountValue);
                        }
                        
                        value = formatMoney(amountValue);
                        totalAmount += amountValue;
                        
                        // Add class for reversal entries to style them differently if needed
                        if (isReversalEntry || isReceiptReversal) {
                            td.addClass('reversal-amount text-danger');
                        }
                    } else if (header.field === 'date') {
                        value = item.created_at ? formatDate(item.created_at) : (item.received_at ? formatDate(item.received_at) : '-');
                    } else if (header.field === 'remarks') {
                        value = item.remarks || '-';
                    }
                    
                    // Only set text if value is not null (HTML was already set for badge)
                    if (value !== null && value !== undefined) {
                        td.text(value);
                    }
                    if (header.align === 'right') {
                        td.addClass('text-right');
                    }
                    row.append(td);
                });
                tbody.append(row);
                dataRowIndex++; // Increment data row index for odd/even tracking
                }
            });
            
            // Add total row
            if (totalAmount > 0) {
                const totalRow = $('<tr></tr>').addClass('total-row');
                headers.forEach(function(header, index) {
                    const td = $('<td></td>');
                    if (index === headers.length - 1) {
                        // Last column (amount)
                        td.addClass('text-right').text(formatMoney(totalAmount));
                    } else if (index === headers.length - 2) {
                        // Second to last column (usually description)
                        td.text('Total');
                    } else {
                        td.text('');
                    }
                    totalRow.append(td);
                });
                tbody.append(totalRow);
            }
        } else {
            const emptyRow = $('<tr></tr>');
            const emptyCell = $('<td></td>').attr('colspan', headers.length).addClass('text-center text-muted').text('No details available');
            emptyRow.append(emptyCell);
            tbody.append(emptyRow);
        }
        
        table.append(tbody);
        return table;
    }


    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    function formatDateTime(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleString('en-US', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        });
    }

    function toggleSeries2AndTotal() {
        if (showSeries2) {
            $('.series-2-section').addClass('show').show();
            $('.series-2-row').show();
            $('.series-2-value').show();
        } else {
            $('.series-2-section').removeClass('show').hide();
            $('.series-2-row').hide();
            $('.series-2-value').hide();
        }

        if (showTotal) {
            $('.total-section').addClass('show').show();
            $('.total-value').show();
        } else {
            $('.total-section').removeClass('show').hide();
            $('.total-value').hide();
        }
    }

    function formatMoney(amount) {
        if (amount === null || amount === undefined || isNaN(amount)) return '0.00';
        const num = parseFloat(amount);
        if (isNaN(num)) return '0.00';
        return num.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Store current cash book data for export
    let currentCashBookData = null;
    let currentShiftCode = '';

    // Update renderCashBook to store data
    const originalRenderCashBook = renderCashBook;
    renderCashBook = function(data) {
        currentCashBookData = data;
        // Get shift code from select
        const selectedOption = $('#shiftSelect option:selected');
        if (selectedOption.length > 0) {
            currentShiftCode = selectedOption.text().split(' - ')[0] || 'CashBook';
        }
        originalRenderCashBook(data);
    };

    // Export to PDF
    function exportToPDF() {
        if (!currentCashBookData) {
            error_toastify('No data available to export. Please load cash book first.');
            return;
        }

        // Load jsPDF and autoTable libraries dynamically
        if (typeof window.jsPDF === 'undefined') {
            const script1 = document.createElement('script');
            script1.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
            script1.onload = function() {
                const script2 = document.createElement('script');
                script2.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js';
                script2.onload = function() {
                    generatePDF();
                };
                document.head.appendChild(script2);
            };
            document.head.appendChild(script1);
        } else if (typeof window.jspdf !== 'undefined' && typeof window.jspdf.API.autoTable === 'undefined') {
            const script2 = document.createElement('script');
            script2.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js';
            script2.onload = function() {
                generatePDF();
            };
            document.head.appendChild(script2);
        } else {
            generatePDF();
        }
    }

    function generatePDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'mm', 'a4');
        const pageWidth = doc.internal.pageSize.getWidth();
        const margin = 15;

        // Title
        doc.setFontSize(18);
        doc.setFont(undefined, 'bold');
        doc.text('Cash Book Report', pageWidth / 2, 20, { align: 'center' });

        // Shift Info
        doc.setFontSize(11);
        doc.setFont(undefined, 'normal');
        doc.text('Shift: ' + currentShiftCode, margin, 30);
        doc.text('Date: ' + new Date().toLocaleDateString(), pageWidth - margin, 30, { align: 'right' });

        // Determine which series to export
        const seriesToExport = $('#seriesTabs').is(':visible') ? 
            ($('.nav-tabs .nav-link.active').attr('id') === 'series1-tab' ? 'series1' : 'series2') : 
            'series1';

        // Generate PDF content with proper layout
        generatePDFContent(doc, currentCashBookData, seriesToExport, pageWidth, margin);

        // Save PDF
        const fileName = 'CashBook_' + currentShiftCode + '_' + new Date().toISOString().split('T')[0] + '.pdf';
        doc.save(fileName);
    }

    function generatePDFContent(doc, data, series, pageWidth, margin) {
        let startY = 40;
        const seriesKey = series === 'series1' ? 'series_1' : 'series_2';

        // Opening Balance Section
        doc.setFontSize(14);
        doc.setFont(undefined, 'bold');
        doc.text('OPENING BALANCE', margin, startY);
        startY += 8;
        
        doc.setFontSize(12);
        doc.setFont(undefined, 'normal');
        const openingBalance = data.opening_balance && data.opening_balance[seriesKey] !== undefined ? 
            data.opening_balance[seriesKey] : 0;
        doc.text(formatMoney(openingBalance), margin + 10, startY);
        startY += 15;

        // Receipt Section
        const receiptsData = data.receipts?.[seriesKey];
        if (receiptsData) {
            const receiptsDetails = receiptsData.details || {};
            startY = addPDFSection(doc, 'RECEIPT', receiptsData, receiptsDetails, 'receipts', startY, pageWidth, margin);
        }

        // Cash In Section
        const cashInData = data.cash_in?.[seriesKey];
        if (cashInData) {
            const cashInDetails = cashInData.details || [];
            startY = addPDFSection(doc, 'CASH IN', cashInData, cashInDetails, 'cash_in', startY, pageWidth, margin);
        }

        // IOU Settlement Section
        const iouSettlementsData = data.iou_settlements?.[seriesKey];
        if (iouSettlementsData) {
            const iouSettlementsDetails = iouSettlementsData.details || [];
            startY = addPDFSection(doc, 'IOU SETTLEMENT', iouSettlementsData, iouSettlementsDetails, 'iou_settlements', startY, pageWidth, margin);
        }

        // IOU Section
        const iousData = data.ious?.[seriesKey];
        if (iousData) {
            const iousDetails = iousData.details || [];
            startY = addPDFSection(doc, 'IOU', iousData, iousDetails, 'ious', startY, pageWidth, margin);
        }

        // Payment Section
        const paymentData = data.cash_out?.[seriesKey];
        if (paymentData) {
            const paymentDetails = paymentData.details || [];
            startY = addPDFSection(doc, 'PAYMENT', paymentData, paymentDetails, 'payment', startY, pageWidth, margin);
        }

        // Closing Balance Section
        const closingBalanceObj = data.closing_balance && data.closing_balance[seriesKey] ? 
            data.closing_balance[seriesKey] : null;
        const closingBalance = closingBalanceObj && closingBalanceObj.calculated !== undefined ? 
            closingBalanceObj.calculated : 0;
        if (doc.lastAutoTable && doc.lastAutoTable.finalY) {
            startY = doc.lastAutoTable.finalY + 15;
        }
        
        if (startY > 250) {
            doc.addPage();
            startY = 20;
        }

        doc.setFontSize(14);
        doc.setFont(undefined, 'bold');
        doc.text('CLOSING BALANCE (CASH IN HAND)', margin, startY);
        startY += 8;
        
        doc.setFontSize(12);
        doc.setFont(undefined, 'normal');
        doc.text(formatMoney(closingBalance || 0), margin + 10, startY);
    }

    function addPDFSection(doc, sectionTitle, sectionData, details, sectionType, startY, pageWidth, margin) {
        // Check if we need a new page
        if (startY > 250) {
            doc.addPage();
            startY = 20;
        }

        // Section Header
        doc.setFontSize(14);
        doc.setFont(undefined, 'bold');
        doc.text(sectionTitle, margin, startY);
        startY += 8;

        // Section Total
        doc.setFontSize(11);
        doc.setFont(undefined, 'normal');
        doc.text('Total: ' + formatMoney(sectionData?.total || 0), margin + 10, startY);
        startY += 10;

        // Create table for details
        if (details && Array.isArray(details) && details.length > 0) {
            const tableData = prepareTableData(details, sectionType);
            if (tableData && tableData.length > 0) {
                doc.autoTable({
                    startY: startY,
                    head: [tableData.headers],
                    body: tableData.rows,
                    margin: { left: margin, right: margin },
                    styles: { fontSize: 8, cellPadding: 2 },
                    headStyles: { fillColor: [37, 99, 235], textColor: 255, fontStyle: 'bold' },
                    alternateRowStyles: { fillColor: [249, 250, 251] },
                    columnStyles: tableData.columnStyles || {},
                    didDrawPage: function(data) {
                        // Reset startY after table
                        startY = data.cursor.y + 10;
                    }
                });
                startY = doc.lastAutoTable.finalY + 10;
            }
        } else if (details && details.receipts && Array.isArray(details.receipts) && details.receipts.length > 0) {
            // For receipts, details is an object with receipts array
            const tableData = prepareTableData(details.receipts, 'receipts');
            if (tableData && tableData.length > 0) {
                doc.autoTable({
                    startY: startY,
                    head: [tableData.headers],
                    body: tableData.rows,
                    margin: { left: margin, right: margin },
                    styles: { fontSize: 8, cellPadding: 2 },
                    headStyles: { fillColor: [37, 99, 235], textColor: 255, fontStyle: 'bold' },
                    alternateRowStyles: { fillColor: [249, 250, 251] },
                    columnStyles: tableData.columnStyles || {}
                });
                startY = doc.lastAutoTable.finalY + 10;
            }
        }

        return startY;
    }

    function prepareTableData(details, sectionType) {
        if (!details || !Array.isArray(details) || details.length === 0) return null;

        let headers = [];
        let rows = [];
        let columnStyles = {};

        if (sectionType === 'iou_settlements') {
            headers = ['Settlement No', 'Name', 'Original IOU', 'Description', 'Amount'];
            columnStyles = { 0: { cellWidth: 30 }, 1: { cellWidth: 40 }, 2: { cellWidth: 30 }, 3: { cellWidth: 60 }, 4: { cellWidth: 25, halign: 'right' } };
            
            details.forEach(function(item) {
                const iouSettlement = item.iou_settlement || item.iouSettlement;
                const settlementCode = iouSettlement?.code || item.code || '-';
                const originalIou = iouSettlement?.cash_movement?.code || '-';
                const description = iouSettlement?.cash_movement?.remarks || item.remarks || '-';
                rows.push([
                    settlementCode,
                    item.payee_name || '-',
                    originalIou,
                    description,
                    formatMoney(item.amount || 0)
                ]);
            });
        } else if (sectionType === 'payment' || sectionType === 'cash_in') {
            headers = ['Voucher NO', 'IOU NO', 'Payee', 'Account', 'Description', 'Amount'];
            columnStyles = { 0: { cellWidth: 25 }, 1: { cellWidth: 25 }, 2: { cellWidth: 35 }, 3: { cellWidth: 35 }, 4: { cellWidth: 50 }, 5: { cellWidth: 25, halign: 'right' } };
            
            details.forEach(function(item) {
                // Handle items with multiple line items - group by movement
                if (item.items && item.items.length > 0) {
                    // Sort items by payee_id to group them
                    const sortedItems = item.items.slice().sort(function(a, b) {
                        const payeeIdA = a.payee_id || 'no_payee';
                        const payeeIdB = b.payee_id || 'no_payee';
                        if (payeeIdA < payeeIdB) return -1;
                        if (payeeIdA > payeeIdB) return 1;
                        return 0;
                    });

                    const iouSettlement = item.iou_settlement || item.iouSettlement;
                    const iouCode = iouSettlement?.cash_movement?.code || '-';
                    const payeeMap = {};
                    if (item.payees && item.payees.length > 0) {
                        item.payees.forEach(function(payee) {
                            payeeMap[payee.id] = payee.payee_name;
                        });
                    }

                    // Group items by payee to show payee only on first occurrence
                    const itemsByPayee = {};
                    sortedItems.forEach(function(lineItem) {
                        const payeeId = lineItem.payee_id || 'no_payee';
                        if (!itemsByPayee[payeeId]) {
                            itemsByPayee[payeeId] = [];
                        }
                        itemsByPayee[payeeId].push(lineItem);
                    });

                    // Get employee information
                    const employeeInfo = [];
                    if (item.employees && item.employees.length > 0) {
                        item.employees.forEach(function(employee) {
                            let empName = '';
                            if (employee.employee_no && employee.employee_name) {
                                empName = employee.employee_no + ' - ' + employee.employee_name;
                            } else if (employee.employee_no) {
                                empName = employee.employee_no;
                            } else if (employee.employee_name) {
                                empName = employee.employee_name;
                            }
                            if (empName) employeeInfo.push(empName);
                        });
                    }

                    // Get supplier job information
                    const supplierJobInfo = [];
                    if (item.supplier_jobs && item.supplier_jobs.length > 0) {
                        item.supplier_jobs.forEach(function(supplierJob) {
                            let jobDesc = '';
                            if (supplierJob.supplier_job) {
                                jobDesc = supplierJob.supplier_job.code || supplierJob.supplier_job.job_name || '';
                                if (supplierJob.supplier_job.job_name && supplierJob.supplier_job.code) {
                                    jobDesc = supplierJob.supplier_job.job_name + ' (' + supplierJob.supplier_job.code + ')';
                                }
                            }
                            if (supplierJob.advance_amount) {
                                if (jobDesc) {
                                    jobDesc += ' - ' + formatMoney(supplierJob.advance_amount);
                                } else {
                                    jobDesc = 'Advance: ' + formatMoney(supplierJob.advance_amount);
                                }
                            }
                            if (supplierJob.remarks) {
                                if (jobDesc) {
                                    jobDesc += ' - ' + supplierJob.remarks;
                                } else {
                                    jobDesc = supplierJob.remarks;
                                }
                            }
                            if (jobDesc) supplierJobInfo.push(jobDesc);
                        });
                    }

                    let globalItemIndex = 0;
                    Object.keys(itemsByPayee).forEach(function(payeeId) {
                        const payeeItems = itemsByPayee[payeeId];
                        let payeeName = payeeMap[payeeId] || item.payee_name || '-';
                        
                        // Add employee info to payee if available
                        if (employeeInfo.length > 0 && globalItemIndex === 0) {
                            payeeName = payeeName + (payeeName !== '-' ? ', ' : '') + employeeInfo.join(', ');
                        }
                        
                        payeeItems.forEach(function(lineItem, payeeItemIndex) {
                            const account = lineItem.account_master?.account_name || item.account_master?.account_name || '-';
                            let description = lineItem.memo || '';
                            
                            // Add supplier job info to description
                            if (supplierJobInfo.length > 0 && globalItemIndex === 0) {
                                if (description) {
                                    description += ' | Supplier Jobs: ' + supplierJobInfo.join('; ');
                                } else {
                                    description = 'Supplier Jobs: ' + supplierJobInfo.join('; ');
                                }
                            }
                            
                            // Fallback to item remarks if no memo
                            if (!description) {
                                description = item.remarks || '-';
                            }
                            
                            rows.push([
                                globalItemIndex === 0 ? (item.code || '-') : '',
                                globalItemIndex === 0 ? iouCode : '',
                                payeeItemIndex === 0 ? payeeName : '',
                                account,
                                description,
                                formatMoney(lineItem.amount || 0)
                            ]);
                            
                            globalItemIndex++;
                        });
                    });
                } else {
                    const iouSettlement = item.iou_settlement || item.iouSettlement;
                    const iouCode = iouSettlement?.cash_movement?.code || '-';
                    
                    // Get all payees
                    let payee = item.payees?.map(p => p.payee_name).join(', ') || item.payee_name || '-';
                    
                    // Add employee information to payee
                    if (item.employees && item.employees.length > 0) {
                        const employeeInfo = [];
                        item.employees.forEach(function(employee) {
                            let empName = '';
                            if (employee.employee_no && employee.employee_name) {
                                empName = employee.employee_no + ' - ' + employee.employee_name;
                            } else if (employee.employee_no) {
                                empName = employee.employee_no;
                            } else if (employee.employee_name) {
                                empName = employee.employee_name;
                            }
                            if (empName) employeeInfo.push(empName);
                        });
                        if (employeeInfo.length > 0) {
                            payee = payee + (payee !== '-' ? ', ' : '') + employeeInfo.join(', ');
                        }
                    }
                    
                    const account = item.account_master?.account_name || '-';
                    let description = item.remarks || '-';
                    
                    // Add supplier job information to description
                    if (item.supplier_jobs && item.supplier_jobs.length > 0) {
                        const supplierJobInfo = [];
                        item.supplier_jobs.forEach(function(supplierJob) {
                            let jobDesc = '';
                            if (supplierJob.supplier_job) {
                                jobDesc = supplierJob.supplier_job.code || supplierJob.supplier_job.job_name || '';
                                if (supplierJob.supplier_job.job_name && supplierJob.supplier_job.code) {
                                    jobDesc = supplierJob.supplier_job.job_name + ' (' + supplierJob.supplier_job.code + ')';
                                }
                            }
                            if (supplierJob.advance_amount) {
                                if (jobDesc) {
                                    jobDesc += ' - ' + formatMoney(supplierJob.advance_amount);
                                } else {
                                    jobDesc = 'Advance: ' + formatMoney(supplierJob.advance_amount);
                                }
                            }
                            if (supplierJob.remarks) {
                                if (jobDesc) {
                                    jobDesc += ' - ' + supplierJob.remarks;
                                } else {
                                    jobDesc = supplierJob.remarks;
                                }
                            }
                            if (jobDesc) supplierJobInfo.push(jobDesc);
                        });
                        if (supplierJobInfo.length > 0) {
                            description = description + (description !== '-' ? ' | ' : '') + 'Supplier Jobs: ' + supplierJobInfo.join('; ');
                        }
                    }
                    
                    rows.push([
                        item.code || '-',
                        iouCode,
                        payee,
                        account,
                        description,
                        formatMoney(item.amount || 0)
                    ]);
                }
            });
        } else {
            // Receipts, IOUs
            headers = ['Code', 'Name', 'Description', 'Amount'];
            columnStyles = { 0: { cellWidth: 40 }, 1: { cellWidth: 50 }, 2: { cellWidth: 70 }, 3: { cellWidth: 30, halign: 'right' } };
            
            details.forEach(function(item) {
                rows.push([
                    item.code || '-',
                    item.payee_name || (item.source?.name || '-'),
                    item.remarks || item.transaction_type || '-',
                    formatMoney(item.amount || 0)
                ]);
            });
        }

        return {
            headers: headers,
            rows: rows,
            columnStyles: columnStyles
        };
    }

    // Export to Excel
    function exportToExcel() {
        if (!currentCashBookData) {
            error_toastify('No data available to export. Please load cash book first.');
            return;
        }

        // Load SheetJS library dynamically if not already loaded
        if (typeof window.XLSX === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js';
            script.onload = function() {
                generateExcel();
            };
            document.head.appendChild(script);
        } else {
            generateExcel();
        }
    }

    function generateExcel() {
        const wb = XLSX.utils.book_new();
        const seriesToExport = $('#seriesTabs').is(':visible') ? 
            ($('.nav-tabs .nav-link.active').attr('id') === 'series1-tab' ? 'series1' : 'series2') : 
            'series1';
        const seriesKey = seriesToExport === 'series1' ? 'series_1' : 'series_2';

        // Create a single sheet with all sections in table format (like frontend preview)
        const allData = [];

        // Header
        allData.push(['Cash Book Report']);
        allData.push(['Shift:', currentShiftCode]);
        allData.push(['Date:', new Date().toLocaleDateString()]);
        allData.push(['Series:', seriesToExport === 'series1' ? 'Series 1' : 'Series 2']);
        allData.push([]); // Empty row

        // Opening Balance Section
        allData.push(['OPENING BALANCE']);
        const openingBalance = currentCashBookData.opening_balance && currentCashBookData.opening_balance[seriesKey] !== undefined ? 
            currentCashBookData.opening_balance[seriesKey] : 0;
        allData.push(['Amount:', formatMoney(openingBalance)]);
        allData.push([]); // Empty row

        // Receipt Section
        const receiptsData = currentCashBookData.receipts?.[seriesKey];
        if (receiptsData) {
            allData.push(['RECEIPT']);
            allData.push(['Total:', formatMoney(receiptsData.total || 0)]);
            const receiptsDetails = receiptsData.details?.receipts || [];
            if (receiptsDetails.length > 0) {
                allData.push(['Code', 'Name', 'Description', 'Amount']);
                receiptsDetails.forEach(function(item) {
                    allData.push([
                        item.code || '-',
                        item.payee_name || (item.source?.name || '-'),
                        item.remarks || item.transaction_type || '-',
                        formatMoney(item.amount || 0)
                    ]);
                });
            }
            allData.push([]); // Empty row
        }

        // Cash In Section
        const cashInData = currentCashBookData.cash_in?.[seriesKey];
        if (cashInData) {
            allData.push(['CASH IN']);
            allData.push(['Total:', formatMoney(cashInData.total || 0)]);
            const cashInDetails = cashInData.details || [];
            if (cashInDetails.length > 0) {
                allData.push(['Voucher NO', 'IOU NO', 'Payee', 'Account', 'Description', 'Amount']);
                addExcelPaymentRows(allData, cashInDetails);
            }
            allData.push([]); // Empty row
        }

        // IOU Settlement Section
        const iouSettlementsData = currentCashBookData.iou_settlements?.[seriesKey];
        if (iouSettlementsData) {
            allData.push(['IOU SETTLEMENT']);
            allData.push(['Total:', formatMoney(iouSettlementsData.total || 0)]);
            const iouSettlementsDetails = iouSettlementsData.details || [];
            if (iouSettlementsDetails.length > 0) {
                allData.push(['Settlement No', 'Name', 'Original IOU', 'Description', 'Amount']);
                iouSettlementsDetails.forEach(function(item) {
                    const iouSettlement = item.iou_settlement || item.iouSettlement;
                    const settlementCode = iouSettlement?.code || item.code || '-';
                    const originalIou = iouSettlement?.cash_movement?.code || '-';
                    const description = iouSettlement?.cash_movement?.remarks || item.remarks || '-';
                    allData.push([
                        settlementCode,
                        item.payee_name || '-',
                        originalIou,
                        description,
                        formatMoney(item.amount || 0)
                    ]);
                });
            }
            allData.push([]); // Empty row
        }

        // IOU Section
        const iousData = currentCashBookData.ious?.[seriesKey];
        if (iousData) {
            allData.push(['IOU']);
            allData.push(['Total:', formatMoney(iousData.total || 0)]);
            const iousDetails = iousData.details || [];
            if (iousDetails.length > 0) {
                allData.push(['Code', 'Name', 'Description', 'Amount']);
                iousDetails.forEach(function(item) {
                    allData.push([
                        item.code || '-',
                        item.payee_name || (item.source?.name || '-'),
                        item.remarks || item.transaction_type || '-',
                        formatMoney(item.amount || 0)
                    ]);
                });
            }
            allData.push([]); // Empty row
        }

        // Payment Section
        const paymentData = currentCashBookData.cash_out?.[seriesKey];
        if (paymentData) {
            allData.push(['PAYMENT']);
            allData.push(['Total:', formatMoney(paymentData.total || 0)]);
            const paymentDetails = paymentData.details || [];
            if (paymentDetails.length > 0) {
                allData.push(['Voucher NO', 'IOU NO', 'Payee', 'Account', 'Description', 'Amount']);
                addExcelPaymentRows(allData, paymentDetails);
            }
            allData.push([]); // Empty row
        }

        // Closing Balance Section
        const closingBalanceObj = currentCashBookData.closing_balance && currentCashBookData.closing_balance[seriesKey] ? 
            currentCashBookData.closing_balance[seriesKey] : null;
        const closingBalance = closingBalanceObj && closingBalanceObj.calculated !== undefined && closingBalanceObj.calculated !== null ? 
            closingBalanceObj.calculated : 0;
        allData.push(['CLOSING BALANCE (CASH IN HAND)']);
        allData.push(['Amount:', formatMoney(closingBalance)]);

        // Create worksheet
        const ws = XLSX.utils.aoa_to_sheet(allData);

        // Track merge ranges for grouped records
        const merges = [];
        const range = XLSX.utils.decode_range(ws['!ref']);
        
        // Track groups for Payment/Cash In sections
        let voucherStartRow = -1;
        let iouStartRow = -1;
        let payeeStartRow = -1;
        let currentSection = '';
        
        // Apply styling and formatting
        for (let row = 0; row <= range.e.r; row++) {
            const cellAddress = XLSX.utils.encode_cell({ r: row, c: 0 });
            if (!ws[cellAddress]) continue;
            
            const cellValue = ws[cellAddress].v;
            
            // Check if this is a section title (all caps)
            if (typeof cellValue === 'string' && cellValue === cellValue.toUpperCase() && 
                ['OPENING BALANCE', 'RECEIPT', 'CASH IN', 'IOU SETTLEMENT', 'IOU', 'PAYMENT', 'CLOSING BALANCE (CASH IN HAND)'].includes(cellValue)) {
                if (!ws[cellAddress].s) ws[cellAddress].s = {};
                ws[cellAddress].s.font = { bold: true, sz: 14 };
                ws[cellAddress].s.fill = { fgColor: { rgb: 'E3F2FD' } };
                
                // Reset tracking when entering new section
                if (cellValue === 'PAYMENT' || cellValue === 'CASH IN') {
                    currentSection = cellValue;
                    voucherStartRow = -1;
                    iouStartRow = -1;
                    payeeStartRow = -1;
                } else {
                    currentSection = '';
                }
            }
            
            // Style table headers (row after section title that contains column names)
            const nextRow = row + 1;
            if (nextRow <= range.e.r) {
                const nextCellAddress = XLSX.utils.encode_cell({ r: nextRow, c: 0 });
                if (ws[nextCellAddress] && ws[nextCellAddress].v && 
                    ['Code', 'Name', 'Voucher NO', 'Settlement No'].includes(ws[nextCellAddress].v)) {
                    for (let col = 0; col <= range.e.c; col++) {
                        const headerCell = XLSX.utils.encode_cell({ r: nextRow, c: col });
                        if (ws[headerCell]) {
                            if (!ws[headerCell].s) ws[headerCell].s = {};
                            ws[headerCell].s.font = { bold: true };
                            ws[headerCell].s.fill = { fgColor: { rgb: '2563EB' } };
                            ws[headerCell].s.fgColor = { rgb: 'FFFFFF' };
                        }
                    }
                }
            }

            // Process data rows for Payment/Cash In sections
            if (currentSection === 'PAYMENT' || currentSection === 'CASH IN') {
                const firstCell = XLSX.utils.encode_cell({ r: row, c: 0 });
                const secondCell = XLSX.utils.encode_cell({ r: row, c: 1 });
                const thirdCell = XLSX.utils.encode_cell({ r: row, c: 2 });
                const amountCell = XLSX.utils.encode_cell({ r: row, c: 5 });
                
                // Right-align amount column
                if (ws[amountCell] && ws[amountCell].v !== undefined && ws[amountCell].v !== null && ws[amountCell].v !== '') {
                    if (!ws[amountCell].s) ws[amountCell].s = {};
                    ws[amountCell].s.alignment = { horizontal: 'right' };
                }

                // Check if this row has a voucher number (starts a new group)
                const hasVoucher = ws[firstCell] && ws[firstCell].v && ws[firstCell].v !== '';
                const hasIou = ws[secondCell] && ws[secondCell].v && ws[secondCell].v !== '';
                const hasPayee = ws[thirdCell] && ws[thirdCell].v && ws[thirdCell].v !== '';
                
                if (hasVoucher) {
                    // Close previous groups if they exist
                    if (voucherStartRow >= 0 && row > voucherStartRow) {
                        merges.push({ s: { r: voucherStartRow, c: 0 }, e: { r: row - 1, c: 0 } });
                    }
                    if (iouStartRow >= 0 && row > iouStartRow) {
                        merges.push({ s: { r: iouStartRow, c: 1 }, e: { r: row - 1, c: 1 } });
                    }
                    if (payeeStartRow >= 0 && row > payeeStartRow) {
                        merges.push({ s: { r: payeeStartRow, c: 2 }, e: { r: row - 1, c: 2 } });
                    }
                    
                    // Start new groups
                    voucherStartRow = row;
                    if (hasIou) iouStartRow = row;
                    if (hasPayee) payeeStartRow = row;
                } else if (voucherStartRow >= 0) {
                    // This is a continuation row - check if payee changes
                    const prevThirdCell = XLSX.utils.encode_cell({ r: row - 1, c: 2 });
                    const prevHasPayee = ws[prevThirdCell] && ws[prevThirdCell].v && ws[prevThirdCell].v !== '';
                    
                    if (prevHasPayee && !hasPayee) {
                        // Payee group ended, merge it
                        if (payeeStartRow >= 0 && row > payeeStartRow) {
                            merges.push({ s: { r: payeeStartRow, c: 2 }, e: { r: row - 1, c: 2 } });
                        }
                        payeeStartRow = -1;
                    } else if (!prevHasPayee && hasPayee) {
                        // New payee group starts
                        payeeStartRow = row;
                    }
                }
            } else {
                // Right-align amount column for other sections too
                const amountCell = XLSX.utils.encode_cell({ r: row, c: 3 }); // Amount is column 3 for simple sections
                if (ws[amountCell] && ws[amountCell].v !== undefined && ws[amountCell].v !== null && ws[amountCell].v !== '') {
                    // Check if it's a number (amount)
                    const cellValue = ws[amountCell].v;
                    if (typeof cellValue === 'number' || (typeof cellValue === 'string' && /^[\d,]+\.?\d*$/.test(cellValue.replace(/,/g, '')))) {
                        if (!ws[amountCell].s) ws[amountCell].s = {};
                        ws[amountCell].s.alignment = { horizontal: 'right' };
                    }
                }
                // Also check column 5 for sections with more columns
                const amountCell5 = XLSX.utils.encode_cell({ r: row, c: 5 });
                if (ws[amountCell5] && ws[amountCell5].v !== undefined && ws[amountCell5].v !== null && ws[amountCell5].v !== '') {
                    const cellValue = ws[amountCell5].v;
                    if (typeof cellValue === 'number' || (typeof cellValue === 'string' && /^[\d,]+\.?\d*$/.test(cellValue.replace(/,/g, '')))) {
                        if (!ws[amountCell5].s) ws[amountCell5].s = {};
                        ws[amountCell5].s.alignment = { horizontal: 'right' };
                    }
                }
            }
        }
        
        // Close any remaining groups at the end
        if (voucherStartRow >= 0 && range.e.r > voucherStartRow) {
            merges.push({ s: { r: voucherStartRow, c: 0 }, e: { r: range.e.r, c: 0 } });
        }
        if (iouStartRow >= 0 && range.e.r > iouStartRow) {
            merges.push({ s: { r: iouStartRow, c: 1 }, e: { r: range.e.r, c: 1 } });
        }
        if (payeeStartRow >= 0 && range.e.r > payeeStartRow) {
            merges.push({ s: { r: payeeStartRow, c: 2 }, e: { r: range.e.r, c: 2 } });
        }

        // Apply merges
        if (merges.length > 0) {
            ws['!merges'] = merges;
        }

        // Set column widths
        ws['!cols'] = [
            { wch: 20 }, // Voucher NO / Code
            { wch: 20 }, // IOU NO / Name
            { wch: 30 }, // Payee
            { wch: 30 }, // Account
            { wch: 50 }, // Description
            { wch: 15 }  // Amount
        ];

        XLSX.utils.book_append_sheet(wb, ws, 'Cash Book');

        // Save file
        const fileName = 'CashBook_' + currentShiftCode + '_' + new Date().toISOString().split('T')[0] + '.xlsx';
        XLSX.writeFile(wb, fileName);
    }

    function addExcelPaymentRows(allData, details) {
        details.forEach(function(item) {
            // Handle items with multiple line items - group by movement
            if (item.items && item.items.length > 0) {
                // Sort items by payee_id to group them
                const sortedItems = item.items.slice().sort(function(a, b) {
                    const payeeIdA = a.payee_id || 'no_payee';
                    const payeeIdB = b.payee_id || 'no_payee';
                    if (payeeIdA < payeeIdB) return -1;
                    if (payeeIdA > payeeIdB) return 1;
                    return 0;
                });

                const iouSettlement = item.iou_settlement || item.iouSettlement;
                const iouCode = iouSettlement?.cash_movement?.code || '-';
                const payeeMap = {};
                if (item.payees && item.payees.length > 0) {
                    item.payees.forEach(function(payee) {
                        payeeMap[payee.id] = payee.payee_name;
                    });
                }

                // Get employee information
                const employeeInfo = [];
                if (item.employees && item.employees.length > 0) {
                    item.employees.forEach(function(employee) {
                        let empName = '';
                        if (employee.employee_no && employee.employee_name) {
                            empName = employee.employee_no + ' - ' + employee.employee_name;
                        } else if (employee.employee_no) {
                            empName = employee.employee_no;
                        } else if (employee.employee_name) {
                            empName = employee.employee_name;
                        }
                        if (empName) employeeInfo.push(empName);
                    });
                }

                // Get supplier job information
                const supplierJobInfo = [];
                if (item.supplier_jobs && item.supplier_jobs.length > 0) {
                    item.supplier_jobs.forEach(function(supplierJob) {
                        let jobDesc = '';
                        if (supplierJob.supplier_job) {
                            jobDesc = supplierJob.supplier_job.code || supplierJob.supplier_job.job_name || '';
                            if (supplierJob.supplier_job.job_name && supplierJob.supplier_job.code) {
                                jobDesc = supplierJob.supplier_job.job_name + ' (' + supplierJob.supplier_job.code + ')';
                            }
                        }
                        if (supplierJob.advance_amount) {
                            if (jobDesc) {
                                jobDesc += ' - ' + formatMoney(supplierJob.advance_amount);
                            } else {
                                jobDesc = 'Advance: ' + formatMoney(supplierJob.advance_amount);
                            }
                        }
                        if (supplierJob.remarks) {
                            if (jobDesc) {
                                jobDesc += ' - ' + supplierJob.remarks;
                            } else {
                                jobDesc = supplierJob.remarks;
                            }
                        }
                        if (jobDesc) supplierJobInfo.push(jobDesc);
                    });
                }

                // Group items by payee
                const itemsByPayee = {};
                sortedItems.forEach(function(lineItem) {
                    const payeeId = lineItem.payee_id || 'no_payee';
                    if (!itemsByPayee[payeeId]) {
                        itemsByPayee[payeeId] = [];
                    }
                    itemsByPayee[payeeId].push(lineItem);
                });

                let globalItemIndex = 0;
                Object.keys(itemsByPayee).forEach(function(payeeId) {
                    const payeeItems = itemsByPayee[payeeId];
                    let payeeName = payeeMap[payeeId] || item.payee_name || '-';
                    
                    // Add employee info to payee if available
                    if (employeeInfo.length > 0 && globalItemIndex === 0) {
                        payeeName = payeeName + (payeeName !== '-' ? ', ' : '') + employeeInfo.join(', ');
                    }
                    
                    payeeItems.forEach(function(lineItem, payeeItemIndex) {
                        const account = lineItem.account_master?.account_name || item.account_master?.account_name || '-';
                        let description = lineItem.memo || '';
                        
                        // Add supplier job info to description
                        if (supplierJobInfo.length > 0 && globalItemIndex === 0) {
                            if (description) {
                                description += ' | Supplier Jobs: ' + supplierJobInfo.join('; ');
                            } else {
                                description = 'Supplier Jobs: ' + supplierJobInfo.join('; ');
                            }
                        }
                        
                        // Fallback to item remarks if no memo
                        if (!description) {
                            description = item.remarks || '-';
                        }
                        
                        allData.push([
                            globalItemIndex === 0 ? (item.code || '-') : '',
                            globalItemIndex === 0 ? iouCode : '',
                            payeeItemIndex === 0 ? payeeName : '',
                            account,
                            description,
                            formatMoney(lineItem.amount || 0)
                        ]);
                        
                        globalItemIndex++;
                    });
                });
            } else {
                const iouSettlement = item.iou_settlement || item.iouSettlement;
                const iouCode = iouSettlement?.cash_movement?.code || '-';
                
                // Get all payees
                let payee = item.payees?.map(p => p.payee_name).join(', ') || item.payee_name || '-';
                
                // Add employee information to payee
                if (item.employees && item.employees.length > 0) {
                    const employeeInfo = [];
                    item.employees.forEach(function(employee) {
                        let empName = '';
                        if (employee.employee_no && employee.employee_name) {
                            empName = employee.employee_no + ' - ' + employee.employee_name;
                        } else if (employee.employee_no) {
                            empName = employee.employee_no;
                        } else if (employee.employee_name) {
                            empName = employee.employee_name;
                        }
                        if (empName) employeeInfo.push(empName);
                    });
                    if (employeeInfo.length > 0) {
                        payee = payee + (payee !== '-' ? ', ' : '') + employeeInfo.join(', ');
                    }
                }
                
                const account = item.account_master?.account_name || '-';
                let description = item.remarks || '-';
                
                // Add supplier job information to description
                if (item.supplier_jobs && item.supplier_jobs.length > 0) {
                    const supplierJobInfo = [];
                    item.supplier_jobs.forEach(function(supplierJob) {
                        let jobDesc = '';
                        if (supplierJob.supplier_job) {
                            jobDesc = supplierJob.supplier_job.code || supplierJob.supplier_job.job_name || '';
                            if (supplierJob.supplier_job.job_name && supplierJob.supplier_job.code) {
                                jobDesc = supplierJob.supplier_job.job_name + ' (' + supplierJob.supplier_job.code + ')';
                            }
                        }
                        if (supplierJob.advance_amount) {
                            if (jobDesc) {
                                jobDesc += ' - ' + formatMoney(supplierJob.advance_amount);
                            } else {
                                jobDesc = 'Advance: ' + formatMoney(supplierJob.advance_amount);
                            }
                        }
                        if (supplierJob.remarks) {
                            if (jobDesc) {
                                jobDesc += ' - ' + supplierJob.remarks;
                            } else {
                                jobDesc = supplierJob.remarks;
                            }
                        }
                        if (jobDesc) supplierJobInfo.push(jobDesc);
                    });
                    if (supplierJobInfo.length > 0) {
                        description = description + (description !== '-' ? ' | ' : '') + 'Supplier Jobs: ' + supplierJobInfo.join('; ');
                    }
                }
                
                allData.push([
                    item.code || '-',
                    iouCode,
                    payee,
                    account,
                    description,
                    formatMoney(item.amount || 0)
                ]);
            }
        });
    }

</script>
