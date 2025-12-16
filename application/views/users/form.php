<!-- This page is used to add users -->
<?php
$ward = $this->db->order_by('id', 'asc')->get('bf_ward')->result();
?>

<div class="content">
	<div class="row">
		<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
		<script src="<?php echo base_url(); ?>assets/utils.js"></script>
		<!--  form area start-->
		<div class="col-lg-12">
			<div class="panel panel-default">
				<!-- user list button start-->
				<div class="panel-heading no-print">
					<div class="btn-group">
						<a class="btn btn-success" href="<?php echo base_url("users") ?>"> <i class="fa fa-list"></i> <?php echo lang_loader('global','global_user_list'); ?> </a>
					</div>
				</div>
				<!-- user list button end-->

				<div class="panel-body panel-form">
					<div class="row">
						<div class="col-md-8 col-sm-12 col-lg-12">

							<?php echo form_open('users/create', 'class="form-inner"') ?>
							<?php echo form_hidden('ids', $department->user_id) ?>
							<?php $permission = json_decode($department->departmentpermission, true); ?>
							<!-- Name start-->
							<div class="form-group row">
								<label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global','global_name'); ?> <i class="text-danger">*</i></label>
								<div class="col-xs-9">
									<input name="name" type="text" class="form-control" id="name" autocomplete="off" placeholder="Name" value="<?php echo $department->firstname; ?>" required>
								</div>
							</div>
							<!-- Name end-->

							<!-- Email start-->
							<div class="form-group row">
								<label for="email" class="col-xs-3 col-form-label"><?php echo lang_loader('global','global_email'); ?> <i class="text-danger">*</i></label>
								<div class="col-xs-9">
									<input name="email" type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $department->email ?>" autocomplete="off" required>
								</div>
							</div>
							<!-- Email end-->

							<!-- Email start-->
							<div class="form-group row" id="department_head_div" <?php if ($permission['userrole'] == 'Department Head') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
								<label for="email" class="col-xs-3 col-form-label"><?php echo lang_loader('global','global_alternate_email'); ?> <i class="text-danger">*</i></label>
								<div class="col-xs-9">
									<input name="alternate_email" type="email" class="form-control" id="alternate_email" placeholder="Alternate Email" value="<?php echo $department->alternate_email ?>">
								</div>
							</div>
							<!-- Email end-->

							<!-- Phone Number start -->
							<div class="form-group row">
								<label for="mobile" class="col-xs-3 col-form-label"><?php echo lang_loader('global','global_mobile'); ?> </label>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="mobile" name="mobile" pattern="[0-9]{10}" maxlength="10" placeholder="Mobile Number" value="<?php echo $department->mobile; ?>" autocomplete="off" required>
								</div>
							</div>
							<!-- Phone Number end -->
							<!-- Another Phone Number start -->

							<div class="form-group row" id="department_head_div2" <?php if ($permission['userrole'] == 'Department Head') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
								<label for="mobile" class="col-xs-3 col-form-label"><?php echo lang_loader('global','global_alternate_mobile'); ?> </label>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="alternate_mobile" name="alternate_mobile" pattern="[0-9]{10}" maxlength="10" placeholder="Alternate Mobile Number" value="<?php echo $department->alternate_mobile; ?>">
								</div>
							</div>


							<!--Another Phone Number end -->

							<!-- Password start -->
							<div class="form-group row" id="show_hide_password">
								<label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global','global_password'); ?> <i class="text-danger">*</i></label>
								<div class="col-xs-9">
									<input name="password" type="password" class="form-control" id="password" placeholder="Password" value="<?php echo $permission['password']; ?>" autocomplete="new-password" required>
									<div class="input-group-addon changepassword">
										<a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
									</div>
								</div>
							</div>
							<!-- Password end -->

							<!-- user role start -->
							<?php if ($department->user_id != 2) { ?>
								<div class="form-group row">
									<label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global','global_user_role'); ?> <i class="text-danger">*</i></label>
									<div class="col-xs-9">
										<select class="form-control" id="sel1" name="userrole" onchange="swithc_role(this.value)" style="border-radius:0px;" required>
											<option value=""><?php echo lang_loader('global','global_select_role'); ?></option>

											<option value="Admin" <?php if ($permission['userrole'] == 'Admin') {
																		echo 'selected';
																	} ?>><?php echo lang_loader('global','global_admin'); ?></option>
											<option value="Department Head" <?php if ($permission['userrole'] == 'Department Head') {
																				echo 'selected';
																			} ?>><?php echo lang_loader('global','global_department_head'); ?></option>
											<?php if (ismodule_active('admissionsection') == true) { ?>
												<option value="Admission Section" <?php if ($permission['userrole'] == 'Admission Section') {
																						echo 'selected';
																					} ?>><?php echo lang_loader('global','global_admission_section'); ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							<?php } else { ?>
								<div class="form-group row" style="display:none;">
									<label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global','global_user_role'); ?> <i class="text-danger">*</i></label>
									<div class="col-xs-9">
										<select class="form-control" id="sel1" name="userrole" style="border-radius:0px;" required>
											<option value="SuperAdmin" selected><?php echo lang_loader('global','global_super_admin'); ?></option>
										</select>
									</div>
								</div>
							<?php } ?>
							<!-- user role end -->
							<?php if ($this->session->userdata('user_role') == 0) { ?>

								<div class="form-group row" style="display:none;">
									<label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global','global_user_role'); ?> <i class="text-danger">*</i></label>
									<div class="col-xs-9">
										<select class="form-control" id="sel1" name="userrole" style="border-radius:0px;" required>
											<option value="SuperAdmin" selected><?php echo lang_loader('global','global_super_admin'); ?></option>
										</select>
									</div>
								</div>
							<?php } ?>
							<?php if ($permission['userrole'] == 'SuperAdmin') {
							?>
								<input type="hidden" class="form-control" value="2" id="user_role" name="user_role">
							<?php } ?>
							<?php if ($permission['userrole'] == 'Admin') {  //$department->user_role = 3;
							?>
								<input type="hidden" class="form-control" value="3" id="user_role" name="user_role">
							<?php } ?>
							<?php if ($permission['userrole'] == 'Department Head') { ?>
								<input type="hidden" class="form-control" value="4" id="user_role" name="user_role">

							<?php } ?>
							<?php if ($permission['userrole'] == 'Admission Section') { ?>
								<input type="hidden" class="form-control" value="5" id="user_role" name="user_role">
							<?php } ?>

							<div id="admin_access" <?php if ($permission['userrole'] == 'Admin') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>


								<div class="accordion" title="Dashboard Access">
								<?php echo lang_loader('global','global_dashboard_access'); ?>
									<a data-placement="up" data-toggle="tooltip" title="Access comprehensive data and metrics specific to all module's performance."><i class="fa fa-info-circle" aria-hidden="true"></i></a>
								</div>

								<div class="panel paneld">


									<div class="col-xs-12">

										<?php if (ismodule_active('ADF') === true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="admission_feedback" name="adfpermission" value="1" <?php if ($permission['adfpermission'] == 1) {
																																			echo 'checked';
																																		} ?>>&nbsp;<?php echo lang_loader('global','global_adf_module'); ?></label>
											</div>
										<?php } ?>

										<?php if (ismodule_active('IP') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="inpatient_feedback" name="ippermission" value="1" <?php if ($permission['ippermission'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;<?php echo lang_loader('global','global_ip_feedback_module'); ?></label>
											</div>
										<?php } ?>

										<?php if (ismodule_active('PCF') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="inpatient_complaint" name="inpermission" value="1" <?php if ($permission['inpermission'] == 1) {
																																			echo 'checked';
																																		} ?>>&nbsp;<?php echo lang_loader('global','global_ip_complaints_module'); ?></label>
											</div>
										<?php } ?>

										<?php if (ismodule_active('OP') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="outpatient_feedback" name="oppermission" value="1" <?php if ($permission['oppermission'] == 1) {
																																			echo 'checked';
																																		} ?>>&nbsp;<?php echo lang_loader('global','global_op_feedback_module'); ?></label>
											</div>
										<?php } ?>


										<?php if (ismodule_active('ISR') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="internal_service_request" name="esrpermission" value="1" <?php if ($permission['esrpermission'] == 1) {
																																				echo 'checked';
																																			} ?>>&nbsp;<?php echo lang_loader('global','global_isr_module'); ?></label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('empex_page') === true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="employee_experience_module" name="empexpermission" value="1" <?php if ($permission['empexpermission'] == 1) {
																																					echo 'checked';
																																				} ?>>&nbsp;<?php echo lang_loader('global','global_emp_exp_module'); ?></label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('INCIDENT') === true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="incident_module" name="incidentpermission" value="1" <?php if ($permission['incidentpermission'] == 1) {
																																			echo 'checked';
																																		} ?>>&nbsp;<?php echo lang_loader('global','global_inc_module'); ?></label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('GRIEVANCE') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="staff_grievance_module" name="grievancepermission" value="1" <?php if ($permission['grievancepermission'] == 1) {
																																					echo 'checked';
																																				} ?>>&nbsp;<?php echo lang_loader('global','global_sg_module'); ?></label>
											</div>
										<?php } ?>

									</div>



								</div>
								<div class="accordion"><?php echo lang_loader('global','global_form_access'); ?>
								<a data-placement="up" data-toggle="tooltip" title="Access the input form to input and submit your concern."><i class="fa fa-info-circle" aria-hidden="true"></i></a>
								</div>
								<div class="panel paneld">
									<div class="col-xs-12">

										<?php if (ismodule_active('ADF') === true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="adf_collect" name="adf_collect" value="1" <?php if ($permission['adf_collect'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_adf_module'); ?></label>
											</div>
										<?php } ?>

										<?php if (ismodule_active('IP') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="ip_collect" name="ip_collect" value="1" <?php if ($permission['ip_collect'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_ip_feedback_module'); ?></label>
											</div>
										<?php } ?>

										<?php if (ismodule_active('PCF') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="pcf_collect" name="pcf_collect" value="1" <?php if ($permission['pcf_collect'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_ip_complaints_module'); ?></label>
											</div>
										<?php } ?>

										<?php if (ismodule_active('OP') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="op_collect" name="op_collect" value="1" <?php if ($permission['op_collect'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_op_feedback_module'); ?></label>
											</div>
										<?php } ?>


										<?php if (ismodule_active('ISR') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="isr_collect" name="isr_collect" value="1" <?php if ($permission['isr_collect'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_isr_module'); ?></label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('INCIDENT') === true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="inc_collect" name="inc_collect" value="1" <?php if ($permission['inc_collect'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_inc_module'); ?></label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('GRIEVANCE') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" id="sg_collect" name="sg_collect" value="1" <?php if ($permission['sg_collect'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_sg_module'); ?></label>
											</div>
										<?php } ?>

									</div>

								</div>
								<!-- Access Permissions end -->
								<div class="accordion"><?php echo lang_loader('global','global_floorwise_access'); ?>
								<a data-placement="up" data-toggle="tooltip" title="Access data and details for different floors."><i class="fa fa-info-circle" aria-hidden="true"></i></a>

								</div>
								<div class="panel paneld">
									<div class="col-xs-12">
										<?php
										$allSelected = empty($permission['floor_ward']); // Check if no checkbox is selected
										$allFloors = array(); // Array to store all available floors

										foreach ($ward as $row) {
											if ($row->title != 'ALL') {
												$floor = $row->title;
												$allFloors[] = $floor; // Add floor to the array

												// Check if the floor is selected
												$isChecked = ($allSelected || in_array($floor, $permission['floor_ward']));

										?>
												<div class="checkboxreport">
													<label>
														<input type="checkbox" name="floor_ward[]" value="<?php echo $floor; ?>" <?php echo $isChecked ? 'checked' : ''; ?>>
														&nbsp;<?php echo $floor; ?>
													</label>
												</div>
										<?php
											}
										}

										// Update $permission['floor_ward'] with all available floors if no checkbox is selected
										if ($allSelected) {
											$permission['floor_ward'] = $allFloors;
										}
										?>
									</div>
								</div>
								<!-- SMS Alerts start -->
								<div class="accordion"><?php echo lang_loader('global','global_sms_alert'); ?>
								<a data-placement="up" data-toggle="tooltip" title="Enable SMS alerts to receive important notifications to your mobile device."><i class="fa fa-info-circle" aria-hidden="true"></i></a>

								</div>
								<div class="panel paneld">
									<div class="col-lg-12">
										<?php if (ismodule_active('ADF') === true) { ?>
											<div id="admission_feedback_sms">
												<h3><?php echo lang_loader('global','global_adf_module_sms'); ?></h3>
												<div class="checkboxreport">
													<label><input type="checkbox" name="message_ticket_adf" value="1" <?php if ($permission['message_ticket_adf'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_all_tickets'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="inweeklyreport_adf" value="1" <?php if ($permission['inweeklyreport_adf'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_feedback_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklyipticketreport_adf" value="1" <?php if ($permission['weeklyipticketreport_adf'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_ticket_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklynpsscore_adf" value="1" <?php if ($permission['weeklynpsscore_adf'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_nps_report'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklyiphospitalselection_adf" value="1" <?php if ($permission['weeklyiphospitalselection_adf'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_hs_analysis'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklyinsighthighlow_adf" value="1" <?php if ($permission['weeklyinsighthighlow_adf'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_tl_perf_parameters'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklyratinganalysis_adf" value="1" <?php if ($permission['weeklyratinganalysis_adf'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_r_analysis'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="inmonthlyreport_adf" value="1" <?php if ($permission['inmonthlyreport_adf'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_montly_f_report'); ?></label>
												</div>


												<div class="checkboxreport">
													<label><input type="checkbox" name="montlyipticketreport_adf" value="1" <?php if ($permission['montlyipticketreport_adf'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_t_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="monthlynpsscore_adf" value="1" <?php if ($permission['monthlynpsscore_adf'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_nps_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="montylyiphospitalselection_adf" value="1" <?php if ($permission['montylyiphospitalselection_adf'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_hs_analysis'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="monthlyinsighthighlow_adf" value="1" <?php if ($permission['monthlyinsighthighlow_adf'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_tl_perf_parameter'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="monthlyratinganalysis_adf" value="1" <?php if ($permission['monthlyratinganalysis_adf'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_r_analysis'); ?></label>
												</div>
											</div>
										<?php } #OP SMS ALERTS 
										?>
										<?php if (ismodule_active('IP') === true) { ?>
											<div id="inpatient_feedback_sms">
												<h3><?php echo lang_loader('global','global_ip_module_sms'); ?></h3>
												<div class="checkboxreport">
													<label><input type="checkbox" name="message_ticket_ip" value="1" <?php if ($permission['message_ticket_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_all_tickets'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="inweeklyreport_ip" value="1" <?php if ($permission['inweeklyreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_feedback_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklyipticketreport_ip" value="1" <?php if ($permission['weeklyipticketreport_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_ticket_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklynpsscore_ip" value="1" <?php if ($permission['weeklynpsscore_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_nps_report'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklyiphospitalselection_ip" value="1" <?php if ($permission['weeklyiphospitalselection_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_hs_analysis'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklyinsighthighlow_ip" value="1" <?php if ($permission['weeklyinsighthighlow_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_tl_perf_parameters'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklyratinganalysis_ip" value="1" <?php if ($permission['weeklyratinganalysis_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_r_analysis'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="inmonthlyreport_ip" value="1" <?php if ($permission['inmonthlyreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_montly_f_report'); ?></label>
												</div>


												<div class="checkboxreport">
													<label><input type="checkbox" name="montlyipticketreport_ip" value="1" <?php if ($permission['montlyipticketreport_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_t_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="monthlynpsscore_ip" value="1" <?php if ($permission['monthlynpsscore_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_nps_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="montylyiphospitalselection_ip" value="1" <?php if ($permission['montylyiphospitalselection_ip'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_hs_analysis'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="monthlyinsighthighlow_ip" value="1" <?php if ($permission['monthlyinsighthighlow_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_tl_perf_parameter'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="monthlyratinganalysis_ip" value="1" <?php if ($permission['monthlyratinganalysis_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_r_analysis'); ?></label>
												</div>
											</div>
										<?php } #OP SMS ALERTS 
										?>
										<?php if (ismodule_active('OP') === true) { ?>
											<div id="outpatient_feedback_sms">
												<h3><?php echo lang_loader('global','global_op_module_sms'); ?></h3>

												<div class="checkboxreport">
													<label><input type="checkbox" name="message_ticket_op" value="1" <?php if ($permission['message_ticket_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_all_tickets'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="inweeklyreport_op" value="1" <?php if ($permission['inweeklyreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_feedback_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklyipticketreport_op" value="1" <?php if ($permission['weeklyipticketreport_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_ticket_report'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklynpsscore_op" value="1" <?php if ($permission['weeklynpsscore_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_nps_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklyiphospitalselection_op" value="1" <?php if ($permission['weeklyiphospitalselection_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_hs_analysis'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklyinsighthighlow_op" value="1" <?php if ($permission['weeklyinsighthighlow_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_tl_perf_parameters'); ?>.</label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="weeklyratinganalysis_op" value="1" <?php if ($permission['weeklyratinganalysis_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_r_analysis'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="inmonthlyreport_op" value="1" <?php if ($permission['inmonthlyreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_montly_f_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="montlyipticketreport_op" value="1" <?php if ($permission['montlyipticketreport_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_t_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="monthlynpsscore_op" value="1" <?php if ($permission['monthlynpsscore_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_nps_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="montylyiphospitalselection_op" value="1" <?php if ($permission['montylyiphospitalselection_op'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_hs_analysis'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="monthlyinsighthighlow_op" value="1" <?php if ($permission['monthlyinsighthighlow_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_tl_perf_parameter'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="monthlyratinganalysis_op" value="1" <?php if ($permission['monthlyratinganalysis_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_r_analysis'); ?></label>
												</div>
											</div>
										<?php } #OP SMS ALERTS 
										?>
										<?php if (ismodule_active('PCF') === true) { ?>
											<div id="inpatient_complaint_sms">
												<h3><?php echo lang_loader('global','global_pcf_sms'); ?></h3>
												<div class="checkboxreport">
													<label><input type="checkbox" name="message_ticket_int" value="1" <?php if ($permission['message_ticket_int'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_all_patient_complaints'); ?></label>
												</div>
											</div>
										<?php } ?>
										<?php if (ismodule_active('ISR') === true) { ?>
											<div id="internal_service_request_sms">
												<h3><?php echo lang_loader('global','global_isr_sms'); ?></h3>
												<div class="checkboxreport">
													<label><input type="checkbox" name="message_ticket_esr" value="1" <?php if ($permission['message_ticket_esr'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_all_request_notification'); ?></label>
												</div>
											</div>
										<?php } ?>
										<?php if (ismodule_active('INCIDENT') === true) { ?>
											<div id="incident_module_sms">
												<h3><?php echo lang_loader('global','global_inc_sms'); ?></h3>
												<div class="checkboxreport">
													<label><input type="checkbox" name="message_ticket_incident" value="1" <?php if ($permission['message_ticket_incident'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_all_inc_notification'); ?></label>
												</div>
											</div>
										<?php } ?>
										<?php if (ismodule_active('GRIEVANCE') === true) { ?>
											<div id="staff_grievance_module_sms">
												<h3><?php echo lang_loader('global','global_sg_sms'); ?></h3>
												<div class="checkboxreport">
													<label><input type="checkbox" name="message_ticket_grievance" value="1" <?php if ($permission['message_ticket_grievance'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_all_grievance_notification'); ?></label>
												</div>
											</div>
										<?php } ?>

									</div>
								</div>
								<!-- SMS Alerts end -->

								<!-- email Alerts start -->
								<div class="accordion"><?php echo lang_loader('global','global_email_alerts'); ?>
								<a data-placement="up" data-toggle="tooltip" title="Activate email alerts to receive important notifications to your inbox."><i class="fa fa-info-circle" aria-hidden="true"></i></a>

								</div>
								<div class="panel paneld">
									<div class="col-lg-12">
										<?php if (ismodule_active('ADF') === true) { ?>
											<div id="admission_feedback_email">
												<h3><?php echo lang_loader('global','global_adf_module_email'); ?></h3>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_ticket_adf" value="1" <?php if ($permission['email_ticket_adf'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_all_tickets'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="email_ticket_adf" value="1" <?php if ($permission['email_dailyticket_adf'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_daily_open_ticket'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_weeklyreport_adf" value="1" <?php if ($permission['email_weeklyreport_adf'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_feedback_report'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_weeklynpsreport_adf" value="1" <?php if ($permission['email_weeklynpsreport_adf'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_nps_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="email_weeklypatientreport_adf" value="1" <?php if ($permission['email_weeklypatientreport_adf'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_hs_analysis'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_monthlyreport_adf" value="1" <?php if ($permission['email_monthlyreport_adf'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_montly_f_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="email_monthlynpsreport_adf" value="1" <?php if ($permission['email_monthlynpsreport_adf'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_nps_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="email_monthlypatientreport_adf" value="1" <?php if ($permission['email_monthlypatientreport_adf'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_hs_analysis'); ?></label>
												</div>
											</div>
										<?php } ?>
										<?php if (ismodule_active('IP') === true) { ?>
											<div id="inpatient_feedback_email">
												<h3><?php echo lang_loader('global','global_ip_module_email'); ?></h3>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_ticket_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_all_tickets'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_dailyticket_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_daily_open_ticket'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_weeklyreport_ip" value="1" <?php if ($permission['email_weeklyreport_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_feedback_report'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_weeklynpsreport_ip" value="1" <?php if ($permission['email_weeklynpsreport_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_nps_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="email_weeklypatientreport_ip" value="1" <?php if ($permission['email_weeklypatientreport_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_hs_analysis'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_monthlyreport_ip" value="1" <?php if ($permission['email_monthlyreport_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_montly_f_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="email_monthlynpsreport_ip" value="1" <?php if ($permission['email_monthlynpsreport_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_nps_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="email_monthlypatientreport_ip" value="1" <?php if ($permission['email_monthlypatientreport_ip'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_hs_analysis'); ?></label>
												</div>
											</div>
										<?php } ?>

										<?php if (ismodule_active('OP') === true) { ?>
											<div id="outpatient_feedback_email">
												<h3><?php echo lang_loader('global','global_op_module_email'); ?></h3>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_ticket_op" value="1" <?php if ($permission['email_ticket_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_all_tickets'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_dailyticket_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_daily_open_ticket'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_weeklyreport_op" value="1" <?php if ($permission['email_weeklyreport_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_feedback_report'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_weeklynpsreport_op" value="1" <?php if ($permission['email_weeklynpsreport_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_nps_report'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_weeklypatientreport_op" value="1" <?php if ($permission['email_weeklypatientreport_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_hs_analysis'); ?></label>
												</div>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_monthlyreport_op" value="1" <?php if ($permission['email_monthlyreport_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_montly_f_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="email_monthlynpsreport_op" value="1" <?php if ($permission['email_monthlynpsreport_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_nps_report'); ?></label>
												</div>

												<div class="checkboxreport">
													<label><input type="checkbox" name="email_monthlypatientreport_op" value="1" <?php if ($permission['email_monthlypatientreport_op'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_hs_analysis'); ?></label>
												</div>
											</div>
										<?php } ?>
										<?php if (ismodule_active('PCF') === true) { ?>
											<div id="inpatient_complaint_email">
												<h3><?php echo lang_loader('global','global_pcf_email'); ?></h3>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_ticket_int" value="1" <?php if ($permission['email_ticket_int'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_all_patient_complaints'); ?>.</label>
												</div>
											</div>
										<?php } ?>
										<?php if (ismodule_active('ISR') === true) { ?>
											<div id="internal_service_request_email">
												<h3><?php echo lang_loader('global','global_isr_email'); ?></h3>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_ticket_esr" value="1" <?php if ($permission['email_ticket_esr'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_all_request_notification'); ?></label>
												</div>
											</div>
										<?php } ?>
										<?php if (ismodule_active('INCIDENT') === true) { ?>
											<div id="incident_module_email">
												<h3><?php echo lang_loader('global','global_inc_email'); ?></h3>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_ticket_incident" value="1" <?php if ($permission['email_ticket_incident'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_all_inc_notification'); ?></label>
												</div>
											</div>
										<?php } ?>
										<?php if (ismodule_active('GRIEVANCE') === true) { ?>
											<div id="staff_grievance_module_email">
												<h3><?php echo lang_loader('global','global_sg_email'); ?></h3>
												<div class="checkboxreport">
													<label><input type="checkbox" name="email_ticket_grievance" value="1" <?php if ($permission['email_ticket_grievance'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_all_grievance_notification'); ?></label>
												</div>
											</div>
										<?php } ?>

									</div>

								</div>

								<div class="accordion"><?php echo lang_loader('global','global_admission_control'); ?>
								<a data-placement="up" data-toggle="tooltip" title="Access the admission control section to oversee and facilitate patient admissions and discharges efficiently."><i class="fa fa-info-circle" aria-hidden="true"></i></a>

								</div>
								<div class="panel paneld">
									<div class="col-xs-12">

										<div class="checkboxreport" style="display: none;">
											<label><input type="checkbox" name="admin_patient_admission" value="1" <?php if ($permission['admin_patient_admission'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_patient_admission'); ?></label>
										</div>
										<div class="checkboxreport">
											<label><input type="checkbox" name="admin_patient_discharge" value="1" <?php if ($permission['admin_patient_discharge'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_patient_discharge'); ?></label>
										</div>
										<div class="checkboxreport">
											<label><input type="checkbox" name="admin_allaccess" value="1" <?php if ($permission['admin_allaccess'] == 1) {
																												echo 'checked';
																											} ?>>&nbsp;<?php echo lang_loader('global','global_all_access'); ?></label>
										</div>
									</div>
								</div>

							</div>


							<div id="department_head" <?php if ($permission['userrole'] == 'Department Head') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
								<?php if (ismodule_active('ADF') === true) { ?>
									<!-- Department Heads ADMISSION start -->
									<div class="accordion"><?php echo lang_loader('global','global_department_head_adf_tickets'); ?></div>
									<div class="panel paneld">
										<div class="col-xs-12">
											<?php foreach ($depadf as $radf) { ?>
												<div class="checkboxreport">
													<label>
														<input type="checkbox" name="depadf[<?php echo $radf->dprt_id; ?>]" value="1" <?php if ($permission['depadf'][$radf->dprt_id] == 1) {
																																			echo 'checked';
																																		} ?> <?php if ($radf->email != $department->email) {
																																					if ($radf->email != NULL || $radf->email != '') {
																																						echo 'disabled';
																																					}
																																				}
																																				?>>
														<?php echo $radf->description; ?> (<span style="font-weight:norma; font-size:12px;"><?php echo $radf->email; ?></span>)
													</label>
												</div>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
								<!-- Department Heads ADMISSION end -->
								<?php if (ismodule_active('IP') === true) { ?>
									<div class="accordion"><?php echo lang_loader('global','global_department_head_ipf_tickets'); ?> </div>
									<div class="panel paneld">
										<div class="col-xs-12">
											<?php foreach ($depip as $rip) { ?>
												<div class="checkboxreport">
													<label>
														<input type="checkbox" name="depip[<?php echo $rip->dprt_id; ?>]" value="1" <?php if ($permission['depip'][$rip->dprt_id] == 1) {
																																		echo 'checked';
																																	} ?> <?php if ($rip->email != $department->email) {
																																				if ($rip->email != NULL || $rip->email != '') {
																																					echo 'disabled';
																																				}
																																			}
																																			?>>
														<?php echo $rip->description; ?> (<span style="font-weight:norma; font-size:12px;"><?php echo $rip->email; ?></span>)
													</label>
												</div>
											<?php } ?>


										</div>
									</div>
								<?php } ?>



								<?php if (ismodule_active('OP') === true) { ?>
									<!-- Department Heads OutPatient start -->
									<div class="accordion"><?php echo lang_loader('global','global_department_head_opf_tickets'); ?> </div>
									<div class="panel paneld">
										<div class="col-xs-12">
											<?php foreach ($depop as $rip) { ?>
												<div class="checkboxreport">
													<label>
														<input type="checkbox" name="depop[<?php echo $rip->dprt_id; ?>]" value="1" <?php if ($permission['depop'][$rip->dprt_id] == 1) {
																																		echo 'checked';
																																	} ?> <?php if ($rip->email != $department->email) {
																																				if ($rip->email != NULL || $rip->email != '') {
																																					echo 'disabled';
																																				}
																																			}
																																			?>>
														<?php echo $rip->description; ?> (<span style="font-weight:norma; font-size:12px;"><?php echo $rip->email; ?></span>)
													</label>
												</div>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
								<!-- Department Heads OutPatient end -->

								<!-- Department Heads Interim start -->
								<?php if (ismodule_active('PCF') === true) { ?>

									<div class="accordion"><?php echo lang_loader('global','global_department_head_ipc_tickets'); ?> </div>
									<div class="panel paneld">
										<div class="col-xs-12">

											<?php foreach ($depin as $rip) { ?>
												<div class="checkboxreport">
													<label>
														<input type="checkbox" name="depin[<?php echo $rip->dprt_id; ?>]" value="1" <?php if ($permission['depin'][$rip->dprt_id] == 1) {
																																		echo 'checked';
																																	} ?> <?php if ($rip->email != $department->email) {
																																				if ($rip->email != NULL || $rip->email != '') {
																																					echo 'disabled';
																																				}
																																			}
																																			?>>
														<?php echo $rip->description; ?> (<span style="font-weight:norma; font-size:12px;"><?php echo $rip->email; ?></span>)
													</label>
												</div>
											<?php } ?>
										</div>

									</div>
								<?php } ?>
								<!-- Department Heads Patient service start -->
								<?php if (ismodule_active('psr_page') === true) { ?>

									<div class="accordion"><?php echo lang_loader('global','global_department_head_pcr'); ?></div>
									<div class="panel paneld">
										<div class="col-xs-12">

											<?php foreach ($deppsr as $rip) { ?>
												<div class="checkboxreport">
													<label>
														<input type="checkbox" name="deppsr[<?php echo $rip->dprt_id; ?>]" value="1" <?php if ($permission['deppsr'][$rip->dprt_id] == 1) {
																																			echo 'checked';
																																		} ?> <?php if ($rip->email != $department->email) {
																																					if ($rip->email != NULL || $rip->email != '') {
																																						echo 'disabled';
																																					}
																																				}
																																				?>>
														<?php echo $rip->description; ?> (<span style="font-weight:norma; font-size:12px;"><?php echo $rip->email; ?></span>)
													</label>
												</div>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
								<!-- Department Heads Interim start -->
								<?php if (ismodule_active('ISR') === true) { ?>

									<div class="accordion"><?php echo lang_loader('global','global_department_head_isr'); ?></div>
									<div class="panel paneld">
										<div class="col-xs-12">

											<?php foreach ($depesr as $rip) { ?>
												<div class="checkboxreport">
													<label>
														<input type="checkbox" name="depesr[<?php echo $rip->dprt_id; ?>]" value="1" <?php if ($permission['depesr'][$rip->dprt_id] == 1) {
																																			echo 'checked';
																																		} ?> <?php if ($rip->email != $department->email) {
																																					if ($rip->email != NULL || $rip->email != '') {
																																						echo 'disabled';
																																					}
																																				}
																																				?>>
														<?php echo $rip->description; ?> (<span style="font-weight:norma; font-size:12px;"><?php echo $rip->email; ?></span>)
													</label>
												</div>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
								<!-- Department Heads Interim start -->
								<?php if (ismodule_active('empex_page') === true) { ?>

									<div class="accordion"><?php echo lang_loader('global','global_department_head_emp_exp'); ?></div>
									<div class="panel paneld">
										<div class="col-xs-12">

											<?php foreach ($depempex as $rip) { ?>
												<div class="checkboxreport">
													<label>
														<input type="checkbox" name="depempex[<?php echo $rip->dprt_id; ?>]" value="1" <?php if ($permission['depempex'][$rip->dprt_id] == 1) {
																																			echo 'checked';
																																		} ?> <?php if ($rip->email != $department->email) {
																																					if ($rip->email != NULL || $rip->email != '') {
																																						echo 'disabled';
																																					}
																																				}
																																				?>>
														<?php echo $rip->description; ?> (<span style="font-weight:norma; font-size:12px;"><?php echo $rip->email; ?></span>)
													</label>
												</div>
											<?php } ?>
										</div>
									</div>
								<?php } ?>

								<?php if (ismodule_active('INCIDENT') === true) { ?>

									<div class="accordion"><?php echo lang_loader('global','global_department_head_inc_mgnt'); ?></div>
									<div class="panel paneld">
										<div class="col-xs-12">

											<?php foreach ($depinci as $rip) { ?>
												<div class="checkboxreport">
													<label>
														<input type="checkbox" name="depinci[<?php echo $rip->dprt_id; ?>]" value="1" <?php if ($permission['depinci'][$rip->dprt_id] == 1) {
																																			echo 'checked';
																																		} ?> <?php if ($rip->email != $department->email) {
																																					if ($rip->email != NULL || $rip->email != '') {
																																						echo 'disabled';
																																					}
																																				}
																																				?>>
														<?php echo $rip->description; ?> (<span style="font-weight:norma; font-size:12px;"><?php echo $rip->email; ?></span>)
													</label>
												</div>
											<?php } ?>
										</div>
									</div>
								<?php } ?>

								<!-- gre -->
								<?php if (ismodule_active('GRIEVANCE') === true) { ?>
									<div class="accordion"><?php echo lang_loader('global','global_department_head_sg_tickets'); ?> </div>
									<div class="panel paneld">
										<div class="col-xs-12">
											<?php foreach ($depgrievance as $rip) { ?>
												<div class="checkboxreport">
													<label>
														<input type="checkbox" name="depgrievance[<?php echo $rip->dprt_id; ?>]" value="1" <?php if ($permission['depgrievance'][$rip->dprt_id] == 1) {
																																				echo 'checked';
																																			} ?> <?php if ($rip->email != $department->email) {
																																						if ($rip->email != NULL || $rip->email != '') {
																																							echo 'disabled';
																																						}
																																					}
																																					?>>
														<?php echo $rip->description; ?> (<span style="font-weight:norma; font-size:12px;"><?php echo $rip->email; ?></span>)
													</label>
												</div>
											<?php } ?>


										</div>
									</div>
								<?php } ?>


								<!-- gre -->

							</div>


							<div id="super_admin" <?php if ($permission['userrole'] == 'SuperAdmin') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>


								<!-- SMS Alerts start -->
								<div class="accordion"><?php echo lang_loader('global','global_sms_alert'); ?>:</div>
								<div class="panel paneld">
									<div class="col-lg-12">
										<?php if (ismodule_active('IP') === true) { ?>
											<h3><?php echo lang_loader('global','global_ip_module_sms'); ?></h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_ip" value="1" <?php if ($permission['message_ticket_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_all_tickets'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="inweeklyreport_ip" value="1" <?php if ($permission['inweeklyreport_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_feedback_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyipticketreport_ip" value="1" <?php if ($permission['weeklyipticketreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_ticket_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklynpsscore_ip" value="1" <?php if ($permission['weeklynpsscore_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_nps_report'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyiphospitalselection_ip" value="1" <?php if ($permission['weeklyiphospitalselection_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_hs_analysis'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyinsighthighlow_ip" value="1" <?php if ($permission['weeklyinsighthighlow_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_tl_perf_parameters'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyratinganalysis_ip" value="1" <?php if ($permission['weeklyratinganalysis_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_r_analysis'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="inmonthlyreport_ip" value="1" <?php if ($permission['inmonthlyreport_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_montly_f_report'); ?></label>
											</div>


											<div class="checkboxreport">
												<label><input type="checkbox" name="montlyipticketreport_ip" value="1" <?php if ($permission['montlyipticketreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_t_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlynpsscore_ip" value="1" <?php if ($permission['monthlynpsscore_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_nps_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="montylyiphospitalselection_ip" value="1" <?php if ($permission['montylyiphospitalselection_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_hs_analysis'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlyinsighthighlow_ip" value="1" <?php if ($permission['monthlyinsighthighlow_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_tl_perf_parameter'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlyratinganalysis_ip" value="1" <?php if ($permission['monthlyratinganalysis_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_r_analysis'); ?></label>
											</div>
										<?php } #OP SMS ALERTS 
										?>
										<?php if (ismodule_active('OP') === true) { ?>
											<h3><?php echo lang_loader('global','global_op_module_sms'); ?></h3>

											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_op" value="1" <?php if ($permission['message_ticket_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_all_tickets'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="inweeklyreport_op" value="1" <?php if ($permission['inweeklyreport_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_feedback_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyipticketreport_op" value="1" <?php if ($permission['weeklyipticketreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_ticket_report'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklynpsscore_op" value="1" <?php if ($permission['weeklynpsscore_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_nps_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyiphospitalselection_op" value="1" <?php if ($permission['weeklyiphospitalselection_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_hs_analysis'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyinsighthighlow_op" value="1" <?php if ($permission['weeklyinsighthighlow_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_tl_perf_parameters'); ?>.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyratinganalysis_op" value="1" <?php if ($permission['weeklyratinganalysis_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_r_analysis'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="inmonthlyreport_op" value="1" <?php if ($permission['inmonthlyreport_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_montly_f_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="montlyipticketreport_op" value="1" <?php if ($permission['montlyipticketreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_t_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlynpsscore_op" value="1" <?php if ($permission['monthlynpsscore_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_nps_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="montylyiphospitalselection_op" value="1" <?php if ($permission['montylyiphospitalselection_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_hs_analysis'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlyinsighthighlow_op" value="1" <?php if ($permission['monthlyinsighthighlow_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_tl_perf_parameter'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlyratinganalysis_op" value="1" <?php if ($permission['monthlyratinganalysis_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_r_analysis'); ?></label>
											</div>

										<?php } #OP SMS ALERTS 
										?>
										<?php if (ismodule_active('PCF') === true) { ?>
											<h3><?php echo lang_loader('global','global_pcf_sms'); ?></h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_int" value="1" <?php if ($permission['message_ticket_int'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_all_patient_complaints'); ?></label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('ISR') === true) { ?>
											<h3><?php echo lang_loader('global','global_isr_sms'); ?></h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_esr" value="1" <?php if ($permission['message_ticket_esr'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;<?php echo lang_loader('global','global_all_request_notification'); ?></label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('INCIDENT') === true) { ?>
											<h3><?php echo lang_loader('global','global_inc_sms'); ?></h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_incident" value="1" <?php if ($permission['message_ticket_incident'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_all_inc_notification'); ?></label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('GRIEVANCE') === true) { ?>
											<h3><?php echo lang_loader('global','global_sg_sms'); ?></h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_grievance" value="1" <?php if ($permission['message_ticket_grievance'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_all_grievance_notification'); ?></label>
											</div>
										<?php } ?>

									</div>
								</div>
								<!-- SMS Alerts end -->

								<!-- email Alerts start -->
								<div class="accordion"><?php echo lang_loader('global','global_email_alerts'); ?>:</div>
								<div class="panel paneld">
									<div class="col-lg-12">
										<?php if (ismodule_active('IP') === true) { ?>
											<h3><?php echo lang_loader('global','global_ip_module_email'); ?></h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_ticket_ip'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;<?php echo lang_loader('global','global_all_tickets'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_dailyticket_ip'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;<?php echo lang_loader('global','global_daily_open_ticket'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklyreport_ip" value="1" <?php if ($permission['email_weeklyreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_feedback_report'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklynpsreport_ip" value="1" <?php if ($permission['email_weeklynpsreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_nps_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklypatientreport_ip" value="1" <?php if ($permission['email_weeklypatientreport_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_hs_analysis'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlyreport_ip" value="1" <?php if ($permission['email_monthlyreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_montly_f_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlynpsreport_ip" value="1" <?php if ($permission['email_monthlynpsreport_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_nps_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlypatientreport_ip" value="1" <?php if ($permission['email_monthlypatientreport_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_hs_analysis'); ?></label>
											</div>

										<?php } ?>

										<?php if (ismodule_active('OP') === true) { ?>
											<h3><?php echo lang_loader('global','global_op_module_email'); ?></h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_op" value="1" <?php if ($permission['email_ticket_op'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;<?php echo lang_loader('global','global_all_tickets'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_dailyticket_op'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;<?php echo lang_loader('global','global_daily_open_ticket'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklyreport_op" value="1" <?php if ($permission['email_weeklyreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_feedback_report'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklynpsreport_op" value="1" <?php if ($permission['email_weeklynpsreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_nps_report'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklypatientreport_op" value="1" <?php if ($permission['email_weeklypatientreport_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_weekly_hs_analysis'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlyreport_op" value="1" <?php if ($permission['email_monthlyreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_montly_f_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlynpsreport_op" value="1" <?php if ($permission['email_monthlynpsreport_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_nps_report'); ?></label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlypatientreport_op" value="1" <?php if ($permission['email_monthlypatientreport_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;<?php echo lang_loader('global','global_monthly_hs_analysis'); ?></label>
											</div>

										<?php } ?>
										<?php if (ismodule_active('PCF') === true) { ?>
											<h3><?php echo lang_loader('global','global_pcf_email'); ?></h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_int" value="1" <?php if ($permission['email_ticket_int'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;<?php echo lang_loader('global','global_all_patient_complaints'); ?>.</label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('ISR') === true) { ?>

											<h3><?php echo lang_loader('global','global_isr_email'); ?></h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_esr" value="1" <?php if ($permission['email_ticket_esr'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;<?php echo lang_loader('global','global_all_request_notification'); ?></label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('INCIDENT') === true) { ?>
											<h3><?php echo lang_loader('global','global_inc_email'); ?></h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_incident" value="1" <?php if ($permission['email_ticket_incident'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_all_inc_notification'); ?></label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('GRIEVANCE') === true) { ?>
											<h3><?php echo lang_loader('global','global_sg_email'); ?></h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_grievance" value="1" <?php if ($permission['email_ticket_grievance'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;<?php echo lang_loader('global','global_all_grievance_notification'); ?></label>
											</div>
										<?php } ?>

									</div>
								</div>
							</div>


							<!-- Access Permissions start -->
							<?php if (ismodule_active('admissionsection') == true) { ?>
								<div id="addmeshon" <?php if ($permission['userrole'] == 'Admission Section') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
									<?php // if ($permission['userrole'] == 'Admission Section') { 
									?>
									<div class="accordion"><?php echo lang_loader('global','global_adf_section'); ?></div>
									<div class="panel paneld">
										<div class="col-xs-12">

											<div class="checkboxreport" style="display: none;">
												<label><input type="checkbox" name="frontoffice" value="1" <?php if ($permission['frontoffice'] == 1) {
																												echo 'checked';
																											} ?>>&nbsp;<?php echo lang_loader('global','global_patient_admission'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="coordinator" value="1" <?php if ($permission['coordinator'] == 1) {
																												echo 'checked';
																											} ?>>&nbsp;<?php echo lang_loader('global','global_patient_discharge'); ?></label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="admissionsection" value="1" <?php if ($permission['admissionsection'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;<?php echo lang_loader('global','global_all_access'); ?></label>
											</div>
										</div>
									</div>
									<?php	//} 
									?>
								</div>
							<?php } ?>






							<!-- email Alerts end -->

							<p>&nbsp;</p>


							<!-- reset and save start -->

							<div class="col-sm-offset-3 col-sm-6">
								<div class="ui buttons">
									<button type="reset" class="ui button"><?php echo display('reset') ?></button>
									<div class="or"></div>
									<button class="ui positive button"><?php echo display('save') ?></button>
								</div>
							</div>

							<!-- reset and save end -->

							<?php echo form_close() ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- form area end -->
</div>
</div>

<style>
	.accordion {
		background-color: #eee;
		color: #444;
		cursor: pointer;
		padding: 18px;
		width: 100%;
		border: none;
		text-align: left;
		outline: none;
		font-size: 15px;
		transition: 0.4s;
		font-weight: bold;
		border-bottom: 1px solid #ccc;
	}

	.active,
	.accordion:hover {
		background-color: #ccc;
	}

	.accordion:after {
		content: '\002B';
		color: #777;
		font-weight: bold;
		float: right;
		margin-left: 5px;
	}

	.active:after {
		content: "\2212";
	}

	.paneld {
		padding: 10px 18px;
		border: 1px solid #ccc;
		border-radius: 0px !important;
		min-height: 166px;
		overflow: hidden;
		display: none;
		transition: height 0.2s ease-out;

	}
</style>
<script>
	var acc = document.getElementsByClassName("accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			if (panel.style.display === "block") {
				panel.style.display = "none";
			} else {
				panel.style.display = "block";
				//$(this).parent().next().show();
			}
		});
	}

	function swithc_role(val) {
		if (val == 'Admin') {
			$('#admin_access').show();
			$('#department_head_div').hide(); // Hide Department Head div
			$('#department_head_div2').hide(); // Hide Department Head div
			$('#department_head').hide(); // Hide Department Head div
			$('#addmeshon').hide();
			$('#user_role').val(3);
		} else if (val == 'Admission Section') {
			$('#addmeshon').show();
			$('#admin_access').hide();
			$('#department_head').hide();
			$('#department_head_div').hide(); // Hide Department Head div
			$('#department_head_div2').hide(); // Hide Department Head div
			$('#user_role').val(5);
		} else if (val == 'Department Head') {
			$('#department_head_div').show();
			$('#department_head_div2').show();
			$('#department_head').show(); // Show Department Head div
			$('#admin_access').hide();
			$('#addmeshon').hide();
			$('#user_role').val(4);
		} else {
			$('#super_admin').show();
			$('#department_head').hide();
			$('#department_head_div').hide(); // Hide Department Head div
			$('#department_head_div2').hide(); // Hide Department Head div
			$('#user_role').val(2);
		}
		$('input:checkbox').attr('checked', false);
	}


	$(document).ready(function() {
		// List of module IDs
		var moduleIds = [
			"staff_grievance_module",
			"incident_module",
			"employee_experience_module",
			"internal_service_request",
			"outpatient_feedback",
			"inpatient_complaint",
			"inpatient_feedback",
			"admission_feedback"
		];

		// Function to toggle email and SMS sections
		function toggleSections(moduleId, isChecked) {
			var emailSectionId = "#" + moduleId + "_email";
			var smsSectionId = "#" + moduleId + "_sms";

			if (isChecked) {
				$(emailSectionId).show();
				$(smsSectionId).show();
			} else {
				$(emailSectionId).hide();
				$(smsSectionId).hide();
			}
		}

		// Check the state of each checkbox and set the visibility of sections on page load
		moduleIds.forEach(function(moduleId) {
			var isChecked = $("#" + moduleId).is(':checked');
			toggleSections(moduleId, isChecked);
		});

		// Attach change event listeners to checkboxes
		moduleIds.forEach(function(moduleId) {
			$("#" + moduleId).change(function() {
				toggleSections(moduleId, this.checked);
			});
		});
	});
</script>

<?php

/* unused code for
<!-- Department Heads Interim end -->

							<!--<div class="form-group row">
								<label for="name" class="col-xs-3 col-form-label">Access Permissions</label>
								<div class="col-xs-9">
									 <div class="checkboxreport">
										<label><input type="checkbox" name="ippermission" value="1" <?php if ($permission['ippermission'] == 1) {
																										echo 'checked';
																									} ?>>IP ACCESS</label>
									</div>
									<div class="checkboxreport">
										<label><input type="checkbox" name="oppermission" value="1" <?php if ($permission['oppermission'] == 1) {
																										echo 'checked';
																									} ?>>OP ACCESS</label>
									</div>
								   
								</div>
							</div>-->


							<!--<div class="form-group row">
								<label for="name" class="col-xs-3 col-form-label">SMS Alerts</label>
								<div class="col-xs-9">
									<div class="checkboxreport">
										<label><input type="checkbox" name="message_report_ip" value="1" <?php if ($permission['message_report_ip'] == 1) {
																												echo 'checked';
																											} ?>>Weekly Report IP</label>
									</div>
									<div class="checkboxreport">
										<label><input type="checkbox" name="message_report_op" value="1" <?php if ($permission['message_report_op'] == 1) {
																												echo 'checked';
																											} ?>>Weekly Report OP</label>
									</div>
									<div class="checkboxreport">
										<label><input type="checkbox" name="message_report_ticket_ip" value="1" <?php if ($permission['message_report_ticket_ip'] == 1) {
																													echo 'checked';
																												} ?>>Weekly Ticket IP</label>
									</div>
									<div class="checkboxreport">
										<label><input type="checkbox" name="message_report_ticket_op" value="1" <?php if ($permission['message_report_ticket_op'] == 1) {
																													echo 'checked';
																												} ?>>Weekly Ticket OP</label>
									</div>
									<div class="checkboxreport">
										<label><input type="checkbox" name="message_ticket_ip" value="1" <?php if ($permission['message_ticket_ip'] == 1) {
																												echo 'checked';
																											} ?>>IP Ticket Alert</label>
									</div>
									<div class="checkboxreport">
										<label><input type="checkbox" name="message_ticket_op" value="1" <?php if ($permission['message_ticket_op'] == 1) {
																												echo 'checked';
																											} ?>>OP Ticket Alert</label>
									</div>
									
								</div>
							</div>-->

							<!--<div class="form-group row">
								<label for="name" class="col-xs-3 col-form-label">Email Alerts </label>
								<div class="col-xs-9">
									<div class="checkboxreport">
										<label><input type="checkbox" name="email_report_ip" value="1" <?php if ($permission['email_report_ip'] == 1) {
																											echo 'checked';
																										} ?>>Weekly Report IP</label>
									</div>
									<div class="checkboxreport">
										<label><input type="checkbox" name="email_report_op" value="1" <?php if ($permission['email_report_op'] == 1) {
																											echo 'checked';
																										} ?>>Weekly Report OP</label>
									</div>
									<div class="checkboxreport">
										<label><input type="checkbox" name="email_report_ticket_ip" value="1" <?php if ($permission['email_report_ticket_ip'] == 1) {
																													echo 'checked';
																												} ?>>Weekly Ticket IP</label>
									</div>
									<div class="checkboxreport">
										<label><input type="checkbox" name="email_report_ticket_op" value="1" <?php if ($permission['email_report_ticket_op'] == 1) {
																													echo 'checked';
																												} ?>>Weekly Ticket OP</label>
									</div>
									<div class="checkboxreport">
										<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_ticket_ip'] == 1) {
																											echo 'checked';
																										} ?>>IP Ticket Alert</label>
									</div>
									<div class="checkboxreport">
										<label><input type="checkbox" name="email_ticket_op" value="1" <?php if ($permission['email_ticket_op'] == 1) {
																											echo 'checked';
																										} ?>>OP Ticket Alert</label>
									</div>
								</div>
							</div>-->




							<!--<div class="form-group row">
								<label for="name" class="col-xs-3 col-form-label">Department Heads IP</label>
								<div class="col-xs-9">
									<?php foreach ($depip as $rip) { ?>
								   <div class="checkboxreport">
										<label><input type="checkbox" name="depip[<?php echo $rip->dprt_id; ?>]" value="1" <?php if ($permission['depip'][$rip->dprt_id] == 1) {
																																echo 'checked';
																															} ?>
										<?php if ($rip->email != $department->email) {
											if ($rip->email != NULL || $rip->email != '') {
												echo 'disabled';
											}
										}
										?>
										
										
										><?php echo $rip->description; ?> (<span style="font-weight:norma; font-size:12px;"><?php echo $rip->email; ?></span>)</label>
									</div>
									<?php } ?>
									
									
								</div>
							</div>-->

							<!--<div class="form-group row">
								<label for="name" class="col-xs-3 col-form-label">Department Heads OP</label>
								<div class="col-xs-9">
								   <?php foreach ($depop as $rip) { ?>
								   <div class="checkboxreport">
										<label>
											<input type="checkbox"  name="depop[<?php echo $rip->dprt_id; ?>]" value="1" 
												<?php if ($permission['depop'][$rip->dprt_id] == 1) {
													echo 'checked';
												} ?>
												<?php if ($rip->email != $department->email) {
													if ($rip->email != NULL || $rip->email != '') {
														echo 'disabled';
													}
												}
												?>
											>
												<?php echo $rip->description; ?> (<span style="font-weight:norma; font-size:12px;"><?php echo $rip->email; ?></span>)
										</label>
									</div>
									<?php } ?>
								</div>
							</div>-->

*/ ?>