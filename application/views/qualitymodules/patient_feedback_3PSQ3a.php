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
		$query = $this->db->get('bf_feedback_3PSQ3a');
		$results = $query->result();

		if (count($results) >= 1) {
			foreach ($results as $result) {
				$param = json_decode($result->dataset, true);


	?>

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_discharge_feedback_id_tooltip'); ?>"> <i class="fa fa-question-circle" aria-hidden="true"></i></a> 3. PSQ3a - <?php echo $result->id; ?> </h3>
							</div>
							<?php if (ismodule_active('QUALITY') === true  && isfeature_active('QUALITY-EDIT-PERMISSION') === true) { ?>
								<div class="btn-group no-print" style="float: right;">
									<a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_feedback_3PSQ3a/$id") ?>"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit </a>
								</div>
							<?php } ?>
							<div class="panel-body" style="background: #fff;">


								<table class=" table table-striped table-bordered  no-footer dtr-inline " style="font-size: 16px;">

									<tr>
										<td><b>Number of staff adhering to safety precautions</b></td>
										<td>
											<?php echo $result->no_staff_adher_safety; ?>
										</td>
									</tr>
									<tr>
										<td><b>Number of staff audited</b></td>
										<td>
											<?php echo $result->number_of_staff_audited; ?>
										</td>
									</tr>
									<tr>
										<td><b>Percentage of adherence to safety precautions by staff working in diagnostics</b></td>
										<td>
											<?php echo $result->percentage_safety_precatutions; ?>

										</td>
									</tr>

									<tr>
										<td><b>Data analysis</b></td>
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
										<td><b>Data collection on</b></td>
										<td><?php echo date('g:i a, d-M-Y', strtotime($result->datetime)); ?></td>
									</tr>
									<tr>
										<td>Uploaded files:</td>
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
						<span>📊 KPI: 3.PSQ3a – Percentage of adherence to safety precautions by staff working in diagnostics for- Raw data derived from <b>RADIOLOGY STAFF SAFETY ADHERENCE AUDIT AND LABORATORY STAFF SAFETY ADHERENCE AUDIT</b></span>

						<a href="/audit/overall_mrd_audit?kpi=1&from=<?= $monthStart; ?>&to=<?= $monthEnd; ?>"
							target="_blank"
							style="text-decoration:none;">
							<i class="fa fa-download"></i>
						</a>

					</div>

					<table style="width:100%; border-collapse:collapse;">
						<tr>
							<td style="width:40%; padding:10px 15px; font-weight:bold; color:#333; border-top:1px solid #eee;">
								Number of staff adhering to safety precautions
							</td>
							<td style="width:60%; padding:10px 15px; color:#555; border-top:1px solid #eee;">
								This value is calculated from the <b>RADIOLOGY STAFF SAFETY ADHERENCE AUDIT AND LABORATORY STAFF SAFETY ADHERENCE AUDIT</b> — It represents the
								<b>Percentage of adherence to safety precautions by staff working in diagnostics”</b> values, where it is the
								difference between the <b>Number of staff adhering to safety precautions</b> and the <b>Number of staff audited</b>,
								aggregated for all audited patients within the selected date range.
							</td>

						</tr>
						<tr>
							<td style="padding:10px 15px; font-weight:bold; color:#333; border-top:1px solid #eee;">
								Number of staff audited
							</td>
							<td style="padding:10px 15px; color:#555; border-top:1px solid #eee;">
								This represents the <b>total number of Radiology safety adherence audits</b> records,
								and the <b> Laboratory safety adherence audits conducted for that month</b>.
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
									<th>Number of staff adhering to safety precautions</th>
									<th>Number of staff audited</th>
									<th>Percentage of adherence to safety precautions by staff working in diagnostics</th>

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

											<td>
											<?php echo $result->no_staff_adher_safety; ?>
										</td>
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
					var benchmark = "<?php echo $result->no_staff_adher_safety; ?>"; // Benchmark value
					var calculated = "<?php echo  $result->number_of_staff_audited; ?>"; // Calculated value
					var monthyear = "<?php echo date('d-M-Y', strtotime($result->datetime)); ?>"; // Calculated value

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
							labels: ['Number of staff adhering to safety precautions', 'Number of staff audited'],
							datasets: [{
								label: 'Number of staff adhering to safety precautions compare with Number of staff audited',
								data: [benchmark, calculated],
								backgroundColor: ['rgba(56, 133, 244, 1)', calculatedColor], // Blue color for benchmark
							}]
						},
						options: {
							plugins: {
								tooltip: {
									callbacks: {
										label: function(context) {
											var value = context.raw;
											return value + ''; // Show only the seconds value
										}
									}
								},
								legend: {
									labels: {
										boxWidth: 30, // Hide the legend color box
										font: {
											size: 16 // Adjust label font size if needed
										}
									}
								},
								title: {
									display: true,
									text: 'Percentage of adherence to safety precautions by staff working in diagnostics for ' + monthyear,
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
											const timeValue = index === 0 ? benchmark : calculated;
											return [label, '(Count: ' + timeValue + ')']; 
										},
										font: {
											size: 20,
											family: 'vazir'
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
			<h3>3.PSQ3a- Percentage of adherence to safety precautions by diagnostics staffs</h3>
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
						link.download = '3.PSQ3a- Percentage of adherence to safety precautions by diagnostics staffs.png'; // Name of downloaded file
						link.click(); // Trigger download
					}
				</script>