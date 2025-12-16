<!--Code updates: 
Worked on UI allignment, fixed all the issues.
Last updated on 05-03-23 -->

<div class="content">
	<div class="row">
		<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
		<script src="<?php echo base_url(); ?>assets/utils.js"></script>

		<!-- PHP Code {-->
		<?php
		include 'info_buttons_int.php';
		require 'pc_table_variables.php';

		if ($minDepartment && $maxDepartment != null) {
			$lowest_complain = $minDepartment;
			$highest_complain = $maxDepartment;
		} else {
			$lowest_complain = '-';
			$highest_complain = '-';
		}

		?>
		<!--}  PHP Code -->

		<!-- Download Buttons-->

		<!-- <span class="download_option" style="display: none; position:relative;" id="showdownload"> -->
		<div class="row" style="position: relative;display: none;" id="showdownload">
			<div class="p-l-30 p-r-30" style="float:right;margin-bottom: 20px;">
				<a data-toggle="tooltip" title="Click here to download category wise requests report" target="_blank" href="<?php echo  $int_download_department_excel; ?>" style="float:right;margin:0px 0px;"><img src="<?php echo base_url(); ?>assets/icon/department.png" style="float: right;
               width: 32px;
               cursor: pointer;"></a>
				<a data-toggle="tooltip" title="Click here to download staff service requests report" target="_blank" href="<?php echo $int_download_comments_excel; ?>" style="float:right;margin:0px 10px;"><img src="<?php echo base_url(); ?>assets/icon/download.png" style="float: right;
               width: 32px;
               cursor: pointer;">
				</a>
				<a data-toggle="tooltip" title="Download overall internal service request report in pdf format?" target="_blank" href="<?php echo $int_download_overall_pdf; ?>" style="float:right;margin:0px 10px;"><img src="<?php echo base_url(); ?>assets/icon/pdfdownload.png" style="float: right;
			   width: 32px;
			   color: 	#62c52d;
			   cursor: pointer;"></a>
				<span style="float:right;margin:5px 10px;">
					<h4><strong><?php echo lang_loader('isr', 'isr_downloads'); ?></strong></h4>
				</span>

			</div>
			<br>
		</div>

		<!-- </span> -->

		<!-- Close Download Buttons-->
		<!-- Metric Boxes-->

		<?php if (ismodule_active('ISR') === true  && isfeature_active('TOTAL-REQUESTS') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $isr_department['alltickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('isr', 'isr_total_requests'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-ticket"></i>
							</div>
							<a href="<?php echo $int_link_alltickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('isr', 'isr_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('ISR') === true  && isfeature_active('OPEN-REQUESTS') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $isr_department['opentickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('isr', 'isr_open_requets'); ?><a href="javascript:void()" data-toggle="tooltip" title="<?php echo $opentickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-envelope-open-o"></i>
							</div>
							<a href="<?php echo $int_link_opentickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('isr', 'isr_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('ISR') === true  && isfeature_active('ADDRESSED-REQUESTS') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $isr_department['rejecttickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small">Addressed request <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $addressedtickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-reply"></i>
							</div>
							<a href="<?php echo $int_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('ISR') === true  && isfeature_active('ISR-ASSIGNED-REQUEST') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $isr_department['assignedtickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small">Assigned request <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $addressedtickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-reply"></i>
							</div>
							<a href="<?php echo $int_link_assignedtickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('ISR') === true  && isfeature_active('CLOSED-REQUESTS') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $isr_department['closedticket']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('isr', 'isr_closed_requests'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $closetickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-check-circle-o"></i>
							</div>
							<a href="<?php echo $int_link_closedtickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('isr', 'isr_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('ISR') === true  && isfeature_active('REQUESTS-DASHBOARD') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $ticket_resolution_rate; ?></span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('isr', 'isr_requests_resolution_rate'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $ticketresolutionrate_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-clock-o"></i>
							</div>
						</div>
						<a href="<?php echo $ip_link_ticket_resolution_rate; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('isr', 'isr_view_list'); ?></a>

					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (ismodule_active('ISR') === true  && isfeature_active('REQUESTS-DASHBOARD') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><?php echo $ticket_close_rate; ?>&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('isr', 'isr_average_resolution_time'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $averageresolutiontime_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-calendar-check-o"></i>
							</div>
						</div>
						<a href="<?php echo $ip_link_average_resolution_time; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('isr', 'isr_view_list'); ?></a>

					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<!-- Close Metric Boxes-->
	<?php if (count($int_tickets_count) > 5 && $highest_complain != $lowest_complain) { ?>
		<!-- Key Highlights -->
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow:hidden;">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4><?php echo lang_loader('isr', 'isr_key_takeaways'); ?> <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="This section will give you a complete understanding of the performance of every parameters and department over the selected period of time."><i class="fa fa-info-circle" aria-hidden="true"></i></a></h4>
					</div>
					<div class="p-l-30 p-r-30">
						<div class="panel-body" style="height: 150px; display:inline;">
							<div class="alert alert-warning">
								<span style="font-size: 15px">
									<?php echo lang_loader('isr', 'isr_you_have_received_most_requests_in'); ?><strong><?php echo $highest_complain; ?></strong>
								</span>
							</div>
							<div class="alert alert-success ">
								<span style="font-size: 15px">
									<?php echo lang_loader('isr', 'isr_you_have_received_least_requests_in'); ?> <strong><?php echo $lowest_complain; ?></strong>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Close Key Highlights -->
	<?php } ?>

	<?php
	$all_feedback = $this->isr_model->patient_and_feedback($table_patients, $table_feedback, $desc, $setup);
	$sresulte = $this->isr_model->setup_result($setup);
	foreach ($sresulte as $r2) {
		$setarray[$r2->type] = $r2->title;
		$question[$r2->shortkey] = $r2->shortname;
		$ticketin[$r2->shortkey] = $r2->title;
	}

	?>



	<div class="row">
		<!-- Total Product Sales area -->
		<div class="col-lg-7 col-sm-12 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo lang_loader('isr', 'isr_request_received_by_category'); ?> <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="<?php echo $ticketrecived_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
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
					<h3><?php echo lang_loader('isr', 'isr_recent_requests'); ?><a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="<?php echo $recentpatientticket_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="   height: 460px;      overflow: auto;">
					<div class="message_inner">

						<?php $a = $this->ticketsesr_model->alltickets();
						$ticket_data = $a;

						$this->db->select("*");
						$this->db->from($setup);
						// $this->db->where('parent', 0);
						$query = $this->db->get();
						$reasons  = $query->result();
						foreach ($reasons as $row) {
							$keys[$row->shortkey] = $row->shortkey;
							$res[$row->shortkey] = $row->shortname;
							$titles[$row->shortkey] = $row->title;
							$dep[$row->title] = $row->title;
							// print_r($row);
						}


						foreach ($ticket_data as $ticketdata) {
							// print_r($ticketdata);
						?>
							<a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
								<div class="inbox-item">
									<p class="inbox-item-author">
										<?php echo 'ISR-' . $ticketdata->id ?>
										<span style="float: right;font-size:10px;"><?php
																					echo date('g:i A, d-m-y', strtotime($ticketdata->created_on)); ?></span>
									</p>
									<p class="inbox-item-text">
										<?php


										if ($ticketdata->feed->priority == 'Medium') {
											//warning
											$color = '#f0ad4e';
										}
										if ($ticketdata->feed->priority == 'High') {
											//danger
											$color = '#d9534f';
										}
										if ($ticketdata->feed->priority == 'Low') {
											//info
											$color = '#5bc0de';
										}

										?>
										<span style="color: <?php echo $color; ?>;">
											<?php echo $ticketdata->feed->priority; ?>
										</span>
									</p>
									<p class="inbox-item-text">
										<i class="fa fa-user-plus"></i> <?php echo $ticketdata->feed->name; ?> (<span style="color:#62c52d;"><?php echo $ticketdata->feed->patientid; ?></span>), from
										<?php


										if ($ticketdata->feed->bedno) {
											echo $ticketdata->feed->bedno;
											echo ' in ';
										}
										?>
										<?php echo $ticketdata->feed->ward . '.'; ?>
									</p>
									<p class="inbox-item-text">
										<i class="fa fa-ticket"></i><b> <?php echo $ticketdata->department->description; ?></b>
									</p>

									<?php if ($ticketdata->feed->reason == true) { ?>
										<p class="inbox-item-text">
											<?php
											foreach ($ticketdata->feed->reason as $key => $value) {
												if ($titles[$key] == $ticketdata->department->description) {
													if (in_array($key, $keys)) { ?>
														<i class="fa fa-frown-o" aria-hidden="true"></i>
														<?php echo $res[$key]; ?>
														<br>
													<?php 	} ?>
												<?php 	} ?>
											<?php 	} ?>
										</p>
									<?php 	} ?>

									<?php if ($ticketdata->feed->comment == true) { ?>

										<?php
										foreach ($ticketdata->feed->comment as $key => $value) { ?>
											<p class="inbox-item-text" style="overflow: clip; word-break: break-all;">

												<?php
												if (strlen($value) > 60) {
													$value = substr($value, 0, 60) . '  ' . ' ...';
												} ?>
												<?php if ($value) { ?>
													<i class="fa fa-comment-o"></i> <?php echo lang_loader('isr', 'isr_description'); ?> :
													"<?php echo $value; ?>"
												<?php 	} ?>

											</p>
										<?php 	} ?>
									<?php 	} ?>



									<p class="inbox-item-text" style="font-size:10px;">
										<?php if ($ticketdata->status == 'Closed') { ?>
											<span style="color:  #198754;font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
											<?php echo 'Closed'; ?>
										<?php } ?>
										<?php if ($ticketdata->status == 'Addressed') { ?>
											<span style="color:  #f0ad4e;font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
											<?php echo 'Addressed'; ?>
										<?php } ?>
										<?php if ($ticketdata->status == 'Open' || $ticketdata->status == 'Reopen' || $ticketdata->status == 'Transfered') { ?>
											<span style="color: #d9534f;font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
											<?php echo 'Open'; ?>
										<?php }  ?>

										<?php
										echo date('g:i A, d-m-y', strtotime($ticketdata->last_modified)); ?>
									</p>
								</div>
							</a>
						<?php } ?>
						<?php  ?>
					</div>
				</div>
				<div style="padding: 20px;    background: #f5f5f5;"><a href="<?php echo base_url($this->uri->segment(1)); ?>/alltickets" style="float: right;    margin-top: -9px;"><?php echo lang_loader('isr', 'isr_view_all'); ?></a></div>
			</div>

		</div>
		<!-- /.row -->
	</div>

	<!-- Close Why choose the hospital and patient comments -->


	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="<?php echo base_url(); ?>assets/efeedor_esr_chart.js"></script>
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