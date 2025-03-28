<?php
include "include/header.php";

include "include/topnavbar.php";
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-file-alt"></i></div>
                            <span>Cancel Appointment Report</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="col-12">
                            <form id="filter_table">
                                <div class="col-12">
                                    <div class="form-row">
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Inquiry Source*</label>
                                            <select class="form-control form-control-sm selecter2 px-0" name="f_inquiry"
                                                id="f_inquiry">
                                                <option value="">Select</option>
                                                <?php foreach ($inquirylist->result() as $rowinquirylist) { ?>
                                                <option value="<?php echo $rowinquirylist->idtbl_inquiry_source ?>">
                                                    <?php echo $rowinquirylist->inquiry_source_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Sales Person*</label>
                                            <select class="form-control form-control-sm selecter2 px-0"
                                                name="f_sales_person" id="f_sales_person">
                                                <option value="">Select</option>
                                                <?php foreach ($salespersonlist->result() as $rowsalespersonlist) { ?>
                                                <option value="<?php echo $rowsalespersonlist->idtbl_sales_person ?>">
                                                    <?php echo $rowsalespersonlist->sales_person_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-2" id="select_from">
                                            <label class="small font-weight-bold text-dark"> Date From*</label>
                                            <input type="date" class="form-control form-control-sm" placeholder=""
                                                name="date_from" id="date_from">
                                        </div>
                                        &nbsp;
                                        <div class="col-2" id="select_to">
                                            <label class="small font-weight-bold text-dark"> Date To*</label>
                                            <input type="date" class="form-control form-control-sm" placeholder=""
                                                name="date_to" id="date_to">
                                        </div>
                                        <div class="col-1" id="hidesumbit">&nbsp;<br>
                                            <button type="submit" class="btn btn-info btn-sm ml-auto w-25 mt-2 px-5"
                                                id="search_button">Search</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-1">
                                        <hr style="border: 1px solid #ddd;">
                                    </div>
                                </div>
                            </form>
                            <div id="columnSelector">
                                <div class="row">
                                    <div class="col-2">
                                        <label><input type="checkbox" class="export-column" value="0" checked> Inquiry Number</label>
                                    </div>
                                    <div class="col-2">
                                        <label><input type="checkbox" class="export-column" value="1" checked> Inquiry Date</label>
                                    </div>
                                    <div class="col-2">
                                        <label><input type="checkbox" class="export-column" value="2" checked> Inquiry Source</label>
                                    </div>
                                    <div class="col-2">
                                        <label><input type="checkbox" class="export-column" value="3" checked> Customer Name</label>
                                    </div>
                                    <div class="col-2">
                                        <label><input type="checkbox" class="export-column" value="4" checked> Mobile Number</label>
                                    </div>
                                    <div class="col-2">
                                        <label><input type="checkbox" class="export-column" value="5" checked> Mobile Number 2</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <label><input type="checkbox" class="export-column" value="6" checked> Vehicle Number</label>
                                    </div>
                                    <div class="col-2">
                                        <label><input type="checkbox" class="export-column" value="7" checked> Vehicle Brand</label>
                                    </div>
                                    <div class="col-2">
                                        <label><input type="checkbox" class="export-column" value="8" checked> Vehicle Model</label>
                                    </div>
                                    <div class="col-2">
                                        <label><input type="checkbox" class="export-column" value="9" checked> Sales Person</label>
                                    </div>
                                    <div class="col-2">
                                        <label><input type="checkbox" class="export-column" value="10" checked>Coordinator</label>
                                    </div>
                                    <div class="col-2">
                                        <label><input type="checkbox" class="export-column" value="11" checked>Appointment Date</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap w-100"
                                        id="dataTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th> Inquiry Number</th>
                                                <th> Inquiry Date</th>
                                                <th> Inquiry Source</th>
                                                <th> Customer Name</th>
                                                <th> Mobile Number</th>
                                                <th> Mobile Number 2</th>
                                                <th> Vehicle Number</th>
                                                <th> Vehicle Brand</th>
                                                <th> Vehicle Model</th>
                                                <!-- <th>Vehicle Year</th> -->
                                                <th> Sales Person</th>
                                                <th> Coordinator</th>
                                                <!-- <th>Appointment</th> -->
                                                <th> Appointment Date</th>
                                                <!-- <th>Image Delivery</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.22/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>

<script>
$(document).ready(function() {
    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';

    $("#f_inquiry").select2({
        placeholder: "Select Inquiry Source",
        allowClear: true
    });
    $("#f_sales_person").select2({
        placeholder: "Select Sales Person",
        allowClear: true
    });

    filterData('', '', '', '');

    $("#filter_table").submit(function(event) {
        event.preventDefault();

        var inquiry_source = $("#f_inquiry").val();
        var sales_person = $("#f_sales_person").val();
        var date_from = $("#date_from").val();
        var date_to = $("#date_to").val();


        $("#search_button").html('<i class="fas fa-spinner fa-pulse"></i>')
        setTimeout(function() {
            filterData(inquiry_source, sales_person, date_from, date_to);
        }, 2000);


    });
});

function filterData(inquiry_source, sales_person, date_from, date_to) {
    $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        "buttons": [{
                className: 'btn btn-success btn-sm',
                text: '<i class="fas fa-file-excel mr-2"></i> Excel',
                action: function(e, dt, node, config) {
                    exportExcel()
                }
            },
            {
                className: 'btn btn-danger btn-sm',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                action: function(e, dt, node, config) {
                    exportPDF();
                }
            }
            // 'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/cancelappointmentreportlist.php",
            type: "POST", // you can use GET
            "data": function(d) {
                return $.extend({}, d, {
                    "company_branch_id": '<?php echo ($_SESSION['branch_id']); ?>',
                    "search_inquiry": inquiry_source,
                    "search_sales_person": sales_person,
                    "search_from_date": date_from,
                    "search_to_date": date_to
                });
            }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "inquiry_number"
            },
            {
                "data": "inquerydate"
            },
            {
                "data": "inquiry_source_name"
            },
            {
                "data": "customer_name"
            },
            {
                "data": "customer_number"
            },
            {
                "data": "customer_number2"
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
            // {
            //     "data": "year_name"
            // },
            {
                "data": "sales_person_name"
            },
            {
                "data": "coordinator_name"
            },
            // {
            //     "targets": -1,
            //     "className": '',
            //     "data": null,
            //     "render": function(data, type, full) {
            //         if (full['appointment'] == 1) {
            //             return '<i class="fas fa-check text-success mr-2"></i>Confirm Appointment';
            //         } else {
            //             return '<i class="fa fa-times text-danger mr-2"></i>Not Confirm Appointment';
            //         }
            //     }
            // },
            {
                "data": "appointmentdate",
                "render": function(data, type, full) {
                    if (full['appointment'] == 1) {
                        return data; // Show the appointment date if appointment is confirmed
                    } else {
                        return ''; // Or return empty if not confirmed
                    }
                }
            },
            // {
            //     "targets": -1,
            //     "className": '',
            //     "data": null,
            //     "render": function(data, type, full) {
            //         if (full['imageDelivery'] == 1) {
            //             return '<i class="fas fa-check text-success mr-2"></i>Sent';
            //         } else {
            //             return '<i class="fa fa-times text-danger mr-2"></i>Not Sent';
            //         }
            //     }
            // }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
            $("#search_button").html('Search')
        }
    });
}

function exportPDF() {
    const {
        jsPDF
    } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'landscape',
        unit: 'pt',
        format: 'A4'
    });

    doc.addFont("<?php echo base_url() ?>assets/fonts/roboto/Roboto-Regular.ttf", "Roboto", "normal");
    doc.addFont("<?php echo base_url() ?>assets/fonts/roboto/Roboto-Bold.ttf", "Roboto", "bold");

    doc.setFont("Roboto", "normal");

    const columnMapping = {
        0: 'inquiry_number',
        1: 'inquerydate',
        2: 'inquiry_source_name',
        3: 'customer_name',
        4: 'customer_number',
        5: 'customer_number2',
        6: 'vehicle_number',
        7: 'brand_name',
        8: 'model_name',
        9: 'sales_person_name',
        10: 'coordinator_name',
        11: 'appointmentdate'
    };

    var selectedCount = 0;

    function countSelectedColumns() {
        const selectedCount = $('.export-column:checked').length;
        return selectedCount;
    }


    const selectedColumns = $('.export-column:checked').map(function() {
        selectedCount = countSelectedColumns()
        return parseInt($(this).val());
    }).get();


    const headers = selectedColumns.map(index => {
        return $('#columnSelector label input[value="' + index + '"]').parent().text().trim();
    });


    const bodyData = $('#dataTable').DataTable().rows({
        filter: 'applied'
    }).data().toArray().map(row => {
        return selectedColumns.map(colIdx => row[columnMapping[colIdx]]);
    });


    if (bodyData.length === 0) {
        console.warn('No data found for selected columns.');
        alert('No data found for selected columns. Please check your DataTable.');
        return;
    }

    const columnStyles = {};
    if (selectedCount === 12) {
        columnStyles[2] = {
            cellWidth: 100
        };
        columnStyles[3] = {
            cellWidth: 70
        };
        // Add other styles if necessary
    }

    // Exporting the HTML table to PDF
    doc.autoTable({
        // html: '#dataTable',
        head: [headers],
        body: bodyData,
        theme: 'striped',
        styles: {
            fontSize: 8,
            lineWidth: 0.1,
            textColor: [0, 0, 0],
            lineColor: [0, 0, 0],
            cellWidth: 'wrap',
            overflow: 'linebreak',
            font: "Roboto",
            fontStyle: "normal"
        },
        headStyles: {
            fillColor: false,
            textColor: [0, 0, 0],
            fontStyle: 'bold',
            lineWidth: 0.1,
            lineColor: [0, 0, 0],
            font: "Roboto",
            fontStyle: 'bold',
        },
        columnStyles: columnStyles,
        margin: {
            top: 40,
            left: 20,
        },
        didDrawPage: function(data) {
            doc.setFont("Roboto", "bold");
            doc.text('Cancel Appointment Report Information', doc.internal.pageSize.getWidth() / 2, 30, {
                align: 'center'
            });
            doc.setFont("Roboto", "normal");
        }
    });

    doc.save('Cancel Appointment Report Information.pdf');
}

function exportExcel() {
    const columnMapping = {
        0: 'inquiry_number',
        1: 'inquerydate',
        2: 'inquiry_source_name',
        3: 'customer_name',
        4: 'customer_number',
        5: 'customer_number2',
        6: 'vehicle_number',
        7: 'brand_name',
        8: 'model_name',
        9: 'sales_person_name',
        10: 'coordinator_name',
        11: 'appointmentdate'
    };

    const selectedColumns = $('.export-column:checked').map(function() {
        return parseInt($(this).val());
    }).get();

    const headers = selectedColumns.map(index => {
        return $('#columnSelector label input[value="' + index + '"]').parent().text().trim();
    });

    const bodyData = $('#dataTable').DataTable().rows({
        filter: 'applied'
    }).data().toArray().map(row => {
        return selectedColumns.map(colIdx => row[columnMapping[colIdx]]);
    });

    if (bodyData.length === 0) {
        console.warn('No data found for selected columns.');
        alert('No data found for selected columns. Please check your DataTable.');
        return;
    }

    // Prepare data for Excel
    const excelData = [headers, ...bodyData];

    // Exporting data to Excel
    const ws = XLSX.utils.aoa_to_sheet(excelData);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Report');

    XLSX.writeFile(wb, 'Cancel Appointment_Report_Information.xlsx');
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
<?php include "include/footer.php"; ?>