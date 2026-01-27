<?php
// Number to words conversion function (using Million instead of Lakh)
function convertNumberToWords($number) {
    $ones = array(
        0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
        5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
        14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
        18 => 'Eighteen', 19 => 'Nineteen'
    );
    
    $tens = array(
        2 => 'Twenty', 3 => 'Thirty', 4 => 'Forty', 5 => 'Fifty',
        6 => 'Sixty', 7 => 'Seventy', 8 => 'Eighty', 9 => 'Ninety'
    );
    
    if ($number == 0) {
        return 'Zero';
    }
    
    $number = abs($number);
    $result = '';
    
    // Handle millions (1,000,000 and above)
    if ($number >= 1000000) {
        $millions = floor($number / 1000000);
        $result .= convertNumberToWords($millions) . ' Million ';
        $number %= 1000000;
    }
    
    // Handle thousands (1,000 to 999,999)
    if ($number >= 1000) {
        $thousands = floor($number / 1000);
        $result .= convertNumberToWords($thousands) . ' Thousand ';
        $number %= 1000;
    }
    
    // Handle hundreds (100 to 999)
    if ($number >= 100) {
        $hundreds = floor($number / 100);
        $result .= $ones[$hundreds] . ' Hundred ';
        $number %= 100;
    }
    
    // Handle tens (20 to 99)
    if ($number >= 20) {
        $tensDigit = floor($number / 10);
        $result .= $tens[$tensDigit] . ' ';
        $number %= 10;
    }
    
    // Handle ones (1 to 19)
    if ($number > 0) {
        $result .= $ones[$number] . ' ';
    }
    
    return trim($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petty Cash Voucher - <?= $movement['code'] ?? 'N/A' ?></title>
    <style>
        @page {
            size: A5 Portrait;
            margin: 0mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #000;
            background: #f5f5f5;
        }
        
        .vouchers-wrapper {
            width: 100%;
        }
        
        .voucher-container {
            width: 210mm; /* A5 landscape width */
            height: 148mm; /* A5 landscape height - fixed height */
            padding: 5mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        /* Header Section */
        .voucher-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 2px solid #000;
        }
        
        .company-logo {
            display: flex;
            align-items: flex-start;
        }
        
        .logo-text {
            font-size: 16px;
            font-weight: bold;
            line-height: 1.1;
        }
        
        .logo-text .ecw {
            color: #d32f2f;
            display: block;
            font-size: 18px;
            letter-spacing: 0.5px;
        }
        
        .logo-text .cushion {
            color: #1976d2;
            display: block;
            font-size: 12px;
            margin-top: 1px;
        }
        
        .company-info {
            text-align: right;
            font-size: 8px;
            line-height: 1.4;
        }
        
        .company-info strong {
            font-size: 9px;
            display: block;
            margin-bottom: 1px;
        }
        
        /* Title Section */
        .voucher-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 4px 0;
            text-decoration: underline;
            letter-spacing: 0.5px;
        }
        
        /* Details Section */
        .voucher-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 6px;
        }
        
        .detail-group {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        
        .detail-row {
            display: flex;
            align-items: baseline;
            gap: 6px;
        }
        
        .detail-label {
            font-weight: bold;
            min-width: 80px;
            font-size: 9px;
        }
        
        .detail-value {
            flex: 1;
            border-bottom: 1px dotted #333;
            padding-bottom: 1px;
            min-height: 12px;
            font-size: 9px;
        }
        
        /* Particulars and Narration Sections */
        .particulars-section {
            margin-bottom: 5px;
        }
        
        /* Ensure narration section doesn't break across pages */
        .narration-section {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        
        .narration-section table {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        
        .narration-section table tbody {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 3px;
            padding-bottom: 2px;
            border-bottom: 1px solid #000;
            text-transform: uppercase;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            font-size: 9px;
        }
        
        table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            padding: 3px 4px;
            border: 1px solid #000;
            font-size: 9px;
        }
        
        table td {
            border: 1px solid #000;
            padding: 3px 4px;
            text-align: left;
            font-size: 9px;
        }
        
        table td strong {
            font-weight: bold;
        }
        
        .text-right {
            text-align: right;
        }
        
        /* Amount in Words */
        .amount-in-words {
            margin-top: 5px;
            padding: 4px 6px;
            border: 1px solid #000;
            font-weight: bold;
            font-size: 9px;
            background-color: #fafafa;
        }
        
        /* Signature Section */
        .signature-section {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;

            display: grid;   
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            width: calc(100% - 40px);
            /* border-top: 1px solid #000; */
            margin-top: 0;
            padding-top: 6px;
        }
        
        .signature-box {
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 15px;
            padding-top: 4px;
            font-size: 9px;
        }
        
        /* Print Styles */
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .vouchers-wrapper {
                width: 100% !important;
                display: block !important;
            }
            
            html, body {
                width: 210mm !important;
                height: 148mm !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                overflow: hidden !important;
            }
            
            body {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
            }
            
            .voucher-container {
                width: 210mm !important;
                height: 148mm !important;
                min-height: 148mm !important;
                max-height: none !important;
                margin: 0 auto !important;
                margin-bottom: 0 !important;
                padding: 5mm !important;
                box-shadow: none !important;
                overflow: visible !important;
                page-break-inside: avoid !important;
                page-break-after: always !important;
                break-after: page !important;
                display: flex !important;
                flex-direction: column !important;
                position: relative !important;
            }
            
            /* Force each voucher to start on a new page (except the first one) */
            .vouchers-wrapper .voucher-container:not(:first-child) {
                page-break-before: always !important;
                break-before: page !important;
                margin-top: 0 !important;
            }
            
            /* Last voucher should not have page break after */
            .vouchers-wrapper .voucher-container:last-child {
                page-break-after: auto !important;
                break-after: auto !important;
            }
            
            /* Ensure vouchers don't break inside */
            .voucher-container * {
                page-break-inside: avoid !important;
            }
            
            .no-print {
                display: none !important;
            }
            
            /* Remove browser headers and footers */
            @page {
                size: A5 landscape !important;
                margin: 0mm !important;
                marks: none !important;
            }
            
            /* Force page breaks between vouchers using adjacent sibling selector */
            .vouchers-wrapper .voucher-container + .voucher-container {
                page-break-before: always !important;
                break-before: page !important;
                margin-top: 0 !important;
            }
            
            /* Ensure wrapper and body allow multiple pages */
            .vouchers-wrapper {
                height: auto !important;
                overflow: visible !important;
                display: block !important;
            }
            
            body {
                height: auto !important;
                overflow: visible !important;
            }
            
            /* Reduce spacing for print to fit on one page */
            .voucher-header {
                margin-bottom: 6px !important;
                padding-bottom: 4px !important;
            }
            
            .voucher-title {
                margin: 6px 0 !important;
                font-size: 18px !important;
            }
            
            .voucher-details {
                margin-bottom: 6px !important;
                gap: 12px !important;
            }
            
            .particulars-section {
                margin-bottom: 4px !important;
            }
            
            .section-title {
                margin-bottom: 4px !important;
                padding-bottom: 2px !important;
            }
            
            table {
                margin-bottom: 4px !important;
                font-size: 9px !important;
            }
            
            table th, table td {
                padding: 4px 6px !important;
            }
            
            .amount-in-words {
                margin-top: 4px !important;
                padding: 5px 8px !important;
                font-size: 10px !important;
            }
            
            /* .signature-section {
                margin-top: 8px !important;
                padding-top: 8px !important;
            } */
            
            .signature-line {
                margin-top: 30px !important;
                padding-top: 4px !important;
            }
        }
        
        /* Print Button */
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .print-button:hover {
            background-color: #0056b3;
        }
        
        .print-button:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">
        <i class="fas fa-print"></i> Print Voucher
    </button>
    
    <?php
    $branchOutput = '';
    
    // Convert branch_id to string for switch comparison (handles both int and string)
    $branchId = (string)($movement['branch_id'] ?? '1');
    
    switch ($branchId) {
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
    
    switch ($branchId) {
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
    
    <?php
    // Check if we need separate vouchers for each supplier
    $paymentCategoryCode = null;
    $advancePaymentType = $movement['advance_payment_type'] ?? null;
    $finalPaymentType = $movement['final_payment_type'] ?? null;
    
    if (isset($movement['payment_category'])) {
        if (is_array($movement['payment_category'])) {
            $paymentCategoryCode = $movement['payment_category']['code'] ?? null;
        } elseif (is_string($movement['payment_category'])) {
            $paymentCategoryCode = $movement['payment_category'];
        }
    }
    
    $isAdvancePayment = ($paymentCategoryCode === 'advance_payment' || $paymentCategoryCode === 'loan');
    $isFinalPayment = ($paymentCategoryCode === 'final_payment');
    $hasSuppliers = isset($movement['suppliers']) && is_array($movement['suppliers']) && count($movement['suppliers']) > 0;
    $supplierCount = $hasSuppliers ? count($movement['suppliers']) : 0;
    
    // Determine if we need separate vouchers for suppliers
    $createSeparateSupplierVouchers = false;
    $suppliersToProcess = [];
    
    if ($hasSuppliers && $supplierCount > 0) {
        if (($isAdvancePayment && $advancePaymentType === 'supplier') || ($isFinalPayment && $finalPaymentType === 'supplier')) {
            $createSeparateSupplierVouchers = true;
            $suppliersToProcess = $movement['suppliers'];
        }
    }
    
    // If creating separate vouchers for suppliers, loop through each supplier
    // Otherwise, create a single voucher (original behavior)
    $vouchersToRender = [];
    if ($createSeparateSupplierVouchers && count($suppliersToProcess) > 0) {
        // Create separate vouchers - one for each supplier
        $vouchersToRender = $suppliersToProcess;
    } else {
        // Single voucher - use null to indicate use original logic (all suppliers together)
        $vouchersToRender = [null];
    }
    ?>
    <div class="vouchers-wrapper">
    <?php
    foreach ($vouchersToRender as $voucherIndex => $singleSupplier) {
        $isSeparateVoucher = ($createSeparateSupplierVouchers && $singleSupplier !== null);
        // Page breaks handled by CSS using :not(:first-child) selector
        ?>
    <div class="voucher-container">
        <!-- Header -->
        <div class="voucher-header">
            <div class="company-logo">
                <img style="height:65px;margin-left:5px" src="<?php echo base_url() ?>assets/img/logo-icon.png" alt="Company Logo" />
            </div>
            <div class="company-info">
                <strong><?= htmlspecialchars($companyOutput) ?></strong>
                <?= htmlspecialchars($branchOutput) ?><br>
                Email: finance@ecw.lk
            </div>
        </div>
        
        <!-- Title -->
        <div class="voucher-title">PETTY CASH VOUCHER</div>
        
        <!-- Voucher Details -->
        <div class="voucher-details" style="position: relative;">
            <div class="detail-group">
                <div class="detail-row">
                    <span class="detail-label">Voucher No:</span>
                    <span class="detail-value"><?= htmlspecialchars($movement['code'] ?? 'N/A') ?></span>
                </div>
            </div>
            <div style="position: absolute; top: 0; right: 0; display: flex; align-items: baseline; gap: 6px;">
                <span class="detail-label">Date:</span>
                <span class="detail-value"><?= isset($movement['created_at']) ? date('Y-m-d', strtotime($movement['created_at'])) : date('Y-m-d') ?></span>
            </div>
        </div>
        
        <!-- Particulars Section -->
        <div class="particulars-section">
            <div class="section-title">PARTICULARS</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 70%;">Particulars</th>
                        <th style="width: 30%;" class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get payment category, advance payment type, and final payment type
                    $paymentCategoryCode = null;
                    $advancePaymentType = $movement['advance_payment_type'] ?? null;
                    $finalPaymentType = $movement['final_payment_type'] ?? null;
                    $advanceEntryType = $movement['advance_entry_type'] ?? null;
                    
                    if (isset($movement['payment_category'])) {
                        if (is_array($movement['payment_category'])) {
                            $paymentCategoryCode = $movement['payment_category']['code'] ?? null;
                        } elseif (is_string($movement['payment_category'])) {
                            $paymentCategoryCode = $movement['payment_category'];
                        }
                    }
                    
                    // Check if this is an advance payment or final payment
                    $isAdvancePayment = ($paymentCategoryCode === 'advance_payment' || $paymentCategoryCode === 'loan');
                    $isFinalPayment = ($paymentCategoryCode === 'final_payment');
                    
                    // Check for different advance types
                    $hasEmployees = isset($movement['employees']) && is_array($movement['employees']) && count($movement['employees']) > 0;
                    $hasSuppliers = isset($movement['suppliers']) && is_array($movement['suppliers']) && count($movement['suppliers']) > 0;
                    $hasSupplierJobs = isset($movement['supplier_jobs']) && is_array($movement['supplier_jobs']) && count($movement['supplier_jobs']) > 0;
                    
                    // Check if we have normalized payees with line items
                    $hasPayees = isset($movement['payees']) && is_array($movement['payees']) && count($movement['payees']) > 0;
                    $hasItems = isset($movement['items']) && is_array($movement['items']) && count($movement['items']) > 0;
                    
                    $totalAmount = 0;
                    
                    // Display based on payment category and advance type
                    if ($isAdvancePayment && $advancePaymentType === 'employee' && $hasEmployees) {
                        // Advance Payment - Employee
                        if ($advanceEntryType === 'automated') {
                            // For automated entry, show only total summary
                            foreach ($movement['employees'] as $employee) {
                                $totalAmount += floatval($employee['amount'] ?? 0);
                            }
                            $scheduleGroupText = $movement['schedule_group_text'] ?? null;
                            ?>
                            <tr>
                                <td>
                                    <strong>Schedule Group:</strong> <?= htmlspecialchars($scheduleGroupText ?? 'Automated Entry') ?><br>
                                    <strong>Description:</strong> <?= htmlspecialchars($movement['remarks'] ?? 'Employee Advance Payment (Automated)') ?><br>
                                    <strong>Total Employees:</strong> <?= count($movement['employees']) ?>
                                </td>
                                <td class="text-right"><?= number_format($totalAmount, 2) ?></td>
                            </tr>
                            <?php
                        } else {
                            // For manual entry, show individual employee details
                            foreach ($movement['employees'] as $employee) {
                                $employeeAmount = floatval($employee['amount'] ?? 0);
                                $totalAmount += $employeeAmount;
                                $employeeNo = $employee['employee_no'] ?? 'N/A';
                                $employeeName = $employee['employee_name'] ?? '';
                                $employeeDisplay = $employeeNo;
                                if ($employeeName) {
                                    $employeeDisplay .= ' - ' . htmlspecialchars($employeeName);
                                }
                                $employeeType = isset($employee['employee_type']) ? ucfirst($employee['employee_type']) : '';
                                ?>
                                <tr>
                                    <td>
                                        <strong>Employee:</strong> <?= htmlspecialchars($employeeDisplay) ?><br>
                                        <?php if ($employeeType): ?>
                                            <strong>Type:</strong> <?= htmlspecialchars($employeeType) ?><br>
                                        <?php endif; ?>
                                        <strong>Description:</strong> <?= htmlspecialchars($employee['remark'] ?? $movement['remarks'] ?? 'Employee Advance Payment') ?>
                                    </td>
                                    <td class="text-right"><?= number_format($employeeAmount, 2) ?></td>
                                </tr>
                                <?php
                            }
                        }
                    } elseif ($isAdvancePayment && $advancePaymentType === 'supplier' && $hasSuppliers) {
                        // Advance Payment - Supplier
                        // If creating separate vouchers, show only the current supplier
                        if ($isSeparateVoucher && $singleSupplier !== null) {
                            $supplierAmount = floatval($singleSupplier['amount'] ?? 0);
                            $totalAmount = $supplierAmount;
                            $supplierName = $singleSupplier['supplier_name'] ?? null;
                            ?>
                            <tr>
                                <td>
                                    <?php if ($supplierName): ?>
                                        <strong>Supplier Name:</strong> <?= htmlspecialchars($supplierName) ?><br>
                                    <?php endif; ?>
                                    <strong>Description:</strong> <?= htmlspecialchars($singleSupplier['remark'] ?? $movement['remarks'] ?? 'Supplier Advance Payment') ?>
                                </td>
                                <td class="text-right"><?= number_format($supplierAmount, 2) ?></td>
                            </tr>
                            <?php
                        } else {
                            // Original logic for single voucher with all suppliers
                            foreach ($movement['suppliers'] as $supplier) {
                                $supplierAmount = floatval($supplier['amount'] ?? 0);
                                $totalAmount += $supplierAmount;
                                $supplierName = $supplier['supplier_name'] ?? null;
                                ?>
                                <tr>
                                    <td>
                                        <?php if ($supplierName): ?>
                                            <strong>Supplier Name:</strong> <?= htmlspecialchars($supplierName) ?><br>
                                        <?php endif; ?>
                                        <strong>Description:</strong> <?= htmlspecialchars($supplier['remark'] ?? $movement['remarks'] ?? 'Supplier Advance Payment') ?>
                                    </td>
                                    <td class="text-right"><?= number_format($supplierAmount, 2) ?></td>
                                </tr>
                                <?php
                            }
                        }
                    } elseif ((($isAdvancePayment && $advancePaymentType === 'outsource_supplier') || ($isFinalPayment && $finalPaymentType === 'outsource_supplier')) && $hasSupplierJobs) {
                        // Advance Payment or Final Payment - Outsource Supplier
                        foreach ($movement['supplier_jobs'] as $supplierJob) {
                            $advanceAmount = floatval($supplierJob['advance_amount'] ?? 0);
                            $totalAmount += $advanceAmount;
                            $supplierJobData = isset($supplierJob['supplier_job']) && is_array($supplierJob['supplier_job']) 
                                ? $supplierJob['supplier_job'] 
                                : [];
                            $jobCode = $supplierJobData['code'] ?? 'N/A';
                            $jobName = $supplierJobData['job_name'] ?? 'N/A';
                            $supplierName = $supplierJobData['supplier_name'] ?? null;
                            $paymentTypeLabel = $isFinalPayment ? 'Final Payment' : 'Advance Payment';
                            ?>
                            <tr>
                                <td>
                                    <strong>Job Code:</strong> <?= htmlspecialchars($jobCode) ?><br>
                                    <strong>Job Name:</strong> <?= htmlspecialchars($jobName) ?><br>
                                    <?php if ($supplierName): ?>
                                        <strong>Supplier Name:</strong> <?= htmlspecialchars($supplierName) ?><br>
                                    <?php endif; ?>
                                    <strong>Description:</strong> <?= htmlspecialchars($supplierJob['remarks'] ?? $movement['remarks'] ?? "Outsource Supplier {$paymentTypeLabel}") ?>
                                </td>
                                <td class="text-right"><?= number_format($advanceAmount, 2) ?></td>
                            </tr>
                            <?php
                        }
                    } elseif ($isFinalPayment && $finalPaymentType === 'supplier' && $hasSuppliers) {
                        // Final Payment - Supplier
                        // If creating separate vouchers, show only the current supplier
                        if ($isSeparateVoucher && $singleSupplier !== null) {
                            $supplierAmount = floatval($singleSupplier['amount'] ?? 0);
                            $totalAmount = $supplierAmount;
                            $supplierName = $singleSupplier['supplier_name'] ?? null;
                            ?>
                            <tr>
                                <td>
                                    <?php if ($supplierName): ?>
                                        <strong>Supplier Name:</strong> <?= htmlspecialchars($supplierName) ?><br>
                                    <?php endif; ?>
                                    <strong>Description:</strong> <?= htmlspecialchars($singleSupplier['remark'] ?? $movement['remarks'] ?? 'Supplier Final Payment') ?>
                                </td>
                                <td class="text-right"><?= number_format($supplierAmount, 2) ?></td>
                            </tr>
                            <?php
                        } else {
                            // Original logic for single voucher with all suppliers
                            foreach ($movement['suppliers'] as $supplier) {
                                $supplierAmount = floatval($supplier['amount'] ?? 0);
                                $totalAmount += $supplierAmount;
                                $supplierName = $supplier['supplier_name'] ?? null;
                                ?>
                                <tr>
                                    <td>
                                        <?php if ($supplierName): ?>
                                            <strong>Supplier Name:</strong> <?= htmlspecialchars($supplierName) ?><br>
                                        <?php endif; ?>
                                        <strong>Description:</strong> <?= htmlspecialchars($supplier['remark'] ?? $movement['remarks'] ?? 'Supplier Final Payment') ?>
                                    </td>
                                    <td class="text-right"><?= number_format($supplierAmount, 2) ?></td>
                                </tr>
                                <?php
                            }
                        }
                    } elseif ($hasPayees || $hasItems) {
                        // Display normalized payees and items
                        if ($hasPayees) {
                            // Group by payee - show one row per payee with total amount
                            foreach ($movement['payees'] as $payee) {
                                $payeeName = $payee['payee_name'] ?? 'N/A';
                                $payeeItems = isset($payee['items']) && is_array($payee['items']) ? $payee['items'] : [];
                                
                                // Calculate total amount for this payee
                                $payeeTotalAmount = 0;
                                if (count($payeeItems) > 0) {
                                    foreach ($payeeItems as $item) {
                                        $payeeTotalAmount += floatval($item['amount'] ?? 0);
                                    }
                                } else {
                                    // Payee without items - use main amount
                                    $payeeTotalAmount = floatval($movement['amount'] ?? 0);
                                }
                                
                                $totalAmount += $payeeTotalAmount;
                                
                                // Show one row per payee with main movement remark
                                ?>
                                <tr>
                                    <td>
                                        <strong>Payee:</strong> <?= htmlspecialchars($payeeName) ?><br>
                                        <strong>Description:</strong> <?= htmlspecialchars($movement['remarks'] ?? 'Petty Cash Payment') ?>
                                    </td>
                                    <td class="text-right"><?= number_format($payeeTotalAmount, 2) ?></td>
                                </tr>
                                <?php
                            }
                        } elseif ($hasItems) {
                            // Direct items without payees
                            foreach ($movement['items'] as $item) {
                                $itemAmount = floatval($item['amount'] ?? 0);
                                $totalAmount += $itemAmount;
                                $accountName = isset($item['account_master']) && is_array($item['account_master']) 
                                    ? $item['account_master']['account_name'] 
                                    : ($item['account_master']['account_name'] ?? 'N/A');
                                ?>
                                <tr>
                                    <td>
                                        <strong>Account:</strong> <?= htmlspecialchars($accountName) ?><br>
                                        <strong>Description:</strong> <?= htmlspecialchars($item['memo'] ?? $movement['remarks'] ?? 'Petty Cash Payment') ?>
                                    </td>
                                    <td class="text-right"><?= number_format($itemAmount, 2) ?></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    
                    // Show total for advance/final payments if multiple records (but not for separate supplier vouchers or automated entries)
                    if ($totalAmount > 0 && !$createSeparateSupplierVouchers && !($isAdvancePayment && $advancePaymentType === 'employee' && $advanceEntryType === 'automated') && (
                        ($isAdvancePayment && $advancePaymentType === 'employee' && $hasEmployees && count($movement['employees']) > 1) ||
                        ($isAdvancePayment && $advancePaymentType === 'supplier' && $hasSuppliers && count($movement['suppliers']) > 1) ||
                        ($isAdvancePayment && $advancePaymentType === 'outsource_supplier' && $hasSupplierJobs && count($movement['supplier_jobs']) > 1) ||
                        ($isFinalPayment && $finalPaymentType === 'supplier' && $hasSuppliers && count($movement['suppliers']) > 1) ||
                        ($isFinalPayment && $finalPaymentType === 'outsource_supplier' && $hasSupplierJobs && count($movement['supplier_jobs']) > 1)
                    )) {
                        ?>
                        <tr>
                            <td class="text-right"><strong>Total:</strong></td>
                            <td class="text-right"><strong><?= number_format($totalAmount, 2) ?></strong></td>
                        </tr>
                        <?php
                    }
                    
                    // Fallback to legacy format (single payee/amount) if no other data
                    if ($totalAmount == 0 && !$hasPayees && !$hasItems && !$hasEmployees && !$hasSuppliers && !$hasSupplierJobs) {
                        // Fallback to legacy format (single payee/amount)
                        ?>
                        <tr>
                            <td>
                                <strong>Payee:</strong> <?= htmlspecialchars($movement['payee_name'] ?? 'N/A') ?><br>
                                <strong>Description:</strong> <?= htmlspecialchars($movement['remarks'] ?? ($movement['description'] ?? 'Petty Cash Payment')) ?>
                            </td>
                            <td class="text-right"><?= number_format($movement['amount'] ?? 0, 2) ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <!-- Narration Section -->
        <div class="particulars-section narration-section">
            <div class="section-title">NARRATION</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 40%;">Narration</th>
                        <th style="width: 40%;">Account</th>
                        <th style="width: 20%;" class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody style="page-break-inside: avoid; break-inside: avoid;">
                    <?php
                    // Display narration based on payment category and advance type
                    $narrationTotalAmount = 0;
                    $narrationRowCount = 0; // Track number of narration rows
                    
                    if ($isAdvancePayment && $advancePaymentType === 'employee' && $hasEmployees) {
                        // Advance Payment - Employee narration
                        if ($advanceEntryType === 'automated') {
                            // For automated entry, show only total summary
                            foreach ($movement['employees'] as $employee) {
                                $narrationTotalAmount += floatval($employee['amount'] ?? 0);
                            }
                            $scheduleGroupText = $movement['schedule_group_text'] ?? null;
                            
                            // Get account master name if available
                            $accountDisplay = 'Employee Advance - ' . htmlspecialchars($scheduleGroupText ?? 'Schedule Group') . ' (' . count($movement['employees']) . ' employees)';
                            if (isset($movement['account_master']) && is_array($movement['account_master'])) {
                                $accountCode = $movement['account_master']['account_code'] ?? '';
                                $accountName = $movement['account_master']['account_name'] ?? '';
                                if ($accountCode && $accountName) {
                                    $accountDisplay = htmlspecialchars($accountCode . ' - ' . $accountName);
                                } elseif ($accountName) {
                                    $accountDisplay = htmlspecialchars($accountName);
                                }
                            }
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($movement['remarks'] ?? 'Employee Advance Payment (Automated)') ?></td>
                                <td><?= $accountDisplay ?></td>
                                <td class="text-right"><?= number_format($narrationTotalAmount, 2) ?></td>
                            </tr>
                            <?php
                            $narrationRowCount++;
                        } else {
                            // For manual entry, show individual employee details
                            foreach ($movement['employees'] as $employee) {
                                $employeeAmount = floatval($employee['amount'] ?? 0);
                                $narrationTotalAmount += $employeeAmount;
                                $employeeNo = $employee['employee_no'] ?? 'N/A';
                                $employeeName = $employee['employee_name'] ?? '';
                                
                                // Get account master name if available
                                $accountDisplay = 'Employee Advance - ' . htmlspecialchars($employeeNo);
                                if ($employeeName) {
                                    $accountDisplay .= ' (' . htmlspecialchars($employeeName) . ')';
                                }
                                if (isset($movement['account_master']) && is_array($movement['account_master'])) {
                                    $accountCode = $movement['account_master']['account_code'] ?? '';
                                    $accountName = $movement['account_master']['account_name'] ?? '';
                                    if ($accountCode && $accountName) {
                                        $accountDisplay = htmlspecialchars($accountCode . ' - ' . $accountName);
                                    } elseif ($accountName) {
                                        $accountDisplay = htmlspecialchars($accountName);
                                    }
                                }
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($employee['remark'] ?? $movement['remarks'] ?? 'Employee Advance Payment') ?></td>
                                    <td><?= $accountDisplay ?></td>
                                    <td class="text-right"><?= number_format($employeeAmount, 2) ?></td>
                                </tr>
                                <?php
                            }
                        }
                    } elseif ($isAdvancePayment && $advancePaymentType === 'supplier' && $hasSuppliers) {
                        // Advance Payment - Supplier narration
                        // If creating separate vouchers, show only the current supplier
                        if ($isSeparateVoucher && $singleSupplier !== null) {
                            $supplierAmount = floatval($singleSupplier['amount'] ?? 0);
                            $narrationTotalAmount = $supplierAmount;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($movement['remarks'] ?? 'Supplier Advance Payment') ?></td>
                                <td>
                                    <?php
                                    $supplierName = $singleSupplier['supplier_name'] ?? null;
                                    $supplierLabel = 'Supplier Advance - ID: ' . htmlspecialchars($singleSupplier['supplier_id'] ?? 'N/A');
                                    if ($supplierName) {
                                        $supplierLabel .= ' (' . htmlspecialchars($supplierName) . ')';
                                    }
                                    echo $supplierLabel;
                                    ?>
                                </td>
                                <td class="text-right"><?= number_format($supplierAmount, 2) ?></td>
                            </tr>
                            <?php
                            $narrationRowCount++;
                        } else {
                            // Original logic for single voucher with all suppliers
                            foreach ($movement['suppliers'] as $supplier) {
                                $supplierAmount = floatval($supplier['amount'] ?? 0);
                                $narrationTotalAmount += $supplierAmount;
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($movement['remarks'] ?? 'Supplier Advance Payment') ?></td>
                                    <td>
                                        <?php
                                        $supplierName = $supplier['supplier_name'] ?? null;
                                        $supplierLabel = 'Supplier Advance - ID: ' . htmlspecialchars($supplier['supplier_id'] ?? 'N/A');
                                        if ($supplierName) {
                                            $supplierLabel .= ' (' . htmlspecialchars($supplierName) . ')';
                                        }
                                        echo $supplierLabel;
                                        ?>
                                    </td>
                                    <td class="text-right"><?= number_format($supplierAmount, 2) ?></td>
                                </tr>
                                <?php
                                $narrationRowCount++;
                            }
                        }
                    } elseif ((($isAdvancePayment && $advancePaymentType === 'outsource_supplier') || ($isFinalPayment && $finalPaymentType === 'outsource_supplier')) && $hasSupplierJobs) {
                        // Advance Payment or Final Payment - Outsource Supplier narration
                        foreach ($movement['supplier_jobs'] as $supplierJob) {
                            $advanceAmount = floatval($supplierJob['advance_amount'] ?? 0);
                            $narrationTotalAmount += $advanceAmount;
                            $supplierJobData = isset($supplierJob['supplier_job']) && is_array($supplierJob['supplier_job']) 
                                ? $supplierJob['supplier_job'] 
                                : [];
                            
                            // Get account master information from supplier job
                            $accountMaster = isset($supplierJobData['account_master']) && is_array($supplierJobData['account_master']) 
                                ? $supplierJobData['account_master'] 
                                : null;
                            
                            // Display account master if available, otherwise show job info as fallback
                            if ($accountMaster && isset($accountMaster['account_code']) && isset($accountMaster['account_name'])) {
                                $accountLabel = htmlspecialchars($accountMaster['account_code']) . ' - ' . htmlspecialchars($accountMaster['account_name']);
                            } else {
                                // Fallback to job information
                                $jobCode = $supplierJobData['code'] ?? 'N/A';
                                $supplierName = $supplierJobData['supplier_name'] ?? null;
                                $accountLabel = 'Outsource Supplier Job - ' . htmlspecialchars($jobCode);
                                if ($supplierName) {
                                    $accountLabel .= ' (' . htmlspecialchars($supplierName) . ')';
                                }
                            }
                            $paymentTypeLabel = $isFinalPayment ? 'Final Payment' : 'Advance Payment';
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($supplierJob['remarks'] ?? $movement['remarks'] ?? "Outsource Supplier {$paymentTypeLabel}") ?></td>
                                <td><?= $accountLabel ?></td>
                                <td class="text-right"><?= number_format($advanceAmount, 2) ?></td>
                            </tr>
                            <?php
                            $narrationRowCount++;
                        }
                    } elseif ($isFinalPayment && $finalPaymentType === 'supplier' && $hasSuppliers) {
                        // Final Payment - Supplier narration
                        // If creating separate vouchers, show only the current supplier
                        if ($isSeparateVoucher && $singleSupplier !== null) {
                            $supplierAmount = floatval($singleSupplier['amount'] ?? 0);
                            $narrationTotalAmount = $supplierAmount;
                            $supplierName = $singleSupplier['supplier_name'] ?? null;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($movement['remarks'] ?? 'Supplier Final Payment') ?></td>
                                <td>
                                    <?php
                                    $supplierLabel = 'Supplier Final Payment - ID: ' . htmlspecialchars($singleSupplier['supplier_id'] ?? 'N/A');
                                    if ($supplierName) {
                                        $supplierLabel .= ' (' . htmlspecialchars($supplierName) . ')';
                                    }
                                    echo $supplierLabel;
                                    ?>
                                </td>
                                <td class="text-right"><?= number_format($supplierAmount, 2) ?></td>
                            </tr>
                            <?php
                            $narrationRowCount++;
                        } else {
                            // Original logic for single voucher with all suppliers
                            foreach ($movement['suppliers'] as $supplier) {
                                $supplierAmount = floatval($supplier['amount'] ?? 0);
                                $narrationTotalAmount += $supplierAmount;
                                $supplierName = $supplier['supplier_name'] ?? null;
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($movement['remarks'] ?? 'Supplier Final Payment') ?></td>
                                    <td>
                                        <?php
                                        $supplierLabel = 'Supplier Final Payment - ID: ' . htmlspecialchars($supplier['supplier_id'] ?? 'N/A');
                                        if ($supplierName) {
                                            $supplierLabel .= ' (' . htmlspecialchars($supplierName) . ')';
                                        }
                                        echo $supplierLabel;
                                        ?>
                                    </td>
                                    <td class="text-right"><?= number_format($supplierAmount, 2) ?></td>
                                </tr>
                                <?php
                                $narrationRowCount++;
                            }
                        }
                    } elseif ($hasPayees || $hasItems) {
                        // Display normalized payees and items for narration
                        if ($hasPayees) {
                            // Display items from payees
                            foreach ($movement['payees'] as $payee) {
                                $payeeItems = isset($payee['items']) && is_array($payee['items']) ? $payee['items'] : [];
                                
                                foreach ($payeeItems as $item) {
                                    $itemAmount = floatval($item['amount'] ?? 0);
                                    $narrationTotalAmount += $itemAmount;
                                    $accountName = isset($item['account_master']) && is_array($item['account_master']) 
                                        ? $item['account_master']['account_name'] 
                                        : ($item['account_master']['account_name'] ?? 'N/A');
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['memo'] ?? $movement['remarks'] ?? 'Petty Cash Payment') ?></td>
                                        <td><?= htmlspecialchars($accountName) ?></td>
                                        <td class="text-right"><?= number_format($itemAmount, 2) ?></td>
                                    </tr>
                                    <?php
                                    $narrationRowCount++;
                                }
                            }
                        } elseif ($hasItems) {
                            // Check if we have normalized items (direct items without payees)
                            foreach ($movement['items'] as $item) {
                                $itemAmount = floatval($item['amount'] ?? 0);
                                $narrationTotalAmount += $itemAmount;
                                $accountName = isset($item['account_master']) && is_array($item['account_master']) 
                                    ? $item['account_master']['account_name'] 
                                    : ($item['account_master']['account_name'] ?? 'N/A');
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['memo'] ?? $movement['remarks'] ?? 'Petty Cash Payment') ?></td>
                                    <td><?= htmlspecialchars($accountName) ?></td>
                                    <td class="text-right"><?= number_format($itemAmount, 2) ?></td>
                                </tr>
                                <?php
                                $narrationRowCount++;
                            }
                        }
                        
                        // Show total if multiple items
                        if ($narrationTotalAmount > 0 && (($hasPayees && count($movement['payees']) > 0) || ($hasItems && count($movement['items']) > 1))) {
                            ?>
                            <tr>
                                <td colspan="2" class="text-right"><strong>Total:</strong></td>
                                <td class="text-right"><strong><?= number_format($narrationTotalAmount, 2) ?></strong></td>
                            </tr>
                            <?php
                            $narrationRowCount++;
                        }
                    }
                    
                    // Show total for advance/final payments narration (but not for separate supplier vouchers or automated entries)
                    if ($narrationTotalAmount > 0 && !$createSeparateSupplierVouchers && !($isAdvancePayment && $advancePaymentType === 'employee' && $advanceEntryType === 'automated') && (
                        ($isAdvancePayment && $advancePaymentType === 'employee' && $hasEmployees && count($movement['employees']) > 1) ||
                        ($isAdvancePayment && $advancePaymentType === 'supplier' && $hasSuppliers && count($movement['suppliers']) > 1) ||
                        ($isAdvancePayment && $advancePaymentType === 'outsource_supplier' && $hasSupplierJobs && count($movement['supplier_jobs']) > 1) ||
                        ($isFinalPayment && $finalPaymentType === 'supplier' && $hasSuppliers && count($movement['suppliers']) > 1) ||
                        ($isFinalPayment && $finalPaymentType === 'outsource_supplier' && $hasSupplierJobs && count($movement['supplier_jobs']) > 1)
                    )) {
                        ?>
                        <tr>
                            <td colspan="2" class="text-right"><strong>Total:</strong></td>
                            <td class="text-right"><strong><?= number_format($narrationTotalAmount, 2) ?></strong></td>
                        </tr>
                        <?php
                        $narrationRowCount++;
                    }
                    
                    // Fallback to legacy format if no other data
                    if ($narrationTotalAmount == 0 && !$hasItems && !$hasEmployees && !$hasSuppliers && !$hasSupplierJobs) {
                        // Fallback to legacy format
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($movement['remarks'] ?? ($movement['description'] ?? 'Petty Cash Payment')) ?></td>
                            <td>
                                <?php
                                if (isset($movement['account_master']) && !empty($movement['account_master'])) {
                                    $accountMaster = is_array($movement['account_master']) ? $movement['account_master'] : (array)$movement['account_master'];
                                    echo htmlspecialchars($accountMaster['account_name'] ?? ($movement['remarks'] ?? 'Donation'));
                                } else {
                                    echo htmlspecialchars($movement['remarks'] ?? ($movement['payee_name'] ?? 'Donation'));
                                }
                                ?>
                            </td>
                            <td class="text-right"><?= number_format($movement['amount'] ?? 0, 2) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right"><strong>Total:</strong></td>
                            <td class="text-right"><strong><?= number_format($movement['amount'] ?? 0, 2) ?></strong></td>
                        </tr>
                        <?php
                        $narrationRowCount += 2; // Count both the data row and total row
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <!-- Amount in Words -->
        <div class="amount-in-words">
            <?php
                // Calculate total amount from normalized data based on payment category
                $amount = 0;
                
                // Check payment category, advance type, and final payment type
                $paymentCategoryCode = null;
                $advancePaymentType = $movement['advance_payment_type'] ?? null;
                $finalPaymentType = $movement['final_payment_type'] ?? null;
                
                if (isset($movement['payment_category'])) {
                    if (is_array($movement['payment_category'])) {
                        $paymentCategoryCode = $movement['payment_category']['code'] ?? null;
                    } elseif (is_string($movement['payment_category'])) {
                        $paymentCategoryCode = $movement['payment_category'];
                    }
                }
                
                $isAdvancePayment = ($paymentCategoryCode === 'advance_payment' || $paymentCategoryCode === 'loan');
                $isFinalPayment = ($paymentCategoryCode === 'final_payment');
                
                // Calculate from advance/final payment details
                if ($isAdvancePayment && $advancePaymentType === 'employee' && isset($movement['employees']) && is_array($movement['employees'])) {
                    foreach ($movement['employees'] as $employee) {
                        $amount += floatval($employee['amount'] ?? 0);
                    }
                } elseif ($isAdvancePayment && $advancePaymentType === 'supplier' && isset($movement['suppliers']) && is_array($movement['suppliers'])) {
                    // If creating separate vouchers, use only current supplier amount
                    if (isset($isSeparateVoucher) && $isSeparateVoucher && isset($singleSupplier) && $singleSupplier !== null) {
                        $amount = floatval($singleSupplier['amount'] ?? 0);
                    } else {
                        foreach ($movement['suppliers'] as $supplier) {
                            $amount += floatval($supplier['amount'] ?? 0);
                        }
                    }
                } elseif ($isAdvancePayment && $advancePaymentType === 'outsource_supplier' && isset($movement['supplier_jobs']) && is_array($movement['supplier_jobs'])) {
                    foreach ($movement['supplier_jobs'] as $supplierJob) {
                        $amount += floatval($supplierJob['advance_amount'] ?? 0);
                    }
                } elseif ($isFinalPayment && $finalPaymentType === 'supplier' && isset($movement['suppliers']) && is_array($movement['suppliers'])) {
                    // If creating separate vouchers, use only current supplier amount
                    if (isset($isSeparateVoucher) && $isSeparateVoucher && isset($singleSupplier) && $singleSupplier !== null) {
                        $amount = floatval($singleSupplier['amount'] ?? 0);
                    } else {
                        foreach ($movement['suppliers'] as $supplier) {
                            $amount += floatval($supplier['amount'] ?? 0);
                        }
                    }
                } elseif ($isFinalPayment && $finalPaymentType === 'outsource_supplier' && isset($movement['supplier_jobs']) && is_array($movement['supplier_jobs'])) {
                    foreach ($movement['supplier_jobs'] as $supplierJob) {
                        $amount += floatval($supplierJob['advance_amount'] ?? 0);
                    }
                } elseif (isset($movement['items']) && is_array($movement['items']) && count($movement['items']) > 0) {
                    // Normal payment with line items
                    foreach ($movement['items'] as $item) {
                        $amount += floatval($item['amount'] ?? 0);
                    }
                } elseif (isset($movement['payees']) && is_array($movement['payees']) && count($movement['payees']) > 0) {
                    // Normal payment with payees
                    foreach ($movement['payees'] as $payee) {
                        if (isset($payee['items']) && is_array($payee['items'])) {
                            foreach ($payee['items'] as $item) {
                                $amount += floatval($item['amount'] ?? 0);
                            }
                        }
                    }
                    // If no items in payees, use main amount
                    if ($amount == 0) {
                        $amount = floatval($movement['amount'] ?? 0);
                    }
                } else {
                    // Fallback to main amount
                    $amount = floatval($movement['amount'] ?? 0);
                }
                echo convertNumberToWords($amount);
            ?> Rupees Only
        </div>
        
        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">Prepared By</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Checked By</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Received By</div>
            </div>
        </div>
    </div>
    <?php
    } // End foreach vouchersToRender
    ?>
    </div>
    <!-- End vouchers-wrapper -->
    
    <script>
        // Optional: Auto-print when page loads (uncomment if needed)
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 500);
        // }
    </script>
</body>
</html>
