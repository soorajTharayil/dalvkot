<div class="row">
	<!--  form area -->
	<div class="col-sm-12">
		<div class="panel panel-default thumbnail">

			<div class="panel-heading no-print">
				<div class="btn-group">
					<a class="btn btn-primary" href="<?php echo base_url("role") ?>"> <i class="fa fa-list"></i> role
						List </a>
				</div>
			</div>

			<div class="panel-body panel-form">
				<div class="row">
					<div class="col-md-9 col-sm-12">

						<?php echo form_open('role/create', 'class="form-inner"') ?>

						<?php echo form_hidden('ids', $department->id) ?>
						<?php $permission = json_decode($department->rolepermission); ?>
						<div class="form-group row">
							<label for="name" class="col-xs-3 col-form-label">Name <i class="text-danger">*</i></label>
							<div class="col-xs-9">
								<input name="name" type="text" class="form-control" id="name" placeholder="Name"
									value="<?php echo $department->title ?>" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="name" class="col-xs-3 col-form-label">Message Notification <i
									class="text-danger">*</i></label>
							<div class="col-xs-9">
								<div class="checkboxreport">
									<label><input type="checkbox" name="message_report_ip" value="1" <?php if ($permission->message_report_ip == 1) {
										echo 'checked';
									} ?>>Weekly Report
										IP</label>
								</div>
								<div class="checkboxreport">
									<label><input type="checkbox" name="message_report_op" value="1" <?php if ($permission->message_report_op == 1) {
										echo 'checked';
									} ?>>Weekly Report
										OP</label>
								</div>
								<div class="checkboxreport">
									<label><input type="checkbox" name="message_report_ticket_ip" value="1" <?php if ($permission->message_report_ticket_ip == 1) {
										echo 'checked';
									} ?>>Weekly
										Ticket IP</label>
								</div>
								<div class="checkboxreport">
									<label><input type="checkbox" name="message_report_ticket_op" value="1" <?php if ($permission->message_report_ticket_op == 1) {
										echo 'checked';
									} ?>>Weekly
										Ticket OP</label>
								</div>
								<div class="checkboxreport">
									<label><input type="checkbox" name="message_ticket_ip" value="1" <?php if ($permission->message_ticket_ip == 1) {
										echo 'checked';
									} ?>>IP Ticket
										Alert</label>
								</div>
								<div class="checkboxreport">
									<label><input type="checkbox" name="message_ticket_op" value="1" <?php if ($permission->message_ticket_op == 1) {
										echo 'checked';
									} ?>>OP Ticket
										Alert</label>
								</div>

							</div>
						</div>

						<div class="form-group row">
							<label for="name" class="col-xs-3 col-form-label">Email Notification <i
									class="text-danger">*</i></label>
							<div class="col-xs-9">
								<div class="checkboxreport">
									<label><input type="checkbox" name="email_report_ip" value="1" <?php if ($permission->email_report_ip == 1) {
										echo 'checked';
									} ?>>Weekly Report
										IP</label>
								</div>
								<div class="checkboxreport">
									<label><input type="checkbox" name="email_report_op" value="1" <?php if ($permission->email_report_op == 1) {
										echo 'checked';
									} ?>>Weekly Report
										OP</label>
								</div>
								<div class="checkboxreport">
									<label><input type="checkbox" name="email_report_ticket_ip" value="1" <?php if ($permission->email_report_ticket_ip == 1) {
										echo 'checked';
									} ?>>Weekly
										Ticket IP</label>
								</div>
								<div class="checkboxreport">
									<label><input type="checkbox" name="email_report_ticket_op" value="1" <?php if ($permission->email_report_ticket_op == 1) {
										echo 'checked';
									} ?>>Weekly
										Ticket OP</label>
								</div>
								<div class="checkboxreport">
									<label><input type="checkbox" name="email_ticket_ip" value="1" <?php if ($permission->email_ticket_ip == 1) {
										echo 'checked';
									} ?>>IP Ticket
										Alert</label>
								</div>
								<div class="checkboxreport">
									<label><input type="checkbox" name="email_ticket_op" value="1" <?php if ($permission->email_ticket_op == 1) {
										echo 'checked';
									} ?>>OP Ticket
										Alert</label>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="name" class="col-xs-3 col-form-label">Application Permission<i
									class="text-danger">*</i></label>
							<div class="col-xs-9">
								<div class="checkboxreport">
									<label><input type="checkbox" name="ippermission" value="1" <?php if ($permission->ippermission == 1) {
										echo 'checked';
									} ?>>IP ACCESS</label>
								</div>
								<div class="checkboxreport">
									<label><input type="checkbox" name="oppermission" value="1" <?php if ($permission->oppermission == 1) {
										echo 'checked';
									} ?>>OP ACCESS</label>
								</div>
								<!--<div class="checkboxreport">
										<label><input type="checkbox" name="export_report" value="1">Export Report</label>
									</div>
									<div class="checkboxreport">
										<label><input type="checkbox" name="report_dashboard" value="1">Report Dashboard</label>
									</div>
									<div class="checkboxreport">
										<label><input type="checkbox" name="ticket_dashboard" value="1">Ticket Dashboard</label>
									</div>->
									<!--<div class="">
										<label><input type="checkbox" name="ip_admin" value="1" >IP Admin Permission</label>
									</div>
									<div class="">
										<label><input type="checkbox" name="email_ticketnotificationdepartment" value="1" >OP Admin Permission</label>
									</div>-->
							</div>
							<p>&nbsp;</p>

							<div class="form-group row">
								<div class="col-sm-offset-3 col-sm-6">
									<div class="ui buttons">
										<button type="reset" class="ui button"><?php echo 'Reset'; ?></button>
										<div class="or"></div>
										<button class="ui positive button"><?php echo display('save') ?></button>
									</div>
								</div>
							</div>
						</div>




						<?php echo form_close() ?>

					</div>
				</div>
			</div>
		</div>
	</div>

</div>