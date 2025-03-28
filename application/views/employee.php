<?php 

$addcheck = 1;
$editcheck = 1;
$statuscheck = 1;
$deletecheck = 1;

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
        				<h1 class="page-header-title ">
        					<div class="page-header-icon"><i data-feather="users"></i></div>
        					<span>Employee</span>
        				</h1>
        			</div>
        		</div>
        	</div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <form action="<?php echo base_url() ?>Employee/Employeeinsertupdate" method="post"
        							autocomplete="off" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Emp No*</label>
                                            <input type="text" class="form-control form-control-sm" name="emp_no"
                                                id="emp_no" required>
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Name with Initials*</label>
                                            <input type="text" class="form-control form-control-sm" name="name_with_initials"
                                                id="name_with_initials" required>
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Calling Name*</label>
                                            <input type="text" class="form-control form-control-sm" name="calling_name"
                                                id="calling_name" required>
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Address</label>
                                            <textarea class="form-control form-control-sm" name="address" id="address"></textarea>
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">DOB*</label>
                                            <input type="date" class="form-control form-control-sm" name="dob"
                                                id="dob" >
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Gender*</label>
                                            <select class="form-control form-control-sm selecter2 px-0" name="gender" id="gender" required>
                                                <option value="">Select</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>  
                                    </div>
                                    <div class="row">     
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Contact No*</label>
                                            <input type="text" class="form-control form-control-sm" name="contact_no"
                                                id="contact_no" required>
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Email</label>
                                            <input type="email" class="form-control form-control-sm" name="email"
                                                id="email">
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">NIC No*</label>
                                            <input type="text" class="form-control form-control-sm" name="nic"
                                                id="nic">
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Department*</label>
                                            <select class="form-control form-control-sm selecter2 px-0" name="department" id="department" required>
                                                <option value="">Select</option>
                                                <?php foreach($departmentlist->result() as $rowdepartmentlist){ ?>
                                                <option value="<?php echo $rowdepartmentlist->id ?>">
                                                    <?php echo $rowdepartmentlist->department_name ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Job Title*</label>
                                            <select class="form-control form-control-sm selecter2 px-0" name="jobtitle" id="jobtitle" required>
                                                <option value="">Select</option>
                                                <?php foreach($jobtitlelist->result() as $rowjobtitlelist){ ?>
                                                <option value="<?php echo $rowjobtitlelist->id ?>">
                                                    <?php echo $rowjobtitlelist->jobtitle ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Image</label>
                                            <input type="file" class="form-control form-control-sm" name="profileimage"
                                                id="profileimage">
                                        </div>
                                    </div>
                                    
        							<div class="form-group mt-3 text-right">
        								<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
        									<?php if($addcheck==0){echo 'disabled';} ?>><i
        										class="far fa-save"></i>&nbsp;Add</button>
        							</div>
        							<input type="hidden" name="recordOption" id="recordOption" value="1">
        							<input type="hidden" name="recordID" id="recordID" value="">
        						</form>
                            </div>
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
        								<thead>
        									<tr>
        										<th>#</th>
        										<th>Emp NO</th>
        										<th>Name with Initials</th>
                                                <th>Calling Name</th>
        										<th>Department</th>
                                                <th>Job Title</th>
                                                <th>Contact No</th>
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
        <div class="modal fade" id="employeeModalCenter" tabindex="-1" role="dialog" aria-labelledby="employeeModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeModalLongTitle">Employee Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body text-center pb-5">
                        <div class="profile-image-container mb-4" id="view_employee_profile"></div>
                        <div class="department-info mb-4 text-left">
                            <div class="row">
                                <div class="col-6">
                                <p class="mb-2"><strong>Emp No : </strong></p>
                                <p class="mb-2"><strong>Name with Initials : </strong></p>
                                <p class="mb-2"><strong>Calling Name : </strong></p>
                                <p class="mb-2"><strong>Address : </strong></p>
                                <p class="mb-2"><strong>DOB : </strong></p>
                                <p class="mb-2"><strong>Gender : </strong></p>
                                <p class="mb-2"><strong>Contact No : </strong></p>
                                <p class="mb-2"><strong>Email : </strong></p>
                                <p class="mb-2"><strong>NIC No : </strong></p>
                                <p class="mb-2"><strong>Department : </strong></p>
                                <p class="mb-2"><strong>Job Title : </strong></p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-2"><span id="view_empno"></span></p>
                                    <p class="mb-2"><span id="view_name_with_initial"></span></p>
                                    <p class="mb-2"><span id="view_calling_name"></span></p>
                                    <p class="mb-2"><span id="view_address"></span></p>
                                    <p class="mb-2"><span id="view_dob"></span></p>
                                    <p class="mb-2"><span id="view_gender"></span></p>
                                    <p class="mb-2"><span id="view_contactno"></span></p>
                                    <p class="mb-2"><span id="view_email"></span></p>
                                    <p class="mb-2"><span id="view_nic"></span></p>
                                    <p class="mb-2"><span id="view_department"></span></p>
                                    <p class="mb-2"><span id="view_jobtitle"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

        $('#department').select2({
            width: '100%',
        });
        $('#jobtitle').select2({
            width: '100%',
        });

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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Employee Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Employee Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Employee Information',
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
                url: "<?php echo base_url() ?>scripts/employeelist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "id"
                },
                {
                    "data": "service_no"
                },
                {
                    "data": "emp_name_with_initial"
                },
                {
                    "data":"calling_name"
                },
                {
                    "data":"department_name"
                },
                {
                    "data":"jobtitle"
                },
                {
                    "data":"emp_mobile"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button title="View All Details" class="btn btn-secondary btn-sm btnView mr-1" id="'+full['id']+'"><i class="fas fa-eye"></i></button>';
                        button+='<button title="Edit" class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['id']+'"><i class="fas fa-pen"></i></button>';
                      
                        button+='<a title="Delete" href="<?php echo base_url() ?>Employee/Employeestatus/'+full['id']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';
                        
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
                    url: '<?php echo base_url() ?>Employee/Employeeedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#emp_no').val(obj.service_no);                                            
                        $('#name_with_initials').val(obj.emp_name_with_initial);      
                        $('#calling_name').val(obj.calling_name);  
                        $('#address').val(obj.emp_address);  
                        $('#nic').val(obj.emp_national_id);  
                        $('#gender').val(obj.emp_gender);  
                        $('#dob').val(obj.emp_birthday);  
                        $('#email').val(obj.emp_email);  
                        $('#department').val(obj.emp_department).trigger('change');  
                        $('#jobtitle').val(obj.job_title_id).trigger('change'); 
                        $('#contact_no').val(obj.emp_mobile);                                                  
                            
                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });

        $('#dataTable tbody').on('click', '.btnView', function() {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Employee/Employeeedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#view_empno').text(obj.service_no);                                            
                        $('#view_name_with_initial').text(obj.emp_name_with_initial);      
                        $('#view_calling_name').text(obj.calling_name);  
                        $('#view_address').text(obj.emp_address);  
                        $('#view_nic').text(obj.emp_national_id);  
                        $('#view_gender').text(obj.emp_gender);  
                        $('#view_dob').text(obj.emp_birthday);  
                        $('#view_email').text(obj.emp_email);  
                        $('#view_department').text(obj.department_name);  
                        $('#view_jobtitle').text(obj.jobtitle); 
                        $('#view_contactno').text(obj.emp_mobile); 
                        if(obj.profile_pic_path){
                            $('#view_employee_profile').html('<img style="" src="<?php echo base_url() ?>images/Employee_Profile/'+obj.profile_pic_path+'" alt="Employee Profile Picture" class="profile-image">'); 
                        }else{
                            $('#view_employee_profile').html('<img style="" src="<?php echo base_url() ?>images/user.jpg" alt="Employee Profile Picture" class="profile-image">'); 
                        }
                       
                        
                        $('#employeeModalCenter').modal('show');
                    }
                });

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
