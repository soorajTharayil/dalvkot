<?php if ($this->session->userdata['user_role'] < 4) { ?>
   <?php
   $desc = 'desc';
   $global_sfrom_lang = lang_loader('global', 'global_sfrom');
   $global_at_lang = lang_loader('global', 'global_at');
   $global_no_feedback_lang = lang_loader('global', 'global_no_feedback');
   $global_view_all_lang = lang_loader('global', 'global_view_all');
   $global_complaint_raised_by_lang = lang_loader('global', 'global_complaint_raised_by');
   $global_for_lang = lang_loader('global', 'global_for');
   $global_on_lang = lang_loader('global', 'global_on');
   $global_grievance_reported_by_lang = lang_loader('global', 'global_grievance_reported_by');
   $global_service_raised_by_lang = lang_loader('global', 'global_service_raised_by');
   $global_no_complaints_lang = lang_loader('global', 'global_no_complaints');
   $global_inc_reported_by_lang = lang_loader('global', 'global_inc_reported_by');

   if ($this->uri->segment(1) == 'ipd') {
      $table_feedback = 'bf_feedback';
      $table_patients = 'bf_patients';
      $table_tickets = 'tickets';
      $all_tickets = $this->ipd_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->ipd_model->patient_and_feedback($table_patients, $table_feedback, $desc);
   }
   if ($this->uri->segment(1) == 'post') {
      $table_feedback = 'bf_feedback_pdf';
      $table_patients = 'bf_patients';
      $table_tickets = 'tickets_pdf';
      $all_tickets = $this->post_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->post_model->patient_and_feedback($table_patients, $table_feedback, $desc);
   }


   if ($this->uri->segment(1) == 'opf') {
      $table_feedback = 'bf_outfeedback';
      $table_patients = 'bf_opatients';
      $table_tickets = 'ticketsop';
      $all_tickets = $this->opf_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->opf_model->patient_and_feedback($table_patients, $table_feedback, $desc);
   }

   if ($this->uri->segment(1) == 'doctor') {
      $table_feedback = 'bf_feedback_doctors';
      $table_patients = 'bf_opatients';
      $table_tickets = 'tickets_doctor';
      $all_tickets = $this->doctorsfeedback_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->doctorsfeedback_model->patient_and_feedback($table_patients, $table_feedback, $desc);
   }

   if ($this->uri->segment(1) == 'doctoropd') {
      $table_feedback = 'bf_feedback_doctors_opd';
      $table_patients = 'bf_opatients';
      $table_tickets = 'tickets_doctor_opd';
      $all_tickets = $this->doctorsopdfeedback_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->doctorsopdfeedback_model->patient_and_feedback($table_patients, $table_feedback, $desc);
   }

   if ($this->uri->segment(1) == 'admissionfeedback') {
      $table_feedback = 'bf_feedback_adf';
      $table_patients = 'bf_patients';
      $table_tickets = 'tickets_adf';
      $all_tickets = $this->admissionfeedback_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->admissionfeedback_model->patient_and_feedback($table_patients, $table_feedback, $desc);
   }
   if ($this->uri->segment(1) == 'pc') {
      $table_feedback = 'bf_feedback_int';
      $table_patients = 'bf_patients';
      $table_tickets = 'tickets_int';
      $all_tickets = $this->pc_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->pc_model->patient_and_feedback($table_patients, $table_feedback, $desc);
      $setup = 'setup_int';
      $all_tickets = $this->pc_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->pc_model->patient_and_feedback($table_patients, $table_feedback, $desc);
      $a = $this->ticketsint_model->alltickets();
      $ticket_data = $a;
      // print_r($a);

      $this->db->select("*");
      $this->db->from($setup);
      // $this->db->where('parent', 0);
      $query = $this->db->get();
      $reasons  = $query->result();
      foreach ($reasons as $row) {
         $keys[$row->shortkey] = $row->shortkey;
         $res[$row->shortkey] = $row->shortname;
         $titles[$row->shortkey] = $row->title;
         $dep[$row->title] = $row->title;
      }
      // print_r($reasons);
   }

   if ($this->uri->segment(1) == 'isr') {
      $table_feedback = 'bf_feedback_esr';
      $table_patients = 'bf_employees_esr';
      $table_tickets = 'tickets_esr';
      $setup = 'setup_esr';
      $all_tickets = $this->isr_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->isr_model->patient_and_feedback($table_patients, $table_feedback, $desc);
      $a = $this->ticketsesr_model->alltickets();
      $ticket_data = $a;
      // print_r($a);

      $this->db->select("*");
      $this->db->from($setup);
      // $this->db->where('parent', 0);
      $query = $this->db->get();
      $reasons  = $query->result();
      foreach ($reasons as $row) {
         $keys[$row->shortkey] = $row->shortkey;
         $res[$row->shortkey] = $row->shortname;
         $titles[$row->shortkey] = $row->title;
         $dep[$row->title] = $row->title;
      }
      // print_r($reasons);
   }

   if ($this->uri->segment(1) == 'incident') {
      $table_feedback = 'bf_feedback_incident';
      $table_patients = 'bf_employees_incident';
      $table_tickets = 'tickets_incident';
      $setup = 'setup_incident';
      $all_tickets = $this->incident_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->incident_model->patient_and_feedback($table_patients, $table_feedback, $desc);
      $a = $this->ticketsincidents_model->alltickets();
      $ticket_data = $a;
      // print_r($a);

      $this->db->select("*");
      $this->db->from($setup);
      // $this->db->where('parent', 0);
      $query = $this->db->get();
      $reasons  = $query->result();
      foreach ($reasons as $row) {
         $keys[$row->shortkey] = $row->shortkey;
         $res[$row->shortkey] = $row->shortname;
         $titles[$row->shortkey] = $row->title;
         $dep[$row->title] = $row->title;
      }
   }



   if ($this->uri->segment(1) == 'grievance') {
      $table_feedback = 'bf_feedback_grievance';
      $table_patients = 'bf_employees_grievance';
      $table_tickets = 'tickets_grievance';
      $setup = 'setup_grievance';
      $all_tickets = $this->grievance_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->grievance_model->patient_and_feedback($table_patients, $table_feedback, $desc);
      $a = $this->ticketsgrievance_model->alltickets();
      $ticket_data = $a;
      // print_r($a);

      $this->db->select("*");
      $this->db->from($setup);
      // $this->db->where('parent', 0);
      $query = $this->db->get();
      $reasons  = $query->result();
      foreach ($reasons as $row) {
         $keys[$row->shortkey] = $row->shortkey;
         $res[$row->shortkey] = $row->shortname;
         $titles[$row->shortkey] = $row->title;
         $dep[$row->title] = $row->title;
      }
   }


   ?>
   <li>
      <?php if ($this->uri->segment(1) == 'ipd' || $this->uri->segment(1) == 'opf'  || $this->uri->segment(1) == 'admissionfeedback' || $this->uri->segment(1) == 'post' || $this->uri->segment(1) == 'doctor' || $this->uri->segment(1) == 'doctoropd') { ?>
         <?php if ($this->uri->segment(2) != 'trend_analytic') { ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
               <span class="label label-success"><?php echo count($feedbacktaken); ?></span>
            </a>
            <ul class="dropdown-menu" style="overflow: auto; margin-left: -216px;min-width:262px;position: absolute;background: #fff;">
               <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                     <?php foreach ($feedbacktaken as $row) {
                        $detail = json_decode($row->dataset);

                        $check = true;
                        foreach ($all_tickets as $t) {
                           if ($t->feedbackid == $row->id && $check == true) {
                              $check = false;
                              $psat = 'Unhappy feedback submitted by, ';
                              $emoji = '<i class="fa fa-frown-o" aria-hidden="true"></i>';
                           }
                        }
                        if ($check == true) {
                           $psat = 'Happy feedback submitted by, ';
                           $emoji = '<i class="fa fa-smile-o" aria-hidden="true"></i>';
                        }
                     ?>
                        <li>
                           <a href="<?php echo base_url($this->uri->segment(1)); ?>/patient_feedback?id=<?php echo $row->id; ?>">
                              <p><?php echo $emoji; ?> <?php echo $psat; ?> <?php echo $detail->name; ?>
                                 (<span style="color:#62c52d;"><?php echo $detail->patientid; ?></span>),
                                 <?php if ($this->uri->segment(1) == 'ipd' || $this->uri->segment(1) == 'admissionfeedback' || $this->uri->segment(1) == 'post') { ?>
                                    <?php echo $global_sfrom_lang; ?>&nbsp;<?php echo $detail->bedno . ' in '  . $detail->ward; ?> <?php echo $global_at_lang; ?> <?php if ($detail->datetime) { ?>
                                       <?php echo date('g:i A', date(($detail->datetime) / 1000)); ?>

                                       <?php echo date('d-m-y', date(($detail->datetime) / 1000)); ?>
                                    <?php } ?></p>
                           <?php } else if ($this->uri->segment(1) == 'opf' || $this->uri->segment(1) == 'doctor' || $this->uri->segment(1) == 'doctoropd') { ?>
                              <?php echo $detail->ward; ?> <?php echo $global_at_lang; ?> <?php if ($detail->datetime) { ?>
                                 <?php echo date('g:i A', date(($detail->datetime) / 1000)); ?>

                                 <?php echo date('d-m-y', date(($detail->datetime) / 1000)); ?>
                              <?php } ?></p>
                           <?php } ?>
                           </a>
                        </li>
                     <?php   }
                     if (count($feedbacktaken) == 0) {  ?>
                        <div style="font-size: 20px;text-align: center;margin-top: 10px; margin-top:20%;">
                           <i class="fa fa-spinner" aria-hidden="true" style=" color:#62c52d;"> </i>
                           <br> <br>
                           <?php echo $global_no_feedback_lang; ?>
                        </div>
                     <?php } ?>
                  </ul>
               </li>
               <?php if (count($feedbacktaken) != 0) {  ?>
                  <div style=" margin-right:5px; box-shadow: -13px 7px 9px 4px #000000; padding: 10px 0px; text-align: center;">
                     <span style=" border-color: #62c52d; margin-left: 13px; margin-bottom: 3px;   margin-top: 3px; ">
                        <a href="<?php echo base_url($this->uri->segment(1)); ?>/notifications"> <b><?php echo $global_view_all_lang; ?></b></a></span>
                  </div>
               <?php } ?>
            </ul>
         <?php } ?>
      <?php } ?>



      <?php if ($this->uri->segment(1) == 'isr') { ?>
         <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
            <span class="label label-success"><?php echo count($ticket_data); ?></span>
         </a>
         <ul class="dropdown-menu" style="overflow: auto; margin-left: -216px;min-width:262px;position: absolute;background: #fff;">
            <li>
               <!-- inner menu: contains the actual data -->
               <ul class="menu">
                  <?php foreach ($ticket_data as $ticketdata) { ?>
                     <li>
                        <a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
                           <p><?php echo $global_service_raised_by_lang; ?> <?php echo $ticketdata->feed->name; ?>
                              (<span style="color:#62c52d;"><?php echo $ticketdata->feed->patientid; ?></span>), <?php echo $global_for_lang; ?>
                              <?php if ($ticketdata->feed->reason == true) { ?>
                                 <?php foreach ($ticketdata->feed->reason as $key => $value) {
                                    if ($titles[$key] == $ticketdata->department->description) {
                                       if (in_array($key, $keys)) { ?>
                                          <b><?php echo $res[$key]; ?></b>
                                       <?php } ?>
                                    <?php } ?>
                                 <?php } ?>
                              <?php } ?>
                              <?php echo $global_sfrom_lang; ?>&nbsp;<?php echo $ticketdata->feed->bedno . ' in '  . $ticketdata->feed->ward; ?> <?php echo $global_at_lang; ?>
                              <?php echo date('g:i A, d-m-y', strtotime($ticketdata->created_on)); ?>
                           </p>
                        </a>
                     </li>
                  <?php   }
                  if (count($ticket_data) == 0) {  ?>
                     <div style="font-size: 20px;text-align: center;margin-top: 10px; margin-top:20%;">
                        <i class="fa fa-spinner" aria-hidden="true" style=" color:#62c52d;"> </i>
                        <br> <br>
                        <?php echo $global_no_feedback_lang; ?>
                     </div>
                  <?php } ?>
               </ul>
            </li>
            <?php if (count($ticket_data) != 0) {  ?>
               <div style=" margin-right:5px; box-shadow: -13px 7px 9px 4px #000000; padding: 10px 0px; text-align: center;">
                  <span style=" border-color: #62c52d; margin-left: 13px; margin-bottom: 3px;   margin-top: 3px; ">
                     <a href="<?php echo base_url($this->uri->segment(1)); ?>/notifications"> <b><?php echo $global_view_all_lang; ?></b></a></span>
               </div>
            <?php } ?>
         </ul>
      <?php } ?>


      <?php if ($this->uri->segment(1) == 'pc') { ?>
         <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
            <span class="label label-success"><?php echo count($ticket_data); ?></span>
         </a>
         <ul class="dropdown-menu" style="overflow: auto; margin-left: -216px;min-width:262px;position: absolute;background: #fff;">
            <li>
               <!-- inner menu: contains the actual data -->
               <ul class="menu">
                  <?php foreach ($ticket_data as $ticketdata) { ?>
                     <li>
                        <a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
                           <p><?php echo $global_complaint_raised_by_lang; ?> <?php echo $ticketdata->feed->name; ?>
                              (<span style="color:#62c52d;"><?php echo $ticketdata->feed->patientid; ?></span>), <?php echo $global_for_lang; ?>
                              <?php if ($ticketdata->feed->reason == true) { ?>
                                 <?php foreach ($ticketdata->feed->reason as $key => $value) {
                                    if ($titles[$key] == $ticketdata->department->description) {
                                       if (in_array($key, $keys)) { ?>
                                          <b><?php echo $res[$key]; ?></b>
                                       <?php } ?>
                                    <?php } ?>
                                 <?php } ?>
                              <?php } ?>
                              <?php echo $global_sfrom_lang; ?>&nbsp;<?php echo $ticketdata->feed->bedno . ' in '  . $ticketdata->feed->ward; ?> <?php echo $global_at_lang; ?>
                              <?php echo date('g:i A, d-m-y', strtotime($ticketdata->created_on)); ?>
                           </p>
                        </a>
                     </li>
                  <?php   }
                  if (count($ticket_data) == 0) {  ?>
                     <div style="font-size: 20px;text-align: center;margin-top: 10px; margin-top:20%;">
                        <i class="fa fa-spinner" aria-hidden="true" style=" color:#62c52d;"> </i>
                        <br> <br>
                        <?php echo $global_no_complaints_lang; ?>
                     </div>
                  <?php } ?>
               </ul>
            </li>
            <?php if (count($ticket_data) != 0) {  ?>
               <div style=" margin-right:5px; box-shadow: -13px 7px 9px 4px #000000; padding: 10px 0px; text-align: center;">
                  <span style=" border-color: #62c52d; margin-left: 13px; margin-bottom: 3px;   margin-top: 3px; ">
                     <a href="<?php echo base_url($this->uri->segment(1)); ?>/notifications"> <b><?php echo $global_view_all_lang; ?></b></a></span>
               </div>
            <?php } ?>
         </ul>
      <?php } ?>

      <?php if ($this->uri->segment(1) == 'incident') { ?>
         <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
            <span class="label label-success"><?php echo count($ticket_data); ?></span>
         </a>
         <ul class="dropdown-menu" style="overflow: auto; margin-left: -216px;min-width:262px;position: absolute;background: #fff;">
            <li>
               <!-- inner menu: contains the actual data -->
               <ul class="menu">
                  <?php foreach ($ticket_data as $ticketdata) { ?>
                     <li>
                        <a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
                           <p><?php echo $global_inc_reported_by_lang; ?> <?php echo $ticketdata->feed->name; ?>
                              (<span style="color:#62c52d;"><?php echo $ticketdata->feed->patientid; ?></span>), <?php echo $global_on_lang; ?>
                              <?php if ($ticketdata->feed->reason == true) { ?>
                                 <?php foreach ($ticketdata->feed->reason as $key => $value) {
                                    if ($titles[$key] == $ticketdata->department->description) {
                                       if (in_array($key, $keys)) { ?>
                                          <b><?php echo $res[$key]; ?></b>
                                       <?php } ?>
                                    <?php } ?>
                                 <?php } ?>
                              <?php } ?>
                              <?php echo $global_sfrom_lang; ?>&nbsp;<?php echo $ticketdata->feed->bedno . ' in '  . $ticketdata->feed->ward; ?> <?php echo $global_at_lang; ?>
                              <?php echo date('g:i A, d-m-y', strtotime($ticketdata->created_on)); ?>
                           </p>
                        </a>
                     </li>
                  <?php   }
                  if (count($ticket_data) == 0) {  ?>
                     <div style="font-size: 20px;text-align: center;margin-top: 10px; margin-top:20%;">
                        <i class="fa fa-spinner" aria-hidden="true" style=" color:#62c52d;"> </i>
                        <br> <br>
                        <?php echo $global_no_feedback_lang; ?>
                     </div>
                  <?php } ?>
               </ul>
            </li>
            <?php if (count($ticket_data) != 0) {  ?>
               <div style=" margin-right:5px; box-shadow: -13px 7px 9px 4px #000000; padding: 10px 0px; text-align: center;">
                  <span style=" border-color: #62c52d; margin-left: 13px; margin-bottom: 3px;   margin-top: 3px; ">
                     <a href="<?php echo base_url($this->uri->segment(1)); ?>/notifications"> <b><?php echo $global_view_all_lang; ?></b></a></span>
               </div>
            <?php } ?>
         </ul>
      <?php } ?>


      <?php if ($this->uri->segment(1) == 'grievance') { ?>
         <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
            <span class="label label-success"><?php echo count($ticket_data); ?></span>
         </a>
         <ul class="dropdown-menu" style="overflow: auto; margin-left: -216px;min-width:262px;position: absolute;background: #fff;">
            <li>
               <!-- inner menu: contains the actual data -->
               <ul class="menu">
                  <?php foreach ($ticket_data as $ticketdata) { ?>
                     <li>
                        <a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
                           <p><?php echo $global_grievance_reported_by_lang; ?> <?php echo $ticketdata->feed->name; ?>
                              (<span style="color:#62c52d;"><?php echo $ticketdata->feed->patientid; ?></span>), <?php echo $global_on_lang; ?>
                              <?php if ($ticketdata->feed->reason == true) { ?>
                                 <?php foreach ($ticketdata->feed->reason as $key => $value) {
                                    if ($titles[$key] == $ticketdata->department->description) {
                                       if (in_array($key, $keys)) { ?>
                                          <b><?php echo $res[$key]; ?></b>
                                       <?php } ?>
                                    <?php } ?>
                                 <?php } ?>
                              <?php } ?>
                              <?php echo $global_sfrom_lang; ?>&nbsp;<?php echo $ticketdata->feed->bedno . ' in '  . $ticketdata->feed->ward; ?> <?php echo $global_at_lang; ?>
                              <?php echo date('g:i A, d-m-y', strtotime($ticketdata->created_on)); ?>
                           </p>
                        </a>
                     </li>
                  <?php   }
                  if (count($ticket_data) == 0) {  ?>
                     <div style="font-size: 20px;text-align: center;margin-top: 10px; margin-top:20%;">
                        <i class="fa fa-spinner" aria-hidden="true" style=" color:#62c52d;"> </i>
                        <br> <br>
                        <?php echo $global_no_feedback_lang; ?>
                     </div>
                  <?php } ?>
               </ul>
            </li>
            <?php if (count($ticket_data) != 0) {  ?>
               <div style=" margin-right:5px; box-shadow: -13px 7px 9px 4px #000000; padding: 10px 0px; text-align: center;">
                  <span style=" border-color: #62c52d; margin-left: 13px; margin-bottom: 3px;   margin-top: 3px; ">
                     <a href="<?php echo base_url($this->uri->segment(1)); ?>/notifications"> <b><?php echo $global_view_all_lang; ?></b></a></span>
               </div>
            <?php } ?>
         </ul>
      <?php } ?>





   </li>
<?php } ?>



<?php /* if ($this->session->userdata['user_role'] == 4) { ?>
   <?php
   $desc = 'desc';
   if ($this->uri->segment(1) == 'ipd') {
      $table_feedback = 'bf_feedback';
      $table_patients = 'bf_patients';
      $table_tickets = 'tickets';

      $setup = 'setup';
      $all_tickets = $this->updated_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->updated_model->patient_and_feedback($table_patients, $table_feedback, $desc);
      $a = $this->tickets_model->alltickets();
      $ticket_data = $a;


      $this->db->select("*");
      $this->db->from($setup);
      // $this->db->where('parent', 0);
      $query = $this->db->get();
      $reasons  = $query->result();
      foreach ($reasons as $row) {
         $keys[$row->shortkey] = $row->shortkey;
         $res[$row->shortkey] = $row->shortname;
         $titles[$row->shortkey] = $row->title;
         $dep[$row->title] = $row->title;
      }
   }

   if ($this->uri->segment(1) == 'opf') {
      $table_feedback = 'bf_outfeedback';
      $table_patients = 'bf_opatients';
      $table_tickets = 'ticketsop';

      $setup = 'setupop';
      $all_tickets = $this->updated_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->updated_model->patient_and_feedback($table_patients, $table_feedback, $desc);
      $a = $this->ticketsop_model->alltickets();
      $ticket_data = $a;


      $this->db->select("*");
      $this->db->from($setup);
      // $this->db->where('parent', 0);
      $query = $this->db->get();
      $reasons  = $query->result();
      foreach ($reasons as $row) {
         $keys[$row->shortkey] = $row->shortkey;
         $res[$row->shortkey] = $row->shortname;
         $titles[$row->shortkey] = $row->title;
         $dep[$row->title] = $row->title;
      }
   }
   if ($this->uri->segment(1) == 'admissionfeedback') {
      $table_feedback = 'bf_feedback_adf';
      $table_patients = 'bf_patients';
      $table_tickets = 'tickets_adf';

      $setup = 'setup_adf';
      $all_tickets = $this->updated_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->updated_model->patient_and_feedback($table_patients, $table_feedback, $desc);
      $a = $this->ticketsadf_model->alltickets();
      $ticket_data = $a;


      $this->db->select("*");
      $this->db->from($setup);
      // $this->db->where('parent', 0);
      $query = $this->db->get();
      $reasons  = $query->result();
      foreach ($reasons as $row) {
         $keys[$row->shortkey] = $row->shortkey;
         $res[$row->shortkey] = $row->shortname;
         $titles[$row->shortkey] = $row->title;
         $dep[$row->title] = $row->title;
      }
   }
   if ($this->uri->segment(1) == 'pc') {
      $table_feedback = 'bf_feedback_int';
      $table_patients = 'bf_patients';
      $table_tickets = 'tickets_int';
      $all_tickets = $this->updated_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->updated_model->patient_and_feedback($table_patients, $table_feedback, $desc);
      $setup = 'setup_int';
      $all_tickets = $this->updated_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->updated_model->patient_and_feedback($table_patients, $table_feedback, $desc);
      $a = $this->ticketsint_model->alltickets();
      $ticket_data = $a;
      // print_r($a);

      $this->db->select("*");
      $this->db->from($setup);
      // $this->db->where('parent', 0);
      $query = $this->db->get();
      $reasons  = $query->result();
      foreach ($reasons as $row) {
         $keys[$row->shortkey] = $row->shortkey;
         $res[$row->shortkey] = $row->shortname;
         $titles[$row->shortkey] = $row->title;
         $dep[$row->title] = $row->title;
      }
      // print_r($reasons);
   }

   if ($this->uri->segment(1) == 'isr') {
      $table_feedback = 'bf_feedback_esr';
      $table_patients = 'bf_employees_esr';
      $table_tickets = 'tickets_esr';
      $setup = 'setup_esr';
      $all_tickets = $this->updated_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->updated_model->patient_and_feedback($table_patients, $table_feedback, $desc);
      $a = $this->ticketsesr_model->alltickets();
      $ticket_data = $a;
      // print_r($a);

      $this->db->select("*");
      $this->db->from($setup);
      // $this->db->where('parent', 0);
      $query = $this->db->get();
      $reasons  = $query->result();
      foreach ($reasons as $row) {
         $keys[$row->shortkey] = $row->shortkey;
         $res[$row->shortkey] = $row->shortname;
         $titles[$row->shortkey] = $row->title;
         $dep[$row->title] = $row->title;
      }
      // print_r($reasons);
   }

   if ($this->uri->segment(1) == 'incident') {
      $table_feedback = 'bf_feedback_incident';
      $table_patients = 'bf_employees_incident';
      $table_tickets = 'tickets_incident';
      $setup = 'setup_incident';
      $all_tickets = $this->updated_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->updated_model->patient_and_feedback($table_patients, $table_feedback, $desc);
      $a = $this->ticketsincidents_model->alltickets();
      $ticket_data = $a;
      // print_r($a);

      $this->db->select("*");
      $this->db->from($setup);
      // $this->db->where('parent', 0);
      $query = $this->db->get();
      $reasons  = $query->result();
      foreach ($reasons as $row) {
         $keys[$row->shortkey] = $row->shortkey;
         $res[$row->shortkey] = $row->shortname;
         $titles[$row->shortkey] = $row->title;
         $dep[$row->title] = $row->title;
      }
   }



   if ($this->uri->segment(1) == 'grievance') {
      $table_feedback = 'bf_feedback_grievance';
      $table_patients = 'bf_employees_grievance';
      $table_tickets = 'tickets_grievance';
      $setup = 'setup_grievance';
      $all_tickets = $this->updated_model->get_tickets($table_feedback, $table_tickets);
      $feedbacktaken = $this->updated_model->patient_and_feedback($table_patients, $table_feedback, $desc);
      $a = $this->ticketsgrievance_model->alltickets();
      $ticket_data = $a;
      // print_r($a);

      $this->db->select("*");
      $this->db->from($setup);
      // $this->db->where('parent', 0);
      $query = $this->db->get();
      $reasons  = $query->result();
      foreach ($reasons as $row) {
         $keys[$row->shortkey] = $row->shortkey;
         $res[$row->shortkey] = $row->shortname;
         $titles[$row->shortkey] = $row->title;
         $dep[$row->title] = $row->title;
      }
   }


   ?>
   <li>
      <?php if ($this->uri->segment(1) == 'ipd' || $this->uri->segment(1) == 'opf' ||$this->uri->segment(1) == 'admissionfeedback') { ?>
         <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
            <span class="label label-success"><?php echo count($ticket_data); ?></span>
         </a>
         <ul class="dropdown-menu" style="overflow: auto; margin-left: -216px;min-width:262px;position: absolute;background: #fff;">
            <li>
               <!-- inner menu: contains the actual data -->
               <ul class="menu">
                  <?php foreach ($ticket_data as $ticketdata) { ?>
                     <li>
                        <a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
                           <p>Negative experience reported by <?php echo $ticketdata->feed->name; ?>
                              (<span style="color:#62c52d;"><?php echo $ticketdata->feed->patientid; ?></span>), for
                              <?php if ($ticketdata->feed->reason == true) { ?>
                                 <?php foreach ($ticketdata->feed->reason as $key => $value) {
                                    if ($titles[$key] == $ticketdata->department->description) {
                                       if (in_array($key, $keys)) { ?>
                                          <b><?php echo $res[$key] . ','; ?></b>
                                       <?php } ?>
                                    <?php } ?>
                                 <?php } ?>
                              <?php } ?>
                              from&nbsp;<?php echo $ticketdata->feed->bedno . ' in '  . $ticketdata->feed->ward; ?> at
                              <?php echo date('g:i A, d-m-y', strtotime($ticketdata->created_on)); ?>
                           </p>
                        </a>
                     </li>
                  <?php   }
                  if (count($ticket_data) == 0) {  ?>
                     <div style="font-size: 20px;text-align: center;margin-top: 10px; margin-top:20%;">
                        <i class="fa fa-spinner" aria-hidden="true" style=" color:#62c52d;"> </i>
                        <br> <br>
                        No Feedbacks
                     </div>
                  <?php } ?>
               </ul>
            </li>
            <?php if (count($ticket_data) != 0) {  ?>
               <div style=" margin-right:5px; box-shadow: -13px 7px 9px 4px #000000; padding: 10px 0px; text-align: center;">
                  <span style=" border-color: #62c52d; margin-left: 13px; margin-bottom: 3px;   margin-top: 3px; ">
                     <a href="<?php echo base_url($this->uri->segment(1)); ?>/notifications"> <b>View All</b></a></span>
               </div>
            <?php } ?>
         </ul>
      <?php } ?>



      <?php if ($this->uri->segment(1) == 'isr') { ?>
         <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
            <span class="label label-success"><?php echo count($ticket_data); ?></span>
         </a>
         <ul class="dropdown-menu" style="overflow: auto; margin-left: -216px;min-width:262px;position: absolute;background: #fff;">
            <li>
               <!-- inner menu: contains the actual data -->
               <ul class="menu">
                  <?php foreach ($ticket_data as $ticketdata) { ?>
                     <li>
                        <a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
                           <p><?php echo $global_service_raised_by_lang; ?> <?php echo $ticketdata->feed->name; ?>
                              (<span style="color:#62c52d;"><?php echo $ticketdata->feed->patientid; ?></span>), for
                              <?php if ($ticketdata->feed->reason == true) { ?>
                                 <?php foreach ($ticketdata->feed->reason as $key => $value) {
                                    if ($titles[$key] == $ticketdata->department->description) {
                                       if (in_array($key, $keys)) { ?>
                                          <b><?php echo $res[$key]; ?></b>
                                       <?php } ?>
                                    <?php } ?>
                                 <?php } ?>
                              <?php } ?>
                              from&nbsp;<?php echo $ticketdata->feed->bedno . ' in '  . $ticketdata->feed->ward; ?> at
                              <?php echo date('g:i A, d-m-y', strtotime($ticketdata->created_on)); ?>
                           </p>
                        </a>
                     </li>
                  <?php   }
                  if (count($ticket_data) == 0) {  ?>
                     <div style="font-size: 20px;text-align: center;margin-top: 10px; margin-top:20%;">
                        <i class="fa fa-spinner" aria-hidden="true" style=" color:#62c52d;"> </i>
                        <br> <br>
                        No Feedbacks
                     </div>
                  <?php } ?>
               </ul>
            </li>
            <?php if (count($ticket_data) != 0) {  ?>
               <div style=" margin-right:5px; box-shadow: -13px 7px 9px 4px #000000; padding: 10px 0px; text-align: center;">
                  <span style=" border-color: #62c52d; margin-left: 13px; margin-bottom: 3px;   margin-top: 3px; ">
                     <a href="<?php echo base_url($this->uri->segment(1)); ?>/notifications"> <b>View All</b></a></span>
               </div>
            <?php } ?>
         </ul>
      <?php } ?>


      <?php if ($this->uri->segment(1) == 'pc') { ?>
         <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
            <span class="label label-success"><?php echo count($ticket_data); ?></span>
         </a>
         <ul class="dropdown-menu" style="overflow: auto; margin-left: -216px;min-width:262px;position: absolute;background: #fff;">
            <li>
               <!-- inner menu: contains the actual data -->
               <ul class="menu">
                  <?php foreach ($ticket_data as $ticketdata) { ?>
                     <li>
                        <a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
                           <p>Complaint raised by <?php echo $ticketdata->feed->name; ?>
                              (<span style="color:#62c52d;"><?php echo $ticketdata->feed->patientid; ?></span>), for
                              <?php if ($ticketdata->feed->reason == true) { ?>
                                 <?php foreach ($ticketdata->feed->reason as $key => $value) {
                                    if ($titles[$key] == $ticketdata->department->description) {
                                       if (in_array($key, $keys)) { ?>
                                          <b><?php echo $res[$key]; ?></b>
                                       <?php } ?>
                                    <?php } ?>
                                 <?php } ?>
                              <?php } ?>
                              from&nbsp;<?php echo $ticketdata->feed->bedno . ' in '  . $ticketdata->feed->ward; ?> at
                              <?php echo date('g:i A, d-m-y', strtotime($ticketdata->created_on)); ?>
                           </p>
                        </a>
                     </li>
                  <?php   }
                  if (count($ticket_data) == 0) {  ?>
                     <div style="font-size: 20px;text-align: center;margin-top: 10px; margin-top:20%;">
                        <i class="fa fa-spinner" aria-hidden="true" style=" color:#62c52d;"> </i>
                        <br> <br>
                        No Complaints
                     </div>
                  <?php } ?>
               </ul>
            </li>
            <?php if (count($ticket_data) != 0) {  ?>
               <div style=" margin-right:5px; box-shadow: -13px 7px 9px 4px #000000; padding: 10px 0px; text-align: center;">
                  <span style=" border-color: #62c52d; margin-left: 13px; margin-bottom: 3px;   margin-top: 3px; ">
                     <a href="<?php echo base_url($this->uri->segment(1)); ?>/notifications"> <b>View All</b></a></span>
               </div>
            <?php } ?>
         </ul>
      <?php } ?>

      <?php if ($this->uri->segment(1) == 'incident') { ?>
         <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
            <span class="label label-success"><?php echo count($ticket_data); ?></span>
         </a>
         <ul class="dropdown-menu" style="overflow: auto; margin-left: -216px;min-width:262px;position: absolute;background: #fff;">
            <li>
               <!-- inner menu: contains the actual data -->
               <ul class="menu">
                  <?php foreach ($ticket_data as $ticketdata) { ?>
                     <li>
                        <a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
                           <p><?php echo $global_no_complaints_lang; ?> <?php echo $ticketdata->feed->name; ?>
                              (<span style="color:#62c52d;"><?php echo $ticketdata->feed->patientid; ?></span>), on
                              <?php if ($ticketdata->feed->reason == true) { ?>
                                 <?php foreach ($ticketdata->feed->reason as $key => $value) {
                                    if ($titles[$key] == $ticketdata->department->description) {
                                       if (in_array($key, $keys)) { ?>
                                          <b><?php echo $res[$key]; ?></b>
                                       <?php } ?>
                                    <?php } ?>
                                 <?php } ?>
                              <?php } ?>
                              from&nbsp;<?php echo $ticketdata->feed->bedno . ' in '  . $ticketdata->feed->ward; ?> at
                              <?php echo date('g:i A, d-m-y', strtotime($ticketdata->created_on)); ?>
                           </p>
                        </a>
                     </li>
                  <?php   }
                  if (count($ticket_data) == 0) {  ?>
                     <div style="font-size: 20px;text-align: center;margin-top: 10px; margin-top:20%;">
                        <i class="fa fa-spinner" aria-hidden="true" style=" color:#62c52d;"> </i>
                        <br> <br>
                        No Feedbacks
                     </div>
                  <?php } ?>
               </ul>
            </li>
            <?php if (count($ticket_data) != 0) {  ?>
               <div style=" margin-right:5px; box-shadow: -13px 7px 9px 4px #000000; padding: 10px 0px; text-align: center;">
                  <span style=" border-color: #62c52d; margin-left: 13px; margin-bottom: 3px;   margin-top: 3px; ">
                     <a href="<?php echo base_url($this->uri->segment(1)); ?>/notifications"> <b>View All</b></a></span>
               </div>
            <?php } ?>
         </ul>
      <?php } ?>


      <?php if ($this->uri->segment(1) == 'grievance') { ?>
         <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i>
            <span class="label label-success"><?php echo count($ticket_data); ?></span>
         </a>
         <ul class="dropdown-menu" style="overflow: auto; margin-left: -216px;min-width:262px;position: absolute;background: #fff;">
            <li>
               <!-- inner menu: contains the actual data -->
               <ul class="menu">
                  <?php foreach ($ticket_data as $ticketdata) { ?>
                     <li>
                        <a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
                           <p>Grievance reported by <?php echo $ticketdata->feed->name; ?>
                              (<span style="color:#62c52d;"><?php echo $ticketdata->feed->patientid; ?></span>), on
                              <?php if ($ticketdata->feed->reason == true) { ?>
                                 <?php foreach ($ticketdata->feed->reason as $key => $value) {
                                    if ($titles[$key] == $ticketdata->department->description) {
                                       if (in_array($key, $keys)) { ?>
                                          <b><?php echo $res[$key]; ?></b>
                                       <?php } ?>
                                    <?php } ?>
                                 <?php } ?>
                              <?php } ?>
                              from&nbsp;<?php echo $ticketdata->feed->bedno . ' in '  . $ticketdata->feed->ward; ?> at
                              <?php echo date('g:i A, d-m-y', strtotime($ticketdata->created_on)); ?>
                           </p>
                        </a>
                     </li>
                  <?php   }
                  if (count($ticket_data) == 0) {  ?>
                     <div style="font-size: 20px;text-align: center;margin-top: 10px; margin-top:20%;">
                        <i class="fa fa-spinner" aria-hidden="true" style=" color:#62c52d;"> </i>
                        <br> <br>
                        No Feedbacks
                     </div>
                  <?php } ?>
               </ul>
            </li>
            <?php if (count($ticket_data) != 0) {  ?>
               <div style=" margin-right:5px; box-shadow: -13px 7px 9px 4px #000000; padding: 10px 0px; text-align: center;">
                  <span style=" border-color: #62c52d; margin-left: 13px; margin-bottom: 3px;   margin-top: 3px; ">
                     <a href="<?php echo base_url($this->uri->segment(1)); ?>/notifications"> <b>View All</b></a></span>
               </div>
            <?php } ?>
         </ul>
      <?php } ?>





   </li>
<?php } */ ?>