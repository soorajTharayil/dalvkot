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
		$query = $this->db->get('bf_feedback_mock_drill');
		$results = $query->result();

		if (count($results) >= 1) {
			foreach ($results as $result) {
				$param = json_decode($result->dataset, true);


	?>

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>"> <i class="fa fa-question-circle" aria-hidden="true"></i></a> Code Red - <?php echo $result->id; ?> </h3>
							</div>
							<?php if (ismodule_active('AUDIT') === true  && isfeature_active('AUDIT-EDIT-PERMISSION') === true) { ?>
								<div class="btn-group" style="float: right;">
									<a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_code_red/$id") ?>"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit </a>
								</div>
							<?php } ?>
							<div class="panel-body" style="background: #fff;">


								<table class=" table table-striped table-bordered  no-footer dtr-inline " style="font-size: 16px;">

									<tr>
										<td><b>Location</b></td>
										<td>
											<?php echo $result->location; ?>
										</td>
									</tr>
									<tr>
										<td><b>Hospital Emergency Code</b></td>
										<td>
											<?php echo $param['checklist']; ?>
										</td>
									</tr>
									<tr>
										<td><b>Spot activation time</b></td>
										<td>
											<?php echo $param['initial_assessment_hr1']; ?>

										</td>
									</tr>
									<tr>
										<td><b>Announcement time</b></td>
										<td><?php echo $param['initial_assessment_hr2']; ?></td>
									</tr>

									<tr>
										<td><b>Number of code announcements</b></td>
										<td><?php echo $param['number_of_code']; ?></td>
									</tr>
									<tr>
										<td><b>Team arrival time</b></td>
										<td><?php echo $param['initial_assessment_hr3']; ?></td>
									</tr>
									<tr>
										<td><b>Number of Respondents</b></td>
										<td><?php echo $param['respondents']; ?></td>
									</tr>
									<tr>
										<td><b>Have they tried to assess the situation?</b></td>
										<td><?php echo $param['situation']; ?></td>
									</tr>
									<tr>
										<td><b>Is there availability of fire fighting equipment?</b></td>
										<td><?php echo $param['fire']; ?></td>
									</tr>
									<tr>
										<td><b>Have they demonstrated the use of fire fighting equipment?</b></td>
										<td><?php echo $param['demonstrated']; ?></td>
									</tr>
									<tr>
										<td><b>Is the lift closed?</b></td>
										<td><?php echo $param['lift']; ?></td>
									</tr>
									<tr>
										<td><b>Are the fire doors opened?</b></td>
										<td><?php echo $param['doors']; ?></td>
									</tr>
									<tr>
										<td><b>Has the patient safety officer announced evacuation?</b></td>
										<td><?php echo $param['safety']; ?></td>
									</tr>
									<tr>
										<td><b>Are transportation modes available for evacuation?</b></td>
										<td><?php echo $param['transportation']; ?></td>
									</tr>
									<tr>
										<td><b>Is the triage arranged?</b></td>
										<td><?php echo $param['action']; ?></td>
									</tr>
									<tr>
										<td><b>Have they cleared the assembly point?</b></td>
										<td><?php echo $param['assembly_point']; ?></td>
									</tr>
									<tr>
										<td><b>Has the safety officer and team revisited the spot for follow-up?</b></td>
										<td><?php echo $param['follow_up']; ?></td>
									</tr>
									<tr>
										<td><b>Code Red clearance time</b></td>
										<td><?php echo $param['initial_assessment_hr4']; ?></td>
									</tr>
									<tr>
										<td><b>Are deviations explained?</b></td>
										<td><?php echo $param['deviations']; ?></td>
									</tr>
									<tr>
										<td><b>Have all events of Code Red been debriefed?</b></td>
										<td><?php echo $param['debrief']; ?></td>
									</tr>
									<tr>
										<td><b>Code Red closure time</b></td>
										<td><?php echo $param['initial_assessment_hr5']; ?></td>
									</tr>
									<tr>
										<td><b>Additional comments</b></td>
										<td><?php echo $param['comments']; ?></td>
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