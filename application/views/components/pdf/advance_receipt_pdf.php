<!DOCTYPE html>
<html>
<head><meta charset="UTF-8">
<title>ECW Software</title>
<link rel="stylesheet" href="<?php echo base_url('assets/fonts/roboto.css'); ?>">
<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/logo-icon.png" />
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome/all.css'); ?>" />
<style>
@page {
	    margin: 40mm 15mm 15mm 1mm;
}

body {
	margin: 0;
	font-family: sans-serif;
	font-size: 9px;
}

header {
    position: fixed;
    top: -40mm;
    left: 0;
    right: 0;
    height: 40mm;
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
$branchOutput = '';

switch ($header['company_branch_id']) {
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
						<td style="text-align:right; width:70%;">ADVANCE PAYMENT RECEIPT</td>
						<td style="text-align:right; width:30%;">
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
