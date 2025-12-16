<div class="content">

	<div class="row">
		<!-- alert message -->
		<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
		<script src="<?php echo base_url(); ?>assets/utils.js"></script>
		<!-- content -->

		<?php

		$dates = get_from_to_date();
		$fdate = $dates['fdate'];
		$tdate = $dates['tdate'];
		$pagetitle = $dates['pagetitle'];
		$fdate = date('Y-m-d', strtotime($fdate));
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$days = $dates['days'];
		$all_feedback = $this->efeedor_model->get_feedback('bf_patients', 'bf_feedback', $fdatet, $tdate);
		$all_tickets = $this->efeedor_model->get_tickets('bf_patients', 'tickets', $fdatet, $tdate);
		$unsatisfied_patients_count = $this->efeedor_model->get_unsatisfied_count($all_feedback, $all_tickets);
		$PSAT = $this->efeedor_model->PSAT($all_feedback, $all_tickets);
		$NPS = $this->efeedor_model->NPS($all_feedback);
		$ticket_resolution_rate = $this->efeedor_model->ticket_resolution_rate($all_tickets);
		$ticket_close_rate = $this->efeedor_model->ticket_close_rate($all_tickets);
		$sresult = $this->efeedor_model->setup_result('setup');

		$feedbacktaken = $all_feedback;

		?>


		<!-- Total Product Sales area -->

		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>All Responses</h3>
					<a href="<?php echo base_url(); ?>exportreport/expormainip?fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>" target="_blank" style="float: right;    margin-top: -15px;">Export List</a>
				</div>
				<div class="panel-body">

						<table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<th>Sl.No</th>
							
								<th>Feedback ID</th>
								<th>Patient Details</th>
								<th>Average Rating</th>
								<th>PSAT</th>
								<th>NPS</th>
								<th>General Comments</th>
								<th>Date</th>
							</thead>
							<tbody>
								<?php $sl = 1; ?>
								<?php foreach ($feedbacktaken as $r) {
									$param = json_decode($r->dataset);
									$id = $r->id;
									$tickets = $all_tickets;


									$check = true;
									foreach ($tickets as $t) {
										if ($t->feedbackid == $r->id && $check == true) {
											$check = false;
											$psat = 'Unsatisfied';
										}
									}
									if ($check == true) {

										$psat = 'Satisfied';
									}

								?>
									<?php if ($param->recommend1Score > 4) {
										$nps = "Promoter";
									} elseif ($param->recommend1Score < 3.5) {
										$nps = "Detractor";
									} else {
										$nps = "Passive";
									} ?>
									<tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC"
												?>">
										<td><?php echo $sl; ?></td>
										<td>IPDF-<?php echo $id; ?></td>
										<td><?php echo $param->name; ?>
											(<a href="<?php echo base_url('report/ip_patient_feedback?patientid=' . $param->patientid); ?>"><?php echo $param->patientid; ?></a>) <br>
											<?php echo 'from '.$param->ward; ?>
											<?php if ($param->bedno != '-') { ?>
												<?php echo 'in ' . $param->bedno; ?>
											<?php } ?>
										
										<td style="width: 5px;"> <?php if ($param->overallScore != 0) {
													echo $param->overallScore;
												} ?></td>
										<td><?php echo $psat; ?></td>
										<td><?php echo $nps; ?></td>
										<td> <?php if ($param->suggestionText != '' && $param->suggestionText != NULL) {
													echo $param->suggestionText;
												} else {
													echo '-';
												} ?></td>
										<td><?php echo date('g:i a, d-M-Y', strtotime($r->datetime)); ?></td>

									</tr>
									<?php $sl++; ?>
								<?php } ?>
							</tbody>
						</table>
		

				</div>
			</div>
			<!-- /.row -->
		</div>
		<!-- /.row -->

	</div>
</div>

<style>
	.panel-body {
		height: auto;
	}
</style>

<style>
	.progress {
		margin-bottom: 10px;
	}
</style>