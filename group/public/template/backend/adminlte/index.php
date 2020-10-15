<!DOCTYPE html>
<html>

<head>
    <?php echo $this->_metaHTTP; ?>
    <?php echo $this->_metaName; ?>
    <title><?php echo $this->title; ?></title>
    <?php echo $this->_cssFiles; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <script>
        var module = '<?php echo $this->arrParam['module'] ?>';
        var controller = '<?php echo $this->arrParam['controller'] ?>';
    </script>
    <div class="wrapper">

        <!-- Navbar -->
        <?php require_once 'html/navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once 'html/sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php require_once 'html/page-header.php'; ?>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?php require_once MODULE_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php'; ?>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php require_once 'html/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <!-- script -->
    <?php echo $this->_jsFiles; ?>
</body>

</html>