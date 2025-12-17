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
		$query = $this->db->get('bf_feedback_surgical_safety');
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
								<h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>"> <i class="fa fa-question-circle" aria-hidden="true"></i></a> Operating Room Safety audit - <?php echo $result->id; ?> </h3>
							</div>
							<?php if (ismodule_active('AUDIT') === true  && isfeature_active('AUDIT-EDIT-PERMISSION') === true) { ?>
								<div class="btn-group" style="float: right;">
									<a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_surgical_safety/$id") ?>"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit </a>
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
										<td><b>Surgery name</b></td>
										<td>
											<?php echo $param['surgeryname']; ?>
										</td>
									</tr>

									<tr>
										<td><b>Surgery date</b></td>
										<td>
											<?php echo $param['initial_assessment_hr1']; ?>
										</td>
									</tr>

									<tr>
										<th colspan="2" style="background-color: #f5f5f5; text-align: left;">Sign in Pre-Op/ Pre anaesthesia check list – Before Induction of Anesthesia</th>
									</tr>

									<tr>
										<td>Has the patient's identity been confirmed by verifying the ID band?</td>
										<td>
											<?php
											echo $param['antibiotic'];
											if (!empty($param['antibiotic_text'])) {
												echo " <br>Remarks: " . htmlspecialchars($param['antibiotic_text']);
											}
											?>
										</td>
									</tr>


									<tr>
										<td>Has the surgical site been marked?</td>
										<td>
											<?php
											echo $param['checklist'];
											if (!empty($param['checklist_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['checklist_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Has the informed consent been completed and documented?</td>
										<td>
											<?php
											echo $param['bundle_care'];
											if (!empty($param['bundle_care_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['bundle_care_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Has the availability of artificial dentures, eyes, or other appliances been checked?</td>
										<td>
											<?php
											echo $param['time_out'];
											if (!empty($param['time_out_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['time_out_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Have HIV, HBsAg, and HCV tests been completed?</td>
										<td>
											<?php
											echo $param['unplanned_return'];
											if (!empty($param['unplanned_return_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['unplanned_return_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Has the time of last oral intake (fluid/food) been mentioned?</td>
										<td>
											<?php
											echo $param['last_oral'];
											if (!empty($param['last_oral_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['last_oral_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Has the patients weight been documented?</td>
										<td>
											<?php
											echo $param['patients_weight'];
											if (!empty($param['patients_weight_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['patients_weight_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Has the time of urine voiding been documented?</td>
										<td>
											<?php
											echo $param['urine_void'];
											if (!empty($param['urine_void_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['urine_void_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Has the anaesthesia safety check been completed?</td>
										<td>
											<?php
											echo $param['anaesthesia'];
											if (!empty($param['anaesthesia_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['anaesthesia_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Has the patients drug allergy history been verified?</td>
										<td>
											<?php
											echo $param['drug_allergy'];
											if (!empty($param['drug_allergy_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['drug_allergy_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Has antibiotic prophylaxis been verified as given prior to surgery?</td>
										<td>
											<?php
											echo $param['prophylaxis'];
											if (!empty($param['prophylaxis_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['prophylaxis_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Was the antibiotic given within the last 60 minutes before surgery?</td>
										<td>
											<?php
											echo $param['antibiotic_given'];
											if (!empty($param['antibiotic_given_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['antibiotic_given_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Has it been checked whether thromboprophylaxis has been ordered?</td>
										<td>
											<?php
											echo $param['thromboprophylaxis'];
											if (!empty($param['thromboprophylaxis_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['thromboprophylaxis_text']);
											}
											?>
										</td>
									</tr>


									<tr>
										<th colspan="2" style="background-color: #f5f5f5; text-align: left;">Time Out– Before Skin Incision</th>
									</tr>

									<tr>
										<td>Have the surgeon, anaesthesia professionals, and nurse verbally confirmed the incision time, patient identity, surgical site, and procedure?</td>
										<td>
											<?php
											echo $param['anaesthesia_professionals'];
											if (!empty($param['anaesthesia_professionals_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['anaesthesia_professionals_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Have the anticipated clinical events been reviewed by the surgeon, anaesthesia team, and nursing team?</td>
										<td>
											<?php
											echo $param['clinical_events'];
											if (!empty($param['clinical_events_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['clinical_events_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Have any anticipated equipment issues or concerns been reviewed?</td>
										<td>
											<?php
											echo $param['anticipated_equipment'];
											if (!empty($param['anticipated_equipment_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['anticipated_equipment_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Has it been confirmed whether any prosthesis or special equipment is required and available for the surgery?</td>
										<td>
											<?php
											echo $param['prosthesis'];
											if (!empty($param['prosthesis_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['prosthesis_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Has the display of essential imaging been checked and confirmed?</td>
										<td>
											<?php
											echo $param['imaging'];
											if (!empty($param['imaging_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['imaging_text']);
											}
											?>
										</td>
									</tr>



									<tr>
										<th colspan="2" style="background-color: #f5f5f5; text-align: left;">Sign Out- Before patient leaves Operating Room</th>
									</tr>

									<tr>
										<td>Has the name of the procedure been recorded?</td>
										<td>
											<?php
											echo $param['procedure_name'];
											if (!empty($param['procedure_name_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['procedure_name_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Have the counts of instruments, sponges, needles, and other items been checked and confirmed?</td>
										<td>
											<?php
											echo $param['instruments_counts'];
											if (!empty($param['instruments_counts_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['instruments_counts_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Has the closure time been documented?</td>
										<td>
											<?php
											echo $param['closure_time'];
											if (!empty($param['closure_time_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['closure_time_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Has the specimen labeling been completed with the correct patient name?</td>
										<td>
											<?php
											echo $param['specimen_labeling'];
											if (!empty($param['specimen_labeling_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['specimen_labeling_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Are there any equipment problems that need to be addressed or reported?</td>
										<td>
											<?php
											echo $param['equipment_report'];
											if (!empty($param['equipment_report_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['equipment_report_text']);
											}
											?>
										</td>
									</tr>

									<tr>
										<td>Have the surgeon, anaesthesia professionals, and nurse reviewed the key concerns for the patients recovery and ongoing management?</td>
										<td>
											<?php
											echo $param['patients_recovery'];
											if (!empty($param['patients_recovery_text'])) {
												echo "<br>Remarks: " . htmlspecialchars($param['patients_recovery_text']);
											}
											?>
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
						<div class="panel panel-default">

							<!-- <canvas id="barChart" width="400" height="200" style="width: 50%;padding:50px;"></canvas> -->

						</div>
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