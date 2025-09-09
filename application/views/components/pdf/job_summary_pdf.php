<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECW Software</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
<style>
@page {
    margin: 43mm 15mm 15mm 1mm;
    /* top right bottom left */
}

body {
    margin: 0;
    font-family: sans-serif;
    font-size: 9px;
}

header {
    position: fixed;
    top: -45mm;
    left: 0;
    right: 0;
    height: 45mm;
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
    margin-top: 0mm;
    margin-bottom: 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
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
    height: 8px;
    line-height: 0.8rem;
    padding: 0;
    font-weight: 400;
}

/* NEW STYLES FOR PAGE BREAK CONTROL */
.payment-summary-container {
    page-break-inside: avoid;
    margin-top: 10px;
}

.items-table {
    page-break-inside: auto;
}

.items-table tr {
    page-break-inside: avoid;
    page-break-after: auto;
}

.summary-table {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
}

.keep-together {
    page-break-inside: avoid;
}

.force-new-page {
    page-break-before: always;
}

/* Adjust content margin for first page */
.first-page-content {
    margin-top: 0mm; /* Height of header */
    margin-bottom: 0; /* Height of footer */
}

/* For subsequent pages */
.subsequent-page {
    margin-top: 30mm;
    margin-bottom: 0mm;
}
</style>

<?php
$branchOutput = '';

switch ($main_data['company_branch_id']) {
    case '1':
        $branchOutput = 'Head Office - Nittambuwa 0332 286 729'; 
        break;
    case '2':
        $branchOutput = 'BRANCH COLOMBO ROAD, KURANA, NEGOMBO 0312 224 220'; 
        break;
    case '3':
        $branchOutput = 'No Branch 3'; 
        break;
    default:
        $branchOutput = 'No Branch defult'; 
        break;
}
?>
</head>
<body>

<header>
    <table>
        <tr>
            <th>
                <img style="height:65px;collapse;margin-left:5px" src="<?php echo base_url() ?>assets/img/logo-icon.png" />
            </th>
            <th colspan="3" style="width:83%;font-size:14px;font-weight:500;" class="header_th">
                <table style="width:100%;">
                    <tr>
                        <td style="text-align:right; width:60%;">JOB SUMMARY</td>
                        <td style="text-align:right; width:40%;">
                            
                        </td>
                    </tr>
                </table>
            </th>
        </tr>
        <tr>
            <th style="width:10%;" class="header_th">Cus. Code</th>
            <th style="width:20%;" class="header_th"><span> : </span><?= $main_data['customer_code'] ?></th>
            <th style="width:10%;" class="header_th">Job No.</th>
            <th style="width:10%;" class="header_th"><span> : </span><?= $main_data['job_card_number'] ?></th>
        </tr>
        <tr>
            <th style="width:10%;" class="header_th">Cus Name</th>
            <th style="width:25%;" class="header_th"><span> : </span><?= $main_data['customer_name'] ?></th>
            <th style="width:10%;" class="header_th">PO No.</th>
            <th style="width:10%;" class="header_th"><span> : </span>None</th>
        </tr>
         <tr>
            <th style="width:10%;" class="header_th">Address</th>
            <th style="width:20%;" class="header_th"><span> : </span><?= ($main_data['address'] ?? '') . 
                        (!empty($main_data['address_2']) ? ', ' . $main_data['address_2'] : '')  ?></th>
            <th style="width:10%;" class="header_th">S.P.Code</th>
            <th style="width:10%;" class="header_th"><span> : </span><?= $main_data['sales_person_code'] ?? 'N/A' ?></th>
        </tr>
        <tr>
            <th style="width:10%;" class="header_th">Vehicle No</th>
            <th style="width:25%;" class="header_th"><span> : </span><?= $main_data['vehicle_number'] ?? 'N/A' ?></th>
            <th style="width:10%;" class="header_th">Created Date</th>
            <th style="width:10%;" class="header_th"><span> : </span><?= date('d/m/Y') ?></th>
        </tr>
        <tr>
            <th style="width:10%;" class="header_th">Vehicle Type.</th>
            <th style="width:20%;" class="header_th"><span> : </span><?= ($main_data['brand_name'] ?? '') . 
                        (!empty($main_data['model_name']) ? ', ' . $main_data['model_name'] : '') ?></th>
            <th style="width:10%;" class="header_th">NIC No</th>
            <th style="width:10%;" class="header_th"><span> : </span><?= $main_data['nic_number'] ?? 'N/A' ?></th>
        </tr>
    </table>
	<table class="items-table" style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;border: none;">
			<tr>
				<th class="sub_header_text_th datatable_td" style="width:3%;">#</th>
				<th class="sub_header_text_th datatable_td" style="width:46%;">PRODUCT DESCRIPTION</th>
				<th class="sub_header_text_th datatable_td" style="width:5%; text-align:center;">QTY</th>
				<th class="sub_header_text_th datatable_td" style="width:10%; text-align:center;">UNIT</th>
				<th class="sub_header_text_th datatable_td" style="width:13%; text-align:right;">RATE</th>
				<th class="sub_header_text_th datatable_td" style="width:8%; text-align:right;">DISC.</th>
				<th class="sub_header_text_th datatable_td" style="width:15%; text-align:right;">AMOUNT</th>
			</tr>
	</table>
</header>

<footer>
    <table>
        <tr>
            <td style="width:65%;" class="footer_text">Edirisingha Cushion Works (Pvt) Ltd</td>
            <td style="width:20%;text-align:center;" class="footer_text">FIND US</td>
            <td rowspan="2" style="width:20%;text-align:right;" class="footer_text">
                <i class="fab fa-facebook-square" style="margin-right:2px;font-size:14px;"></i>
                <i class="fab fa-tiktok" style="margin-right:2px;font-size:14px;"></i>
                <i class="fab fa-instagram-square" style="margin-right:2px;font-size:14px;"></i>
                <i class="fab fa-youtube" style="margin-right:2px;font-size:14px;"></i>
            </td>
        </tr>
        <tr>
            <td class="footer_text"><?= $branchOutput ?></td>
            <td style="text-align:center;" class="footer_text">FOLLOW US</td>
        </tr>
        <tr>
            <td colspan="3;" class="footer_text" style="letter-spacing: 2.8px;">THE PRIME OF VEHICLE INTERIOR &
                EXTERIOR MODIFICATION</td>
        </tr>
    </table>
</footer>

<div class="content first-page-content">
    <table class="items-table" style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;border: none;">
        <!-- <tr>
            <th class="sub_header_text_th datatable_td" style="width:3%;">#</th>
            <th class="sub_header_text_th datatable_td" style="width:46%;">PRODUCT DESCRIPTION</th>
            <th class="sub_header_text_th datatable_td" style="width:5%; text-align:center;">QTY</th>
            <th class="sub_header_text_th datatable_td" style="width:10%; text-align:center;">UNIT</th>
            <th class="sub_header_text_th datatable_td" style="width:13%; text-align:right;">RATE</th>
            <th class="sub_header_text_th datatable_td" style="width:8%; text-align:right;">DISC.</th>
            <th class="sub_header_text_th datatable_td" style="width:15%; text-align:right;">AMOUNT</th>
        </tr> -->
        <tbody class="dataTableBody" style="border-bottom: 1.5px solid #000;">
            <?php
            $mainCount = 1;
            $currentHeight = 0;
            $maxPageHeight = 220;
            $totalRows = count($details_data); 
            $groupedData = [];

            foreach ($details_data as $item) {
                $category = $item['job_sub_category_text'] ?? 'N/A';
                if (!isset($groupedData[$category])) {
                    $groupedData[$category] = [];
                }
                foreach ($item['details'] as $joblist) {
                    $groupedData[$category][] = $joblist;
                }
            }
            ?>

            <?php foreach ($groupedData as $category => $jobs): ?>
                <tr class="table-group-header">
                    <td colspan="7" class="fw-bold text-dark" style="font-weight: 700;">
                        <?= $mainCount ?> <?= $category ?>
                    </td>
                </tr>

                <?php
                $subCount = 1; 
                foreach ($jobs as $joblist): 
                    $line_net_total = $is_line_discount_approved ? number_format(($joblist['total'] ?? 0) -($joblist['line_discount'] ?? 0), 2) : number_format(($joblist['total'] ?? 0), 2);
					$line_discount = $is_line_discount_approved ? number_format($joblist['line_discount_pc'] ?? 0, 0) . '%' : number_format(0, 0) . '%';
                    ?>
                    <tr>
                        <td class="datatable_data_td" style="width:3%; text-align:left;"><?= $mainCount . '.' . $subCount ?></td>
                        <td class="datatable_data_td" style="width:46%; text-align:left;">
                            <?= $joblist['option_text'] ?? 'N/A' ?> - <?= $joblist['combined_option'] ?? 'N/A' ?>
                        </td>
                        <td class="datatable_data_td" style="width:5%; text-align:center;"><?= $joblist['qty'] ?? 0 ?></td>
                        <td class="datatable_data_td" style="width:8%; text-align:center;">EA</td>
                        <td class="datatable_data_td" style="width:13%; text-align:right;">
                            <?= number_format($joblist['list_price'] ?? 0, 2) ?>
                        </td>
                        <td class="datatable_data_td" style="width:10%; text-align:right;">
                            <?= $line_net_total == 0 ? '' : $line_discount ?>
                        </td>
                        <td class="datatable_data_td" style="width:15%; text-align:right;">
                            <?= $line_net_total == 0 ? '' : $line_net_total ?>
                        </td>
                    </tr>
                    <?php
                    $subCount++;
                endforeach;
                $mainCount++;
            endforeach;
            ?>
        </tbody>
    </table>

    <!-- Payment Summary Container - Will not split across pages -->
    <div class="payment-summary-container keep-together">
        <?php 
        $net_total = 0;
        if ($summary_data) {
            foreach ($summary_data as $summlist): ?>
            <table class="summary-table">
                <tr>
                    <td style="width: 30%; text-align: left;" class="datatable_data_td">Pay.Method : <?= $main_data['payment_type'] ?? 'N/A' ?></td>
                    <td style="width: 40%; text-align: left;" class="datatable_data_td">Due. Date : <?= $main_data['handover_date'] ?? 'N/A' ?></td>
                    <td colspan="3" style="width: 13%; text-align: left;" class="datatable_data_td">Total Value</td>
                    <td style="width: 2%; text-align: center;" class="datatable_data_td">:</td>
                    <td style="width: 15%; text-align: right;" class="datatable_data_td">
                        <?= number_format($summlist['sub_total'], 2) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="width: 70%; text-align: left;" class="datatable_data_td"></td>
                    <td style="width: 13%; text-align: left;" class="datatable_data_td">Disc. Total</td>
                    <td style="width: 2%; text-align: center;" class="datatable_data_td">:</td>
                    <td style="width: 15%; text-align: right;" class="datatable_data_td">
                        <?php $header_discount =  $summlist['header_discount_status'] == 'Approved' ? $summlist['discount_amount'] : 0?>
                        <?php $line_discount =  $summlist['line_discount_status'] == 'Approved' ? $summlist['total_line_discount'] : 0?>
                        <?=    number_format($header_discount + $line_discount, 2) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="width: 70%; text-align: left;" class="datatable_data_td"></td>
                    <td style="width: 13%; text-align: left;" class="datatable_data_td">SVAT / VAT</td>
                    <td style="width: 2%; text-align: center;" class="datatable_data_td">:</td>
                    <td style="width: 15%; text-align: right;" class="datatable_data_td">
                        <?= number_format($summlist['vat_amount'], 2) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="width: 70%; text-align: left;" class="datatable_data_td"></td>
                    <td style="width: 13%; text-align: left;" class="datatable_data_td">Total</td>
                    <td style="width: 2%; text-align: center;" class="datatable_data_td">:</td>
                    <td style="width: 15%; text-align: right;" class="datatable_data_td">
                        <?php echo number_format($summlist['total'], 2); ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%; text-align: center;" class="datatable_data_td">........................</td>
                    <td style="width: 40%; text-align: center;" class="datatable_data_td">........................</td>
                    <td colspan="3" style="width: 13%; text-align: left;" class="datatable_data_td">T. Advance</td>
                    <td style="width: 2%; text-align: center;" class="datatable_data_td">:</td>
                    <td style="width: 15%; text-align: right;" class="datatable_data_td">
                        <?= number_format($summlist['advance'], 2) ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%; text-align: center;" class="datatable_data_td">Customer</td>
                    <td style="width: 40%; text-align: center;" class="datatable_data_td">Sales Person</td>
                    <td colspan="3" style="width: 13%; text-align: left; border-top: 1px solid #000; border-bottom: 3px double #000;" class="datatable_data_td">Balance</td>
                    <td style="width: 2%; text-align: center; border-top: 1px solid #000; border-bottom: 3px double #000;" class="datatable_data_td">:</td>
                    <td style="width: 15%; text-align: right; border-top: 1px solid #000; border-bottom: 3px double #000;" class="datatable_data_td">
                        <?php echo number_format($summlist['net_total'], 2); ?>
                    </td>
                </tr>
            </table>
        <?php 
            endforeach;
        } 
        ?>
    </div>
</div>

</body>
</html>