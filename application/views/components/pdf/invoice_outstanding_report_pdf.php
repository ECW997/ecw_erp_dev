<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ECW Software</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/img/ecw2.jpg" />
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
        font-size: 10px;
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

    /* th, td {
    border: 1px solid #000;
    padding: 4px 2px;
    font-size: 9px;
} */

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
    </style>
</head>

<body>
    <header>
        <table>
            <tr>
                <th>
                    <img style="height:65px;collapse;margin-left:5px;"
                        src="<?php echo base_url() ?>assets/img/logo-icon.png" />
                </th>
                <th colspan="3" style="width:83%;font-size:18px;font-weight:500;text-align:center;" class="header_th">
                    <span style="margin-left:-125">Customer Invoice Outstanding Report</span>
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
                    <!-- <i class="fab fa-facebook-square" style="margin-right:2px;font-size:14px;"></i>
                    <i class="fab fa-tiktok" style="margin-right:2px;font-size:14px;"></i>
                    <i class="fab fa-instagram-square" style="margin-right:2px;font-size:14px;"></i>
                    <i class="fab fa-youtube" style="margin-right:2px;font-size:14px;"></i> -->
                    ECW Software
                </td>
            </tr>
            <tr>
                <td class="footer_text">Nittambuwa</td>
                <td style="text-align:center;" class="footer_text"></td>
            </tr>
            <tr>
                <td colspan="3;" class="footer_text" style="letter-spacing: 2.8px; text-align:center;">SOUTH ASIA'S LARGEST INTERIOR MODIFICATION CENTER</td>
            </tr>
        </table>
    </footer>

    <table class="content" style="border: 1px solid #000;">
        <thead>
            <tr>
            <th style="text-align: center; border: 1px solid #000; width: 12%;">Invoice Date</th>
            <th style="text-align: left; border: 1px solid #000; width: 13%;">Invoice Number</th>
            <th style="text-align: left; border: 1px solid #000; width: 24%;">Customer Name</th>
            <th style="text-align: right; border: 1px solid #000; width: 16%;">Total Invoice Amount</th>
            <th style="text-align: right; border: 1px solid #000; width: 16%;">Outstanding Amount</th>
            <th style="text-align: center; border: 1px solid #000; width: 12%;">Due Date</th>
            <th style="text-align: center; border: 1px solid #000; width: 10%;">Age</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report as $row): ?>
            <tr>
                <td style="text-align: center; border: 1px solid #000;"><?= htmlspecialchars($row['invoice']['invoice_date'] ?? '') ?></td>
                <td style="border: 1px solid #000;"><?= htmlspecialchars($row['invoice']['invoice_number'] ?? '') ?>
                </td>
                <td style="border: 1px solid #000;"><?= htmlspecialchars($row['invoice']['customer_name'] ?? '') ?></td>
                <td style="text-align: right; border: 1px solid #000;">
                    <?= number_format($row['invoice']['inv_grand_total'] ?? 0, 2) ?></td>
                <td style="text-align: right; border: 1px solid #000;">
                    <?= number_format($row['invoice']['inv_payble_total'] ?? 0, 2) ?></td>
                <td style="text-align: center; border: 1px solid #000;">
                    <?= htmlspecialchars($row['invoice']['due_date'] ?? '') ?></td>
                <td style="text-align: center; border: 1px solid #000;">
                    <?php
                    $due_date = $row['invoice']['due_date'] ?? '';
                    $age = '';
                    if ($due_date) {
                        $due = new DateTime($due_date);
                        $today = new DateTime(date('Y-m-d'));
                        $interval = $today->diff($due);
                        $days = (int)$interval->format('%r%a');
                        $age = $days;
                    }
                    echo $age !== '' ? $age . ' days' : '';
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>