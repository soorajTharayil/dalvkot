<div class="content">
	<!-- content -->
	<?php
	include 'info_buttons_ip.php';
	require 'ip_table_variables.php';
	$ip_nps = $this->ipd_model->nps_analytics($table_feedback, $desc, $setup);
	$feedback = $ip_nps['passives_feedback'];
	?>
	<?php if (count($feedback)) { ?>
		<div class="row">
			<!-- Total Product Sales area -->

			<div class="col-lg-12">
				<div class="panel panel-default">

					<div class="panel-body">

						<table class="ipnpspassive table table-striped table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
								<th><?php echo lang_loader('ip','ip_slno'); ?></th>
								<th><?php echo lang_loader('ip','ip_date'); ?></th>
								<th style="white-space: nowrap;"><?php echo lang_loader('ip','ip_patient_details'); ?></th>
								<th><?php echo lang_loader('ip','ip_nps_score_7_8'); ?></th>
								<?php if (nps_passives_page('avg_rating') == true) { ?>
									<th><?php echo lang_loader('ip','ip_average_rating'); ?></th>
								<?php } ?>

								<?php if (nps_passives_page('nps_comment') == true) { ?>
									<th><?php echo lang_loader('ip','ip_nps_comment'); ?></th>
								<?php } ?>
								
								<?php if (nps_passives_page('overall_comments') == true) { ?>
									<th><?php echo lang_loader('ip','ip_comment'); ?></th>
								<?php } ?>
							</thead>
							<?php $sl = 1;
							$i = 0; ?>
							<tbody>
								<?php foreach ($feedback as $detractor) { ?>

									<?php $fid = array_keys($feedback); ?>
									<tr>
										<td>
											<?php echo $sl; ?>
										</td>
										<td style="white-space: nowrap;">
											<?php if ($detractor->datetime) { ?>
												<?php echo date('g:i A', date(($detractor->datetime) / 1000)); ?>
												<br>
												<?php echo date('d-m-y', date(($detractor->datetime) / 1000)); ?>
											<?php } ?>
										</td>
										<td style="overflow: clip;">
											<?php echo $detractor->name; ?> (<a href="<?php echo $ip_link_patient_feedback . $fid[$i]; ?>"><?php echo $detractor->patientid; ?></a>)
											<br>
											<?php echo $detractor->ward; ?>
											<?php if ($detractor->bedno) { ?>

												<?php echo 'in ' . $detractor->bedno; ?>
											<?php } ?>
											<br>
											<?php
											echo "<i class='fa fa-phone'></i> ";
											echo $detractor->contactnumber; ?>
											<?php if ($detractor->email) { ?>
												<br>
												<?php
												echo "<i class='fa fa-envelope'></i> ";
												echo $detractor->email; ?>
											<?php } ?>
										</td>
										<td>
											<?php echo (($detractor->recommend1Score) * 2); ?>
										</td>
										<?php if (nps_passives_page('avg_rating') == true) { ?>
											<td style="overflow: clip; word-break: break-all;">
												<?php echo ($detractor->overallScore); ?>
											</td>
										<?php } ?>

										<?php if (nps_passives_page('nps_comment') == true) { ?>
											<td style="overflow: clip; word-break: break-all;">
												<?php echo ($detractor->passivecomment); ?>
											</td>
										<?php } ?>

										<?php if (nps_passives_page('overall_comments') === true) { ?>
											<td style="overflow: clip; word-break: break-all;">
												<?php echo ($detractor->suggestionText); ?>
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

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('ip','ip_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>

</div>
<style>
	.panel-body {
		height: auto;
		overflow: auto;
	}
</style>