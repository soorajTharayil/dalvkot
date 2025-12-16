<?php
if ($this->uri->segment(1) == 'pc' && ismodule_active('int_tat') === true) {
   // Assuming you only need one database query result for both $ticket_data and $departments
   $ticket_data = $this->ticketsint_model->read();
   $departments = $ticket_data;
   $desc = 'desc';
   $start_time = 0.10;
   $end_time = 1;
   $currentTime = time();
   $countoftickets = 0;

   foreach ($departments as $department) {
      $closeTime = $department->department->close_time;
      $createdOn1 = strtotime($department->created_on);
      $underrange = $createdOn1 + ($start_time * $closeTime);
      $uprange = $createdOn1 + ($end_time * $closeTime);
      $lastModified1 = strtotime($department->last_modified) - 5;
      $lastModified2 = strtotime($department->last_modified);
      $countexc = 0;
      $time_rem = $createdOn1 + $closeTime;
      $timeDifferenceInSeconds =  $time_rem - $currentTime;
      $value = $this->pc_model->convertSecondsToTime($timeDifferenceInSeconds);

      if (($lastModified1 < $currentTime) && ($uprange > $currentTime && $underrange <= $currentTime)) {
         $countoftickets =   $countoftickets + 1;
      }
   }

?>

   <!-- Main notification dropdown button -->
   <li>
      <?php if ($countoftickets) { ?>
         <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bullhorn"></i>
            <span class="label label-danger"><?php echo $countoftickets; ?></span>
         </a>
      <?php } else { ?>
         <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-ticket"></i>
            <span class="label label-success"><?php echo $countoftickets; ?></span>
         </a>
      <?php } ?>

      <ul class="dropdown-menu" style="overflow: auto; margin-left: -216px; min-width:262px; position: absolute; background: #fff;">
         <li>
            <ul class="menu">
               <?php if ($countoftickets) { ?>
                  <?php foreach ($departments as $department) {
                     $closeTime = $department->department->close_time;
                     $createdOn1 = strtotime($department->created_on);
                     $underrange = $createdOn1 + ($start_time * $closeTime);
                     $uprange = $createdOn1 + ($end_time * $closeTime);
                     $lastModified1 = strtotime($department->last_modified) - 5;
                     $lastModified2 = strtotime($department->last_modified);
                     $countexc = 0;
                     $time_rem = $createdOn1 + $closeTime;
                     $timeDifferenceInSeconds =  $time_rem - $currentTime;
                     $value = $this->pc_model->convertSecondsToTime($timeDifferenceInSeconds);

                     if (($lastModified1 < $currentTime) && ($uprange > $currentTime && $underrange <= $currentTime)) {
                        $countoftickets++;
                  ?>

                        <!-- Inner notification item -->
                        <li>
                           <a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $department->id; ?>">
                              <p>
                                 <span style="color:red;"> <i class="fa fa-ticket"></i> <?php echo lang_loader('global','global_attenction_pct'); ?><?php echo $department->id; ?> <?php echo lang_loader('global','global_open_tat_limit'); ?> :
                                    <?php
                                    if ($value['days'] != 0) echo $value['days'] . ' days, ';
                                    if ($value['hours'] != 0) echo $value['hours'] . ' hrs, ';
                                    if ($value['minutes'] != 0) echo $value['minutes'] . ' mins.';
                                    if ($timeDifferenceInSeconds <= 60) echo $timeDifferenceInSeconds . ' seconds.';
                                    ?>
                                 </span>
                                 <br>
                                 <span style="display:inline;float:right;">
                                    <?php echo lang_loader('global','global_click_to_view'); ?>
                                 </span>
                                 <br>
                                 <span style="display:none;">
                                    <?php echo $department->feed->name; ?>
                                    (<span style="color:#62c52d;"><?php echo $department->feed->patientid; ?></span>),
                                    <?php if ($this->uri->segment(1) == 'pc') { ?>
                                       <?php echo lang_loader('global','global_from'); ?>&nbsp;<?php echo $department->feed->bedno . ' in ' . $department->feed->ward; ?> <?php echo lang_loader('global','global_at'); ?>
                                       <?php echo date('g:i A', strtotime($department->created_on)); ?>
                                       <?php echo date('d-m-y', strtotime($department->created_on)); ?>
                                    <?php } ?>
                                 </span>
                              </p>
                           </a>
                        </li>

                  <?php }
                  } ?>
               <?php } else { ?>
                  <div style="font-size: 20px;text-align: center;margin-top: 10px; margin-top:20%;">
                     <i class="fa fa-spinner" aria-hidden="true" style=" color:#62c52d;"> </i>
                     <br> <br>
                     <?php echo lang_loader('global','global_no_data'); ?>
                  </div>
               <?php } ?>

            </ul>
         </li>
      </ul>
   </li>
<?php } ?>