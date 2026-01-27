<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ECW Software</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/fonts/roboto.css'); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/logo-icon.png" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome/all.css'); ?>" />
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

    tbody td. {
        border: 0.5px solid #000;
        padding: 5px 2px;
        font-size: 9px;
    }

    tfoot th. {
        border: 0.5px solid #000;
        padding: 5px 2px;
        font-size: 9px;
    }

    thead th. {
        border: 0.5px solid #000;
        padding: 5px 2px;
        font-size: 9px;
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

    /* .datatable_td {
        padding: 3px;
        border-top: 1.5px solid #000;
        border-bottom: 1.5px solid #000;
    } */

    .datatable_data_td {
        padding: 1px 3px;
        line-height: 1.2;
    }

    .page-break {
        page-break-after: always;
    }

    .header_th {
        text-align: left;
        height: 20px;
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
                    <span style="margin-left:-125">Daily Sales Summary Report</span>
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
                <td colspan="3;" class="footer_text" style="letter-spacing: 2.8px; text-align:center;">SOUTH ASIA'S
                    LARGEST INTERIOR MODIFICATION CENTER</td>
            </tr>
        </table>
    </footer>


    <?php
    $total_ecw = 0;
    $total_sales02 = 0;
    $total_total = 0;
    foreach ($report as $row) {
        $total_ecw += $row['Invoice1Amount'] ?? 0;
        $total_sales02 += $row['Invoice2Amount'] ?? 0;
        $total_total += $row['Total'] ?? 0;
    }
    ?>

    <table class="content" style="border: 1px solid #000;">
        <thead>
            <tr>
                <th style="text-align: center;  width: 25%;">Invoice Date</th>
                <th style="text-align: center;  width: 25%;">Invoice Sale 01 Amount </th>
                <th style="text-align: center;  width: 25%;">Invoice Sale 02 Amount</th>
                <th style="text-align: center;  width: 25%;">Total Invoice Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report as $row): ?>
            <tr>
                <td style="text-align: center; "><?= htmlspecialchars($row['Date'] ?? '') ?></td>
                <td style="text-align: right; "><?= number_format($row['Invoice1Amount'] ?? 0, 2) ?></td>
                <td style="text-align: right; "><?= number_format($row['Invoice2Amount'] ?? 0, 2) ?></td>
                <td style="text-align: right; "><?= number_format($row['Total'] ?? 0, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align: center; background-color: #cce5ff">Total</th>
                <th style="text-align: right; background-color: #cce5ff"><?= number_format($total_ecw, 2) ?></th>
                <th style="text-align: right; background-color: #cce5ff"><?= number_format($total_sales02, 2) ?></th>
                <th style="text-align: right; background-color: #cce5ff"><?= number_format($total_total, 2) ?></th>
            </tr>
        </tfoot>
    </table>
</body>

</html>