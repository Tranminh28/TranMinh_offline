<?php
$groupACPValues = ['default' => 'Select Group ACP', 0 => 'No', 1 => 'Yes'];
$slbGroupACP = HTMLBackend::createSelectBox('filter_groupacp', 'custom-select custom-select-sm mr-1', $groupACPValues, $this->arrParam['filter_groupacp'] ?? 'default', 'width: unset');


$countStatusValues = [
    'all' => $this->countActive + $this->countInactive,
    'active' => $this->countActive,
    'inactive' => $this->countInactive,
];
$filterButtons = HTMLBackend::showFilterButtons($this->arrParam, $countStatusValues);
?>

<div class="card card-info card-outline">
    <div class="card-header">
        <h6 class="card-title">Search & Filter</h6>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-between">
            <div class="mb-1">
                <?php echo $filterButtons; ?>
            </div>
            <div class="mb-1">
                <form action="" method="get" id="filter-bar">
                    <input type="hidden" name="module" value="<?php echo $this->arrParam['module']; ?>">
                    <input type="hidden" name="controller" value="<?php echo $this->arrParam['controller']; ?>">
                    <input type="hidden" name="action" value="<?php echo $this->arrParam['action']; ?>">
                    <?php echo $slbGroupACP; ?>
                </form>
            </div>
            <div class="mb-1">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="hidden" name="module" value="<?php echo $this->arrParam['module']; ?>">
                        <input type="hidden" name="controller" value="<?php echo $this->arrParam['controller']; ?>">
                        <input type="hidden" name="action" value="<?php echo $this->arrParam['action']; ?>">
                        <input type="text" class="form-control form-control-sm" name="search" value="<?php echo $searchValue ?>" style="min-width: 300px">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-sm btn-danger" id="btn-clear-search">Clear</button>
                            <button type="submit" class="btn btn-sm btn-info" id="btn-search">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>