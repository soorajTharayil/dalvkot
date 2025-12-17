<div class="content">
	<?php
	if ($this->input->post('id') || $this->input->get('id')) {
		$email = $this->session->userdata['email'];
		$hide = true;
		$id = $this->input->post('id') ? $this->input->post('id') : $this->input->get('id');

		$this->db->where('id', $id);
		$query = $this->db->get('bf_feedback_ppe_audit');
		$results = $query->result();

		if (count($results) >= 1) {
			foreach ($results as $result) {
				$param = json_decode($result->dataset, true);


	?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3>
									<a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>">
										<i class="fa fa-question-circle" aria-hidden="true"></i>
									</a>
									Radiology safety audit - <?php echo $result->id; ?>
								</h3>
							</div>
							<div class="btn-group" style="float: right;">
								<a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_ppe_audit/$id") ?>">
									<i class="fa fa-pencil" style="font-size:18px;"></i> Edit
								</a>
							</div>
							<div class="panel-body" style="background: #fff;">
								<table class="table table-striped table-bordered no-footer dtr-inline" style="font-size: 16px;">
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
										<td><b>Staff name</b></td>
										<td>
											<?php echo $param['staffname']; ?>
										</td>
									</tr>
									<tr>
										<td><b>ID No</b></td>
										<td>
											<?php echo $param['idno']; ?>
										</td>
									</tr>
									<?php if (!empty($param['department'])) { ?>
										<tr>
											<td><b>Department</b></td>
											<td><?php echo $param['department']; ?></td>
										</tr>
									<?php } ?>


									<tr>
										<td><b>Staff engaged in</b></td>
										<td><?php echo $param['comment']; ?></td>
									</tr>


									<tr>
										<td><b>Is personal protective equipment (LED apron, thyroid shield, gonad shield, LED goggles, LED gloves) being used appropriately?</b></td>
										<td>
											<?= !empty($param['gloves']) ? ucfirst(htmlspecialchars($param['gloves'])) : '-' ?><br>
											Remarks: <?= !empty($param['gloves_text']) ? htmlspecialchars($param['gloves_text']) : '-' ?>
										</td>
									</tr>


									<tr>
										<td><b>Is the TLD badge being used correctly by staff?</b></td>
										<td>
											<?= !empty($param['mask']) ? ucfirst(htmlspecialchars($param['mask'])) : '-' ?><br>
											Remarks: <?= !empty($param['mask_text']) ? htmlspecialchars($param['mask_text']) : '-' ?>
										</td>
									</tr>

									<tr>
										<td><b>Is the patient identification policy followed by staff to performing tests?</b></td>
										<td>
											<?= !empty($param['cap']) ? ucfirst(htmlspecialchars($param['cap'])) : '-' ?><br>
											Remarks: <?= !empty($param['cap_text']) ? htmlspecialchars($param['cap_text']) : '-' ?>
										</td>
									</tr>

									<tr>
										<td><b>Is the staff following the hand hygiene policy as required?</b></td>
										<td>
											<?= !empty($param['apron']) ? ucfirst(htmlspecialchars($param['apron'])) : '-' ?><br>
											Remarks: <?= !empty($param['apron_text']) ? htmlspecialchars($param['apron_text']) : '-' ?>
										</td>
									</tr>

									<tr>
										<td><b>Do staff demonstrate knowledge of the ALARA Principle in their daily practices?</b></td>
										<td>
											<?= !empty($param['leadApron']) ? ucfirst(htmlspecialchars($param['leadApron'])) : '-' ?><br>
											Remarks: <?= !empty($param['leadApron_text']) ? htmlspecialchars($param['leadApron_text']) : '-' ?>
										</td>
									</tr>

									<tr>
										<td><b>Is the radiation warning light activated by staff prior to conducting tests?</b></td>
										<td>
											<?= !empty($param['xrayBarrior']) ? ucfirst(htmlspecialchars($param['xrayBarrior'])) : '-' ?><br>
											Remarks: <?= !empty($param['xrayBarrior_text']) ? htmlspecialchars($param['xrayBarrior_text']) : '-' ?>
										</td>
									</tr>

									<tr>
										<td><b>Do staff adequately screen female patients prior to performing tests?</b></td>
										<td>
											<?= !empty($param['tld']) ? ucfirst(htmlspecialchars($param['tld'])) : '-' ?><br>
											Remarks: <?= !empty($param['tld_text']) ? htmlspecialchars($param['tld_text']) : '-' ?>
										</td>
									</tr>

									<tr>
										<td><b>Do staff provide adequate PPE to patients to minimize radiation exposure before the procedure?</b></td>
										<td>
											<?= !empty($param['ppe_to_patients']) ? ucfirst(htmlspecialchars($param['ppe_to_patients'])) : '-' ?><br>
											Remarks: <?= !empty($param['ppe_to_patients_text']) ? htmlspecialchars($param['ppe_to_patients_text']) : '-' ?>
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
										<td><?= $param['dataAnalysis'] ?? '' ?></td>
									</tr>

								</table>
							</div>
						</div>
					</div>
				</div>
			<?php } // End foreach
		} else { ?>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 style="text-align: center; color:tomato;">
								<?php echo lang_loader('ip', 'ip_no_record_found'); ?>
								<br>
								<a href="<?php echo base_url(uri_string(1)); ?>">
									<button type="button" data-toggle="tooltip" title="Back" class="btn btn-sm btn-success" style="text-align: center;">
										<i class="fa fa-arrow-left"></i>
									</button>
								</a>
							</h3>
						</div>
					</div>
				</div>
			</div>
	<?php } // End else
	} // End if 
	?>

	<?php if ($hide == false) { ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?php echo form_open(); ?>
						<table class="table">
							<tr>
								<th style="border:none !important;vertical-align: middle; text-align:right;">
									<?php echo lang_loader('ip', 'ip_feedback_id'); ?>
								</th>
								<td style="border:none !important;">
									<input type="text" class="form-control" placeholder="Enter Feedback ID" maxlength="15" size="10" name="pid">
								</td>
								<th style="text-align:left;">
									<p style="text-align:left;">
										<a href="javascript:void()" data-toggle="tooltip" title="Search">
											<button type="submit" class="btn btn-success">
												<i class="fa fa-search"></i>
											</button>
										</a>
									</p>
								</th>
							</tr>
						</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<!-- <div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<canvas id="barChart" width="400" height="200" style="width: 50%;padding:50px;"></canvas>
			</div>
		</div>
	</div> -->
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