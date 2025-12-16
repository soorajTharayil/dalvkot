<!--Code updates: 
Worked on UI allignment, fixed all the issues.
Last updated on 05-03-23 -->

<?php


$dates = get_from_to_date();
$fdate = $dates['fdate'];
$tdate = $dates['tdate'];
$pagetitle = $dates['pagetitle'];
$fdate = date('Y-m-d', strtotime($fdate));
$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
$days = $dates['days'];
$num_of_modules = 0;
$num_of_modules_tickets = 0;


if (ismodule_active('IP') === true) {
	require_once 'ip_tables.php';
}

if (ismodule_active('OP') === true) {
	require_once 'op_tables.php';
}
if (ismodule_active('PCF') === true) {
	require_once 'interim_tables.php';
}
if (ismodule_active('ADF') === true) {
	require_once 'adf_tables.php';
}

if (ismodule_active('ISR') === true) {
	require_once 'esr_tables.php';
}

if (ismodule_active('INCIDENT') === true) {
	require_once 'incident_tables.php';
}

if (ismodule_active('GRIEVANCE') === true) {
	require_once 'grievance_tables.php';
}

date_default_timezone_set('Asia/Kolkata');
$hour = date('H');
// echo $hour;
if ($hour < 12) {
	$greeting =  '<b>Good morning,<\/b>';
} elseif ($hour < 17) {
	$greeting = '<b>Good afternoon,<\/b> ';
} else {
	$greeting = '<b>Good evening,<\/b> ';
}



if ($pagetitle != 'Custom') {
	$welcometext = $greeting . "<br><br>Here's an overview of the key healthcare experience metrics from each module based on the data collected over the " . strtolower($pagetitle) . ". For more detailed analytics and comprehensive reports, please visit the individual dashboards.";
} else {
	$dateObjstrt = DateTime::createFromFormat('Y-m-d', $fdate);
	$enddate = $dateObjstrt->format('d-m-y');
	$dateObjend = DateTime::createFromFormat('Y-m-d', $tdate);
	$startdate = $dateObjend->format('d-m-y');
	$welcometext = $greeting . "<br><br>Here is an overview of the key healthcare experience metrics from each module for the data collected from " . $startdate . " to " . $enddate . ". For more detailed analytics and comprehensive reports, please visit the individual dashboards.";
}
// print_r($_SESSION['floorwise']);
?>

<!-- content -->
<div class="content">
	<div class="col-lg-12">
		<div style="margin-bottom: 15px;     margin-top: 10px;">

			<h4 style="font-size:18px;font-weight:normal;">
				<span class="typing-text"></span>
			</h4>
			<!-- &nbsp;&nbsp;&nbsp;&nbsp;<span class="typing-text"></span> </h4> -->
		</div>
	</div>

	<br>
	<!-- START FOR SUPERADMIN AND ADMIN -->
	<?php if ($this->session->userdata['user_role'] == 0 || $this->session->userdata['user_role'] == 2 || $this->session->userdata['user_role'] == 3) { ?>

		<!-- START ADMISSION OVERVIEW -->
		<?php if (ismodule_active('ADF') === true) {  ?>
			<?php if (ismodule_active('ADF') === true) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">

								<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of Inpatient admission feedbacks" style="color: inherit;" href="<?php echo base_url(); ?>admissionfeedback/feedback_dashboard">
									<span>
										<h3>ADMISSION FEEDBACKS </h3>
										<?php if (ismodule_active('ADF') === true) { ?><a href="<?php echo base_url(); ?>admissionfeedback/feedback_dashboard" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>
							<div class="panel-body" style="height:120px; max-height:120px;">

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($adf_feedbacks_count); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Total Feedbacks</div>
												<div class="icon">
													<i class="fa fa-comments-o"></i>
												</div>
												<a href="<?php echo $adf_link_feedback_report; ?>" style="float: right;    margin-top: -9px;">View List</a>
											</div>
										</div>
									</div>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_psat_tool; ?>">

											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $adf_psat['psat_score']; ?>
													</span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">PSAT </div>
												<div class="icon">
													<i class="fa fa-star-half-o"></i>
												</div>
												<a href="<?php echo $adf_link_psat_page; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_nps_tool; ?>">

											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $adf_nps['nps_score']; ?>
													</span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">NPS </div>
												<div class="icon">
													<i class="fa fa-tachometer"></i>
												</div>
												<a href="<?php echo $adf_link_nps_page; ?>" style="float: right;    margin-top: -9px;">View List</a>
											</div>
										</div>
									</div>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($adf_tickets_count); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Total Tickets </div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $adf_link_ticket_dashboard; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>



							</div>
							<!-- Close Metric Boxes-->
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		<!-- START ADMISSION OVERVIEW -->

		<!-- START INPATIENT OVERVIEW -->
		<?php if (ismodule_active('IP') === true) {  ?>
			<?php if (ismodule_active('IP') === true) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">
								<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of Inpatient discharge feedbacks" style="color: inherit;" href="<?php echo base_url(); ?>ipd/feedback_dashboard">
									<span>
										<h3>IP DISCHARGE FEEDBACKS </h3>
										<?php if (ismodule_active('IP') === true) { ?><a href="<?php echo base_url(); ?>ipd/feedback_dashboard" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>
							<div class="panel-body" style="height:120px; max-height:120px;">

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($ip_feedbacks_count); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Total Feedbacks</div>
												<div class="icon">
													<i class="fa fa-comments-o"></i>
												</div>
												<a href="<?php echo $ip_link_feedback_report; ?>" style="float: right;    margin-top: -9px;">View List</a>
											</div>
										</div>
									</div>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_psat_tool; ?>">

											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $ip_psat['psat_score']; ?>
													</span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">PSAT </div>
												<div class="icon">
													<i class="fa fa-star-half-o"></i>
												</div>
												<a href="<?php echo $ip_link_psat_page; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_nps_tool; ?>">

											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $ip_nps['nps_score']; ?>
													</span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">NPS </div>
												<div class="icon">
													<i class="fa fa-tachometer"></i>
												</div>
												<a href="<?php echo $ip_link_nps_page; ?>" style="float: right;    margin-top: -9px;">View List</a>
											</div>
										</div>
									</div>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($ip_tickets_count); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Total Tickets </div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $ip_link_ticket_dashboard; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Close Metric Boxes-->
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		<!-- END INPATIENT OVERVIEW -->

		<!-- START INTERIM OVERVIEW -->
		<?php if (ismodule_active('PCF') === true) { ?>
			<?php if (ismodule_active('PCF') === true) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">

								<a href="<?php echo base_url(); ?>pc/ticket_dashboard" data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of patient complaints and requests" style="color: inherit;" href="<?php echo base_url(); ?>dashboard/swithc?type=2">
									<span>
										<h3>INPATIENT COMPLAINTS</h3>
										<?php if (ismodule_active('PCF') === true) { ?><a href="<?php echo base_url(); ?>pc/ticket_dashboard" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>
							<div class="panel-body" style="height:120px; max-height:120px;">

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $interim_tickets_tool; ?>">

											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($int_tickets_count); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Total Complaints</div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $int_link_alltickets; ?>" style="float: right;    margin-top: -9px;">View List</a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $interim_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $int_allopenticket_count; ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Open Complaints </div>
												<div class="icon">
													<i class="fa fa-plus"></i>
												</div>
												<a href="<?php echo $int_link_opentickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<?php if (ticket_addressal('pc_addressal') === true) { ?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $interim_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($int_addressed_tickets); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Addressed Complaints </div>
												<div class="icon">
													<i class="fa fa-reply"></i>
												</div>
												<a href="<?php echo $int_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $interim_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($int_closed_tickets); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Closed Complaints </div>
												<div class="icon">
													<i class="fa fa-check-circle-o"></i>
												</div>
												<a href="<?php echo $int_link_closedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>

							</div>
							<!-- Close Metric Boxes-->
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		<!-- END INTERIM OVERVIEW -->

		<!-- START OUTPATIENT OVERVIEW -->
		<?php if (ismodule_active('OP') === true) { ?>
			<?php if (ismodule_active('OP') === true) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">
								<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of Outpatient feedbacks" style="color: inherit;" href="<?php echo base_url(); ?>opf/feedback_dashboard">
									<span>
										<h3>OUTPATIENT FEEDBACKS </h3>
										<?php if (ismodule_active('OP') === true) { ?><a href="<?php echo base_url(); ?>opf/feedback_dashboard" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>
							<div class="panel-body" style="height:120px; max-height:120px;">

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($op_feedbacks_count); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Total Feedbacks</div>
												<div class="icon">
													<i class="fa fa-comments-o"></i>
												</div>
												<a href="<?php echo $op_link_feedback_report; ?>" style="float: right;    margin-top: -9px;">View List</a>
											</div>
										</div>
									</div>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_psat_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $op_psat['psat_score']; ?>
													</span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">PSAT </div>
												<div class="icon">
													<i class="fa fa-star-half-o"></i>
												</div>
												<a href="<?php echo $op_link_psat_page; ?>" style="float: right;    margin-top: -9px;">View List</a>
											</div>
										</div>
									</div>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_nps_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $op_nps['nps_score']; ?>
													</span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">NPS </div>
												<div class="icon">
													<i class="fa fa-tachometer"></i>
												</div>
												<a href="<?php echo $op_link_nps_page; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($op_tickets_count); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Total Tickets </div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $op_link_ticket_dashboard; ?>" style="float: right;    margin-top: -9px;">View List</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Close Metric Boxes-->
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		<!-- END OUTPATIENT OVERVIEW -->


		<!-- START ISR OVERVIEW -->
		<?php if (ismodule_active('ISR') === true) { ?>
			<?php if (ismodule_active('ISR') === true) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">

								<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of internal service requests" style="color: inherit;" href="<?php echo base_url(); ?>isr/ticket_dashboard">
									<span>
										<h3>INTERNAL REQUESTS</h3>
										<?php if (ismodule_active('ISR') === true) { ?><a href="<?php echo base_url(); ?>isr/ticket_dashboard" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>
							<div class="panel-body" style="height:120px; max-height:120px;">

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $esr_tickets_tool; ?>">

											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $esr_department['alltickets']; ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Total Requests</div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $esr_link_alltickets; ?>" style="float: right;    margin-top: -9px;">View List</a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $esr_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $esr_department['opentickets']; ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Open Requests </div>
												<div class="icon">
													<i class="fa fa-plus"></i>
												</div>
												<a href="<?php echo $esr_link_opentickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<?php if (ticket_addressal('isr_addressal') === true) { ?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $esr_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $esr_department['addressedtickets']; ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Addressed Requests </div>
												<div class="icon">
													<i class="fa fa-reply"></i>
												</div>
												<a href="<?php echo $esr_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $esr_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $esr_department['closedtickets']; ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Closed Requests </div>
												<div class="icon">
													<i class="fa fa-check-circle-o"></i>
												</div>
												<a href="<?php echo $esr_link_closedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>

							</div>
							<!-- Close Metric Boxes-->
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		<!-- END ISR OVERVIEW -->

		<!-- START INCIDENT OVERVIEW -->
		<?php if (ismodule_active('INCIDENT') === true) { ?>
			<?php if (ismodule_active('INCIDENT') === true) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">

								<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of incidents" style="color: inherit;" href="<?php echo base_url(); ?>incident/ticket_dashboard">
									<span>
										<h3>INCIDENTS</h3>
										<?php if (ismodule_active('INCIDENT') === true) { ?><a href="<?php echo base_url(); ?>incident/ticket_dashboard" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>
							<div class="panel-body" style="height:120px; max-height:120px;">

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $incident_tickets_tool; ?>">

											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($incident_tickets_count); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Total Incidents</div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $incident_link_alltickets; ?>" style="float: right;    margin-top: -9px;">View List</a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $incident_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $incident_department['opentickets']; ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Open Incidents </div>
												<div class="icon">
													<i class="fa fa-plus"></i>
												</div>
												<a href="<?php echo $incident_link_opentickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<?php if (ticket_addressal('incident_addressal') === true) { ?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $incident_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($incident_addressed_tickets); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Addressed Incidents </div>
												<div class="icon">
													<i class="fa fa-reply"></i>
												</div>
												<a href="<?php echo $incident_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $incident_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($incident_closed_tickets); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Closed Incidents </div>
												<div class="icon">
													<i class="fa fa-check-circle-o"></i>
												</div>
												<a href="<?php echo $incident_link_closedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>

							</div>
							<!-- Close Metric Boxes-->
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		<!-- END INCIDENT OVERVIEW -->

		<!-- START grievance_page OVERVIEW -->
		<?php if (ismodule_active('GRIEVANCE') === true) { ?>
			<?php if (ismodule_active('GRIEVANCE') === true) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">

								<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of staff grievance" style="color: inherit;" href="<?php echo base_url(); ?>grievance/ticket_dashboard">
									<span>
										<h3>STAFF GRIEVANCES </h3>
										<?php if (ismodule_active('GRIEVANCE') === true) { ?><a href="<?php echo base_url(); ?>grievance/ticket_dashboard" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>
							<div class="panel-body" style="height:120px; max-height:120px;">

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $grievance_tickets_tool; ?>">

											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($grievance_tickets_count); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Total Grievances</div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $grievance_link_alltickets; ?>" style="float: right;    margin-top: -9px;">View List</a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $grievance_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $grievance_department['opentickets']; ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Open Grievances </div>
												<div class="icon">
													<i class="fa fa-plus"></i>
												</div>
												<a href="<?php echo $grievance_link_opentickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<?php if (ticket_addressal('grievance_addressal') === true) { ?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $grievance_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($grievance_addressed_tickets); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Addressed Grievances </div>
												<div class="icon">
													<i class="fa fa-reply"></i>
												</div>
												<a href="<?php echo $grievance_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $grievance_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo count($grievance_closed_tickets); ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Closed Grievances </div>
												<div class="icon">
													<i class="fa fa-check-circle-o"></i>
												</div>
												<a href="<?php echo $grievance_link_closedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>

							</div>
							<!-- Close Metric Boxes-->
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		<!-- END grievance_page OVERVIEW -->







	<?php } ?>
	<!-- FOR SUPERADMIN AND ADMIN -->


	<!-- START FOR DEPARTMENT HEAD -->
	<?php if ($this->session->userdata['user_role'] == 4) { ?>

		<!-- if dephead has access to admission feedback tickets -->
		<?php if (ismodule_active('ADF') === true) { ?>
			<?php if (ismodule_active('ADF') === true) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">
								<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of patient complaints and requests" style="color: inherit;" href="<?php echo base_url(); ?>admissionfeedback/department_tickets">
									<span>
										<h3>ADMISSION TICKETS </h3>
										<?php if (ismodule_active('ADF') === true) { ?><a href="<?php echo base_url(); ?>admissionfeedback/department_tickets" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>

							<div class="panel-body" style="height:135px; max-height:150px;">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo $adf_department['alltickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Total Tickets </div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $adf_link_alltickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

												<!-- <a href="<?php echo base_url('tickets/alltickets'); ?>" style="float: right;    margin-top: -9px;">View List</a> -->
											</div>
										</div>
									</div>
								</div>

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo  $adf_department['opentickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Open Tickets </div>
												<div class="icon">
													<i class="fa fa-plus"></i>
												</div>
												<a href="<?php echo $adf_link_opentickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<?php if (ticket_addressal('adf_addressal') === true) { ?>

									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
										<div class="panel panel-bd">
											<div class="panel-body" style="height: 100px;">
												<div class="statistic-box">
													<h2><span class="count-number"><?php echo $adf_department['addressedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
													<div class="small">Addressed Tickets </div>
													<div class="icon">
														<i class="fa fa-reply"></i>
													</div>
													<a href="<?php echo $adf_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

												</div>
											</div>
										</div>
									</div>
								<?php } ?>

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo $adf_department['closedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Closed Tickets </div>
												<div class="icon">
													<i class="fa fa-check-circle-o"></i>
												</div>
												<a href="<?php echo $adf_link_closedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>


								<!-- Close Metric Boxes-->
							</div>
							<!-- Close Metric Boxes-->
						</div>
					</div>
				</div>

			<?php } ?>
		<?php } ?>

		<!-- if dephead has access to ipfeedback tickets -->
		<?php if (ismodule_active('IP') === true) {  ?>
			<?php if (ismodule_active('IP') === true) { ?>

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">
								<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of Inpatient discharge feedbacks" style="color: inherit;" href="<?php echo base_url(); ?>ipd/department_tickets">

									<span>
										<h3>IP TICKETS</h3>
										<?php if (ismodule_active('IP') === true) { ?><a href="<?php echo base_url(); ?>ipd/department_tickets" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>
							<div class="panel-body" style="height:135px; max-height:150px;">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo $ip_department['alltickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Total Tickets </div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $ip_link_alltickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo  $ip_department['opentickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Open Tickets </div>
												<div class="icon">
													<i class="fa fa-plus"></i>
												</div>
												<a href="<?php echo $ip_link_opentickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>

								<?php if (ticket_addressal('ip_addressal') === true) { ?>

									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
										<div class="panel panel-bd">
											<div class="panel-body" style="height: 100px;">
												<div class="statistic-box">
													<h2><span class="count-number"><?php echo $ip_department['addressedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
													<div class="small">Addressed Tickets </div>
													<div class="icon">
														<i class="fa fa-reply"></i>
													</div>
													<a href="<?php echo $ip_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

												</div>
											</div>
										</div>
									</div>

								<?php }  ?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo $ip_department['closedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Closed Tickets </div>
												<div class="icon">
													<i class="fa fa-check-circle-o"></i>
												</div>
												<a href="<?php echo $ip_link_closedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

												<!-- <a href="<?php echo base_url('tickets/ticket_close'); ?>" style="float: right;    margin-top: -9px;">View List</a> -->
											</div>
										</div>
									</div>
								</div>


								<!-- Close Metric Boxes-->
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>

		<!-- if dephead has access to patient complaints -->
		<?php if (ismodule_active('PCF') === true) { ?>
			<?php if (ismodule_active('PCF') === true) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">
								<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of patient complaints and requests" style="color: inherit;" href="<?php echo base_url(); ?>pc/department_tickets">
									<span>
										<h3>PATIENT COMPLAINTS </h3>
										<?php if (ismodule_active('PCF') === true) { ?><a href="<?php echo base_url(); ?>pc/department_tickets" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>
							<div class="panel-body" style="height:135px; max-height:150px;">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo $int_department['alltickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Total Complaints </div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $int_link_alltickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

												<!-- <a href="<?php echo base_url('tickets/alltickets'); ?>" style="float: right;    margin-top: -9px;">View List</a> -->
											</div>
										</div>
									</div>
								</div>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo  $int_department['opentickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Open Complaints </div>
												<div class="icon">
													<i class="fa fa-plus"></i>
												</div>
												<a href="<?php echo $int_link_opentickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>

								<?php if (ticket_addressal('pc_addressal') === true) { ?>

									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
										<div class="panel panel-bd">
											<div class="panel-body" style="height: 100px;">
												<div class="statistic-box">
													<h2><span class="count-number"><?php echo $int_department['addressedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
													<div class="small">Addressed Complaints </div>
													<div class="icon">
														<i class="fa fa-reply"></i>
													</div>
													<a href="<?php echo $int_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

												</div>
											</div>
										</div>
									</div>
								<?php } ?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo $int_department['closedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Closed Complaints </div>
												<div class="icon">
													<i class="fa fa-check-circle-o"></i>
												</div>
												<a href="<?php echo $int_link_closedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>


								<!-- Close Metric Boxes-->
							</div>
							<!-- Close Metric Boxes-->
						</div>
					</div>
				</div>

			<?php } ?>
		<?php } ?>

		<!-- if dephead has access to outpatient feedback tickets -->
		<?php if (ismodule_active('OP') === true) {  ?>
			<?php if (ismodule_active('OP') === true) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">
								<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of Outpatient feedbacks" style="color: inherit;" href="<?php echo base_url(); ?>opf/department_tickets">
									<span>
										<h3>OP TICKETS</h3>
										<?php if (ismodule_active('OP') === true) { ?><a href="<?php echo base_url(); ?>opf/department_tickets" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>
							<div class="panel-body" style="height:135px; max-height:150px;">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo $op_department['alltickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Total Tickets </div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $op_link_alltickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo  $op_department['opentickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Open Tickets </div>
												<div class="icon">
													<i class="fa fa-plus"></i>
												</div>
												<a href="<?php echo $op_link_opentickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<?php if (ticket_addressal('op_addressal') === true) { ?>

									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
										<div class="panel panel-bd">
											<div class="panel-body" style="height: 100px;">
												<div class="statistic-box">
													<h2><span class="count-number"><?php echo $op_department['addressedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
													<div class="small">Addressed Tickets </div>
													<div class="icon">
														<i class="fa fa-reply"></i>
													</div>
													<a href="<?php echo $op_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

													<!-- <a href="<?php echo base_url('tickets/ticket_close'); ?>" style="float: right;    margin-top: -9px;">View List</a> -->
												</div>
											</div>
										</div>
									</div>
								<?php } ?>


								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo $op_department['closedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Closed Tickets </div>
												<div class="icon">
													<i class="fa fa-check-circle-o"></i>
												</div>
												<a href="<?php echo $op_link_closedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>


								<!-- Close Metric Boxes-->
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>

		<!-- if dephead has access to internal service requests -->
		<?php if (ismodule_active('ISR') === true) {  ?>
			<?php if (ismodule_active('ISR') === true) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">
								<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of employee requests" style="color: inherit;" href="<?php echo base_url(); ?>isr/department_tickets">
									<span>
										<h3>INTERNAL REQUESTS</h3>
										<?php if (ismodule_active('ISR') === true) { ?><a href="<?php echo base_url(); ?>isr/department_tickets" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>
							<div class="panel-body" style="height:135px; max-height:150px;">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo $esr_department['alltickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Total Requests </div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $esr_link_alltickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo  $esr_department['opentickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Open Requests </div>
												<div class="icon">
													<i class="fa fa-plus"></i>
												</div>
												<a href="<?php echo $esr_link_opentickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>

								<?php if (ticket_addressal('isr_addressal') === true) { ?>

									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
										<div class="panel panel-bd">
											<div class="panel-body" style="height: 100px;">
												<div class="statistic-box">
													<h2><span class="count-number"><?php echo $esr_department['addressedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
													<div class="small">Addressed Requests </div>
													<div class="icon">
														<i class="fa fa-reply"></i>
													</div>
													<a href="<?php echo $esr_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

													<!-- <a href="<?php echo base_url('tickets/ticket_close'); ?>" style="float: right;    margin-top: -9px;">View List</a> -->
												</div>
											</div>
										</div>
									</div>

								<?php } ?>

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;">
											<div class="statistic-box">
												<h2><span class="count-number"><?php echo $esr_department['closedtickets'];  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
												<div class="small">Closed Requests </div>
												<div class="icon">
													<i class="fa fa-check-circle-o"></i>
												</div>
												<a href="<?php echo $esr_link_closedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>


								<!-- Close Metric Boxes-->
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>

		<!-- START INCIDENT OVERVIEW -->
		<?php if (ismodule_active('INCIDENT') === true) { ?>
			<?php if (ismodule_active('INCIDENT') === true) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">

								<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of incidents" style="color: inherit;" href="<?php echo base_url(); ?>incident/department_tickets">
									<span>
										<h3>INCIDENT</h3>
										<?php if (ismodule_active('INCIDENT') === true) { ?><a href="<?php echo base_url(); ?>incident/department_tickets" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>
							<div class="panel-body" style="height:120px; max-height:120px;">

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $esr_tickets_tool; ?>">

											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $incident_department['alltickets']; ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Total Incidents</div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $incident_link_alltickets; ?>" style="float: right;    margin-top: -9px;">View List</a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $incident_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $incident_department['opentickets']; ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Open Incidents </div>
												<div class="icon">
													<i class="fa fa-plus"></i>
												</div>
												<a href="<?php echo $incident_link_opentickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>
								<?php if (ticket_addressal('incident_addressal') === true) { ?>

									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
										<div class="panel panel-bd">
											<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $incident_tickets_tool; ?>">
												<div class="statistic-box">
													<h2><span class="count-number">
															<?php echo $incident_department['addressedtickets']; ?>
														</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
															</i></span></h2>
													<div class="small">Addressed Incidents </div>
													<div class="icon">
														<i class="fa fa-reply"></i>
													</div>
													<a href="<?php echo $incident_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

												</div>
											</div>
										</div>
									</div>
								<?php } ?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $incident_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $incident_department['closedtickets']; ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Closed Incidents </div>
												<div class="icon">
													<i class="fa fa-check-circle-o"></i>
												</div>
												<a href="<?php echo $incident_link_closedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>

							</div>
							<!-- Close Metric Boxes-->
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		<!-- END INCIDENT OVERVIEW -->

		<!-- START grievance_page OVERVIEW -->
		<?php if (ismodule_active('GRIEVANCE') === true) { ?>
			<?php if (ismodule_active('GRIEVANCE') === true) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default" style="overflow:auto;">
							<div class="panel-heading">

								<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of staff grievance" style="color: inherit;" href="<?php echo base_url(); ?>grievance/department_tickets">
									<span>
										<h3>STAFF GRIEVANCES </h3>
										<?php if (ismodule_active('GRIEVANCE') === true) { ?><a href="<?php echo base_url(); ?>grievance/department_tickets" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
									</span>
								</a>
							</div>
							<div class="panel-body" style="height:120px; max-height:120px;">

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $grievance_tickets_tool; ?>">

											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $grievance_department['alltickets']; ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Total Grievances</div>
												<div class="icon">
													<i class="fa fa-ticket"></i>
												</div>
												<a href="<?php echo $grievance_link_alltickets; ?>" style="float: right;    margin-top: -9px;">View List</a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $grievance_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $grievance_department['opentickets']; ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Open Grievances </div>
												<div class="icon">
													<i class="fa fa-plus"></i>
												</div>
												<a href="<?php echo $grievance_link_opentickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>

								<?php if (ticket_addressal('grievance_addressal') === true) { ?>

									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
										<div class="panel panel-bd">
											<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $grievance_tickets_tool; ?>">
												<div class="statistic-box">
													<h2><span class="count-number">
															<?php echo $grievance_department['addressedtickets']; ?>
														</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
															</i></span></h2>
													<div class="small">Addressed Grievances </div>
													<div class="icon">
														<i class="fa fa-reply"></i>
													</div>
													<a href="<?php echo $grievance_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

												</div>
											</div>
										</div>
									</div>
								<?php }  ?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
									<div class="panel panel-bd">
										<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $grievance_tickets_tool; ?>">
											<div class="statistic-box">
												<h2><span class="count-number">
														<?php echo $grievance_department['closedtickets']; ?>
													</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
														</i></span></h2>
												<div class="small">Closed Grievances </div>
												<div class="icon">
													<i class="fa fa-check-circle-o"></i>
												</div>
												<a href="<?php echo $grievance_link_closedtickets; ?>" style="float: right;    margin-top: -9px;">View List</a>

											</div>
										</div>
									</div>
								</div>

							</div>
							<!-- Close Metric Boxes-->
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		<!-- END grievance_page OVERVIEW -->

	<?php } ?>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		var typed = new Typed(".typing-text", {
			strings: ["<?php echo $welcometext; ?>"],
			// delay: 10,
			loop: false,
			typeSpeed: 30,
			backSpeed: 5,
			backDelay: 1000,
		});
	});
</script>