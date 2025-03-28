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
        					<div class="page-header-icon"><i class="fas fa-th"></i></div>
        					<span>Job Title</span>
        				</h1>
        			</div>
        		</div>
        	</div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                            <form action="<?php echo base_url() ?>Jobtitle/Jobtitleinsertupdate" method="post"
        							autocomplete="off">
                                    <div class="form-group mb-1">
        								<label class="small font-weight-bold">Job Title*</label>
        								<input type="text" class="form-control form-control-sm" name="jobtitle"
        									id="jobtitle" required>
        							</div>
                                   
        							<div class="form-group mt-2 text-right">
        								<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
        									<?php if($addcheck==0){echo 'disabled';} ?>><i
        										class="far fa-save"></i>&nbsp;Add</button>
        							</div>
        							<input type="hidden" name="recordOption" id="recordOption" value="1">
        							<input type="hidden" name="recordID" id="recordID" value="">
        						</form>
                            </div>
                            <div class="col-9">
                                <div class="scrollbar pb-3" id="style-2">
                                <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
        								<thead>
        									<tr>
        										<th>#</th>
        										<th>Job Title</th>
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
<script>
    $(document).ready(function() {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Job Title Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Job Title Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Job Title Information',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/jobtitlelist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "id"
                },
                {
                    "data": "jobtitle"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button title="Edit" class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['id']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a title="Deactive" href="<?php echo base_url() ?>Jobtitle/Jobtitlestatus/'+full['id']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a title="Active" href="<?php echo base_url() ?>Jobtitle/Jobtitlestatus/'+full['id']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a title="Delete" href="<?php echo base_url() ?>Jobtitle/Jobtitlestatus/'+full['id']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTable tbody').on('click', '.btnEdit', function() {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Jobtitle/Jobtitleedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#jobtitle').val(obj.jobtitle);                                             
    
                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });
    });

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
