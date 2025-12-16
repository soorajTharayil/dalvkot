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



$all_feedback = $this->efeedor_model->get_feedback('bf_patients', 'bf_feedback', $fdatet, $tdate);
$all_tickets = $this->efeedor_model->get_tickets('bf_patients', 'tickets', $fdatet, $tdate);
$satisfied_patients_count = $this->efeedor_model->get_satisfied_count($all_feedback, $all_tickets);
$unsatisfied_patients_count = $this->efeedor_model->get_unsatisfied_count($all_feedback, $all_tickets);
$closedticket = $this->efeedor_model->closed_tickets($all_tickets);
$openticket = $this->efeedor_model->open_tickets($all_tickets);
$PSAT = $this->efeedor_model->PSAT($all_feedback, $all_tickets);
$NPS = $this->efeedor_model->NPS($all_feedback);
$ticket_resolution_rate = $this->efeedor_model->ticket_resolution_rate($all_tickets);
$ticket_close_rate = $this->efeedor_model->ticket_close_rate($all_tickets);

$all_feedback_op = $this->efeedor_model->get_feedback('bf_opatients', 'bf_outfeedback', $fdatet, $tdate);
$all_tickets_op = $this->efeedor_model->get_tickets('bf_opatients', 'ticketsop', $fdatet, $tdate);
$satisfied_patients_count_op = $this->efeedor_model->get_satisfied_count($all_feedback_op, $all_tickets_op);
$unsatisfied_patients_count_op = $this->efeedor_model->get_unsatisfied_count($all_feedback_op, $all_tickets_op);
$closedticket_op = $this->efeedor_model->closed_tickets($all_tickets_op);
$openticket_op = $this->efeedor_model->open_tickets($all_tickets_op);
$PSAT = $this->efeedor_model->PSAT($all_feedback_op, $all_tickets_op);
$NPS = $this->efeedor_model->NPS($all_feedback_op);
$ticket_resolution_rate_op = $this->efeedor_model->ticket_resolution_rate($all_tickets_op);
$ticket_close_rate_op = $this->efeedor_model->ticket_close_rate($all_tickets_op);

$all_feedback_int = $this->efeedor_model->get_feedback('bf_patients_int', 'bf_feedback_int', $fdatet, $tdate);
$all_tickets_int = $this->efeedor_model->get_tickets('bf_patients_int', 'tickets_int', $fdatet, $tdate);
$satisfied_patients_count_int = $this->efeedor_model->get_satisfied_count($all_feedback_int, $all_tickets_int);
$sresult_int = $this->efeedor_model->setup_result('setup_int');
$closedticket_int = $this->efeedor_model->closed_tickets($all_tickets_int);
$openticket_int = $this->efeedor_model->open_tickets($all_tickets_int);
$ticket_resolution_rate_int = $this->efeedor_model->ticket_resolution_rate($all_tickets_int);
$ticket_close_rate_int = $this->efeedor_model->ticket_close_rate($all_tickets_int);


?>

<!-- content -->
<div class="content">


	<!-- Download Buttons-->
	<div class="row">
		<?php if (is_mobile() === true) { ?>
			<div style="    
     width: 231px;
    float: right;
    margin-top: -23px;">

				<h5>From&nbsp;<b><?php echo date('d/m/Y', strtotime($tdate)); ?> </b> to&nbsp;<b><?php echo date('d/m/Y', strtotime($fdate)); ?> </b><a data-toggle="modal" data-target="#exampleModal" href="javascript:void()" data-toggle="tooltip" title="Click on the calendar icon and select your date range for which you want to display the reports."><i class="fa fa-calendar"></i></a></h5>
			</div>

		<?php } else { ?>
			<div style="    
     width: 429px;
    float: right;
    margin-top: -24px;">
				<h3>Showing data from&nbsp;<b><?php echo date('d/m/Y', strtotime($tdate)); ?> </b> to&nbsp;<b><?php echo date('d/m/Y', strtotime($fdate)); ?> </b><a data-toggle="modal" data-target="#exampleModal" href="javascript:void()" data-toggle="tooltip" title="Click on the calendar icon and select your date range for which you want to display the reports."><i class="fa fa-calendar"></i></a></h3>

			</div>
		<?php }  ?>
		<hr>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default" style="overflow:auto;">
				<div class="panel-heading">
					<h3>Platform Usage</h3>
				</div>
				<div class="panel-body" style="height:270px; max-height:300px;">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
								<?php $totalfeedbacks_PU = count($all_feedback)+count($all_feedback_op)+count($all_feedback_int); ?>
									<h2><span class="count-number"><?php echo $totalfeedbacks_PU  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="icon">
										<i class="fa fa-comments"></i>
									</div>
									<div class="small">Total feedbacks</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
								<?php $satisfied_PU= count($satisfied_patients_count + $satisfied_patients_count_op); ?>		
									<h2><span class="count-number"><?php echo $satisfied_PU;  ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="icon">
										<i class="fa fa-smile-o"></i>
									</div>
									<div class="small">Satisfied Patients </div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo round(($PSAT+$PSAT_op)/2); ?> </span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="icon">
										<i class="fa fa-user-plus"></i>
									</div>
									<div class="small">PSAT </div>
								</div>
							</div>
						</div>
					</div>


					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo round(($NPS+$NPS_op)/2)	; ?></span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="icon">
										<i class="fa fa-tachometer"></i>
									</div>
									<div class="small">NPS </div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
								<?php 	$all_tickets_PU = count($all_tickets)+count($all_tickets_op)+count($all_tickets_int); ?>								
									<h2><span class="count-number"><?php echo 	$all_tickets_PU; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="icon">
										<i class="fa fa-suitcase"></i>
									</div>
									<div class="small">Total tickets </div>
								</div>
							</div>
						</div>
					</div>


					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
								<?php $all_opentickets_PU = $openticket+$openticket_op+$openticket_int; ?>
									
									<h2><span class="count-number"><?php echo $all_opentickets_PU; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="icon">
										<i class="fa fa-unlock"></i>
									</div>
									<div class="small">Open tickets</div>
								</div>
							</div>
						</div>
					</div>


					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
								<?php $all_closetickets_PU= $closedticket+$closedticket_op+$closedticket_int; ?>
									<h2><span class="count-number"><?php echo $all_closetickets_PU; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="icon">
										<i class="fa fa-lock"></i>
									</div>
									<div class="small">Closed tickets </div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
								<?php $ticket_res_rate_PU=  round(($ticket_resolution_rate+$ticket_resolution_rate_op+$ticket_resolution_rate_int)/3); ?>
									<h2><span class="count-number"><?php echo $ticket_res_rate_PU ?></span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									
									<div class="icon">
										<i class="fa fa-reply-all"></i>
									</div>
									<div class="small">Ticket Resolution Rate</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Close Metric Boxes-->
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default" style="overflow:auto;">
				<div class="panel-heading">
					<h3>DISCHARGE INPATIENT FEEDBACKS</h3>
				</div>
				<div class="panel-body" style="height:270px; max-height:300px;">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo count($all_feedback); ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Total feedbacks <a href="javascript:void()" data-toggle="tooltip" title="Total patient feedbacks took during the selected period of time."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-comments"></i>
									</div>
									<a href="<?php echo base_url('report/ip_allfeedbacks_list'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo  $satisfied_patients_count; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Satisfied Patients <a href="javascript:void()" data-toggle="tooltip" title="Patients whose overall rating is good and hasn't raised any negative feedback tickets."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-smile-o"></i>
									</div>
									<a href="<?php echo base_url('reports/ip_satisfied_list'); ?>?fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo $PSAT; ?> </span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">PSAT <a href="javascript:void()" data-toggle="tooltip" title="Patient Satisfaction rate is a key performance indicator that measures how happy patients are with your services."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-user-plus"></i>
									</div>
									<a href="<?php echo base_url('dashboard/ip_psat_page'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>


					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo $NPS; ?></span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">NPS <a href="javascript:void()" data-toggle="tooltip" title="Net promoters Score is a patient loyalty measurement taken from asking how likely they are to recommend your hospital to others."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-tachometer"></i>
									</div>
									<a href="<?php echo base_url('dashboard/ip_nps_page'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo count($all_tickets); ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Total tickets <a href="javascript:void()" data-toggle="tooltip" title="Total no. of negative tickets received for the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-suitcase"></i>
									</div>
									<a href="<?php echo base_url('tickets/alltickets'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>


					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo $openticket; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Open tickets <a href="javascript:void()" data-toggle="tooltip" title="No. of patient tickets which are still open/ yet to be addressed."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-unlock"></i>
									</div>
									<a href="<?php echo base_url('tickets'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>


					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo $closedticket; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Closed tickets <a href="javascript:void()" data-toggle="tooltip" title="No. of patient tickets which are closed/ addressed by writing CAPA."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-lock"></i>
									</div>
									<a href="<?php echo base_url('tickets/ticket_close'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo $ticket_resolution_rate; ?></span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Ticket Resolution Rate <a href="javascript:void()" data-toggle="tooltip" title="is the ratio of the number of tickets generated to the number of tickets closed in a selected time period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-reply-all"></i>
									</div>
									<!-- <a href="<?php echo base_url('dashboard/ticketdashboard'); ?>" style="float: right;    margin-top: -9px;">View List</a> -->
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Close Metric Boxes-->
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
		<div class="panel panel-default" style="overflow:auto;">
				<div class="panel-heading">
					<h3>OUTPATIENT FEEDBACKS</h3>
				</div>
				<div class="panel-body" style="height:270px; max-height:300px;">

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo count($all_feedback_op); ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Total feedbacks <a href="javascript:void()" data-toggle="tooltip" title="Total patient feedbacks took during the selected period of time."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-comments"></i>
									</div>
									<a href="<?php echo base_url('report/op_allfeedbacks_list'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo count($satisfied_patients_count_op); ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Satisfied Patients <a href="javascript:void()" data-toggle="tooltip" title="Patients whose overall rating is good and hasn't raised any negative feedback tickets."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-smile-o"></i>
									</div>
									<a href="<?php echo base_url('reports/op_satisfied_list'); ?>?fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo $PSAT_op; ?> </span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">PSAT <a href="javascript:void()" data-toggle="tooltip" title="Patient Satisfaction rate is a key performance indicator that measures how happy patients are with your services."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-user-plus"></i>
									</div>
									<a href="<?php echo base_url('dashboard/ip_psat_page'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>


					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo $NPS_op; ?></span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">NPS <a href="javascript:void()" data-toggle="tooltip" title="Net promoters Score is a patient loyalty measurement taken from asking how likely they are to recommend your hospital to others."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-tachometer"></i>
									</div>
									<a href="<?php echo base_url('dashboard/op_nps_page'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>


					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo count($all_tickets_op); ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Total Tickets <a href="javascript:void()" data-toggle="tooltip" title="Total no. of negative tickets received for the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-suitcase"></i>
									</div>
									<a href="<?php echo base_url('ticketsop/alltickets'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>


					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo $openticket_op; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Open tickets <a href="javascript:void()" data-toggle="tooltip" title="No. of patient tickets which are still open/ yet to be addressed."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-unlock"></i>
									</div>
									<a href="<?php echo base_url('ticketsop'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo $closedticket_op; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Closed tickets <a href="javascript:void()" data-toggle="tooltip" title="No. of patient tickets which are closed/ addressed by writing CAPA."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-lock"></i>
									</div>
									<a href="<?php echo base_url('ticketsop/ticket_close'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo $ticket_resolution_rate_op; ?></span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Ticket Resolution Rate <a href="javascript:void()" data-toggle="tooltip" title="is the ratio of the number of tickets generated to the number of tickets closed in a selected time period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-reply-all"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Close Metric Boxes-->
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
		<div class="panel panel-default" style="overflow:auto;">
				<div class="panel-heading">
					<h3>Complaints/Service Requests</h3>
				</div>
				<div class="panel-body" style="height:135px; max-height:150px;">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo count($all_feedback_int); ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Total complaints <a href="javascript:void()" data-toggle="tooltip" title="Total patient feedbacks took during the selected period of time.  "><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-bed"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo count($all_tickets_int); ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Total tickets <a href="javascript:void()" data-toggle="tooltip" title="Total no. of negative tickets received for the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-suitcase"></i>
									</div>
									<a href="<?php echo base_url('ticketsint/alltickets'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>


					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo $openticket_int; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Open tickets <a href="javascript:void()" data-toggle="tooltip" title="No. of patient tickets which are still open/ yet to be addressed."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-unlock"></i>
									</div>
									<a href="<?php echo base_url('ticketsint'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>


					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
						<div class="panel panel-bd">
							<div class="panel-body" style="height: 100px;">
								<div class="statistic-box">
									<h2><span class="count-number"><?php echo $closedticket_int; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
									<div class="small">Closed tickets <a href="javascript:void()" data-toggle="tooltip" title="No. of patient tickets which are closed/ addressed by writing CAPA."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
									<div class="icon">
										<i class="fa fa-lock"></i>
									</div>
									<a href="<?php echo base_url('ticketsint/ticket_close'); ?>" style="float: right;    margin-top: -9px;">View List</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Close Metric Boxes-->
			</div>
		</div>
	</div>


	<!-- main row close -->
</div>
<!-- Close of content opened in main wrapper -->



<style>
	.panel-body {
		height: 531px;
	}
</style>
