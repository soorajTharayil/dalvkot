<div class="content">

	<!-- alert message -->
	<!-- content -->
	<?php
	include 'info_buttons_ip.php';
	require 'ip_table_variables.php';

	$ip_nps = $this->admissionfeedback_model->nps_analytics($table_feedback, $desc, $setup);
	// print_r($ip_nps);
	$feedback = $ip_nps['promoters_feedbacks'];

	// print_r($ip_nps);
	if (($feedback)) {

	?>

		<div class="row">
			<!-- Total Product Sales area -->

			<div class="col-lg-12">
				<div class="panel panel-default">

					<div class="panel-body">
						<table class="ipnpspromoters table table-striped table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<th><?php echo lang_loader('adf', 'adf_slno'); ?></th>
								<th><?php echo lang_loader('adf', 'adf_date'); ?></th>
								<th style="white-space: nowrap;"><?php echo lang_loader('adf', 'adf_patient_details'); ?>
								</th>
								<th><?php echo lang_loader('adf', 'adf_nps_score_9_10'); ?></th>
								<?php if (nps_promoters_page('avg_rating') == true) { ?>
									<th><?php echo lang_loader('adf', 'adf_average_rating'); ?></th>
								<?php } ?>

								<?php if (nps_promoters_page('nps_comment') == true) { ?>
									<th><?php echo lang_loader('adf', 'adf_nps_comment'); ?></th>
								<?php } ?>

								<?php if (nps_promoters_page('overall_comments') == true) { ?>
									<th><?php echo lang_loader('adf', 'adf_comment'); ?></th>
								<?php } ?>
							</thead>
							<?php $sl = 1;
							$i = 0; ?>
							<tbody>
								<?php foreach ($feedback as $promoter) { ?>

									<?php $fid = array_keys($feedback); ?>
									<tr>
										<td>
											<?php echo $sl; ?>
										</td>
										<td style="white-space: nowrap;">
											<?php if ($promoter->datetime) { ?>
												<?php echo date('g:i A', date(($promoter->datetime) / 1000)); ?>
												<br>
												<?php echo date('d-m-y', date(($promoter->datetime) / 1000)); ?>
											<?php } ?>
										</td>
										<td style="overflow: clip;">
											<?php echo $promoter->name; ?> (<a href="<?php echo $ip_link_patient_feedback . $fid[$i]; ?>"><?php echo $promoter->patientid; ?></a>)
											<br>
											<?php echo $promoter->ward; ?>
											<?php if ($promoter->bedno) { ?>

												<?php echo 'in ' . $promoter->bedno; ?>
											<?php } ?>
											<br>
											<?php
											echo "<i class='fa fa-phone'></i> ";
											echo $promoter->contactnumber; ?>
											<?php if ($promoter->email) { ?>
												<br>
												<?php
												echo "<i class='fa fa-envelope'></i> ";
												echo $promoter->email; ?>
											<?php } ?>
										</td>
										<td>
											<?php echo (($promoter->recommend1Score) * 2); ?>
										</td>
										<?php if (nps_promoters_page('avg_rating') == true) { ?>
											<td style="overflow: clip; word-break: break-all;">
												<?php echo ($promoter->overallScore); ?>
											</td>
										<?php } ?>

										<?php if (nps_promoters_page('nps_comment') == true) { ?>
											<td style="overflow: clip; word-break: break-all;">
												<?php echo ($promoter->promotercomment); ?>
											</td>
										<?php } ?>

										<?php if (nps_promoters_page('overall_comments') === true) { ?>
											<td style="overflow: clip; word-break: break-all;">
												<?php echo ($promoter->suggestionText); ?>
											</td>
										<?php } ?>
										<?php $sl = $sl + 1; ?>
										<?php $i++; ?>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<?php } else {   ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('adf', 'adf_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>
</div>
</div>
<style>
	.panel-body {
		height: auto;
		overflow: auto;
	}
</style>