<div class="content">
	<!-- alert message -->
	<!-- content -->

	<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
	<script src="<?php echo base_url(); ?>assets/utils.js"></script>

	<?php
	$fdate = date('Y-m-d', strtotime('+1 days'));
	$tdate = date('Y-m-d', strtotime('-120 days'));
	$this->db->order_by('datetime', 'desc');
	$this->db->where('bf_feedback_service.datet <=', $fdate);
	$this->db->where('bf_feedback_service.datet >=', $tdate);
	$this->db->order_by('datetime', 'desc');
	$query = $this->db->get('bf_feedback_service');
	$resultpse = $query->result();

	$this->db->where('discharged_date', '0');
	$query = $this->db->get('bf_patients_service');
	if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
		$this->db->where('bf_patients_service.ward', $_SESSION['ward']);
	}
	$resultp = $query->result();

	$this->db->order_by('id');
	$query = $this->db->get('setup_service');
	$sresult = $query->result();
	$setarray = array();
	$questioarray = array();
	foreach ($sresult as $r) {
		$setarray[$r->type] = $r->title;
	}

	foreach ($sresult as $r) {
		$questioarray[$r->type][$r->shortkey] = $r->shortname;
	}

	?>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Recent Comments <a href="javascript:void()" data-toggle="tooltip" title="This section displays the list of recent comments given by the patients for the selected period."><i class="fa fa-question-circle" aria-hidden="true"></i></a></h3>
					<a data-toggle="tooltip" title="Click here to download the list of patient's recent comments given by the patients for the selected period" target="_blank" href="<?php echo base_url(); ?>exportreportop/explortopcomment?fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>" style="float:right;margin:0px 10px; margin-top:-30px;"><img src="<?php echo base_url(); ?>assets/icon/download.png" style="float: right;
               width: 32px;
               cursor: pointer;"></a>
				</div>
				<div class="panel-body" style="    height: 455px;     overflow: auto;">
					<div class="message_inner">
						<?php
						foreach ($resultpse as $r) {
							$param = json_decode($r->dataset);
							// print_r($param);
							// exit;						
						?>

							<a href="javascript:return false;">
								<div class="inbox-item">
									<strong class="inbox-item-author"><?php echo $param->name; ?> (<a href="<?php echo base_url('report/patient_request_details?patientid=' . $r->patientid); ?>"><?php echo $r->patientid; ?></a>) </strong>
									<?php $this->db->where('patient_id', $r->patientid);
									      $query = $this->db->get('bf_patients_service');
										  $patient = $query->result();
										?>
									<p class="inbox-item-text"><?php echo $patient[0]->ward;
																if ($param->bedno != '') {
																	echo '(' . $param->bedno . ')';
																}
																?></p>
									<?php foreach ($param->parameter->question as $key => $value) {
										if ($value->valuetext == 1) {
									?>
											<p class="inbox-item-text"><b><?php echo $setarray[$value->type]; ?></b>: <?php echo $value->question; ?></p>
									<?php
										}
									}
									?>
									<?php if ($param->other != '' && $param->other != NULL) { ?>
										<p class="inbox-item-text"><b>General comment</b>: <?php echo $param->other; ?></p>
									<?php } ?>
								</div>
							</a>


						<?php } ?>
					</div>
				</div>
			</div>


			<!-- /.row -->
		</div>
		<!-- /.row -->

	</div>
</div>
<style>
	.panel-body {
		height: 531px;
	}
</style>

<style>
	.progress {
		margin-bottom: 10px;
	}
</style>