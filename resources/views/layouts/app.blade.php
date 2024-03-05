<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>
<?php

use Illuminate\Support\Facades\Auth;

$roleadmin = Auth::user()->role;
$userhalo = Auth::user()->email;

?>

<head>

    <title>Aplikasi Manajemen Ruangan</title>
    <?php include 'layouts/title-meta.php'; ?>

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="vendor/daterangepicker/daterangepicker.css">

    <!-- Vector Map css -->
    <link rel="stylesheet" href="vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css">

    <!-- Datatables css -->
    <link href="vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    <!-- calendar -->
    <link href="vendor/fullcalendar/main.min.css" rel="stylesheet" type="text/css" />

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <?php include 'layouts/head-css.php'; ?>
</head>

<body>

    <!-- Begin page -->
    <div class="wrapper">
        <?php include 'layouts/menu.php'; ?>
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <div class="content">

                @yield('content')

            </div>
        </div>

        <?php include 'layouts/footer.php'; ?>
    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <?php include 'layouts/right-sidebar.php'; ?>

    <?php include 'layouts/footer-scripts.php'; ?>

    <!-- jQuery  -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/modernizr.min.js"></script>
    <script src="js/detect.js"></script>
    <script src="js/fastclick.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/jquery.blockUI.js"></script>
    <script src="js/waves.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>

    <script src="plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

    <!-- Daterangepicker js -->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>

    <!-- Apex Charts js -->
    <script src="vendor/apexcharts/apexcharts.min.js"></script>
    <!-- calendar -->
    <script src="assets/vendor/fullcalendar/main.min.js"></script>

    <!-- Vector Map js -->
    <script src="vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
    <script src="vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js"></script>
    <script src="vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendor/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendor/datatables.net-select/js/dataTables.select.min.js"></script>

    <!-- Datatable Demo Aapp js -->
    <script src="js/pages/demo.datatable-init.js"></script>
    <!-- Dashboard App js -->
    <script src="js/pages/demo.dashboard.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- App js -->
    <script src="js/app.min.js"></script>

</body>

</html>