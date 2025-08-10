<!DOCTYPE html>
<html>
<head>
    <title>ECW Software - Job Card</title>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 6mm 10mm 6mm 10mm;
            size: A4 portrait;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Arial", sans-serif;
            font-size: 10px;
            line-height: 1.2;
            color: #000;
        }

        .page-container {
            width: 100%;
        }

        /* Header Section */
        .document-header {
            text-align: center;
            margin-bottom: 8px;
            padding: 6px 0;
            border-bottom: 2px solid #000;
            page-break-after: avoid;
        }

        .document-header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .document-header .company-info {
            font-size: 10px;
            margin-top: 2px;
            color: #666;
        }

        /* Main Information Section */
        .main-info-section {
            margin-bottom: 8px;
            page-break-after: avoid;
        }

        .section-header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0;
            page-break-after: avoid;
        }

        .main-info-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            font-size: 10px;
            margin-bottom: 6px;
        }

        .main-info-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: left;
            padding: 3px 5px;
            border: 1px solid #000;
            width: 18%;
            vertical-align: middle;
        }

        .main-info-table td {
            padding: 3px 5px;
            border: 1px solid #000;
            text-align: left;
            vertical-align: middle;
        }

        /* Job Details Section */
        .job-details-section {
            margin-top: 8px;
            page-break-inside: avoid;
        }

        .job-header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
            border: 1px solid #000;
            page-break-after: avoid;
        }

        .job-header-table th {
            background-color: #444;
            color: white;
            text-align: center;
            padding: 4px 3px;
            font-size: 10px;
            font-weight: bold;
            border: 1px solid #000;
            text-transform: uppercase;
        }

        /* Job Category Containers */
        .job-category-container {
            margin-bottom: 10px;
            page-break-inside: avoid;
            border: 1px solid #000;
            background-color: #fafafa;
        }

        .job-category-header {
            background-color: #e0e0e0;
            border-bottom: 1px solid #000;
            padding: 4px 6px;
            font-weight: bold;
            font-size: 10px;
            page-break-after: avoid;
        }

        .job-items-container {
            padding: 4px;
        }

        /* Individual Job Items */
        .job-item {
            border: 1px solid #ccc;
            margin-bottom: 6px;
            background-color: white;
            page-break-inside: avoid;
        }

        .job-item-content {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        .job-item-content td {
            padding: 4px;
            border: 1px solid #666;
            vertical-align: top;
            font-size: 10px;
        }

        .job-item-content td:last-child {
            border-right: none;
        }

        .job-number {
            width: 5%;
            text-align: center;
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .job-description {
            width: 30%;
            font-weight: 500;
        }

        .job-remarks {
            width: 30%;
            font-weight: 500;
        }

        .job-quantity {
            width: 5%;
            text-align: center;
            font-weight: bold;
        }

        /* Image Handling */
        .image-container {
            margin-top: 3px;
            text-align: center;
            max-height: 80px;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .image-container img {
            max-width: 100%;
            max-height: 80px;
            object-fit: contain;
            border: 1px solid #ddd;
        }

        /* Signature Section */
        .signature-section {
            margin-top: -4px;
            padding-top: 3px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        .signature-table th {
            background-color: #e8e8e8;
            border: 1px solid #666;
            padding: 1px;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
            height: 14px;
        }

        .signature-table td {
            border: 1px solid #666;
            padding: 1px;
            text-align: center;
            height: 14px;
            font-size: 10px;
        }

        /* Page Break Controls */
        .page-break-before {
            page-break-before: always;
        }

        .page-break-after {
            page-break-after: always;
        }

        .no-page-break {
            page-break-inside: avoid;
        }

        .keep-together {
            page-break-inside: avoid;
            orphans: 3;
            widows: 3;
        }

        /* Category Separators */
        .category-separator {
            border-bottom: 2px dashed #000;
            margin: 8px 0;
            height: 1px;
            page-break-after: avoid;
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .text-uppercase { text-transform: uppercase; }

        /* Enhanced Page Break Controls */
        .header-and-customer-info {
            page-break-inside: avoid;
            page-break-after: avoid;
        }

        .job-details-with-header {
            page-break-before: avoid;
        }

        .keep-together {
            page-break-inside: avoid;
            orphans: 2;
            widows: 2;
        }

        /* Print Optimizations */
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            
            .header-and-customer-info {
                break-inside: avoid;
                break-after: avoid;
            }
            
            .job-details-with-header {
                break-before: avoid;
            }
            
            .job-category-container {
                break-inside: avoid;
            }
            
            .job-item {
                break-inside: avoid;
            }
            
            .image-container {
                break-inside: avoid;
            }
            
            .signature-section {
                break-inside: avoid;
            }
        }

        /* Footer Space */
        .document-footer {
            margin-top: 15px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
            text-align: center;
            font-size: 8px;
            color: #666;
            page-break-before: avoid;
        }
    </style>
</head>

<body>
    <div class="page-container">
        
        <!-- Header and Customer Information - Keep Together -->
        <div class="header-and-customer-info">
            <!-- Document Header -->
            <div class="document-header">
                <h1>Job Card Quotation</h1>
                <div class="company-info">ECW Software Solutions</div>
                <table style="width: 100%; margin-top: 5px;">
                    <tr>
                        <td style="font-size:14px; font-weight:bold; text-align:left; padding:0px; width:50%;">Job Card No: <?= $main_data['job_card_number'] ?? 'N/A' ?></td>
                        <td style="font-size:14px; font-weight:bold; text-align:right; padding:0px; width:50%;">Handover Date: <?= date('d/m/Y', strtotime($main_data['handover_date'])) ?></td>
                    </tr>
                </table>
            </div>
            
            <!-- Main Information Section -->
            <div class="main-info-section">
                <div class="section-header">Customer & Job Information</div>
                <table class="main-info-table">
                    <tr>
                        <th>Customer:</th>
                        <td><?= $main_data['customer_name'] ?? 'N/A' ?></td>
                        <th>Contact No:</th>
                        <td>
                            <?= $main_data['customer_mobile_num'] ?? 'N/A' ?>
                            <?= (!empty($main_data['customer_mobile_num_2']) && $main_data['customer_mobile_num_2'] != "+94" ? ' / ' . $main_data['customer_mobile_num_2'] : '') ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td colspan="3">
                            <?= ($main_data['address'] ?? '') . 
                               (!empty($main_data['address_2']) ? ', ' . $main_data['address_2'] : '') . 
                               (!empty($main_data['city']) ? ', ' . $main_data['city'] : '') . 
                               (!empty($main_data['district']) ? ', ' . $main_data['district'] : '') ?>
                        </td>
                    </tr>
                    <tr>
                        <th>NIC:</th>
                        <td><?= $main_data['nic_number'] ?? 'N/A' ?></td>
                        <th>Customer PO:</th>
                        <td><?= $main_data['customer_po'] ?? 'None' ?></td>
                    </tr>
                    <tr>
                        <th>Vehicle No:</th>
                        <td><?= $main_data['vehicle_number'] ?? 'N/A' ?></td>
                        <th>Vehicle Type:</th>
                        <td>
                            <?= ($main_data['brand_name'] ?? '') . 
                               (!empty($main_data['model_name']) ? ', ' . $main_data['model_name'] : '') ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Sales Person:</th>
                        <td><?= $main_data['sales_person_name'] ?? 'N/A' ?></td>
                        <th>Sales Code:</th>
                        <td><?= $main_data['sales_person_code'] ?? 'N/A' ?></td>
                    </tr>
                    <tr>
                        <th>Job Card No:</th>
                        <td><?= $main_data['job_card_number'] ?? 'N/A' ?></td>
                        <th>Quotation No:</th>
                        <td><?= $main_data['quotation_no'] ?? 'None' ?></td>
                    </tr>
                    <tr>
                        <th>Created Date:</th>
                        <td><?= date('d/m/Y', strtotime($main_data['jobcard_date'])) ?></td>
                        <th>Created At:</th>
                        <td><?= date('h:i A', strtotime($main_data['jobcard_date'])) ?></td>
                    </tr>
                    <tr>
                        <th>Job Start:</th>
                        <td><?= date('d/m/Y', strtotime($main_data['jobcard_date'])) ?></td>
                        <th>Job Complete:</th>
                        <td>
                            <?= !empty($main_data['complete_date']) ? date('d/m/Y', strtotime($main_data['complete_date'])) : 'Pending' ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Handover Date:</th>
                        <td><?= date('d/m/Y', strtotime($main_data['handover_date'])) ?></td>
                        <th>Print Date:</th>
                        <td><?= date('d/m/Y') ?></td>
                    </tr>
                    <tr>
                        <th>Payment Method:</th>
                        <td colspan="3"><?= $main_data['payment_type'] ?? 'N/A' ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="job-details-section job-details-with-header">
            <div class="section-header">Job Details & Work Instructions</div>

            <table class="job-header-table">
                <tr>
                    <th style="width:5%;">No</th>
                    <th style="width:30%;">Job Description</th>
                    <th style="width:30%;">Details</th>
                    <th style="width:30%;">Remarks</th>
                    <th style="width:5%;">Qty</th>
                </tr>
            </table>

            <?php 
            $mainJob_cnt = 1;
            $totalCategories = count($details_data);
            
            foreach ($details_data as $categoryIndex => $item): ?>
                
                <div class="job-category-container keep-together">
                    <div class="job-category-header">
                        <strong><?= $mainJob_cnt ?>. <?= $item['job_sub_category_text'] ?? 'N/A' ?></strong>
                    </div>
                    
                    <div class="job-items-container">
                        <?php
                        $joblist_cnt = 1;
                        $totalJobsInCategory = count($item['details']);
                        
                        foreach ($item['details'] as $jobIndex => $joblist): ?>
                            
                            <div class="job-item keep-together">
                                <table class="job-item-content">
                                    <tr>
                                        <td class="job-number"><?= $joblist_cnt ?></td>
                                        <td class="job-description">
                                            <strong><?= $joblist['option_group_text'] ?? 'N/A' ?></strong>
                                        </td>
                                        <td class="job-remarks">
                                            <?= $joblist['option_text'] ?? 'N/A' ?> <br>
                                            <?= $joblist['combined_option'] ?? 'N/A' ?> <?= ($joblist['description'] != 'image') ? ($joblist['child_value_name'] ?? ''):'' ?>
                                            
                                            <?php if($joblist['description'] == 'image'): ?>
                                                <div class="image-container">
                                                    <img src="<?= htmlspecialchars($joblist['child_value_name'] ?? '') ?>" alt="Job Reference Image" />
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="job-remarks">
                                            <?= $joblist['remark'] ?? 'N/A' ?>
                                        </td>
                                        <td class="job-quantity">x <?= $joblist['qty'] ?? 0 ?></td>
                                    </tr>
                                </table>
                                
                                <div class="signature-section">
                                    <table class="signature-table">
                                        <tr>
                                            <th style="width:4%;">#</th>
                                            <th style="width:9%;">EMP CODE</th>
                                            <th style="width:8%;">RATE</th>
                                            <th style="width:12%;">EMPLOYEE</th>
                                            <th style="width:11%;">E-R OFFICER</th>
                                            <th style="width:11%;">PROD. SUPERVISOR</th>
                                            <th style="width:11%;">QUALITY SUPERVISOR</th>
                                            <th style="width:11%;">UPDATED HR</th>
                                            <th style="width:11%;">CHECKED HR</th>
                                            <th style="width:12%;">CHECKED ACC</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div style="border-bottom: 1px dashed #000;margin_bottom:4px"></div>
                            <?php $joblist_cnt++; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <?php if ($categoryIndex < $totalCategories - 1): ?>
                    <div class="category-separator"></div>
                <?php endif; ?>
                
                <?php $mainJob_cnt++; ?>
            <?php endforeach; ?>
        </div>

        <table style="border-collapse: collapse; border-spacing: 0; width: 100%; margin-top: 30px;">
            <tr>
                <td style="font-size:10px; font-weight:bold; text-align:center; padding:3px; width: 20%;">...............................................</td>
                <td style="font-size:10px; font-weight:bold; text-align:center; padding:3px; width: 20%;">...............................................</td>
                <td style="font-size:10px; font-weight:bold; text-align:center; padding:3px; width: 20%;">...............................................</td>
                <td style="font-size:10px; font-weight:bold; text-align:center; padding:3px; width: 20%;">...............................................</td>
                <td style="font-size:10px; font-weight:bold; text-align:center; padding:3px; width: 20%;">...............................................</td>
            </tr>
            <tr>
                <td style="font-size:10px; font-weight:bold; text-align:center; padding:3px; width: 20%;">Customer</td>
                <td style="font-size:10px; font-weight:bold; text-align:center; padding:3px; width: 20%;">Sales Person Job &amp; Price Accepted By</td>
                <td style="font-size:10px; font-weight:bold; text-align:center; padding:3px; width: 20%;">Showroom Manager Technical Approval</td>
                <td style="font-size:10px; font-weight:bold; text-align:center; padding:3px; width: 20%;">Head Of Operation Production Accepted By</td>
                <td style="font-size:10px; font-weight:bold; text-align:center; padding:3px; width: 20%;">Job Coordinator Before Pics</td>
            </tr>
        </table>
       
        <div class="document-footer">
            <p>This job card was generated on <?= date('d/m/Y H:i:s') ?> | ECW Software Solutions</p>
            <p>Please retain this document for your records</p>
        </div>
    </div>
</body>
</html>