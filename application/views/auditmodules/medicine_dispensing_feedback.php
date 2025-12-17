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
		$query = $this->db->get('bf_feedback_medicine_dispense');
		$results = $query->result();

		if (count($results) >= 1) {
			foreach ($results as $result) {
				$param = json_decode($result->dataset, true);

				// echo '<pre>';
				// print_r($param);
				// exit;


	?>

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>"> <i class="fa fa-question-circle" aria-hidden="true"></i></a> Medication management process audit - <?php echo $result->id; ?> </h3>
							</div>
							<?php if (ismodule_active('AUDIT') === true  && isfeature_active('AUDIT-EDIT-PERMISSION') === true) { ?>
								<div class="btn-group" style="float: right;">
									<a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_medicine_dispensing/$id") ?>"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit </a>
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
										<th colspan="2" style="background-color: #f5f5f5; text-align: left;">Patient Information</th>
									</tr>
									<tr>
										<td>Patient UHID</td>
										<td><?php echo $param['mid_no']; ?></td>
									</tr>
									<tr>
										<td>Patient Name</td>
										<td><?php echo $param['patient_name']; ?></td>
									</tr>
									<tr>
										<td>Patient Age</td>
										<td><?php echo $param['patient_age']; ?></td>
									</tr>
									<tr>
										<td>Patient Gender</td>
										<td><?php echo $param['patient_gender']; ?></td>
									</tr>
									<tr>
										<td>Area</td>
										<td><?php echo $param['location']; ?></td>
									</tr>
									<tr>
										<td>Department</td>
										<td><?php echo $param['department']; ?></td>
									</tr>
									<tr>
										<td>Attended Doctor</td>
										<td><?php echo $param['attended_doctor']; ?></td>
									</tr>
									<tr>
										<td>Admission / Visit Date & Time</td>
										<td><?php echo date('Y-m-d H:i', strtotime($param['initial_assessment_hr6'])); ?></td>
									</tr>
									<tr>
										<td>Discharge Date & Time</td>
										<td>
											<?php
											if (!empty($param['discharge_date_time']) && strtotime($param['discharge_date_time']) > 0 && $param['discharge_date_time'] != '1970-01-01 05:30:00') {
												echo date('Y-m-d H:i', strtotime($param['discharge_date_time']));
											} else {
												echo '-';
											}
											?>
										</td>
									</tr>

									<tr>
										<td><b>Consultant Name</b></td>
										<td>
											<?php echo $param['consultant_name']; ?>
										</td>
									</tr>

									<tr>
										<td><b>Diagnosis</b></td>
										<td>
											<?php echo $param['diagnosis']; ?>
										</td>
									</tr>

									<tr>
										<td><b>Medicine Name</b></td>
										<td>
											<?php echo $param['medicinename']; ?>
										</td>
									</tr>


									<tr>
										<td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
											I. DOCTORS
										</td>
									</tr>

									<tr>
										<td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
											1. Incorrect Prescription
										</td>
									</tr>


									<tr>
										<td><b>a. Has the correct drug been selected for the patient's condition?</b></td>
										<td>
											<?php echo $param['correct_medicine']; ?>
											<br>
											Remarks: <?php echo !empty($param['correct_medicine_text']) ? $param['correct_medicine_text'] : '-'; ?>
										</td>
									</tr>


									<tr>
										<td><b>b. Has the appropriate dose been prescribed?</b></td>
										<td>
											<?php echo $param['correct_quantity']; ?>
											<br>
											Remarks: <?php echo !empty($param['correct_quantity_text']) ? $param['correct_quantity_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>c. Has the correct unit of measurement for the drug dose been used?</b></td>
										<td>
											<?php echo $param['medicine_expiry']; ?>
											<br>
											Remarks: <?php echo !empty($param['medicine_expiry_text']) ? $param['medicine_expiry_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>d. Has the correct frequency of administration been specified?</b></td>
										<td>
											<?php echo $param['apron']; ?>
											<br>
											Remarks: <?php echo !empty($param['apron_text']) ? $param['apron_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>e. Has the correct route of administration been mentioned?</b></td>
										<td>
											<?php echo $param['lead_apron']; ?>
											<br>
											Remarks: <?php echo !empty($param['lead_apron_text']) ? $param['lead_apron_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>f. Has the correct drug concentration been prescribed?</b></td>
										<td>
											<?php echo $param['use_xray_barrior']; ?>
											<br>
											Remarks: <?php echo !empty($param['use_xray_barrior_text']) ? $param['use_xray_barrior_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>g. Has the correct rate of administration been indicated?</b></td>
										<td>
											<?php echo $param['administration_rate']; ?>
											<br>
											Remarks: <?php echo !empty($param['administration_rate_text']) ? $param['administration_rate_text'] : '-'; ?>
										</td>
									</tr>


									<tr>
										<td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
											2. Therapeutic Duplication
										</td>
									</tr>


									<tr>
										<td><b>a. Has the prescription been checked for therapeutic duplication?</b></td>
										<td>
											<?php echo $param['therapeutic_duplication']; ?>
											<br>
											Remarks: <?php echo !empty($param['therapeutic_duplication_text']) ? $param['therapeutic_duplication_text'] : '-'; ?>
										</td>
									</tr>


									<tr>
										<td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
											3. Illegible Handwriting
										</td>
									</tr>


									<tr>
										<td><b>a. Is the handwriting legible and easily understandable?</b></td>
										<td>
											<?php echo $param['handwriting_legible']; ?>
											<br>
											Remarks: <?php echo !empty($param['handwriting_legible_text']) ? $param['handwriting_legible_text'] : '-'; ?>
										</td>
									</tr>


									<tr>
										<td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
											4. Non-approved Abbreviations
										</td>
									</tr>


									<tr>
										<td><b>a. Have only approved medical abbreviations been used in the prescription?</b></td>
										<td>
											<?php echo $param['medical_abbreviations']; ?>
											<br>
											Remarks: <?php echo !empty($param['medical_abbreviations_text']) ? $param['medical_abbreviations_text'] : '-'; ?>
										</td>
									</tr>


									<tr>
										<td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
											5. Non-usage of Capital Letters for Drug Names
										</td>
									</tr>


									<tr>
										<td><b>a. Have drug names been written using capital letters to avoid confusion?</b></td>
										<td>
											<?php echo $param['capital_letters']; ?>
											<br>
											Remarks: <?php echo !empty($param['capital_letters_text']) ? $param['capital_letters_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>b. Has the drug been prescribed using its generic name?</b></td>
										<td>
											<?php echo $param['generic_name']; ?>
											<br>
											Remarks: <?php echo !empty($param['generic_name_text']) ? $param['generic_name_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>c. Has the drug dose been modified considering potential drug-drug interactions?</b></td>
										<td>
											<?php echo $param['drug_interaction']; ?>
											<br>
											Remarks: <?php echo !empty($param['drug_interaction_text']) ? $param['drug_interaction_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>d. Has the timing, dose, or choice of drug been adjusted considering food-drug interactions?</b></td>
										<td>
											<?php echo $param['food_drug']; ?>
											<br>
											Remarks: <?php echo !empty($param['food_drug_text']) ? $param['food_drug_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>e. Has the correct drug been dispensed as per the prescription?</b></td>
										<td>
											<?php echo $param['drug_dispensed']; ?>
											<br>
											Remarks: <?php echo !empty($param['drug_dispensed_text']) ? $param['drug_dispensed_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>f. Has the correct dose of the medication been dispensed?</b></td>
										<td>
											<?php echo $param['dose_dispensed']; ?>
											<br>
											Remarks: <?php echo !empty($param['dose_dispensed_text']) ? $param['dose_dispensed_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>g. Has the correct formulation (e.g., tablet, syrup, injection) been dispensed?</b></td>
										<td>
											<?php echo $param['formulation_dispensed']; ?>
											<br>
											Remarks: <?php echo !empty($param['formulation_dispensed_text']) ? $param['formulation_dispensed_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>h. Has the pharmacist ensured that expired or near-expiry drugs are not dispensed?</b></td>
										<td>
											<?php echo $param['expired_drungs']; ?>
											<br>
											Remarks: <?php echo !empty($param['expired_drungs_text']) ? $param['expired_drungs_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>i. Has the medication been properly labeled with accurate patient and drug information?</b></td>
										<td>
											<?php echo $param['accurate_patient']; ?>
											<br>
											Remarks: <?php echo !empty($param['accurate_patient_text']) ? $param['accurate_patient_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>j. Was the medication dispensed within the defined acceptable timeframe?</b></td>
										<td>
											<?php echo $param['medication_dispese']; ?>
											<br>
											Remarks: <?php echo !empty($param['medication_dispese_text']) ? $param['medication_dispese_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>k. Has any generic or therapeutic substitution been done only after consulting the prescribing doctor?</b></td>
										<td>
											<?php echo $param['generic_substitution']; ?>
											<br>
											Remarks: <?php echo !empty($param['generic_substitution_text']) ? $param['generic_substitution_text'] : '-'; ?>
										</td>
									</tr>


									<tr>
										<td colspan="2" style="background:#f5f5f5; font-weight:bold; padding:8px; border:1px solid #ddd;">
											II. NURSES
										</td>
									</tr>

									<tr>
										<td><b>a. Has the medication been administered to the correct patient?</b></td>
										<td>
											<?php echo $param['correct_patient']; ?>
											<br>
											Remarks: <?php echo !empty($param['correct_patient_text']) ? $param['correct_patient_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>b. Has any prescribed dose been unintentionally omitted?</b></td>
										<td>
											<?php echo $param['dose_omitted']; ?>
											<br>
											Remarks: <?php echo !empty($param['dose_omitted_text']) ? $param['dose_omitted_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>c. Has the correct dose of the medication been administered?</b></td>
										<td>
											<?php echo $param['medication_dose']; ?>
											<br>
											Remarks: <?php echo !empty($param['medication_dose_text']) ? $param['medication_dose_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>d. Has the correct drug been administered as per the prescription?</b></td>
										<td>
											<?php echo $param['drug_administered']; ?>
											<br>
											Remarks: <?php echo !empty($param['drug_administered_text']) ? $param['drug_administered_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>e. Has the correct dosage form (e.g., tablet, injection, syrup) been used?</b></td>
										<td>
											<?php echo $param['correct_dosage']; ?>
											<br>
											Remarks: <?php echo !empty($param['correct_dosage_text']) ? $param['correct_dosage_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>f. Has the correct route of administration (e.g., oral, IV, IM) been followed?</b></td>
										<td>
											<?php echo $param['correct_route']; ?>
											<br>
											Remarks: <?php echo !empty($param['correct_route_text']) ? $param['correct_route_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>g. Has the medication been administered at the correct rate?</b></td>
										<td>
											<?php echo $param['correct_rate']; ?>
											<br>
											Remarks: <?php echo !empty($param['correct_rate_text']) ? $param['correct_rate_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>h. Has the medication been administered for the correct duration?</b></td>
										<td>
											<?php echo $param['correct_duration']; ?>
											<br>
											Remarks: <?php echo !empty($param['correct_duration_text']) ? $param['correct_duration_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>i. Has the medication been given at the correct time as prescribed?</b></td>
										<td>
											<?php echo $param['correct_time']; ?>
											<br>
											Remarks: <?php echo !empty($param['correct_time_text']) ? $param['correct_time_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>j. Has the drug administration been properly documented?</b></td>
										<td>
											<?php echo $param['drug_administration']; ?>
											<br>
											Remarks: <?php echo !empty($param['drug_administration_text']) ? $param['drug_administration_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>k. Has the documentation by nursing staff been complete and accurate?</b></td>
										<td>
											<?php echo $param['nursing_staff']; ?>
											<br>
											Remarks: <?php echo !empty($param['nursing_staff_text']) ? $param['nursing_staff_text'] : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>l. Has there been any documentation without actual drug administration?</b></td>
										<td>
											<?php echo $param['documentation_drug']; ?>
											<br>
											Remarks: <?php echo !empty($param['documentation_drug_text']) ? $param['documentation_drug_text'] : '-'; ?>
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
										<td><?php echo $param['dataAnalysis']; ?></td>
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