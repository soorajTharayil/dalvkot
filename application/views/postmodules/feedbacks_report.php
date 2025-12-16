<div class="content">
	<!-- content -->
	<?php
	include 'info_buttons_ip.php';
	require 'ip_table_variables.php';

	$all_tickets = $this->post_model->get_tickets($table_feedback, $table_tickets);
	$feedbacktaken = $this->post_model->patient_and_feedback($table_patients, $table_feedback, $desc);

	if ($feedbacktaken) {
	?>

		<div class="row">
			<div class="col-lg-12 col-sm-12">
				<div class="panel panel-default">
					<div class="alert alert-dismissible" role="alert" style="margin-bottom: -12px;">
						<span class="p-l-30 p-r-30" style="font-size: 15px">
							<?php $text = "In the last <strong>" .  $dates['pagetitle'] . "," . count($ip_feedbacks_count) . " feedbacks</strong> are collected." ?>
							<span class="typing-text"></span>

						</span>
					</div>
					<div class="panel-body" style="height:250px;" id="bar">
						<div class="message_inner line_chart" >
							<canvas id="resposnsechart"></canvas>

						</div>
					</div>
				</div>

			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: right;">
						<div class="btn-group">
							<a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_download_total_feedback_tooltip'); ?>" href="<?php echo base_url($this->uri->segment(1)) . '/overall_patient_excel' ?>">
								<i class="fa fa-download"></i>
							</a>
						</div>
					</div>
					<div class="panel-body">
						<table class="ipallfeedbacks table table-striped table-hover table-bordered" cellspacing="0" width="100%">
							<thead>
								<th><?php echo lang_loader('ip', 'ip_slno'); ?></th>
								<th><?php echo lang_loader('ip', 'ip_date'); ?></th>

								<?php if (allfeedbacks_page('feedback_id') == true) { ?>
									<th style="white-space: nowrap;"><?php echo lang_loader('ip', 'ip_feedback_id'); ?></th>
								<?php } ?>

								<th style="white-space: nowrap;"><?php echo lang_loader('ip', 'ip_patient_details'); ?></th>

								<?php if (allfeedbacks_page('avg_rating') == true) { ?>
									<th><?php echo lang_loader('ip', 'ip_average_rating'); ?></th>

								<?php } ?>
								<?php if (allfeedbacks_page('psat_score') == true) { ?>
									<th><?php echo lang_loader('ip', 'ip_psat'); ?></th>

								<?php } ?>
								<?php if (allfeedbacks_page('nps_score') == true) { ?>
									<th><?php echo lang_loader('ip', 'ip_nps'); ?></th>

								<?php } ?>

								<?php if (allfeedbacks_page('overall_comments') == true) { ?>
									<th><?php echo lang_loader('ip', 'ip_comment'); ?></th>
								<?php } ?>
								<?php if (allfeedbacks_page('nps_comment') == true) { ?>
									<th><?php echo lang_loader('ip', 'ip_nps_comment'); ?></th>

								<?php } ?>
							</thead>
							<tbody>
								<?php $sl = 1; ?>
								<?php foreach ($feedbacktaken as $r) {
									$param = json_decode($r->dataset);
									$id = $r->id;
									$check = true;
									foreach ($all_tickets as $t) {
										if ($t->feedbackid == $r->id && $check == true) {
											$check = false;
											$psat = 'Unsatisfied';
										}
									}
									if ($check == true) {
										$psat = 'Satisfied';
									}

								?>
									<?php if ($param->recommend1Score > 4) {
										$nps = "Promoter";
									} elseif ($param->recommend1Score < 3.5) {
										$nps = "Detractor";
									} else {
										$nps = "Passive";
									} ?>
									<tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC"
												?>">
										<td><?php echo $sl; ?></td>
										<td style="white-space: nowrap;"><?php if ($param->datetime) { ?>
												<?php echo date('g:i A', date(($param->datetime) / 1000)); ?>
												<br>
												<?php echo date('d-m-y', date(($param->datetime) / 1000)); ?>
											<?php } ?>
										</td>
										<?php if (allfeedbacks_page('feedback_id') == true) { ?>
											<td>
												<a href="<?php echo  $ip_link_patient_feedback . $id; ?>">IPDF-<?php echo $id; ?></a>
											</td>
										<?php } ?>

										<td style="overflow: clip;">
											<?php echo $param->name; ?>
											<?php if (allfeedbacks_page('feedback_id') == false) { ?>
												(<a href="<?php echo  $ip_link_patient_feedback . $id; ?>"><?php echo $param->patientid; ?></a>)
											<?php } else { ?>
												(<?php echo $param->patientid; ?>)
											<?php } ?>


											<br>
											<?php echo $param->ward; ?>
											<?php if ($param->bedno) { ?>
												<?php echo 'in ' . $param->bedno; ?>
											<?php } ?>
											<br>
											<?php
											echo "<i class='fa fa-phone'></i> ";
											echo $param->contactnumber;
											?>
											<?php if ($param->email) { ?>
												<br>
												<?php echo "<i class='fa fa-envelope'></i> "; ?>
												<?php echo $param->email; ?>
											<?php } ?>
										</td>

										<?php if (allfeedbacks_page('avg_rating') == true) { ?>
											<td style="width: 5px;">
												<?php
												if ($param->overallScore != 0) {
													echo $param->overallScore;
												}
												?>
											</td>
										<?php } ?>
										<?php if (allfeedbacks_page('psat_score') == true) { ?>
											<td>
												<?php echo $psat; ?>
											</td>
										<?php } ?>
										<?php if (allfeedbacks_page('nps_score') == true) { ?>
											<td>
												<?php echo $nps; ?>
											</td>
										<?php } ?>

										<?php if (allfeedbacks_page('overall_comments') == true) { ?>
											<td style="overflow: clip; word-break: break-all;">
												<?php if ($param->suggestionText != '' && $param->suggestionText != NULL) {
													echo $param->suggestionText;
												} else {
													echo '-';
												} ?>
											</td>
										<?php } ?>
										<?php if (allfeedbacks_page('nps_comment') == true) { ?>
											<td style="overflow: clip; word-break: break-all;">
												<?php
												if ($param->promotercomment) {
													echo $param->promotercomment;
												}
												if ($param->detractorcomment) {
													echo $param->detractorcomment;
												}
												if ($param->passivecomment) {
													echo $param->passivecomment;
												}
												?>
											</td>
										<?php } ?>

									</tr>
									<?php $sl++; ?>
								<?php } ?>

							</tbody>
						</table>


					</div>
				</div>
				<!-- /.row -->
			</div>
			<!-- /.row -->
		</div>
	<?php } else {   ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('ip', 'ip_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>

</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		var typed = new Typed(".typing-text", {
			strings: ["<?php echo $text; ?>"],
			// delay: 10,
			loop: false,
			typeSpeed: 30,
			backSpeed: 5,
			backDelay: 1000,
		});
	});
</script>

<style>
	.panel-body {
		height: auto;
	}
</style>

<style>
	.progress {
		margin-bottom: 10px;
	}
</style>


<!-- <script src="<?php echo base_url(); ?>assets/efeedor_pdf_chart.js"></script> -->

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

<script>
	var url = window.location.href;
	var domain = url.replace(/^(?:https?:\/\/)?(?:www\.)?/, "");
	domain = domain.split("/")[0];

	function resposnsechart(callback) {

		var xhr = new XMLHttpRequest();
		var apiUrl = "https://" + domain + "/analytics/resposnsechart"; // Replace with your API endpoint
		xhr.open("GET", apiUrl, true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && xhr.status === 200) {
				var responseData = JSON.parse(xhr.responseText);
				callback(responseData); // Call the callback function with the API data
			}
		};
		xhr.send();
	}

	function resposnseChart(apiData) {
		var labels = apiData.map(function(item) {
			return item.label_field;
		});

		var dataPoints = apiData.map(function(item) {
			return item.all_detail.count;
		});
		if (dataPoints.length == 1) {
			dataPoints.push(null);
			labels.push(" ");
		}
		// Create Chart.js chart
		var ctx = document.getElementById("resposnsechart").getContext("2d");
		ctx.canvas.parentNode.style.width = "100%"; // Set the container width to 100%
		ctx.canvas.parentNode.style.height = "100%";

		// Create a linear gradient fill for the chart
		var gradientFill = ctx.createLinearGradient(0, 0, 0, 400);
		gradientFill.addColorStop(0, "rgba(0, 128, 0, 0.8)"); // Start color
		gradientFill.addColorStop(1, "rgba(0, 128, 0, 0.1)"); // End color (more transparent)

		var myChart = new Chart(ctx, {
			type: "line",
			data: {
				labels: labels,
				datasets: [{
					label: "Feedback/Responses Analysis",
					data: dataPoints,
					backgroundColor: gradientFill,
					borderColor: "rgba(0, 128, 0, 1)",
					borderWidth: 1,
					pointBackgroundColor: "rgba(0, 128, 0, 1)", // Green color with full opacity
					pointBorderColor: "rgba(0, 128, 0, 1)",
					pointHoverBackgroundColor: "rgba(255, 165, 0, 0.4)", // Orange color with reduced opacity
					pointHoverBorderColor: "rgba(0, 128, 0, 1)",
				}, ],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				title: {
					display: false,
					text: "Chart.js Line Chart",
				},
				tooltips: {
					enabled: true,
					mode: "single",
					callbacks: {
						label: function(tooltipItems, data) {
							var multistringText = [];
							var dataIndex = tooltipItems.index; // Get the index of the hovered data point
							var all_detail = apiData[dataIndex].all_detail;
							multistringText.push("Feedbacks Collected: " + all_detail.count);
							return multistringText;
						},
					},
				},
				hover: {
					mode: "nearest",
					intersect: true,
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: false,
							labelString: "Month",
						},
					}, ],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: false,
							labelString: "Value",
						},
						ticks: {

							min: 0,
							padding: 25,
							// forces step size to be 5 units
							stepSize: 30,
						},
					}, ],
				},
			},
		});
	}

	// Call the fetchDataFromAPI function and pass the callback function to create the chart
	setTimeout(function() {
		resposnsechart(resposnseChart);
	}, 1000);
	/*patient_feedback_analysis*/
</script>