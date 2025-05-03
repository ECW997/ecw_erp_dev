<table id="detailDataTable" class="table table-bordered table-striped table-sm nowrap w-100">
    <thead>
        <tr>
            <th>Job Option</th>
            <th>Job Option Value</th>
            <?php if ($data['status'] && !empty($data['data'][0]['price_category'])): ?>
                <?php foreach ($data['data'][0]['price_category'] as $category): ?>
                    <th class="text-center"><?php echo htmlspecialchars($category['short_name']); ?></th>
                <?php endforeach; ?>
            <?php endif; ?>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($data['status'] && !empty($data['data'][0]['all_details'])): ?>
            <?php foreach ($data['data'][0]['all_details'] as $jobDetail): ?>
                <?php 
                    $jobOptionName = $jobDetail['job_option']['OptionName']; 
                    $optionValues = $jobDetail['option_values'];
                    $valueCount = count($optionValues);
                ?>

                    <?php if (!empty($optionValues)): ?>
                        <?php foreach ($optionValues as $index => $value):?>
                            <tr>
                                <?php if ($index === 0): ?>
                                    <td rowspan="<?php echo $valueCount; ?>"><?php echo htmlspecialchars($jobOptionName); ?></td>
                                <?php endif; ?>

                                <td><?php echo htmlspecialchars($value['ValueName']); ?></td>

                                <?php foreach ($data['data'][0]['price_category'] as $category): ?>
                                    <?php 
                                        $type = $category['price_category_type'];
                                        $price = isset($value['price_category_type'][$type]) ? $value['price_category_type'][$type] : '-';
                                    ?>
                                    <td class="text-right"><?php echo htmlspecialchars($price); ?></td>
                                <?php endforeach; ?>

                                <td class="text-right">
                                    <button title="Edit" 
                                            class="btn btn-sm btn-primary mr-2 detailEditBtn <?php echo ($editcheck != 1 ? 'd-none' : '') ?>" 
                                            id="<?php echo htmlspecialchars($value['OptionValueID']); ?>" 
                                            valuename="<?php echo htmlspecialchars($value['ValueName']); ?>">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td><?php echo htmlspecialchars($jobOptionName); ?></td>
                        <td colspan="<?php echo count($data['data'][0]['price_category']) + 2; ?>" class="text-center">No option values</td>
                    </tr>
                <?php endif; ?>
             
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="<?php echo count($data['data'][0]['price_category']) + 3; ?>" class="text-center">No job options available.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
