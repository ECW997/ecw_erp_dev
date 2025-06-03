
 <!DOCTYPE html>
 <html>

 <head>
 	<title>ECW Software</title>
 	<link rel="preconnect" href="https://fonts.googleapis.com">
 	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 	<link
 		href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
 		rel="stylesheet">
 	<link rel="icon" type="image/x-icon" href="assets/img/ecw2.jpg" />
 	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
 	<style>
 		@page {
 			margin: 5mm 16mm 2mm 20mm;
 			/* top right bottom left */
 		}

 		body {
 			margin: 0;
 			font-family: "Roboto", sans-serif;
 			font-size: 10px;
 			line-height: 1.5;
 			text-align: left;
 		}

 		header {
 			position: fixed;
 			top: 20px;
 			left: 0;
 			right: 0;
 			height: 90px;
 			text-align: center;
 			line-height: 35px;
 			border-bottom: 2px solid #000;
 		}

 		footer {
 			position: fixed;
 			bottom: 50px;
 			left: 0;
 			right: 0;
 			height: 30px;
 			text-align: center;
 			line-height: 30px;
 			border-top: 1px solid #ddd;
 		}

 		.content {
 			margin-top: 0px;

 		}

 		.header_th {
 			text-align: right;
 			height: 8px;
 			line-height: 0.4rem;
 			padding: 0;
 			font-weight: 400;
 		}

 		.sub_header_text_th {
 			text-align: left;
 			height: 4px;
 			line-height: 0.7rem;
 			padding: 0;
 			font-weight: 700;
 		}

 		.sub_header_text_td {
 			text-align: left;
 			height: 4px;
 			line-height: 0.7rem;
 			padding: 0;
 			font-weight: 400;
 		}

 		.datatable_td {
 			padding: 3px;
 			color: #000;
 			border: 1px solid #000;
 			font-size: 9px
 		}

 		.datatable_data_td {
 			border: none;
 			text-align: left;
 			height: 4px;
 			line-height: 0.6rem;
 			padding: 0;
 			padding: 0 3px 0 3px;
 			font-weight: 400;
 		}

 		.datatable_total_td {
 			padding: 3px;
 			border-top: 1.5px solid #000;
 			border-left: none;
 			border-right: none;
 			border-bottom: 1.5px solid #000;
 			text-align: right;
 		}
 	</style>
 </head>

 <body>
 	<div class="content">
 		<h1 style="text-align:center;">JOB CARD</h1>
 		<table
 			style="table-layout: fixed;padding:3px;padding-left:0px;padding-right:0px;width:100%;border-collapse: collapse;border-bottom: 1.5px solid #000">
 			<tr>
 				<th style="width:10%;" class="sub_header_text_th">Customer</th>
 				<th style="width:55%;" class="sub_header_text_td"><?= $main_data['customer_name'] ?? 'N/A' ?></th>
 				<th style="width:15%;" class="sub_header_text_th">Job Card No</th>
 				<th style="width:20%;" class="sub_header_text_td"><?= $main_data['job_card_number'] ?></th>
 			</tr>
 			<tr>
 				<th style="" class="sub_header_text_th">Address</th>
 				<th style="" class="sub_header_text_td"><?= ($main_data['address'] ?? '') . 
                        (!empty($main_data['address_2']) ? ', ' . $main_data['address_2'] : '') . 
                        (!empty($main_data['city']) ? ', ' . $main_data['city'] : '') . 
                        (!empty($main_data['district']) ? ', ' . $main_data['district'] : '') ?>
                </th>
 				<th style="" class="sub_header_text_th">Created Date</th>
 				<th style="" class="sub_header_text_td"><?= date('d/m/Y', strtotime($main_data['jobcard_date'])) ?></th>
 			</tr>
 			<tr>
 				<th style="" class="sub_header_text_th">Contact No</th>
 				<th style="" class="sub_header_text_td"> <?= $main_data['customer_mobile_num'] ?? 'N/A' ?>
					<?= (!empty($main_data['customer_mobile_num_2']) && $main_data['customer_mobile_num_2'] != "+94" ? ' / ' . $main_data['customer_mobile_num_2'] : '') ?>
                </th>
 				<th style="" class="sub_header_text_th">Created at</th>
 				<th style="" class="sub_header_text_td"><?= $main_data['branch'] ?? 'N/A' ?></th>
 			</tr>
 			<tr>
 				<th style="" class="sub_header_text_th">Vehicle No</th>
 				<th style="" class="sub_header_text_td"><?= $main_data['customer_vehicle_number'] ?? 'N/A' ?></th>
 				<th style="" class="sub_header_text_th">Sales Person Code</th>
 				<th style="" class="sub_header_text_td"><?= $main_data['sales_person_code'] ?? 'N/A' ?></th>
 			</tr>
 			<tr>
 				<th style="" class="sub_header_text_th">Vehicle Type</th>
 				<th style="" class="sub_header_text_td"><?= ($main_data['brand_name'] ?? '') . 
                        (!empty($main_data['model_name']) ? ', ' . $main_data['model_name'] : '') ?>
                </th>
 				<th style="" class="sub_header_text_th">Quotation No</th>
 				<th style="" class="sub_header_text_td"><?= $main_data['quotation_no'] ?? 'None' ?></th>
 			</tr>
 			<tr>
 				<th style="" class="sub_header_text_th">NIC</th>
 				<th style="" class="sub_header_text_td"><?= $main_data['nic_number'] ?? 'N/A' ?></th>
 				<th style="" class="sub_header_text_th">Customer PO</th>
 				<th style="" class="sub_header_text_td"><?= $main_data['customer_po'] ?? 'None' ?></th>
 			</tr>
 			<tr>
 				<th style="" class="sub_header_text_th">Job Start Date</th>
 				<th style="" class="sub_header_text_td"><?= date('d/m/Y', strtotime($main_data['jobcard_date'])) ?></th>
 				<th style="" class="sub_header_text_th">Payment Method</th>
 				<th style="" class="sub_header_text_td"><?= $main_data['payment_type'] ?? 'N/A' ?></th>
 			</tr>
 			<tr>
 				<th style="" class="sub_header_text_th">Sales Person</th>
 				<th style="" class="sub_header_text_td"><?= $main_data['sales_person_name'] ?? 'N/A' ?></th>
 				<th style="" class="sub_header_text_th">Job Complete Date</th>
 				<th style="" class="sub_header_text_td">
					<?= !empty($main_data['complete_date']) ? date('d/m/Y', strtotime($main_data['complete_date'])) : 'Pending' ?>
				</th>
 			</tr>
 			<tr>
 				<th style="" class="sub_header_text_th"></th>
 				<th style="" class="sub_header_text_td"></th>
 				<th style="" class="sub_header_text_th">Print Date</th>
 				<th style="" class="sub_header_text_td"><?= date('d/m/Y') ?></th>
 			</tr>
 		</table>
 		<h2 style="text-align:center;">JOB DETAILS</h2>
 		<table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
 			<tr>
 				<th style="width:4%;text-align:left;font-size:12px;"
 					class="sub_header_text_th datatable_td datatable_total_td">No</th>
 				<th style="width:46%;text-align:left;font-size:12px;"
 					class="sub_header_text_th datatable_td datatable_total_td">Job</th>
 				<th style="width:10%;text-align:left;font-size:12px;"
 					class="sub_header_text_th datatable_td datatable_total_td">Quantity</th>
 				<th style="width:40%;text-align:left;font-size:12px;"
 					class="sub_header_text_th datatable_td datatable_total_td">Remark</th>
 			</tr>
 		</table>

 		<?php 
        $mainJob_cnt = 1;
        foreach ($details_data as $item): ?>
 		<table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;border: 0px solid #000">
 			<tr>
				<td style="width:4%;text-align:left;border: 0px solid #000;font-size:12px;font-weight:bold;" class="datatable_td">
					<?= $mainJob_cnt ?>.</td>
				<td colspan="3" style="width:96%;text-align:left;border: 0px solid #000;font-size:12px;font-weight:bold;" class="datatable_td">
					<?= $item['job_sub_category_text'] ?? 'N/A' ?>
				</td>
			</tr>
            
        <?php
        $joblist_cnt = 1;
        foreach ($item['details'] as $joblist): ?>
            <tr>
                <td style="width:4%;text-align:left;border:none;font-size:12px;" class="datatable_td">
				</td>
				<td style="width:4%;text-align:left;border:none;font-size:12px;" class="datatable_td">
					<?= $joblist_cnt ?>.</td>
				<td style="width:42%;text-align:left;border:none;font-size:12px;" class="datatable_td">
					<?= $joblist['option_group_text'] ?? 'N/A' ?>
				</td>
				<td style="width:10%;text-align:left;border:none;font-size:12px;" class="datatable_td">
					X <?= $joblist['qty'] ?? 0 ?>
				</td>
				<td style="width:40%;text-align:left;border:none;font-size:12px;" class="datatable_td">
					<?= $joblist['combined_option'] ?? 'N/A' ?>
				</td>
			</tr>
        <?php $joblist_cnt++; ?>
        <?php endforeach; ?>
 		</table>

       
 		<table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
 			<tr>
 				<th style="width:3%;text-align:left;" class="sub_header_text_th datatable_td">#</th>
 				<th style="width:7%;text-align:left;" class="sub_header_text_th datatable_td">EMP CODE</th>
 				<th style="width:13%;text-align:center;" class="sub_header_text_th datatable_td">RATE</th>
 				<th style="width:17%;text-align:left;" class="sub_header_text_th datatable_td">EMP.</th>
 				<th style="width:10%;text-align:left;" class="sub_header_text_th datatable_td">E-R OFFICER </th>
 				<th style="width:10%;text-align:left;" class="sub_header_text_th datatable_td">PRODUCTION SUPERVISOR
 				</th>
 				<th style="width:10%;text-align:left;" class="sub_header_text_th datatable_td">QUALITY SUPERVISOR </th>
 				<th style="width:10%;text-align:left;" class="sub_header_text_th datatable_td">UPDATED HR DEPT.</th>
 				<th style="width:10%;text-align:left;" class="sub_header_text_th datatable_td">CHECKED HR DEPT.</th>
 				<th style="width:10%;text-align:left;" class="sub_header_text_th datatable_td">CHECKED ACC DEPT.</th>
 			</tr>
         
 			<tr>
 					<td style="width:3%;text-align:left;" class="datatable_td"></td>
 					<td style="width:7%;text-align:left;" class="datatable_td">ECW001</td>
 					<td style="width:13%;text-align:center;" class="datatable_td"></td>
 					<td style="width:17%;text-align:left;" class=" datatable_td"></td>
 					<td style="width:10%;text-align:left;" class="datatable_td"></td>
 					<td style="width:10%;text-align:left;" class="datatable_td"></td>
 					<td style="width:10%;text-align:left;" class="datatable_td"></td>
 					<td style="width:10%;text-align:left;" class="datatable_td"></td>
 					<td style="width:10%;text-align:left;" class="datatable_td"></td>
 					<td style="width:10%;text-align:left;" class="datatable_td"></td>
 			</tr>
            
 		</table> 
	
 		<div style="border-bottom: 2px dashed #000;margin-top:10px;"></div>';
 		<?php $mainJob_cnt++; ?>
		<?php endforeach; ?>

 	</div>
 </body>

 </html>