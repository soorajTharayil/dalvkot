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
		$query = $this->db->get('bf_feedback_18PSQ3b');
		$results = $query->result();

		if (count($results) >= 1) {
			foreach ($results as $result) {
				$param = json_decode($result->dataset, true);


	?>

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_discharge_feedback_id_tooltip'); ?>"> <i class="fa fa-question-circle" aria-hidden="true"></i></a> 18. PSQ3b - <?php echo $result->id; ?> </h3>
							</div>
							<?php if (ismodule_active('QUALITY') === true  && isfeature_active('QUALITY-EDIT-PERMISSION') === true) { ?>
								<div class="btn-group" style="float: right;">
									<a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_feedback_18PSQ3a/$id") ?>"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit </a>
								</div>
							<?php } ?>
							<div class="panel-body" style="background: #fff;">


								<table class=" table table-striped table-bordered  no-footer dtr-inline " style="font-size: 16px;">

									<tr>
										<td><b>Number of patients who did receive appropriate prophylactic antibiotic</b></td>
										<td>
											<?php echo $result->no_of_receive_prophylactic; ?>
										</td>
									<tr>
										<td><b>Number of patients who underwent surgeries in the OT</b></td>
										<td>
											<?php echo $result->no_of_underwent_surgery; ?>
										</td>
									</tr>
									<tr>
										<td><b>Percentage of cases who received appropriate prophylactic antibiotics within the specified time frame</b></td>
										<td>
											<?php echo $result->prophylactic_percentage; ?>
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
								<span style="font-size:17px"><strong>Download Chart:</strong></span>
								<span style="margin-right: 10px;">
									<i data-placement="bottom" class="fa fa-file-pdf-o" style="font-size: 20px; color: red; cursor: pointer;"
										onclick="printChart()" data-toggle="tooltip" title="Download Chart as PDF"></i>
								</span>
								<span>
									<i data-placement="bottom" class="fa fa-file-image-o" style="font-size: 20px; color: green; cursor: pointer;"
										onclick="downloadChartImage()" data-toggle="tooltip"
										title="Download Chart as Image"></i>
								</span>
							</div>

							<canvas id="barChart" width="400" height="200" style="width: 50%;padding:50px;"></canvas>

						</div>
					</div>
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
					var benchmark = "<?php echo $result->no_of_receive_prophylactic; ?>"; // Benchmark value
					var calculated = "<?php echo $result->no_of_underwent_surgery; ?>"; // Calculated value
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
							labels: ['Patients receiving appropriate prophylactic antibiotic', 'Number of patients in the OT'],
							datasets: [{
								label: 'Number of patients who did receive appropriate prophylactic antibiotic compare with Number of patients who underwent surgeries in the OT',
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
									text: 'Percentage of cases who received appropriate prophylactic antibiotics within the specified time frame for ' + monthyear,
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
			<h3>18.PSQ3b- Percentage of cases who received appropriate prophylactic antibiotics</h3>
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
						link.download = '18.PSQ3b- Percentage of cases who received appropriate prophylactic antibiotics.png'; // Name of downloaded file
						link.click(); // Trigger download
					}
				</script>