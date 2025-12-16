<?php
// individual patient feedback link
$ip_link_patient_feedback = base_url($this->uri->segment(1) . '/patient_feedback?id=');
$this->db->select("*");
$this->db->from('setup_pdf');
$this->db->where('parent', 0);
$query = $this->db->get();
$reasons  = $query->result();
foreach ($reasons as $row) {
	$keys[$row->shortkey] = $row->shortkey;
	$res[$row->shortkey] = $row->shortname;
	$titles[$row->shortkey] = $row->title;
}
?>

<div class="content">
	<?php if (count($departments)) { ?>
		<div class="row">

			<!--  table area -->
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: right;">
						<div class="btn-group">
							<a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="<?php echo lang_loader('ip','ip_download_open_tickets_report_tooltip'); ?>" href="<?php echo base_url($this->uri->segment(1)) . '/download_' . ($this->uri->segment(2)) ?>">
								<i class="fa fa-file-text"></i>
							</a>
						</div>
					</div>
					<div class="panel-body">
						<?php if ($this->session->userdata('user_role') != 4) { ?>
							<form>
								<p>
									<!-- <span style="font-size:15px; font-weight:bold;">Sort Tickets By : </span> -->
									<select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment2(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
										<option value="1" selected><?php echo lang_loader('ip','ip_select_department'); ?></option>
										<?php
										$this->db->group_by('description');
										$this->db->where('type', 'pdf');
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
								<div style="display: none;">
									<?php if (isset($_GET['depsec'])) { ?>
										<span style="font-size:15px; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<select name="dep" class="form-control" onchange="gotonextdepartment(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
											<option value="1" selected><?php echo lang_loader('ip','ip_select_parameter'); ?></option>
											<?php
											$this->db->where('type', 'pdf');
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

						<table class="ipticketsopen table table-striped table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo lang_loader('ip','ip_slno'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('ip','ip_ticket_id'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('ip','ip_patient_details'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('ip','ip_rating'); ?></th>
									<th style="white-space: nowrap;"><?php echo lang_loader('ip','ip_concern'); ?></th>
									<?php if ($this->session->userdata('user_role') != 4) { ?>
										<th><?php echo lang_loader('ip','ip_department'); ?></th>
									<?php } ?>
									<th style="white-space: nowrap;"><?php echo lang_loader('ip','ip_created_on'); ?></th>
									<?php if (ip_tat('open_ticket') === true) { ?>
										<th style="white-space: nowrap;"><?php echo lang_loader('ip','ip_action'); ?></th>
									<?php } ?>
									<th style="text-align: center;"><?php echo display('action') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($departments)) {

								?>
									<?php $sl = 1; ?>
									<?php foreach ($departments as $department) {

										if ($department->status == 'Transfered') {
											$this->db->where('ticketid', $department->id)->where('ticket_status', 'Transfered');
											$query = $this->db->get('ticket_pdf_message');
											$ticket = $query->result();
											$trans_comm =  $ticket[0]->reply;
											$rowmessage = $ticket[0]->message . ' Transfered because, ' . $ticket[0]->reply;
										} elseif ($department->status == 'Reopen') {
											$this->db->where('ticketid', $department->id)->where('ticket_status', 'Reopen');
											$query = $this->db->get('ticket_pdf_message');
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
											<td>PDFT-<?php echo $department->id; ?></td>
											<td style="overflow: clip; word-break: break-all;"><?php echo $department->feed->name; ?>&nbsp;(<a href="<?php echo $ip_link_patient_feedback . $department->feedbackid; ?>"><?php echo $department->feed->patientid; ?></a>)
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
											<td>
												<?php echo $department->ratingt; ?>
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
																	$show = $res[$key];
																}
															}
														}
													}
												}
												// print_r($show);
												?>
											</td>
											<?php if ($this->session->userdata('user_role') != 4) { ?>
												<td><?php echo $department->department->description; ?>
													<br>
													<?php echo $department->department->pname; ?>
												</td>
											<?php } ?>
											<td style="overflow: clip; word-break: break-all;">

												<?php echo date('g:i A', strtotime($department->created_on)); ?>
												<br>
												<?php echo date('d-m-y', strtotime($department->created_on)); ?>
											</td>
											<?php if (ip_tat('open_ticket') === true) { ?>
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
											if ($department->status == 'Reopen') {
												$tool = 'Click to close this ticket.';
												$color = 'primary';
											} elseif ($department->status == 'Open') {
												$tool = 'Click to change the status.';
												$color = 'danger';
											} elseif ($department->status == 'Transfered') {
												$tool = 'Click to close this ticket.';
												$color = 'info';
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

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('ip','ip_no_record_found'); ?>
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
</script>