<?php 
include "include/header.php";  

include "include/topnavbar.php"; 
?>
  <style>
    .card-header {
      background-color: white;
      border-bottom: 1px solid #6c757d;
      padding: 1rem 2rem;
    }
    label {
      color: #6c757d;
      font-weight: 700;
      font-size: 0.85rem;
      white-space: nowrap;
      margin-bottom: 0;
      line-height: 1.5;
    }
    .form-control-sm, .custom-select-sm {
      font-size: 0.85rem;
      padding: 0.25rem 0.5rem;
      height: 1.9rem;
    }
    #filterBtn {
      min-width: 100px;
      height: 1.9rem;
      font-size: 0.85rem;
      padding: 0 0.75rem;
    }
    .input-group-text {
      background-color: #e9ecef;
      border-right: 0;
      font-weight: 700;
      color: #6c757d;
      white-space: nowrap;
      height: 1.9rem;
      padding: 0 0.5rem;
      line-height: 1.9rem;
    }
    .input-group > .form-control:first-child {
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
    }
    .input-group > .form-control:last-child {
      border-top-left-radius: 0;
      border-bottom-left-radius: 0;
      border-left: 0;
    }
    @media (max-width: 575.98px) {
      .card-header .row > div {
        margin-bottom: 0.5rem;
      }
      .card-header .row > div:last-child {
        margin-bottom: 0;
      }
    }
  </style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3 d-flex justify-content-between align-items-center">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-list-ul"></i></div>
                            <span>Job Card List</span>
                        </h1>
                        <div>
                          <button type="button" id="exportExcelBtn3" class="btn btn-sm px-4 p-2 ml-2 mr-3"
                                style="display:none; background-color:#fd7e14; color:#ffffff; border-color:#fd7e14;">
                                <i class="fas fa-file-excel mr-2"></i>Export Excel(Category)
                            </button>
                           <button type="button" id="exportExcelBtn" class="btn btn-success btn-sm px-4 p-2 ml-2 mr-3" style="display:none;">
                                <i class="fas fa-file-excel mr-2"></i>Export Excel
                            </button>
                              <button type="button" id="exportExcelBtn2" class="btn btn-sm px-4 p-2 ml-2 mr-3" style="display:none; background-color:#e83e8c; color:#ffffff; border-color:#e83e8c;">
                                <i class="fas fa-file-excel mr-2"></i>Export Excel
                            </button>
                            <a href="<?= base_url('JobCard/jobCardDetailIndex') ?>"
                                class="btn btn-primary btn-sm px-4 p-2 <?php if($addcheck==0){echo 'd-none';} ?>">
                                <i class="fas fa-plus mr-2"></i>Create New JobCard
                            </a>
                        </div>
                    </div>
                </div>


            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="p-2">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3 d-flex align-items-center justify-content-start">
                                <label for="date_from" class="mb-0 mr-2">Date Filter</label>
                                <div class="input-group">
                                    <input type="date" id="date_from" class="form-control form-control-sm" aria-label="Date From" />
                                    <div class="input-group-append">
                                    <span class="input-group-text">to</span>
                                    </div>
                                    <input type="date" id="date_to" class="form-control form-control-sm" aria-label="Date To" />
                                </div>
                            </div>

                            <div class="col-12 col-md-9 d-flex align-items-center justify-content-end flex-wrap">
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="sales_agent" class="mb-0 mr-2">Sales Agent</label>
                                    <select id="sales_agent" class="custom-select custom-select-sm" style="min-width: 130px;">
                                    <option value="">All</option>
                                       <?php if (!empty($sales_agents)) : ?>
                                            <?php foreach ($sales_agents as $agent) : ?>
                                                <option value="<?= $agent['idtbl_sales_person']; ?>">
                                                    <?= htmlspecialchars($agent['sales_person_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="job_status" class="mb-0 mr-2">Job Status</label>
                                    <select id="job_status" class="custom-select custom-select-sm" style="min-width: 130px;">
                                    <option value="">All</option>
                                    <option value="0">Not Started</option>
                                    <option value="1">Started</option>
                                    <option value="2">Job Done</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="status" class="mb-0 mr-2">Status</label>
                                    <select id="status" class="custom-select custom-select-sm" style="min-width: 130px;">
                                    <option value="">All Status</option>
                                    <option value="Draft">Draft</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                                 <div class="d-flex align-items-center mr-3 mb-2 mb-md-0">
                                    <label for="payment_status" class="mb-0 mr-2">Payment Status</label>
                                    <select id="payment_status" class="custom-select custom-select-sm" style="min-width: 130px;">
                                    <option value="">All Status</option>
                                    <option value="0">Payment Pending</option>
                                    <option value="1">Payment Paid</option>
                                    </select>
                                </div>
                                <button class="btn btn-secondary btn-sm" id="filterBtn" style="height: 1.9rem; font-size: 0.85rem;">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                                <button class="btn btn-outline-secondary btn-sm ml-2" id="clearFilterBtn">Clear</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
        								<thead>
        									<tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Job Card No</th>
                                                <th>Customer</th>
                                                <th>Vehicle Number</th>
                                                <th>Vehicle Brand</th>
                                                <th>Vehicle Model</th>
                                                <th>Scheduled</th>
                                                <th>Completed</th>
                                                <th>Handover</th>
                                                <th>Sales Agent</th>
                                                <th>Job Status</th>
                                                <th>Status</th>
                                                <th>Payment Status</th>
        										<th class="text-right">Actions</th>
        									</tr>
        								</thead>
        							</table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';
    var approve1check = '<?php echo $approve1check; ?>';
    var approve2check = '<?php echo $approve2check; ?>';
    var approve3check = '<?php echo $approve3check; ?>';
    var approve4check = '<?php echo $approve4check; ?>';
    var cancelcheck = '<?php echo $cancelcheck; ?>';



    $(document).ready(function() {
      var base_url = "<?php echo base_url(); ?>";

        $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-5'l><'col-sm-2'><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        "buttons": [{
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                title: 'Job Card List',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Job Card List',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Job Card List',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            },
        ],
        ajax: {
            url: apiBaseUrl + '/v1/job_card',
            type: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + api_token
            },
            data: function(d) {
                d.date_from = $('#date_from').val();
                d.date_to = $('#date_to').val();
                d.sales_agent = $('#sales_agent').val();
                d.job_status = $('#job_status').val();
                d.status = $('#status').val();
                d.payment_status = $('#payment_status').val();
            },
            dataSrc: function(json) {
                if (json.status === false && json.code === 401) {
                    falseResponse(errorObj);
                } else {
                    return json.data;
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) {
                    falseResponse(errorObj);
                }
            }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "idtbl_jobcard"
            },
            {
                "data": "jobcard_date"
            },
            {
                "data": "job_card_number"
            },
            {
                "data": "customer_name"
            },
            {
                "data": "vehicle_number"
            },
            {
                "data": "brand_name"
            },
            {
                "data": "model_name"
            },
            {
                "data": "job_start_date"
            },
            {
                data: "complete_date",
                className: "text-center",
                render: function(data, type, row) {
                    if (row.job_progress_status_text !== "Completed") {
                        return `<i class="fas fa-hourglass-half text-muted" title="In Progress"></i>`;
                    }

                    return `<span class="text-success">${data}</span>`;
                }
            },
            {
                "data": "handover_date"
            },
            {
                "data": "sales_person_name"
            },
            {
                data: "job_progress_status_text",
                className: "text-center",
                render: function(data, type, row) {
                    let baseClasses = "badge badge-pill";
                    let style = "";

                    switch (data) {
                        case "Not Started":
                            style = "background-color: #D9D9D9; color: #6B7280;";
                            break;
                        case "In Progress":
                            style = "background-color: #BBF7D0; color: #15803D;";
                            break;
                        case "Completed":
                            style = "background-color: #22C55E; color: #D1FAE5;";
                            break;
                        case "On Hold":
                            style = "background-color: #DC2626; color: #FEE2E2;";
                            break;
                        case "Pending RM":
                            style = "background-color: #FB923C; color: #FFEDD5;";
                            break;
                        default:
                            style = "background-color: #1F2937; color: #F3F4F6;";
                    }

                    return `<span class="${baseClasses}" style="${style}">${data}</span>`;
                }
            },
            {
                data: "status",
                className: "text-center",
                render: function(data, type, row) {
                    let baseClasses = "badge badge-pill";
                    let style = "";

                    switch (data) {
                        case 'Draft':
                            style = 'background-color: #6B7280; color: #FFFFFF;';
                            break;
                        case 'Pending':
                            style = 'background-color: #F59E0B; color: #1F2937;';
                            break;
                        case 'Approved':
                            style = 'background-color: #10B981; color: #FFFFFF;';
                            break;
                        case 'Cancelled':
                            style = 'background-color: #EF4444; color: #FFFFFF;';
                            break;
                        case 'Re-Approve Pending':
                            style = 'background-color: #F97316; color: #FFFFFF;';
                            break;
                        case 'Re-Approved':
                            style = 'background-color: #059669; color: #FFFFFF;';
                            break;
                        default:
                            style = 'background-color: #4B5563; color: #FFFFFF;';
                            break;
                    }
                    return `<span class="${baseClasses}" style="${style}">${data}</span>`;
                }
            },
            {
                data: "payment_status",
                className: "text-center",
                render: function(data, type, row) {
                    let baseClasses = "badge badge-pill";
                    let style = "";
                    let status = "";

                    switch (data) {
                        case '0':
                            style = 'background-color: #e81500; color: #FFFFFF;';
                            status = 'Payment Pending';
                            break;
                        case '1':
                            style = 'background-color: #00ac69; color: #1F2937;';
                            status = 'Payment Paid';
                            break;
                        case '2':
                            style = 'background-color: #00ac69; color: #1F2937;';
                            status = 'Payment Pending';
                            break;
                        default:
                            style = 'background-color: #4B5563; color: #FFFFFF;';
                            break;
                    }
                    return `<span class="${baseClasses}" style="${style}">${status}</span>`;
                }
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button += '<a href="' + base_url + 'JobCard/jobCardDetailIndex/' + full[
                            'idtbl_jobcard'] +
                        '" title="View" class="btn btn-secondary btn-sm btnView mr-1">' +
                        '<i class="fas fa-external-link-alt"></i></a>';
                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

        $(document).on('click', '#addtolistBtn', function(){
           var sub_job_category = $('#sub_job_category').val();
           var group_name = $('#group_name').val();
           var sort_order = $('#sort_order').val();
           var description = $('#description').val();
           var recordID = $('#recordID').val();
           var recordOption = $('#recordOption').val();

           $.ajax({
                type: "POST",
                dataType: 'json',
                data: {
                    sub_job_category: sub_job_category,
                    group_name: group_name,
                    sort_order: sort_order,
                    description: description,
                    recordOption: recordOption,
                    recordID: recordID
                },
                url: '<?php echo base_url() ?>JobOptionGroup/jobOptionGroupInsertUpdate',
                success: function(result) { 
                    if (result.status == true) {
                        cancelBtn();
                        success_toastify(result.message);
                        showGroupDetailsList(sub_job_category,1);
                    } else {
                        falseResponse(result);
                    }
                }
            });
        })
        
        $(document).on('click', '.detailEditBtn', function() {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: '<?php echo base_url() ?>JobOptionGroup/jobOptionGroupEdit/'+id,
                    success: function(result) { 
                        if(result.status){
                            $('#recordID').val(result.data.id);
                            $('#group_name').val(result.data.group_name);
                            $('#sort_order').val(result.data.sort_order);
                            $('#description').val(result.data.description);

                            $('#recordOption').val('2');
                            $('#addtolistBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                            $('#cancellistBtn').removeClass('d-none');
                        }else{
                            falseResponse(result);
                        }
                    }
                });
            }
        });

        $(document).on('click', '.detailStatusBtn', function() {
            var status = $(this).attr('status');
            var r = (status == '1'? confirm("Are you sure, You want to Active this ? ") : confirm("Are you sure, You want to Deactive this ? "));
            if (r == true) {
                var id = $(this).attr('id');
                var sub_id = $(this).attr('sub_id');
                $.ajax({
                    type: "PUT",
                    dataType: 'json',
                    url: '<?php echo base_url() ?>JobOptionGroup/jobOptionGroupStatus/'+id+'/'+status,
                    success: function(result) { 
                        if(result.status){
                            showGroupDetailsList(sub_id,1);
                            success_toastify(result.message);
                        }else{
                            falseResponse(result);
                        }
                    }
                });
            }
        });

        $(document).on('click', '.detailDeleteBtn', function() {
            var r = confirm("Are you sure, You want to Delete this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                var sub_id = $(this).attr('sub_id');
                $.ajax({
                    type: "DELETE",
                    dataType: 'json',
                    url: '<?php echo base_url() ?>JobOptionGroup/jobOptionGroupDelete/'+id,
                    success: function(result) { 
                        if(result.status){
                            showGroupDetailsList(sub_id,1);
                            success_toastify(result.message);
                        }else{
                            falseResponse(result);
                        }
                    }
                });
            }
        });

        $('#filterBtn').on('click', function() {
            $('#dataTable').DataTable().ajax.reload();
        });

        $('#clearFilterBtn').on('click', function() {
            $('#date_from, #date_to, #sales_agent, #job_status, #status, #payment_status').val('');
            $('#dataTable').DataTable().ajax.reload();
        });
                
      
      
   		document.getElementById('exportExcelBtn').addEventListener('click', function() {
            const date_from = document.getElementById('date_from').value;
            const date_to = document.getElementById('date_to').value;

            if (!date_from || !date_to) {
                alert('Please select both Dates.');
                return;
            }

            fetch('<?php echo base_url(); ?>JobCard/exportJobCardExcelData', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'

                    },
                    body: JSON.stringify({
                        date_from,
                        date_to
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status && Array.isArray(data.data)) {
                        // Convert numeric fields
                        const numericFields = [
                            'qty', 'standard_price', 'jobcard_price', 'subtotal', 'nettotal',
                            'line_discount'
                        ];
                        data.data.forEach(row => {
                            numericFields.forEach(field => {
                                if (row[field] !== undefined && row[field] !== null &&
                                    row[field] !== '') {
                                    row[field] = Number(row[field]);
                                }
                            });
                        });

                        const ws = XLSX.utils.json_to_sheet(data.data);
                        ws['!cols'] = [{
                                wch: 18
                            }, //Date
                            {
                                wch: 16
                            }, //Invoice Number
                            {
                                wch: 16
                            }, //Invoice Date
                            {
                                wch: 15
                            }, //Sales Person Code
                            {
                                wch: 15
                            }, //Sales Person Name
                            {
                                wch: 15
                            }, //Vehicle No
                            {
                                wch: 16
                            }, //Job card No
                            {
                                wch: 10
                            }, //Receipt No
                            {
                                wch: 10
                            }, //Bank/Cash
                            {
                                wch: 150
                            }, //Job Item Name
                            {
                                wch: 10
                            }, //Qty
                            {
                                wch: 20
                            }, //Standard Price
                            {
                                wch: 16
                            }, //Open Price
                            {
                                wch: 10
                            }, //Discount%
                            {
                                wch: 16
                            }, //Discount Amount
                            {
                                wch: 16
                            }, //Net Total
                            {
                                wch: 15
                            }, //Approve by
                        ];

                        // Bold header row
                        const range = XLSX.utils.decode_range(ws['!ref']);
                        for (let C = range.s.c; C <= range.e.c; ++C) {
                            const cell = ws[XLSX.utils.encode_cell({
                                r: 0,
                                c: C
                            })];
                            if (cell && !cell.s) cell.s = {};
                            if (cell) cell.s.font = {
                                bold: true
                            };
                        }

                        // Create workbook and export
                        const wb = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(wb, ws, "JobCards");
                        XLSX.writeFile(wb, "JobCardsInformation.xlsx");
                    } else {
                        alert('No data found for the selected date range.');
                    }
                })
                .catch(err => {
                    alert('Error fetching data: ' + err);
                });
        });


      function loadExcelJSLibrary() {
          return new Promise((resolve, reject) => {
              if (typeof ExcelJS !== 'undefined') {
                  resolve();
                  return;
              }

              // Load ExcelJS
              const script = document.createElement('script');
              script.src = 'https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js';
              script.onload = resolve;
              script.onerror = reject;
              document.head.appendChild(script);
          });
      }

      
      document.getElementById('exportExcelBtn2').addEventListener('click', async function() {
          try {
              await loadExcelJSLibrary();

              const date_from = document.getElementById('date_from').value;
              const date_to = document.getElementById('date_to').value;
              const type = 'both';

              if (!date_from || !date_to) {
                  alert('Please select both Dates.');
                  return;
              }

              const requestData = { date_from, date_to, type };

              // Show loading indicator
              const originalText = this.innerHTML;
              this.innerHTML = 'Generating Excel...';
              this.disabled = true;

              const response = await fetch('<?php echo base_url(); ?>JobCard/exportJobCardExcelData', {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify(requestData)
              });

              const data = await response.json();

              // Restore button state
              this.innerHTML = originalText;
              this.disabled = false;

              if (data.status && Array.isArray(data.data) && data.data.length > 0) {
                  // --- Group by Invoice Number ---
                  const groupedByInvoice = {};
                  data.data.forEach(row => {
                      if (!groupedByInvoice[row['Invoice Number']]) {
                          groupedByInvoice[row['Invoice Number']] = {
                              items: [],
                              invoiceData: {
                                  'Invoice Number': row['Invoice Number'],
                                  'Invoice Date': row['Invoice Date'],
                                  'Sales Person Code': row['Sales Person Code'],
                                  'Sales Person Name': row['Sales Person Name'],
                                  'Vehicle Number': row['Vehicle Number'],
                                  'Job Card Number': row['Job Card Number'],
                                  'Jobcard Date': row['Jobcard Date']
                              }
                          };
                      }
                      groupedByInvoice[row['Invoice Number']].items.push(row);
                  });

                  const excelData = [];

                  // --- Process Each Invoice Group ---
                  Object.values(groupedByInvoice).forEach(invoiceGroup => {
                      const items = invoiceGroup.items;
                      const invoiceData = invoiceGroup.invoiceData;
                      let invoiceSubtotal = 0;
                      let invoiceDiscount = 0;
 				      let jobCardNo = ''

                      items.forEach(item => {
                          // Convert numeric fields
                          const numericFields = ['Qty', 'Standard (System) Price', 'Open Price', 'Discount Amount', 'Net Total Amount'];
                          numericFields.forEach(field => {
                              if (item[field] !== undefined && item[field] !== null && item[field] !== '') {
                                  item[field] = Number(item[field]);
                              }
                          });

                          excelData.push({
                              'Jobcard Date': item['Jobcard Date'] || '',
                              'Invoice Number': item['Invoice Number'] || '',
                              'Invoice Date': item['Invoice Date'] || '',
                              'Sales Person Code': item['Sales Person Code'] || '',
                              'Sales Person Name': item['Sales Person Name'] || '',
                              'Vehicle Number': item['Vehicle Number'] || '',
                              'Job Card Number': item['Job Card Number'] || '',
                              'Receipt No': item['Receipt No'] || '',
                              'Bank / Cash': item['Bank / Cash'] || '',
                              'Job Item Name': item['Job Item Name'] || '',
                              'Qty': item['Qty'] || 0,
                              'Standard (System) Price': item['Standard (System) Price'] || '',
                              'Open Price': item['Open Price'] || 0,
                              'Discount %': item['Discount %'] || '',
                              'Discount Amount': item['Discount Amount'] || 0,
                              'Net Total Amount': item['Net Total Amount'] || 0,
                              'Discount Approved By': item['Discount Approved By'] || '',
                              'Main Category': item['Main Category'] || 0,
                              'Sub Category': item['Sub Category'] || ''
                          });

                          invoiceSubtotal = Number(item['Final Total Amount'] || 0);
                          invoiceDiscount = Number(item['All Discounts'] || 0);
                          jobCardNo = invoiceData['Job Card Number'];
                      });

                      // --- Add Discount Row ---
                      const discountRow = {
                          'Bank / Cash': 'INVOICE DISCOUNT',
                          'Discount Amount': invoiceDiscount,
                          //'Discount Approved By': -invoiceDiscount
                      };
                    
                      if (invoiceDiscount > 0) {
                        discountRow['Job Card Number'] = jobCardNo;
                      }

                      excelData.push(discountRow);

                      // --- Add Total Row ---
                      excelData.push({
                          'Bank / Cash': 'INVOICE TOTAL',
                          'Discount Approved By': invoiceSubtotal
                      });
                    

                      // Add empty row for separation
                      excelData.push({});
                  });

                  // Remove last empty row if exists
                  if (excelData.length > 0 && Object.keys(excelData[excelData.length - 1]).length === 0) {
                      excelData.pop();
                  }

                  if (excelData.length === 0) {
                      alert('No data available to export.');
                      return;
                  }

                  // Generate Excel with proper styling
                  await generateStyledExcel(excelData);
              } else {
                  alert('No data found for the selected date range.');
              }
          } catch (error) {
              console.error('Error:', error);
              alert('Error: ' + error.message);

              // Restore button state in case of error
              const btn = document.getElementById('exportExcelBtn2');
              btn.innerHTML = 'Export to Excel';
              btn.disabled = false;
          }
      });
      
      async function generateStyledExcel(excelData) {
          // Create workbook and worksheet
          const workbook = new ExcelJS.Workbook();
          const worksheet = workbook.addWorksheet('JobCards');

          // Define headers
          const headers = [
              'Jobcard Date', 'Invoice Number', 'Invoice Date', 'Sales Person Code', 
              'Sales Person Name', 'Vehicle Number', 'Job Card Number', 'Receipt No', 
              'Bank / Cash', 'Job Item Name', 'Qty', 'Standard (System) Price', 
              'Open Price', 'Discount %', 'Discount Amount', 'Net Total Amount', 
              'Discount Approved By','Main Category','Sub Category'
          ];

          // Add header row
          const headerRow = worksheet.addRow(headers);

          // Style header row
          headerRow.eachCell((cell) => {
              cell.font = { bold: true, color: { argb: 'FFFFFFFF' } };
              cell.fill = {
                  type: 'pattern',
                  pattern: 'solid',
                  fgColor: { argb: 'FF2F5496' } // Dark blue background
              };
              cell.alignment = { vertical: 'middle', horizontal: 'center' };
              cell.border = {
                  top: { style: 'thin' },
                  left: { style: 'thin' },
                  bottom: { style: 'thin' },
                  right: { style: 'thin' }
              };
          });

          // Add data rows
          excelData.forEach((rowData, index) => {
              const row = worksheet.addRow(headers.map(header => rowData[header] || ''));

              // Check if this is a special row (INVOICE DISCOUNT or INVOICE TOTAL)
              const bankCashValue = rowData['Bank / Cash'];
              const isDiscountRow = bankCashValue === 'INVOICE DISCOUNT';
              const isTotalRow = bankCashValue === 'INVOICE TOTAL';
              const isEmptyRow = Object.keys(rowData).length === 0;

              if (isDiscountRow || isTotalRow) {
                  // Style entire row for discount and total rows
                  row.eachCell((cell) => {
                      cell.font = { bold: true };
                      cell.fill = {
                          type: 'pattern',
                          pattern: 'solid',
                          fgColor: { argb: isTotalRow ? 'FFC6EFCE' : 'FFFFC7CE' } // Green for total, Red for discount
                      };
                      cell.border = {
                          top: { style: 'thin' },
                          left: { style: 'thin' },
                          bottom: { style: 'thin' },
                          right: { style: 'thin' }
                      };

                      // Format numeric cells
                      if (typeof cell.value === 'number') {
                          cell.numFmt = '#,##0.00';
                      }
                  });
              } else if (isEmptyRow) {
                  // Empty row for separation
                  row.height = 5;
              } else {
                  // Regular data row styling
                  row.eachCell((cell) => {
                      cell.border = {
                          top: { style: 'thin' },
                          left: { style: 'thin' },
                          bottom: { style: 'thin' },
                          right: { style: 'thin' }
                      };

                      // Format numeric cells
                      if (typeof cell.value === 'number') {
                          cell.numFmt = '#,##0.00';
                          cell.alignment = { horizontal: 'right' };
                      }
                  });

                  // Alternate row coloring for better readability
                  if (index % 2 === 0) {
                      row.eachCell((cell) => {
                          cell.fill = {
                              type: 'pattern',
                              pattern: 'solid',
                              fgColor: { argb: 'FFF2F2F2' } // Light gray
                          };
                      });
                  }
              }
          });

          // Set column widths
          worksheet.columns = [
              { width: 18 }, { width: 16 }, { width: 16 },
              { width: 15 }, { width: 15 }, { width: 15 },
              { width: 16 }, { width: 10 }, { width: 15 },
              { width: 130 }, { width: 10 }, { width: 20 },
              { width: 16 }, { width: 10 }, { width: 16 },
              { width: 16 }, { width: 15 }, { width: 18 }, { width: 25}
          ];

          // Freeze header row
          worksheet.views = [
              { state: 'frozen', ySplit: 1 }
          ];

          // Generate and download Excel file
          try {
              const buffer = await workbook.xlsx.writeBuffer();
              const blob = new Blob([buffer], { 
                  type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' 
              });

              // Create download link
              const url = window.URL.createObjectURL(blob);
              const a = document.createElement('a');
              a.href = url;
              a.download = 'JobCardsInformation_Direct_Indirect.xlsx';
              document.body.appendChild(a);
              a.click();
              document.body.removeChild(a);
              window.URL.revokeObjectURL(url);

          } catch (error) {
              console.error('Error generating Excel file:', error);
              alert('Error generating Excel file: ' + error.message);
          }
      }

  
      });

    function showInsertModal() {
        $('#main_job_category').val('').trigger('change');
        $('#sub_job_category').val('').trigger('change');
        $("#crudTable").html('');
        $('#addModal').modal('show');
        cancelBtn();
    }

    function showViewModal(sub_id) {
        showGroupDetailsList(sub_id,2);
        $('#viewModal').modal('show');
    }

    function showGroupDetailsList(sub_id,modalOption){  
        if(sub_id == ''){
            return false;
        }

        var tableOption = (modalOption == '2') ? 'viewTable' : 'crudTable';
        $("#"+tableOption+"").html('');
        $.ajax({
            type: "GET",
            url: '<?php echo base_url() ?>JobOptionGroup/jobOptionGroupDetailsList',
            data: { sub_id: sub_id, 
                    modalOption: modalOption,
                    editcheck: editcheck,
                    statuscheck: statuscheck,
                    deletecheck: deletecheck },
            success: function (result) {
                if(result){
                    $("#"+tableOption+"").html(result);
                }  
            },
            error: function () {
                $("#" + tableOption).html('<p class="text-center text-danger">Error fetching data!</p>');
            }
        });
    }

    function cancelBtn(){
        $('#group_name').val('');
        $('#sort_order').val('');
        $('#description').val('');
        $('#recordID').val('');
        $('#recordOption').val('1');
        $('#cancellistBtn').addClass('d-none');
        $('#addtolistBtn').html('<i class="fas fa-plus mr-2"></i>Add to list')
    }

    function checkedDublicate(input) {
        var inputValue = input.value;
        var table_name = 'job_optiongroups';
        var columnName = input.getAttribute('data-field');

        $.ajax({
            url: '<?php echo base_url() ?>CheckDublicate/check_duplicate',
            type: 'POST',
            dataType: 'json',
            data: {
                input_value: inputValue,
                table_name: table_name,
                column_name: columnName
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'error') {
                    $('#' + columnName + '_errorMsg').text(response.message).show();
                } else {
                    $('#' + columnName + '_errorMsg').hide();
                }
            }
        });
    }

    function deactive_confirm() {
        return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to active this?");
    }

    function delete_confirm() {
        return confirm("Are you sure you want to remove this?");
    }
</script>

<script>
$(document).ready(function() {
    let showSecret = "boom";
    let hideSecret = "hide";
    let buffer = "";

    $(document).on('keydown', function(e) {
        if (e.key.length === 1 && /[a-zA-Z]/.test(e.key)) {
            buffer += e.key.toLowerCase();
            if (buffer.length > Math.max(showSecret.length, hideSecret.length)) {
                buffer = buffer.slice(-Math.max(showSecret.length, hideSecret.length));
            }
            if (buffer === showSecret) {
                $('#exportExcelBtn').show();
                buffer = "";
            }
            if (buffer === hideSecret) {
                $('#exportExcelBtn').hide();
                buffer = "";
            }
        }
    });
});
  
$(document).ready(function() {
    let showSecret = "boom";
    let hideSecret = "hide";
    let buffer = "";

    $(document).on('keydown', function(e) {
        if (e.key.length === 1 && /[a-zA-Z]/.test(e.key)) {
            buffer += e.key.toLowerCase();
            if (buffer.length > Math.max(showSecret.length, hideSecret.length)) {
                buffer = buffer.slice(-Math.max(showSecret.length, hideSecret.length));
            }
            if (buffer === showSecret) {
                $('#exportExcelBtn2').show();
                buffer = "";
            }
            if (buffer === hideSecret) {
                $('#exportExcelBtn2').hide();
                buffer = "";
            }
        }
    });
});
</script>
<?php include "include/footer.php"; ?>