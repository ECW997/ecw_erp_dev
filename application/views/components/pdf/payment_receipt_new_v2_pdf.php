<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ECW Software - Payment Receipt</title>
<link rel="stylesheet" href="<?php echo base_url('assets/fonts/roboto.css'); ?>">
<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/logo-icon.png" />
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome/all.css'); ?>" />
<style>
@page { margin: 0mm 0mm 0mm 0mm; }
body {
    font-family: sans-serif;
    font-size: 9px;
    margin: 0;
    color: #222;
	width: 80mm;
	padding: 5mm;

}
.table {
	width: 100%;
	border-collapse: collapse;
	/* margin-bottom: 4px; */
}
footer { text-align: center; font-size: 8px; color: #555; margin-top: 5px; }
.table th,
.table td {
	padding: 2px 3px;
	vertical-align: middle;
}

.table th {
	background: #f1f1f1;
	border-bottom: 1px solid #000;
	font-weight: bold;
}

.text-right {
	text-align: right;
}

.text-center {
	text-align: center;
}

.bold {
	font-weight: bold;
}

hr {
	border: 0;
	border-top: 1px solid #000;
	margin: 3px 0;
}

.item-negative {
	color: red;
}

.summary-table {
	width: 100%;
	border-collapse: collapse;
	margin-top: 4px;
}

.summary-table td {
	padding: 2px 3px;
}

.summary-table td.title {
	font-weight: bold;
	text-align: left;
}

.summary-table td.value {
	text-align: right;
}
.balance-cell {
    border-top: 1px solid #000;        /* top border */
    border-bottom: 3px double #000;    /* bottom double border */
    padding: 2px 4px;                  /* optional padding */
}

</style>
</head>
<body>

<?php
$customer_name = $header['customer_name'] ?? 'N/A';
$branch = $header['company_branch'] ?? '';
$address = ($header['address'] ?? '') . 
           (!empty($header['city']) ? ', '.$header['city'] : '') .
           (!empty($header['district']) ? ', '.$header['district'] : '');
?>

<!-- HEADER -->
<div style="text-align:center; font-size:12px; font-weight:bold;">PAYMENT RECEIPT</div>
<div class="text-center"><?= $branch ?></div>
<hr>

<table>
<tr>
    <td class="bold">Customer:</td>
    <td><?= $customer_name ?></td>
</tr>
<tr>
    <td class="bold">Date:</td>
    <td><?= date('d/m/Y') ?></td>
</tr>
<tr>
    <td class="bold">Address:</td>
    <td><?= $address ?></td>
</tr>
</table>

<hr>

<?php if (!empty($invoices)): ?>
<?php foreach ($invoices as $inv): ?>

<?php 
$invoice_details = $inv['invoice_details'] ?? [];
$totals = $inv['totals'] ?? [];
$payment_transactions = $inv['payment_methods'][0]['transactions'] ?? [];
?>

<table class="table">
<thead>
<tr>
    <th>#</th>
    <th>Description</th>
    <th class="text-center">Qty</th>
    <th class="text-right">Amount</th>
</tr>
</thead>
<tbody>
<?php foreach ($invoice_details as $i => $item): 
    // Extract main description before parentheses
    $mainDescription = preg_replace('/\s*\(.*\)$/', '', $item['description'] ?? '');
    $amount = (float)$item['line_total_after_discount'];
    $is_exchange = stripos($mainDescription,'Exchange') !== false;
?>
<tr>
    <td><?= $i+1 ?></td>
    <td><?= $item['description'] ?></td>
    <td class="text-center"><?= $item['quantity'] ?></td>
    <td class="text-right <?= $is_exchange ? 'item-negative' : '' ?>">
        <?= $is_exchange ? '(' . number_format($amount,2) . ')' : number_format($amount,2) ?>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<hr>

<table class="summary-table">
<tr><td colspan="2" class="bold">Payment Methods</td></tr>
<?php $total_paid = 0; ?>
<?php foreach ($payment_transactions as $txn): $total_paid += (float)($txn['allocated_amount'] ?? 0); ?>
<tr>
    <td class="title"><?= $txn['pay_method_label'] ?></td>
    <td class="value"><?= number_format($txn['allocated_amount'],2) ?></td>
</tr>
<?php endforeach; ?>

<tr><td colspan="2"><hr></td></tr>

<tr>
    <td class="title bold">Grand Total</td>
    <td class="value bold"><?= number_format($totals['gross_total'] ?? 0,2) ?></td>
</tr>
<tr>
    <td class="title">Discount</td>
    <td class="value"><?= number_format($totals['total_discount'] ?? 0,2) ?></td>
</tr>
<tr>
    <td class="title">Advance</td>
    <td class="value"><?= number_format($totals['advance_total'] ?? 0,2) ?></td>
</tr>
<tr>
    <td class="title bold">Paid</td>
    <td class="value bold"><?= number_format($total_paid + ($totals['advance_total'] ?? 0),2) ?></td>
</tr>
<tr>
    <td class="title bold balance-cell">Balance</td>
    <td class="value bold balance-cell"><?= number_format(($totals['payble_total'] ?? 0) - $total_paid,2) ?></td>
</tr>
</table>

<?php endforeach; ?>
<?php endif; ?>

<footer>
    <div>Thank you for your payment!</div>
</footer>

</body>
</html>