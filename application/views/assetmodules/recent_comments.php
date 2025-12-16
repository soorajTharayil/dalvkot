<!-- content -->
<div class="content">
	<!-- alert message -->
	<!-- content -->





	<!-- PHP Code {-->

	<?php

	include 'info_buttons_int.php';
	require 'pc_table_variables.php';


	$all_tickets = $this->pc_model->get_tickets($table_feedback, $table_tickets);
	$feedbacktaken = $this->pc_model->patient_and_feedback($table_patients, $table_feedback, $desc);
	$sresult = $this->pc_model->setup_result($setup);
	foreach ($sresult as $r2) {
		$setarray[$r2->type] = $r2->title;
		$question[$r2->shortkey] = $r2->shortname;
		$dep[$r2->shortkey] = $r2->title;
	}

	if (($feedbacktaken)) {
	?>




		<div class="row">
			<!-- Total Product Sales area -->

			<div class="col-lg-12">
				<div class="panel panel-default">

					<div class="panel-heading" style="text-align: right;">
						<div class="btn-group">
							<a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="Download Complaints?" href="<?php echo base_url($this->uri->segment(1)) . '/downloadcomments' ?>">
								<i class="fa fa-file-text"></i>
							</a>
						</div>
					</div>


					<?php if ($feedbacktaken) { ?>
						<div class="panel-body">

							<?php
							foreach ($feedbacktaken as $r) {

								$param = json_decode($r->dataset);
								if (($param->suggestionText != '' && $param->suggestionText != NULL) || count($param->comment) > 0) { ?>
									<a href="<?php echo  $int_link_patient_feedback . $param->patientid; ?>">

										<div class="inbox-item">

											<strong class="inbox-item-author"><?php echo $param->name; ?>
												(<span style="color:#62c52d;"><?php echo $param->patientid; ?></span>)
												<p class="inbox-item-text">
													<?php

													echo $param->ward;
													?>
												</p>

												<span class="inbox-item-date">
													<?php echo date('g:i A', date(($param->datetime) / 1000)); ?>
													<?php echo date('d-m-y', date(($param->datetime) / 1000)); ?>
												</span>
												<?php foreach ($param->reason as $key => $value) { ?>
													<?php if ($value) { ?>

														<p class="inbox-item-text"><i class="fa fa-ticket" aria-hidden="true"></i>&nbsp;<b><?php echo $dep[$key]; ?></b></p>
														<p class="inbox-item-text"><i class="fa fa-frown-o" aria-hidden="true"></i>&nbsp;<b><?php echo $question[$key]; ?></b></p>
													<?php } ?>
												<?php } ?>
												<?php foreach ($param->comment as $key => $value) {
													if ($value != '') {
												?>
														<p class="inbox-item-text" style="overflow: clip; word-break: break-all;"><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;<b><?php echo lang_loader('pcf','pcf_comment'); ?></b>:"<?php echo $value; ?>"</p>
												<?php
													}
												}
												?>

										</div>
									</a>
								<?php	} ?>
							<?php } ?>


						<?php } else { ?>
							<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('pcf','pcf_no_comment'); ?></h3>
						<?php	} ?>
						</div>

				</div>
			</div>

			<!-- /.row -->
		</div>
		<!-- /.row -->
	<?php } else {   ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('pcf','pcf_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>
</div>
<style>
	.panel-body {
		height: auto;
	}
</style>

<style>
	.progress {
		margin-bottom: 10px;
	}
</style>