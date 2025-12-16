<?php
        $fdate = date('Y-m-d', strtotime('+1 days'));
        $tdate = date('Y-m-d', strtotime('-120 days'));
        $this->db->order_by('datetime', 'desc');
        $this->db->where('bf_feedback_int.datet <=', $fdate);
        $this->db->where('bf_feedback_int.datet >=', $tdate);
        $this->db->order_by('datetime', 'desc');
        $query = $this->db->get('bf_feedback_int');
        $resultpse = $query->result();
   
        $this->db->where('discharged_date', '0');
        $query = $this->db->get('bf_patients_int');
        $resultp = $query->result();
        ?>


	 <!-- Content Wrapper. Contains page content -->
	 <div class="content">
	     <!-- Content Header (Page header) -->

	     <!-- Main content -->
	     <section class="">
	         <!-- Small boxes (Stat box) -->
	         <div class="row">
	             <div class="col-lg-8 col-xs-12">
	                 <ul style="padding:0px;">
	                     <li>
	                         <!-- inner menu: contains the actual data -->
	                         <ul class="menu">
	                             <?php foreach ($resultpse as $row) { ?>
	                                 <li>

	                                     <h4>
	                                         <?php
                                                $this->db->where('patient_id', $row->patientid);
                                                $this->db->order_by('id', 'desc');
                                                $query = $this->db->get('bf_patients_int');
                                                $rowps = $query->result();
                                                $rowp = $rowps[0];

                                                ?>
	                                         <?php echo $rowp->name; ?> (<a href="<?php echo base_url('report/patient_complaint_details'); ?>?patientid=<?php echo $rowp->patient_id; ?>"><?php echo $rowp->patient_id; ?></a>)

	                                     </h4>
	                                     <p>Feedback taken by "<?php echo $rown->name; ?>" at <?php echo date('g:i a', strtotime($row->datetime)); ?> on <?php echo date('F j, Y', strtotime($row->datetime)); ?></p>

	                                 </li>
	                             <?php } ?>


	                         </ul>
	                     </li>
	                 </ul>
	             </div>
	         </div>
	     </section>
	 </div>
	 <!-- /.content-wrapper -->