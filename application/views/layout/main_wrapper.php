<?php
defined('BASEPATH') or exit('No direct script access allowed');
$settings = $this->db->select("site_align")
    ->get('setting')
    ->row();
// header('Refresh: 60');
session_start();
if (!isset($_SESSION['ward'])) {
    $_SESSION['ward'] = 'ALL';
} else {
    if (isset($_GET['cward'])) {
        $_SESSION['ward'] = $_GET['cward'];
        $url = $actual_link = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/';
        header('Location: ' . $url);
        die();
    }
}
$dates = get_from_to_date();

$pagetitle = $dates['pagetitle'];
// print_r($title);
if ($title == '<i class="fa fa-gear"></i> Settings') {
    $titlex = 'Settings -';
}
if ($title != '<i class="fa fa-gear"></i> Settings') {
    $titlex = $title;
}
if ($title == null) {
    $titlex = "Summary -";
}

?>

<!DOCTYPE html>

<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta http-equiv="refresh" content="60"/> -->

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $titlex; ?> <?php echo lang_loader('global', 'global_patient_efeedor_exp'); ?></title>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> -->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="<?php echo base_url('favicon.png'); ?>">

    <!-- jquery-ui js -->
    <?php ?>

    <!-- jquery ui css -->
    <link href="<?php echo base_url(); ?>assets/css/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") { ?>
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
    <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") { ?>
        <!-- THEME RTL -->
        <link href="<?php echo base_url('assets/css/custom-rtl.css') ?>" rel="stylesheet" type="text/css" />
    <?php } ?>
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.5/typed.min.js" integrity="sha512-1KbKusm/hAtkX5FScVR5G36wodIMnVd/aP04af06iyQTkD17szAMGNmxfNH+tEuFp3Og/P5G32L1qEC47CZbUQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/wordcloud2.js/1.0.2/wordcloud2.min.js" integrity="sha512-f1TzI0EVjfhwKkLEFZnu8AgzzzuUBE9X4YY61EoQJhjH8m+25VKdWmEfTJjmtnm0TEP8q9h+J061kCHvx3NJDA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            // Initialize the datepicker for both inputs
            $(".datepicker[name='tdate']").datepicker({
                maxDate: new Date(), // This ensures that the max selectable date is today.
                onClose: function(selectedDate) {
                    $(".datepicker[name='fdate']").datepicker("option", "minDate", selectedDate);
                }
            });

            $(".datepicker[name='fdate']").datepicker({
                maxDate: new Date(),
                onClose: function(selectedDate) {
                    $(".datepicker[name='tdate']").datepicker("option", "maxDate", selectedDate);
                }
            });
        });
    </script>
    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        /* Loader spinner */
        .loader {
            border: 4px solid rgba(255, 255, 255, 0.2);
            border-top: 4px solid #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin-bottom: 15px;
        }

        /* Loader animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Visible state for the overlay */
        .loading-overlay.active {
            visibility: visible;
            opacity: 1;
        }

        /* Loading message styling */
        .loading-overlay p {
            color: white;
            font-size: 18px;
            font-family: Arial, sans-serif;
        }
    </style>
</head>



<body class="hold-transition sidebar-mini">
    <!--<div id="loading-overlay">Loading...</div>-->
    <div id="loading-overlay" class="loading-overlay">
        <div class="loader"></div>
        <p id="loading-message">Loading...</p>
    </div>

    <div class="se-pre-con"></div>
    <!-- Site wrapper -->

    <div class="wrapper">

        <!-- =============================================== -->

        <?php if ($this->session->userdata('isLogIn') == true) { ?>
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
                            <a href="#"><i class="fa fa-universal-access"></i>
                                <?php echo $this->session->userdata('user_role_name'); ?>
                            </a>
                        </div>
                    </div>
                    <!-- sidebar menu -->

                    <ul class="sidebar-menu">
                        <?php if (ismodule_active('GLOBAL') === true && (isfeature_active('ADMINS-OVERALL-PAGE') === true || isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true)) { ?>
                            <li class="treeview">
                                <a href="<?php echo base_url('dashboard/welcome') ?>"> <i class="fa fa-globe"></i><span><?php echo lang_loader('global', 'global_overall_summary_s'); ?></span></a>
                            </li>
                        <?php } ?>
                        <?php if (isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true || isfeature_active('IP-FEEDBACKS-DASHBOARD') === true || isfeature_active('PC-COMPLAINTS-DASHBOARD') === true || isfeature_active('OP-FEEDBACKS-DASHBOARD') === true || isfeature_active('ISR-REQUESTS-DASHBOARD') === true || isfeature_active('INC-INCIDENTS-DASHBOARD') === true || isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true || isfeature_active('ASSET-DASHBOARD') === true) { ?>

                            <?php if ($this->uri->segment(1) != "ipd" || $this->uri->segment(1) != "opf"  || $this->uri->segment(1) != "pc"  || $this->uri->segment(1) != "isr" || $this->uri->segment(1) != "asset") { ?>
                                <li class="treeview <?php echo (($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == 'setupefeedor') ? "active" : null) ?>">
                                    <!-- <a href="#"> -->
                                    <a> <i class="fa fa-bars"></i><span><?php echo lang_loader('global', 'global_modules'); ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <!-- </a> -->
                                    <ul class="treeview-menu">

                                        <?php if (ismodule_active('ADF') === true && isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("admissionfeedback/feedback_dashboard") ?>"><?php echo lang_loader('global', 'global_admission_feedbacks'); ?></a></li>
                                        <?php } ?>

                                        <?php if (ismodule_active('IP') === true && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("ipd/feedback_dashboard") ?>"><?php echo lang_loader('global', 'global_ipd_feedbacks'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("pc/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_inp_complaints'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('PDF') === true && isfeature_active('PDF-FEEDBACKS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("post/feedback_dashboard") ?>"><?php echo lang_loader('global', 'global_pdf_feedbacks'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("opf/feedback_dashboard") ?>"><?php echo lang_loader('global', 'global_ops_feedbacks'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("doctor/feedback_dashboard") ?>">OT Doctor Feedbacks</a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("doctoropd/feedback_dashboard") ?>">OPD Doctor Feedbacks</a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('ISR') === true && isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("isr/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_ir_request'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('INCIDENT') === true && isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("incident/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_incs_report'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('GRIEVANCE') === true && isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("grievance/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_sgs_report'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('QUALITY') === true && isfeature_active('QUALITY-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("quality/quality_welcome_page") ?>">Quality Indicator Manager</a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('AUDIT') === true && isfeature_active('AUDIT-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("audit/audit_welcome_page") ?>">Quality Audit Manager</a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('ASSET') === true && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("asset/ticket_dashboard") ?>">Asset Manager</a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>


                            <?php if ($this->uri->segment(2) != "welcome") { ?>

                                <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true && $this->uri->segment(1) == 'ipd') { ?>
                                    <?php if (in_array('ip_dashboard', $this->session->userdata['active_menu'])) { ?>
                                        <li class="<?php echo (($this->uri->segment(2) == 'feedback_dashboard' && $this->uri->segment(1) == 'ipd') ? "active" : null) ?>">
                                            <a href="<?php echo base_url('ipd/feedback_dashboard') ?>">
                                                <i class="fa fa-home"></i> <span><?php echo lang_loader('global', 'global_dashboard'); ?> </span>

                                            </a>
                                        </li>

                                    <?php } ?>
                                    <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TICKETS-DASHBOARD') === true && $this->uri->segment(1) == 'ipd') { ?>
                                        <?php if (in_array('ip_ticket', $this->session->userdata['active_menu'])) { ?>

                                            <li class="treeview <?php echo (($this->uri->segment(1) == 'ipd' && ($this->uri->segment(2) == "track" || $this->uri->segment(2) == "ticket_resolution_rate" || $this->uri->segment(2) == "average_resolution_time" || $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "ticket_dashboard" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets")) ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_tickets'); ?> </span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>

                                                <ul class="treeview-menu">
                                                    <li><a href="<?php echo base_url("ipd/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_ticket_dashboard'); ?></a></li>
                                                    <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TOTAL-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("ipd/alltickets") ?>"><?php echo lang_loader('global', 'global_all_tickets'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('IP') === true  && isfeature_active('IP-OPEN-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("ipd/opentickets") ?>"><?php echo lang_loader('global', 'global_open_tickets'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('IP') === true  && isfeature_active('IP-CLOSED-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("ipd/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_tickets'); ?></a></li>
                                                    <?php } ?>

                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('IP') === true   && $this->uri->segment(1) == 'ipd' && (isfeature_active('IP-FEEDBACK-REPORTS') === true || isfeature_active('IP-STAFF-APPRECIATION-REPORTS') === true || isfeature_active('IP-CAPA-REPORTS') === true)) { ?>
                                        <?php if (in_array('ip_reports', $this->session->userdata['active_menu'])) { ?>

                                            <li class="treeview  <?php echo (($this->uri->segment(1) == 'ipd' && ($this->uri->segment(2) == "patient_feedback" || $this->uri->segment(2) == "feedbacks_report" || $this->uri->segment(2) == "staff_appreciation" || $this->uri->segment(2) == "capa_report")) ? "active" : null) ?>">
                                                <a href="#">
                                                    <i class="fa fa-bar-chart"></i> <span><?php echo lang_loader('global', 'global_reports'); ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACK-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("ipd/feedbacks_report") ?>"><?php echo lang_loader('global', 'global_feedback_report'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('IP') === true  && isfeature_active('IP-STAFF-APPRECIATION-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("ipd/staff_appreciation") ?>"><?php echo lang_loader('global', 'global_staff_appreciation'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('IP') === true  && isfeature_active('IP-CAPA-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("ipd/capa_report") ?>"><?php echo lang_loader('global', 'global_capa_report'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('IP') === true  &&  $this->uri->segment(1) == 'ipd' && (isfeature_active('IP-NPS') === true || isfeature_active('IP-PSAT') === true)) { ?>
                                        <?php if (in_array('ip_analysis', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo (($this->uri->segment(1) == 'ipd' && ($this->uri->segment(2) == "nps_page" || $this->uri->segment(2) == "nps_passive_list" || $this->uri->segment(2) == "nps_detractors_list" || $this->uri->segment(2) == "nps_promoter_list" ||  $this->uri->segment(2) == "psat_page" || $this->uri->segment(2) == "psat_satisfied_list" ||  $this->uri->segment(2) == "psat_unsatisfied_list")) ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-pie-chart"></i> <span><?php echo lang_loader('global', 'global_analytics'); ?> </span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>

                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('IP') === true  && isfeature_active('IP-NPS') === true) { ?>
                                                        <li><a href="<?php echo base_url("ipd/nps_page") ?>"><?php echo lang_loader('global', 'global_nps'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('IP') === true  && isfeature_active('IP-PSAT') === true) { ?>
                                                        <li><a href="<?php echo base_url("ipd/psat_page") ?>"><?php echo lang_loader('global', 'global_psat'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                                <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-FEEDBACKS-DASHBOARD') === true && $this->uri->segment(1) == 'post') { ?>

                                    <li class="<?php echo (($this->uri->segment(2) == 'feedback_dashboard' && $this->uri->segment(1) == 'post') ? "active" : null) ?>">
                                        <a href="<?php echo base_url('post/feedback_dashboard') ?>">
                                            <i class="fa fa-home"></i> <span><?php echo lang_loader('global', 'global_dashboard'); ?> </span>

                                        </a>
                                    </li>


                                    <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true && $this->uri->segment(1) == 'post') { ?>

                                        <li class="treeview <?php echo (($this->uri->segment(1) == 'post' && ($this->uri->segment(2) == "track" || $this->uri->segment(2) == "ticket_resolution_rate" || $this->uri->segment(2) == "average_resolution_time" || $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "ticket_dashboard" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets")) ? "active" : null) ?> ">
                                            <a href="#">
                                                <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_tickets'); ?> </span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>

                                            <ul class="treeview-menu">
                                                <li><a href="<?php echo base_url("post/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_ticket_dashboard'); ?></a></li>
                                                <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TOTAL-TICKETS') === true) { ?>
                                                    <li><a href="<?php echo base_url("post/alltickets") ?>"><?php echo lang_loader('global', 'global_all_tickets'); ?> </a></li>
                                                <?php } ?>
                                                <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-OPEN-TICKETS') === true) { ?>
                                                    <li><a href="<?php echo base_url("post/opentickets") ?>"><?php echo lang_loader('global', 'global_open_tickets'); ?> </a></li>
                                                <?php } ?>
                                                <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-CLOSED-TICKETS') === true) { ?>
                                                    <li><a href="<?php echo base_url("post/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_tickets'); ?></a></li>
                                                <?php } ?>

                                            </ul>
                                        </li>

                                    <?php } ?>
                                    <?php if (ismodule_active('PDF') === true   && $this->uri->segment(1) == 'post' && (isfeature_active('PDF-FEEDBACK-REPORTS') === true || isfeature_active('PDF-STAFF-APPRECIATION-REPORTS') === true || isfeature_active('PDF-CAPA-REPORTS') === true)) { ?>

                                        <li class="treeview  <?php echo (($this->uri->segment(1) == 'post' && ($this->uri->segment(2) == "patient_feedback" || $this->uri->segment(2) == "feedbacks_report" || $this->uri->segment(2) == "staff_appreciation" || $this->uri->segment(2) == "capa_report")) ? "active" : null) ?>">
                                            <a href="#">
                                                <i class="fa fa-bar-chart"></i> <span><?php echo lang_loader('global', 'global_reports'); ?></span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-FEEDBACK-REPORTS') === true) { ?>
                                                    <li><a href="<?php echo base_url("post/feedbacks_report") ?>"><?php echo lang_loader('global', 'global_feedback_report'); ?></a></li>
                                                <?php } ?>
                                                <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-STAFF-APPRECIATION-REPORTS') === true) { ?>
                                                    <li><a href="<?php echo base_url("post/staff_appreciation") ?>"><?php echo lang_loader('global', 'global_staff_appreciation'); ?></a></li>
                                                <?php } ?>
                                                <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-CAPA-REPORTS') === true) { ?>
                                                    <li><a href="<?php echo base_url("post/capa_report") ?>"><?php echo lang_loader('global', 'global_capa_report'); ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                    <?php } ?>
                                    <?php if (ismodule_active('PDF') === true  &&  $this->uri->segment(1) == 'post' && (isfeature_active('PDF-NPS') === true || isfeature_active('PDF-PSAT') === true)) { ?>
                                        <li class="treeview <?php echo (($this->uri->segment(1) == 'post' && ($this->uri->segment(2) == "nps_page" || $this->uri->segment(2) == "nps_passive_list" || $this->uri->segment(2) == "nps_detractors_list" || $this->uri->segment(2) == "nps_promoter_list" ||  $this->uri->segment(2) == "psat_page" || $this->uri->segment(2) == "psat_satisfied_list" ||  $this->uri->segment(2) == "psat_unsatisfied_list")) ? "active" : null) ?> ">
                                            <a href="#">
                                                <i class="fa fa-pie-chart"></i> <span><?php echo lang_loader('global', 'global_analytics'); ?> </span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>

                                            <ul class="treeview-menu">
                                                <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-NPS') === true) { ?>
                                                    <li><a href="<?php echo base_url("post/nps_page") ?>"><?php echo lang_loader('global', 'global_nps'); ?></a></li>
                                                <?php } ?>
                                                <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-PSAT') === true) { ?>
                                                    <li><a href="<?php echo base_url("post/psat_page") ?>"><?php echo lang_loader('global', 'global_psat'); ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>

                                    <?php } ?>
                                <?php } ?>


                                <?php if (ismodule_active('OP') === true || $this->uri->segment(1) == 'opf') { ?>
                                    <?php if (ismodule_active('OP') === true  && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?>
                                        <?php if (in_array('op_dashboard', $this->session->userdata['active_menu'])) { ?>
                                            <li class="<?php echo (($this->uri->segment(2) == 'feedback_dashboard'  && $this->uri->segment(1) == 'opf') ? "active" : null) ?>">
                                                <a href="<?php echo base_url('opf/feedback_dashboard') ?>">
                                                    <i class="fa fa-home"></i> <span><?php echo lang_loader('global', 'global_dashboard'); ?> </span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('OP') === true  && isfeature_active('OP-TICKETS-DASHBOARD') === true && $this->uri->segment(1) == 'opf') { ?>
                                        <?php if (in_array('op_ticket', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo ($this->uri->segment(1) == 'opf' && ($this->uri->segment(2) == "track"   || $this->uri->segment(2) == "ticket_resolution_rate" || $this->uri->segment(2) == "average_resolution_time" ||  $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "ticket_dashboard" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets") ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_tickets'); ?> </span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>

                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('OP') === true  && isfeature_active('OP-TICKETS-DASHBOARD') === true) { ?>
                                                        <li><a href="<?php echo base_url("opf/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_ticket_dashboard'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('OP') === true  && isfeature_active('OP-TOTAL-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("opf/alltickets") ?>"><?php echo lang_loader('global', 'global_all_tickets'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('OP') === true  && isfeature_active('OP-OPEN-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("opf/opentickets") ?>"><?php echo lang_loader('global', 'global_open_tickets'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('OP') === true  && isfeature_active('OP-CLOSED-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("opf/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_tickets'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('OP') === true  && $this->uri->segment(1) == 'opf' && (isfeature_active('OP-FEEDBACK-REPORTS') === true || isfeature_active('OP-CAPA-REPORTS') === true)) { ?>
                                        <?php if (in_array('op_reports', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview  <?php echo ($this->uri->segment(1) == 'opf' && ($this->uri->segment(2) == "patient_feedback" || $this->uri->segment(2) == "feedbacks_report" || $this->uri->segment(2) == "capa_report") ? "active" : null) ?>">
                                                <a href="#">
                                                    <i class="fa fa-bar-chart"></i> <span><?php echo lang_loader('global', 'global_reports'); ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('OP') === true  && isfeature_active('OP-FEEDBACK-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("opf/feedbacks_report") ?>"><?php echo lang_loader('global', 'global_feedback_report'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('OP') === true  && isfeature_active('OP-CAPA-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("opf/capa_report") ?>"><?php echo lang_loader('global', 'global_capa_report'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('OP') === true  && $this->uri->segment(1) == 'opf' && (isfeature_active('OP-NPS') === true || isfeature_active('OP-PSAT') === true)) { ?>
                                        <?php if (in_array('op_analysis', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo (($this->uri->segment(1) == 'opf' && ($this->uri->segment(2) == "nps_page" || $this->uri->segment(2) == "nps_passive_list" || $this->uri->segment(2) == "nps_detractors_list" || $this->uri->segment(2) == "nps_promoter_list" ||  $this->uri->segment(2) == "psat_page" || $this->uri->segment(2) == "psat_satisfied_list" ||  $this->uri->segment(2) == "psat_unsatisfied_list")) ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-pie-chart"></i> <span><?php echo lang_loader('global', 'global_analytics'); ?> </span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>

                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('OP') === true  && isfeature_active('OP-NPS') === true) { ?>
                                                        <li><a href="<?php echo base_url("opf/nps_page") ?>"><?php echo lang_loader('global', 'global_nps'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('OP') === true  && isfeature_active('OP-PSAT') === true) { ?>
                                                        <li><a href="<?php echo base_url("opf/psat_page") ?>"><?php echo lang_loader('global', 'global_psat'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                                <?php if (ismodule_active('DOCTOR') === true || $this->uri->segment(1) == 'doctor') { ?>
                                    <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?>
                                        <?php if (in_array('doctor_dashboard', $this->session->userdata['active_menu'])) { ?>
                                            <li class="<?php echo (($this->uri->segment(2) == 'feedback_dashboard'  && $this->uri->segment(1) == 'doctor') ? "active" : null) ?>">
                                                <a href="<?php echo base_url('doctor/feedback_dashboard') ?>">
                                                    <i class="fa fa-home"></i> <span><?php echo lang_loader('global', 'global_dashboard'); ?> </span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true && $this->uri->segment(1) == 'doctor') { ?>
                                        <?php if (in_array('doctor_ticket', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo ($this->uri->segment(1) == 'doctor' && ($this->uri->segment(2) == "track"   || $this->uri->segment(2) == "ticket_resolution_rate" || $this->uri->segment(2) == "average_resolution_time" ||  $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "ticket_dashboard" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets") ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_tickets'); ?> </span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>

                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctor/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_ticket_dashboard'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-TOTAL-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctor/alltickets") ?>"><?php echo lang_loader('global', 'global_all_tickets'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-OPEN-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctor/opentickets") ?>"><?php echo lang_loader('global', 'global_open_tickets'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-CLOSED-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctor/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_tickets'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('DOCTOR') === true  && $this->uri->segment(1) == 'doctor' && (isfeature_active('DOCTOR-FEEDBACK-REPORTS') === true || isfeature_active('DOCTOR-CAPA-REPORTS') === true)) { ?>
                                        <?php if (in_array('doctor_reports', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview  <?php echo ($this->uri->segment(1) == 'doctor' && ($this->uri->segment(2) == "patient_feedback" || $this->uri->segment(2) == "feedbacks_report" || $this->uri->segment(2) == "capa_report") ? "active" : null) ?>">
                                                <a href="#">
                                                    <i class="fa fa-bar-chart"></i> <span><?php echo lang_loader('global', 'global_reports'); ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-FEEDBACK-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctor/feedbacks_report") ?>"><?php echo lang_loader('global', 'global_feedback_report'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-CAPA-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctor/capa_report") ?>"><?php echo lang_loader('global', 'global_capa_report'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('DOCTOR') === true  && $this->uri->segment(1) == 'doctor' && (isfeature_active('DOCTOR-NPS') === true || isfeature_active('DOCTOR-PSAT') === true)) { ?>
                                        <?php if (in_array('doctor_analysis', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo (($this->uri->segment(1) == 'doctor' && ($this->uri->segment(2) == "nps_page" || $this->uri->segment(2) == "nps_passive_list" || $this->uri->segment(2) == "nps_detractors_list" || $this->uri->segment(2) == "nps_promoter_list" ||  $this->uri->segment(2) == "psat_page" || $this->uri->segment(2) == "psat_satisfied_list" ||  $this->uri->segment(2) == "psat_unsatisfied_list")) ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-pie-chart"></i> <span><?php echo lang_loader('global', 'global_analytics'); ?> </span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>

                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-NPS') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctor/nps_page") ?>"><?php echo lang_loader('global', 'global_nps'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-PSAT') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctor/psat_page") ?>">DSAT</a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                                <?php if (ismodule_active('DOCTOR-OPD') === true || $this->uri->segment(1) == 'doctoropd') { ?>
                                    <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?>
                                        <?php if (in_array('opddoctor_dashboard', $this->session->userdata['active_menu'])) { ?>
                                            <li class="<?php echo (($this->uri->segment(2) == 'feedback_dashboard'  && $this->uri->segment(1) == 'doctoropd') ? "active" : null) ?>">
                                                <a href="<?php echo base_url('doctoropd/feedback_dashboard') ?>">
                                                    <i class="fa fa-home"></i> <span><?php echo lang_loader('global', 'global_dashboard'); ?> </span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true && $this->uri->segment(1) == 'doctoropd') { ?>
                                        <?php if (in_array('opddoctor_ticket', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo ($this->uri->segment(1) == 'doctoropd' && ($this->uri->segment(2) == "track"   || $this->uri->segment(2) == "ticket_resolution_rate" || $this->uri->segment(2) == "average_resolution_time" ||  $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "ticket_dashboard" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets") ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_tickets'); ?> </span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>

                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctoropd/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_ticket_dashboard'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-TOTAL-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctoropd/alltickets") ?>"><?php echo lang_loader('global', 'global_all_tickets'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-OPEN-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctoropd/opentickets") ?>"><?php echo lang_loader('global', 'global_open_tickets'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-CLOSED-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctoropd/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_tickets'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('DOCTOR-OPD') === true  && $this->uri->segment(1) == 'doctoropd' && (isfeature_active('OPD-DOCTOR-FEEDBACK-REPORTS') === true || isfeature_active('OPD-DOCTOR-CAPA-REPORTS') === true)) { ?>
                                        <?php if (in_array('opddoctor_reports', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview  <?php echo ($this->uri->segment(1) == 'doctoropd' && ($this->uri->segment(2) == "patient_feedback" || $this->uri->segment(2) == "feedbacks_report" || $this->uri->segment(2) == "capa_report") ? "active" : null) ?>">
                                                <a href="#">
                                                    <i class="fa fa-bar-chart"></i> <span><?php echo lang_loader('global', 'global_reports'); ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-FEEDBACK-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctoropd/feedbacks_report") ?>"><?php echo lang_loader('global', 'global_feedback_report'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-CAPA-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctoropd/capa_report") ?>"><?php echo lang_loader('global', 'global_capa_report'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('DOCTOR-OPD') === true  && $this->uri->segment(1) == 'doctoropd' && (isfeature_active('OPD-DOCTOR-NPS') === true || isfeature_active('OPD-DOCTOR-PSAT') === true)) { ?>
                                        <?php if (in_array('opddoctor_analysis', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo (($this->uri->segment(1) == 'doctoropd' && ($this->uri->segment(2) == "nps_page" || $this->uri->segment(2) == "nps_passive_list" || $this->uri->segment(2) == "nps_detractors_list" || $this->uri->segment(2) == "nps_promoter_list" ||  $this->uri->segment(2) == "psat_page" || $this->uri->segment(2) == "psat_satisfied_list" ||  $this->uri->segment(2) == "psat_unsatisfied_list")) ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-pie-chart"></i> <span><?php echo lang_loader('global', 'global_analytics'); ?> </span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>

                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-NPS') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctoropd/nps_page") ?>"><?php echo lang_loader('global', 'global_nps'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-PSAT') === true) { ?>
                                                        <li><a href="<?php echo base_url("doctoropd/psat_page") ?>">DSAT</a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                                <?php if (ismodule_active('PCF') === true || $this->uri->segment(1) == 'pc') { ?>
                                    <?php if (ismodule_active('PCF') === true  && isfeature_active('COMPLAINTS-DASHBOARD') === true && $this->uri->segment(1) == 'pc') { ?>
                                        <?php if (in_array('int_dashboard', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo ($this->uri->segment(1) == 'pc' && ($this->uri->segment(2) == "track" ||   $this->uri->segment(2) == "ticket_resolution_rate" || $this->uri->segment(2) == "average_resolution_time" ||    $this->uri->segment(2) == "ticket_resolution_rate" || $this->uri->segment(2) == "average_resolution_time" || $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "ticket_dashboard" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets") ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_patient_s_complaints'); ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('PCF') === true  && isfeature_active('COMPLAINTS-DASHBOARD') === true) { ?>
                                                        <li><a href="<?php echo base_url("pc/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_complaint_dash'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('PCF') === true  && isfeature_active('TOTAL-COMPLAINTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("pc/alltickets") ?>"><?php echo lang_loader('global', 'global_all_complaints'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('PCF') === true  && isfeature_active('OPEN-COMPLAINTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("pc/opentickets") ?>"><?php echo lang_loader('global', 'global_open_complaints'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('PCF') === true  && isfeature_active('CLOSED-COMPLAINTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("pc/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_complaints'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>

                                    <?php } ?>
                                    <?php if (ismodule_active('PCF') === true  && $this->uri->segment(1) == 'pc' && (isfeature_active('SEARCH-COMPLAINTS') === true || isfeature_active('PC-CAPA-REPORTS') === true)) { ?>
                                        <?php if (in_array('int_reports', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo ($this->uri->segment(1) == 'pc' && ($this->uri->segment(2) == "capa_report" || $this->uri->segment(2) == "patient_complaint") ? "active" : null) ?>">
                                                <a href="#">
                                                    <i class="fa fa-bar-chart"></i> <span><?php echo lang_loader('global', 'global_reports'); ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('PCF') === true  && isfeature_active('SEARCH-COMPLAINTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("pc/patient_complaint") ?>"><?php echo lang_loader('global', 'global_search_complaint'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('PCF') === true  && isfeature_active('PC-CAPA-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("pc/capa_report") ?>"><?php echo lang_loader('global', 'global_action_report'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                                <?php if (ismodule_active('ASSET') === true && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                    <li class="treeview <?php if (in_array(current_url(), [base_url('/departmentasset'), base_url('/assetlocation'), base_url('assetgrade'), base_url('asset/asset_preventive_tickets'), base_url('asset/ticket_dashboard'), base_url('asset/alltickets'), base_url('asset/asset_warranty_reports'), base_url('asset/asset_contract_reports'), base_url('asset/asset_financial_metrices'), base_url('asset/asset_distribution_analysis'), base_url('asset/asset_calibration_tickets')])) echo 'active'; ?>">

                                        <a href="">
                                            <i class="fa fa fa-list-alt"></i><span>Manage Asset Essentials</span>
                                            <span class="pull-right-container">
                                                <i class="fa fa-angle-left pull-right"></i>
                                            </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="<?php echo base_url("asset/alltickets"); ?>">Asset Master</a></li>
                                            <li><a href="<?php echo base_url("asset/asset_preventive_tickets"); ?>">Preventive Maintenance</a></li>
                                            <li><a href="<?php echo base_url("asset/asset_calibration_tickets"); ?>">Asset Calibration</a></li>
                                            <li><a href="<?php echo base_url("asset/asset_contract_reports"); ?>">Asset Contracts</a></li>
                                            <li><a href="<?php echo base_url("asset/asset_warranty_reports"); ?>">Asset Warranty</a></li>
                                            <li><a href="<?php echo base_url("departmentasset"); ?>">Asset Grouping</a></li>
                                            <li><a href="<?php echo base_url("assetlocation"); ?>">Asset Departments</a></li>
                                            <li><a href="<?php echo base_url("assetgrade"); ?>">Asset Grading</a></li>
                                            <li><a href="<?php echo base_url("asset/asset_distribution_analysis"); ?>">Asset Distribution Analysis</a></li>
                                            <li><a href="<?php echo base_url("asset/asset_financial_metrices"); ?>">Asset Financials</a></li>

                                        </ul>
                                    </li>
                                <?php } ?>

                                <?php if (ismodule_active('ASSET') === true && isfeature_active('ASSET-DASHBOARD') === true && $this->uri->segment(1) == 'asset') { ?>

                                    <li class="treeview <?php // echo ($this->uri->segment(1) === 'asset') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url("asset/asset_qrcode"); ?>">
                                            <i class="fa fa-qrcode"></i> <span>Asset QR Codes</span>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- add here -->
                                <?php if (ismodule_active('ADF') === true || $this->uri->segment(1) == 'admissionfeedback') { ?>
                                    <?php if (in_array('adf_dashboard', $this->session->userdata['active_menu'])) { ?>
                                        <li class="<?php echo (($this->uri->segment(2) == 'feedback_dashboard' && $this->uri->segment(1) == 'admissionfeedback') ? "active" : null) ?>">
                                            <a href="<?php echo base_url('admissionfeedback/feedback_dashboard') ?>">
                                                <i class="fa fa-home"></i> <span><?php echo lang_loader('global', 'global_dashboard'); ?> </span>

                                            </a>
                                        </li>

                                    <?php } ?>
                                    <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-TICKETS-DASHBOARD') === true && $this->uri->segment(1) == 'admissionfeedback') { ?>
                                        <?php if (in_array('adf_ticket', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo (($this->uri->segment(1) == 'admissionfeedback' &&  ($this->uri->segment(2) == "track"  || $this->uri->segment(2) == "ticket_resolution_rate" || $this->uri->segment(2) == "average_resolution_time" ||  $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "ticket_dashboard" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets")) ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_tickets'); ?> </span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>

                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?>
                                                        <li><a href="<?php echo base_url("admissionfeedback/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_ticket_dashboard'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-TOTAL-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("admissionfeedback/alltickets") ?>"><?php echo lang_loader('global', 'global_all_tickets'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-OPEN-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("admissionfeedback/opentickets") ?>"><?php echo lang_loader('global', 'global_open_tickets'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-CLOSED-TICKETS') === true) { ?>
                                                        <li><a href="<?php echo base_url("admissionfeedback/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_tickets'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if (ismodule_active('ADF') === true  && $this->uri->segment(1) == 'admissionfeedback' && (isfeature_active('ADF-FEEDBACK-REPORTS') === true || isfeature_active('ADF-CAPA-REPORTS') === true)) { ?>
                                        <?php if (in_array('adf_reports', $this->session->userdata['active_menu'])) { ?>

                                            <li class="treeview  <?php echo (($this->uri->segment(1) == 'admissionfeedback' && ($this->uri->segment(2) == "patient_feedback" || $this->uri->segment(2) == "feedbacks_report" || $this->uri->segment(2) == "staff_appreciation" || $this->uri->segment(2) == "capa_report")) ? "active" : null) ?>">
                                                <a href="#">
                                                    <i class="fa fa-bar-chart"></i> <span><?php echo lang_loader('global', 'global_reports'); ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-FEEDBACK-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("admissionfeedback/feedbacks_report") ?>"><?php echo lang_loader('global', 'global_feedback_report'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-CAPA-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("admissionfeedback/capa_report") ?>"><?php echo lang_loader('global', 'global_capa_report'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('ADF') === true  && $this->uri->segment(1) == 'admissionfeedback' && (isfeature_active('ADF-NPS') === true || isfeature_active('ADF-PSAT') === true)) { ?>
                                        <?php if (in_array('adf_analysis', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo (($this->uri->segment(1) == 'admissionfeedback' && ($this->uri->segment(2) == "nps_page" || $this->uri->segment(2) == "nps_passive_list" || $this->uri->segment(2) == "nps_detractors_list" || $this->uri->segment(2) == "nps_promoter_list" ||  $this->uri->segment(2) == "psat_page" || $this->uri->segment(2) == "psat_satisfied_list" ||  $this->uri->segment(2) == "psat_unsatisfied_list")) ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-pie-chart"></i> <span><?php echo lang_loader('global', 'global_analytics'); ?> </span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>

                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-NPS') === true) { ?>
                                                        <li><a href="<?php echo base_url("admissionfeedback/nps_page") ?>"><?php echo lang_loader('global', 'global_nps'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-PSAT') === true) { ?>
                                                        <li><a href="<?php echo base_url("admissionfeedback/psat_page") ?>"><?php echo lang_loader('global', 'global_psat'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>



                                <?php if (ismodule_active('ISR') === true || $this->uri->segment(1) == 'isr') { ?>
                                    <?php if (ismodule_active('ISR') === true  && isfeature_active('REQUESTS-DASHBOARD') === true && $this->uri->segment(1) == 'isr') { ?>
                                        <?php if (in_array('esr_dashboard', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo ($this->uri->segment(1) == 'isr' && ($this->uri->segment(2) == "track"  || $this->uri->segment(2) == "ticket_resolution_rate" || $this->uri->segment(2) == "average_resolution_time" ||  $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "ticket_dashboard" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets") ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_ir_request'); ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('ISR') === true  && isfeature_active('REQUESTS-DASHBOARD') === true) { ?>
                                                        <li><a href="<?php echo base_url("isr/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_request_dashboard'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('ISR') === true  && isfeature_active('TOTAL-REQUESTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("isr/alltickets") ?>"><?php echo lang_loader('global', 'global_all_requests'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('ISR') === true  && isfeature_active('OPEN-REQUESTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("isr/opentickets") ?>"><?php echo lang_loader('global', 'global_open_requests'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('ISR') === true  && isfeature_active('CLOSED-REQUESTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("isr/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_requests'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if (ismodule_active('ISR') === true  && $this->uri->segment(1) == 'isr' && (isfeature_active('SEARCH-REQUESTS') === true || isfeature_active('ISR-CAPA-REPORTS') === true)) { ?>
                                        <?php if (in_array('esr_reports', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo ($this->uri->segment(1) == 'isr' && ($this->uri->segment(2) == "capa_report" || $this->uri->segment(2) == "employee_complaint") ? "active" : null) ?>">
                                                <a href="#">
                                                    <i class="fa fa-bar-chart"></i> <span><?php echo lang_loader('global', 'global_reports'); ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('ISR') === true  && isfeature_active('SEARCH-REQUESTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("isr/employee_complaint") ?>"><?php echo lang_loader('global', 'global_search_requests'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('ISR') === true  && isfeature_active('ISR-CAPA-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("isr/capa_report") ?>"><?php echo lang_loader('global', 'global_action_report'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>



                                <?php if (ismodule_active('INCIDENT') === true || $this->uri->segment(1) == 'incident') { ?>
                                    <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('INCIDENTS-DASHBOARD') === true && $this->uri->segment(1) == 'incident') { ?>
                                        <?php if (in_array('inci_dashboard', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo ($this->uri->segment(1) == 'incident' && ($this->uri->segment(2) == "track"  || $this->uri->segment(2) == "ticket_resolution_rate" || $this->uri->segment(2) == "average_resolution_time" ||  $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "ticket_dashboard" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets") ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_incidents'); ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('INCIDENTS-DASHBOARD') === true) { ?>
                                                        <li><a href="<?php echo base_url("incident/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_inc_dash'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('TOTAL-INCIDENTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("incident/alltickets") ?>"><?php echo lang_loader('global', 'global_all_inc'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('OPEN-INCIDENTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("incident/opentickets") ?>"><?php echo lang_loader('global', 'global_open_inc'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('CLOSED-INCIDENTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("incident/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_inc'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (ismodule_active('INCIDENT') === true  && $this->uri->segment(1) == 'incident' && (isfeature_active('SEARCH-INCIDENTS') === true || isfeature_active('IN-CAPA-REPORTS') === true)) { ?>
                                        <?php if (in_array('inci_reports', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo ($this->uri->segment(1) == 'incident' && ($this->uri->segment(2) == "capa_report" || $this->uri->segment(2) == "employee_complaint") ? "active" : null) ?>">
                                                <a href="#">
                                                    <i class="fa fa-bar-chart"></i> <span><?php echo lang_loader('global', 'global_reports'); ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('SEARCH-INCIDENTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("incident/employee_complaint") ?>"><?php echo lang_loader('global', 'global_search_inc'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('IN-CAPA-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("incident/capa_report") ?>"><?php echo lang_loader('global', 'global_action_report'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>

                                <?php } ?>

                                <?php if (ismodule_active('GRIEVANCE') === true || $this->uri->segment(1) == 'grievance') { ?>
                                    <?php if (ismodule_active('GRIEVANCE') === true  && isfeature_active('GRIEVANCES-DASHBOARD') === true && $this->uri->segment(1) == 'grievance') { ?>
                                        <?php if (in_array('grievance_dashboard', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo ($this->uri->segment(1) == 'grievance' && ($this->uri->segment(2) == "track"  || $this->uri->segment(2) == "ticket_resolution_rate" || $this->uri->segment(2) == "average_resolution_time" ||  $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "ticket_dashboard" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets") ? "active" : null) ?> ">
                                                <a href="#">
                                                    <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_sgs'); ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('GRIEVANCE') === true  && isfeature_active('GRIEVANCES-DASHBOARD') === true) { ?>
                                                        <li><a href="<?php echo base_url("grievance/ticket_dashboard") ?>"><?php echo lang_loader('global', 'global_grievances_dash'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('GRIEVANCE') === true  && isfeature_active('TOTAL-GRIEVANCES') === true) { ?>
                                                        <li><a href="<?php echo base_url("grievance/alltickets") ?>"><?php echo lang_loader('global', 'global_all_gs'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('GRIEVANCE') === true  && isfeature_active('OPEN-GRIEVANCES') === true) { ?>
                                                        <li><a href="<?php echo base_url("grievance/opentickets") ?>"><?php echo lang_loader('global', 'global_open_grievance'); ?> </a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('GRIEVANCE') === true  && isfeature_active('CLOSED-GRIEVANCES') === true) { ?>
                                                        <li><a href="<?php echo base_url("grievance/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_grievance'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if (ismodule_active('GRIEVANCE') === true  && $this->uri->segment(1) == 'grievance' && (isfeature_active('SEARCH-GRIEVANCES') === true || isfeature_active('SG-CAPA-REPORTS') === true)) { ?>
                                        <?php if (in_array('grievance_reports', $this->session->userdata['active_menu'])) { ?>
                                            <li class="treeview <?php echo ($this->uri->segment(1) == 'grievance' && ($this->uri->segment(2) == "capa_report" || $this->uri->segment(2) == "employee_complaint") ? "active" : null) ?>">
                                                <a href="#">
                                                    <i class="fa fa-bar-chart"></i> <span><?php echo lang_loader('global', 'global_reports'); ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php if (ismodule_active('GRIEVANCE') === true  && isfeature_active('SEARCH-GRIEVANCES') === true) { ?>
                                                        <li><a href="<?php echo base_url("grievance/employee_complaint") ?>"><?php echo lang_loader('global', 'global_search_grievances'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if (ismodule_active('GRIEVANCE') === true  && isfeature_active('SG-CAPA-REPORTS') === true) { ?>
                                                        <li><a href="<?php echo base_url("grievance/capa_report") ?>"><?php echo lang_loader('global', 'global_action_report'); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>


                        <?php if (ismodule_active('GLOBAL') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true) { ?>
                            <?php if ($this->uri->segment(1) != "ipd" || $this->uri->segment(1) != "opf"  || $this->uri->segment(1) != "pc" || $this->uri->segment(1) != "isr" || $this->uri->segment(1) != "doctor" || $this->uri->segment(1) != "doctoropd") { ?>
                                <li class="treeview <?php echo (($this->uri->segment(2) == 'welcome' || $this->uri->segment(1) == 'setupefeedor') ? "active" : null) ?>">
                                    <!-- <a href="#"> -->
                                    <a href="<?php echo base_url('dashboard/welcome') ?>"> <i class="fa fa-area-chart"></i><span><?php echo lang_loader('global', 'global_ticket_dash'); ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <!-- </a> -->
                                    <ul class="treeview-menu">
                                        <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("admissionfeedback/department_tickets") ?>"><?php echo lang_loader('global', 'global_adfs_tickets'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TICKETS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("ipd/department_tickets") ?>"><?php echo lang_loader('global', 'global_ips_tickets'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('PCF') === true  && isfeature_active('COMPLAINTS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("pc/department_tickets") ?>"><?php echo lang_loader('global', 'global_inp_complaints'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("post/department_tickets") ?>"><?php echo lang_loader('global', 'global_pdf_ticketss'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('OP') === true  && isfeature_active('OP-TICKETS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("opf/department_tickets") ?>"><?php echo lang_loader('global', 'global_ops_tickets'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("doctor/department_tickets") ?>">OT Doctors Ticket</a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("doctoropd/department_tickets") ?>">OPD Doctors Ticket</a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('ISR') === true  && isfeature_active('REQUESTS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("isr/department_tickets") ?>"><?php echo lang_loader('global', 'global_ir_request'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('INCIDENTS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("incident/department_tickets") ?>"><?php echo lang_loader('global', 'global_incs_report'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('GRIEVANCE') === true  && isfeature_active('GRIEVANCES-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("grievance/department_tickets") ?>"><?php echo lang_loader('global', 'global_sgs_report'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>

                            <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TICKETS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true && $this->uri->segment(1) == "ipd") { ?>

                                <li class="treeview <?php echo ((($this->uri->segment(1) == "ipd") && ($this->uri->segment(2) == "patient_feedback" || $this->uri->segment(2) == "track" || $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "department_tickets" ||  $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets")) ? "active" : null) ?> ">
                                    <a href="#">
                                        <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_ips_tickets'); ?> </span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TICKETS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("ipd/department_tickets") ?>"><?php echo lang_loader('global', 'global_ticket_dashboard'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TOTAL-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("ipd/alltickets") ?>"><?php echo lang_loader('global', 'global_all_tickets'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('IP') === true  && isfeature_active('IP-OPEN-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("ipd/opentickets") ?>"><?php echo lang_loader('global', 'global_open_tickets'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('IP') === true  && isfeature_active('IP-CLOSED-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("ipd/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_tickets'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>



                            <?php } ?>

                            <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true && $this->uri->segment(1) == "post") { ?>

                                <li class="treeview <?php echo ((($this->uri->segment(1) == "post") && ($this->uri->segment(2) == "patient_feedback" || $this->uri->segment(2) == "track" || $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "department_tickets" ||  $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets")) ? "active" : null) ?> ">
                                    <a href="#">
                                        <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_pdf_ticketss'); ?> </span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("post/department_tickets") ?>"><?php echo lang_loader('global', 'global_ticket_dashboard'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TOTAL-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("post/alltickets") ?>"><?php echo lang_loader('global', 'global_all_tickets'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-OPEN-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("post/opentickets") ?>"><?php echo lang_loader('global', 'global_open_tickets'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-CLOSED-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("post/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_tickets'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>



                            <?php } ?>

                            <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-TICKETS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true && $this->uri->segment(1) == "admissionfeedback") { ?>

                                <li class="treeview <?php echo ((($this->uri->segment(1) == "admissionfeedback") && ($this->uri->segment(2) == "track" || $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "department_tickets" ||  $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets")) ? "active" : null) ?> ">
                                    <a href="#">
                                        <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_adfs_tickets'); ?> </span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-TICKETS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true) { ?>
                                            <li><a href="<?php echo base_url("admissionfeedback/department_tickets") ?>"><?php echo lang_loader('global', 'global_ticket_dashboard'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-TOTAL-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("admissionfeedback/alltickets") ?>"><?php echo lang_loader('global', 'global_all_tickets'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-OPEN-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("admissionfeedback/opentickets") ?>"><?php echo lang_loader('global', 'global_open_tickets'); ?> </a></li>
                                        <?php } ?>

                                        <?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-CLOSED-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("admissionfeedback/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_tickets'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>



                            <?php } ?>

                            <?php if (ismodule_active('OP') === true  && isfeature_active('OP-TICKETS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true && $this->uri->segment(1) == "opf") { ?>

                                <li class="treeview <?php echo ((($this->uri->segment(1) == "opf") && ($this->uri->segment(2) == "patient_feedback" || $this->uri->segment(2) == "track" || $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "department_tickets" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets")) ? "active" : null) ?> ">
                                    <a href="#">
                                        <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_ops_tickets'); ?> </span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php if (ismodule_active('OP') === true  && isfeature_active('OP-TICKETS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true) { ?>
                                            <li><a href="<?php echo base_url("opf/department_tickets") ?>"><?php echo lang_loader('global', 'global_ticket_dashboard'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('OP') === true  && isfeature_active('OP-TOTAL-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("opf/alltickets") ?>"><?php echo lang_loader('global', 'global_all_tickets'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('OP') === true  && isfeature_active('OP-OPEN-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("opf/opentickets") ?>"><?php echo lang_loader('global', 'global_open_tickets'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('OP') === true  && isfeature_active('OP-CLOSED-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("opf/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_tickets'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>



                            <?php } ?>


                            <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true && $this->uri->segment(1) == "doctor") { ?>

                                <li class="treeview <?php echo ((($this->uri->segment(1) == "doctor") && ($this->uri->segment(2) == "patient_feedback" || $this->uri->segment(2) == "track" || $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "department_tickets" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets")) ? "active" : null) ?> ">
                                    <a href="#">
                                        <i class="fa fa-ticket"></i> <span>OT Doctor Tickets</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true) { ?>
                                            <li><a href="<?php echo base_url("doctor/department_tickets") ?>"><?php echo lang_loader('global', 'global_ticket_dashboard'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-TOTAL-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("doctor/alltickets") ?>"><?php echo lang_loader('global', 'global_all_tickets'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-OPEN-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("doctor/opentickets") ?>"><?php echo lang_loader('global', 'global_open_tickets'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('DOCTOR') === true  && isfeature_active('DOCTOR-CLOSED-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("doctor/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_tickets'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>



                            <?php } ?>

                            <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true && $this->uri->segment(1) == "doctoropd") { ?>

                                <li class="treeview <?php echo ((($this->uri->segment(1) == "doctoropd") && ($this->uri->segment(2) == "patient_feedback" || $this->uri->segment(2) == "track" || $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "department_tickets" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets")) ? "active" : null) ?> ">
                                    <a href="#">
                                        <i class="fa fa-ticket"></i> <span>OPD Doctor Tickets </span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true) { ?>
                                            <li><a href="<?php echo base_url("doctoropd/department_tickets") ?>"><?php echo lang_loader('global', 'global_ticket_dashboard'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-TOTAL-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("doctoropd/alltickets") ?>"><?php echo lang_loader('global', 'global_all_tickets'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-OPEN-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("doctoropd/opentickets") ?>"><?php echo lang_loader('global', 'global_open_tickets'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('DOCTOR-OPD') === true  && isfeature_active('OPD-DOCTOR-CLOSED-TICKETS') === true) { ?>
                                            <li><a href="<?php echo base_url("doctoropd/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_tickets'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>

                            <?php } ?>

                            <?php if (ismodule_active('PCF') === true  && isfeature_active('COMPLAINTS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true && $this->uri->segment(1) == "pc") { ?>

                                <li class="treeview <?php echo ((($this->uri->segment(1) == "pc") && ($this->uri->segment(2) == "patient_complaint" || $this->uri->segment(2) == "track" || $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "department_tickets" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets")) ? "active" : null) ?> ">
                                    <a href="#">
                                        <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_patient_s_complaints'); ?> </span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php if (ismodule_active('PCF') === true  && isfeature_active('COMPLAINTS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true) { ?>
                                            <li><a href="<?php echo base_url("pc/department_tickets") ?>"><?php echo lang_loader('global', 'global_complaint_dash'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('PCF') === true  && isfeature_active('TOTAL-COMPLAINTS') === true) { ?>
                                            <li><a href="<?php echo base_url("pc/alltickets") ?>"><?php echo lang_loader('global', 'global_all_complaints'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('PCF') === true  && isfeature_active('OPEN-COMPLAINTS') === true) { ?>
                                            <li><a href="<?php echo base_url("pc/opentickets") ?>"><?php echo lang_loader('global', 'global_open_complaints'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('PCF') === true  && isfeature_active('CLOSED-COMPLAINTS') === true) { ?>
                                            <li><a href="<?php echo base_url("pc/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_complaints'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>

                            <?php } ?>

                            <?php if (ismodule_active('ISR') === true  && isfeature_active('REQUESTS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true && $this->uri->segment(1) == "isr") { ?>

                                <li class="treeview <?php echo ((($this->uri->segment(1) == "isr") && ($this->uri->segment(2) == "employee_complaint" || $this->uri->segment(2) == "track" || $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "department_tickets" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets")) ? "active" : null) ?> ">
                                    <a href="#">
                                        <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_ir_request'); ?> </span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php if (ismodule_active('ISR') === true  && isfeature_active('REQUESTS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true) { ?>
                                            <li><a href="<?php echo base_url("isr/department_tickets") ?>"><?php echo lang_loader('global', 'global_request_dashboard'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('ISR') === true  && isfeature_active('TOTAL-REQUESTS') === true) { ?>
                                            <li><a href="<?php echo base_url("isr/alltickets") ?>"><?php echo lang_loader('global', 'global_all_requests'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('ISR') === true  && isfeature_active('OPEN-REQUESTS') === true) { ?>
                                            <li><a href="<?php echo base_url("isr/opentickets") ?>"><?php echo lang_loader('global', 'global_open_requests'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('ISR') === true  && isfeature_active('CLOSED-REQUESTS') === true) { ?>
                                            <li><a href="<?php echo base_url("isr/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_requests'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>

                            <?php } ?>


                            <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('INCIDENTS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true && $this->uri->segment(1) == "incident") { ?>

                                <li class="treeview <?php echo ((($this->uri->segment(1) == "incident") && ($this->uri->segment(2) == "track" || $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "department_tickets" || $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets")) ? "active" : null) ?> ">
                                    <a href="#">
                                        <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_incidents'); ?> </span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('INCIDENTS-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true) { ?>
                                            <li><a href="<?php echo base_url("incident/department_tickets") ?>"><?php echo lang_loader('global', 'global_inc_dash'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('TOTAL-INCIDENTS') === true) { ?>
                                            <li><a href="<?php echo base_url("incident/alltickets") ?>"><?php echo lang_loader('global', 'global_all_inc'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('OPEN-INCIDENTS') === true) { ?>
                                            <li><a href="<?php echo base_url("incident/opentickets") ?>"><?php echo lang_loader('global', 'global_open_inc'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('INCIDENT') === true  && isfeature_active('CLOSED-INCIDENTS') === true) { ?>
                                            <li><a href="<?php echo base_url("incident/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_inc'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>

                            <?php } ?>

                            <?php if (ismodule_active('GRIEVANCE') === true  && isfeature_active('GRIEVANCES-DASHBOARD') === true && isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === true && $this->uri->segment(1) == "grievance") { ?>

                                <li class="treeview <?php echo ((($this->uri->segment(1) == "grievance") && ($this->uri->segment(2) == "employee_complaint" || $this->uri->segment(2) == "track" || $this->uri->segment(2) == "addressedtickets" || $this->uri->segment(2) == "department_tickets" ||  $this->uri->segment(2) == "alltickets" || $this->uri->segment(2) == "opentickets" || $this->uri->segment(2) == "closedtickets")) ? "active" : null) ?> ">
                                    <a href="#">
                                        <i class="fa fa-ticket"></i> <span><?php echo lang_loader('global', 'global_gievance_ticket'); ?> </span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php if (ismodule_active('GRIEVANCE') === true  && isfeature_active('GRIEVANCES-DASHBOARD') === true) { ?>
                                            <li><a href="<?php echo base_url("grievance/department_tickets") ?>"><?php echo lang_loader('global', 'global_grievance_dash'); ?></a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('GRIEVANCE') === true  && isfeature_active('TOTAL-GRIEVANCES') === true) { ?>
                                            <li><a href="<?php echo base_url("grievance/alltickets") ?>"><?php echo lang_loader('global', 'global_all_g'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('GRIEVANCE') === true  && isfeature_active('OPEN-GRIEVANCES') === true) { ?>
                                            <li><a href="<?php echo base_url("grievance/opentickets") ?>"><?php echo lang_loader('global', 'global_open_g'); ?> </a></li>
                                        <?php } ?>
                                        <?php if (ismodule_active('GRIEVANCE') === true  && isfeature_active('CLOSED-GRIEVANCES') === true) { ?>
                                            <li><a href="<?php echo base_url("grievance/closedtickets") ?>"><?php echo lang_loader('global', 'global_closed_g'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>



                            <?php } ?>

                            <li class="treeview <?php echo (($this->uri->segment(2) == "departmenthead") ? "active" : null) ?> ">
                                <a href="<?php echo base_url("dashboard/departmenthead") ?>">
                                    <i class="fa fa-sitemap"></i><span><?php echo lang_loader('global', 'global_your_dep'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (ismodule_active('GLOBAL') === true && isfeature_active('CONSOLIDATED-REPORT') === true && !($this->uri->segment(1) == 'asset' && (ismodule_active('ASSET') === true || isfeature_active('ASSET-DASHBOARD') === true))) { ?>


                            <li class="treeview <?php echo (($this->uri->segment(1) == "view") ? "active" : null) ?>" data-toggle="tooltip" data-placement="right" title="View <?php echo lang_loader('global', 'global_consolidated_report'); ?>">
                                <a href="<?php echo base_url("view/consolidated_report") ?>" target="_blank"> <i class="fa fa-file"></i><span><?php echo lang_loader('global', 'global_consolidated_report'); ?></span></a>
                            </li>
                        <?php } ?>

                        <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ALL-DOWNLOADS') === true && !($this->uri->segment(1) == 'asset' && (ismodule_active('ASSET') === true || isfeature_active('ASSET-DASHBOARD') === true))) { ?>


                            <li class="treeview <?php echo (($this->uri->segment(1) == "view") ? "active" : null) ?>" data-toggle="tooltip" data-placement="right" title="View <?php echo lang_loader('global', 'global_all_downloads'); ?>">
                                <a href="<?php echo base_url("/downloads") ?>" target="_blank"> <i class="fa fa-download"></i><span><?php echo lang_loader('global', 'global_all_downloads'); ?></span></a>
                            </li>
                        <?php } ?>

                        <?php if (isfeature_active('DEPARTMENT-HEAD-OVERALL-PAGE') === false && isfeature_active('ADMINS-OVERALL-PAGE') === false && isfeature_active('ADD-PATIENT') === false) { ?>


                            <li class="treeview <?php echo (($this->uri->segment(1) == "view") ? "active" : null) ?>" data-toggle="tooltip" data-placement="right" title="">
                                <a href="<?php echo base_url("/Devcheck/devhome") ?>" target="_blank"> <i class="fa fa-download"></i><span>Add Departments</span></a>
                            </li>
                        <?php } ?>

                        <?php if ((isfeature_active('EDIT-PATIENT') || isfeature_active('VIEW-PATIENT') || isfeature_active('ADD-PATIENT') || isfeature_active('DISCHARGE-PATIENT')) && !($this->uri->segment(1) == 'asset' && (ismodule_active('ASSET') || isfeature_active('ASSET-DASHBOARD')))) { ?>

                            <li class="treeview <?php echo (($this->uri->segment(1) == "patient") ? "active" : null) ?>">
                                <a href="#">
                                    <i class="fa fa-bed"></i> <span><?php echo lang_loader('global', 'global_admission_section'); ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if (ismodule_active('ADMISSION SECTION') === true  && isfeature_active('ADD-PATIENT') === true) { ?>
                                        <li><a href="<?php echo base_url("patient/create") ?>"><?php echo lang_loader('global', 'global_admit_patient'); ?></a></li>
                                    <?php } ?>
                                    <?php if (ismodule_active('ADMISSION SECTION') === true  && (isfeature_active('VIEW-PATIENT') === true || isfeature_active('DISCHARGE-PATIENT') === true)) { ?>
                                        <li><a href="<?php echo base_url("patient") ?>"><?php echo lang_loader('global', 'global_ip_list'); ?></a></li>
                                    <?php } ?>
                                    <?php if (ismodule_active('ADMISSION SECTION') === true  && isfeature_active('DISCHARGE-PATIENT') === true) { ?>
                                        <li><a href="<?php echo base_url("patient/discharged") ?>"><?php echo lang_loader('global', 'global_dis_ip'); ?> </a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (isfeature_active('EDIT-OUTPATIENT') === true || isfeature_active('VIEW-OUTPATIENT') === true  || isfeature_active('ADD-OUTPATIENT') === true || isfeature_active('DISCHARGE-OUTPATIENT') === true) { ?>
                            <li class="treeview <?php echo (($this->uri->segment(1) == "patientop") ? "active" : null) ?>">
                                <a href="#">
                                    <i class="fa fa-file-text-o"></i> <span><?php echo lang_loader('global', 'global_admission_section_op'); ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if (ismodule_active('OUTPATIENT SECTION') === true  && isfeature_active('ADD-OUTPATIENT') === true) { ?>
                                        <li><a href="<?php echo base_url("patientop/create") ?>"><?php echo lang_loader('global', 'global_admit_patient_op'); ?></a></li>
                                    <?php } ?>
                                    <?php if (ismodule_active('OUTPATIENT SECTION') === true  && (isfeature_active('VIEW-OUTPATIENT') === true || isfeature_active('DISCHARGE-OUTPATIENT') === true)) { ?>
                                        <li><a href="<?php echo base_url("patientop") ?>"><?php echo lang_loader('global', 'global_ip_list_op'); ?></a></li>
                                    <?php } ?>
                                    <?php if (ismodule_active('OUTPATIENT SECTION') === true  && isfeature_active('DISCHARGE-OUTPATIENT') === true) { ?>
                                        <li><a href="<?php echo base_url("patientop/discharged") ?>"><?php echo lang_loader('global', 'global_dis_op'); ?> </a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (ismodule_active('GLOBAL') === true && isfeature_active('SETTINGS') === true || $this->session->userdata['user_role'] == 1) { ?>

                            <li class="treeview <?php echo ($this->uri->segment(1) == "settings" ? "active" : null) ?>">
                                <a href="#">
                                    <i class="fa fa-gear"></i></i> <span><?php echo lang_loader('global', 'global_settings'); ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ORGANIZATION-PROFILE') === true || $this->session->userdata['user_role'] == 1) { ?>
                                        <li><a href="<?php echo base_url("settings/organization_profile") ?>"><?php echo lang_loader('global', 'global_org_profile'); ?></a></li>
                                    <?php } ?>
                                    <?php if (ismodule_active('GLOBAL') === true && isfeature_active('APPLICATION-SETTINGS') === true || $this->session->userdata['user_role'] == 1) { ?>
                                        <li><a href="<?php echo base_url("settings") ?>"><?php echo lang_loader('global', 'global_app_setting'); ?></a></li>
                                    <?php } ?>
                                    <?php if (ismodule_active('GLOBAL') === true && isfeature_active('MANAGE-SUBSCRIPTION') === true || $this->session->userdata['user_role'] == 1) { ?>
                                        <li><a href="<?php echo base_url("subscription/organization") ?>"><?php echo lang_loader('global', 'global_manage_sub'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ARCHIVE-DATA') === true) { ?>
                            <?php
                            $url = base_url();
                            $old_prefix = "archive-";
                            $new_url = str_replace("https://", "https://" . $old_prefix, $url);
                            ?>
                            <li class="treeview" data-toggle="tooltip" data-placement="bottom" title="This section provides access to all historical data collected prior to the software version and structural update, allowing admins to review past information.">
                                <a href="<?php echo $new_url; ?>" target="_blank"> <i class="fa fa-archive"></i><span><?php echo lang_loader('global', 'global_archive_data'); ?></span></a>
                            </li>

                        <?php } ?>

                        <?php if (ismodule_active('GLOBAL') === true && isfeature_active('USER-ACTIVITY') === true) { ?>
                            <li><a href="<?php echo base_url("view/user_activity") ?>"><i class="fa fa-user"></i> User Activity</a></li>


                        <?php } ?>

                    </ul>




                </div>

                <!-- /.sidebar -->

            </aside>
        <?php } ?>

        <!-- =============================================== -->

        <?php if ($this->session->userdata('isLogIn') == true) { ?>

            <header class="main-header">

                <?php if ($this->session->userdata['user_role'] >= 1) { ?>
                    <a href="<?php echo base_url('dashboard/swithc?type=1') ?>" class="logo">
                        <?php $a['logo'] = $this->session->userdata['logo'];  ?>
                        <span class="logo-mini">
                            <img src="<?php echo (!empty($a) ? base_url('uploads/' . $a['logo']) : null) ?>" width="50px" height="60px" alt="">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo (!empty($a) ? base_url('uploads/' . $a['logo']) : null) ?>" width="130" height="60px" alt="">
                        </span>
                    </a>
                <?php } else { ?>
                    <a href="<?php echo base_url('dashboard/swithc?type=1') ?>" class="logo">
                        <?php $a['logo'] = $this->session->userdata['logo'];      ?>
                        <span class="logo-mini">
                            <img src="<?php echo (!empty($a) ? base_url('uploads/' . $a['logo']) : null) ?>" width="50px" height="60px" alt="">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo (!empty($a) ? base_url('uploads/' . $a['logo']) : null) ?>" width="130" height="60px" alt="">
                        </span>
                    </a>
                <?php } ?>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" style="    background: #dadada;">
                    <ul class="nav navbar-nav" style="display: inline-flex; float:left;">
                        <li>
                            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
                                <span class="sr-only"><?php echo lang_loader('global', 'global_toogle_navi'); ?></span>
                                <span class="pe-7s-keypad"></span>
                            </a>
                        </li>
                        <li>
                            <span class="nav navbar-nav" style="margin-left: 10px; margin-bottom: 2px; margin-top:5px; position:absolute;">
                                <span class="content-icon"><img src="<?php echo base_url("assets/images/eflogo.png"); ?>" style="height: 40px; width: 40px; margin-top: 5px;" alt=""></span>
                            </span>
                        </li>
                        <li>
                               <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div class="navheader"><?php echo lang_loader('global', 'global_efeedor_patient_exp'); ?></div>
                                <?php if (ismodule_active('ISR') === true && (isfeature_active('ISR-REQUESTS-DASHBOARD') === true || isfeature_active('REQUESTS-DASHBOARD') === true)) { ?>
                             <!--       <a class="btn btn-success btn-sm" target="_blank" style="background: #62c52d; font-size: 13px; margin-left: 10px; margin-top: 10px; border: none;" data-placement="bottom" data-toggle="tooltip"
                                        title="Raise requests"
                                        href="<?php // echo  base_url($this->uri . '/isrf?user_id=' . $this->session->userdata['user_id']) ?>"
                                        style="margin-right: 10px;">
                                        Raise requests
                                    </a> --!>
                                <?php } ?>
                            </div>
                        </li>
                    </ul>
                    <style>
                        .navheader {
                            font-size: 22px;
                            display: flex;
                            padding: 14px;
                            margin-left: 45px;
                            font-weight: bold;
                            margin-top: 7px;
                        }

                        @media (max-width: 1000px) {
                            .navheader {
                                display: none;
                            }
                        }
                    </style>

                    <ul class="nav navbar-nav p-r-30" style="display: inline-flex; float:right; ">
                        <?php if ($this->uri->segment(2) != 'welcome') { ?>
                            <?php $this->load->view('layout/notifiation'); ?>
                        <?php } ?>
                        <?php if ($this->uri->segment(2) != 'welcome') { ?>
                            <?php $this->load->view('layout/bell');  ?>
                        <?php } ?>
                        <li class="dropdown dropdown-user">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user-o"></i></a>
                            <ul class="dropdown-menu" style="margin-left: -114px; width: 100px;     position: absolute;   background: #fff;">
                                <li><a href="<?php echo base_url('dashboard/profile'); ?>"><i class="fa fa-id-card"></i>Profile</a></li>
                                <li><a href="<?php echo base_url('dashboard/form'); ?>"><i class="fa fa-pencil-square"></i>Edit Profile</a></li>
                                <li><a href="<?php echo base_url('logout') ?>"><i class="fa fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    </ul>
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
                </nav>
            </header>
        <?php } ?>

        <?php if ($this->session->userdata('isLogIn') == true) { ?>
            <div class="content-wrapper">
                <?php if (show_filter($this->uri->segment(1), $this->uri->segment(2)) === true) {
                    if (is_mobile() === true) {
                        $this->load->view('layout/filter_mob');
                    } else {
                        $this->load->view('layout/filter');
                    }
                }
                ?>
                <!-- Content Header (Page header) -->

                <div class="content">
                    <div class="p-l-30 p-r-30 mobileversion">
                        <?php
                        $this->db->where('setting_id', 2);
                        $this->db->from('setting');
                        $query = $this->db->get();
                        $res = $query->result();
                        $a2 = $res[0]->notice_message;
                        $dateofdelivery = $res[0]->delivered_on;
                        $datechanged = $res[0]->last_modified;

                        ?>
                        <?php if (notice('display_notice') == true) { ?>
                            <?php if ($a2) { ?>
                                <h3 class="text-center">
                                    <span style="color: red; "><strong><?php echo $a2; ?> </strong></span>
                                </h3>
                                <!-- <marquee behavior="scroll" direction="top" style="color: red;"><strong>NOTICE: DEMO PERIOD EXTENDED </strong></marquee> -->
                            <?php } ?>
                        <?php } ?>

                        <?php if ($this->uri->segment(2) != 'welcome') { ?>
                            <div class="content-title">
                                <!-- <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12" style="overflow:auto;"> -->

                                <h2 class="text header_title">
                                    <?php echo !empty($title) ? $title : null; ?>
                                    <?php if (($this->uri->segment(2) == 'feedback_dashboard') || (($this->uri->segment(2) == 'ticket_dashboard' && ($this->uri->segment(1) == 'pc') || $this->uri->segment(2) == 'ticket_dashboard' && ($this->uri->segment(1) == 'isr')  || $this->uri->segment(2) == 'ticket_dashboard' && ($this->uri->segment(1) == 'incident')   || $this->uri->segment(2) == 'ticket_dashboard' && ($this->uri->segment(1) == 'grievance')))) { ?>
                                        <i class="fa fa-download" data-toggle="tooltip" title="<?php echo lang_loader('global', 'global_click_to_download_tooltip'); ?>" onclick="$('#showdownload').toggle(300)" style="font-size: 20px;margin-top: 5px;margin-left: 1px;cursor: pointer; color: #62c52d;"></i>
                                    <?php } elseif ($this->uri->segment(2) == 'ticket_dashboard' && $this->uri->segment(1) == 'asset') { ?>
                                        <a href="<?php echo base_url('asset/download_alltickets'); ?>" target="_blank"
                                            data-toggle="tooltip"
                                            title="Download Assets"
                                            style="font-size: 20px; margin-top: 5px; margin-left: 1px; cursor: pointer; color: #62c52d;">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    <?php } ?>
                                </h2>
                                <!-- </div> -->
                            </div>
                        <?php } ?>

                        <div class="row">

                            <?php
                            if ($this->uri->segment(2) != 'track') {
                                $dates = get_from_to_date();
                                $fdate = $dates['fdate'];
                                $tdate = $dates['tdate'];
                                $fdate = date('Y-m-d', strtotime($fdate));
                                $fdatet = date('Y-m-d 23:59:59', strtotime($fdate));

                            ?>
                                <?php if (hidecalender($this->uri->segment(1)) !== true) { ?>
                                    <?php if (hide_cal_seg2($this->uri->segment(2)) !== true) { ?>

                                        <?php if (is_mobile() === true) { ?>
                                            <div style=" width: 231px;float: right;margin-top: -23px;">
                                                <h5><?php echo lang_loader('global', 'global_from'); ?>&nbsp;<b><?php echo date('d/m/Y', strtotime($tdate)); ?> </b> to&nbsp;<b><?php echo date('d/m/Y', strtotime($fdate)); ?> </b><a data-toggle="modal" data-target="#exampleModal" href="javascript:void()" data-toggle="tooltip" title="Click on the calendar icon and select your date range for which you want to display the reports."><i class="fa fa-calendar"></i></a></h5>
                                            </div>
                                        <?php } else { ?>
                                            <div style="width: 429px;float: right;margin-top: -24px;">
                                                <h3><?php echo lang_loader('global', 'global_showing_datafrom'); ?>&nbsp;<b><?php echo date('d/m/Y', strtotime($tdate)); ?> </b> to&nbsp;<b><?php echo date('d/m/Y', strtotime($fdate)); ?> </b><a data-toggle="modal" data-target="#exampleModal" href="javascript:void()" data-toggle="tooltip" title="Click on the calendar icon and select your date range for which you want to display the reports."><i class="fa fa-calendar"></i></a></h3>
                                            </div>
                                        <?php } ?>
                            <?php }
                                }
                            } ?>
                        </div>

                    </div>
                    <?php
                    if ($this->uri->segment(2) != 'welcome') { ?>
                        <hr>
                    <?php } ?>
                    <!-- alert message -->
                    <?php if ($this->session->flashdata('message') != null) { ?>
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $this->session->flashdata('message'); ?>
                        </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('exception') != null) { ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $this->session->flashdata('exception'); ?>
                        </div>
                    <?php } ?>
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php } ?>
                    <!-- content -->


                    <?php //echo $a3; 
                    ?>
                    <?php echo (!empty($content) ? $content : null) ?>

                </div> <!-- /.content-wrapper -->


            </div> <!-- /.content -->
            <?php if (($this->session->userdata['user_role'] == 0) || notice('dev_info') == true) { ?>
                <footer class="main-footer">
                    <?php
                    echo '<b>Date of Delivery:</b> ';
                    echo $dateofdelivery;
                    echo '<br>';
                    $path =  $_SERVER['DOCUMENT_ROOT'];
                    echo '<b>Directory:</b> ';
                    echo $path;
                    echo '<br>';
                    echo '<b>DB:</b> ';
                    $db_name = $this->db->database;
                    echo $db_name;
                    echo '<br>';
                    echo '<b>Last Modified:</b> ';
                    echo $datechanged;
                    echo '<br>';


                    ?>
                </footer>
            <?php } ?>
        <?php } ?>


        <br>
        <?php if ($this->uri->segment(2) == 'track' && $this->session->userdata('isLogIn') == false) { ?>

            <div class="p-l-30 p-r-30">
                <div class="panel panel-default">
                    <div class="title" style="text-align:center;align-items:center; ">
                        <a href="" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang_loader('global', 'global_efeedor_patient_exp_tooltip'); ?>"> <img src="<?php echo base_url(); ?>assets/icon/loginlogo1.png" style=" height: 35px; width: 100px; margin-bottom: -14px;  margin-top: 14px;">
                        </a>
                    </div>

                    <div class="panel-body" style="height: 50px; ">
                        <h5 style="text-align: center;"><?php echo lang_loader('global', 'global_if_an_org_emp'); ?> <a href="<?php echo base_url(); ?> "><?php echo lang_loader('global', 'global_login'); ?></a> <?php echo lang_loader('global', 'global_view_more_con'); ?></h5>
                    </div>
                </div>
            </div>
            <?php echo (!empty($content) ? $content : null) ?>
        <?php } ?>

        <?php if ($this->uri->segment(1) == 'track' && $this->session->userdata('isLogIn') == false && ($this->uri->segment(2) == 'ipdf' || $this->uri->segment(2) == 'opf' || $this->uri->segment(2) == 'isr' ||  $this->uri->segment(2) == 'adf' ||  $this->uri->segment(2) == 'pc' ||  $this->uri->segment(2) == 'inc' || $this->uri->segment(2) == 'doctor')) { ?>
            <?php echo (!empty($content) ? $content : null) ?>
        <?php } ?>


        <?php /* if ($this->uri->segment(1) == 'view') { ?>
            <br>
            <?php echo (!empty($content) ? $content : null) ?>
        <?php } */ ?>


        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo lang_loader('global', 'global_select_your_data_range'); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">

                            <table style="width:100%">
                                <tr>
                                    <td>
                                        <?php echo lang_loader('global', 'global_from_date'); ?><br />
                                        <input type="text" name="tdate" class="form-control datepicker" autocomplete="off" required>
                                    </td>
                                    <td>
                                        <?php echo lang_loader('global', 'global_to_date'); ?><br />
                                        <input type="text" name="fdate" class="form-control datepicker" autocomplete="off" required>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang_loader('global', 'global_close'); ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo lang_loader('global', 'global_search'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <footer class="main-footer" style="display: none;">
            copyright@ehandor
        </footer>
        <!-- dont remove this div -->
    </div> <!-- /.content-wrapper -->

    <!-- jQuery  -->

    <script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
    <script src="<?php echo base_url(); ?>assets/utils.js"></script>

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

        .icon:hover {
            color: #62c52d;
            transition: color 0.3s;
        }

        select#warddropdown {
            color: #FFFFFF;
            background: #62c52d;
            text-align: left;
        }

        select#warddropdown option {
            background: #FFFFFF;
            color: black;
        }

        .header_title {
            font-size: 21px;
            margin-top: 10px !important;
            display: inline-block;
            margin-left: 20px;
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
                width: 272px;
                margin-left: -36px;
                margin-top: 10px;
            }

            div.content>div.mobileversion {
                padding: 0px 4px 0px 32px !important;
                margin: 0px !important;
            }

            hr {
                border-top: 1px solid #e1e6ef;
                padding: 0px;
                margin: 12px;
            }
        }

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
            color: black;
        }
    </style>

    <!-- Updated by dhananjay -->

    <!-- ADMISSION MODULES -->
    <script>
        $('.adfticketanalisys').DataTable({
            "ordering": true,
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
                    title: 'ADF-TICKET ANALISYS',
                    className: 'btn-sm',
                    title: 'ADF-TICKET ANALISYS',
                },
                {
                    extend: 'excel',
                    title: 'ADF-TICKET ANALISYS',
                    className: 'btn-sm',
                    title: 'ADF-TICKET ANALISYS',
                },

            ]
        });
    </script>
    <!-- ADMISSION ALL FEEDBACKS -->
    <script>
        $('.adfallfeedbacks').DataTable({
            "ordering": true,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'cadfy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'ADMISSION-FEEDBACK REPPORT',
                    className: 'btn-sm',
                    title: 'ADMISSION-FEEDBACK REPPORT',
                },
                {
                    extend: 'excel',
                    title: 'ADMISSION-FEEDBACK REPPORT',
                    className: 'btn-sm',
                    title: 'ADMISSION-FEEDBACK REPPORT',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Promoter List',
                //     className: 'btn-sm',
                //     title: 'IP-Promoter List',
                // },

            ]
        });
    </script>

    <!-- ADMISSION SATISFIED LIST -->
    <script>
        $('.adfpsatsatisfied').DataTable({
            "ordering": true,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'cadfy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'ADMISSION-SATISFIED LIST',
                    className: 'btn-sm',
                    title: 'ADMISSION-SATISFIED LIST',
                },
                {
                    extend: 'excel',
                    title: 'ADMISSION-SATISFIED LIST',
                    className: 'btn-sm',
                    title: 'ADMISSION-SATISFIED LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'ADMISSION-Satisfied List',
                //     className: 'btn-sm',
                //     title: 'ADMISSION-Satisfied List',
                // },

            ]
        });
    </script>

    <!-- ADMISSION UNSATISFIED LIST -->
    <script>
        $('.adfpsatunsatisfied').DataTable({
            "ordering": true,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'cadfy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'ADMISSION-UNSATISFIED LIST',
                    className: 'btn-sm',
                    title: 'ADMISSION-UNSATISFIED LIST',
                },
                {
                    extend: 'excel',
                    title: 'ADMISSION-UNSATISFIED LIST',
                    className: 'btn-sm',
                    title: 'ADMISSION-UNSATISFIED LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'ADMISSION-Satisfied List',
                //     className: 'btn-sm',
                //     title: 'ADMISSION-Satisfied List',
                // },

            ]
        });
    </script>

    <!-- ADMISSION PROMOTER LIST -->
    <script>
        $('.adfnpspromoters').DataTable({
            "ordering": true,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'cadfy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'ADMISSION-PROMOTER LIST',
                    className: 'btn-sm',
                    title: 'ADMISSION-PROMOTER LIST',
                },
                {
                    extend: 'excel',
                    title: 'ADMISSION-PROMOTER LIST',
                    className: 'btn-sm',
                    title: 'ADMISSION-PROMOTER LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'ADMISSION-Promoter List',
                //     className: 'btn-sm',
                //     title: 'ADMISSION-Promoter List',
                // },

            ]
        });
    </script>

    <!-- ADMISSION PASSIVE LIST -->
    <script>
        $('.adfnpspassive').DataTable({
            "ordering": true,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'cadfy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'ADMISSION-PASSIVE LIST',
                    className: 'btn-sm',
                    title: 'ADMISSION-PASSIVE LIST',
                },
                {
                    extend: 'excel',
                    title: 'ADMISSION-PASSIVE LIST',
                    className: 'btn-sm',
                    title: 'ADMISSION-PASSIVE LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'ADMISSION-Passive List',
                //     className: 'btn-sm',
                //     title: 'ADMISSION-Passive List',
                // },

            ]
        });
    </script>

    <!-- ADMISSION DETRACTOR LIST -->
    <script>
        $('.adfnpsdetractor').DataTable({
            "ordering": true,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'cadfy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'ADMISSION-DETRACTOR LIST',
                    className: 'btn-sm',
                    title: 'ADMISSION-DETRACTOR LIST',
                },
                {
                    extend: 'excel',
                    title: 'ADMISSION-DETRACTOR LIST',
                    className: 'btn-sm',
                    title: 'ADMISSION-DETRACTOR LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'ADMISSION-Detractor List',
                //     className: 'btn-sm',
                //     title: 'ADMISSION-Detractor List',
                // },

            ]
        });
    </script>

    <!-- ADMISSION ALL TICKETS -->
    <script>
        $('.adfticketsall').DataTable({
            "ordering": true,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'cadfy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'ADMISSION-ALL TICKETS',
                    className: 'btn-sm',
                    title: 'ADMISSION-ALL TICKETS',
                },
                {
                    extend: 'excel',
                    title: 'ADMISSION-ALL TICKETS',
                    className: 'btn-sm',
                    title: 'ADMISSION-ALL TICKETS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Promoter List',
                //     className: 'btn-sm',
                //     title: 'IP-Promoter List',
                // },

            ]
        });
    </script>

    <!-- ADMISSION OPEN TICKETS -->
    <script>
        $('.adfticketsopen').DataTable({
            "ordering": true,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'cadfy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'ADMISSION-OPEN TICKETS',
                    className: 'btn-sm',
                    title: 'ADMISSION-OPEN TICKETS',
                },
                {
                    extend: 'excel',
                    title: 'ADMISSION-OPEN TICKETS',
                    className: 'btn-sm',
                    title: 'ADMISSION-OPEN TICKETS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'IP-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- ADMISSION ADDRESSED TICKETS -->
    <script>
        $('.adfticketsaddressed').DataTable({
            "ordering": true,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'cadfy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'ADMISSION-ADDRESSED TICKETS',
                    className: 'btn-sm',
                    title: 'ADMISSION-ADDRESSED TICKETS',
                },
                {
                    extend: 'excel',
                    title: 'ADMISSION-ADDRESSED TICKETS',
                    className: 'btn-sm',
                    title: 'ADMISSION-ADDRESSED TICKETS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'IP-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- ADMISSION CLOSED TICKETS -->
    <script>
        $('.adfticketsclose').DataTable({
            "ordering": true,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'cadfy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'ADMISSION-CLOSED TICKETS',
                    className: 'btn-sm',
                    title: 'ADMISSION-CLOSED TICKETS',
                },
                {
                    extend: 'excel',
                    title: 'ADMISSION-CLOSED TICKETS',
                    className: 'btn-sm',
                    title: 'ADMISSION-CLOSED TICKETS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'IP-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- ADMISSION CAPA REPORT -->
    <script>
        $('.adfcapa').DataTable({
            "ordering": true,
            responsive: true,
            "pageLength": 50,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [
                /*  {extend: 'cadfy', className: 'btn-sm'},*/
                {
                    extend: 'csv',
                    title: 'ADMISSION-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'ADMISSION-CAPA REPORT',
                },
                {
                    extend: 'excel',
                    title: 'ADMISSION-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'ADMISSION-CAPA REPORT',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Promoter List',
                //     className: 'btn-sm',
                //     title: 'IP-Promoter List',
                // },

            ]
        });
    </script>


    <!-- DISCHARGE INPATIENT MODULES -->

    <!-- IP TICKET ANALISYS -->
    <script>
        $('.ipticketanalisys').DataTable({
            "ordering": true,
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
                    title: 'IP-TICKET ANALISYS',
                    className: 'btn-sm',
                    title: 'IP-TICKET ANALISYS',
                },
                {
                    extend: 'excel',
                    title: 'IP-TICKET ANALISYS',
                    className: 'btn-sm',
                    title: 'IP-TICKET ANALISYS',
                },

            ]
        });
    </script>


    <!-- Quality KPI -->

    <script>
        $('.psq3a').DataTable({
            "ordering": true,
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
                    title: 'PSQ3a - Readmission to ICU within 48 hours after being discharged from ICU',
                    className: 'btn-sm',
                    title: 'PSQ3a - Readmission to ICU within 48 hours after being discharged from ICU',
                },
                {
                    extend: 'excel',
                    title: 'PSQ3a - Readmission to ICU within 48 hours after being discharged from ICU',
                    className: 'btn-sm',
                    title: 'PSQ3a - Readmission to ICU within 48 hours after being discharged from ICU',
                },


            ]
        });
    </script>

    <script>
        $('.1psq3a').DataTable({
            "ordering": true,
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
                    title: '1.PSQ3a- Time taken for initial assessment of indoor patients',
                    className: 'btn-sm',
                    title: '1.PSQ3a- Time taken for initial assessment of indoor patients',
                },
                {
                    extend: 'excel',
                    title: '1.PSQ3a- Time taken for initial assessment of indoor patients',
                    className: 'btn-sm',
                    title: '1.PSQ3a- Time taken for initial assessment of indoor patients',
                },


            ]
        });
    </script>

    <script>
        $('.2psq3a').DataTable({
            "ordering": true,
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
                    title: '2.PSQ3a- Number of reporting errors per 1000 investigations',
                    className: 'btn-sm',
                    title: '2.PSQ3a- Number of reporting errors per 1000 investigations',
                },
                {
                    extend: 'excel',
                    title: '2.PSQ3a- Number of reporting errors per 1000 investigations',
                    className: 'btn-sm',
                    title: '2.PSQ3a- Number of reporting errors per 1000 investigations',
                },


            ]
        });
    </script>

    <script>
        $('.3psq3a').DataTable({
            "ordering": true,
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
                    title: '3.PSQ3a- Percentage of adherence to safety precautions by staff working in diagnostics',
                    className: 'btn-sm',
                    title: '3.PSQ3a- Percentage of adherence to safety precautions by staff working in diagnostics',
                },
                {
                    extend: 'excel',
                    title: '3.PSQ3a- Percentage of adherence to safety precautions by staff working in diagnostics',
                    className: 'btn-sm',
                    title: '3.PSQ3a- Percentage of adherence to safety precautions by staff working in diagnostics',
                },


            ]
        });
    </script>

    <script>
        $('.4psq3a').DataTable({
            "ordering": true,
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
                    title: '4.PSQ3a- Medication errors rate',
                    className: 'btn-sm',
                    title: '4.PSQ3a- Medication errors rate',
                },
                {
                    extend: 'excel',
                    title: '4.PSQ3a- Medication errors rate',
                    className: 'btn-sm',
                    title: '4.PSQ3a- Medication errors rate',
                },


            ]
        });
    </script>

    <script>
        $('.5psq3a').DataTable({
            "ordering": true,
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
                    title: '5.PSQ3a- Percentage of medication charts with error-prone abbreviations',
                    className: 'btn-sm',
                    title: '5.PSQ3a- Percentage of medication charts with error-prone abbreviations',
                },
                {
                    extend: 'excel',
                    title: '5.PSQ3a- Percentage of medication charts with error-prone abbreviations',
                    className: 'btn-sm',
                    title: '5.PSQ3a- Percentage of medication charts with error-prone abbreviations',
                },


            ]
        });
    </script>

    <script>
        $('.6psq3a').DataTable({
            "ordering": true,
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
                    title: '6.PSQ3a- Percentage of in-patients developing adverse drug reaction(s)',
                    className: 'btn-sm',
                    title: '6.PSQ3a- Percentage of in-patients developing adverse drug reaction(s)',
                },
                {
                    extend: 'excel',
                    title: '6.PSQ3a- Percentage of in-patients developing adverse drug reaction(s)',
                    className: 'btn-sm',
                    title: '6.PSQ3a- Percentage of in-patients developing adverse drug reaction(s)',
                },


            ]
        });
    </script>

    <script>
        $('.7psq3a').DataTable({
            "ordering": true,
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
                    title: '7.PSQ3a- Percentage of unplanned return to OT',
                    className: 'btn-sm',
                    title: '7.PSQ3a- Percentage of unplanned return to OT',
                },
                {
                    extend: 'excel',
                    title: '7.PSQ3a- Percentage of unplanned return to OT',
                    className: 'btn-sm',
                    title: '7.PSQ3a- Percentage of unplanned return to OT',
                },


            ]
        });
    </script>

    <script>
        $('.8psq3a').DataTable({
            "ordering": true,
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
                    title: '8.PSQ3a- Percentage of surgeries where the organisations procedure to prevent adverse events- wrong site/wrong patient/wrong surgery have been adhered to',
                    className: 'btn-sm',
                    title: '8.PSQ3a- Percentage of surgeries where the organisations procedure to prevent adverse events- wrong site/wrong patient/wrong surgery have been adhered to',
                },
                {
                    extend: 'excel',
                    title: '8.PSQ3a- Percentage of surgeries where the organisations procedure to prevent adverse events- wrong site/wrong patient/wrong surgery have been adhered to',
                    className: 'btn-sm',
                    title: '8.PSQ3a- Percentage of surgeries where the organisations procedure to prevent adverse events- wrong site/wrong patient/wrong surgery have been adhered to',
                },


            ]
        });
    </script>

    <script>
        $('.9psq3a').DataTable({
            "ordering": true,
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
                    title: '9.PSQ3a- Percentage of transfusion reactions',
                    className: 'btn-sm',
                    title: '9.PSQ3a- Percentage of transfusion reactions',
                },
                {
                    extend: 'excel',
                    title: '9.PSQ3a- Percentage of transfusion reactions',
                    className: 'btn-sm',
                    title: '9.PSQ3a- Percentage of transfusion reactions',
                },


            ]
        });
    </script>

    <script>
        $('.10psq3a').DataTable({
            "ordering": true,
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
                    title: '10.PSQ3a- Standardised mortality ratio for ICU',
                    className: 'btn-sm',
                    title: '10.PSQ3a- Standardised mortality ratio for ICU',
                },
                {
                    extend: 'excel',
                    title: '10.PSQ3a- Standardised mortality ratio for ICU',
                    className: 'btn-sm',
                    title: '10.PSQ3a- Standardised mortality ratio for ICU',
                },


            ]
        });
    </script>



    <script>
        $('.11psq3a').DataTable({
            "ordering": true,
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
                    title: '11.PSQ3a- Return to the emergency department within 72 hours with similar presenting complaints',
                    className: 'btn-sm',
                    title: '11.PSQ3a- Return to the emergency department within 72 hours with similar presenting complaints',
                },
                {
                    extend: 'excel',
                    title: '11.PSQ3a- Return to the emergency department within 72 hours with similar presenting complaints',
                    className: 'btn-sm',
                    title: '11.PSQ3a- Return to the emergency department within 72 hours with similar presenting complaints',
                },


            ]
        });
    </script>

    <script>
        $('.12psq3a').DataTable({
            "ordering": true,
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
                    title: '12.PSQ3a- Incidence of hospital associated pressure ulcers after admission(Bed sore per 1000 patient days)',
                    className: 'btn-sm',
                    title: '12.PSQ3a- Incidence of hospital associated pressure ulcers after admission(Bed sore per 1000 patient days)',
                },
                {
                    extend: 'excel',
                    title: '12.PSQ3a- Incidence of hospital associated pressure ulcers after admission(Bed sore per 1000 patient days)',
                    className: 'btn-sm',
                    title: '12.PSQ3a- Incidence of hospital associated pressure ulcers after admission(Bed sore per 1000 patient days)',
                },


            ]
        });
    </script>

    <script>
        $('.13psq3a').DataTable({
            "ordering": true,
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
                    title: '13.PSQ3b- Catheter associated urinary tract infection rate',
                    className: 'btn-sm',
                    title: '13.PSQ3b- Catheter associated urinary tract infection rate',
                },
                {
                    extend: 'excel',
                    title: '13.PSQ3b- Catheter associated urinary tract infection rate',
                    className: 'btn-sm',
                    title: '13.PSQ3b- Catheter associated urinary tract infection rate',
                },


            ]
        });
    </script>

    <script>
        $('.14psq3a').DataTable({
            "ordering": true,
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
                    title: '14.PSQ3b- Ventilator associated pneumonia rate',
                    className: 'btn-sm',
                    title: '14.PSQ3b- Ventilator associated pneumonia rate',
                },
                {
                    extend: 'excel',
                    title: '14.PSQ3b- Ventilator associated pneumonia rate',
                    className: 'btn-sm',
                    title: '14.PSQ3b- Ventilator associated pneumonia rate',
                },


            ]
        });
    </script>

    <script>
        $('.15psq3a').DataTable({
            "ordering": true,
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
                    title: '15.PSQ3b- Central line - associated blood stream infection rate',
                    className: 'btn-sm',
                    title: '15.PSQ3b- Central line - associated blood stream infection rate',
                },
                {
                    extend: 'excel',
                    title: '15.PSQ3b- Central line - associated blood stream infection rate',
                    className: 'btn-sm',
                    title: '15.PSQ3b- Central line - associated blood stream infection rate',
                },


            ]
        });
    </script>

    <script>
        $('.16psq3a').DataTable({
            "ordering": true,
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
                    title: '16.PSQ3b- Surgical site infection rate',
                    className: 'btn-sm',
                    title: '16.PSQ3b- Surgical site infection rate',
                },
                {
                    extend: 'excel',
                    title: '16.PSQ3b- Surgical site infection rate',
                    className: 'btn-sm',
                    title: '16.PSQ3b- Surgical site infection rate',
                },


            ]
        });
    </script>

    <script>
        $('.17psq3a').DataTable({
            "ordering": true,
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
                    title: '17.PSQ3b- Hand hygiene compliance rate',
                    className: 'btn-sm',
                    title: '17.PSQ3b- Hand hygiene compliance rate',
                },
                {
                    extend: 'excel',
                    title: '17.PSQ3b- Hand hygiene compliance rate',
                    className: 'btn-sm',
                    title: '17.PSQ3b- Hand hygiene compliance rate',
                },


            ]
        });
    </script>

    <script>
        $('.18psq3a').DataTable({
            "ordering": true,
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
                    title: '18.PSQ3b- Percentage of cases who received appropriate prophylactic antibiotics within the specified timeframe',
                    className: 'btn-sm',
                    title: '18.PSQ3b- Percentage of cases who received appropriate prophylactic antibiotics within the specified timeframe',
                },
                {
                    extend: 'excel',
                    title: '18.PSQ3b- Percentage of cases who received appropriate prophylactic antibiotics within the specified timeframe',
                    className: 'btn-sm',
                    title: '18.PSQ3b- Percentage of cases who received appropriate prophylactic antibiotics within the specified timeframe',
                },


            ]
        });
    </script>

    <script>
        $('.19psq3a').DataTable({
            "ordering": true,
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
                    title: '19.PSQ3c- Percentage of re- scheduling of surgeries',
                    className: 'btn-sm',
                    title: '19.PSQ3c- Percentage of re- scheduling of surgeries',
                },
                {
                    extend: 'excel',
                    title: '19.PSQ3c- Percentage of re- scheduling of surgeries',
                    className: 'btn-sm',
                    title: '19.PSQ3c- Percentage of re- scheduling of surgeries',
                },


            ]
        });
    </script>

    <script>
        $('.20psq3a').DataTable({
            "ordering": true,
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
                    title: '20.PSQ3c- Turn around time for issue of blood and blood components',
                    className: 'btn-sm',
                    title: '20.PSQ3c- Turn around time for issue of blood and blood components',
                },
                {
                    extend: 'excel',
                    title: '20.PSQ3c- Turn around time for issue of blood and blood components',
                    className: 'btn-sm',
                    title: '20.PSQ3c- Turn around time for issue of blood and blood components',
                },


            ]
        });
    </script>

    <script>
        $('.21psq3a').DataTable({
            "ordering": true,
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
                    title: '21.PSQ3c- Nurse-patient ratio for ICUs',
                    className: 'btn-sm',
                    title: '21.PSQ3c- Nurse-patient ratio for ICUs',
                },
                {
                    extend: 'excel',
                    title: '21.PSQ3c- Nurse-patient ratio for ICUs',
                    className: 'btn-sm',
                    title: '21.PSQ3c- Nurse-patient ratio for ICUs',
                },


            ]
        });
    </script>

    <script>
        $('.21apsq3a').DataTable({
            "ordering": true,
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
                    title: '21a.PSQ3c- Nurse-patient ratio for Wards',
                    className: 'btn-sm',
                    title: '21a.PSQ3c- Nurse-patient ratio for Wards',
                },
                {
                    extend: 'excel',
                    title: '21a.PSQ3c- Nurse-patient ratio for Wards',
                    className: 'btn-sm',
                    title: '21a.PSQ3c- Nurse-patient ratio for Wards',
                },


            ]
        });
    </script>

    <script>
        $('.22psq3a').DataTable({
            "ordering": true,
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
                    title: '22.PSQ3c - Waiting time for out- patient consultation',
                    className: 'btn-sm',
                    title: '22.PSQ3c - Waiting time for out- patient consultation',
                },
                {
                    extend: 'excel',
                    title: '22.PSQ3c - Waiting time for out- patient consultation',
                    className: 'btn-sm',
                    title: '22.PSQ3c - Waiting time for out- patient consultation',
                },


            ]
        });
    </script>

    <script>
        $('.23apsq3a').DataTable({
            "ordering": true,
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
                    title: '23a.PSQ4c- Waiting time for laboratory diagnostics',
                    className: 'btn-sm',
                    title: '23a.PSQ4c- Waiting time for laboratory diagnostics',
                },
                {
                    extend: 'excel',
                    title: '23a.PSQ4c- Waiting time for laboratory diagnostics',
                    className: 'btn-sm',
                    title: '23a.PSQ4c- Waiting time for laboratory diagnostics',
                },


            ]
        });
    </script>

    <script>
        $('.23bpsq3a').DataTable({
            "ordering": true,
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
                    title: '23b.PSQ4c- Waiting time for X-ray diagnostics',
                    className: 'btn-sm',
                    title: '23b.PSQ4c- Waiting time for X-ray diagnostics',
                },
                {
                    extend: 'excel',
                    title: '23b.PSQ4c- Waiting time for X-ray diagnostics',
                    className: 'btn-sm',
                    title: '23b.PSQ4c- Waiting time for X-ray diagnostics',
                },


            ]
        });
    </script>

    <script>
        $('.23cpsq3a').DataTable({
            "ordering": true,
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
                    title: '23c.PSQ4c- Waiting time for USG diagnostics',
                    className: 'btn-sm',
                    title: '23c.PSQ4c- Waiting time for USG diagnostics',
                },
                {
                    extend: 'excel',
                    title: '23c.PSQ4c- Waiting time for USG diagnostics',
                    className: 'btn-sm',
                    title: '23c.PSQ4c- Waiting time for USG diagnostics',
                },


            ]
        });
    </script>

    <script>
        $('.23dpsq3a').DataTable({
            "ordering": true,
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
                    title: '23d.PSQ4c- Waiting time for CT scan diagnostics',
                    className: 'btn-sm',
                    title: '23d.PSQ4c- Waiting time for CT scan diagnostics',
                },
                {
                    extend: 'excel',
                    title: '23d.PSQ4c- Waiting time for CT scan diagnostics',
                    className: 'btn-sm',
                    title: '23d.PSQ4c- Waiting time for CT scan diagnostics',
                },


            ]
        });
    </script>


    <script>
        $('.24psq3a').DataTable({
            "ordering": true,
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
                    title: '24.PSQ4c- Time taken for discharge for General Patients',
                    className: 'btn-sm',
                    title: '24.PSQ4c- Time taken for discharge for General Patients',
                },
                {
                    extend: 'excel',
                    title: '24.PSQ4c- Time taken for discharge for General Patients',
                    className: 'btn-sm',
                    title: '24.PSQ4c- Time taken for discharge for General Patients',
                },


            ]
        });
    </script>

    <script>
        $('.24bpsq3a').DataTable({
            "ordering": true,
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
                    title: '24.PSQ4c- Time taken for discharge for Insurance Patients',
                    className: 'btn-sm',
                    title: '24.PSQ4c- Time taken for discharge for Insurance Patients',
                },
                {
                    extend: 'excel',
                    title: '24.PSQ4c- Time taken for discharge for Insurance Patients',
                    className: 'btn-sm',
                    title: '24.PSQ4c- Time taken for discharge for Insurance Patients',
                },


            ]
        });
    </script>

    <script>
        $('.24cpsq3a').DataTable({
            "ordering": true,
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
                    title: '24.PSQ4c- Time taken for discharge for Corporate Patients',
                    className: 'btn-sm',
                    title: '24.PSQ4c- Time taken for discharge for Corporate Patients',
                },
                {
                    extend: 'excel',
                    title: '24.PSQ4c- Time taken for discharge for Corporate Patients',
                    className: 'btn-sm',
                    title: '24.PSQ4c- Time taken for discharge for Corporate Patients',
                },


            ]
        });
    </script>

    <script>
        $('.25psq3a').DataTable({
            "ordering": true,
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
                    title: '25.PSQ4c- Percentage of medical records having incomplete and/or improper consent',
                    className: 'btn-sm',
                    title: '25.PSQ4c- Percentage of medical records having incomplete and/or improper consent',
                },
                {
                    extend: 'excel',
                    title: '25.PSQ4c- Percentage of medical records having incomplete and/or improper consent',
                    className: 'btn-sm',
                    title: '25.PSQ4c- Percentage of medical records having incomplete and/or improper consent',
                },


            ]
        });
    </script>

    <script>
        $('.26psq3a').DataTable({
            "ordering": true,
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
                    title: '26.PSQ4c- Stock out rate of emergency medications',
                    className: 'btn-sm',
                    title: '26.PSQ4c- Stock out rate of emergency medications',
                },
                {
                    extend: 'excel',
                    title: '26.PSQ4c- Stock out rate of emergency medications',
                    className: 'btn-sm',
                    title: '26.PSQ4c- Stock out rate of emergency medications',
                },


            ]
        });
    </script>

    <script>
        $('.27psq3a').DataTable({
            "ordering": true,
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
                    title: '27.PSQ4d- Number of variations observed in mock drills',
                    className: 'btn-sm',
                    title: '27.PSQ4d- Number of variations observed in mock drills',
                },
                {
                    extend: 'excel',
                    title: '27.PSQ4d- Number of variations observed in mock drills',
                    className: 'btn-sm',
                    title: '27.PSQ4d- Number of variations observed in mock drills',
                },


            ]
        });
    </script>

    <script>
        $('.28psq3a').DataTable({
            "ordering": true,
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
                    title: '28.PSQ4d- Patient fall rate (Falls per 1000 patient days)',
                    className: 'btn-sm',
                    title: '28.PSQ4d- Patient fall rate (Falls per 1000 patient days)',
                },
                {
                    extend: 'excel',
                    title: '28.PSQ4d- Patient fall rate (Falls per 1000 patient days)',
                    className: 'btn-sm',
                    title: '28.PSQ4d- Patient fall rate (Falls per 1000 patient days)',
                },


            ]
        });
    </script>

    <script>
        $('.29psq3a').DataTable({
            "ordering": true,
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
                    title: '29.PSQ4d- Percentage of near misses',
                    className: 'btn-sm',
                    title: '29.PSQ4d- Percentage of near misses',
                },
                {
                    extend: 'excel',
                    title: '29.PSQ4d- Percentage of near misses',
                    className: 'btn-sm',
                    title: '29.PSQ4d- Percentage of near misses',
                },


            ]
        });
    </script>

    <script>
        $('.30psq3a').DataTable({
            "ordering": true,
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
                    title: '30.PSQ3d- Incidence of needle stick injuries',
                    className: 'btn-sm',
                    title: '30.PSQ3d- Incidence of needle stick injuries',
                },
                {
                    extend: 'excel',
                    title: '30.PSQ3d- Incidence of needle stick injuries',
                    className: 'btn-sm',
                    title: '30.PSQ3d- Incidence of needle stick injuries',
                },


            ]
        });
    </script>

    <script>
        $('.31psq3a').DataTable({
            "ordering": true,
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
                    title: '31.PSQ3d- Appropriate handovers during shift change (To be done separately for doctors and nurses)',
                    className: 'btn-sm',
                    title: '31.PSQ3d- Appropriate handovers during shift change (To be done separately for doctors and nurses)',
                },
                {
                    extend: 'excel',
                    title: '31.PSQ3d- Appropriate handovers during shift change (To be done separately for doctors and nurses)',
                    className: 'btn-sm',
                    title: '31.PSQ3d- Appropriate handovers during shift change (To be done separately for doctors and nurses)',
                },


            ]
        });
    </script>

    <script>
        $('.32psq3a').DataTable({
            "ordering": true,
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
                    title: '32.PSQ3d- Compliance rate to medication prescription in capitals',
                    className: 'btn-sm',
                    title: '32.PSQ3d- Compliance rate to medication prescription in capitals',
                },
                {
                    extend: 'excel',
                    title: '32.PSQ3d- Compliance rate to medication prescription in capitals',
                    className: 'btn-sm',
                    title: '32.PSQ3d- Compliance rate to medication prescription in capitals',
                },


            ]
        });
    </script>


    <script>
        $('.mrdauditallfeedbacks').DataTable({
            "ordering": true,
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
                    title: 'MRD AUDIT REPPORT',
                    className: 'btn-sm',
                    title: 'MRD AUDIT REPPORT',
                },
                {
                    extend: 'excel',
                    title: 'MRD AUDIT REPPORT',
                    className: 'btn-sm',
                    title: 'MRD AUDIT REPPORT',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Promoter List',
                //     className: 'btn-sm',
                //     title: 'IP-Promoter List',
                // },

            ]
        });
    </script>

    <script>
        $('.ppeauditallfeedbacks').DataTable({
            "ordering": true,
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
                    title: 'PPE AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'PPE AUDIT REPORT',
                },
                {
                    extend: 'excel',
                    title: 'PPE AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'PPE AUDIT REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.opconsultationtime').DataTable({
            "ordering": true,
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
                    title: 'OP CONSULTATION WAITING TIME REPORT',
                    className: 'btn-sm',
                    title: 'OP CONSULTATION WAITING TIME REPORT',
                },
                {
                    extend: 'excel',
                    title: 'OP CONSULTATION WAITING TIME REPORT',
                    className: 'btn-sm',
                    title: 'OP CONSULTATION WAITING TIME REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.labtime').DataTable({
            "ordering": true,
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
                    title: 'LABORATORY WAITING TIME REPORT',
                    className: 'btn-sm',
                    title: 'LABORATORY WAITING TIME REPORT',
                },
                {
                    extend: 'excel',
                    title: 'LABORATORY WAITING TIME REPORT',
                    className: 'btn-sm',
                    title: 'LABORATORY WAITING TIME REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.xraytime').DataTable({
            "ordering": true,
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
                    title: 'X-RAY WAITING TIME REPORT',
                    className: 'btn-sm',
                    title: 'X-RAY WAITING TIME REPORT',
                },
                {
                    extend: 'excel',
                    title: 'X-RAY WAITING TIME REPORT',
                    className: 'btn-sm',
                    title: 'X-RAY WAITING TIME REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.usgtime').DataTable({
            "ordering": true,
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
                    title: 'USG WAITING TIME REPORT',
                    className: 'btn-sm',
                    title: 'USG WAITING TIME REPORT',
                },
                {
                    extend: 'excel',
                    title: 'USG WAITING TIME REPORT',
                    className: 'btn-sm',
                    title: 'USG WAITING TIME REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.ctscantime').DataTable({
            "ordering": true,
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
                    title: 'CT SCAN WAITING TIME REPORT',
                    className: 'btn-sm',
                    title: 'CT SCAN WAITING TIME REPORT',
                },
                {
                    extend: 'excel',
                    title: 'CT SCAN WAITING TIME REPORT',
                    className: 'btn-sm',
                    title: 'CT SCAN WAITING TIME REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.surgicalsafety').DataTable({
            "ordering": true,
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
                    title: 'SURGICAL SAFETY AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'SURGICAL SAFETY AUDIT REPORT',
                },
                {
                    extend: 'excel',
                    title: 'SURGICAL SAFETY AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'SURGICAL SAFETY AUDIT REPORT',
                },


            ]
        });
    </script>


    <script>
        $('.medicinedispense').DataTable({
            "ordering": true,
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
                    title: 'MEDICINE DISPENSING AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'MEDICINE DISPENSING AUDIT REPORT',
                },
                {
                    extend: 'excel',
                    title: 'MEDICINE DISPENSING AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'MEDICINE DISPENSING AUDIT REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.medicationadministration').DataTable({
            "ordering": true,
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
                    title: 'MEDICATION ADMINISTRATION AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'MEDICATION ADMINISTRATION AUDIT REPORT',
                },
                {
                    extend: 'excel',
                    title: 'MEDICATION ADMINISTRATION AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'MEDICATION ADMINISTRATION AUDIT REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.handover').DataTable({
            "ordering": true,
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
                    title: 'HANDOVER AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'HANDOVER AUDIT REPORT',
                },
                {
                    extend: 'excel',
                    title: 'HANDOVER AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'HANDOVER AUDIT REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.prescriptions').DataTable({
            "ordering": true,
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
                    title: 'PRESCRIPTIONS AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'PRESCRIPTIONS AUDIT REPORT',
                },
                {
                    extend: 'excel',
                    title: 'PRESCRIPTIONS AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'PRESCRIPTIONS AUDIT REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.handhygiene').DataTable({
            "ordering": true,
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
                    title: 'HAND HYGIENE AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'HAND HYGIENE AUDIT REPORT',
                },
                {
                    extend: 'excel',
                    title: 'HAND HYGIENE AUDIT REPORT',
                    className: 'btn-sm',
                    title: 'HAND HYGIENE AUDIT REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.tatblood').DataTable({
            "ordering": true,
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
                    title: 'TAT FOR BLOOD ISSUE REPORT',
                    className: 'btn-sm',
                    title: 'TAT FOR BLOOD ISSUE REPORT',
                },
                {
                    extend: 'excel',
                    title: 'TAT FOR BLOOD ISSUE REPORT',
                    className: 'btn-sm',
                    title: 'TAT FOR BLOOD ISSUE REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.npratio').DataTable({
            "ordering": true,
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
                    title: 'NURSE-PATIENT RATIO REPORT',
                    className: 'btn-sm',
                    title: 'NURSE-PATIENT RATIO REPORT',
                },
                {
                    extend: 'excel',
                    title: 'NURSE-PATIENT RATIO REPORT',
                    className: 'btn-sm',
                    title: 'NURSE-PATIENT RATIO REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.returntoi').DataTable({
            "ordering": true,
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
                    title: 'ICU RETURN REPORT',
                    className: 'btn-sm',
                    title: 'ICU RETURN REPORT',
                },
                {
                    extend: 'excel',
                    title: 'ICU RETURN REPORT',
                    className: 'btn-sm',
                    title: 'ICU RETURN REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.returntoicu').DataTable({
            "ordering": true,
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
                    title: 'ICU RETURN REPORT- DATA VERIFICATION',
                    className: 'btn-sm',
                    title: 'ICU RETURN REPORT- DATA VERIFICATION',
                },
                {
                    extend: 'excel',
                    title: 'ICU RETURN REPORT- DATA VERIFICATION',
                    className: 'btn-sm',
                    title: 'ICU RETURN REPORT- DATA VERIFICATION',
                },


            ]
        });
    </script>

    <script>
        $('.returntoed').DataTable({
            "ordering": true,
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
                    title: 'EMERGENCY RETURN REPORT',
                    className: 'btn-sm',
                    title: 'EMERGENCY RETURN REPORT',
                },
                {
                    extend: 'excel',
                    title: 'EMERGENCY RETURN REPORT',
                    className: 'btn-sm',
                    title: 'EMERGENCY RETURN REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.returntoemr').DataTable({
            "ordering": true,
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
                    title: 'EMERGENCY RETURN REPORT- DATA VERIFICATION',
                    className: 'btn-sm',
                    title: 'EMERGENCY RETURN REPORT- DATA VERIFICATION',
                },
                {
                    extend: 'excel',
                    title: 'EMERGENCY RETURN REPORT- DATA VERIFICATION',
                    className: 'btn-sm',
                    title: 'EMERGENCY RETURN REPORT- DATA VERIFICATION',
                },


            ]
        });
    </script>

    <script>
        $('.codepink').DataTable({
            "ordering": true,
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
                    title: 'CODE PINK REPORT',
                    className: 'btn-sm',
                    title: 'CODE PINK REPORT',
                },
                {
                    extend: 'excel',
                    title: 'CODE PINK REPORT',
                    className: 'btn-sm',
                    title: 'CODE PINK REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.codered').DataTable({
            "ordering": true,
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
                    title: 'CODE RED REPORT',
                    className: 'btn-sm',
                    title: 'CODE RED REPORT',
                },
                {
                    extend: 'excel',
                    title: 'CODE RED REPORT',
                    className: 'btn-sm',
                    title: 'CODE RED REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.codeblue').DataTable({
            "ordering": true,
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
                    title: 'CODE BLUE REPORT',
                    className: 'btn-sm',
                    title: 'CODE BLUE REPORT',
                },
                {
                    extend: 'excel',
                    title: 'CODE BLUE REPORT',
                    className: 'btn-sm',
                    title: 'CODE BLUE REPORT',
                },


            ]
        });
    </script>

    <script>
        $('.stairways').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT- ST.THOMAS WARD',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT- ST.THOMAS WARD',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT- ST.THOMAS WARD',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT- ST.THOMAS WARD',
                },


            ]
        });
    </script>

    <script>
        $('.alphonsa').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.ALPHONSA WARD',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.ALPHONSA WARD',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.ALPHONSA WARD',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.ALPHONSA WARD',
                },


            ]
        });
    </script>

    <script>
        $('.martins').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.MARTINS WARD',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.MARTINS WARD',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.MARTINS WARD',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.MARTINS WARD',
                },


            ]
        });
    </script>

    <script>
        $('.anns').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.ANNS WARD',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.ANNS WARD',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.ANNS WARD',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.ANNS WARD',
                },


            ]
        });
    </script>

    <script>
        $('.antony').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.ANTONYS WARD',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.ANTONYS WARD',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.ANTONYS WARD',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ST.ANTONYS WARD',
                },


            ]
        });
    </script>


    <script>
        $('.paediatric').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - PAEDIATRIC-OBSERVATION',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - PAEDIATRIC-OBSERVATION',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - PAEDIATRIC-OBSERVATION',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - PAEDIATRIC-OBSERVATION',
                },


            ]
        });
    </script>

    <script>
        $('.ot').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - OT',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - OT',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - OT ',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - OT ',
                },


            ]
        });
    </script>

    <script>
        $('.icu').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - CCU/ICU ',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - CCU/ICU ',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - CCU/ICU ',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - CCU/ICU ',
                },


            ]
        });
    </script>

    <script>
        $('.casualty').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - CASUALTY',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - CASUALTY',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - CASUALTY',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - CASUALTY',
                },


            ]
        });
    </script>

    <script>
        $('.dialysis').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - DIALYSIS',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - DIALYSIS',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - DIALYSIS',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - DIALYSIS',
                },


            ]
        });
    </script>

    <script>
        $('.injection').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - INJECTION ROOM',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - INJECTION ROOM',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - INJECTION ROOM',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - INJECTION ROOM',
                },


            ]
        });
    </script>

    <script>
        $('.nicu').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - NICU',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - NICU',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - NICU',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - NICU',
                },


            ]
        });
    </script>

    <script>
        $('.lab').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - LABORATORY',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - LABORATORY',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - LABORATORY',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - LABORATORY',
                },


            ]
        });
    </script>

    <script>
        $('.basearea').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - BASEMENT-COMMON AREA',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - BASEMENT-COMMON AREA',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - BASEMENT-COMMON AREA',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - BASEMENT-COMMON AREA',
                },


            ]
        });
    </script>

    <script>
        $('.groundarea').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - GROUND FLOOR-COMMON AREA',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - GROUND FLOOR-COMMON AREA',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - GROUND FLOOR-COMMON AREA',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - GROUND FLOOR-COMMON AREA',
                },


            ]
        });
    </script>

    <script>
        $('.firstarea').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - FIRST FLOOR-COMMON AREA',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - FIRST FLOOR-COMMON AREA',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - FIRST FLOOR-COMMON AREA',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - FIRST FLOOR-COMMON AREA',
                },


            ]
        });
    </script>

    <script>
        $('.bioarea').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - BIO-MEDICAL WASTE STORAGE AREA',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - BIO-MEDICAL WASTE STORAGE AREA',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - BIO-MEDICAL WASTE STORAGE AREA',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - BIO-MEDICAL WASTE STORAGE AREA',
                },


            ]
        });
    </script>

    <script>
        $('.water').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - WATER STORAGE',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - WATER STORAGE',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - WATER STORAGE',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - WATER STORAGE',
                },


            ]
        });
    </script>

    <script>
        $('.electricalarea').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - ELECTRICAL ROOM/AREA',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ELECTRICAL ROOM/AREA',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ELECTRICAL ROOM/AREA',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - ELECTRICAL ROOM/AREA',
                },


            ]
        });
    </script>

    <script>
        $('.oxygenarea').DataTable({
            "ordering": true,
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
                    title: 'FACILITY SAFETY INSPECTION REPORT - OXYGEN CYLINDER STORAGE AREA',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - OXYGEN CYLINDER STORAGE AREA',
                },
                {
                    extend: 'excel',
                    title: 'FACILITY SAFETY INSPECTION REPORT - OXYGEN CYLINDER STORAGE AREA',
                    className: 'btn-sm',
                    title: 'FACILITY SAFETY INSPECTION REPORT - OXYGEN CYLINDER STORAGE AREA',
                },


            ]
        });
    </script>


    <script>
        $('.vapPrevention').DataTable({
            "ordering": true,
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
                    title: 'VAP PREVENTION CHECKLIST',
                    className: 'btn-sm',
                    title: 'VAP PREVENTION CHECKLIST',
                },
                {
                    extend: 'excel',
                    title: 'VAP PREVENTION CHECKLIST',
                    className: 'btn-sm',
                    title: 'VAP PREVENTION CHECKLIST',
                },


            ]
        });
    </script>

    <script>
        $('.catheter').DataTable({
            "ordering": true,
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
                    title: 'CATHETER INSERTION CHECKLIST',
                    className: 'btn-sm',
                    title: 'CATHETER INSERTION CHECKLIST',
                },
                {
                    extend: 'excel',
                    title: 'CATHETER INSERTION CHECKLIST',
                    className: 'btn-sm',
                    title: 'CATHETER INSERTION CHECKLIST',
                },


            ]
        });
    </script>

    <script>
        $('.ssi').DataTable({
            "ordering": true,
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
                    title: 'SSI BUNDLE CARE POLICY',
                    className: 'btn-sm',
                    title: 'SSI BUNDLE CARE POLICY',
                },
                {
                    extend: 'excel',
                    title: 'SSI BUNDLE CARE POLICY',
                    className: 'btn-sm',
                    title: 'SSI BUNDLE CARE POLICY',
                },


            ]
        });
    </script>

    <script>
        $('.urinary').DataTable({
            "ordering": true,
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
                    title: 'URINARY CATHETER MAINTENANCE CHECKLIST',
                    className: 'btn-sm',
                    title: 'URINARY CATHETER MAINTENANCE CHECKLIST',
                },
                {
                    extend: 'excel',
                    title: 'URINARY CATHETER MAINTENANCE CHECKLIST',
                    className: 'btn-sm',
                    title: 'URINARY CATHETER MAINTENANCE CHECKLIST',
                },


            ]
        });
    </script>

    <script>
        $('.central').DataTable({
            "ordering": true,
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
                    title: 'CENTRAL LINE INSERTION CHECKLIST',
                    className: 'btn-sm',
                    title: 'CENTRAL LINE INSERTION CHECKLIST',
                },
                {
                    extend: 'excel',
                    title: 'CENTRAL LINE INSERTION CHECKLIST',
                    className: 'btn-sm',
                    title: 'CENTRAL LINE INSERTION CHECKLIST',
                },


            ]
        });
    </script>

    <script>
        $('.centralline').DataTable({
            "ordering": true,
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
                    title: 'CENTRAL LINE MAINTENANCE CHECKLIST ',
                    className: 'btn-sm',
                    title: 'CENTRAL LINE MAINTENANCE CHECKLIST ',
                },
                {
                    extend: 'excel',
                    title: 'CENTRAL LINE MAINTENANCE CHECKLIST ',
                    className: 'btn-sm',
                    title: 'CENTRAL LINE MAINTENANCE CHECKLIST ',
                },


            ]
        });
    </script>

    <script>
        $('.room').DataTable({
            "ordering": true,
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
                    title: 'PATIENT ROOM CLEANING AUDIT',
                    className: 'btn-sm',
                    title: 'PATIENT ROOM CLEANING AUDIT',
                },
                {
                    extend: 'excel',
                    title: 'PATIENT ROOM CLEANING AUDIT',
                    className: 'btn-sm',
                    title: 'PATIENT ROOM CLEANING AUDIT ',
                },


            ]
        });
    </script>

    <script>
        $('.area').DataTable({
            "ordering": true,
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
                    title: 'OTHER AREA CLEANING CHECKLIST',
                    className: 'btn-sm',
                    title: 'OTHER AREA CLEANING CHECKLIST',
                },
                {
                    extend: 'excel',
                    title: 'OTHER AREA CLEANING CHECKLIST',
                    className: 'btn-sm',
                    title: 'OTHER AREA CLEANING CHECKLIST',
                },


            ]
        });
    </script>

    <script>
        $('.toilet').DataTable({
            "ordering": true,
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
                    title: 'TOILET CLEANING CHECKLIST',
                    className: 'btn-sm',
                    title: 'TOILET CLEANING CHECKLIST',
                },
                {
                    extend: 'excel',
                    title: 'TOILET CLEANING CHECKLIST',
                    className: 'btn-sm',
                    title: 'TOILET CLEANING CHECKLIST',
                },


            ]
        });
    </script>

    <script>
        $('.canteen').DataTable({
            "ordering": true,
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
                    title: 'CANTEEN AAUDIT CHECKLIST',
                    className: 'btn-sm',
                    title: 'CANTEEN AAUDIT CHECKLIST',
                },
                {
                    extend: 'excel',
                    title: 'CANTEEN AAUDIT CHECKLIST',
                    className: 'btn-sm',
                    title: 'CANTEEN AAUDIT CHECKLIST',
                },


            ]
        });
    </script>


    <!-- IP ALL FEEDBACKS -->
    <script>
        $('.ipallfeedbacks').DataTable({
            "ordering": true,
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
                    title: 'IP-FEEDBACK REPPORT',
                    className: 'btn-sm',
                    title: 'IP-FEEDBACK REPPORT',
                },
                {
                    extend: 'excel',
                    title: 'IP-FEEDBACK REPPORT',
                    className: 'btn-sm',
                    title: 'IP-FEEDBACK REPPORT',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Promoter List',
                //     className: 'btn-sm',
                //     title: 'IP-Promoter List',
                // },

            ]
        });
    </script>

    <!-- IP SATISFIED LIST -->
    <script>
        $('.ippsatsatisfied').DataTable({
            "ordering": true,
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
                    title: 'IP-SATISFIED LIST',
                    className: 'btn-sm',
                    title: 'IP-SATISFIED LIST',
                },
                {
                    extend: 'excel',
                    title: 'IP-SATISFIED LIST',
                    className: 'btn-sm',
                    title: 'IP-SATISFIED LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Satisfied List',
                //     className: 'btn-sm',
                //     title: 'IP-Satisfied List',
                // },

            ]
        });
    </script>

    <!-- IP UNSATISFIED LIST -->
    <script>
        $('.ippsatunsatisfied').DataTable({
            "ordering": true,
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
                    title: 'IP-UNSATISFIED LIST',
                    className: 'btn-sm',
                    title: 'IP-UNSATISFIED LIST',
                },
                {
                    extend: 'excel',
                    title: 'IP-UNSATISFIED LIST',
                    className: 'btn-sm',
                    title: 'IP-UNSATISFIED LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Satisfied List',
                //     className: 'btn-sm',
                //     title: 'IP-Satisfied List',
                // },

            ]
        });
    </script>

    <!-- IP PROMOTER LIST -->
    <script>
        $('.ipnpspromoters').DataTable({
            "ordering": true,
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
                    title: 'IP-PROMOTER LIST',
                    className: 'btn-sm',
                    title: 'IP-PROMOTER LIST',
                },
                {
                    extend: 'excel',
                    title: 'IP-PROMOTER LIST',
                    className: 'btn-sm',
                    title: 'IP-PROMOTER LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Promoter List',
                //     className: 'btn-sm',
                //     title: 'IP-Promoter List',
                // },

            ]
        });
    </script>

    <!-- IP PASSIVE LIST -->
    <script>
        $('.ipnpspassive').DataTable({
            "ordering": true,
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
                    title: 'IP-PASSIVE LIST',
                    className: 'btn-sm',
                    title: 'IP-PASSIVE LIST',
                },
                {
                    extend: 'excel',
                    title: 'IP-PASSIVE LIST',
                    className: 'btn-sm',
                    title: 'IP-PASSIVE LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Passive List',
                //     className: 'btn-sm',
                //     title: 'IP-Passive List',
                // },

            ]
        });
    </script>

    <!-- IP DETRACTOR LIST -->
    <script>
        $('.ipnpsdetractor').DataTable({
            "ordering": true,
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
                    title: 'IP-DETRACTOR LIST',
                    className: 'btn-sm',
                    title: 'IP-DETRACTOR LIST',
                },
                {
                    extend: 'excel',
                    title: 'IP-DETRACTOR LIST',
                    className: 'btn-sm',
                    title: 'IP-DETRACTOR LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Detractor List',
                //     className: 'btn-sm',
                //     title: 'IP-Detractor List',
                // },

            ]
        });
    </script>

    <!-- USER LIST -->
    <script>
        $('.userlisttable').DataTable({
            "ordering": true,
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
                    title: 'USER LIST',
                    className: 'btn-sm',
                    title: 'USER LIST',
                },
                {
                    extend: 'excel',
                    title: 'USER LIST',
                    className: 'btn-sm',
                    title: 'USER LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Promoter List',
                //     className: 'btn-sm',
                //     title: 'IP-Promoter List',
                // },

            ]
        });
    </script>

    <!-- IP ALL TICKETS -->
    <script>
        $('.ipticketsall').DataTable({
            "ordering": true,
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
                    title: 'IP-ALL TICKETS',
                    className: 'btn-sm',
                    title: 'IP-ALL TICKETS',
                },
                {
                    extend: 'excel',
                    title: 'IP-ALL TICKETS',
                    className: 'btn-sm',
                    title: 'IP-ALL TICKETS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Promoter List',
                //     className: 'btn-sm',
                //     title: 'IP-Promoter List',
                // },

            ]
        });
    </script>

    <!-- IP OPEN TICKETS -->
    <script>
        $('.ipticketsopen').DataTable({
            "ordering": true,
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
                    title: 'IP-OPEN TICKETS',
                    className: 'btn-sm',
                    title: 'IP-OPEN TICKETS',
                },
                {
                    extend: 'excel',
                    title: 'IP-OPEN TICKETS',
                    className: 'btn-sm',
                    title: 'IP-OPEN TICKETS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'IP-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- IP ADDRESSED TICKETS -->
    <script>
        $('.ipticketsaddressed').DataTable({
            "ordering": true,
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
                    title: 'IP-ADDRESSED TICKETS',
                    className: 'btn-sm',
                    title: 'IP-ADDRESSED TICKETS',
                },
                {
                    extend: 'excel',
                    title: 'IP-ADDRESSED TICKETS',
                    className: 'btn-sm',
                    title: 'IP-ADDRESSED TICKETS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'IP-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- IP CLOSED TICKETS -->
    <script>
        $('.ipticketsclose').DataTable({
            "ordering": true,
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
                    title: 'IP-CLOSED TICKETS',
                    className: 'btn-sm',
                    title: 'IP-CLOSED TICKETS',
                },
                {
                    extend: 'excel',
                    title: 'IP-CLOSED TICKETS',
                    className: 'btn-sm',
                    title: 'IP-CLOSED TICKETS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'IP-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- IP CAPA REPORT -->
    <script>
        $('.ipcapa').DataTable({
            "ordering": true,
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
                    title: 'IP-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'IP-CAPA REPORT',
                },
                {
                    extend: 'excel',
                    title: 'IP-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'IP-CAPA REPORT',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Promoter List',
                //     className: 'btn-sm',
                //     title: 'IP-Promoter List',
                // },

            ]
        });
    </script>

    <!-- IP STAFF REPORT -->
    <script>
        $('.ipstaffrec').DataTable({
            "ordering": true,
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
                    title: 'IP-STAFF REPPORT',
                    className: 'btn-sm',
                    title: 'IP-STAFF REPPORT',
                },
                {
                    extend: 'excel',
                    title: 'IP-STAFF REPPORT',
                    className: 'btn-sm',
                    title: 'IP-STAFF REPPORT',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Staff List',
                //     className: 'btn-sm',
                //     title: 'IP-Staff List',
                // },

            ]
        });
    </script>


    <!-- OUTPATIENT MODULES -->
    <script>
        $('.opticketanalisys').DataTable({
            "ordering": true,
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
                    title: 'OP-TICKET ANALISYS',
                    className: 'btn-sm',
                    title: 'OP-TICKET ANALISYS',
                },
                {
                    extend: 'excel',
                    title: 'OP-TICKET ANALISYS',
                    className: 'btn-sm',
                    title: 'OP-TICKET ANALISYS',
                },

            ]
        });
    </script>
    <!-- OP ALL FEEDBACKS -->
    <script>
        $('.opallfeedbacks').DataTable({
            "ordering": true,
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
                    title: 'OP-FEEDBACK REPPORT',
                    className: 'btn-sm',
                    title: 'OP-FEEDBACK REPPORT',
                },
                {
                    extend: 'excel',
                    title: 'OP-FEEDBACK REPPORT',
                    className: 'btn-sm',
                    title: 'OP-FEEDBACK REPPORT',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Promoter List',
                //     className: 'btn-sm',
                //     title: 'IP-Promoter List',
                // },

            ]
        });
    </script>

    <!-- OP SATISFIED LIST -->
    <script>
        $('.oppsatsatisfied').DataTable({
            "ordering": true,
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
                    title: 'OP-SATISFIED LIST',
                    className: 'btn-sm',
                    title: 'OP-SATISFIED LIST',
                },
                {
                    extend: 'excel',
                    title: 'OP-SATISFIED LIST',
                    className: 'btn-sm',
                    title: 'OP-SATISFIED LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'OP-Satisfied List',
                //     className: 'btn-sm',
                //     title: 'OP-Satisfied List',
                // },

            ]
        });
    </script>

    <!-- OP UNSATISFIED LIST -->
    <script>
        $('.oppsatunsatisfied').DataTable({
            "ordering": true,
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
                    title: 'OP-UNSATISFIED LIST',
                    className: 'btn-sm',
                    title: 'OP-UNSATISFIED LIST',
                },
                {
                    extend: 'excel',
                    title: 'OP-UNSATISFIED LIST',
                    className: 'btn-sm',
                    title: 'OP-UNSATISFIED LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'OP-Satisfied List',
                //     className: 'btn-sm',
                //     title: 'OP-Satisfied List',
                // },

            ]
        });
    </script>

    <!-- OP PROMOTER LIST -->
    <script>
        $('.opnpspromoters').DataTable({
            "ordering": true,
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
                    title: 'OP-PROMOTER LIST',
                    className: 'btn-sm',
                    title: 'OP-PROMOTER LIST',
                },
                {
                    extend: 'excel',
                    title: 'OP-PROMOTER LIST',
                    className: 'btn-sm',
                    title: 'OP-PROMOTER LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'OP-Promoter List',
                //     className: 'btn-sm',
                //     title: 'OP-Promoter List',
                // },

            ]
        });
    </script>

    <!-- OP PASSIVE LIST -->
    <script>
        $('.opnpspassive').DataTable({
            "ordering": true,
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
                    title: 'OP-PASSIVE LIST',
                    className: 'btn-sm',
                    title: 'OP-PASSIVE LIST',
                },
                {
                    extend: 'excel',
                    title: 'OP-PASSIVE LIST',
                    className: 'btn-sm',
                    title: 'OP-PASSIVE LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'OP-Passive List',
                //     className: 'btn-sm',
                //     title: 'OP-Passive List',
                // },

            ]
        });
    </script>

    <!-- OP DETRACTOR LIST -->
    <script>
        $('.opnpsdetractor').DataTable({
            "ordering": true,
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
                    title: 'OP-DETRACTOR LIST',
                    className: 'btn-sm',
                    title: 'OP-DETRACTOR LIST',
                },
                {
                    extend: 'excel',
                    title: 'OP-DETRACTOR LIST',
                    className: 'btn-sm',
                    title: 'OP-DETRACTOR LIST',
                },
                // {
                //     extend: 'pdf',
                //     title: 'OP-Detractor List',
                //     className: 'btn-sm',
                //     title: 'OP-Detractor List',
                // },

            ]
        });
    </script>

    <!-- OP ALL TICKETS -->
    <script>
        $('.opticketsall').DataTable({
            "ordering": true,
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
                    title: 'OP-ALL TICKETS',
                    className: 'btn-sm',
                    title: 'OP-ALL TICKETS',
                },
                {
                    extend: 'excel',
                    title: 'OP-ALL TICKETS',
                    className: 'btn-sm',
                    title: 'OP-ALL TICKETS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Promoter List',
                //     className: 'btn-sm',
                //     title: 'IP-Promoter List',
                // },

            ]
        });
    </script>

    <!-- OP OPEN TICKETS -->
    <script>
        $('.opticketsopen').DataTable({
            "ordering": true,
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
                    title: 'OP-OPEN TICKETS',
                    className: 'btn-sm',
                    title: 'OP-OPEN TICKETS',
                },
                {
                    extend: 'excel',
                    title: 'OP-OPEN TICKETS',
                    className: 'btn-sm',
                    title: 'OP-OPEN TICKETS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'IP-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- OP ADDRESSED TICKETS -->
    <script>
        $('.opticketsaddressed').DataTable({
            "ordering": true,
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
                    title: 'OP-ADDRESSED TICKETS',
                    className: 'btn-sm',
                    title: 'OP-ADDRESSED TICKETS',
                },
                {
                    extend: 'excel',
                    title: 'OP-ADDRESSED TICKETS',
                    className: 'btn-sm',
                    title: 'OP-ADDRESSED TICKETS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'IP-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- OP CLOSED TICKETS -->
    <script>
        $('.opticketsclose').DataTable({
            "ordering": true,
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
                    title: 'OP-CLOSED TICKETS',
                    className: 'btn-sm',
                    title: 'OP-CLOSED TICKETS',
                },
                {
                    extend: 'excel',
                    title: 'OP-CLOSED TICKETS',
                    className: 'btn-sm',
                    title: 'OP-CLOSED TICKETS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'IP-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- OP CAPA REPORT -->
    <script>
        $('.opcapa').DataTable({
            "ordering": true,
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
                    title: 'OP-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'OP-CAPA REPORT',
                },
                {
                    extend: 'excel',
                    title: 'OP-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'OP-CAPA REPORT',
                },
                // {
                //     extend: 'pdf',
                //     title: 'IP-Promoter List',
                //     className: 'btn-sm',
                //     title: 'IP-Promoter List',
                // },

            ]
        });
    </script>


    <!-- PATIENT COMPLAINTS MODULES -->
    <script>
        $('.pcticketanalisys').DataTable({
            "ordering": true,
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
                    title: 'PC-COMPLAINT ANALISYS',
                    className: 'btn-sm',
                    title: 'PC-COMPLAINT ANALISYS',
                },
                {
                    extend: 'excel',
                    title: 'PC-COMPLAINT ANALISYS',
                    className: 'btn-sm',
                    title: 'PC-COMPLAINT ANALISYS',
                },

            ]
        });
    </script>
    <!-- PC ALL COMPLAINTS -->
    <script>
        $('.pcticketsall').DataTable({
            "ordering": true,
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
                    title: 'PC-ALL COMPLAINTS',
                    className: 'btn-sm',
                    title: 'PC-ALL COMPLAINTS',
                },
                {
                    extend: 'excel',
                    title: 'PC-ALL COMPLAINTS',
                    className: 'btn-sm',
                    title: 'PC-ALL COMPLAINTS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'PC-Promoter List',
                //     className: 'btn-sm',
                //     title: 'PC-Promoter List',
                // },

            ]
        });
    </script>

    <!-- PC OPEN COMPLAINTS -->
    <script>
        $('.pcticketsopen').DataTable({
            "ordering": true,
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
                    title: 'PC-OPEN COMPLAINTS',
                    className: 'btn-sm',
                    title: 'PC-OPEN COMPLAINTS',
                },
                {
                    extend: 'excel',
                    title: 'PC-OPEN COMPLAINTS',
                    className: 'btn-sm',
                    title: 'PC-OPEN COMPLAINTS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'PC-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'PC-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- PC ADDRESSED COMPLAINTS -->
    <script>
        $('.pcticketsaddressed').DataTable({
            "ordering": true,
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
                    title: 'PC-ADDRESSED COMPLAINTS',
                    className: 'btn-sm',
                    title: 'PC-ADDRESSED COMPLAINTS',
                },
                {
                    extend: 'excel',
                    title: 'PC-ADDRESSED COMPLAINTS',
                    className: 'btn-sm',
                    title: 'PC-ADDRESSED COMPLAINTS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'PC-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'PC-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- PC CLOSED COMPLAINTS -->
    <script>
        $('.pcticketsclose').DataTable({
            "ordering": true,
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
                    title: 'PC-CLOSED COMPLAINTS',
                    className: 'btn-sm',
                    title: 'PC-CLOSED COMPLAINTS',
                },
                {
                    extend: 'excel',
                    title: 'PC-CLOSED COMPLAINTS',
                    className: 'btn-sm',
                    title: 'PC-CLOSED COMPLAINTS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'PC-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'PC-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- PC CAPA REPORT -->
    <script>
        $('.pccapa').DataTable({
            "ordering": true,
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
                    title: 'PC-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'PC-CAPA REPORT',
                },
                {
                    extend: 'excel',
                    title: 'PC-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'PC-CAPA REPORT',
                },
                // {
                //     extend: 'pdf',
                //     title: 'PC-Promoter List',
                //     className: 'btn-sm',
                //     title: 'PC-Promoter List',
                // },

            ]
        });
    </script>


    <!-- ISR REQUESTS MODULES -->
    <script>
        $('.isrticketanalisys').DataTable({
            "ordering": true,
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
                    title: 'ISR-REQUEST ANALISYS',
                    className: 'btn-sm',
                    title: 'ISR-REQUEST ANALISYS',
                },
                {
                    extend: 'excel',
                    title: 'ISR-REQUEST ANALISYS',
                    className: 'btn-sm',
                    title: 'ISR-REQUEST ANALISYS',
                },

            ]
        });
    </script>
    <!-- ISR ALL REQUESTS -->
    <script>
        $('.esrticketsall').DataTable({
            "ordering": true,
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
                    title: 'ISR-ALL REQUESTS',
                    className: 'btn-sm',
                    title: 'ISR-ALL REQUESTS',
                },
                {
                    extend: 'excel',
                    title: 'ISR-ALL REQUESTS',
                    className: 'btn-sm',
                    title: 'ISR-ALL REQUESTS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'ISR-Promoter List',
                //     className: 'btn-sm',
                //     title: 'ISR-Promoter List',
                // },

            ]
        });
    </script>

    <!-- ISR OPEN REQUESTS -->
    <script>
        $('.esrticketsopen').DataTable({
            "ordering": true,
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
                    title: 'ISR-OPEN REQUESTS',
                    className: 'btn-sm',
                    title: 'ISR-OPEN REQUESTS',
                },
                {
                    extend: 'excel',
                    title: 'ISR-OPEN REQUESTS',
                    className: 'btn-sm',
                    title: 'ISR-OPEN REQUESTS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'INC-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'INC-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- ISR ADDRESSED REQUESTS -->
    <script>
        $('.esrticketsaddressed').DataTable({
            "ordering": true,
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
                    title: 'ISR-ADDRESSED REQUESTS',
                    className: 'btn-sm',
                    title: 'ISR-ADDRESSED REQUESTS',
                },
                {
                    extend: 'excel',
                    title: 'ISR-ADDRESSED REQUESTS',
                    className: 'btn-sm',
                    title: 'ISR-ADDRESSED REQUESTS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'ISR-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'ISR-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- ISR CLOSED REQUESTS -->
    <script>
        $('.esrticketsclose').DataTable({
            "ordering": true,
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
                    title: 'ISR-CLOSED REQUESTS',
                    className: 'btn-sm',
                    title: 'ISR-CLOSED REQUESTS',
                },
                {
                    extend: 'excel',
                    title: 'ISR-CLOSED REQUESTS',
                    className: 'btn-sm',
                    title: 'ISR-CLOSED REQUESTS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'ISR-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'ISR-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- ISR CAPA REPORT -->
    <script>
        $('.esrcapa').DataTable({
            "ordering": true,
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
                    title: 'ISR-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'ISR-CAPA REPORT',
                },
                {
                    extend: 'excel',
                    title: 'ISR-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'ISR-CAPA REPORT',
                },
                // {
                //     extend: 'pdf',
                //     title: 'ISR-Promoter List',
                //     className: 'btn-sm',
                //     title: 'ISR-Promoter List',
                // },

            ]
        });
    </script>


    <!-- INC INCIDENTS MODULES -->
    <script>
        $('.incticketanalisys').DataTable({
            "ordering": true,
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
                    title: 'INC-INCIDENT ANALISYS',
                    className: 'btn-sm',
                    title: 'INC-INCIDENT ANALISYS',
                },
                {
                    extend: 'excel',
                    title: 'INC-INCIDENT ANALISYS',
                    className: 'btn-sm',
                    title: 'INC-INCIDENT ANALISYS',
                },

            ]
        });
    </script>
    <!-- INC ALL INCIDENTS -->
    <script>
        $('.incticketsall').DataTable({
            "ordering": true,
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
                    title: 'INC-ALL INCIDENTS',
                    className: 'btn-sm',
                    title: 'INC-ALL INCIDENTS',
                },
                {
                    extend: 'excel',
                    title: 'INC-ALL INCIDENTS',
                    className: 'btn-sm',
                    title: 'INC-ALL INCIDENTS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'INC-Promoter List',
                //     className: 'btn-sm',
                //     title: 'INC-Promoter List',
                // },

            ]
        });
    </script>

    <!-- INC OPEN INCIDENTS -->
    <script>
        $('.incticketsopen').DataTable({
            "ordering": true,
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
                    title: 'INC-OPEN INCIDENTS',
                    className: 'btn-sm',
                    title: 'INC-OPEN INCIDENTS',
                },
                {
                    extend: 'excel',
                    title: 'INC-OPEN INCIDENTS',
                    className: 'btn-sm',
                    title: 'INC-OPEN INCIDENTS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'INC-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'INC-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- INC ADDRESSED INCIDENTS -->
    <script>
        $('.incticketsaddressed').DataTable({
            "ordering": true,
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
                    title: 'INC-ADDRESSED INCIDENTS',
                    className: 'btn-sm',
                    title: 'INC-ADDRESSED INCIDENTS',
                },
                {
                    extend: 'excel',
                    title: 'INC-ADDRESSED INCIDENTS',
                    className: 'btn-sm',
                    title: 'INC-ADDRESSED INCIDENTS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'INC-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'INC-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- INC CLOSED INCIDENTS -->
    <script>
        $('.incticketsclose').DataTable({
            "ordering": true,
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
                    title: 'INC-CLOSED INCIDENTS',
                    className: 'btn-sm',
                    title: 'INC-CLOSED INCIDENTS',
                },
                {
                    extend: 'excel',
                    title: 'INC-CLOSED INCIDENTS',
                    className: 'btn-sm',
                    title: 'INC-CLOSED INCIDENTS',
                },
                // {
                //     extend: 'pdf',
                //     title: 'INC-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'INC-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- INC CAPA REPORT -->
    <script>
        $('.inccapareport').DataTable({
            "ordering": true,
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
                    title: 'INC-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'INC-CAPA REPORT',
                },
                {
                    extend: 'excel',
                    title: 'INC-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'INC-CAPA REPORT',
                },
                // {
                //     extend: 'pdf',
                //     title: 'INC-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'INC-Open Tickets',
                // },

            ]
        });
    </script>


    <!-- SG GRIEVANCES MODULES -->
    <script>
        $('.sgticketanalisys').DataTable({
            "ordering": true,
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
                    title: 'SG-GRIEVANCE ANALISYS',
                    className: 'btn-sm',
                    title: 'SG-GRIEVANCE ANALISYS',
                },
                {
                    extend: 'excel',
                    title: 'SG-GRIEVANCE ANALISYS',
                    className: 'btn-sm',
                    title: 'SG-GRIEVANCE ANALISYS',
                },

            ]
        });
    </script>
    <!-- SG ALL GRIEVANCES -->
    <script>
        $('.grievanceticketsall').DataTable({
            "ordering": true,
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
                    title: 'SG-ALL GRIEVANCES',
                    className: 'btn-sm',
                    title: 'SG-ALL GRIEVANCES',
                },
                {
                    extend: 'excel',
                    title: 'SG-ALL GRIEVANCES',
                    className: 'btn-sm',
                    title: 'SG-ALL GRIEVANCES',
                },
                // {
                //     extend: 'pdf',
                //     title: 'INC-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'INC-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- SG OPEN GRIEVANCES -->
    <script>
        $('.grievanceticketsopen').DataTable({
            "ordering": true,
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
                    title: 'SG-OPEN GRIEVANCES',
                    className: 'btn-sm',
                    title: 'SG-OPEN GRIEVANCES',
                },
                {
                    extend: 'excel',
                    title: 'SG-OPEN GRIEVANCES',
                    className: 'btn-sm',
                    title: 'SG-OPEN GRIEVANCES',
                },
                // {
                //     extend: 'pdf',
                //     title: 'INC-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'INC-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- SG ADDRESSED GRIEVANCES -->
    <script>
        $('.grievanceticketsaddressed').DataTable({
            "ordering": true,
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
                    title: 'SG-ADDRESSED GRIEVANCES',
                    className: 'btn-sm',
                    title: 'SG-ADDRESSED GRIEVANCES',
                },
                {
                    extend: 'excel',
                    title: 'SG-ADDRESSED GRIEVANCES',
                    className: 'btn-sm',
                    title: 'SG-ADDRESSED GRIEVANCES',
                },
                // {
                //     extend: 'pdf',
                //     title: 'INC-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'INC-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- SG CLOSED GRIEVANCES -->
    <script>
        $('.grievanceticketsclose').DataTable({
            "ordering": true,
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
                    title: 'SG-CLOSED GRIEVANCES',
                    className: 'btn-sm',
                    title: 'SG-CLOSED GRIEVANCES',
                },
                {
                    extend: 'excel',
                    title: 'SG-CLOSED GRIEVANCES',
                    className: 'btn-sm',
                    title: 'SG-CLOSED GRIEVANCES',
                },
                // {
                //     extend: 'pdf',
                //     title: 'INC-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'INC-Open Tickets',
                // },

            ]
        });
    </script>

    <!-- SG CAPA REPORT -->
    <script>
        $('.grievancecapa').DataTable({
            "ordering": true,
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
                    title: 'SG-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'SG-CAPA REPORT',
                },
                {
                    extend: 'excel',
                    title: 'SG-CAPA REPORT',
                    className: 'btn-sm',
                    title: 'SG-CAPA REPORT',
                },
                // {
                //     extend: 'pdf',
                //     title: 'INC-Open Tickets',
                //     className: 'btn-sm',
                //     title: 'INC-Open Tickets',
                // },

            ]
        });
    </script>




    <script>
        $('.assetticketsall').DataTable({
            "ordering": false,
            responsive: false,
            scrollX: true,
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
                    title: 'ALL ASSET LIST',
                    className: 'btn-sm',
                    title: 'ALL ASSET LIST',
                },
                {
                    extend: 'excel',
                    title: 'ALL ASSET LIST',
                    className: 'btn-sm',
                    title: 'ALL ASSET LIST',
                },

            ]
        });
    </script>

    <script>
        $('.assetpm').DataTable({
            "ordering": false,
            responsive: false,
            scrollX: true,
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
                    title: 'PREVENTIVE MAINTENANCE REPORT',
                    className: 'btn-sm',
                    title: 'PREVENTIVE MAINTENANCE REPORT',
                },
                {
                    extend: 'excel',
                    title: 'PREVENTIVE MAINTENANCE REPORT',
                    className: 'btn-sm',
                    title: 'PREVENTIVE MAINTENANCE REPORT',
                },

            ]
        });
    </script>

    <script>
        $('.assetcalibration').DataTable({
            "ordering": false,
            responsive: false,
            scrollX: true,
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
                    title: 'CALIBRATION REPORT',
                    className: 'btn-sm',
                    title: 'CALIBRATION REPORT',
                },
                {
                    extend: 'excel',
                    title: 'CALIBRATION REPORT',
                    className: 'btn-sm',
                    title: 'CALIBRATION REPORT',
                },

            ]
        });
    </script>

    <script>
        $('.assetwarranty').DataTable({
            "ordering": false,
            responsive: false,
            scrollX: true,
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
                    title: 'ASSET WARRANTY REPORT',
                    className: 'btn-sm',
                    title: 'ASSET WARRANTY REPORT',
                },
                {
                    extend: 'excel',
                    title: 'ASSET WARRANTY REPORT',
                    className: 'btn-sm',
                    title: 'ASSET WARRANTY REPORT',
                },

            ]
        });
    </script>

    <script>
        $('.assetcontract').DataTable({
            "ordering": false,
            responsive: false,
            scrollX: true,
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
                    title: 'ASSET AMC/ CMC REPORT',
                    className: 'btn-sm',
                    title: 'ASSET AMC/ CMC REPORT',
                },
                {
                    extend: 'excel',
                    title: 'ASSET AMC/ CMC REPORT',
                    className: 'btn-sm',
                    title: 'ASSET AMC/ CMC REPORT',
                },

            ]
        });
    </script>

    <script>
        $('.assetbroken').DataTable({
            "ordering": true,
            responsive: false,
            scrollX: true,
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
                    title: 'BROKEN ASSETS LIST',
                    className: 'btn-sm',
                    title: 'BROKEN ASSETS LIST',
                },
                {
                    extend: 'excel',
                    title: 'BROKEN ASSETS LIST',
                    className: 'btn-sm',
                    title: 'BROKEN ASSETS LIST',
                },

            ]
        });
    </script>

    <script>
        $('.assetassign').DataTable({
            "ordering": false,
            responsive: false,
            scrollX: true,
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
                    title: 'USED ASSETS LIST',
                    className: 'btn-sm',
                    title: 'USED ASSETS LIST',
                },
                {
                    extend: 'excel',
                    title: 'USED ASSETS LIST',
                    className: 'btn-sm',
                    title: 'USED ASSETS LIST',
                },

            ]
        });
    </script>

    <script>
        $('.assetdispose').DataTable({
            "ordering": false,
            responsive: false,
            scrollX: true,
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
                    title: 'DISPOSED ASSETS LIST',
                    className: 'btn-sm',
                    title: 'DISPOSED ASSETS LIST',
                },
                {
                    extend: 'excel',
                    title: 'DISPOSED ASSETS LIST',
                    className: 'btn-sm',
                    title: 'DISPOSED ASSETS LIST',
                },

            ]
        });
    </script>

    <script>
        $('.assetlost').DataTable({
            "ordering": false,
            responsive: false,
            scrollX: true,
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
                    title: 'LOST ASSETS LIST',
                    className: 'btn-sm',
                    title: 'LOST ASSETS LIST',
                },
                {
                    extend: 'excel',
                    title: 'LOST ASSETS LIST',
                    className: 'btn-sm',
                    title: 'LOST ASSETS LIST',
                },

            ]
        });
    </script>

    <script>
        $('.assetuse').DataTable({
            "ordering": false,
            responsive: false,
            scrollX: true,
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
                    title: 'USED ASSETS LIST',
                    className: 'btn-sm',
                    title: 'USED ASSETS LIST',
                },
                {
                    extend: 'excel',
                    title: 'USED ASSETS LIST',
                    className: 'btn-sm',
                    title: 'USED ASSETS LIST',
                },

            ]
        });
    </script>

    <script>
        $('.assetrepair').DataTable({
            "ordering": false,
            responsive: false,
            scrollX: true,
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
                    title: 'ASSET REPAIR LIST',
                    className: 'btn-sm',
                    title: 'ASSET REPAIR LIST',
                },
                {
                    extend: 'excel',
                    title: 'ASSET REPAIR LIST',
                    className: 'btn-sm',
                    title: 'ASSET REPAIR LIST',
                },

            ]
        });
    </script>

    <script>
        $('.assetunall').DataTable({
            "ordering": false,
            responsive: false,
            scrollX: true,
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
                    title: 'UNALLOCATED ASSETS LIST',
                    className: 'btn-sm',
                    title: 'UNALLOCATED ASSETS LIST',
                },
                {
                    extend: 'excel',
                    title: 'UNALLOCATED ASSETS LIST',
                    className: 'btn-sm',
                    title: 'UNALLOCATED ASSETS LIST',
                },

            ]
        });
    </script>

    <script>
        $('.assetsold').DataTable({
            "ordering": false,
            responsive: false,
            scrollX: true,
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
                    title: 'SOLD ASSET LIST',
                    className: 'btn-sm',
                    title: 'SOLD ASSET LIST',
                },
                {
                    extend: 'excel',
                    title: 'SOLD ASSET LIST',
                    className: 'btn-sm',
                    title: 'SOLD ASSET LIST',
                },

            ]
        });
    </script>



    <script>
        $('.listtickets').DataTable({
            "ordering": false,
            responsive: true,
            // "pageLength": 50,
            // dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            // "lengthMenu": [
            //     [10, 25, 50, -1],
            //     [10, 25, 50, "All"]
            // ],
            // buttons: [
            //     /*  {extend: 'copy', className: 'btn-sm'},*/
            //     {
            //         extend: 'csv',
            //         title: 'IP-All Tickets',
            //         className: 'btn-sm',
            //         title: 'IP-All Tickets',
            //     },
            //     {
            //         extend: 'excel',
            //         title: 'IP-All Tickets',
            //         className: 'btn-sm',
            //         title: 'IP-All Tickets',
            //     },
            //     // {
            //     //     extend: 'pdf',
            //     //     title: 'IP-Promoter List',
            //     //     className: 'btn-sm',
            //     //     title: 'IP-Promoter List',
            //     // },

            // ]
        });
    </script>
    <script>
        // Initialize the DataTable
        $('.vertical-table').DataTable({
            "ordering": false,
            "searching": false,
            "paging": false,
            responsive: true,
            "bInfo": false
        });

        // Force all responsive-hidden columns to be shown
        setTimeout(function() {
            $('.vertical-table tr td').each(function(e) {
                $(this).click();
            });
        }, 200);
    </script>


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
                    title: 'OP-PASSIVE LIST',
                    className: 'btn-sm',
                    title: 'OP-PASSIVE LIST'
                },
                {
                    extend: 'excel',
                    title: 'OP-PASSIVE LIST',
                    className: 'btn-sm',
                    title: 'OP-PASSIVE LIST'
                },
                /*{extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},*/
                /*{extend: 'print', className: 'btn-sm'}*/
            ]
        });
    </script>

    <script>
        // // Show the loader before the page unloads
        // window.addEventListener("beforeunload", function() {
        //     const loadingOverlay = document.getElementById("loading-overlay");
        //     loadingOverlay.classList.add("active");
        // });

        // // Hide the loader after the page loads
        // window.addEventListener("load", function() {
        //     const loadingOverlay = document.getElementById("loading-overlay");
        //     loadingOverlay.classList.remove("active");
        // });
        // Show the loader before the page unloads
        // Show the loader before the page unloads
        window.addEventListener("beforeunload", function() {
            const loadingOverlay = document.getElementById("loading-overlay");
            const loadingMessage = document.getElementById("loading-message");

            if (loadingOverlay && loadingMessage) {
                let seconds = 15; // Initial seconds to display
                loadingMessage.textContent = `Loading... ${seconds}s`; // Initial message

                // Update the countdown every second
                const countdown = setInterval(() => {
                    seconds -= 1;
                    loadingMessage.textContent = `Loading... ${seconds}s`;

                    // Stop the countdown when it reaches zero
                    if (seconds <= 0) {
                        clearInterval(countdown);
                    }
                }, 1000);

                loadingOverlay.classList.add("active");
            }
        });

        // Hide the loader after the page loads
        window.addEventListener("load", function() {
            const loadingOverlay = document.getElementById("loading-overlay");
            const loadingMessage = document.getElementById("loading-message");

            if (loadingOverlay && loadingMessage) {
                loadingOverlay.classList.remove("active");
            }
        });
    </script>
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
                    title: 'OP-PROMOTER LIST',
                    className: 'btn-sm',
                    title: 'OP-PROMOTER LIST'
                },
                {
                    extend: 'excel',
                    title: 'OP-PROMOTER LIST',
                    className: 'btn-sm',
                    title: 'OP-PROMOTER LIST'
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
                    title: 'OP-DETRACTOR LIST',
                    className: 'btn-sm',
                    title: 'OP-DETRACTOR LIST'
                },
                {
                    extend: 'excel',
                    title: 'OP-DETRACTOR LIST',
                    className: 'btn-sm',
                    title: 'OP-DETRACTOR LIST'
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
            ordering: true,
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
        // $(document).ready(function() {
        // Hide all elements by default
        setTimeout(function() {
            $('#capa').hide();
            $('#address').hide();
            $('#move').hide();
            $('#reopen').hide();
            $('#assign').hide();
            $('#reject').hide();
            $('#describe').hide();
            $('#reassign').hide();
            $('#verify').hide();
            $('#asset_assign').hide();
            $('#asset_broken').hide();
            $('#asset_repair').hide();
            $('#asset_sold').hide();
            $('#asset_revoke').hide();
            $('#asset_lost').hide();
            $('#asset_dispose').hide();
            $('#asset_preventive').hide();
            $('#asset_transfer').hide();
            $('#asset_warranty').hide();
            $('#asset_amc_cmc').hide();
            $('#asset_restore').hide();
            $('#asset_calibration').hide();



        }, 1000);

        function ticket_options(val) {
            if (val == 'capa') {
                $('#capa').show();
                $('#address').hide();
                $('#move').hide();
                $('#reopen').hide();
                $('#assign').hide();
                $('#reject').hide();
                $('#describe').hide();
                $('#reassign').hide();
                $('#verify').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();





            } else if (val == 'address') {
                $('#address').show();
                $('#capa').hide();
                $('#move').hide();
                $('#reopen').hide();
                $('#assign').hide();
                $('#reject').hide();
                $('#describe').hide();
                $('#reassign').hide();
                $('#verify').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();




            } else if (val == 'reject') {
                $('#reject').show();
                $('#capa').hide();
                $('#move').hide();
                $('#reopen').hide();
                $('#assign').hide();
                $('#address').hide();
                $('#describe').hide();
                $('#reassign').hide();
                $('#verify').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();




            } else if (val == 'movetick') {
                $('#move').show();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#assign').hide();
                $('#reject').hide();
                $('#describe').hide();
                $('#reassign').hide();
                $('#verify').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();




            } else if (val == 'assignuser') {
                $('#assign').show();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#move').hide();
                $('#reject').hide();
                $('#describe').hide();
                $('#reassign').hide();
                $('#verify').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();




            } else if (val == 'reassign') {
                $('#assign').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#move').hide();
                $('#reject').hide();
                $('#describe').hide();
                $('#reassign').show();
                $('#verify').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();




            } else if (val == 'reopen') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').show();
                $('#assign').hide();
                $('#reject').hide();
                $('#describe').hide();
                $('#reassign').hide();
                $('#verify').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();




            } else if (val == 'verify') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#assign').hide();
                $('#reject').hide();
                $('#describe').hide();
                $('#reassign').hide();
                $('#verify').show();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();




            } else if (val == 'describe') {
                $('#move').hide();
                $('#capa').hide();
                $('#reopen').hide();
                $('#address').hide();
                $('#describe').show();
                $('#assign').hide();
                $('#reject').hide();
                $('#reassign').hide();
                $('#verify').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();




            } else if (val == 'asset_sold') {
                $('#move').hide();
                $('#capa').hide();
                $('#reopen').hide();
                $('#address').hide();
                $('#describe').hide();
                $('#assign').hide();
                $('#reject').hide();
                $('#reassign').hide();
                $('#verify').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').show();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();




            } else if (val == 'asset_assign') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#asset_assign').show();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();



            } else if (val == 'asset_broken') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#asset_assign').hide();
                $('#asset_broken').show();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();



            } else if (val == 'asset_repair') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').show();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();



            } else if (val == 'asset_revoke') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').show();
                $('#asset_lost').hide();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();



            } else if (val == 'asset_lost') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').show();
                $('#asset_dispose').hide();
                $('#asset_preventive').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();



            } else if (val == 'asset_dispose') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_preventive').hide();
                $('#asset_dispose').show();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();



            } else if (val == 'asset_preventive') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_preventive').show();
                $('#asset_dispose').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();



            } else if (val == 'asset_warranty') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_preventive').hide();
                $('#asset_dispose').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').show();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();



            } else if (val == 'asset_amc_cmc') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_preventive').hide();
                $('#asset_dispose').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').show();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();



            } else if (val == 'asset_restore') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_preventive').hide();
                $('#asset_dispose').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').show();
                $('#asset_calibration').hide();



            } else if (val == 'asset_transfer') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_preventive').hide();
                $('#asset_dispose').hide();
                $('#asset_transfer').show();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').hide();



            } else if (val == 'asset_calibration') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#asset_assign').hide();
                $('#asset_broken').hide();
                $('#asset_repair').hide();
                $('#asset_sold').hide();
                $('#asset_revoke').hide();
                $('#asset_lost').hide();
                $('#asset_preventive').hide();
                $('#asset_dispose').hide();
                $('#asset_transfer').hide();
                $('#asset_warranty').hide();
                $('#asset_amc_cmc').hide();
                $('#asset_restore').hide();
                $('#asset_calibration').show();



            } else if (val == 'Open' || val == 'Close' || val == 'Addressed' || val == 'Reopen' || val == 'describe' || val == 'reassign' || val == 'verify') {
                $('#move').hide();
                $('#capa').hide();
                $('#address').hide();
                $('#reopen').hide();
                $('#assign').hide();
                $('#reject').hide();
                $('#describe').hide();
                $('#reassign').hide();
                $('#verify').hide();

            }
            $('input:checkbox').attr('checked', false);
        }
    </script>
    <!-- DISCHARGE INPATIENT MODULES -->




</body>

</html>
