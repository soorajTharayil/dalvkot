<!--Code updates: 

Worked on UI allignment, fixed all the issues.

Last updated on 05-03-23 -->
<?php

//Tooltip for setting page
$users_role_tooltip = "Page allowing the Administrator to manage user accounts, assign roles, and control access levels across system";
$suppementary_info_tooltip = "Page providing convenient access to supplementary links of the application such as feedback forms, Google review links, and the Android APP download etc.";

$inpatient_floor_tooltip = "Page for Adding/Editing Floors/Wards and beds in the hospital where Inpatients are Located";
$outpatient_specialities_tooltip = "Page for Adding/Editing Clinical Specialties of the Hospital, Used for Capturing Patient Demographics";
$isr_floor_tooltip = "Page for Adding/Editing Floors and sites of the hospital as per the floor directory";

$ip_escalation_tooltip = "Page for Configuring Escalation Matrix and Turn around time for Inpatient Discharge Feedback-Related Tickets and Negative Experiences.";
$op_escalation_tooltip = "Page for Configuring Escalation Matrix and Turn around time for Outpatient Feedback-Related Tickets and Negative Experiences.";
$pcf_escalation_tooltip = "Page for Configuring Escalation Matrix and Turn around time for Patient complaints and requests.";
$isr_escalation_tooltip = "Page for Configuring Escalation Matrix and Turn around time for internal service requests raised by the staffs";
$incident_escalation_tooltip = "Page for Configuring Escalation Matrix and Turn around time for healthcare incidents reported by the staffs";

$emp_list_tooltip = "Page to view key details, such as names, positions, and contact information, to stay organized and informed about your employee members.";
$emp_role_tooltip = "Page to add, edit, and manage job roles for seamless organization and clear responsibilities";
$asset_tooltip = "Page for Adding/Editing asset group/category";
$asset_location_tooltip = "Page for Adding/Editing asset departments";
$asset_grade_tooltip = "Page for Adding/Editing asset grade";

$benchmark_tooltip = "Page for Adding/Editing bench mark time for Quality KPIs";
$audit_department_tooltip = "Page for Adding/Editing audit department";
$audit_patient_category_tooltip = "Page for Adding/Editing patient category";
$audit_safety_department_tooltip = "Page for Adding/Editing department for safety insepction audit";
$audit_safety_adherence_tooltip = "Page for Adding/Editing department for safety adherence audit";

$audit_np_ratio_icu_tooltip = "Page for Adding/Editing ICU for Nurse-Patient Ratio audit";
$audit_np_ratio_ward_tooltip = "Page for Adding/Editing Ward for Nurse-Patient Ratio audit";

$audit_hand_tooltip = "Page for Adding/Editing designations for Handover/ Hand hygiene audit";
$audit_indication_tooltip = "Page for Adding/Editing indications for Hand hygiene audit";

$audit_hand_action_tooltip = "Page for Adding/Editing HH action for Hand hygiene audit";

$audit_hand_compliance_tooltip = "Page for Adding/Editing compliance for Hand hygiene audit";

$audit_transfusion_type_tooltip = "Page for Adding/Editing  transfusion type";

$audit_patient_status_tooltip = "Page for Adding/Editing patient status for Nurse-Patient ratio audit";

$audit_emergency_code_tooltip = "Page for Adding/Editing emergency code for mock drill audit";

$audit_frequency_tooltip = "Page for setting the frequency and scheduling of audits";


$audit_doctor_tooltip = "Page for Adding/Editing the doctor";

$audit_area_tooltip = "Page for Adding/Editing the area";

$audit_custdian_tooltip = "Page for display the custdians";


?>


<!-- content -->

<div class="content">

	<div class="row">

		<div class="col-lg-12">

			<div class="panel panel-default" style="overflow:auto;">

				<div class="panel-body">

					<div class="col-md-9 col-sm-12 col-lg-12">

						<table class=" table table-striped" cellspacing="0" width="100%">

							<tbody>

								<tr>

									<td colspan="2"><strong><span style="font-size: 18px;">
												<?php echo lang_loader('global', 'global_general_setting'); ?>
											</span></strong></td>

								</tr>

								<tr>

									<td><b>Users and Roles</b>
										<span>
											<a href="javascript:void()" data-toggle="tooltip"
												title="<?php echo $users_role_tooltip; ?>" data-placement="right">
												<i class="fa fa-info-circle" aria-hidden="true"></i>
											</a>
										</span>
									</td>

									<td>

										<a class="btn btn-success" href="<?php echo base_url("UserManagement") ?>"> <i
												class="fa fa-gear"></i>
											<?php echo lang_loader('global', 'global_manage'); ?> </a>

									</td>

								</tr>


								<?php if (ismodule_active('GLOBAL') === true && isfeature_active('SUPPLEMENTARY-INFO') === true || $this->session->userdata['user_role'] == 1) { ?>
									<tr>

										<td><b><?php echo lang_loader('global', 'global_supplementary_info'); ?></b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip"
													title="<?php echo $suppementary_info_tooltip; ?>"
													data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" style="padding-right: 30px;"
												href="<?php echo base_url("settings/supplementary_info") ?>"> <i
													class="fa fa-eye"></i>
												<?php echo lang_loader('global', 'global_view'); ?> </a>

										</td>

									</tr>
								<?php } ?>


								<?php if (isfeature_active('IP-FEEDBACKS-DASHBOARD') === true || isfeature_active('OP-FEEDBACKS-DASHBOARD') === true || isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?>

									<tr>

										<td colspan="2"><strong><span style="font-size: 18px;"> Manage Filters(Floors/
													Wards, Rooms, Specialties etc)</span></strong></td>

									</tr>

									<?php if (ismodule_active('IP') === true && isfeature_active('IP-FEEDBACKS-DASHBOARD') === true) { ?>

										<tr>

											<td><b><?php echo lang_loader('global', 'global_ip_floors_wards'); ?></b>
												<span>
													<a href="javascript:void()" data-toggle="tooltip"
														title="<?php echo $inpatient_floor_tooltip; ?>" data-placement="right">
														<i class="fa fa-info-circle" aria-hidden="true"></i>
													</a>
												</span>
											</td>

											<td>

												<a class="btn btn-success" href="<?php echo base_url("settings/sites_ip") ?>">
													<i class="fa fa-gear"></i>
													<?php echo lang_loader('global', 'global_manage'); ?> </a>

											</td>

										</tr>

									<?php } ?>

									<?php if (ismodule_active('OP') === true && isfeature_active('OP-FEEDBACKS-DASHBOARD') === true) { ?>

										<tr>

											<td><b>Outpatient Specialities / Doctors</b>
												<span>
													<a href="javascript:void()" data-toggle="tooltip"
														title="<?php echo $outpatient_specialities_tooltip; ?>"
														data-placement="right">
														<i class="fa fa-info-circle" aria-hidden="true"></i>
													</a>
												</span>
											</td>

											<td>

												<a class="btn btn-success" href="<?php echo base_url("settings/sites_op") ?>">
													<i class="fa fa-gear"></i>
													Manage</a>


											</td>

										</tr>
										<tr>

											<td><b>OP locations / Specialities / Doctors</b>
												<span>
													<a href="javascript:void()" data-toggle="tooltip"
														title="<?php echo $outpatient_specialities_tooltip; ?>"
														data-placement="right">
														<i class="fa fa-info-circle" aria-hidden="true"></i>
													</a>
												</span>
											</td>

											<td>

												<a class="btn btn-success" href="<?php echo base_url("settings/sites_op_location") ?>">
													<i class="fa fa-gear"></i>
													Manage</a>


											</td>

										</tr>

									<?php } ?>

									<?php if (ismodule_active('ISR') === true && isfeature_active('ISR-REQUESTS-DASHBOARD') === true) { ?>

										<tr>

											<td><b><?php echo lang_loader('global', 'global_floors_sites_service'); ?></b>
												<span>
													<a href="javascript:void()" data-toggle="tooltip"
														title="<?php echo $isr_floor_tooltip; ?>" data-placement="right">
														<i class="fa fa-info-circle" aria-hidden="true"></i>
													</a>
												</span>
											</td>

											<td>

												<a class="btn btn-success" href="<?php echo base_url("settings/sites_isr") ?>">
													<i class="fa fa-gear"></i>
													<?php echo lang_loader('global', 'global_manage'); ?> </a>

											</td>

										</tr>

									<?php } ?>
								<?php } ?>

								<tr>

									<td colspan="2"><br></td>

								</tr>


								<?php if ((isfeature_active('ADF-ESCALATION') === true) || (isfeature_active('IP-ESCALATION') === true) || (isfeature_active('OP-ESCALATION') === true) || (isfeature_active('PC-ESCALATION') === true) || (isfeature_active('ISR-ESCALATION') === true) || (isfeature_active('IN-ESCALATION') === true) || (isfeature_active('SG-ESCALATION') === true)) { ?>

									<tr>

										<td colspan="2"><strong><span style="font-size: 18px;">
													<?php echo lang_loader('global', 'global_manage_sla'); ?></span></strong>
										</td>

									</tr>

									<?php if (isfeature_active('ADF-ESCALATION') === true) { ?>



										<tr>

											<td><b><?php echo lang_loader('global', 'global_adf_feedback_ticket_escalation'); ?></b>
												<span>
													<a href="javascript:void()" data-toggle="tooltip"
														title="<?php echo $ip_escalation_tooltip; ?>" data-placement="right">
														<i class="fa fa-info-circle" aria-hidden="true"></i>
													</a>
												</span>
											</td>

											<td>

												<a class="btn btn-success" href="<?php echo base_url("settings/") ?>"> <i
														class="fa fa-gear"></i>
													<?php echo lang_loader('global', 'global_manage'); ?> </a>

											</td>

										</tr>



									<?php } ?>

									<?php if (isfeature_active('IP-ESCALATION') === true) { ?>



										<tr>

											<td><b><?php echo lang_loader('global', 'global_ip_feedback_ticket_escalation'); ?></b>

												<span>
													<a href="javascript:void()" data-toggle="tooltip"
														title="<?php echo $ip_escalation_tooltip; ?>" data-placement="right">
														<i class="fa fa-info-circle" aria-hidden="true"></i>
													</a>
												</span>
											</td>

											<td>

												<a class="btn btn-success"
													href="<?php echo base_url("settings/escalationip") ?>"> <i
														class="fa fa-gear"></i>
													<?php echo lang_loader('global', 'global_manage'); ?> </a>

												&nbsp;&nbsp;

												<a class="btn btn-success" href="<?php echo base_url("settings/ip_tat") ?>"> <i
														class="fa fa-clock-o"></i>
													<?php echo lang_loader('global', 'global_configure_TAT'); ?> </a>

											</td>

										</tr>



									<?php } ?>

									<?php if (isfeature_active('OP-ESCALATION') === true) { ?>





										<tr>

											<td><b><?php echo lang_loader('global', 'global_op_feedback_ticket_escalation'); ?></b>
												<span>
													<a href="javascript:void()" data-toggle="tooltip"
														title="<?php echo $op_escalation_tooltip; ?>" data-placement="right">
														<i class="fa fa-info-circle" aria-hidden="true"></i>
													</a>
												</span>
											</td>

											<td>

												<a class="btn btn-success"
													href="<?php echo base_url("settings/escalationop") ?>"> <i
														class="fa fa-gear"></i>
													<?php echo lang_loader('global', 'global_manage'); ?> </a>

												&nbsp;&nbsp;

												<a class="btn btn-success" href="<?php echo base_url("settings/op_tat") ?>"> <i
														class="fa fa-clock-o"></i>
													<?php echo lang_loader('global', 'global_configure_TAT'); ?> </a>

											</td>

										</tr>



									<?php } ?>

									<?php if (isfeature_active('PC-ESCALATION') === true) { ?>

										<tr>

											<td><b><?php echo lang_loader('global', 'global_patient_complaint_esc'); ?></b>
												<span>
													<a href="javascript:void()" data-toggle="tooltip"
														title="<?php echo $pcf_escalation_tooltip; ?>" data-placement="right">
														<i class="fa fa-info-circle" aria-hidden="true"></i>
													</a>
												</span>
											</td>

											<td>

												<a class="btn btn-success"
													href="<?php echo base_url("settings/escalationpc") ?>"> <i
														class="fa fa-gear"></i>
													<?php echo lang_loader('global', 'global_manage'); ?> </a>

												&nbsp;&nbsp;

												<a class="btn btn-success" href="<?php echo base_url("settings/pc_tat") ?>"> <i
														class="fa fa-clock-o"></i>
													<?php echo lang_loader('global', 'global_configure_TAT'); ?> </a>

											</td>

										</tr>

									<?php } ?>



									<?php if (isfeature_active('ISR-ESCALATION') === true) { ?>

										<tr>

											<td><b><?php echo lang_loader('global', 'global_isr_escalation'); ?></b>
												<span>
													<a href="javascript:void()" data-toggle="tooltip"
														title="<?php echo $isr_escalation_tooltip; ?>" data-placement="right">
														<i class="fa fa-info-circle" aria-hidden="true"></i>
													</a>
												</span>
											</td>

											<td>

												<a class="btn btn-success"
													href="<?php echo base_url("settings/escalationisr") ?>"> <i
														class="fa fa-gear"></i>
													<?php echo lang_loader('global', 'global_manage'); ?> </a>

												&nbsp;&nbsp;

												<a class="btn btn-success" href="<?php echo base_url("settings/isr_tat") ?>"> <i
														class="fa fa-clock-o"></i>
													<?php echo lang_loader('global', 'global_configure_TAT'); ?> </a>

											</td>

										</tr>

									<?php } ?>

									<?php if (isfeature_active('IN-ESCALATION') === true) { ?>

										<tr>

											<td><b><?php echo lang_loader('global', 'global_inc_escalation'); ?></b>
												<span>
													<a href="javascript:void()" data-toggle="tooltip"
														title="<?php echo $incident_escalation_tooltip; ?>"
														data-placement="right">
														<i class="fa fa-info-circle" aria-hidden="true"></i>
													</a>
												</span>
											</td>

											<td>

												<a class="btn btn-success"
													href="<?php echo base_url("settings/escalationincident") ?>"> <i
														class="fa fa-gear"></i>
													<?php echo lang_loader('global', 'global_manage'); ?> </a>

												&nbsp;&nbsp;

												<a class="btn btn-success"
													href="<?php echo base_url("settings/incident_tat") ?>"> <i
														class="fa fa-clock-o"></i>
													<?php echo lang_loader('global', 'global_configure_TAT'); ?> </a>

											</td>

										</tr>

									<?php } ?>

									<?php if (isfeature_active('SG-ESCALATION') === true) { ?>

										<tr>

											<td><b><?php echo lang_loader('global', 'global_sg_escalation'); ?></b>
												<span>
													<a href="javascript:void()" data-toggle="tooltip"
														title="<?php echo $incident_escalation_tooltip; ?>"
														data-placement="right">
														<i class="fa fa-info-circle" aria-hidden="true"></i>
													</a>
												</span>
											</td>

											<td>

												<a class="btn btn-success"
													href="<?php echo base_url("settings/escalationgrievance") ?>"> <i
														class="fa fa-gear"></i>
													<?php echo lang_loader('global', 'global_manage'); ?> </a>

												&nbsp;&nbsp;

												<a class="btn btn-success"
													href="<?php echo base_url("settings/grievance_tat") ?>"> <i
														class="fa fa-clock-o"></i>
													<?php echo lang_loader('global', 'global_configure_TAT'); ?> </a>

											</td>

										</tr>

									<?php } ?>
								<?php } ?>
								<tr>

									<td colspan="2"><br></td>

								</tr>


								<?php if (ismodule_active('QUALITY') === true && isfeature_active('QUALITY-DASHBOARD') === true) { ?>
									<tr>
										<td colspan="2"><strong><span style="font-size: 18px;">Manage Quality Module</span></strong>
										</td>
									</tr>

									<tr>

										<td><b>Set bench mark time for KPIs</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip"
													title="<?php echo $benchmark_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/quality_benchmark") ?>"> <i
													class="fa fa-gear"></i>
												<?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

								<?php } ?>


								<?php if (ismodule_active('AUDIT') === true && isfeature_active('AUDIT-DASHBOARD') === true) { ?>
									<tr>
										<td colspan="2"><strong><span style="font-size: 18px;">Manage Audit Module</span></strong>
										</td>
									</tr>

									<tr>

										<td><b>Audit Frequency</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_frequency_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_frequency") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Audit Departments</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_department_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_department") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Doctor list for Audit</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_doctor_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_doctor") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Audit Patient Area</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_area_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_area") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Audit Custodians</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_custdian_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_custodians") ?>" target="_blank"> <i class="fa fa-eye"></i> View</a>

										</td>

									</tr>

									<tr>

										<td><b>Patient Categories</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_patient_category_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_patient_category") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Safety inspection audit departments</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_safety_department_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_safety_department") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Safety adherence audit departments</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_safety_adherence_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_safety_adherence_dept") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>ICUs for Nurse-Patient ratio audit</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_np_ratio_icu_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_np_ratio_icu") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Wards for Nurse-Patient ratio audit</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_np_ratio_ward_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_np_ratio_ward") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Designations for Handover/ Hand hygiene audit</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_hand_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_hand_designation") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Indications for Hand hygiene audit</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_indication_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_hand_indication") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Hygiene actions for Hand hygiene audit</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_hand_action_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_hand_action") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Compliance levels for Hand hygiene audit</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_hand_compliance_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_hand_compliance") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Transfusion Type for TAT for issue blood audit</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_transfusion_type_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_transfusion_type") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Patient Status for Nurse-Patient ratio audit</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_patient_status_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_patient_status") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Emergency codes for Mock drill audit</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $audit_emergency_code_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/audit_emergency_code") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>


								<?php } ?>

								<?php if (ismodule_active('ASSET') === true && isfeature_active('ASSET-DASHBOARD') === true) { ?>
									<tr>
										<td colspan="2"><strong><span style="font-size: 18px;">Asset Management Settings</span></strong></td>
									</tr>

									<tr>

										<td><b>Asset Groups/ Categories</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $asset_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/asset_group") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Asset Departments</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $asset_location_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/asset_location") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

									<tr>

										<td><b>Asset Gradings</b>
											<span>
												<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $asset_grade_tooltip; ?>" data-placement="right">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</span>
										</td>

										<td>

											<a class="btn btn-success" href="<?php echo base_url("settings/asset_grade") ?>" target="_blank"> <i class="fa fa-gear"></i> <?php echo lang_loader('global', 'global_manage'); ?> </a>

										</td>

									</tr>

								<?php } ?>

							</tbody>

						</table>

					</div>

				</div>







				<!-- Close Metric Boxes-->

			</div>

		</div>

	</div>





	<?php // } 

	?>

	<!-- FOR SUPERADMIN AND ADMIN -->



</div>



<style>
	.table {

		width: 100%
	}



	.td {

		width: 50%;

	}
</style>