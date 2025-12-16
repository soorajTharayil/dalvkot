<div class="content">

	<?php
	if ($this->input->post('id') || $this->input->get('id')) {
		$email = $this->session->userdata['email'];

		$hide = true;
		if ($this->input->post('id')) {
			$id = $this->input->post('id');
		} else {
			$id = $this->input->get('id');
		}
		$this->db->where('id', $id);
		$query = $this->db->get('bf_feedback_canteen_audit');
		$results = $query->result();

		if (count($results) >= 1) {
			foreach ($results as $result) {
				$param = json_decode($result->dataset, true);
				
	?>

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>"> <i class="fa fa-question-circle" aria-hidden="true"></i></a> Canteen audit checklist - <?php echo $result->id; ?> </h3>
							</div>
							<?php if (ismodule_active('AUDIT') === true  && isfeature_active('AUDIT-EDIT-PERMISSION') === true) { ?>
								<div class="btn-group" style="float: right;">
									<a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_canteen_audit/$id") ?>"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit </a>
								</div>
							<?php } ?>
							<div class="panel-body" style="background: #fff;">


								<table class=" table table-striped table-bordered  no-footer dtr-inline " style="font-size: 16px;">

									<tr>
										<td><b>Are walls, ceilings, and doors free from flaking paint/plaster?</b></td>
										<td><?php echo $param->identification_details; ?></td>
									</tr>
									<tr>
										<td><b>Are all equipment non-toxic and free from rust?</b></td>
										<td><?php echo $param->vital_signs; ?></td>
									</tr>
									<tr>
										<td><b>Is potable water used where it contacts food?</b></td>
										<td><?php echo $param->surgery; ?></td>
									</tr>
									<tr>
										<td><b>Is proper ventilation and lighting provided?</b></td>
										<td><?php echo $param->complaints_communicated; ?></td>
									</tr>
									<tr>
										<td><b>Is there separate storage for raw materials, processed food, and packaging?</b></td>
										<td><?php echo $param->intake; ?></td>
									</tr>
									<tr>
										<td><b>Is all food stored properly in clean, closed containers with appropriate temperatures?</b></td>
										<td><?php echo $param->output; ?></td>
									</tr>
									<tr>
										<td><b>Are hand washing, pot washing, and toilets segregated from food areas?</b></td>
										<td><?php echo $param->allergies; ?></td>
									</tr>
									<tr>
										<td><b>Is cleaning done regularly, with pest control in place?</b></td>
										<td><?php echo $param->medication; ?></td>
									</tr>
									<tr>
										<td><b>Is food and water tested periodically in FSSAI labs?</b></td>
										<td><?php echo $param->diagnostic; ?></td>
									</tr>
									<tr>
										<td><b>Is raw material procured from licensed suppliers, with expiry checked?</b></td>
										<td><?php echo $param->lab_results; ?></td>
									</tr>
									<tr>
										<td><b>Are cutlery and utensils made of food-grade materials?</b></td>
										<td><?php echo $param->pending_investigation; ?></td>
									</tr>
									<tr>
										<td><b>Is garbage removed on time and bins kept clean?</b></td>
										<td><?php echo $param->medicine_order; ?></td>
									</tr>
									<tr>
										<td><b>Is there segregation of vegetarian and non-vegetarian food?</b></td>
										<td><?php echo $param->facility_communicated; ?></td>
									</tr>
									<tr>
										<td><b>Is there segregation of raw and cooked food?</b></td>
										<td><?php echo $param->health_education; ?></td>
									</tr>
									<tr>
										<td><b>Are ill persons excluded from food handling?</b></td>
										<td><?php echo $param->risk_assessment; ?></td>
									</tr>
									<tr>
										<td><b>Do food handlers maintain personal hygiene?</b></td>
										<td><?php echo $param->urethral; ?></td>
									</tr>

									<tr>
										<td><b>Is the FSSAI license updated and displayed?</b></td>
										<td><?php echo $param->urine_sample; ?></td>
									</tr>
									<tr>
										<td><b>Does the premises design allow for cleaning and prevent dirt entry?</b></td>
										<td><?php echo $param->bystander; ?></td>
									</tr>
									<tr>
										<td><b>Are internal structures made of non-toxic, impermeable materials?</b></td>
										<td><?php echo $param->instruments; ?></td>
									</tr>
									<tr>
										<td><b>Are walls, ceilings, and doors free from shedding paint and condensation?</b></td>
										<td><?php echo $param->sterile; ?></td>
									</tr>
									<tr>
										<td><b>Are floors non-absorbent, non-slippery, and sloped?</b></td>
										<td><?php echo $param->antibiotics; ?></td>
									</tr>
									<tr>
										<td><b>Are windows fitted with insect-proof screens when open?</b></td>
										<td><?php echo $param->surgical_site; ?></td>
									</tr>
									<tr>
										<td><b>Are doors smooth, non-absorbent, and pest-proof?</b></td>
										<td><?php echo $param->wound; ?></td>
									</tr>
									<tr>
										<td><b>Are containers made of non-toxic, impervious, and easy-to-clean materials?</b></td>
										<td><?php echo $param->documented; ?></td>
									</tr>
									<tr>
										<td><b>Are adequate heating, cooling, refrigeration, and freezing facilities available?</b></td>
										<td><?php echo $param->adequate_facilities; ?></td>
									</tr>
									<tr>
										<td><b>Is there sufficient lighting, with fixtures protected to prevent contamination?</b></td>
										<td><?php echo $param->sufficient_lighting; ?></td>
									</tr>
									<tr>
										<td><b>Is there adequate storage for food, packaging materials, and chemicals?</b></td>
										<td><?php echo $param->storage_facility_for_food; ?></td>
									</tr>
									<tr>
										<td><b>Are hygiene facilities available for staff (handwashing, toilets, changing rooms)?</b></td>
										<td><?php echo $param->personnel_hygiene_facilities; ?></td>
									</tr>
									<tr>
										<td><b>Is food tested in labs with proper records?</b></td>
										<td><?php echo $param->food_material_testing; ?></td>
									</tr>
									<tr>
										<td><b>Is raw material procured from approved vendors as per specifications?</b></td>
										<td><?php echo $param->incoming_material; ?></td>
									</tr>
									<tr>
										<td><b>Are vegetables, fruits, and eggs inspected on receipt for safety hazards?</b></td>
										<td><?php echo $param->raw_materials_inspection; ?></td>
									</tr>
									<tr>
										<td><b>Are materials stored hygienically at required temperatures, following FIFO/FEFO?</b></td>
										<td><?php echo $param->storage_of_materials; ?></td>
									</tr>
									<tr>
										<td><b>Are raw materials cleaned thoroughly before food preparation?</b></td>
										<td><?php echo $param->raw_materials_cleaning; ?></td>
									</tr>

									<tr>
										<td><b>Is all equipment sanitized before and after use?</b></td>
										<td><?php echo $param->equipment_sanitization; ?></td>
									</tr>
									<tr>
										<td><b>Is frozen food thawed hygienically, with proper temperatures for different foods?</b></td>
										<td><?php echo $param->frozen_food_thawing; ?></td>
									</tr>
									<tr>
										<td><b>Are vegetarian and non-vegetarian items cooked to safe temperatures?</b></td>
										<td><?php echo $param->vegetarian_and_non_vegetarian; ?></td>
									</tr>
									<tr>
										<td><b>Is cooked food cooled to safe temperatures in a timely manner?</b></td>
										<td><?php echo $param->cooked_food_cooling; ?></td>
									</tr>
									<tr>
										<td><b>Is food portioned in hygienic conditions, with high-risk food kept cold?</b></td>
										<td><?php echo $param->food_portioning; ?></td>
									</tr>
									<tr>
										<td><b>Is hot food held at correct temperatures and monitored for up to 42 hours?</b></td>
										<td><?php echo $param->temperature_control; ?></td>
									</tr>
									<tr>
										<td><b>Is reheating done appropriately, ensuring safe core temperatures?</b></td>
										<td><?php echo $param->reheating_food; ?></td>
									</tr>
									<tr>
										<td><b>Is the oil used suitable for cooking and periodically checked?</b></td>
										<td><?php echo $param->oil_suitability; ?></td>
									</tr>
									<tr>
										<td><b>Are food transport vehicles clean and capable of maintaining required temperatures?</b></td>
										<td><?php echo $param->vehicles_for_food; ?></td>
									</tr>
									<tr>
										<td><b>Are food and non-food items separated during transportation?</b></td>
										<td><?php echo $param->food_non_food_separation; ?></td>
									</tr>
									<tr>
										<td><b>Are cutlery and dining accompaniments sanitized?</b></td>
										<td><?php echo $param->cutlery_crockery; ?></td>
									</tr>
									<tr>
										<td><b>Is packaging material of food-grade quality?</b></td>
										<td><?php echo $param->packaging_material_quality; ?></td>
									</tr>
									<tr>
										<td><b>Is equipment cleaning scheduled and water stagnation avoided?</b></td>
										<td><?php echo $param->equipment_cleaning; ?></td>
									</tr>
									<tr>
										<td><b>Is equipment maintained regularly as per manufacturer instructions?</b></td>
										<td><?php echo $param->pm_of_equipment; ?></td>
									</tr>
									<tr>
										<td><b>Are measuring and monitoring devices calibrated periodically?</b></td>
										<td><?php echo $param->measuring_devices; ?></td>
									</tr>
									<tr>
										<td><b>Is there a pest control program, with trained personnel and records?</b></td>
										<td><?php echo $param->pest_control_program; ?></td>
									</tr>
									<tr>
										<td><b>Are drains designed to handle flow loads and equipped with traps?</b></td>
										<td><?php echo $param->drain_design; ?></td>
									</tr>
									<tr>
										<td><b>Is food waste removed regularly to prevent accumulation?</b></td>
										<td><?php echo $param->food_waste_removal; ?></td>
									</tr>

									<tr>
										<td><b>Are food handlers given medical exams and inoculations, with records?</b></td>
										<td><?php echo $param->food_handler_medical; ?></td>
									</tr>
									<tr>
										<td><b>Are ill persons excluded from handling food or materials that touch food?</b></td>
										<td><?php echo $param->ill_individual_exclusion; ?></td>
									</tr>
									<tr>
										<td><b>Do food handlers maintain cleanliness and appropriate behavior?</b></td>
										<td><?php echo $param->food_handler_personal; ?></td>
									</tr>
									<tr>
										<td><b>Are food handlers provided with necessary protective gear?</b></td>
										<td><?php echo $param->food_handler_protection; ?></td>
									</tr>
									<tr>
										<td><b>Does the food business have a consumer complaints system?</b></td>
										<td><?php echo $param->consumer_complaints; ?></td>
									</tr>
									<tr>
										<td><b>Are food handlers trained and equipped with necessary skills?</b></td>
										<td><?php echo $param->food_handler_training; ?></td>
									</tr>
									<tr>
										<td><b>Are records maintained for at least one year?</b></td>
										<td><?php echo $param->documentation_and_records; ?></td>
									</tr>
									<tr>
										<td><b>Are tables and chairs kept clean?</b></td>
										<td><?php echo $param->tables_and_chairs; ?></td>
									</tr>
									<tr>
										<td><b>Is the waiting time for food supplies acceptable?</b></td>
										<td><?php echo $param->waiting_time_for_food; ?></td>
									</tr>
									<tr>
										<td><b>Is the inpatient food supply schedule followed?</b></td>
										<td><?php echo $param->inpatient_food_schedule; ?></td>
									</tr>
									<tr>
										<td><b>Is banned synthetic substance use avoided?</b></td>
										<td><?php echo $param->use_of_banned_synthetic; ?></td>
									</tr>
									<tr>
										<td><b>Are TPC meter checks used in food establishments on campus?</b></td>
										<td><?php echo $param->vegetable_oil; ?></td>
									</tr>
									<tr>
										<td><b>Are used cooking oil disposal records maintained as per FSSAI guidelines?</b></td>
										<td><?php echo $param->used_oil_disposal; ?></td>
									</tr>
									<tr>
										<td><b>Is used cooking oil collected by authorized aggregators for biodiesel?</b></td>
										<td><?php echo $param->used_oil_collection; ?></td>
									</tr>
									<tr>
										<td><b>Is daily food waste monitored and food waste audits conducted?</b></td>
										<td><?php echo $param->monitoring_food_waste; ?></td>
									</tr>
									<tr>
										<td><b>Are methods used to reduce food waste (portion sizes, procurement, etc.)?</b></td>
										<td><?php echo $param->food_waste_reduction; ?></td>
									</tr>
									<tr>
										<td><b>Is food waste separated and recycled, reused, or composted?</b></td>
										<td><?php echo $param->food_waste_recycling; ?></td>
									</tr>
									<tr>
										<td><b>Is surplus food shared with those in need?</b></td>
										<td><?php echo $param->surplus_food; ?></td>
									</tr>
									<tr>
										<td><b>Does the campus minimize plastic use with alternative options?</b></td>
										<td><?php echo $param->plastic_use; ?></td>
									</tr>

									<tr>
										<td><b>Does the campus organize recycling drives for plastics, cans, and paper?</b></td>
										<td><?php echo $param->waste_collection; ?></td>
									</tr>
									<tr>
										<td><b>Is water recycled and reused on campus?</b></td>
										<td><?php echo $param->recycling_and_reusing; ?></td>
									</tr>
									<tr>
										<td><b>Are awareness messages about food safety regularly shared on campus?</b></td>
										<td><?php echo $param->awareness_messages; ?></td>
									</tr>
									<tr>
										<td><b>Are global food safety/environment days celebrated for awareness?</b></td>
										<td><?php echo $param->celebration; ?></td>
									</tr>
									<tr>
										<td><b>Are activities organized monthly to encourage healthy food choices?</b></td>
										<td><?php echo $param->healthy_food_choices; ?></td>
									</tr>
									<tr>
										<td><b>Does the campus promote healthier food choices through various means?</b></td>
										<td><?php echo $param->encouraging_healthier; ?></td>
									</tr>
									<tr>
										<td><b>Is there a feedback system for suggestions, complaints, and improvements?</b></td>
										<td><?php echo $param->feedback_system; ?></td>
									</tr>

									<tr>
										<td><b>Additional comments</b></td>
										<td>
											<?php echo $result->comments; ?>
										</td>
									</tr>

									<tr>
										<td><b>Data collected by</b></td>
										<td>
											<?php echo $result->name; ?>

										</td>
									</tr>
									<tr>
										<td><b>Data collection on</b></td>
										<td><?php echo date('g:i a, d-M-Y', strtotime($result->datetime)); ?></td>
									</tr>



								</table>






							<?php } ?>
						<?php } else {  ?>
							<div class="row">
								<div class="col-sm-12">
									<div class="panel panel-default ">
										<div class="panel-heading">
											<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('ip', 'ip_no_record_found'); ?> <br>
												<a href="<?php echo base_url(uri_string(1)); ?>">
													<button type="button" href="javascript:void()" data-toggle="tooltip" title="Back" class="btn btn-sm btn-success" style="text-align: center;">
														<i class="fa fa-arrow-left"></i>
													</button>
													<?php //$_SESSION['ward'] = 'ALL';
													//$fdate = date('Y-m-d', time());
													//$tdate = date('Y-m-d', strtotime('-90 days'));
													//$_SESSION['from_date'] = $fdate;
													//$_SESSION['to_date'] = $tdate; 
													?>
												</a>
											</h3>
										</div>
									</div>
								</div>
							</div>
					<?php }
				} ?>

					<?php if ($hide == false) { ?>
						<div class="row">
							<div class="col-sm-12">
								<div class="panel panel-default ">
									<div class="panel-heading">

										<?php echo form_open(); ?>
										<table class="table">
											<tr>
												<th class="" style="border:none !important;vertical-align: middle; text-align:right;"><?php echo lang_loader('ip', 'ip_feedback_id'); ?></th>
												<td class="" style="border:none !important;">
													<input type="text" class="form-control" placeholder="Enter Feedback ID" maxlength="15" size="10" name="pid">
												</td>
												<th class="" style="text-align:left;">
													<p style="text-align:left;"><a href="javascript:void()" data-toggle="tooltip" title="Search"><button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button></a>

												</th>
											</tr>
										</table>
										</form>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>




							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<!-- <div class="panel panel-default">

							<canvas id="barChart" width="400" height="200" style="width: 50%;padding:50px;"></canvas>

						</div> -->
					</div>
				</div>



				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

				<style>
					ul.feedback {
						margin: 0px;
						padding: 0px;
					}

					ul.feedback li {
						list-style: none;
					}

					li#feedback {
						list-style: none;
						padding: 5px;
						width: 100%;
						background: #f7f7f7;
						margin: 8px;
						box-shadow: -1px 1px 0px #ccc;
						border-radius: 5px;
					}

					li#feedback h4 {
						margin: 0px;
						font-weight: bold;
					}

					span.fa.fa-star {
						visibility: hidden;
					}

					.checked {
						color: orange;
						visibility: visible !important;
					}

					ul.feedback li {
						list-style: none;
					}
				</style>
				<script>
					// Data
					var benchmark = "<?php echo $param['benchmark']; ?>"; // Benchmark value
					var calculated = "<?php echo $result->average_time_taken_initial_assessment; ?>"; // Calculated value

					// Parse times to seconds
					var benchmarkSeconds = parseTimeToSeconds(benchmark);
					var calculatedSeconds = parseTimeToSeconds(calculated);

					// Determine colors based on comparison
					var calculatedColor = calculatedSeconds > benchmarkSeconds ? 'rgba(234, 67, 53, 0.8)' : 'rgba(52, 168, 83, 1)'; // Red if calculated is greater, otherwise blue
					var calculatedBorderColor = calculatedSeconds > benchmarkSeconds ? 'rgba(234, 67, 53, 0.8)' : 'rgba(52, 168, 83, 1)';

					// Create the chart
					var ctx = document.getElementById('barChart').getContext('2d');
					var myChart = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: ['Benchmark Time', 'Avg. Time taken for initial assessment of indoor patients'],
							datasets: [{
									label: 'Benchmark Time',
									data: [benchmarkSeconds, null],
									backgroundColor: 'rgba(56, 133, 244, 1)', // Red color for benchmark
									borderColor: 'rgba(54, 162, 235, 1)',
									borderWidth: 1,
									barThickness: 200
								},
								{
									label: 'Avg. Time taken for initial assessment of indoor patients',
									data: [null, calculatedSeconds],
									backgroundColor: calculatedColor, // Dynamic color for calculated
									borderColor: calculatedBorderColor,
									borderWidth: 1,
									barThickness: 200
								}
							]
						},
						options: {
							scales: {
								y: {
									ticks: {
										callback: function(value) {
											return secondsToTime(value); // Convert seconds to time format (hh:mm:ss)
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
							indexAxis: 'x', // Horizontal bar chart
							categorySpacing: 0, // Remove spacing between bars
							barPercentage: -1 // Reduce the width of the bars
						}
					});

					// Function to parse time to seconds
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
				</script>