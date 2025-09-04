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
	  margin: 36mm 15mm 15mm 1mm;
}

body {
	margin: 0;
	font-family: sans-serif;
	font-size: 9px;
}

header {
    position: fixed;
    top: -36mm;
    left: 0;
    right: 0;
    height: 36mm;
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

switch ($main_data['branch_id']) {
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
						<td style="text-align:right;">INVOICE</td>
						<td style="text-align:right; width:50px;">
							<?php if ($main_data['print_invoice_cnt'] > 1): ?>
								<span style="font-size:11px;color: rgba(200, 0, 0, 1);">(DUPLICATE)</span>
							<?php endif; ?>
						</td>
					</tr>
				</table>
			</th>
		</tr>
		<tr>
			<th style="width:10%;" class="header_th">Cus. Code</th>
			<th style="width:25%;" class="header_th"><span> : </span><?= $main_data['customer_code'] ?></th>
			<th style="width:10%;" class="header_th">Invoice No.</th>
			<th style="width:10%;" class="header_th"><span> : </span><?= $main_data['invoice_number'] ?></th>
		</tr>
		<tr>
			<th style="width:10%;" class="header_th">Cus Name</th>
			<th style="width:25%;" class="header_th"><span> : </span><?= $main_data['customer_name'] ?></th>
			<th style="width:10%;" class="header_th">Date</th>
			<th style="width:10%;" class="header_th"><span> : </span><?= date('d/m/Y',strtotime($main_data['invoice_date'])) ?></th>
		</tr>
		 <tr>
        	<th style="width:10%;" class="header_th">Address</th>
        	<th style="width:20%;" class="header_th"><span> : </span>
			<?= $main_data['invoice_type'] == '1' 
			? 	($main_data['address'] ?? '') . ' ' . 
				($main_data['address_2'] ?? '') . ' ' . 
				($main_data['city'] ?? '') . ' ' . 
				($main_data['district'] ?? '')
			: 	($main_data['customer_address'] ?? '') ?>
			</th>
			<th style="width:10%;" class="header_th">S.P.Code</th>
            <th style="width:10%;" class="header_th"><span> : </span><?= $main_data['sales_person_code'] ?? 'N/A' ?></th>
        </tr>
		<?php if ($main_data['invoice_type'] != 'direct'): ?>
		<tr>
			<th style="width:10%;" class="header_th">Vehicle No</th>
            <th style="width:20%;" class="header_th"><span> : </span><?= $main_data['vehicle_number'] ?? 'N/A' ?></th>
			<th style="width:10%;" class="header_th">Invoice Type</th>
        	<th style="width:10%;" class="header_th"><span> : </span><?= $main_data['invoice_type'] == 'direct' ? 'Direct' : 'JobCard' ?></th>
		</tr>
		<?php endif; ?>
		<tr>
            <th style="width:10%;" class="header_th">Vehicle Type.</th>
            <th style="width:10%;" class="header_th"><span> : </span><?= ($main_data['brand_name'] ?? '') . 
                        (!empty($main_data['model_name']) ? ', ' . $main_data['model_name'] : '') ?></th>
          	<th style="width:10%;" class="header_th" colspan="1" style="vertical-align: bottom;">JobCard No</th>
			<th style="width:10%; vertical-align: bottom;" class="header_th"><span> : </span><?= $main_data['real_jobcard_no'] ?? '' ?></th>
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

<div style="margin-bottom: 20px;">
	<table>
		<thead>
			<tr>
				<th class="datatable_td" style="width:3%">#</th>
				<th class="datatable_td" style="width:43%">DESCRIPTION</th>
				<th class="datatable_td" style="width:3%">QTY</th>
				<th class="datatable_td" style="width:10%">UNIT</th>
				<th class="datatable_td" style="width:13%">RATE</th>
				<th class="datatable_td" style="width:13%">DISC.</th>
				<th class="datatable_td" style="width:15%">AMOUNT</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total_line_discount = 0;
			foreach ($details_data as $i => $item): ?>
			<tr>
				<td class="datatable_data_td"><?= $i+1 ?></td>
				<td class="datatable_data_td"><?= $item['description'] ?></td>
				<td class="datatable_data_td" style="text-align:center"><?= $item['quantity'] ?></td>
				<td class="datatable_data_td" style="text-align:center"><?= $item['unit'] ?></td>
				<td class="datatable_data_td" style="text-align:right">
					<?= number_format($item['unit_price'],2) ?></td>
				<td class="datatable_data_td" style="text-align:right">
					<?= number_format($item['line_discount_amount'],2) ?></td>
				<td class="datatable_data_td" style="text-align:right">
					<?= number_format($item['line_total_after_discount'],2) ?></td>
			</tr>
			<?php
		 	$total_line_discount += (float)$item['line_discount_amount'];
			endforeach; ?>
		</tbody>
	</table>

	<div style="margin-top:10px;border-top: 1.5px solid #000;">
		<table>
			<tr>
				<td style="width:50%; vertical-align:top; padding-right:10px;">
					<table>
						<?php
                        $total_extr_charges = 0;
                        foreach ($extra_charge_data as $txn):
                            $total_extr_charges += (float)$txn['charge_amount'];
                        ?>
						<tr>
							<td class="datatable_data_td"><?= $txn['charge_type'] ?></td>
							<td class="datatable_data_td" style="text-align:right">
								<?= number_format($txn['charge_amount'],2) ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</td>

				<?php
				$inv_gross_total = (float)($main_data['inv_gross_total'] ?? 0);
				$inv_discount_amount = (float)($main_data['inv_discount_amount'] ?? 0);
				// $total_discount = $main_data['invoice_type'] == 'direct' ? $inv_discount_amount : $inv_discount_amount + $total_line_discount;
				$total_discount = $inv_discount_amount;
				$advance = (float)($main_data['inv_advance_total'] ?? 0);
				$grand_total = $inv_gross_total - ($total_discount + $advance);
				$total_paid = (float)($total_paid_for_ref ?? 0);
				$total_net_balance = $grand_total - $total_paid;
				?>
				<td style="width:50%; vertical-align:top; padding-left:10px;">
					<table style="width:100%;">
						<tr>
							<td class="datatable_data_td" style="width:60%;">Grand Total</td>
							<td class="datatable_data_td" style="width:10%; text-align:center;">:</td>
							<td class="datatable_data_td" style="width:30%; text-align:right;">
								<?= number_format($inv_gross_total ?? 0, 2) ?>
							</td>
						</tr>
						<tr>
							<td class="datatable_data_td" style="width:60%;">Discount Total</td>
							<td class="datatable_data_td" style="width:10%; text-align:center;">:</td>
							<td class="datatable_data_td" style="width:30%; text-align:right;">
								<?= number_format($total_discount ?? 0, 2) ?>
							</td>
						</tr>
						<tr>
							<td class="datatable_data_td">Advance</td>
							<td class="datatable_data_td" style="text-align:center;">:</td>
							<td class="datatable_data_td" style="text-align:right;">
								<?= number_format($advance ?? 0, 2) ?>
							</td>
						</tr>
						<!-- <tr>
							<td class="datatable_data_td">Grand Total</td>
							<td class="datatable_data_td" style="text-align:center;">:</td>
							<td class="datatable_data_td" style="text-align:right;">
								<?= number_format($grand_total ?? 0, 2) ?>
							</td>
						</tr> -->
						<tr>
							<td class="datatable_data_td" style="font-weight:bold;">Total Paid</td>
							<td class="datatable_data_td" style="text-align:center; font-weight:bold;">:</td>
							<td class="datatable_data_td" style="text-align:right; font-weight:bold;">
								<?= number_format(($total_paid ?? 0) + ($advance ?? 0), 2) ?>
							</td>
						</tr>
						<tr>
							<td class="datatable_data_td"
								style="border-top:1px solid #000; border-bottom:3px double #000; font-weight:bold;">
								Net Balance</td>
							<td class="datatable_data_td"
								style="text-align:center; border-top:1px solid #000; border-bottom:3px double #000; font-weight:bold;">
								:</td>
							<td class="datatable_data_td"
								style="text-align:right; border-top:1px solid #000; border-bottom:3px double #000; font-weight:bold;">
								<?= number_format($total_net_balance ?? 0, 2) ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>

</body>
</html>
