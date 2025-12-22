<!-- This page is used to add users -->
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
						<a class="btn btn-success" href="<?php echo base_url("users") ?>"> <i class="fa fa-list"></i> User List </a>
					</div>
				</div>
				<!-- user list button end-->

				<div class="panel-body panel-form">
					<div class="row">
						<div class="col-md-8 col-sm-12 col-lg-12">

							<?php echo form_open('users/create', 'class="form-inner"')  ?>
							<?php echo form_hidden('ids', $department->user_id) ?>
							<?php $permission = json_decode($department->departmentpermission, true);   ?>
							<!-- Name start-->
							<div class="form-group row">
								<label for="name" class="col-xs-3 col-form-label">Name <i class="text-danger">*</i></label>
								<div class="col-xs-9">
									<input name="name" type="text" class="form-control" id="name" autocomplete="off" placeholder="Name" value="<?php echo $department->firstname; ?>" required>
								</div>
							</div>
							<!-- Name end-->

							<!-- Email start-->
							<div class="form-group row">
								<label for="email" class="col-xs-3 col-form-label">Email <i class="text-danger">*</i></label>
								<div class="col-xs-9">
									<input name="email" type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $department->email ?>" autocomplete="off" required>
								</div>
							</div>
							<!-- Email end-->

							<!-- Phone Number start -->
							<div class="form-group row">
								<label for="mobile" class="col-xs-3 col-form-label">Mobile </label>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="mobile" name="mobile" pattern="[0-9]{10}" maxlength="10" placeholder="Mobile Number" value="<?php echo $department->mobile; ?>" autocomplete="off" required>
								</div>
							</div>
							<!-- Phone Number end -->

							<!-- Password start -->
							<div class="form-group row" id="show_hide_password">
								<label for="name" class="col-xs-3 col-form-label">Password <i class="text-danger">*</i></label>
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
									<label for="name" class="col-xs-3 col-form-label">User Role <i class="text-danger">*</i></label>
									<div class="col-xs-9">
										<select class="form-control" id="sel1" name="userrole" onchange="swithc_role(this.value)" style="border-radius:0px;" required>
											<option value="">Select Role</option>

											<option value="Admin" <?php if ($permission['userrole'] == 'Admin') {
																		echo 'selected';
																	} ?>>Admin</option>
											<option value="Department Head" <?php if ($permission['userrole'] == 'Department Head') {
																				echo 'selected';
																			} ?>>Department Head</option>
											<?php if (ismodule_active('admissionsection') == true) { ?>
												<option value="Admission Section" <?php if ($permission['userrole'] == 'Admission Section') {
																						echo 'selected';
																					} ?>>Admission Section</option>
											<?php }	?>
										</select>
									</div>
								</div>
							<?php } else { ?>
								<div class="form-group row" style="display:none;">
									<label for="name" class="col-xs-3 col-form-label">User Role <i class="text-danger">*</i></label>
									<div class="col-xs-9">
										<select class="form-control" id="sel1" name="userrole" style="border-radius:0px;" required>
											<option value="SuperAdmin" selected>SuperAdmin</option>
										</select>
									</div>
								</div>
							<?php } ?>
							<!-- user role end -->
							<?php if ($this->session->userdata('user_role') == 0) { ?>

								<div class="form-group row" style="display:none;">
									<label for="name" class="col-xs-3 col-form-label">User Role <i class="text-danger">*</i></label>
									<div class="col-xs-9">
										<select class="form-control" id="sel1" name="userrole" style="border-radius:0px;" required>
											<option value="SuperAdmin" selected>SuperAdmin</option>
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


							<?php


							?>

							<div id="super_admin" <?php if ($permission['userrole'] == 'SuperAdmin') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>


								<!-- SMS Alerts start -->
								<div class="accordion">SMS ALERTS:</div>
								<div class="panel paneld">
									<div class="col-lg-12">
										<?php if (ismodule_active('IP') === true) { ?>
											<h3>INPATIENT MODULE SMS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_ip" value="1" <?php if ($permission['message_ticket_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;All Tickets.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="inweeklyreport_ip" value="1" <?php if ($permission['inweeklyreport_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Weekly Feedbacks Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyipticketreport_ip" value="1" <?php if ($permission['weeklyipticketreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Tickets Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklynpsscore_ip" value="1" <?php if ($permission['weeklynpsscore_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Weekly NPS Report.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyiphospitalselection_ip" value="1" <?php if ($permission['weeklyiphospitalselection_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Weekly Hospital Selection Analysis.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyinsighthighlow_ip" value="1" <?php if ($permission['weeklyinsighthighlow_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Top & Least Performing Parameters</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyratinganalysis_ip" value="1" <?php if ($permission['weeklyratinganalysis_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Rating Analysis.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="inmonthlyreport_ip" value="1" <?php if ($permission['inmonthlyreport_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Monthly Feedbacks Report.</label>
											</div>


											<div class="checkboxreport">
												<label><input type="checkbox" name="montlyipticketreport_ip" value="1" <?php if ($permission['montlyipticketreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Tickets Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlynpsscore_ip" value="1" <?php if ($permission['monthlynpsscore_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Monthly NPS Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="montylyiphospitalselection_ip" value="1" <?php if ($permission['montylyiphospitalselection_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Hospital Selection Analysis.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlyinsighthighlow_ip" value="1" <?php if ($permission['monthlyinsighthighlow_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Top & Least Performing Parameters.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlyratinganalysis_ip" value="1" <?php if ($permission['monthlyratinganalysis_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Rating Analysis.</label>
											</div>
										<?php } #OP SMS ALERTS 
										?>
										<?php if (ismodule_active('OP') === true) { ?>
											<h3>OUTPATIENT MODULE SMS</h3>

											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_op" value="1" <?php if ($permission['message_ticket_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;All Tickets.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="inweeklyreport_op" value="1" <?php if ($permission['inweeklyreport_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Weekly Feedbacks Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyipticketreport_op" value="1" <?php if ($permission['weeklyipticketreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Tickets Report.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklynpsscore_op" value="1" <?php if ($permission['weeklynpsscore_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Weekly NPS Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyiphospitalselection_op" value="1" <?php if ($permission['weeklyiphospitalselection_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Weekly Hospital Selection Analysis.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyinsighthighlow_op" value="1" <?php if ($permission['weeklyinsighthighlow_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Top & Least Performing Parameters.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyratinganalysis_op" value="1" <?php if ($permission['weeklyratinganalysis_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Rating Analysis.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="inmonthlyreport_op" value="1" <?php if ($permission['inmonthlyreport_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Monthly Feedbacks Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="montlyipticketreport_op" value="1" <?php if ($permission['montlyipticketreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Tickets Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlynpsscore_op" value="1" <?php if ($permission['monthlynpsscore_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Monthly NPS Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="montylyiphospitalselection_op" value="1" <?php if ($permission['montylyiphospitalselection_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Hospital Selection Analysis.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlyinsighthighlow_op" value="1" <?php if ($permission['monthlyinsighthighlow_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Top & Least Performing Parameters.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlyratinganalysis_op" value="1" <?php if ($permission['monthlyratinganalysis_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Rating Analysis.</label>
											</div>

										<?php } #OP SMS ALERTS 
										?>
										<?php if (ismodule_active('PCF') === true) { ?>
											<h3>PATIENT COMPLAINT SMS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_int" value="1" <?php if ($permission['message_ticket_int'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;All Patient Complaints</label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('ISR') === true) { ?>
											<h3>INTERNAL SERVICE SMS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_esr" value="1" <?php if ($permission['message_ticket_esr'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;All Request Notification</label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('INCIDENT') === true) { ?>
											<h3>INCIDENT SMS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_incident" value="1" <?php if ($permission['message_ticket_incident'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;All Incident Notification</label>
											</div>
										<?php } ?>

									</div>
								</div>
								<!-- SMS Alerts end -->

								<!-- email Alerts start -->
								<div class="accordion">EMAIL ALERTS:</div>
								<div class="panel paneld">
									<div class="col-lg-12">
										<?php if (ismodule_active('IP') === true) { ?>
											<h3>INPATIENT MODULE EMAILS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_ticket_ip'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;All Tickets.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_dailyticket_ip'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;Daily Open Tickets.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklyreport_ip" value="1" <?php if ($permission['email_weeklyreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Feedbacks Report.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklynpsreport_ip" value="1" <?php if ($permission['email_weeklynpsreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly NPS Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklypatientreport_ip" value="1" <?php if ($permission['email_weeklypatientreport_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Weekly Hospital Selection Analysis.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlyreport_ip" value="1" <?php if ($permission['email_monthlyreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Feedbacks Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlynpsreport_ip" value="1" <?php if ($permission['email_monthlynpsreport_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Monthly NPS Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlypatientreport_ip" value="1" <?php if ($permission['email_monthlypatientreport_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Hospital Selection Analysis.</label>
											</div>

										<?php } ?>

										<?php if (ismodule_active('OP') === true) { ?>
											<h3>OUTPATIENT MODULE EMAILS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_op" value="1" <?php if ($permission['email_ticket_op'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;All Tickets.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_dailyticket_op'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;Daily Open Tickets.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklyreport_op" value="1" <?php if ($permission['email_weeklyreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Feedbacks Report.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklynpsreport_op" value="1" <?php if ($permission['email_weeklynpsreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly NPS Report.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklypatientreport_op" value="1" <?php if ($permission['email_weeklypatientreport_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Weekly Hospital Selection Analysis.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlyreport_op" value="1" <?php if ($permission['email_monthlyreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Feedbacks Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlynpsreport_op" value="1" <?php if ($permission['email_monthlynpsreport_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Monthly NPS Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlypatientreport_op" value="1" <?php if ($permission['email_monthlypatientreport_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Hospital Selection Analysis.</label>
											</div>

										<?php } ?>
										<?php if (ismodule_active('PCF') === true) { ?>
											<h3>PATIENT COMPLAINT EMAILS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_int" value="1" <?php if ($permission['email_ticket_int'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;All Patient Complaints.</label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('ISR') === true) { ?>

											<h3>INTERNAL SERVICE EMAIL</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_esr" value="1" <?php if ($permission['email_ticket_esr'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;All Request Notification</label>
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
									<div class="accordion">ADMISSION SECTION</div>
									<div class="panel paneld">
										<div class="col-xs-12">

											<div class="checkboxreport" style="display: none;">
												<label><input type="checkbox" name="frontoffice" value="1" <?php if ($permission['frontoffice'] == 1) {
																												echo 'checked';
																											} ?>>&nbsp;PATIENT ADMISSION</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="coordinator" value="1" <?php if ($permission['coordinator'] == 1) {
																												echo 'checked';
																											} ?>>&nbsp;PATIENT DISCHARGE</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="admissionsection" value="1" <?php if ($permission['admissionsection'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;ALL ACCESS</label>
											</div>
										</div>
									</div>
									<?php	//} 
									?>
								</div>
							<?php	} ?>

							<!-- Access Permissions start -->
							<?php // if ($permission['userrole'] == 'Admin') { 
							?>
							<div id="admin_access" <?php if ($permission['userrole'] == 'Admin') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>


								<div class="accordion">FEEDBACK/REPORT DASHBOARD ACCESS:</div>
								<div class="panel paneld">


									<div class="col-xs-12">

										<?php if (ismodule_active('ADF') === true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" name="adfpermission" value="1" <?php if ($permission['adfpermission'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;ADMISSION FEEDBACK MODULE</label>
											</div>
										<?php } ?>

										<?php if (ismodule_active('IP') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" name="ippermission" data-toggle="modal" data-target="#languageModal_ip" value="1" <?php if ($permission['ippermission'] == 1) {
																																									echo 'checked';
																																								} ?>>&nbsp;INPATIENT FEEDBACK MODULE</label>
											</div>
										<?php } ?>

										<?php if (ismodule_active('PCF') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" name="inpermission" data-toggle="modal" data-target="#languageModal_int" value="1" <?php if ($permission['inpermission'] == 1) {
																																										echo 'checked';
																																									} ?>>&nbsp;INPATIENT COMPLAINTS MODULE</label>
											</div>
										<?php } ?>

										<?php if (ismodule_active('OP') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" name="oppermission" data-toggle="modal" data-target="#languageModal_op" value="1" <?php if ($permission['oppermission'] == 1) {
																																									echo 'checked';
																																								} ?>>&nbsp;OUTPATIENT FEEDBACK MODULE</label>
											</div>
										<?php } ?>

										<?php if (ismodule_active('psr_page') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" name="psrpermission" value="1" <?php if ($permission['psrpermission'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;PATIENT SERVICE REQUEST MODULE</label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('ISR') == true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" name="esrpermission" data-toggle="modal" data-target="#languageModal_esr" value="1" <?php if ($permission['esrpermission'] == 1) {
																																										echo 'checked';
																																									} ?>>&nbsp;INTERNAL SERVICE REQUEST MODULE</label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('empex_page') === true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" name="empexpermission" value="1" <?php if ($permission['empexpermission'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;EMPLOYEE EXPERIENCE MODULE</label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('INCIDENT') === true) { ?>
											<div class="checkboxreport">
												<label><input type="checkbox" name="incidentpermission" data-toggle="modal" data-target="#languageModal_incident" value="1" <?php if ($permission['incidentpermission'] == 1) {
																																												echo 'checked';
																																											} ?>>&nbsp;INCIDENT MODULE</label>
											</div>
										<?php } ?>

									</div>
								</div>
								<!-- Access Permissions end -->
								<div class="modal fade" id="languageModal_ip" tabindex="-1" role="dialog" aria-labelledby="languageModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">

												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<!-- Place your language selection options here -->
												<?php if (ismodule_active('IP') === true) { ?>


													<h3>INPATIENT MODULE SMS</h3>
													<div class="checkboxreport">
														<label><input type="checkbox" name="message_ticket_ip" value="1" <?php if ($permission['message_ticket_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;All Tickets.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="inweeklyreport_ip" value="1" <?php if ($permission['inweeklyreport_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Weekly Feedbacks Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="weeklyipticketreport_ip" value="1" <?php if ($permission['weeklyipticketreport_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Weekly Tickets Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="weeklynpsscore_ip" value="1" <?php if ($permission['weeklynpsscore_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Weekly NPS Report.</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="weeklyiphospitalselection_ip" value="1" <?php if ($permission['weeklyiphospitalselection_ip'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;Weekly Hospital Selection Analysis.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="weeklyinsighthighlow_ip" value="1" <?php if ($permission['weeklyinsighthighlow_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Weekly Top & Least Performing Parameters</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="weeklyratinganalysis_ip" value="1" <?php if ($permission['weeklyratinganalysis_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Weekly Rating Analysis.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="inmonthlyreport_ip" value="1" <?php if ($permission['inmonthlyreport_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Monthly Feedbacks Report.</label>
													</div>


													<div class="checkboxreport">
														<label><input type="checkbox" name="montlyipticketreport_ip" value="1" <?php if ($permission['montlyipticketreport_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Tickets Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="monthlynpsscore_ip" value="1" <?php if ($permission['monthlynpsscore_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Monthly NPS Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="montylyiphospitalselection_ip" value="1" <?php if ($permission['montylyiphospitalselection_ip'] == 1) {
																																			echo 'checked';
																																		} ?>>&nbsp;Monthly Hospital Selection Analysis.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="monthlyinsighthighlow_ip" value="1" <?php if ($permission['monthlyinsighthighlow_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Top & Least Performing Parameters.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="monthlyratinganalysis_ip" value="1" <?php if ($permission['monthlyratinganalysis_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Rating Analysis.</label>
													</div>
												<?php } #OP SMS ALERTS 
												?>

												<?php if (ismodule_active('IP') === true) { ?>
													<h3>INPATIENT MODULE EMAILS</h3>
													<div class="checkboxreport">
														<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_ticket_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;All Tickets.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_dailyticket_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Daily Open Tickets.</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="email_weeklyreport_ip" value="1" <?php if ($permission['email_weeklyreport_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Weekly Feedbacks Report.</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="email_weeklynpsreport_ip" value="1" <?php if ($permission['email_weeklynpsreport_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Weekly NPS Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="email_weeklypatientreport_ip" value="1" <?php if ($permission['email_weeklypatientreport_ip'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;Weekly Hospital Selection Analysis.</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="email_monthlyreport_ip" value="1" <?php if ($permission['email_monthlyreport_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Feedbacks Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="email_monthlynpsreport_ip" value="1" <?php if ($permission['email_monthlynpsreport_ip'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;Monthly NPS Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="email_monthlypatientreport_ip" value="1" <?php if ($permission['email_monthlypatientreport_ip'] == 1) {
																																			echo 'checked';
																																		} ?>>&nbsp;Monthly Hospital Selection Analysis.</label>
													</div>

												<?php } ?>

											</div>
										</div>
									</div>
								</div>
								<div class="modal fade" id="languageModal_op" tabindex="-1" role="dialog" aria-labelledby="languageModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">

												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<!-- Place your language selection options here -->
												<?php if (ismodule_active('OP') === true) { ?>
													<h3>OUTPATIENT MODULE SMS</h3>

													<div class="checkboxreport">
														<label><input type="checkbox" name="message_ticket_op" value="1" <?php if ($permission['message_ticket_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;All Tickets.</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="inweeklyreport_op" value="1" <?php if ($permission['inweeklyreport_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Weekly Feedbacks Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="weeklyipticketreport_op" value="1" <?php if ($permission['weeklyipticketreport_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Weekly Tickets Report.</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="weeklynpsscore_op" value="1" <?php if ($permission['weeklynpsscore_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Weekly NPS Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="weeklyiphospitalselection_op" value="1" <?php if ($permission['weeklyiphospitalselection_op'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;Weekly Hospital Selection Analysis.</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="weeklyinsighthighlow_op" value="1" <?php if ($permission['weeklyinsighthighlow_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Weekly Top & Least Performing Parameters.</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="weeklyratinganalysis_op" value="1" <?php if ($permission['weeklyratinganalysis_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Weekly Rating Analysis.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="inmonthlyreport_op" value="1" <?php if ($permission['inmonthlyreport_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Monthly Feedbacks Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="montlyipticketreport_op" value="1" <?php if ($permission['montlyipticketreport_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Tickets Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="monthlynpsscore_op" value="1" <?php if ($permission['monthlynpsscore_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Monthly NPS Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="montylyiphospitalselection_op" value="1" <?php if ($permission['montylyiphospitalselection_op'] == 1) {
																																			echo 'checked';
																																		} ?>>&nbsp;Monthly Hospital Selection Analysis.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="monthlyinsighthighlow_op" value="1" <?php if ($permission['monthlyinsighthighlow_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Top & Least Performing Parameters.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="monthlyratinganalysis_op" value="1" <?php if ($permission['monthlyratinganalysis_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Rating Analysis.</label>
													</div>

												<?php } #OP SMS ALERTS 
												?>

												<?php if (ismodule_active('OP') === true) { ?>
													<h3>OUTPATIENT MODULE EMAILS</h3>
													<div class="checkboxreport">
														<label><input type="checkbox" name="email_ticket_op" value="1" <?php if ($permission['email_ticket_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;All Tickets.</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_dailyticket_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Daily Open Tickets.</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="email_weeklyreport_op" value="1" <?php if ($permission['email_weeklyreport_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Weekly Feedbacks Report.</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="email_weeklynpsreport_op" value="1" <?php if ($permission['email_weeklynpsreport_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Weekly NPS Report.</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="email_weeklypatientreport_op" value="1" <?php if ($permission['email_weeklypatientreport_op'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;Weekly Hospital Selection Analysis.</label>
													</div>
													<div class="checkboxreport">
														<label><input type="checkbox" name="email_monthlyreport_op" value="1" <?php if ($permission['email_monthlyreport_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Feedbacks Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="email_monthlynpsreport_op" value="1" <?php if ($permission['email_monthlynpsreport_op'] == 1) {
																																		echo 'checked';
																																	} ?>>&nbsp;Monthly NPS Report.</label>
													</div>

													<div class="checkboxreport">
														<label><input type="checkbox" name="email_monthlypatientreport_op" value="1" <?php if ($permission['email_monthlypatientreport_op'] == 1) {
																																			echo 'checked';
																																		} ?>>&nbsp;Monthly Hospital Selection Analysis.</label>
													</div>

												<?php } ?>


											
											</div>
										</div>
									</div>
								</div>
								<div class="modal fade" id="languageModal_int" tabindex="-1" role="dialog" aria-labelledby="languageModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">

												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<!-- Place your language selection options here -->
												<?php if (ismodule_active('PCF') === true) { ?>
													<h3>PATIENT COMPLAINT SMS</h3>
													<div class="checkboxreport">
														<label><input type="checkbox" name="message_ticket_int" value="1" <?php if ($permission['message_ticket_int'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;All Patient Complaints</label>
													</div>
												<?php } ?>

												<?php if (ismodule_active('PCF') === true) { ?>
													<h3>PATIENT COMPLAINT EMAILS</h3>
													<div class="checkboxreport">
														<label><input type="checkbox" name="email_ticket_int" value="1" <?php if ($permission['email_ticket_int'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;All Patient Complaints.</label>
													</div>
												<?php } ?>
												
											</div>
										</div>
									</div>
								</div>
								<div class="modal fade" id="languageModal_esr" tabindex="-1" role="dialog" aria-labelledby="languageModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">

												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<!-- Place your language selection options here -->
												<?php if (ismodule_active('ISR') === true) { ?>
													<h3>INTERNAL SERVICE SMS</h3>
													<div class="checkboxreport">
														<label><input type="checkbox" name="message_ticket_esr" value="1" <?php if ($permission['message_ticket_esr'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;All Request Notification</label>
													</div>
												<?php } ?>
												<?php if (ismodule_active('ISR') === true) { ?>
													<h3>INTERNAL SERVICE EMAILS</h3>
													<div class="checkboxreport">
														<label><input type="checkbox" name="email_ticket_esr" value="1" <?php if ($permission['email_ticket_esr'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;All Request Notification</label>
													</div>
												<?php } ?>


												<!-- reset and save start -->

												<div style="text-align:center;">
													<div class="ui buttons">
														<button type="reset" class="ui button"><?php echo 'Reset' ; ?></button>
														<div class="or"></div>
														<button class="ui positive button"><?php echo 'Save' ; ?></button>
													</div>
												</div>

												<!-- reset and save end -->
											</div>
										</div>
									</div>
								</div>
								<div class="modal fade" id="languageModal_incident" tabindex="-1" role="dialog" aria-labelledby="languageModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">

												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<!-- Place your language selection options here -->

												<?php if (ismodule_active('INCIDENT') === true) { ?>
													<h3>INCIDENT SMS</h3>
													<div class="checkboxreport">
														<label><input type="checkbox" name="message_ticket_incident" value="1" <?php if ($permission['message_ticket_incident'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;All Incident Notification</label>
													</div>
												<?php } ?>

												<?php if (ismodule_active('INCIDENT') === true) { ?>
													<h3>INCIDENT EMAILS</h3>
													<div class="checkboxreport">
														<label><input type="checkbox" name="email_ticket_incident" value="1" <?php if ($permission['email_ticket_incident'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;All Incident Notification</label>
													</div>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								<!-- SMS Alerts start -->
								<!-- <div class="accordion">SMS ALERTS:</div>
								<div class="panel paneld">
									<div class="col-lg-12">
										<?php if (ismodule_active('IP') === true) { ?>
											<h3>INPATIENT MODULE SMS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_ip" value="1" <?php if ($permission['message_ticket_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;All Tickets.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="inweeklyreport_ip" value="1" <?php if ($permission['inweeklyreport_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Weekly Feedbacks Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyipticketreport_ip" value="1" <?php if ($permission['weeklyipticketreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Tickets Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklynpsscore_ip" value="1" <?php if ($permission['weeklynpsscore_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Weekly NPS Report.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyiphospitalselection_ip" value="1" <?php if ($permission['weeklyiphospitalselection_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Weekly Hospital Selection Analysis.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyinsighthighlow_ip" value="1" <?php if ($permission['weeklyinsighthighlow_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Top & Least Performing Parameters</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyratinganalysis_ip" value="1" <?php if ($permission['weeklyratinganalysis_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Rating Analysis.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="inmonthlyreport_ip" value="1" <?php if ($permission['inmonthlyreport_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Monthly Feedbacks Report.</label>
											</div>


											<div class="checkboxreport">
												<label><input type="checkbox" name="montlyipticketreport_ip" value="1" <?php if ($permission['montlyipticketreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Tickets Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlynpsscore_ip" value="1" <?php if ($permission['monthlynpsscore_ip'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Monthly NPS Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="montylyiphospitalselection_ip" value="1" <?php if ($permission['montylyiphospitalselection_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Hospital Selection Analysis.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlyinsighthighlow_ip" value="1" <?php if ($permission['monthlyinsighthighlow_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Top & Least Performing Parameters.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlyratinganalysis_ip" value="1" <?php if ($permission['monthlyratinganalysis_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Rating Analysis.</label>
											</div>
										<?php } #OP SMS ALERTS 
										?>
										<?php if (ismodule_active('OP') === true) { ?>
											<h3>OUTPATIENT MODULE SMS</h3>

											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_op" value="1" <?php if ($permission['message_ticket_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;All Tickets.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="inweeklyreport_op" value="1" <?php if ($permission['inweeklyreport_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Weekly Feedbacks Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyipticketreport_op" value="1" <?php if ($permission['weeklyipticketreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Tickets Report.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklynpsscore_op" value="1" <?php if ($permission['weeklynpsscore_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Weekly NPS Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyiphospitalselection_op" value="1" <?php if ($permission['weeklyiphospitalselection_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Weekly Hospital Selection Analysis.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyinsighthighlow_op" value="1" <?php if ($permission['weeklyinsighthighlow_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Top & Least Performing Parameters.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="weeklyratinganalysis_op" value="1" <?php if ($permission['weeklyratinganalysis_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Rating Analysis.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="inmonthlyreport_op" value="1" <?php if ($permission['inmonthlyreport_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Monthly Feedbacks Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="montlyipticketreport_op" value="1" <?php if ($permission['montlyipticketreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Tickets Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlynpsscore_op" value="1" <?php if ($permission['monthlynpsscore_op'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;Monthly NPS Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="montylyiphospitalselection_op" value="1" <?php if ($permission['montylyiphospitalselection_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Hospital Selection Analysis.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlyinsighthighlow_op" value="1" <?php if ($permission['monthlyinsighthighlow_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Top & Least Performing Parameters.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="monthlyratinganalysis_op" value="1" <?php if ($permission['monthlyratinganalysis_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Rating Analysis.</label>
											</div>

										<?php } #OP SMS ALERTS 
										?>
										<?php if (ismodule_active('PCF') === true) { ?>
											<h3>PATIENT COMPLAINT SMS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_int" value="1" <?php if ($permission['message_ticket_int'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;All Patient Complaints</label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('ISR') === true) { ?>
											<h3>INTERNAL SERVICE SMS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_esr" value="1" <?php if ($permission['message_ticket_esr'] == 1) {
																														echo 'checked';
																													} ?>>&nbsp;All Request Notification</label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('INCIDENT') === true) { ?>
											<h3>INCIDENT SMS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="message_ticket_incident" value="1" <?php if ($permission['message_ticket_incident'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;All Incident Notification</label>
											</div>
										<?php } ?>

									</div>
								</div> -->
								<!-- SMS Alerts end -->

								<!-- email Alerts start -->
								<!-- <div class="accordion">EMAIL ALERTS:</div>
								<div class="panel paneld">
									<div class="col-lg-12">
										<?php if (ismodule_active('IP') === true) { ?>
											<h3>INPATIENT MODULE EMAILS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_ticket_ip'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;All Tickets.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_dailyticket_ip'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;Daily Open Tickets.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklyreport_ip" value="1" <?php if ($permission['email_weeklyreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Feedbacks Report.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklynpsreport_ip" value="1" <?php if ($permission['email_weeklynpsreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly NPS Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklypatientreport_ip" value="1" <?php if ($permission['email_weeklypatientreport_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Weekly Hospital Selection Analysis.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlyreport_ip" value="1" <?php if ($permission['email_monthlyreport_ip'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Feedbacks Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlynpsreport_ip" value="1" <?php if ($permission['email_monthlynpsreport_ip'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Monthly NPS Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlypatientreport_ip" value="1" <?php if ($permission['email_monthlypatientreport_ip'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Hospital Selection Analysis.</label>
											</div>

										<?php } ?>

										<?php if (ismodule_active('OP') === true) { ?>
											<h3>OUTPATIENT MODULE EMAILS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_op" value="1" <?php if ($permission['email_ticket_op'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;All Tickets.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission['email_dailyticket_op'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;Daily Open Tickets.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklyreport_op" value="1" <?php if ($permission['email_weeklyreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly Feedbacks Report.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklynpsreport_op" value="1" <?php if ($permission['email_weeklynpsreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Weekly NPS Report.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_weeklypatientreport_op" value="1" <?php if ($permission['email_weeklypatientreport_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Weekly Hospital Selection Analysis.</label>
											</div>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlyreport_op" value="1" <?php if ($permission['email_monthlyreport_op'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;Monthly Feedbacks Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlynpsreport_op" value="1" <?php if ($permission['email_monthlynpsreport_op'] == 1) {
																																echo 'checked';
																															} ?>>&nbsp;Monthly NPS Report.</label>
											</div>

											<div class="checkboxreport">
												<label><input type="checkbox" name="email_monthlypatientreport_op" value="1" <?php if ($permission['email_monthlypatientreport_op'] == 1) {
																																	echo 'checked';
																																} ?>>&nbsp;Monthly Hospital Selection Analysis.</label>
											</div>

										<?php } ?>
										<?php if (ismodule_active('PCF') === true) { ?>
											<h3>PATIENT COMPLAINT EMAILS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_int" value="1" <?php if ($permission['email_ticket_int'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;All Patient Complaints.</label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('ISR') === true) { ?>
											<h3>INTERNAL SERVICE EMAILS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_esr" value="1" <?php if ($permission['email_ticket_esr'] == 1) {
																													echo 'checked';
																												} ?>>&nbsp;All Request Notification</label>
											</div>
										<?php } ?>
										<?php if (ismodule_active('INCIDENT') === true) { ?>
											<h3>INCIDENT EMAILS</h3>
											<div class="checkboxreport">
												<label><input type="checkbox" name="email_ticket_incident" value="1" <?php if ($permission['email_ticket_incident'] == 1) {
																															echo 'checked';
																														} ?>>&nbsp;All Incident Notification</label>
											</div>
										<?php } ?>

									</div>
								</div> -->
							</div>
							<?php	// } 
							?>

							<!-- email Alerts end -->

							<!-- Department Heads InPatient start -->
							<?php // if ($permission['userrole'] == 'Department Head') { 
							?>
							<div id="department_head" <?php if ($permission['userrole'] == 'Department Head') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
								<?php if (ismodule_active('ADF') === true) { ?>
									<!-- Department Heads ADMISSION start -->
									<div class="accordion">DEPARTMENT HEAD- ADMISSION TICKETS</div>
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
									<div class="accordion">DEPARTMENT HEAD- INPATIENT FEEDBACK TICKETS </div>
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
								<!-- Department Heads InPatient end -->


								<?php if (ismodule_active('OP') === true) { ?>
									<!-- Department Heads OutPatient start -->
									<div class="accordion">DEPARTMENT HEAD- OUTPATIENT FEEDBACK TICKETS </div>
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

									<div class="accordion">DEPARTMENT HEAD- INPATIENT COMPLAINT TICKETS </div>
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

									<div class="accordion">DEPARTMENT HEAD- PATIENT SERVICE REQUEST</div>
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

									<div class="accordion">DEPARTMENT HEAD- INTERNAL SERVICE REQUEST</div>
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

									<div class="accordion">DEPARTMENT HEAD- EMPLOYEE EXPERIENCE</div>
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

									<div class="accordion">DEPARTMENT HEAD- INCIDENT MANAGEMENT</div>
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
							</div>
							<?php // } 
							?>

							<p>&nbsp;</p>


							<!-- reset and save start -->

							<div class="col-sm-offset-3 col-sm-6">
								<div class="ui buttons">
									<button type="reset" class="ui button"><?php echo 'Reset' ;
																			?></button>
									<div class="or"></div>
									<button class="ui positive button"><?php echo 'Save' ;
																		?></button>
								</div>
							</div>

							<!-- reset and save end -->

							<?php echo form_close() ?>

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
		// alert(val);
		if (val == 'Admin') {
			$('#admin_access').show();
			$('#department_head').hide();
			$('#addmeshon').hide();
			$('#user_role').val(3);
		} else if (val == 'Admission Section') {
			$('#addmeshon').show();
			$('#admin_access').hide();
			$('#department_head').hide();
			$('#user_role').val(5);
		} else if (val == 'Department Head') {
			$('#department_head').show();
			$('#admin_access').hide();
			$('#addmeshon').hide();
			$('#user_role').val(4);
		} else {
			$('#super_admin').show();
			$('#user_role').val(2);

		}
		$('input:checkbox').attr('checked', false);
	}
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