<div class="content">
	<!-- alert message -->
	<!-- content -->
	<?php
	include 'info_buttons_ip.php';
	require 'ip_table_variables.php';

	$ip_nps = $this->doctorsopdfeedback_model->nps_analytics($table_feedback, $asc, $setup);
	?>
	<!-- Metric Boxes-->
	<div class="row">

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;" data-toggle="tooltip" title="<?php echo $nps_info_tooltip; ?>">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo $ip_nps['nps_score']; ?></span>% <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small"><?php echo lang_loader('op','op_nps'); ?></div>
						<div class="icon">
							<i class="fa fa-tachometer"></i>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;" data-toggle="tooltip" title="<?php echo $promoter_tooltip; ?>">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo $ip_nps['promoters_count']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small"><?php echo lang_loader('op','op_promoters'); ?></div>
						<div class="icon">
							<i class="fa fa-smile-o"></i>
						</div>
						<a href="<?php echo $ip_link_promoter_list; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op','op_view_list'); ?></a>

					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;" data-toggle="tooltip" title="<?php echo $detractor_tooltip; ?>">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo $ip_nps['detractors_count']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small"><?php echo lang_loader('op','op_detractors'); ?></div>
						<div class="icon">
							<i class="fa fa-frown-o"></i>
						</div>
						<a href="<?php echo $ip_link_detractor_list; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op','op_view_list'); ?></a>

					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel panel-bd">
				<div class="panel-body" style="height: 100px;" data-toggle="tooltip" title="<?php echo $passive_tooltip; ?>">
					<div class="statistic-box">
						<h2><span class="count-number"><?php echo $ip_nps['passives_count']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
						<div class="small"><?php echo lang_loader('op','op_passives'); ?> </div>
						<div class="icon">
							<i class="fa fa-meh-o"></i>

						</div>
						<a href="<?php echo $ip_link_passives_list; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('op','op_view_list'); ?></a>

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
						<canvas id="net_permoter_analysis"></canvas>
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