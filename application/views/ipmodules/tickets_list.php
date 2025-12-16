<div class="content">
	<div class="row">
		<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
		<script src="<?php echo base_url(); ?>assets/utils.js"></script>

		<?php
		$this->db->select("*");
		$this->db->from('setup');
		$this->db->where('parent', 0);
		$query = $this->db->get();
		$reasons  = $query->result();
		foreach ($reasons as $row) {
			$keys[$row->shortkey] = $row->shortkey;
			$res[$row->shortkey] = $row->shortname;
			$titles[$row->shortkey] = $row->title;
		}
		$ip_link_patient_feedback = base_url('ipd/patient_feedback?id=');



		$hosplogo = $this->db->select("logo,title")
			->get('setting')
			->row();

		$logo_img['logo'] = $hosplogo->logo;
		$logo_img['title'] = $hosplogo->title;
		?>


		<div class="col-lg-12">
			<?php $department = $departments[0]; ?>


			<div class="panel panel-default">
				<div style="width:100%; text-align:center">
					<img src="<?php echo (!empty($logo_img) ? base_url('uploads/' . $logo_img['logo']) : null) ?>" style=" height: 60px; width: 180px; margin-top:5px;   margin-bottom: 0px;">
					<br>
					<p style="font-family: Arial, sans-serif;font-size:20px; margin-bottom: 5px; margin-top: 2px;font-weight: bold;"><?php echo $logo_img['title']; ?></p>
				</div>


				<div class="panel-body" style="background: #fff;">


					<div class="patient-card">
						<h4 class="patient-info">
							<strong><?php echo lang_loader('ip','ip_patient_details'); ?></strong>
						</h4>
						<div class="patient-details">
							<span class="patient-name"><b><?php echo $departments[0]->feedback->name; ?>&nbsp;(<a href="<?php echo $ip_link_patient_feedback . $department->feedbackid; ?>"><?php echo $department->feedback->patientid; ?></a>)</b></span>
							<br>
							<?php if ($departments[0]->feedback->bedno) { ?>
								From <?php echo $departments[0]->feedback->bedno; ?>
							<?php } ?>
							<?php if ($departments[0]->feedback->ward) { ?>
								in <?php echo $departments[0]->feedback->ward; ?>
							<?php } ?>
							<br>
							<?php if ($departments[0]->feedback->contactnumber) { ?>
								<span class="contact-number">
									<i class="fa fa-phone"></i> <?php echo $departments[0]->feedback->contactnumber; ?>
								</span>
							<?php } ?>
						</div>
					</div>
					<br>

					<table class="<?php if ($this->session->userdata('isLogIn') === true) {
										echo 'listtickets ';
									} else {
										echo 'vertical-table';
									} ?> table table-striped table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="white-space: nowrap;"><?php echo lang_loader('ip','ip_ticket_id'); ?></th>
								<th style="white-space: nowrap;"><?php echo lang_loader('ip','ip_rating'); ?></th>
								<th style="white-space: nowrap;"><?php echo lang_loader('ip','ip_reasons'); ?></th>
								<?php if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?>
									<th><?php echo lang_loader('ip','ip_department'); ?></th>
								<?php } ?>
								<th style="white-space: nowrap;"><?php echo lang_loader('ip','ip_created_on'); ?></th>
								<?php if (ip_tat('admin_link') === true) { ?>
									<th style="white-space: nowrap;"> <?php echo lang_loader('ip','ip_tat'); ?></th>
								<?php } ?>
								<th style="text-align: center;"><?php echo display('action') ?></th>
							</tr>
						</thead>
						<?php foreach ($departments as $department) { ?>

							<tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>" data-placement="bottom" data-toggle="tooltip" title="<?php echo $rowmessage; ?>">

								<td><?php echo lang_loader('ip','ip_ipdt'); ?><?php echo $department->id; ?></td>
								<td>
									<?php echo $department->ratingt; ?>
								</td>
								<td>
									<?php foreach ($department->feedback->reason as $key => $value) {
										if ($value) {
											if ($titles[$key] == $department->department->description) {
												if (in_array($key, $keys)) {
													echo $res[$key];
													echo '<br>';
												}
											}
										}
									} ?>
								</td>
								<?php if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?>
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

								<?php if (ip_tat('admin_link') === true) { ?>
									<td style="overflow: clip; word-break: break-all;">
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
										?>
									</td>
								<?php } ?>

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
								<td style="align-items: center;">
									<a href="<?php echo base_url("ipd/admin_track/$department->id") ?>" data-placement="bottom" data-toggle="tooltip" title="<?php echo $tool; ?>" class="btn btn-sm btn-block btn-<?php echo $color; ?>"><?php echo $department->status; ?> <i style="font-size:x-small;" class="fa fa-edit"></i></a>
								</td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>


	</div>



</div>
<style>
	.patient-card {
		/* border: 1px solid #e0e0e0; */
		padding: 10px;
		border-radius: 5px;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		font-family: Arial, sans-serif;
		/* text-align: center; */
	}

	.patient-info {
		font-weight: bold;
		margin-bottom: 5px;
	}

	.patient-details span {
		display: inline-block;
		margin-right: 10px;
	}

	.patient-name {
		font-weight: bold;
	}

	.patient-id {
		color: #888;
	}

	.contact-number {
		color: #333;
	}
</style>