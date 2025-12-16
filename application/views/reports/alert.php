	<?php
							$query = $this->db->get('bf_nursing_notes');
							$resultpse = $query->result();

						?>
						<?php
							$this->db->where('discharged_date','0');
							$query = $this->db->get('bf_patients');
							$resultp = $query->result();

							?>
  <!-- Content Wrapper. Contains page content -->
         <div class="contentdevnotification-wrapper">
            <!-- Content Header (Page header) -->

			   <!-- Main content -->
            <section class="contentdev">
               <!-- Small boxes (Stat box) -->
               <div class="row">
			   <?php $mydate = date('Y-m-d'); ?>
						<?php $hour = date('H');
							if($hour < 12){
								$mydate = date('Y-m-d', strtotime('-1 day', strtotime($mydate)));
								$shift = 3;
							}else if($hour < 18){
								$shift = 1;
							}else if($hour < 23){
								$shift = 2;
							}
						?>
                  <div class="col-lg-8 col-xs-12">
            <ul style="margin:0px; padding:0px;">


                              <!-- inner menu: contains the actual data -->

							   <?php $mycount = 0; for($i=0; $i<9; $i++){ ?>
							   <?php if($shift == 0){
									$shift = 3;
									$mydate = date('Y-m-d', strtotime('-1 day', strtotime($mydate)));
							    } ?>
								 <?php foreach($resultp as $row){ ?>
								<?php
								$datecom =  date('Y-m-d',strtotime($row->created_on));
								if(strtotime($datecom) <= strtotime($mydate)){
								$query = 'SELECT * FROM bf_nursing_handover where shiftValue = "Shift'.$shift.'" AND datet="'.$mydate.'" AND patientid="'.$row->patient_id.'"';
								$resultss = $this->db->query($query);
								$resultpq = $resultss->result();

								if(count($resultpq) == 0){

$mycount++;
								?>

                                 <li style="    background: #fff;
    padding: 20px;
    list-style: none;
    margin: 2px;">
                                    <a href="#">
                                    <p> Handover missed for  <?php print_r($row->name); ?> PID : <?php print_r($row->patient_id); ?><br /> for <?php echo 'Shift'.$shift; ?> (<?php echo date('d/m/Y',strtotime($mydate)); ?>)
                                  </p>  </a>
                                 </li>
							   <?php } ?>
							   <?php } ?>
							   <?php } ?>

                                 <?php
									$shift--;
								 } ?>


                        </ul>
                     </li>
         </div>
         </div>
         </div>
         </section>
         <!-- /.content-wrapper -->
