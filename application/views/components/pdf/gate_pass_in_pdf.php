<!DOCTYPE html>
<html>
<head><meta charset="UTF-8">
<title>ECW Software - Gate Pass</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
<style>
@page {
	margin: 3mm 15mm 2mm 1mm;
}

* {
	/* margin: 0; */
	padding: 0;
	box-sizing: border-box;
}

body {
	/* margin: 3mm 0mm 0mm 0mm; */
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

/* Header Section - Centered */
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

/* Table Section */
.gate-pass-table {
	margin: 12px auto;
	width: 100%;
	border: 1px solid #d0d0d0;
	/* background-color: #f5f5f5; */
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

/* Print Info Section */
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

/* Instructions Section */
.instructions {
	margin-top: 10px;
	color: #dc3545;
	font-style: italic;
	font-size: 7px;
	text-align: center;
	line-height: 1.4;
	width: 100%;
}
</style>
<!-- <style>
        body::before {
            content: "ECW";
            position: fixed;
            top: 8%;
            left: 5%;
            width: 100%;
            text-align: center;
            font-size: 300px;
            color: rgba(0, 0, 0, 0.23);
            transform: rotate(-45deg);
            z-index: 9999;
            pointer-events: none;
            spacing: 10px;
        }
    </style> -->
<?php
// Get current user info for print details
$CI =& get_instance();
$printed_by = $CI->session->userdata('name') 
           ?? $CI->session->userdata('username')
           ?? $CI->session->userdata('user_name')
           ?? $CI->session->userdata('user')
           ?? 'System';
$printed_date = date('l jS F, Y');
$printed_time = date('H:i');
?>
</head>
<body>

<div class="wrapper">
<div class="content">
	<!-- Gate Pass Header - Centered -->
	<?php if (!empty($is_duplicate)): ?>
		<div class="duplicate-label">DUPLICATE</div>
	<?php endif; ?>
	<div class="gate-pass-header">
		<div class="gate-pass-title">GATE PASS</div>
		<div class="gate-pass-out">IN</div>
		<div class="vehicle-number-label">Vehicle Number</div>
		<div class="vehicle-number"><?= strtoupper($main_data['vehicle_number'] ?? 'N/A') ?></div>
	</div>

	<!-- Job and Payment Details Table - 4 Columns -->
	<table class="gate-pass-table">
		<tr>
			<td class="label">Job Card No:</td>
			<td class="value"><?= $main_data['job_card_number2'] ?? 'N/A' ?></td>
			
		</tr>
		<tr>
			
			<td class="label">Sales Person:</td>
			<td class="value"><?= $main_data['sales_person_name'] ?? 'N/A' ?></td>
		</tr>
		<tr>
			<td class="label">Job Start Date:</td>
			<td class="value"><?= isset($main_data['job_start_datetime']) ? date('Y-m-d', strtotime($main_data['job_start_datetime'])) : 'N/A' ?></td>
		</tr>
	</table>

	<!-- Signature Area - Two Signatures -->
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
						Sign: Sales Manager
					</div>
				</td>
			</tr>
		</table>
	</div>

	<!-- Print Information - Left Aligned -->
	<div class="print-info">
		Printed On: <?= $printed_date ?> at <?= $printed_time ?> by <?= $printed_by ?>
	</div>
</div>
</div>

</body>
</html>
