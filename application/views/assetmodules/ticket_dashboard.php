<!--Code updates: 
Worked on UI allignment, fixed all the issues.
Last updated on 05-03-23 -->

<div class="content">
	<div class="row">
		<script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
		<script src="<?php echo base_url(); ?>assets/utils.js"></script>

		<!-- PHP Code {-->
		<?php
		include 'info_buttons_int.php';
		require 'pc_table_variables.php';



		if ($minDepartment && $maxDepartment != null) {
			$lowest_complain = $minDepartment;
			$highest_complain = $maxDepartment;
		} else {
			$lowest_complain = '-';
			$highest_complain = '-';
		}


		?>
		<!--}  PHP Code -->

		<!-- Download Buttons-->

		<!-- <span class="download_option" style="display: none; position:relative;" id="showdownload"> -->
		<div class="row" style="position: relative;display: none;" id="showdownload">
			<div class="p-l-30 p-r-30" style="float:right;margin-bottom: 20px;">
				<a data-toggle="tooltip" title="Click here to download department wise patient complaints report" target="_blank" href="<?php echo  $int_download_department_excel; ?>" style="float:right;margin:0px 0px;"><img src="<?php echo base_url(); ?>assets/icon/department.png" style="float: right;
               width: 32px;
               cursor: pointer;"></a>
				<a data-toggle="tooltip" title="Click here to download patient wise complaints report" target="_blank" href="<?php echo $int_download_comments_excel; ?>" style="float:right;margin:0px 10px;"><img src="<?php echo base_url(); ?>assets/icon/download.png" style="float: right;
               width: 32px;
               cursor: pointer;">
				</a>
				<a data-toggle="tooltip" title="Download Overall Patient Complaints Report in pdf format" target="_blank" href="<?php echo $int_download_overall_pdf; ?>" style="float:right;margin:0px 10px;"><img src="<?php echo base_url(); ?>assets/icon/pdfdownload.png" style="float: right;
			   width: 32px;
			   color: 	#62c52d;
			   cursor: pointer;"></a>
				<span style="float:right;margin:5px 10px;">
					<h4><strong><?php echo lang_loader('pcf', 'pcf_downloads'); ?></strong></h4>
				</span>

			</div>
			<br>
		</div>

		<!-- </span> -->

		<!-- Close Download Buttons-->
		<!-- Metric Boxes-->

		<?php if (ismodule_active('ASSET') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $int_department['alltickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small">Total Assets <a href="javascript:void()" data-toggle="tooltip" title="Total no. of hospital assets registered for use in the hospital during the selected period"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-hospital-o"></i>
							</div>
							<a href="<?php echo $int_link_alltickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('pcf', 'pcf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (ismodule_active('ASSET') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $int_department['asset_use']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small">Assets in Use <a href="javascript:void()" data-toggle="tooltip" title="Total no. of hospital assets currently in use."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-check-square-o"></i>
							</div>
							<a href="<?php echo $asset_use_tickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('pcf', 'pcf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (ismodule_active('ASSET') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $int_department['asset_assign_tickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small">Allocated Assets <a href="javascript:void()" data-toggle="tooltip" title="Total no. of hospital assets that are currently allocated to any users or departments for use."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-address-book"></i>
							</div>
							<a href="<?php echo $asset_assign_tickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('pcf', 'pcf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (ismodule_active('ASSET') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $int_department['asset_unallocate_tickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small">Unallocated Assets <a href="javascript:void()" data-toggle="tooltip" title="Total no. of hospital assets that are not allocated to any users or departments for use."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-user-times"></i>
							</div>
							<a href="<?php echo $asset_unallocate_tickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('pcf', 'pcf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (ismodule_active('ASSET') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $int_department['asset_repair_tickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small">Malfunctioned Assets <a href="javascript:void()" data-toggle="tooltip" title="Total no. of hospital assets that are not operational due to maintenance, repair, or malfunction."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-wrench"></i>
							</div>
							<a href="<?php echo $asset_repair_tickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('pcf', 'pcf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (ismodule_active('ASSET') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $int_department['asset_lost_tickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small">Lost Assets <a href="javascript:void()" data-toggle="tooltip" title="Total no. of hospital assets that are currently reported as lost or missing."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-times-circle"></i>
							</div>
							<a href="<?php echo $asset_lost_tickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('pcf', 'pcf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (ismodule_active('ASSET') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $int_department['asset_dispose_tickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small">Disposed Assets <a href="javascript:void()" data-toggle="tooltip" title="Total no. of hospital assets that have been disposed of and are no longer part of hospital resources."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-trash"></i>
							</div>
							<a href="<?php echo $asset_dispose_tickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('pcf', 'pcf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (ismodule_active('ASSET') === true) { ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2><span class="count-number"><?php echo $int_department['asset_sold_tickets']; ?></span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span></h2>
							<div class="small">Sold Assets <a href="javascript:void()" data-toggle="tooltip" title="Total no. of hospital assets that are currently sold"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon">
								<i class="fa fa-ban"></i>
							</div>
							<a href="<?php echo $asset_sold_tickets; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('pcf', 'pcf_view_list'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>


	</div>
	<!-- Close Metric Boxes-->
	<?php if (count($int_tickets_count) > 5) { ?>
		<!-- Key Highlights -->
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow:hidden;">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h4><?php echo lang_loader('pcf', 'pcf_key_takeaways'); ?> <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="This section will give you a complete understanding of the performance of every parameters and department over the selected period of time."><i class="fa fa-info-circle" aria-hidden="true"></i></a></h4>
					</div>
					<div class="p-l-30 p-r-30">
						<div class="panel-body" style="height: 150px; display:inline;">
							<div class="alert alert-success">
								<span style="font-size: 15px">
									<?php echo lang_loader('pcf', 'pcf_you_have_received_least_complaints_in'); ?> <strong><?php echo $highest_complain; ?></strong>
								</span>
							</div>
							<div class="alert alert-warning ">
								<span style="font-size: 15px">
									<?php echo lang_loader('pcf', 'pcf_you_have_received_most_complaints_in'); ?> <strong><?php echo $lowest_complain; ?></strong>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Close Key Highlights -->
	<?php } ?>

	<?php if (ismodule_active('ASSET') === true && isfeature_active('ASSET-DASHBOARD') === true) { ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="overflow:auto;">
					<div class="panel-heading">

						<a href="<?php echo base_url(); ?>asset/asset_preventive_tickets" data-toggle="tooltip" data-placement="bottom" title="This section provides an overview of assets requiring preventive maintenance and Assets under various status. Click the Explore button to update the status or take further action." style="color: inherit;" href="<?php echo base_url(); ?>dashboard/swithc?type=2">
							<span>
								<h3>Preventive Maintenance Overview</h3>
								<?php if (ismodule_active('ASSET') === true && isfeature_active('ASSET-DASHBOARD') === true) { ?><a href="<?php echo base_url(); ?>asset/asset_preventive_tickets" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
							</span>
						</a>
					</div>
					<div class="panel-body" style="height:120px; max-height:120px;">



						<?php

						$floor_asset = $this->session->userdata['floor_asset'];

						// $fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
						// $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
						$this->db->select("*");
						$this->db->from('bf_feedback_asset_creation');
						// $this->db->where('datetime >=', $tdate);
						// $this->db->where('datetime <=', $fdate);
						if ($_SESSION['ward'] !== 'ALL') {
							$this->db->where('locationsite', $_SESSION['ward']);
						}

						if (!empty($floor_asset)) {
							if (is_array($floor_asset)) {
								$this->db->where_in('depart', $floor_asset);
							} else {
								$this->db->where('depart', $floor_asset);
							}
						}

						// Execute the query
						$query = $this->db->get();

						$ASSETSresults  = $query->result();

						?>
						<?php

						$scheduleCount = 0;
						$notApplicableCount = 0;
						$overdueCount = 0;
						$dueIn45DaysCount = 0;
						$overDue30DaysCount = 0;
						$dueThisMonthCount = 0;

						// Loop through the results to calculate counts
						if (!empty($ASSETSresults)) {
							foreach ($ASSETSresults as $department) {
								$upcomingDate = $department->upcoming_preventive_maintenance_date;
								$assetWithPm = $department->assetWithPm;
								$currentDate = new DateTime();

								if ($assetWithPm === 'PM not applicable') {
									$notApplicableCount++;
								} elseif ($assetWithPm === 'PM applicable') {
									if (empty($upcomingDate)) {
										// PM applicable but no upcoming date → Scheduled
										$scheduleCount++;
									} else {
										$upcomingDateObj = new DateTime($upcomingDate);
										$interval = $currentDate->diff($upcomingDateObj);
										$daysRemaining = $interval->format('%r%a');

										if ($daysRemaining < -30) {
											$overDue30DaysCount++;
										} elseif ($daysRemaining < 0) {
											$overdueCount++;
										} elseif ($currentDate->format('Y-m') === $upcomingDateObj->format('Y-m')) {
											$dueThisMonthCount++;
										} elseif ($daysRemaining >= 1 && $daysRemaining <= 45) {
											$dueIn45DaysCount++;
										} else {
											$scheduleCount++;
										}
									}
								} else {
									// If assetWithPm is empty or unrecognized → mark as Not Applicable (fallback)
									$notApplicableCount++;
								}
							}
						}

						$applicableCount = $scheduleCount + $overdueCount + $dueIn45DaysCount + $dueThisMonthCount + $overDue30DaysCount;


						?>


						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">

										<div class="statistic-box" title="Represents the total count of assets requiring preventive maintenance.">
											<h2><span class="count-number">
													<?php echo $applicableCount; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">PM applicable assets
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total count of assets requiring preventive maintenance.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>
											<div class="icon">
												<i class="fa fa-calendar-check-o"></i>
											</div>
											<!-- <a href="<?php echo base_url(); ?>asset/asset_preventive_tickets?status=Scheduled" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a> -->
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
										<div class="statistic-box" title="Represents the total count of assets that do not require preventive maintenance.">
											<h2><span class="count-number">
													<?php echo $notApplicableCount; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">Assets without PM
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total count of assets that do not require preventive maintenance.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>

											<div class="icon">
												<i class="fa fa-calendar-times-o"></i>
											</div>
											<a href="<?php echo base_url(); ?>asset/asset_preventive_tickets?status=Not+Applicable" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>

										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
										<div class="statistic-box" title="Represents the total number of assets with overdue preventive maintenance.">
											<h2><span class="count-number">
													<?php echo $overdueCount; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">PM Overdue
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total number of assets with overdue preventive maintenance.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>

											<div class="icon">
												<i class="fa fa-calendar-minus-o"></i>
											</div>
											<a href="<?php echo base_url(); ?>asset/asset_preventive_tickets?status=Maintenance+Overdue" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>

										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
										<div class="statistic-box" title="Represents the total number of assets with preventive maintenance due in the current month.">
											<h2><span class="count-number">
													<?php echo $dueThisMonthCount; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">PM Due this Month
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total number of assets with preventive maintenance due in the current month.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>
											<div class="icon">
												<i class="fa fa-calendar"></i>
											</div>
											<a href="<?php echo base_url(); ?>asset/asset_preventive_tickets?status=Due+this+Month" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>

										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<!-- Close Metric Boxes-->
				</div>
			</div>
		</div>
	<?php } ?>

	<?php if (ismodule_active('ASSET') === true && isfeature_active('ASSET-DASHBOARD') === true) { ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="overflow:auto;">
					<div class="panel-heading">

						<a href="<?php echo base_url(); ?>asset/asset_calibration_tickets" data-toggle="tooltip" data-placement="bottom" title="This section provides an overview of assets requiring calibration and Assets under various status. Click the Explore button to update the status or take further action." style="color: inherit;" href="<?php echo base_url(); ?>dashboard/swithc?type=2">
							<span>
								<h3>Calibration Overview</h3>
								<?php if (ismodule_active('ASSET') === true && isfeature_active('ASSET-DASHBOARD') === true) { ?><a href="<?php echo base_url(); ?>asset/asset_preventive_tickets" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
							</span>
						</a>
					</div>
					<div class="panel-body" style="height:120px; max-height:120px;">



						<?php

						$floor_asset = $this->session->userdata['floor_asset'];

						// $fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
						// $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
						$this->db->select("*");
						$this->db->from('bf_feedback_asset_creation');
						// $this->db->where('datetime >=', $tdate);
						// $this->db->where('datetime <=', $fdate);
						if ($_SESSION['ward'] !== 'ALL') {
							$this->db->where('locationsite', $_SESSION['ward']);
						}

						if (!empty($floor_asset)) {
							if (is_array($floor_asset)) {
								$this->db->where_in('depart', $floor_asset);
							} else {
								$this->db->where('depart', $floor_asset);
							}
						}

						// Execute the query
						$query = $this->db->get();

						$ASSETSresults  = $query->result();

						?>
						<?php

						$scheduleCount = 0;
						$notApplicableCount = 0;
						$overdueCount = 0;
						$dueIn45DaysCount = 0;
						$overDue30DaysCount = 0;
						$dueThisMonthCount = 0;

						// Loop through the results to calculate counts
						if (!empty($ASSETSresults)) {
							foreach ($ASSETSresults as $department) {
								$upcomingDate = $department->upcoming_calibration_date;
								$assetWithCalibration = $department->assetWithCalibration;
								$currentDate = new DateTime();

								if ($assetWithCalibration === 'Calibration not applicable') {
									$notApplicableCount++;
								} elseif ($assetWithCalibration === 'Calibration applicable') {
									if (empty($upcomingDate)) {
										// Calibration applicable but no date → Scheduled
										$scheduleCount++;
									} else {
										$upcomingDateObj = new DateTime($upcomingDate);
										$interval = $currentDate->diff($upcomingDateObj);
										$daysRemaining = $interval->format('%r%a');

										if ($daysRemaining < -30) {
											$overDue30DaysCount++;
										} elseif ($daysRemaining < 0) {
											$overdueCount++;
										} elseif ($currentDate->format('Y-m') === $upcomingDateObj->format('Y-m')) {
											$dueThisMonthCount++;
										} elseif ($daysRemaining >= 1 && $daysRemaining <= 45) {
											$dueIn45DaysCount++;
										} else {
											$scheduleCount++;
										}
									}
								} else {
									// Fallback for unknown calibration flag
									$notApplicableCount++;
								}
							}
						}

						$applicableCount = $scheduleCount + $overdueCount + $dueIn45DaysCount + $dueThisMonthCount + $overDue30DaysCount;


						?>


						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">

										<div class="statistic-box" title="Represents the total count of assets requiring preventive maintenance.">
											<h2><span class="count-number">
													<?php echo $applicableCount; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">Calibration applicable assets
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total count of assets requiring preventive maintenance.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>
											<div class="icon">
												<i class="fa fa-calendar-check-o"></i>
											</div>
											<!-- <a href="<?php echo base_url(); ?>asset/asset_preventive_tickets?status=Scheduled" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a> -->
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
										<div class="statistic-box" title="Represents the total count of assets that do not require preventive maintenance.">
											<h2><span class="count-number">
													<?php echo $notApplicableCount; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">Assets without Calibration
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total count of assets that do not require preventive maintenance.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>

											<div class="icon">
												<i class="fa fa-calendar-times-o"></i>
											</div>
											<a href="<?php echo base_url(); ?>asset/asset_calibration_tickets?status=Not+Applicable" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>

										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
										<div class="statistic-box" title="Represents the total number of assets with overdue preventive maintenance.">
											<h2><span class="count-number">
													<?php echo $overdueCount; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">Calibration Overdue
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total number of assets with overdue preventive maintenance.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>

											<div class="icon">
												<i class="fa fa-calendar-minus-o"></i>
											</div>
											<a href="<?php echo base_url(); ?>asset/asset_calibration_tickets?status=Calibration+Overdue" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>

										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
										<div class="statistic-box" title="Represents the total number of assets with preventive maintenance due in the current month.">
											<h2><span class="count-number">
													<?php echo $dueThisMonthCount; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">Due this Month
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total number of assets with preventive maintenance due in the current month.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>
											<div class="icon">
												<i class="fa fa-calendar"></i>
											</div>
											<a href="<?php echo base_url(); ?>asset/asset_calibration_tickets?status=Due+this+Month" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>

										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<!-- Close Metric Boxes-->
				</div>
			</div>
		</div>
	<?php } ?>

	<?php if (ismodule_active('ASSET') === true && isfeature_active('ASSET-DASHBOARD') === true) { ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="overflow:auto;">
					<div class="panel-heading">

						<a href="<?php echo base_url(); ?>asset/asset_warranty_reports" data-toggle="tooltip" data-placement="bottom" title="This section provides an overview of assets with warranties and their respective warranty statuses. Click the Explore button to update the status." style="color: inherit;" href="<?php echo base_url(); ?>dashboard/swithc?type=2">
							<span>
								<h3>Assets Warranty Overview</h3>
								<?php if (ismodule_active('ASSET') === true && isfeature_active('ASSET-DASHBOARD') === true) { ?><a href="<?php echo base_url(); ?>asset/asset_warranty_reports" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
							</span>
						</a>
					</div>
					<div class="panel-body" style="height:120px; max-height:120px;">
						<?php

						$floor_asset = $this->session->userdata['floor_asset'];

						// $fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
						// $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
						$this->db->select("*");
						$this->db->from('bf_feedback_asset_creation');
						// $this->db->where('datetime >=', $tdate);
						// $this->db->where('datetime <=', $fdate);
						if ($_SESSION['ward'] !== 'ALL') {
							$this->db->where('locationsite', $_SESSION['ward']);
						}

						if (!empty($floor_asset)) {
							if (is_array($floor_asset)) {
								$this->db->where_in('depart', $floor_asset);
							} else {
								$this->db->where('depart', $floor_asset);
							}
						}

						$query = $this->db->get();
						$ASSETSresults  = $query->result();
						?>

						<?php
						$totalNoWarranty = 0;
						$totalExpired30Days = 0;
						$totalExpired = 0;
						$totalExpiresThisMonth = 0;
						$totalExpiringSoon = 0;
						$totalWarrantyActive = 0;

						if (!empty($ASSETSresults)) {
							foreach ($ASSETSresults as $department) {
								$warrantyEndDate = $department->warrenty_end;
								$assetWithWarranty = $department->assetWithWarranty;
								$currentDate = new DateTime();

								if ($assetWithWarranty === 'Warranty not applicable' || empty($assetWithWarranty)) {
									$totalNoWarranty++; // Not applicable or not under warranty
								} elseif ($assetWithWarranty === 'Warranty applicable') {
									if (empty($warrantyEndDate)) {
										// Warranty applicable but no end date → treat as active
										$totalWarrantyActive++;
									} else {
										$warrantyEndDateObj = new DateTime($warrantyEndDate);
										$interval = $currentDate->diff($warrantyEndDateObj);
										$daysRemaining = (int)$interval->format('%r%a'); // signed days

										if ($daysRemaining < -30) {
											$totalExpired30Days++;
										} elseif ($daysRemaining < 0) {
											$totalExpired++;
										} elseif ($currentDate->format('Y-m') === $warrantyEndDateObj->format('Y-m')) {
											$totalExpiresThisMonth++;
										} elseif ($daysRemaining >= 1 && $daysRemaining <= 90) {
											$totalExpiringSoon++;
										} else {
											$totalWarrantyActive++;
										}
									}
								} else {
									// Unrecognized status — treat as no warranty
									$totalNoWarranty++;
								}
							}
						}

						$applicableWarrantyCount = $totalWarrantyActive + $totalExpired + $totalExpired30Days + $totalExpiresThisMonth + $totalExpiringSoon;

						?>

						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">

										<div class="statistic-box" title="Represents the total number of assets for which warranty is applicable.">
											<h2><span class="count-number">
													<?php echo $applicableWarrantyCount; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">Warranty applicable assets
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total number of assets for which warranty is applicable.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>

											<div class="icon">
												<i class="fa fa-calendar-check-o"></i>
											</div>
											<!-- <a href="<?php echo base_url(); ?>asset/asset_warranty_reports?status=Warranty+Active" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a> -->
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
										<div class="statistic-box" title="Represents the total number of assets where warranty is not applicable.">
											<h2><span class="count-number">
													<?php echo $totalNoWarranty; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">Non Warranty Assets
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total number of assets where warranty is not applicable.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>

											<div class="icon">
												<i class="fa fa-calendar-times-o"></i>
											</div>
											<a href="<?php echo base_url(); ?>asset/asset_warranty_reports?status=No+Warranty" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>

										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
										<div class="statistic-box" title="Represents the total number of assets with expired warranties">
											<h2><span class="count-number">
													<?php echo $totalExpired; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">Expired Warranty Assets
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total number of assets with expired warranties.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>
											<div class="icon">
												<i class="fa fa-calendar-minus-o"></i>
											</div>
											<a href="<?php echo base_url(); ?>asset/asset_warranty_reports?status=Expired" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>

										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
										<div class="statistic-box" title="Represents the total number of assets with warranties expiring within the current month.">
											<h2><span class="count-number">
													<?php echo $totalExpiresThisMonth; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">Warranty Expires this Month
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total number of assets with warranties expiring within the current month.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>

											<div class="icon">
												<i class="fa fa-calendar"></i>
											</div>
											<a href="<?php echo base_url(); ?>asset/asset_warranty_reports?status=Expires+This+Month" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>

										</div>
									</div>
								</div>
							</div>
						<?php } ?>

					</div>
					<!-- Close Metric Boxes-->
				</div>
			</div>
		</div>
	<?php } ?>

	<?php if (ismodule_active('ASSET') === true && isfeature_active('ASSET-DASHBOARD') === true) { ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="overflow:auto;">
					<div class="panel-heading">

						<a href="<?php echo base_url(); ?>asset/asset_contract_reports" data-toggle="tooltip" data-placement="bottom" title="This section provides an overview of assets with annual/comprehensive maintenance contracts and their respective AMC/CMC statuses. Click the Explore button to update the status." style="color: inherit;" href="<?php echo base_url(); ?>dashboard/swithc?type=2">
							<span>
								<h3>AMC/ CMC Overview</h3>
								<?php if (ismodule_active('ASSET') === true && isfeature_active('ASSET-DASHBOARD') === true) { ?><a href="<?php echo base_url(); ?>asset/asset_contract_reports" style="float: right;margin-top: -22px;">Explore</a><?php } ?>
							</span>
						</a>
					</div>
					<div class="panel-body" style="height:120px; max-height:120px;">
						<?php

						$floor_asset = $this->session->userdata['floor_asset'];

						// $fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
						// $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
						$this->db->select("*");
						$this->db->from('bf_feedback_asset_creation');
						// $this->db->where('datetime >=', $tdate);
						// $this->db->where('datetime <=', $fdate);
						if ($_SESSION['ward'] !== 'ALL') {
							$this->db->where('locationsite', $_SESSION['ward']);
						}

						if (!empty($floor_asset)) {
							if (is_array($floor_asset)) {
								$this->db->where_in('depart', $floor_asset);
							} else {
								$this->db->where('depart', $floor_asset);
							}
						}

						$query = $this->db->get();
						$ASSETSresults  = $query->result();
						?>

						<?php
						$totalNoContract = 0;
						$totalExpired30Days = 0;
						$totalExpired = 0;
						$totalExpiresThisMonth = 0;
						$totalExpiringSoon = 0;
						$totalContractActive = 0;

						// Loop through the results to calculate counts
						if (!empty($ASSETSresults)) {
							foreach ($ASSETSresults as $department) {
								$contractEndDate = $department->contract_end_date;
								$assetWithAmc = $department->assetWithAmc;
								$currentDate = new DateTime();

								if ($assetWithAmc === 'AMC/ CMC not applicable' || empty($assetWithAmc)) {
									$totalNoContract++; // Not applicable or missing → Count as No Contract
								} elseif ($assetWithAmc === 'AMC/ CMC applicable') {
									if (empty($contractEndDate)) {
										$totalContractActive++; // AMC exists but no end date → Consider Active
									} else {
										$contractEndDateObj = new DateTime($contractEndDate);
										$interval = $currentDate->diff($contractEndDateObj);
										$daysRemaining = (int)$interval->format('%r%a'); // Negative if expired

										if ($daysRemaining < -30) {
											$totalExpired30Days++;
										} elseif ($daysRemaining < 0) {
											$totalExpired++;
										} elseif ($currentDate->format('Y-m') == $contractEndDateObj->format('Y-m')) {
											$totalExpiresThisMonth++;
										} elseif ($daysRemaining >= 1 && $daysRemaining <= 90) {
											$totalExpiringSoon++;
										} else {
											$totalContractActive++;
										}
									}
								} else {
									// If AMC status is unknown, treat as No Contract
									$totalNoContract++;
								}
							}
						}

						$applicableContractCount = $totalContractActive + $totalExpired + $totalExpired30Days + $totalExpiresThisMonth + $totalExpiringSoon;

						?>

						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
										<div class="statistic-box" title="Represents the total number of assets under an active annual or comprehensive maintenance contract.">
											<h2><span class="count-number">
													<?php echo $applicableContractCount; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">AMC/CMC applicable assets
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total number of assets under an active annual or comprehensive maintenance contract.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>
											<div class="icon">
												<i class="fa fa-calendar-check-o"></i>
											</div>
											<!-- <a href="<?php echo base_url(); ?>asset/asset_contract_reports?status=Contract+Active&amc_status=all" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a> -->
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
										<div class="statistic-box" title="Represents the total number of assets where an annual or comprehensive maintenance contract is not applicable">
											<h2><span class="count-number">
													<?php echo $totalNoContract; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">Assets without AMC/CMC
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total number of assets where an annual or comprehensive maintenance contract is not applicable.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>

											<div class="icon">
												<i class="fa fa-calendar-times-o"></i>
											</div>
											<a href="<?php echo base_url(); ?>asset/asset_contract_reports?status=No+Contract&amc_status=all" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>

										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
										<div class="statistic-box" title="Represents the total number of assets with expired annual or comprehensive maintenance contracts.">
											<h2><span class="count-number">
													<?php echo $totalExpired; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">AMC/CMC Expired
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total number of assets with expired annual or comprehensive maintenance contracts.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>
											<div class="icon">
												<i class="fa fa-calendar-minus-o"></i>
											</div>
											<a href="<?php echo base_url(); ?>asset/asset_contract_reports?status=Expired&amc_status=all" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>

										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="panel panel-bd">
									<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
										<div class="statistic-box" title="Represents the total number of assets with annual or comprehensive maintenance contracts due to expire this month.">
											<h2><span class="count-number">
													<?php echo $totalExpiresThisMonth; ?>
												</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
													</i></span></h2>
											<div class="small">AMC/CMC Exp. This Month
												<a href="javascript:void(0)" data-toggle="tooltip" title="Represents the total number of assets with annual or comprehensive maintenance contracts due to expire this month.">
													<i class="fa fa-info-circle" aria-hidden="true"></i>
												</a>
											</div>

											<div class="icon">
												<i class="fa fa-calendar"></i>
											</div>
											<a href="<?php echo base_url(); ?>asset/asset_contract_reports?status=Expires+This+Month&amc_status=all" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>

										</div>
									</div>
								</div>
							</div>
						<?php } ?>

					</div>
					<!-- Close Metric Boxes-->
				</div>
			</div>
		</div>
	<?php } ?>

	<?php
	$all_feedback = $this->asset_model->patient_and_feedback($table_feedback, $desc, $setup);
	$sresulte = $this->asset_model->setup_result($setup);
	foreach ($sresulte as $r2) {
		$setarray[$r2->type] = $r2->title;
		$question[$r2->shortkey] = $r2->shortname;
		$ticketin[$r2->shortkey] = $r2->title;
	}

	?>



	<div class="row">
		<!-- Total Product Sales area -->
		<div class="col-lg-7 col-sm-12 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Asset Classification by Asset Group or Category <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="This pie chart shows how assets are divided into various categories and the percentage each category contributes to the total."><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="height: 495px;" id="pie_donut">
					<div class="message_inner chart-container">
						<canvas id="department_asset"></canvas>
					</div>
				</div>

			</div>
		</div>

		<div class="col-lg-5">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Recent Asset Activity <a href="javascript:void()" data-placement="bottom" data-toggle="tooltip" title="This shows the recent actions taken on hospital assets, showcasing recent changes in status."><i class="fa fa-info-circle" aria-hidden="true"></i></a></h3>
				</div>
				<div class="panel-body" style="   height: 460px;      overflow: auto;">
					<div class="message_inner">

						<?php
						$a = $this->ticketsasset_model->alltickets();
						$ticket_data = $a;

						$this->db->select("*");
						$this->db->from('tickets_asset');
						// $this->db->where('parent', 0);
						$query = $this->db->get();
						$reasons  = $query->result();
						foreach ($reasons as $row) {
							$keys[$row->shortkey] = $row->shortkey;
							$res[$row->shortkey] = $row->shortname;
							$titles[$row->shortkey] = $row->title;
							$dep[$row->title] = $row->title;
						}


						foreach ($ticket_data as $ticketdata) {

						?>
							<a href="<?php echo base_url($this->uri->segment(1)); ?>/track/<?php echo $ticketdata->id ?>">
								<div class="inbox-item">
									<p class="inbox-item-author">
										<?php echo 'ASTACT-' . $ticketdata->id ?>
										<span style="float: right;font-size:10px;"><?php
																					echo date('g:i A, d-m-y', strtotime($ticketdata->datetime)); ?></span>
									</p>

									<p class="inbox-item-text">
										<i class="fa fa-user-plus"></i> <?php echo $ticketdata->assetname; ?> (<span style="color:#62c52d;"><?php echo $ticketdata->patientid; ?></span>), added in
										<?php

										if ($ticketdata->bedno) {

											echo $ticketdata->bedno;
											echo ' in ';
										}
										?>
										<?php echo $ticketdata->locationsite . '.'; ?>
									</p>
									<p class="inbox-item-text">
										<i class="fa fa-ticket"></i><b> <?php echo $ticketdata->ward; ?></b>
									</p>


									<p class="inbox-item-text" style="font-size:10px;">
										<?php if ($ticketdata->assignstatus == 'Asset Assign' || $ticketdata->assignstatus == 'Asset Reassign') { ?>

											<span style="color: #198754; font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
											<?php echo 'Allocated Asset'; ?>
										<?php } ?>
										<?php if ($ticketdata->assignstatus == 'Asset Broken') { ?>
											<span style="color: #d9534f; font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
											<?php echo 'Broken Asset'; ?>
										<?php } ?>
										<?php if ($ticketdata->assignstatus == 'Asset Repair') { ?>
											<span style="color: #62d0f1; font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
											<?php echo 'Asset in Repair'; ?>
										<?php }  ?>
										<?php if ($ticketdata->assignstatus == 'Asset Lost') { ?>
											<span style="color: #428bca; font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
											<?php echo 'Lost Asset'; ?>
										<?php }  ?>
										<?php if ($ticketdata->assignstatus == 'Asset Dispose') { ?>
											<span style="color: #FFB61E; font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
											<?php echo 'Disposed Asset'; ?>
										<?php }  ?>

										<!-- <?php
												echo date('g:i A, d-m-y', strtotime($ticketdata->last_modified)); ?> -->
									</p>
								</div>
							</a>
						<?php } ?>
						<?php  ?>
					</div>
				</div>
				<div style="padding: 20px;    background: #f5f5f5;"><a href="<?php echo base_url($this->uri->segment(1)); ?>/alltickets" style="float: right;    margin-top: -9px;">View All</a></div>
			</div>
		</div>
		<!-- /.row -->
	</div>

	<!-- Close Why choose the hospital and patient comments -->


</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	// Function to fetch data from API and update the chart
	async function fetchChartData() {
		try {
			// Replace 'your-api-url' with the actual URL of your API endpoint
			const response = await fetch('<?php echo base_url(); ?>asset/ticket_dashboard_pie');

			if (!response.ok) {
				throw new Error('Network response was not ok');
			}

			const apiData = await response.json();

			// Assuming the API returns the following format:
			// {
			//   labels: ['Emergency Response Equipment', 'Facility and Infrastructure', ...],
			//   values: [12, 15, 8, 20, 17, 10, 9, 5, 12, 7, 18, 6]
			// }

			// Data for the pie chart
			const data = {
				labels: apiData.labels,
				datasets: [{
					data: apiData.values, // Dynamic values from API
					backgroundColor: [
						'#FF6384', '#36A2EB', '#FFCE56', '#FF9F40', '#4BC0C0',
						'#9966FF', '#FFCD56', '#FF6384', '#36A2EB', '#FF9F40',
						'#4BC0C0', '#9966FF'
					],
				}]
			};

			// Get the canvas context
			var ctx = document.getElementById('department_asset').getContext('2d');

			// Create the pie chart
			var departmentAssetChart = new Chart(ctx, {
				type: 'pie', // Type of chart (pie)
				data: data,
				options: {
					responsive: true,
					plugins: {
						legend: {
							display: true,
							position: 'right', // Position of the legend (right, bottom, left)
						}
					}
				}
			});
		} catch (error) {
			console.error('Error fetching chart data:', error);
		}
	}

	// Fetch the chart data when the page loads
	window.onload = fetchChartData;
</script>


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

	.panel-body {
		height: 531px;
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
		height: 270px;
		width: 200px;
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