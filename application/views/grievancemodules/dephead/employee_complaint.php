<div class="content">
	
	<?php

	$hide = false;
	if ($this->input->post('empid') || $this->input->get('empid')) {
		$hide = true;
		if ($this->input->post('empid')) {
			$pid = $this->input->post('empid');
		} else {
			$pid = $this->input->get('empid');
		}
		$this->db->where('patientid', $pid);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('bf_feedback_grievance');
		$results = $query->result();

		foreach ($results as $result) {
			$encodedImage = $result->image;
			$pat = json_decode($result->dataset, true);
		}
	?>
		<?php if ($pat) { ?>

			<div class="panel-body" style="background: #fff;">
				<table class=" table table-striped table-bordered  no-footer dtr-inline ">
					<tr>
						<td colspan="2"><strong><?php echo lang_loader('sg', 'sg_grievance_reported_by'); ?></strong></td>
					</tr>
					<tr>
						<td>
							<?php echo lang_loader('sg', 'sg_employee_name'); ?>
						</td>
						<td>
							<?php echo $pat['name']; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo lang_loader('sg', 'sg_employee_id'); ?></td>
						<td>
							<?php echo $pat['patientid']; ?>
						</td>
					</tr>
					<!-- <tr>
						<td><?php echo lang_loader('sg', 'sg_employee_role'); ?></td>
						<td>
							<?php echo $pat['role']; ?>
						</td>
					</tr> -->
					<tr>
						<td><?php echo lang_loader('sg', 'sg_contact_details'); ?></td>
						<td>
							<?php if ($pat['contactnumber'] != '') { ?>
								<i class="fa fa-phone"></i> <?php echo $pat['contactnumber']; ?>
							<?php } ?>
							<br>
							<?php if ($pat['email'] != '') { ?>
								<i class="fa fa-envelope-o"></i> <?php echo $pat['email']; ?>
							<?php } ?>
						</td>
					</tr>
				</table>
			</div>
			<br>

			<?php
			//udpated code 

			$session_permissions = $this->session->userdata;

			// changed the depin 
			// adf for ADF
			// inpatient for IP
			// outpatient for OP
			// interim for PCF 
			// esr for ISR
			// incident for INCIDENT 
			// grievance for GRIEVANCES
			$dep_array = $session_permissions['department_access']['grievance'];

			$department_array = array_keys((array)$dep_array);


			foreach ($results as $result) {
				$param = json_decode($result->dataset, true);
				$this->db->select("*");
				$this->db->where_in('type', $department_array);
				$this->db->from('setup_grievance');
				$query = $this->db->get();
				$reasons  = $query->result();
				// print_r($reasons);
				// exit;
				// print_r($reasons);
				foreach ($reasons as $row) {
					$keys[$row->shortkey] = $row->shortkey;
					$res[$row->shortkey] = $row->shortname;
					$titles[$row->type] = $row->title;
					$title_key[$row->type] = $row->type;
				}


				foreach ($param['reason'] as $key => $crow) {
					if (in_array($key, $keys)) {
						$Concern = $res[$key];
					}
				}
				foreach ($param['comment'] as $key2 => $crow) {
					if (in_array($key2, $title_key)) {
						$department = $titles[$key2];
						$comment = $crow;
					}
				}
				//print_r($department);
				// print_r($Concern);
			?>
				<?php if (in_array($key2, $department_array)) { ?>
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3><a href="javascript:void()" data-toggle="tooltip" title="GRIEVANCE- <GRIEVANCE ID> "><i class="fa fa-question-circle" aria-hidden="true"></i></a> SG-<?php echo $result->id; ?> </h3>
								</div>
								<div class="panel-body" style="background: #fff;">
									<table class=" table table-striped table-bordered  no-footer dtr-inline ">
										<?php //$department = $patients[0]; ?>
										<table class=" table table-striped table-bordered  no-footer dtr-inline ">
											<tr>
												<td colspan="2"><strong><?php echo lang_loader('sg', 'sg_grievance_detail'); ?></strong> </td>
											</tr>
											<tr>
												<td><?php echo lang_loader('sg', 'sg_reported_on'); ?></td>
												<td><?php echo date('g:i A, d-m-y', strtotime($result->datetime)); ?></td>
											</tr>
											<tr>
												<td><?php echo lang_loader('sg', 'sg_category'); ?></td>
												<td><?php echo  $department; ?></td>
											</tr>
											<tr>
												<td><?php echo lang_loader('sg', 'sg_grievance'); ?></td>
												<td><?php echo $Concern; ?></td>
											</tr>

											<?php if ($param['other']) { ?>
												<tr>
													<td><?php echo lang_loader('sg', 'sg_description'); ?></td>
													<td><span style="overflow: clip; word-break: break-all;">"<?php echo $param['other']; ?>"</span></td>
												</tr>
											<?php } ?>

											<?php
											if ($param['image'] != '' && $param['image'] != NULL) {
												$encodedImage = $param['image'];  ?>
												<tr>
													<td><?php echo lang_loader('sg', 'sg_attached_image'); ?></td>
													<td><img src="<?php echo $encodedImage; ?>" width="100%" height="300px" alt="Rendered Image" onclick="openImageInNewTab('<?php echo $encodedImage; ?>')"></td>
												</tr>
											<?php } ?>
											<tr>
												<td><?php echo lang_loader('sg', 'sg_grievance_reported_in'); ?></td>
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
											<?php if ($result->source != '') { ?>
												<tr>
													<td><?php echo lang_loader('sg', 'sg_source'); ?></td>
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
			<?php } ?>

		<?php } else {  ?>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default thumbnail">
						<div class="panel-heading">
							<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('sg', 'sg_no_record_found'); ?> <br>
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
								<th class="" style="border:none !important;vertical-align: middle; text-align:right;"><?php echo lang_loader('sg', 'sg_find_by_employee_id'); ?></th>
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