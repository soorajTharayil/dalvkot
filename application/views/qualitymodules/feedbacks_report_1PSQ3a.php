<div class="content">
	<!-- content -->
	<?php
	include 'info_buttons_ip.php';

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

	$patient_feedback_1PSQ3a = base_url($this->uri->segment(1) . '/patient_feedback_1PSQ3a?id=');
	$table_feedback_1PSQ3a = 'bf_feedback_1PSQ3a';
	$table_patients_1PSQ3a = 'bf_patients';
	$desc_1PSQ3a = 'desc';
	$sorttime = 'asc';
	$setup = 'setup';
	$ip_feedbacks_count = $this->quality_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
	$feedbacktaken = $this->quality_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $desc_1PSQ3a);

	if ($feedbacktaken) {
	?>

		<div class="row">

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">

						<div style="float: right; margin-top: 10px; margin-right: 10px;">
							<span style="font-size:17px"><strong>Download Chart:</strong></span>
							<span style="margin-right: 10px;">
								<i data-placement="bottom" class="fa fa-file-pdf-o" style="font-size: 20px; color: red; cursor: pointer;"
									onclick="printChart()" data-toggle="tooltip" title="Download Chart as PDF"></i>
							</span>
							<span>
								<i data-placement="bottom" class="fa fa-file-image-o" style="font-size: 20px; color: green; cursor: pointer;"
									onclick="downloadChartImage()" data-toggle="tooltip"
									title="Download Chart as Image"></i>
							</span>
						</div>

						<canvas id="lineChart" width="400" height="200" style="width: 50%;padding:50px;"></canvas>

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
						<table class="1psq3a table table-striped table-hover table-bordered" cellspacing="0" width="100%">
							<thead>
								<th><?php echo lang_loader('ip', 'ip_slno'); ?></th>
								<th>Recorded by</th>
								<th>Month-Year</th>

								<th style="white-space: nowrap;">Employee details</th>

								<th>Sum of time taken for initial the assessment</th>
								<th>Total number of admissions</th>
								<th>Avg. time taken for initial assessment of indoor patients</th>


								<th>Bench Mark Time</th>

								<th>Data analysis</th>

								<th>Corrective action</th>

								<th>Preventive action</th>



							</thead>
							<tbody>
								<?php $sl = 1; ?>
								<?php $calculated_time = ["00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00", "00:00:00"];

								?>
								<?php foreach ($feedbacktaken as $r) {
									$id = $r->id;

									$param = json_decode($r->dataset);


								?>

									<tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC"; ?>" onclick="window.location.href='<?php echo $patient_feedback_1PSQ3a . $id; ?>'" style="cursor: pointer;">
										<td><?php echo $sl; ?></td>
										<td>
											<?php echo $r->name; ?>
										</td>
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
											<?php echo $r->name; ?>
											<?php if (allfeedbacks_page('feedback_id') == false) { ?>
												(<a href="<?php echo  $patient_feedback_1PSQ3a . $id; ?>"><?php echo $r->patientid; ?></a>)
											<?php } else { ?>
												(<?php echo $r->patientid; ?>)
											<?php } ?>



											<br>
											<?php
											echo "<i class='fa fa-phone'></i> ";
											echo $r->mobile;
											?>
											<?php if ($r->email) { ?>
												<br>
												<?php echo "<i class='fa fa-envelope'></i> "; ?>
												<?php echo $r->email; ?>
											<?php } ?>
										</td>
										<td>
											<?php echo $r->time_taken_initial_assessment; ?>
										</td>
										<td>
											<?php echo $r->number_of_admission; ?>
										</td>

										<td>
											<?php
											// Benchmark time (4 hours) in seconds
											$benchmarkSeconds = $r->bench_mark_time * 60 * 60;

											// Convert the calculatedResult to seconds
											list($calculatedHours, $calculatedMinutes, $calculatedSeconds) = explode(':', $r->average_time_taken_initial_assessment);
											$calculatedTotalSeconds = $calculatedHours * 3600 + $calculatedMinutes * 60 + $calculatedSeconds;

											// Check if calculatedResult is less than benchmark
											$color = ($calculatedTotalSeconds < $benchmarkSeconds) ? 'green' : 'red';

											// Output the calculatedResult with appropriate color
											?>
											<span style="color: <?php echo $color; ?>">
												<?php echo $r->average_time_taken_initial_assessment;
												$calculated_time[round(date("m", strtotime($r->datetime))) - 1] = $r->average_time_taken_initial_assessment;
												?>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
	// Example Data
	var benchmark = ["04:00:00", "04:00:00", "04:00:00", "04:00:00", "04:00:00", "04:00:00", "04:00:00", "04:00:00", "04:00:00", "04:00:00", "04:00:00", "04:00:00"];
	// var calculated = ["03:45:05", "03:50:00", "03:55:10", "04:00:30", "03:40:15", "03:55:20", "03:50:30", "04:05:40", "03:50:10", "03:45:50", "03:55:30", "03:50:00"];

	var calculated = <?php echo json_encode($calculated_time); ?>
	// Parse times to seconds
	function parseTimeToSeconds(time) {
		var parts = time.split(':');
		return parseInt(parts[0]) * 3600 + parseInt(parts[1]) * 60 + parseInt(parts[2]);
	}

	// Function to convert seconds to time format (hh:mm:ss)
	function secondsToTime(seconds) {
		var hours = Math.floor(seconds / 3600);
		var minutes = Math.floor((seconds % 3600) / 60);
		var remainingSeconds = seconds % 60;
		return hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0') + ':' + remainingSeconds.toString().padStart(2, '0');
	}

	// Convert all times to seconds
	var benchmarkSeconds = benchmark.map(parseTimeToSeconds);
	var calculatedSeconds = calculated.map(parseTimeToSeconds);

	// Determine colors based on comparison for each month
	var calculatedColors = calculatedSeconds.map((time, index) => time > benchmarkSeconds[index] ? 'rgba(234, 67, 53, 0.8)' : 'rgba(52, 168, 83, 1)');
	var calculatedBorderColors = calculatedSeconds.map((time, index) => time > benchmarkSeconds[index] ? 'rgba(234, 67, 53, 0.8)' : 'rgba(52, 168, 83, 1)');

	// Create the chart
	var ctx = document.getElementById('lineChart').getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			datasets: [{
					label: 'Benchmark Time',
					data: benchmarkSeconds,
					backgroundColor: 'rgba(56, 133, 244, 0.2)', // Blue color for benchmark
					borderColor: 'rgba(54, 162, 235, 1)',
					borderWidth: 2, // Adjusted border width
					fill: false, // No fill under the line
				},
				{
					label: 'Avg. Time taken for initial assessment of indoor patients',
					data: calculatedSeconds,
					backgroundColor: 'rgba(52, 168, 83, 0.2)', // Dynamic color for calculated
					borderColor: 'rgba(52, 168, 83, 1)',
					borderWidth: 2, // Adjusted border width
					fill: false, // No fill under the line
				}
			]
		},
		options: {
			scales: {
				x: {
					ticks: {
						font: {
							size: 16 // Adjust this value to increase/decrease font size
						}
					}
				},
				y: {
					ticks: {
						callback: function(value) {
							return secondsToTime(value); // Convert seconds to time format (hh:mm:ss)
						},
						font: {
							size: 16 // Adjust this value to increase/decrease font size
						}
					}
				}
			},
			plugins: {
				tooltip: {
					callbacks: {
						label: function(context) {
							var value = context.raw;
							return secondsToTime(value); // Convert seconds to time format (hh:mm:ss)
						}
					}
				}
			},
		}
	});
</script>

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

<script>
	function printChart() {
		const canvas = document.getElementById('lineChart');
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
			<h3>1.PSQ3a- Time taken for initial assessment of indoor patients</h3>
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
	function downloadChartImage() {
		const canvas = document.getElementById('lineChart');
		const image = canvas.toDataURL('image/png'); // Convert canvas to image data

		// Create a temporary link element
		const link = document.createElement('a');
		link.href = image;
		link.download = '1.PSQ3a- Time taken for initial assessment of indoor patients.png'; // Name of downloaded file
		link.click(); // Trigger download
	}
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