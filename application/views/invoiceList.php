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
        					<div class="page-header-icon"><i class="fas fa-align-left"></i></div>
        					<span>Invoice List</span>
        				</h1>
        			</div>
        		</div>
        	</div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-end">
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary btn-sm px-4 mt-auto p-2 <?php if($addcheck==0){echo 'd-none';} ?>" data-toggle="modal" data-target="#invoiceTypeModal">
                                    <i class="fas fa-plus mr-3"></i>Create New Invoice
                                </button>
                                <!-- <a href="<?= base_url('Invoice/invoiceDetailIndex') ?>" 
                                class="btn btn-primary btn-sm px-4 mt-auto p-2 <?php if($addcheck==0){echo 'd-none';} ?>">
                                <i class="fas fa-plus mr-3"></i>Create New Invoice
                                </a> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
        								<thead>
        									<tr>
                                                <th>#</th>
                                                <th>Invoice No</th>
                                                <th>Customer Name</th>
                                                <th>Invoice Date</th>
                                                <th>Status</th>
                                                <th>Amount</th>
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

        
        <!-- Invoice Type Modal -->
        <div class="modal fade" id="invoiceTypeModal" tabindex="-1" aria-labelledby="invoiceTypeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h5 class="modal-title" id="invoiceTypeModalLabel">Invoice Type</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body text-center">
                        <button type="button" class="btn btn-primary btn-sm mb-2 w-100" id="direct" onclick="selectInvoiceType('direct');">
                            Direct Invoice
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm w-100" id="indirect" onclick="selectInvoiceType('indirect');">
                            Job Card Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    var addcheck='<?php echo $addcheck; ?>';
    var editcheck='<?php echo $editcheck; ?>';
    var statuscheck='<?php echo $statuscheck; ?>';
    var deletecheck='<?php echo $deletecheck; ?>';

    $(document).ready(function() {
      var base_url = "<?php echo base_url(); ?>";

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Invoice List', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Invoice List', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Invoice List',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
            ],
            ajax: {
                url: apiBaseUrl+'/v1/invoice', 
                type: "GET",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + api_token 
                }, 
                dataSrc: function (json) {
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
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "id"
                },
                {
                    "data": "invoice_number"
                },
                 {
                    "data": "customer_name"
                },
                 {
                    "data": "invoice_date"
                },
                 {
                    "data": "inv_status_text"
                },
                 {
                    "data": "inv_grand_total"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button += '<a href="' + base_url + 'JobCard/jobCardDetailIndex/' + full['idtbl_jobcard'] + '" title="View" class="btn btn-secondary btn-sm btnView mr-1">' +
                        '<i class="fas fa-external-link-alt"></i></a>';
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

    });

    function selectInvoiceType(type) {
        const baseUrl = "<?= base_url('Invoice/invoiceDetailIndex/') ?>";
        window.location.href = baseUrl + type;
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
