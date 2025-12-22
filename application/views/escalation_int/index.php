<?php
$escalation = $escalation[0];
$level2_escalate_to = json_decode($escalation->level2_escalate_to);
$level1_escalate_to = json_decode($escalation->level1_escalate_to);
$dept_level_escalation_to = json_decode($escalation->dept_level_escalation_to);
$users = $this->db->get('user')->result();
?>
<br>
<div class="content">
	<div class="row">
		<!--  table area -->
		<div class="col-sm-12">
			<div class="panel panel-default thumbnail">
				<div class="panel-body">
					<?php if ($this->session->userdata('user_role') != 4) { ?>
						<ul class="list-group">

							<li class="list-group-item">
								<b>Enable Escalation</b>
								<div class="material-switch pull-right">
									<input id="someSwitchOptionPrimary" name="someSwitchOption001" type="checkbox" <?php
																													if ($escalation->status == 'ACTIVE') {
																														echo 'checked="true"';
																														echo 'onclick="set_active(0)"';
																													} else {
																														echo 'onclick="set_active(1)"';
																													}
																													?> />
									<label for="someSwitchOptionPrimary" class="label-primary"></label>
								</div>
							</li>
						</ul>

						<br />
					<?php } ?>
					<?php if ($escalation->status == 'ACTIVE') { ?>
						<?php echo form_open('escalation_int/create'); ?>

						<!-- sooraj updated -->
						<div class="accordion">Department Level Escalation (L1)</div>

						<div class="panel paneld" style="display:block; background:#FFF;">

							<div class="col-xs-12">


								<div class="form-group row">

									<!-- <label for="name" class="col-xs-3 col-form-label">Time Until escalation action<i class="text-danger">*</i></label> -->

									<div class="col-xs-9">

										<select name="level1_duration_type" style="display: none;">

											<option value="minutes" <?php if ($escalation->level1_duration_type == 'minutes') {
																		echo 'selected';
																	} ?>>Minutes</option>

											<option value="hours" <?php if ($escalation->level1_duration_type == 'hours') {
																		echo 'selected';
																	} ?>>Hours</option>

											<option value="days" <?php if ($escalation->level1_duration_type == 'days') {
																		echo 'selected';
																	} ?>>Days</option>

										</select>

										<!-- <input type="number" name="level1_duration_value"  value="<?php echo $escalation->level1_duration_value; ?>" min="1" max="9999" step="1"> -->

									</div>

								</div>
								<div class="form-group row">

									<label for="name" class="col-xs-3 col-form-label">Escalate to<i class="text-danger">*</i></label>
									<br />
									<br />
									<ul class="list-group" style="margin-left: 15px;">


										<?php

										foreach ($users as $u) {
											if ($u->user_id > 1 && ($u->user_role == 4)) {
										?>
												<li class="list-group-item">
													<div class="checkboxreport">

														<label>
															<input type="checkbox" name="dept_level_escalation_to[]" value="<?php echo $u->user_id; ?>" <?php if (in_array($u->user_id, $dept_level_escalation_to)) {
																																						echo 'checked';
																																					} ?>>
															<?php echo $u->firstname; ?>(<?php echo $u->email; ?>)
														</label>

													</div>
												</li>
										<?php
											}
										}
										?>
									</ul>
								</div>

								<ul class="list-group">

									<li class="list-group-item">
										<b>SMS Alert</b>
										<div class="material-switch pull-right">
											<input id="deptlevelsmsalert" name="dept_level_sms_alert" value="YES" type="checkbox" <?php
																															if ($escalation->dept_level_sms_alert == 'YES') {
																																echo 'checked="true"';
																															}
																															?> />
											<label for="deptlevelsmsalert" class="label-success"></label>
										</div>
									</li>
									<li class="list-group-item">
										<b>Email Alert</b>
										<div class="material-switch pull-right">
											<input id="deptlevelemailalert" name="dept_level_email_alert" value="YES" type="checkbox" <?php
																																if ($escalation->dept_level_email_alert == 'YES') {
																																	echo 'checked="true"';
																																}

																																?> />
											<label for="deptlevelemailalert" class="label-success"></label>
										</div>
									</li>
									<li class="list-group-item">
										<b>Whatsapp Alert</b>
										<div class="material-switch pull-right">
											<input id="deptlevelwhatsappalert" name="dept_level_whatsapp_alert" value="YES" type="checkbox" <?php
																																if ($escalation->dept_level_whatsapp_alert == 'YES') {
																																	echo 'checked="true"';
																																}

																																?> />
											<label for="deptlevelwhatsappalert" class="label-success"></label>
										</div>
									</li>
								</ul>

							</div>

						</div>

						<div class="accordion">Admin Level Escalation (L2)</div>

						<div class="panel paneld" style="display:block; background:#FFF;">

							<div class="col-xs-12">


								<div class="form-group row">

									<!-- <label for="name" class="col-xs-3 col-form-label">Time Until escalation action<i class="text-danger">*</i></label> -->

									<div class="col-xs-9">

										<select name="level1_duration_type" style="display: none;">

											<option value="minutes" <?php if ($escalation->level1_duration_type == 'minutes') {
																		echo 'selected';
																	} ?>>Minutes</option>

											<option value="hours" <?php if ($escalation->level1_duration_type == 'hours') {
																		echo 'selected';
																	} ?>>Hours</option>

											<option value="days" <?php if ($escalation->level1_duration_type == 'days') {
																		echo 'selected';
																	} ?>>Days</option>

										</select>

										<!-- <input type="number" name="level1_duration_value"  value="<?php echo $escalation->level1_duration_value; ?>" min="1" max="9999" step="1"> -->

									</div>

								</div>
								<div class="form-group row">

									<label for="name" class="col-xs-3 col-form-label">Escalate to<i class="text-danger">*</i></label>
									<br />
									<br />
									<ul class="list-group" style="margin-left: 15px;">


										<?php

										foreach ($users as $u) {
											if ($u->user_id > 1 && $u->user_role <= 3) {
										?>
												<li class="list-group-item">
													<div class="checkboxreport">

														<label>
															<input type="checkbox" name="level1_escalate_to[]" value="<?php echo $u->user_id; ?>" <?php if (in_array($u->user_id, $level1_escalate_to)) {
																																						echo 'checked';
																																					} ?>>
															<?php echo $u->firstname; ?>(<?php echo $u->email; ?>)
														</label>

													</div>
												</li>
										<?php
											}
										}
										?>
									</ul>
								</div>

								<ul class="list-group">

									<li class="list-group-item">
										<b>SMS Alert</b>
										<div class="material-switch pull-right">
											<input id="smsalertlevel1" name="level1_sms_alert" value="YES" type="checkbox" <?php
																															if ($escalation->level1_sms_alert == 'YES') {
																																echo 'checked="true"';
																															}
																															?> />
											<label for="smsalertlevel1" class="label-success"></label>
										</div>
									</li>
									<li class="list-group-item">
										<b>Email Alert</b>
										<div class="material-switch pull-right">
											<input id="emailalertlevel1" name="level1_email_alert" value="YES" type="checkbox" <?php
																																if ($escalation->level1_email_alert == 'YES') {
																																	echo 'checked="true"';
																																}

																																?> />
											<label for="emailalertlevel1" class="label-success"></label>
										</div>
									</li>
									<li class="list-group-item">
										<b>Whatsapp Alert</b>
										<div class="material-switch pull-right">
											<input id="whatsappalertlevel1" name="level1_whatsapp_alert" value="YES" type="checkbox" <?php
																																if ($escalation->level1_whatsapp_alert == 'YES') {
																																	echo 'checked="true"';
																																}

																																?> />
											<label for="whatsappalertlevel1" class="label-success"></label>
										</div>
									</li>
								</ul>

							</div>

						</div>

						<!-- SMS Alerts end -->

					
						<div class="accordion">Admin Level Escalation (L3)</div>

						<div class="panel paneld" style="display:block; background:#FFF;">

							<div class="col-xs-12">


								<div class="form-group row">

									<!-- <label for="name" class="col-xs-3 col-form-label">Time Until escalation action<i class="text-danger">*</i></label> -->

									<div class="col-xs-9">

										<select name="level2_duration_type" style="display: none;">

											<option value="minutes" <?php if ($escalation->level2_duration_type == 'minutes') {
																		echo 'selected';
																	} ?>>Minutes</option>

											<option value="hours" <?php if ($escalation->level2_duration_type == 'hours') {
																		echo 'selected';
																	} ?>>Hours</option>

											<option value="days" <?php if ($escalation->level2_duration_type == 'days') {
																		echo 'selected';
																	} ?>>Days</option>


										</select>

										<!-- <input type="number" name="level2_duration_value" value="<?php echo $escalation->level2_duration_value; ?>" min="1" max="9999" step="1"> -->

									</div>

								</div>
								<div class="form-group row">

									<label for="name" class="col-xs-3 col-form-label">Escalate to<i class="text-danger">*</i></label>
									<br />
									<br />
									<ul class="list-group" style="margin-left: 15px;">


										<?php

										foreach ($users as $u) {
											if ($u->user_id > 1 && $u->user_role <= 3) {
										?>
												<li class="list-group-item">
													<div class="checkboxreport">

														<label>
															<input type="checkbox" name="level2_escalate_to[]" value="<?php echo $u->user_id; ?>" <?php if (in_array($u->user_id, $level2_escalate_to)) {
																																						echo 'checked';
																																					} ?>>
															<?php echo $u->firstname; ?>(<?php echo $u->email; ?>)
														</label>

													</div>
												</li>
										<?php
											}
										}
										?>
									</ul>
								</div>

								<ul class="list-group">

									<li class="list-group-item">
										<b>SMS Alert</b>
										<div class="material-switch pull-right">
											<input id="smsalertlevel2" name="level2_sms_alert" value="YES" type="checkbox" <?php
																															if ($escalation->level2_sms_alert == 'YES') {
																																echo 'checked="true"';
																															}

																															?> />
											<label for="smsalertlevel2" class="label-success"></label>
										</div>
									</li>
									<li class="list-group-item">
										<b>Email Alert</b>
										<div class="material-switch pull-right">
											<input id="emailalertlevel2" name="level2_email_alert" value="YES" type="checkbox" <?php
																																if ($escalation->level2_email_alert == 'YES') {
																																	echo 'checked="true"';
																																}
																																?> />
											<label for="emailalertlevel2" class="label-success"></label>
										</div>
									</li>
									<li class="list-group-item">
										<b>Whatsapp Alert</b>
										<div class="material-switch pull-right">
											<input id="whatsappalertlevel2" name="level2_whatsapp_alert" value="YES" type="checkbox" <?php
																																if ($escalation->level2_whatsapp_alert == 'YES') {
																																	echo 'checked="true"';
																																}
																																?> />
											<label for="whatsappalertlevel2" class="label-success"></label>
										</div>
									</li>
								</ul>

							</div>

						</div>
						<div class="col-sm-offset-3 col-sm-6">

							<div class="ui buttons">

								<button type="reset" class="ui button"><?php echo 'Reset' ; ?></button>

								<div class="or"></div>

								<button class="ui positive button"><?php echo 'Save' ; ?></button>

							</div>

						</div>

						</form>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function set_active(active) {
		if (active == 1) {
			var url = "<?php echo base_url(); ?>escalation_int/action/active";
			window.location.href = url;
		} else {
			var url = "<?php echo base_url(); ?>escalation_int/action/inactive";
			window.location.href = url;
		}
	}
</script>

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
<style>
	.material-switch>input[type="checkbox"] {
		display: none;
	}

	.material-switch>label {
		cursor: pointer;
		height: 0px;
		position: relative;
		width: 40px;
	}

	.material-switch>label::before {
		background: rgb(0, 0, 0);
		box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
		border-radius: 8px;
		content: '';
		height: 16px;
		margin-top: -8px;
		position: absolute;
		opacity: 0.3;
		transition: all 0.4s ease-in-out;
		width: 40px;
	}

	.material-switch>label::after {
		background: rgb(255, 255, 255);
		border-radius: 16px;
		box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
		content: '';
		height: 24px;
		left: -4px;
		margin-top: -8px;
		position: absolute;
		top: -4px;
		transition: all 0.3s ease-in-out;
		width: 24px;
	}

	.material-switch>input[type="checkbox"]:checked+label::before {
		background: inherit;
		opacity: 0.5;
	}

	.material-switch>input[type="checkbox"]:checked+label::after {
		background: inherit;
		left: 20px;
	}
</style>