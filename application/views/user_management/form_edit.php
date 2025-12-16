<!-- This page is used to add users -->
<?php
$roles = $this->db->order_by('role_id', 'asc')->get('roles')->result();
$ward = $this->db->order_by('id', 'asc')->get('bf_roles')->result();

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
						<a class="btn btn-success" href="<?php echo base_url("UserManagement") ?>"> <i class="fa fa-list"></i> <?php echo lang_loader('global', 'global_user_list'); ?> </a>
					</div>
				</div>
				<!-- user list button end-->

				<div class="panel-body panel-form">
					<div class="row">
						<div class="col-md-8 col-sm-12 col-lg-12">

							<?php echo form_open('UserManagement/create_edit', 'class="form-inner"') ?>
							<?php echo form_hidden('ids', $department->user_id) ?>
							<?php $permission = json_decode($department->departmentpermission, true); ?>
							<!-- Name start-->
							<div class="form-group row">
								<label for="name" class="col-xs-3 col-form-label">Employee Name <i class="text-danger">*</i></label>
								<div class="col-xs-9">
									<input name="name" type="text" class="form-control" id="name" autocomplete="off" placeholder="Name" value="<?php echo $department->firstname; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="name" class="col-xs-3 col-form-label">Designation  <i class="text-danger">*</i></label>
								<div class="col-xs-9">
									<input name="designation" type="text" class="form-control" id="designation" autocomplete="off" placeholder="Designation" value="<?php echo $department->designation; ?>" required>
								</div>
							</div>
							<!-- Name end-->
							<div class="form-group row" id="empid">
								<label for="email" class="col-xs-3 col-form-label">Employee Id <i class="text-danger">*</i></label>
								<div class="col-xs-9">
									<input name="empid" type="text" class="form-control" id="empid" placeholder="Enter Employee Id" value="<?php echo $department->emp_id ?>">
								</div>
							</div>




							<!-- Email start-->
							<div class="form-group row">
								<label for="email" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_email'); ?> <i class="text-danger">*</i></label>
								<div class="col-xs-9">
									<input name="email" type="email" class="form-control" id="email"  placeholder="Email" value="<?php echo $department->email ?>" autocomplete="off" >
								</div>
							</div>
							<!-- Email end-->

							<!-- Email start-->
							<!-- <div class="form-group row" id="alternateEmail" style="display: none;">
								<label for="email" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_alternate_email'); ?> <i class="text-danger">*</i></label>
								<div class="col-xs-9">
									<input name="alternate_email" type="email" class="form-control" id="alternate_email" placeholder="Alternate Email" value="<?php echo $department->alternate_email ?>">
								</div>
							</div> -->
							<!-- Email end-->

							<!-- Phone Number start -->
							<div class="form-group row">
								<label for="mobile" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_mobile'); ?> <i class="text-danger">*</i> </label>
								<div class="col-xs-9">
									<input type="number" class="form-control" id="mobile" name="mobile"  value="<?php echo $department->mobile; ?>" autocomplete="off" 	maxlength="10"
										pattern="\d{10}"
										placeholder="Mobile Number" oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);">
								</div>
							</div>
							<!-- Phone Number end -->
							<!-- Another Phone Number start -->

							<!-- <div class="form-group row" id="alternatePhoneNumber" style="display: none;">
								<label for="mobile" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_alternate_mobile'); ?> </label>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="alternate_mobile" name="alternate_mobile" pattern="[0-9]{10}" maxlength="10" placeholder="Alternate Mobile Number" value="<?php echo $department->alternate_mobile; ?>">
								</div>
							</div> -->


							<!--Another Phone Number end -->

							<!-- Password start -->
							<div class="form-group row" id="show_hide_password">
								<label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_password'); ?> <i class="text-danger">*</i></label>
								<div class="col-xs-9">
									<input name="password" type="password" class="form-control" id="password" placeholder="Password" value="<?php echo $permission['password']; ?>" autocomplete="new-password" required>
									<div class="input-group-addon changepassword">
										<a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
									</div>
								</div>
							</div>
							<!-- Password end -->

							<!-- user role start -->
							<div class="form-group row">
								<label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_user_role'); ?> <i class="text-danger">*</i></label>
								<div class="col-xs-9">
									<select class="form-control" id="sel1" name="userrole" style="border-radius: 0px;" required>
										<option value=""><?php echo lang_loader('global', 'global_select_role'); ?></option>
										<?php
										foreach ($roles as $role) {
											if ($role->role_name != 'DEVELOPER') {
												echo '<option value="' . $role->role_id . '"';
												// Check if $department->lastname matches the current role name
												if (isset($department->lastname) && $department->lastname == $role->role_name) {
													echo ' selected'; // Mark this option as selected
												}
												echo '>' . $role->role_name . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>




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
<!-- <script>
	function handleUserRoleChange(selectedRole) {
		console.log('Selected Role:', selectedRole);
		console.log('Selected Role:', selectedRole);

		// Hide both divs by default
		document.getElementById('alternatePhoneNumber').style.display = 'none';
		document.getElementById('alternateEmail').style.display = 'none';

		// Show divs based on selected role
		if (selectedRole == 4) {
			document.getElementById('alternatePhoneNumber').style.display = 'block';
			document.getElementById('alternateEmail').style.display = 'block';
		}
	}
</script> -->




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