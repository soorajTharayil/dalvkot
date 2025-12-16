<?php
if ($this->session->userdata) {
  $dates = get_from_to_date();
  $pagetitle = $dates['pagetitle'];
  $y = date('Y');
?>
  <div style="
    margin-top: 22px;
    position: absolute;
    right: 3%;
">
    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"><?php echo lang_loader('global','global_filter'); ?> <i class="fa fa-filter"></i></button>
  </div>
  <div id="myModal" tabindex="-1" role="dialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo lang_loader('global','global_apply_filters'); ?></h4>
        </div>
        <!-- <div class=""> -->
        <div class="modal-body" style="padding-top: 4px;">
          <!-- style="background:#e0f3cf" -->
          <table class="tab-nav" style="margin-left: -14px;margin-right: -16px;margin-top: 19px;">
            <?php if ($this->session->userdata['user_role'] >= 0) { ?>
              <tr>
                <?php if (hidecalender($this->uri->segment(1)) !== true) { ?>


                  <td style="align-items:center;text-align:center;"> <span style="margin: 10px -20px 5px 20px;  font-size: 16px;"><strong><?php echo lang_loader('global','global_showing'); ?>: </strong></span></td>
                  
                  <!-- welcome filter -->
                  <?php if ($this->session->userdata['active_menu'] ==  null ||  $this->uri->segment(2) == 'welcome') { ?>
                    <?php if ($this->session->user_role != 4) { ?>

                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_overall_summary'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_feedbacks'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ipd_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . 'feedback_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>

                          </div>
                        </div>
                      </td>
                    <?php } else { ?>

                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_overall_summary'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'department_tickets'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>

                          </div>
                        </div>
                      </td>
                    <?php } ?>

                  <?php } ?>
                  <!-- ip filter -->



                  <!-- ip filter -->
                  <?php if (ismodule_active('IP') === true &&  $this->uri->segment(1) == 'ipd') {  ?>
                    <?php if ($this->session->user_role != 4) { ?>

                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_dsf_report'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?></button></a>
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_feedbacks'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>

                          </div>
                        </div>
                      </td>
                    <?php } else { ?>

                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_ip_tickets'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?> </button></a>
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>

                          </div>
                        </div>
                      </td>
                    <?php } ?>

                  <?php } ?>
                  <!-- ip filter -->

                  <!-- op filter -->
                  <?php if (ismodule_active('OP') === true &&  $this->uri->segment(1) == 'opf') {  ?>
                    <?php if ($this->session->user_role != 4) { ?>
                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_op_feedback'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?></button></a>
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_feedbacks'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ipd_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>
                          </div>
                        </div>
                      </td>
                    <?php } else { ?>
                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_op_tickets'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?> </button></a>
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>
                          </div>
                        </div>
                      </td>
                    <?php } ?>
                  <?php } ?>
                  <!-- op filter -->

                  <!-- pc filter -->
                  <?php if (ismodule_active('PCF') === true &&  $this->uri->segment(1) == 'pc') {  ?>
                    <?php if ($this->session->user_role != 4) { ?>
                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_ip_complaints'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?></button></a>
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_feedbacks'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ipd_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>

                          </div>
                        </div>
                      </td>
                    <?php } else { ?>
                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_ip_complaints'); ?><i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?></button></a>
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>
                          </div>
                        </div>
                      </td>
                    <?php } ?>
                  <?php } ?>
                  <!-- pc filter -->

                  <!-- adf filter -->
                  <?php if (ismodule_active('ADF') === true &&  $this->uri->segment(1) == 'admissionfeedback') {  ?>
                    <?php if ($this->session->user_role != 4) { ?>
                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_adf_feedbacks'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?></button></a>
                            <?php if (ismodule_active('IP') === true &&  isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ipd_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>
                          </div>
                        </div>
                      </td>
                    <?php } else { ?>
                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_adf_tickets'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?></button></a>
                            <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>
                          </div>
                        </div>
                      </td>
                    <?php } ?>
                  <?php } ?>
                  <!-- adf filter -->

                  <!-- esr filter -->
                  <?php if (ismodule_active('ISR') === true &&  $this->uri->segment(1) == 'isr') {  ?>
                    <?php if ($this->session->user_role != 4) { ?>
                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_isr'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?></button></a>
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_feedbacks'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ipd_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>

                          </div>
                        </div>
                      </td>
                    <?php } else { ?>
                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_isr'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?></button></a>
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('IP') === true && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>

                          </div>
                        </div>
                      </td>
                    <?php } ?>
                  <?php } ?>
                  <!-- esr filter -->

                  <!-- grievance filter -->
                  <?php if (ismodule_active('GRIEVANCE') === true &&  ($this->uri->segment(1) ==  'grievance')) {  ?>
                    <?php if ($this->session->user_role != 4) { ?>
                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_sg_report'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?></button></a>
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_feedbacks'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ipd_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>

                          </div>
                        </div>
                      </td>
                    <?php } else { ?>
                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_sg_report'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?></button></a>
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('INCIDENT') === true &&  isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('incident/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_inc_reoprt'); ?></button></a><?php } ?>

                          </div>
                        </div>
                      </td>
                    <?php } ?>
                  <?php } ?>
                  <!-- grievance filter -->


                  <!-- incident filter -->
                  <?php if (ismodule_active('INCIDENT') === true &&  ($this->uri->segment(1) ==  'incident')) {  ?>
                    <?php if ($this->session->user_role != 4) { ?>
                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_inc_reoprt'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?></button></a>
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_feedbacks'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ipd_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_feedback'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . 'ticket_dashboard'; ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>

                          </div>
                        </div>
                      </td>
                    <?php } else { ?>
                      <td style="align-items:center;text-align:center;">
                        <div class="btn-group" style=" margin: 0px 20px 5px 20px;">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #62c52d;    border: none;">
                            <?php echo lang_loader('global','global_inc_report'); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a href="<?php echo base_url(); ?>dashboard/swithc?type=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_overall_summary'); ?></button></a>
                            <?php if (ismodule_active('ADF') === true &&  isfeature_active('ADF-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('admissionfeedback/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_adf_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('IP') === true  && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('ipd/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('PCF') === true && isfeature_active('PC-COMPLAINTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('pc/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_ip_complaints'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?><a href="<?php echo base_url('opf/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_op_tickets'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('ISR') === true &&  isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?><a href="<?php echo base_url('isr/')  . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_isr'); ?></button></a><?php } ?>
                            <?php if (ismodule_active('GRIEVANCE') === true &&  isfeature_active('SG-STAFF-GRIEVANCES-DASHBOARD') === true) { ?><a href="<?php echo base_url('grievance/') . $this->uri->segment(2); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;  text-align:left;"><?php echo lang_loader('global','global_sg_report'); ?></button></a><?php } ?>

                          </div>
                        </div>
                      </td>
                    <?php } ?>
                  <?php } ?>
                  <!-- grievance filter -->

              </tr>
            <?php } ?>
          <?php } ?>

          <?php if ($this->uri->segment(1) != 'patient') {  ?>
            <tr>
              <td style="align-items:center;text-align:center;"><span style=" margin: 10px -5px 5px 20px;font-size: 16px;"><strong><?php echo lang_loader('global','global_period'); ?>:</strong></span></td>
              <td>
                <div class="btn-group" style="margin: 2px 2px 5px 20px;">
                  <button type="button" style="background: #62c52d;border: none; width: 150px;" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-timer" aria-hidden="true"></i> <?php echo $pagetitle; ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </button>
                  <div class="dropdown-menu" style="width: 100%;">
                    <a href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>?today=1&tdate=<?php echo date('d-m-Y'); ?>&fdate=<?php echo date('d-m-Y'); ?>" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;"><?php echo lang_loader('global','global_last_24_hours'); ?></button></a>
                    <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>?weekly=1" style="width:100%"> <button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc; "><?php echo lang_loader('global','global_last_7_days'); ?></button></a>
                    <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>?yearm=<?php echo $y; ?>&mon=<?php echo date("n", time()); ?>" style="width:100%; border:0px; border-bottom:1px solid #ccc;"><button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc;"><?php echo lang_loader('global','global_last_30_days'); ?></button></a>
                    <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>?quaterly=1" style="width:100%"><button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc; "><?php echo lang_loader('global','global_last_90_days'); ?></button></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo $this->uri->segment(1); ?>/<?php echo $this->uri->segment(2); ?>?year=<?php echo $y; ?>" style="width:100%"><button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc; "><?php echo lang_loader('global','global_last_365_days'); ?></button></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item"><a data-toggle="modal" data-target="#exampleModal" style="width:100%"><button class="btn btn-default" style="width:100%; border:0px; border-bottom:1px solid #ccc; "><?php echo lang_loader('global','global_custom'); ?></button></a></a>
                  </div>
                </div>
              </td>
            </tr>
          <?php } ?>


          <?php if ((ismodule_active('ADF') === true && $this->uri->segment(1) == 'admissionfeedback')) {  ?>

            <tr>
              <script>
                function changefloore(cward) {
                  window.location = '<?php echo base_url(uri_string()); ?>?cward=' + cward;
                }
              </script>
              <td style="align-items:center;text-align:center;"><span style="margin: 9px -18px 10px 16px;font-size: 16px;"><strong><?php echo lang_loader('global','global_speciality'); ?>:</strong></span></td>
              <td>
                <div class="btn-group" style="margin: 2px 6px 5px 19px;">
                  <button type="button" style="background: #62c52d;border: none; width:200px" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo lang_loader('global','global_all'); ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
                  </button>
                  <ul class="dropdown-menu" style="text-align: left; width:100%;">
                    <?php
                    $this->db->order_by('title');
                    $query = $this->db->get('bf_departmentop');
                    $ward = $query->result();
                    foreach ($ward as $rw) {
                      if ($_SESSION['ward'] == $rw->title) {
                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                    ?><div class="dropdown-divider"></div><?php
                                                        } else {
                                                          echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                        }
                                                      }
                                                          ?>
                  </ul>
                </div>
              </td>
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

          <?php if ((ismodule_active('IP') === true && $this->uri->segment(1) == 'ipd') || ($this->uri->segment(1) == 'patient')) {  ?>
            <tr>

              <script>
                function changefloore(cward) {
                  window.location = '<?php echo base_url(uri_string()); ?>?cward=' + cward;
                }
              </script>
              <td style="align-items:center;text-align:center;"><span style="margin: 9px -18px 10px 16px;font-size: 16px;"><strong><?php echo lang_loader('global','global_floor_ward'); ?>:</strong></span></td>
              <td>
                <div class="btn-group" style="margin: 2px 6px 5px 19px;">
                  <button type="button" style="background: #62c52d;border: none; width:200px" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo lang_loader('global','global_all'); ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
                  </button>
                  <ul class="dropdown-menu" style="text-align: left; width:100%;">
                    <?php
                    $this->db->order_by('title');
                    $query = $this->db->get('bf_ward');
                    $ward = $query->result();
                    foreach ($ward as $rw) {
                      if ($_SESSION['ward'] == $rw->title) {
                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                    ?><div class="dropdown-divider"></div><?php
                                                        } else {
                                                          echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                        }
                                                      }
                                                          ?>
                  </ul>
                </div>
              </td>
              <style>
                .dropdown-menu>.li {
                  width: 100%;
                  border: 0px;
                  border-bottom: 1px solid #ccc;
                  text-align: left;
                }
              </style>
            </tr>
          <?php } ?>

          <?php if ((ismodule_active('PCF') === true && $this->uri->segment(1) == 'pc')) {  ?>
            <tr>
              <script>
                function changefloore(cward) {
                  window.location = '<?php echo base_url(uri_string()); ?>?cward=' + cward;
                }
              </script>
              <td style="align-items:center;text-align:center;"><span style="margin: 9px -18px 10px 16px;font-size: 16px;"><strong><?php echo lang_loader('global','global_floor_ward'); ?>:</strong></span></td>
              <td>
                <div class="btn-group" style="margin: 2px 6px 5px 19px;">
                  <button type="button" style="background: #62c52d;border: none; width:200px" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo lang_loader('global','global_all'); ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
                  </button>
                  <ul class="dropdown-menu" style="text-align: left; width:100%;">
                    <?php
                    $this->db->order_by('title');
                    $query = $this->db->get('bf_ward');
                    $ward = $query->result();
                    foreach ($ward as $rw) {
                      if ($_SESSION['ward'] == $rw->title) {
                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                    ?><div class="dropdown-divider"></div><?php
                                                        } else {
                                                          echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                        }
                                                      }
                                                          ?>
                  </ul>
                </div>
              </td>
              <style>
                .dropdown-menu>.li {
                  width: 100%;
                  border: 0px;
                  border-bottom: 1px solid #ccc;
                  text-align: left;
                }
              </style>
            </tr>
          <?php } ?>

          <?php if (ismodule_active('OP') === true && $this->uri->segment(1) == 'opf') {  ?>
            <tr>
              <script>
                function changefloore(cward) {
                  window.location = '<?php echo base_url(uri_string()); ?>?cward=' + cward;
                }
              </script>
              <td style="align-items:center;text-align:center;"><span style="margin: 9px -18px 10px 16px;font-size: 16px;"><strong><?php echo lang_loader('global','global_speciality'); ?>:</strong></span></td>
              <td>
                <div class="btn-group" style="margin: 2px 6px 5px 19px;">
                  <button type="button" style="background: #62c52d;border: none; width:200px" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo lang_loader('global','global_all'); ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
                  </button>
                  <ul class="dropdown-menu" style="text-align: left; width:100%;">
                    <?php
                    $this->db->order_by('title');
                    $query = $this->db->get('bf_departmentop');
                    $ward = $query->result();
                    foreach ($ward as $rw) {
                      if ($_SESSION['ward'] == $rw->title) {
                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                    ?><div class="dropdown-divider"></div><?php
                                                        } else {
                                                          echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                        }
                                                      }
                                                          ?>
                  </ul>
                </div>
              </td>
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

          <?php if ((ismodule_active('GRIEVANCE') === true && $this->uri->segment(1) == 'grievance')) {  ?>

            <tr>
              <script>
                function changefloore(cward) {
                  window.location = '<?php echo base_url(uri_string()); ?>?cward=' + cward;
                }
              </script>
              <td style="align-items:center;text-align:center;"><span style="margin: 9px -18px 10px 16px;font-size: 16px;"><strong><?php echo lang_loader('global','global_floor_ward'); ?>:</strong></span></td>
              <td>
                <div class="btn-group" style="margin: 2px 6px 5px 19px;">
                  <button type="button" style="background: #62c52d;border: none; width:200px" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo lang_loader('global','global_all'); ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
                  </button>
                  <ul class="dropdown-menu" style="text-align: left; width:100%;">
                    <?php
                    $this->db->order_by('title');
                    $query = $this->db->get('bf_ward_esr');
                    $ward = $query->result();
                    foreach ($ward as $rw) {
                      if ($_SESSION['ward'] == $rw->title) {
                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                    ?><div class="dropdown-divider"></div><?php
                                                        } else {
                                                          echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                        }
                                                      }
                                                          ?>
                  </ul>
                </div>
              </td>
              <style>
                .dropdown-menu>.li {
                  width: 100%;
                  border: 0px;
                  border-bottom: 1px solid #ccc;
                  text-align: left;
                }
              </style>
            </tr>
          <?php } ?>

          <?php if ((ismodule_active('ISR') === true && $this->uri->segment(1) == 'isr')) {  ?>

            <tr>
              <script>
                function changefloore(cward) {
                  window.location = '<?php echo base_url(uri_string()); ?>?cward=' + cward;
                }
              </script>
              <td style="align-items:center;text-align:center;"><span style="margin: 9px -18px 10px 16px;font-size: 16px;"><strong><?php echo lang_loader('global','global_floor_ward'); ?>:</strong></span></td>
              <td>
                <div class="btn-group" style="margin: 2px 6px 5px 19px;">
                  <button type="button" style="background: #62c52d;border: none; width:200px" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo lang_loader('global','global_all'); ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
                  </button>
                  <ul class="dropdown-menu" style="text-align: left; width:100%;">
                    <?php
                    $this->db->order_by('title');
                    $query = $this->db->get('bf_ward_esr');
                    $ward = $query->result();
                    foreach ($ward as $rw) {
                      if ($_SESSION['ward'] == $rw->title) {
                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                    ?><div class="dropdown-divider"></div><?php
                                                        } else {
                                                          echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                        }
                                                      }
                                                          ?>
                  </ul>
                </div>
              </td>
              <style>
                .dropdown-menu>.li {
                  width: 100%;
                  border: 0px;
                  border-bottom: 1px solid #ccc;
                  text-align: left;
                }
              </style>
            </tr>
          <?php } ?>

          <?php if ((ismodule_active('INCIDENT') === true && $this->uri->segment(1) == 'incident')) {  ?>

            <tr>
              <script>
                function changefloore(cward) {
                  window.location = '<?php echo base_url(uri_string()); ?>?cward=' + cward;
                }
              </script>
              <td style="align-items:center;text-align:center;"><span style="margin: 9px -18px 10px 16px;font-size: 16px;"><strong><?php echo lang_loader('global','global_floor_ward'); ?>:</strong></span></td>
              <td>
                <div class="btn-group" style="margin: 2px 6px 5px 19px;">
                  <button type="button" style="background: #62c52d;border: none; width:200px" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo lang_loader('global','global_all'); ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
                  </button>
                  <ul class="dropdown-menu" style="text-align: left; width:100%;">
                    <?php
                    $this->db->order_by('title');
                    $query = $this->db->get('bf_ward_esr');
                    $ward = $query->result();
                    foreach ($ward as $rw) {
                      if ($_SESSION['ward'] == $rw->title) {
                        echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
                    ?><div class="dropdown-divider"></div><?php
                                                        } else {
                                                          echo '<li><a class="dropdown-item" href="#" onclick="changefloore(\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
                                                        }
                                                      }
                                                          ?>
                  </ul>
                </div>
              </td>
              <style>
                .dropdown-menu>.li {
                  width: 100%;
                  border: 0px;
                  border-bottom: 1px solid #ccc;
                  text-align: left;
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
                    "><i class="fa fa-repeat">&nbsp; <?php echo lang_loader('global','global_reset'); ?></i></button></a>
          </span>
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang_loader('global','global_close'); ?></button>
        </div>
      </div>
    </div>
  </div>
<?php } ?>