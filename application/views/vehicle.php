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
						<h1 class="page-header-title font-weight-light">
							<div class="page-header-icon"><i class="fas fa-car"></i></div>
							<span><b>Vehicle</b></span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">

						<form action="<?php echo base_url() ?>Vehicle/Vehicleinsertupdate" method="post"
							autocomplete="off">
							<div class="row">
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Vehicle Reg NO*</label>
										<input type="text" class="form-control form-control-sm" name="vehicleregno"
											id="vehicleregno" required>
									</div>
								</div>
								<div class=" col-3 form-group">
									<label class="small font-weight-bold">Vehicle Type*</label>
									<select class="form-control form-control-sm" name="vehicletype" id="vehicletype"
										required>
										<option value="">Select</option>
										<?php foreach ($Vehicletype->result() as $rowvehicletype) { ?>
										<option value="<?php echo $rowvehicletype->idtbl_vehicle_type  ?>">
											<?php echo $rowvehicletype->vehicle_type ?></option>
										<?php } ?>
									</select>
								</div>
								<div class=" col-3 ">
									<label class="small font-weight-bold">Vehicle Brand*</label>
									<select class="form-control form-control-sm" name="vehiclebrand" id="vehiclebrand"
										required>
										<option value="">Select</option>
										<?php foreach ($Vehiclebrand->result() as $rowvehiclebrand) { ?>
										<option value="<?php echo $rowvehiclebrand->idtbl_vehicle_brand   ?>">
											<?php echo $rowvehiclebrand->vehicle_brand ?></option>
										<?php } ?>
									</select>
								</div>
								<div class=" col-3 ">
									<label class="small font-weight-bold">Vehicle Model*</label>
									<select class="form-control form-control-sm" name="vehiclemodel" id="vehiclemodel"
										required>
										<option value="">Select</option>
										<?php foreach ($Vehiclemodel->result() as $rowvehiclemodel) { ?>
										<option value="<?php echo $rowvehiclemodel->idtbl_vehicle_model    ?>">
											<?php echo $rowvehiclemodel->vehicle_model ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Engine No*</label>
										<input type="text" class="form-control form-control-sm" name="engineno"
											id="engineno" required>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Chassis No*</label>
										<input type="text" class="form-control form-control-sm" name="chassisno"
											id="chassisno" required>
									</div>
								</div>

								<div class="col-3">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Current Mileage (Km)*</label>
										<input type="text" class="form-control form-control-sm" name="mileage"
											id="mileage" required>
									</div>
								</div>

								<div class="col-1">
									<div class="form-group mt-2 text-right" style="padding-top: 25px;">
										<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
											<?php if($addcheck==0){echo 'disabled';} ?>><i
												class="far fa-save"></i>&nbsp;Add</button>
									</div>
								</div>
							</div>

							<input type="hidden" name="recordOption" id="recordOption" value="1">
							<input type="hidden" name="recordID" id="recordID" value="">
						</form>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
										<thead>
											<tr>
												<th>#</th>
												<th>vehicle Reg NO</th>
												<th>Vehicle Type</th>
												<th>Vehicle Brand</th>
												<th>Vehicle Model</th>
												<th>Engine No</th>
												<th>Chassis No</th>
												<th>Current Mileage (Km)</th>
												<th>Next Renew Date</th>
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
	$(document).ready(function () {
		var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

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
					extend: 'csv',
					className: 'btn btn-success btn-sm',
					title: 'Vehicle  Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Vehicle  Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Vehicle  Information',
					className: 'btn btn-primary btn-sm',
					text: '<i class="fas fa-print mr-2"></i> Print',
					customize: function (win) {
						$(win.document.body).find('table')
							.addClass('compact')
							.css('font-size', 'inherit');
					},
				},
				// 'copy', 'csv', 'excel', 'pdf', 'print'
			],

			ajax: {
				url: "<?php echo base_url() ?>scripts/vehiclelist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"createdRow": function (row, data, dataIndex) {
				var checkdate = data['next_renew_date'];
				if (checkdate !== null) {
					var vals = data['next_renew_date'].split('-');

					var y = vals[0];
					var m = vals[1];
					var d = vals[2];

					var year = parseInt(y)
					var month = m - 1
					var date = parseInt(d)

					currentdate = new Date();
					currentyear = currentdate.getFullYear();
					currentmonth = currentdate.getMonth() + 1;
					currentday = currentdate.getDate();
					// console.log(currentyear,currentmonth,currentday,month,date)
					if (currentmonth >= month && date <= currentday && year == currentyear) {
						$(row).addClass('bg-pink text-white');
					}

				}


			},
			"columns": [

				{
					"data": "idtbl_vehicle"
				},
				{
					"data": "vehicle_reg_no"
				},
				{
					"data": "vehicle_type"
				},
				{
					"data": "vehicle_brand"
				},
				{
					"data": "vehicle_model"
				},
				{
					"data": "engine_no"
				},
				{
					"data": "chassis_no"
				},
				{
					"data": "mileage"
				},
				{
					"data": "next_renew_date"

				},
				// {
				//         "targets": -1,
				//         "className": 'text-left',
				//         "data": "next_renew_date ",
				//         "render": function (data, type, full) {
				//             var label = '';

				//             if (full['next_renew_date'] == "") {
				//                 label += '<label >Retail Sale</label>';
				//             } else {
				//                 label += '<label >Whole Sale</label>';
				//             }
				//             return label;
				//         }

				//     },
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<a href="<?php echo base_url() ?>Renewdetails/index/' + full[
								'idtbl_vehicle'] +
							'" target="_self" class="btn btn-secondary btn-sm mr-1"><i class="fas fa-file"></i></a>';

						button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '" id="' + full['idtbl_vehicle'] +
							'"><i class="fas fa-pen"></i></button>';
						if (full['status'] == 1) {
							button += '<a href="<?php echo base_url() ?>Vehicle/Vehiclestatus/' +
								full['idtbl_vehicle'] +
								'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></a>';
						} else {
							button += '<a href="<?php echo base_url() ?>Vehicle/Vehiclestatus/' +
								full['idtbl_vehicle'] +
								'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}
						button += '<a href="<?php echo base_url() ?>Vehicle/Vehiclestatus/' + full[
								'idtbl_vehicle'] +
							'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';
						if (deletecheck != 1) {
							button += 'd-none';
						}
						button += '"><i class="fas fa-trash-alt"></i></a>';

						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});
		$('#dataTable tbody').on('click', '.btnEdit', function () {
			var r = confirm("Are you sure, You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Vehicle/Vehicleedit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						$('#recordID').val(obj.id);
						$('#vehicleregno').val(obj.vehicleregno);
						$('#vehicletype').val(obj.vehicletype);
						$('#vehiclebrand').val(obj.vehiclebrand);
						$('#vehiclemodel').val(obj.vehiclemodel);
						$('#engineno').val(obj.engineno);
						$('#chassisno').val(obj.chassisno);
						$('#mileage').val(obj.mileage);


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