<div class="content">

	<?php
	// individual patient feedback link
	$ip_link_patient_feedback = base_url($this->uri->segment(1).'/employee_complaint?empid=');
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
							<a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="<?php echo lang_loader('inc','inc_download_addressed_incident_report_tooltip'); ?>" href="<?php echo base_url($this->uri->segment(1)) . '/download_opentickets' ;?>">
								<i class="fa fa-file-text"></i>
							</a>
						</div>
					</div>
					<div class="panel-body">
					<?php   if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?>
							<form>
								<p> 
									<!-- <span style="font-size:15px; font-weight:bold;"><?php echo lang_loader('inc','inc_sort_incident_by'); ?></span> -->
									<select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment2(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
										<option value="1" selected><?php echo lang_loader('inc','inc_select_category'); ?></option>
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
											<option value="1" selected><?php echo lang_loader('inc','inc_select_incident'); ?></option>
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

						<table class="incticketsaddressed table table-striped table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo lang_loader('inc','inc_slno'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc','inc_incidents_id'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc','inc_incident_reported_by'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc','inc_incident'); ?></th>
									<?php   if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?>
										<th><?php echo lang_loader('inc','inc_category'); ?></th>
									<?php } ?>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc','inc_addressal_comment'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('inc','inc_modified_on'); ?></th>
									<th style="text-align: center;"><?php echo display('action') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($departments)) {		?>
									<?php $sl = 1; ?>
									<?php foreach ($departments as $department) {
										if ($department->status == 'Addressed') {
											$this->db->where('ticketid', $department->id)->where('ticket_status', 'Addressed');
											$query = $this->db->get('ticket_incident_message');
											$ticket = $query->result();
											$rowmessage = 'Addressed by ' . $ticket[0]->message;
											$addressed_comm = $ticket[0]->reply;
										} else {
											$rowmessage = 'THIS TICKET IS OPEN';
										}
										if (strlen($rowmessage) > 60) {
											$rowmessage = substr($rowmessage, 0, 60) . '  ' . ' ... click status to view';
										}
									?>
										<tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>" data-placement="bottom" data-toggle="tooltip" title="<?php echo $rowmessage; ?>">
											<td><?php echo $sl; ?></td>
											<td><a href="<?php echo $ip_link_patient_feedback . $department->id; ?>"><?php echo lang_loader('inc','inc_inc'); ?><?php echo $department->id; ?></a></td>
											<!-- <br>
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
														echo 'Ticket was transferred';
														$show = true;
													}
													if ($department->status == 'Transfered') {
														echo 'Ticket was transferred';
														$show = true;
													}
													if ($department->status == 'Reopen') {
														echo 'Ticket was transferred';
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
											<?php   if (isfeature_active('INC-INCIDENTS-DASHBOARD') === true) { ?>
												<td><?php echo $department->department->description; ?>
													<br>
													<?php echo $department->department->pname; ?>
												</td>
											<?php } ?>
											<td class="inbox-item-text" style="overflow: clip; word-break: break-all;">
												<?php echo $addressed_comm; ?>
											</td>
											<td style="overflow: clip; word-break: break-all;">
												<?php echo date('g:i A', strtotime($department->last_modified)); ?>
												<br>
												<?php echo date('d-m-y', strtotime($department->last_modified)); ?>
											</td>
											<?php
											if ($department->status == 'Addressed') {
												$tool = 'Click to close this ticket.';
												$color = 'warning';
											} else {
												$color = 'info';
											}
											?>
											<td style="align-items: center;">
												<a href="<?php echo base_url($this->uri->segment(1) . "/track/$department->id") ?>" data-placement="bottom" data-toggle="tooltip" title="<?php echo $tool; ?>" class="btn btn-sm btn-block btn-<?php echo $color; ?>"><?php echo $department->status; ?> <i style="font-size:x-small;" class="fa fa-edit"></i></a>
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

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('inc','inc_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>
</div>
<script>
	function gotonextdepartment(type) {
		var subsecid = $('#subsecid').val();
		var url = "<?php echo base_url($this->uri->segment(1) . "/addressedtickets?type=") ?>" + type + "&depsec=" + subsecid;
		window.location.href = url;
	}

	function gotonextdepartment2(type) {
		var url = "<?php echo base_url($this->uri->segment(1) . "/addressedtickets?depsec=") ?>" + type;
		window.location.href = url;
	}
</script>