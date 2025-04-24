<div class="row">
    <div class="col-6">
        <h5><?= $subCategoryText ?> <i class="fas fa-long-arrow-alt-right me-2 text-info d-grid justify-content-center"></i><?= $valuename ?></h5>
    </div>
    <div class="col-6">
        <div class="d-flex flex-column gap-2">
			<?php if ($data['status']): ?>
				<?php foreach ($data['data'] as $item): ?>
					<div class="d-flex align-items-center mb-3">
						<h6 class="small font-weight-bold mb-0 me-2" style="width: 60px;">
							<?= htmlspecialchars($item['category_name']) ?>
						</h6>
						<input type="number" step="any" class="form-control text-right"
                           id="size<?= htmlspecialchars($item['category_name']) ?>"
                           value="<?= number_format((float)$item['price'], 2, '.', '') ?>"
                           style="width: 50%">
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<h6 class="small font-weight-bold mb-0 me-2 text-danger" style="width: 60px;">Data Not Loaded!</h6>
			<?php endif; ?>
        </div>
    </div>
</div>