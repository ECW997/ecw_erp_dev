<div class="modal fade" id="addJobItemModal" tabindex="-1" aria-labelledby="addJobItemModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="addJobItemModalLabel">
                    Add Job Item to <span id="jobNameLabel"></span>
                </h5>
				<button type="button" class="btn-close btn-close-white addJobItemCloseBtn"
					aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row d-flex align-items-center">
					<div class="col-12 col-md-4 mb-2 mb-md-0">
						<h2>Job Card</h2>
					</div>
					<div class="col-12 col-md-3 d-flex align-items-center mb-2 mb-md-0">
						<h6 class="col-form-label me-2 text-nowrap">P.C.</h6>
						<select class="form-select form-select-sm" id="item_pc_category" name="item_pc_category">
							<option value="">Select</option>
							<option value="1">One</option>
							<option value="2">Two</option>
							<option value="3">Three</option>
						</select>
					</div>
					<div class="col-12 col-md-3 d-flex justify-content-md-end align-items-center mb-2 mb-md-0">
						<h6 class="col-form-label me-2 text-nowrap">Discount %</h6>
						<input class="form-control form-control-sm" type="number" step="any" id="item_discount"
							name="item_discount">
					</div>
					<div class="col-12 col-md-2 d-flex justify-content-md-end align-items-center">
						<h2 class="me-2 text-nowrap">Total:</h2>
						<h2 id="item_total_net_price" class="me-2 text-nowrap">0</h2>
					</div>
				</div>
				<hr>
				<form action="" id="jobCardForm">
					<div class="mb-3">
						<p class="mb-0">
							<a class="jobSubItem text-info" data-toggle="collapse" href="#collapseExample1" role="button"
								aria-expanded="false" aria-controls="collapseExample1">
								<i class="fas fa-caret-right text-dark"></i>
								Door Board Top
							</a>
						</p>
						<div class="collapse" id="collapseExample1">
							<div class="card card-body">
								<div class="row">
									<div class="col-6">
										<div class="row">
											<div class="col-6">
												<h6 class="col-form-label me-2 text-nowrap">Material</h6>
												<select class="form-select form-select-sm" id="pc_category" name="pc_category">
													<option value="">Select</option>
													<option value="1">One</option>
													<option value="2">Two</option>
													<option value="3">Three</option>
												</select>
											</div>
											<div class="col-6">
												<h6 class="col-form-label me-2 text-nowrap">Colour</h6>
												<select class="form-select form-select-sm" id="pc_category" name="pc_category">
													<option value="">Select</option>
													<option value="1">One</option>
													<option value="2">Two</option>
													<option value="3">Three</option>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-6">
												<h6 class="col-form-label me-2 text-nowrap">Painting</h6>
												<select class="form-select form-select-sm" id="pc_category" name="pc_category">
													<option value="">Select</option>
													<option value="1">Yes</option>
													<option value="2">No</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-6">
										<div class="row justify-content-end">
											<div class="col-4">
												<h6 class="col-form-label me-2 text-nowrap">Price</h6>
												<input class="form-control form-control-sm text-end" type="number" step="any"
													id="item_price" name="item_price">
											</div>
											<div class="col-3">
												<h6 class="col-form-label me-2 text-nowrap">QTY</h6>
												<input class="form-control form-control-sm text-end" type="number" step="any"
													id="item_qty" name="item_qty">
											</div>
											<div class="col-4">
												<h6 class="col-form-label me-2 text-nowrap">Net Price</h6>
												<input class="form-control form-control-sm text-end" type="number" step="any"
													id="item_net_price" name="item_net_price">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="mb-3">
						<p class="mb-0">
							<a class="jobSubItem text-info" data-toggle="collapse" href="#collapseExample2" role="button"
								aria-expanded="false" aria-controls="collapseExample2">
								<i class="fas fa-caret-right text-dark"></i>
								Door Arm
							</a>
						</p>
						<div class="collapse" id="collapseExample2">
							<div class="card card-body">
								Some placeholder content for the collapse component. This panel is hidden by default but revealed when
								the
								user activates the relevant trigger.
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="addToJobCardBtn" class="btn btn-info">Add to Job Card<i
						class="fas fa-plus-circle ml-2"></i></i></button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addItemCloseConfirmModal" tabindex="-1" aria-labelledby="addItemCloseConfirmModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-confirmation">
            <div class="modal-header delete-header">
                <h5 class="delete-title" id="addItemCloseConfirmModalLabel">Unsaved Changes</h5>
                <button type="button" class="btn-close delete-btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-question-circle delete-warning-icon"></i>
                <p class="mb-0">Are you sure you want to close this modal?<br>Any unsaved data will be lost.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary delete-btn-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary delete-btn-confirm" onclick="confirmCloseBtn()">
                    <i class="fas fa-arrow-right me-2"></i>Yes, Close Without Saving
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let isUnsaved = false;

$(document).on('change', '#jobCardForm input, #jobCardForm select', function() {
    isUnsaved = true;
});

$(document).on('click', '.addJobItemCloseBtn', function(e) {
    var item_total_net_price = parseFloat($('#item_total_net_price').text().replace(/,/g, ''));

    if (item_total_net_price > 0 && isUnsaved) {
        e.preventDefault();
        $('#addItemCloseConfirmModal').modal('show');
    } else {
        $('#addJobItemModal').modal('hide');
        reSetContent('#jobCardForm');
    }
});


$(document).ready(function() {

    let price_category = $('#price_category');

    price_category.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>JobCard/getPriceCategory',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                }
            },
            cache: true,
            processResults: function(data) {
                if (data.status == true) {
                    return {
                        results: data.data.item,
                        pagination: {
                            more: data.data.item.length > 0
                        }
                    }
                } else {
                    falseResponse(data);
                }
            }
        }
    });
});

function confirmCloseBtn() {
    isUnsaved = false;
    $('#addItemCloseConfirmModal').modal('hide');

    setTimeout(() => {
        $('#addJobItemModal').modal('hide');
        $('.modal-backdrop').remove();
        reSetContent('#jobCardForm');
    }, 500);
}

function reSetContent(target) {
    $('#item_pc_category').val('');
    $('#item_discount').val(0);
    $('#item_total_net_price').text('0');

    const $el = $(target);
    $el.find('input, textarea, select').val('');
    $el.find('input[type="checkbox"], input[type="radio"]').prop('checked', false);
    $el.find('.collapse.show').collapse('hide');

    var icon = $el.find('svg');
    icon.css('transform', '');

    isUnsaved = false;
}
</script>