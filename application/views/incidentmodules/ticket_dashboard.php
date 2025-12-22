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
				<a data-toggle="tooltip" title="Click here to download category wise incident report" target="_blank"
					href="<?php echo $int_download_department_excel; ?>" style="float:right;margin:0px 0px;"><img
						src="<?php echo base_url(); ?>assets/icon/department.png" style="float: right;
			   width: 32px;
			   cursor: pointer;"></a>
				<a data-toggle="tooltip" title="Click here to download incidents wise report" target="_blank"
					href="<?php echo $int_download_comments_excel; ?>" style="float:right;margin:0px 10px;"><img
						src="<?php echo base_url(); ?>assets/icon/download.png" style="float: right;
			   width: 32px;
			   cursor: pointer;">
				</a>
				<a data-toggle="tooltip" title="Download overall incident report in pdf format" target="_blank"
					href="<?php echo $int_download_overall_pdf; ?>" style="float:right;margin:0px 10px;"><img
						src="<?php echo base_url(); ?>assets/icon/pdfdownload.png" style="float: right;
			   width: 32px;
			   color: 	#62c52d;
			   cursor: pointer;"></a>
				<span style="float:right;margin:5px 10px;">
					<h4><strong><?php echo lang_loader('inc', 'inc_downloads'); ?></strong></h4>
				</span>

			</div>
			<br>
		</div>

		<!-- </span> -->

		<!-- Close Download Buttons-->
		<!-- Metric Boxes-->
		<?php if (ismodule_active('INCIDENT') === true && isfeature_active('TOTAL-INCIDENTS') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $inc_department['alltickets']; ?></span> <span
									class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('inc', 'inc_total_incidents'); ?> <a
									href="javascript:void()" data-toggle="tooltip"
									title="<?php echo $totaltickect_tooltip; ?>"><i class="fa fa-info-circle"
										aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-ticket"></i>
							</div>
							<a href="<?php echo $int_link_alltickets; ?>"
								style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('INCIDENT') === true && isfeature_active('OPEN-INCIDENTS') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $inc_department['opentickets']; ?></span> <span
									class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('inc', 'inc_open_incidents'); ?> <a
									href="javascript:void()" data-toggle="tooltip"
									title="<?php echo $opentickect_tooltip; ?>"><i class="fa fa-info-circle"
										aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-envelope-open-o"></i>
							</div>
							<a href="<?php echo $int_link_opentickets; ?>"
								style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('INCIDENT') === true && isfeature_active('DESCRIBING-INCIDENTS') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $inc_department['addressedtickets']; ?></span> <span
									class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small">Described Incidents <a
									href="javascript:void()" data-toggle="tooltip"
									title="<?php echo $opentickect_tooltip; ?>"><i class="fa fa-info-circle"
										aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-reply"></i>
							</div>
							<a href="<?php echo $int_link_addressedtickets; ?>"
								style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (ismodule_active('INCIDENT') === true && isfeature_active('IN-REJECTED-INCIDENTS') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $inc_department['rejecttickets']; ?></span> <span
									class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small">Rejected incident <a href="javascript:void()" data-toggle="tooltip"
									title="<?php echo $addressedtickect_tooltip; ?>"><i class="fa fa-info-circle"
										aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-reply"></i>
							</div>
							<a href="<?php echo $int_link_rejecttickets; ?>"
								style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('INCIDENT') === true && isfeature_active('CLOSED-INCIDENTS') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $inc_department['closedticket']; ?></span> <span
									class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('inc', 'inc_closed_incidents'); ?> <a
									href="javascript:void()" data-toggle="tooltip"
									title="<?php echo $closetickect_tooltip; ?>"><i class="fa fa-info-circle"
										aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-check-circle-o"></i>
							</div>
							<a href="<?php echo $int_link_closedtickets; ?>"
								style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('INCIDENT') === true && isfeature_active('INCIDENTS-DASHBOARD') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $ticket_resolution_rate; ?></span>% <span
									class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('inc', 'inc_incidents_resolution_rate'); ?> <a
									href="javascript:void()" data-toggle="tooltip"
									title="<?php echo $ticketresolutionrate_info_tooltip; ?>"><i class="fa fa-info-circle"
										aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-clock-o"></i>
							</div>
						</div>
						<a href="<?php echo $ip_link_ticket_resolution_rate; ?>"
							style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>

					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('INCIDENT') === true && isfeature_active('INCIDENTS-DASHBOARD') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><?php echo $ticket_close_rate; ?>&nbsp;<span class="slight"><i
										class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('inc', 'inc_average_resolution_time'); ?> <a
									href="javascript:void()" data-toggle="tooltip"
									title="<?php echo $averageresolutiontime_info_tooltip; ?>"><i class="fa fa-info-circle"
										aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-calendar-check-o"></i>
							</div>
						</div>
						<a href="<?php echo $ip_link_average_resolution_time; ?>"
							style="float: right;    margin-top: -9px;"><?php echo lang_loader('inc', 'inc_view_list'); ?></a>

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
						<h4><?php echo lang_loader('inc', 'inc_key_takeaways'); ?> <a href="javascript:void()"
								data-placement="bottom" data-toggle="tooltip"
								title="This section will give you a complete understanding of the performance of every parameters and department over the selected period of time."><i
									class="fa fa-info-circle" aria-hidden="true"></i></a></h4>
					</div>
					<div class="p-l-30 p-r-30">
						<div class="panel-body" style="height: 150px; display:inline;">
							<div class="alert alert-warning">
								<span style="font-size: 15px">
								You have received the most incidents in <strong><?php echo $highest_complain; ?></strong>
								</span>
							</div>
							<div class="alert alert-success ">
								<span style="font-size: 15px">
									<?php echo lang_loader('inc', 'inc_you_have_received_least_incidents_in'); ?>
									<strong><?php echo $lowest_complain; ?></strong>
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
	$all_feedback = $this->incident_model->patient_and_feedback($table_patients, $table_feedback, $desc, $setup);
	$sresulte = $this->incident_model->setup_result($setup);
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
					<div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">

						<h3> <?php echo lang_loader('inc', 'inc_incident_received_by_category'); ?><a
								href="javascript:void()" data-placement="bottom" data-toggle="tooltip"
								title="<?php echo $ticketrecived_tooltip; ?>"><i class="fa fa-info-circle"
									aria-hidden="true"></i></a></h3>
						<div style="display: flex; align-items: center; gap: 8px;">

							<div class="btn-group">
								<button type="button" style="background: #62c52d; border: none; width: 170px;"
									class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
									aria-expanded="false">
									<span id="selectedDepartment">Filter by Department</span>
									<i class="fa fa-angle-down" aria-hidden="true"></i>
								</button>
								<ul class="dropdown-menu" style="text-align: left; width: 100%;">
									<?php
									$this->db->order_by('title');
									$this->db->group_by('title');
									$query = $this->db->get('setup_incident');
									$ward = $query->result();

									// echo '<pre>';
									// print_r($ward);
									// echo '<pre>';
									// exit;
									
									foreach ($ward as $rw) {
										if ($rw->title) {

											echo '<li><a class="dropdown-item" href="javascript:void(0)" onclick="tickets_recived_by_department_set(\'' . $rw->type . '\',\'' . $rw->title . '\')">' . $rw->title . ' </a></li>';
											echo '<div class="dropdown-divider"></div>';
										} else {
											echo '<li><a class="dropdown-item" href="javascript:void(0)" onclick="tickets_recived_by_department_set(\'' . $rw->type . '\',\'' . $rw->title . '\')">' . $rw->title . '</a></li>';
										}
									}
									?>
								</ul>
							</div>
							<div class="btn-group" style="margin: 0px 0px 0px 0px;">
								<a onclick="location.reload()" class="btn btn-primary"
									style="background: #8791a4; border: none;">
									Reset
									<i class="fa fa-repeat" aria-hidden="true" style="margin-right:0px;"></i>
								</a>
							</div>
						</div>
						<div>
							<span style="margin-right: 10px;">
								<i data-placement="bottom" class="fa fa-file-pdf-o"
									style="font-size: 20px; color: red; cursor: pointer;"
									onclick="printChart_tickets_recived_by_department()" data-toggle="tooltip"
									title="Download Chart as PDF"></i>
							</span>
							<span>
								<i data-placement="bottom" class="fa fa-file-image-o"
									style="font-size: 20px; color: green; cursor: pointer;"
									onclick="downloadChartImage_tickets_recived_by_department()" data-toggle="tooltip"
									title="Download Chart as Image"></i>
							</span>
						</div>
					</div>
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
					<h3><?php echo lang_loader('inc', 'inc_recent_incidents'); ?> <a href="javascript:void()"
							data-placement="bottom" data-toggle="tooltip"
							title="<?php echo $recentpatientticket_tooltip; ?>"><i class="fa fa-info-circle"
								aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="   height: 460px;      overflow: auto;">
					<div class="message_inner">

						<?php $a = $this->ticketsincidents_model->alltickets();
						$ticket_data = $a;

						$this->db->select("*");
						$this->db->from($setup);
						// $this->db->where('parent', 0);
						$query = $this->db->get();
						$reasons = $query->result();
						foreach ($reasons as $row) {
							$keys[$row->shortkey] = $row->shortkey;
							$res[$row->shortkey] = $row->shortname;
							$titles[$row->shortkey] = $row->title;
							$dep[$row->title] = $row->title;
						}


						foreach ($ticket_data as $ticketdata) {
							?>
							<a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
								<div class="inbox-item">
									<p class="inbox-item-author">
										<?php echo 'INC-' . $ticketdata->id ?>
										<span style="float: right;font-size:10px;"><?php
										echo date('g:i A, d-m-y', strtotime($ticketdata->created_on)); ?></span>
									</p>

									<p class="inbox-item-text">
										<i class="fa fa-user-plus"></i> <?php echo $ticketdata->feed->name; ?> (<span
											style="color:#62c52d;"><?php echo $ticketdata->feed->patientid; ?></span>), from
										<?php
										if ($ticketdata->feed->bedno) {
											echo $ticketdata->feed->bedno;
											echo ' in ';
										}
										?>
										<?php echo $ticketdata->feed->ward . '.'; ?>
									</p>
									<p class="inbox-item-text">
										<i class="fa fa-ticket"></i><b>
											<?php echo $ticketdata->department->description; ?></b>
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
													<?php } ?>
												<?php } ?>
											<?php } ?>
										</p>
									<?php } ?>

									<?php if ($ticketdata->feed->comment == true) { ?>

										<?php
										foreach ($ticketdata->feed->comment as $key => $value) { ?>
											<p class="inbox-item-text" style="overflow: clip; word-break: break-all;">

												<?php
												if (strlen($value) > 60) {
													$value = substr($value, 0, 60) . '  ' . ' ...';
												} ?>
												<?php if ($value) { ?>
													<i class="fa fa-comment-o"></i> <?php echo lang_loader('inc', 'inc_description'); ?>
													:
													"<?php echo $value; ?>"
												<?php } ?>

											</p>
										<?php } ?>
									<?php } ?>



									<p class="inbox-item-text" style="font-size:10px;">
										<?php if ($ticketdata->status == 'Closed') { ?>
											<span style="color:  #198754;font-weight: bold; display: inline-block;"><i
													class="fa fa-circle" aria-hidden="true"></i></span>
											<?php echo 'Closed'; ?>
										<?php } ?>
										<?php if ($ticketdata->status == 'Addressed') { ?>
											<span style="color:  #f0ad4e;font-weight: bold; display: inline-block;"><i
													class="fa fa-circle" aria-hidden="true"></i></span>
											<?php echo 'Addressed'; ?>
										<?php } ?>
										<?php if ($ticketdata->status == 'Open' || $ticketdata->status == 'Reopen' || $ticketdata->status == 'Transfered') { ?>
											<span style="color: #d9534f;font-weight: bold; display: inline-block;"><i
													class="fa fa-circle" aria-hidden="true"></i></span>
											<?php echo 'Open'; ?>
										<?php } ?>

										<?php
										echo date('g:i A, d-m-y', strtotime($ticketdata->last_modified)); ?>
									</p>
								</div>
							</a>
						<?php } ?>
						<?php ?>
					</div>
				</div>
				<div style="padding: 20px;    background: #f5f5f5;"><a
						href="<?php echo base_url($this->uri->segment(1)); ?>/alltickets"
						style="float: right;    margin-top: -9px;">View All</a></div>
			</div>

		</div>
		<!-- /.row -->
	</div>

	<!-- Close Why choose the hospital and patient comments -->


	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="<?php echo base_url(); ?>assets/efeedor_incidents_chart.js"></script>
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
<script>
	function printChart_tickets_recived_by_department() {
		const canvas = document.getElementById('tickets_recived_by_department');
		const dataUrl = canvas.toDataURL(); // Get image data of canvas
		const windowContent = `
		<html>
		<head>
			<title>Print Chart</title>
			<style>
				body {
					text-align: center;
					margin: 0;
					padding: 20px;
					font-family: Arial;
				}
				img {
					max-width: 100%;
					height: auto;
				}
			</style>
		</head>
		<body>
			<h3>Tickets Received By Department</h3>
			<img src="${dataUrl}" alt="Chart">
		</body>
		</html>
	`;

		const printWin = window.open('', '', 'width=800,height=600');
		printWin.document.open();
		printWin.document.write(windowContent);
		printWin.document.close();
		printWin.focus();

		setTimeout(() => {
			printWin.print();
			printWin.close();
		}, 500);
	}
</script>
<script>
	function downloadChartImage_tickets_recived_by_department() {
		const canvas = document.getElementById('tickets_recived_by_department');
		const image = canvas.toDataURL('image/png'); // Convert canvas to image data

		// Create a temporary link element
		const link = document.createElement('a');
		link.href = image;
		link.download = 'tickets_recived_by_department.png'; // Name of downloaded file
		link.click(); // Trigger download
	}
</script>