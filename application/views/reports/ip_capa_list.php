<div class="content">
   <script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
   <script src="<?php echo base_url(); ?>assets/utils.js"></script>
   <?php
   $dates = get_from_to_date();
   $fdate = $dates['fdate'];
   $tdate = $dates['tdate'];
   $pagetitle = $dates['pagetitle'];
   $fdate = date('Y-m-d', strtotime($fdate));
   $fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
   $days = $dates['days'];
   $this->db->select('tickets.*');
   $this->db->from('tickets');

   $this->db->join('bf_feedback', 'tickets.feedbackid = bf_feedback.id', 'inner');
   $this->db->join('bf_patients', 'bf_patients.patient_id = bf_feedback.patientid', 'inner');
   if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
      //$this->db->where('bf_patients.ward',$_SESSION['ward']);
   }
   $fdate = date('Y-m-d', strtotime($fdate) + 2 * 3600 * 12);
   $tdate = date('Y-m-d', strtotime($tdate) - 2 * 3600 * 12);
   $this->db->where('tickets.last_modified <=', $fdate);
   $this->db->where('tickets.last_modified >=', $tdate);
   $this->db->where('tickets.status', 'Closed');
   $this->db->order_by('last_modified', 'desc');
   $query = $this->db->get();
   $departments = $query->result();



   //print_r($departments); exit;
   ?>


   <div class="row">

      <!--  table area -->
      <div class="col-sm-12">
         <div class="panel panel-default thumbnail">
            <!-- <div class="panel-heading no-print">
         </div> -->
            <div class="panel-body">
               <?php if (!empty($departments)) { ?>
                  <?php $sl = 1; ?>
                  <?php foreach ($departments as $dep) { ?>
                     <div class="panel-heading no-print">
                        <div class=" text-center">
                           <?php
                           $departments = $this->tickets_model->read_by_id($dep->id);
                           $department = $departments[0];

                           //print_r($department);
                           ?>
                           <h3>Ticket ID: IPDT-<?php echo $department->id; ?></h3>
                        </div>
                     </div>
                     <div class="col-md-8">
                        <div class="panel-body">
                           <table class=" table table-striped table-bordered dataTable no-footer dtr-inline ">
                              <tr>
                                 <td colspan="2" style="background:#ccc;"><b>Patient Details</b></td>
                              </tr>
                              <tr>
                                 <td><b>Name and PID</b></td>
                                 <td>
                                    <b><?php echo $department->patinet->name; ?> (<a href="<?php echo base_url('report/ip_patient_feedback'); ?>?patientid=<?php echo  $department->patinet->patient_id; ?>"><?php echo  $department->patinet->patient_id; ?></a>)
                                 </td>
                              </tr>
                              <tr>
                                 <td>Overall Rating</td>
                                 <td>
                                    <?php echo $department->feedback->overallScore; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Ward</td>
                                 <td>
                                    <?php echo $department->patinet->ward; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="2" style="background:#ccc;"><b>Ticket Details</b></td>
                              </tr>
                              <tr>
                                 <td>Department</td>
                                 <td>
                                    <?php echo $department->department->description; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Parameter</td>
                                 <td>
                                    <?php echo $department->department->name; ?>
                                 </td>
                              </tr>

                              <tr>
                                 <td>Rating</td>
                                 <td>
                                    <?php echo $department->ratingt; ?>
                                 </td>
                              </tr>
                              <tr style="display:none;">
                                 <td>Comment</td>
                                 <td>
                                    <?php //echo $department->feedback->suggestionText; 
                                    ?>

                                    <?php if ($department->department->description == 'Admission Experience') { ?>
                                       <p class="inbox-item-text">
                                          <?php echo $department->feedback->admissionComment; ?></p>

                                    <?php } ?>
                                    <?php if ($department->department->description == 'Billing & Discharge Process') { ?>
                                       <p class="inbox-item-text"><?php echo $department->feedback->billingComment; ?></p>

                                    <?php } ?>
                                    <?php if ($department->department->description == 'Diagnostic & Ancillary Services') { ?>
                                       <p class="inbox-item-text"><?php echo $department->feedback->diagnosticComment; ?></p>

                                    <?php } ?>
                                    <?php if ($department->department->description == 'Dietary Services') { ?>
                                       <p class="inbox-item-text"><?php echo $department->feedback->dietaryComment; ?></p>

                                    <?php } ?>
                                    <?php if ($department->department->description == 'DOCTORS Experience') { ?>
                                       <p class="inbox-item-text"><?php echo $department->feedback->doctorComment; ?></p>

                                    <?php } ?>
                                    <?php if ($department->department->description == 'In Room Experience') { ?>
                                       <p class="inbox-item-text"><?php echo $department->feedback->inRoomComment; ?></p>

                                    <?php } ?>
                                    <?php if ($department->department->description == 'NURSING Experience') { ?>
                                       <p class="inbox-item-text"><?php echo $department->feedback->nursingComment; ?></p>

                                    <?php } ?>
                                    <?php if ($department->department->description == 'Security Experience') { ?>
                                       <p class="inbox-item-text"> <?php echo $department->feedback->securityComment; ?></p>

                                    <?php } ?>
                                 </td>
                              </tr>
                              <?php foreach ($department->replymessage as $r) { ?>
                                 <?php if ($r->corrective != NULL) { ?>
                                    <tr>
                                       <td><b>Corrective Actions</b></td>
                                       <td>
                                          <b><?php echo $r->corrective; ?></b>
                                       </td>
                                    </tr>
                                 <?php } ?>
                                 <?php if ($r->preventive != NULL) { ?>
                                    <tr>
                                       <td><b>Preventive Actions</b></td>
                                       <td>
                                          <b><?php echo $r->preventive; ?></b>
                                       </td>
                                    </tr>
                                 <?php } ?>
                              <?php } ?>
                           </table>
                        </div>
                     </div>
                     <div class="col-md-4" style="height:400px; overflow:auto;">
                        <div class="panel-body">
                           <table class=" table table-striped table-bordered dataTable no-footer dtr-inline ">
                              <tr>
                                 <td colspan="2" style="background:#ccc;"><b>Status</b></td>
                              </tr>
                              <tr>
                                 <td>Created on</td>
                                 <td>
                                    <?php echo date('g:i a, d-M-Y', strtotime($department->created_on)); ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Closed on</td>
                                 <td>
                                    <?php echo date('g:i a, d-M-Y', strtotime($department->last_modified)); ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Closed by</td>
                                 <td>
                                    <?php echo $department->replymessage[0]->message; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td>TAT <a href="javascript:void()" data-toggle="tooltip" title="Turn Arround Time"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a>
                                 </td>
                                 <td>
                                    <?php
                                    $createdOn = strtotime($department->created_on);
                                    $lastModified = strtotime($department->last_modified);
                                    $timeDifferenceInSeconds = $lastModified - $createdOn;
                                    if ($timeDifferenceInSeconds <= 60) {
                                       $timeDifferenceInMins =   round($timeDifferenceInSeconds / (60));
                                       $value = round($timeDifferenceInMins) . ' Minutes';
                                    } else {
                                       $timeDifferenceInHours =  $timeDifferenceInSeconds / (60 * 60);
                                       $value = round($timeDifferenceInHours) . ' Hours';
                                    }
                                    echo $value;
                                    ?>
                                 </td>
                              </tr>
                           </table>
                        </div>
                     </div>
                  <?php } ?>

               <?php } else { ?>
                  <h3 style="text-align: center; color:tomato;">No Records Found!</h3>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>