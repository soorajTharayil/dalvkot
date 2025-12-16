<!-- content -->
<div class="content">
	<!-- alert message -->
	<!-- content -->


	<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
	<script src="<?php echo base_url(); ?>assets/utils.js"></script>


	<!-- PHP Code {-->

	<?php

	include 'info_buttons_ip.php';
	require 'ip_table_variables.php'; 


	$all_tickets = $this->doctorsopdfeedback_model->get_tickets($table_feedback, $table_tickets);
	$feedbacktaken = $this->doctorsopdfeedback_model->patient_and_feedback($table_patients, $table_feedback, $desc);
	$sresult = $this->doctorsopdfeedback_model->setup_result($setup);
	foreach ($sresult as $r2) {
		$setarray[$r2->type] = $r2->title;
	}

	// $hi = $this->doctorsopdfeedback_model->comm($table_patients, $table_feedback, $desc, $setup, $type);

	if (($feedbacktaken)) {
	?>



		<div class="row" style="display: none;">
			<!-- Total Product Sales area -->

			<div class="col-lg-12 col-sm-12 col-md-12" style="overflow:auto;">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3><?php echo lang_loader('op','op_patient_comment_analysis'); ?><a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="<?php //echo $patientfeedbackanalysis_tooltip; 
																																		?> hi"> <i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
					</div>
					<div class="panel-body" style="height: 450px;" id="word">

						<div class="btn-group" style="float: right;		display: flex;">
							<button id="dropdownButton" type="button" style="border: none; width:200px;" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?php echo lang_loader('op','op_general_comment'); ?> <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>
							</button>
							<ul class="dropdown-menu" id="wordcloudDropdown" style="text-align: left; width:100%;">

								<?php
								echo '<li><a class="dropdown-item" href="#" onclick="handleDropdownChange(\'\')" data-value="">General comment</a></li>';
								foreach ($sresult as $data) {
									echo '<li><a class="dropdown-item" href="#" onclick="handleDropdownChange(\'' . $data->type . '\')" data-value="' . $data->type . '">' . $data->title . ' comment</a></li>';
								}
								?>

							</ul>
						</div>
						<br>
						<!-- <canvas id="comment_ip"></canvas> -->
						<div class="inbox-item" style="width:100%; ">

							<p class="inbox-item-text" style="margin-top: 2px; margin-left: 5px;margin-bottom:2px;font-size:13px;"><?php echo lang_loader('op','op_peaple_often_mention'); ?></p>
							<p class="inbox-item-text" id="wordLabel"></p>

						</div>
						<div class="message_inner coment-cloud">
							<canvas id="comment_ip"></canvas>
						</div>

					</div>
				</div>
			</div>
		</div>







		<div class="row">
			<!-- Total Product Sales area -->

			<div class="col-lg-12">
				<div class="panel panel-default">

					<div class="panel-heading" style="text-align: right;">
						<div class="btn-group">
							<a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="Download comments?" href="<?php echo base_url($this->uri->segment(1)) . '/downloadcomments' ?>">
								<i class="fa fa-file-text"></i>
							</a>
						</div>
					</div>



					<div class="panel-body">

						<?php
						foreach ($feedbacktaken as $r) {

							$param = json_decode($r->dataset);
							if (($param->suggestionText != '' && $param->suggestionText != NULL) || count($param->comment) > 0) { ?>
								<a href="<?php echo  $ip_link_patient_feedback . $r->id; ?>">

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

											<?php foreach ($param->comment as $key => $value) {
												if ($value != '') {
											?>
													<p class="inbox-item-text"><b><?php echo $setarray[$key]; ?></b>: <?php echo $value; ?></p>
											<?php
												}
											}
											?>
											<?php if ($param->suggestionText != '' && $param->suggestionText != NULL) { ?>
												<p class="inbox-item-text" style="overflow: clip; word-break: break-all;"><b><?php echo lang_loader('op','op_comment'); ?></b>: <?php echo $param->suggestionText; ?></p>
											<?php } ?>
									</div>
								</a>
							<?php	} ?>
						<?php } ?>



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

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('op','op_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?php echo base_url(); ?>assets/efeedor_doctor_chart.js"></script>


<style>
	.panel-body {
		height: auto;
	}

	.progress {
		margin-bottom: 10px;
	}

	.coment-cloud {
		display: flex;
		justify-content: center;
		align-items: center;
		overflow: auto;
		/* width: 100%;
			height: 50%; */
		margin-bottom: 5px;
		margin-top: 5px;
	}

	.dropdown-menu>li>a {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		width: 100%;
		display: block;
		/* Ensure the anchor element takes up full width */
	}


	.dropdown-menu>.li {
		width: 100%;
		border: 0px;
		border-bottom: 1px solid #ccc;
		text-align: left;
	}

	@media screen and (max-width: 1024px) {
		#word {
			overflow-x: scroll;
		}
	}
</style>