<!DOCTYPE html>
<html>
<head><meta charset="UTF-8">
<title>ECW Software</title>
<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="assets/img/ecw2.jpg" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/> -->
<link rel="stylesheet" href="<?php echo base_url('assets/fonts/roboto.css'); ?>">
<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/logo-icon.png" />
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome/all.css'); ?>" />
<style>
@page {
	    margin: 32mm 15mm 15mm 1mm;
}

body {
	margin: 0;
	font-family: sans-serif;
	font-size: 9px;
}

header {
    position: fixed;
    top: -25mm;
    left: 0;
    right: 0;
    height: 25mm;
	margin-bottom:5px;
	border-bottom: 2px solid #000;
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
    margin-top: 10mm;
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

.datatable_td {
	padding: 3px;
	border-top: 1.5px solid #000;
	border-bottom: 1.5px solid #000;
}

.datatable_data_td {
	padding: 1px 3px;
	line-height: 1.2;
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
						<td style="text-align:right; width:55%;">ADVANCE PAYMENT RECEIPT</td>
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

<footer>
	
</footer>

<?php foreach ($invoices as $inv_index => $invoice): ?>
        <div style="margin-bottom: 10px;">
            
			<br>
            <table>
                    <?php
                    $total_paid = 0;
                    foreach ($invoice['payment_methods'][0]['transactions'] as $txn):
                                    $total_paid += (float)$txn['allocated_amount'];
                    ?>
                    <tr>
                        <td class="datatable_data_td">Advance: <?= $txn['pay_method_label'] ?></td>
                        <td class="datatable_data_td" style="text-align:right"><?= number_format($txn['allocated_amount'],2) ?></td>
                    </tr>
                    <?php endforeach; ?>
					<tr>
                        <td colspan="2" style="height:220px;"></td>
                    </tr>
					<tr>
                        <td style="width: 50%; text-align: center;" class="datatable_data_td">....................................</td>
                        <td style="width: 50%; text-align: center;" class="datatable_data_td">....................................</td>
                    </tr>
                    <tr>
                        <td style="width: 50%; text-align: center;" class="datatable_data_td">Customer</td>
                        <td style="width: 50%; text-align: center;" class="datatable_data_td">Cashier</td>
                    </tr>
                        
            </table>
        </div>
<?php endforeach; ?>

</body>
</html>
