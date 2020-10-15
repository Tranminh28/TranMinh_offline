<?php

$action = isset($this->arrParam['id']) ? 'form&id=' . $this->arrParam['id'] : 'form';
// Save
$linkSave       = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], $action, ['type' => 'save']);
$btnSave        = HTMLBackend::createActionButton("javascript:submitForm('$linkSave')", 'btn-success mr-1', 'Save');

// Save & New
$linkSaveNew    = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], $action, ['type' => 'save-new']);
$btnSaveNew     = HTMLBackend::createActionButton("javascript:submitForm('$linkSaveNew')", 'btn-success mr-1', 'Save & New');

// Save & Close
$linkSaveClose  = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], $action, ['type' => 'save-close']);
$btnSaveClose   = HTMLBackend::createActionButton("javascript:submitForm('$linkSaveClose')", 'btn-success mr-1', 'Save & Close');

// Cancel
$linkCancel     = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], 'index');
$btnCancel      = HTMLBackend::createActionButton($linkCancel, 'btn-danger mr-1', 'Cancel');


// Input
$dataForm       = $this->arrParam['form'];
$inputName      = FormBackend::input('text', 'form[name]', 'form[name]', $dataForm['name'], 'form-control form-control-sm');
$inputToken     = FormBackend::input('hidden', 'form[token]', 'form[token]', time());
$selectStatus   = FormBackend::selectNonNumeric('form[status]', 'custom-select custom-select-sm', ['default' => '- Select Status -', 'active' => 'Active', 'inactive' => 'Inactive'], $dataForm['status']);
$selectGroupACP = FormBackend::select('form[group_acp]', 'custom-select custom-select-sm', ['default' => '- Select Group ACP -', 1 => 'Yes', 0 => 'No'], $dataForm['group_acp']);
$inputIDHidden = '';
if (isset($this->arrParam['id'])) {
    $inputIDHidden = FormBackend::input('hidden', 'form[id]', 'form[id]', $this->arrParam['id']);
}

// Form row
$rowName        = FormBackend::formGroup('Name', $inputName, true);
$rowStatus      = FormBackend::formGroup('Status', $selectStatus, true);
$rowGroupACP    = FormBackend::formGroup('Group ACP', $selectGroupACP, true);
?>

<?php echo $this->errors ?>
<div class="card card-info card-outline">
    <div class="card-body">
        <form action="" method="post" class="mb-0" id="admin-form">
            <?= $rowName . $rowStatus . $rowGroupACP ?>
            <?= $inputToken . $inputIDHidden ?>
        </form>
    </div>
    <div class="card-footer">
        <div class="col-12 col-sm-8 offset-sm-2">
            <?php echo $btnSave . $btnSaveClose . $btnSaveNew . $btnCancel ?>
        </div>
    </div>
</div>