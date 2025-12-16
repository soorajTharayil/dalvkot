<br>
<div class="content">
   <div class="row">

      <?php
      $y = date('Y');
      $fdate = date('Y-m-d', time());
      $tdate = date('Y-m-d', strtotime('-90 days'));

      if (isset($_GET['fdate']) && isset($_GET['tdate'])) {
         $fdate = $_GET['fdate'];
         $tdate = $_GET['tdate'];
      }
      $this->db->select('ticketsop.*');
      $this->db->from('ticketsop');

      $this->db->join('bf_outfeedback', 'ticketsop.feedbackid = bf_outfeedback.id', 'inner');
      $this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');
      if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
         $this->db->where('bf_opatients.ward', $_SESSION['ward']);
      }
      $fdate = date('Y-m-d', strtotime($fdate) + 2 * 3600 * 12);
      $tdate = date('Y-m-d', strtotime($tdate) - 2 * 3600 * 12);
      $this->db->where('ticketsop.last_modified <=', $fdate);
      $this->db->where('ticketsop.last_modified >=', $tdate);
      $this->db->where('ticketsop.status', 'Closed');
      $this->db->order_by('last_modified', 'desc');
      $query = $this->db->get();
      $departments = $query->result();
      //print_r($departments); exit;
      ?>


      <!--  table area -->
      <div class="col-sm-12">
         <div class="panel panel-default thumbnail">
            <?php if (!empty($departments)) { ?>
               <div class="panel-body">

                  <?php $sl = 1; ?>
                  <?php foreach ($departments as $dep) { ?>
                     <div class="panel-heading no-print">
                        <div class=" text-center">

                           <?php
                           //print_r($dep->id);
                           $departments = $this->ticketsop_model->read_by_id($dep->id);
                           $department = $departments[0];

                           //print_r($department);
                           ?>
                           <h3>Ticket ID: FMSOP-<?php echo $department->id; ?></h3>
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
                                    <b><?php echo $department->patinet->name; ?> (
                                       <?php echo $department->patinet->patient_id; ?>) </b>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Overall Rating</td>
                                 <td>
                                    <?php echo $department->feedback->overallScore; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Speciality</td>
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
                              <tr>
                                 <td>Comment</td>
                                 <td>
                                    <?php if ($department->department->description == 'Reception & Registration Experience') { ?>
                                       <p class="inbox-item-text">
                                          <?php echo $department->feedback->reception; ?></p>

                                    <?php } ?>
                                    <?php if ($department->department->description == 'Doctors Experience') { ?>
                                       <p class="inbox-item-text"><?php echo $department->feedback->registration; ?></p>

                                    <?php } ?>
                                    <?php if ($department->department->description == 'Nursing Experience') { ?>
                                       <p class="inbox-item-text"><?php echo $department->feedback->nursingComment; ?></p>

                                    <?php } ?>
                                    <?php if ($department->department->description == 'Diagnostic & Ancillary Services') { ?>
                                       <p class="inbox-item-text"><?php echo $department->feedback->diagnostic; ?></p>

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
                                    <?php echo date('d, M Y H:i', strtotime($department->created_on)); ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Closed on</td>
                                 <td>
                                    <?php echo date('d, M Y H:i', strtotime($department->last_modified)); ?>
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

                     <div class="row" style="    height: 20px;    width: 100%;    overflow: hidden;    border-top: 1px solid #ccc;"></div>
                  <?php } ?>
               </div>
            <?php } else { ?>
               <div class="panel-body">
                  <h3 style="text-align: center; color:tomato;">No Records Found! <a href="javascript:void()" data-toggle="tooltip" title="No tickets are closed yet."><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
               </div>


            <?php }     ?>
         </div>
      </div>
   </div>

</div>