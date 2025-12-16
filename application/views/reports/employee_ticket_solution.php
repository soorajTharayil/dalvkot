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
      $this->db->select('ticketsemployees.*');
      $this->db->from('ticketsemployees');

      $this->db->join('bf_feedbackemployees', 'ticketsemployees.feedbackid = bf_feedbackemployees.id', 'inner');
      $this->db->join('bf_employees', 'bf_employees.patient_id = bf_feedbackemployees.patientid', 'inner');
      if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
         $this->db->where('bf_employees.ward', $_SESSION['ward']);
      }
      $fdate = date('Y-m-d', strtotime($fdate) + 2 * 3600 * 12);
      $tdate = date('Y-m-d', strtotime($tdate) - 2 * 3600 * 12);
      $this->db->where('ticketsemployees.last_modified <=', $fdate);
      $this->db->where('ticketsemployees.last_modified >=', $tdate);
      $this->db->where('ticketsemployees.status', 'Closed');
      $this->db->order_by('last_modified', 'desc');
      $query = $this->db->get();
      $departments = $query->result();
      //print_r($departments); exit;
      ?>


      <!--  table area -->
      <div class="col-sm-12">
         <div class="panel panel-default thumbnail">

            <div class="panel-body">
               <?php if (!empty($departments)) { ?>
                  <?php $sl = 1; ?>
                  <?php foreach ($departments as $dep) { ?>
                     <div class="panel-heading no-print">
                        <div class=" text-center">

                           <?php
                           //print_r($dep->id);
                           $departments = $this->ticketsempex_model->read_by_id($dep->id);
                           $department = $departments[0];

                           //print_r($department);
                           ?>
                           <h3>Ticket ID: EMPXP-<?php echo $department->id; ?></h3>
                        </div>
                     </div>
                     <div class="col-md-8">
                        <div class="panel-body">
                           <table class=" table table-striped table-bordered dataTable no-footer dtr-inline ">
                              <tr>
                                 <td colspan="2" style="background:#ccc;"><b>Employee Details</b></td>
                              </tr>
                              <tr>
                                 <td><b>Name and ID</b></td>
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
                                 <td>Role</td>
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
                              <tr style="display: none;">
                                 <td>Comment</td>
                                 <td>
                                    <?php if ($param['suggestionText'] != '' && $param['suggestionText'] != NULL) { ?>
                                       <p class="inbox-item-text">
                                          <?php echo $param['suggestionText']; ?></p>

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


                           </table>
                        </div>
                     </div>
                     <div class="row" style="    height: 20px;    width: 100%;    overflow: hidden;    border-top: 1px solid #ccc;"></div>
                  <?php } ?>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Search by date Range</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form>
               <div class="modal-body">

                  <table style="width:100%">
                     <tr>
                        <td>
                           From Date<br />
                           <input type="text" name="tdate" class="form-control datepicker" required>
                        </td>
                        <td>
                           to Date<br />
                           <input type="text" name="fdate" class="form-control datepicker" required>
                        </td>
                     </tr>
                  </table>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Search</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>