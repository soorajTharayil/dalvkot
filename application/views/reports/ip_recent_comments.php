<!-- content -->
<div class="content">
	<!-- alert message -->
	<!-- content -->


	<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
	<script src="<?php echo base_url(); ?>assets/utils.js"></script>


	<!-- PHP Code {-->

	<?php
	$dates = get_from_to_date();
	$fdate = $dates['fdate'];
	$tdate = $dates['tdate'];
	$pagetitle = $dates['pagetitle'];
	$fdate = date('Y-m-d', strtotime($fdate));
	$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
	$days = $dates['days'];

	$this->db->select('bf_feedback.*,bf_patients.name as pname,bf_patients.patient_id as pid,bf_patients.mobile as pmobile,bf_patients.email as pemail');
	$this->db->from('bf_feedback');
	$this->db->join('bf_patients', 'bf_patients.patient_id = bf_feedback.patientid', 'inner');
	if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
		$this->db->where('bf_patients.ward', $_SESSION['ward']);
	}
	$this->db->where('bf_feedback.datet <=', $fdate);
	$this->db->where('bf_feedback.datet >=', $tdate);
	$this->db->order_by('datetime', 'desc');
	$query = $this->db->get();
	$feedbacktaken = $query->result();

	$this->db->order_by('id');
	$query = $this->db->get('setup');
	$sresult = $query->result();
	$setarray = array();
	foreach ($sresult as $r) {
		$setarray[$r->type] = $r->title;
	}
	?>




	<div class="row">
		<!-- Total Product Sales area -->

		<div class="col-lg-12">
			<div class="panel panel-default">


				<div class="panel-heading">
					<h3>Recent Comments <a href="javascript:void()" data-toggle="tooltip" title="This section displays the list of recent comments given by the patients for the selected period."><i class="fa fa-question-circle" aria-hidden="true"></i></a></h3>
					<a data-toggle="tooltip" title="Click here to download the list of patient's recent comments given by the patients for the selected period" target="_blank" href="<?php echo base_url(); ?>exportreport/explortopcomment?fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>" style="float:right;margin:0px 10px; margin-top:-30px;"><img src="<?php echo base_url(); ?>assets/icon/download.png" style="float: right;
               width: 32px;
               cursor: pointer;"></a>
				</div>
				<div class="panel-body" style="    height: 455px;     overflow: auto;">
					<div class="message_inner">
						<?php
						foreach ($feedbacktaken as $r) {
							$param = json_decode($r->dataset);
							if (($param->suggestionText != '' && $param->suggestionText != NULL) || count($param->comment) > 0) {
						?>

								<a href="javascript:return false;">
									<div class="inbox-item">
										<strong class="inbox-item-author"><?php echo $r->pname; ?> (<a href="<?php echo base_url('report/ip_patient_feedback?patientid=' . $r->pid); ?>"><?php echo $r->pid; ?></a>) </strong>
										<?php $this->db->where('patient_id', $r->pid);
										$query = $this->db->get('bf_patients');
										$patient = $query->result();
										//print_r($patient); 
										?>
										<p class="inbox-item-text">
											<?php echo $patient[0]->ward;
											if ($param->bedno != '') {
												echo '(' . $param->bedno . ')';
											}
											?></p>
										<span class="inbox-item-date"></span>
										<?php if ($param->suggestionText != '' && $param->suggestionText != NULL) { ?>
											<p class="inbox-item-text"><b>General comment</b>: <?php echo $param->suggestionText; ?></p>
										<?php } ?>
										<?php foreach ($param->comment as $key => $value) {
											if ($value != '') {
										?>
												<p class="inbox-item-text"><b><?php echo $setarray[$key]; ?></b>: <?php echo $value; ?></p>
										<?php
											}
										}
										?>

									</div>
								</a>

							<?php	} ?>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<!-- /.row -->
	</div>
	<!-- /.row -->

</div>
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