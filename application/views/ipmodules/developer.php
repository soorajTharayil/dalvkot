<?php
include 'info_buttons_ip.php';
require 'ip_table_variables.php';
$process_feedback_data = $this->ipd_model->process_feedback_data('bf_patients', 'bf_feedback', $sorttime, 'setup', 'tickets', 'ticket_message');

echo '<pre>';
print_r($process_feedback_data);
// exit;
?>
<div class="content">
	<div class="alert alert-warning alert-dismissible" role="alert">

		<span style="font-size: 15px">
			In the last <strong><?php echo $dates['pagetitle']; ?>, <?php echo count($ip_feedbacks_count); ?> feedbacks</strong> are collected.

		</span>

	</div>


	<div class="col-lg-12 col-sm-12">
		<div class="panel panel-default">

			<div class="panel-body" style="height:250px;" id="bar">
				<div class="message_inner line_chart">
					<canvas id="resposnsechart"></canvas>
				</div>
			</div>
		</div>
		<!-- /.row -->
	</div>

</div>


<script src="<?php echo base_url(); ?>assets/efeedor_chart.js"></script>
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
		height: 250px;
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