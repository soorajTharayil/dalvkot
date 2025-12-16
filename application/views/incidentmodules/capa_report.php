<div class="content">

	<?php

	// Initialize arrays to track user statistics
	$userStats = [];

	// Process the departments array to calculate the required values
	foreach ($departments as $department) {
		$userName = $department->replymessage[0]->message ?? 'Unknown'; // User name from reply message
		$createdOn1 = strtotime($department->created_on); // Ticket open time
		$lastModified1 = strtotime($department->last_modified); // Ticket close time
		$ticketStatus = $department->status; // Ticket status

		// Ensure the user exists in the stats array
		if (!isset($userStats[$userName])) {
			$userStats[$userName] = [
				'closed_count' => 0,
				'total_tickets' => 0,
				'total_resolution_time' => 0, // Cumulative resolution time
			];
		}

		// Increment total tickets
		$userStats[$userName]['total_tickets']++;

		// Process only closed tickets
		if ($ticketStatus === 'Closed') {
			$userStats[$userName]['closed_count']++;
			$resolutionTime = ($lastModified1 - $createdOn1) / 60; // Time in minutes
			$userStats[$userName]['total_resolution_time'] += $resolutionTime;
		}
	}
	// Start the table
	echo '<table class="table table-striped table-bordered">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>User Name</th>';
	echo '<th>Closed Ticket Count</th>';
	echo '<th>Average Resolution Time (Minutes)</th>';
	echo '<th>Average Resolution Time (Days)</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';

	// Loop through user statistics and display in the table
	foreach ($userStats as $userName => $stats) {
		$closedCount = $stats['closed_count'];
		$totalTickets = $stats['total_tickets'];
		$averageResolutionTimeMinutes = $closedCount > 0 ? floor($stats['total_resolution_time'] / $closedCount) : 0;
		$averageResolutionTimeDays = $closedCount > 0 ? floor(($stats['total_resolution_time'] / $closedCount) / 1440) : 0;

		echo '<tr>';
		echo '<td>' . htmlspecialchars($userName) . '</td>';
		echo '<td>' . htmlspecialchars($closedCount) . '</td>';
		echo '<td>' . htmlspecialchars($averageResolutionTimeMinutes) . ' Minutes</td>';

		if ($averageResolutionTimeDays == 0) {
			echo '<td>Less than a day</td>';
		} else {
			echo '<td>' . htmlspecialchars($averageResolutionTimeDays) . ' Days</td>';
		}
		echo '</tr>';
	}

	echo '</tbody>';
	echo '</table>';
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
	if (count($departments)) {
	?>

		<div class="row">

			<!--  table area -->
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: right;">
						<div class="btn-group">
							<a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="<?php echo lang_loader('inc', 'inc_download_capa_report_tooltip'); ?>" href="<?php echo base_url($this->uri->segment(1)) . '/download_capa_report' ?>">
								<i class="fa fa-file-text"></i>
							</a>
						</div>
					</div>

					<div class="panel-body">
						<?php if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?>
							<form>
								<p>
									<!-- <span style="font-size:15px; font-weight:bold;"><?php echo lang_loader('inc', 'inc_sort_incident_by'); ?></span> -->
									<select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment2(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
										<option value="1" selected><?php echo lang_loader('inc', 'inc_select_category'); ?></option>
										<?php
										$this->db->group_by('description');
										$this->db->where('type', 'incident');
										$query = $this->db->get('department');
										$result = $query->result();

										foreach ($result as $row) {
										?>
											<?php if ($this->input->get('depsec') == $row->description) { ?>
												<option value="<?php echo str_replace('&', '%26', $row->description); ?>" selected><?php echo $row->description; ?></option>
											<?php } else { ?>
												<option value="<?php echo str_replace('&', '%26', $row->description); ?>"><?php echo $row->description; ?></option>
											<?php } ?>

										<?php } ?>
									</select>
									<?php if (isset($_GET['depsec'])) { ?>
										<span style="font-size:15px; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<select name="dep" class="form-control" onchange="gotonextdepartment(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
											<option value="1" selected><?php echo lang_loader('inc', 'inc_select_incident'); ?></option>
											<?php
											$this->db->where('type', 'incident');
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
								</p>
							</form>
							<br />
						<?php } ?>

						<table class="inccapareport table table-striped table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo lang_loader('inc', 'inc_slno'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_incidents_id'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_incident_reported_by'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_incident'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_rca'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_capa'); ?></th>
									<th style="white-space: nowrap;">Closed by</th>
									<?php if (close_comment('inc_close_comment') === true) { ?>
										<th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_comment'); ?></th>
									<?php } ?>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_turn_around'); ?><br><?php echo lang_loader('inc', 'inc_tat'); ?></th>


								</tr>
							</thead>
							<tbody>
								<?php if (!empty($departments)) {		?>
									<?php $sl = 1; ?>
									<?php foreach ($departments as $department) {

										if ($department->status == 'Closed') {
											$this->db->where('ticketid', $department->id)->where('ticket_status', 'Closed');
											$query = $this->db->get('ticket_incident_message');
											$ticket = $query->result();
											$rowmessage = $ticket[0]->message . ' Closed this ticket';
											$createdOn1 = strtotime($department->created_on);
											$lastModified1 = strtotime($department->last_modified);
											$closeddiff = $lastModified1 - $createdOn1;
											if ($department->department->close_time <= $closeddiff) {
												$close = '<b><span style="color:red;">Exceeded TAT<span></b>';
											} else {
												$close = '<b><span style="color:green;">Within TAT<span></b>';
											}
										} elseif ($department->status == 'Addressed') {
											$this->db->where('ticketid', $department->id)->where('ticket_status', 'Addressed');
											$query = $this->db->get('ticket_incident_message');
											$ticket = $query->result();
											$addressed_comm = $ticket[0]->reply;
											$createdOn2 = strtotime($department->created_on);
											$lastModified2 = strtotime($department->last_modified);
											$adddiff = $lastModified2 - $createdOn2;
											if ($department->department->address_time <= $adddiff) {
												$add = 'Addressed OT';
											} else {
												$add = 'Addressed WT';
											}
										}
										if (strlen($rowmessage) > 60) {
											$rowmessage = substr($rowmessage, 0, 60) . '  ' . ' ... click status to view';
										}

									?>
										<tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>" data-placement="bottom" data-toggle="tooltip" title="<?php echo $rowmessage; ?>">
											<td><?php echo $sl; ?></td>
											<td><a href="<?php echo $ip_link_patient_feedback . $department->id; ?>"><?php echo lang_loader('inc', 'inc_inc'); ?><?php echo $department->id; ?></a></td>

											<td style="overflow: clip; word-break: break-all;">


												<?php if (!empty($department->feed->patientid)) : ?>
													<?php echo $department->feed->name; ?>
													&nbsp;(
													<?php echo $department->feed->patientid; ?>
													</a>)
												<?php else : ?>

													<?php echo $department->feed->name; ?>

												<?php endif; ?>

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

											<td style="overflow: clip; word-break: break-all;">

												<?php
												if ($department->departmentid_trasfered != 0) {
													$show = false;
													if ($department->status == 'Addressed') {
														echo $addressed_comm;
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
																	echo $res[$key];
																	echo '<br>';
																	$show = $res[$key];
																}
															}
														}
													}
												}
												// print_r($show);
												?>
											</td>


											<td style="overflow: clip; word-break: break-all;">
												<?php foreach ($department->replymessage as $r) { ?>
													<?php if ($r->rootcause != NULL) { ?>
														<?php echo $r->rootcause; ?>
														<br>

													<?php } ?>
												<?php } ?>
											</td>
											<td style="overflow: clip; word-break: break-all;">
												<?php foreach ($department->replymessage as $r) { ?>
													<?php if ($r->corrective != NULL) { ?>

														<?php echo $r->corrective; ?>
														<br>
													<?php } ?>
												<?php } ?>
											</td>
											<td style="overflow: clip; word-break: break-all;">
												<?php foreach ($department->replymessage as $r) { ?>
													<?php if ($r->corrective != NULL) { ?>

														<?php echo $ticket[0]->message; ?>

														<br>
													<?php } ?>
												<?php } ?>
											</td>
											<?php if (close_comment('inc_close_comment') === true) { ?>
												<td style="overflow: clip; word-break: break-all;">
													<?php foreach ($department->replymessage as $r) { ?>
														<?php if ($r->comment != NULL) { ?>

															<?php echo $r->comment; ?>
														<?php } ?>
													<?php } ?>
												</td>
											<?php } ?>

											<td>
												<?php
												$createdOn = strtotime($department->created_on);
												$lastModified = strtotime($department->last_modified);
												$timeDifferenceInSeconds = $lastModified - $createdOn;
												$value = $this->incident_model->convertSecondsToTime($timeDifferenceInSeconds);

												if ($value['days'] != 0) {
													echo $value['days'] . ' days, ';
												}
												if ($value['hours'] != 0) {
													echo  $value['hours'] . ' hrs, ';
												}
												if ($value['minutes'] != 0) {
													echo  $value['minutes'] . ' mins.';
												}
												if ($timeDifferenceInSeconds <= 60) {
													echo  'less than a minute';
												}
												?>
											</td>


										</tr>
										<?php $sl++; ?>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table> <!-- /.table-responsive -->
					</div>
				</div>
			</div>
		</div>
	<?php } else {   ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('inc', 'inc_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>
</div>
<script>
	function gotonextdepartment(type) {
		var subsecid = $('#subsecid').val();
		var url = "<?php echo base_url($this->uri->segment(1) . "/capa_report?type=") ?>" + type + "&depsec=" + subsecid;
		window.location.href = url;
	}

	function gotonextdepartment2(type) {
		var url = "<?php echo base_url($this->uri->segment(1) . "/capa_report?depsec=") ?>" + type;
		window.location.href = url;
	}
</script>