<div class="row">
    <div class="col-4">
        <h5><?= $subCategoryText ?> <i
                class="fas fa-long-arrow-alt-right mr-2 ml-2 text-info d-grid justify-content-center"></i><?= $valuename ?>
        </h5>
    </div>
    <div class="col-8">
        <div class="d-flex flex-column gap-2">
            <div class="row mb-2">
                <div class="col-5"></div>
                <div class="col-4">
                    <h6 class="small font-weight-bold mb-0 me-2">Vaild From</h6>
                </div>
                <div class="col-3">
                    <h6 class="small font-weight-bold mb-0 me-2">Status</h6>
                </div>
            </div>
            <?php if ($data['status']): ?>
            <?php foreach ($data['data'] as $item): ?>
            <div class="row d-flex align-items-center mb-3 row-price-item" data-price_category_id="<?= htmlspecialchars($item['PriceCategoryID']) ?>">
                <div class="col-5 d-flex align-items-center">
                    <h6 class="small font-weight-bold mb-0 mr-2" style="width: 60px;">
                        <?= htmlspecialchars($item['category_name']) ?>
                    </h6>
                    <input type="number" step="any" class="form-control text-right price-input"
                        id="size<?= htmlspecialchars($item['PriceCategoryID']) ?>"
                        name="size<?= htmlspecialchars($item['PriceCategoryID']) ?>"
						data-original="<?= number_format((float)$item['price'], 2, '.', '') ?>"
                        value="<?= number_format((float)$item['price'], 2, '.', '') ?>" style="width: 100%">
                </div>
                <div class="col-4">
                    <input type="date" class="form-control text-righ date-input"
                        id="valid_from<?= htmlspecialchars($item['PriceCategoryID']) ?>"
                        name="valid_from<?= htmlspecialchars($item['PriceCategoryID']) ?>"
						data-original="<?= !empty($item['valid_from']) ? date('Y-m-d', strtotime($item['valid_from'])) : '' ?>"
                        value="<?= !empty($item['valid_from']) ? date('Y-m-d', strtotime($item['valid_from'])) : '' ?>"
                        style="width: 100%">
                </div>

                <div class="col-3">
                    <?php $hasValues = !empty($item['valid_from']) && isset($item['price']) && $item['price'] !== ''; ?>
                    <select class="form-control form-control-sm status-input"
                        id="status<?= htmlspecialchars($item['PriceCategoryID']) ?>"
                        name="status<?= htmlspecialchars($item['PriceCategoryID']) ?>"
						data-original="<?= $hasValues ? '1' : '' ?>" required>
                        <option value="">Select</option>
                        <option value="1" <?= $hasValues ? 'selected' : '' ?>>Active</option>
                        <option value="2">DeActive</option>
                    </select>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <h6 class="small font-weight-bold mb-0 mr-2 text-danger" style="width: 60px;">Data Not Loaded!</h6>
            <?php endif; ?>
        </div>
    </div>
</div>
