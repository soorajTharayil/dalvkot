<div class="content">
	<?php
	$hide = false;
	if ($this->input->post('pid') || $this->input->get('patientid')) {
		$hide = true;
		if ($this->input->post('pid')) {
			$pid = $this->input->post('pid');
		} else {
			$pid = $this->input->get('patientid');
		}
		$this->db->where('patientid', $pid);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('bf_feedback_int');
		$results = $query->result();

		foreach ($results as $result) {
			$encodedImage = $result->image;
			$pat = json_decode($result->dataset, true);
		}
	?>
		<?php if ($pat) { ?>
			<div class="panel panel-default">
				<div class="panel-body" style="background: #fff;">
					<table class=" table table-striped table-bordered  no-footer dtr-inline ">
						<tr>
							<td colspan="2"><strong><?php echo lang_loader('pcf', 'pcf_complaint_raised_by'); ?></strong></td>
						</tr>
						<tr>
							<td>
								<?php echo lang_loader('pcf', 'pcf_patient_name'); ?>
							</td>
							<td>
								<?php echo $pat['name']; ?>
							</td>
						</tr>
						<tr>
							<td><?php echo lang_loader('pcf', 'pcf_patient_id'); ?></td>
							<td>
								<?php echo $pat['patientid']; ?>
							</td>
						</tr>
						<tr>
							<td><?php echo lang_loader('pcf', 'pcf_contact_details'); ?></td>
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
			</div>

			<br>
			<?php
			//udpated code 
			foreach ($results as $result) {
				$param = json_decode($result->dataset, true);
				$this->db->select("*");
				$this->db->from('setup_int');
				$query = $this->db->get();
				$reasons  = $query->result();
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
			?>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('pcf', 'pcf_patient_complaint_id_tooltip'); ?> "><i class="fa fa-question-circle" aria-hidden="true"></i></a> PC-<?php echo $result->id; ?> </h3>
							</div>
							<div class="panel-body" style="background: #fff;">
								<table class=" table table-striped table-bordered  no-footer dtr-inline ">
									<tr>
										<td colspan="2"><strong><?php echo lang_loader('pcf', 'pcf_complaint_details'); ?></strong> </td>
									</tr>
									<tr>
										<td><?php echo lang_loader('pcf', 'pcf_reported_on'); ?></td>
										<td><?php echo date('g:i A, d-m-y', strtotime($result->datetime)); ?></td>
									</tr>
									<tr>
										<td><?php echo lang_loader('pcf', 'pcf_department'); ?></td>
										<td><?php echo  $department; ?></td>
									</tr>
									<tr>
										<td><?php echo lang_loader('pcf', 'pcf_concern'); ?></td>
										<td><?php echo $Concern; ?></td>
									</tr>

									<?php if ($comment) { ?>
										<tr>
											<td><?php echo lang_loader('pcf', 'pcf_description'); ?></td>
											<td><span style="overflow: clip; word-break: break-all;">"<?php echo $comment; ?>"</span></td>
										</tr>
									<?php } ?>
									<tr>
										<td><?php echo lang_loader('pcf', 'pcf_complaint_raised_in'); ?></td>
										<td><?php if ($param['ward'] != '') { ?>
												<?php echo 'Floor/Ward: '; ?>
												<?php echo ($param['ward']); ?>
											<?php } ?>
											<br>
											<?php if ($param['bedno']) { ?>
												<?php echo 'Room/Bed no: '; ?>
												<?php echo $param['bedno']; ?>
											<?php } ?>

										</td>
									</tr>
									<?php if ($result->source != '') { ?>
										<tr>
											<td><?php echo lang_loader('pcf', 'pcf_source'); ?></td>
											<td><?php if ($result->source == 'APP') {
													echo 'Mobile Application.';
												} elseif ($result->source == 'Link') {
													echo 'Web Link.';
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
					<div class="panel panel-default ">
						<div class="panel-heading">
							<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('pcf', 'pcf_no_record_found'); ?> <br>
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
				<div class="panel panel-default">
					<div class="panel-heading">
						<?php echo form_open(); ?>
						<table class="table">
							<tr>
								<th class="" style="border:none !important;vertical-align: middle; text-align:right;"><?php echo lang_loader('pcf', 'pcf_find_by_patient'); ?></th>
								<td class="" style="border:none !important;">
									<input type="text" class="form-control" placeholder="Enter Patient ID" maxlength="15" size="10" name="pid">
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