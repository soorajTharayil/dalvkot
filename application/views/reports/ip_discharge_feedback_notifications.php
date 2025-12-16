<div class="content">
	<!-- alert message -->
	<!-- content -->
	<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
	<script src="<?php echo base_url(); ?>assets/utils.js"></script>

	<?php
	$fdate = date('Y-m-d', strtotime('+1 days'));
	$tdate = date('Y-m-d', strtotime('-120 days'));
	$this->db->order_by('datetime', 'desc');
	$this->db->where('bf_feedback.datet <=', $fdate);
	$this->db->where('bf_feedback.datet >=', $tdate);
	$this->db->order_by('datetime', 'desc');
	$query = $this->db->get('bf_feedback');
	$resultpse = $query->result();

	$this->db->where('discharged_date', '0');
	$query = $this->db->get('bf_patients');
	$resultp = $query->result();

	?>

	<div class="row">
		<div class="col-lg-12">
			<!-- Main content -->
			<div class="panel panel-default">
				<div class="panel-body" style=" height: 493px;   overflow: auto;">
					<?php if ($resultpse) { ?>

						<?php foreach ($resultpse as $row) {
							$detail = json_decode($row->dataset); ?>
							<ul class="menu">
								<li>
									<?php
									$this->db->where('patient_id', $row->patientid);
									$this->db->order_by('id', 'desc');
									$query = $this->db->get('bf_patients');
									$rowps = $query->result();
									$rowp = $rowps[0];
									?>
									<h4>
										<?php echo $detail->name; ?> (<a href="<?php echo base_url('report/ip_patient_feedback'); ?>?patientid=<?php echo $rowp->patient_id; ?>"><?php echo $rowp->patient_id; ?></a>)
									</h4>
									<p> Feedback taken at <?php echo date('g:i a', strtotime($row->datetime)); ?> on <?php echo date('F j, Y', strtotime($row->datetime)); ?> in <?php echo $rowp->ward; ?></p>

								</li> <!-- inner menu: contains the actual data -->
							</ul>
						<?php	}  ?>
					<?php	} else { ?>
						<h3 style="text-align: center; color:tomato;">No Notifiations</h3>
					<?php	} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.content-wrapper -->