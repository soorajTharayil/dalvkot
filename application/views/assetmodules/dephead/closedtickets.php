<div class="content">
	<?php
	// individual patient feedback link
	$ip_link_patient_feedback = base_url($this->uri->segment(1).'/patient_complaint?patientid=');
	$this->db->select("*");
	$this->db->from('setup_int');
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
							<a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="<?php echo lang_loader('pcf','pcf_download_capa_report_tooltip'); ?>" href="<?php echo base_url($this->uri->segment(1)) . '/download_capa_report'; ?>">
								<i class="fa fa-file-text"></i>
							</a>
						</div>
					</div>

					<div class="panel-body">
						<?php if ($this->session->userdata('user_role') != 4) { ?>
							<form>
								<p> <!-- <span style="font-size:15px; font-weight:bold;">Sort Complaints By : </span> -->
									<select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment2(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
										<option value="1" selected><?php echo lang_loader('pcf','pcf_select_department'); ?></option>
										<?php
										$this->db->group_by('description');
										$this->db->where('type', 'interim');
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
											<option value="1" selected><?php echo lang_loader('pcf','pcf_select_parameter'); ?></option>
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
								</p>
							</form>
							<br />
						<?php } ?>
					
						<table class="pcticketsclose table table-striped table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo lang_loader('pcf','pcf_slno'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('pcf','pcf_complaint_id'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('pcf','pcf_patient_details'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('pcf','pcf_concern'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('pcf','pcf_rca'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('pcf','pcf_capa'); ?></th>
									<?php if (close_comment('pc_close_comment') === true) { ?> 
										<th style="white-space: nowrap;"><?php echo lang_loader('pcf','pcf_comment'); ?></th>
									<?php } ?>
									<?php if (int_tat('close_ticket') === true) { ?>
									<th style="white-space: nowrap;"><?php echo lang_loader('pcf','pcf_turn_around'); ?><br><?php echo lang_loader('pcf','pcf_tat'); ?></th>
									<?php } ?>
									<th style="text-align: center;"><?php echo display('action') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($departments)) {		?>
									<?php $sl = 1; ?>
									<?php foreach ($departments as $department) {

										if ($department->status == 'Closed') {
											$this->db->where('ticketid', $department->id)->where('ticket_status', 'Closed');
											$query = $this->db->get('ticket_int_message');
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
											$query = $this->db->get('ticket_int_message');
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
											<td>PCT-<?php echo $department->id; ?></td>
											<td style="overflow: clip; word-break: break-all;"><?php echo $department->feed->name; ?>&nbsp;(<a href="<?php echo $ip_link_patient_feedback . $department->feed->patientid; ?>"><?php echo $department->feed->patientid; ?></a>)
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
											<?php if (close_comment('pc_close_comment') === true) { ?> 
											<td style="overflow: clip; word-break: break-all;">
												<?php foreach ($department->replymessage as $r) { ?>
													<?php if ($r->comment != NULL) { ?>

														<?php echo $r->comment; ?>
													<?php } ?>
												<?php } ?>
											</td>
											<?php } ?>

											<?php if (int_tat('close_ticket') === true) { ?>
												<td>
													<?php
													$createdOn = strtotime($department->created_on);
													$lastModified = strtotime($department->last_modified);
													$timeDifferenceInSeconds = $lastModified - $createdOn;
													$value = $this->updated_model->convertSecondsToTime($timeDifferenceInSeconds);

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
													echo '<br>';
													echo  $close;
													echo '<br>';
													echo  $add;
													?>
												</td>
											<?php } ?>
											<?php
											if ($department->status == 'Closed') {
												$tool = 'Ticket is closed';
												$color = 'success';
											} else {
												$color = 'info';
											}
											// print_r($department->department->close_time);
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

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('pcf','pcf_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>
</div>
<script>
	function gotonextdepartment(type) {
		var subsecid = $('#subsecid').val();
		var url = "<?php echo base_url($this->uri->segment(1) . "/closedtickets?type=") ?>" + type + "&depsec=" + subsecid;
		window.location.href = url;
	}

	function gotonextdepartment2(type) {
		var url = "<?php echo base_url($this->uri->segment(1) . "/closedtickets?depsec=") ?>" + type;
		window.location.href = url;
	}
</script>