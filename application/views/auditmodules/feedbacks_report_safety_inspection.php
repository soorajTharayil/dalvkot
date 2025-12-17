<div class="content">
	<!-- content -->
	<?php
	include 'info_buttons_ip.php';
	include 'audit_tables.php';


	/* START DATE AND CALENDER */
	$dates = get_from_to_date();
	$pagetitle = $dates['pagetitle'];
	$fdate = $dates['fdate'];
	$tdate = $dates['tdate'];
	$pagetitle = $dates['pagetitle'];
	$fdate = date('Y-m-d', strtotime($fdate));
	$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
	$days = $dates['days'];
	/* END DATE AND CALENDER */

	$table_feedback = 'bf_feedback_safety_inspection';
	$table_patients = 'bf_patients';
	$sorttime = 'asc';
	$setup = 'setup';
	$asc = 'asc';
	$desc = 'desc';

	$feedbacktaken = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $desc);
	$ip_feedbacks_count = $this->audit_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
	if ($feedbacktaken) {


	?>

		<div class="row">

			<!-- Audit details -->
			<div class="col-lg-12 col-sm-12">
				<div class="panel panel-default">

					<div class="panel-heading">
						<strong>Audit Details</strong>
					</div>

					<div class="panel-body" style="font-size:14px; line-height:1.5;">

						<?php
						// Frequency (case-insensitive by title)
						$auditTitle = 'Facility safety inspection audit';
						$norm = mb_strtolower($auditTitle, 'UTF-8');

						$row = $this->db->select('frequency, target')
							->from('bf_audit_frequency')
							->where("LOWER(title) = " . $this->db->escape($norm), NULL, FALSE)
							->limit(1)->get()->row();

						$freq   = $row ? $row->frequency : 'N/A';


						// Load all users
						$users = $this->db->select('user.*, roles.role_id')
							->join('roles', 'user.user_role = roles.role_id')
							->order_by('roles.role_id', 'asc')
							->get('user')->result();

						// Per-user permission check (example feature: AUDIT-FORM1)
						$custodian_names = [];
						if (!empty($users)) {
							foreach ($users as $user) {
								$this->db->from('user_permissions as UP');
								$this->db->select('F.feature_name');
								$this->db->join('features as F', 'UP.feature_id = F.feature_id');
								$this->db->where('UP.user_id', $user->user_id);
								$this->db->where('UP.status', 1);
								$perms = $this->db->get()->result();

								foreach ($perms as $p) {
									if (strcasecmp(trim($p->feature_name), 'AUDIT-FORM22') === 0) {
										$custodian_names[] = htmlspecialchars($user->firstname, ENT_QUOTES, 'UTF-8');
										break;
									}
								}
							}
						}
						$custodian_names = array_unique($custodian_names);

						// Last audit date (using your current array shape)
						$lastDate = (!empty($feedbacktaken) && !empty($feedbacktaken[0]->datet))
							? date('d-M-Y', strtotime($feedbacktaken[0]->datet))
							: 'N/A';
						?>

						<table class="table table-bordered table-condensed" style="margin:0;">
							<tbody>
								<tr>
									<th style="width:240px;">Audit Definition</th>
									<td>Audits hospital facility safety—stairways, corridors, lighting, electricals, fire safety, cleanliness & signage—to prevent accidents and ensure compliance with NABH, JCI, CAHO & safety standards.</td>
								</tr>
								<tr>
									<th>Audit Frequency</th>
									<td>
										<?= htmlspecialchars($freq, ENT_QUOTES, 'UTF-8'); ?>

									</td>
								</tr>
								<tr>
									<th>Last Audit Date</th>
									<td><?= $lastDate; ?></td>
								</tr>
								<tr>
									<th>Audit Custodians</th>
									<td><?= !empty($custodian_names) ? implode(', ', $custodian_names) : 'N/A'; ?></td>
								</tr>
							</tbody>
						</table>

					</div>

				</div>
			</div>


			<div class="col-lg-12 col-sm-12">
				<div class="panel panel-default">
					<div style="float: right; margin-top: 10px; margin-right: 10px;">
						<span style="font-size:17px"><strong>Download Chart:</strong></span>
						<span style="margin-right: 10px;">
							<i data-placement="bottom" class="fa fa-file-pdf-o" style="font-size: 20px; color: red; cursor: pointer;"
								onclick="printChart()" data-toggle="tooltip" title="Download Chart as PDF"></i>
						</span>
						<span>
							<i data-placement="bottom" class="fa fa-file-image-o" style="font-size: 20px; color: green; cursor: pointer;"
								onclick="downloadChartImage()" data-toggle="tooltip"
								title="Download Chart as Image"></i>
						</span>
					</div>
					<div class="alert alert-dismissible" role="alert" style="margin-bottom: -12px;">
						<span class="p-l-30 p-r-30" style="font-size: 15px">
							<?php $text = "In the " .  $dates['pagetitle'] . "," . "a total of " . count($ip_feedbacks_count) . " audits were conducted." ?>
							<span class="typing-text"></span>
						</span>
						<span id="audit-report-text" style="display: none;">
							<?php echo "In the " . $dates['pagetitle'] . ", a total of " . count($ip_feedbacks_count) . " audits were conducted."; ?>
						</span>
					</div>
					<div class="panel-body" style="height:250px;" id="bar">
						<div class="message_inner line_chart">
							<canvas id="resposnsechart"></canvas>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>St. Thomas Ward</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="stairways table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>
							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							<th>Is there sufficient oxygen in the cylinders?</th>
							<th>Is the RO water changed regularly and dated?</th>
							<th>Is there an oxygen cylinder monitoring chart?</th>
							<th>Is there a trolley/stand provided for the oxygen cylinder?</th>

							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>

							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>

							<th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>

							<th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>

							<th>Are all medicines as per the list available?</th>
							<th>Are the medicines within 2 months of expiry or near expiry?</th>
							<th>Are there no expired or over-dated medicines?</th>
							<th>Are additional or extra medicines present (mismatches in the stock)?</th>
							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>

							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>

							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>

							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>

							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "St.Thomas Ward") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';

								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								//STAIRWAYS

								echo '<td>' . (isset($data->{'obstruction_stairways_St.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'obstruction_stairways_St.Thomas Ward_' . $location}) : '') . '</td>';


								echo '<td>' . (isset($data->{'slipperySt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'slipperySt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'railsSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_St.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'obstruction_corridor_St.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'floors_slipSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'avoid_fallsSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'carpetSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'warning_signagesSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'natural_lightSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'illuminationSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'glareSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'night_lightsSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'plug_pointsSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'cords_damagedSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'cables_exposedSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'safety_matsSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'fire_preventSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'cords_conditionsSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'sufficient_oxygenSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'ro_waterSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'cylinder_chartSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'cylinder_standSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'containers_codedSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'containers_closedSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'biohazardSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'segregationSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'containers_fillSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'kit_accessibleSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'items_presentSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeSt.Thomas Ward_' . $location}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'vial_needleSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'opening_dateSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'storageSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'vial_expireSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'temperature_chartSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'temperature_limitsSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'freezing_doneSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'medical_itemsSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'expired_medicineSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'medicines_availSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'medicines_near_expSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'overdatedSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'extra_medicinesSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'hazardous_materialSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'msds_sheetSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'workplace_storageSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_availSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'safety_trainedSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'exit_routeSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'fire_doorsSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'exit_signagesSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'use_ppeSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'staff_trainedSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'safety_devicesSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'work_station_neatSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'washroom_checklistSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'signages_placedSt.Thomas Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionSt.Thomas Ward_' . $location}) ? htmlspecialchars($data->{'missionSt.Thomas Ward_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>St. Alphonsa Ward</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="alphonsa table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>
							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							<th>Is there sufficient oxygen in the cylinders?</th>
							<th>Is the RO water changed regularly and dated?</th>
							<th>Is there an oxygen cylinder monitoring chart?</th>
							<th>Is there a trolley/stand provided for the oxygen cylinder?</th>
							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>
							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>
							<th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>
							<th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>
							<th>Are all medicines as per the list available?</th>
							<th>Are the medicines within 2 months of expiry or near expiry?</th>
							<th>Are there no expired or over-dated medicines?</th>
							<th>Are additional or extra medicines present (mismatches in the stock)?</th>
							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "St.Alphonsa Ward") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';



								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_St.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'obstruction_stairways_St.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperySt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'slipperySt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'railsSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_St.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'obstruction_corridor_St.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'floors_slipSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'avoid_fallsSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'carpetSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'warning_signagesSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'natural_lightSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'illuminationSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'glareSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'night_lightsSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'plug_pointsSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'cords_damagedSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'cables_exposedSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'safety_matsSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'fire_preventSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'cords_conditionsSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'sufficient_oxygenSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'ro_waterSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'cylinder_chartSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'cylinder_standSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'containers_codedSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'containers_closedSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'biohazardSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'segregationSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'containers_fillSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'kit_accessibleSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'items_presentSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'vial_needleSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'opening_dateSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'storageSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'vial_expireSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'temperature_chartSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'temperature_limitsSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'freezing_doneSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'medical_itemsSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'expired_medicineSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'medicines_availSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'medicines_near_expSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'overdatedSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'extra_medicinesSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'hazardous_materialSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'msds_sheetSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'workplace_storageSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_availSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'safety_trainedSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'exit_routeSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'fire_doorsSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'exit_signagesSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'use_ppeSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'staff_trainedSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'safety_devicesSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'work_station_neatSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'washroom_checklistSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'signages_placedSt.Alphonsa Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionSt.Alphonsa Ward_' . $location}) ? htmlspecialchars($data->{'missionSt.Alphonsa Ward_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>St. Martins Ward</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="martins table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>
							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							<th>Is there sufficient oxygen in the cylinders?</th>
							<th>Is the RO water changed regularly and dated?</th>
							<th>Is there an oxygen cylinder monitoring chart?</th>
							<th>Is there a trolley/stand provided for the oxygen cylinder?</th>
							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>
							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>
							<th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>
							<th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>
							<th>Are all medicines as per the list available?</th>
							<th>Are the medicines within 2 months of expiry or near expiry?</th>
							<th>Are there no expired or over-dated medicines?</th>
							<th>Are additional or extra medicines present (mismatches in the stock)?</th>
							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "St.Martins Ward") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_St.Martins Ward_' . $location}) ? htmlspecialchars($data->{'obstruction_stairways_St.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperySt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'slipperySt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'railsSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_St.Martins Ward_' . $location}) ? htmlspecialchars($data->{'obstruction_corridor_St.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'floors_slipSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'avoid_fallsSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'carpetSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'warning_signagesSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'natural_lightSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'illuminationSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'glareSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'night_lightsSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'plug_pointsSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'cords_damagedSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'cables_exposedSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'safety_matsSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'fire_preventSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'cords_conditionsSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'sufficient_oxygenSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'ro_waterSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'cylinder_chartSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'cylinder_standSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'containers_codedSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'containers_closedSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'biohazardSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'segregationSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'containers_fillSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'kit_accessibleSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'items_presentSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeSt.Martins Ward_' . $location}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'vial_needleSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'opening_dateSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'storageSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'vial_expireSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'temperature_chartSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'temperature_limitsSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'freezing_doneSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'medical_itemsSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'expired_medicineSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'medicines_availSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'medicines_near_expSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'overdatedSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'extra_medicinesSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'hazardous_materialSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'msds_sheetSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'workplace_storageSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_availSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'safety_trainedSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'exit_routeSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'fire_doorsSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'exit_signagesSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'use_ppeSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'staff_trainedSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'safety_devicesSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'work_station_neatSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'washroom_checklistSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'signages_placedSt.Martins Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionSt.Martins Ward_' . $location}) ? htmlspecialchars($data->{'missionSt.Martins Ward_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>St. Ann’s Ward</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="anns table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>
							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							<th>Is there sufficient oxygen in the cylinders?</th>
							<th>Is the RO water changed regularly and dated?</th>
							<th>Is there an oxygen cylinder monitoring chart?</th>
							<th>Is there a trolley/stand provided for the oxygen cylinder?</th>
							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>
							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>
							<th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>
							<th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>
							<th>Are all medicines as per the list available?</th>
							<th>Are the medicines within 2 months of expiry or near expiry?</th>
							<th>Are there no expired or over-dated medicines?</th>
							<th>Are additional or extra medicines present (mismatches in the stock)?</th>
							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "St.Anns Ward") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';



								// STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_St.Anns Ward_' . $location}) ? htmlspecialchars($data->{'obstruction_stairways_St.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperySt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'slipperySt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'railsSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_St.Anns Ward_' . $location}) ? htmlspecialchars($data->{'obstruction_corridor_St.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'floors_slipSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'avoid_fallsSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'carpetSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'warning_signagesSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'natural_lightSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'illuminationSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'glareSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'night_lightsSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'plug_pointsSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'cords_damagedSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'cables_exposedSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'safety_matsSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'fire_preventSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'cords_conditionsSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'sufficient_oxygenSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'ro_waterSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'cylinder_chartSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'cylinder_standSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'containers_codedSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'containers_closedSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'biohazardSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'segregationSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'containers_fillSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'kit_accessibleSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'items_presentSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeSt.Anns Ward_' . $location}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'vial_needleSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'opening_dateSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'storageSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'vial_expireSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'temperature_chartSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'temperature_limitsSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'freezing_doneSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'medical_itemsSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'expired_medicineSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'medicines_availSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'medicines_near_expSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'overdatedSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'extra_medicinesSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'hazardous_materialSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'msds_sheetSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'workplace_storageSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_availSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'safety_trainedSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'exit_routeSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'fire_doorsSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'exit_signagesSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'use_ppeSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'staff_trainedSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'safety_devicesSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'work_station_neatSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'washroom_checklistSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'signages_placedSt.Anns Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionSt.Anns Ward_' . $location}) ? htmlspecialchars($data->{'missionSt.Anns Ward_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>St. Antony’s Ward</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="antony table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>
							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							<th>Is there sufficient oxygen in the cylinders?</th>
							<th>Is the RO water changed regularly and dated?</th>
							<th>Is there an oxygen cylinder monitoring chart?</th>
							<th>Is there a trolley/stand provided for the oxygen cylinder?</th>
							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>
							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>
							<th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>
							<th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>
							<th>Are all medicines as per the list available?</th>
							<th>Are the medicines within 2 months of expiry or near expiry?</th>
							<th>Are there no expired or over-dated medicines?</th>
							<th>Are additional or extra medicines present (mismatches in the stock)?</th>
							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "St.Antonys Ward") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';



								// STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_St.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'obstruction_stairways_St.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperySt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'slipperySt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'railsSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_St.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'obstruction_corridor_St.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'floors_slipSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'avoid_fallsSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'carpetSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'warning_signagesSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'natural_lightSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'illuminationSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'glareSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'night_lightsSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'plug_pointsSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'cords_damagedSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'cables_exposedSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'safety_matsSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'fire_preventSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'cords_conditionsSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'sufficient_oxygenSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'ro_waterSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'cylinder_chartSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'cylinder_standSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'containers_codedSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'containers_closedSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'biohazardSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'segregationSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'containers_fillSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'kit_accessibleSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'items_presentSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeSt.Antonys Ward_' . $location}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'vial_needleSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'opening_dateSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'storageSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'vial_expireSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'temperature_chartSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'temperature_limitsSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'freezing_doneSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'medical_itemsSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'expired_medicineSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'medicines_availSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'medicines_near_expSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'overdatedSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'extra_medicinesSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'hazardous_materialSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'msds_sheetSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'workplace_storageSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_availSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'safety_trainedSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'exit_routeSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'fire_doorsSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'exit_signagesSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'use_ppeSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'staff_trainedSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'safety_devicesSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'work_station_neatSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'washroom_checklistSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'signages_placedSt.Antonys Ward_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionSt.Antonys Ward_' . $location}) ? htmlspecialchars($data->{'missionSt.Antonys Ward_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Paediatric- Observation</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="paediatric table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>
							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							<th>Is there sufficient oxygen in the cylinders?</th>
							<th>Is the RO water changed regularly and dated?</th>
							<th>Is there an oxygen cylinder monitoring chart?</th>
							<th>Is there a trolley/stand provided for the oxygen cylinder?</th>
							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>
							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>
							<th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>
							<th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>
							<th>Are all medicines as per the list available?</th>
							<th>Are the medicines within 2 months of expiry or near expiry?</th>
							<th>Are there no expired or over-dated medicines?</th>
							<th>Are additional or extra medicines present (mismatches in the stock)?</th>
							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Paediatric-Observation") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								// STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_Paediatric-Observation_' . $location}) ? htmlspecialchars($data->{'obstruction_stairways_Paediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'slipperyPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'railsPaediatric-Observation_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_Paediatric-Observation_' . $location}) ? htmlspecialchars($data->{'obstruction_corridor_Paediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'floors_slipPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'avoid_fallsPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'carpetPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'warning_signagesPaediatric-Observation_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'natural_lightPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'illuminationPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glarePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'glarePaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'night_lightsPaediatric-Observation_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'plug_pointsPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'cords_damagedPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'cables_exposedPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'safety_matsPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'fire_preventPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'cords_conditionsPaediatric-Observation_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'sufficient_oxygenPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'ro_waterPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'cylinder_chartPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'cylinder_standPaediatric-Observation_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'containers_codedPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'containers_closedPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'biohazardPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'segregationPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'containers_fillPaediatric-Observation_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessiblePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'kit_accessiblePaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'items_presentPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'staff_knowledgePaediatric-Observation_' . $location}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needlePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'vial_needlePaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_datePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'opening_datePaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storagePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'storagePaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expirePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'vial_expirePaediatric-Observation_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'temperature_chartPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'temperature_limitsPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_donePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'freezing_donePaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'medical_itemsPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicinePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'expired_medicinePaediatric-Observation_' . $location}) : '') . '</td>';

								// MEDICINES AND HAZARDOUS MATERIALS
								echo '<td>' . (isset($data->{'medicines_availPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'medicines_availPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'medicines_near_expPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'overdatedPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'extra_medicinesPaediatric-Observation_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'hazardous_materialPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'msds_sheetPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storagePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'workplace_storagePaediatric-Observation_' . $location}) : '') . '</td>';

								// FIRE SAFETY AND PPE
								echo '<td>' . (isset($data->{'extinguishers_accessiblePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessiblePaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'extinguishers_availPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'safety_trainedPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'exit_routePaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'fire_doorsPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'exit_signagesPaediatric-Observation_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'use_ppePaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'staff_trainedPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'safety_devicesPaediatric-Observation_' . $location}) : '') . '</td>';

								// HOUSEKEEPING AND CLEANLINESS
								echo '<td>' . (isset($data->{'work_station_neatPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'work_station_neatPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'washroom_checklistPaediatric-Observation_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								// PATIENT RIGHTS AND SIGNAGES
								echo '<td>' . (isset($data->{'patient_right_visiblePaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'patient_right_visiblePaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'signages_placedPaediatric-Observation_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionPaediatric-Observation_' . $location}) ? htmlspecialchars($data->{'missionPaediatric-Observation_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>OT</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="ot table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>
							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							<th>Is there sufficient oxygen in the cylinders?</th>
							<th>Is the RO water changed regularly and dated?</th>
							<th>Is there an oxygen cylinder monitoring chart?</th>
							<th>Is there a trolley/stand provided for the oxygen cylinder?</th>
							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>
							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>
							<th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>
							<th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>
							<th>Are all medicines as per the list available?</th>
							<th>Are the medicines within 2 months of expiry or near expiry?</th>
							<th>Are there no expired or over-dated medicines?</th>
							<th>Are additional or extra medicines present (mismatches in the stock)?</th>
							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "OT") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';



								// STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_OT_' . $location}) ? htmlspecialchars($data->{'obstruction_stairways_OT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyOT_' . $location}) ? htmlspecialchars($data->{'slipperyOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsOT_' . $location}) ? htmlspecialchars($data->{'railsOT_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_OT_' . $location}) ? htmlspecialchars($data->{'obstruction_corridor_OT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipOT_' . $location}) ? htmlspecialchars($data->{'floors_slipOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsOT_' . $location}) ? htmlspecialchars($data->{'avoid_fallsOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetOT_' . $location}) ? htmlspecialchars($data->{'carpetOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesOT_' . $location}) ? htmlspecialchars($data->{'warning_signagesOT_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightOT_' . $location}) ? htmlspecialchars($data->{'natural_lightOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationOT_' . $location}) ? htmlspecialchars($data->{'illuminationOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareOT_' . $location}) ? htmlspecialchars($data->{'glareOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsOT_' . $location}) ? htmlspecialchars($data->{'night_lightsOT_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsOT_' . $location}) ? htmlspecialchars($data->{'plug_pointsOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedOT_' . $location}) ? htmlspecialchars($data->{'cords_damagedOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedOT_' . $location}) ? htmlspecialchars($data->{'cables_exposedOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsOT_' . $location}) ? htmlspecialchars($data->{'safety_matsOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventOT_' . $location}) ? htmlspecialchars($data->{'fire_preventOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsOT_' . $location}) ? htmlspecialchars($data->{'cords_conditionsOT_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenOT_' . $location}) ? htmlspecialchars($data->{'sufficient_oxygenOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterOT_' . $location}) ? htmlspecialchars($data->{'ro_waterOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartOT_' . $location}) ? htmlspecialchars($data->{'cylinder_chartOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standOT_' . $location}) ? htmlspecialchars($data->{'cylinder_standOT_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedOT_' . $location}) ? htmlspecialchars($data->{'containers_codedOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedOT_' . $location}) ? htmlspecialchars($data->{'containers_closedOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardOT_' . $location}) ? htmlspecialchars($data->{'biohazardOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationOT_' . $location}) ? htmlspecialchars($data->{'segregationOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillOT_' . $location}) ? htmlspecialchars($data->{'containers_fillOT_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleOT_' . $location}) ? htmlspecialchars($data->{'kit_accessibleOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentOT_' . $location}) ? htmlspecialchars($data->{'items_presentOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeOT_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeOT_' . $location}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleOT_' . $location}) ? htmlspecialchars($data->{'vial_needleOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateOT_' . $location}) ? htmlspecialchars($data->{'opening_dateOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageOT_' . $location}) ? htmlspecialchars($data->{'storageOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireOT_' . $location}) ? htmlspecialchars($data->{'vial_expireOT_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartOT_' . $location}) ? htmlspecialchars($data->{'temperature_chartOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsOT_' . $location}) ? htmlspecialchars($data->{'temperature_limitsOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneOT_' . $location}) ? htmlspecialchars($data->{'freezing_doneOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsOT_' . $location}) ? htmlspecialchars($data->{'medical_itemsOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineOT_' . $location}) ? htmlspecialchars($data->{'expired_medicineOT_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availOT_' . $location}) ? htmlspecialchars($data->{'medicines_availOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expOT_' . $location}) ? htmlspecialchars($data->{'medicines_near_expOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedOT_' . $location}) ? htmlspecialchars($data->{'overdatedOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesOT_' . $location}) ? htmlspecialchars($data->{'extra_medicinesOT_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialOT_' . $location}) ? htmlspecialchars($data->{'hazardous_materialOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetOT_' . $location}) ? htmlspecialchars($data->{'msds_sheetOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageOT_' . $location}) ? htmlspecialchars($data->{'workplace_storageOT_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleOT_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availOT_' . $location}) ? htmlspecialchars($data->{'extinguishers_availOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedOT_' . $location}) ? htmlspecialchars($data->{'safety_trainedOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeOT_' . $location}) ? htmlspecialchars($data->{'exit_routeOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsOT_' . $location}) ? htmlspecialchars($data->{'fire_doorsOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedOT_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesOT_' . $location}) ? htmlspecialchars($data->{'exit_signagesOT_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeOT_' . $location}) ? htmlspecialchars($data->{'use_ppeOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedOT_' . $location}) ? htmlspecialchars($data->{'staff_trainedOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesOT_' . $location}) ? htmlspecialchars($data->{'safety_devicesOT_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatOT_' . $location}) ? htmlspecialchars($data->{'work_station_neatOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistOT_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsOT_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanOT_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistOT_' . $location}) ? htmlspecialchars($data->{'washroom_checklistOT_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleOT_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedOT_' . $location}) ? htmlspecialchars($data->{'signages_placedOT_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionOT_' . $location}) ? htmlspecialchars($data->{'missionOT_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>CCU/ ICU</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="icu table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>
							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							<th>Is there sufficient oxygen in the cylinders?</th>
							<th>Is the RO water changed regularly and dated?</th>
							<th>Is there an oxygen cylinder monitoring chart?</th>
							<th>Is there a trolley/stand provided for the oxygen cylinder?</th>
							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>
							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>
							<th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>
							<th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>
							<th>Are all medicines as per the list available?</th>
							<th>Are the medicines within 2 months of expiry or near expiry?</th>
							<th>Are there no expired or over-dated medicines?</th>
							<th>Are additional or extra medicines present (mismatches in the stock)?</th>
							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "CCU/ICU") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								echo '<td>' . (isset($data->{'obstruction_stairways_CCU/ICU_' . $location}) ? htmlspecialchars($data->{'obstruction_stairways_CCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyCCU/ICU_' . $location}) ? htmlspecialchars($data->{'slipperyCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsCCU/ICU_' . $location}) ? htmlspecialchars($data->{'railsCCU/ICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_CCU/ICU_' . $location}) ? htmlspecialchars($data->{'obstruction_corridor_CCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipCCU/ICU_' . $location}) ? htmlspecialchars($data->{'floors_slipCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsCCU/ICU_' . $location}) ? htmlspecialchars($data->{'avoid_fallsCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetCCU/ICU_' . $location}) ? htmlspecialchars($data->{'carpetCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesCCU/ICU_' . $location}) ? htmlspecialchars($data->{'warning_signagesCCU/ICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightCCU/ICU_' . $location}) ? htmlspecialchars($data->{'natural_lightCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationCCU/ICU_' . $location}) ? htmlspecialchars($data->{'illuminationCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareCCU/ICU_' . $location}) ? htmlspecialchars($data->{'glareCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsCCU/ICU_' . $location}) ? htmlspecialchars($data->{'night_lightsCCU/ICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsCCU/ICU_' . $location}) ? htmlspecialchars($data->{'plug_pointsCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedCCU/ICU_' . $location}) ? htmlspecialchars($data->{'cords_damagedCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedCCU/ICU_' . $location}) ? htmlspecialchars($data->{'cables_exposedCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsCCU/ICU_' . $location}) ? htmlspecialchars($data->{'safety_matsCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventCCU/ICU_' . $location}) ? htmlspecialchars($data->{'fire_preventCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsCCU/ICU_' . $location}) ? htmlspecialchars($data->{'cords_conditionsCCU/ICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenCCU/ICU_' . $location}) ? htmlspecialchars($data->{'sufficient_oxygenCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterCCU/ICU_' . $location}) ? htmlspecialchars($data->{'ro_waterCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartCCU/ICU_' . $location}) ? htmlspecialchars($data->{'cylinder_chartCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standCCU/ICU_' . $location}) ? htmlspecialchars($data->{'cylinder_standCCU/ICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedCCU/ICU_' . $location}) ? htmlspecialchars($data->{'containers_codedCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedCCU/ICU_' . $location}) ? htmlspecialchars($data->{'containers_closedCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardCCU/ICU_' . $location}) ? htmlspecialchars($data->{'biohazardCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationCCU/ICU_' . $location}) ? htmlspecialchars($data->{'segregationCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillCCU/ICU_' . $location}) ? htmlspecialchars($data->{'containers_fillCCU/ICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleCCU/ICU_' . $location}) ? htmlspecialchars($data->{'kit_accessibleCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentCCU/ICU_' . $location}) ? htmlspecialchars($data->{'items_presentCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeCCU/ICU_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeCCU/ICU_' . $location}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleCCU/ICU_' . $location}) ? htmlspecialchars($data->{'vial_needleCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateCCU/ICU_' . $location}) ? htmlspecialchars($data->{'opening_dateCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageCCU/ICU_' . $location}) ? htmlspecialchars($data->{'storageCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireCCU/ICU_' . $location}) ? htmlspecialchars($data->{'vial_expireCCU/ICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartCCU/ICU_' . $location}) ? htmlspecialchars($data->{'temperature_chartCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsCCU/ICU_' . $location}) ? htmlspecialchars($data->{'temperature_limitsCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneCCU/ICU_' . $location}) ? htmlspecialchars($data->{'freezing_doneCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsCCU/ICU_' . $location}) ? htmlspecialchars($data->{'medical_itemsCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineCCU/ICU_' . $location}) ? htmlspecialchars($data->{'expired_medicineCCU/ICU_' . $location}) : '') . '</td>';

								// MEDICINES AND HAZARDOUS MATERIALS
								echo '<td>' . (isset($data->{'medicines_availCCU/ICU_' . $location}) ? htmlspecialchars($data->{'medicines_availCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expCCU/ICU_' . $location}) ? htmlspecialchars($data->{'medicines_near_expCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedCCU/ICU_' . $location}) ? htmlspecialchars($data->{'overdatedCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesCCU/ICU_' . $location}) ? htmlspecialchars($data->{'extra_medicinesCCU/ICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialCCU/ICU_' . $location}) ? htmlspecialchars($data->{'hazardous_materialCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetCCU/ICU_' . $location}) ? htmlspecialchars($data->{'msds_sheetCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageCCU/ICU_' . $location}) ? htmlspecialchars($data->{'workplace_storageCCU/ICU_' . $location}) : '') . '</td>';

								// FIRE SAFETY AND PPE
								echo '<td>' . (isset($data->{'extinguishers_accessibleCCU/ICU_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availCCU/ICU_' . $location}) ? htmlspecialchars($data->{'extinguishers_availCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedCCU/ICU_' . $location}) ? htmlspecialchars($data->{'safety_trainedCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeCCU/ICU_' . $location}) ? htmlspecialchars($data->{'exit_routeCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsCCU/ICU_' . $location}) ? htmlspecialchars($data->{'fire_doorsCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedCCU/ICU_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesCCU/ICU_' . $location}) ? htmlspecialchars($data->{'exit_signagesCCU/ICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeCCU/ICU_' . $location}) ? htmlspecialchars($data->{'use_ppeCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedCCU/ICU_' . $location}) ? htmlspecialchars($data->{'staff_trainedCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesCCU/ICU_' . $location}) ? htmlspecialchars($data->{'safety_devicesCCU/ICU_' . $location}) : '') . '</td>';


								echo '<td>' . (isset($data->{'work_station_neatCCU/ICU_' . $location}) ? htmlspecialchars($data->{'work_station_neatCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistCCU/ICU_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsCCU/ICU_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanCCU/ICU_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistCCU/ICU_' . $location}) ? htmlspecialchars($data->{'washroom_checklistCCU/ICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								// SIGNAGES 
								echo '<td>' . (isset($data->{'patient_right_visibleCCU/ICU_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedCCU/ICU_' . $location}) ? htmlspecialchars($data->{'signages_placedCCU/ICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionCCU/ICU_' . $location}) ? htmlspecialchars($data->{'missionCCU/ICU_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Casualty</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="casualty table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>
							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							<th>Is there sufficient oxygen in the cylinders?</th>
							<th>Is the RO water changed regularly and dated?</th>
							<th>Is there an oxygen cylinder monitoring chart?</th>
							<th>Is there a trolley/stand provided for the oxygen cylinder?</th>
							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>
							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>
							<th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>
							<th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>
							<th>Are all medicines as per the list available?</th>
							<th>Are the medicines within 2 months of expiry or near expiry?</th>
							<th>Are there no expired or over-dated medicines?</th>
							<th>Are additional or extra medicines present (mismatches in the stock)?</th>
							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Casualty") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								// STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_Casualty_' . $location}) ? htmlspecialchars($data->{'obstruction_stairways_Casualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyCasualty_' . $location}) ? htmlspecialchars($data->{'slipperyCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsCasualty_' . $location}) ? htmlspecialchars($data->{'railsCasualty_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_Casualty_' . $location}) ? htmlspecialchars($data->{'obstruction_corridor_Casualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipCasualty_' . $location}) ? htmlspecialchars($data->{'floors_slipCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsCasualty_' . $location}) ? htmlspecialchars($data->{'avoid_fallsCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetCasualty_' . $location}) ? htmlspecialchars($data->{'carpetCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesCasualty_' . $location}) ? htmlspecialchars($data->{'warning_signagesCasualty_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightCasualty_' . $location}) ? htmlspecialchars($data->{'natural_lightCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationCasualty_' . $location}) ? htmlspecialchars($data->{'illuminationCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareCasualty_' . $location}) ? htmlspecialchars($data->{'glareCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsCasualty_' . $location}) ? htmlspecialchars($data->{'night_lightsCasualty_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsCasualty_' . $location}) ? htmlspecialchars($data->{'plug_pointsCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedCasualty_' . $location}) ? htmlspecialchars($data->{'cords_damagedCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedCasualty_' . $location}) ? htmlspecialchars($data->{'cables_exposedCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsCasualty_' . $location}) ? htmlspecialchars($data->{'safety_matsCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventCasualty_' . $location}) ? htmlspecialchars($data->{'fire_preventCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsCasualty_' . $location}) ? htmlspecialchars($data->{'cords_conditionsCasualty_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenCasualty_' . $location}) ? htmlspecialchars($data->{'sufficient_oxygenCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterCasualty_' . $location}) ? htmlspecialchars($data->{'ro_waterCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartCasualty_' . $location}) ? htmlspecialchars($data->{'cylinder_chartCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standCasualty_' . $location}) ? htmlspecialchars($data->{'cylinder_standCasualty_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedCasualty_' . $location}) ? htmlspecialchars($data->{'containers_codedCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedCasualty_' . $location}) ? htmlspecialchars($data->{'containers_closedCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardCasualty_' . $location}) ? htmlspecialchars($data->{'biohazardCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationCasualty_' . $location}) ? htmlspecialchars($data->{'segregationCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillCasualty_' . $location}) ? htmlspecialchars($data->{'containers_fillCasualty_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleCasualty_' . $location}) ? htmlspecialchars($data->{'kit_accessibleCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentCasualty_' . $location}) ? htmlspecialchars($data->{'items_presentCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeCasualty_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeCasualty_' . $location}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleCasualty_' . $location}) ? htmlspecialchars($data->{'vial_needleCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateCasualty_' . $location}) ? htmlspecialchars($data->{'opening_dateCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageCasualty_' . $location}) ? htmlspecialchars($data->{'storageCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireCasualty_' . $location}) ? htmlspecialchars($data->{'vial_expireCasualty_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartCasualty_' . $location}) ? htmlspecialchars($data->{'temperature_chartCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsCasualty_' . $location}) ? htmlspecialchars($data->{'temperature_limitsCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneCasualty_' . $location}) ? htmlspecialchars($data->{'freezing_doneCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsCasualty_' . $location}) ? htmlspecialchars($data->{'medical_itemsCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineCasualty_' . $location}) ? htmlspecialchars($data->{'expired_medicineCasualty_' . $location}) : '') . '</td>';

								// MEDICINES AND HAZARDOUS MATERIALS
								echo '<td>' . (isset($data->{'medicines_availCasualty_' . $location}) ? htmlspecialchars($data->{'medicines_availCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expCasualty_' . $location}) ? htmlspecialchars($data->{'medicines_near_expCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedCasualty_' . $location}) ? htmlspecialchars($data->{'overdatedCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesCasualty_' . $location}) ? htmlspecialchars($data->{'extra_medicinesCasualty_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialCasualty_' . $location}) ? htmlspecialchars($data->{'hazardous_materialCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetCasualty_' . $location}) ? htmlspecialchars($data->{'msds_sheetCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageCasualty_' . $location}) ? htmlspecialchars($data->{'workplace_storageCasualty_' . $location}) : '') . '</td>';

								// FIRE SAFETY
								echo '<td>' . (isset($data->{'extinguishers_accessibleCasualty_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availCasualty_' . $location}) ? htmlspecialchars($data->{'extinguishers_availCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedCasualty_' . $location}) ? htmlspecialchars($data->{'safety_trainedCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeCasualty_' . $location}) ? htmlspecialchars($data->{'exit_routeCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsCasualty_' . $location}) ? htmlspecialchars($data->{'fire_doorsCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedCasualty_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesCasualty_' . $location}) ? htmlspecialchars($data->{'exit_signagesCasualty_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeCasualty_' . $location}) ? htmlspecialchars($data->{'use_ppeCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedCasualty_' . $location}) ? htmlspecialchars($data->{'staff_trainedCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesCasualty_' . $location}) ? htmlspecialchars($data->{'safety_devicesCasualty_' . $location}) : '') . '</td>';


								echo '<td>' . (isset($data->{'work_station_neatCasualty_' . $location}) ? htmlspecialchars($data->{'work_station_neatCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistCasualty_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsCasualty_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanCasualty_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistCasualty_' . $location}) ? htmlspecialchars($data->{'washroom_checklistCasualty_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								// SIGNAGES
								echo '<td>' . (isset($data->{'patient_right_visibleCasualty_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedCasualty_' . $location}) ? htmlspecialchars($data->{'signages_placedCasualty_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionCasualty_' . $location}) ? htmlspecialchars($data->{'missionCasualty_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Dialysis</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="dialysis table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>
							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							<th>Is there sufficient oxygen in the cylinders?</th>
							<th>Is the RO water changed regularly and dated?</th>
							<th>Is there an oxygen cylinder monitoring chart?</th>
							<th>Is there a trolley/stand provided for the oxygen cylinder?</th>
							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>
							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>
							<th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>
							<th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>
							<th>Are all medicines as per the list available?</th>
							<th>Are the medicines within 2 months of expiry or near expiry?</th>
							<th>Are there no expired or over-dated medicines?</th>
							<th>Are additional or extra medicines present (mismatches in the stock)?</th>
							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Dialysis") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								// STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_Dialysis_' . $location}) ? htmlspecialchars($data->{'obstruction_stairways_Dialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyDialysis_' . $location}) ? htmlspecialchars($data->{'slipperyDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsDialysis_' . $location}) ? htmlspecialchars($data->{'railsDialysis_' . $location}) : '') . '</td>';

								// CORRIDOR AND LIGHTING
								echo '<td>' . (isset($data->{'obstruction_corridor_Dialysis_' . $location}) ? htmlspecialchars($data->{'obstruction_corridor_Dialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipDialysis_' . $location}) ? htmlspecialchars($data->{'floors_slipDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsDialysis_' . $location}) ? htmlspecialchars($data->{'avoid_fallsDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetDialysis_' . $location}) ? htmlspecialchars($data->{'carpetDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesDialysis_' . $location}) ? htmlspecialchars($data->{'warning_signagesDialysis_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightDialysis_' . $location}) ? htmlspecialchars($data->{'natural_lightDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationDialysis_' . $location}) ? htmlspecialchars($data->{'illuminationDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareDialysis_' . $location}) ? htmlspecialchars($data->{'glareDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsDialysis_' . $location}) ? htmlspecialchars($data->{'night_lightsDialysis_' . $location}) : '') . '</td>';

								// ELECTRICAL SAFETY AND OXYGEN SUPPLY
								echo '<td>' . (isset($data->{'plug_pointsDialysis_' . $location}) ? htmlspecialchars($data->{'plug_pointsDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedDialysis_' . $location}) ? htmlspecialchars($data->{'cords_damagedDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedDialysis_' . $location}) ? htmlspecialchars($data->{'cables_exposedDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsDialysis_' . $location}) ? htmlspecialchars($data->{'safety_matsDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventDialysis_' . $location}) ? htmlspecialchars($data->{'fire_preventDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsDialysis_' . $location}) ? htmlspecialchars($data->{'cords_conditionsDialysis_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenDialysis_' . $location}) ? htmlspecialchars($data->{'sufficient_oxygenDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterDialysis_' . $location}) ? htmlspecialchars($data->{'ro_waterDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartDialysis_' . $location}) ? htmlspecialchars($data->{'cylinder_chartDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standDialysis_' . $location}) ? htmlspecialchars($data->{'cylinder_standDialysis_' . $location}) : '') . '</td>';

								// WASTE MANAGEMENT AND EMERGENCY KIT
								echo '<td>' . (isset($data->{'containers_codedDialysis_' . $location}) ? htmlspecialchars($data->{'containers_codedDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedDialysis_' . $location}) ? htmlspecialchars($data->{'containers_closedDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardDialysis_' . $location}) ? htmlspecialchars($data->{'biohazardDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationDialysis_' . $location}) ? htmlspecialchars($data->{'segregationDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillDialysis_' . $location}) ? htmlspecialchars($data->{'containers_fillDialysis_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleDialysis_' . $location}) ? htmlspecialchars($data->{'kit_accessibleDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentDialysis_' . $location}) ? htmlspecialchars($data->{'items_presentDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeDialysis_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeDialysis_' . $location}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleDialysis_' . $location}) ? htmlspecialchars($data->{'vial_needleDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateDialysis_' . $location}) ? htmlspecialchars($data->{'opening_dateDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageDialysis_' . $location}) ? htmlspecialchars($data->{'storageDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireDialysis_' . $location}) ? htmlspecialchars($data->{'vial_expireDialysis_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartDialysis_' . $location}) ? htmlspecialchars($data->{'temperature_chartDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsDialysis_' . $location}) ? htmlspecialchars($data->{'temperature_limitsDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneDialysis_' . $location}) ? htmlspecialchars($data->{'freezing_doneDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsDialysis_' . $location}) ? htmlspecialchars($data->{'medical_itemsDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineDialysis_' . $location}) ? htmlspecialchars($data->{'expired_medicineDialysis_' . $location}) : '') . '</td>';

								// MEDICINES AND HAZARDOUS MATERIALS
								echo '<td>' . (isset($data->{'medicines_availDialysis_' . $location}) ? htmlspecialchars($data->{'medicines_availDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expDialysis_' . $location}) ? htmlspecialchars($data->{'medicines_near_expDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedDialysis_' . $location}) ? htmlspecialchars($data->{'overdatedDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesDialysis_' . $location}) ? htmlspecialchars($data->{'extra_medicinesDialysis_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialDialysis_' . $location}) ? htmlspecialchars($data->{'hazardous_materialDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetDialysis_' . $location}) ? htmlspecialchars($data->{'msds_sheetDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageDialysis_' . $location}) ? htmlspecialchars($data->{'workplace_storageDialysis_' . $location}) : '') . '</td>';

								// SAFETY AND FIRE EQUIPMENT
								echo '<td>' . (isset($data->{'extinguishers_accessibleDialysis_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availDialysis_' . $location}) ? htmlspecialchars($data->{'extinguishers_availDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedDialysis_' . $location}) ? htmlspecialchars($data->{'safety_trainedDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeDialysis_' . $location}) ? htmlspecialchars($data->{'exit_routeDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsDialysis_' . $location}) ? htmlspecialchars($data->{'fire_doorsDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedDialysis_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesDialysis_' . $location}) ? htmlspecialchars($data->{'exit_signagesDialysis_' . $location}) : '') . '</td>';

								// PPE AND SAFETY TRAINING
								echo '<td>' . (isset($data->{'use_ppeDialysis_' . $location}) ? htmlspecialchars($data->{'use_ppeDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedDialysis_' . $location}) ? htmlspecialchars($data->{'staff_trainedDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesDialysis_' . $location}) ? htmlspecialchars($data->{'safety_devicesDialysis_' . $location}) : '') . '</td>';

								// CLEANLINESS AND SAFETY CHECKS
								echo '<td>' . (isset($data->{'work_station_neatDialysis_' . $location}) ? htmlspecialchars($data->{'work_station_neatDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistDialysis_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsDialysis_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanDialysis_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistDialysis_' . $location}) ? htmlspecialchars($data->{'washroom_checklistDialysis_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								// SIGNAGE
								echo '<td>' . (isset($data->{'patient_right_visibleDialysis_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedDialysis_' . $location}) ? htmlspecialchars($data->{'signages_placedDialysis_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionDialysis_' . $location}) ? htmlspecialchars($data->{'missionDialysis_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Injection Room</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="injection table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>
							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							<th>Is there sufficient oxygen in the cylinders?</th>
							<th>Is the RO water changed regularly and dated?</th>
							<th>Is there an oxygen cylinder monitoring chart?</th>
							<th>Is there a trolley/stand provided for the oxygen cylinder?</th>
							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>
							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>
							<th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>
							<th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>
							<th>Are all medicines as per the list available?</th>
							<th>Are the medicines within 2 months of expiry or near expiry?</th>
							<th>Are there no expired or over-dated medicines?</th>
							<th>Are additional or extra medicines present (mismatches in the stock)?</th>
							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Injection Room") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								// STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_Injection Room_' . $location}) ? htmlspecialchars($data->{'obstruction_stairways_Injection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyInjection Room_' . $location}) ? htmlspecialchars($data->{'slipperyInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsInjection Room_' . $location}) ? htmlspecialchars($data->{'railsInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_Injection Room_' . $location}) ? htmlspecialchars($data->{'obstruction_corridor_Injection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipInjection Room_' . $location}) ? htmlspecialchars($data->{'floors_slipInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsInjection Room_' . $location}) ? htmlspecialchars($data->{'avoid_fallsInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetInjection Room_' . $location}) ? htmlspecialchars($data->{'carpetInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesInjection Room_' . $location}) ? htmlspecialchars($data->{'warning_signagesInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightInjection Room_' . $location}) ? htmlspecialchars($data->{'natural_lightInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationInjection Room_' . $location}) ? htmlspecialchars($data->{'illuminationInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareInjection Room_' . $location}) ? htmlspecialchars($data->{'glareInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsInjection Room_' . $location}) ? htmlspecialchars($data->{'night_lightsInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsInjection Room_' . $location}) ? htmlspecialchars($data->{'plug_pointsInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedInjection Room_' . $location}) ? htmlspecialchars($data->{'cords_damagedInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedInjection Room_' . $location}) ? htmlspecialchars($data->{'cables_exposedInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsInjection Room_' . $location}) ? htmlspecialchars($data->{'safety_matsInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventInjection Room_' . $location}) ? htmlspecialchars($data->{'fire_preventInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsInjection Room_' . $location}) ? htmlspecialchars($data->{'cords_conditionsInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenInjection Room_' . $location}) ? htmlspecialchars($data->{'sufficient_oxygenInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterInjection Room_' . $location}) ? htmlspecialchars($data->{'ro_waterInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartInjection Room_' . $location}) ? htmlspecialchars($data->{'cylinder_chartInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standInjection Room_' . $location}) ? htmlspecialchars($data->{'cylinder_standInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedInjection Room_' . $location}) ? htmlspecialchars($data->{'containers_codedInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedInjection Room_' . $location}) ? htmlspecialchars($data->{'containers_closedInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardInjection Room_' . $location}) ? htmlspecialchars($data->{'biohazardInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationInjection Room_' . $location}) ? htmlspecialchars($data->{'segregationInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillInjection Room_' . $location}) ? htmlspecialchars($data->{'containers_fillInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleInjection Room_' . $location}) ? htmlspecialchars($data->{'kit_accessibleInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentInjection Room_' . $location}) ? htmlspecialchars($data->{'items_presentInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeInjection Room_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeInjection Room_' . $location}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleInjection Room_' . $location}) ? htmlspecialchars($data->{'vial_needleInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateInjection Room_' . $location}) ? htmlspecialchars($data->{'opening_dateInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageInjection Room_' . $location}) ? htmlspecialchars($data->{'storageInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireInjection Room_' . $location}) ? htmlspecialchars($data->{'vial_expireInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartInjection Room_' . $location}) ? htmlspecialchars($data->{'temperature_chartInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsInjection Room_' . $location}) ? htmlspecialchars($data->{'temperature_limitsInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneInjection Room_' . $location}) ? htmlspecialchars($data->{'freezing_doneInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsInjection Room_' . $location}) ? htmlspecialchars($data->{'medical_itemsInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineInjection Room_' . $location}) ? htmlspecialchars($data->{'expired_medicineInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availInjection Room_' . $location}) ? htmlspecialchars($data->{'medicines_availInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expInjection Room_' . $location}) ? htmlspecialchars($data->{'medicines_near_expInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedInjection Room_' . $location}) ? htmlspecialchars($data->{'overdatedInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesInjection Room_' . $location}) ? htmlspecialchars($data->{'extra_medicinesInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialInjection Room_' . $location}) ? htmlspecialchars($data->{'hazardous_materialInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetInjection Room_' . $location}) ? htmlspecialchars($data->{'msds_sheetInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageInjection Room_' . $location}) ? htmlspecialchars($data->{'workplace_storageInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleInjection Room_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availInjection Room_' . $location}) ? htmlspecialchars($data->{'extinguishers_availInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedInjection Room_' . $location}) ? htmlspecialchars($data->{'safety_trainedInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeInjection Room_' . $location}) ? htmlspecialchars($data->{'exit_routeInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsInjection Room_' . $location}) ? htmlspecialchars($data->{'fire_doorsInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedInjection Room_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesInjection Room_' . $location}) ? htmlspecialchars($data->{'exit_signagesInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeInjection Room_' . $location}) ? htmlspecialchars($data->{'use_ppeInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedInjection Room_' . $location}) ? htmlspecialchars($data->{'staff_trainedInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesInjection Room_' . $location}) ? htmlspecialchars($data->{'safety_devicesInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatInjection Room_' . $location}) ? htmlspecialchars($data->{'work_station_neatInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistInjection Room_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsInjection Room_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanInjection Room_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistInjection Room_' . $location}) ? htmlspecialchars($data->{'washroom_checklistInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleInjection Room_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedInjection Room_' . $location}) ? htmlspecialchars($data->{'signages_placedInjection Room_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionInjection Room_' . $location}) ? htmlspecialchars($data->{'missionInjection Room_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>NICU</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="nicu table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>
							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							<th>Is there sufficient oxygen in the cylinders?</th>
							<th>Is the RO water changed regularly and dated?</th>
							<th>Is there an oxygen cylinder monitoring chart?</th>
							<th>Is there a trolley/stand provided for the oxygen cylinder?</th>
							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>
							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>
							<th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>
							<th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>
							<th>Are all medicines as per the list available?</th>
							<th>Are the medicines within 2 months of expiry or near expiry?</th>
							<th>Are there no expired or over-dated medicines?</th>
							<th>Are additional or extra medicines present (mismatches in the stock)?</th>
							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "NICU") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								echo '<td>' . (isset($data->{'obstruction_stairways_NICU_' . $location}) ? htmlspecialchars($data->{'obstruction_stairways_NICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyNICU_' . $location}) ? htmlspecialchars($data->{'slipperyNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsNICU_' . $location}) ? htmlspecialchars($data->{'railsNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_NICU_' . $location}) ? htmlspecialchars($data->{'obstruction_corridor_NICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipNICU_' . $location}) ? htmlspecialchars($data->{'floors_slipNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsNICU_' . $location}) ? htmlspecialchars($data->{'avoid_fallsNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetNICU_' . $location}) ? htmlspecialchars($data->{'carpetNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesNICU_' . $location}) ? htmlspecialchars($data->{'warning_signagesNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightNICU_' . $location}) ? htmlspecialchars($data->{'natural_lightNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationNICU_' . $location}) ? htmlspecialchars($data->{'illuminationNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareNICU_' . $location}) ? htmlspecialchars($data->{'glareNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsNICU_' . $location}) ? htmlspecialchars($data->{'night_lightsNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsNICU_' . $location}) ? htmlspecialchars($data->{'plug_pointsNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedNICU_' . $location}) ? htmlspecialchars($data->{'cords_damagedNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedNICU_' . $location}) ? htmlspecialchars($data->{'cables_exposedNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsNICU_' . $location}) ? htmlspecialchars($data->{'safety_matsNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventNICU_' . $location}) ? htmlspecialchars($data->{'fire_preventNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsNICU_' . $location}) ? htmlspecialchars($data->{'cords_conditionsNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenNICU_' . $location}) ? htmlspecialchars($data->{'sufficient_oxygenNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterNICU_' . $location}) ? htmlspecialchars($data->{'ro_waterNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartNICU_' . $location}) ? htmlspecialchars($data->{'cylinder_chartNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standNICU_' . $location}) ? htmlspecialchars($data->{'cylinder_standNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedNICU_' . $location}) ? htmlspecialchars($data->{'containers_codedNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedNICU_' . $location}) ? htmlspecialchars($data->{'containers_closedNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardNICU_' . $location}) ? htmlspecialchars($data->{'biohazardNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationNICU_' . $location}) ? htmlspecialchars($data->{'segregationNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillNICU_' . $location}) ? htmlspecialchars($data->{'containers_fillNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleNICU_' . $location}) ? htmlspecialchars($data->{'kit_accessibleNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentNICU_' . $location}) ? htmlspecialchars($data->{'items_presentNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeNICU_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'vial_needleNICU_' . $location}) ? htmlspecialchars($data->{'vial_needleNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateNICU_' . $location}) ? htmlspecialchars($data->{'opening_dateNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageNICU_' . $location}) ? htmlspecialchars($data->{'storageNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireNICU_' . $location}) ? htmlspecialchars($data->{'vial_expireNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartNICU_' . $location}) ? htmlspecialchars($data->{'temperature_chartNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsNICU_' . $location}) ? htmlspecialchars($data->{'temperature_limitsNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneNICU_' . $location}) ? htmlspecialchars($data->{'freezing_doneNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsNICU_' . $location}) ? htmlspecialchars($data->{'medical_itemsNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineNICU_' . $location}) ? htmlspecialchars($data->{'expired_medicineNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availNICU_' . $location}) ? htmlspecialchars($data->{'medicines_availNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expNICU_' . $location}) ? htmlspecialchars($data->{'medicines_near_expNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedNICU_' . $location}) ? htmlspecialchars($data->{'overdatedNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesNICU_' . $location}) ? htmlspecialchars($data->{'extra_medicinesNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialNICU_' . $location}) ? htmlspecialchars($data->{'hazardous_materialNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetNICU_' . $location}) ? htmlspecialchars($data->{'msds_sheetNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageNICU_' . $location}) ? htmlspecialchars($data->{'workplace_storageNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleNICU_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availNICU_' . $location}) ? htmlspecialchars($data->{'extinguishers_availNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedNICU_' . $location}) ? htmlspecialchars($data->{'safety_trainedNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeNICU_' . $location}) ? htmlspecialchars($data->{'exit_routeNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsNICU_' . $location}) ? htmlspecialchars($data->{'fire_doorsNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedNICU_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesNICU_' . $location}) ? htmlspecialchars($data->{'exit_signagesNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeNICU_' . $location}) ? htmlspecialchars($data->{'use_ppeNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedNICU_' . $location}) ? htmlspecialchars($data->{'staff_trainedNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesNICU_' . $location}) ? htmlspecialchars($data->{'safety_devicesNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatNICU_' . $location}) ? htmlspecialchars($data->{'work_station_neatNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistNICU_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsNICU_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanNICU_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistNICU_' . $location}) ? htmlspecialchars($data->{'washroom_checklistNICU_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleNICU_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedNICU_' . $location}) ? htmlspecialchars($data->{'signages_placedNICU_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionNICU_' . $location}) ? htmlspecialchars($data->{'missionNICU_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Laboratory</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="lab table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>
							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							<th>Is there sufficient oxygen in the cylinders?</th>
							<th>Is the RO water changed regularly and dated?</th>
							<th>Is there an oxygen cylinder monitoring chart?</th>
							<th>Is there a trolley/stand provided for the oxygen cylinder?</th>
							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>
							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>
							<th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>
							<th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>
							<th>Are all medicines as per the list available?</th>
							<th>Are the medicines within 2 months of expiry or near expiry?</th>
							<th>Are there no expired or over-dated medicines?</th>
							<th>Are additional or extra medicines present (mismatches in the stock)?</th>
							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Laboratory") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								// STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_Laboratory_' . $location}) ? htmlspecialchars($data->{'obstruction_stairways_Laboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyLaboratory_' . $location}) ? htmlspecialchars($data->{'slipperyLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsLaboratory_' . $location}) ? htmlspecialchars($data->{'railsLaboratory_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_Laboratory_' . $location}) ? htmlspecialchars($data->{'obstruction_corridor_Laboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipLaboratory_' . $location}) ? htmlspecialchars($data->{'floors_slipLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsLaboratory_' . $location}) ? htmlspecialchars($data->{'avoid_fallsLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetLaboratory_' . $location}) ? htmlspecialchars($data->{'carpetLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesLaboratory_' . $location}) ? htmlspecialchars($data->{'warning_signagesLaboratory_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightLaboratory_' . $location}) ? htmlspecialchars($data->{'natural_lightLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationLaboratory_' . $location}) ? htmlspecialchars($data->{'illuminationLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareLaboratory_' . $location}) ? htmlspecialchars($data->{'glareLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsLaboratory_' . $location}) ? htmlspecialchars($data->{'night_lightsLaboratory_' . $location}) : '') . '</td>';

								// ELECTRICAL SAFETY
								echo '<td>' . (isset($data->{'plug_pointsLaboratory_' . $location}) ? htmlspecialchars($data->{'plug_pointsLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedLaboratory_' . $location}) ? htmlspecialchars($data->{'cords_damagedLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedLaboratory_' . $location}) ? htmlspecialchars($data->{'cables_exposedLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsLaboratory_' . $location}) ? htmlspecialchars($data->{'safety_matsLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventLaboratory_' . $location}) ? htmlspecialchars($data->{'fire_preventLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsLaboratory_' . $location}) ? htmlspecialchars($data->{'cords_conditionsLaboratory_' . $location}) : '') . '</td>';

								// OXYGEN & CYLINDER SAFETY
								echo '<td>' . (isset($data->{'sufficient_oxygenLaboratory_' . $location}) ? htmlspecialchars($data->{'sufficient_oxygenLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterLaboratory_' . $location}) ? htmlspecialchars($data->{'ro_waterLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartLaboratory_' . $location}) ? htmlspecialchars($data->{'cylinder_chartLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standLaboratory_' . $location}) ? htmlspecialchars($data->{'cylinder_standLaboratory_' . $location}) : '') . '</td>';

								// WASTE MANAGEMENT
								echo '<td>' . (isset($data->{'containers_codedLaboratory_' . $location}) ? htmlspecialchars($data->{'containers_codedLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedLaboratory_' . $location}) ? htmlspecialchars($data->{'containers_closedLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardLaboratory_' . $location}) ? htmlspecialchars($data->{'biohazardLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationLaboratory_' . $location}) ? htmlspecialchars($data->{'segregationLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillLaboratory_' . $location}) ? htmlspecialchars($data->{'containers_fillLaboratory_' . $location}) : '') . '</td>';

								// EMERGENCY KIT ACCESSIBILITY
								echo '<td>' . (isset($data->{'kit_accessibleLaboratory_' . $location}) ? htmlspecialchars($data->{'kit_accessibleLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentLaboratory_' . $location}) ? htmlspecialchars($data->{'items_presentLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeLaboratory_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeLaboratory_' . $location}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleLaboratory_' . $location}) ? htmlspecialchars($data->{'vial_needleLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateLaboratory_' . $location}) ? htmlspecialchars($data->{'opening_dateLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageLaboratory_' . $location}) ? htmlspecialchars($data->{'storageLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireLaboratory_' . $location}) ? htmlspecialchars($data->{'vial_expireLaboratory_' . $location}) : '') . '</td>';

								// TEMPERATURE CONTROL & MEDICINE STORAGE
								echo '<td>' . (isset($data->{'temperature_chartLaboratory_' . $location}) ? htmlspecialchars($data->{'temperature_chartLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsLaboratory_' . $location}) ? htmlspecialchars($data->{'temperature_limitsLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneLaboratory_' . $location}) ? htmlspecialchars($data->{'freezing_doneLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsLaboratory_' . $location}) ? htmlspecialchars($data->{'medical_itemsLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineLaboratory_' . $location}) ? htmlspecialchars($data->{'expired_medicineLaboratory_' . $location}) : '') . '</td>';

								// MEDICINES MANAGEMENT
								echo '<td>' . (isset($data->{'medicines_availLaboratory_' . $location}) ? htmlspecialchars($data->{'medicines_availLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expLaboratory_' . $location}) ? htmlspecialchars($data->{'medicines_near_expLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedLaboratory_' . $location}) ? htmlspecialchars($data->{'overdatedLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesLaboratory_' . $location}) ? htmlspecialchars($data->{'extra_medicinesLaboratory_' . $location}) : '') . '</td>';

								// HAZARDOUS MATERIALS & STORAGE
								echo '<td>' . (isset($data->{'hazardous_materialLaboratory_' . $location}) ? htmlspecialchars($data->{'hazardous_materialLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetLaboratory_' . $location}) ? htmlspecialchars($data->{'msds_sheetLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageLaboratory_' . $location}) ? htmlspecialchars($data->{'workplace_storageLaboratory_' . $location}) : '') . '</td>';

								// FIRE SAFETY & EMERGENCY EQUIPMENT
								echo '<td>' . (isset($data->{'extinguishers_accessibleLaboratory_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availLaboratory_' . $location}) ? htmlspecialchars($data->{'extinguishers_availLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedLaboratory_' . $location}) ? htmlspecialchars($data->{'safety_trainedLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeLaboratory_' . $location}) ? htmlspecialchars($data->{'exit_routeLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsLaboratory_' . $location}) ? htmlspecialchars($data->{'fire_doorsLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedLaboratory_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesLaboratory_' . $location}) ? htmlspecialchars($data->{'exit_signagesLaboratory_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeLaboratory_' . $location}) ? htmlspecialchars($data->{'use_ppeLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedLaboratory_' . $location}) ? htmlspecialchars($data->{'staff_trainedLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesLaboratory_' . $location}) ? htmlspecialchars($data->{'safety_devicesLaboratory_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatLaboratory_' . $location}) ? htmlspecialchars($data->{'work_station_neatLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistLaboratory_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsLaboratory_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanLaboratory_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistLaboratory_' . $location}) ? htmlspecialchars($data->{'washroom_checklistLaboratory_' . $location}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleLaboratory_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedLaboratory_' . $location}) ? htmlspecialchars($data->{'signages_placedLaboratory_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionLaboratory_' . $location}) ? htmlspecialchars($data->{'missionLaboratory_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Basement-Common Area</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="basearea table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>

							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>

							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>

							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Basement-Common Area") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_Basement-Common Area_' . $location}) ? htmlspecialchars($data->{'obstruction_Basement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'slipperyBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'railsBasement-Common Area_' . $location}) : '') . '</td>';

								//CORRIDOR & FLOORS
								echo '<td>' . (isset($data->{'obstruction_Basement-Common Area_' . $location}) ? htmlspecialchars($data->{'obstruction_Basement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'floors_slipBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'avoid_fallsBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'carpetBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'warning_signagesBasement-Common Area_' . $location}) : '') . '</td>';

								//LIGHTING ALL OVER THE AREA
								echo '<td>' . (isset($data->{'natural_lightBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'natural_lightBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'illuminationBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'glareBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'night_lightsBasement-Common Area_' . $location}) : '') . '</td>';

								//ELECTRICAL
								echo '<td>' . (isset($data->{'plug_pointsBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'plug_pointsBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'cords_damagedBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'cables_exposedBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'safety_matsBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'fire_preventBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'cords_conditionsBasement-Common Area_' . $location}) : '') . '</td>';

								//FIRE AND EVACUATION
								echo '<td>' . (isset($data->{'extinguishers_accessibleBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'extinguishers_availBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'safety_trainedBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'exit_routeBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'fire_doorsBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'exit_signagesBasement-Common Area_' . $location}) : '') . '</td>';


								//GENERAL CONDITION OF THE DEPARTMENT
								echo '<td>' . (isset($data->{'work_station_neatBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'work_station_neatBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'washroom_checklistBasement-Common Area_' . $location}) : '') . '</td>';

								//SIGNAGES
								echo '<td>' . (isset($data->{'patient_right_visibleBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'signages_placedBasement-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionBasement-Common Area_' . $location}) ? htmlspecialchars($data->{'missionBasement-Common Area_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Ground Floor-Common Area</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="groundarea table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>

							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>

							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>

							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Ground Floor-Common Area") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_Ground Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'obstruction_Ground Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'slipperyGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'railsGround Floor-Common Area_' . $location}) : '') . '</td>';

								//CORRIDOR & FLOORS
								echo '<td>' . (isset($data->{'obstruction_Ground Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'obstruction_Ground Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'floors_slipGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'avoid_fallsGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'carpetGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'warning_signagesGround Floor-Common Area_' . $location}) : '') . '</td>';

								//LIGHTING ALL OVER THE AREA
								echo '<td>' . (isset($data->{'natural_lightGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'natural_lightGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'illuminationGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'glareGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'night_lightsGround Floor-Common Area_' . $location}) : '') . '</td>';

								//ELECTRICAL
								echo '<td>' . (isset($data->{'plug_pointsGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'plug_pointsGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'cords_damagedGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'cables_exposedGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'safety_matsGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'fire_preventGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'cords_conditionsGround Floor-Common Area_' . $location}) : '') . '</td>';

								//FIRE AND EVACUATION
								echo '<td>' . (isset($data->{'extinguishers_accessibleGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'extinguishers_availGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'safety_trainedGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'exit_routeGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'fire_doorsGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'exit_signagesGround Floor-Common Area_' . $location}) : '') . '</td>';


								//GENERAL CONDITION OF THE DEPARTMENT
								echo '<td>' . (isset($data->{'work_station_neatGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'work_station_neatGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'washroom_checklistGround Floor-Common Area_' . $location}) : '') . '</td>';

								//SIGNAGES
								echo '<td>' . (isset($data->{'patient_right_visibleGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'signages_placedGround Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionGround Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'missionGround Floor-Common Area_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>First Floor-Common Area</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="firstarea table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the area free of obstruction?</th>
							<th>Are the step surfaces slippery?</th>
							<th>Are the stairs and grab rails in good condition?</th>

							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>

							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>

							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>
							
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "First Floor-Common Area") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_First Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'obstruction_First Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'slipperyFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'railsFirst Floor-Common Area_' . $location}) : '') . '</td>';

								//CORRIDOR & FLOORS
								echo '<td>' . (isset($data->{'obstruction_First Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'obstruction_First Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'floors_slipFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'avoid_fallsFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'carpetFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'warning_signagesFirst Floor-Common Area_' . $location}) : '') . '</td>';

								//LIGHTING ALL OVER THE AREA
								echo '<td>' . (isset($data->{'natural_lightFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'natural_lightFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'illuminationFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'glareFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'night_lightsFirst Floor-Common Area_' . $location}) : '') . '</td>';

								//ELECTRICAL
								echo '<td>' . (isset($data->{'plug_pointsFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'plug_pointsFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'cords_damagedFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'cables_exposedFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'safety_matsFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'fire_preventFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'cords_conditionsFirst Floor-Common Area_' . $location}) : '') . '</td>';

								//FIRE AND EVACUATION
								echo '<td>' . (isset($data->{'extinguishers_accessibleFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'extinguishers_availFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'safety_trainedFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'exit_routeFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'fire_doorsFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'exit_signagesFirst Floor-Common Area_' . $location}) : '') . '</td>';

								// GENERAL CONDITION OF THE DEPARTMENT
								echo '<td>' . (isset($data->{'work_station_neatFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'work_station_neatFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'washroom_checklistFirst Floor-Common Area_' . $location}) : '') . '</td>';

								// SIGNAGES
								echo '<td>' . (isset($data->{'patient_right_visibleFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'signages_placedFirst Floor-Common Area_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionFirst Floor-Common Area_' . $location}) ? htmlspecialchars($data->{'missionFirst Floor-Common Area_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Bio-Medical Waste Storage Area</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="bioarea table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the BM waste properly stored?</th>
                            <th>Are the BM wastes weight and bag number properly recorded?</th>
                            <th>Is the storage area clean and maintained?</th>

							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Bio-Medical Waste Storage Area") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';


								//Bio-Medical Waste Storage Area
								echo '<td>' . (isset($data->{'bm_waste_store'}) ? htmlspecialchars($data->{'bm_waste_store'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'bm_waste_record'}) ? htmlspecialchars($data->{'bm_waste_record'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storage_area'}) ? htmlspecialchars($data->{'storage_area'}) : '') . '</td>';


								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Water Storage</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="water table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is enough water stored?</th>
                            <th>Is the tank cleaning checklist maintained?</th>
                            <th>Is the RO plant maintenance checklist maintained?</th>

							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Water Storage") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';


								//Water Storage
								echo '<td>' . (isset($data->{'enough_water'}) ? htmlspecialchars($data->{'enough_water'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'tank_cleaning'}) ? htmlspecialchars($data->{'tank_cleaning'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'plant_maintain'}) ? htmlspecialchars($data->{'plant_maintain'}) : '') . '</td>';


								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Electrical Room/Area</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="electricalarea table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Is the status of the transformer documented?</th>
                            <th>Is the status of backup generators documented?</th>
                            <th>Are adequate safety mats placed in electrical areas?</th>
                            <th>Are all electrical boxes, ELCBs properly maintained?</th>
                            <th>Are enough precautions taken to prevent fire?</th>

							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Electrical Room/Area") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';


								//Electrical Room/Area
								echo '<td>' . (isset($data->{'transformer_status'}) ? htmlspecialchars($data->{'transformer_status'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'generators_status'}) ? htmlspecialchars($data->{'generators_status'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'electrical_areas'}) ? htmlspecialchars($data->{'electrical_areas'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'electrical_boxes'}) ? htmlspecialchars($data->{'electrical_boxes'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'precautions_to_fire'}) ? htmlspecialchars($data->{'precautions_to_fire'}) : '') . '</td>';



								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Oxygen Cylinder Storage Area</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="oxygenarea table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							<th>Are the cylinders properly chained in storage areas?</th>
                            <th>Can empty/full cylinders be easily identified?</th>
                            <th>Are warning signages placed wherever necessary?</th>
							
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Oxygen Cylinder Storage Area") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';


								//Oxygen Cylinder Storage Area
								echo '<td>' . (isset($data->{'cylinders_chained'}) ? htmlspecialchars($data->{'cylinders_chained'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'empty_cylinders'}) ? htmlspecialchars($data->{'empty_cylinders'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signage'}) ? htmlspecialchars($data->{'warning_signage'}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>X-Ray</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="xray table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>
							
							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>

							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>

							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>

							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>

							
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>

							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							
							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>


							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// echo '</pre>';
							// exit;

							if (isset($data->dep) && $data->dep === "X Ray") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								// CORRIDOR & FLOORS
								echo '<td>' . (isset($data->{'obstruction_X Ray_' . $location}) ? htmlspecialchars($data->{'obstruction_X Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipX Ray_' . $location}) ? htmlspecialchars($data->{'floors_slipX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsX Ray_' . $location}) ? htmlspecialchars($data->{'avoid_fallsX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetX Ray_' . $location}) ? htmlspecialchars($data->{'carpetX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesX Ray_' . $location}) ? htmlspecialchars($data->{'warning_signagesX Ray_' . $location}) : '') . '</td>';

								// LIGHTING ALL OVER THE AREA
								echo '<td>' . (isset($data->{'natural_lightX Ray_' . $location}) ? htmlspecialchars($data->{'natural_lightX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationX Ray_' . $location}) ? htmlspecialchars($data->{'illuminationX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareX Ray_' . $location}) ? htmlspecialchars($data->{'glareX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsX Ray_' . $location}) ? htmlspecialchars($data->{'night_lightsX Ray_' . $location}) : '') . '</td>';

								// ELECTRICAL
								echo '<td>' . (isset($data->{'plug_pointsX Ray_' . $location}) ? htmlspecialchars($data->{'plug_pointsX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedX Ray_' . $location}) ? htmlspecialchars($data->{'cords_damagedX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedX Ray_' . $location}) ? htmlspecialchars($data->{'cables_exposedX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsX Ray_' . $location}) ? htmlspecialchars($data->{'safety_matsX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventX Ray_' . $location}) ? htmlspecialchars($data->{'fire_preventX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsX Ray_' . $location}) ? htmlspecialchars($data->{'cords_conditionsX Ray_' . $location}) : '') . '</td>';

								// SPILL KIT
								echo '<td>' . (isset($data->{'kit_accessibleX Ray_' . $location}) ? htmlspecialchars($data->{'kit_accessibleX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentX Ray_' . $location}) ? htmlspecialchars($data->{'items_presentX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeX Ray_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeX Ray_' . $location}) : '') . '</td>';


								// FIRE AND EVACUATION
								echo '<td>' . (isset($data->{'extinguishers_accessibleX Ray_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availX Ray_' . $location}) ? htmlspecialchars($data->{'extinguishers_availX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedX Ray_' . $location}) ? htmlspecialchars($data->{'safety_trainedX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeX Ray_' . $location}) ? htmlspecialchars($data->{'exit_routeX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsX Ray_' . $location}) ? htmlspecialchars($data->{'fire_doorsX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedX Ray_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesX Ray_' . $location}) ? htmlspecialchars($data->{'exit_signagesX Ray_' . $location}) : '') . '</td>';

								// PERSONAL PROTECTIVE EQUIPMENT
								echo '<td>' . (isset($data->{'use_ppeX Ray_' . $location}) ? htmlspecialchars($data->{'use_ppeX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedX Ray_' . $location}) ? htmlspecialchars($data->{'staff_trainedX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesX Ray_' . $location}) ? htmlspecialchars($data->{'safety_devicesX Ray_' . $location}) : '') . '</td>';

								// GENERAL CONDITION OF THE DEPARTMENT
								echo '<td>' . (isset($data->{'work_station_neatX Ray_' . $location}) ? htmlspecialchars($data->{'work_station_neatX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistX Ray_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsX Ray_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanX Ray_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistX Ray_' . $location}) ? htmlspecialchars($data->{'washroom_checklistX Ray_' . $location}) : '') . '</td>';


								//EQUIPMENTS
								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';


								// SIGNAGES
								echo '<td>' . (isset($data->{'patient_right_visibleX Ray_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedX Ray_' . $location}) ? htmlspecialchars($data->{'signages_placedX Ray_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionX Ray_' . $location}) ? htmlspecialchars($data->{'missionX Ray_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Ultrasound Scanning</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="ultra table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>

							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>

							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>

							
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>

							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>

							<th>Is the spill kit readily accessible?</th>
							<th>Are all items present?</th>
							<th>Is the knowledge of staff adequate?</th>
							
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>

							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>

							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Ultrasound Scanning") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								// CORRIDOR & FLOORS
								echo '<td>' . (isset($data->{'obstruction_Ultrasound Scanning_' . $location}) ? htmlspecialchars($data->{'obstruction_Ultrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'floors_slipUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'avoid_fallsUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'carpetUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'warning_signagesUltrasound Scanning_' . $location}) : '') . '</td>';

								// LIGHTING ALL OVER THE AREA
								echo '<td>' . (isset($data->{'natural_lightUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'natural_lightUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'illuminationUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'glareUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'night_lightsUltrasound Scanning_' . $location}) : '') . '</td>';

								// ELECTRICAL
								echo '<td>' . (isset($data->{'plug_pointsUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'plug_pointsUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'cords_damagedUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'cables_exposedUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'safety_matsUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'fire_preventUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'cords_conditionsUltrasound Scanning_' . $location}) : '') . '</td>';


								// BIO-MEDICAL WASTE
								echo '<td>' . (isset($data->{'containers_codedUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'containers_codedUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'containers_closedUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'biohazardUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'segregationUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'containers_fillUltrasound Scanning_' . $location}) : '') . '</td>';

								// SPILL KIT
								echo '<td>' . (isset($data->{'kit_accessibleUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'kit_accessibleUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'items_presentUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'staff_knowledgeUltrasound Scanning_' . $location}) : '') . '</td>';

								// FIRE AND EVACUATION
								echo '<td>' . (isset($data->{'extinguishers_accessibleUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'extinguishers_availUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'safety_trainedUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'exit_routeUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'fire_doorsUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'exit_signagesUltrasound Scanning_' . $location}) : '') . '</td>';

								// PERSONAL PROTECTIVE EQUIPMENT
								echo '<td>' . (isset($data->{'use_ppeUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'use_ppeUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'staff_trainedUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'safety_devicesUltrasound Scanning_' . $location}) : '') . '</td>';

								// GENERAL CONDITION OF THE DEPARTMENT
								echo '<td>' . (isset($data->{'work_station_neatUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'work_station_neatUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'washroom_checklistUltrasound Scanning_' . $location}) : '') . '</td>';

								//EQUIPMENTS
								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								// SIGNAGES
								echo '<td>' . (isset($data->{'patient_right_visibleUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'signages_placedUltrasound Scanning_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionUltrasound Scanning_' . $location}) ? htmlspecialchars($data->{'missionUltrasound Scanning_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Procedure OPD</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="opd table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>

							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>

							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>

							
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>

							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>

		                    <th>Is there no needle kept in the vial?</th>
							<th>Is the date of opening recorded?</th>
							<th>Is the storage under proper conditions?</th>
							<th>Is the vial not expired?</th>

							<th>Is the material safety data sheet available for all hazardous material used?</th>
							<th>Are employees trained on how to locate, read, and understand an MSDS sheet?</th>
							<th>Is the storage of minimal quantities in the workplace maintained?</th>
							
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>

							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>

							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>
							
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Procedure OPD") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								// CORRIDOR & FLOORS
								echo '<td>' . (isset($data->{'obstruction_Procedure OPD_' . $location}) ? htmlspecialchars($data->{'obstruction_Procedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipProcedure OPD_' . $location}) ? htmlspecialchars($data->{'floors_slipProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsProcedure OPD_' . $location}) ? htmlspecialchars($data->{'avoid_fallsProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetProcedure OPD_' . $location}) ? htmlspecialchars($data->{'carpetProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesProcedure OPD_' . $location}) ? htmlspecialchars($data->{'warning_signagesProcedure OPD_' . $location}) : '') . '</td>';

								// LIGHTING ALL OVER THE AREA
								echo '<td>' . (isset($data->{'natural_lightProcedure OPD_' . $location}) ? htmlspecialchars($data->{'natural_lightProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationProcedure OPD_' . $location}) ? htmlspecialchars($data->{'illuminationProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareProcedure OPD_' . $location}) ? htmlspecialchars($data->{'glareProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsProcedure OPD_' . $location}) ? htmlspecialchars($data->{'night_lightsProcedure OPD_' . $location}) : '') . '</td>';

								// ELECTRICAL
								echo '<td>' . (isset($data->{'plug_pointsProcedure OPD_' . $location}) ? htmlspecialchars($data->{'plug_pointsProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedProcedure OPD_' . $location}) ? htmlspecialchars($data->{'cords_damagedProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedProcedure OPD_' . $location}) ? htmlspecialchars($data->{'cables_exposedProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsProcedure OPD_' . $location}) ? htmlspecialchars($data->{'safety_matsProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventProcedure OPD_' . $location}) ? htmlspecialchars($data->{'fire_preventProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsProcedure OPD_' . $location}) ? htmlspecialchars($data->{'cords_conditionsProcedure OPD_' . $location}) : '') . '</td>';


								// BIO-MEDICAL WASTE
								echo '<td>' . (isset($data->{'containers_codedProcedure OPD_' . $location}) ? htmlspecialchars($data->{'containers_codedProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedProcedure OPD_' . $location}) ? htmlspecialchars($data->{'containers_closedProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardProcedure OPD_' . $location}) ? htmlspecialchars($data->{'biohazardProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationProcedure OPD_' . $location}) ? htmlspecialchars($data->{'segregationProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillProcedure OPD_' . $location}) ? htmlspecialchars($data->{'containers_fillProcedure OPD_' . $location}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleProcedure OPD_' . $location}) ? htmlspecialchars($data->{'vial_needleProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateProcedure OPD_' . $location}) ? htmlspecialchars($data->{'opening_dateProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageProcedure OPD_' . $location}) ? htmlspecialchars($data->{'storageProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireProcedure OPD_' . $location}) ? htmlspecialchars($data->{'vial_expireProcedure OPD_' . $location}) : '') . '</td>';

								// HAZARDOUS SUBSTANCES
								echo '<td>' . (isset($data->{'hazardous_materialProcedure OPD_' . $location}) ? htmlspecialchars($data->{'hazardous_materialProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetProcedure OPD_' . $location}) ? htmlspecialchars($data->{'msds_sheetProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageProcedure OPD_' . $location}) ? htmlspecialchars($data->{'workplace_storageProcedure OPD_' . $location}) : '') . '</td>';


								// FIRE AND EVACUATION
								echo '<td>' . (isset($data->{'extinguishers_accessibleProcedure OPD_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availProcedure OPD_' . $location}) ? htmlspecialchars($data->{'extinguishers_availProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedProcedure OPD_' . $location}) ? htmlspecialchars($data->{'safety_trainedProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeProcedure OPD_' . $location}) ? htmlspecialchars($data->{'exit_routeProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsProcedure OPD_' . $location}) ? htmlspecialchars($data->{'fire_doorsProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedProcedure OPD_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesProcedure OPD_' . $location}) ? htmlspecialchars($data->{'exit_signagesProcedure OPD_' . $location}) : '') . '</td>';

								// PERSONAL PROTECTIVE EQUIPMENT
								echo '<td>' . (isset($data->{'use_ppeProcedure OPD_' . $location}) ? htmlspecialchars($data->{'use_ppeProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedProcedure OPD_' . $location}) ? htmlspecialchars($data->{'staff_trainedProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesProcedure OPD_' . $location}) ? htmlspecialchars($data->{'safety_devicesProcedure OPD_' . $location}) : '') . '</td>';

								// GENERAL CONDITION OF THE DEPARTMENT
								echo '<td>' . (isset($data->{'work_station_neatProcedure OPD_' . $location}) ? htmlspecialchars($data->{'work_station_neatProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistProcedure OPD_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsProcedure OPD_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanProcedure OPD_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanProcedure OPD_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistProcedure OPD_' . $location}) ? htmlspecialchars($data->{'washroom_checklistProcedure OPD_' . $location}) : '') . '</td>';

								//EQUIPMENTS
								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Pharmacy</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="pharma table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>

							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>

							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>

							
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>

							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>

		                    <th>Is there a temperature monitoring chart?</th>
							<th>Is the temperature within normal limits?</th>
							<th>Is de-freezing done regularly?</th>
							<th>Are there no non-medical items in the refrigerator?</th>
							<th>Are there no expired/over-dated medicines in the refrigerator?</th>
							

							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>

							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>
							
							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>

							<th>Are medicines stored appropriately?</th>
							<th>Are there expired or over-dated medicines?</th>
							<th>Are near expiry medicines returned to supplier?</th>
							<th>Are staff maintains credit note book?</th>


							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Pharmacy") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								// CORRIDOR & FLOORS
								echo '<td>' . (isset($data->{'obstruction_Pharmacy_' . $location}) ? htmlspecialchars($data->{'obstruction_Pharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipPharmacy_' . $location}) ? htmlspecialchars($data->{'floors_slipPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsPharmacy_' . $location}) ? htmlspecialchars($data->{'avoid_fallsPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetPharmacy_' . $location}) ? htmlspecialchars($data->{'carpetPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesPharmacy_' . $location}) ? htmlspecialchars($data->{'warning_signagesPharmacy_' . $location}) : '') . '</td>';

								// LIGHTING ALL OVER THE AREA
								echo '<td>' . (isset($data->{'natural_lightPharmacy_' . $location}) ? htmlspecialchars($data->{'natural_lightPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationPharmacy_' . $location}) ? htmlspecialchars($data->{'illuminationPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glarePharmacy_' . $location}) ? htmlspecialchars($data->{'glarePharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsPharmacy_' . $location}) ? htmlspecialchars($data->{'night_lightsPharmacy_' . $location}) : '') . '</td>';

								// ELECTRICAL
								echo '<td>' . (isset($data->{'plug_pointsPharmacy_' . $location}) ? htmlspecialchars($data->{'plug_pointsPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedPharmacy_' . $location}) ? htmlspecialchars($data->{'cords_damagedPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedPharmacy_' . $location}) ? htmlspecialchars($data->{'cables_exposedPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsPharmacy_' . $location}) ? htmlspecialchars($data->{'safety_matsPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventPharmacy_' . $location}) ? htmlspecialchars($data->{'fire_preventPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsPharmacy_' . $location}) ? htmlspecialchars($data->{'cords_conditionsPharmacy_' . $location}) : '') . '</td>';


								// BIO-MEDICAL WASTE
								echo '<td>' . (isset($data->{'containers_codedPharmacy_' . $location}) ? htmlspecialchars($data->{'containers_codedPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedPharmacy_' . $location}) ? htmlspecialchars($data->{'containers_closedPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardPharmacy_' . $location}) ? htmlspecialchars($data->{'biohazardPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationPharmacy_' . $location}) ? htmlspecialchars($data->{'segregationPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillPharmacy_' . $location}) ? htmlspecialchars($data->{'containers_fillPharmacy_' . $location}) : '') . '</td>';

								// REFRIGERATOR
								echo '<td>' . (isset($data->{'temperature_chartPharmacy_' . $location}) ? htmlspecialchars($data->{'temperature_chartPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsPharmacy_' . $location}) ? htmlspecialchars($data->{'temperature_limitsPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_donePharmacy_' . $location}) ? htmlspecialchars($data->{'freezing_donePharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsPharmacy_' . $location}) ? htmlspecialchars($data->{'medical_itemsPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicinePharmacy_' . $location}) ? htmlspecialchars($data->{'expired_medicinePharmacy_' . $location}) : '') . '</td>';


								// FIRE AND EVACUATION
								echo '<td>' . (isset($data->{'extinguishers_accessiblePharmacy_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessiblePharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availPharmacy_' . $location}) ? htmlspecialchars($data->{'extinguishers_availPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedPharmacy_' . $location}) ? htmlspecialchars($data->{'safety_trainedPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routePharmacy_' . $location}) ? htmlspecialchars($data->{'exit_routePharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsPharmacy_' . $location}) ? htmlspecialchars($data->{'fire_doorsPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedPharmacy_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesPharmacy_' . $location}) ? htmlspecialchars($data->{'exit_signagesPharmacy_' . $location}) : '') . '</td>';

								// PERSONAL PROTECTIVE EQUIPMENT
								echo '<td>' . (isset($data->{'use_ppePharmacy_' . $location}) ? htmlspecialchars($data->{'use_ppePharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedPharmacy_' . $location}) ? htmlspecialchars($data->{'staff_trainedPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesPharmacy_' . $location}) ? htmlspecialchars($data->{'safety_devicesPharmacy_' . $location}) : '') . '</td>';

								// GENERAL CONDITION OF THE DEPARTMENT
								echo '<td>' . (isset($data->{'work_station_neatPharmacy_' . $location}) ? htmlspecialchars($data->{'work_station_neatPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistPharmacy_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsPharmacy_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanPharmacy_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistPharmacy_' . $location}) ? htmlspecialchars($data->{'washroom_checklistPharmacy_' . $location}) : '') . '</td>';

								// SIGNAGES
								echo '<td>' . (isset($data->{'patient_right_visiblePharmacy_' . $location}) ? htmlspecialchars($data->{'patient_right_visiblePharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedPharmacy_' . $location}) ? htmlspecialchars($data->{'signages_placedPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionPharmacy_' . $location}) ? htmlspecialchars($data->{'missionPharmacy_' . $location}) : '') . '</td>';

								// MEDICINE STORAGE
								echo '<td>' . (isset($data->{'medicine_storedPharmacy_' . $location}) ? htmlspecialchars($data->{'medicine_storedPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'over_datedPharmacy_' . $location}) ? htmlspecialchars($data->{'over_datedPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'near_expiryPharmacy_' . $location}) ? htmlspecialchars($data->{'near_expiryPharmacy_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'credit_notePharmacy_' . $location}) ? htmlspecialchars($data->{'credit_notePharmacy_' . $location}) : '') . '</td>';


								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Terrace</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="terrace table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>

							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							
							<th>Is the entire premises neat and tidy?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Is the access to terrace restricted?</th>
							
							<th>Are the signages properly placed?</th>
							
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Terrace") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								// FIRE AND EVACUATION
								echo '<td>' . (isset($data->{'extinguishers_accessibleTerrace_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleTerrace_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availTerrace_' . $location}) ? htmlspecialchars($data->{'extinguishers_availTerrace_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedTerrace_' . $location}) ? htmlspecialchars($data->{'safety_trainedTerrace_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeTerrace_' . $location}) ? htmlspecialchars($data->{'exit_routeTerrace_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsTerrace_' . $location}) ? htmlspecialchars($data->{'fire_doorsTerrace_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedTerrace_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedTerrace_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesTerrace_' . $location}) ? htmlspecialchars($data->{'exit_signagesTerrace_' . $location}) : '') . '</td>';

								// GENERAL CONDITION OF THE DEPARTMENT
								echo '<td>' . (isset($data->{'terrace_neatTerrace_' . $location}) ? htmlspecialchars($data->{'terrace_neatTerrace_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsTerrace_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsTerrace_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'terrace_restrictTerrace_' . $location}) ? htmlspecialchars($data->{'terrace_restrictTerrace_' . $location}) : '') . '</td>';

								// SIGNAGES
								echo '<td>' . (isset($data->{'signages_placedTerrace_' . $location}) ? htmlspecialchars($data->{'signages_placedTerrace_' . $location}) : '') . '</td>';


								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Laundry</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="laundry table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>


							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>

							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>
							
							<th>Is the entire premises neat and tidy?</th>
							<th>Is there enough space for collecting, cleaning, drying, and storing linen?</th>

							<th>Are all equipment numbered?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are periodic maintenance performed?</th>
							
							<th>Are the signages properly placed?</th>

							<th>Are the staff maintaining records of linen properly?</th>

							<th>Are the staff using 1% hypochlorite solution for body fluid-contaminated linen?</th>

							
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Laundry") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								// FIRE AND EVACUATION
								echo '<td>' . (isset($data->{'extinguishers_accessibleLaundry_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleLaundry_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availLaundry_' . $location}) ? htmlspecialchars($data->{'extinguishers_availLaundry_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedLaundry_' . $location}) ? htmlspecialchars($data->{'safety_trainedLaundry_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeLaundry_' . $location}) ? htmlspecialchars($data->{'exit_routeLaundry_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsLaundry_' . $location}) ? htmlspecialchars($data->{'fire_doorsLaundry_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedLaundry_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedLaundry_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesLaundry_' . $location}) ? htmlspecialchars($data->{'exit_signagesLaundry_' . $location}) : '') . '</td>';

								// PERSONAL PROTECTIVE EQUIPMENT
								echo '<td>' . (isset($data->{'use_ppeLaundry_' . $location}) ? htmlspecialchars($data->{'use_ppeLaundry_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedLaundry_' . $location}) ? htmlspecialchars($data->{'staff_trainedLaundry_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesLaundry_' . $location}) ? htmlspecialchars($data->{'safety_devicesLaundry_' . $location}) : '') . '</td>';

								// GENERAL CONDITION OF THE DEPARTMENT
								echo '<td>' . (isset($data->{'terrace_neatLaundry_' . $location}) ? htmlspecialchars($data->{'terrace_neatLaundry_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'space_linenLaundry_' . $location}) ? htmlspecialchars($data->{'space_linenLaundry_' . $location}) : '') . '</td>';

								//EQUIPMENTS
								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								// SIGNAGES
								echo '<td>' . (isset($data->{'signages_placedLaundry_' . $location}) ? htmlspecialchars($data->{'signages_placedLaundry_' . $location}) : '') . '</td>';

								// RECORDS
								echo '<td>' . (isset($data->{'staff_recordLaundry_' . $location}) ? htmlspecialchars($data->{'staff_recordLaundry_' . $location}) : '') . '</td>';

								// DISINFECTION
								echo '<td>' . (isset($data->{'hypochloriteLaundry_' . $location}) ? htmlspecialchars($data->{'hypochloriteLaundry_' . $location}) : '') . '</td>';

								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Other OPD's</h3>
					</div>
					<div class="panel-body">
						<?php
						echo '<table class="otheropd table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
						echo '
						<thead>
							<th>Sl. No.</th>
							<th>Date</th>
							<th>Department</th>

							<th>Is the area free of obstruction?</th>
							<th>Are the floors slippery?</th>
							<th>Are the floors free of liquids to avoid trips and falls?</th>
							<th>Is the carpet intact?</th>
							<th>Are warning signages placed wherever necessary?</th>

							<th>Is there good natural lighting?</th>
							<th>Is there adequate illumination?</th>
							<th>Is there direct or reflected glare?</th>
							<th>Are night lights fitted and in good condition?</th>

							
							<th>Are there adequate plug points?</th>
							<th>Are the power cords frayed or damaged?</th>
							<th>Are the electric cables exposed?</th>
							<th>Are adequate safety mats placed in electrical areas?</th>
							<th>Are enough precautions taken to prevent fire?</th>
							<th>Are plugs and cords in good condition?</th>

							<th>Are the containers color-coded?</th>
							<th>Are the containers closed?</th>
							<th>Is the bio-hazard symbol present on the containers?</th>
							<th>Is waste segregation according to the color code?</th>
							<th>Are the containers less than 3/4 filled up?</th>

		                	
							<th>Are fire extinguishers easily accessible?</th>
							<th>Are the fire extinguishers available in the area expired?</th>
							<th>Are the staff trained on fire safety?</th>
							<th>Is the exit route free of obstacles?</th>
							<th>Are the fire doors open?</th>
							<th>Are the fire extinguishers properly maintained (checklist)?</th>
							<th>Are the fire exit signages placed?</th>
							
							<th>Is there the use of adequate PPE in the workplace?</th>
							<th>Are the staff trained in the proper use of PPE?</th>
							<th>Is the use of appropriate safety measures/devices in the workplace maintained?</th>

							<th>Is the workstation and entire premises neat and tidy?</th>
							<th>Is the cleaning checklist maintained?</th>
							<th>Is the placement of furniture, overhead storage, equipment, etc. likely to cause accidents?</th>
							<th>Are the washrooms clean?</th>
							<th>Are the washroom checklists maintained?</th>

							<th>Are all equipment numbered?</th>
							<th>Is the equipment log sheet available?</th>
							<th>Are the equipment maintained in working condition?</th>
							<th>Are the fixed assets numbered?</th>
							<th>Is the asset register maintained?</th>
							<th>Is the complaint register updated?</th>
							<th>Are periodic maintenance performed?</th>

							<th>Are the patient rights and responsibilities visible?</th>
							<th>Are the signages properly placed?</th>
							<th>Are the mission and vision properly placed?</th>
							
							<th>Additional comments</th>
						</thead>';


						echo '<tbody>';
						$sl = 1;
						foreach ($feedbacktaken as $paramm) {

							$data = json_decode($paramm->dataset);

							// echo '<pre>';
							// print_r($data);
							// // echo '</pre>';
							// exit;
							if (isset($data->dep) && $data->dep === "Other OPDs") {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" data-placement="bottom" data-toggle="tooltip" title="' . htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ?
										date('d-M-Y', $data->datetime / 1000) . '<br>' .
										date('g:i a', $data->datetime / 1000) :
										'') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								$location = isset($data->location) ? $data->location : '';


								// CORRIDOR & FLOORS
								echo '<td>' . (isset($data->{'obstruction_Other OPDs_' . $location}) ? htmlspecialchars($data->{'obstruction_Other OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipOther OPDs_' . $location}) ? htmlspecialchars($data->{'floors_slipOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsOther OPDs_' . $location}) ? htmlspecialchars($data->{'avoid_fallsOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetOther OPDs_' . $location}) ? htmlspecialchars($data->{'carpetOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesOther OPDs_' . $location}) ? htmlspecialchars($data->{'warning_signagesOther OPDs_' . $location}) : '') . '</td>';

								// LIGHTING ALL OVER THE AREA
								echo '<td>' . (isset($data->{'natural_lightOther OPDs_' . $location}) ? htmlspecialchars($data->{'natural_lightOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationOther OPDs_' . $location}) ? htmlspecialchars($data->{'illuminationOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareOther OPDs_' . $location}) ? htmlspecialchars($data->{'glareOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsOther OPDs_' . $location}) ? htmlspecialchars($data->{'night_lightsOther OPDs_' . $location}) : '') . '</td>';

								// ELECTRICAL
								echo '<td>' . (isset($data->{'plug_pointsOther OPDs_' . $location}) ? htmlspecialchars($data->{'plug_pointsOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedOther OPDs_' . $location}) ? htmlspecialchars($data->{'cords_damagedOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedOther OPDs_' . $location}) ? htmlspecialchars($data->{'cables_exposedOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsOther OPDs_' . $location}) ? htmlspecialchars($data->{'safety_matsOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventOther OPDs_' . $location}) ? htmlspecialchars($data->{'fire_preventOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsOther OPDs_' . $location}) ? htmlspecialchars($data->{'cords_conditionsOther OPDs_' . $location}) : '') . '</td>';

								// BIO-MEDICAL WASTE
								echo '<td>' . (isset($data->{'containers_codedOther OPDs_' . $location}) ? htmlspecialchars($data->{'containers_codedOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedOther OPDs_' . $location}) ? htmlspecialchars($data->{'containers_closedOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardOther OPDs_' . $location}) ? htmlspecialchars($data->{'biohazardOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationOther OPDs_' . $location}) ? htmlspecialchars($data->{'segregationOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillOther OPDs_' . $location}) ? htmlspecialchars($data->{'containers_fillOther OPDs_' . $location}) : '') . '</td>';

								// FIRE AND EVACUATION
								echo '<td>' . (isset($data->{'extinguishers_accessibleOther OPDs_' . $location}) ? htmlspecialchars($data->{'extinguishers_accessibleOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availOther OPDs_' . $location}) ? htmlspecialchars($data->{'extinguishers_availOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedOther OPDs_' . $location}) ? htmlspecialchars($data->{'safety_trainedOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeOther OPDs_' . $location}) ? htmlspecialchars($data->{'exit_routeOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsOther OPDs_' . $location}) ? htmlspecialchars($data->{'fire_doorsOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedOther OPDs_' . $location}) ? htmlspecialchars($data->{'extinguishers_maintainedOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesOther OPDs_' . $location}) ? htmlspecialchars($data->{'exit_signagesOther OPDs_' . $location}) : '') . '</td>';

								// PERSONAL PROTECTIVE EQUIPMENT
								echo '<td>' . (isset($data->{'use_ppeOther OPDs_' . $location}) ? htmlspecialchars($data->{'use_ppeOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedOther OPDs_' . $location}) ? htmlspecialchars($data->{'staff_trainedOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesOther OPDs_' . $location}) ? htmlspecialchars($data->{'safety_devicesOther OPDs_' . $location}) : '') . '</td>';

								// GENERAL CONDITION OF THE DEPARTMENT
								echo '<td>' . (isset($data->{'work_station_neatOther OPDs_' . $location}) ? htmlspecialchars($data->{'work_station_neatOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistOther OPDs_' . $location}) ? htmlspecialchars($data->{'cleaning_checklistOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsOther OPDs_' . $location}) ? htmlspecialchars($data->{'equipment_accidentsOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanOther OPDs_' . $location}) ? htmlspecialchars($data->{'washrooms_cleanOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistOther OPDs_' . $location}) ? htmlspecialchars($data->{'washroom_checklistOther OPDs_' . $location}) : '') . '</td>';

								//EQUIPMENTS
								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								// SIGNAGES
								echo '<td>' . (isset($data->{'patient_right_visibleOther OPDs_' . $location}) ? htmlspecialchars($data->{'patient_right_visibleOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedOther OPDs_' . $location}) ? htmlspecialchars($data->{'signages_placedOther OPDs_' . $location}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionOther OPDs_' . $location}) ? htmlspecialchars($data->{'missionOther OPDs_' . $location}) : '') . '</td>';


								echo '<td>' . $data->dataAnalysis . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>


		</div>

	<?php } else {   ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('ip', 'ip_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>

</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		var typed = new Typed(".typing-text", {
			strings: ["<?php echo $text; ?>"],
			// delay: 10,
			loop: false,
			typeSpeed: 30,
			backSpeed: 5,
			backDelay: 1000,
		});
	});
</script>

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


<!-- <script src="<?php echo base_url(); ?>assets/efeedor_chart.js"></script> -->

<style>
	.chart-container {
		justify-content: center;
		/* Align the chart horizontally in the center */
		align-items: center;
		/* Align the chart vertically in the center */
		width: 460px !important;
		margin: 0px auto;
		height: 450px;
		width: 200px;
	}


	.progress {
		margin-bottom: 10px;
	}

	.mybarlength {
		text-align: right;
		margin-right: 18px;
		font-weight: bold;
	}

	.bar_chart {
		justify-content: center;
		/* Align the chart horizontally in the center */
		align-items: center;
		/* Align the chart vertically in the center */
		/* width: 460px !important; */
		margin: 0px auto;
		height: 500px;
		width: 1024px;
	}


	.line_chart {
		justify-content: center;
		/* Align the chart horizontally in the center */
		align-items: center;
		/* Align the chart vertically in the center */
		/* width: 460px !important; */
		margin: 0px auto;
		height: 250px;
		width: 1024px;
	}

	@media screen and (max-width: 1024px) {
		#pie_donut {
			overflow-x: scroll;
		}

		#bar {
			overflow-x: scroll;
		}

		#line {
			overflow-x: scroll;
			overflow-y: scroll;
		}
	}
</style>

<script>
	var url = window.location.href;
	var domain = url.replace(/^(?:https?:\/\/)?(?:www\.)?/, "");
	domain = domain.split("/")[0];

	function resposnsechart(callback) {

		var xhr = new XMLHttpRequest();
		var apiUrl = "https://" + domain + "/analytics_audit_quality/resposnsechart_safety_inspection"; // Replace with your API endpoint
		xhr.open("GET", apiUrl, true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && xhr.status === 200) {
				var responseData = JSON.parse(xhr.responseText);
				callback(responseData); // Call the callback function with the API data
			}
		};
		xhr.send();
	}

	function resposnseChart(apiData) {
		var labels = apiData.map(function(item) {
			return item.label_field;
		});

		var dataPoints = apiData.map(function(item) {
			return item.all_detail.count;
		});
		if (dataPoints.length == 1) {
			dataPoints.push(null);
			labels.push(" ");
		}
		// Create Chart.js chart
		var ctx = document.getElementById("resposnsechart").getContext("2d");
		ctx.canvas.parentNode.style.width = "100%"; // Set the container width to 100%
		ctx.canvas.parentNode.style.height = "100%";

		// Create a linear gradient fill for the chart
		var gradientFill = ctx.createLinearGradient(0, 0, 0, 400);
		gradientFill.addColorStop(0, "rgba(0, 128, 0, 0.8)"); // Start color
		gradientFill.addColorStop(1, "rgba(0, 128, 0, 0.1)"); // End color (more transparent)

		var myChart = new Chart(ctx, {
			type: "line",
			data: {
				labels: labels,
				datasets: [{
					label: "Audit Analysis",
					data: dataPoints,
					backgroundColor: gradientFill,
					borderColor: "rgba(0, 128, 0, 1)",
					borderWidth: 1,
					pointBackgroundColor: "rgba(0, 128, 0, 1)", // Green color with full opacity
					pointBorderColor: "rgba(0, 128, 0, 1)",
					pointHoverBackgroundColor: "rgba(255, 165, 0, 0.4)", // Orange color with reduced opacity
					pointHoverBorderColor: "rgba(0, 128, 0, 1)",
				}, ],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				title: {
					display: false,
					text: "Chart.js Line Chart",
				},
				tooltips: {
					enabled: true,
					mode: "single",
					callbacks: {
						label: function(tooltipItems, data) {
							var multistringText = [];
							var dataIndex = tooltipItems.index; // Get the index of the hovered data point
							var all_detail = apiData[dataIndex].all_detail;
							multistringText.push("Audits Conducted: " + all_detail.count);
							return multistringText;
						},
					},
				},
				hover: {
					mode: "nearest",
					intersect: true,
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: false,
							labelString: "Month",
						},
					}, ],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: false,
							labelString: "Value",
						},
						ticks: {

							min: 0,
							padding: 25,
							// forces step size to be 5 units
							stepSize: 30,
						},
					}, ],
				},
			},
		});
	}

	// Call the fetchDataFromAPI function and pass the callback function to create the chart
	setTimeout(function() {
		resposnsechart(resposnseChart);
	}, 1000);
	/*patient_feedback_analysis*/
</script>

<script>
	function printChart() {
		const canvas = document.getElementById('resposnsechart');
		const dataUrl = canvas.toDataURL();

		const reportText = document.getElementById('audit-report-text').innerText;

		const windowContent = `
		<html>
		<head>
			<title>Print Chart</title>
			<style>
				body {
					text-align: center;
					margin: 0;
					padding: 20px;
					font-family: Arial;
				}
				h3, p {
					margin-bottom: 10px;
				}
				img {
					max-width: 100%;
					height: auto;
				}
			</style>
		</head>
		<body>
			<h3>FACILITY SAFETY INSPECTION CHECKLIST & AUDIT</h3>
			<p>${reportText}</p>
			<img src="${dataUrl}" alt="Chart">
		</body>
		</html>
	`;

		const printWin = window.open('', '', 'width=800,height=600');
		printWin.document.open();
		printWin.document.write(windowContent);
		printWin.document.close();
		printWin.focus();

		setTimeout(() => {
			printWin.print();
			printWin.close();
		}, 500);
	}
</script>
<script>
	function downloadChartImage() {
		const canvas = document.getElementById('resposnsechart');
		const chartImage = canvas.toDataURL('image/png');

		const reportText = document.getElementById('audit-report-text').innerText;

		// Create new canvas
		const newCanvas = document.createElement('canvas');
		const ctx = newCanvas.getContext('2d');

		const width = canvas.width;
		const height = canvas.height;
		const extraHeight = 60; // Space for text

		newCanvas.width = width;
		newCanvas.height = height + extraHeight;

		// White background
		ctx.fillStyle = '#fff';
		ctx.fillRect(0, 0, newCanvas.width, newCanvas.height);

		// Draw the report text
		ctx.fillStyle = '#000';
		ctx.font = '20px Arial';
		ctx.fillText(reportText, 10, 30);

		// Draw the chart image after it loads
		const img = new Image();
		img.onload = function() {
			ctx.drawImage(img, 0, extraHeight);

			// Create downloadable image
			const finalImage = newCanvas.toDataURL('image/png');
			const link = document.createElement('a');
			link.href = finalImage;
			link.download = 'FACILITY SAFETY INSPECTION CHECKLIST & AUDIT.png';
			link.click();
		};
		img.src = chartImage;
	}
</script>