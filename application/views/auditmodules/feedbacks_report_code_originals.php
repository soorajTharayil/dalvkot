<div class="content">
	<!-- content -->
	<?php
	include 'info_buttons_ip.php';
	include 'audit_tables.php';


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

	$table_feedback = 'bf_feedback_code_originals';
	$table_patients = 'bf_patients';
	$sorttime = 'asc';
	$setup = 'setup';
	$asc = 'asc';
	$desc = 'desc';

	$feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);
	$ip_feedbacks_count = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
	if ($feedbacktaken) {


	?>

		<div class="row">
			<div class="col-lg-12 col-sm-12">
				<div class="panel panel-default">
					<div class="alert alert-dismissible" role="alert" style="margin-bottom: -12px;">
						<span class="p-l-30 p-r-30" style="font-size: 15px">
							<?php $text = "In the " .  $dates['pagetitle'] . "," . "a total of " . count($ip_feedbacks_count) . " audits were conducted." ?>
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
					<div class="panel-heading" style="text-align: left;">
						<h3>Code Pink</h3>
					</div>
					<div class="panel-body">
						<?php
						// Initialize arrays to collect data for each checklist type
						$codePinkData = [];


						foreach ($feedbacktaken as $r) {
							$param = json_decode($r->dataset);
							if ($param->checklist == 'Code Pink') {
								// Add id to the data object
								$param->id = $r->id;
								$param->datetime = $r->datetime;
								$param->location = $r->location;
								$codePinkData[] = $param;
							}
						}

						// Function to display the data for Code Pink
						function displayCodePinkTable($data)
						{
							if (!empty($data)) {
								echo '<table class="codepink table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
								echo '<thead>
									<th>Sl. No.</th>
									<th>Date</th>
									<th>Location</th>
									<th>Hospital Emergency Code</th>
									<th>Spot activation time</th>
									<th>Announcement time</th>
									<th>Number of code announcements</th>
									<th>Was the description of the child included in the announcement?</th>
									<th>Was the Code Pink team activated?</th>
									<th>Were all exit points closed?</th>
									<th>Were security guards positioned at all entry/exit points</th>
									<th>Was counseling provided to the mother?</th>
									<th>Were all areas, including exteriors, terrace searched?</th>
									<th>Were suspicious persons within the hospital premises checked?</th>
									<th>Were all areas closely examined through CCTV?</th>
									<th>Was the child handed over?</th>
									<th>Were all events described to the mother?</th>
									<th>Code Pink clearance time</th>
									<th>Are deviations explained?</th>
									<th>Have all events of Code Pink been debriefed?</th>
									<th>Code Pink closure time</th>
									<th>Additional comments</th>
								</thead>';
								echo '<tbody>';
								$sl = 1;
								foreach ($data as $param) {
									echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" onclick="window.location=\'' . base_url('audit/code_pink_feedback?id=') . $param->id . '\';" style="cursor: pointer;">';
									echo "<td>$sl</td>";
									echo '<td style="white-space: nowrap;">' .
										(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
										'</td>';
									echo '<td>' . $param->location . '</td>';
									echo '<td>' . $param->checklist . '</td>';
									echo '<td>' . $param->initial_assessment_hr1 . '</td>';
									echo '<td>' . $param->initial_assessment_hr2 . '</td>';
									echo '<td>' . $param->number_of_code . '</td>';
									echo '<td>' . $param->child_announce . '</td>';
									echo '<td>' . $param->code_pink_team . '</td>';
									echo '<td>' . $param->exit_points . '</td>';
									echo '<td>' . $param->security_guard . '</td>';
									echo '<td>' . $param->counseling_to_mother . '</td>';
									echo '<td>' . $param->searched . '</td>';
									echo '<td>' . $param->suspicious . '</td>';
									echo '<td>' . $param->cctv . '</td>';
									echo '<td>' . $param->handing . '</td>';
									echo '<td>' . $param->events . '</td>';
									echo '<td>' . $param->initial_assessment_hr4 . '</td>';
									echo '<td>' . $param->deviations . '</td>';
									echo '<td>' . $param->debrief_p . '</td>';
									echo '<td>' . $param->initial_assessment_hr5 . '</td>';
									echo '<td>' . $param->comments . '</td>';
									echo '</tr>';
									$sl++;
								}
								echo '</tbody>';
								echo '</table>';
							}
						}

						// Display the tables for each checklist type
						displayCodePinkTable($codePinkData);

						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>


			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Code Red</h3>
					</div>
					<div class="panel-body">
						<?php

						// Initialize arrays to collect data for each checklist type
						$codeRedData = [];

						foreach ($feedbacktaken as $r) {
							$param = json_decode($r->dataset);
							if ($param->checklist == 'Code Red') {
								// Add id to the data object
								$param->id = $r->id;
								$param->datetime = $r->datetime;
								$param->location = $r->location;
								$codeRedData[] = $param;
							}
						}

						function displayCodeRedTable($data)
						{
							if (!empty($data)) {
								echo '<table class="codered table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
								echo '<thead>
                                    <tr>
                                      <th>Sl. No.</th>
                                      <th>Date</th>
                                      <th>Location</th>
                                      <th>Hospital Emergency Code</th>
                                      <th>Spot activation time</th>
                                      <th>Announcement time</th>
                                      <th>Number of code announcements</th>
                                      <th>Team arrival time</th>
                                      <th>Number of Respondents</th>
                                      <th>Have they tried to assess the situation?</th>
                                      <th>Is there availability of fire fighting equipment?</th>
                                      <th>Have they demonstrated the use of fire fighting equipment?</th>
                                      <th>Is the lift closed?</th>
                                      <th>Are the fire doors opened?</th>
                                      <th>Has the patient safety officer announced evacuation?</th>
                                      <th>Are transportation modes available for evacuation?</th>
                                      <th>Is the triage arranged?</th>
                                      <th>Have they cleared the assembly point?</th>
                                      <th>Has the safety officer and team revisited the spot for follow-up?</th>
                                      <th>Code Red clearance time</th>
                                      <th>Are deviations explained?</th>
                                      <th>Have all events of Code Red been debriefed?</th>
                                      <th>Code Red closure time</th>
                                      <th>Additional comments</th>
                                    </tr>
                                </thead>';
								echo '<tbody>';
								$sl = 1;
								foreach ($data as $param) {
									echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" onclick="window.location=\'' . base_url('audit/code_red_feedback?id=') . $param->id . '\';" style="cursor: pointer;">';
									echo "<td>$sl</td>";
									echo '<td style="white-space: nowrap;">' .
										(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
										'</td>';
									echo '<td>' . $param->location . '</td>';
									echo '<td>' . $param->checklist . '</td>';
									echo '<td>' . $param->initial_assessment_hr1 . '</td>';
									echo '<td>' . $param->initial_assessment_hr2 . '</td>';
									echo '<td>' . $param->number_of_code . '</td>';
									echo '<td>' . $param->initial_assessment_hr3 . '</td>';
									echo '<td>' . $param->respondents . '</td>';
									echo '<td>' . $param->situation . '</td>';
									echo '<td>' . $param->fire . '</td>';
									echo '<td>' . $param->demonstrated . '</td>';
									echo '<td>' . $param->lift . '</td>';
									echo '<td>' . $param->doors . '</td>';
									echo '<td>' . $param->safety . '</td>';
									echo '<td>' . $param->transportation . '</td>';
									echo '<td>' . $param->action . '</td>';
									echo '<td>' . $param->assembly_point . '</td>';
									echo '<td>' . $param->follow_up . '</td>';
									echo '<td>' . $param->initial_assessment_hr4 . '</td>';
									echo '<td>' . $param->deviations . '</td>';
									echo '<td>' . $param->debrief . '</td>';
									echo '<td>' . $param->initial_assessment_hr5 . '</td>';
									echo '<td>' . $param->comments . '</td>';
									echo '</tr>';
									$sl++;
								}
								echo '</tbody>';
								echo '</table>';
							}
						}


						// Display the tables for each checklist type
						displayCodeRedTable($codeRedData);

						?>
					</div>
				</div>
				<!-- End of Code Red table -->
			</div>


			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Code Blue</h3>
					</div>
					<div class="panel-body">
						<?php
						// Initialize arrays to collect data for each checklist type
						$codeBlueData = [];

						// Collect data
						foreach ($feedbacktaken as $r) {
							$param = json_decode($r->dataset);
							if ($param->checklist == 'Code Blue') {
								// Add id to the data object
								$param->id = $r->id;
								$param->datetime = $r->datetime;
								$param->location = $r->location;
								$codeBlueData[] = $param;
							}
						}

						function displayCodeBlueTable($data)
						{
							if (!empty($data)) {
								echo '<table class="codeblue table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
								echo '<thead>
                                    <tr>
                                      <th>Sl. No.</th>
                                      <th>Date</th>
                                      <th>Location</th>
                                      <th>Hospital Emergency Code</th>
                                      <th>Spot activation time</th>
                                      <th>Announcement time</th>
                                      <th>Number of code announcements</th>
                                      <th>Team arrival time</th>
                                      <th>Number of Respondents</th>
                                      <th>Was the crash cart or emergency kit available?</th>
                                      <th>Was the patient identified?</th>
                                      <th>Was the patient\'s response checked?</th>
                                      <th>Was the patient\'s circulation (pulse) checked?</th>
                                      <th>Was the airway cleared?</th>
                                      <th>Was the patient\'s breathing checked?</th>
                                      <th>Was CPR started?</th>
                                      <th>Were compressions given as per standard?</th>
                                      <th>Were rescue breaths given?</th>
                                      <th>Were patient transportation modes available?</th>
                                      <th>Were proper safety measures used?</th>
                                      <th>Was a lift available?</th>
                                      <th>Was the patient shifted to the CCU?</th>
                                      <th>Code Blue clearance time</th>
                                      <th>Was the medical team available in the CCU?</th>
                                      <th>Was the CCU ready to receive the patient with adequate life support measures?</th>
                                      <th>Was the patient\'s condition assessed?</th>
                                      <th>Was DC shock applied?</th>
                                      <th>Were deviations communicated?</th>
                                      <th>Was there a repetition of deviated areas?</th>
                                      <th>Were all events of Code Blue debriefed?</th>
                                      <th>Code Blue closure time</th>
                                      <th>Additional comments</th>
                                    </tr>
                                </thead>';
								echo '<tbody>';
								$sl = 1;
								foreach ($data as $param) {
									echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" onclick="window.location=\'' . base_url('audit/code_blue_feedback?id=') . $param->id . '\';" style="cursor: pointer;">';
									echo "<td>$sl</td>";
									echo '<td style="white-space: nowrap;">' .
										(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
										'</td>';
									echo '<td>' . $param->location . '</td>';
									echo '<td>' . $param->checklist . '</td>';
									echo '<td>' . $param->initial_assessment_hr1 . '</td>';
									echo '<td>' . $param->initial_assessment_hr2 . '</td>';
									echo '<td>' . $param->number_of_code . '</td>';
									echo '<td>' . $param->initial_assessment_hr3 . '</td>';
									echo '<td>' . $param->respondents . '</td>';
									echo '<td>' . $param->emergency . '</td>';
									echo '<td>' . $param->identified . '</td>';
									echo '<td>' . $param->response . '</td>';
									echo '<td>' . $param->circulation . '</td>';
									echo '<td>' . $param->airway . '</td>';
									echo '<td>' . $param->breathing . '</td>';
									echo '<td>' . $param->cpr . '</td>';
									echo '<td>' . $param->compressions . '</td>';
									echo '<td>' . $param->rescue . '</td>';
									echo '<td>' . $param->mode . '</td>';
									echo '<td>' . $param->safety_measure . '</td>';
									echo '<td>' . $param->lift_avail . '</td>';
									echo '<td>' . $param->shift_ccu . '</td>';
									echo '<td>' . $param->initial_assessment_hr4 . '</td>';
									echo '<td>' . $param->medical . '</td>';
									echo '<td>' . $param->adequate . '</td>';
									echo '<td>' . $param->condition . '</td>';
									echo '<td>' . $param->shock . '</td>';
									echo '<td>' . $param->deviations_c . '</td>';
									echo '<td>' . $param->repetition . '</td>';
									echo '<td>' . $param->debriefed . '</td>';
									echo '<td>' . $param->initial_assessment_hr5 . '</td>';
									echo '<td>' . $param->comments . '</td>';
									echo '</tr>';
									$sl++;
								}
								echo '</tbody>';
								echo '</table>';
							}
						}


						// Display the tables for each checklist type
						displayCodeBlueTable($codeBlueData);
						?>
					</div>
				</div>
				<!-- End of Code Blue table -->
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
		var apiUrl = "https://" + domain + "/analytics_audit_quality/resposnsechart_tat_blood"; // Replace with your API endpoint
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
					label: "Audit Analysis",
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
							multistringText.push("Audits Conducted: " + all_detail.count);
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