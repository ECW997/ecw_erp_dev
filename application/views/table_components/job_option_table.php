<table id="detailDataTable" class="table table-bordered table-striped table-sm nowrap w-100">
    <thead>
        <tr>
            <th>ID</th>
            <th>Option Name</th>
            <th>Option Type</th>
            <th>Option Group</th>
            <th>Required Status</th>
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
                        <td><?php echo  $list['JobOptionID'] ?></td>
                        <td><?php echo  $list['OptionName'] ?></td>
                        <td><?php echo  $list['OptionType'] ?></td>
                        <td><?php echo  $list['OptionGroupName'] ?></td>
                        <td class="text-center"><?php echo  ($list['IsRequired'] == '1'?'<span class="badge badge-pill badge-success"><i class="fas fa-check"></i>':'<span class="badge badge-pill badge-warning"><i class="fas fa-times"></i>') ?></td>
                        <td><?php echo  $list['Description'] ?></td>
                        <td class="text-right <?php echo ($modalOption == '2') ? 'd-none' : '' ?>">
                        <button title="Edit" class="btn btn-sm btn-primary mr-2 detailEditBtn <?php echo ($editcheck!=1? 'd-none' : '')?>" id="<?php echo  $list['JobOptionID'] ?>"><i class="fas fa-pen"></i></button>
                        <?php if ($list['status'] == '1'): ?>
                            <button title="Deactive" class="btn btn-sm btn-success mr-2 detailStatusBtn <?php echo ($statuscheck!=1? 'd-none' : '')?>" id="<?php echo  $list['JobOptionID'] ?>" status="2" sub_id="<?php echo  $list['JobSubcategoryID'] ?>"><i class="fas fa-check"></i></button>
                        <?php else: ?>
                            <button title="Active" class="btn btn-sm btn-warning mr-2 detailStatusBtn <?php echo ($statuscheck!=1? 'd-none' : '')?>" id="<?php echo  $list['JobOptionID'] ?>" status="1" sub_id="<?php echo  $list['JobSubcategoryID'] ?>"><i class="fas fa-times"></i></button>
                        <?php endif; ?>
                            <button title="Delete" class="btn btn-sm btn-danger detailDeleteBtn <?php echo ($deletecheck!=1? 'd-none' : '')?>" id="<?php echo  $list['JobOptionID'] ?>" sub_id="<?php echo  $list['JobSubcategoryID'] ?>"><i class="fas fa-trash-alt"></i></button>
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
