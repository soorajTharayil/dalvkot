<div class="content">
	<!-- alert message -->
	<!-- content -->
	<?php

	include 'info_buttons_ip.php';
	require 'ip_table_variables.php';

	/* END TABLES FROM DATABASE */
	$ip_feedbacks_count = $this->doctorsopdfeedback_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
	$ip_psat = $this->doctorsopdfeedback_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $asc);
	?>
	<!-- Metric Boxes-->
	<div class="row">

		<?php if ($this->uri->segment(2) == "ticket_resolution_rate") { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $ticket_resolution_rate; ?></span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('op','op_ticket_resolution_rate'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $ticketresolutionrate_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-clock-o"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if ($this->uri->segment(2) == "average_resolution_time") { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><?php echo $ticket_close_rate; ?>&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('op','op_average_resolution_time'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $averageresolutiontime_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-calendar-check-o"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo $op_department['alltickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small"><?php echo lang_loader('op','op_total_tickets'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickets_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
						<div class="icon">
							<i class="fa fa-ticket"></i>
						</div>
						<a href="<?php echo $ip_link_alltickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op','op_view_list'); ?></a>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;">
					<div class="statistic-box">

						<h2><span class="count-number"><?php echo $op_department['opentickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small"><?php echo lang_loader('op','op_open_tickets'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $opentickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
						<div class="icon">
							<i class="fa fa-envelope-open-o"></i>
						</div>
						<a href="<?php echo $ip_link_opentickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op','op_view_list'); ?></a>
					</div>
				</div>
			</div>
		</div>

		<?php if (ticket_addressal('op_addressal') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $op_department['addressedtickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small"><?php echo lang_loader('op','op_addressed_tickets'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $addressedtickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-reply"></i>
							</div>
							<a href="<?php echo $ip_link_addressedtickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op','op_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>


		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo $op_department['closedticket']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small"><?php echo lang_loader('op','op_closed_tickets'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $closetickect_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
						<div class="icon">
							<i class="fa fa-check-circle-o"></i>
						</div>
						<a href="<?php echo $ip_link_closedtickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op','op_view_list'); ?></a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" style="display: none;">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo count($ip_feedbacks_count); ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small"><?php echo lang_loader('op','op_total_feedbacks'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totalfeedback_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
						<div class="icon">
							<i class="fa fa-comments-o"></i>
						</div>
					</div>
					<a href="<?php echo $ip_link_feedback_report; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op','op_view_list'); ?></a>

				</div>
			</div>
		</div>

	</div>


	<div class="panel panel-default">

		<div class="panel-body">
			<!-- change here update in mainwrapper script -->
			<table class="opticketanalisys table table-striped table-bordered table-hover" cellspacing="0" width="100%">
				<thead>
					<th><?php echo lang_loader('op','op_slno'); ?></th>
					<th><?php echo lang_loader('op','op_department'); ?></th>
					<!-- <th>Percentage</th> -->
					<th><?php echo lang_loader('op','op_s_total_tickets'); ?></th>
					<th><?php echo lang_loader('op','op_s_open_tickets'); ?></th>
					<!-- change here according to helper -->
					<?php if (ticket_addressal('op_addressal') === true) { ?>
						<th><?php echo lang_loader('op','op_s_addressed_tickets'); ?></th>
					<?php } ?>
					<th><?php echo lang_loader('op','op_s_closed_tickets'); ?></th>
					<?php if ($this->uri->segment(2) == "ticket_resolution_rate") { ?>
						<th><?php echo lang_loader('op','op_resolution_rate'); ?></th>
					<?php } ?>
					<?php if ($this->uri->segment(2) == "average_resolution_time") { ?>
						<th><?php echo lang_loader('op','op_avg_resolution_time'); ?></th>
					<?php } ?>
				</thead>
				<?php $sl = 1;
				$i = 0; ?>
				<tbody>
					<?php foreach ($ticket_analisys as $dep_wise) {	?>
						<tr>
							<td>
								<?php echo $sl; ?>
							</td>
							<td>
								<?php echo $dep_wise['department']; ?>
							</td>
							<!-- <td style="display: none;">
								<?php //echo $dep_wise['percentage'] . '%'; 
								?>
							</td> -->
							<td>
								<?php echo $dep_wise['count']; ?>
							</td>
							<td>
								<?php echo $dep_wise['open_tickets']; ?>
							</td>
							<?php if (ticket_addressal('op_addressal') === true) { ?>

								<td>
									<?php echo $dep_wise['addressed_tickets']; ?>
								</td>
							<?php } ?>

							<td>
								<?php echo $dep_wise['closed_tickets']; ?>
							</td>
							<?php if ($this->uri->segment(2) == "ticket_resolution_rate") { ?>
								<td>
									<?php echo $dep_wise['tr_rate'] . '%'; ?>
								</td>
							<?php } ?>
							<?php if ($this->uri->segment(2) == "average_resolution_time") {
								$time = secondsToTimeforreport($dep_wise['res_time']);  ?>
								<td>
									<?php echo $time; ?>
								</td>
							<?php } ?>
							<?php $sl = $sl + 1; ?>
							<?php $i++; ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>


</div>
<style>
	.panel-body {
		height: auto;
	}
</style>