<!--Code updates: 
Worked on UI allignment, fixed all the issues.
Last updated on 05-03-23 -->

<?php //echo lang_loader('ip','ip_allfeedbacks_dashboard'); exit; 
require_once 'audit_tables.php';
?>

<!-- content -->
<div class="content">
	<!-- alert message -->
	<!-- content -->
	<!-- PHP Code {-->

	<!-- } PHP Code -->


	<!-- Download Buttons-->

	<!-- <span class="download_option" style="display: none; position:relative;" id="showdownload"> -->
	<div class="row" style="position: relative;display: none;" id="showdownload">
		<div class="p-l-30 p-r-30" style="float:right;margin-bottom: 20px;">
			<a data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_download_department_report_tooltip'); ?>" target="_blank" href="<?php echo $ip_download_department_excel; ?>" style="float:right;margin:0px 0px;"><img src="<?php echo base_url(); ?>assets/icon/department.png" style="float: right;
			   width: 32px;
			   cursor: pointer;"></a>
			<a data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_download_discharge_report_tooltip'); ?>" target="_blank" href="<?php echo $ip_download_patient_excel; ?>" style="float:right;margin:0px 10px;"><img src="<?php echo base_url(); ?>assets/icon/hospital.png" style="float: right;
			   width: 32px;
			   cursor: pointer;"></a>
			<a data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_download_discharge_overall_report_tooltip'); ?>" target="_blank" href="<?php echo $ip_download_overall_excel; ?>" style="float:right;margin:0px 10px;"><img src="<?php echo base_url(); ?>assets/icon/download.png" style="float: right;
			   width: 32px;
			   cursor: pointer;"></a>
			<a data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_download_discharge_overall_report_pdf_tooltip'); ?>" target="_blank" href="<?php echo $ip_download_overall_pdf; ?>" style="float:right;margin:0px 10px;"><img src="<?php echo base_url(); ?>assets/icon/pdfdownload.png" style="float: right;
			   width: 32px;
			   color: 	#62c52d;
			   cursor: pointer;"></a>

			<span style="float:right;margin:5px 10px;">
				<h4><strong><?php echo lang_loader('ip', 'ip_downloads'); ?></strong></h4>
			</span>

		</div>
		<br>
	</div>

	<!-- </span> -->

	<!-- Close Download Buttons-->
	<!--Search box-->

	<input type="text" id="searchAudit" placeholder="🔍 Search audits" style="width:49%; margin:5px auto;margin-right:0px; display:block; padding:8px 10px; border:1px solid #ccc; border-radius:4px; font-size:16px;">


	<!-- Metric Boxes-->
	<div class="row">
		<div class="col-12 heading-block">
			<div class="heading">
				<h2 style="margin-top: 20px;margin-bottom: 20px; font-size: 22px; font-weight: bold;margin-left:5px;background:#f5f5f5; padding: 7px 10px; border: 1px solid #ccc; border-radius: 6px;width:99%;">Clinical Audits</h2>
			</div>
		</div>


		<?php if (isfeature_active('AUDIT-FORM1') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_mrd_audit';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count1 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>
			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_mrd_audit; ?>'"
				data-title="<?php echo strtolower('MRD audit'); ?>">

				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;"><span class="count-number">
									<?php echo count($ip_feedbacks_count1); ?>
								</span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
									</i></span></h2>
							<div class="small" style="font-size: 18px;">MRD audit <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $initial_assesment_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-book"></i>
							</div>
							<a href="<?php echo $feedbacks_report_mrd_audit; ?>" style="float: right; font-size:15px;   margin-top: -9px;">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM8') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_surgical_safety';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_surgical_safety; ?>'"
				data-title="<?php echo strtolower('Operating Room Safety audit'); ?>">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span>
							</h2>
							<div class="small" style="font-size: 18px;">Operating Room Safety audit <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $wrong_surgery_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-user-md"></i>
							</div>
						</div>
						<a href="<?php echo $feedbacks_report_surgical_safety; ?>" style="float: right; font-size:15px;   margin-top: -9px;">Explore</a>

					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM9') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_medicine_dispense';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_medicine_dispense; ?>'"
				data-title="<?php echo strtolower('Medication management process audit'); ?>">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span>
							</h2>
							<div class="small" style="font-size: 18px;">Medication management process audit <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $transfusion_reactions_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-medkit"></i>
							</div>
						</div>
						<a href="<?php echo $feedbacks_report_medicine_dispense; ?>" style="float: right; font-size:15px;   margin-top: -9px;">Explore</a>

					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM10') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_medication_administration';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_medication_administration; ?>'"
				data-title="<?php echo strtolower('Medication administration audit'); ?>">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span>
							</h2>
							<div class="small" style="font-size: 18px;">Medication administration audit <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $mortality_ratio_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-medkit"></i>
							</div>
						</div>
						<a href="<?php echo $feedbacks_report_medication_administration; ?>" style="float: right; font-size:15px;   margin-top: -9px;">Explore</a>

					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM12') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_prescriptions';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6" onclick="window.location.href='<?php echo $feedbacks_report_prescriptions; ?>'" data-title="<?php echo strtolower('Prescriptions audit'); ?>">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span>
							</h2>
							<div class="small" style="font-size: 18px;">Prescriptions audit <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $ulcers_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-file-text-o"></i>
							</div>
						</div>
						<a href="<?php echo $feedbacks_report_prescriptions; ?>" style="float: right; font-size:15px;   margin-top: -9px;">Explore</a>

					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM14') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_tat_blood';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_tat_blood; ?>'"
				data-title="<?php echo strtolower('TAT for issue of blood & blood components'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								TAT for issue of blood & blood components
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $pneumonia_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-tint"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_tat_blood; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM15') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_nurse_patients_ratio';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_nurse_patients_ratio; ?>'"
				data-title="<?php echo strtolower('Nurse-Patients ratio for ICU'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Nurse-Patients ratio for ICU
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $blood_infection_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-users"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_nurse_patients_ratio; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM16') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_return_to_i';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_return_to_i; ?>'"
				data-title="<?php echo strtolower('Return to ICU within 48 hours'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Return to ICU within 48 hours
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $site_infection_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-ambulance"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_return_to_i; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM17') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_return_to_icu';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_return_to_icu; ?>'"
				data-title="<?php echo strtolower('Return to ICU - Data Verification'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Return to ICU - Data Verification
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $hand_hygiene_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-check"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_return_to_icu; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM18') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_return_to_ed';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_return_to_ed; ?>'"
				data-title="<?php echo strtolower('Return to Emergency within 72 hours'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Return to Emergency within 72 hours
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $prophylactic_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-ambulance"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_return_to_ed; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM19') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_return_to_emr';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_return_to_emr; ?>'"
				data-title="<?php echo strtolower('Return to Emergency - Data Verification'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Return to Emergency - Data Verification
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $re_scheduling_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-check"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_return_to_emr; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM22') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_nurse_patients_ratio_ward';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i></span>
							</h2>
							<div class="small" style="font-size: 18px;">Nurse-Patients ratio for Ward <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $ward_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-users"></i>
							</div>
						</div>
						<a href="<?php echo $feedbacks_report_nurse_patients_ratio_ward; ?>" style="float: right; font-size:15px;   margin-top: -9px;">Explore</a>

					</div>
				</div>
			</div>

		<?php } ?>
	</div>

	<div class="row">
		<div class="col-12 heading-block">
			<div class="heading">
				<h2 style="margin-top: 20px;margin-bottom: 20px; font-size: 22px; font-weight: bold;margin-left:15px;background:#f5f5f5; padding: 7px 10px; border: 1px solid #ccc; border-radius: 6px;width:98%;">Infection Control & Prevention Audits</h2>
			</div>
		</div>
		<?php if (isfeature_active('AUDIT-FORM13') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_hand_hygiene';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_hand_hygiene; ?>'"
				data-title="<?php echo strtolower('Hand hygiene audit'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Hand hygiene audit
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $urinary_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-hand-paper-o"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_hand_hygiene; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM23') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_vap_prevention';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_vap; ?>'"
				data-title="<?php echo strtolower('VAP Prevention checklist'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								VAP Prevention checklist
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $vap_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-stethoscope"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_vap; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>

		<?php if (isfeature_active('AUDIT-FORM24') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_catheter_insert';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_catheter_insert; ?>'"
				data-title="<?php echo strtolower('Catheter Insertion checklist'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Catheter Insertion checklist
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $catheter_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-medkit"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_catheter_insert; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>

		<?php if (isfeature_active('AUDIT-FORM25') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_ssi_bundle';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_ssi_bundle; ?>'"
				data-title="<?php echo strtolower('SSI Bundle care policy'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								SSI Bundle care policy
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $ssi_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-clipboard"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_ssi_bundle; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>

		<?php if (isfeature_active('AUDIT-FORM26') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_urinary_catheter';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_urinary; ?>'"
				data-title="<?php echo strtolower('Urinary Catheter maintenance checklist'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Urinary Catheter maintenance checklist
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $urinary_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-wrench"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_urinary; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>

		<?php if (isfeature_active('AUDIT-FORM27') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_central_line_insert';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_central_line_insert; ?>'"
				data-title="<?php echo strtolower('Central Line Insertion checklist'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Central Line Insertion checklist
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $central_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-plus-square"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_central_line_insert; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>

		<?php if (isfeature_active('AUDIT-FORM28') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_central_maintenance';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_central_maintenance; ?>'"
				data-title="<?php echo strtolower('Central Line maintenance checklist'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Central Line maintenance checklist
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $maintenance_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-cogs"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_central_maintenance; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
	</div>

	<div class="row">
		<div class="col-12 heading-block">
			<div class="heading">
				<h2 style="margin-top: 20px;margin-bottom: 20px; font-size: 22px; font-weight: bold;margin-left:15px;background:#f5f5f5; padding: 7px 10px; border: 1px solid #ccc; border-radius: 6px;width:98%;">Process / Operational Audits</h2>
			</div>
		</div>
		<?php if (isfeature_active('AUDIT-FORM3') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_consultation_time';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count3 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>
			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_consultation_time; ?>'"
				data-title="<?php echo strtolower('OP consultation waiting time audit'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<span class="count-number"><?php echo count($ip_feedbacks_count3); ?></span>
								&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								OP consultation waiting time audit
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $safety_precautions_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-clock-o"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_consultation_time; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>

		<?php if (isfeature_active('AUDIT-FORM4') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_lab_wait_time';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count4 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>
			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_lab_time; ?>'"
				data-title="<?php echo strtolower('Laboratory waiting time audit'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<span class="count-number"><?php echo count($ip_feedbacks_count4); ?></span>
								&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Laboratory waiting time audit
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $medication_errors_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-flask"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_lab_time; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>


		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM5') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_xray_wait_time';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count5 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>
			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_xray_time; ?>'"
				data-title="<?php echo strtolower('X-Ray waiting time audit'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<span class="count-number"><?php echo count($ip_feedbacks_count5); ?></span>
								&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								X-Ray waiting time audit
								<a href="javascript:void()" data-toggle="tooltip" data-placement="bottom" title="<?php echo $medication_charts_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-stethoscope"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_xray_time; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM6') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_usg_wait_time';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count6 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>
			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_usg_time; ?>'"
				data-title="<?php echo strtolower('USG waiting time audit'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<span class="count-number"><?php echo count($ip_feedbacks_count6); ?></span>
								&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								USG waiting time audit
								<a href="javascript:void()" data-toggle="tooltip" data-placement="bottom" title="<?php echo $adverse_drug_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-heartbeat"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_usg_time; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>

		<?php if (isfeature_active('AUDIT-FORM7') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_ctscan_time';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count7 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_ctscan_time; ?>'"
				data-title="<?php echo strtolower('CT scan waiting time audit'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<span class="count-number"><?php echo count($ip_feedbacks_count7); ?></span>
								&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								CT scan waiting time audit
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $unplanned_return_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-clock-o"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_ctscan_time; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>

		<?php if (isfeature_active('AUDIT-FORM11') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_handover';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_handover; ?>'"
				data-title="<?php echo strtolower('Handover audit'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Handover audit
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $theemergency_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-handshake-o"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_handover; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM29') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_room_cleaning';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_room_cleaning; ?>'"
				data-title="<?php echo strtolower('Patient room cleaning checklist'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Patient room cleaning checklist
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $room_clean_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-bed"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_room_cleaning; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>

		<?php if (isfeature_active('AUDIT-FORM30') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_other_area_cleaning';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_other_cleaning; ?>'"
				data-title="<?php echo strtolower('Other area cleaning checklist'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Other area cleaning checklist
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $area_clean_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-map-o"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_other_cleaning; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>

		<?php if (isfeature_active('AUDIT-FORM31') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_toilet_cleaning';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_toilet_cleaning; ?>'"
				data-title="<?php echo strtolower('Toilet cleaning checklist'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Toilet cleaning checklist
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $toilet_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-tint"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_toilet_cleaning; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>

		<?php if (isfeature_active('AUDIT-FORM33') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_canteen_audit';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_canteen; ?>'"
				data-title="<?php echo strtolower('Canteen audit checklist'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Canteen audit checklist
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $canteen_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-cutlery"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_canteen; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
	</div>

	<div class="row">
		<div class="col-12 heading-block">
			<div class="heading">
				<h2 style="margin-top: 20px;margin-bottom: 20px; font-size: 22px; font-weight: bold;margin-left:15px;background:#f5f5f5; padding: 7px 10px; border: 1px solid #ccc; border-radius: 6px;width:98%;">Management / System & Safety Audits</h2>
			</div>
		</div>
		
		<?php if (isfeature_active('AUDIT-FORM20') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_mock_drill';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_mock_drill; ?>'"
				data-title="<?php echo strtolower('Mock drills audit'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Mock drills audit
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $mock_drill_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-check-square"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_mock_drill; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM32') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_code_originals';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count66 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_code_originals; ?>'"
				data-title="<?php echo strtolower('Code - Originals audit'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count66); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Code - Originals audit
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $mock_drill_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-check-square"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_code_originals; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM21') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_safety_inspection';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count8 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>

			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_safety_inspection; ?>'"
				data-title="<?php echo strtolower('Facility safety inspection audit'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count8); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Facility safety inspection audit
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $facility_inspection_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-shield"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_safety_inspection; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('AUDIT-FORM2') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_ppe_audit';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count2 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>
			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_ppe_audit; ?>'"
				data-title="<?php echo strtolower('Radiology safety adherence audit'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<?php echo count($ip_feedbacks_count2); ?>&nbsp;
								<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Radiology safety adherence audit
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $report_error_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-shield"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_ppe_audit; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>

		
		<?php if (isfeature_active('AUDIT-FORM34') === true) { ?>
			<?php
			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
			$table_feedback_1PSQ3a = 'bf_feedback_lab_safety_audit';
			$table_patients_1PSQ3a = 'bf_patients';
			$desc_1PSQ3a = 'desc';
			$sorttime = 'asc';
			$setup = 'setup';
			$ip_feedbacks_count2 = $this->audit_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>
			<div class="audit-card col-xs-12 col-sm-6 col-md-6 col-lg-6"
				onclick="window.location.href='<?php echo $feedbacks_report_lab_safety_audit; ?>'"
				data-title="<?php echo strtolower('Laboratory safety adherence audit'); ?>">

				<div class="panel panel-bd">
					<div class="panel-body" style="height: 100px;">
						<div class="statistic-box">
							<h2 style="font-size: 25px;">
								<span class="count-number"><?php echo count($ip_feedbacks_count2); ?></span>
								&nbsp;<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i></span>
							</h2>

							<div class="small" style="font-size: 18px;">
								Laboratory safety adherence audit
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $report_error_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div class="icon large-screen-only">
								<i class="fa fa-shield"></i>
							</div>
						</div>

						<a href="<?php echo $feedbacks_report_lab_safety_audit; ?>"
							style="float: right; font-size:15px; margin-top: -9px;">Explore</a>
					</div>
				</div>
			</div>

		<?php } ?>
	</div>



	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="<?php echo base_url(); ?>assets/efeedor_chart.js"></script>
</div>

<style>
	.icon .fa {
		font-size: 55px;
	}

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
		#pie_donut {
			overflow-x: scroll;
		}

		#bar {
			overflow-x: scroll;
		}

		#word {
			overflow-x: scroll;
		}

		#line {
			overflow-x: scroll;
			overflow-y: scroll;
		}
	}

	/* Default: hide the icon */
	.icon.large-screen-only {
		display: none;
	}

	/* Show the icon only on large screens */
	@media (min-width: 992px) {
		.icon.large-screen-only {
			display: block;
		}
	}
</style>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const searchInput = document.getElementById("searchAudit");
		const allHeadings = document.querySelectorAll(".heading-block");

		// Helper to get all audit cards under a given heading
		function getAuditCardsUnderHeading(headingBlock) {
			const cards = [];
			let next = headingBlock.nextElementSibling;
			while (next && !next.classList.contains("heading-block")) {
				if (next.classList.contains("audit-card")) cards.push(next);
				next = next.nextElementSibling;
			}
			return cards;
		}

		// Function to update visibility of headings based on content
		function updateHeadings(searchQuery = "") {
			allHeadings.forEach(block => {
				const audits = getAuditCardsUnderHeading(block);
				let hasVisibleCard = false;

				audits.forEach(card => {
					const title = (card.dataset.title || "").toLowerCase();
					if (!searchQuery || title.includes(searchQuery)) {
						card.style.display = "block";
						hasVisibleCard = true;
					} else {
						card.style.display = "none";
					}
				});

				// 🔥 Hide the heading if no cards exist or all are hidden
				block.style.display = hasVisibleCard ? "block" : "none";
			});
		}

		// Initial check after DOM load
		updateHeadings();

		// Handle search filter dynamically
		if (searchInput) {
			searchInput.addEventListener("input", function() {
				const query = searchInput.value.toLowerCase().trim();
				updateHeadings(query);
			});
		}
	});
</script>