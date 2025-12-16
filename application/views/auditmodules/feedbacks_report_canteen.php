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

	$table_feedback = 'bf_feedback_canteen_audit';
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
					<div class="panel-heading" style="text-align: right;">
						<div class="btn-group">
							<!-- <a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_download_total_feedback_tooltip'); ?>" href="<?php echo base_url($this->uri->segment(1)) . '/overall_patient_excel' ?>">
								<i class="fa fa-download"></i>
							</a> -->
						</div>
					</div>
					<div class="panel-body">
						<table class="canteen table table-striped table-hover table-bordered" cellspacing="0" width="100%">
							<thead>
								<th><?php echo lang_loader('ip', 'ip_slno'); ?></th>
								<th>Date</th>

								<th>Are walls, ceilings, and doors free from flaking paint/plaster?</th>
								<th>Are all equipment non-toxic and free from rust?</th>
								<th>Is potable water used where it contacts food?</th>
								<th>Is proper ventilation and lighting provided?</th>
								<th>Is there separate storage for raw materials, processed food, and packaging?</th>
								<th>Is all food stored properly in clean, closed containers with appropriate temperatures?</th>
								<th>Are hand washing, pot washing, and toilets segregated from food areas?</th>
								<th>Is cleaning done regularly, with pest control in place?</th>
								<th>Is food and water tested periodically in FSSAI labs?</th>
								<th>Is raw material procured from licensed suppliers, with expiry checked?</th>
								<th>Are cutlery and utensils made of food-grade materials?</th>
								<th>Is garbage removed on time and bins kept clean?</th>
								<th>Is there segregation of vegetarian and non-vegetarian food?</th>
								<th>Is there segregation of raw and cooked food?</th>
								<th>Are ill persons excluded from food handling?</th>
								<th>Do food handlers maintain personal hygiene?</th>

								<th>Is the FSSAI license updated and displayed?</th>
								<th>Does the premises design allow for cleaning and prevent dirt entry?</th>
								<th>Are internal structures made of non-toxic, impermeable materials?</th>
								<th>Are walls, ceilings, and doors free from shedding paint and condensation?</th>
								<th>Are floors non-absorbent, non-slippery, and sloped?</th>
								<th>Are windows fitted with insect-proof screens when open?</th>
								<th>Are doors smooth, non-absorbent, and pest-proof?</th>
								<th>Are containers made of non-toxic, impervious, and easy-to-clean materials?</th>
								<th>Are adequate heating, cooling, refrigeration, and freezing facilities available?</th>
								<th>Is there sufficient lighting, with fixtures protected to prevent contamination?</th>
								<th>Is there adequate storage for food, packaging materials, and chemicals?</th>
								<th>Are hygiene facilities available for staff (handwashing, toilets, changing rooms)?</th>
								<th>Is food tested in labs with proper records?</th>
								<th>Is raw material procured from approved vendors as per specifications?</th>
								<th>Are vegetables, fruits, and eggs inspected on receipt for safety hazards?</th>
								<th>Are materials stored hygienically at required temperatures, following FIFO/FEFO?</th>
								<th>Are raw materials cleaned thoroughly before food preparation?</th>

								<th>Is all equipment sanitized before and after use?</th>
								<th>Is frozen food thawed hygienically, with proper temperatures for different foods?</th>
								<th>Are vegetarian and non-vegetarian items cooked to safe temperatures?</th>
								<th>Is cooked food cooled to safe temperatures in a timely manner?</th>
								<th>Is food portioned in hygienic conditions, with high-risk food kept cold?</th>
								<th>Is hot food held at correct temperatures and monitored for up to 42 hours?</th>
								<th>Is reheating done appropriately, ensuring safe core temperatures?</th>
								<th>Is the oil used suitable for cooking and periodically checked?</th>
								<th>Are food transport vehicles clean and capable of maintaining required temperatures?</th>
								<th>Are food and non-food items separated during transportation?</th>
								<th>Are cutlery and dining accompaniments sanitized?</th>
								<th>Is packaging material of food-grade quality?</th>
								<th>Is equipment cleaning scheduled and water stagnation avoided?</th>
								<th>Is equipment maintained regularly as per manufacturer instructions?</th>
								<th>Are measuring and monitoring devices calibrated periodically?</th>
								<th>Is there a pest control program, with trained personnel and records?</th>
								<th>Are drains designed to handle flow loads and equipped with traps?</th>
								<th>Is food waste removed regularly to prevent accumulation?</th>

								<th>Are food handlers given medical exams and inoculations, with records?</th>
								<th>Are ill persons excluded from handling food or materials that touch food?</th>
								<th>Do food handlers maintain cleanliness and appropriate behavior?</th>
								<th>Are food handlers provided with necessary protective gear?</th>
								<th>Does the food business have a consumer complaints system?</th>
								<th>Are food handlers trained and equipped with necessary skills?</th>
								<th>Are records maintained for at least one year?</th>
								<th>Are tables and chairs kept clean?</th>
								<th>Is the waiting time for food supplies acceptable?</th>
								<th>Is the inpatient food supply schedule followed?</th>
								<th>Is banned synthetic substance use avoided?</th>
								<th>Are TPC meter checks used in food establishments on campus?</th>
								<th>Are used cooking oil disposal records maintained as per FSSAI guidelines?</th>
								<th>Is used cooking oil collected by authorized aggregators for biodiesel?</th>
								<th>Is daily food waste monitored and food waste audits conducted?</th>
								<th>Are methods used to reduce food waste (portion sizes, procurement, etc.)?</th>
								<th>Is food waste separated and recycled, reused, or composted?</th>
								<th>Is surplus food shared with those in need?</th>
								<th>Does the campus minimize plastic use with alternative options?</th>
								
								<th>Does the campus organize recycling drives for plastics, cans, and paper?</th>
								<th>Is water recycled and reused on campus?</th>
								<th>Are awareness messages about food safety regularly shared on campus?</th>
								<th>Are global food safety/environment days celebrated for awareness?</th>
								<th>Are activities organized monthly to encourage healthy food choices?</th>
								<th>Does the campus promote healthier food choices through various means?</th>
								<th>Is there a feedback system for suggestions, complaints, and improvements?</th>

								<th>Additional comments</th>

							</thead>
							<tbody>
								<?php $sl = 1; ?>
								<?php foreach ($feedbacktaken as $r) {
									// echo '<pre>';
									// print_r($r);
									$param = json_decode($r->dataset);
									// print_r($param);
									// exit;
									$id = $r->id;
									$check = true;


								?>

									<tr class="<?php echo ($sl & 1) ? 'odd gradeX' : 'even gradeC'; ?>" style="cursor: pointer;">
									<!-- onclick="window.location='<?php echo $canteen_audit_feedback . $id; ?>';" -->
										<td><?php echo $sl; ?></td>
										<td style="white-space: nowrap;">
											<?php if ($r->datetime) { ?>
												<?php echo date('d-M-Y', strtotime($r->datetime)); ?><br>
												<?php echo date('g:i a', strtotime($r->datetime)); ?>
											<?php } ?>
										</td>

										<td><?php echo $param->identification_details; ?></td>
										<td><?php echo $param->vital_signs; ?></td>
										<td><?php echo $param->surgery; ?></td>
										<td><?php echo $param->complaints_communicated; ?></td>
										<td><?php echo $param->intake; ?></td>
										<td><?php echo $param->output; ?></td>
										<td><?php echo $param->allergies; ?></td>
										<td><?php echo $param->medication; ?></td>
										<td><?php echo $param->diagnostic; ?></td>
										<td><?php echo $param->lab_results; ?></td>
										<td><?php echo $param->pending_investigation; ?></td>
										<td><?php echo $param->medicine_order; ?></td>
										<td><?php echo $param->facility_communicated; ?></td>
										<td><?php echo $param->health_education; ?></td>
										<td><?php echo $param->risk_assessment; ?></td>
										<td><?php echo $param->urethral; ?></td>
										<td><?php echo $param->urine_sample; ?></td>
										<td><?php echo $param->bystander; ?></td>
										<td><?php echo $param->instruments; ?></td>
										<td><?php echo $param->sterile; ?></td>
										<td><?php echo $param->antibiotics; ?></td>
										<td><?php echo $param->surgical_site; ?></td>
										<td><?php echo $param->wound; ?></td>
										<td><?php echo $param->documented; ?></td>
										<td><?php echo $param->adequate_facilities; ?></td>
										<td><?php echo $param->sufficient_lighting; ?></td>
										<td><?php echo $param->storage_facility_for_food; ?></td>
										<td><?php echo $param->personnel_hygiene_facilities; ?></td>
										<td><?php echo $param->food_material_testing; ?></td>
										<td><?php echo $param->incoming_material; ?></td>
										<td><?php echo $param->raw_materials_inspection; ?></td>
										<td><?php echo $param->storage_of_materials; ?></td>
										<td><?php echo $param->raw_materials_cleaning; ?></td>
										<td><?php echo $param->equipment_sanitization; ?></td>
										<td><?php echo $param->frozen_food_thawing; ?></td>
										<td><?php echo $param->vegetarian_and_non_vegetarian; ?></td>
										<td><?php echo $param->cooked_food_cooling; ?></td>
										<td><?php echo $param->food_portioning; ?></td>
										<td><?php echo $param->temperature_control; ?></td>
										<td><?php echo $param->reheating_food; ?></td>
										<td><?php echo $param->oil_suitability; ?></td>
										<td><?php echo $param->vehicles_for_food; ?></td>
										<td><?php echo $param->food_non_food_separation; ?></td>
										<td><?php echo $param->cutlery_crockery; ?></td>
										<td><?php echo $param->packaging_material_quality; ?></td>
										<td><?php echo $param->equipment_cleaning; ?></td>
										<td><?php echo $param->pm_of_equipment; ?></td>
										<td><?php echo $param->measuring_devices; ?></td>
										<td><?php echo $param->pest_control_program; ?></td>
										<td><?php echo $param->drain_design; ?></td>
										<td><?php echo $param->food_waste_removal; ?></td>
										<td><?php echo $param->food_handler_medical; ?></td>
										<td><?php echo $param->ill_individual_exclusion; ?></td>
										<td><?php echo $param->food_handler_personal; ?></td>
										<td><?php echo $param->food_handler_protection; ?></td>
										<td><?php echo $param->consumer_complaints; ?></td>
										<td><?php echo $param->food_handler_training; ?></td>
										<td><?php echo $param->documentation_and_records; ?></td>
										<td><?php echo $param->tables_and_chairs; ?></td>
										<td><?php echo $param->waiting_time_for_food; ?></td>
										<td><?php echo $param->inpatient_food_schedule; ?></td>
										<td><?php echo $param->use_of_banned_synthetic; ?></td>
										<td><?php echo $param->vegetable_oil; ?></td>
										<td><?php echo $param->used_oil_disposal; ?></td>
										<td><?php echo $param->used_oil_collection; ?></td>
										<td><?php echo $param->monitoring_food_waste; ?></td>
										<td><?php echo $param->food_waste_reduction; ?></td>
										<td><?php echo $param->food_waste_recycling; ?></td>
										<td><?php echo $param->surplus_food; ?></td>
										<td><?php echo $param->plastic_use; ?></td>
										<td><?php echo $param->waste_collection; ?></td>
										<td><?php echo $param->recycling_and_reusing; ?></td>
										<td><?php echo $param->awareness_messages; ?></td>
										<td><?php echo $param->celebration; ?></td>
										<td><?php echo $param->healthy_food_choices; ?></td>
										<td><?php echo $param->encouraging_healthier; ?></td>
										<td><?php echo $param->feedback_system; ?></td>

										<td><?php echo $r->comments; ?></td>

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
		var apiUrl = "https://" + domain + "/analytics_audit_quality/resposnsechart_canteen"; // Replace with your API endpoint
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