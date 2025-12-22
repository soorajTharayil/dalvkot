<div class="content">

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
	if (count($departments)) {
	?>

		<div class="row">

			<!--  table area -->
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: right;">
						<div class="btn-group">
							<a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="Download open incidents report" href="<?php echo base_url($this->uri->segment(1)) . '/download_' . ($this->uri->segment(2)) ?>">
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
									<select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment_severity(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
										<option value="1" selected>Select Severity</option>
										<?php
										$this->db->order_by('title');

										$query = $this->db->get('incident_type');
										$result = $query->result();

										foreach ($result as $row) {
										?>
											<?php if ($this->input->get('depsec_severity') == $row->title) { ?>
												<option value="<?php echo str_replace('&', '%26', $row->title); ?>" selected><?php echo $row->title; ?></option>
											<?php } else { ?>
												<option value="<?php echo str_replace('&', '%26', $row->title); ?>"><?php echo $row->title; ?></option>
											<?php } ?>

										<?php } ?>
									</select>
									<select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment_priority(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
										<option value="1" selected>Select Priority</option>
										<?php
										$this->db->order_by('title');
										$query = $this->db->get('priority');
										$result = $query->result();

										foreach ($result as $row) {
										?>
											<?php if ($this->input->get('depsec_priority') == $row->title) { ?>
												<option value="<?php echo str_replace('&', '%26', $row->title); ?>" selected><?php echo $row->title; ?></option>
											<?php } else { ?>
												<option value="<?php echo str_replace('&', '%26', $row->title); ?>"><?php echo $row->title; ?></option>
											<?php } ?>

										<?php } ?>
									</select>
								</p>
							</form>
							<br />
						<?php } ?>

						<table class="incticketsopen table table-striped table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo lang_loader('inc', 'inc_slno'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_incidents_id'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_incident_reported_by'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_incident'); ?></th>
									<th style="white-space: nowrap;">Incident<br>Severity</th>
									<th style="white-space: nowrap;">Incident<br>Priority</th>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_reported_on'); ?></th>
									<!-- <?php if (incident_tat('open_ticket') === true) { ?>
										<th style="white-space: nowrap;"><?php echo lang_loader('inc', 'inc_turn_around'); ?><br><?php echo lang_loader('inc', 'inc_tat'); ?></th>
									<?php } ?> -->
									<th style="text-align: center;"><?php echo lang_loader('inc', 'inc_status'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($departments)) {

								?>
									<?php $sl = 1; ?>
									<?php foreach ($departments as $department) {

										if ($department->status == 'Transfered') {
											$this->db->where('ticketid', $department->id)->where('ticket_status', 'Transfered');
											$query = $this->db->get('ticket_incident_message');
											$ticket = $query->result();
											$trans_comm =  $ticket[0]->reply;
											$rowmessage = $ticket[0]->message . ' Transfered because, ' . $ticket[0]->reply;
										} elseif ($department->status == 'Reopen') {
											$this->db->where('ticketid', $department->id)->where('ticket_status', 'Reopen');
											$query = $this->db->get('ticket_incident_message');
											$ticket = $query->result();
											$reopen_comm =  $ticket[0]->reply;
											$rowmessage = $ticket[0]->message . 'Reopened because, ' . $ticket[0]->reply;
											$comment = $ticket[0]->reply;
										} else {
											$last_modified = time();
											$rowmessage = 'THIS TICKET IS OPEN';
											$createdOn1 = strtotime($department->created_on);
											//print_r($createdOn1);
											$lastModified1 = $last_modified;
											// print_r($lastModified1);

											//print_r($ttime);
											//print_r($department->department);
											$ttime = strtotime('+' . $department->department->close_time . ' seconds', $createdOn1);
											$closeddiff =   $lastModified1 - $createdOn1;
											// $timeleft =   $department->department->close_time + $createdOn1;
											if ($department->department->close_time <= $closeddiff) {
												$close = '<b><span style="color:red;">Exceeded TAT<span></b>';
											} else {
												$close = '<b><span style="color:green;">Within TAT<span></b>';
											}
										}
										if (strlen($rowmessage) > 60) {
											$rowmessage = substr($rowmessage, 0, 60) . '...';
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

												<?php endif; ?> <!-- <br>
											
												<?php echo $department->feed->role; ?> -->
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

													if ($show == false) {
														echo 'Ticket was transferred';
													}
												} else {

													foreach ($department->feed->reason as $key => $value) {


														if ($key) {
															if ($titles[$key] == $department->department->description) {
																if (in_array($key, $keys)) {
																	echo $res[$key];
																	echo '<br>';
																	echo '<strong>' . $department->department->description . '</strong>';
																	$show = $res[$key];
																}
															}
														}
													}
												}
												// print_r($show);
												?>
											<td style="overflow: clip; word-break: break-all; white-space: nowrap;">
												<span><?php echo $department->feed->incident_type; ?></span>
												<?php if (!empty($department->feed->patientid)) { ?>
													<?php if (ismodule_active('INCIDENT') === true && isfeature_active('EDIT-SEVERITY-INCIDENTS') === true) { ?>
														<a href="<?php echo $ip_link_patient_feedback . $department->feed->patientid; ?>" title="Edit" style="margin-left: 5px;">
															<i style="font-size: 20px; color: green; vertical-align: middle; position: relative; top: 1px;" class="fa fa-edit" data-toggle="tooltip" data-placement="bottom"></i>
														</a>
													<?php } ?>
												<?php } ?>
											</td>


											<td style="overflow: clip; word-break: break-all; white-space: nowrap;">
												<span><?php echo $department->feed->priority; ?></span>
												<?php if (!empty($department->feed->patientid)) { ?>
													<?php if (ismodule_active('INCIDENT') === true && isfeature_active('EDIT-PRIORITY-INCIDENTS') === true) { ?>
														<a href="<?php echo $ip_link_patient_feedback . $department->feed->patientid; ?>" title="Edit" style="margin-left: 5px;">
															<i style="font-size: 20px; color: green; vertical-align: middle; position: relative; top: 1px;" class="fa fa-edit" data-toggle="tooltip" data-placement="bottom"></i>
														</a>
													<?php } ?>
												<?php } ?>
											</td>
											<td style="overflow: clip; word-break: break-all;">

												<?php echo date('g:i A', strtotime($department->created_on)); ?>
												<br>
												<?php echo date('d-m-y', strtotime($department->created_on)); ?>
											</td>
											<?php if (incident_tat('open_ticket') === true) { ?>
												<td style="overflow: clip; word-break: break-all;">
													<?php



													// echo 'Close ticket within';

													echo date('g:i A', $ttime);
													echo '<br>';

													echo date('d-m-y', $ttime);
													echo '<br>';


													echo  $close;

													?>
												</td>
											<?php } ?>

											<?php
											// Set default values for $tool and $color
											$tool = '';
											$color = 'btn-info'; // Default to a Bootstrap class if status doesn't match

											// Determine the tooltip and color based on the department status
											if ($department->status == 'Addressed') {
												$tool = 'Click to close this ticket.';
												$department_status = 'Addressed';
												$color = 'btn-warning';
											} elseif ($department->status == 'Open') {
												$tool = 'Click to change the status.';
												$department_status = 'Pending';
												$color = 'btn-danger';
											} elseif ($department->status == 'Rejected') {
												$tool = 'Click to change the status.';
												$department_status = 'Rejected';
												$color = 'btn-yellow'; // Changed color to btn-yellow for Rejected
											} elseif ($department->status == 'Closed') {
												$tool = 'Ticket is closed';
												$department_status = 'Closed';
												$color = 'btn-success';
											} elseif ($department->status == 'Reopen') {
												$department_status = 'Reopened';
												$tool = 'Click to close this ticket.';
												$color = 'btn-primary';
											} elseif ($department->status == 'Transfered') {
												$tool = 'Click to close this ticket.';
												$color = 'btn-info';
												$department_status = 'Transfered';
											} elseif ($department->status == 'Assigned') {
												$tool = 'Click to change the status.';
												$department_status = 'Assigned';
												$color = 'btn-orange'; // Added this condition for Assigned
											} else {
												$tool = 'Unknown status';
												$color = 'btn-info';
											}
											?>


											<td style="display: flex; align-items: center; gap: 10px;">
												<a
													data-placement="bottom"
													data-toggle="tooltip"
													title="<?php echo $tool; ?>" class="btn btn-sm <?php echo $color; ?>">
													<?php echo $department_status; ?>
													<i style="font-size: x-small;" class="fa fa-edit"></i>
												</a>

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
		var url = "<?php echo base_url($this->uri->segment(1) . "/opentickets?type=") ?>" + type + "&depsec=" + subsecid;
		window.location.href = url;
	}

	function gotonextdepartment2(type) {
		var url = "<?php echo base_url($this->uri->segment(1) . "/opentickets?depsec=") ?>" + type;
		window.location.href = url;
	}


	function gotonextdepartment_severity(type) {
		var url = "<?php echo base_url($this->uri->segment(1) . "/opentickets?depsec_severity=") ?>" + type;
		window.location.href = url;
	}

	function gotonextdepartment_priority(type) {
		var url = "<?php echo base_url($this->uri->segment(1) . "/opentickets?depsec_priority=") ?>" + type;
		window.location.href = url;
	}
</script>
<style>
	.btn-orange {
		background-color: #f09a22;
		color: white;
		font-size: 14px;
	}

	.btn-bluee {
		background-color: #2a73e8;
		color: white;
		font-size: 14px;
	}

	.btn-reddd {
		background-color: #3f1670;
		color: white;
		font-size: 14px;
	}

	.btn-yellow {
		background-color: #FFDE4D;
		color: white;
		font-size: 14px;
	}
</style>
<script>
	function submitDeleteForm(event) {
		event.preventDefault(); // Prevent default anchor behavior

		// Show confirmation alert
		const confirmDelete = confirm("This incident will be permanently deleted from the application. Are you sure you want to proceed?");

		if (confirmDelete) {
			document.getElementById('deleteForm').submit(); // Submit the form if confirmed
		}
	}
</script>