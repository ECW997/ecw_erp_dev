<div class="modal fade" id="selectCustomerInquiryModal" tabindex="-1" aria-labelledby="selectCustomerInquiryModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="selectCustomerInquiryModalLabel">New Job Card - Select Customer Inquiry</h5>
        <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<div class="col-12">
      		<div class="scrollbar pb-3" id="style-2">
      			<table class="table table-bordered table-striped table-sm nowrap w-100" id="inquiryListDataTable">
      				<thead>
      					<tr>
      						<th>Customer</th>
      						<th>Sales Rep</th>
      						<th>Inquiry Number</th>
      						<th>Vehicle</th>
      						<th class="text-center">Action</th>
      					</tr>
      				</thead>
      			</table>
      		</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" id="inqNextBtn" class="btn btn-primary">Next<i class="fas fa-arrow-circle-right ml-2"></i></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="inqSelectConfirmModal" tabindex="-1" aria-labelledby="inqSelectConfirmModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content next-step-confirmation">
            <div class="modal-header next-step-header">
                <h5 class="next-step-title" id="inqSelectConfirmModalLabel">Proceed to Next Step</h5>
                <button type="button" class="btn-close next-step-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-question-circle next-step-icon"></i>
                <p class="mb-0">Are you sure you want to proceed to the next step?<br>This action will move you forward in the process.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary next-step-btn-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary next-step-btn-confirm" onclick="confirmNextStep()">
                    <i class="fas fa-arrow-right me-2"></i>Proceed
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let company_id = "<?php echo ucfirst($_SESSION['company_id']); ?>";
let branch_id = "<?php echo ucfirst($_SESSION['branch_id']); ?>";

$(document).ready(function () {
	$('#inquiryListDataTable').DataTable({
		"destroy": true,
		"processing": true,
		"serverSide": true,
		dom: "<<'col-sm-12'f>>" + "<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
		responsive: true,
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 25, 50, 'All'],
		],
		ajax: {
			url: apiBaseUrl + '/v1/customer_inquiry_list',
			type: "GET",
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + api_token
			},
			data: function(d) {
                    d.company_id = company_id;
                    d.branch_id = branch_id;
            },
			dataSrc: function (json) {
				if (json.status === false && json.code === 401) {
					falseResponse(errorObj);
				} else {
					return json.data;
				}
			},
			error: function (xhr, status, error) {
				if (xhr.status === 401) {
					falseResponse(errorObj);
				}
			}
		},
		"order": [
			[0, "desc"]
		],
		"columns": [{
				"data": "customer_name"
			},
			{
				"data": "sales_person_name"
			},
			{
				"data": "inquiry_number"
			},
			{
				"data": "vehicle_number"
			},
			{
				"targets": -1,
				"className": 'text-center',
				"data": null,
				"render": function (data, type, full) {
					var input = '';
					input += '<input class="form-check-input form-check-input-width form-check-lg border border-2 border-primary shadow-lg" type="radio" name="ch_inquiry" id="'+full['idtbl_customer_inquiry']+'" value="'+full['idtbl_customer_inquiry']+'">';

					return input;
				}
			}
		],
		drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
});

var customer_inq_id=0;
$(document).on('click','#inqNextBtn', function(){
  var selectedId = $("input[name='ch_inquiry']:checked").val();
  if (!selectedId) {
    error_toastify("⚠️ Please select an inquiry before proceeding.");
  } else {
    $('#inqSelectConfirmModal').modal('show');
	customer_inq_id = selectedId;
  }
})

function confirmNextStep(){
	getCustomerDetails();
}

function getCustomerDetails() {
	$.ajax({
		type: "GET",
		dataType: 'json',
		url: '<?php echo base_url() ?>JobCard/getCustomerDetails/' + customer_inq_id,
		success: function (result) {
			if (result.status) {
				
				customerData.name = result.data.customer_name;
				customerData.email = result.data.email;
				customerData.address1 = result.data.address;
				customerData.address2 = result.data.address_2;
				customerData.city = result.data.city;
				customerData.district = result.data.district;
				customerData.nic = result.data.nic;
				customerData.contact = result.data.customer_number;
				customerData.contact2 = result.data.customer_number2;
				customerData.dob = result.data.dob;
				customerData.inquiry_date = result.data.inquerydate;
				customerData.inquiry_id = result.data.idtbl_customer_inquiry;
				customerData.inquiry_no = result.data.inquiry_number;
				customerData.vehicle_brand = result.data.brand_name;
				customerData.vehicle_brand_id = result.data.idtbl_vehicle_brand;
				customerData.vehicle_gen = result.data.generation_name;
				customerData.vehicle_gen_id = result.data.idtbl_vehicle_generation;
				customerData.vehicle_model = result.data.model_name;
				customerData.vehicle_model_id = result.data.idtbl_vehicle_model;
				customerData.vehicle_no = result.data.vehicle_number;
				customerData.vehicle_type = result.data.vehicle_type_name;
				customerData.vehicle_type_id = result.data.idtbl_vehicle_type;
				customerData.vehicle_year = result.data.year_name;
				customerData.vehicle_year_id = result.data.idtbl_vehicle_year;
				customerData.price_category = result.data.customer_name;
				customerData.sales_person_name = result.data.sales_person_name;
				customerData.sales_person_id = result.data.idtbl_sales_person;

				$('#cus_name').val(customerData.name);
				$('#contact_no').val(customerData.contact);
				$('#address1').val(customerData.address1);
				$('#address2').val(customerData.address2);
				$('#nic_number').val(customerData.nic);
				$('#email').val(customerData.email);

				$('#inqSelectConfirmModal').modal('hide');
				$('#selectCustomerInquiryModal').modal('hide');
				$('.modal-backdrop').remove();
				$('#jobHeaderModal').modal('show');
			} else {
				falseResponse(result);
			}
		}
	});
}

</script>