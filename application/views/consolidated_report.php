<!--Code updates: 

Worked on UI allignment, fixed all the issues.

Last updated on 05-03-23 -->



<?php

$dates = get_from_to_date();

$fdate = $dates['fdate'];

$tdate = $dates['tdate'];

$pagetitle = $dates['pagetitle'];

$fdate = date('Y-m-d', strtotime($fdate));

$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));

$days = $dates['days'];

$num_of_modules = 0;

$num_of_modules_tickets = 0;



if (ismodule_active('IP') === true) {

	require_once 'ip_tables.php';
}
if (ismodule_active('PDF') === true) {

	require_once 'pdf_tables.php';
}

if (ismodule_active('OP') === true) {

	require_once 'op_tables.php';
}

if (ismodule_active('PCF') === true) {

	require_once 'interim_tables.php';
}

if (ismodule_active('ADF') === true) {

	require_once 'adf_tables.php';
}



if (ismodule_active('ISR') === true) {

	require_once 'esr_tables.php';
}



if (ismodule_active('INCIDENT') === true) {

	require_once 'incident_tables.php';
}



if (ismodule_active('GRIEVANCE') === true) {

	require_once 'grievance_tables.php';
}











$hosplogo = $this->db->select("logo,title")

	->get('setting')

	->row();



$logo_img['logo'] = $hosplogo->logo;

$logo_img['title'] = $hosplogo->title;



?>





<!-- content -->

<div class="content">





	<!-- START FOR SUPERADMIN AND ADMIN -->



	<div class="row">

		<div class="col-lg-12">



			<div class="panel panel-default" style="overflow:auto;" id="PrintMe">

				<div class="panel-heading no-print">

					<div class="btn-group">

						<button type="button" onclick="printContent('PrintMe')" style="float: right;" class="btn btn-success"><i class="fa fa-print"></i></button>

					</div>

				</div>





				<div class="panel-body">

					<div style="display: flex; justify-content: center; align-items: center; ">

						<img src="<?php echo !empty($logo_img) ? base_url('uploads/' . $logo_img['logo']) : null; ?>" style="height: 60px; width: 180px; margin-top:2px; margin-bottom: 0px;">

					</div>

					<h3 style="text-align:center; font-family: Arial, sans-serif;font-size:20px; margin-bottom: 1px; margin-top: 2px;font-weight: bold;"><?php echo strtoupper($logo_img['title']); ?></h3>

					<h3 style="text-align:center; font-family: Arial, sans-serif;font-size:20px; margin-bottom: 2px; margin-top: 0px;font-weight: bold;"><?php echo lang_loader('global', 'global_efeedor_consolidated_hexpr'); ?></h3>

					<?php

					$d1 = date('d/m/Y', strtotime($tdate));

					$d2 = date('d/m/Y', strtotime($fdate));

					?>

					<h5 style="text-align:right;"><b><?php echo lang_loader('global', 'global_showing_data_from'); ?> <?php echo $d1; ?> <?php echo lang_loader('global', 'global_to'); ?> <?php echo $d2; ?></b></h5>





					<table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

						<tr>

							<strong><?php echo lang_loader('global', 'global_overall_f_report'); ?></strong>

						</tr>

						<tr>

							<td><b><?php echo lang_loader('global', 'global_module'); ?></td>

							<td><b><?php echo lang_loader('global', 'global_total_feedbacks'); ?></b></td>

							<td><b><?php echo lang_loader('global', 'global_total_tickets'); ?></b></td>

							<td><b><?php echo lang_loader('global', 'global_nps'); ?></b></td>

							<td><b><?php echo lang_loader('global', 'global_psat'); ?></b></td>

						</tr>

						<!-- if condition  -->

						<?php if (ismodule_active('ADF') === true) {  ?>

							<tr>

								<?php $num_of_modules = $num_of_modules + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_admission_feedback'); ?></b></td>

								<td><?php echo count($adf_feedbacks_count); ?></td>

								<td><?php echo count($adf_tickets_count); ?></td>

								<td><?php echo $adf_nps['nps_score'] . '%'; ?></td>

								<td><?php echo $adf_psat['psat_score'] . '%'; ?></td>

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('IP') === true) {  ?>

							<tr>

								<?php $num_of_modules = $num_of_modules + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_inpatient_feedback'); ?></b></td>

								<td><?php echo count($ip_feedbacks_count); ?></td>

								<td><?php echo count($ip_tickets_count); ?></td>

								<td><?php echo $ip_nps['nps_score'] . '%'; ?></td>

								<td><?php echo $ip_psat['psat_score'] . '%'; ?></td>

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('PDF') === true) {  ?>

							<tr>

								<?php $num_of_modules = $num_of_modules + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_post_feedback'); ?></b></td>

								<td><?php echo count($pdf_feedbacks_count); ?></td>

								<td><?php echo count($pdf_tickets_count); ?></td>

								<td><?php echo $pdf_nps['nps_score'] . '%'; ?></td>

								<td><?php echo $pdf_psat['psat_score'] . '%'; ?></td>

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('OP') === true) {  ?>

							<tr>

								<?php $num_of_modules = $num_of_modules + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_otpatient_feedback'); ?></b></td>

								<td><?php echo count($op_feedbacks_count); ?></td>

								<td><?php echo count($op_tickets_count); ?></td>

								<td><?php echo $op_nps['nps_score'] . '%'; ?></td>

								<td><?php echo $op_psat['psat_score'] . '%'; ?></td>

							</tr>

						<?php  } ?>



						<tr>

							<td><b><?php echo lang_loader('global', 'global_total'); ?></b></td>

							<td><?php echo count($op_feedbacks_count) + count($adf_feedbacks_count) + count($ip_feedbacks_count); ?></td>

							<td><?php echo count($op_tickets_count) + count($adf_tickets_count) + count($ip_tickets_count); ?></td>

							<td><?php echo round(($op_nps['nps_score'] + $ip_nps['nps_score'] + $adf_nps['nps_score']) / $num_of_modules) . '%'; ?></td>

							<td><?php echo round(($op_psat['psat_score'] + $adf_psat['psat_score'] + $ip_psat['psat_score']) / $num_of_modules) . '%'; ?></td>

						</tr>

					</table>





					<table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

						<tr>

							<strong><?php echo lang_loader('global', 'global_overall_ps_analysis'); ?></strong>

						</tr>

						<tr>



							<td><b><?php echo lang_loader('global', 'global_module'); ?></td>

							<td><b><?php echo lang_loader('global', 'global_total_feedbacks'); ?></b></td>

							<td><b><?php echo lang_loader('global', 'global_satisfied'); ?></b></td>

							<td><b><?php echo lang_loader('global', 'global_unsatisfied'); ?></b></td>

							<td><b><?php echo lang_loader('global', 'global_psat'); ?></b></td>



							<!-- <td>PSAT</td> -->

						</tr>

						<!-- if condition  -->

						<?php if (ismodule_active('ADF') === true) {  ?>

							<tr>

								<?php $num_of_modules_psat = $num_of_modules_psat + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_admission_feedback'); ?></b></td>

								<td><?php echo count($adf_feedbacks_count); ?></td>

								<td><?php echo $adf_psat['satisfied_count']; ?></td>

								<td><?php echo $adf_psat['unsatisfied_count']; ?></td>

								<td><?php echo $adf_psat['psat_score'] . '%'; ?></td>

								<!-- <td>PSAT</td> -->

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('IP') === true) {  ?>

							<tr>

								<?php $num_of_modules_psat = $num_of_modules_psat + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_inpatient_feedback'); ?></b></td>

								<td><?php echo count($ip_feedbacks_count); ?></td>

								<td><?php echo $ip_psat['satisfied_count']; ?></td>

								<td><?php echo $ip_psat['unsatisfied_count']; ?></td>

								<td><?php echo $ip_psat['psat_score'] . '%'; ?></td>

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('PDF') === true) {  ?>

							<tr>

								<?php $num_of_modules_psat = $num_of_modules_psat + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_post_feedback'); ?></b></td>

								<td><?php echo count($pdf_feedbacks_count); ?></td>

								<td><?php echo $pdf_psat['satisfied_count']; ?></td>

								<td><?php echo $pdf_psat['unsatisfied_count']; ?></td>

								<td><?php echo $pdf_psat['psat_score'] . '%'; ?></td>

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('OP') === true) {  ?>

							<tr>

								<?php $num_of_modules_psat = $num_of_modules_psat + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_otpatient_feedback'); ?></b></td>

								<td><?php echo count($op_feedbacks_count); ?></td>

								<td><?php echo $op_psat['satisfied_count']; ?></td>

								<td><?php echo $op_psat['unsatisfied_count']; ?></td>

								<td><?php echo $op_psat['psat_score'] . '%'; ?></td>

								<!-- <td>PSAT</td> -->

							</tr>

						<?php  } ?>



						<tr>

							<td><b><?php echo lang_loader('global', 'global_total'); ?></b></td>

							<td><?php echo count($op_feedbacks_count) + count($adf_feedbacks_count) + count($ip_feedbacks_count); ?></td>

							<td><?php echo round(($op_psat['satisfied_count'] + $ip_psat['satisfied_count'] + $adf_psat['satisfied_count'])); ?></td>

							<td><?php echo round(($op_psat['unsatisfied_count'] + $ip_psat['unsatisfied_count'] + $adf_psat['unsatisfied_count'])); ?></td>

							<td><?php echo round(($op_psat['psat_score'] + $ip_psat['psat_score'] + $adf_psat['psat_score']) / $num_of_modules_psat) . '%'; ?></td>

						</tr>



					</table>







					<table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

						<tr>

							<strong><?php echo lang_loader('global', 'global_overall_np_analysis'); ?></strong>

						</tr>

						<tr>



							<td><b><?php echo lang_loader('global', 'global_module'); ?></td>

							<td><b><?php echo lang_loader('global', 'global_total_feedbacks'); ?></b></td>

							<td><b><?php echo lang_loader('global', 'global_promoters'); ?></b></td>

							<td><b><?php echo lang_loader('global', 'global_passives'); ?></b></td>

							<td><b><?php echo lang_loader('global', 'global_detractors'); ?></b></td>

							<td><b><?php echo lang_loader('global', 'global_nps'); ?></b></td>



							<!-- <td>PSAT</td> -->

						</tr>

						<!-- if condition  -->

						<?php if (ismodule_active('ADF') === true) {  ?>

							<tr>

								<?php $num_of_modules_nps = $num_of_modules_nps + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_admission_feedback'); ?></b></td>

								<td><?php echo count($adf_feedbacks_count); ?></td>

								<td><?php echo $adf_nps['promoters_count']; ?></td>

								<td><?php echo $adf_nps['passives_count']; ?></td>

								<td><?php echo $adf_nps['detractors_count']; ?></td>

								<td><?php echo $adf_nps['nps_score'] . '%'; ?></td>

								<!-- <td>PSAT</td> -->

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('IP') === true) {  ?>

							<tr>

								<?php $num_of_modules_nps = $num_of_modules_nps + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_inpatient_feedback'); ?></b></td>

								<td><?php echo count($ip_feedbacks_count); ?></td>

								<td><?php echo $ip_nps['promoters_count']; ?></td>

								<td><?php echo $ip_nps['passives_count']; ?></td>

								<td><?php echo $ip_nps['detractors_count']; ?></td>

								<td><?php echo $ip_nps['nps_score'] . '%'; ?></td>

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('PDF') === true) {  ?>

							<tr>

								<?php $num_of_modules_nps = $num_of_modules_nps + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_post_feedback'); ?></b></td>

								<td><?php echo count($pdf_feedbacks_count); ?></td>

								<td><?php echo $pdf_nps['promoters_count']; ?></td>

								<td><?php echo $pdf_nps['passives_count']; ?></td>

								<td><?php echo $pdf_nps['detractors_count']; ?></td>

								<td><?php echo $pdf_nps['nps_score'] . '%'; ?></td>

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('OP') === true) {  ?>

							<tr>

								<?php $num_of_modules_nps = $num_of_modules_nps + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_otpatient_feedback'); ?></b></td>

								<td><?php echo count($op_feedbacks_count); ?></td>

								<td><?php echo $op_nps['promoters_count']; ?></td>

								<td><?php echo $op_nps['passives_count']; ?></td>

								<td><?php echo $op_nps['detractors_count']; ?></td>

								<td><?php echo $op_nps['nps_score'] . '%'; ?></td>

								<!-- <td>PSAT</td> -->

							</tr>

						<?php  } ?>



						<tr>

							<td><b><?php echo lang_loader('global', 'global_total'); ?></b></td>

							<td><?php echo count($op_feedbacks_count) + count($adf_feedbacks_count) + count($ip_feedbacks_count); ?></td>

							<td><?php echo round(($op_nps['promoters_count'] + $ip_nps['promoters_count'] + $adf_nps['promoters_count'])); ?></td>

							<td><?php echo round(($op_nps['passives_count'] + $ip_nps['passives_count'] + $adf_nps['passives_count'])); ?></td>

							<td><?php echo round(($op_nps['detractors_count'] + $ip_nps['detractors_count'] + $adf_nps['detractors_count'])); ?></td>

							<td><?php echo round(($op_nps['nps_score'] + $ip_nps['nps_score'] + $adf_nps['nps_score']) / $num_of_modules_nps) . '%'; ?></td>

							<!-- <td>PSAT</td> -->



						</tr>



					</table>





					<table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

						<tr>

							<strong><?php echo lang_loader('global', 'global_overall_t_report'); ?></strong>

						</tr>

						<tr>

							<td><b><?php echo lang_loader('global', 'global_module'); ?></td>

							<td><b><?php echo lang_loader('global', 'global_total_tickets'); ?></b></td>

							<td><b><?php echo lang_loader('global', 'global_open'); ?> </b></td>

							<td><b><?php echo lang_loader('global', 'global_addressed'); ?> </b></td>

							<td><b><?php echo lang_loader('global', 'global_closed'); ?> </b></td>

							<td><b><?php echo lang_loader('global', 'global_ticket_r_rate'); ?> </b></td>

							<td><b><?php echo lang_loader('global', 'global_avg_r_time'); ?></b></td>

						</tr>

						<!-- if condition  -->

						<?php if (ismodule_active('ADF') === true) {  ?>

							<tr>

								<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_admission_feedback'); ?></b></td>

								<td><?php echo count($adfalltickets); ?></td>

								<td><?php echo count($adfopentickets); ?></td>

								<td><?php echo count($adfaddressed); ?></td>

								<td><?php echo count($adfclosedtickets); ?></td>

								<td><?php echo $ticket_resolution_rate_adf . '%'; ?></td>

								<td><?php echo $ticket_close_rate_adf; ?></td>

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('IP') === true) {  ?>

							<tr>

								<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_inpatient_feedback'); ?></b></td>

								<td><?php echo count($ip_tickets_count); ?></td>

								<td><?php echo count($ip_open_tickets) + count($ip_reopen_tickets); ?></td>

								<td><?php echo count($ip_addressed_tickets); ?></td>

								<td><?php echo count($ip_closed_tickets); ?></td>

								<td><?php echo $ticket_resolution_rate_ip . '%';  ?></td>

								<td><?php echo $ticket_close_rate_ip; ?></td>

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('PDF') === true) {  ?>

							<tr>

								<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_post_feedback'); ?></b></td>

								<td><?php echo count($pdf_tickets_count); ?></td>

								<td><?php echo count($pdf_open_tickets) + count($pdf_reopen_tickets); ?></td>

								<td><?php echo count($pdf_addressed_tickets); ?></td>

								<td><?php echo count($pdf_closed_tickets); ?></td>

								<td><?php echo $ticket_resolution_rate_ip . '%';  ?></td>

								<td><?php echo $ticket_close_rate_ip; ?></td>

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('PCF') === true) {  ?>

							<tr>

								<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_inp_complaints'); ?></b></td>

								<td><?php echo count($int_tickets_count); ?></td>

								<td><?php echo count($int_open_tickets) + count($int_reopen_tickets); ?></td>

								<td><?php echo count($int_addressed_tickets); ?></td>

								<td><?php echo count($int_closed_tickets); ?></td>

								<td><?php echo $ticket_resolution_rate_int . '%';  ?></td>

								<td><?php echo $ticket_close_rate_int; ?></td>

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('OP') === true) {  ?>

							<tr>

								<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_otpatient_feedback'); ?></b></td>

								<td><?php echo count($op_tickets_count); ?></td>

								<td><?php echo count($op_open_tickets) + count($op_reopen_tickets); ?></td>

								<td><?php echo count($op_addressed_tickets); ?></td>

								<td><?php echo count($op_closed_tickets); ?></td>

								<td><?php echo $ticket_resolution_rate_op . '%';  ?></td>

								<td><?php echo $ticket_close_rate_op; ?></td>

							</tr>

						<?php  } ?>

						<?php if (ismodule_active('ISR') === true) {  ?>

							<tr>

								<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_ir_request'); ?></b></td>

								<td><?php echo count($esr_tickets_count); ?></td>

								<td><?php echo count($esr_open_tickets) + count($esr_reopen_tickets); ?></td>

								<td><?php echo count($esr_addressed_tickets); ?></td>

								<td><?php echo count($esr_closed_tickets); ?></td>

								<td><?php echo $ticket_resolution_rate_esr . '%';  ?></td>

								<td><?php echo $ticket_close_rate_esr; ?></td>

							</tr>

						<?php  } ?>





						<?php if (ismodule_active('INCIDENT') === true) {  ?>

							<tr>

								<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_incidents'); ?></b></td>

								<td><?php echo count($incident_tickets_count); ?></td>

								<td><?php echo count($incident_open_tickets) + count($esr_reopen_tickets); ?></td>

								<td><?php echo count($incident_addressed_tickets); ?></td>

								<td><?php echo count($incident_closed_tickets); ?></td>

								<td><?php echo $ticket_resolution_rate_incident . '%';  ?></td>

								<td><?php echo $ticket_close_rate_incident; ?></td>

							</tr>

						<?php  } ?>





						<?php if (ismodule_active('GRIEVANCE') === true) {  ?>

							<tr>

								<?php $num_of_modules_tickets = $num_of_modules_tickets + 1; ?>

								<td><b><?php echo lang_loader('global', 'global_g_report'); ?></b></td>

								<td><?php echo count($grievance_tickets_count); ?></td>

								<td><?php echo count($grievance_open_tickets) + count($esr_reopen_tickets); ?></td>

								<td><?php echo count($grievance_addressed_tickets); ?></td>

								<td><?php echo count($grievance_closed_tickets); ?></td>

								<td><?php echo $ticket_resolution_rate_grievance . '%';  ?></td>

								<td><?php echo $ticket_close_rate_grievance; ?></td>

							</tr>

						<?php  } ?>



						<tr>

							<td><b><?php echo lang_loader('global', 'global_total'); ?></b></td>

							<td><?php echo count($op_tickets_count) + count($adf_tickets_count) + count($int_tickets_count) + count($esr_tickets_count) + count($ip_tickets_count); ?></td>

							<td><?php echo count($op_open_tickets) + count($adf_open_tickets) + count($int_open_tickets) + count($ip_open_tickets) + count($esr_open_tickets) + count($op_reopen_tickets) + count($adf_reopen_tickets) + count($int_reopen_tickets) + count($ip_reopen_tickets); ?></td>

							<td><?php echo count($op_addressed_tickets) + count($int_addressed_tickets) + count($ip_addressed_tickets) + count($esr_addressed_tickets) + count($adf_addressed_tickets); ?></td>

							<td><?php echo count($op_closed_tickets) + count($int_closed_tickets) + count($esr_closed_tickets) + count($ip_closed_tickets) + count($adf_closed_tickets); ?></td>

							<td><?php echo round(($ticket_resolution_rate_op + $ticket_resolution_rate_ip + $ticket_resolution_rate_adf + $ticket_resolution_rate_int + $ticket_resolution_rate_esr) / $num_of_modules_tickets) . '%'; ?></td>

							<?php $total_close_rate = (($close_rate_adf + $close_rate_ip + $close_rate_int + $close_rate_op + $close_rate_esr) / $num_of_modules_tickets);



							$val_rate = secondsToTime($total_close_rate);

							?>



							<td><?php echo $val_rate; ?></td>

							<!-- <td>PSAT</td> -->



						</tr>



					</table>







				</div>







				<!-- Close Metric Boxes-->

			</div>

		</div>

	</div>





	<?php // } 

	?>

	<!-- FOR SUPERADMIN AND ADMIN -->



</div>