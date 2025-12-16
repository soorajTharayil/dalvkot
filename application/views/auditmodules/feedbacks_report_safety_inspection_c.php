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
							$param = json_decode($paramm->dataset);
							foreach ($param as $data) {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ? date('d-M-Y', strtotime($data->datetime)) . '<br>' . date('g:i a', strtotime($data->datetime)) : '') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								//STAIRWAYS
								echo '<td>' . (isset($data->{'obstruction_stairways_St. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_stairways_St. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'slipperySt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'slipperySt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'railsSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'railsSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'obstruction_corridor_St. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'obstruction_corridor_St. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'floors_slipSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'floors_slipSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'avoid_fallsSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'avoid_fallsSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'carpetSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'carpetSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'warning_signagesSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'warning_signagesSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'natural_lightSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'natural_lightSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'illuminationSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'illuminationSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'glareSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'glareSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'night_lightsSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'night_lightsSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'plug_pointsSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'plug_pointsSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_damagedSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_damagedSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cables_exposedSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cables_exposedSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'safety_matsSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'safety_matsSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'fire_preventSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'fire_preventSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'cords_conditionsSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'cords_conditionsSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';

								echo '<td>' . (isset($data->{'sufficient_oxygenSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'sufficient_oxygenSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
								echo '<td>' . (isset($data->{'ro_waterSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) ? htmlspecialchars($data->{'ro_waterSt. Thomas Ward_OXYGEN CYLINDER STORAGE AREA'}) : '') . '</td>';
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

								echo '<td>' . $data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'equipment_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'log_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'assets_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'asset_registerSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'complaint_updatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'periodic_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->comment . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';

						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<!-- <div class="col-lg-12">
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
							$param = json_decode($paramm->dataset);
							foreach ($param as $data) {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ? date('d-M-Y', strtotime($data->datetime)) . '<br>' . date('g:i a', strtotime($data->datetime)) : '') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								//STAIRWAYS
								echo '<td>' . $data->{'obstruction_stairways_St. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'slipperySt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'railsSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								//CORRIDOR
								echo '<td>' . $data->{'obstruction_corridor_St. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'floors_slipSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'avoid_fallsSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'carpetSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'warning_signagesSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								//LIGHTING ALL OVER THE AREA
								echo '<td>' . $data->{'natural_lightSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'illuminationSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'glareSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'night_lightsSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								//ELECTRICAL
								echo '<td>' . $data->{'plug_pointsSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_damagedSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cables_exposedSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_matsSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_preventSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_conditionsSt. Alphonsa Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								//OXYGEN CYLINDERS
								echo '<td>' . $data->{'sufficient_oxygenSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'ro_waterSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_standSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								//BIO-MEDICAL WASTE
								echo '<td>' . $data->{'containers_codedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_closedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'biohazardSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'segregationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_fillSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								//SPILL KIT
								echo '<td>' . $data->{'kit_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'items_presentSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_knowledgeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								//MULTI-DOSE VIALS
								echo '<td>' . $data->{'vial_needleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'opening_dateSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'vial_expireSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								//MULTI-DOSE VIALS
								echo '<td>' . $data->{'temperature_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'temperature_limitsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'freezing_doneSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medical_itemsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'expired_medicineSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								//REFRIGERATOR
								echo '<td>' . $data->{'medicines_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medicines_near_expSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'overdatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extra_medicinesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'hazardous_materialSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'msds_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'workplace_storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'extinguishers_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_routeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_doorsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_maintainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'use_ppeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_devicesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'equipment_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'log_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'assets_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'asset_registerSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'complaint_updatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'periodic_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';


								echo '<td>' . $data->comment . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';

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
						echo '<table class="martin table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
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
							$param = json_decode($paramm->dataset);
							foreach ($param as $data) {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ? date('d-M-Y', strtotime($data->datetime)) . '<br>' . date('g:i a', strtotime($data->datetime)) : '') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';
								echo '<td>' . $data->{'obstruction_stairways_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'slipperySt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'railsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'obstruction_corridor_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'floors_slipSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'avoid_fallsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'carpetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'warning_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'natural_lightSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'illuminationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'glareSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'night_lightsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'plug_pointsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_damagedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cables_exposedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_matsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_preventSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_conditionsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'sufficient_oxygenSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'ro_waterSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_standSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'containers_codedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_closedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'biohazardSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'segregationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_fillSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'kit_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'items_presentSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_knowledgeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'vial_needleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'opening_dateSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'vial_expireSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'temperature_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'temperature_limitsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'freezing_doneSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medical_itemsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'expired_medicineSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'medicines_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medicines_near_expSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'overdatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extra_medicinesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'hazardous_materialSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'msds_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'workplace_storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'extinguishers_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_routeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_doorsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_maintainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'use_ppeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_devicesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'equipment_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'log_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'assets_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'asset_registerSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'complaint_updatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'periodic_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';


								echo '<td>' . $data->comment . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
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
						foreach ($feedbacktaken as $paramm) {
							$param = json_decode($paramm->dataset);
							// print_r($param);exit;
							echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
							echo "<td>$sl</td>";
							echo '<td style="white-space: nowrap;">' .
								(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
								'</td>';
							echo '<td>' . $param->dep . '</td>';

							// Dynamically extract keys that match your columns
							$obstructionKey = 'obstruction_stairways_' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$slipperyKey = 'slippery' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$railsKey = 'rails' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';

							echo '<td>' . (isset($param->$obstructionKey) ? ucfirst($param->$obstructionKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$slipperyKey) ? ucfirst($param->$slipperyKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$railsKey) ? ucfirst($param->$railsKey) : '-') . '</td>';
							echo '<td>' . (!empty($param->comment) ? htmlspecialchars($param->comment) : 'No comments') . '</td>';
							echo '</tr>';
							$sl++;
						}

						echo '</tbody>';
						echo '</table>';

						// Function to display the data for Code Pink
						function displayStairways($data)
						{
							if (!empty($data)) {
								echo '<table class="stairways table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
								echo '<thead>
									<th>Sl. No.</th>
									<th>Date</th>
									<th>Department</th>
									<th>Is the area free of obstruction?</th>
									<th>Are the step surfaces slippery?</th>
									<th>Are the stairs and grab rails in good condition?</th>
									<th>Additional comments</th>
								</thead>';
								echo '<tbody>';
								$sl = 1;
								foreach ($data as $param) {
									echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
									echo "<td>$sl</td>";
									echo '<td style="white-space: nowrap;">' .
										(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
										'</td>';
									echo '<td>' . $param->dep . '</td>';
									echo '<td>' . $param->obstruction . '</td>';
									echo '<td>' . $param->slippery . '</td>';
									echo '<td>' . $param->rails . '</td>';
									echo '<td>' . $param->comment . '</td>';
									echo '</tr>';
									$sl++;
								}
								echo '</tbody>';
								echo '</table>';
							}
						}

						// Display the tables for each checklist type
						displayStairways($stairwaysData);

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
							$param = json_decode($paramm->dataset);
							foreach ($param as $data) {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ? date('d-M-Y', strtotime($data->datetime)) . '<br>' . date('g:i a', strtotime($data->datetime)) : '') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';
								echo '<td>' . $data->{'obstruction_stairways_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'slipperySt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'railsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'obstruction_corridor_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'floors_slipSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'avoid_fallsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'carpetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'warning_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'natural_lightSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'illuminationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'glareSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'night_lightsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'plug_pointsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_damagedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cables_exposedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_matsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_preventSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_conditionsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'sufficient_oxygenSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'ro_waterSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_standSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'containers_codedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_closedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'biohazardSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'segregationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_fillSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'kit_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'items_presentSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_knowledgeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'vial_needleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'opening_dateSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'vial_expireSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'temperature_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'temperature_limitsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'freezing_doneSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medical_itemsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'expired_medicineSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'medicines_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medicines_near_expSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'overdatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extra_medicinesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'hazardous_materialSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'msds_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'workplace_storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'extinguishers_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_routeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_doorsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_maintainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'use_ppeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_devicesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'equipment_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'log_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'assets_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'asset_registerSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'complaint_updatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'periodic_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';


								echo '<td>' . $data->comment . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
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
							$param = json_decode($paramm->dataset);
							foreach ($param as $data) {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ? date('d-M-Y', strtotime($data->datetime)) . '<br>' . date('g:i a', strtotime($data->datetime)) : '') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';
								echo '<td>' . $data->{'obstruction_stairways_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'slipperySt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'railsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'obstruction_corridor_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'floors_slipSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'avoid_fallsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'carpetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'warning_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'natural_lightSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'illuminationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'glareSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'night_lightsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'plug_pointsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_damagedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cables_exposedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_matsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_preventSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_conditionsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'sufficient_oxygenSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'ro_waterSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_standSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'containers_codedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_closedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'biohazardSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'segregationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_fillSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'kit_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'items_presentSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_knowledgeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'vial_needleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'opening_dateSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'vial_expireSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'temperature_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'temperature_limitsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'freezing_doneSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medical_itemsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'expired_medicineSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'medicines_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medicines_near_expSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'overdatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extra_medicinesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'hazardous_materialSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'msds_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'workplace_storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'extinguishers_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_routeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_doorsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_maintainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'use_ppeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_devicesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'equipment_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'log_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'assets_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'asset_registerSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'complaint_updatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'periodic_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';


								echo '<td>' . $data->comment . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
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
							$param = json_decode($paramm->dataset);
							foreach ($param as $data) {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ? date('d-M-Y', strtotime($data->datetime)) . '<br>' . date('g:i a', strtotime($data->datetime)) : '') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';
								echo '<td>' . $data->{'obstruction_stairways_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'slipperySt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'railsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'obstruction_corridor_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'floors_slipSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'avoid_fallsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'carpetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'warning_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'natural_lightSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'illuminationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'glareSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'night_lightsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'plug_pointsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_damagedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cables_exposedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_matsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_preventSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_conditionsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'sufficient_oxygenSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'ro_waterSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_standSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'containers_codedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_closedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'biohazardSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'segregationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_fillSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'kit_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'items_presentSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_knowledgeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'vial_needleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'opening_dateSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'vial_expireSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'temperature_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'temperature_limitsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'freezing_doneSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medical_itemsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'expired_medicineSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'medicines_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medicines_near_expSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'overdatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extra_medicinesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'hazardous_materialSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'msds_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'workplace_storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'extinguishers_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_routeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_doorsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_maintainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'use_ppeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_devicesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'equipment_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'log_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'assets_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'asset_registerSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'complaint_updatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'periodic_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';


								echo '<td>' . $data->comment . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
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
							$param = json_decode($paramm->dataset);
							foreach ($param as $data) {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ? date('d-M-Y', strtotime($data->datetime)) . '<br>' . date('g:i a', strtotime($data->datetime)) : '') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';
								echo '<td>' . $data->{'obstruction_stairways_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'slipperySt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'railsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'obstruction_corridor_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'floors_slipSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'avoid_fallsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'carpetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'warning_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'natural_lightSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'illuminationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'glareSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'night_lightsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'plug_pointsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_damagedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cables_exposedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_matsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_preventSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_conditionsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'sufficient_oxygenSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'ro_waterSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_standSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'containers_codedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_closedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'biohazardSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'segregationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_fillSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'kit_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'items_presentSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_knowledgeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'vial_needleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'opening_dateSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'vial_expireSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'temperature_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'temperature_limitsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'freezing_doneSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medical_itemsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'expired_medicineSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'medicines_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medicines_near_expSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'overdatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extra_medicinesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'hazardous_materialSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'msds_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'workplace_storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'extinguishers_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_routeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_doorsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_maintainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'use_ppeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_devicesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'equipment_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'log_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'assets_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'asset_registerSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'complaint_updatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'periodic_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';


								echo '<td>' . $data->comment . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
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
						echo '<table class="casuality table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
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
							$param = json_decode($paramm->dataset);
							foreach ($param as $data) {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ? date('d-M-Y', strtotime($data->datetime)) . '<br>' . date('g:i a', strtotime($data->datetime)) : '') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';
								echo '<td>' . $data->{'obstruction_stairways_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'slipperySt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'railsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'obstruction_corridor_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'floors_slipSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'avoid_fallsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'carpetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'warning_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'natural_lightSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'illuminationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'glareSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'night_lightsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'plug_pointsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_damagedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cables_exposedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_matsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_preventSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_conditionsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'sufficient_oxygenSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'ro_waterSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_standSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'containers_codedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_closedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'biohazardSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'segregationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_fillSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'kit_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'items_presentSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_knowledgeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'vial_needleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'opening_dateSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'vial_expireSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'temperature_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'temperature_limitsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'freezing_doneSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medical_itemsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'expired_medicineSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'medicines_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medicines_near_expSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'overdatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extra_medicinesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'hazardous_materialSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'msds_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'workplace_storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'extinguishers_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_routeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_doorsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_maintainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'use_ppeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_devicesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'equipment_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'log_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'assets_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'asset_registerSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'complaint_updatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'periodic_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';


								echo '<td>' . $data->comment . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
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
							$param = json_decode($paramm->dataset);
							foreach ($param as $data) {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ? date('d-M-Y', strtotime($data->datetime)) . '<br>' . date('g:i a', strtotime($data->datetime)) : '') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';
								echo '<td>' . $data->{'obstruction_stairways_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'slipperySt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'railsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'obstruction_corridor_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'floors_slipSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'avoid_fallsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'carpetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'warning_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'natural_lightSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'illuminationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'glareSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'night_lightsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'plug_pointsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_damagedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cables_exposedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_matsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_preventSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_conditionsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'sufficient_oxygenSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'ro_waterSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_standSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'containers_codedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_closedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'biohazardSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'segregationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_fillSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'kit_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'items_presentSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_knowledgeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'vial_needleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'opening_dateSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'vial_expireSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'temperature_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'temperature_limitsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'freezing_doneSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medical_itemsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'expired_medicineSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'medicines_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medicines_near_expSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'overdatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extra_medicinesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'hazardous_materialSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'msds_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'workplace_storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'extinguishers_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_routeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_doorsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_maintainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'use_ppeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_devicesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'equipment_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'log_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'assets_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'asset_registerSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'complaint_updatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'periodic_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';


								echo '<td>' . $data->comment . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
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
							$param = json_decode($paramm->dataset);
							foreach ($param as $data) {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ? date('d-M-Y', strtotime($data->datetime)) . '<br>' . date('g:i a', strtotime($data->datetime)) : '') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';
								echo '<td>' . $data->{'obstruction_stairways_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'slipperySt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'railsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'obstruction_corridor_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'floors_slipSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'avoid_fallsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'carpetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'warning_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'natural_lightSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'illuminationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'glareSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'night_lightsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'plug_pointsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_damagedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cables_exposedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_matsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_preventSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_conditionsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'sufficient_oxygenSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'ro_waterSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_standSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'containers_codedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_closedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'biohazardSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'segregationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_fillSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'kit_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'items_presentSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_knowledgeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'vial_needleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'opening_dateSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'vial_expireSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'temperature_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'temperature_limitsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'freezing_doneSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medical_itemsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'expired_medicineSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'medicines_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medicines_near_expSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'overdatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extra_medicinesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'hazardous_materialSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'msds_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'workplace_storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'extinguishers_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_routeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_doorsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_maintainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'use_ppeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_devicesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'equipment_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'log_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'assets_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'asset_registerSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'complaint_updatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'periodic_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';


								echo '<td>' . $data->comment . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
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
							$param = json_decode($paramm->dataset);
							foreach ($param as $data) {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ? date('d-M-Y', strtotime($data->datetime)) . '<br>' . date('g:i a', strtotime($data->datetime)) : '') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';
								echo '<td>' . $data->{'obstruction_stairways_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'slipperySt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'railsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'obstruction_corridor_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'floors_slipSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'avoid_fallsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'carpetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'warning_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'natural_lightSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'illuminationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'glareSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'night_lightsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'plug_pointsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_damagedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cables_exposedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_matsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_preventSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_conditionsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'sufficient_oxygenSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'ro_waterSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_standSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'containers_codedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_closedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'biohazardSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'segregationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_fillSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'kit_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'items_presentSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_knowledgeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'vial_needleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'opening_dateSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'vial_expireSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'temperature_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'temperature_limitsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'freezing_doneSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medical_itemsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'expired_medicineSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'medicines_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medicines_near_expSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'overdatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extra_medicinesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'hazardous_materialSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'msds_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'workplace_storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'extinguishers_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_routeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_doorsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_maintainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'use_ppeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_devicesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'equipment_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'log_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'assets_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'asset_registerSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'complaint_updatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'periodic_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';


								echo '<td>' . $data->comment . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
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
							$param = json_decode($paramm->dataset);
							foreach ($param as $data) {
								echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
								echo "<td>$sl</td>";
								echo '<td style="white-space: nowrap;">' .
									(isset($data->datetime) ? date('d-M-Y', strtotime($data->datetime)) . '<br>' . date('g:i a', strtotime($data->datetime)) : '') .
									'</td>';
								echo '<td>' . $data->dep . '</td>';

								echo '<td>' . $data->{'obstruction_stairways_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'slipperySt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'railsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'obstruction_corridor_St.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'floors_slipSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'avoid_fallsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'carpetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'warning_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'natural_lightSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'illuminationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'glareSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'night_lightsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'plug_pointsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_damagedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cables_exposedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_matsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_preventSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cords_conditionsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'sufficient_oxygenSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'ro_waterSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cylinder_standSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'containers_codedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_closedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'biohazardSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'segregationSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'containers_fillSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'kit_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'items_presentSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_knowledgeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'vial_needleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'opening_dateSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'vial_expireSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'temperature_chartSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'temperature_limitsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'freezing_doneSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medical_itemsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'expired_medicineSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'medicines_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'medicines_near_expSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'overdatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extra_medicinesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'hazardous_materialSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'msds_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'workplace_storageSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'extinguishers_accessibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_availSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_routeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'fire_doorsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'extinguishers_maintainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'exit_signagesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'use_ppeSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'staff_trainedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'safety_devicesSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'work_station_neatSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'cleaning_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_accidentsSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washrooms_cleanSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'washroom_checklistSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'equipment_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'log_sheetSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'equipment_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'assets_numberedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'asset_registerSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'complaint_updatedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'periodic_maintainSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';

								echo '<td>' . $data->{'patient_right_visibleSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'signages_placedSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';
								echo '<td>' . $data->{'missionSt.Thomas Ward_OXYGEN CYLINDER STORAGE AREA'} . '</td>';


								echo '<td>' . $data->comment . '</td>';
								echo '</tr>';
								$sl++;
							}
						}
						echo '</tbody>';
						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Basement- Common Area</h3>
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
						foreach ($feedbacktaken as $paramm) {
							$param = json_decode($paramm->dataset);
							// print_r($param);exit;
							echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
							echo "<td>$sl</td>";
							echo '<td style="white-space: nowrap;">' .
								(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
								'</td>';
							echo '<td>' . $param->dep . '</td>';

							// Dynamically extract keys that match your columns
							$obstructionKey = 'obstruction_stairways_' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$slipperyKey = 'slippery' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$railsKey = 'rails' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';

							echo '<td>' . (isset($param->$obstructionKey) ? ucfirst($param->$obstructionKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$slipperyKey) ? ucfirst($param->$slipperyKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$railsKey) ? ucfirst($param->$railsKey) : '-') . '</td>';
							echo '<td>' . (!empty($param->comment) ? htmlspecialchars($param->comment) : 'No comments') . '</td>';
							echo '</tr>';
							$sl++;
						}

						echo '</tbody>';
						echo '</table>';

						// Function to display the data for Code Pink
						function displayStairways($data)
						{
							if (!empty($data)) {
								echo '<table class="stairways table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
								echo '<thead>
									<th>Sl. No.</th>
									<th>Date</th>
									<th>Department</th>
									<th>Is the area free of obstruction?</th>
									<th>Are the step surfaces slippery?</th>
									<th>Are the stairs and grab rails in good condition?</th>
									<th>Additional comments</th>
								</thead>';
								echo '<tbody>';
								$sl = 1;
								foreach ($data as $param) {
									echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
									echo "<td>$sl</td>";
									echo '<td style="white-space: nowrap;">' .
										(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
										'</td>';
									echo '<td>' . $param->dep . '</td>';
									echo '<td>' . $param->obstruction . '</td>';
									echo '<td>' . $param->slippery . '</td>';
									echo '<td>' . $param->rails . '</td>';
									echo '<td>' . $param->comment . '</td>';
									echo '</tr>';
									$sl++;
								}
								echo '</tbody>';
								echo '</table>';
							}
						}

						// Display the tables for each checklist type
						displayStairways($stairwaysData);

						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>Ground Floor- Common Area</h3>
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
						foreach ($feedbacktaken as $paramm) {
							$param = json_decode($paramm->dataset);
							// print_r($param);exit;
							echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
							echo "<td>$sl</td>";
							echo '<td style="white-space: nowrap;">' .
								(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
								'</td>';
							echo '<td>' . $param->dep . '</td>';

							// Dynamically extract keys that match your columns
							$obstructionKey = 'obstruction_stairways_' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$slipperyKey = 'slippery' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$railsKey = 'rails' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';

							echo '<td>' . (isset($param->$obstructionKey) ? ucfirst($param->$obstructionKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$slipperyKey) ? ucfirst($param->$slipperyKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$railsKey) ? ucfirst($param->$railsKey) : '-') . '</td>';
							echo '<td>' . (!empty($param->comment) ? htmlspecialchars($param->comment) : 'No comments') . '</td>';
							echo '</tr>';
							$sl++;
						}

						echo '</tbody>';
						echo '</table>';

						// Function to display the data for Code Pink
						function displayStairways($data)
						{
							if (!empty($data)) {
								echo '<table class="stairways table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
								echo '<thead>
									<th>Sl. No.</th>
									<th>Date</th>
									<th>Department</th>
									<th>Is the area free of obstruction?</th>
									<th>Are the step surfaces slippery?</th>
									<th>Are the stairs and grab rails in good condition?</th>
									<th>Additional comments</th>
								</thead>';
								echo '<tbody>';
								$sl = 1;
								foreach ($data as $param) {
									echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
									echo "<td>$sl</td>";
									echo '<td style="white-space: nowrap;">' .
										(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
										'</td>';
									echo '<td>' . $param->dep . '</td>';
									echo '<td>' . $param->obstruction . '</td>';
									echo '<td>' . $param->slippery . '</td>';
									echo '<td>' . $param->rails . '</td>';
									echo '<td>' . $param->comment . '</td>';
									echo '</tr>';
									$sl++;
								}
								echo '</tbody>';
								echo '</table>';
							}
						}

						// Display the tables for each checklist type
						displayStairways($stairwaysData);

						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="text-align: left;">
						<h3>First Floor- Common Area</h3>
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
						foreach ($feedbacktaken as $paramm) {
							$param = json_decode($paramm->dataset);
							// print_r($param);exit;
							echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
							echo "<td>$sl</td>";
							echo '<td style="white-space: nowrap;">' .
								(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
								'</td>';
							echo '<td>' . $param->dep . '</td>';

							// Dynamically extract keys that match your columns
							$obstructionKey = 'obstruction_stairways_' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$slipperyKey = 'slippery' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$railsKey = 'rails' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';

							echo '<td>' . (isset($param->$obstructionKey) ? ucfirst($param->$obstructionKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$slipperyKey) ? ucfirst($param->$slipperyKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$railsKey) ? ucfirst($param->$railsKey) : '-') . '</td>';
							echo '<td>' . (!empty($param->comment) ? htmlspecialchars($param->comment) : 'No comments') . '</td>';
							echo '</tr>';
							$sl++;
						}

						echo '</tbody>';
						echo '</table>';

						// Function to display the data for Code Pink
						function displayStairways($data)
						{
							if (!empty($data)) {
								echo '<table class="stairways table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
								echo '<thead>
									<th>Sl. No.</th>
									<th>Date</th>
									<th>Department</th>
									<th>Is the area free of obstruction?</th>
									<th>Are the step surfaces slippery?</th>
									<th>Are the stairs and grab rails in good condition?</th>
									<th>Additional comments</th>
								</thead>';
								echo '<tbody>';
								$sl = 1;
								foreach ($data as $param) {
									echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
									echo "<td>$sl</td>";
									echo '<td style="white-space: nowrap;">' .
										(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
										'</td>';
									echo '<td>' . $param->dep . '</td>';
									echo '<td>' . $param->obstruction . '</td>';
									echo '<td>' . $param->slippery . '</td>';
									echo '<td>' . $param->rails . '</td>';
									echo '<td>' . $param->comment . '</td>';
									echo '</tr>';
									$sl++;
								}
								echo '</tbody>';
								echo '</table>';
							}
						}

						// Display the tables for each checklist type
						displayStairways($stairwaysData);

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
						foreach ($feedbacktaken as $paramm) {
							$param = json_decode($paramm->dataset);
							// print_r($param);exit;
							echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
							echo "<td>$sl</td>";
							echo '<td style="white-space: nowrap;">' .
								(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
								'</td>';
							echo '<td>' . $param->dep . '</td>';

							// Dynamically extract keys that match your columns
							$obstructionKey = 'obstruction_stairways_' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$slipperyKey = 'slippery' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$railsKey = 'rails' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';

							echo '<td>' . (isset($param->$obstructionKey) ? ucfirst($param->$obstructionKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$slipperyKey) ? ucfirst($param->$slipperyKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$railsKey) ? ucfirst($param->$railsKey) : '-') . '</td>';
							echo '<td>' . (!empty($param->comment) ? htmlspecialchars($param->comment) : 'No comments') . '</td>';
							echo '</tr>';
							$sl++;
						}

						echo '</tbody>';
						echo '</table>';

						// Function to display the data for Code Pink
						function displayStairways($data)
						{
							if (!empty($data)) {
								echo '<table class="stairways table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
								echo '<thead>
									<th>Sl. No.</th>
									<th>Date</th>
									<th>Department</th>
									<th>Is the area free of obstruction?</th>
									<th>Are the step surfaces slippery?</th>
									<th>Are the stairs and grab rails in good condition?</th>
									<th>Additional comments</th>
								</thead>';
								echo '<tbody>';
								$sl = 1;
								foreach ($data as $param) {
									echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
									echo "<td>$sl</td>";
									echo '<td style="white-space: nowrap;">' .
										(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
										'</td>';
									echo '<td>' . $param->dep . '</td>';
									echo '<td>' . $param->obstruction . '</td>';
									echo '<td>' . $param->slippery . '</td>';
									echo '<td>' . $param->rails . '</td>';
									echo '<td>' . $param->comment . '</td>';
									echo '</tr>';
									$sl++;
								}
								echo '</tbody>';
								echo '</table>';
							}
						}

						// Display the tables for each checklist type
						displayStairways($stairwaysData);

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
						echo '<table class="waters table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
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
						foreach ($feedbacktaken as $paramm) {
							$param = json_decode($paramm->dataset);
							// print_r($param);exit;
							echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
							echo "<td>$sl</td>";
							echo '<td style="white-space: nowrap;">' .
								(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
								'</td>';
							echo '<td>' . $param->dep . '</td>';

							// Dynamically extract keys that match your columns
							$obstructionKey = 'obstruction_stairways_' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$slipperyKey = 'slippery' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$railsKey = 'rails' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';

							echo '<td>' . (isset($param->$obstructionKey) ? ucfirst($param->$obstructionKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$slipperyKey) ? ucfirst($param->$slipperyKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$railsKey) ? ucfirst($param->$railsKey) : '-') . '</td>';
							echo '<td>' . (!empty($param->comment) ? htmlspecialchars($param->comment) : 'No comments') . '</td>';
							echo '</tr>';
							$sl++;
						}

						echo '</tbody>';
						echo '</table>';

						// Function to display the data for Code Pink
						function displayStairways($data)
						{
							if (!empty($data)) {
								echo '<table class="stairways table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
								echo '<thead>
									<th>Sl. No.</th>
									<th>Date</th>
									<th>Department</th>
									<th>Is the area free of obstruction?</th>
									<th>Are the step surfaces slippery?</th>
									<th>Are the stairs and grab rails in good condition?</th>
									<th>Additional comments</th>
								</thead>';
								echo '<tbody>';
								$sl = 1;
								foreach ($data as $param) {
									echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
									echo "<td>$sl</td>";
									echo '<td style="white-space: nowrap;">' .
										(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
										'</td>';
									echo '<td>' . $param->dep . '</td>';
									echo '<td>' . $param->obstruction . '</td>';
									echo '<td>' . $param->slippery . '</td>';
									echo '<td>' . $param->rails . '</td>';
									echo '<td>' . $param->comment . '</td>';
									echo '</tr>';
									$sl++;
								}
								echo '</tbody>';
								echo '</table>';
							}
						}

						// Display the tables for each checklist type
						displayStairways($stairwaysData);

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
						echo '<table class="elecarea table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
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
						foreach ($feedbacktaken as $paramm) {
							$param = json_decode($paramm->dataset);
							// print_r($param);exit;
							echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
							echo "<td>$sl</td>";
							echo '<td style="white-space: nowrap;">' .
								(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
								'</td>';
							echo '<td>' . $param->dep . '</td>';

							// Dynamically extract keys that match your columns
							$obstructionKey = 'obstruction_stairways_' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$slipperyKey = 'slippery' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$railsKey = 'rails' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';

							echo '<td>' . (isset($param->$obstructionKey) ? ucfirst($param->$obstructionKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$slipperyKey) ? ucfirst($param->$slipperyKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$railsKey) ? ucfirst($param->$railsKey) : '-') . '</td>';
							echo '<td>' . (!empty($param->comment) ? htmlspecialchars($param->comment) : 'No comments') . '</td>';
							echo '</tr>';
							$sl++;
						}

						echo '</tbody>';
						echo '</table>';

						// Function to display the data for Code Pink
						function displayStairways($data)
						{
							if (!empty($data)) {
								echo '<table class="stairways table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
								echo '<thead>
									<th>Sl. No.</th>
									<th>Date</th>
									<th>Department</th>
									<th>Is the area free of obstruction?</th>
									<th>Are the step surfaces slippery?</th>
									<th>Are the stairs and grab rails in good condition?</th>
									<th>Additional comments</th>
								</thead>';
								echo '<tbody>';
								$sl = 1;
								foreach ($data as $param) {
									echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
									echo "<td>$sl</td>";
									echo '<td style="white-space: nowrap;">' .
										(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
										'</td>';
									echo '<td>' . $param->dep . '</td>';
									echo '<td>' . $param->obstruction . '</td>';
									echo '<td>' . $param->slippery . '</td>';
									echo '<td>' . $param->rails . '</td>';
									echo '<td>' . $param->comment . '</td>';
									echo '</tr>';
									$sl++;
								}
								echo '</tbody>';
								echo '</table>';
							}
						}

						// Display the tables for each checklist type
						displayStairways($stairwaysData);

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
						foreach ($feedbacktaken as $paramm) {
							$param = json_decode($paramm->dataset);
							// print_r($param);exit;
							echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
							echo "<td>$sl</td>";
							echo '<td style="white-space: nowrap;">' .
								(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
								'</td>';
							echo '<td>' . $param->dep . '</td>';

							// Dynamically extract keys that match your columns
							$obstructionKey = 'obstruction_stairways_' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$slipperyKey = 'slippery' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';
							$railsKey = 'rails' . str_replace(' ', '_', $param->dep) . '_OXYGEN_CYLINDER_STORAGE_AREA';

							echo '<td>' . (isset($param->$obstructionKey) ? ucfirst($param->$obstructionKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$slipperyKey) ? ucfirst($param->$slipperyKey) : '-') . '</td>';
							echo '<td>' . (isset($param->$railsKey) ? ucfirst($param->$railsKey) : '-') . '</td>';
							echo '<td>' . (!empty($param->comment) ? htmlspecialchars($param->comment) : 'No comments') . '</td>';
							echo '</tr>';
							$sl++;
						}

						echo '</tbody>';
						echo '</table>';

						// Function to display the data for Code Pink
						function displayStairways($data)
						{
							if (!empty($data)) {
								echo '<table class="stairways table table-striped table-hover table-bordered" cellspacing="0" width="100%">';
								echo '<thead>
									<th>Sl. No.</th>
									<th>Date</th>
									<th>Department</th>
									<th>Is the area free of obstruction?</th>
									<th>Are the step surfaces slippery?</th>
									<th>Are the stairs and grab rails in good condition?</th>
									<th>Additional comments</th>
								</thead>';
								echo '<tbody>';
								$sl = 1;
								foreach ($data as $param) {
									echo '<tr class="' . (($sl & 1) ? 'odd gradeX' : 'even gradeC') . '" style="cursor: pointer;">';
									echo "<td>$sl</td>";
									echo '<td style="white-space: nowrap;">' .
										(isset($param->datetime) ? date('d-M-Y', strtotime($param->datetime)) . '<br>' . date('g:i a', strtotime($param->datetime)) : '') .
										'</td>';
									echo '<td>' . $param->dep . '</td>';
									echo '<td>' . $param->obstruction . '</td>';
									echo '<td>' . $param->slippery . '</td>';
									echo '<td>' . $param->rails . '</td>';
									echo '<td>' . $param->comment . '</td>';
									echo '</tr>';
									$sl++;
								}
								echo '</tbody>';
								echo '</table>';
							}
						}

						// Display the tables for each checklist type
						displayStairways($stairwaysData);

						?>
					</div>
				</div>
				<!--End of Code Pink table -->
			</div> -->
			<!-- /.row -->
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