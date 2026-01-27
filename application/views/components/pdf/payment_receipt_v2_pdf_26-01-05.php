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
	margin: 27mm 15mm 15mm 1mm;
}
body {
	margin: 0;
	font-family: sans-serif;
	font-size: 9px;
}
header {
	position: fixed;
	top: -22mm;
	left: 0;
	right: 0;
	height: 22mm;
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
	margin-top: -5mm;
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
// Safe header variables
$branchOutput = 'No Branch';
$branch_id = $header['company_branch_id'] ?? null;
switch ($branch_id) {
	case '1': $branchOutput = 'Head Office - Nittambuwa 0332 286 729'; break;
	case '2': $branchOutput = 'BRANCH COLOMBO ROAD, KURANA, NEGOMBO 0312 224 220'; break;
	case '3': $branchOutput = 'No Branch 3'; break;
}
$customer_name = $header['customer_name'] ?? 'N/A';
$address = $header['address'] ?? '';
$address2 = $header['address_2'] ?? '';
$city = $header['city'] ?? '';
$district = $header['district'] ?? '';
?>

</head>
<body>

<header>
	<table>
		<tr>
			<th colspan="2" style="height:20px;width:83%;font-size:14px;font-weight:500;" class="header_th">
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
			<th style="width:90%;" class="header_th"><span> : </span><?= $customer_name ?></th>
		</tr>
		<tr>
			<th style="width:10%;" class="header_th">Address</th>
			<th style="width:90%;" class="header_th"><span> : </span>
				<?= $address . ($address2 ? ', ' . $address2 : '') . ($city ? ', ' . $city : '') . ($district ? ', ' . $district : '') ?>
			</th>
		</tr>
		<tr>
			<th style="width:10%;" class="header_th">Date</th>
			<th style="width:90%;" class="header_th"><span> : </span><?= date('d/m/Y') ?></th>
		</tr>
	</table>
</header>

<footer></footer>

<div class="content">
<?php if (!empty($invoices)): ?>
	<?php foreach ($invoices as $inv_index => $invoice): ?>
		<?php 
		$invoice_details = $invoice['invoice_details'] ?? [];
		$totals = $invoice['totals'] ?? [];
		$payment_transactions = $invoice['payment_methods'][0]['transactions'] ?? [];
		?>
		<div style="<?= ($inv_index < count($invoices) - 1) ? 'page-break-after: always;' : '' ?>">
			<div style="margin-bottom: 20px;">
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
						<?php foreach ($invoice_details as $i => $item): ?>
						<tr>
							<td class="datatable_data_td"><?= $i+1 ?></td>
							<td class="datatable_data_td"><?= $item['description'] ?? '' ?></td>
							<td class="datatable_data_td" style="text-align:center"><?= $item['quantity'] ?? '' ?></td>
							<td class="datatable_data_td" style="text-align:center"><?= $item['unit'] ?? '' ?></td>
							<td class="datatable_data_td" style="text-align:right"><?= number_format($item['unit_price'] ?? 0,2) ?></td>
							<td class="datatable_data_td" style="text-align:right"><?= $item['line_total_after_discount'] == 0 ? '' : number_format($item['line_discount_pc'], 0). '%' ?></td>
							<?php
								$line_net_total = (float)$item['line_total_after_discount'];
								$is_exchange = (stripos($item['description'], 'Exchange') !== false); // Case-insensitive search
							?>
							<td class="datatable_data_td" style="text-align:right">
								<?= $line_net_total == 0 ? '' : ($is_exchange ? '(' . number_format($line_net_total, 2) . ')' : number_format($line_net_total, 2)) ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php
                    $gross_total = $totals['gross_total'] ?? 0;
                    $total_discount = $totals['total_discount'] ?? 0;

                    $net_total_after_discount = $gross_total - $total_discount;

					$advance_total = $totals['advance_total'] ?? 0;
                ?>
				<div style="margin-top:10px;border-top: 1.5px solid #000;">
					<table>
						<tr>
							<td style="width:50%; vertical-align:top; padding-right:10px;">
								<table>
									<?php $total_paid = 0; ?>
									<?php foreach ($payment_transactions as $txn): ?>
										<?php $total_paid += (float)($txn['allocated_amount'] ?? 0); ?>
										<tr>
											<td class="datatable_data_td"><?= $txn['pay_method_label'] ?? '' ?></td>
											<td class="datatable_data_td" style="text-align:right"><?= number_format($txn['allocated_amount'] ?? 0,2) ?></td>
										</tr>
									<?php endforeach; ?>
									<tr><td colspan="2" style="height:40px;"></td></tr>
								</table>
							</td>

							<td style="width:50%; vertical-align:top; padding-left:10px;">
								<table style="width:100%;">
									<tr>
										<td class="datatable_data_td">Grand Total</td>
										<td class="datatable_data_td" style="text-align:center;">:</td>
										<td class="datatable_data_td" style="text-align:right;"><?= number_format($totals['gross_total'] ?? 0, 2) ?></td>
									</tr>
									<tr>
										<td class="datatable_data_td">Discount Total</td>
										<td class="datatable_data_td" style="text-align:center;">:</td>
										<td class="datatable_data_td" style="text-align:right; border-bottom:1px solid #000;">
											<?= ($total_discount > 0)
												? '(' . number_format($total_discount, 2) . ')'
												: number_format($total_discount, 2)
											?>
										</td>
									</tr>
									<tr>
										<td class="datatable_data_td" style="width:60%;">Net Amount</td>
										<td class="datatable_data_td" style="width:10%; text-align:center;">:</td>
										<td class="datatable_data_td" style="width:30%; text-align:right;">
											<?= number_format($net_total_after_discount ?? 0, 2) ?>
										</td>
									</tr>
									<tr>
										<td class="datatable_data_td">Advance</td>
										<td class="datatable_data_td" style="text-align:center;">:</td>
										<td class="datatable_data_td" style="text-align:right; border-bottom:1px solid #000;">
											<?= ($advance_total > 0)
												? '(' . number_format($advance_total, 2) . ')'
												: number_format($advance_total, 2)
											?>
										</td>
									</tr>
									<tr>
										<td class="datatable_data_td" style="font-weight:bold;">Current Paid</td>
										<td class="datatable_data_td" style="text-align:center; font-weight:bold;">:</td>
										<td class="datatable_data_td" style="text-align:right; font-weight:bold;"><?= number_format($totals['total_current_paid'] ?? 0, 2) ?></td>
									</tr>
									<tr>
										<td class="datatable_data_td" style="font-weight:bold;">Total Paid</td>
										<td class="datatable_data_td" style="text-align:center; font-weight:bold;">:</td>
										<td class="datatable_data_td" style="text-align:right; font-weight:bold;"><?= number_format(($totals['total_paid_for_ref'] ?? 0) + ($totals['advance_total'] ?? 0), 2) ?></td>
									</tr>
									<tr>
										<td class="datatable_data_td" style="border-top:1px solid #000; border-bottom:3px double #000; font-weight:bold;">Net Balance</td>
										<td class="datatable_data_td" style="text-align:center; border-top:1px solid #000; border-bottom:3px double #000; font-weight:bold;">:</td>
										<td class="datatable_data_td" style="text-align:right; border-top:1px solid #000; border-bottom:3px double #000; font-weight:bold;"><?= number_format(($totals['payble_total'] ?? 0) - ($totals['total_paid_for_ref'] ?? 0), 2) ?></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<p style="text-align:center; font-weight:bold;">No Payment Details available</p>
<?php endif; ?>
</div>

</body>
</html>
