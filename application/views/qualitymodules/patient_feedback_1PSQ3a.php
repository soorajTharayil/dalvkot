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
		$query = $this->db->get('bf_feedback_1PSQ3a');
		$results = $query->result();

		if (count($results) >= 1) {
			foreach ($results as $result) {
				$param = json_decode($result->dataset, true);


	?>

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_discharge_feedback_id_tooltip'); ?>"> <i class="fa fa-question-circle" aria-hidden="true"></i></a> 1. PSQ3a - <?php echo $result->id; ?> </h3>
							</div>
							<?php if (ismodule_active('QUALITY') === true  && isfeature_active('QUALITY-EDIT-PERMISSION') === true) { ?>
								<div class="btn-group no-print" style="float: right;">
									<a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_feedback_1PSQ3a/$id") ?>"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit </a>
								</div>
							<?php } ?>
							<div class="panel-body" style="background: #fff;">


								<table class=" table table-striped table-bordered  no-footer dtr-inline " style="font-size: 16px;">

									<tr>
										<td><b>Sum of time taken for initial the assessment</b></td>
										<td><?php echo $result->time_taken_initial_assessment; ?></td>
									</tr>
									<tr>
										<td><b>Total number of admissions</b></td>
										<td><?php echo $param['total_admission']; ?></td>
									</tr>
									<tr>
										<td><b>Avg. time taken for initial assessment of indoor patients</b></td>
										<td>
											<?php
											// Benchmark time (4 hours) in seconds
											$benchmarkSeconds = $result->bench_mark_time * 60 * 60;

											// Convert the calculatedResult to seconds
											list($calculatedHours, $calculatedMinutes, $calculatedSeconds) = explode(':', $result->average_time_taken_initial_assessment);
											$calculatedTotalSeconds = $calculatedHours * 3600 + $calculatedMinutes * 60 + $calculatedSeconds;

											// Check if calculatedResult is less than benchmark
											$color = ($calculatedTotalSeconds < $benchmarkSeconds) ? 'green' : 'red';

											// Output the calculatedResult with appropriate color
											?>
											<span style="color: <?php echo $color; ?>">
												<?php echo $result->average_time_taken_initial_assessment; ?>
											</span>
										</td>
									</tr>
									<tr>
										<td><b>Bench Mark Time</b></td>
										<td><?php echo $param['benchmark']; ?></td>
									</tr>

									<tr>
										<td><b>Data analysis (RCA, Reason for Variation etc.)</b></td>
										<td><?php echo $param['dataAnalysis']; ?></td>
									</tr>
									<tr>
										<td><b>Corrective action</b></td>
										<td><?php echo $param['correctiveAction']; ?></td>
									</tr>
									<tr>
										<td><b>Preventive action</b></td>
										<td><?php echo $param['preventiveAction']; ?></td>
									</tr>
									<tr>
										<td><b>KPI recorded by</b></td>
										<td>
											<?php echo $param['name']; ?> ,
											<?php echo $param['patientid']; ?>

										</td>
									</tr>
									<tr>
										<td><b>KPI Recorded on</b></td>
										<td><?php echo date('g:i a, d-M-Y', strtotime($result->datetime)); ?></td>
									</tr>

									<!-- Newly added tr-->
									<tr>
										<td><b>KPI Submission Status</b></td>
										<td>
											<?php
											$period = new DateTime($result->datetime); // KPI period
											$submitted = new DateTime($result->datet); // actual submission

											// compute deadline = 10th of next month
											$deadline = clone $period;
											$deadline->modify('first day of next month');
											$deadline->setDate($deadline->format('Y'), $deadline->format('m'), 10);
											$deadline->setTime(23, 59, 59);

											if ($submitted <= $deadline) {
												echo "<span style='color:green;font-weight:bold;'>Within TAT</span>";
											} else {
												echo "<span style='color:red;font-weight:bold;'>Exceeded TAT</span>";
											}

											echo " (Deadline: " . $deadline->format('d-M-Y') . ", Submitted on: " . $submitted->format('d-M-Y') . ")";
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

							<div style="float: right; margin-top: 10px; margin-right: 10px;">
								<span class="no-print" style="font-size:17px"><strong>Download Chart:</strong></span>
								<span class="no-print" style="margin-right: 10px;">
									<i data-placement="bottom" class="fa fa-file-pdf-o" style="font-size: 20px; color: red; cursor: pointer;"
										onclick="printChart()" data-toggle="tooltip" title="Download Chart as PDF"></i>
								</span>
								<span class="no-print">
									<i data-placement="bottom" class="fa fa-file-image-o" style="font-size: 20px; color: green; cursor: pointer;"
										onclick="downloadChartImage()" data-toggle="tooltip"
										title="Download Chart as Image"></i>
								</span>
							</div>

							<canvas id="barChart" width="400" height="200" style="width: 50%;padding:50px;"></canvas>

						</div>
					</div>
				</div>

				<!-- Raw data section -->

				<?php
				// KPI recorded datetime
				$kpiDate = $result->datetime;

				// Convert to year-month
				$monthStart = date("Y-m-01", strtotime($kpiDate));
				$monthEnd   = date("Y-m-t", strtotime($kpiDate));   // Last day of month
				?>

				<div style="width: 100%; margin-top: 30px; margin-left: 8px; border:1px solid #ccc; border-radius:6px; background-color:#fafafa; font-family:Arial, sans-serif; font-size:14px; position: relative;">

					<div style="background-color:#e9f1ff; color:#004aad; padding:10px 15px; font-weight:bold; border-bottom:1px solid #ccc; display:flex; justify-content:space-between; align-items:center;">
						<span>📊 KPI: 1.PSQ3a – Time Taken for Initial Assessment of Inpatients- Raw data derived from <b>MRD File Audit</b></span>

						<a href="/audit/overall_mrd_audit?kpi=1&from=<?= $monthStart; ?>&to=<?= $monthEnd; ?>"
							target="_blank"
							style="text-decoration:none;">
							<i class="fa fa-download"></i>
						</a>

					</div>

					<table style="width:100%; border-collapse:collapse;">
						<tr>
							<td style="width:40%; padding:10px 15px; font-weight:bold; color:#333; border-top:1px solid #eee;">
								Sum of Time Taken for Initial Assessment
							</td>
							<td style="width:60%; padding:10px 15px; color:#555; border-top:1px solid #eee;">
								This value is calculated from the <b>MRD File Audit</b> — It represents the
								<b>sum of all “Time taken for initial assessment”</b> values, where the time taken is the
								difference between the <b>patient’s arrival time</b> and the <b>initial assessment completed time</b>,
								aggregated for all audited patients within the selected date range.
							</td>

						</tr>
						<tr>
							<td style="padding:10px 15px; font-weight:bold; color:#333; border-top:1px solid #eee;">
								Total Number of Admissions
							</td>
							<td style="padding:10px 15px; color:#555; border-top:1px solid #eee;">
								This represents the <b>total number of MRD Audit</b> records,
								corresponding to the <b>total inpatient admissions audited</b>.
							</td>
						</tr>
					</table>

					<?php if (!empty($feedbacktaken)) { ?>

						<div class="panel-body">

							<table class="mrdkpitable table table-striped table-hover table-bordered" cellspacing="0" width="100%">
								<thead>
									<th><?php echo lang_loader('ip', 'ip_slno'); ?></th>
									<th>Audit by</th>
									<th>Audit Date</th>
									<th style="white-space: nowrap;"><?php echo lang_loader('ip', 'ip_patient_details'); ?></th>
									<th>Patient arrived time</th>
									<th>Initial assessment completed time</th>
									<th>Time taken for initial assessment</th>

								</thead>
								<tbody>
									<?php
									$sl = 1;
									foreach ($feedbacktaken as $r) {

										$auditDate = date("Y-m-d", strtotime($r->datetime));

										// Show only records from this KPI's month
										if ($auditDate < $monthStart || $auditDate > $monthEnd) {
											continue;
										}

										$audit = json_decode($r->dataset);
									?>


										<tr class="<?php echo ($sl & 1) ? 'odd gradeX' : 'even gradeC'; ?>">
											<td><?php echo $sl; ?></td>
											<td><?php echo $audit->audit_by; ?></td>

											<td style="white-space: nowrap;">
												<?php if ($r->datetime) { ?>
													<?php echo date('d-M-Y', strtotime($r->datetime)); ?><br>
													<?php echo date('g:i a', strtotime($r->datetime)); ?>
												<?php } ?>
											</td>

											<td style="overflow: clip;">
												<?php echo $audit->patient_name; ?> (<?php echo $audit->mid_no; ?>)
												<br>
												Age: <?php echo $audit->patient_age; ?>
												<br>
												Gender: <?php echo $audit->patient_gender; ?>
											</td>

											<td><?php echo $audit->initial_assessment_hr1; ?></td>
											<td><?php echo $audit->initial_assessment_hr2; ?></td>
											<td><?php echo date("H:i:s", strtotime($audit->calculatedResult)); ?></td>




										</tr>
										<?php $sl++; ?>
									<?php } ?>

								</tbody>
							</table>

						</div>

					<?php } ?>


				</div>





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
				<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

				<script>
					// Data
					var benchmark = "<?php echo $param['benchmark']; ?>"; // Benchmark value
					var calculated = "<?php echo $result->average_time_taken_initial_assessment; ?>"; // Calculated value
					var monthyear = "<?php echo date('M-Y', strtotime($result->datetime)); ?>"; // Date value

					// Parse times to seconds
					var benchmarkSeconds = parseTimeToSeconds(benchmark);
					var calculatedSeconds = parseTimeToSeconds(calculated);

					// Determine colors based on comparison
					var calculatedColor = calculatedSeconds > benchmarkSeconds ? 'rgba(234, 67, 53, 0.8)' : 'rgba(52, 168, 83, 1)'; // Red if calculated is greater, otherwise green
					var calculatedBorderColor = calculatedSeconds > benchmarkSeconds ? 'rgba(234, 67, 53, 0.8)' : 'rgba(52, 168, 83, 1)';

					// Create the chart
					var ctx = document.getElementById('barChart').getContext('2d');
					var myChart = new Chart(ctx, {
						type: 'bar',
						responsive: true,
						data: {
							labels: ['Benchmark Time', 'Avg. time taken for initial assessment of indoor patients'],
							datasets: [{
								label: 'Benchmark Time compared with Avg. time taken for initial assessment of indoor patients',
								data: [benchmarkSeconds, calculatedSeconds],
								backgroundColor: ['rgba(56, 133, 244, 1)', calculatedColor], // Blue color for benchmark
							}]
						},
						options: {
							plugins: {
								tooltip: {
									callbacks: {
										label: function(context) {
											var value = context.raw;
											return secondsToTime(value); // Convert seconds to time format (hh:mm:ss)
										}
									}
								},
								legend: {
									labels: {
										boxWidth: 30, // Adjust the legend color box size
										font: {
											size: 16 // Adjust label font size if needed
										}
									}
								},
								title: {
									display: true,
									text: 'Avg. time taken for initial assessment of indoor patients for ' + monthyear,
									font: {
										size: 24 // Increase this value to adjust the title font size
									},
									padding: {
										top: 10,
										bottom: 30
									}
								}
							},
							scales: {
								x: {
									ticks: {
										callback: function(value, index) {
											const label = this.getLabelForValue(value);
											const timeValue = index === 0 ? benchmarkSeconds : calculatedSeconds;
											return [label, '(' + secondsToTime(timeValue) + ')'];
										},
										font: {
											size: 20,
											family: 'vazir'
										}
									}
								},
								y: {
									ticks: {
										callback: function(value) {
											return secondsToTime(value); // Convert seconds to time format (hh:mm:ss)
										},
										font: {
											size: 16 // Adjust y-axis label font size if needed
										}
									}
								}
							}
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

				<script>
					function printChart() {
						const canvas = document.getElementById('barChart');
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
						const canvas = document.getElementById('barChart');
						const image = canvas.toDataURL('image/png'); // Convert canvas to image data

						// Create a temporary link element
						const link = document.createElement('a');
						link.href = image;
						link.download = '1.PSQ3a- Time taken for initial assessment of indoor patients.png'; // Name of downloaded file
						link.click(); // Trigger download
					}
				</script>