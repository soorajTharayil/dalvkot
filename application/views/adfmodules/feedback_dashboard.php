<!--Code updates: 
Worked on UI allignment, fixed all the issues.
Last updated on 05-03-23 -->



<!-- content -->
<div class="content">
	<!-- alert message -->
	<!-- content -->
	<!-- PHP Code {-->
	<?php
	include 'info_buttons_ip.php';
	require 'ip_table_variables.php';

	?>
	<!-- } PHP Code -->


	<!-- Download Buttons-->

	<!-- <span class="download_option" style="display: none; position:relative;" id="showdownload"> -->
	<div class="row" style="position: relative;display: none;" id="showdownload">
		<div class="p-l-30 p-r-30" style="float:right;margin-bottom: 20px;">
			<a data-toggle="tooltip" title="Click here to download department wise patient feedback report" target="_blank" href="<?php echo $ip_download_department_excel; ?>" style="float:right;margin:0px 0px;"><img src="<?php echo base_url(); ?>assets/icon/department.png" style="float: right;
			   width: 32px;
			   cursor: pointer;"></a>
			<a data-toggle="tooltip" title="Download Discharge Inpatient Feedbacks Patient Wise Report" target="_blank" href="<?php echo $ip_download_patient_excel; ?>" style="float:right;margin:0px 10px;"><img src="<?php echo base_url(); ?>assets/icon/hospital.png" style="float: right;
			   width: 32px;
			   cursor: pointer;"></a>
			<a data-toggle="tooltip" title="Download Discharge Inpatient Overall Feedbacks Report in excel format" target="_blank" href="<?php echo $ip_download_overall_excel; ?>" style="float:right;margin:0px 10px;"><img src="<?php echo base_url(); ?>assets/icon/download.png" style="float: right;
			   width: 32px;
			   cursor: pointer;"></a>
			<a data-toggle="tooltip" title="Download Discharge Inpatient Overall Feedbacks Report in pdf format" target="_blank" href="<?php echo $ip_download_overall_pdf; ?>" style="float:right;margin:0px 10px;"><img src="<?php echo base_url(); ?>assets/icon/pdfdownload.png" style="float: right;
			   width: 32px;
			   color: 	#62c52d;
			   cursor: pointer;"></a>
			<span style="float:right;margin:5px 10px;">
				<h4><strong><?php echo lang_loader('adf', 'adf_downloads'); ?></strong></h4>
			</span>

		</div>
		<br>
	</div>

	<!-- </span> -->

	<!-- Close Download Buttons-->
	<!-- Metric Boxes-->
	<div class="row">
		<?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-FEEDBACK-REPORTS') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number">
									<?php echo count($ip_feedbacks_count); ?>
								</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
									</i></span></h2>
							<div class="small"><?php echo lang_loader('adf', 'adf_total_feedbacks'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totalfeedback_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-comments-o"></i>
							</div>
							<a href="<?php echo $ip_link_feedback_report; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf', 'adf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-PSAT') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number">
									<?php echo $ip_psat['satisfied_count']; ?>
								</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
									</i></span></h2>
							<div class="small"><?php echo lang_loader('adf', 'adf_psat_satisfied'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $satisfiedpatients_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-smile-o"></i>
							</div>
							<a href="<?php echo $ip_link_satisfied_list; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf', 'adf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-PSAT') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number">
									<?php echo $ip_psat['unsatisfied_count']; ?>
								</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
									</i></span></h2>
							<div class="small"><?php echo lang_loader('adf', 'adf_unsatisfied_patients'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $unsatisfiedpatients_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-frown-o"></i>
							</div>
							<a href="<?php echo $ip_link_unsatisfied_list; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf', 'adf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_tickets_tool; ?>">
						<div class="statistic-box">
							<h2><span class="count-number">
									<?php echo count($ip_tickets_count); ?>
								</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
									</i></span></h2>
							<div class="small"><?php echo lang_loader('adf', 'adf_total_tickets'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickets_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-ticket"></i>
							</div>
							<a href="<?php echo $ip_link_ticket_dashboard; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf', 'adf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-PSAT') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_psat_tool; ?>">
						<div class="statistic-box">
							<h2><span class="count-number">
									<?php echo $ip_psat['psat_score']; ?>
								</span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
									</i></span></h2>
							<div class="small"><?php echo lang_loader('adf', 'adf_psat'); ?> <a href="javascript:void()" data-toggle="tooltip" data-placement="bottom" title="<?php echo $psat_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-star-half-o"></i>
							</div>
							<a href="<?php echo $ip_link_psat_page; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf', 'adf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-NPS') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_nps_tool; ?>">
						<div class="statistic-box">
							<h2><span class="count-number">
									<?php echo $ip_nps['nps_score']; ?>
								</span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
									</i></span></h2>
							<div class="small"><?php echo lang_loader('adf', 'adf_nps'); ?> <a href="javascript:void()" data-toggle="tooltip" data-placement="bottom" title="<?php echo $nps_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-tachometer"></i>
							</div>
							<a href="<?php echo $ip_link_nps_page; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf', 'adf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $ticket_resolution_rate; ?></span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('adf', 'adf_ticket_resolution_rate'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $ticketresolutionrate_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-clock-o"></i>
							</div>
						</div>
						<a href="<?php echo $ip_link_ticket_resolution_rate; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf', 'adf_view_list'); ?></a>

					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('ADF') === true  && isfeature_active('ADF-TICKETS-DASHBOARD') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><?php echo $ticket_close_rate; ?>&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('adf', 'adf_avg_resolution_time'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $averageresolutiontime_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-calendar-check-o"></i>
							</div>
						</div>
						<a href="<?php echo $ip_link_average_resolution_time; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf', 'adf_view_list'); ?></a>

					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<!-- Close Metric Boxes-->
	<?php



	?>



	<?php if (count($ip_feedbacks_count) > 5) {
	?>
		<!-- Key Highlights -->
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow:hidden;">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4><?php echo lang_loader('adf', 'adf_key_takeaways'); ?><a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="Key takeaway section will showcase key points to be learned from the patient experience data."><i class="fa fa-info-circle" aria-hidden="true"></i></a></h4>
					</div>
					<div class="p-l-30 p-r-30">
						<div class="panel-body" style="height: 150px; display:inline;">
							<div class="alert alert-success">
								<span style="font-size: 15px">
									<?php echo lang_loader('adf', 'adf_your'); ?> <strong><?php echo $key_highlights['best_param']; ?></strong><?php echo lang_loader('adf', 'adf_received_the_highest_satisfaction_rating'); ?>
								</span>
							</div>
							<div class="alert alert-warning ">
								<span style="font-size: 15px">
									<?php echo lang_loader('adf', 'adf_your'); ?> <strong><?php echo $key_highlights['lowest_param']; ?></strong> <?php echo lang_loader('adf', 'adf_has_to_be_improved'); ?>

								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Close Key Highlights -->
	<?php } ?>



	<div class="row">
		<!-- Total Product Sales area -->

		<div class="col-lg-12 col-sm-12 col-md-12" style="overflow:auto;">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('adf', 'adf_patient_feedbacks_analysis'); ?> <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="<?php echo $patientfeedbackanalysis_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="height:510px;" id="bar">
					<div class="message_inner bar_chart">
						<canvas id="patient_feedback_analysis"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Satisfaction and NPS charts -->
	<div class="row">
		<!-- Total Product Sales area -->
		<div class="col-lg-6 col-sm-12 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('adf', 'adf_patient_satisfaction_analysis'); ?> <a href="javascript:void()" data-toggle="tooltip" data-placement="bottom" title="<?php echo $patientsatisficationanalysis_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="  height:270px;" id="line">
					<div class="message_inner line_chart">
						<canvas id="patient_satisfaction_analysis"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-sm-12 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('adf', 'adf_netpromoter_analysis'); ?> <a href="javascript:void()" data-toggle="tooltip" data-placement="bottom" title="<?php echo $netpromoteranalysis_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="  height:270px;" id="line">
					<div class="message_inner line_chart">
						<canvas id="net_permoter_analysis"></canvas>
					</div>
				</div>
			</div>
		</div>
		<!-- /.row -->
	</div>
	<!-- Close Satisfaction and NPS charts -->

	<?php
	$all_feedback = $this->admissionfeedback_model->patient_and_feedback($table_patients, $table_feedback, $desc, $setup);
	$sresulte = $this->admissionfeedback_model->setup_result($setup);
	foreach ($sresulte as $r2) {
		$setarray[$r2->type] = $r2->title;
	}
	$all_tickets = $this->admissionfeedback_model->get_tickets($table_feedback, $table_tickets);
	$feedbacktaken = $this->admissionfeedback_model->patient_and_feedback($table_patients, $table_feedback, $desc);
	?>

	<!-- Ticket Pie chart & Tickets -->
	<div class="row">
		<!-- Total Product Sales area -->
		<div class="col-lg-7 col-sm-12 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('adf', 'adf_tickets_received_by_department'); ?> <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="<?php echo $ticketrecived_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="height: 495px;" id="pie_donut">
					<div class="message_inner chart-container">
						<canvas id="tickets_recived_by_department"></canvas>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-5">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('adf', 'adf_recent_patient_feedbacks'); ?> <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="<?php echo $recentpatientfeedback_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="   height: 460px;      overflow: auto;">
					<div class="message_inner">
						<strong>
							<?php foreach ($feedbacktaken as $row) {
								$detail = json_decode($row->dataset);
								$check = true;
								foreach ($all_tickets as $t) {
									if ($t->feedbackid == $row->id && $check == true) {
										$check = false;
										$psat = 'Unhappy feedback submitted by, ';
										$emoji = '<i class="fa fa-frown-o" aria-hidden="true"></i>';
									}
								}
								if ($check == true) {
									$psat = 'Happy feedback submitted by, ';
									$emoji = '<i class="fa fa-smile-o" aria-hidden="true"></i>';
								}
							?>
								<div class="inbox-item">
									<a href="<?php echo base_url($this->uri->segment(1)); ?>/patient_feedback?id=<?php echo $row->id; ?>">
										<p class="inbox-item-text">
											<?php echo $psat; ?>
											<?php echo $detail->name; ?> (<span style="color:#62c52d;"><?php echo $detail->patientid; ?></span>)
										</p>
										<p class="inbox-item-text">
											From
											<?php
											if ($detail->bedno != '' && $detail->bedno != '-') {
												echo $detail->bedno;
												echo ' in ';
											}
											?>
											<?php echo $detail->ward . '.'; ?> at
											<?php //echo date('g:i A, d-m-y', strtotime($row->datetime)); 
											?>
											<?php if ($detail->datetime) { ?>
												<?php echo date('g:i A', date(($detail->datetime) / 1000)); ?>

												<?php echo date('d-m-y', date(($detail->datetime) / 1000)); ?>
											<?php } ?>

										</p>
									</a>
								</div>

							<?php
							} ?>
						</strong>
					</div>
				</div>
				<div style="padding: 20px;    background: #f5f5f5;"><a href="<?php echo base_url($this->uri->segment(1)); ?>/notifications" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf', 'adf_view_all'); ?></a></div>
			</div>
			<!-- /.row -->
		</div>
	</div>
	<!-- Close Ticket Pie chart & Tickets -->




	<!-- Why choose the hospital and patient comments -->
	<div class="row">
		<!-- Total Product Sales area -->
		<div class="col-lg-7 col-sm-12 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('adf', 'adf_hospital_selection_analysis'); ?> <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="<?php echo $hospitalselectionanalysis_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>

				</div>
				<div class="panel-body" style="height: 495px;" id="pie_donut">
					<div class="message_inner chart-container">
						<canvas id="why_patient_choose"></canvas>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-5">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('adf', 'adf_recent_patient_comments'); ?> <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="<?php echo $recentpatientcomment_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="   height: 460px;      overflow: auto;">
					<div class="message_inner">
						<?php foreach ($all_feedback as $r) {
							$param = json_decode($r->dataset);
							$comment = $param->comment;
							$comment_check = array_filter($comment);
							// print_r($comment);
							// exit;
							$message = 0;
							if ($param->comment && !empty($param->comment)) {

								foreach ($param->comment as $key2 => $value) {
									if (!empty($value)) {
										$message++;
									}
								}
							}
							//  print_r($message);
							//  exit;
							if (!empty($param->suggestionText) || !empty($message > 0)) {
						?>
								<a href="<?php echo base_url($this->uri->segment(1)); ?>/patient_feedback?id=<?php echo $r->id; ?>">
									<div class="inbox-item">
										<p class="inbox-item-author">
											<?php echo htmlspecialchars($param->name); ?> (<span style="color:#62c52d;"><?php echo htmlspecialchars($param->patientid); ?></span>)
										</p>
										<p class="inbox-item-text">From
											<?php
											if ($param->bedno != '' && $param->bedno != '-') {
												echo htmlspecialchars($param->bedno) . ' in ';
											}
											echo htmlspecialchars($param->ward) . '.';
											?>
										</p>

										<?php foreach ($param->comment as $key => $value) {
											if (!empty($value)) {
										?>
												<p class="inbox-item-text" style="overflow: clip; word-break: break-all;"><i class="fa fa-frown-o" aria-hidden="true"></i>&nbsp;<b><?php echo htmlspecialchars($setarray[$key]); ?>:</b>
													"<?php
														if (strlen($value) > 60) {
															$value = substr($value, 0, 60) . ' ...';
														}
														echo htmlspecialchars($value);
														?>"
												</p>
										<?php
											}
										}
										?>

										<?php if (!empty($param->suggestionText)) { ?>
											<p class="inbox-item-text" style="overflow: clip; word-break: break-all;"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;<b><?php echo lang_loader('adf', 'adf_comment'); ?>:</b>:
												"<?php
													if (strlen($param->suggestionText) > 60) {
														$param->suggestionText = substr($param->suggestionText, 0, 60) . ' ...';
													}
													echo htmlspecialchars($param->suggestionText);
													?>"
											</p>
										<?php
										} ?>
										<small>
											<p class="inbox-item-text">
												<?php if (!empty($param->datetime)) { ?>
													<?php echo date('g:i A, d-m-y', $param->datetime / 1000); ?>
												<?php } ?>
											</p>
										</small>
									</div>
								</a>
						<?php
							}
						} ?>
					</div>

				</div>
				<div style="padding: 20px;    background: #f5f5f5;"><a href="<?php echo base_url($this->uri->segment(1)); ?>/comments" style="float: right;    margin-top: -9px;"><?php echo lang_loader('adf', 'adf_view_all'); ?></a></div>
			</div>

		</div>
		<!-- /.row -->
	</div>

	<!-- Close Why choose the hospital and patient comments -->


	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="<?php echo base_url(); ?>assets/efeedor_adf_chart.js"></script>
</div>

<style>
	.chart-container {
		justify-content: center;
		/* Align the chart horizontally in the center */
		align-items: center;
		/* Align the chart vertically in the center */
		width: 460px !important;
		margin: 0px auto;
		height: 450px;
		width: 200px;
	}


	.progress {
		margin-bottom: 10px;
	}

	.mybarlength {
		text-align: right;
		margin-right: 18px;
		font-weight: bold;
	}

	.panel-body {
		height: 531px;
	}

	.bar_chart {
		justify-content: center;
		/* Align the chart horizontally in the center */
		align-items: center;
		/* Align the chart vertically in the center */
		/* width: 460px !important; */
		margin: 0px auto;
		height: 500px;
		width: 1024px;
	}


	.line_chart {
		justify-content: center;
		/* Align the chart horizontally in the center */
		align-items: center;
		/* Align the chart vertically in the center */
		/* width: 460px !important; */
		margin: 0px auto;
		height: 270px;
		width: 200px;
	}

	@media screen and (max-width: 1024px) {
		#pie_donut {
			overflow-x: scroll;
		}

		#bar {
			overflow-x: scroll;
		}

		#line {
			overflow-x: scroll;
			overflow-y: scroll;
		}
	}
</style>