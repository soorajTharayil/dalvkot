<?php
// individual patient feedback link
$users = $this->db->select('user.*')
	->get('user')
	->result();

$department_users = array();
foreach ($users as $user) {
	$parameter = json_decode($user->department);


	foreach ($parameter as $key => $rows) {
		foreach ($rows as $k => $row) {

			$slugs = explode(',', $row);

			foreach ($slugs as $r) {
				$department_users[$key][$k][$r][] = $user->firstname;
			}
		}
	}
}


$ip_link_patient_feedback = base_url($this->uri->segment(1) . '/patient_feedback?id=');
$this->db->select("*");
$this->db->from('setup_incident');
$this->db->where('parent', 1);
$query = $this->db->get();
$reasons = $query->result();
foreach ($reasons as $row) {
	$keys[$row->shortkey] = $row->shortkey;
	$res[$row->shortkey] = $row->shortname;
	$titles[$row->shortkey] = $row->title;
}
// $feedbacktaken = $this->ipd_model->patient_and_feedback($table_patients, $table_feedback, $desc);

// Step 1: Get escalation rows
$this->db->select('*');
$this->db->from('escalation');
$this->db->where('section', 'INCIDENT');
$query = $this->db->get();
$escalations = $query->result();

foreach ($escalations as &$e) {
	// Step 2: Decode JSON user ID arrays
	$level1_ids = json_decode($e->level1_escalate_to ?? '[]');
	$level2_ids = json_decode($e->level2_escalate_to ?? '[]');
	$dept_ids = json_decode($e->dept_level_escalation_to ?? '[]');

	// Step 3: Get usernames for level1
	if (!empty($level1_ids)) {
		$this->db->select('firstname');
		$this->db->from('user');
		$this->db->where_in('user_id', $level1_ids);

		$level1_users = $this->db->get()->result();
		$e->level1_usernames = array_column($level1_users, 'firstname');
	}

	// Step 4: Get usernames for level2
	if (!empty($level2_ids)) {
		$this->db->select('firstname');
		$this->db->from('user');
		$this->db->where_in('user_id', $level2_ids);

		$level2_users = $this->db->get()->result();
		$e->level2_usernames = array_column($level2_users, 'firstname');
	}

	// Step 5: Get usernames for dept-level
	if (!empty($dept_ids)) {
		$this->db->select('firstname');
		$this->db->from('user');
		$this->db->where_in('user_id', $dept_ids);

		$dept_users = $this->db->get()->result();
		$e->dept_usernames = array_column($dept_users, 'firstname');
	}
}



// $this->db->select('*');
// $this->db->from('department');
// $this->db->where('type', 'inpatient');
// $query_tat = $this->db->get();
// $tat_department = $query_tat->result();

// print_r($tat_department);
// exit;

?>

<div class="content">
	<?php
	$filtered_departments = [];

	foreach ($departments as $department) {
		$tat_filter = $this->input->get('tat_status');

		// Calculate TAT duration
		$createdOn = strtotime($department->created_on);
		$lastModified = strtotime($department->last_modified);
		$tatSeconds = $lastModified - $createdOn;

		$status = '';

		if ($department->status == 'Closed' && $department->department->close_time > $tatSeconds) {
			$status = 'within';
		} elseif ($department->department->close_time <= $tatSeconds) {
			$status = 'exceeded';
		} else {
			$status = 'within'; // For open ones not exceeding yet
		}

		if (!$tat_filter || $tat_filter === $status) {
			$filtered_departments[] = $department;
		}
	}
	?>
	<?php if (count($departments)) {



		?>
		<div class="row">

			<!--  table area -->
			<div class="col-lg-12">
				<div class="panel panel-default ">
					<div class="panel-heading" style="text-align: right;">
						<div class="btn-group">
							<a class="btn btn-success" target="_blank" data-placement="bottom" data-toggle="tooltip"
								title="<?php echo lang_loader('ip', 'ip_download_all_report'); ?>"
								href="<?php echo base_url($this->uri->segment(1)) . '/download_' . ($this->uri->segment(2)) ?>">
								<i class="fa fa-file-text"></i>
							</a>
						</div>
					</div>
					<div class="panel-body">
						<?php if ($this->session->userdata('user_role') != 4) { ?>
							<form>
								<p>
									<!-- <span style="font-size:15px; font-weight:bold;">Sort Tickets By : </span> -->
									<select name="dep" class="form-control" id="subsecid"
										onchange="gotonextdepartment2(this.value)"
										style="width:200px; margin:0px 0px 20px 20px;">
										<option value="1" disabled selected>Filter by Department
										</option>
										<?php
										$this->db->group_by('description');
										$this->db->where('type', 'interim');
										$query = $this->db->get('department');
										$result = $query->result();

										foreach ($result as $row) {
											?>
											<?php if ($this->input->get('depsec') == $row->description) { ?>
												<option value="<?php echo str_replace('&', '%26', $row->description); ?>" selected>
													<?php echo $row->description; ?>
												</option>
											<?php } else { ?>
												<option value="<?php echo str_replace('&', '%26', $row->description); ?>">
													<?php echo $row->description; ?>
												</option>
											<?php } ?>

										<?php } ?>
									</select>
									<select name="tat_status" class="form-control" id="tat_status"
										onchange="gotonextTATFilter(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
										<option value="1" selected disabled>Filter by TAT Status</option>

										<option value="within" <?php echo ($this->input->get('tat_status') == 'within') ? 'selected' : ''; ?>>Within TAT</option>
										<option value="exceeded" <?php echo ($this->input->get('tat_status') == 'exceeded') ? 'selected' : ''; ?>>Exceeded TAT</option>
									</select>
								<div style="display: none;">

									<?php if (isset($_GET['depsec'])) { ?>
										<span
											style="font-size:15px; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<select name="dep" class="form-control" onchange="gotonextdepartment(this.value)"
											style="width:200px; margin:0px 0px 20px 20px;">
											<option value="1" selected><?php echo lang_loader('ip', 'ip_select_parameter'); ?>
											</option>
											<?php
											$this->db->where('type', 'interim');
											$this->db->where('description', $this->input->get('depsec'));
											$query = $this->db->get('department');
											$result = $query->result();
											foreach ($result as $row) {
												?>
												<?php if ($this->input->get('type') == $row->dprt_id) { ?>
													<option value="<?php echo $row->dprt_id; ?>" selected><?php echo $row->name; ?></option>
												<?php } else { ?>
													<option value="<?php echo $row->dprt_id; ?>"><?php echo $row->name; ?></option>
												<?php } ?>

											<?php } ?>
										</select>
									<?php } ?>
								</div>
								</p>
							</form>
							<br />
						<?php } ?>
						<div style="width: 100%; overflow-x: auto;">
							<table class="escalationticketsall table table-bordered table-hover"
								style="min-width: 1800px; white-space: nowrap;">

								<thead>
									<tr>
										<th>Sl. No</th>
										<th>Incident ID</th>
										<th>Incident Reported by </th>
										<th>Escalation Mapping</th>
										<th>Ticket Timeline</th>
										<th>Incident Explanation Escalation</th>
										<!-- <th>Department Level Escalation (L1)</th> -->
										<!-- <th>(L1) Escalated To</th> -->
										<th>TAT Status</th>
										<!-- <th>L2 TAT</th> -->
										<th>L2 - Admin Level Escalations</th>
										<!-- <th>(L2) Escalated To</th> -->
										<!-- <th>L3 TAT</th> -->
										<th>L3 - Sr. Admin Level Escalations </th>
										<!-- <th>(L3) Escalated To</th> -->
										<th>Status</th>
									</tr>
								</thead>
								<tbody>

									<?php $sl = 1; ?>
									<?php foreach ($filtered_departments as $department) {


										if ($department->status == 'Addressed') {
											$this->db->where('ticketid', $department->id)->where('ticket_status', 'Addressed');
											$query = $this->db->get('ticket_message');
											$ticket = $query->result();
											$addressed_comm = $ticket[0]->reply;
											$rowmessage = $ticket[0]->message . '  addressed the ticket with , ' . $ticket[0]->reply;
										} elseif ($department->status == 'Transfered') {
											$this->db->where('ticketid', $department->id)->where('ticket_status', 'Transfered');
											$query = $this->db->get('ticket_message');
											$ticket = $query->result();
											$trans_comm = $ticket[0]->reply;
											$rowmessage = $ticket[0]->message . ' Transfered because, ' . $ticket[0]->reply;
										} elseif ($department->status == 'Reopen') {
											$this->db->where('ticketid', $department->id)->where('ticket_status', 'Reopen');
											$query = $this->db->get('ticket_message');
											$ticket = $query->result();
											$reopen_comm = $ticket[0]->reply;
											$rowmessage = $ticket[0]->message . 'Reopened because, ' . $ticket[0]->reply;
										} elseif ($department->status == 'Closed') {
											$this->db->where('ticketid', $department->id)->where('ticket_status', 'Closed');
											$query = $this->db->get('ticket_message');
											$ticket = $query->result();

											$rowmessage = $ticket[0]->message . ' Closed the ticket,  Root Cause: ' . $ticket[0]->rootcause . '. CAPA: ' . $ticket[0]->corrective . '  ';
										} else {
											$rowmessage = 'THIS TICKET IS OPEN';
										}
										if (strlen($rowmessage) > 60) {
											$rowmessage = substr($rowmessage, 0, 60) . '  ' . ' ... click status to view';
										}

										?>
										<tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>"
											data-placement="bottom" data-toggle="tooltip" title="<?php echo $rowmessage; ?>">
											<td><?php echo $sl; ?></td>
											<td>
												<a href="<?php echo base_url($this->uri->segment(1) . "/track/$department->id"); ?>"
													style="color: inherit; text-decoration: none;">


													INC - <?php echo $department->id; ?>
												</a>
											</td>
											<td class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?> clickable-row"
												data-href="<?php echo $ip_link_patient_feedback . $department->feedbackid; ?>"
												style="overflow-wrap: break-word; word-break: normal;">
												<?php echo $department->feed->name; ?>&nbsp;(<a
													href="<?php echo $ip_link_patient_feedback . $department->feedbackid; ?>"
													style="color: #000; text-decoration: none;">
													<?php echo $department->feed->patientid; ?>
												</a>)
												<br>
												<?php echo $department->feed->ward; ?>
												<?php if ($department->feed->bedno) { ?>
													<?php echo 'in ' . $department->feed->bedno; ?>

												<?php } ?>
												<br>
												<?php
												echo "<i class='fa fa-phone'></i> ";
												echo $department->feed->contactnumber; ?>
												<?php if ($department->feed->email) { ?>
													<br>
													<?php echo "<i class='fa fa-envelope'></i> "; ?>
													<?php echo $department->feed->email; ?>
												<?php } ?>
											</td>

											<td style="overflow-wrap: break-word; word-break: normal;">
												<a href="<?php echo base_url($this->uri->segment(1) . "/track/$department->id"); ?>"
													style="color: inherit; text-decoration: none;">

													<?php
													echo '<strong> Department : </strong>';
													echo $department->department->description;
													if ($department->departmentid_trasfered != 0) {
														$show = false;
														if ($department->status == 'Addressed') {
															echo 'Ticket was transferred';
															$show = true;
														}
														if ($department->status == 'Transfered') {
															echo $trans_comm;
															$show = true;
														}
														if ($department->status == 'Reopen') {
															echo $reopen_comm;
															$show = true;
														}

														if ($show == false && $department->status == 'Closed') {
															echo 'Ticket was transferred';
														}
													} else {

														foreach ($department->feed->reason as $key => $value) {


															if ($key) {
																if ($titles[$key] == $department->department->description) {
																	if (in_array($key, $keys)) {

																		echo '<br>';
																		echo '<strong> Concern : </strong>';
																		echo $res[$key];
																		echo '<br>';
																		echo '<strong> Assigned To : </strong>';
																		$users = $department_users[$department->department->type][$department->department->setkey][$department->department->slug] ?? [];

																		echo !empty($users) ? implode(', ', $users) : 'None';

																		$show = $res[$key];
																	}
																}
															}
														}
													}
													// print_r($show);
													?>
												</a>

											</td>






											<td style="overflow-wrap: break-word; word-break: normal;">
												<a href="<?php echo base_url($this->uri->segment(1) . "/track/$department->id"); ?>"
													style="color: inherit; text-decoration: none;">
													<?php
													echo '<strong> Created On : </strong>';
													echo date('g:i A', strtotime($department->created_on));
													echo ' , ';
													?>

													<?php echo date('d-m-y', strtotime($department->created_on));
													echo '<br>';
													echo '<strong> Closed On : </strong>';
													if ($department->status == 'Closed') {
														echo date('g:i A', strtotime($department->last_modified));
														echo ' , ';
														echo date('d-m-y', strtotime($department->last_modified));
													} else {
														echo 'Ticket is still open';
													}
													?>

												</a>
											</td>


											<!-- L1 TAT -->
											<td>
												<?php
												$seconds = (int) $department->department->dept_level_escalation;
												echo "<strong>L1 TAT :</strong> ";

												if ($seconds >= 86400) { // more than or equal to 1 day
													$days = $seconds / 86400;
													echo round($days, 1) . ' day(s)';
												} elseif ($seconds >= 3600) { // more than or equal to 1 hour
													$hours = $seconds / 3600;
													echo round($hours, 1) . ' hr(s)';
												} elseif ($seconds >= 60) {
													$minutes = $seconds / 60;
													echo round($minutes) . ' min(s)';
												} else {
													echo $seconds . ' sec';
												}
												echo '<br>';
												?>
												<?php
												$json = $department->dept_level_escalation_status;
												$decoded = json_decode($json, true);

												if ($decoded) {
													// Format datetime to 12-hour with am/pm
													$created = date("d-m-Y h:iA", strtotime($decoded['created_at']));
													$scheduled = date("d-m-Y h:iA", strtotime($decoded['sheduled_at']));

													// Get status
													$status = strtolower($decoded['status']);
													$statusColor = 'black';
													$reasonText = '';

													if ($status === 'sent') {
														$statusColor = 'red';
														$statuschange = "Escalated";
													} elseif ($status === 'pending') {
														$statusColor = 'orange';
														$statuschange = "Awaiting Trigger";
													} elseif ($status === 'failed') {
														$statusColor = 'green';
														$statuschange = "Unescalated";
														$reasonText = " (Closed within TAT)";
													}

													echo "<span style='color: $statusColor; font-weight: bold;'>Status: " . $statuschange . "$reasonText</span><br>";
													// echo "Created: " . htmlspecialchars($created) . "<br>";
													echo "Scheduled: " . htmlspecialchars($scheduled);
												} else {
													echo "L1 Escalation not set";
												}
												echo '<br>';

												?>

												<?php
												echo "<strong>Escalated to :</strong> ";
												foreach ($escalations as $e) {
													if (!empty($e->dept_usernames)) {
														echo ' ' . implode(', ', $e->dept_usernames) . '<br>';
													} else {
														echo 'None<br>';
													}
												}
												?>
											</td>


											<!-- TAT Status -->
											<td>

												<?php

												$createdOn1 = strtotime($department->created_on);
												$lastModified1 = strtotime($department->last_modified);
												$closeddiff = $lastModified1 - $createdOn1;
												if ($department->department->close_time <= $closeddiff   || $department->status != 'Closed') {
													$close = '<b><span style="color:red;">Exceeded TAT<span></b>';
												} elseif ($department->status == 'Closed') {
													$close = '<b><span style="color:green;">Closed within TAT<span></b>';

												} else {
													$close = '<b><span style="color:green;">Within TAT<span></b>';
												}

												$createdOn = strtotime($department->created_on);
												$lastModified = strtotime($department->last_modified);
												$timeDifferenceInSeconds = $lastModified - $createdOn;
												$value = $this->incident_model->convertSecondsToTime($timeDifferenceInSeconds);

												// if ($value['days'] != 0) {
												// 	echo $value['days'] . ' days, ';
												// }
												// if ($value['hours'] != 0) {
												// 	echo $value['hours'] . ' hrs, ';
												// }
												// if ($value['minutes'] != 0) {
												// 	echo $value['minutes'] . ' mins.';
												// }
												// if ($timeDifferenceInSeconds <= 60) {
												// 	echo 'less than a minute';
												// }
												echo '<br>';
												echo $close;

												?>

											</td>

											<!-- Admin Level Escalations( L2) -->
											<td>
												<?php
												echo "<strong>L2 TAT : </strong> ";

												$seconds = (int) $department->department->close_time;

												if ($seconds >= 86400) { // more than or equal to 1 day
													$days = $seconds / 86400;
													echo round($days, 1) . ' day(s)';
												} elseif ($seconds >= 3600) { // more than or equal to 1 hour
													$hours = $seconds / 3600;
													echo round($hours, 1) . ' hr(s)';
												} elseif ($seconds >= 60) {
													$minutes = $seconds / 60;
													echo round($minutes) . ' min(s)';
												} else {
													echo $seconds . ' sec';
												}
												?>
												<br>
												<?php

												$json = $department->level1_escalation_status;
												$decoded = json_decode($json, true);

												if ($decoded) {
													// Format datetime to 12-hour with am/pm
													$created = date("d-m-Y h:iA", strtotime($decoded['created_at']));
													$scheduled = date("d-m-Y h:iA", strtotime($decoded['sheduled_at']));

													// Get status
													$status = strtolower($decoded['status']);
													$statusColor = 'black';
													$reasonText = '';


													if ($status === 'sent') {
														$statusColor = 'red';
														$statuschange = "Escalated";
													} elseif ($status === 'pending') {
														$statusColor = 'orange';
														$statuschange = "Awaiting Trigger";
													} elseif ($status === 'failed') {
														$statusColor = 'green';
														$statuschange = "Unescalate";
														$reasonText = " (Closed within TAT)";
													}

													echo "<span style='color: $statusColor; font-weight: bold;'>Status: " . $statuschange . "$reasonText</span><br>";// echo "Created: " . htmlspecialchars($created) . "<br>";
													echo "Scheduled: " . htmlspecialchars($scheduled);
												} else {
													echo "L2 Escalation not set";
												}
												?>
												<br>
												<?php
												echo "<strong>Escalated to : </strong> ";

												foreach ($escalations as $e) {
													if (!empty($e->level1_usernames)) {
														echo ' ' . implode(', ', $e->level1_usernames) . '<br>';
													} else {
														echo 'None<br>';
													}
												}
												?>
											</td>



											<!-- Sr. Admin Level Escalations( L3) -->
											<td>
												<?php
												echo "<strong>L3 TAT : </strong> ";

												$seconds = (int) $department->department->close_time_l2;

												if ($seconds >= 86400) { // more than or equal to 1 day
													$days = $seconds / 86400;
													echo round($days, 1) . ' day(s)';
												} elseif ($seconds >= 3600) { // more than or equal to 1 hour
													$hours = $seconds / 3600;
													echo round($hours, 1) . ' hr(s)';
												} elseif ($seconds >= 60) {
													$minutes = $seconds / 60;
													echo round($minutes) . ' min(s)';
												} else {
													echo $seconds . ' sec';
												}
												?>
												<br>
												<?php
												$json = $department->level2_escalation_status;
												$decoded = json_decode($json, true);

												if ($decoded) {
													// Format datetime to 12-hour with am/pm
													$created = date("d-m-Y h:iA", strtotime($decoded['created_at']));
													$scheduled = date("d-m-Y h:iA", strtotime($decoded['sheduled_at']));

													// Get status
													$status = strtolower($decoded['status']);
													$statusColor = 'black';
													$reasonText = '';


													if ($status === 'sent') {
														$statusColor = 'red';
														$statuschange = "Escalated";
													} elseif ($status === 'pending') {
														$statusColor = 'orange';
														$statuschange = "Awaiting Trigger";
													} elseif ($status === 'failed') {
														$statusColor = 'green';
														$statuschange = "Unescalate";
														$reasonText = " (Closed within TAT)";
													}

													echo "<span style='color: $statusColor; font-weight: bold;'>Status: " . $statuschange . "$reasonText</span><br>";// echo "Created: " . htmlspecialchars($created) . "<br>";
													echo "Scheduled: " . htmlspecialchars($scheduled);
												} else {
													echo "L3 Escalation not set";
												}

												?>
												<br>
												<?php
												echo "<strong>Escalated to : </strong> ";

												foreach ($escalations as $e) {
													if (!empty($e->level2_usernames)) {
														echo ' ' . implode(', ', $e->level2_usernames) . '<br>';
													} else {
														echo 'None<br>';
													}
												}
												?>
											</td>
											<!-- Action -->

											<?php
											if ($department->status == 'Addressed') {
												$tool = 'Click to close this ticket.';
												$color = 'warning';
											} elseif ($department->status == 'Open') {
												$tool = 'Click to change the status.';
												$color = 'danger';
											} elseif ($department->status == 'Closed') {
												$tool = 'Ticket is closed';
												$color = 'success';
											} elseif ($department->status == 'Reopen') {
												$tool = 'Click to close this ticket.';
												$color = 'primary';
											} elseif ($department->status == 'Transfered') {
												$tool = 'Click to close this ticket.';
												$color = 'info';
											} else {
												$color = 'info';
											}



											?>
											<?php if (ismodule_active('IP') === true && isfeature_active('IP-OPEN-TICKETS') === true) { ?>
												<td style="align-items: center;">
													<?php echo $department->status; ?>
												</td>
											<?php } ?>
										</tr>
										<?php $sl++; ?>
									<?php } ?>


								</tbody>
							</table> <!-- /.table-responsive -->
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('ip', 'ip_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>

</div>
<script>
	function gotonextdepartment(type) {
		var subsecid = $('#subsecid').val();
		var url = "<?php echo base_url($this->uri->segment(1) . "/alltickets?type=") ?>" + type + "&depsec=" + subsecid;
		window.location.href = url;
	}

	function gotonextdepartment2(type) {
		var url = "<?php echo base_url($this->uri->segment(1) . "/alltickets?depsec=") ?>" + type;
		window.location.href = url;
	}
</script>

<script>
	document.addEventListener("DOMContentLoaded", function () {
		const rows = document.querySelectorAll(".clickable-row");
		rows.forEach(row => {
			row.addEventListener("click", function () {
				const url = this.getAttribute("data-href");
				if (url) {
					window.location.href = url;
				}
			});
		});
	});
</script>

<script>
	function gotonextTATFilter(value) {
		const params = new URLSearchParams(window.location.search);
		params.set("tat_status", value);
		window.location.href = window.location.pathname + "?" + params.toString();
	}
</script>