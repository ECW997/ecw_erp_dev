<!DOCTYPE html>
<html>
<head><meta charset="UTF-8">
<title>ECW Software</title>
<link rel="stylesheet" href="<?php echo base_url('assets/fonts/roboto.css'); ?>">
<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/logo-icon.png" />
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome/all.css'); ?>" />
<style>
@page {
	  margin: 30mm 15mm 15mm 1mm;
      /* top right bottom left */
}

body {
	margin: 0;
	font-family: sans-serif;
	font-size: 9px;
}

header {
    position: fixed;
    top: -30mm;
    left: 0;
    right: 0;
    height: 30mm;
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
            <th colspan="2" style="height:65px;width:83%;font-size:14px;font-weight:500;" class="header_th">
				<table style="width:100%;">
					<tr>
						<td style="text-align:right; width:55%;">RECEIPT</td>
						<td style="text-align:right; width:45%;"><span style="font-size:11px;color: rgba(200, 0, 0, 1);"></span></td>
					</tr>
				</table>
			</th>
		</tr>
		<tr>
			<th style="width:20%;" class="header_th">Cus Name</th>
			<th style="width:90%;" class="header_th"><span> : </span><?= $header['customer_name'] ?></th>
		</tr>
		<tr>
			<th style="width:10%;" class="header_th">Address</th>
			<th style="width:90%;" class="header_th"><span> : </span>
				<?= ($header['address'] ?? '') . 
                        (!empty($header['address_2']) ? ', ' . $header['address_2'] : '') . 
                        (!empty($header['city']) ? ', ' . $header['city'] : '') . 
                        (!empty($header['district']) ? ', ' . $header['district'] : '') ?>
			</th>
		</tr>
		<tr>
			<th style="width:10%;" class="header_th">Date</th>
			<th style="width:90%;" class="header_th"><span> : <?= date('d/m/Y',strtotime($header['receipt_date'])) ?></th>
		</tr>
	</table>
</header>

<footer>
	
</footer>

<!-- ================= BODY ================= -->
<div class="content">

<table style="margin-top:30px;">
<thead>
<tr>
<th class="datatable_td" style="width:100%;text-align:center; nowrap;">Payment & Summary</th>
</tr>
</thead>

<tbody>

<?php foreach ($invoices as $invoice): 
    $gross = $invoice['totals']['gross_total'] ?? 0;
    $discount = $invoice['totals']['total_discount'] ?? 0;
    $net = $gross - $discount;
?>

<tr>

<!-- LEFT PAYMENTS + RIGHT TOTALS -->
<td class="datatable_data_td">

<table style="width:100%;">
<tr>
<td style="width:50%;vertical-align:top;border-right:1px solid #000;">

<!-- PAYMENT METHODS -->
<table style="width:100%;">
<tr>
<th style="text-align:left;">Payment Method</th>
<th style="text-align:right;">Amount</th>
</tr>

<?php foreach ($invoice['payment_methods'][0]['transactions'] as $txn): ?>
<tr>
<td><?= ucfirst($txn['pay_method_label']) ?></td>
<td style="text-align:right;"><?= number_format($txn['allocated_amount'],2) ?></td>
</tr>
<?php endforeach; ?>

<tr>
<td style="font-weight:bold;border-top:1px solid #000;">Total Current Paid</td>
<td style="text-align:right;font-weight:bold;border-top:1px solid #000;">
<?= number_format($invoice['totals']['total_current_paid'],2) ?>
</td>
</tr>
</table>

</td>

<!-- TOTAL SUMMARY -->
<td style="width:50%;vertical-align:top;">

<table style="width:100%;">
<tr><td>Gross Total</td><td>:</td><td style="text-align:right"><?= number_format($gross,2) ?></td></tr>
<tr><td>Discount</td><td>:</td><td style="text-align:right;border-bottom:1px solid #000;"><?= ($invoice['totals']['total_discount'] > 0) ? '(' . number_format($invoice['totals']['total_discount'], 2) . ')' : number_format($invoice['totals']['total_discount'] ?? 0, 2) ?></td></tr>
<tr><td>Net Total</td><td>:</td><td style="text-align:right"><?= number_format($net,2) ?></td></tr>
<tr><td>Advance</td><td>:</td><td style="text-align:right;border-bottom:1px solid #000;"><?= ($invoice['totals']['advance_total'] > 0)? '(' . number_format($invoice['totals']['advance_total'], 2) . ')' : number_format($invoice['totals']['advance_total'] ?? 0, 2) ?></td></tr>
<tr><td style="font-weight:bold;">Total Paid</td><td>:</td><td style="text-align:right;font-weight:bold;"><?= number_format(($invoice['totals']['total_paid_for_ref'] ?? 0) + ($invoice['totals']['advance_total'] ?? 0),2) ?></td></tr>
<tr>
<td style="font-weight:bold;border-top:1px solid #000;border-bottom:3px double #000;">Balance</td>
<td style="border-top:1px solid #000;border-bottom:3px double #000;">:</td>
<td style="text-align:right;font-weight:bold;border-top:1px solid #000;border-bottom:3px double #000; font-weight:bold;">
    <?= number_format(($invoice['totals']['grand_total'] ?? 0) - ($invoice['totals']['total_paid_for_ref'] ?? 0),2) ?>
</td>
</tr>
</table>

</td>
</tr>

</table>
</td>
</tr>


<?php endforeach; ?>

</tbody>
</table>

</div>

</body>
</html>
