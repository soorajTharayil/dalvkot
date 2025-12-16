<div class="content">
	<!-- alert message -->
	<!-- content -->


	<!-- PHP Code {-->
	<?php
	include 'info_buttons_int.php';
	$dates = get_from_to_date();
	$pagetitle = $dates['pagetitle'];
	$fdate = $dates['fdate'];
	$tdate = $dates['tdate'];
	$pagetitle = $dates['pagetitle'];
	$fdate = date('Y-m-d', strtotime($fdate));
	$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
	$days = $dates['days'];

	/* START TABLES FROM DATABASE */
	$table_feedback_int = 'bf_feedback_int';
	$table_patients = 'bf_patients';
	$sorttime = 'asc';
	$setup_int = 'setup_int';
	$asc = 'asc';
	$desc = 'desc';
	$table_tickets_int = 'tickets_int';
	$open = 'Open';
	$closed = 'Closed';
	$addressed = 'Addressed';
	/* END TABLES FROM DATABASE */

	/* pc_model.php FOR GLOBAL UPDATES */

	// For count of total feedbacks and for charts only.
	$all_feedback = $this->pc_model->patient_and_feedback($table_patients, $table_feedback_int, $sorttime, $setup_int);



	$interim_tickets_count = $this->pc_model->feedback_and_ticket($table_feedback_int, $table_tickets_int, $sorttime);

	$open_tickets_int = $this->pc_model->tickets_feeds($table_feedback_int, $table_tickets_int, $sorttime, $open);
	$closed_tickets_int = $this->pc_model->tickets_feeds($table_feedback_int, $table_tickets_int, $sorttime, $closed);
	$addressed_tickets_int = $this->pc_model->tickets_feeds($table_feedback_int, $table_tickets_int, $sorttime, $addressed);
	$interim_tickets_tool = "Open: " . count($open_tickets_int) . ', ' . "Closed: " . count($closed_tickets_int) . ', ' . "Addressed: " . count($addressed_tickets_int);

	if (($all_feedback)) {
	?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">

					<div class="panel-body" style="   height: 493px;      overflow: auto;">
						<div class="message_inner">
							<?php
							foreach ($all_feedback as $r) {
								$param = json_decode($r->dataset);

								if (($param->other != '' && $param->other != NULL)) { ?>
									<!-- <a href="javascript:return false;"> -->
									<div class="inbox-item">
										<p class="inbox-item-author">
											<?php echo $param->name; ?> (<a href="<?php echo base_url('report/patient_complaint_details?patientid=' . $r->patientid); ?>"><?php echo $param->patientid; ?></a>)
										</p>

										<p class="inbox-item-text">From
											<?php
											if ($param->bedno != '' && $param->bedno != '-') {
												echo $param->bedno;
												echo ' in ';
											}
											?>
											<?php echo $param->ward . '.'; ?>
										</p>
										<?php if ($param->suggestionText != '' && $param->suggestionText != NULL) { ?>
											<p class="inbox-item-text"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;<b><?php echo lang_loader('pcf','pcf_other_comment'); ?></b>:
												<?php echo $param->suggestionText; ?>
											</p>
										<?php
										} ?>
										<?php
										//foreach ($param->other as $key => $value) {
										if ($param->other != '') { ?>
											<p class="inbox-item-text"><i class="fa fa-frown-o" aria-hidden="true"></i>&nbsp;<b>
													<?php //echo $param; 
													?>
													<!-- </b>: -->
													<?php echo $param->other; ?>
											</p>
										<?php
										}
										// }

										?>
										<p class="inbox-item-text">

											<?php
											echo date('g:i A, d-m-y', strtotime($r->datetime)); ?>

										</p>


									</div>
									<!-- </a> -->

								<?php
								} ?>
							<?php
							} ?>
						</div>
					</div>
					<div style="padding: 20px;    background: #f5f5f5;"><a href="<?php //echo base_url('report/ip_recent_comments'); 
																					?>?fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>" style="float: right;    margin-top: -9px;"></a></div>
				</div>
				<!-- /.row -->
			</div>
		</div>
	<?php } else {   ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('pcf','pcf_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>
</div>
<!-- /.content-wrapper -->