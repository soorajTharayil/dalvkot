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
		$query = $this->db->get('bf_feedback_catheter_insert');
		$results = $query->result();

		if (count($results) >= 1) {
			foreach ($results as $result) {
				$param = json_decode($result->dataset, true);


	?>

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>"> <i class="fa fa-question-circle" aria-hidden="true"></i></a> Catheter Insertion checklist - <?php echo $result->id; ?> </h3>
							</div>
							<?php if (ismodule_active('AUDIT') === true  && isfeature_active('AUDIT-EDIT-PERMISSION') === true) { ?>
								<div class="btn-group" style="float: right;">
									<a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_catheter_insert/$id") ?>"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit </a>
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
										<td>Patient MID</td>
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
										<th colspan="2" style="background-color: #f5f5f5; text-align: left;">Before Procedure</th>
									</tr>

									<tr>
										<td><b>Has an alternative for the indwelling catheterization been considered and documented?</b></td>
										<td>
											<?php echo !empty($param['identification_details']) ? ucfirst(htmlspecialchars($param['identification_details'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['identification_details_text']) ? htmlspecialchars($param['identification_details_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is the patient confirmed using two identifiers?</b></td>
										<td>
											<?php echo !empty($param['vital_signs']) ? ucfirst(htmlspecialchars($param['vital_signs'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['vital_signs_text']) ? htmlspecialchars($param['vital_signs_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Are the clinical reasons for insertion specified, communicated to the patient/bystander, and documented?</b></td>
										<td>
											<?php echo !empty($param['surgery']) ? ucfirst(htmlspecialchars($param['surgery'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['surgery_text']) ? htmlspecialchars($param['surgery_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Has the need, possible complications, potential outcomes, and procedures been explained, and consent obtained?</b></td>
										<td>
											<?php echo !empty($param['complaints_communicated']) ? ucfirst(htmlspecialchars($param['complaints_communicated'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['complaints_communicated_text']) ? htmlspecialchars($param['complaints_communicated_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Did the person performing the procedure perform hand hygiene?</b></td>
										<td>
											<?php echo !empty($param['intake']) ? ucfirst(htmlspecialchars($param['intake'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['intake_text']) ? htmlspecialchars($param['intake_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is the person performing the procedure wearing PPE?</b></td>
										<td>
											<?php echo !empty($param['output']) ? ucfirst(htmlspecialchars($param['output'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['output_text']) ? htmlspecialchars($param['output_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Does the person performing the procedure use sterile gloves?</b></td>
										<td>
											<?php echo !empty($param['allergies']) ? ucfirst(htmlspecialchars($param['allergies'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['allergies_text']) ? htmlspecialchars($param['allergies_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is the catheterization kit available with all necessary sterile items?</b></td>
										<td>
											<?php echo !empty($param['medication']) ? ucfirst(htmlspecialchars($param['medication'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['medication_text']) ? htmlspecialchars($param['medication_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is the smallest gauge of the catheter selected for effective drainage?</b></td>
										<td>
											<?php echo !empty($param['diagnostic']) ? ucfirst(htmlspecialchars($param['diagnostic'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['diagnostic_text']) ? htmlspecialchars($param['diagnostic_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<th colspan="2" style="background-color: #f5f5f5; text-align: left;">During Procedure</th>
									</tr>

									<tr>
										<td><b>Has perineal care been performed, and has hand hygiene been re-performed?</b></td>
										<td>
											<?php echo !empty($param['lab_results']) ? ucfirst(htmlspecialchars($param['lab_results'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['lab_results_text']) ? htmlspecialchars($param['lab_results_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is the catheter lubricated with sterile lubricant?</b></td>
										<td>
											<?php echo !empty($param['pending_investigation']) ? ucfirst(htmlspecialchars($param['pending_investigation'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['pending_investigation_text']) ? htmlspecialchars($param['pending_investigation_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is aseptic technique maintained throughout insertion?</b></td>
										<td>
											<?php echo !empty($param['medicine_order']) ? ucfirst(htmlspecialchars($param['medicine_order'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['medicine_order_text']) ? htmlspecialchars($param['medicine_order_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is urine allowed to drain before the catheter balloon is inflated?</b></td>
										<td>
											<?php echo !empty($param['facility_communicated']) ? ucfirst(htmlspecialchars($param['facility_communicated'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['facility_communicated_text']) ? htmlspecialchars($param['facility_communicated_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is the balloon inflated correctly?</b></td>
										<td>
											<?php echo !empty($param['health_education']) ? ucfirst(htmlspecialchars($param['health_education'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['health_education_text']) ? htmlspecialchars($param['health_education_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is the catheter connected to a sterile drainage bag and placed safely below the level of the bladder, and has hand hygiene been re-performed?</b></td>
										<td>
											<?php echo !empty($param['risk_assessment']) ? ucfirst(htmlspecialchars($param['risk_assessment'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['risk_assessment_text']) ? htmlspecialchars($param['risk_assessment_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<th colspan="2" style="background-color: #f5f5f5; text-align: left;">After Procedure</th>
									</tr>

									<tr>
										<td><b>Is urine flow checked, and is there no urethral trauma?</b></td>
										<td>
											<?php echo !empty($param['urethral']) ? ucfirst(htmlspecialchars($param['urethral'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['urethral_text']) ? htmlspecialchars($param['urethral_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Is a urine sample sent to the laboratory if required?</b></td>
										<td>
											<?php echo !empty($param['urine_sample']) ? ucfirst(htmlspecialchars($param['urine_sample'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['urine_sample_text']) ? htmlspecialchars($param['urine_sample_text']) : '-'; ?>
										</td>
									</tr>

									<tr>
										<td><b>Has the patient/bystander been educated regarding catheter care and procedure documentation?</b></td>
										<td>
											<?php echo !empty($param['bystander']) ? ucfirst(htmlspecialchars($param['bystander'])) : '-'; ?><br>
											Remarks: <?php echo !empty($param['bystander_text']) ? htmlspecialchars($param['bystander_text']) : '-'; ?>
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
											<?php echo $param['dataAnalysis']; ?>
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