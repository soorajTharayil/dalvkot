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
		$query = $this->db->get('bf_feedback_medication_administration');
		$results = $query->result();

		if (count($results) >= 1) {
			foreach ($results as $result) {
				$param = json_decode($result->dataset, true);


	?>

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>"> <i class="fa fa-question-circle" aria-hidden="true"></i></a> Medication administration audit - <?php echo $result->id; ?> </h3>
							</div>
							<?php if (ismodule_active('AUDIT') === true  && isfeature_active('AUDIT-EDIT-PERMISSION') === true) { ?>
								<div class="btn-group" style="float: right;">
									<a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_medication_administration/$id") ?>"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit </a>
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
									<td><b>Have you checked own medications and verified the medication order, including drug name, dose, route, time, and frequency?</b></td>
									<td>
										<?php echo !empty($param['triple_check']) ? ucfirst(htmlspecialchars($param['triple_check'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['triple_check_text']) ? htmlspecialchars($param['triple_check_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Did you confirm that the prescribed medicine is written in the order?</b></td>
									<td>
										<?php echo !empty($param['medicine_labelled']) ? ucfirst(htmlspecialchars($param['medicine_labelled'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['medicine_labelled_text']) ? htmlspecialchars($param['medicine_labelled_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Is the medication tray stocked with all required articles?</b></td>
									<td>
										<?php echo !empty($param['file_verified']) ? ucfirst(htmlspecialchars($param['file_verified'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['file_verified_text']) ? htmlspecialchars($param['file_verified_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Did you perform handwashing or use hand rub before administering the medication to patient?</b></td>
									<td>
										<?php echo !empty($param['six_rights']) ? ucfirst(htmlspecialchars($param['six_rights'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['six_rights_text']) ? htmlspecialchars($param['six_rights_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Did you greet and identify the patient using two identification methods?</b></td>
									<td>
										<?php echo !empty($param['administration_documented']) ? ucfirst(htmlspecialchars($param['administration_documented'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['administration_documented_text']) ? htmlspecialchars($param['administration_documented_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Have you explained the procedure to the patient and verified their allergic status?</b></td>
									<td>
										<?php echo !empty($param['use_xray_barrior']) ? ucfirst(htmlspecialchars($param['use_xray_barrior'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['use_xray_barrior_text']) ? htmlspecialchars($param['use_xray_barrior_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Did you check and ensure that all medications are present at the patient’s side with patient’s file?</b></td>
									<td>
										<?php echo !empty($param['patient_file']) ? ucfirst(htmlspecialchars($param['patient_file'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['patient_file_text']) ? htmlspecialchars($param['patient_file_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Have you verified the medicine for its name, expiry date, color, and texture?</b></td>
									<td>
										<?php echo !empty($param['verified']) ? ucfirst(htmlspecialchars($param['verified'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['verified_text']) ? htmlspecialchars($param['verified_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Did you explain the drug indication, expected action, reaction, and side effects to the patient or relatives?</b></td>
									<td>
										<?php echo !empty($param['indication']) ? ucfirst(htmlspecialchars($param['indication'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['indication_text']) ? htmlspecialchars($param['indication_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Is all medicine available for use at the bedside on time?</b></td>
									<td>
										<?php echo !empty($param['medicine']) ? ucfirst(htmlspecialchars($param['medicine'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['medicine_text']) ? htmlspecialchars($param['medicine_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>For high-alert drugs, did you ensure verification by one staff nurse before administration?</b></td>
									<td>
										<?php echo !empty($param['alert']) ? ucfirst(htmlspecialchars($param['alert'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['alert_text']) ? htmlspecialchars($param['alert_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Have you labeled the prepared medicine with the drug name and dilution?</b></td>
									<td>
										<?php echo !empty($param['dilution']) ? ucfirst(htmlspecialchars($param['dilution'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['dilution_text']) ? htmlspecialchars($param['dilution_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Are you administering the medication as per approved techniques?</b></td>
									<td>
										<?php echo !empty($param['administering']) ? ucfirst(htmlspecialchars($param['administering'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['administering_text']) ? htmlspecialchars($param['administering_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Did you provide privacy for the patient if needed?</b></td>
									<td>
										<?php echo !empty($param['privacy']) ? ucfirst(htmlspecialchars($param['privacy'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['privacy_text']) ? htmlspecialchars($param['privacy_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>For multi-dose vials, did you note the date and time of opening on the medicine?</b></td>
									<td>
										<?php echo !empty($param['vials']) ? ucfirst(htmlspecialchars($param['vials'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['vials_text']) ? htmlspecialchars($param['vials_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Did you check the patency and status of the cannula, including the date and time of cannulation near the site?</b></td>
									<td>
										<?php echo !empty($param['cannula']) ? ucfirst(htmlspecialchars($param['cannula'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['cannula_text']) ? htmlspecialchars($param['cannula_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>After IV administration, did you flush the line with normal saline?</b></td>
									<td>
										<?php echo !empty($param['flush']) ? ucfirst(htmlspecialchars($param['flush'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['flush_text']) ? htmlspecialchars($param['flush_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Are IV medications being run on time, and have they been discontinued or discarded appropriately?</b></td>
									<td>
										<?php echo !empty($param['medications']) ? ucfirst(htmlspecialchars($param['medications'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['medications_text']) ? htmlspecialchars($param['medications_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>After administering the medication, did you reassess the patient for any reactions and ensure their comfort?</b></td>
									<td>
										<?php echo !empty($param['reassess']) ? ucfirst(htmlspecialchars($param['reassess'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['reassess_text']) ? htmlspecialchars($param['reassess_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>For oral medications, have you ensured that the patient has taken the medications and that no medicine is left unattended?</b></td>
									<td>
										<?php echo !empty($param['oral']) ? ucfirst(htmlspecialchars($param['oral'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['oral_text']) ? htmlspecialchars($param['oral_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Have you discarded waste and replaced used articles?</b></td>
									<td>
										<?php echo !empty($param['discarded']) ? ucfirst(htmlspecialchars($param['discarded'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['discarded_text']) ? htmlspecialchars($param['discarded_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Did you perform handwashing or use hand rub after the procedure?</b></td>
									<td>
										<?php echo !empty($param['handwashing']) ? ucfirst(htmlspecialchars($param['handwashing'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['handwashing_text']) ? htmlspecialchars($param['handwashing_text']) : '-'; ?>
									</td>
								</tr>

								<tr>
									<td><b>Have you recorded the procedure in the documents immediately after completing it?</b></td>
									<td>
										<?php echo !empty($param['procedures']) ? ucfirst(htmlspecialchars($param['procedures'])) : '-'; ?><br>
										Remarks: <?php echo !empty($param['procedures_text']) ? htmlspecialchars($param['procedures_text']) : '-'; ?>
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