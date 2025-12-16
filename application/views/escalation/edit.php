<div class="content">
	<div class="row">
		<!--  table area -->
		<div class="col-sm-12">
			<div class="panel panel-default thumbnail">
				<div class="panel-body">
					<?php if ($this->session->userdata('user_role') != 4) { ?>
						<form>
							<p> <span style="font-size:15px; font-weight:bold;">Sort Tickets By : </span>
								<select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment2(this.value)" style="width:200px; margin:0px 0px 20px 20px;">
									<option value="1" selected>Select Department</option>
									<?php
									$this->db->group_by('description');
									$this->db->where('type', 'inpatient');
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
										<option value="1" selected>Select Parameter</option>
										<?php
										$this->db->where('type', 'inpatient');
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
					
					<table class="datatabletc table table-striped table-bordered " cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>No.</th>
								<th>Ticket ID</th>
								<th>Patient Details</th>
								<th>Floor(Bed)</th>
								<th>Rating</th>
								<th>Parameter</th>
								<th>Department</th>
								<th>Assigned to</th>
								<th>Created On</th>
								<th>Closed On</th>
								<th>Status</th>

								<th>Corrective & Preventive Actions</th>
								<!-- <th style="width:600px;"> Actions</th> -->




								<th><?php echo display('action') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($departments)) { ?>
								<?php $sl = 1; ?>
								<?php foreach ($departments as $department) { ?>
									<tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>">
										<td><?php echo $sl; ?></td>
										<td>FMS-<?php echo $department->id; ?></td>
										<td><?php echo $department->patinet->name; ?>(<?php echo $department->patinet->patient_id; ?>)</td>
										<td><?php echo $department->patinet->ward; ?>(<?php echo $department->patinet->bed_no; ?>)</td>
										<td>
											<?php echo $department->ratingt; ?><a class="pull-right" href="javascript:void(0)" title="<?php echo $department->anymessage; ?>" data-toggle="tooltip"><i class="fa fa-comment"></i></a>
										</td>
										<td><?php echo $department->department->name; ?></td>
										<td><?php echo $department->department->description; ?></td>
										<td><?php echo $department->department->pname; ?></td>
										<td><?php echo date('d, M Y  H:i', strtotime($department->created_on)); ?></td>
										<td><?php echo date('d, M Y  H:i', strtotime($department->closed_on)); ?></td>
										<td><?php  echo $department->status; ?></td>
										<td style="overflow: auto;"><?php foreach ($department->replymessage as $r) { ?> <?php if ($r->corrective != NULL) { ?> <?php echo $r->corrective; ?> <?php }
																																															} ?></td>
										<!--<td style="white-space: nowrap;"><?php foreach ($department->replymessage as $r) { ?>	<?php if ($r->preventive != NULL) { ?> <?php echo $r->preventive; ?> <?php }
																																																	} ?></td>-->

										<td class="center">
											<a href="<?php echo base_url("tickets/track_close/$department->id") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a>

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
</div>
<style>
	th.sorting_disabled {
		white-space: nowrap;
		overflow: hidden;
	}
</style>

<script>
	function gotonextdepartment(type) {
		var subsecid = $('#subsecid').val();
		var url = "<?php echo base_url(); ?>tickets/ticket_close?type=" + type + "&depsec=" + subsecid;
		window.location.href = url;
	}

	function gotonextdepartment2(type) {
		var url = "<?php echo base_url(); ?>tickets/ticket_close?depsec=" + type;
		window.location.href = url;
	}
</script>