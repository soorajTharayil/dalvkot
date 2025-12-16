 <?php

    // if ($this->session->userdata['user_access'] == 1 || $this->session->user_id == 1) {
    if ($this->session->userdata) {
        $dates = get_from_to_date();
        $pagetitle = $dates['pagetitle'];
        $y = date('Y');

    ?>
     <div class="filterbor">
         <!-- style="background:#e0f3cf" -->
         <div class="p-l-30 p-r-30" style="padding: 0px; margin-bottom:-11px;">

             <table class="table table-filter" style="width: 100%; margin-left: 53px;margin-right: -53px; padding:10px; vertical-align:middle; ">
                 <tr>
                     <?php if ($this->session->userdata['user_role'] >= 0) { ?>

                         <?php if (hidecalender($this->uri->segment(1)) !== true) { ?>
                             <td style="white-space: nowrap;">
                                 <span style="margin: 0px -2px 0px -17px; font-size: 17px;">
                                     <strong><?php echo lang_loader('global', 'global_showing'); ?>:</strong>
                                 </span>
                             </td>
                             <td>
                                 <?php if ($this->session->userdata['active_menu'] ==  null ||  $this->uri->segment(2) == 'welcome') { ?>
                                     <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                         <div class="btn-group" style="margin: 0px 0px 0px 0px;">

                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 <?php echo lang_loader('global', 'global_overall_summary'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>

                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_feedbacks'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ipd_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true && isfeature_active('PDF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OT DOCTOR FEEDBACKS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OPD DOCTOR FEEDBACKS</button></a><?php } ?>
                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } else { ?>
                                         <div class="btn-group" style="margin: 0px 0px 0px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 <?php echo lang_loader('global', 'global_overall_summary'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>

                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OT DOCTOR FEEDBACKS TICKETS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OPD DOCTOR FEEDBACKS TICKETS</button></a><?php } ?>

                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } ?>
                                 <?php  } ?>

                                 <?php if ($this->session->userdata['active_menu'] ==  null ||  $this->uri->segment(1) == 'downloads') { ?>

                                     <div class="btn-group" style="margin: 0px 0px 0px 0px;">

                                         <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                             <?php echo lang_loader('global', 'global_overall_summary'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                         </button>

                                         <div class="dropdown-menu">
                                             <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_feedbacks'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('IP') === true && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ipd_feedback'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('PDF') === true && isfeature_active('PDF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_complaints'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OT DOCTOR FEEDBACKS</button></a><?php } ?>
                                             <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OPD DOCTOR FEEDBACKS</button></a><?php } ?>

                                             <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_feedback'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                         </div>
                                     </div>



                                 <?php  } ?>

                                 <?php if (ismodule_active('OP') === true &&  $this->uri->segment(1) == 'opf') {  ?>
                                     <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>

                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 <?php echo lang_loader('global', 'global_op_feedback'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true &&  ismodule_active('ADF') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_feedbacks'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true && ismodule_active('IP') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ipd_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && ismodule_active('PCF') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true && isfeature_active('PDF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OT DOCTOR FEEDBACKS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OPD DOCTOR FEEDBACKS</button></a><?php } ?>

                                                 <?php if (ismodule_active('ISR') === true &&  ismodule_active('ISR') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  ismodule_active('INCIDENT') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  ismodule_active('GRIEVANCE') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } else { ?>
                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 <?php echo lang_loader('global', 'global_op_tickets'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?> </button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true && isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OT DOCTOR FEEDBACKS TICKETS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OPD DOCTOR FEEDBACKS TICKETS</button></a><?php } ?>

                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } ?>
                                 <?php } ?>

                                 <?php if (ismodule_active('DOCTOR') === true &&  $this->uri->segment(1) == 'doctor') {  ?>
                                     <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>

                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 OT DOCTOR FEEDBACKS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true &&  ismodule_active('ADF') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_feedbacks'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true && ismodule_active('IP') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ipd_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && ismodule_active('PCF') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true && isfeature_active('PDF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OPD DOCTOR FEEDBACKS</button></a><?php } ?>

                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('ISR') === true &&  ismodule_active('ISR') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  ismodule_active('INCIDENT') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  ismodule_active('GRIEVANCE') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } else { ?>
                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 DOCTOR FEEDBACKS TICKETS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?> </button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true && isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS OPD</button></a><?php } ?>

                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } ?>
                                 <?php } ?>
                                 <?php if (ismodule_active('DOCTOR-OPD') === true &&  $this->uri->segment(1) == 'doctoropd') {  ?>
                                     <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>

                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 OPD DOCTOR FEEDBACKS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true &&  ismodule_active('ADF') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_feedbacks'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true && ismodule_active('IP') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ipd_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && ismodule_active('PCF') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true && isfeature_active('PDF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OT DOCTOR FEEDBACKS</button></a><?php } ?>

                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('ISR') === true &&  ismodule_active('ISR') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  ismodule_active('INCIDENT') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  ismodule_active('GRIEVANCE') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } else { ?>
                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 OPD DOCTOR FEEDBACKS TICKETS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?> </button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true && isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS OPD</button></a><?php } ?>

                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } ?>
                                 <?php } ?>

                                 <?php if (ismodule_active('IP') === true &&  $this->uri->segment(1) == 'ipd') {  ?>

                                     <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>

                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 INPATIENT DISCHARGE FEEDBACKS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_feedbacks'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true && isfeature_active('PDF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OT DOCTOR FEEDBACKS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OPD DOCTOR FEEDBACKS</button></a><?php } ?>

                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } else { ?>
                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 <?php echo lang_loader('global', 'global_ip_tickets'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?> </button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS TICKETS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS OPD</button></a><?php } ?>

                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } ?>



                                 <?php } ?>

                                 <?php if (ismodule_active('PDF') === true &&  $this->uri->segment(1) == 'post') {  ?>

                                     <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>

                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 POST DISCHARGE FEEDBACKS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_feedbacks'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OT DOCTOR FEEDBACKS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OPD DOCTOR FEEDBACKS</button></a><?php } ?>

                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } else { ?>
                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 POST DISCHARGE TICKETS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?> </button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS TICKETS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS OPD</button></a><?php } ?>

                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } ?>



                                 <?php } ?>
                                 <?php if (ismodule_active('PCF') === true &&  ($this->uri->segment(1) ==  'pc')) {  ?>

                                     <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>

                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 <?php echo lang_loader('global', 'global_ip_complaints'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true && isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_feedbacks'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ipd_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true && isfeature_active('PDF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OT DOCTOR FEEDBACKS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OPD DOCTOR FEEDBACKS</button></a><?php } ?>

                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>
                                             </div>
                                         </div>
                                     <?php } else { ?>
                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 <?php echo lang_loader('global', 'global_ip_complaints'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS TICKETS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS OPD</button></a><?php } ?>

                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>
                                             </div>
                                         </div>
                                     <?php } ?>
                                 <?php } ?>



                                 <?php if (ismodule_active('ISR') === true &&  ($this->uri->segment(1) ==  'isr')) {  ?>

                                     <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>

                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 <?php echo lang_loader('global', 'global_isr'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_feedbacks'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ipd_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OT DOCTOR FEEDBACKS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OPD DOCTOR FEEDBACKS</button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } else { ?>
                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 <?php echo lang_loader('global', 'global_isr'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS TICKETS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS OPD</button></a><?php } ?>

                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } ?>
                                 <?php } ?>



                                 <?php if (ismodule_active('INCIDENT') === true &&  ($this->uri->segment(1) ==  'incident')) {  ?>

                                     <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>

                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 <?php echo lang_loader('global', 'global_inc_reoprt'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_feedbacks'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ipd_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true && isfeature_active('PDF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OT DOCTOR FEEDBACKS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OPD DOCTOR FEEDBACKS</button></a><?php } ?>

                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } else { ?>
                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 <?php echo lang_loader('global', 'global_inc_report'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('ADF') === true && isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS TICKETS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS OPD</button></a><?php } ?>

                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } ?>
                                 <?php } ?>

                                 <?php if (ismodule_active('ADF') === true &&  ($this->uri->segment(1) ==  'admissionfeedback')) {  ?>

                                     <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>

                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 <?php echo lang_loader('global', 'global_adf_feedbacks'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ipd_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true && isfeature_active('PDF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OT DOCTOR FEEDBACKS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OPD DOCTOR FEEDBACKS</button></a><?php } ?>

                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_feedback'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } else { ?>
                                         <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                                 <?php echo lang_loader('global', 'global_adf_tickets'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                             </button>
                                             <div class="dropdown-menu">
                                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                     <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                                 <?php } ?>
                                                 <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PCF') === true && isfeature_active('COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS TICKETS</button></a><?php } ?>
                                                 <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS OPD</button></a><?php } ?>

                                                 <?php if (ismodule_active('OP') === true && isfeature_active('OP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_tickets'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('ISR') === true &&  isfeature_active('REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                                 <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_sgc_report'); ?></button></a><?php } ?>

                                             </div>
                                         </div>
                                     <?php } ?>
                                 <?php } ?>
                             <?php }  ?>

                             <?php if (ismodule_active('GRIEVANCE') === true &&  ($this->uri->segment(1) ==  'grievance')) {  ?>

                                 <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>

                                     <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                         <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                             <?php echo lang_loader('global', 'global_sgc_report'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                         </button>
                                         <div class="dropdown-menu">
                                             <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                 <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                             <?php } ?>
                                             <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_feedbacks'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ipd_feedback'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_feedback'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('PDF') === true && isfeature_active('PDF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_complaints'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OT DOCTOR FEEDBACKS</button></a><?php } ?>
                                             <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">OPD DOCTOR FEEDBACKS</button></a><?php } ?>

                                             <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>

                                         </div>
                                     </div>
                                 <?php } else { ?>
                                     <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                         <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                                             STAFF GRIEVANCES TICKETS <i class="fa fa-angle-down" aria-hidden="true"></i>
                                         </button>
                                         <div class="dropdown-menu">
                                             <?php if (ismodule_active('GLOBAL') === true && isfeature_active('ADMINS-OVERALL-PAGE') === true) { ?>
                                                 <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_overall_summary'); ?></button></a>
                                             <?php } ?>
                                             <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_adf_tickets'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('IP') === true  && isfeature_active('IP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_tickets'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('PCF') === true && isfeature_active('COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_ip_complaints'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('PDF') === true  && isfeature_active('PDF-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('post/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_pdf_tickets'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('DOCTOR') === true && isfeature_active('DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctor/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS TICKETS</button></a><?php } ?>
                                             <?php if (ismodule_active('DOCTOR-OPD') === true && isfeature_active('OPD-DOCTOR-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('doctoropd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;">DOCTOR FEEDBACKS OPD</button></a><?php } ?>

                                             <?php if (ismodule_active('OP') === true && isfeature_active('OP-TICKETS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_op_tickets'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('ISR') === true &&  isfeature_active('REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_isr'); ?></button></a><?php } ?>
                                             <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global', 'global_inc_reoprt'); ?></button></a><?php } ?>

                                         </div>
                                     </div>
                                 <?php } ?>
                             <?php } ?>




                             </td>
                         <?php   }  ?>
                         <?php if ($this->uri->segment(1) != 'patient' && !($this->uri->segment(1) == 'asset' && $this->uri->segment(2) == 'ticket_dashboard')) { ?>
                             <td style="white-space: nowrap;">
                                 <span style="margin: 0px 0px 0px 0px; font-size: 17px; ">
                                     <strong>
                                         <?php echo ($this->uri->segment(1) == 'asset') ? "Asset Added Period" : lang_loader('global', 'global_period'); ?>:
                                     </strong>
                                 </span>
                             </td>

                             <td>
                                 <div class="btn-group" style="margin: 0px 20px 5px 0px;">
                                     <button type="button" style="background: #62c52d;border: none; width: 150px;" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                         <i class="fa fa-timer" aria-hidden="true"></i> <?php echo $pagetitle; ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                                     </button>
                                     <div class="dropdown-menu" style="width: 100%;">
                                         <a href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3); ?>?today_only=1" style="width:100%">
                                             <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;">
                                                 Today
                                             </button>
                                         </a>
                                         <a href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3); ?>?previous_day=1" style="width:100%">
                                             <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;">
                                                 Previous Day
                                             </button>
                                         </a>
                                         <a href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3); ?>?today=1&tdate=<?php echo date('d-m-Y'); ?>&fdate=<?php echo date('d-m-Y'); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;"><?php echo lang_loader('global', 'global_last_24_hours'); ?></button></a>
                                         <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3); ?>?weekly=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc; "><?php echo lang_loader('global', 'global_last_7_days'); ?></button></a>
                                         <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3); ?>?yearm=<?php echo $y; ?>&mon=<?php echo date("n", time()); ?>" style="width:100%; border:0px; border-bottom:1px solid #ccc;"><button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;"><?php echo lang_loader('global', 'global_last_30_days'); ?></button></a>
                                         <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3); ?>?quaterly=1" style="width:100%"><button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc; "><?php echo lang_loader('global', 'global_last_90_days'); ?></button></a>
                                         <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3); ?>?this_month=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc; ">Current Month</button></a>
                                         <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3); ?>?last_month=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc; ">Previous Month</button></a>

                                         <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3); ?>?year=<?php echo $y; ?>" style="width:100%"><button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc; "><?php echo lang_loader('global', 'global_last_365_days'); ?></button></a>
                                         <div class="dropdown-divider"></div>
                                         <a class="dropdown-item"><a data-toggle="modal" data-target="#exampleModal" style="width:100%"><button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;"><?php echo lang_loader('global', 'global_custom'); ?></button></a>
                                     </div>
                             </td>
                         <?php   }  ?>


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
                                                if ($rw->title == 'ALL' || count($this->session->userdata['floor_ward']) == 0 || (count($this->session->userdata['floor_ward']) > 0 && in_array($rw->title, $this->session->userdata['floor_ward']))) {
                                                    if ($_SESSION['ward'] == $rw->title) {

                                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';

                                            ?><div class="dropdown-divider"></div>

                                             <?php
                                                    } else {
                                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                    }
                                                }
                                                ?>
                                         <?php } ?>
                                     </ul>
                                 </div>
                             </td>

                             <style>
                                 .dropdown-menu>li>a {
                                     overflow: auto;

                                 }

                                 .dropdown-menu>li>a {
                                     overflow: hidden;
                                     text-overflow: ellipsis;
                                     white-space: nowrap;
                                     width: 100%;
                                     display: block;
                                     /* Ensure the anchor element takes up full width */
                                 }
                             </style>
                         <?php } ?>
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
                                                if ($rw->title == 'ALL' || count($this->session->userdata['floor_ward']) == 0 || (count($this->session->userdata['floor_ward']) > 0 && in_array($rw->title, $this->session->userdata['floor_ward']))) {
                                                    if ($_SESSION['ward'] == $rw->title) {

                                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';

                                            ?><div class="dropdown-divider"></div>

                                             <?php
                                                    } else {
                                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                    }
                                                }
                                                ?>
                                         <?php } ?>
                                     </ul>
                                 </div>
                             </td>

                             <style>
                                 .dropdown-menu>li>a {
                                     overflow: auto;

                                 }

                                 .dropdown-menu>li>a {
                                     overflow: hidden;
                                     text-overflow: ellipsis;
                                     white-space: nowrap;
                                     width: 100%;
                                     display: block;
                                     /* Ensure the anchor element takes up full width */
                                 }
                             </style>
                         <?php } ?>
                         <!--FOR INTERIM WARDS END -->



                         <!--FOR INTERIM WARDS -->
                         <?php if ((ismodule_active('ADF') === true && $this->uri->segment(1) == 'admissionfeedback')) {  ?>
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

                                 .dropdown-menu>li>a {
                                     overflow: hidden;
                                     text-overflow: ellipsis;
                                     white-space: nowrap;
                                     width: 100%;
                                     display: block;
                                     /* Ensure the anchor element takes up full width */
                                 }
                             </style>
                         <?php } ?>
                         <!--FOR INTERIM WARDS END -->


                         <!--FOR ESR WARDS -->
                         <?php if ((ismodule_active('ISR') === true && $this->uri->segment(1) == 'isr')) {  ?>
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
                                                if ($rw->title == 'ALL' || count($this->session->userdata['floor_ward_esr']) == 0 || (count($this->session->userdata['floor_ward_esr']) > 0 && in_array($rw->title, $this->session->userdata['floor_ward_esr']))) {

                                                    if ($_SESSION['ward'] == $rw->title) {

                                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                                            ?><div class="dropdown-divider"></div>
                                         <?php
                                                    } else {
                                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                    }
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

                                 .dropdown-menu>li>a {
                                     overflow: hidden;
                                     text-overflow: ellipsis;
                                     white-space: nowrap;
                                     width: 100%;
                                     display: block;
                                     /* Ensure the anchor element takes up full width */
                                 }
                             </style>
                         <?php } ?>
                         <!--FOR ESR WARDS END -->


                         <!--FOR ESR WARDS -->
                         <?php if ((ismodule_active('INCIDENT') === true && $this->uri->segment(1) == 'incident')) {  ?>
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
                                                if ($rw->title == 'ALL' || count($this->session->userdata['floor_ward_esr']) == 0 || (count($this->session->userdata['floor_ward_esr']) > 0 && in_array($rw->title, $this->session->userdata['floor_ward_esr']))) {

                                                    if ($_SESSION['ward'] == $rw->title) {
                                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                                            ?><div class="dropdown-divider"></div>
                                         <?php
                                                    } else {
                                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                    }
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

                                 .dropdown-menu>li>a {
                                     overflow: hidden;
                                     text-overflow: ellipsis;
                                     white-space: nowrap;
                                     width: 100%;
                                     display: block;
                                     /* Ensure the anchor element takes up full width */
                                 }
                             </style>
                         <?php } ?>
                         <!--FOR ESR WARDS END -->

                         <!--FOR ESR WARDS -->
                         <?php if ((ismodule_active('GRIEVANCE') === true && $this->uri->segment(1) == 'grievance')) {  ?>
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
                                                if ($rw->title == 'ALL' || count($this->session->userdata['floor_ward_esr']) == 0 || (count($this->session->userdata['floor_ward_esr']) > 0 && in_array($rw->title, $this->session->userdata['floor_ward_esr']))) {

                                                    if ($_SESSION['ward'] == $rw->title) {
                                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                                            ?><div class="dropdown-divider"></div>
                                         <?php
                                                    } else {
                                                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                    }
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

                                 .dropdown-menu>li>a {
                                     overflow: hidden;
                                     text-overflow: ellipsis;
                                     white-space: nowrap;
                                     width: 100%;
                                     display: block;
                                     /* Ensure the anchor element takes up full width */
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
                                     <strong><?php echo lang_loader('global', 'global_speciality'); ?>:</strong>
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

                                 .dropdown-menu>li>a {
                                     overflow: hidden;
                                     text-overflow: ellipsis;
                                     white-space: nowrap;
                                     width: 100%;
                                     display: block;
                                     /* Ensure the anchor element takes up full width */
                                 }
                             </style>
                         <?php } ?>




                         <?php if ((ismodule_active('ASSET') === true && $this->uri->segment(1) == 'asset')) {  ?>
                             <script>
                                 function changefloore(cward) {
                                     window.location = '<?php echo base_url(uri_string()); ?>?cward=' + cward;
                                 }
                             </script>
                             <td style="white-space: nowrap;">
                                 <span style="margin: 0px 0px 0px 0px; font-size: 17px; ">
                                     <strong>Floor:</strong>
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

                                 .dropdown-menu>li>a {
                                     overflow: hidden;
                                     text-overflow: ellipsis;
                                     white-space: nowrap;
                                     width: 100%;
                                     display: block;
                                     /* Ensure the anchor element takes up full width */
                                 }
                             </style>
                         <?php } ?>

                         <!-- <td style="white-space: nowrap;">
                             <span style="margin: 0px 10px 0px 10px;">
                                 <div class="btn-group" style="margin: 0px 0px 0px 0px;">
                                     <a href="<?php echo base_url(uri_string(1)); ?>?reset=1" class="btn btn-primary" style="background: #8791a4; border: none;">
                                         Reset
                                         <i class="fa fa-repeat" aria-hidden="true" style="margin-right:0px;"></i>
                                     </a>
                                 </div>
                             </span>
                         </td> -->
                         <?php if ((ismodule_active('INCIDENT') === true && $this->uri->segment(1) == 'incident')) {  ?>
                             <td>
                                 <button type="button" class="btn btn-primary dropdown-toggle" style="background: #62c52d;    border: none;" data-toggle="modal" data-target="#myModal">More filters <i class="fa fa-filter"></i></button>

                             </td>
                         <?php } ?>
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



 <div id="myModal" tabindex="-1" role="dialog" class="modal fade" role="dialog">
     <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title"><?php echo lang_loader('global', 'global_apply_filters'); ?></h4>
             </div>
             <!-- <div class=""> -->
             <div class="modal-body">
                 <!-- style="background:#e0f3cf" -->
                 <table class="tab-nav" style="margin-left: -14px;margin-right: -16px;">




                     <?php if ((ismodule_active('INCIDENT') === true && $this->uri->segment(1) == 'incident')) {  ?>

                         <tr>
                             <script>
                                 function changeseverity(severity) {
                                     window.location = '<?php echo base_url(uri_string()); ?>?depsec_severity=' + severity;
                                 }
                             </script>
                             <td style="align-items:center;text-align:center;">
                                 <span style="margin: 9px -18px 10px 16px;font-size: 16px; white-space: nowrap;">
                                     <strong>Incident Severity :</strong>
                                 </span>
                             </td>
                             <td>
                                 <div class="btn-group" style="margin: 2px 6px 5px 19px;">
                                     <button type="button" style="background: #62c52d;border: none; width:200px" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                         <?php echo lang_loader('global', 'global_all'); ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
                                     </button>
                                     <ul class="dropdown-menu" style="text-align: left; width:100%;">
                                         <?php
                                            $this->db->order_by('title');
                                            $query = $this->db->get('incident_type');
                                            $ward = $query->result();
                                            foreach ($ward as $rw) {
                                                if ($_SESSION['severity'] == $rw->title) {
                                                    echo '<li><a class="dropdown-item" href="#" onclick="changeseverity(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                                            ?><div class="dropdown-divider"></div><?php
                                                                                } else {
                                                                                    echo '<li><a class="dropdown-item" href="#" onclick="changeseverity(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                                                }
                                                                            }
                                                                                    ?>
                                     </ul>
                                 </div>
                             </td>
                         </tr>


                         <tr style="margin-bottom: 20px;">

                             <script>
                                 function changepriority(priority) {
                                     window.location = '<?php echo base_url(uri_string()); ?>?depsec_severity=' + priority;
                                 }
                             </script>

                             <td style="align-items:center;text-align:center;">
                                 <span style="margin: 9px -18px 10px 16px;font-size: 16px; white-space: nowrap;">
                                     <strong>Incident Priority :</strong>
                                 </span>
                             </td>
                             <td>
                                 <div class="btn-group" style="margin: 2px 6px 5px 19px;">
                                     <button type="button" style="background: #62c52d;border: none; width:200px" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                         <?php echo lang_loader('global', 'global_all'); ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
                                     </button>
                                     <ul class="dropdown-menu" style="text-align: left; width:100%;">
                                         <?php
                                            $this->db->order_by('title');
                                            $query = $this->db->get('priority');
                                            $ward = $query->result();
                                            foreach ($ward as $rw) {
                                                if ($_SESSION['priority'] == $rw->title) {
                                                    echo '<li><a class="dropdown-item" href="#" onclick="changepriority(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                                            ?><div class="dropdown-divider"></div><?php
                                                                                } else {
                                                                                    echo '<li><a class="dropdown-item" href="#" onclick="changepriority(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                                                }
                                                                            }
                                                                                    ?>
                                     </ul>
                                 </div>
                             </td>
                         </tr>
                         <style>
                             .dropdown-menu>.li {
                                 width: 100%;
                                 border: 0px;
                                 border-bottom: 1px solid #ccc;
                                 text-align: left;
                             }

                             .dropdown-menu>li>a {
                                 overflow: hidden;
                             }
                         </style>
                         </tr>
                     <?php } ?>



                 </table>
             </div>
             <!-- </div> -->
             <div class="modal-footer">
                 <a href="<?php echo base_url(); ?>"> <button type="button" style=" background-color: #8791a4;
                        border-color: #8791a4;" class="btn btn-primary" style=" background-color: #8791a4; margin: 0px 40px 0px 0px;
                    "><i class="fa fa-repeat">&nbsp; <?php echo lang_loader('global', 'global_reset'); ?></i></button></a>
                 </span>
                 <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang_loader('global', 'global_close'); ?></button>
             </div>
         </div>
     </div>
 </div>