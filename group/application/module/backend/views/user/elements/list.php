<?php
echo '<pre>';
print_r($this->items);
echo '</pre>';
$xhtml = '';

foreach ($this->items as $item) {
    $id         = $item['id'];
    $name       = $item['username'];
    $ordering       = '<input type="text" value="5" size="5" >';
    $group       = '<select id="bulk-action" name="bulk-action" class="custom-select custom-select-sm mr-1" style="width: unset">
                    <option value="default">Bulk Action</option>
                    <option value="delete">Multi Delete</option>
                    <option value="active">Multi Active</option>
                    <option value="inactive">Multi Inactive</option>
                    </select> ';
    $status     = HTMLBackend::showItemStatus($this->arrParam['module'], $this->arrParam['controller'], $item['id'], $item['status']);
    $groupACP   = HTMLBackend::showItemGroupACP($this->arrParam['module'], $this->arrParam['controller'], $item['id'], $item['group_acp']);
    $created    = HTMLBackend::showItemHistory($item['created_by'], $item['created']);
    $modified   = HTMLBackend::showItemHistory($item['modified_by'], $item['modified']);
    $linkDelete = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], 'delete', ['id' => $item['id']]);
    $linkEdit = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], 'form', ['id' => $item['id']]);
    $xhtml .= '
    <tr>
        <td class="text-center">
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="checkbox-' . $item['id'] . '" name="checkbox[]" value="' . $item['id'] . '">
                <label for="checkbox-' . $item['id'] . '" class="custom-control-label"></label>
            </div>
        </td>
        <td class="text-center">' . $id . '</td>
        <td class="text-center">' . $name . '</td>
        <td class="text-center position-relative">' . $status . '</td>
        <td class="text-center position-relative">' . $group . '</td>
        <td class="text-center">' . $ordering . '</td>
        <td class="text-center">' . $created . '</td>
        <td class="text-center modified-' . $item['id'] . '">' . $modified . '</td>
        <td class="text-center">
            <a href="' . $linkEdit . '" class="rounded-circle btn btn-sm btn-info" title="Edit">
                <i class="fas fa-pencil-alt"></i>
            </a>
            <a href="' . $linkDelete . '" class="rounded-circle btn btn-sm btn-danger btn-delete" title="Delete" data-toggle="tooltip">
                <i class="fas fa-trash-alt"></i>
            </a>
        </td>
    </tr>
    ';
}

$linkAdd = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], 'form');
$linkReload = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], 'index');

?>

<div class="card card-info card-outline">
    <div class="card-header">
        <h4 class="card-title">List</h4>
        <div class="card-tools">
            <a href="<?php echo $linkReload  ?>" class="btn btn-tool"><i class="fas fa-sync"></i></a>
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <!-- Control -->

        <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
            <div class="mb-1">
                <select id="bulk-action" name="bulk-action" class="custom-select custom-select-sm mr-1" style="width: unset">
                    <option value="default">Bulk Action</option>
                    <option value="delete">Multi Delete</option>
                    <option value="active">Multi Active</option>
                    <option value="inactive">Multi Inactive</option>
                </select>
                <button id="bulk-apply" class="btn btn-sm btn-info">Apply <span class="badge badge-pill badge-danger navbar-badge" style="display: none"></span></button>
            </div>
            <a href="<?php echo $linkAdd ?>" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> Add New</a>
        </div>
        <!-- List Content -->
        <form action="" method="post" class="table-responsive" id="form-table">
            <table class="table table-bordered table-hover text-nowrap btn-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="check-all">
                                <label for="check-all" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="text-center">ID</a></th>
                        <th class="text-center">Name</a></th>
                        <th class="text-center">Status</a></th>
                        <th class="text-center">Group</a></th>
                        <th class="text-center">Ordering</a></th>
                        <th class="text-center">Created</a></th>
                        <th class="text-center">Modified</a></th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $xhtml; ?>
                </tbody>
            </table>
        </form>
    </div>
    <div class="card-footer clearfix">
        <?php echo $this->pagination->showPaginationBackend() ?>
    </div>
</div>