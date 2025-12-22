<?php
if (!function_exists('getRiskColor')) {
	function getRiskColor($value)
	{
		switch ($value) {
			case 'High':
				return '#d9534f'; // red
			case 'Medium':
				return '#f0ad4e'; // orange
			case 'Low':
				return '#16ae6aff'; // blue
			default:
				return '#6c757d'; // gray
		}
	}
}


?>

<div class="content">

	<?php
	// individual patient feedback link
	$ip_link_patient_feedback = base_url($this->uri->segment(1) . '/employee_complaint?empid=');
	$this->db->select("*");
	$this->db->from('setup_incident');
	//$this->db->where('parent', 0);
	$query = $this->db->get();
	$reasons = $query->result();
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
						<div class="btn-group" style="display: inline-flex;">
							<span style="margin-right: 10px; font-weight: bold;margin-top: 8px;">Downloads:</span>
							<a class="btn btn-success" target="_blank" data-placement="bottom" style="margin-right: 5px;"
								data-toggle="tooltop" title="Download PDF report"
								href="<?php echo base_url($this->uri->segment(1)) . '/download_capa_report_pdf' ?>">
								<i class="fa fa-file-pdf-o"></i>
							</a>
							<a class="btn btn-success" target="_blank" data-placement="bottom" data-toggle="tooltip"
								title="Download Excel report"
								href="<?php echo base_url($this->uri->segment(1)) . '/download_capa_report' ?>">
								<i class="fa fa-file-excel-o"></i>
							</a>
						</div>
					</div>

					<div class="panel-body">
						<?php if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?>
							<form>
								<p>
									<span style="font-size:16px;"><strong>Filter By : </strong></span>

									<!-- <span style="font-size:15px; font-weight:bold;"><?php echo lang_loader('inc', 'inc_sort_incident_by'); ?></span> -->
									<select name="dep" class="form-control" id="subsecid"
										onchange="gotonextdepartment2(this.value)"
										style="width:200px; margin:0px 0px 20px 20px;">
										<option value="1" selected>Category</option>

										<?php
										$this->db->group_by('description');
										$this->db->where('type', 'incident');
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
									<?php if (isset($_GET['depsec'])) { ?>
										<span
											style="font-size:15px; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<select name="dep" class="form-control" onchange="gotonextdepartment(this.value)"
											style="width:200px; margin:0px 0px 20px 20px;">
											<option value="1" selected><?php echo lang_loader('inc', 'inc_select_incident'); ?>
											</option>
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

						<table class="inccapareport table table-striped table-bordered table-hover" cellspacing="0"
							width="100%">
							<thead>
								<tr>
									<th><?php echo lang_loader('inc', 'inc_slno'); ?></th>

									<th style="white-space: nowrap;">
										Incident Details</th>
									<!-- <th style="white-space: nowrap;">Incident Category</th> -->
									<th style="white-space: nowrap;">Incident Timeline & History</th>



								</tr>
							</thead>
							<tbody>
								<?php if (!empty($departments)) { ?>
									<?php $sl = 1; ?>
									<?php foreach ($departments as $department) {

										// echo '<pre>';
										// print_r($department);
										// echo '</pre>';
										// exit;
							

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
										<tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>" data-placement="bottom"
											data-toggle="tooltip" title="<?php echo $rowmessage; ?>">
											<td><?php echo $sl; ?></td>
											<!-- <td><?php echo lang_loader('inc', 'inc_inc'); ?><?php echo $department->id; ?></td> -->
											<td
												style="overflow-wrap: break-word; word-break: normal; font-size:14px; line-height:1.6;">

												<?php
												$rep = '';
												if ($department->departmentid_trasfered != 0) {
													$issue = NULL;
												} else {
													foreach ($department->feed->reason as $key => $value) {
														if ($key) {
															if ($titles[$key] == $department->department->description) {
																if (in_array($key, $keys)) {
																	$issue = $res[$key];
																}
															}
														}
													}
												}


												$createdOn = strtotime($department->created_on);
												$lastModified = strtotime($department->last_modified);
												$timeDifferenceInSeconds = $lastModified - $createdOn;

												$value = $this->incident_model->convertSecondsToTime($timeDifferenceInSeconds);

												$timetaken = '';
												if ($value['days'] != 0) {
													$timetaken .= $value['days'] . ' days, ';
												}

												if ($value['hours'] != 0) {
													$timetaken .= $value['hours'] . ' hrs, ';
												}

												if ($value['minutes'] != 0) {
													$timetaken .= $value['minutes'] . ' mins.';
												}

												if ($timeDifferenceInSeconds <= 60) {
													$timetaken .= 'less than a minute';
												}

												?>

												<?php
												if (!empty($department->feed->risk_matrix)) {
													$impact = $department->feed->risk_matrix->impact ?? 'NA';
													$likelihood = $department->feed->risk_matrix->likelihood ?? 'NA';
													$level = $department->feed->risk_matrix->level ?? 'NA';
												}
												?>

												<?php

												$userss = $this->db->select('user_id, firstname')
													->where('user_id !=', 1)
													->get('user')
													->result();

												$userMap = [];
												foreach ($userss as $u) {
													$userMap[$u->user_id] = $u->firstname;
												}

												// Step 2: Convert comma-separated IDs into arrays
												$assign_for_process_monitor_ids = !empty($department->assign_for_process_monitor)
													? explode(',', $department->assign_for_process_monitor)
													: [];

												$assign_to_ids = !empty($department->assign_to)
													? explode(',', $department->assign_to)
													: [];

												// Step 3: Map IDs → names
												$assign_for_process_monitor_names = array_map(function ($id) use ($userMap) {
													return $userMap[$id] ?? $id;
												}, $assign_for_process_monitor_ids);

												$assign_to_names = array_map(function ($id) use ($userMap) {
													return $userMap[$id] ?? $id;
												}, $assign_to_ids);

												// Step 4: Join into comma-separated strings
												$actionText_process_monitor = implode(', ', $assign_for_process_monitor_names);
												$names = implode(', ', $assign_to_names);

												// Normalize and map color for Risk Priority
												$priority = str_replace('–', '-', $department->priority);
												switch ($priority) {
													case 'P1-Critical':
														$color = '#ff4d4d';
														break;   // Red
													case 'P2-High':
														$color = '#ff9800';
														break;   // Orange
													case 'P3-Medium':
														$color = '#fbc02d';
														break;   // Yellow
													case 'P4-Low':
														$color = '#166cc7ff';
														break;   // Blue
													default:
														$color = '#000';
												}

												echo '<div style="background:#fafafa;
												border-left:4px solid #dadada;
												padding:12px 15px;
												border-radius:4px;
												box-shadow:0 1px 3px rgba(0,0,0,0.05);
                                                ">';

												if (!empty($department->id)) {
													echo '<div><strong>Incident ID : </strong> ' . htmlspecialchars($department->id) . '</div>';
												}

												if (!empty($department->department->description)) {
													echo '<div><strong>Incident : </strong> ' . htmlspecialchars($department->department->description) . '</div>';
												}

												if (isset($issue) && $issue !== '') {
													echo '<div><strong>Category : </strong> ' . htmlspecialchars($issue) . '</div>';
												} else {
													echo '<div><strong>Category : </strong> Ticket was transferred</div>';
												}

												if (!empty($department->feed->other)) {
													echo '<div><strong>Description : </strong> ' . htmlspecialchars($department->feed->other) . '</div>';
												} else {
													echo '<div><strong>Description : </strong> NA</div>';
												}

												// if (!empty($department->feed->what_went_wrong)) {
												// 	echo '<div><strong>What went wrong : </strong> ' . htmlspecialchars($department->feed->what_went_wrong) . '</div>';
												// } else {
												// 	echo '<div><strong>What went wrong : </strong> NA</div>';
												// }
									
												// if (!empty($department->feed->action_taken)) {
												// 	echo '<div><strong>Immediate action taken : </strong> ' . htmlspecialchars($department->feed->action_taken) . '</div>';
												// } else {
												// 	echo '<div><strong>Immediate action taken : </strong> NA</div>';
												// }
									
												if (!empty($department->feed->name) || !empty($department->feed->patientid)) {
													echo '<div><strong>Reported By : </strong> '
														. htmlspecialchars($department->feed->name ?? '')
														. (!empty($department->feed->patientid) ? ' (' . htmlspecialchars($department->feed->patientid) . ')' : '')
														. '</div>';
												}
												if (!empty($department->feed->incident_occured_in)) {
													echo '<div><strong>Incident Occured On : </strong> ' . htmlspecialchars($department->incident_occured_in) . '</div>';
												}

												if (!empty($department->created_on)) {
													echo '<div><strong>Reported On : </strong> ' . htmlspecialchars($department->created_on) . '</div>';
												}

												if (!empty($department->feed->ward) || !empty($department->feed->bedno)) {
													echo '<div><strong>Reported In : </strong> '
														. htmlspecialchars($department->feed->ward ?? '')
														. (!empty($department->feed->bedno) ? ' (' . htmlspecialchars($department->feed->bedno) . ')' : '')
														. '</div>';
												}



												if (!empty($level) && !empty($impact) && !empty($likelihood)) {
													echo '<div><strong>Assigned Risk : 
        <span style="color:' . getRiskColor($level) . ';">' . htmlspecialchars($level) . '</span> </strong> 
        ( <span >' . htmlspecialchars($impact) . '</span> Impact × 
        <span>' . htmlspecialchars($likelihood) . '</span> Likelihood )
    </div>';
												}



												if (!empty($priority)) {
													echo '<div><strong>Assigned Priority : </strong> <span style="color:'
														. htmlspecialchars($color ?? 'black')
														. '; font-weight:600;">'
														. htmlspecialchars($priority) . '</span></div>';
												}
												if (!empty($department->incident_type)) {
													$severity = $department->incident_type;

													// Map severity levels to colors
													$severityColors = [
														'Near miss' => '#1cb23cff',   // Blue
														'No-harm' => '#fbc02d',   // Yellow
														'Adverse' => '#ff9800',   // Orange
														'Sentinel' => '#ff4d4d',   // Red
														'Unassigned' => '#6c757d'    // Gray fallback
													];

													$sevColor = $severityColors[$severity] ?? $severityColors['Unassigned'];

													echo '<div><strong>Assigned Severity : </strong> 
            <span style="color:' . htmlspecialchars($sevColor) . '; font-weight:600;">'
														. htmlspecialchars($severity) . '</span></div>';
												}

												if (!empty($department->feed->tag_name) || !empty($department->feed->tag_patientid)) {
													echo '<div><strong>Patient details : </strong> '
														. htmlspecialchars($department->feed->tag_name ?? '')
														. (!empty($department->feed->tag_patientid) ? ' (' . htmlspecialchars($department->feed->tag_patientid) . ')' : '')
														. '</div>';
												}
												if (!empty($department->feed->employee_name) || !empty($department->feed->employee_id)) {
													echo '<div><strong>Employe details : </strong> '
														. htmlspecialchars($department->feed->employee_name ?? '')
														. (!empty($department->feed->employee_id) ? ' (' . htmlspecialchars($department->feed->employee_id) . ')' : '')
														. '</div>';
												}
												if (!empty($department->feed->asset_name) || !empty($department->feed->asset_code)) {
													echo '<div><strong>Equipment details : </strong> '
														. htmlspecialchars($department->feed->asset_name ?? '')
														. (!empty($department->feed->asset_code) ? ' (' . htmlspecialchars($department->feed->asset_code) . ')' : '')
														. '</div>';
												}

												if (!empty($names)) {
													echo '<div><strong>Team Leader : </strong> <span >'
														. htmlspecialchars($names) . '</span></div>';
												}

												if (!empty($actionText_process_monitor)) {
													echo '<div><strong>Process Monitor : </strong> <span >'
														. htmlspecialchars($actionText_process_monitor) . '</span></div>';
												}



												if (!empty($department->last_modified)) {
													echo '<div><strong>Closed On : </strong> ' . htmlspecialchars($department->last_modified) . '</div>';
												}



												if (!empty($timetaken)) {
													echo '<div><strong>TAT : </strong> ' . htmlspecialchars($timetaken) . '</div>';
												}

												echo '</div>';
												?>
											</td>


											<!-- <td style="overflow-wrap: break-word; word-break: normal;">

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
											</td> -->



											<td
												style="border: 1px solid #dadada; overflow: clip; word-break: break-word; font-size:14px;">

												<?php
												// Sort reply messages by created_on
												usort($department->replymessage, function ($a, $b) {
													return strtotime($a->created_on) - strtotime($b->created_on);
												});

												foreach ($department->replymessage as $r) {
													// print_r($r);
													echo '<div style="
                margin-bottom:15px; 
                padding:12px; 
                border:1px solid #e0e0e0; 
                border-radius:6px; 
                background:#fafafa;
                box-shadow:0 1px 2px rgba(0,0,0,0.05);
                font-size:14px; line-height:1.5;">';



													echo '<strong>' . $r->ticket_status . '</strong>';
													echo '<div style="margin-top:10px;"> <b>Date & Time:</b> ' . date('d M, Y - g:i A', strtotime($r->created_on)) . '</div>';

													if ($r->ticket_status != 'Assigned') {
														echo '<div><b>Action:</b> ' . htmlspecialchars($r->action) . '</div>';
													}

													if (!empty($r->process_monitor_note)) {
														echo '<div><b>Notes:</b> ' . htmlspecialchars($r->process_monitor_note) . '</div>';
													}

													if ($r->ticket_status == 'Transfered') {
														echo '<div><b>Action:</b> ' . htmlspecialchars($r->action) . ' <b>(Team Leader)</b></div>';
														echo '<div><b>Transferred by:</b> ' . htmlspecialchars($r->message) . '</div>';
														echo '<div><b>Comment:</b> ' . htmlspecialchars($r->reply) . '</div>';
													}

													if ($r->ticket_status == 'Assigned') {
														echo '<div><b>Action:</b> ' . htmlspecialchars($r->action) . ' <b>(Team Leader)</b></div>';
														echo '<div><b>Process Monitor:</b> ' . htmlspecialchars($r->action_for_process_monitor) . '</div>';
														echo '<div><b>Assigned by:</b> ' . htmlspecialchars($r->message) . '</div>';
													}

													if ($r->ticket_status == 'Re-assigned') {
														echo '<div><b>Process Monitor:</b> ' . htmlspecialchars($r->action_for_process_monitor) . '</div>';
														echo '<div><b>Re-assigned by:</b> ' . htmlspecialchars($r->message) . '</div>';
													}

													if ($r->ticket_status == 'Described') {
														if (!empty($r->rca_tool_describe)) {
															echo '<div><b>Root Cause Analysis (RCA)</b></div>';
															echo '<div><b>Tool Applied:</b> ' . htmlspecialchars($r->rca_tool_describe) . '</div>';
														}

														if ($r->rca_tool_describe == 'DEFAULT') {
															echo '<div><b>Closure RCA:</b> ' . htmlspecialchars($r->rootcause_describe) . '</div>';
														}

														if ($r->rca_tool_describe == '5WHY') {
															echo '<ul>';
															echo '<li><b>WHY 1:</b> ' . htmlspecialchars($r->fivewhy_1_describe) . '</li>';
															echo '<li><b>WHY 2:</b> ' . htmlspecialchars($r->fivewhy_2_describe) . '</li>';
															echo '<li><b>WHY 3:</b> ' . htmlspecialchars($r->fivewhy_3_describe) . '</li>';
															echo '<li><b>WHY 4:</b> ' . htmlspecialchars($r->fivewhy_4_describe) . '</li>';
															echo '<li><b>WHY 5:</b> ' . htmlspecialchars($r->fivewhy_5_describe) . '</li>';
															echo '</ul>';
														}

														if ($r->rca_tool_describe == '5W2H') {
															echo '<dl>';
															if (!empty($r->fivewhy2h_1_describe))
																echo '<dt>What happened?</dt><dd>' . htmlspecialchars($r->fivewhy2h_1_describe) . '</dd>';
															if (!empty($r->fivewhy2h_2_describe))
																echo '<dt>Why did it happen?</dt><dd>' . htmlspecialchars($r->fivewhy2h_2_describe) . '</dd>';
															if (!empty($r->fivewhy2h_3_describe))
																echo '<dt>Where did it happen?</dt><dd>' . htmlspecialchars($r->fivewhy2h_3_describe) . '</dd>';
															if (!empty($r->fivewhy2h_4_describe))
																echo '<dt>When did it happen?</dt><dd>' . htmlspecialchars($r->fivewhy2h_4_describe) . '</dd>';
															if (!empty($r->fivewhy2h_5_describe))
																echo '<dt>Who was involved?</dt><dd>' . htmlspecialchars($r->fivewhy2h_5_describe) . '</dd>';
															if (!empty($r->fivewhy2h_6_describe))
																echo '<dt>How did it happen?</dt><dd>' . htmlspecialchars($r->fivewhy2h_6_describe) . '</dd>';
															if (!empty($r->fivewhy2h_7_describe))
																echo '<dt>How much/How many (impact/cost)?</dt><dd>' . htmlspecialchars($r->fivewhy2h_7_describe) . '</dd>';
															echo '</dl>';
														}

														if (!empty($r->corrective_describe)) {
															echo '<div><b>Corrective Action:</b> ' . htmlspecialchars($r->corrective_describe) . '</div>';
														}

														if (!empty($r->preventive_describe)) {
															echo '<div><b>Preventive Action:</b> ' . htmlspecialchars($r->preventive_describe) . '</div>';
														}

														if (!empty($r->verification_comment_describe)) {
															echo '<div><b>Lesson Learned:</b> ' . htmlspecialchars($r->verification_comment_describe) . '</div>';
														}
													}

													if (!empty($r->reply) && $r->ticket_status != 'Described' && $r->ticket_status != 'Transfered') {
														echo '<div><b>' . lang_loader('inc', 'inc_comment') . ':</b> ' . htmlspecialchars($r->reply) . '</div>';
													}

													if (!empty($r->rca_tool)) {
														echo '<div><b>Root Cause Analysis (RCA) for Incident Closure</b></div>';
														echo '<div><b>Tool Applied:</b> ' . htmlspecialchars($r->rca_tool) . '</div>';
													}

													if ($r->rca_tool == 'DEFAULT') {
														echo '<div><b>Closure RCA:</b> ' . htmlspecialchars($r->rootcause) . '</div>';
													}

													if ($r->rca_tool == '5WHY') {
														echo '<ul>';
														echo '<li><b>WHY 1:</b> ' . htmlspecialchars($r->fivewhy_1) . '</li>';
														echo '<li><b>WHY 2:</b> ' . htmlspecialchars($r->fivewhy_2) . '</li>';
														echo '<li><b>WHY 3:</b> ' . htmlspecialchars($r->fivewhy_3) . '</li>';
														echo '<li><b>WHY 4:</b> ' . htmlspecialchars($r->fivewhy_4) . '</li>';
														echo '<li><b>WHY 5:</b> ' . htmlspecialchars($r->fivewhy_5) . '</li>';
														echo '</ul>';
													}

													if ($r->rca_tool == '5W2H') {
														echo '<dl>';
														if (!empty($r->fivewhy2h_1))
															echo '<dt>What happened?</dt><dd>' . htmlspecialchars($r->fivewhy2h_1) . '</dd>';
														if (!empty($r->fivewhy2h_2))
															echo '<dt>Why did it happen?</dt><dd>' . htmlspecialchars($r->fivewhy2h_2) . '</dd>';
														if (!empty($r->fivewhy2h_3))
															echo '<dt>Where did it happen?</dt><dd>' . htmlspecialchars($r->fivewhy2h_3) . '</dd>';
														if (!empty($r->fivewhy2h_4))
															echo '<dt>When did it happen?</dt><dd>' . htmlspecialchars($r->fivewhy2h_4) . '</dd>';
														if (!empty($r->fivewhy2h_5))
															echo '<dt>Who was involved?</dt><dd>' . htmlspecialchars($r->fivewhy2h_5) . '</dd>';
														if (!empty($r->fivewhy2h_6))
															echo '<dt>How did it happen?</dt><dd>' . htmlspecialchars($r->fivewhy2h_6) . '</dd>';
														if (!empty($r->fivewhy2h_7))
															echo '<dt>How much/How many (impact/cost)?</dt><dd>' . htmlspecialchars($r->fivewhy2h_7) . '</dd>';
														echo '</dl>';
													}

													if (!empty($r->corrective)) {
														echo '<div><b>Closure Corrective Action:</b> ' . htmlspecialchars($r->corrective) . '</div>';
													}

													if (!empty($r->preventive)) {
														echo '<div><b>Closure Preventive Action:</b> ' . htmlspecialchars($r->preventive) . '</div>';
													}

													if (!empty($r->verification_comment)) {
														echo '<div><b>Closure Verification Remark:</b> ' . htmlspecialchars($r->verification_comment) . '</div>';
													}


													echo '</div>'; // close card
												}
												?>
											</td>




											<!-- <td>
												<?php
												$createdOn = strtotime($department->created_on);
												$lastModified = strtotime($department->last_modified);
												$timeDifferenceInSeconds = $lastModified - $createdOn;
												$value = $this->incident_model->convertSecondsToTime($timeDifferenceInSeconds);

												if ($value['days'] != 0) {
													echo $value['days'] . ' days, ';
												}
												if ($value['hours'] != 0) {
													echo $value['hours'] . ' hrs, ';
												}
												if ($value['minutes'] != 0) {
													echo $value['minutes'] . ' mins.';
												}
												if ($timeDifferenceInSeconds <= 60) {
													echo 'less than a minute';
												}
												?>
											</td> -->


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
	<?php } else { ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">

						<h3 style="text-align: center; color:tomato;">
							<?php echo lang_loader('inc', 'inc_no_record_found'); ?>
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