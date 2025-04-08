<?php if ($data['status']): ?>
    <?php if (!empty($data['data'])): ?>
        <?php foreach ($data['data'] as $subJob): ?>
            <div class="mb-3">
                <p class="mb-0">
                    <a class="jobSubItem text-info" data-toggle="collapse" href="#collapse<?php echo  $subJob['sub_job_category']['idtbl_sub_job_category'] ?>"
                        role="button" aria-expanded="false" aria-controls="collapse<?php echo  $subJob['sub_job_category']['idtbl_sub_job_category'] ?>">
                        <i class="fas fa-caret-right text-dark"></i>
                        <?php echo  $subJob['sub_job_category']['sub_job_category'] ?> 
                    </a>
                </p>
                <div class="collapse" id="collapse<?php echo  $subJob['sub_job_category']['idtbl_sub_job_category'] ?>">
                	<div class="card card-body">
                        <?php foreach ($subJob['job_options'] as $jobOptionGroup): ?>
                            <div class="mb-3 p- border border-1">
                            	<h6 class="text-secondary"><?php echo $jobOptionGroup['job_option_group']['GroupName']; ?></h6>
                            	<div class="row">
                            		<div class="col-6">
                            			<div class="row">
                            				<div class="col-6">
                            					<h6 class="col-form-label me-2 text-nowrap">Material</h6>
                            					<select class="form-select form-select-sm" id="pc_category"
                            						name="pc_category">
                            						<option value="">Select</option>
                            						<option value="1">One</option>
                            						<option value="2">Two</option>
                            						<option value="3">Three</option>
                            					</select>
                            				</div>
                            				<div class="col-6">
                            					<h6 class="col-form-label me-2 text-nowrap">Colour</h6>
                            					<select class="form-select form-select-sm" id="pc_category"
                            						name="pc_category">
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
                            					<select class="form-select form-select-sm" id="pc_category"
                            						name="pc_category">
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
                            					<input class="form-control form-control-sm text-end" type="number"
                            						step="any" id="item_price" name="item_price">
                            				</div>
                            				<div class="col-3">
                            					<h6 class="col-form-label me-2 text-nowrap">QTY</h6>
                            					<input class="form-control form-control-sm text-end" type="number"
                            						step="any" id="item_qty" name="item_qty">
                            				</div>
                            				<div class="col-4">
                            					<h6 class="col-form-label me-2 text-nowrap">Net Price</h6>
                            					<input class="form-control form-control-sm text-end" type="number"
                            						step="any" id="item_net_price" name="item_net_price">
                            				</div>
                            			</div>
                            		</div>
                            	</div>
                            </div>
                        <?php endforeach; ?>
                	</div>
                </div>

                <div class="collapse" id="collapse<?php echo  $subJob['sub_job_category']['idtbl_sub_job_category'] ?>">
                    <?php if (!empty($subJob['job_options'])): ?>
                        <?php foreach ($subJob['job_options'] as $jobOptionGroup): ?>
                            <div class="mb-2">
                                <h6 class="text-secondary"><?php echo $jobOptionGroup['job_option_group']['GroupName']; ?></h6>
                                <ul>
                                    <?php foreach ($jobOptionGroup['job_options'] as $jobOption): ?>
                                        <?php if ($jobOption['job_option']['OptionType'] == 'Primary'): ?>
                                            <li class="job-option-wrapper" data-level="0">
                                                <label for="job_option_<?php echo $jobOption['job_option']['JobOptionID']; ?>">
                                                    <?php echo $jobOption['job_option']['OptionName']; ?>
                                                </label>
                                                <select class="form-select job-option-select" id="job_option_<?php echo $jobOption['job_option']['JobOptionID']; ?>"
                                                        name="job_option_<?php echo $jobOption['job_option']['JobOptionID']; ?>" 
                                                        data-option-type="<?php echo $jobOption['job_option']['OptionType']; ?>"
                                                        data-option_id="<?php echo $jobOption['job_option']['JobOptionID']; ?>"
                                                        data-option-group="<?php echo $jobOptionGroup['job_option_group']['id']; ?>"
                                                        data-sub-job-category="<?php echo $subJob['sub_job_category']['idtbl_sub_job_category']; ?>">
                                                    <option value="">Select an option</option>
                                                    <?php foreach ($jobOption['option_values'] as $optionValue): ?>
                                                        <option value="<?php echo $optionValue['id']; ?>">
                                                            <?php echo $optionValue['ValueName']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="conditional-container"></div>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h6>No job options found for this category.</h6>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="mb-3">
            <h3 class="text-center">No records found!</h3>
        </div>
    <?php endif; ?>
<?php endif; ?>

<script>
    $(document).on('change', '.job-option-select', function () {
    var selectedOptionValue = $(this).val();   
    var optionType = $(this).data('option-type'); 
    var subJobCategoryID = $(this).data('sub-job-category'); 
    const currentWrapper = $(this).closest('.job-option-wrapper');
    const currentLevel = parseInt(currentWrapper.data('level'));

    $('.job-option-wrapper').each(function () {
        if (parseInt($(this).data('level')) > currentLevel) {
            $(this).remove();
        }
    });
    
    if (selectedOptionValue) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>JobCard/getItemParentOptions',
            dataType: 'json',
            data: {
                subJobCategoryID: subJobCategoryID,
                selectedOptionValue: selectedOptionValue
            },
            success: function(res) {
                if (res.status && res.data.length > 0) {
            res.data.forEach(function (group) {
                const jobOption = group.job_option;
                const optionValues = group.option_values;

                if (optionValues.length > 0) {
                    let html = `
                        <div class="job-option-wrapper" data-level="${currentLevel + 1}">
                            <label class="mt-2 fw-bold">${jobOption.OptionName}</label>
                            <select class="form-select job-option-select" 
                                    data-option-id="${jobOption.JobOptionID}" 
                                    data-sub-job-category="${jobOption.JobSubcategoryID}">
                                <option value="">Select an option</option>`;

                    optionValues.forEach(function (val) {
                        html += `<option value="${val.id}">${val.ValueName}</option>`;
                    });

                    html += `</select></div>`;

                    // Insert after the current wrapper
                    currentWrapper.after(html);
                }
            });
        }
            },
            error: function() {
                console.error("Failed to load conditional options.");
            }
        });
    }
});
</script>
