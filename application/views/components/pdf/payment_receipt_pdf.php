<!DOCTYPE html>
<html>
<head><meta charset="UTF-8">
<title>ECW Software</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="assets/img/ecw2.jpg" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
<style>
@page {
	  margin: 38mm 15mm 25mm 5mm;
}

body {
	margin: 0;
	font-family: sans-serif;
	font-size: 9px;
}

header {
    position: fixed;
    top: -38mm;
    left: 0;
    right: 0;
    height: 38mm;
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
    margin-top: -8mm;
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
</style>
<?php if ($header['print_receipt_cnt'] > 1): ?>
    <style>
        body::before {
            content: "DUPLICATE";
            position: fixed;
            top: 25%;
            left: 5%;
            width: 100%;
            text-align: center;
            font-size: 100px;
            color: rgba(200, 0, 0, 0.08);
            transform: rotate(-45deg);
            z-index: 9999;
            pointer-events: none;
        }
    </style>
<?php endif; ?>
</head>
<body>

<header>
	<table>
		<tr>
			<th>
				<img style="height:65px;collapse;margin-left:5px" src="<?php echo base_url() ?>assets/img/logo-icon.png" />
			</th>
			<th colspan="3" style="width:83%;font-size:14px;font-weight:500;text-align:center;" class="header_th"><span
					style="margin-left:-55">PAYMENT RECEIPT</span>
			</th>
		</tr>
		<tr>
			<th style="width:10%;" class="header_th">Cus. Code</th>
			<th style="width:25%;" class="header_th"><span> : </span><?= $header['receipt_cus_id'] ?></th>
			<th style="width:10%;" class="header_th">Receipt No.</th>
			<th style="width:10%;" class="header_th"><span> : </span><?= $header['receipt_number'] ?></th>
		</tr>
		<tr>
			<th style="width:10%;" class="header_th">Cust Name</th>
			<th style="width:25%;" class="header_th"><span> : </span><?= $header['customer_name'] ?></th>
			<th style="width:10%;" class="header_th">Date</th>
			<th style="width:10%;" class="header_th"><span> : </span><?= date('d/m/Y',strtotime($header['receipt_date'])) ?></th>
		</tr>
		 <tr>
        	<th style="width:10%;" class="header_th">Address</th>
        	<th style="width:20%;" class="header_th"><span> : </span><?= ($header['address'] ?? '') . 
                        (!empty($header['address_2']) ? ', ' . $header['address_2'] : '') . 
                        (!empty($header['city']) ? ', ' . $header['city'] : '') . 
                        (!empty($header['district']) ? ', ' . $header['district'] : '') ?></th>
        	<th style="width:10%;" class="header_th">S.P.Code</th>
        	<th style="width:10%;" class="header_th"><span> : </span>02</th>
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
			<td class="footer_text">BRANCH COLOMBO ROAD, KURANA, NEGOMBO 0312 224 220</td>
			<td style="text-align:center;" class="footer_text">FOLLOW US</td>
		</tr>
		<tr>
			<td colspan="3;" class="footer_text" style="letter-spacing: 2.8px;">THE PRIME OF VEHICLE INTERIOR &
				EXTERIOR MODIFICATION</td>
		</tr>
	</table>
</footer>

<?php foreach ($invoices as $inv_index => $invoice): ?>
    <div style="<?= ($inv_index < count($invoices) - 1) ? 'page-break-after: always;' : '' ?>">
        <div style="margin-bottom: 20px;">
            <h4 style="margin: 0 0 5px 0;">Invoice No: <?= $invoice['invoice']['invoice_number'] ?></h4>
            <table>
                <thead>
                    <tr>
                        <th class="datatable_td" style="width:3%">#</th>
                        <th class="datatable_td" style="width:46%">DESCRIPTION</th>
                        <th class="datatable_td" style="width:5%">QTY</th>
                        <th class="datatable_td" style="width:10%">UNIT</th>
                        <th class="datatable_td" style="width:13%">RATE</th>
                        <th class="datatable_td" style="width:8%">DISC.</th>
                        <th class="datatable_td" style="width:15%">AMOUNT</th>
                    </tr>
                </thead>
                <tbody>   
                    <?php foreach ($invoice['invoice_details'] as $i => $item): ?>
                    <tr>
                        <td class="datatable_data_td"><?= $i+1 ?></td>
                        <td class="datatable_data_td"><?= $item['description'] ?></td>
                        <td class="datatable_data_td" style="text-align:center"><?= $item['quantity'] ?></td>
                        <td class="datatable_data_td" style="text-align:center"><?= $item['unit'] ?></td>
                        <td class="datatable_data_td" style="text-align:right"><?= number_format($item['unit_price'],2) ?></td>
                        <td class="datatable_data_td" style="text-align:right"><?= number_format($item['line_discount_amount'],2) ?></td>
                        <td class="datatable_data_td" style="text-align:right"><?= number_format($item['line_total_after_discount'],2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="margin-top:10px;border-top: 1.5px solid #000;">
                <table>
                    <tr>
                        <td style="width:50%; vertical-align:top; padding-right:10px;">
                            <table>
                                <?php
                                $total_paid = 0;
                                foreach ($invoice['payment_methods'][0]['transactions'] as $txn):
                                    $total_paid += (float)$txn['allocated_amount'];
                                ?>
                                <tr>
                                    <td class="datatable_data_td"><?= $txn['pay_method_label'] ?></td>
                                    <td class="datatable_data_td" style="text-align:right"><?= number_format($txn['allocated_amount'],2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </td>

                        <td style="width:50%; vertical-align:top; padding-left:10px;">
                            <table style="width:100%;">
                                <tr>
                                    <td class="datatable_data_td" style="width:60%;">Discount Total</td>
                                    <td class="datatable_data_td" style="width:10%; text-align:center;">:</td>
                                    <td class="datatable_data_td" style="width:30%; text-align:right;"><?= number_format($invoice['totals']['total_discount'] ?? 0, 2) ?></td>
                                </tr>
                                <tr>
                                    <td class="datatable_data_td">Advance</td>
                                    <td class="datatable_data_td" style="text-align:center;">:</td>
                                    <td class="datatable_data_td" style="text-align:right;"><?= number_format($invoice['totals']['advance_total'] ?? 0, 2) ?></td>
                                </tr>
                                <tr>
                                    <td class="datatable_data_td">Grand Total</td>
                                    <td class="datatable_data_td" style="text-align:center;">:</td>
                                    <td class="datatable_data_td" style="text-align:right;"><?= number_format($invoice['totals']['grand_total'] ?? 0, 2) ?></td>
                                </tr>
                                <tr>
                                    <td class="datatable_data_td" style="font-weight:bold;">Current Paid</td>
                                    <td class="datatable_data_td" style="text-align:center; font-weight:bold;">:</td>
                                    <td class="datatable_data_td" style="text-align:right; font-weight:bold;"><?= number_format($invoice['totals']['total_current_paid'] ?? 0, 2) ?></td>
                                </tr>
                                <tr>
                                    <td class="datatable_data_td" style="font-weight:bold;">Total Paid</td>
                                    <td class="datatable_data_td" style="text-align:center; font-weight:bold;">:</td>
                                    <td class="datatable_data_td" style="text-align:right; font-weight:bold;"><?= number_format($invoice['totals']['total_paid_for_ref'] ?? 0, 2) ?></td>
                                </tr>
                                <tr>
                                    <td class="datatable_data_td" style="border-top:1px solid #000; border-bottom:3px double #000; font-weight:bold;">Net Balance</td>
                                    <td class="datatable_data_td" style="text-align:center; border-top:1px solid #000; border-bottom:3px double #000; font-weight:bold;">:</td>
                                    <td class="datatable_data_td" style="text-align:right; border-top:1px solid #000; border-bottom:3px double #000; font-weight:bold;">
                                        <?= number_format(($invoice['totals']['grand_total'] ?? 0) - ($invoice['totals']['total_paid_for_ref'] ?? 0), 2) ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>   
<?php endforeach; ?>

</body>
</html>
