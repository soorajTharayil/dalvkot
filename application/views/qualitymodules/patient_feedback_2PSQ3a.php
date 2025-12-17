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
		$query = $this->db->get('bf_feedback_2PSQ3a');
		$results = $query->result();

		if (count($results) >= 1) {
			foreach ($results as $result) {
				$param = json_decode($result->dataset, true);


	?>

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_discharge_feedback_id_tooltip'); ?>"> <i class="fa fa-question-circle" aria-hidden="true"></i></a> 2. PSQ3a - <?php echo $result->id; ?> </h3>
							</div>
							<?php if (ismodule_active('QUALITY') === true  && isfeature_active('QUALITY-EDIT-PERMISSION') === true) { ?>
								<div class="btn-group no-print" style="float: right;">
									<a class="btn btn-danger" style="margin-top:-40px;margin-right:10px;" href="<?php echo base_url($this->uri->segment(1) . "/edit_feedback_2PSQ3a/$id") ?>"> <i class="fa fa-pencil" style="font-size:18px;"></i> Edit </a>
								</div>
							<?php } ?>
							<div class="panel-body" style="background: #fff;">


								<table class=" table table-striped table-bordered  no-footer dtr-inline " style="font-size: 16px;">

									<tr>
										<td><b>Number of reporting errors</b></td>
										<td>
											<?php echo $result->reporting_errors; ?>
										</td>
									</tr>
									<tr>
										<td><b>Number of tests performed</b></td>
										<td>
											<?php echo $result->number_of_test_performed; ?>
										</td>
									</tr>
									<tr>
										<td><b>No. of reporting errors per 1000 investigations</b></td>
										<td>
											<?php echo $result->average_no_of_reporting_errors; ?>
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
						<span>📊 KPI: 2. PSQ3a – Number of reporting errors per 1000 investigations- Raw data derived from <b>Incident Management</b></span>

						<a href="/incident/download_alltickets?kpi=incident&from=<?= $monthStart; ?>&to=<?= $monthEnd; ?>"
							target="_blank"
							style="text-decoration:none;">
							<i class="fa fa-download"></i>
						</a>

					</div>

					<table style="width:100%; border-collapse:collapse;">
						<tr>
							<td style="width:40%; padding:10px 15px; font-weight:bold; color:#333; border-top:1px solid #eee;">
								Number of reporting errors
							</td>
							<td style="width:60%; padding:10px 15px; color:#555; border-top:1px solid #eee;">
								This value is fetched from the <b>Incident Management</b> — It represents the count of all incidents reported under the
								<b>"Reporting Error"</b> category.
							</td>

						</tr>
						<tr>
							<td style="padding:10px 15px; font-weight:bold; color:#333; border-top:1px solid #eee;">
								Number of tests performed
							</td>
							<td style="padding:10px 15px; color:#555; border-top:1px solid #eee;">
								This represents the <b>total number of incidents</b> reported during the selected month.
							</td>
						</tr>
					</table>

					<?php
					// individual patient feedback link
					$ip_link_patient_feedback = base_url($this->uri->segment(1) . '/employee_complaint?empid=');
					$this->db->select("*");
					$this->db->from('setup_incident');
					//$this->db->where('parent', 0);
					$query = $this->db->get();
					$reasons  = $query->result();
					foreach ($reasons as $row) {
						$keys[$row->shortkey] = $row->shortkey;
						$res[$row->shortkey] = $row->shortname;
						$titles[$row->shortkey] = $row->title;
					}

					if (!empty($departments)) { ?>

						<div class="panel-body">

							<table class="incident table table-striped table-bordered table-hover" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th style="width:5%"><?php echo lang_loader('inc', 'inc_slno'); ?></th>
										<th style="width:20%;">Incident details</th>
										<th style="width:15%;"><?php echo lang_loader('inc', 'inc_incident_reported_by'); ?></th>
										<th style="width:13%;"><?php echo lang_loader('inc', 'inc_reported_on'); ?> / Occurred on</th>
										<th style="width:17%;">Risk / Priority / Category</th>

									</tr>
								</thead>

								<tbody>
									<?php if (!empty($departments)) { ?>
										<?php $sl = 1; ?>

										<?php foreach ($departments as $department) {

											$auditDate = date("Y-m-d", strtotime($department->created_on));

											// Show only records from this KPI's month
											if ($auditDate < $monthStart || $auditDate > $monthEnd) {
												continue;
											}

											$userss = $this->db->select('user_id, firstname')
												->where('user_id !=', 1)
												->get('user')
												->result();

											$userMap = [];
											foreach ($userss as $u) {
												$userMap[$u->user_id] = $u->firstname;
											}

											$assign_for_process_monitor_ids = !empty($department->assign_for_process_monitor)
												? explode(',', $department->assign_for_process_monitor) : [];

											$assign_to_ids = !empty($department->assign_to)
												? explode(',', $department->assign_to) : [];

											$assign_for_team_member_ids = !empty($department->assign_for_team_member)
												? explode(',', $department->assign_for_team_member) : [];


											$assign_for_process_monitor_names = array_map(function ($id) use ($userMap) {
												return isset($userMap[$id]) ? $userMap[$id] : $id;
											}, $assign_for_process_monitor_ids);

											$assign_to_names = array_map(function ($id) use ($userMap) {
												return isset($userMap[$id]) ? $userMap[$id] : $id;
											}, $assign_to_ids);

											$assign_for_team_member_names = array_map(function ($id) use ($userMap) {
												return isset($userMap[$id]) ? $userMap[$id] : $id;
											}, $assign_for_team_member_ids);


											$actionText_process_monitor = implode(', ', $assign_for_process_monitor_names);
											$names = implode(', ', $assign_to_names);
											$actionText_team_member = implode(', ', $assign_for_team_member_names);


											if ($department->status == 'Addressed') {
												$this->db->where('ticketid', $department->id)->where('ticket_status', 'Addressed');
												$ticket = $this->db->get('ticket_incident_message')->result();
												$rowmessage = $ticket[0]->message . ' addressed the ticket with, ' . $ticket[0]->reply;
											} elseif ($department->status == 'Transfered') {
												$this->db->where('ticketid', $department->id)->where('ticket_status', 'Transfered');
												$ticket = $this->db->get('ticket_incident_message')->result();
												$rowmessage = $ticket[0]->message . ' Transfered because, ' . $ticket[0]->reply;
											} elseif ($department->status == 'Reopen') {
												$this->db->where('ticketid', $department->id)->where('ticket_status', 'Reopen');
												$ticket = $this->db->get('ticket_incident_message')->result();
												$rowmessage = $ticket[0]->message . ' Reopened because, ' . $ticket[0]->reply;
											} elseif ($department->status == 'Closed') {
												$this->db->where('ticketid', $department->id)->where('ticket_status', 'Closed');
												$ticket = $this->db->get('ticket_incident_message')->result();
												$rowmessage = $ticket[0]->message . ' Closed the ticket, Root Cause: ' . $ticket[0]->rootcause . '. CAPA: ' . $ticket[0]->corrective;
											} else {
												$rowmessage = 'THIS TICKET IS OPEN';
											}

											if (strlen($rowmessage) > 60) {
												$rowmessage = substr($rowmessage, 0, 60) . ' ... click status to view';
											}
										?>

											<tr class="<?php echo ($sl & 1) ? 'odd gradeX' : 'even gradeC'; ?>"
												data-placement="bottom" data-toggle="tooltip" title="<?php echo $rowmessage; ?>">

												<td><?php echo $sl; ?></td>

												<td style="overflow-wrap: break-word; white-space: normal;">
													<strong>Incident ID:</strong> <?php echo $department->id; ?><br>

													<?php
													if ($department->departmentid_trasfered != 0) {
														$show = false;
														if ($department->status == 'Addressed') {
															echo '<strong>Incident:</strong> Ticket was transferred<br>';
															$show = true;
														}
														if ($department->status == 'Transfered') {
															echo '<strong>Incident:</strong> ' . $trans_comm . '<br>';
															$show = true;
														}
														if ($department->status == 'Reopen') {
															echo '<strong>Incident:</strong> ' . $reopen_comm . '<br>';
															$show = true;
														}
														if (!$show && $department->status == 'Closed') {
															echo '<strong>Incident:</strong> Ticket was transferred<br>';
														}
													} else {
														foreach ($department->feed->reason as $key => $value) {
															if ($key && $titles[$key] == $department->department->description) {
																if (in_array($key, $keys)) {
																	echo '<strong>Incident:</strong> ' . $res[$key] . '<br>';
																	echo '<strong>Incident Short Name:</strong> ' . $department->department->description . '<br>';
																}
															}
														}
													}
													?>
												</td>


												<td style="word-break: break-all;">

													<?php if (!empty($department->feed->patientid)) : ?>
														<?php echo $department->feed->name; ?>
														&nbsp;(<a href="<?php echo $ip_link_patient_feedback . $department->id; ?>">
															<?php echo $department->feed->patientid; ?>
														</a>)
													<?php else : ?>
														<?php echo $department->feed->name; ?>
													<?php endif; ?>

													<br><?php echo $department->feed->ward; ?>
													<?php if ($department->feed->bedno) echo ' in ' . $department->feed->bedno; ?>
													<br>

													<i class="fa fa-phone"></i> <?php echo $department->feed->contactnumber; ?>

													<?php if ($department->feed->email) { ?>
														<br><i class="fa fa-envelope"></i> <?php echo $department->feed->email; ?>
													<?php } ?>

												</td>


												<td style="word-break: break-all;">
													<strong>Reported on:</strong><br>
													<?php echo date('g:i A', strtotime($department->created_on)); ?><br>
													<?php echo date('d-m-Y', strtotime($department->created_on)); ?><br><br>

													<strong>Occurred on:</strong><br>
													<?php
													if (!empty($department->incident_occured_in)) {
														echo date('g:i A', strtotime(str_replace([',', '-'], '', $department->incident_occured_in))) . "<br>";
														echo date('d-m-Y', strtotime(str_replace([',', '-'], '', $department->incident_occured_in)));
													} else {
														echo '-';
													}
													?>
												</td>

												<?php
												/* Colors for priority & category */
												$priority = !empty($department->feed->priority)
													? str_replace('–', '-', $department->feed->priority) : 'Unassigned';

												$incident_type = !empty($department->feed->incident_type)
													? str_replace('–', '-', $department->feed->incident_type) : 'Unassigned';

												$riskMatrix = !empty($department->feed->risk_matrix) ? (array) $department->feed->risk_matrix : [];
												$level = $riskMatrix['level'] ?? '';

												$riskColors = [
													'High' => '#d9534f',
													'Medium' => '#f0ad4e',
													'Low' => '#1c8e42ff',
													'default' => '#6c757d'
												];

												$priorityColors = [
													'P1-Critical' => '#ff4d4d',
													'P2-High' => '#ff9800',
													'P3-Medium' => '#fbc02d',
													'P4-Low' => '#1c8e42ff',
													'Unassigned' => '#6c757d'
												];

												$incidentColors = [
													'Sentinel' => '#ff4d4d',
													'Hazardous Condition' => '#ff9800',
													'Adverse' => '#fbc02d',
													'No-harm' => '#1c36b4ff',
													'Near miss' => '#1c8e42ff',
													'Unassigned' => '#6c757d'
												];
												?>

												<td>
													<table style="width:100%; font-size:14px;">

														<!-- RISK -->
														<tr>
															<td style="width:30px; font-weight:bold;">Risk</td>
															<td style="width:10px;">:</td>
															<td>
																<strong style="color:<?php echo $riskColors[$level] ?? $riskColors['default']; ?>;">
																	<?php echo $level ?: 'Unassigned'; ?>
																</strong>
															</td>
														</tr>

														<!-- PRIORITY -->
														<tr>
															<td style="font-weight:bold;">Priority</td>
															<td>:</td>
															<td>
																<strong style="color:<?php echo $priorityColors[$priority]; ?>;">
																	<?php echo $priority; ?>
																</strong>
															</td>
														</tr>

														<!-- CATEGORY -->
														<tr>
															<td style="font-weight:bold;">Category</td>
															<td>:</td>
															<td>
																<strong style="color:<?php echo $incidentColors[$incident_type]; ?>;">
																	<?php echo $incident_type; ?>
																</strong>
															</td>
														</tr>

													</table>
												</td>


											</tr>

										<?php $sl++;
										} ?>

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
					var benchmark = "<?php echo $result->reporting_errors; ?>"; // Benchmark value
					var calculated = "<?php echo  $result->number_of_test_performed; ?>"; // Calculated value
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
							labels: ['Number of reporting errors', 'Number of tests performed'],
							datasets: [{
								label: 'Number of reporting errors compare with Number of tests performed',
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
									text: 'No. of reporting errors per 1000 investigations for ' + monthyear,
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
			<h3>2.PSQ3a- Number of reporting errors per 1000 investigations</h3>
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
						link.download = '2.PSQ3a- Number of reporting errors per 1000 investigations.png'; // Name of downloaded file
						link.click(); // Trigger download
					}
				</script>