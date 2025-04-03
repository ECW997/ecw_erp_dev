<table id="detailDataTable" class="table table-bordered table-striped table-sm nowrap w-100">
    <thead>
        <tr>
            <th>ID</th>
            <th>Group Name</th>
            <th>Sort Order</th>
            <th>Description</th>
            <th class="text-right <?php echo ($modalOption == '2') ? 'd-none' : '' ?>">Actions</th>
            <th class="text-center <?php echo ($modalOption == '1') ? 'd-none' : '' ?>">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($data['status']): ?>
            <?php if (!empty($data['data'])): ?>
                <?php foreach ($data['data'] as $list): ?>
                    <tr>
                        <td><?php echo  $list['id'] ?></td>
                        <td><?php echo  $list['GroupName'] ?></td>
                        <td><?php echo  $list['SortOrder'] ?></td>
                        <td><?php echo  $list['Description'] ?></td>
                        <td class="text-right <?php echo ($modalOption == '2') ? 'd-none' : '' ?>">
                        <button title="Edit" class="btn btn-sm btn-primary mr-2 detailEditBtn <?php echo ($editcheck!=1? 'd-none' : '')?>" id="<?php echo  $list['id'] ?>"><i class="fas fa-pen"></i></button>
                        <?php if ($list['status'] == '1'): ?>
                            <button title="Deactive" class="btn btn-sm btn-success mr-2 detailStatusBtn <?php echo ($statuscheck!=1? 'd-none' : '')?>" id="<?php echo  $list['id'] ?>" status="2" sub_id="<?php echo  $list['JobSubcategoryID'] ?>"><i class="fas fa-check"></i></button>
                        <?php else: ?>
                            <button title="Active" class="btn btn-sm btn-warning mr-2 detailStatusBtn <?php echo ($statuscheck!=1? 'd-none' : '')?>" id="<?php echo  $list['id'] ?>" status="1" sub_id="<?php echo  $list['JobSubcategoryID'] ?>"><i class="fas fa-times"></i></button>
                        <?php endif; ?>
                            <button title="Delete" class="btn btn-sm btn-danger detailDeleteBtn <?php echo ($deletecheck!=1? 'd-none' : '')?>" id="<?php echo  $list['id'] ?>" sub_id="<?php echo  $list['JobSubcategoryID'] ?>"><i class="fas fa-trash-alt"></i></button>
                        </td>
                        <td class="text-center <?php echo ($modalOption == '1') ? 'd-none' : ''; ?>">
                            <?php if ($list['status'] == '1'): ?>
                                <span class="badge badge-pill badge-success"><i class="fas fa-check"></i></span>
                            <?php else: ?>
                                <span class="badge badge-pill badge-warning"><i class="fas fa-times"></i></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No records found!</td>
                </tr>
            <?php endif; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Server response error! Reload page & Try Again!</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
