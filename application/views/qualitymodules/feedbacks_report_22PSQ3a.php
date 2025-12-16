<div class="content">
	<!-- content -->
	<?php
	include 'info_buttons_ip.php';
	// require 'ip_table_variables.php';
		/* START DATE AND CALENDER */
		$dates = get_from_to_date();
		$pagetitle = $dates['pagetitle'];
		$fdate = $dates['fdate'];
		$tdate = $dates['tdate'];
		$pagetitle = $dates['pagetitle'];
		$fdate = date('Y-m-d', strtotime($fdate));
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$days = $dates['days'];
		/* END DATE AND CALENDER */
	$patient_feedback_1PSQ3a = base_url($this->uri->segment(1) . '/patient_feedback_22PSQ3a?id=');

	$table_feedback_2PSQ3a = 'bf_feedback_22PSQ3c';
	$table_patients_1PSQ3a = 'bf_patients';
	$desc_1PSQ3a = 'desc';
	$sorttime = 'asc';
	$setup = 'setup';
	$ip_feedbacks_count = $this->quality_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_2PSQ3a, $sorttime, $setup);
	$feedbacktaken = $this->quality_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_2PSQ3a, $desc_1PSQ3a);

	if ($feedbacktaken) {
	?>

		<div class="row">
			<div class="col-lg-12 col-sm-12">
				<div class="panel panel-default">
					<div class="alert alert-dismissible" role="alert" style="margin-bottom: -12px;">
						<span class="p-l-30 p-r-30" style="font-size: 15px">
						<?php $text = "In the " .  $dates['pagetitle'] . "," . count($ip_feedbacks_count) . " KPI forms were submitted." ?>
							<span class="typing-text"></span>

						</span>
					</div>
					<div class="panel-body" style="height:250px;" id="bar">
						<div class="message_inner line_chart">
							<canvas id="resposnsechart"></canvas>

						</div>
					</div>
				</div>

			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: right;">
						<div class="btn-group">
							<!-- <a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_download_total_feedback_tooltip'); ?>" href="<?php echo base_url($this->uri->segment(1)) . '/overall_patient_excel' ?>">
								<i class="fa fa-download"></i>
							</a> -->
						</div>
					</div>
					<div class="panel-body">
						<table class="22psq3a table table-striped table-hover table-bordered" cellspacing="0" width="100%">
							<thead>
								<th><?php echo lang_loader('ip', 'ip_slno'); ?></th>
								<th>Recorded by</th>
								<!-- <th><?php echo lang_loader('ip', 'ip_date'); ?></th> -->

								<th>Month-Year</th>
								<th style="white-space: nowrap;"><?php echo lang_loader('ip', 'emp'); ?></th>


								<th>Sum total patient-in time for consultation</th>
								<th>Total number of out-patients</th>
								<th>Avg. waiting time for out-patient consultation</th>
								<th>Bench Mark Time</th>



								<th><?php echo lang_loader('ip', 'data'); ?></th>



								<th><?php echo lang_loader('ip', 'corrective'); ?></th>




								<th><?php echo lang_loader('ip', 'preventive'); ?></th>
						


							</thead>
							<tbody>
								<?php $sl = 1; ?>
								<?php foreach ($feedbacktaken as $r) {
									$id = $r->id;

									$param = json_decode($r->dataset);


								?>

									<tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC"; ?>" onclick="window.location.href='<?php echo $patient_feedback_1PSQ3a . $id; ?>'" style="cursor: pointer;">
										<td><?php echo $sl; ?></td>
										<td>
											<?php echo $r->name; ?>
										</td>
										<!-- <td style="white-space: nowrap;"><?php if ($r->datetime) { ?>

												<?php
																				// Assuming $r->datetime contains the datetime value
																				$datetime = new DateTime($r->datetime);
																				$formatted_date = $datetime->format('Y-m-d');
																				$formatted_time = $datetime->format('h:i a');

																				echo $formatted_date . "<br>"; // Display date on one line
																				echo $formatted_time; // Display time on another line
												?>


											<?php } ?>
										</td> -->
										<td style="white-space: nowrap;">
											<?php if ($r->datetime) { ?>
												<?php echo date('M-Y', strtotime($r->datetime)); ?>
												
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
												(<a href="<?php echo  $patient_feedback_1PSQ3a . $id; ?>"><?php echo $param->patientid; ?></a>)
											<?php } else { ?>
												(<?php echo $param->patientid; ?>)
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

										<td>
											<?php echo $r->sum_of_consultation_time; ?>
										</td>
										<td>
											<?php echo $r->no_of_outpatients; ?>
										</td>
										<td>
											<?php
											// Benchmark time (50 minutes) in seconds
											$benchmarkSeconds = 50 * 60;

											// Convert the calculatedResult to seconds
											list($calculatedHours, $calculatedMinutes, $calculatedSeconds) = explode(':', $r->avg_consultation_wait_time);
											$calculatedTotalSeconds = $calculatedHours * 3600 + $calculatedMinutes * 60 + $calculatedSeconds;

											// Check if calculatedResult is less than benchmark
											$color = ($calculatedTotalSeconds < $benchmarkSeconds) ? 'green' : 'red';

											// Output the calculatedResult with appropriate color
											?>
											<span style="color: <?php echo $color; ?>">
												<?php echo $r->avg_consultation_wait_time; ?>
											</span>
										</td>


										<td>
											<?php echo $param->benchmark; ?>
										</td>


										<td>
											<?php echo $param->dataAnalysis; ?>
										</td>

										<td>
											<?php echo $param->correctiveAction; ?>
										</td>

										<td>
											<?php echo $param->preventiveAction; ?>
										</td>
									

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


<!-- <script src="<?php echo base_url(); ?>assets/efeedor_chart.js"></script> -->

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
		var apiUrl = "https://" + domain + "/analytics_audit_quality/resposnsechart_22ps"; // Replace with your API endpoint
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
					label: "KPI Analysis Chart",
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
							multistringText.push("Forms submitted: " + all_detail.count);
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