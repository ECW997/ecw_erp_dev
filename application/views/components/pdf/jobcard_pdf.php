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
            padding: 15px;
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
            height: 22px;
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
         table {
            page-break-inside: auto;
        }
        
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        
        .job-item-content {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .signature-table {
            page-break-inside: avoid;
        }
        
        .main-info-table {
            page-break-inside: avoid;
        }
        
        .job-category-container {
            page-break-inside: avoid;
        }
        
        .job-item {
            page-break-inside: avoid;
        }
        .job-items-container {
            page-break-inside: avoid;
        }
        .signature-section {
            break-inside: avoid;
        }

        .job-item-with-signature {
            page-break-inside: avoid;
            break-inside: avoid;
            display: block;
            margin-bottom: 6px;
        }
        
        /*Customer Agreement Section*/
        .customer-agreement-container {
            margin-top: 100px;
            page-break-inside: avoid;
            /*border: 3px solid #000;*/
            background-color: #fafafa;
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

            .job-item-with-signature {
                break-inside: avoid;
                -webkit-break-inside: avoid;
            }
            
            .signature-section {
                break-inside: avoid;
                -webkit-break-inside: avoid;
            }
            
            .job-item + .signature-section {
                break-before: avoid;
            }

            .job-item-container {
                page-break-before: avoid;
                page-break-after: avoid;
                page-break-inside: avoid;
            }

             table, tr, .job-item-content, .signature-table, .main-info-table, 
            .job-category-container, .job-item, .job-items-container {
                break-inside: avoid;
                -webkit-break-inside: avoid;
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
                <h1 style="font-size:22px; font-weight:bold;">Job Card</h1>
                <div class="company-info">ECW Software</div>
                <table style="width: 100%; margin-top: 5px;">
                    <tr>
                        <td style="font-size:18px; font-weight:bold; text-align:left; padding:0px; width:50%;">Job Card No: <?= $main_data['job_card_number'] ?? 'N/A' ?></td>
                        <td style="font-size:18px; font-weight:bold; text-align:right; padding:0px; width:50%;">Handover Date: <?= date('d/m/Y', strtotime($main_data['handover_date'])) ?></td>
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
                        <td><b><?= $main_data['vehicle_number'] ?? 'N/A' ?></b></td>
                        <th>Vehicle Type:</th>
                        <td>
                            <b><?= ($main_data['brand_name'] ?? '') . 
                               (!empty($main_data['model_name']) ? ', ' . $main_data['model_name'] : '').(!empty($main_data['vehicle_year']) ? ', ' . $main_data['vehicle_year'] : '') ?></b>
                        </td>
                    </tr>
                    <tr>
                        <th>Job Card No:</th>
                        <td><?= $main_data['job_card_number'] ?? 'N/A' ?></td>
                        <th>Payment Method:</th>
                        <td><?= $main_data['payment_type'] ?? 'N/A' ?></td>
                    </tr>
                    <tr>
                        <th>Sales Person:</th>
                        <td><?= $main_data['sales_person_name'] ?? 'N/A' ?></td>
                        <th>Sales Code:</th>
                        <td><?= $main_data['sales_person_code'] ?? 'N/A' ?></td>
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
                </table>
            </div>
        </div>

        <div class="job-details-section job-details-with-header">
            <div class="section-header">Job Details & Work Instructions</div>

            <?php 
            $mainJob_cnt = 1;
            $totalCategories = count($details_data);
            
            foreach ($details_data as $categoryIndex => $item): ?>
                
                <div class="job-category-container keep-together">
                    <div class="job-category-header">
                        <table style="width:100%;">
                            <tr>
                                <td style="text-align:left; width: 65%;">
                                    <strong><?= $mainJob_cnt ?>. <?= $item['job_sub_category_text'] ?? 'N/A' ?> (<?= $item['subcategory_price_category'] ?? 'N/A' ?>)</strong>
                                </td>
                                <?php if (($item['job_sub_category_text'] ?? '') === "Seat Cover"): ?>
                                    <td style="text-align:center; background-color: #ffffff; width: 15%; padding: 5px;border-radius:15px;">
                                        <img style="height:100px;border-radius:15px;" src="<?= base_url('images/OEM2.jpg') ?>" alt="Job Reference Image" />
                                    </td>
                                <?php endif; ?>
                                <td style="text-align:left; width: 20%;"></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="job-items-container job-item-with-signature">
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
                        $joblist_cnt = 1;
                        $totalJobsInCategory = count($item['details']);
                        
                        foreach ($item['details'] as $jobIndex => $joblist): ?>
                            
                            <div class="job-item keep-together">
                                <table class="job-item-content">
                                    <tr>
                                        <td class="job-number"><?= $joblist_cnt ?></td>
                                        <td colspan="2" class="job-description">
                                            <strong><?= $joblist['option_group_text'] ?? 'N/A' ?> - <?= $joblist['option_text'] ?? 'N/A' ?> - </strong>
                                            <?= $joblist['combined_option'] ?? 'N/A' ?> <?= ($joblist['description'] != 'image' && $joblist['description'] != 'dot_image') ? ($joblist['child_value_name'] ?? ''):'' ?>
                                            
                                            <?php if ($joblist['description'] == 'image' || $joblist['description'] == 'dot_image') : ?>
                                                <div class="image-container">
                                                    <img src="<?= htmlspecialchars($joblist['child_value_name'] ?? '') ?>" alt="Job Reference Image" />
                                                </div>
                                            <?php endif; ?>
                                            <br><br>
                                            <?php if (empty($joblist['list_price']) || $joblist['list_price'] <= 0): ?>
                                                <span style="background-color: black; color: white; padding: 4px 4px; border-radius: 3px;">
                                                    (Price Not Included)
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="job-remarks">
                                            <?= $joblist['remark'] ?? '' ?>
                                        </td>
                                        <td class="job-quantity"> <?= $joblist['qty'] ?? 0 ?></td>
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
        <br>
         <p>
          <strong><?= $main_data['discount'] ?? 'N/A' ?> % Discount Approved By:</strong> <?= $main_data['person_name'] ?? 'N/A' ?> <br>
 </p>
        <div class="customer-agreement-container" style="font-family: Arial, sans-serif; font-size: 12px; line-height: 1.5;">
           <h1 style="text-align:center; margin-bottom: 60px;">
        Customer Agreement for Vehicle Interior Modifications
    </h1>

    <p>
        <strong>This Agreement</strong> is made on this <?= date('jS') ?> day of <?= date('F') ?>, <?= date('Y') ?>, by and between:
    </p>

    <p>
        <strong>Company Name:</strong> Edirisingha Cushion Works (Pvt) Ltd <br>
        <strong>Customer Name:</strong> <?= $main_data['customer_name'] ?? 'N/A' ?> <br>
        <strong>Vehicle Registration No:</strong> <?= $main_data['vehicle_number'] ?? 'N/A' ?>
    </p>

     <hr style="margin: 30px 0;">

    <!-- Scope of Work -->
    <h3>1. Scope of Work</h3>
    <p>The Company specializes in vehicle interior modifications, which may include but are not limited to:</p>
    <ul>
        <li>Removal and reinstallation of original seats and interior fittings</li>
        <li>Alterations or customizations to the seating layout, upholstery, flooring, ceiling, panels, and other interior components</li>
        <li>Installation of new or custom-built interior parts and accessories</li>
    </ul>
    
     <hr style="margin: 30px 0;">

    <!-- Acknowledgment -->
    <h3>2. Acknowledgment by the Customer</h3>
    <p>The Customer acknowledges and agrees that:</p>
    <ul>
        <li>Original factory settings, fittings, and fixing points of interior components (including seats) may be altered, removed, or replaced as part of the modification process.</li>
        <li>Any changes made during the modification process may affect the vehicle’s original condition, including warranty terms with the manufacturer or third parties.</li>
        <li>Based on the date of manufacture, there is an increased risk of parts breaking during the removal and fitting process involved in the modification procedure. Older vehicles, in particular, are more likely to have worn or fragile components in the modification area, increasing the likelihood of damage.</li>
        <li>The Company will carry out the work to the best of its professional standards but cannot guarantee that modifications will maintain original manufacturer specifications.</li>
    </ul>

    <hr style="margin: 30px 0;">

    <!-- Customer Consent -->
    <h3>3. Customer Consent</h3>
    <p>By signing this agreement, the Customer provides full consent for the Company to:</p>
    <ul>
        <li>Proceed with the interior modifications as discussed and agreed upon</li>
        <li>Make necessary alterations to the seat and interior part settings and their fixing mechanisms</li>
        <li>Use alternative materials, tools, or configurations as required for the intended design</li>
    </ul>

 <hr style="margin: 30px 0;">
    <!-- Warranty -->
    <h3>4. Warranty and Liability</h3>
    <ul>
        <li>The Company’s workmanship warranty on modifications performed, excluding normal wear and tear or misuse, will be covered under a separate warranty policy.</li>
        <li>The Company shall not be held responsible for any issues related to manufacturer warranty voids or structural limitations arising due to these modifications.</li>
        <li>Any further requests or changes after the initial agreed-upon design will be subject to additional charges.</li>
    </ul>

 <hr style="margin: 30px 0;">
    <!-- Delivery -->
    <h3>5. Vehicle Delivery &amp; Inspection</h3>
    <ul>
        <li>Upon completion, the Customer will inspect the modified vehicle and confirm acceptance of the work done.</li>
        <li>Any concerns must be raised immediately during the handover. Subsequent alterations will be treated as separate work.</li>
    </ul>
 <hr style="margin: 30px 0;">
    <!-- Governing Law -->
    <h3>6. Governing Law</h3>
    <p>This Agreement shall be governed by the law of Democratic Socialist Republic of Sri Lanka.</p>
    
     <hr style="margin: 30px 0;">
     <p>IN WITNESS WHEREOF, the parties have executed this Agreement on the date first written above.<p>
        </div>

        <table style="border-collapse: collapse; border-spacing: 0; width: 100%; margin-top: 150px;">
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
            <p>This job card was generated on <?= date('d/m/Y H:i:s') ?> | ECW Software</p>
            <p>Please retain this document for your records</p>
        </div>
    </div>
    
</body>
</html>