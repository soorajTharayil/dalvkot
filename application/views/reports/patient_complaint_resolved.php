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
   $this->db->select('tickets_int.*');
   $this->db->from('tickets_int');

   $this->db->join('bf_feedback_int', 'tickets_int.feedbackid = bf_feedback_int.id', 'inner');
   $this->db->join('bf_patients_int', 'bf_patients_int.patient_id = bf_feedback_int.patientid', 'inner');
   if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
      //$this->db->where('bf_patients_int.ward',$_SESSION['ward']);
   }
   $fdate = date('Y-m-d', strtotime($fdate) + 2 * 3600 * 12);
   $tdate = date('Y-m-d', strtotime($tdate) - 2 * 3600 * 12);
   $this->db->where('tickets_int.last_modified <=', $fdate);
   $this->db->where('tickets_int.last_modified >=', $tdate);
   $this->db->where('tickets_int.status', 'Closed');
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
                           $departments = $this->ticketsint_model->read_by_id($dep->id);
                           $department = $departments[0];

                           // print_r($department);
                           ?>
                           <h3>Ticket ID: PC-<?php echo $department->id; ?></h3>
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
                                    <b><?php echo $department->feedback->name; ?> (<a href="<?php echo base_url('report/patient_complaint_details'); ?>?patientid=<?php echo  $department->feedback->patientid; ?>"><?php echo  $department->feedback->patientid; ?></a>)
                                 </td>
                              </tr>
                              <tr>
                                 <td>Ward</td>
                                 <td>
                                    <?php  echo $department->feedback->ward; ?>
                                 </td>
                              </tr>
                              <?php if ($department->feedback->bed_no != '' && $department->feedback->bed_no != NULL) { ?>
                                 <tr>
                                    <td>Bed No.</td>
                                    <td>
                                       <?php echo $department->feedback->bed_no; ?>
                                    </td>
                                 </tr>
                              <?php } ?>
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
</div>