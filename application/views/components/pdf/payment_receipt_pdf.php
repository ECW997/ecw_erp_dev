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
	  margin: 35mm 15mm 15mm 1mm;
      /* top right bottom left */
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

<?php
$branchOutput = '';

switch ($header['company_branch_id']) {
    case '1':
        $branchOutput = 'Head Office - Nittambuwa 0332 286 729'; 
        break;
    case '2':
        $branchOutput = 'BRANCH COLOMBO ROAD, KURANA, NEGOMBO 0312 224 225'; 
        break;
    case '3':
        $branchOutput = 'No Branch 3'; 
        break;
    default:
        $branchOutput = 'No Branch defult'; 
        break;
}
?>
<?php
$companyOutput = '';

switch ($header['company_branch_id']) {
    case '1':
        $companyOutput = 'Edirisingha Cushion Works (Pvt) Ltd'; 
        break;
    case '2':
        $companyOutput = 'Edirisingha Cushion Works'; 
        break;
    case '3':
        $companyOutput = 'No Branch 3'; 
        break;
    default:
        $companyOutput = 'No Branch defult'; 
        break;
}
?>
</head>
<body>

<header>
	<table>
		<tr>
			<th>
				<img style="height:65px;margin-left:5px" src="<?php echo base_url() ?>assets/img/logo-icon.png" />
			</th>
            <th colspan="3" style="width:83%;font-size:14px;font-weight:500;" class="header_th">
				<table style="width:100%;">
					<tr>
						<td style="text-align:right; width:60%;">PAYMENT RECEIPT</td>
						<td style="text-align:right; width:40%;">
							<?php if ($header['print_receipt_cnt'] > 1): ?>
								<span style="font-size:11px;color: rgba(200, 0, 0, 1);">(DUPLICATE)</span>
							<?php endif; ?>
						</td>
					</tr>
				</table>
			</th>
		</tr>
		<tr>
			<th style="width:10%;" class="header_th">Cus. Code</th>
			<th style="width:25%;" class="header_th"><span> : </span><?= $header['customer_code'] ?></th>
			<th style="width:10%;" class="header_th">Receipt No.</th>
			<th style="width:10%;" class="header_th"><span> : </span><?= $header['receipt_number'] ?></th>
		</tr>
		<tr>
			<th style="width:10%;" class="header_th">Cus Name</th>
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
        	<th style="width:10%;" class="header_th"><span> : </span><?= $header['sales_person_code'] ?></th>
        </tr>
        <tr>
			<th style="width:10%;" class="header_th">Vehicle No</th>
			<th style="width:25%;" class="header_th"><span> : </span><?= $header['Vehicle_no'] ?></th>
			<th style="width:10%;" class="header_th">JobCard No</th>
			<th style="width:10%;" class="header_th"><span> : </span><?= $header['jobcard_no'] ?></th>
		</tr>
        <tr>
            <th style="width:10%;" class="header_th">Vehicle Type.</th>
            <th style="width:10%;" class="header_th"><span> : </span><?= ($header['brand_name'] ?? '') . 
                        (!empty($header['model_name']) ? ', ' . $header['model_name'] : '') ?></th>
          	<th style="width:10%;" class="header_th" colspan="1" style="vertical-align: bottom;"></th>
			<th style="width:10%; vertical-align: bottom;" class="header_th"></th>
        </tr>
	</table>
</header>

<footer>
	<table>
		<tr>
			<td style="width:65%;" class="footer_text"><?= $companyOutput ?></td>
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
			<td colspan="3" class="footer_text" style="letter-spacing: 2.8px; text-align:center;">SOUTH ASIA'S LARGEST INTERIOR MODIFICATION CENTER</td>
		</tr>
	</table>
</footer>

<?php foreach ($invoices as $inv_index => $invoice): ?>
    <div style="<?= ($inv_index < count($invoices) - 1) ? 'page-break-after: always;' : '' ?>">
        <div style="margin-bottom: 20px;">
            <h4 style="margin: 0 0 5px 0;">
                <?php 
                    if (!empty($invoice['invoice']['invoice_number'])) {
                        echo 'Invoice No: ' . $invoice['invoice']['invoice_number'];
                    } elseif (!empty($invoice['invoice']['job_card_number'])) {
                        echo 'Advance Payment - Jobcard No: ' . $invoice['invoice']['job_card_number'];
                    } else {
                        echo 'Advance Payment';
                    }
                ?>
            </h4>
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
                        <td class="datatable_data_td" style="text-align:right"><?= $item['line_total_after_discount'] == 0 ? '' : number_format($item['line_discount_pc'], 0). '%' ?></td>
                        <td class="datatable_data_td" style="text-align:right"><?= $item['line_total_after_discount'] == 0 ? '' : number_format($item['line_total_after_discount'], 2) ?></td>
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
                                <tr>
                                    <td colspan="2" style="height:40px;"></td>
                                </tr>
                               <!-- <tr>
                                    <td style="width: 50%; text-align: center;" class="datatable_data_td">........................</td>
                                    <td style="width: 50%; text-align: center;" class="datatable_data_td">........................</td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: center;" class="datatable_data_td">Customer</td>
                                    <td style="width: 50%; text-align: center;" class="datatable_data_td">Cashier</td>
                                </tr> -->
                            </table>
                        </td>

                        <td style="width:50%; vertical-align:top; padding-left:10px;">
                            <table style="width:100%;">
                                <tr>
                                    <td class="datatable_data_td">Grand Total</td>
                                    <td class="datatable_data_td" style="text-align:center;">:</td>
                                    <td class="datatable_data_td" style="text-align:right;"><?= number_format($invoice['totals']['gross_total'] ?? 0, 2) ?></td>
                                </tr>
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
                                    <td class="datatable_data_td" style="font-weight:bold;">Current Paid</td>
                                    <td class="datatable_data_td" style="text-align:center; font-weight:bold;">:</td>
                                    <td class="datatable_data_td" style="text-align:right; font-weight:bold;"><?= number_format($invoice['totals']['total_current_paid'] ?? 0, 2) ?></td>
                                </tr>
                                <tr>
                                    <td class="datatable_data_td" style="font-weight:bold;">Total Paid</td>
                                    <td class="datatable_data_td" style="text-align:center; font-weight:bold;">:</td>
                                    <td class="datatable_data_td" style="text-align:right; font-weight:bold;">
                                        <?= number_format(
                                            ($invoice['totals']['total_paid_for_ref'] ?? 0) + 
                                            ($invoice['totals']['advance_total'] ?? 0), 
                                            2
                                        ) ?>
                                    </td>
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
