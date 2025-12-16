<?php

defined('BASEPATH') or exit('No direct script access allowed');

$settings = $this->db->select("site_align")

    ->get('setting')

    ->row();

?>

<?php



if (!isset($_SESSION['ward'])) {

    $_SESSION['ward'] = 'ALL';
} else {

    if (isset($_GET['cward'])) {

        $_SESSION['ward'] = $_GET['cward'];

        $url = $actual_link = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(4) . '/';

        header('Location: ' . $url);

        die();
    }
}

$dates = get_from_to_date();

$pagetitle = $dates['pagetitle'];

?>

<!DOCTYPE html>

<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= display('dashboard') ?> - Efeedor Patient feedback Management Software</title>

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="<?= base_url($this->session->userdata('favicon')) ?>">

    <!-- jquery ui css -->
    <link href="<?php echo base_url(); ?>assets/css/jquery-ui.min.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") {  ?>
        <!-- THEME RTL -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/custom-rtl.css" rel="stylesheet" type="text/css" />
    <?php } ?>



    <!-- Font Awesome 4.7.0 -->
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- semantic css -->
    <link href="<?php echo base_url(); ?>assets/css/semantic.min.css" rel="stylesheet" type="text/css" />
    <!-- sliderAccess css -->
    <link href="<?php echo base_url(); ?>assets/css/jquery-ui-timepicker-addon.min.css" rel="stylesheet" type="text/css" />
    <!-- slider  -->
    <link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- DataTables CSS -->
    <link href="<?php echo base_url(); ?>assets/datatables/css/dataTables.min.css" rel="stylesheet" type="text/css" />


    <!-- pe-icon-7-stroke -->
    <link href="<?php echo base_url('assets/css/pe-icon-7-stroke.css') ?>" rel="stylesheet" type="text/css" />
    <!-- themify icon css -->
    <link href="<?php echo base_url('assets/css/themify-icons.css') ?>" rel="stylesheet" type="text/css" />
    <!-- Pace css -->
    <link href="<?php echo base_url('assets/css/flash.css') ?>" rel="stylesheet" type="text/css" />

    <!-- Theme style -->
    <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet" type="text/css" />
    <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") {  ?>
        <!-- THEME RTL -->
        <link href="<?php echo base_url('assets/css/custom-rtl.css') ?>" rel="stylesheet" type="text/css" />
    <?php } ?>


    <!-- jQuery  -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
    <script src="<?php echo base_url(); ?>assets/utils.js"></script>
</head>

<body class="hold-transition sidebar-mini">

    <div class="se-pre-con"></div>



    <!-- Site wrapper -->

    <div class="wrapper">

        <!-- =============================================== -->





        <!-- Left side column. contains the sidebar -->


        <aside class="main-sidebar">

            <!-- sidebar -->

            <div class="sidebar">

                <!-- Sidebar user panel -->

                <div class="user-panel text-center">

                    <?php $picture = $this->session->userdata('picture'); ?>

                    <div class="image">

                        <img src="<?php echo (!empty($picture) ? base_url($picture) : base_url("assets/images/no-img.png")) ?>" class="img-circle" alt="User Image">

                    </div>

                    <div class="info">

                        <p style="overflow:breakword;"><?php echo $this->session->userdata('fullname') ?></p>

                        <a href="#"><i class="fa fa-circle text-success"></i>

                            <?php echo $this->session->userdata('user_role_name');   ?>
                        </a>

                    </div>

                </div>



                <!-- sidebar menu -->

                <ul class="sidebar-menu">

                    <?php if ($this->session->userdata['user_role'] == 0) { ?>
                        <li class="treeview">
                            <a href="<?php echo base_url(); ?>dashboard/welcome">
                                <i class="fa fa-globe"></i> <span>Overall Summary</span>
                            </a>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-gear"></i> <span>Inpatient Feedback</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">

                                <li><a href="<?php echo base_url("../ipfeedback/language/english.json") ?>" target="_blank">English</a></li>
                                <li><a href="<?php echo base_url("../ipfeedback/language/lang2.json") ?>" target="_blank">Lang 2</a></li>
                                <li><a href="<?php echo base_url("../ipfeedback/language/lang3.json") ?>" target="_blank">Lang 3</a></li>
                                <li><a href="<?php echo base_url("../ipfeedback/") ?>" target="_blank">Open IPfeedback</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-gear"></i> <span>Outpatient Feedback</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("../opfeedback/language/english.json") ?>" target="_blank">English</a></li>
                                <li><a href="<?php echo base_url("../opfeedback/language/lang2.json") ?>" target="_blank">Lang 2</a></li>
                                <li><a href="<?php echo base_url("../opfeedback/language/lang3.json") ?>" target="_blank">Lang 3</a></li>
                                <li><a href="<?php echo base_url("../opfeedback/") ?>" target="_blank">Open OPfeedback</a></li>

                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-gear"></i> <span>Interim Feedback</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">

                                <li><a href="<?php echo base_url("../interimfeedback/language/english.json") ?>" target="_blank">English</a></li>
                                <li><a href="<?php echo base_url("../interimfeedback/language/lang2.json") ?>" target="_blank">Lang 2</a></li>
                                <li><a href="<?php echo base_url("../interimfeedback/language/lang3.json") ?>" target="_blank">Lang 3</a></li>
                                <li><a href="<?php echo base_url("../interimfeedback/") ?>" target="_blank">Open Interimfeedback</a></li>

                            </ul>
                        </li>


                        <li class="treeview <?php echo (($this->uri->segment(1) == "coordinator" || $this->uri->segment(1) == "users"  || $this->uri->segment(1) == "settings") ? "active" : null) ?>">
                            <a href="#">
                            <i class="fa fa-gear"></i> <span>Settings</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("settings/organization_profile") ?>">Organization Profile</a></li>
                                <li><a href="<?php echo base_url("settings") ?>">Application Settings</a></li>
                                <li><a href="<?php echo base_url("subscription/organization") ?>">Manage Subscription</a></li>
                            </ul>
                        </li>


                        <li class="treeview">
                            <a href="<?php echo base_url('SetupEfeeder/exportdatabase'); ?>" target="_blank">
                                <i class="fa fa-database"></i> <span>Export DB</span>
                            </a>
                        </li>
                    <?php } ?>



                </ul>

            </div>

            <!-- /.sidebar -->

        </aside>

        <!-- =============================================== -->



        <header class="main-header">

            <?php

            //  print_r($data);
            //  exit;
            if ($this->session->userdata['user_id'] == 1) {
                $a['logo'] = $this->session->userdata['logo'];

            ?>
                <a href="<?php echo base_url('devcheck/devhome') ?>" class="logo">



                    <span class="logo-mini">

                        <img src="<?php echo (!empty($a) ? base_url('uploads/' . $a['logo']) :  null) ?>" width="50px" height="60px" alt="">

                    </span>

                    <span class="logo-lg">

                        <img src="<?php echo (!empty($a) ? base_url('uploads/' . $a['logo']) :  null) ?>" width="130" height="60px" alt="">

                    </span>
                <?php } ?>

                </a>



                <!-- Header Navbar -->

                <nav class="navbar navbar-static-top" style="    background: #dadada;">

                    <ul class="nav navbar-nav" style="display: inline-flex; float:left;">



                        <li>

                            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->

                                <span class="sr-only">Toggle navigation</span>

                                <span class="pe-7s-keypad"></span>

                            </a>



                        </li>

                        <li>

                            <span class="nav navbar-nav" style="margin-left: 10px; margin-bottom: 2px; margin-top:5px; position:absolute;">

                                <span class="content-icon"><img src="<?php echo base_url("assets/images/eflogo.png"); ?>" style="
    height: 40px;
    width: 40px;
    margin-top: 5px;
" alt=""></span>

                            </span>

                        </li>

                        <li>
                            <div class="navheader">EFEEDOR- ADMIN</div>
                        </li>

                    </ul>
                    <style>
                        .navheader {

                            font-size: 23px;

                            display: flex;

                            padding: 20px;

                            margin-left: 45px;

                            font-weight: bold;
                        }

                        @media (max-width: 1000px) {
                            .navheader {
                                display: none;
                            }
                        }
                    </style>



                    <ul class="nav navbar-nav p-r-30" style="display: inline-flex; float:right;  ">




                        <?php $this->load->view('layout/notifiation'); ?>

                        <li class="dropdown dropdown-user">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell-o"></i></a>

                        </li>



                        <li class="dropdown dropdown-user">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user-o"></i></a>

                            <ul class="dropdown-menu" style="
    margin-left: -114px;
    width: 100px;
        position: absolute;
    background: #fff;
">

                                <li><a href="<?php echo base_url('dashboard/profile'); ?>"><i class="pe-7s-users"></i> <?php echo display('profile') ?></a></li>

                                <li><a href="<?php echo base_url('dashboard/form'); ?>"><i class="pe-7s-settings"></i> <?php echo display('edit_profile') ?></a></li>

                                <li><a href="<?php echo base_url('logout') ?>"><i class="pe-7s-key"></i> <?php echo display('logout') ?></a></li>

                            </ul>

                        </li>
                        <style>
                            .navbar-nav>li>a>i {
                                border: none;
                                padding: 6px 3px;
                                width: 36px;
                                text-align: center;
                                color: #374767;
                                background-color: #dadada;
                                height: 36px;
                                font-size: 25px;
                            }


                            .navbar-nav>.dropdown-user>.dropdown-menu>li>a {
                                padding: 10px 10px;

                            }
                        </style>

                    </ul>

                </nav>

        </header>







        <!-- Content Wrapper. Contains page content  nav content-header-->

        <div class="content-wrapper">
            <?php
            // if (show_filter($this->uri->segment(1), $this->uri->segment(2)) === true) {

            //     if (is_mobile() === true) {

            //         $this->load->view('layout/filter_mob');
            //     } else {
            $this->load->view('zdeveloper/dev_navtop');
            //     }
            // }
            ?>


            <!-- Content Header (Page header) -->

            <div class="content">

                <div class="p-l-30 p-r-30">



                    <div class="content-title">

                        <h2 class="text header_title"><?php echo !empty($title) ? $title : null; ?>
                            <?php if (($this->uri->segment(1) == 'dashboard') || $this->uri->segment(1) == 'ticketdashboard_int') { ?>
                                <i class="fa fa-download" data-toggle="tooltip" title="Click on the download icon to download the reports." onclick="$('#showdownload').toggle(300)" style="font-size: 20px;margin-top: 5px;margin-left: 11px;cursor: pointer; color: #62c52d;"></i>
                            <?php } ?>
                        </h2>
                    </div>

                </div>





                <!-- alert message -->

                <?php if ($this->session->flashdata('message') != null) {  ?>

                    <div class="alert alert-info alert-dismissable">

                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                        <?php echo $this->session->flashdata('message'); ?>

                    </div>

                <?php } ?>



                <?php if ($this->session->flashdata('exception') != null) {  ?>

                    <div class="alert alert-danger alert-dismissable">

                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                        <?php echo $this->session->flashdata('exception'); ?>

                    </div>

                <?php } ?>



                <?php if (validation_errors()) {  ?>

                    <div class="alert alert-danger alert-dismissable">

                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                        <?php echo validation_errors(); ?>

                    </div>

                <?php } ?>







                <!-- content -->

                <?php echo (!empty($content) ? $content : null) ?>



            </div> <!-- /.content -->

        </div> <!-- /.content-wrapper -->



        <footer class="main-footer">
            <?php
            $path =  $_SERVER['DOCUMENT_ROOT'];
            echo '<b>Directory:</b> ';
            echo $path;
            ?>
            <br>
            <?php
            echo '<b>DB:</b> ';
            $db_name = $this->db->database;
            echo $db_name;
            ?>
        </footer>
    </div> <!-- ./wrapper -->

    <!-- jquery-ui js -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js" type="text/javascript"></script>
    <!-- bootstrap js -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- pace js -->
    <script src="<?php echo base_url(); ?>assets/js/pace.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.min.js" type="text/javascript"></script>

    <!-- bootstrap timepicker -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-ui-sliderAccess.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-ui-timepicker-addon.min.js" type="text/javascript"></script>
    <!-- select2 js -->
    <script src="<?php echo base_url(); ?>assets/js/select2.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/js/sparkline.min.js" type="text/javascript"></script>
    <!-- Counter js -->
    <script src="<?php echo base_url(); ?>assets/js/waypoints.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.counterup.min.js" type="text/javascript"></script>

    <!-- ChartJs JavaScript -->
    <script src="<?php echo base_url(); ?>assets/js/Chart.min.js" type="text/javascript"></script>

    <!-- semantic js -->
    <script src="<?php echo base_url(); ?>assets/js/semantic.min.js" type="text/javascript"></script>
    <!-- DataTables JavaScript -->
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.min.js"></script>
    <!-- tinymce texteditor -->
    <script src="<?php echo base_url(); ?>assets/tinymce/tinymce.min.js" type="text/javascript"></script>

    <!-- Admin Script -->
    <script src="<?php echo base_url(); ?>assets/js/frame.js" type="text/javascript"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url(); ?>assets/js/custom.js" type="text/javascript"></script>
    <script>
        $('.datatabletl').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'OP-PromotersList',
                    className: 'btn-sm',
                    title: 'OP-PromotersList'
                },
                {
                    extend: 'excel',
                    title: 'OP-PromotersList',
                    className: 'btn-sm',
                    title: 'OP-PromotersList'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>
    <!-- <script>
		$('.datatableun').DataTable({
			"ordering": false,
			 responsive: true,
			"pageLength":50,
			dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			buttons: [
			  /*  {extend: 'copy', className: 'btn-sm'},*/
				{extend: 'csv', title: 'IP-UnSatisfiedPatientsList', className: 'btn-sm', title: 'IP-UnSatisfiedPatientsList'},
				{extend: 'excel', title: 'IP-UnSatisfiedPatientsList', className: 'btn-sm', title: 'IP-UnSatisfiedPatientsList'},
				/{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},/
				/{extend: 'print', className: 'btn-sm'}/
			]
		} );
		</script>
  <script>
		$('.datatablerrr').DataTable({
			"ordering": false,
			 responsive: true,
			"pageLength":50,
			dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			buttons: [
			  /*  {extend: 'copy', className: 'btn-sm'},*/
				{extend: 'csv', title: 'OP-UnSatisfiedPatientsList', className: 'btn-sm', title: 'OP-UnSatisfiedPatientsList'},
				{extend: 'excel', title: 'OP-UnSatisfiedPatientsList', className: 'btn-sm', title: 'OP-UnSatisfiedPatientsList'},
				/{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},/
				/{extend: 'print', className: 'btn-sm'}/
			]
		} );
		</script> -->
    <script>
        $('.datatabletr').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'OP-PassiveList',
                    className: 'btn-sm',
                    title: 'OP-PassiveList'
                },
                {
                    extend: 'excel',
                    title: 'OP-PassiveList',
                    className: 'btn-sm',
                    title: 'OP-PassiveList'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>
    <script>
        $('.datatablett').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'OP-DetractorsList',
                    className: 'btn-sm',
                    title: 'OP-DetractorsList'
                },
                {
                    extend: 'excel',
                    title: 'OP-DetractorsList',
                    className: 'btn-sm',
                    title: 'OP-DetractorsList'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>
    <script>
        $('.datatables').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'General Report',
                    className: 'btn-sm'
                },
                {
                    extend: 'excel',
                    title: 'General Report',
                    className: 'btn-sm',
                    title: 'exportTitle'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>

    <script>
        $('.datatabledp').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'Discharged PatientsList',
                    className: 'btn-sm',
                    title: 'Discharged PatientsList'
                },
                {
                    extend: 'excel',
                    title: 'Discharged PatientsList',
                    className: 'btn-sm',
                    title: 'Discharged PatientsList'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>

    <script>
        $('.datatableto').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'IP-Open Tickets',
                    className: 'btn-sm',
                    title: 'IP-OpenTicket'
                },
                {
                    extend: 'excel',
                    title: 'IP-Open Tickets',
                    className: 'btn-sm',
                    title: 'IP-OpenTicket'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>
    <script>
        $('.datatabletio').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'Interim-Open Tickets',
                    className: 'btn-sm',
                    title: 'Interim-OpenTicket'
                },
                {
                    extend: 'excel',
                    title: 'Interim-Open Tickets',
                    className: 'btn-sm',
                    title: 'Interim-OpenTicket'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>
    <script>
        $('.datatabletic').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'Interim-Closed Tickets',
                    className: 'btn-sm',
                    title: 'Interim-ClosedTicket'
                },
                {
                    extend: 'excel',
                    title: 'Interim-Closed Tickets',
                    className: 'btn-sm',
                    title: 'Interim-ClosedTicket'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>
    <script>
        $('.datatableint').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'Interim-PatientsList',
                    className: 'btn-sm',
                    title: 'Interim-PatientsList'
                },
                {
                    extend: 'excel',
                    title: 'Interim-PatientsList',
                    className: 'btn-sm',
                    title: 'Interim-PatientsList'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>


    <script>
        $('.datatabletf').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'OP-Open Tickets',
                    className: 'btn-sm',
                    title: 'OP-OpenTicket'
                },
                {
                    extend: 'excel',
                    title: 'OP-Open Tickets',
                    className: 'btn-sm',
                    title: 'OP-OpenTicket'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>

    <script>
        $('.datatabletc').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'IP-Closed Tickets',
                    className: 'btn-sm',
                    title: 'IP-ClosedTicket'
                },
                {
                    extend: 'excel',
                    title: 'IP-Closed Tickets',
                    className: 'btn-sm',
                    title: 'IP-ClosedTicket'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>
    <script>
        $('.datatableip').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'PatientList',
                    className: 'btn-sm',
                    title: 'PatientList'
                },
                {
                    extend: 'excel',
                    title: 'PatientList',
                    className: 'btn-sm',
                    title: 'PatientList'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>

    <script>
        $('.datatablecod').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'IP-Patient CoordinatorsList',
                    className: 'btn-sm',
                    title: 'P-Patient CoordinatorsList'
                },
                {
                    extend: 'excel',
                    title: 'P-Patient CoordinatorsList',
                    className: 'btn-sm',
                    title: 'P-Patient CoordinatorsList'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>
    <script>
        $('.datatabletq').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'OP-Closed Tickets',
                    className: 'btn-sm',
                    title: 'OP-ClosedTicket'
                },
                {
                    extend: 'excel',
                    title: 'OP-Closed Tickets',
                    className: 'btn-sm',
                    title: 'OP-ClosedTicket'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>


    <script>
        $('.datatabletd').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'IP-PromotersList',
                    className: 'btn-sm',
                    title: 'IP-PromotersList'
                },
                {
                    extend: 'excel',
                    title: 'IP-PromotersList',
                    className: 'btn-sm',
                    title: 'IP-PromotersList'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>

    <script>
        $('.datatablete').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'IP-PassiveList',
                    className: 'btn-sm',
                    title: 'IP-PassiveList'
                },
                {
                    extend: 'excel',
                    title: 'IP-PassiveList',
                    className: 'btn-sm',
                    title: 'IP-PassiveList'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>

    <script>
        $('.datatabletw').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'IP-DetractorsList',
                    className: 'btn-sm',
                    title: 'IP-DetractorsList'
                },
                {
                    extend: 'excel',
                    title: 'IP-DetractorsList',
                    className: 'btn-sm',
                    title: 'IP-DetractorsList'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>

    <script>
        $('.datatablets').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'IP-SatisfiedPatientsList',
                    className: 'btn-sm',
                    title: 'IP-SatisfiedPatientsList'
                },
                {
                    extend: 'excel',
                    title: 'IP-SatisfiedPatientsList',
                    className: 'btn-sm',
                    title: 'IP-SatisfiedPatientsList'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>

    <script>
        $('.datatabletm').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'OP-SatisfiedPatientsList',
                    className: 'btn-sm',
                    title: 'OP-SatisfiedPatientsList'
                },
                {
                    extend: 'excel',
                    title: 'OP-SatisfiedPatientsList',
                    className: 'btn-sm',
                    title: 'OP-SatisfiedPatientsList'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>

    <script>
        $('.datatablestaff').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'Staff Report',
                    className: 'btn-sm',
                    title: 'StaffReport'
                },
                {
                    extend: 'excel',
                    title: 'Staff Report',
                    className: 'btn-sm',
                    title: 'StaffReport'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>

    <script>
        $('.datatablek').DataTable({
            "ordering": false,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'copy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'Interim-PatientsList',
                    className: 'btn-sm',
                    title: 'Interim-PatientsList'
                },
                {
                    extend: 'excel',
                    title: 'Interim-PatientsList',
                    className: 'btn-sm',
                    title: 'Interim-PatientsList'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
        });
    </script>


    <style>
        .changepassword {
            width: 45px;
            position: relative;
            float: right;
            margin-top: -33px;
            padding: 8px;
            background: transparent;
            border: 0px;
        }

        select#warddropdown {
            color: #FFFFFF;
            background: #62c52d;
            text-align: left;
        }

        select#warddropdown option {
            background: #FFFFFF;
            color: black; // color of all the other options
        }

        .header_title {
            font-size: 21px;
            margin-top: 13px !important;
            display: inline-block;
            margin-left: 7px;
        }

        .btn:active:focus,
        .btn:focus {
            outline: 0px;
        }

        @media screen and (max-width: 700px) {
            .header_title {
                font-size: 16px;
                margin-top: 20px !important;
                display: inline-block;
                margin-left: -4px;
                overflow: hidden;
                height: 80px;
            }

            div#myModal table td {
                text-align: left !important;
            }

            div#myModal table tr td button {
                text-align: left;
                width: 225px !important;
                display: inherit;

                font-size: 12px;
            }

            .content-title {
                width: 191px;
                margin-left: -10px;
            }

            hr {
                border-top: 1px solid #e1e6ef;
                padding: 0px;
                margin: 12px;
            }
        }
    </style>
</body>
</body>

</html>

<style>
    .panel-default>.panel-heading {

        background: #dadada;
    }

    .panel {
        border-radius: 15px;
    }

    .table {
        border-radius: 15px;
    }

    .alert {
        border-radius: 15px;

    }

    .form-control {
        border-radius: 15px;
    }

    .btn {
        border-radius: 15px;
    }

    .changepassword {
        width: 45px;
        position: relative;
        float: right;
        margin-top: -33px;
        padding: 8px;
        background: transparent;
        border: 0px;
    }

    .select {
        border-radius: 15px;
    }

    select#warddropdown {
        color: #FFFFFF;
        background: #62c52d;
        text-align: left;

        height: 32px;
    }

    select#warddropdown option {
        background: #FFFFFF;
        color: black; // color of all the other options
    }
</style>
</body>
</body>

</html>