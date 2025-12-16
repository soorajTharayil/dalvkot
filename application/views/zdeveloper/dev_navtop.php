<?php

// if ($this->session->userdata['user_access'] == 1 || $this->session->user_id == 1) {
if ($this->session->userdata['user_role'] == 0) {
    $dates = get_from_to_date();
    $pagetitle = $dates['pagetitle'];
    $y = date('Y');
?>
    <div class="filterbor">
        <!-- style="background:#e0f3cf" -->
        <div class="p-l-30 p-r-30" style="padding: 0px; margin-bottom:-11px;">

            <table class="table table-filter" style="width: 100%; margin-left: 53px;margin-right: -53px; padding:10px; vertical-align:middle; ">
                <tr>



                    <td style="white-space: nowrap;">
                        <span style="margin: 0px -2px 0px -17px; font-size: 17px;">
                            <strong>Showing:</strong>
                        </span>
                    </td>
                    <td>
                        <?php if ($this->session->userdata['active_menu'] ==  null ||  $this->uri->segment(2) == 'devhome') { ?>
                            <?php if ($this->session->user_role != 4) { ?>
                                <div class="btn-group" style="margin: 0px 0px 0px 0px;">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                        OVERALL SUMMARY <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <?php if (ismodule_active('IP') === true && ismodule_active('IP') === true) { ?><a href="<?php echo base_url('ipd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">IP DISCHARGE FEEDBACKS</button></a><?php } ?>
                                        <?php if (ismodule_active('OP') === true && ismodule_active('OP') === true) { ?><a href="<?php echo base_url('opf/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OUTPATIENT FEEDBACKS</button></a><?php } ?>
                                        <?php if (ismodule_active('PCF') === true && $this->session->userdata['access3'] == 'int') { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">PATIENT COMPLAINTS</button></a><?php } ?>
                                        <?php if (ismodule_active('ISR') === true &&  ismodule_active('ISR') === true) { ?><a href="<?php echo base_url('esr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">EMPLOYEE SERVICE REQUESTS</button></a><?php } ?>

                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="btn-group" style="margin: 0px 0px 0px 0px;">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                        OVERALL SUMMARY <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <?php if (ismodule_active('IP') === true &&  ismodule_active('IP') === true) { ?><a href="<?php echo base_url('ipd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">IP TICKETS</button></a><?php } ?>
                                        <?php if (ismodule_active('OP') === true && ismodule_active('OP') === true) { ?><a href="<?php echo base_url('opf/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OP TICKETS</button></a><?php } ?>
                                        <?php if (ismodule_active('PCF') === true &&  $this->session->userdata['access3'] == 'int') { ?><a href="<?php echo base_url('pc/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">PATIENT COMPLAINTS</button></a><?php } ?>
                                        <?php if (ismodule_active('ISR') === true &&  ismodule_active('ISR') === true) { ?><a href="<?php echo base_url('esr/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">EMPLOYEE SERVICE REQUESTS</button></a><?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php  } ?>

                        <?php if (ismodule_active('OP') === true &&  $this->uri->segment(1) == 'opf') {  ?>
                            <?php if ($this->session->user_role != 4) { ?>
                                <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                        OUTPATIENT FEEDBACKS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OVERALL SUMMARY</button></a>
                                        <?php if (ismodule_active('IP') === true && ismodule_active('IP') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">IP DISCHARGE FEEDBACKS</button></a><?php } ?>
                                        <?php if (ismodule_active('PCF') === true && $this->session->userdata['access3'] == 'int') { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">PATIENT COMPLAINTS</button></a><?php } ?>
                                        <?php if (ismodule_active('ISR') === true &&  ismodule_active('ISR') === true) { ?><a href="<?php echo base_url('esr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">EMPLOYEE SERVICE REQUESTS</button></a><?php } ?>

                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                        OP TICKETS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OVERALL SUMMARY </button></a>
                                        <?php if (ismodule_active('IP') === true &&  ismodule_active('IP') === true) { ?><a href="<?php echo base_url('ipd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">IP TICKETS</button></a><?php } ?>
                                        <?php if (ismodule_active('PCF') === true &&  $this->session->userdata['access3'] == 'int') { ?><a href="<?php echo base_url('pc/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">PATIENT COMPLAINTS</button></a><?php } ?>
                                        <?php if (ismodule_active('ISR') === true &&  ismodule_active('ISR') === true) { ?><a href="<?php echo base_url('esr/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">EMPLOYEE SERVICE REQUESTS</button></a><?php } ?>

                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>

                        <?php if (ismodule_active('IP') === true &&  $this->uri->segment(1) == 'ipd') {  ?>

                            <?php if ($this->session->user_role != 4) { ?>
                                <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                        IP DISCHARGE FEEDBACKS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OVERALL SUMMARY</button></a>
                                        <?php if (ismodule_active('OP') === true && ismodule_active('OP') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OUTPATIENT FEEDBACKS</button></a><?php } ?>
                                        <?php if (ismodule_active('PCF') === true && $this->session->userdata['access3'] == 'int') { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">PATIENT COMPLAINTS</button></a><?php } ?>
                                        <?php if (ismodule_active('ISR') === true &&  ismodule_active('ISR') === true) { ?><a href="<?php echo base_url('esr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">EMPLOYEE SERVICE REQUESTS</button></a><?php } ?>

                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                        IP TICKETS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OVERALL SUMMARY </button></a>
                                        <?php if (ismodule_active('OP') === true &&  ismodule_active('OP') === true) { ?><a href="<?php echo base_url('opf/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OP TICKETS</button></a><?php } ?>
                                        <?php if (ismodule_active('PCF') === true &&  $this->session->userdata['access3'] == 'int') { ?><a href="<?php echo base_url('pc/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">PATIENT COMPLAINTS</button></a><?php } ?>
                                        <?php if (ismodule_active('ISR') === true &&  ismodule_active('ISR') === true) { ?><a href="<?php echo base_url('esr/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">EMPLOYEE SERVICE REQUESTS</button></a><?php } ?>

                                    </div>
                                </div>
                            <?php } ?>



                        <?php } ?>


                        <?php if (ismodule_active('PCF') === true &&  ($this->uri->segment(1) ==  'pc')) {  ?>

                            <?php if ($this->session->user_role != 4) { ?>
                                <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                        PATIENT COMPLAINTS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OVERALL SUMMARY</button></a>
                                        <?php if (ismodule_active('IP') === true &&  ismodule_active('IP') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">IP DISCHARGE FEEDBACKS</button></a><?php } ?>
                                        <?php if (ismodule_active('OP') === true && ismodule_active('OP') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OUTPATIENT FEEDBACKS</button></a><?php } ?>
                                        <?php if (ismodule_active('ISR') === true &&  ismodule_active('ISR') === true) { ?><a href="<?php echo base_url('esr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">EMPLOYEE SERVICE REQUESTS</button></a><?php } ?>

                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                        PATIENT COMPLAINTS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OVERALL SUMMARY</button></a>
                                        <?php if (ismodule_active('IP') === true &&  ismodule_active('IP') === true) { ?><a href="<?php echo base_url('ipd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">IP TICKETS</button></a><?php } ?>
                                        <?php if (ismodule_active('OP') === true &&  ismodule_active('OP') === true) { ?><a href="<?php echo base_url('opf/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OP TICKETS</button></a><?php } ?>
                                        <?php if (ismodule_active('ISR') === true &&  ismodule_active('ISR') === true) { ?><a href="<?php echo base_url('esr/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">EMPLOYEE SERVICE REQUESTS</button></a><?php } ?>

                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>



                        <?php if (ismodule_active('ISR') === true &&  ($this->uri->segment(1) ==  'esr')) {  ?>

                            <?php if ($this->session->user_role != 4) { ?>
                                <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                        EMPLOYEE SERVICE REQUESTS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OVERALL SUMMARY</button></a>
                                        <?php if (ismodule_active('IP') === true &&  ismodule_active('IP') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">IP DISCHARGE FEEDBACKS</button></a><?php } ?>
                                        <?php if (ismodule_active('OP') === true && ismodule_active('OP') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OUTPATIENT FEEDBACKS</button></a><?php } ?>
                                        <?php if (ismodule_active('PCF') === true && $this->session->userdata['access3'] == 'int') { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">PATIENT COMPLAINTS</button></a><?php } ?>

                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                        EMPLOYEE SERVICE REQUESTS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OVERALL SUMMARY</button></a>
                                        <?php if (ismodule_active('IP') === true &&  ismodule_active('IP') === true) { ?><a href="<?php echo base_url('ipd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">IP TICKETS</button></a><?php } ?>
                                        <?php if (ismodule_active('OP') === true &&  ismodule_active('OP') === true) { ?><a href="<?php echo base_url('opf/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OP TICKETS</button></a><?php } ?>
                                        <?php if (ismodule_active('PCF') === true &&  $this->session->userdata['access3'] == 'int') { ?><a href="<?php echo base_url('pc/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">PATIENT COMPLAINTS</button></a><?php } ?>

                                    </div>
                                </div>
                            <?php } ?>


                    </td>
                <?php   }  ?>

                <td style="white-space: nowrap;">
                    <span style="margin: 0px 0px 0px 0px; font-size: 17px; ">
                        <strong>Period:</strong>
                    </span>
                </td>
                <td>
                    <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                        <button type="button" style="background: #62c52d;border: none; width: 150px;" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-timer" aria-hidden="true"></i> <?php echo $pagetitle; ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu" style="width: 100%;">
                            <a href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>?today=1&tdate=<?php echo date('d-m-Y'); ?>&fdate=<?php echo date('d-m-Y'); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;">Last 24 Hours</button></a>
                            <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>?weekly=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc; ">Last 7 Days</button></a>
                            <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>?yearm=<?php echo $y; ?>&mon=<?php echo date("n", time()); ?>" style="width:100%; border:0px; border-bottom:1px solid #ccc;"><button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;">Last 30 Days</button></a>
                            <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>?quaterly=1" style="width:100%"><button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc; ">Last 90 Days</button></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>?year=<?php echo $y; ?>" style="width:100%"><button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc; ">Last 365 Days</button></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"><a data-toggle="modal" data-target="#exampleModal" style="width:100%"><button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;">Custom</button></a>
                        </div>
                </td>


                <!--FOR INPATIENT WARDS -->
                <?php if ((ismodule_active('IP') === true && $this->uri->segment(1) == 'ipd') || ($this->uri->segment(1) == 'patient')) {  ?>
                    <script>
                        function changefloore(cward) {
                            window.location = '<?php echo base_url(uri_string()); ?>?cward=' + cward;
                        }
                    </script>
                    <td style="white-space: nowrap;">
                        <span style="margin: 0px 0px 0px 0px; font-size: 17px; ">
                            <strong>Floor/ Ward:</strong>
                        </span>
                    </td>
                    <td>
                        <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                            <button type="button" style="background: #62c52d;border: none; width:200px" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION['ward']; ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
                            </button>
                            <ul class="dropdown-menu" style="text-align: left; width:100%;">
                                <?php
                                $this->db->order_by('title');
                                $query = $this->db->get('bf_ward');
                                $ward = $query->result();
                                foreach ($ward as $rw) {
                                    if ($_SESSION['ward'] == $rw->title) {
                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                                ?><div class="dropdown-divider"></div>
                                <?php
                                    } else {
                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </td>

                    <style>
                        .dropdown-menu>li>a {
                            overflow: auto;

                        }

                        .dropdown-menu>.li {
                            width: 100%;
                            border: 0px;
                            border-bottom: 1px solid #ccc;
                            text-align: left;
                        }
                    </style>
                <?php }
                ?>
                <!--FOR INPATIENT WARDS END -->

                <!--FOR INTERIM WARDS -->
                <?php if ((ismodule_active('PCF') === true && $this->uri->segment(1) == 'pc')) {  ?>
                    <script>
                        function changefloore(cward) {
                            window.location = '<?php echo base_url(uri_string()); ?>?cward=' + cward;
                        }
                    </script>
                    <td style="white-space: nowrap;">
                        <span style="margin: 0px 0px 0px 0px; font-size: 17px; ">
                            <strong>Floor/ Ward:</strong>
                        </span>
                    </td>
                    <td>
                        <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                            <button type="button" style="background: #62c52d;border: none; width:200px" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION['ward']; ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
                            </button>
                            <ul class="dropdown-menu" style="text-align: left; width:100%;">
                                <?php
                                $this->db->order_by('title');
                                $query = $this->db->get('bf_ward');
                                $ward = $query->result();
                                foreach ($ward as $rw) {
                                    if ($_SESSION['ward'] == $rw->title) {
                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                                ?><div class="dropdown-divider"></div>
                                <?php
                                    } else {
                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </td>

                    <style>
                        .dropdown-menu>li>a {
                            overflow: auto;

                        }

                        .dropdown-menu>.li {
                            width: 100%;
                            border: 0px;
                            border-bottom: 1px solid #ccc;
                            text-align: left;
                        }
                    </style>
                <?php } ?>
                <!--FOR INTERIM WARDS END -->




                <!--FOR ESR WARDS -->
                <?php if ((ismodule_active('ISR') === true && $this->uri->segment(1) == 'esr')) {  ?>
                    <script>
                        function changefloore(cward) {
                            window.location = '<?php echo base_url(uri_string()); ?>?cward=' + cward;
                        }
                    </script>
                    <td style="white-space: nowrap;">
                        <span style="margin: 0px 0px 0px 0px; font-size: 17px; ">
                            <strong>Floor/ Ward:</strong>
                        </span>
                    </td>
                    <td>
                        <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                            <button type="button" style="background: #62c52d;border: none; width:200px" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION['ward']; ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
                            </button>
                            <ul class="dropdown-menu" style="text-align: left; width:100%;">
                                <?php
                                $this->db->order_by('title');
                                $query = $this->db->get('bf_ward_esr');
                                $ward = $query->result();
                                foreach ($ward as $rw) {
                                    if ($_SESSION['ward'] == $rw->title) {
                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                                ?><div class="dropdown-divider"></div>
                                <?php
                                    } else {
                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </td>

                    <style>
                        .dropdown-menu>li>a {
                            overflow: auto;

                        }

                        .dropdown-menu>.li {
                            width: 100%;
                            border: 0px;
                            border-bottom: 1px solid #ccc;
                            text-align: left;
                        }
                    </style>
                <?php } ?>
                <!--FOR ESR WARDS END -->










                <!-- FOR OUTPATIENT SPEACIALITY -->
                <?php if (ismodule_active('OP') === true && $this->uri->segment(1) == 'opf') {  ?>
                    <script>
                        function changefloore(cward) {
                            window.location = '<?php echo base_url(uri_string()); ?>?cward=' + cward;
                        }
                    </script>
                    <td style="white-space: nowrap;">
                        <span style="margin: 0px 0px 0px 0px; font-size: 17px; ">
                            <strong>Speciality:</strong>
                        </span>
                    </td>
                    <td>
                        <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                            <button type="button" style="background: #62c52d;border: none; width:200px" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION['ward']; ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
                            </button>
                            <ul class="dropdown-menu" style="text-align: left; width:100%;">
                                <?php
                                $this->db->order_by('title');
                                $query = $this->db->get('bf_departmentop');
                                $ward = $query->result();
                                foreach ($ward as $rw) {
                                    if ($_SESSION['ward'] == $rw->title) {
                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                                ?><div class="dropdown-divider"></div>
                                <?php
                                    } else {
                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </td>
                    <style>
                        .dropdown-menu>li>a {
                            overflow: auto;

                        }

                        .dropdown-menu>.li {
                            width: 100%;
                            border: 0px;
                            border-bottom: 1px solid #ccc;
                            text-align: left;
                        }
                    </style>
                <?php } ?>
                <td style="white-space: nowrap;">
                    <span style="margin: 0px 10px 0px 10px;">
                        <div class="btn-group" style="margin: 0px 0px 0px 0px;">
                            <a href="<?php echo base_url(uri_string(1)); ?>?reset=1" class="btn btn-primary" style="background: #8791a4; border: none;">
                                Reset
                                <i class="fa fa-repeat" aria-hidden="true" style="margin-right:0px;"></i>
                            </a>
                        </div>
                    </span>
                </td>
                </tr>
            </table>
        </div>

        <style>
            .filterbor {
                width: 100%;
                border: none;

                font-size: 20px;
                display: flex;
                background-color: #FFF;
                margin-top: 0px;
                margin-bottom: 5px;
                padding: 1px;
            }

            @media (max-width: 1000px) {
                .filterbor {
                    display: none;
                }
            }
        </style>
    </div>
<?php } ?>
<!-- </div> -->