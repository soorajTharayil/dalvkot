<div class="content">
	<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
	<script src="<?php echo base_url(); ?>assets/utils.js"></script>
	<?php
	if ($this->input->post('empid') || $this->input->get('empid')) {
		$hide = true;
		if ($this->input->post('empid')) {
			$pid = $this->input->post('empid');
		} else {
			$pid = $this->input->get('empid');
		}
		$this->db->where('id', $pid);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('bf_feedback_incident');
		$results = $query->result(); ?>

		<?php foreach ($results as $result) {
			$id = $result->id;
			$param = json_decode($result->dataset, true);
			$this->db->where('id', $result->pid);
		}
		?>


		<?php
		if (count($results) >= 1) { ?>
			<div class="panel-body" style="background: #fff;">
				<table class=" table table-striped table-bordered  no-footer dtr-inline ">
					<tr>
						<td colspan="2"><strong><?php echo lang_loader('inc', 'inc_incident_reported_by'); ?></strong></td>
					</tr>
					<tr>
						<td>
							<?php echo lang_loader('inc', 'inc_employee_name'); ?>
						</td>
						<td>
							<?php echo $param['name']; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo lang_loader('inc', 'inc_employee_id'); ?></td>
						<td>
							<?php echo $param['patientid']; ?>
						</td>
					</tr>
					<!-- <tr>
						<td><?php echo lang_loader('inc', 'inc_employee_role'); ?></td>
						<td>
							<?php echo $param['role']; ?>
						</td>
					</tr> -->
					<tr>
						<td><?php echo lang_loader('inc', 'inc_contact_details'); ?></td>
						<td>
							<?php if ($param['contactnumber'] != '') { ?>
								<i class="fa fa-phone"></i> <?php echo $param['contactnumber']; ?>
							<?php } ?>
							<br>
							<?php if ($param['email'] != '') { ?>
								<i class="fa fa-envelope-o"></i> <?php echo $param['email']; ?>
							<?php } ?>
						</td>
					</tr>
				</table>
			</div>
			<br>

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
								<h3><a href="javascript:void()" data-toggle="tooltip" title="INCIDENT- <ID> "><i class="fa fa-question-circle" aria-hidden="true"></i></a><?php echo lang_loader('inc', 'inc_inc'); ?><?php echo $result->id; ?> </h3>
							</div>
							<div class="panel-body" style="background: #fff;">
								<table class=" table table-striped table-bordered  no-footer dtr-inline ">
									<?php $department = $patients[0]; ?>
									<table class=" table table-striped table-bordered  no-footer dtr-inline ">
										<tr>
											<td colspan="2"><strong><?php echo lang_loader('inc', 'inc_incident_report'); ?></strong> </td>
										</tr>
										<tr>
											<td><?php echo lang_loader('inc', 'inc_reported_on'); ?></td>
											<td><?php echo date('g:i A, d-m-y', strtotime($result->datetime)); ?></td>
										</tr>
										<tr>
											<td><?php echo lang_loader('inc', 'inc_incident_type'); ?></td>
											<td>
												<?php if (ismodule_active('INCIDENT') === true && isfeature_active('EDIT-SEVERITY-INCIDENTS') === true) { ?>
													<!-- Show editable dropdown if conditions are met -->
													<?php echo form_open('ticketsincident/edit_priority_serverity', 'class="form-inner"') ?>
													<select name="incident_type">
														<option value="Near miss" <?php echo ($param['incident_type'] == 'Near miss') ? 'selected' : ''; ?>>Near miss</option>
														<option value="No-harm" <?php echo ($param['incident_type'] == 'No-harm') ? 'selected' : ''; ?>>No-harm</option>
														<option value="Adverse" <?php echo ($param['incident_type'] == 'Adverse') ? 'selected' : ''; ?>>Adverse</option>
														<option value="Sentinel" <?php echo ($param['incident_type'] == 'Sentinel') ? 'selected' : ''; ?>>Sentinel</option>
													</select>

													<!-- Save button -->
													<span style="margin-left: 20px;">
														<button id="save_button" type="submit" class="ui positive button"><?php echo display('save') ?></button>
													</span>

													<!-- Hidden input to pass other parameters if needed -->
													<input type="hidden" name="id" value="<?php echo $id ?>" />
													<input type="hidden" name="empid" value="<?php echo $param['patientid'] ?>" />
													<input type="hidden" name="status" value="EditSeverity" />
													<?php echo form_close(); ?>
												<?php } else { ?>
													<!-- Show current status if conditions are not met -->
													<span><?php echo $param['incident_type']; ?></span>
												<?php } ?>
											</td>
										</tr>


										<tr>
											<td><?php echo lang_loader('inc', 'inc_category'); ?></td>
											<td><?php echo  $cresult1[0]->title; ?></td>
										</tr>
										<tr>
											<td><?php echo lang_loader('inc', 'inc_incident'); ?></td>
											<td><?php echo  $cresult1[0]->shortname; ?></td>
										</tr>
										<tr>
											<td><?php echo lang_loader('inc', 'inc_priority'); ?></td>
											<td>
												<?php if (ismodule_active('INCIDENT') === true && isfeature_active('EDIT-PRIORITY-INCIDENTS') === true) { ?>
													<!-- Show editable dropdown if conditions are met -->
													<?php echo form_open('ticketsincident/edit_priority_type', 'class="form-inner"') ?>
													<?php
													// Set the color based on the priority value
													if ($param['priority'] == 'Medium') {
														$color = '#f0ad4e'; // warning
													} elseif ($param['priority'] == 'High') {
														$color = '#d9534f'; // danger
													} elseif ($param['priority'] == 'Low') {
														$color = '#5bc0de'; // info
													} else {
														$color = '#000'; // default color if no match
													}
													?>

													<!-- Editable dropdown for priority -->
													<select name="priority" style="color: <?php echo $color; ?>;">
														<option value="Low" <?php echo ($param['priority'] == 'Low') ? 'selected' : ''; ?>>Low</option>
														<option value="Medium" <?php echo ($param['priority'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
														<option value="High" <?php echo ($param['priority'] == 'High') ? 'selected' : ''; ?>>High</option>
													</select>

													<!-- Save button -->
													<span style="margin-left: 20px;">
														<button id="save_button" type="submit" class="ui positive button"><?php echo display('save') ?></button>
													</span>

													<!-- Hidden input to pass other parameters if needed -->
													<input type="hidden" name="id" value="<?php echo $id ?>" />
													<input type="hidden" name="empid" value="<?php echo $param['patientid'] ?>" />
													<input type="hidden" name="status" value="EditPriority" />


													<?php echo form_close(); ?>
												<?php } else { ?>
													<!-- Show current priority as plain text if conditions are not met -->
													<span style="color: <?php echo $color; ?>;"><?php echo $param['priority']; ?></span>
												<?php } ?>
											</td>
										</tr>

										<?php if ($param['other']) { ?>
											<tr>
												<td><?php echo lang_loader('inc', 'inc_description'); ?></td>
												<td><span style="overflow: clip; word-break: break-all;">"<?php echo $param['other']; ?>"</span></td>
											</tr>
										<?php } ?>

										<?php
										if ($param['image'] != '' && $param['image'] != NULL) {
											$encodedImage = $param['image'];  ?>
											<tr>
												<td><?php echo lang_loader('inc', 'inc_attached_image'); ?></td>
												<td><img src="<?php echo $encodedImage; ?>" width="100%" height="300px" alt="Rendered Image" onclick="openImageInNewTab('<?php echo $encodedImage; ?>')"></td>
											</tr>
										<?php } ?>
										<tr>
											<td><?php echo lang_loader('inc', 'inc_incident_reported_by'); ?></td>
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
										<?php if ($param['tag_patient_type'] && $param['tag_patientid'] && $param['tag_name'] && $param['tag_consultant']) { ?>
											<tr>
												<td><?php echo lang_loader('inc', 'inc_patient_details'); ?></td>
												<td>
													<?php echo lang_loader('inc', 'inc_patient_type'); ?> <?php echo $param['tag_patient_type']; ?> <br>
													<?php echo lang_loader('inc', 'inc_patient_id'); ?> <?php echo $param['tag_patientid']; ?> <br>
													<?php echo lang_loader('inc', 'inc_patient_name'); ?> <?php echo $param['tag_name']; ?> <br>
													<?php echo lang_loader('inc', 'inc_primary_consultant'); ?> <?php echo $param['tag_consultant']; ?> <br>
												</td>
											</tr>
										<?php } ?>


										<?php if ($result->source != '') { ?>
											<tr>
												<td><?php echo lang_loader('inc', 'inc_source'); ?></td>
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

		<?php } else {  ?>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default thumbnail">
						<div class="panel-heading">
							<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('inc', 'inc_no_record_found'); ?> <br>
								<a href="<?php echo base_url(uri_string(1)); ?>">
									<button type="button" href="javascript:void()" data-toggle="tooltip" title="Back" class="btn btn-sm btn-success" style="text-align: center;">
										<i class="fa fa-arrow-left"></i>
									</button>

								</a>
							</h3>
						</div>
					</div>
				</div>
			</div>
		<?php }  ?>
	<?php } ?>
	<?php if ($hide == false) { ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default ">
					<div class="panel-heading">

						<?php echo form_open(); ?>
						<table class="table">
							<tr>
								<th class="" style="border:none !important;vertical-align: middle; text-align:right;"><?php echo lang_loader('inc', 'inc_find_by_employee_id'); ?></th>
								<td class="" style="border:none !important;">
									<input type="text" class="form-control" placeholder="Enter Employee ID" maxlength="15" size="10" name="empid">
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