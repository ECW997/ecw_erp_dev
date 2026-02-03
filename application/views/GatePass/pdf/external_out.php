<!DOCTYPE html>
<html>
<head><meta charset="UTF-8">
<title>ECW Software - Gate Pass EXTERNAL OUT</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
<style>
@page {
	margin: 3mm 15mm 2mm 1mm;
}

@page:first {
	margin: 3mm 15mm 2mm 1mm;
}

@page:not(:first) {
	margin: 5mm 15mm 2mm 1mm;
}

* {
	padding: 0;
	box-sizing: border-box;
}

body {
	padding: 0;
	font-family: 'Roboto', Arial, sans-serif;
	font-size: 9px;
	line-height: 1.2;
}

.wrapper {
	width: 100%;
	text-align: center;
}

.content {
	width: 100mm;
	margin: 0 auto;
	text-align: center;
}


.gate-pass-header {
	text-align: center;
	margin: 0 0 6px 0;
	width: 100%;
}

.gate-pass-title {
	font-size: 32px;
	font-weight: 700;
	letter-spacing: 2px;
	margin: 0;
	padding: 0;
	text-transform: uppercase;
	line-height: 1.1;
	text-align: center;
}

.gate-pass-type {
	font-size: 22px;
	font-weight: 700;
	letter-spacing: 2px;
	margin: 2px 0;
	padding: 0;
	text-transform: uppercase;
	line-height: 1.1;
	text-align: center;
}

.vehicle-number-label {
	font-size: 18px;
	font-weight: 400;
	margin: 6px 0 2px 0;
	padding: 0;
	text-align: center;
}

.vehicle-number {
	font-size: 32px;
	font-weight: 700;
	letter-spacing: 4px;
	margin: 0;
	padding: 0;
	text-transform: uppercase;
	line-height: 1.1;
	text-align: center;
}

.gate-pass-table {
	margin: 8px auto;
	width: 100%;
	border: 1px solid #d0d0d0;
	border-collapse: collapse;
	table-layout: fixed;
}

.gate-pass-table tr {
	border: 1.5px solid rgb(0, 0, 0);
}

.gate-pass-table td {
	padding: 5px 3px;
	border: 1.5px solid rgb(0, 0, 0);
	font-size: 11px;
	line-height: 1.3;
	vertical-align: middle;
	text-align: center;
	word-wrap: break-word;
	overflow-wrap: break-word;
}

.gate-pass-table td.label {
	font-weight: 400;
	width: 27%;
	text-align: center;
	font-size: 10px;
}

.gate-pass-table td.value {
	font-weight: 600;
	width: 23%;
	text-align: center;
	font-size: 11px;
}

/* Address field - allow wrapping */
.gate-pass-table td.value.address-value {
	font-size: 10px;
	line-height: 1.2;
	text-align: left;
	padding: 4px 3px;
	word-break: break-word;
}

/* Signature Section */
.signature-area {
	margin: 55px 0 10px 0;
	width: 100%;
}

.signature-table {
	width: 100%;
	border-collapse: collapse;
	table-layout: fixed;
}

.signature-table td {
	padding: 15px 2px 0 2px;
	vertical-align: top;
	width: 25%;
	text-align: center;
}

.signature-line {
	border-top: 2px dashed #000;
	padding-top: 4px;
	font-size: 11px;
	font-weight: 400;
	white-space: nowrap;
	line-height: 1.2;
	margin: 0 8px;
}

.signature-line.left {
	text-align: left;
	padding-right: 10px;
}

.signature-line.center {
	text-align: center;
	padding: 0 10px;
}

.signature-line.right {
	text-align: right;
	padding-left: 10px;
}

.print-info {
	margin-top: 8px;
	font-weight: 700;
	font-size: 9px;
	text-align: center;
	line-height: 1.3;
	width: 100%;
}

.duplicate-label {
	color:rgb(0, 0, 0);
	font-weight: 700;
	font-size: 13px;
	text-transform: uppercase;
	margin-bottom: 3px;
}

.gate-pass-number {
	font-size: 13px;
	font-weight: 600;
	margin: 3px 0;
	text-align: center;
}


</style>
<?php
$CI =& get_instance();
$printed_by = $CI->session->userdata('name') 
           ?? $CI->session->userdata('username')
           ?? $CI->session->userdata('user_name')
           ?? $CI->session->userdata('user')
           ?? 'System';
// Use actual print timestamp from database, not current server time
$printed_timestamp = isset($printed_timestamp) ? $printed_timestamp : date('Y-m-d H:i:s');
$printed_datetime = new DateTime($printed_timestamp);
$printed_date = $printed_datetime->format('l jS F, Y');
$printed_time = $printed_datetime->format('H:i');

// Extract data from gate pass
$gp = $gate_pass;
$jobCard = $gp['job_card'] ?? [];
$sales_person = $jobCard['sales_person_name'] ?? '';
$location = $gp['location'] ?? [];
$vehicle_number = $jobCard['vehicle_number'] ?? 'N/A';
$job_card_number = $jobCard['real_jobcard_no'] ?? $jobCard['job_card_number2'] ?? 'N/A';
$external_party_name = $gp['external_party_name'] ?? 'N/A';
$external_party_type = $gp['external_party_type'] ?? '';
$external_party_contact = $gp['external_party_contact'] ?? '';
$external_party_address = $gp['external_party_address'] ?? '';
$external_transfer_purpose = $gp['external_transfer_purpose'] ?? 'N/A';
$company_driver_name = $gp['company_driver_name'] ?? '';
$company_driver_contact = $gp['company_driver_contact'] ?? '';
$company_worker_name = $gp['company_worker_name'] ?? '';
$company_worker_contact = $gp['company_worker_contact'] ?? '';
$expected_return_date = isset($gp['expected_return_date']) ? date('Y-m-d', strtotime($gp['expected_return_date'])) : '';
$gate_pass_number = $gp['gate_pass_number'] ?? 'N/A';
$remarks = $gp['remarks'] ?? '';
?>
</head>
<body>

<div class="wrapper">
<div class="content first-page">
	<?php if (!empty($is_duplicate)): ?>
		<div class="duplicate-label">DUPLICATE</div>
	<?php endif; ?>
	<div class="gate-pass-header">
		<div class="gate-pass-title">GATE PASS</div>
		<div class="gate-pass-type">EXTERNAL - TEMP OUT</div>
		<div class="gate-pass-number">No: <?= $gate_pass_number ?></div>
		<div class="vehicle-number-label">Vehicle Number</div>
		<div class="vehicle-number"><?= strtoupper($vehicle_number) ?></div>
	</div>

	<table class="gate-pass-table">
		<tr>
			<td class="label">Job Card No:</td>
			<td class="value"><?= $job_card_number ?></td>
		</tr>
		<?php if (!empty($sales_person)): ?>
		<tr>
			<td class="label">Sales Person:</td>
			<td class="value"><?= $sales_person ?></td>
		</tr>
		<?php endif; ?>
		<tr>
			<td class="label">External Party:</td>
			<td class="value"><?= $external_party_name ?></td>
		</tr>
		<?php if (!empty($external_transfer_purpose) && $external_transfer_purpose !== 'N/A'): ?>
		<tr>
			<td class="label">Transfer Purpose:</td>
			<td class="value"><?= $external_transfer_purpose ?></td>
		</tr>
		<?php endif; ?>
		<?php if (!empty($company_driver_name)): ?>
		<tr>
			<td class="label">Company Driver:</td>
			<td class="value"><?= $company_driver_name ?><?= !empty($company_driver_contact) ? ' (' . $company_driver_contact . ')' : '' ?></td>
		</tr>
		<?php endif; ?>
		<?php if (!empty($company_worker_name)): ?>
		<tr>
			<td class="label">Company Worker:</td>
			<td class="value"><?= $company_worker_name ?><?= !empty($company_worker_contact) ? ' (' . $company_worker_contact . ')' : '' ?></td>
		</tr>
		<?php endif; ?>
		<?php if (!empty($remarks)): ?>
		<tr>
			<td class="label">Remarks:</td>
			<td class="value"><?= $remarks ?></td>
		</tr>
		<?php endif; ?>
	</table>

	<div class="signature-area">
		<table class="signature-table">
			<tr>
				<td>
					<div class="signature-line center">
						Sales Person
					</div>
				</td>
				<td>
					<div class="signature-line center">
						Cashier
					</div>
				</td>
				<td class="center">
					<div class="signature-line center">
						Authorized Person
					</div>
				</td>
				<td class="center">
					<div class="signature-line center">
						Security Officer
					</div>
				</td>
			</tr>
		</table>
	</div>

	<div class="print-info">
		Printed On: <?= $printed_date ?> at <?= $printed_time ?> by <?= $printed_by ?>
	</div>
</div>
</div>

</body>
</html>

