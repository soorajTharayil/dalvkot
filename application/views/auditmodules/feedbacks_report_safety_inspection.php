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
			<div class="col-lg-12 col-sm-12">
				<div class="panel panel-default">
					<div class="alert alert-dismissible" role="alert" style="margin-bottom: -12px;">
						<span class="p-l-30 p-r-30" style="font-size: 15px">
							<?php $text = "In the " .  $dates['pagetitle'] . "," . "a total of " . count($ip_feedbacks_count) . " audits were conducted." ?>
							<span class="typing-text"></span>
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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'slipperySt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperySt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_standSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_codedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_closedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'biohazardSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'segregationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_fillSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'kit_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'items_presentSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_knowledgeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_needleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'opening_dateSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_expireSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_limitsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'freezing_doneSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medical_itemsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'expired_medicineSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_near_expSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'overdatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extra_medicinesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'hazardous_materialSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'msds_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'workplace_storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'use_ppeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_devicesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_St.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_St.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'slipperySt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperySt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_St.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_St.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_chartSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_standSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_codedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_closedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'biohazardSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'segregationSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_fillSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'kit_accessibleSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'items_presentSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_knowledgeSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_needleSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'opening_dateSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'storageSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_expireSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_chartSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_limitsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'freezing_doneSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medical_itemsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'expired_medicineSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_availSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_near_expSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'overdatedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extra_medicinesSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'hazardous_materialSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'msds_sheetSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'workplace_storageSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'use_ppeSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_trainedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_devicesSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionSt.Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_St.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_St.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'slipperySt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperySt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_St.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_St.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_chartSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_standSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_codedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_closedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'biohazardSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'segregationSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_fillSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'kit_accessibleSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'items_presentSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_knowledgeSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_needleSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'opening_dateSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'storageSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_expireSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_chartSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_limitsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'freezing_doneSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medical_itemsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'expired_medicineSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_availSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_near_expSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'overdatedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extra_medicinesSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'hazardous_materialSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'msds_sheetSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'workplace_storageSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'use_ppeSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_trainedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_devicesSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionSt.Martins Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_St.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_St.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'slipperySt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperySt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_St.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_St.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_chartSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_standSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_codedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_closedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'biohazardSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'segregationSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_fillSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'kit_accessibleSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'items_presentSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_knowledgeSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_needleSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'opening_dateSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'storageSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_expireSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_chartSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_limitsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'freezing_doneSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medical_itemsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'expired_medicineSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_availSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_near_expSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'overdatedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extra_medicinesSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'hazardous_materialSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'msds_sheetSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'workplace_storageSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'use_ppeSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_trainedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_devicesSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionSt.Anns Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_St.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_St.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'slipperySt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperySt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_St.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_St.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_chartSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_standSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_codedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_closedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'biohazardSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'segregationSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_fillSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'kit_accessibleSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'items_presentSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_knowledgeSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_needleSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'opening_dateSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'storageSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_expireSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_chartSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_limitsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'freezing_doneSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medical_itemsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'expired_medicineSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_availSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_near_expSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'overdatedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extra_medicinesSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'hazardous_materialSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'msds_sheetSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'workplace_storageSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'use_ppeSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_trainedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_devicesSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionSt.Antonys Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_Paediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_Paediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'slipperyPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperyPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_Paediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_Paediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glarePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glarePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_chartPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_standPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_codedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_closedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'biohazardPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'segregationPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_fillPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessiblePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'kit_accessiblePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'items_presentPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_knowledgePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needlePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_needlePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_datePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'opening_datePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storagePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'storagePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expirePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_expirePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_chartPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_limitsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_donePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'freezing_donePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medical_itemsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicinePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'expired_medicinePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_availPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_near_expPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'overdatedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extra_medicinesPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'hazardous_materialPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'msds_sheetPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storagePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'workplace_storagePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessiblePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessiblePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'use_ppePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_trainedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_devicesPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visiblePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visiblePaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionPaediatric-Observation_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_OT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_OT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'slipperyOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperyOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_OT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_OT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_chartOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_standOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_codedOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_closedOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'biohazardOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'segregationOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_fillOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'kit_accessibleOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'items_presentOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_knowledgeOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_needleOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'opening_dateOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'storageOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_expireOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_chartOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_limitsOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'freezing_doneOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medical_itemsOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'expired_medicineOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_availOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_near_expOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'overdatedOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extra_medicinesOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'hazardous_materialOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'msds_sheetOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'workplace_storageOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'use_ppeOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_trainedOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_devicesOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionOT_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionOT_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_CCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_CCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'slipperyCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperyCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_CCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_CCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_chartCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_standCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_codedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_closedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'biohazardCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'segregationCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_fillCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'kit_accessibleCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'items_presentCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_knowledgeCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_needleCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'opening_dateCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'storageCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_expireCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_chartCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_limitsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'freezing_doneCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medical_itemsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'expired_medicineCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_availCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_near_expCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'overdatedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extra_medicinesCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'hazardous_materialCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'msds_sheetCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'workplace_storageCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'use_ppeCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_trainedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_devicesCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionCCU/ICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_Casualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_Casualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'slipperyCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperyCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_Casualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_Casualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_chartCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_standCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_codedCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_closedCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'biohazardCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'segregationCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_fillCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'kit_accessibleCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'items_presentCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_knowledgeCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_needleCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'opening_dateCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'storageCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_expireCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_chartCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_limitsCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'freezing_doneCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medical_itemsCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'expired_medicineCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_availCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_near_expCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'overdatedCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extra_medicinesCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'hazardous_materialCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'msds_sheetCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'workplace_storageCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'use_ppeCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_trainedCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_devicesCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionCasualty_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionCasualty_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_Dialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_Dialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'slipperyDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperyDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_Dialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_Dialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_chartDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_standDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_codedDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_closedDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'biohazardDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'segregationDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_fillDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'kit_accessibleDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'items_presentDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_knowledgeDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_needleDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'opening_dateDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'storageDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_expireDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_chartDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_limitsDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'freezing_doneDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medical_itemsDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'expired_medicineDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_availDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_near_expDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'overdatedDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extra_medicinesDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'hazardous_materialDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'msds_sheetDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'workplace_storageDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'use_ppeDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_trainedDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_devicesDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionDialysis_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionDialysis_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_Injection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_Injection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperyInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_Injection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_Injection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_chartInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_standInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_codedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_closedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'biohazardInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'segregationInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_fillInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'kit_accessibleInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'items_presentInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_knowledgeInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_needleInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'opening_dateInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'storageInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_expireInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_chartInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_limitsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'freezing_doneInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medical_itemsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'expired_medicineInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_availInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_near_expInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'overdatedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extra_medicinesInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'hazardous_materialInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'msds_sheetInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'workplace_storageInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'use_ppeInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_trainedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_devicesInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionInjection Room_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionInjection Room_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_NICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_NICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperyNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_NICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_NICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_chartNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_standNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_codedNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_closedNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'biohazardNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'segregationNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_fillNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'kit_accessibleNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'items_presentNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_knowledgeNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_needleNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'opening_dateNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'storageNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_expireNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_chartNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_limitsNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'freezing_doneNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medical_itemsNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'expired_medicineNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_availNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_near_expNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'overdatedNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extra_medicinesNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'hazardous_materialNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'msds_sheetNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'workplace_storageNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'use_ppeNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_trainedNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_devicesNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionNICU_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionNICU_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_Laboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_Laboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperyLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_Laboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_Laboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_chartLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_chartLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cylinder_standLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cylinder_standLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'containers_codedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_codedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_closedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_closedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'biohazardLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'biohazardLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'segregationLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'segregationLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'containers_fillLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'containers_fillLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'kit_accessibleLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'kit_accessibleLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'items_presentLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'items_presentLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_knowledgeLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_knowledgeLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// MULTI-DOSE VIALS
								echo '<td>' . (isset($data->{'vial_needleLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_needleLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'opening_dateLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'opening_dateLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'storageLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'storageLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'vial_expireLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'vial_expireLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'temperature_chartLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_chartLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'temperature_limitsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'temperature_limitsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'freezing_doneLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'freezing_doneLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medical_itemsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medical_itemsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'expired_medicineLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'expired_medicineLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'medicines_availLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_availLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'medicines_near_expLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'medicines_near_expLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'overdatedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'overdatedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extra_medicinesLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extra_medicinesLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'hazardous_materialLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'hazardous_materialLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'msds_sheetLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'msds_sheetLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'workplace_storageLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'workplace_storageLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'extinguishers_accessibleLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'use_ppeLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'use_ppeLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'staff_trainedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'staff_trainedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_devicesLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_devicesLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'work_station_neatLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'equipment_numbered'}) ? htmlspecialchars($data->{'equipment_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'log_sheet'}) ? htmlspecialchars($data->{'log_sheet'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_maintain'}) ? htmlspecialchars($data->{'equipment_maintain'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'assets_numbered'}) ? htmlspecialchars($data->{'assets_numbered'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'asset_register'}) ? htmlspecialchars($data->{'asset_register'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'complaint_updated'}) ? htmlspecialchars($data->{'complaint_updated'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'periodic_maintain'}) ? htmlspecialchars($data->{'periodic_maintain'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'patient_right_visibleLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionLaboratory_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionLaboratory_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_Basement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_Basement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperyBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//CORRIDOR & FLOORS
								echo '<td>' . (isset($data->{'obstruction_Basement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_Basement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//LIGHTING ALL OVER THE AREA
								echo '<td>' . (isset($data->{'natural_lightBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//ELECTRICAL
								echo '<td>' . (isset($data->{'plug_pointsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//FIRE AND EVACUATION
								echo '<td>' . (isset($data->{'extinguishers_accessibleBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';


								//GENERAL CONDITION OF THE DEPARTMENT
								echo '<td>' . (isset($data->{'work_station_neatBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//SIGNAGES
								echo '<td>' . (isset($data->{'patient_right_visibleBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionBasement-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_Ground Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_Ground Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperyGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//CORRIDOR & FLOORS
								echo '<td>' . (isset($data->{'obstruction_Ground Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_Ground Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//LIGHTING ALL OVER THE AREA
								echo '<td>' . (isset($data->{'natural_lightGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//ELECTRICAL
								echo '<td>' . (isset($data->{'plug_pointsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//FIRE AND EVACUATION
								echo '<td>' . (isset($data->{'extinguishers_accessibleGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';


								//GENERAL CONDITION OF THE DEPARTMENT
								echo '<td>' . (isset($data->{'work_station_neatGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//SIGNAGES
								echo '<td>' . (isset($data->{'patient_right_visibleGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionGround Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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


								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_First Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_First Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'slipperyFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperyFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//CORRIDOR & FLOORS
								echo '<td>' . (isset($data->{'obstruction_First Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_First Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//LIGHTING ALL OVER THE AREA
								echo '<td>' . (isset($data->{'natural_lightFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//ELECTRICAL
								echo '<td>' . (isset($data->{'plug_pointsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								//FIRE AND EVACUATION
								echo '<td>' . (isset($data->{'extinguishers_accessibleFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_accessibleFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_availFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_availFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_trainedFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_trainedFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_routeFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_routeFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_doorsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_doorsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'extinguishers_maintainedFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'extinguishers_maintainedFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'exit_signagesFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'exit_signagesFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';


								// GENERAL CONDITION OF THE DEPARTMENT
								echo '<td>' . (isset($data->{'work_station_neatFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'work_station_neatFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cleaning_checklistFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cleaning_checklistFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'equipment_accidentsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'equipment_accidentsFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washrooms_cleanFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washrooms_cleanFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'washroom_checklistFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'washroom_checklistFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								// SIGNAGES
								echo '<td>' . (isset($data->{'patient_right_visibleFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'patient_right_visibleFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'signages_placedFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'signages_placedFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'missionFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'missionFirst Floor-Common Area_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

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
		var apiUrl = "https://" + domain + "/analytics_audit_quality/resposnsechart_tat_blood"; // Replace with your API endpoint
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