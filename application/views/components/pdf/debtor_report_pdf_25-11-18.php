<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ECW Software</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/ecw2.jpg'); ?>" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <style>
    @page {
        margin-top: 40mm;
        margin-right: 10mm;
        margin-bottom: 20mm;
        margin-left: 10mm;
    }

    body {
        margin: 0;
        font-family: sans-serif;
        font-size: 8px;
    }

    header {
        position: fixed;
        top: -38mm;
        left: -20;
        right: 0;
        height: 20mm;
    }

    footer {
        position: fixed;
        bottom: -25mm;
        left: 0;
        right: 0;
        height: 25mm;
        text-align: center;
        line-height: 13px;
        border-top: 2px solid #000;
    }

    .content {
        margin-top: -16mm;
        margin-bottom: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    thead th {
        background-color: #cf1349;
        color: #fff;
        text-align: center;
    }

    thead {
        display: table-header-group;
    }

    tr {
        page-break-inside: avoid;
    }

    .datatable_td {
        padding: 3px;
        border-top: 1.5px solid #000;
        border-bottom: 1.5px solid #000;
    }

    .datatable_data_td {
        padding: 1px 3px;
        line-height: 1.2;
    }

    .page-break {
        page-break-after: always;
    }

    .header_th {
        text-align: left;
        height: 10px;
        line-height: 0.8rem;
        padding: 0;
        font-weight: 400;
    }

    .summary-table {
        margin-top: 10px;
        width: 50%;
        margin-left: auto;
        border: 1px solid #000;
    }

    .summary-table td {
        padding: 5px;
        border: 1px solid #000;
    }

    .summary-table td:first-child {
        font-weight: bold;
        background-color: #f5f5f5;
    }

    .summary-table td:last-child {
        text-align: right;
    }

    .report-info {
        margin-bottom: 10px;
        padding: 5px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        font-size: 9px;
    }

    .text-right {
        text-align: right;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        font-style: italic;
        color: #666;
    }
    </style>
</head>

<body>
    <header>
        <table>
            <tr>
                <th>
                    <img style="height:65px;collapse;margin-left:5px;"
                        src="<?php echo base_url('assets/img/logo-icon.png'); ?>" />
                </th>
                <th colspan="3" style="width:83%;font-size:18px;font-weight:500;text-align:center;" class="header_th">
                    <span style="margin-left:-125"><?= isset($main_data['title']) ? $main_data['title'] : 'Report' ?></span>
                </th>
            </tr>
        </table>
    </header>

    <footer>
        <table>
            <tr>
                <td style="width:65%;" class="footer_text">Edirisingha Cushion Works (Pvt) Ltd</td>
                <td style="width:20%;text-align:center;" class="footer_text"></td>
                <td style="width:20%;text-align:right;" class="footer_text">
                    ECW Software
                </td>
            </tr>
            <tr>
                <td class="footer_text">Nittambuwa</td>
                <td style="text-align:center;" class="footer_text"></td>
            </tr>
            <tr>
                <td colspan="3" class="footer_text" style="letter-spacing: 2.8px; text-align:center;">SOUTH ASIA'S LARGEST INTERIOR MODIFICATION CENTER</td>
            </tr>
        </table>
    </footer>

    <!-- <div class="report-info">
        <strong>Report Type:</strong> <?= isset($main_data['type']) ? ucfirst($main_data['type']) : 'N/A' ?> | 
        <strong>Series:</strong> <?= isset($main_data['series']) ? $main_data['series'] : 'N/A' ?> | 
        <strong>Total Records:</strong> <?= isset($main_data['records_count']) ? $main_data['records_count'] : '0' ?> | 
        <strong>Generated:</strong> <?= isset($main_data['generated_at']) ? $main_data['generated_at'] : date('Y-m-d H:i:s') ?>
    </div> -->

    <table class="content" style="border: 1px solid #000;">
        <thead>
            <tr>
                <?php if(isset($main_data['type']) && $main_data['type'] === 'debitor'): ?>
                    <th style="width: 3%;">#</th>
                    <th style="width: 7%;">Date</th>
                    <th style="width: 10%;">Job No</th>
                    <th style="width: 10%;">Sale Person</th>
                    <th style="width: 16%;">Customer Name</th>
                    <th style="width: 8%;">Phone No</th>
                    <th style="width: 8%;">Vehicle No</th>
                    <th style="width: 10%;">Vehicle Type</th>
                    <th style="width: 8%;" class="text-right">Inv Amount</th>
                    <th style="width: 8%;" class="text-right">Advance Amount</th>
                    <th style="width: 8%;" class="text-right">Balance Amount</th>
                    <th style="width: 5%;">Days</th>
                    <th style="width: 9%;">Approved By</th>
                <?php else: ?>
                    <th style="width: 3%;">#</th>
                    <th style="width: 7%;">Credited Date</th>
                    <th style="width: 10%;">Job No</th>
                    <th style="width: 10%;">Sale Person</th>
                    <th style="width: 15%;">Customer Name</th>
                    <th style="width: 8%;">Phone No</th>
                    <th style="width: 8%;">Vehicle No</th>
                    <th style="width: 10%;">Vehicle Type</th>
                    <th style="width: 8%;" class="text-right">Inv Amount</th>
                    <th style="width: 8%;" class="text-right">Advance Amount</th>
                    <th style="width: 8%;" class="text-right">Balance Amount</th>
                    <th style="width: 7%;">Settlement Date</th>
                    <th style="width: 8%;">Payment Details</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            $counter = 1;
            if (!empty($details_data) && is_array($details_data)): 
                foreach ($details_data as $row): 
                    // Check if row is valid (object or array)
                    if (is_object($row) || is_array($row)):
            ?>
            <tr>
                <?php if(isset($main_data['type']) && $main_data['type'] === 'debitor'): ?>
                    <td style="text-align: center; border: 1px solid #000;"><?= $counter ?></td>
                    <td style="text-align: center; border: 1px solid #000;">
                        <?= isset($row->date) ? date('d-m-Y', strtotime($row->date)) : (isset($row['date']) ? date('d-m-Y', strtotime($row['date'])) : 'N/A') ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(is_object($row) ? ($row->job_no ?? 'N/A') : ($row['job_no'] ?? 'N/A')) ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(
                            (is_object($row) ? ($row->sales_person_code ?? 'N/A') : ($row['sales_person_code'] ?? 'N/A'))
                            . ' - ' .
                            (is_object($row) ? ($row->sales_person_name ?? 'N/A') : ($row['sales_person_name'] ?? 'N/A'))
                        ) ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(is_object($row) ? ($row->customer_name ?? 'N/A') : ($row['customer_name'] ?? 'N/A')) ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(is_object($row) ? ($row->phone_no ?? 'N/A') : ($row['phone_no'] ?? 'N/A')) ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(is_object($row) ? ($row->vehicle_no ?? 'N/A') : ($row['vehicle_no'] ?? 'N/A')) ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(is_object($row) ? ($row->vehicle_type ?? 'N/A') : ($row['vehicle_type'] ?? 'N/A')) ?>
                    </td>
                    <td style="text-align: right; border: 1px solid #000;">
                        <?= number_format(is_object($row) ? ($row->inv_amount ?? 0) : ($row['inv_amount'] ?? 0), 2) ?>
                    </td>
                    <td style="text-align: right; border: 1px solid #000;">
                        <?= number_format(is_object($row) ? ($row->advance_amount ?? 0) : ($row['advance_amount'] ?? 0), 2) ?>
                    </td>
                    <td style="text-align: right; border: 1px solid #000;">
                        <?= number_format(is_object($row) ? ($row->balance_amount ?? 0) : ($row['balance_amount'] ?? 0), 2) ?>
                    </td>
                    <td style="text-align: center; border: 1px solid #000;">
                        <?php
                        $recordDate = is_object($row) ? ($row->date ?? '') : ($row['date'] ?? '');
                        $numberOfDays = '0';
                        
                        if (!empty($recordDate)) {
                            try {
                                $recordDateTime = new DateTime($recordDate);
                                $currentDateTime = new DateTime();
                                $interval = $currentDateTime->diff($recordDateTime);
                                $numberOfDays = $interval->days;
                                
                                // If the record date is in the future, show as negative
                                if ($recordDateTime > $currentDateTime) {
                                    $numberOfDays = '-' . $numberOfDays;
                                }
                            } catch (Exception $e) {
                                $numberOfDays = '0';
                            }
                        }
                        echo $numberOfDays;
                        ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(is_object($row) ? ($row->approved_by ?? 'N/A') : ($row['approved_by'] ?? 'N/A')) ?>
                    </td>
                <?php else: ?>
                    <td style="text-align: center; border: 1px solid #000;"><?= $counter ?></td>
                    <td style="text-align: center; border: 1px solid #000;">
                        <?= isset($row->credited_date) ? date('d-m-Y', strtotime($row->credited_date)) : (isset($row['credited_date']) ? date('d-m-Y', strtotime($row['credited_date'])) : 'N/A') ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(is_object($row) ? ($row->job_no ?? 'N/A') : ($row['job_no'] ?? 'N/A')) ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(
                            (is_object($row) ? ($row->sales_person_code ?? 'N/A') : ($row['sales_person_code'] ?? 'N/A'))
                            . ' - ' .
                            (is_object($row) ? ($row->sales_person_name ?? 'N/A') : ($row['sales_person_name'] ?? 'N/A'))
                        ) ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(is_object($row) ? ($row->customer_name ?? 'N/A') : ($row['customer_name'] ?? 'N/A')) ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(is_object($row) ? ($row->phone_no ?? 'N/A') : ($row['phone_no'] ?? 'N/A')) ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(is_object($row) ? ($row->vehicle_no ?? 'N/A') : ($row['vehicle_no'] ?? 'N/A')) ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(is_object($row) ? ($row->vehicle_type ?? 'N/A') : ($row['vehicle_type'] ?? 'N/A')) ?>
                    </td>
                    <td style="text-align: right; border: 1px solid #000;">
                        <?= number_format(is_object($row) ? ($row->inv_amount ?? 0) : ($row['inv_amount'] ?? 0), 2) ?>
                    </td>
                    <td style="text-align: right; border: 1px solid #000;">
                        <?= number_format(is_object($row) ? ($row->advance_amount ?? 0) : ($row['advance_amount'] ?? 0), 2) ?>
                    </td>
                    <td style="text-align: right; border: 1px solid #000;">
                        <?= number_format(is_object($row) ? ($row->balance_amount ?? 0) : ($row['balance_amount'] ?? 0), 2) ?>
                    </td>
                    <td style="text-align: center; border: 1px solid #000;">
                        <?= isset($row->settlement_date) ? date('d-m-Y', strtotime($row->settlement_date)) : (isset($row['settlement_date']) ? date('d-m-Y', strtotime($row['settlement_date'])) : 'N/A') ?>
                    </td>
                    <td style="border: 1px solid #000;">
                        <?= htmlspecialchars(is_object($row) ? ($row->payment_details ?? 'N/A') : ($row['payment_details'] ?? 'N/A')) ?>
                    </td>
                <?php endif; ?>
            </tr>
            <?php 
                    endif;
                    $counter++;
                endforeach; 
            else: 
            ?>
            <tr>
                <td colspan="14" class="no-data" style="border: 1px solid #000;">
                    No data available
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Summary Totals Section -->
    <?php if(isset($summary_data) && is_array($summary_data)): ?>
    <table class="summary-table">
        <tr>
            <td>Total Invoice Amount:</td>
            <td><?= number_format($summary_data['total_inv_amount'] ?? 0, 2) ?></td>
        </tr>
        <tr>
            <td>Total Advance Amount:</td>
            <td><?= number_format($summary_data['total_advance_amount'] ?? 0, 2) ?></td>
        </tr>
        <tr>
            <td>Total Balance Amount:</td>
            <td><?= number_format($summary_data['total_balance_amount'] ?? 0, 2) ?></td>
        </tr>
    </table>
    <?php endif; ?>
</body>
</html>