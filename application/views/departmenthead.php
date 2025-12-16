<!-- This page shows the list of departments -->
<?php include 'overallpage_department_user_count.php';  ?>
<div class="content">
	<?php
	$session_permissions = $this->session->userdata;
	$dep_array = $session_permissions['department_access'];

	$new_array = array();

	foreach ($dep_array as $department) {
		foreach ($department as $set) {
			$values = explode(',', $set);
			$new_array = array_merge($new_array, $values);
		}
	}




	$this->db->group_by('type,description');
	$this->db->order_by('dprt_id');

	$this->db->where_in('department.slug', $new_array);
	$query = $this->db->get('department');
	$departments = $query->result();

	?>

	<div class="row">
		<!--  table area start-->
		<div class="col-lg-12">
			<div class="panel panel-default">


				<div class="panel-body">
					<table class="datatables table table-striped table-bordered" cellspacing="0" width="100%">
						<!-- table head start -->
						<thead>
							<tr>
								<th><?php echo display('serial') ?></th>
								<th>Module</th>
								<th>Department</th>
							</tr>
						</thead>
						<!-- table head end -->

						<!-- table body start -->
						<tbody>
							<?php
							$sl = 1;
							foreach ($departments as $department) {
								$T = false; // Initialize $T as false for each department

								if (ismodule_active('IP') && $department->type == 'inpatient') {
									$T = 'INPATIENT FEEDBACKS';
								} elseif (ismodule_active('OP') && $department->type == 'outpatient') {
									$T = 'OUTPATIENT FEEDBACKS';
								} elseif (ismodule_active('PCF') && $department->type == 'interim') {
									$T = 'PATIENT COMPLAINTS';
								} elseif (ismodule_active('PDF') && $department->type == 'pdf') {
									$T = 'POST DISCHARGE FEEDBACKS';
								} elseif (ismodule_active('ISR') && $department->type == 'esr') {
									$T = 'INTERNAL SERVICE REQUEST';
								} elseif (ismodule_active('INCIDENT') && $department->type == 'incident') {
									$T = 'INCIDENTS';
								} elseif (ismodule_active('GRIEVANCE') && $department->type == 'grievance') {
									$T = 'GRIEVANCES';
								}

								// Output department details with $T
								echo '<tr class="' . ($sl & 1 ? "odd gradeX" : "even gradeC") . '">';
								echo '<td>' . $sl . '</td>';
								echo '<td>' . ($T ? $T : '') . '</td>'; // Output $T if it has a value
								echo '<td>' . $department->description . '</td>';
								echo '</tr>';

								$sl++; // Increment serial number
							}
							?>
						</tbody>
						<!-- table body end -->

					</table> <!-- /.table-responsive -->
				</div>
			</div>
		</div>
		<!--  table area end-->
	</div>
	<?php if ($this->session->userdata['user_role'] != 7) { ?>
		<?php

		$user_id = $this->session->userdata('user_id');
		$setAccess = [];
		foreach ($this->session->userdata('department_access') as $key => $rows) {
			foreach ($rows as $k => $row) {
				//print_r($row); exit;
				$setAccess[] = $k;
			}
		}
		$users = $this->db->select('*')
			->from('user')

			->get()
			->result();

		$department_users = array();
		foreach ($users as $user) {
			$parameter = json_decode($user->department);

			foreach ($parameter as $key => $rows) {

				foreach ($rows as $k => $row) {

					$slugs = explode(',', $row);

					foreach ($slugs as $r) {
						if (in_array($k, $setAccess)) {
							//$department_users[$key][$k][$r][] = $user->firstname;
							$department_users[$user->user_id][$user->lastname] = $user->firstname;
						}
					}
				}
			}
		}



		?>
		<?php foreach ($department_users as $key => $rows) { ?>
			<?php foreach ($rows as $k => $r) { ?>

				<div class="row">
					<!--  table area start-->
					<div class="col-lg-12">
						<div class="panel panel-default">

							<table class="datatables table table-striped table-bordered" cellspacing="0" width="100%">


								<tr>
									<div style="margin: 5px; padding:5px;">
										<strong><?php echo $r ." (". $k .")" ?></strong>

									</div>
								</tr>

								<tr>

									<td><b><?php echo lang_loader('global', 'global_module'); ?></td>

									<td><b><?php echo lang_loader('global', 'global_total_tickets'); ?></b></td>
									<?php if ($this->session->userdata['user_id'] == $key) { ?>
										<td><b><?php echo lang_loader('global', 'global_open'); ?> </b></td>
									<?php } else { ?>
										<td><b> Assigned </b></td>
									<?php } ?>
									<td><b><?php echo lang_loader('global', 'global_addressed'); ?> </b></td>

									<td><b><?php echo lang_loader('global', 'global_closed'); ?> </b></td>

									<!-- <td><b><?php echo lang_loader('global', 'global_ticket_r_rate'); ?> </b></td>

								<td><b><?php echo lang_loader('global', 'global_avg_r_time'); ?></b></td> -->

								</tr>

								<!-- if condition  -->

								<?php if (ismodule_active('ADF') === true) {  ?>

									<tr>

										<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

										<td><b><?php echo lang_loader('global', 'global_admission_feedback'); ?></b></td>

										<td><?php echo count($adfalltickets); ?></td>

										<td><?php echo count($adfopentickets); ?></td>

										<td><?php echo count($adfaddressed); ?></td>

										<td><?php echo count($adfclosedtickets); ?></td>

										<!-- <td><?php echo $ticket_resolution_rate_adf . '%'; ?></td>

									<td><?php echo $ticket_close_rate_adf; ?></td> -->

									</tr>

								<?php  } ?>

								<?php if (ismodule_active('IP') === true) {  ?>

									<tr>

										<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

										<td><b><?php echo lang_loader('global', 'global_inpatient_feedback'); ?></b></td>

										<td><?php echo count($ip_tickets_count); ?></td>

										<td><?php echo count($ip_open_tickets) + count($ip_reopen_tickets); ?></td>

										<td><?php echo count($ip_addressed_tickets); ?></td>

										<td><?php echo count($ip_closed_tickets); ?></td>

										<!-- <td><?php echo $ticket_resolution_rate_ip . '%';  ?></td>

									<td><?php echo $ticket_close_rate_ip; ?></td> -->

									</tr>

								<?php  } ?>

								<?php if (ismodule_active('PDF') === true) {  ?>

									<tr>

										<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

										<td><b><?php echo lang_loader('global', 'global_post_feedback'); ?></b></td>

										<td><?php echo count($pdf_tickets_count); ?></td>

										<td><?php echo count($pdf_open_tickets) + count($pdf_reopen_tickets); ?></td>

										<td><?php echo count($pdf_addressed_tickets); ?></td>

										<td><?php echo count($pdf_closed_tickets); ?></td>

										<td><?php echo $ticket_resolution_rate_ip . '%';  ?></td>

										<td><?php echo $ticket_close_rate_ip; ?></td>

									</tr>

								<?php  } ?>

								<?php if (ismodule_active('PCF') === true) {  ?>

									<tr>

										<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

										<td><b><?php echo lang_loader('global', 'global_inp_complaints'); ?></b></td>

										<td><?php echo count($int_tickets_count); ?></td>

										<td><?php echo count($int_open_tickets) + count($int_reopen_tickets); ?></td>

										<td><?php echo count($int_addressed_tickets); ?></td>

										<td><?php echo count($int_closed_tickets); ?></td>

										<!-- <td><?php echo $ticket_resolution_rate_int . '%';  ?></td>

									<td><?php echo $ticket_close_rate_int; ?></td> -->

									</tr>

								<?php  } ?>

								<?php if (ismodule_active('OP') === true) {  ?>

									<tr>

										<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

										<td><b><?php echo lang_loader('global', 'global_otpatient_feedback'); ?></b></td>

										<td><?php echo count($op_tickets_count); ?></td>

										<td><?php echo count($op_open_tickets) + count($op_reopen_tickets); ?></td>

										<td><?php echo count($op_addressed_tickets); ?></td>

										<td><?php echo count($op_closed_tickets); ?></td>

										<!-- <td><?php echo $ticket_resolution_rate_op . '%';  ?></td>

									<td><?php echo $ticket_close_rate_op; ?></td> -->

									</tr>

								<?php  } ?>

								<?php if (ismodule_active('ISR') === true) {  ?>
									<?php
									$alltickets = $this->ticketsesr_model->alltickets();
									$opentickets = $this->ticketsesr_model->read();
									$closedtickets = $this->ticketsesr_model->read_close();
									$addressed = $this->ticketsesr_model->addressedtickets();


									$isr_department_head_count['alltickets'] = count($alltickets);
									$isr_department_head_count['opentickets'] = count($opentickets);
									$isr_department_head_count['closedticket'] = count($closedtickets);
									$isr_department_head_count['addressedtickets'] = count($addressed);
									?>
									<?php if ($this->session->userdata['user_id'] == $key) { ?>
										<tr>

											<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

											<td><b><?php echo lang_loader('global', 'global_ir_request'); ?></b></td>

											<td><?php echo $isr_department_head_count['alltickets'] ?></td>

											<td><?php echo $isr_department_head_count['opentickets'] ?></td>

											<td><?php echo $isr_department_head_count['addressedtickets'] ?></td>

											<td><?php echo $isr_department_head_count['closedticket'] ?></td>

											<!-- <td><?php echo $ticket_resolution_rate_esr . '%';  ?></td>

								<td><?php echo $ticket_close_rate_esr; ?></td> -->

										</tr>

									<?php  } else { ?>
										<?php

										$alltickets = $this->ticketsesr_model->alltickets();
										$opentickets = $this->ticketsesr_model->read();
										$closedtickets = $this->ticketsesr_model->read_close();
										$addressed = $this->ticketsesr_model->addressedtickets();


										$alltickets_assign_user_count = 0; // Initialize a variable to count the tickets where assign_user = 1
										$opentickets_assign_user_count = 0; // Initialize a variable to count the tickets where assign_user = 1
										$closetickets_assign_user_count = 0; // Initialize a variable to count the tickets where assign_user = 1
										$addressedtickets_assign_user_count = 0; // Initialize a variable to count the tickets where assign_user = 1
										$dept_user = array();
										foreach ($alltickets as $ticket) {
											if ($ticket->assign_user == 1 && $ticket->assign_to == $key) {
												$alltickets_assign_user_count++; // Increment the count if assign_user is equal to 1
												$dept_user[] = $ticket;
											}
										}

										foreach ($opentickets as $ticket) {
											if ($ticket->assign_user == 1 && $ticket->assign_to == $key) {
												$opentickets_assign_user_count++; // Increment the count if assign_user is equal to 1
											}
										}

										foreach ($closedtickets as $ticket) {
											if ($ticket->assign_user == 1 && $ticket->assign_to == $key) {
												$closetickets_assign_user_count++; // Increment the count if assign_user is equal to 1
											}
										}

										foreach ($addressed as $ticket) {
											if ($ticket->assign_user == 1 && $ticket->assign_to == $key) {
												$addressedtickets_assign_user_count++; // Increment the count if assign_user is equal to 1
											}
										}


										$isr_department_head_user_count['alltickets'] =  $alltickets_assign_user_count;
										$isr_department_head_user_count['opentickets'] = $opentickets_assign_user_count;
										$isr_department_head_user_count['closedticket'] = $closetickets_assign_user_count;
										$isr_department_head_user_count['addressedtickets'] = $addressedtickets_assign_user_count;
										?>

										<tr>

											<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

											<td><b><?php echo lang_loader('global', 'global_ir_request'); ?></b></td>

											<td><?php echo $isr_department_head_user_count['alltickets'] ?></td>

											<td><?php echo $isr_department_head_user_count['opentickets'] ?></td>

											<td><?php echo $isr_department_head_user_count['addressedtickets'] ?></td>

											<td><?php echo $isr_department_head_user_count['closedticket'] ?></td>

											<!-- <td><?php echo $ticket_resolution_rate_esr . '%';  ?></td>

								<td><?php echo $ticket_close_rate_esr; ?></td> -->

										</tr>

									<?php  } ?>

								<?php  } ?>





								<?php if (ismodule_active('INCIDENT') === true) {  ?>

									<tr>

										<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

										<td><b><?php echo lang_loader('global', 'global_incidents'); ?></b></td>

										<td><?php echo count($incident_tickets_count); ?></td>

										<td><?php echo count($incident_open_tickets) + count($esr_reopen_tickets); ?></td>

										<td><?php echo count($incident_addressed_tickets); ?></td>

										<td><?php echo count($incident_closed_tickets); ?></td>

										<!-- <td><?php echo $ticket_resolution_rate_incident . '%';  ?></td>

									<td><?php echo $ticket_close_rate_incident; ?></td> -->

									</tr>

								<?php  } ?>





								<?php if (ismodule_active('GRIEVANCE') === true) {  ?>

									<tr>

										<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

										<td><b><?php echo lang_loader('global', 'global_g_report'); ?></b></td>

										<td><?php echo count($grievance_tickets_count); ?></td>

										<td><?php echo count($grievance_open_tickets) + count($esr_reopen_tickets); ?></td>

										<td><?php echo count($grievance_addressed_tickets); ?></td>

										<td><?php echo count($grievance_closed_tickets); ?></td>

										<!-- <td><?php echo $ticket_resolution_rate_grievance . '%';  ?></td>

									<td><?php echo $ticket_close_rate_grievance; ?></td> -->

									</tr>

								<?php  } ?>







							</table>
						</div>
					</div>
				</div>
			<?php } ?>

		<?php } ?>


</div>

<?php } ?>




<style>
	.dt-buttons.btn-group {
		display: none;
	}
</style>