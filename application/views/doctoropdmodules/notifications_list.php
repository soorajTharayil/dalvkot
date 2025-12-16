<!--Code updates: 
Worked on UI allignment, fixed all the issues.
Last updated on 05-03-23 -->



<!-- content -->
<div class="content">
	<!-- alert message -->
	<!-- content -->
	<!-- PHP Code {-->
	<?php
	include 'info_buttons_ip.php';
	require 'ip_table_variables.php';


	$all_feedback = $this->doctorsopdfeedback_model->patient_and_feedback($table_patients, $table_feedback, $desc, $setup);
	$sresulte = $this->doctorsopdfeedback_model->setup_result($setup);
	foreach ($sresulte as $r2) {
		$setarray[$r2->type] = $r2->title;
	}
	if (($all_feedback)) {
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">

				<div class="panel-body" style="   height: 493px;      overflow: auto;">
					<div class="message_inner">
						<strong>
							<?php
							foreach ($all_feedback as $r) {
								$param = json_decode($r->dataset);

								if (($param->overallScore != 0 && $param->overallScore > 3)) {
									$feedbacktype = 'Happy feedback';
								} else {
									$feedbacktype = 'Unhappy feedback';
								}
							?>

								<div class="inbox-item">
									<a href="<?php echo  $ip_link_patient_feedback . $r->id; ?>">
										<p class="inbox-item-text">
											<?php echo $feedbacktype; ?> by
											<?php echo $param->name; ?> (<span style="color:#62c52d;"><?php echo $param->patientid; ?></span>)
										</p>

										<p class="inbox-item-text">
											From
											<?php
											if ($param->bedno != '' && $param->bedno != '-') {
												echo $param->bedno;
												echo ' in ';
											}
											?>
											<?php echo $param->ward . '.'; ?> at
											<?php //echo date('g:i A, d-m-y', strtotime($r->datetime)); ?>
											<?php if ($param->datetime) { ?>
												<?php echo date('g:i A', date(($param->datetime) / 1000)); ?>
												
												<?php echo date('d-m-y', date(($param->datetime) / 1000)); ?>
											<?php } ?>

										</p>


									</a>
								</div>

							<?php
							} ?>
						</strong>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } else {   ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('op','op_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>
</div>