<?php
$searchValue = $this->arrParam['search'] ?? '';
?>



<?php echo HTMLBackend::showNotify(); ?>
<!-- Search & Filter -->
<?php require_once 'elements/search-filter.php'; ?>

<!-- List -->
<?php require_once 'elements/list.php'; ?>