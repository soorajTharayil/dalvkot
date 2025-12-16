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
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;" data-toggle="tooltip" title="<?php echo $psat_info_tooltip; ?>">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo $ip_psat['psat_score']; ?></span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small">DSAT</div>
						<div class="icon">
							<i class="fa fa-star-half-o"></i>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;">
					<div class="statistic-box">
						<h2><span class="count-number">
								<?php echo count($ip_feedbacks_count); ?>
							</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
								</i></span></h2>
						<div class="small"><?php echo lang_loader('op','op_total_feedbacks'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totalfeedback_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
						<div class="icon">
							<i class="fa fa-comments-o"></i>
						</div>
						<a href="<?php echo $ip_link_feedback_report; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op','op_view_list'); ?></a>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;" data-toggle="tooltip" data-toggle="tooltip" title="<?php echo $satisfiedpatients_info_tooltip; ?>">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo $ip_psat['satisfied_count']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small">Satisfied Feedbacks</div>
						<div class="icon">
							<i class="fa fa-smile-o"></i>
						</div>
						<a href="<?php echo $ip_link_satisfied_list; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op','op_view_list'); ?></a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;" data-toggle="tooltip" title="<?php echo $unsatisfiedpatients_info_tooltip; ?>">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo $ip_psat['unsatisfied_count']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small">Unsatisfied Feedbacks</div>
						<div class="icon">
							<i class="fa fa-frown-o"></i>
						</div>
						<a href="<?php echo $ip_link_unsatisfied_list; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op','op_view_list'); ?></a>
					</div>
				</div>
			</div>
		</div>

		<!-- NPS chart-->

		<!-- Total Product Sales area -->
		<div class="col-lg-12 col-sm-12">
			<div class="panel panel-default">

				<div class="panel-body" style="height:510px;" id="bar">
					<div class="message_inner line_chart">
						<canvas id="patient_satisfaction_analysis"></canvas>
					</div>
				</div>
			</div>
			<!-- /.row -->
		</div>
	</div>

</div>
<script src="<?php echo base_url(); ?>assets/efeedor_doctoropd_chart.js"></script>
<style>
	.panel-body {
		height: 531px;
	}
</style>
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
		height: 500px;
		width: 1024px;
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