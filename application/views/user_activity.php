<!--Code updates: 
Worked on UI allignment, fixed all the issues.
Last updated on 05-03-23 -->

<?php
// ip module related
$feedbacktaken_count_ip = $this->ipd_model->get_feedback_count();
$ip_link_allfeedback = base_url('ipd/feedbacks_report_login_apk');
// print_r($ipallfeedbackk);
// exit;

// op module  
$feedbacktaken_count_op = $this->opf_model->get_feedback_count();
$op_link_allfeedback = base_url('opf/feedbacks_report_login_apk');

// op module  
$feedbacktaken_count_pcf = $this->pc_model->get_feedback_count();
$pcf_link_allfeedback = base_url('pc/alltickets_login_apk');


// isr related 
$esralltickets = $this->ticketsesr_model->alltickets_individual_user();
$esrallticketsOpen = $this->ticketsesr_model->read_individual_user();
$esrallticketsAssigned = $this->ticketsesr_model->assignedtickets_individual_user();
$esrallticketsClosed = $this->ticketsesr_model->read_close_individual_user();
$totalTicketsCount = count($esralltickets);
$totalTicketsCountOpen = count($esrallticketsOpen);
$totalTicketsCountAssigned = count($esrallticketsAssigned);
$totalTicketsCountClosed = count($esrallticketsClosed);

// incident related 
$incidentalltickets = $this->ticketsincidents_model->alltickets_individual_user();
$incidentallticketsOpen = $this->ticketsincidents_model->read_individual_user();
$incidentallticketsAssigned = $this->ticketsincidents_model->assignedtickets_individual_user();
$incidentallticketsClosed = $this->ticketsincidents_model->read_close_individual_user();
$totalTicketsCount_incident = count($incidentalltickets);
$totalTicketsCountOpen_inciden = count($incidentallticketsOpen);
$totalTicketsCountAssigned_inciden = count($incidentallticketsAssigned);
$totalTicketsCountClosed_inciden = count($incidentallticketsClosed);

// incident related 
$grievencealltickets = $this->ticketsgrievance_model->alltickets_individual_user();
$grievenceallticketsOpen = $this->ticketsgrievance_model->read_individual_user();
$grievenceallticketsAddressed = $this->ticketsgrievance_model->addressedtickets_individual_user();
$grievenceallticketsClosed = $this->ticketsgrievance_model->read_close_individual_user();
$totalTicketsCount_grievence = count($grievencealltickets);
$totalTicketsCountOpen_grievence = count($grievenceallticketsOpen);
$totalTicketsCountAddressed_grievence = count($grievenceallticketsAddressed);
$totalTicketsCountClosed_grievence = count($grievenceallticketsClosed);

$esr_link_alltickets = base_url('isr/alltickets_individual_user');
$esr_link_opentickets = base_url('isr/read_individual_user');
$esr_link_assignedtickets = base_url('isr/assignedtickets_individual_user');
$esr_link_closedtickets = base_url('isr/read_close_individual_user');

$incident_link_alltickets = base_url('incident/alltickets_individual_user');
$incident_link_opentickets = base_url('incident/read_individual_user');
$incident_link_assignedtickets = base_url('incident/assignedtickets_individual_user');
$incident_link_closedtickets = base_url('incident/read_close_individual_user');

$grievance_link_alltickets = base_url('grievance/alltickets_individual_user');
$grievance_link_opentickets = base_url('grievance/read_individual_user');
$grievance_link_addressedtickets = base_url('grievance/addressedtickets_individual_user');
$grievance_link_closedtickets = base_url('grievance/read_close_individual_user');



//  print_r($this->session->userdata['departmenthead']->empid);
$welcometext = "This page provides an overview of each user's activities across various tools, including patient feedback, concerns raised, internal requests, and incidents reported through Efeedor.";

?>

<!-- content -->
<div class="content">
	<div class="col-lg-12">
		<div style="margin-bottom: 25px; ">

			<h4 style="font-size:18px;font-weight:normal; margin-top: 20px; ">
				<span class="typing-text"></span>
			</h4>
			<!-- &nbsp;&nbsp;&nbsp;&nbsp;<span class="typing-text"></span> </h4> -->
		</div>
	</div>



	<?php if ($totalTicketsCount >= 1) { ?>

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="overflow:auto;">
					<div class="panel-heading">
						<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of employee requests" style="color: inherit;" href="<?php echo base_url(); ?>isr/department_tickets">
							<span>
								<h3>INTERNAL SERVICE REQUEST</h3>
								<!-- <a href="<?php echo base_url(); ?>isr/department_tickets" style="float: right;margin-top: -22px;">Explore</a> -->
							</span>
						</a>
					</div>
					<div class="panel-body" style="height:135px; max-height:150px;">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $totalTicketsCount; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">Requests raised</div>
										<div class="icon">
											<i class="fa fa-ticket"></i>
										</div>
										<a href="<?php echo $esr_link_alltickets; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $totalTicketsCountOpen; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">Requests Unaddressed</div>
										<div class="icon">
											<i class="fa fa-plus"></i>
										</div>
										<a href="<?php echo $esr_link_opentickets; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $totalTicketsCountAssigned; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">
											Requests Assigned</div>
										<div class="icon">
											<i class="fa fa-reply"></i>
										</div>
										<a href="<?php echo $esr_link_assignedtickets; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $totalTicketsCountClosed; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">Requests Resolved</div>
										<div class="icon">
											<i class="fa fa-check-circle-o"></i>
										</div>
										<a href="<?php echo $esr_link_closedtickets; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<br>
	<?php } ?>
	<?php if ($totalTicketsCount_incident >= 1) { ?>

		<div class="col-lg-12">
			<div style="margin-bottom: 15px; ">

				<h4 style="font-size:18px;font-weight:normal; margin-top: -40px; ">
					<!-- <span class="typing-text1"></span> -->
				</h4>
				<!-- &nbsp;&nbsp;&nbsp;&nbsp;<span class="typing-text"></span> </h4> -->
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="overflow:auto;">
					<div class="panel-heading">
						<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of employee requests" style="color: inherit;" href="<?php echo base_url(); ?>isr/department_tickets">
							<span>
								<h3>INCIDENT</h3>
								<!-- <a href="<?php echo base_url(); ?>isr/department_tickets" style="float: right;margin-top: -22px;">Explore</a> -->
							</span>
						</a>
					</div>
					<div class="panel-body" style="height:135px; max-height:150px;">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $totalTicketsCount_incident; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">Incidents Reported</div>
										<div class="icon">
											<i class="fa fa-ticket"></i>
										</div>
										<a href="<?php echo $incident_link_alltickets; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $totalTicketsCountOpen_inciden; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">
											Incidents Unaddressed</div>
										<div class="icon">
											<i class="fa fa-plus"></i>
										</div>
										<a href="<?php echo $incident_link_opentickets; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $totalTicketsCountAssigned_inciden; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">
											Incidents Assigned</div>
										<div class="icon">
											<i class="fa fa-reply"></i>
										</div>
										<a href="<?php echo $incident_link_assignedtickets; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $totalTicketsCountClosed_inciden; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">Incidents Closed</div>
										<div class="icon">
											<i class="fa fa-check-circle-o"></i>
										</div>
										<a href="<?php echo $incident_link_closedtickets; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
	<?php } ?>
	<?php if ($totalTicketsCount_grievence >= 1) { ?>

		<div class="col-lg-12">
			<div style="margin-bottom: 15px; ">

				<h4 style="font-size:18px;font-weight:normal; margin-top: -40px; ">
					<!-- <span class="typing-text2"></span> -->
				</h4>
				<!-- &nbsp;&nbsp;&nbsp;&nbsp;<span class="typing-text"></span> </h4> -->
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="overflow:auto;">
					<div class="panel-heading">
						<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of employee requests" style="color: inherit;" href="<?php echo base_url(); ?>isr/department_tickets">
							<span>
								<h3>GREVIENCE</h3>
								<!-- <a href="<?php echo base_url(); ?>isr/department_tickets" style="float: right;margin-top: -22px;">Explore</a> -->
							</span>
						</a>
					</div>
					<div class="panel-body" style="height:135px; max-height:150px;">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $totalTicketsCount_grievence; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">Grievance Reported</div>
										<div class="icon">
											<i class="fa fa-ticket"></i>
										</div>
										<a href="<?php echo $grievance_link_alltickets; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo  $totalTicketsCountOpen_grievence; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">
											Grievance Unaddressed</div>
										<div class="icon">
											<i class="fa fa-plus"></i>
										</div>
										<a href="<?php echo $grievance_link_opentickets; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $totalTicketsCountAddressed_grievence; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">
											Grievance Addressed</div>
										<div class="icon">
											<i class="fa fa-reply"></i>
										</div>
										<a href="<?php echo $grievance_link_addressedtickets; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $totalTicketsCountClosed_grievence; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">
											Grievance Closed</div>
										<div class="icon">
											<i class="fa fa-check-circle-o"></i>
										</div>
										<a href="<?php echo $grievance_link_closedtickets; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<?php if ($feedbacktaken_count_ip >= 1) { ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="overflow:auto;">
					<div class="panel-heading">
						<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of employee requests" style="color: inherit;" href="<?php echo base_url(); ?>isr/department_tickets">
							<span>
								<h3>IP DISCHARGE FEEDBACKS</h3>
								<!-- <a href="<?php echo base_url(); ?>isr/department_tickets" style="float: right;margin-top: -22px;">Explore</a> -->
							</span>
						</a>
					</div>
					<div class="panel-body" style="height:135px; max-height:150px;">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $feedbacktaken_count_ip; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">Feedbacks collected</div>
										<div class="icon">
											<i class="fa fa-ticket"></i>
										</div>
										<a href="<?php echo $ip_link_allfeedback; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<br>

	<?php } ?>
	<?php if ($feedbacktaken_count_op >= 1) { ?>

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="overflow:auto;">
					<div class="panel-heading">
						<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of employee requests" style="color: inherit;" href="<?php echo base_url(); ?>isr/department_tickets">
							<span>
								<h3>OUTPATIENT FEEDBACKS</h3>
								<!-- <a href="<?php echo base_url(); ?>isr/department_tickets" style="float: right;margin-top: -22px;">Explore</a> -->
							</span>
						</a>
					</div>
					<div class="panel-body" style="height:135px; max-height:150px;">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $feedbacktaken_count_op; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">Feedbacks collected</div>
										<div class="icon">
											<i class="fa fa-ticket"></i>
										</div>
										<a href="<?php echo $op_link_allfeedback; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<br>
	<?php } ?>
	<?php if ($feedbacktaken_count_pcf >= 1) { ?>

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="overflow:auto;">
					<div class="panel-heading">
						<a data-toggle="tooltip" data-placement="bottom" title="Click here for detailed analysis of employee requests" style="color: inherit;" href="<?php echo base_url(); ?>isr/department_tickets">
							<span>
								<h3>INPATIENT COMPLAINTS</h3>
								<!-- <a href="<?php echo base_url(); ?>isr/department_tickets" style="float: right;margin-top: -22px;">Explore</a> -->
							</span>
						</a>
					</div>
					<div class="panel-body" style="height:135px; max-height:150px;">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="panel panel-bd">
								<div class="panel-body" style="height: 100px;">
									<div class="statistic-box">
										<h2><span class="count-number"><?php echo $feedbacktaken_count_pcf; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
										<div class="small">Complaints Captured</div>
										<div class="icon">
											<i class="fa fa-ticket"></i>
										</div>
										<a href="<?php echo $pcf_link_allfeedback; ?>" style="float: right; margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
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
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var typed = new Typed(".typing-text1", {
			strings: ["<?php echo $welcometext1; ?>"],
			// delay: 10,
			loop: false,
			typeSpeed: 30,
			backSpeed: 5,
			backDelay: 1000,
		});
	});
</script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var typed = new Typed(".typing-text2", {
			strings: ["<?php echo $welcometext2; ?>"],
			// delay: 10,
			loop: false,
			typeSpeed: 30,
			backSpeed: 5,
			backDelay: 1000,
		});
	});
</script>