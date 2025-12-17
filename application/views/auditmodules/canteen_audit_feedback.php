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
				// echo '<pre>';
				// 					print_r($param);
				// 					echo '</pre>';
				// 					exit;

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
									<!-- Audit Details -->
									<tr>
										<th colspan="2" style="background-color: #f5f5f5; text-align: left;">Audit Details</th>
									</tr>
									<tr>
										<td>Audit Name</td>
										<td><?php echo $param['audit_type']; ?></td>
									</tr>
									<tr>
										<td>Date & Time of Audit</td>
										<td><?php echo date('Y-m-d H:i', strtotime($result->datetime)); ?></td>
									</tr>
									<tr>
										<td>Audit by</td>
										<td><?php echo $param['audit_by']; ?></td>
									</tr>



									<tr>
										<td>Area</td>
										<td><?php echo $param['location']; ?></td>
									</tr>


									<tr>
										<th colspan="2" style="background:#f0f0f0;"><b>PERSONAL HYGIENE</b></th>
									</tr>

									<tr>
										<td><b>Are hair caps worn by all food handlers?</b></td>
										<td>
											<?php echo !empty($param['identification_details']) ? ucfirst(htmlspecialchars($param['identification_details'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['identification_details_text']) ? htmlspecialchars($param['identification_details_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Are fingernails of food handlers short and clean?</b></td>
										<td>
											<?php echo !empty($param['vital_signs']) ? ucfirst(htmlspecialchars($param['vital_signs'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['vital_signs_text']) ? htmlspecialchars($param['vital_signs_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Are gloves worn by food handlers during the preparation of raw and cooked food?</b></td>
										<td>
											<?php echo !empty($param['surgery']) ? ucfirst(htmlspecialchars($param['surgery'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['surgery_text']) ? htmlspecialchars($param['surgery_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Are any open infections, cuts, or bandages on hands properly covered while handling food?</b></td>
										<td>
											<?php echo !empty($param['complaints_communicated']) ? ucfirst(htmlspecialchars($param['complaints_communicated'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['complaints_communicated_text']) ? htmlspecialchars($param['complaints_communicated_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Are adequate handwashing and drying facilities available?</b></td>
										<td>
											<?php echo !empty($param['intake']) ? ucfirst(htmlspecialchars($param['intake'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['intake_text']) ? htmlspecialchars($param['intake_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Do catering staff understand when and how to wash their hands?</b></td>
										<td>
											<?php echo !empty($param['output']) ? ucfirst(htmlspecialchars($param['output'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['output_text']) ? htmlspecialchars($param['output_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is smoking prohibited in the kitchen area?</b></td>
										<td>
											<?php echo !empty($param['allergies']) ? ucfirst(htmlspecialchars($param['allergies'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['allergies_text']) ? htmlspecialchars($param['allergies_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is Personal Hygiene training regularly provided to new and existing staff?</b></td>
										<td>
											<?php echo !empty($param['medication']) ? ucfirst(htmlspecialchars($param['medication'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['medication_text']) ? htmlspecialchars($param['medication_text']) : '-'; ?>
										</td>
									</tr>

									<!-- UTENSILS AND EQUIPMENT -->
									<tr>
										<td colspan="2" style="background:#f2f2f2;"><b>UTENSILS AND EQUIPMENT</b></td>
									</tr>

									<tr>
										<td><b>Are all small equipment and utensils, including cutting boards, thoroughly cleaned between uses?</b></td>
										<td>
											<?php echo !empty($param['diagnostic']) ? ucfirst(htmlspecialchars($param['diagnostic'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['diagnostic_text']) ? htmlspecialchars($param['diagnostic_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Are all utensils clean and dry?</b></td>
										<td>
											<?php echo !empty($param['lab_results']) ? ucfirst(htmlspecialchars($param['lab_results'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['lab_results_text']) ? htmlspecialchars($param['lab_results_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Are work surfaces clean?</b></td>
										<td>
											<?php echo !empty($param['pending_investigation']) ? ucfirst(htmlspecialchars($param['pending_investigation'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['pending_investigation_text']) ? htmlspecialchars($param['pending_investigation_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Are drawers and racks clean?</b></td>
										<td>
											<?php echo !empty($param['medicine_order']) ? ucfirst(htmlspecialchars($param['medicine_order'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['medicine_order_text']) ? htmlspecialchars($param['medicine_order_text']) : '-'; ?>
										</td>
									</tr>
									<!-- CLEANING -->
									<tr>
										<td colspan="2" style="background:#f2f2f2;"><b>CLEANING</b></td>
									</tr>

									<tr>
										<td><b>Is there periodic cleaning schedule in place for utensils, equipment, and canteen areas?</b></td>
										<td>
											<?php echo !empty($param['facility_communicated']) ? ucfirst(htmlspecialchars($param['facility_communicated'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['facility_communicated_text']) ? htmlspecialchars($param['facility_communicated_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is cleaning equipment stored appropriately?</b></td>
										<td>
											<?php echo !empty($param['health_education']) ? ucfirst(htmlspecialchars($param['health_education'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['health_education_text']) ? htmlspecialchars($param['health_education_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is the dining area clean and sanitized?</b></td>
										<td>
											<?php echo !empty($param['risk_assessment']) ? ucfirst(htmlspecialchars($param['risk_assessment'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['risk_assessment_text']) ? htmlspecialchars($param['risk_assessment_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Are cleaning solutions properly labelled and stored?</b></td>
										<td>
											<?php echo !empty($param['urethral']) ? ucfirst(htmlspecialchars($param['urethral'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['urethral_text']) ? htmlspecialchars($param['urethral_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Are Material Safety Data Sheets (MSDS) for chemicals available?</b></td>
										<td>
											<?php echo !empty($param['urine_sample']) ? ucfirst(htmlspecialchars($param['urine_sample'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['urine_sample_text']) ? htmlspecialchars($param['urine_sample_text']) : '-'; ?>
										</td>
									</tr>
									<!-- GARBAGE DISPOSAL -->
									<tr>
										<td colspan="2" style="background:#f2f2f2;"><b>GARBAGE DISPOSAL</b></td>
									</tr>

									<tr>
										<td><b>Are garbage containers regularly washed and well maintained?</b></td>
										<td>
											<?php echo !empty($param['bystander']) ? ucfirst(htmlspecialchars($param['bystander'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['bystander_text']) ? htmlspecialchars($param['bystander_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is the garbage/waste storage area protected from insects, pests, or rodent infestation?</b></td>
										<td>
											<?php echo !empty($param['instruments']) ? ucfirst(htmlspecialchars($param['instruments'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['instruments_text']) ? htmlspecialchars($param['instruments_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is garbage removed from the canteen in a timely manner?</b></td>
										<td>
											<?php echo !empty($param['sterile']) ? ucfirst(htmlspecialchars($param['sterile'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['sterile_text']) ? htmlspecialchars($param['sterile_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Are records of food waste disposal maintained?</b></td>
										<td>
											<?php echo !empty($param['antibiotics']) ? ucfirst(htmlspecialchars($param['antibiotics'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['antibiotics_text']) ? htmlspecialchars($param['antibiotics_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Are records of oil waste disposal maintained?</b></td>
										<td>
											<?php echo !empty($param['surgical_site']) ? ucfirst(htmlspecialchars($param['surgical_site'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['surgical_site_text']) ? htmlspecialchars($param['surgical_site_text']) : '-'; ?>
										</td>
									</tr>
									<!-- PEST CONTROL -->
									<tr>
										<td colspan="2" style="background:#f2f2f2;"><b>PEST CONTROL</b></td>
									</tr>
									<tr>
										<td><b>Is a regular pest control program in place, and are records of the same available?</b></td>
										<td>
											<?php echo !empty($param['wound']) ? ucfirst(htmlspecialchars($param['wound'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['wound_text']) ? htmlspecialchars($param['wound_text']) : '-'; ?>
										</td>
									</tr>

									<!-- RECEIVING -->
									<tr>
										<td colspan="2" style="background:#f2f2f2;"><b>RECEIVING</b></td>
									</tr>
									<tr>
										<td><b>Are products supplied by approved suppliers?</b></td>
										<td>
											<?php echo !empty($param['documented']) ? ucfirst(htmlspecialchars($param['documented'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['documented_text']) ? htmlspecialchars($param['documented_text']) : '-'; ?>
										</td>
									</tr>
									<tr>
										<td><b>Are incoming food and supplies promptly inspected upon receipt?</b></td>
										<td>
											<?php echo !empty($param['adequate_facilities']) ? ucfirst(htmlspecialchars($param['adequate_facilities'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['adequate_facilities_text']) ? htmlspecialchars($param['adequate_facilities_text']) : '-'; ?>
										</td>
									</tr>
									<tr>
										<td><b>Are all food items, materials, and supplies immediately moved to appropriate storage areas?</b></td>
										<td>
											<?php echo !empty($param['sufficient_lighting']) ? ucfirst(htmlspecialchars($param['sufficient_lighting'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['sufficient_lighting_text']) ? htmlspecialchars($param['sufficient_lighting_text']) : '-'; ?>
										</td>
									</tr>
									<tr>
										<td><b>Is all food labelled with the name and delivery/expiry date?</b></td>
										<td>
											<?php echo !empty($param['storage_facility_for_food']) ? ucfirst(htmlspecialchars($param['storage_facility_for_food'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['storage_facility_for_food_text']) ? htmlspecialchars($param['storage_facility_for_food_text']) : '-'; ?>
										</td>
									</tr>
									<tr>
										<td><b>Is food protected from contamination during the receiving process?</b></td>
										<td>
											<?php echo !empty($param['personnel_hygiene_facilities']) ? ucfirst(htmlspecialchars($param['personnel_hygiene_facilities'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['personnel_hygiene_facilities_text']) ? htmlspecialchars($param['personnel_hygiene_facilities_text']) : '-'; ?>
										</td>
									</tr>

									<!-- STORAGE -->
									<tr>
										<td colspan="2" style="background:#f2f2f2;"><b>STORAGE</b></td>
									</tr>
									<tr>
										<td><b>Is there proper separation between food and chemicals in storage areas?</b></td>
										<td>
											<?php echo !empty($param['food_material_testing']) ? ucfirst(htmlspecialchars($param['food_material_testing'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['food_material_testing_text']) ? htmlspecialchars($param['food_material_testing_text']) : '-'; ?>
										</td>
									</tr>
									<tr>
										<td><b>Is air-conditioned storage available where required?</b></td>
										<td>
											<?php echo !empty($param['incoming_material']) ? ucfirst(htmlspecialchars($param['incoming_material'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['incoming_material_text']) ? htmlspecialchars($param['incoming_material_text']) : '-'; ?>
										</td>
									</tr>
									<tr>
										<td><b>Is all food stored off the floor?</b></td>
										<td>
											<?php echo !empty($param['raw_materials_inspection']) ? ucfirst(htmlspecialchars($param['raw_materials_inspection'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['raw_materials_inspection_text']) ? htmlspecialchars($param['raw_materials_inspection_text']) : '-'; ?>
										</td>
									</tr>
									<tr>
										<td><b>Is the storage unit clean?</b></td>
										<td>
											<?php echo !empty($param['storage_of_materials']) ? ucfirst(htmlspecialchars($param['storage_of_materials'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['storage_of_materials_text']) ? htmlspecialchars($param['storage_of_materials_text']) : '-'; ?>
										</td>
									</tr>

									<!-- TRANSPORT -->
									<tr>
										<td colspan="2" style="background:#f2f2f2;"><b>TRANSPORT</b></td>
									</tr>
									<tr>
										<td><b>Are transport containers and carts regularly cleaned?</b></td>
										<td>
											<?php echo !empty($param['raw_materials_cleaning']) ? ucfirst(htmlspecialchars($param['raw_materials_cleaning'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['raw_materials_cleaning_text']) ? htmlspecialchars($param['raw_materials_cleaning_text']) : '-'; ?>
										</td>
									</tr>
									<tr>
										<td><b>Are proper temperatures maintained during transport for hot foods?</b></td>
										<td>
											<?php echo !empty($param['equipment_sanitization']) ? ucfirst(htmlspecialchars($param['equipment_sanitization'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['equipment_sanitization_text']) ? htmlspecialchars($param['equipment_sanitization_text']) : '-'; ?>
										</td>
									</tr>
									<tr>
										<td><b>Are transport trolleys clean?</b></td>
										<td>
											<?php echo !empty($param['frozen_food_thawing']) ? ucfirst(htmlspecialchars($param['frozen_food_thawing'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['frozen_food_thawing_text']) ? htmlspecialchars($param['frozen_food_thawing_text']) : '-'; ?>
										</td>
									</tr>

									<!-- HEALTH -->
									<tr>
										<td colspan="2" style="background:#f2f2f2;"><b>HEALTH</b></td>
									</tr>
									<tr>
										<td><b>Are food handlers' medical checkup records up to date?</b></td>
										<td>
											<?php echo !empty($param['vegetarian_and_non_vegetarian']) ? ucfirst(htmlspecialchars($param['vegetarian_and_non_vegetarian'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['vegetarian_and_non_vegetarian_text']) ? htmlspecialchars($param['vegetarian_and_non_vegetarian_text']) : '-'; ?>
										</td>
									</tr>
									<tr>
										<td><b>Is Food Safety training regularly provided?</b></td>
										<td>
											<?php echo !empty($param['cooked_food_cooling']) ? ucfirst(htmlspecialchars($param['cooked_food_cooling'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['cooked_food_cooling_text']) ? htmlspecialchars($param['cooked_food_cooling_text']) : '-'; ?>
										</td>
									</tr>

									<!-- QUALITY -->
									<tr>
										<td colspan="2" style="background:#f2f2f2;"><b>QUALITY</b></td>
									</tr>
									<tr>
										<td><b>Are food samples preserved for 24 hours?</b></td>
										<td>
											<?php echo !empty($param['food_portioning']) ? ucfirst(htmlspecialchars($param['food_portioning'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['food_portioning_text']) ? htmlspecialchars($param['food_portioning_text']) : '-'; ?>
										</td>
									</tr>







									<tr>
										<td><b>Uploaded files</b></td>
										<td>
											<?php
											if (!empty($param['files_name']) && is_array($param['files_name'])) {
												foreach ($param['files_name'] as $file) {
													echo '<a href="' . htmlspecialchars($file['url']) . '" target="_blank">' . htmlspecialchars($file['name']) . '</a><br>';
												}
											} else {
												echo 'No files uploaded';
											}
											?>
										</td>
									</tr>

									<tr>
										<td><b>Additional comments</b></td>
										<td>
											<?php echo $result->comments; ?>
										</td>
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