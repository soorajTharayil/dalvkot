<div class="content">
	<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
	<script src="<?php echo base_url(); ?>assets/utils.js"></script>
	<?php

	// Debug output
	


	if ($this->input->post('empid') || $this->input->get('empid')) {
		$hide = true;
		if ($this->input->post('empid')) {
			$pid = $this->input->post('empid');
		} else {
			$pid = $this->input->get('empid');
		}
		$this->db->select('bf_feedback_incident.*, tickets_incident.*');
		$this->db->from('bf_feedback_incident');
		$this->db->join('tickets_incident', 'tickets_incident.feedbackid = bf_feedback_incident.id', 'inner');
		$this->db->where('tickets_incident.id', $pid);
		$this->db->order_by('bf_feedback_incident.id', 'desc');
		$query = $this->db->get();
		$results = $query->result();
		?>

		<?php foreach ($results as $result) {

			// Step 1: Build user_id → firstname map
			$userss = $this->db->select('user_id, firstname')
				->where('user_id !=', 1)
				->get('user')
				->result();

			$userMap = [];
			foreach ($userss as $u) {
				$userMap[$u->user_id] = $u->firstname;
			}

			// Step 2: Convert comma-separated IDs into arrays
			$assign_for_process_monitor_ids = !empty($result->assign_for_process_monitor)
				? explode(',', $result->assign_for_process_monitor)
				: [];

			$assign_to_ids = !empty($result->assign_to)
				? explode(',', $result->assign_to)
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


			$id = $result->id;
			$param = json_decode($result->dataset, true);
			$this->db->where('id', $result->pid);

			// print_r($param);exit;
		}
		?>


		<?php
		if (count($results) >= 1) { ?>


			<?php foreach ($results as $result) {
				$param = json_decode($result->dataset, true);
				$this->db->where('id', $result->pid);
				$query = $this->db->get('bf_employees_incident');
				$patients = $query->result();
				$encodedImage = $result->image;

				foreach ($param['reason'] as $key => $crow) {
					//print_r($crow);
					if ($crow == true) {
						$this->db->where('shortkey', $key);
						$query = $this->db->get('setup_incident');
						$cresult1 = $query->result();
						// print_r($cresult1);
						// exit;
	
					}
				}

				foreach ($param['comment'] as $key => $crow) {

					if ($crow) {
						$this->db->where('type', $key);
						$query = $this->db->get('setup_incident');
						$cresult = $query->result();
						$comment = $crow;
					}
				}

				?>

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3><a href="javascript:void()" data-toggle="tooltip" title="INCIDENT- <ID> "><i
											class="fa fa-question-circle" aria-hidden="true"></i></a>
									<?php echo lang_loader('inc', 'inc_inc'); ?> 			<?php echo $result->id; ?>
								</h3>
							</div>
							<div class="panel-body" style="background: #fff;">
								<table class=" table table-striped table-bordered  no-footer dtr-inline ">
									<?php $department = $patients[0];
									// print_r($department);
									?>
									<table class=" table table-striped table-bordered  no-footer dtr-inline ">
										<tr>
											<td> <strong><?php echo lang_loader('inc', 'inc_incident_report'); ?></strong> </td>
											<td>



												<strong> <?php echo lang_loader('inc', 'inc_category'); ?></strong>
												<?php echo $cresult1[0]->title; ?>
												<br>
												<?php
												// print_r($reasons);
												if ($param['reason']) { ?>
													<strong> <?php echo 'Incident : '; ?></strong>

													<?php foreach ($param['reason'] as $key => $value) { ?>
														<?php if ($value === true) {
															$this->db->where('shortkey', $key);
															$query = $this->db->get('setup_incident');
															$cresult = $query->result();
															?>
															<?php if (count($cresult) != 0) { ?>
																<?php echo $cresult[0]->shortname; ?>

															<?php } ?>
														<?php } ?>
													<?php } ?>
												<?php } else {
													echo $departments[0]->department->name;
												} ?>

												<?php foreach ($param['comment'] as $key => $value) { ?>
													<?php if ($key) { ?>
														<?php $comm = $value; ?>
													<?php } ?>
												<?php } ?>

												<?php if ($comm) { ?>
													<span style="overflow: clip; word-break: break-all; display:block; margin-top:8px;">
														<strong> <?php echo 'Description : '; ?></strong>
														<?php echo '"' . $comm . '"'; ?>.
													</span>
												<?php } ?>

												<?php if ($param['what_went_wrong']) { ?>
													<span style="overflow: clip; word-break: break-all; display:block; margin-top:8px;">
														<strong> <?php echo 'What went wrong : '; ?></strong>
														<?php echo '"' . $param['what_went_wrong'] . '"'; ?>.
													</span>
												<?php } ?>

												<?php if ($param['action_taken']) { ?>
													<span style="overflow: clip; word-break: break-all; display:block; margin-top:8px;">
														<strong> <?php echo 'Immediate action taken : '; ?></strong>
														<?php echo '"' . $param['action_taken'] . '"'; ?>.
													</span>
												<?php } ?>

											</td>
										</tr>
										<tr>
											<td><strong><?php echo lang_loader('inc', 'inc_incident_reported_by'); ?></strong></td>
											<td>
												<?php echo $param['name']; ?>
												(<a href=""><?php echo $param['patientid']; ?></a>)

												<!-- <br>
								<?php echo $param['role']; ?> -->
												<br>
												<?php if ($param['contactnumber'] != '') { ?>
													<i class="fa fa-phone"></i> <?php echo $param['contactnumber']; ?>
												<?php } ?>
												<br>
												<?php if ($param['email'] != '') { ?>
													<i class="fa fa-envelope-o"></i> <?php echo $param['email']; ?>
												<?php } ?>
											</td>
										</tr>
										<?php if ($result->incident_occured_in) { ?>

											<tr>
												<td><strong>Incident occured on</strong></td>
												<td><?php echo $result->incident_occured_in; ?></td>
											</tr>
										<?php } ?>

										<tr>
											<td><strong>Incident reported on</strong></td>
											<td><?php echo date('g:i A, d-m-y', strtotime($department->created_on)); ?></td>
										</tr>

										<tr>
											<td><strong>Incident reported in</strong></td>
											<td><?php if ($param['ward'] != '') { ?>
													<?php echo 'Floor/Ward: '; ?>
													<?php echo ($param['ward']); ?>
												<?php } ?>
												<br>
												<?php if ($param['bedno']) { ?>
													<?php echo 'Site: '; ?>
													<?php echo $param['bedno']; ?>
												<?php } ?>

											</td>
										</tr>

										<tr>
											<td><strong>Assigned risk</strong></td>
											<td>
												<?php
												// Safely read values (empty string if missing)
												$level = $param['risk_matrix']['level'] ?? '';
												$impact = $param['risk_matrix']['impact'] ?? '';
												$likelihood = $param['risk_matrix']['likelihood'] ?? '';

												// Decide display & color
												if ($level === 'High') {
													$color = '#d9534f';
												}   // red
												elseif ($level === 'Medium') {
													$color = '#f0ad4e';
												}   // orange
												elseif ($level === 'Low') {
													$color = '#0c7e36ff';
												}   // blue
												else {
													$color = '#6c757d';
												}   // gray for "Unassigned"
									
												$hasValue = ($level !== '' || $impact !== '' || $likelihood !== '');
												?>

												<?php if ($hasValue): ?>
													<strong><span style="color: <?php echo $color; ?>;">
															<?php echo $level ?: 'Unassigned'; ?></strong></span>

													( <?php echo $impact ?: 'Unassigned'; ?> Impact ×
													<?php echo $likelihood ?: 'Unassigned'; ?> Likelihood )

												<?php else: ?>
													<span style="color:#6c757d;font-style:italic;">Unassigned</span>
												<?php endif; ?>

												<!-- Edit button (always available; open modal) -->
												<?php if ($result->status != 'Closed') { ?>
													<div
														style="display:flex; justify-content:space-between; align-items:center; width:100%;margin-top:10px;">

														<span>
															<button id="save_button" type="submit" data-toggle="modal"
																data-target="#riskMatrixModal"
																class="ui positive button"><?php echo display('edit') ?></button>
														</span>
													</div>
												<?php } ?>

											</td>
										</tr>

										<tr>
											<td><strong>Assigned priority</strong></td>
											<td>
												<?php if (
													ismodule_active('INCIDENT') === true &&
													isfeature_active('EDIT-PRIORITY-INCIDENTS') === true &&
													$result->status != 'Closed'
												) { ?>

													<?php echo form_open('ticketsincident/edit_priority_type', 'class="form-inner"') ?>
													<?php
													$priority = !empty($param['priority']) ? str_replace('–', '-', $param['priority']) : 'Unassigned';

													// Set default select color
													switch ($priority) {
														case 'P1-Critical':
															$color = '#ff4d4d';
															break;   // red
														case 'P2-High':
															$color = '#ff9800';
															break;   // orange
														case 'P3-Medium':
															$color = '#fbc02d';
															break;   // yellow
														case 'P4-Low':
															$color = '#19ca6e';
															break;   // green
														case 'Unassigned':
															$color = '#6c757d';
															break;   // gray
														default:
															$color = '#000';
													}
													?>

													<select name="priority" id="priorityDropdown" style="color:<?php echo $color; ?>;">
														<option value="" <?php echo ($priority == 'Unassigned') ? 'selected' : ''; ?>
															style="color:#6c757d;">Unassigned</option>
														<option value="P1-Critical" <?php echo ($priority == 'P1-Critical') ? 'selected' : ''; ?> style="color:#ff4d4d;">P1 - Critical</option>
														<option value="P2-High" <?php echo ($priority == 'P2-High') ? 'selected' : ''; ?>
															style="color:#ff9800;">P2 - High</option>
														<option value="P3-Medium" <?php echo ($priority == 'P3-Medium') ? 'selected' : ''; ?> style="color:#fbc02d;">P3 - Medium</option>
														<option value="P4-Low" <?php echo ($priority == 'P4-Low') ? 'selected' : ''; ?>
															style="color:#19ca6e;">P4 - Low</option>
													</select>

													<script>
														document.getElementById("priorityDropdown").addEventListener("change", function () {
															var colors = {
																"P1-Critical": "#ff4d4d",
																"P2-High": "#ff9800",
																"P3-Medium": "#fbc02d",
																"P4-Low": "#19ca6e",
																"": "#6c757d"
															};
															this.style.color = colors[this.value] || "#6c757d";
														});
													</script>

													<!-- Flexbox for save button -->
													<div style="margin-top:10px;">
														<button id="save_button" type="submit" class="ui positive button">
															<?php echo display('save') ?>
														</button>
													</div>

													<!-- Hidden inputs -->
													<input type="hidden" name="id" value="<?php echo $id ?>" />
													<input type="hidden" name="pid" value="<?php echo $pid ?>" />
													<input type="hidden" name="empid" value="<?php echo $param['patientid'] ?>" />
													<input type="hidden" name="status" value="EditPriority" />

													<?php echo form_close(); ?>

												<?php } else { ?>
													<?php
													$priority = !empty($param['priority']) ? str_replace('–', '-', $param['priority']) : 'Unassigned';
													switch ($priority) {
														case 'P1-Critical':
															$color = '#ff4d4d';
															break;
														case 'P2-High':
															$color = '#ff9800';
															break;
														case 'P3-Medium':
															$color = '#fbc02d';
															break;
														case 'P4-Low':
															$color = '#19ca6e';
															break;
														case 'Unassigned':
															$color = '#6c757d';
															break;
														default:
															$color = '#000';
													}
													?>
													<span style="color:<?php echo $color; ?>; font-weight:600; 
						 <?php echo ($priority == 'Unassigned') ? 'font-style:italic;' : ''; ?>">
														<?php echo htmlspecialchars($priority); ?>
													</span>
												<?php } ?>
											</td>
										</tr>

										<tr>
											<td><strong>Assigned severity</strong></td>
											<td>
												<?php if (
													ismodule_active('INCIDENT') === true &&
													isfeature_active('EDIT-SEVERITY-INCIDENTS') === true &&
													$result->verified_status != 1 &&
													$result->status != 'Closed'
												) { ?>
													<?php echo form_open('ticketsincident/edit_priority_serverity', 'class="form-inner"') ?>
													<?php
													$incident_type = !empty($param['incident_type']) ? $param['incident_type'] : 'Unassigned';

													// Default select text color
													switch ($incident_type) {
														case 'Sentinel':
															$sevColor = '#ff4d4d';
															break;   // red
														case 'Adverse':
															$sevColor = '#ff9800';
															break;   // orange
														case 'No-harm':
															$sevColor = '#fbc02d';
															break;   // blue
														case 'Near miss':
															$sevColor = '#19ca6e';
															break;   // green
														default:
															$sevColor = '#6c757d';          // gray
													}
													?>

													<select name="incident_type" id="incidentTypeDropdown"
														style="color:<?php echo $sevColor; ?>;">
														<option value="" <?php echo ($incident_type == 'Unassigned') ? 'selected' : ''; ?>
															style="color:#6c757d;">Unassigned</option>
														<option value="Near miss" <?php echo ($incident_type == 'Near miss') ? 'selected' : ''; ?> style="color:#19ca6e;">Near miss</option>
														<option value="No-harm" <?php echo ($incident_type == 'No-harm') ? 'selected' : ''; ?> style="color:#2196f3;">No-harm</option>
														<option value="Adverse" <?php echo ($incident_type == 'Adverse') ? 'selected' : ''; ?> style="color:#ff9800;">Adverse</option>
														<option value="Sentinel" <?php echo ($incident_type == 'Sentinel') ? 'selected' : ''; ?> style="color:#ff4d4d;">Sentinel</option>
													</select>

													<script>
														document.getElementById("incidentTypeDropdown").addEventListener("change", function () {
															var sevColors = {
																"Sentinel": "#ff4d4d",
																"Adverse": "#ff9800",
																"No-harm": "#fbc02d",
																"Near miss": "#19ca6e",
																"": "#6c757d"
															};
															// Only change the SELECT text color (not all options)
															this.style.color = sevColors[this.value] || "#6c757d";
														});
													</script>

													<!-- Save button -->
													<div style="margin-top:10px; ">
														<button id="save_button" type="submit" class="ui positive button">
															<?php echo display('save') ?>
														</button>
													</div>

													<!-- Hidden inputs -->
													<input type="hidden" name="id" value="<?php echo $id ?>" />
													<input type="hidden" name="pid" value="<?php echo $pid ?>" />
													<input type="hidden" name="status" value="EditSeverity" />
													<?php echo form_close(); ?>

												<?php } else { ?>
													<?php if (!empty($param['incident_type'])) { ?>
														<span><?php echo $param['incident_type']; ?></span>
													<?php } else { ?>
														<span style="color:#6c757d;font-style:italic;">Unassigned</span>
													<?php } ?>
												<?php } ?>
											</td>
										</tr>


										<?php if ($param['tag_patientid'] || $param['tag_name']) { ?>
											<tr>
												<td><strong><?php echo lang_loader('inc', 'inc_patient_details'); ?></strong></td>
												<td>
													<?php echo lang_loader('inc', 'inc_patient_id'); ?>
													<?php echo $param['tag_patientid']; ?> <br>
													<?php echo lang_loader('inc', 'inc_patient_name'); ?>
													<?php echo $param['tag_name']; ?>
													<br>

												</td>
											</tr>
										<?php } ?>
										<?php if ($param['employee_name'] || $param['employee_id']) { ?>
											<tr>
												<td><strong>Employe Details</strong></td>
												<td>
													Employe Id :
													<?php echo $param['employee_id']; ?> <br>
													Employe Name : <?php echo $param['employee_name']; ?>
													<br>

												</td>
											</tr>
										<?php } ?>
										<?php if ($param['asset_name'] || $param['asset_code']) { ?>
											<tr>
												<td><strong> Equipment Details</strong></td>
												<td>
													Asset Name :
													<?php echo $param['asset_name']; ?> <br>
													Asset Code : <?php echo $param['asset_code']; ?>
													<br>

												</td>
											</tr>
										<?php } ?>

										<?php if ($names) { ?>
											<tr>
												<td><strong>Assigned team leader</strong></td>
												<td>
													<?php echo $names; ?>
												</td>
											</tr>
										<?php } ?>
										<?php if ($actionText_process_monitor) { ?>
											<tr>
												<td><strong>Assigned process monitor</strong></td>
												<td>
													<?php echo $actionText_process_monitor; ?>
												</td>
											</tr>
										<?php } ?>


										<?php
										if (!empty($param['images']) && is_array($param['images'])) { ?>
											<tr>
												<td><strong><?php echo lang_loader('inc', 'inc_attached_image'); ?></strong></td>
												<td>
													<?php
													$i = 1;
													foreach ($param['images'] as $encodedImage) { ?>
														<a href="<?php echo $encodedImage; ?>" download="image_<?php echo $i; ?>.jpg"
															target="_blank">
															Download Image <?php echo $i; ?>
														</a><br>
														<?php
														$i++;
													} ?>
												</td>
											</tr>
										<?php } ?>

										<tr>
											<td><strong>Attached Documents</strong></td>
											<td>
												<?php
												if (!empty($param['files_name']) && is_array($param['files_name'])) {
													foreach ($param['files_name'] as $file) {
														if (!empty($file['name']) && !empty($file['url'])) {
															echo '<span class="no-print"><a href="' . htmlspecialchars($file['url'], ENT_QUOTES, 'UTF-8') . '" download="' . htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8') . '">';
															echo htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8');
															echo '</a></span>';

															echo '<span class="only-print" style="display:none;">' . htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8') . '</span><br>';
														}
													}
												} else {
													echo 'No files available';
												}
												?>
											</td>

										</tr>



										<?php if ($result->source != '') { ?>
											<tr>
												<td><strong><?php echo lang_loader('inc', 'inc_source'); ?></strong></td>
												<td><?php if ($result->source == 'APP') {
													echo 'Mobile Application.';
												} elseif ($result->source == 'Link') {
													echo 'Default Feedback Link.';
												} else {
													echo $result->source;
												} ?></td>
											</tr>
										<?php } ?>
										<!-- done -->

									</table>
							</div>
						</div>
					</div>
				</div>
				<hr />
			<?php } ?>

		<?php } else { ?>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default thumbnail">
						<div class="panel-heading">
							<h3 style="text-align: center; color:tomato;">
								<?php echo lang_loader('inc', 'inc_no_record_found'); ?> <br>
								<a href="<?php echo base_url(uri_string(1)); ?>">
									<button type="button" href="javascript:void()" data-toggle="tooltip" title="Back"
										class="btn btn-sm btn-success" style="text-align: center;">
										<i class="fa fa-arrow-left"></i>
									</button>

								</a>
							</h3>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
	<?php if ($hide == false) { ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default ">
					<div class="panel-heading">

						<?php echo form_open(); ?>
						<table class="table">
							<tr>
								<th class="" style="border:none !important;vertical-align: middle; text-align:right;">
									<?php echo lang_loader('inc', 'inc_find_by_employee_id'); ?>
								</th>
								<td class="" style="border:none !important;">
									<input type="text" class="form-control" placeholder="Enter Employee ID" maxlength="15"
										size="10" name="empid">
								</td>
								<th class="" style="text-align:left;">
									<p style="text-align:left;"><a href="javascript:void()" data-toggle="tooltip"
											title="Search"><button type="submit" class="btn btn-success"><i
													class="fa fa-search"></i></button></a>

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
<style>
	ul.feedback {
		margin: 0px;
		padding: 0px;
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
	function openImageInNewTab(imageUrl) {
		window.open(imageUrl, '_blank');
	}
</script>
<!-- Modal -->
<div class="modal fade" id="riskMatrixModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<?php echo form_open('ticketsincident/update_risk_matrix'); ?>
			<div class="modal-header">
				<h5 class="modal-title">Edit Risk Matrix</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<input type="hidden" name="id" value="<?php echo $id ?>" />
			<input type="hidden" name="pid" value="<?php echo $pid ?>" />
			<input type="hidden" name="empid" value="<?php echo $param['patientid'] ?>" />
			<input type="hidden" name="status" value="EditAssignedRisk" />
			<!-- Initialize Angular model with current values or empty -->
			<?php

			// Pull previous/saved values from DB (adjust to your variables)
			$impact = isset($param['risk_matrix']['impact']) ? $param['risk_matrix']['impact'] : '';
			$likelihood = isset($param['risk_matrix']['likelihood']) ? $param['risk_matrix']['likelihood'] : '';
			$level = isset($param['risk_matrix']['level']) ? $param['risk_matrix']['level'] : '';

			// Color by level for initial render
			if ($level === 'High') {
				$color = '#d9534f';
			}   // red
			elseif ($level === 'Medium') {
				$color = '#f0ad4e';
			}   // orange
			elseif ($level === 'Low') {
				$color = '#19ca6eff';
			}   // blue
			else {
				$color = '#000000';
			}   // default
			?>

			<style>
				.risk-table {
					border-collapse: collapse;
				}

				.risk-table th,
				.risk-table td {
					border: 1px solid #ddd;
					padding: 10px;
					text-align: center;
				}

				.risk-table th[style*="border:none"] {
					border: none !important;
				}

				.risk-low {
					background: rgba(91, 192, 222, 0.15);
				}

				.risk-medium {
					background: rgba(240, 173, 78, 0.15);
				}

				.risk-high {
					background: rgba(217, 83, 79, 0.15);
				}

				.risk-table td {
					cursor: pointer;
					user-select: none;
				}

				.selected-cell {
					outline: 3px solid #333;
				}
			</style>

			<div class="risk-matrix" style="margin-top:10px;">
				<table class="risk-table" id="riskMatrix">
					<!-- Axis headers -->
					<tr>
						<th rowspan="5" style="writing-mode: vertical-rl; transform: rotate(180deg); border:none;">
							IMPACT</th>
					</tr>
					<tr></tr>

					<!-- High Impact row -->
					<tr>
						<th style="border:none;">High</th>
						<td class="risk-medium" data-impact="High" data-likelihood="Low">Medium</td>
						<td class="risk-high" data-impact="High" data-likelihood="Medium">High</td>
						<td class="risk-high" data-impact="High" data-likelihood="High">High</td>
					</tr>

					<!-- Medium Impact row -->
					<tr>
						<th style="border:none;">Medium</th>
						<td class="risk-low" data-impact="Medium" data-likelihood="Low">Low</td>
						<td class="risk-medium" data-impact="Medium" data-likelihood="Medium">Medium</td>
						<td class="risk-high" data-impact="Medium" data-likelihood="High">High</td>
					</tr>

					<!-- Low Impact row -->
					<tr>
						<th style="border:none;">Low</th>
						<td class="risk-low" data-impact="Low" data-likelihood="Low">Low</td>
						<td class="risk-low" data-impact="Low" data-likelihood="Medium">Low</td>
						<td class="risk-medium" data-impact="Low" data-likelihood="High">Medium</td>
					</tr>

					<tr>
						<th style="border:none;"></th>
						<th style="border:none;">Low</th>
						<th style="border:none;">Medium</th>
						<th style="border:none;">High</th>
					</tr>
					<tr>
						<th style="border:none;"></th>
						<th style="border:none;"></th>
						<th style="border:none;"></th>
						<th style="border:none;" colspan="3">LIKELIHOOD</th>
					</tr>
				</table>

				<!-- Live display -->
				<p id="riskDisplay" style="margin-top:15px;   margin-left: 15px;">
					<span id="riskLevelSpan" style="color: <?php echo htmlspecialchars($color, ENT_QUOTES); ?>;">
						<strong id="riskLevelText"><?php echo htmlspecialchars($level ?: '—', ENT_QUOTES); ?></strong>
					</span>
					(<span id="impactText"><?php echo htmlspecialchars($impact ?: '—', ENT_QUOTES); ?></span>
					Impact ×
					<span id="likelihoodText"><?php echo htmlspecialchars($likelihood ?: '—', ENT_QUOTES); ?></span>
					Likelihood)
				</p>

				<!-- Hidden fields for form submit -->
				<input type="hidden" name="impact" id="impactInput"
					value="<?php echo htmlspecialchars($impact, ENT_QUOTES); ?>">
				<input type="hidden" name="likelihood" id="likelihoodInput"
					value="<?php echo htmlspecialchars($likelihood, ENT_QUOTES); ?>">
				<input type="hidden" name="level" id="levelInput"
					value="<?php echo htmlspecialchars($level, ENT_QUOTES); ?>">
			</div>

			<script>
				(function () {
					// Compute Level from Impact × Likelihood (same mapping as your original table)
					function computeLevel(impact, likelihood) {
						const map = {
							'High': { 'Low': 'Medium', 'Medium': 'High', 'High': 'High' },
							'Medium': { 'Low': 'Low', 'Medium': 'Medium', 'High': 'High' },
							'Low': { 'Low': 'Low', 'Medium': 'Low', 'High': 'Medium' }
						};
						if (map[impact] && map[impact][likelihood]) return map[impact][likelihood];
						return '';
					}

					function levelColor(level) {
						if (level === 'High') return '#d9534f';
						if (level === 'Medium') return '#f0ad4e';
						if (level === 'Low') return '#137f35ff';
						return '#000000';
					}

					const matrix = document.getElementById('riskMatrix');
					const cells = matrix.querySelectorAll('td');

					const savedImpact = <?php echo json_encode($impact); ?>;
					const savedLikelihood = <?php echo json_encode($likelihood); ?>;

					const impactInput = document.getElementById('impactInput');
					const likelihoodInput = document.getElementById('likelihoodInput');
					const levelInput = document.getElementById('levelInput');

					const impactText = document.getElementById('impactText');
					const likelihoodText = document.getElementById('likelihoodText');
					const riskLevelText = document.getElementById('riskLevelText');
					const riskLevelSpan = document.getElementById('riskLevelSpan');

					function clearSelection() {
						cells.forEach(td => td.classList.remove('selected-cell'));
					}

					function selectCellByValues(impact, likelihood) {
						let matched = false;
						cells.forEach(td => {
							if (td.dataset.impact === impact && td.dataset.likelihood === likelihood) {
								td.classList.add('selected-cell');
								matched = true;
							}
						});
						return matched;
					}

					function updateOutputs(impact, likelihood) {
						const level = computeLevel(impact, likelihood);

						// Hidden inputs
						impactInput.value = impact;
						likelihoodInput.value = likelihood;
						levelInput.value = level;

						// Live text
						impactText.textContent = impact || '—';
						likelihoodText.textContent = likelihood || '—';
						riskLevelText.textContent = level || '—';
						riskLevelSpan.style.color = levelColor(level);
					}

					// Preselect saved value (if any)
					if (savedImpact && savedLikelihood) {
						selectCellByValues(savedImpact, savedLikelihood);
					}
					// Sync outputs initially
					updateOutputs(savedImpact || '', savedLikelihood || '');

					// Click handling
					cells.forEach(td => {
						td.addEventListener('click', function () {
							clearSelection();
							this.classList.add('selected-cell');

							const impact = this.dataset.impact;
							const likelihood = this.dataset.likelihood;

							updateOutputs(impact, likelihood);
						});
					});
				})();
			</script>


			<div class="modal-footer">
				<button type="submit" class="btn btn-success">Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<!-- CSS -->
<style>
	.risk-table {
		border-collapse: collapse;
		text-align: center;
	}

	.risk-table td,
	.risk-table th {
		border: 1px solid #ccc;
		padding: 14px;
		cursor: pointer;
	}

	.risk-low {
		background: #28a745;
		color: #fff;
	}

	/* green */
	.risk-medium {
		background: #ffc107;
		color: #000;
	}

	/* yellow */
	.risk-high {
		background: #dc3545;
		color: #fff;
	}

	/* red */
	.selected-cell {
		outline: 3px solid #000;
	}
</style>