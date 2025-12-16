<div class="content">
	<!-- alert message -->
	<!-- content -->
	<?php
	include 'info_buttons_ip.php';
	require 'ip_table_variables.php';


	$ip_psat = $this->opf_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $desc);
	$feedback = $ip_psat['unsatisfied_feedback'];
	foreach ($sresult as $r) {
		$questionarray[$r->shortkey] = $r->shortkey;
		$titles[$r->shortkey] = $r->title;
	}
	$rresult = $this->opf_model->setup_sub_result($setup);
	foreach ($rresult as $r) {
		// $setarray[$r->type] = $r->title;
		$setarray[$r->shortkey] = $r->shortkey;
		$titles[$r->shortkey] = $r->title;
		$shortname[$r->shortkey] = $r->shortname;
	}

	?>
	<?php if (count($feedback)) { ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<table class="oppsatunsatisfied table table-striped table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<th><?php echo lang_loader('op','op_slno'); ?></th>
								<th><?php echo lang_loader('op','op_date'); ?></th>
								<th style="white-space: nowrap;"><?php echo lang_loader('op','op_patient_details'); ?></th>
								<th><?php echo lang_loader('op','op_average'); ?><br><?php echo lang_loader('op','op_rating'); ?></th>
								<?php if (psat_unsatisfied_page('nps_score') == true) { ?>
									<th><?php echo lang_loader('op','op_nps'); ?><br> <?php echo lang_loader('op','op_score'); ?></th>
								<?php } ?>
								<?php if (psat_unsatisfied_page('department_rating') == true) { ?>
									<th><?php echo lang_loader('op','op_department'); ?></th>
								<?php } ?>
								<?php if (psat_unsatisfied_page('reason') == true) { ?>
									<th><?php echo lang_loader('op','op_concern'); ?></th>
								<?php } ?>
								<?php if (psat_unsatisfied_page('overall_comments') == true) { ?>
									<th><?php echo lang_loader('op','op_comment'); ?></th>
								<?php } ?>
							</thead>
							<?php $sl = 1;
							$i = 0; ?>
							<tbody>
								<?php foreach ($feedback as $unsatisfied) { ?>

									<?php $fid = array_keys($feedback); ?>
									<tr>
										<td>
											<?php echo $sl; ?>
										</td>
										<td style="white-space: nowrap;">
											<?php if ($unsatisfied->datetime) { ?>
												<?php echo date('g:i A', date(($unsatisfied->datetime) / 1000)); ?>
												<br>
												<?php echo date('d-m-y', date(($unsatisfied->datetime) / 1000)); ?>
											<?php } ?>
										</td>
										<td style="overflow: clip;">
											<?php echo $unsatisfied->name; ?> (<a href="<?php echo $ip_link_patient_feedback . $fid[$i]; ?>"><?php echo $unsatisfied->patientid; ?></a>)
											<br>
											<?php echo $unsatisfied->ward; ?>
											<?php if ($unsatisfied->bedno) { ?>

												<?php echo 'in ' . $unsatisfied->bedno; ?>
											<?php } ?>
											<br>
											<?php
											echo "<i class='fa fa-phone'></i> ";
											echo $unsatisfied->contactnumber; ?>
											<?php if ($unsatisfied->email) { ?>
												<br>
												<?php
												echo "<i class='fa fa-envelope'></i> ";
												echo $unsatisfied->email; ?>
											<?php } ?>
										</td>

										<td style="white-space: nowrap;">
											<?php echo (($unsatisfied->overallScore)); ?>
										</td>
										<?php if (psat_unsatisfied_page('nps_score') == true) { ?>
											<td style="white-space: nowrap;">
												<?php echo (($unsatisfied->recommend1Score) * 2); ?>
											</td>
										<?php } ?>

										<?php if (psat_unsatisfied_page('department_rating') == true) { ?>
											<td style="overflow: clip; word-break: break-all;">
												<?php
												foreach ($questionarray as $key) {
													if (isset($unsatisfied->$key) && $unsatisfied->$key <= 3) {
														$result->$key = $unsatisfied->$key;
														if ($result->$key) {
															echo '<li>';
															echo $titles[$key] . ' ';
															echo '</li>';
														}
													}
												}
												?>
											</td>
										<?php } ?>
										<?php if (psat_unsatisfied_page('reason') == true) { ?>
											<td style="overflow: clip; word-break: break-all;">
												<?php
												foreach ($setarray as $key2) {
													if (isset($unsatisfied->reason->$key2) && $unsatisfied->reason->$key2) {
														$rzn->$key2 = $unsatisfied->reason->$key2;
														if ($rzn->$key2) {
															echo '<li>';
															echo $shortname[$key2] . ' ';
															echo '</li>';
														}
													}
												}
												?>
											</td>
										<?php } ?>
										<?php if (psat_unsatisfied_page('overall_comments') == true) { ?>
											<td style="overflow: clip; word-break: break-all;">
												<?php echo ($unsatisfied->suggestionText); ?>
											</td>
										<?php } ?>
										<?php $sl = $sl + 1; ?>
										<?php $i++;
										$z++; ?>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		</table>
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
<style>
	.panel-body {
		height: auto;
		overflow: auto;
	}
</style>