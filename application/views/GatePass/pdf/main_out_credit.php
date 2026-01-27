<!DOCTYPE html>
<html>
<head><meta charset="UTF-8">
<title>ECW Software - Gate Pass OUT</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
<style>
@page {
	margin: 3mm 15mm 2mm 1mm;
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
	margin: 0 0 8px 0;
	width: 100%;
}

.gate-pass-title {
	font-size: 34px;
	font-weight: 700;
	letter-spacing: 2px;
	margin: 0;
	padding: 0;
	text-transform: uppercase;
	line-height: 1.1;
	text-align: center;
}

.gate-pass-out {
	font-size: 44px;
	font-weight: 700;
	letter-spacing: 3px;
	margin: 2px 0;
	padding: 0;
	text-transform: uppercase;
	line-height: 1.1;
	text-align: center;
}

.vehicle-number-label {
	font-size: 20px;
	font-weight: 400;
	margin: 8px 0 2px 0;
	padding: 0;
	text-align: center;
}

.vehicle-number {
	font-size: 34px;
	font-weight: 700;
	letter-spacing: 4px;
	margin: 0;
	padding: 0;
	text-transform: uppercase;
	line-height: 1.1;
	text-align: center;
}

.gate-pass-table {
	margin: 12px auto;
	width: 100%;
	border: 1px solid #d0d0d0;
	border-collapse: collapse;
	table-layout: fixed;
}

.gate-pass-table tr {
	border: 1.5px solid rgb(0, 0, 0);
}

.gate-pass-table td {
	padding: 7px 3px;
	border: 1.5px solid rgb(0, 0, 0);
	font-size: 12px;
	line-height: 1.4;
	vertical-align: middle;
	text-align: center;
}

.gate-pass-table td.label {
	font-weight: 400;
	width: 27%;
	text-align: center;
}

.gate-pass-table td.value {
	font-weight: 600;
	width: 23%;
	text-align: center;
}

.status-pass {
	color:rgb(0, 0, 0);
	font-weight: 700;
	font-size: 12px;
	text-transform: uppercase;
}

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
	padding: 15px 0 0 0;
	vertical-align: top;
}

.signature-table td:first-child {
	width: 45%;
	text-align: center;
}

.signature-table td:nth-child(2) {
	width: 10%;
	padding: 0;
}

.signature-table td:last-child {
	width: 45%;
	text-align: right;
}

.signature-line {
	border-top: 2px dashed #000;
	padding-top: 4px;
	font-size: 12px;
	font-weight: 400;
}

.signature-line.center {
	text-align: center;
	padding: 0 10px;
}

.print-info {
	margin-top: 12px;
	font-weight: 700;
	font-size: 10px;
	text-align: center;
	line-height: 1.4;
	width: 100%;
}

.duplicate-label {
	color:rgb(0, 0, 0);
	font-weight: 700;
	font-size: 14px;
	text-transform: uppercase;
	margin-bottom: 4px;
}

.gate-pass-number {
	font-size: 14px;
	font-weight: 600;
	margin: 4px 0;
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
$location = $gp['location'] ?? [];
$vehicle_number = $jobCard['vehicle_number'] ?? 'N/A';
$job_card_number = $jobCard['real_jobcard_no'] ?? $jobCard['job_card_number2'] ?? 'N/A';
$sales_person = $jobCard['sales_person_name'] ?? 'N/A';
$cashier = $jobCard['cashier_name'] ?? 'N/A';
$job_start_date = isset($jobCard['job_start_datetime']) ? date('Y-m-d', strtotime($jobCard['job_start_datetime'])) : 'N/A';
$job_end_date = isset($jobCard['handover_date']) ? date('Y-m-d', strtotime($jobCard['handover_date'])) : 'N/A';
$gate_pass_number = $gp['gate_pass_number'] ?? 'N/A';

// Determine actual job status and payment status from job card
// Job Status: job_progress_status (0=Pending, 1=In Progress, 2=Completed)
$job_progress_status = $jobCard['job_progress_status'] ?? 0;
$job_status_text = 'PENDING';
if ($job_progress_status == 1) {
    $job_status_text = 'IN PROGRESS';
} elseif ($job_progress_status == 2) {
    $job_status_text = 'PASS';
}

// Payment Status: Check invoice_status and payment_status
$invoice_status = $jobCard['invoice_status'] ?? 0;
$payment_status = $jobCard['payment_status'] ?? 0;
$payment_status_text = 'PENDING';

// Payment completed if: invoice_status == 2 AND (payment_status == 1 OR payment_status == 2)
if ($invoice_status == 2 && ($payment_status == 1 || $payment_status == 2)) {
    $payment_status_text = 'PASS';
} elseif ($invoice_status == 2 && $payment_status == 0) {
    $payment_status_text = 'PENDING';
} elseif ($invoice_status == 2) {
    $payment_status_text = 'INVOICED';
} else {
    $payment_status_text = 'PENDING';
}

// For credit gate passes, show payment type
$payment_type = $jobCard['payment_type'] ?? 1;
if ($payment_type != 1) {
    $payment_status_text = 'CREDIT';
}
?>
</head>
<body>

<div class="wrapper">
<div class="content">
	<?php if (!empty($is_duplicate)): ?>
		<div class="duplicate-label">DUPLICATE</div>
	<?php endif; ?>
	<div class="gate-pass-header">
		<div class="gate-pass-title">GATE PASS</div>
		<div class="gate-pass-out">OUT</div>
		<div class="gate-pass-number">No: <?= $gate_pass_number ?></div>
		<div class="vehicle-number-label">Vehicle Number</div>
		<div class="vehicle-number"><?= strtoupper($vehicle_number) ?></div>
	</div>

	<table class="gate-pass-table">
		<tr>
			<td class="label">Job Card No:</td>
			<td class="value"><?= $job_card_number ?></td>
			<td class="label">Sales Person:</td>
			<td class="value"><?= $sales_person ?></td>
		</tr>
		<tr>
			<td class="label">Job Start Date:</td>
			<td class="value"><?= $job_start_date ?></td>
			<td class="label">Job End Date:</td>
			<td class="value"><?= $job_end_date ?></td>
		</tr>
		<tr>
			<td class="label">Job Status</td>
			<td class="value"><span class="status-pass"><?= $job_status_text ?></span></td>
			<td class="label">Payment</td>
			<td class="value"><span class="status-pass"><?= $payment_status_text ?></span></td>
		</tr>
	</table>

	<div class="signature-area">
		<table class="signature-table">
			<tr>
				<td class="center">
					<div class="signature-line center">
						Sign: Sales Person
					</div>
				</td>
                <td></td>
				<td class="center">
					<div class="signature-line center">
						Sign: Cashier
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

